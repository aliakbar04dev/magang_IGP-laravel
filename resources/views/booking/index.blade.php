<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Q. Anianda -->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.env', 'local') === 'production' ? config('app.name', 'Laravel') : config('app.name', 'Laravel').' TRIAL' }}</title>
    <link rel="shortcut icon" href="{{ asset('images/splash.png') }}"/>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('fullcalendar/bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
    {{-- <link rel="stylesheet" href="{{ asset('fullcalendar/fullcalendar.min.css') }}"> --}}
    <style>
      /*body {
        background-color: white;
      }*/
      .content {
        max-width: auto;
        /*margin-top: 30px;*/
        margin-left: 5px;
        margin-right: 5px;
      }
      h1 { 
        display: block;
        font-size: 2em;
        margin-top: 0.67em;
        margin-bottom: 0.67em;
        margin-left: 0;
        margin-right: 0;
        font-weight: bold;
        color: red;
        text-align: center;
        text-decoration: underline;
        letter-spacing: 3px;
        /*word-spacing: 10px;*/
        /*text-shadow: 3px 2px grey;*/
      }
    </style>
  </head>
  <body>
    @include ('layouts.script')
    @include ('layouts.script2')
    <H1>MONITORING {{ $ruangan->nama }}</H1>
    <div class="content">
      <p>{!! $calendar->calendar() !!}</p>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    {{-- <script src="{{ asset('fullcalendar/moment.min.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    {{-- <script src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script> --}}
    {!! $calendar->script() !!}
    <script>
      //auto refresh
      setTimeout(function() {
        location.reload();
        {{-- // var urlRedirect = "{{ url('/rrit') }}"; --}}
        // urlRedirect = urlRedirect.replace('param', displayStart);
        // window.location.href = urlRedirect;
      }, 180000); //1000 = 1 second
    </script>
  </body>
</html>