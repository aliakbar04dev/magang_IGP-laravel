<!DOCTYPE html>
<html>
  <head>
    @include ('layouts.head')  
  </head>
  @if (Auth::check())
    <body class="hold-transition {{ config('app.skin', 'skin-blue') }} sidebar-mini{{ !empty(Auth::user()->st_collapse) ? (Auth::user()->st_collapse === "T" ? " sidebar-collapse" : "") : "" }}">
  @else
    <body class="hold-transition {{ config('app.skin', 'skin-blue') }} sidebar-mini">
  @endif
    <div class="wrapper">
        @include ('layouts.header')
        @include ('layouts.sidebar_left')
        {{-- @include('layouts._flash') --}}
        <div id="loading" style="display: none; margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;">
          <p style="position: absolute; color: White; top: 50%; left: 45%;">
            <img src={{ asset('images/ajax-loader.gif') }}>
          </p>
        </div>
        @yield('content')
        @include ('layouts.footer')
        @include ('layouts.sidebar_right')      
    </div>
    <!-- ./wrapper -->
    @include ('layouts.script')
    @yield('scripts')
    @include ('layouts.script2')
  </body>
</html>