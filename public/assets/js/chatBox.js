function profil($id)
{
	  var contact = document.getElementById('c'+$id);
	  contact.classList.toggle("activeContact");
}



  window.addEventListener('load', function() {
	var divMessages = document.querySelector('.msg_card_body');
	
	if(divMessages)
	{
		divMessages.scrollTop = divMessages.scrollHeight;
	}
	});





const submitBtn = document.getElementById('submitBtn');
const userInput = document.getElementById('userInput');

submitBtn.addEventListener('click', () => {
	const username = userInput.value;
    const sanitizedUsername = username.replace('#', '');
    window.location.href = `/message/${sanitizedUsername}`;
});

var fileInput = document.getElementById('screenshot');
var form = document.getElementById('form');
/*
if(fileInput)
{
    fileInput.addEventListener('change', function() {
        form.submit();
    });
}*/