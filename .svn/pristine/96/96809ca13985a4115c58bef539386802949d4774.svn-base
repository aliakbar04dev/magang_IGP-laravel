<!DOCTYPE html>
<html lang="en">
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

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('asset-ops/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset-ops/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset-ops/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}">

    <style>
        #btn-top {
          display: none;
          position: fixed;
          bottom: 20px;
          right: 5px;
          z-index: 99;
          font-size: 18px;
          border: none;
          outline: none;
          background-color: gray;
          color: white;
          cursor: pointer;
          padding: 15px;
          border-radius: 4px;
        }

        #btn-top:hover {
          background-color: #555;
        }
    </style>

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    @include('monitoring.ops.layouts._flash')
    <div id="loading" style="display: none; margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;">
        <p style="position: absolute; color: White; top: 50%; left: 45%;">
            <img src={{ asset('images/ajax-loader.gif') }}>
        </p>
    </div>
    @yield('content')
    <button id="btn-top" name="btn-top" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Go to Top" onclick="topFunction()">
      <span class="glyphicon glyphicon-menu-up"></span>
    </button>
    <!-- Scripts -->
    @include ('layouts.script')
    @yield('scripts')
    @include ('layouts.script2')
    <script>
      //Get the button
      var mybutton = document.getElementById("btn-top");

      // When the user scrolls down 20px from the top of the document, show the button
      window.onscroll = function() {scrollFunction()};

      function scrollFunction() {
        if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
          mybutton.style.display = "block";
        } else {
          mybutton.style.display = "none";
        }
      }

      // When the user clicks on the button, scroll to the top of the document
      function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
      }
    </script>
</body>
</html>