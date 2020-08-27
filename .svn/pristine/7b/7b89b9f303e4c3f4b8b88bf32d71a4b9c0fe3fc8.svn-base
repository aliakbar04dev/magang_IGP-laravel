<!DOCTYPE html>
<html>
  <head>
    @include ('layouts.head')  
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