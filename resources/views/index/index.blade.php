@extends('layout.base')

@section('styleCSS')
   <title>WebChat</title>

   <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
@endsection

@section('Page') 

@if( session('errorLogMiddleware') || session('errorLog') || $errors-> has("Lname") || $errors-> has("Lpassword"))
<section class="home show">
@else
<section class="home">
@endif

  <div class="form_container">
    <i class="uil uil-times form_close"></i>

    <!-- Login From -->
    <div class="form login_form">
      <form method = "POST" action = "{{ route('loginSubmit') }}">
        @csrf
        <h2>Login </h2>
        @if(session('errorLog') || $errors-> has("Lname") || $errors-> has("Lpassword"))<p class='error'>Username or password is wrong</p>@endif
        @if(session('activate'))<p class='error'>Your account is not yet activated. Please check your email for the activation link</p>@endif
        <div class="input_box">
          <input  name ="Lname" type="email" placeholder="Enter your email" required />
          <i class="uil uil-envelope-alt email"></i>
        </div>
        <div class="input_box">
          <input name ="Lpassword" type="password" placeholder="Enter your password" required />
          <i class="uil uil-lock password"></i>
          <i class="uil uil-eye-slash pw_hide"></i>
        </div>
        
        <button type="submit" class="buttons">Login Now</button>
        <div class="login_signup">Don't have an account? <a href="#" id="signup">Signup</a></div>
      </form>
    </div>
    <!-- Signup From -->
    <div class="form signup_form">
      <form method = "POST" action = "{{ route('signupSubmit') }}">
        @csrf
        <h2>Signup</h2>
        <div class="input_box">
          <input name ="email" type="email" placeholder="Enter your email" required />
          <i class="uil uil-envelope-alt email"></i>
        </div>
        <div class="input_box">
          <input name ="name" type="text" placeholder="Enter your name" required />
          <i class="bi bi-card-text email"></i>
        </div>
        <div class="input_box">
          <input name ="password" type="password" placeholder="Create password" required />
          <i class="uil uil-lock password"></i>
          <i class="uil uil-eye-slash pw_hide"></i>
        </div>
        <div class="input_box">
          <input name ="ConfirmPassword" type="password" placeholder="Confirm password" required />
          <i class="uil uil-lock password"></i>
          <i class="uil uil-eye-slash pw_hide"></i>
        </div>
        <button type="submit" class="buttons">Signup Now</button>
        <div class="login_signup">Already have an account? <a href="#" id="login">Login</a></div>
      </form>
    </div>
  </div>
</section>

<script src="/assets/js/index.js"></script>

@if (session('signupActivate'))
<script>
new swal({
  title: "Please check your inbox.",
  text: "We have sent you an email to activate your account.",
  icon: "success"
});</script>
@endif

@if (session('signup'))
<script>
  new swal({
    title: "You have been registered.",
    text: "You can now log in.",
    icon: "success"
  });</script>
@endif

@if (session('Welcome'))
<script>
new swal({
  text: "You are now logged in.",
  icon: "success",
  confirmButtonText: "OK"
});</script>
@endif

@if (session('Out'))
<script>
new swal({
  text: "You are now logged out.",
  icon: "info",
  confirmButtonText: "OK"
});</script>
@endif

@endsection