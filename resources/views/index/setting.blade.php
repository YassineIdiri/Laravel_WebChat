@extends('layout.base')

@section('styleCSS')
<title>Setting</title>
<link rel="stylesheet" href="/assets/css/setting.css">
@endsection

@section('Page')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-4 col-xl-3 chat" style="margin-top: 110px;" data-aos="fade-right" data-aos-duration="1500">
            <div class="card mb-sm-3 mb-md-0 contacts_card">
				<div class="container">
					
					<div class="user-info">
						<h2>User Information</h2>
                        <p><strong>Account Opening Date:</strong> {{$user->openingDate->format('F j, Y, g:i A')}}</p>
						@php
                            // Assumer que le username contient des lettres suivies de chiffres
                            $username = $user->username;
                            // Trouver la position du premier chiffre
                            $pos = strcspn($username, '0123456789');
                            // Extraire les lettres et les chiffres
                            $letters = substr($username, 0, $pos);
                            $numbers = substr($username, $pos);
                        @endphp

                        <p><strong>User Code :</strong> {{ $letters }}#{{ $numbers }}</p>
                        <hr>
                        <p><strong>Name :</strong> {{ $user->name}}</p>
						<p><strong>Email :</strong> {{ $user->email}}</p>
						
					</div>
					<div class="stats">
						<h2>Number of Messages Sent</h2>
						<ul>
							<li> {{ $messageCount}}</li>
						</ul>
					</div>

				</div>
				<div style="display:flex;">
                
                <button class="btn btn-warning" onclick="promptPasswordChange()">Change your password</button>
				<button class="btn btn-danger" onclick="deleteAccount()">Delete your account</button>
            	</div>
			</div>
        </div>
    </div>
</div>

<script src="/assets/js/chatBox.js"></script>
<script>
	function deleteAccount() {
		Swal.fire({
			title: "Are you sure?",
			text: "You won't be able to revert this!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, delete it!"
		}).then((result) => {
			if (result.isConfirmed) {
				// Envoi de la requête POST pour supprimer le compte
				fetch('/user/delete', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
						'X-CSRF-TOKEN': '{{ csrf_token() }}' // Inclure le token CSRF pour la sécurité
					},
					body: JSON.stringify({ userId: 1 }) // Remplacer par l'ID utilisateur approprié
				})
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						Swal.fire({
							title: "Deleted!",
							text: "Your account has been deleted.",
							icon: "success"
						}).then(() => {
							// Rediriger ou rafraîchir la page après la suppression
							window.location.href = '/';
						});
					} else {
						Swal.fire({
							title: "Error!",
							text: "There was a problem deleting your account.",
							icon: "error"
						});
					}
				})
				.catch(error => {
					Swal.fire({
						title: "Error!",
						text: "There was a problem deleting your account.",
						icon: "error"
					});
				});
			}
		});
	}

	function promptPasswordChange() {
    Swal.fire({
        title: 'Change Password',
        html: `
            <div style="position: relative;">
                <input type="password" id="current_password" class="swal2-input" placeholder="Current Password">
                <i class="bi bi-toggle2-off" id="toggleCurrentPassword" style="position: absolute; right: 20px; top: 60%; transform: translateY(-50%); cursor: pointer; font-size:40px;"></i>
            </div>
            <div style="position: relative;">
                <input type="password" id="new_password" class="swal2-input" placeholder="New Password">
                <i class="bi bi-toggle2-off" id="toggleNewPassword" style="position: absolute; right: 20px; top: 60%; transform: translateY(-50%); cursor: pointer;  font-size:40px;"></i>
            </div>
            <div style="position: relative;">
                <input type="password" id="new_password_confirmation" class="swal2-input" placeholder="Confirm New Password">
                <i class="bi bi-toggle2-off" id="toggleNewPasswordConfirmation" style="position: absolute; right: 20px; top: 60%; transform: translateY(-50%); cursor: pointer; font-size:40px;"></i>
            </div>
        `,
        focusConfirm: false,
        didOpen: () => {
            const toggleCurrentPassword = document.getElementById('toggleCurrentPassword');
            const toggleNewPassword = document.getElementById('toggleNewPassword');
            const toggleNewPasswordConfirmation = document.getElementById('toggleNewPasswordConfirmation');

            toggleCurrentPassword.addEventListener('click', () => {
                const currentPasswordInput = document.getElementById('current_password');
                togglePasswordVisibility(currentPasswordInput, toggleCurrentPassword);
            });

            toggleNewPassword.addEventListener('click', () => {
                const newPasswordInput = document.getElementById('new_password');
                togglePasswordVisibility(newPasswordInput, toggleNewPassword);
            });

            toggleNewPasswordConfirmation.addEventListener('click', () => {
                const newPasswordConfirmationInput = document.getElementById('new_password_confirmation');
                togglePasswordVisibility(newPasswordConfirmationInput, toggleNewPasswordConfirmation);
            });
        },
        preConfirm: () => {
            const current_password = document.getElementById('current_password').value;
            const new_password = document.getElementById('new_password').value;
            const new_password_confirmation = document.getElementById('new_password_confirmation').value;

            if (!current_password || !new_password || !new_password_confirmation) {
                Swal.showValidationMessage('Please enter all fields');
                return false;
            }
            if (new_password !== new_password_confirmation) {
                Swal.showValidationMessage('New passwords do not match');
                return false;
            }

            return { current_password, new_password, new_password_confirmation };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            updatePassword(result.value);
        }
    });
}

function togglePasswordVisibility(input, icon) {
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-toggle2-off');
        icon.classList.add('bi-toggle2-on');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-toggle2-on');
        icon.classList.add('bi-toggle2-off');
    }
}


function updatePassword(data) {
    fetch('{{ route("user.edit") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire('Success', 'Password updated successfully', 'success');
        } else {
            Swal.fire('Error', data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'An error occurred', 'error');
    });
}
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

@endsection
