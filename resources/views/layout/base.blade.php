@php
if(!isset($_SESSION))
   session_start();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/index.css" />
    <link href="/assets/vendor/aos/aos.css" rel="stylesheet">
    <script src="/assets/vendor/aos/aos.js"></script>
    <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <script src="/assets/vendor/sweetalert/sweetalert2.js"></script> 
    <link rel="icon" type="image/x-icon" href="/assets/Images/img/favicon.ico">
    <script src="https://cdn.jsdelivr.net/npm/js-confetti@latest/dist/js-confetti.browser.js"></script>
    @yield('styleCSS')
    @livewireStyles
</head>

<body data-aos-easing="ease-in-out" data-aos-duration="1000" data-aos-delay="0">


  <header class="header">

    <script src="//js.pusher.com/3.1/pusher.min.js"></script>
      @if(session()->has('connexion') && session('connexion') == true)
      <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;
      
        var pusher = new Pusher('7ae88cecac02b66b8975', {
          cluster: 'eu'
        });
      
        var channel = pusher.subscribe('message_notif');
        channel.bind('message', function(data) {
          
          if(data.id_user === {{ session('user') }} )
          {
              Livewire.emit("newMessage");
              Livewire.emit("actualiseNotif");
              Livewire.emit("actualiseContact");
          }

        });
      </script>
    @endif


    <nav class="nav">
      <a href="/" class="nav_logo">WebChat</a>
      <ul class="nav_items">
        <li class="nav_item">

          <a href =  "{{route('message.index')}}"  class='anotif nav_link'>
            <div style="display:flex;">
            <span>Messenger &nbsp</span>
            @if(session('user'))
               @livewire('notifications')
            @endif
            </div>
          </a>


          <a  href="{{route('user.settings')}}" class="nav_link">Settings</a>

        </li>
      </ul>

      @if(session()->has('connexion') && session('connexion') == true)
      <a href = "{{ route('logout') }}" class='buttons' >Log Out</a>
    @else
      <button class='buttons'  id="form-open" >Log In</button>
    @endif



    </nav>
  </header>
  <script src="/assets/js/base.js"></script>

@yield('Page')
@livewireScripts

</body>
</html>
