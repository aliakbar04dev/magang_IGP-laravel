<!DOCTYPE html>
<html>
<head>
  @include ('layouts.head')
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('plugins/iCheck/square/blue.css') }}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="{{ url('/') }}"><b>{{ config('app.env', 'local') === 'production' ? config('app.name', 'Laravel') : config('app.name', 'Laravel')." TRIAL" }}</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    @include('layouts._flash')
    {!! Form::open(['url'=>'login']) !!}
      <div class="form-group has-feedback{{ $errors->has('login') ? ' has-error' : '' }}">
        {!! Form::text('login', null, ['class'=>'form-control', 'placeholder'=>'Username or Email or NPK', 'onchange' => 'autoRemember()', 'id' => 'login']) !!}
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        {!! $errors->first('login', '<p class="help-block">:message</p>') !!}
      </div>
      <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
        {!! Form::password('password', ['class'=>'form-control', 'placeholder'=>'Password']) !!}
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
      </div>
      {{-- @if (config('app.env', 'local') === 'production')
        <div class="form-group has-feedback{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
          {!! app('captcha')->display() !!}
            {!! $errors->first('g-recaptcha-response', '<p class="help-block">:message</p>') !!}
        </div>
      @endif --}}
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" id="remember"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <div class="social-auth-links text-left">
      <a href="{{ url('/password/reset') }}">I forgot my password</a>
      @if(config('app.url', 'http://localhost') === 'https://iaess.igp-astra.co.id' || config('app.url', 'http://localhost') === 'http://localhost')
        <br>
        <a href="{{ url('/register') }}">Don't have an account? Sign up</a>
      @endif
    </div>

    <hr>

    <p>
      <img src="{{ asset('images/logo.png') }}" height="65" width="120"/>
      <br><br>
      <b>{{ config('app.nm_pt', 'Laravel') }}</b>
      <br>
      Jl. Pegangsaan Dua Blok A-3, Km 1,6 Kelapa Gading, Jakarta Utara, DKI Jakarta, 14250 - Indonesia
      <br>
      <b>Phone:</b> 021 - 4602755 (Ext. 184)
      <br>
      <b>Fax:</b> 021 - 4602765
      <br>
      <b>E-Mail:</b> <a href="mailto:septian@igp-astra.co.id">Septian</a>, <a href="mailto:agus.purwanto@igp-astra.co.id">Agus</a>
    </p>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
<script>
  document.getElementById("login").focus();

  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });

  function autoRemember() {
    var login = document.getElementById("login").value.trim();
    if(login === 'ian' || login === 'ian.septian22@gmail.com' || login === '14438' || login === 'septian@igp-astra.co.id') {
      $('#remember').iCheck('check');
    } else {
      if(login.length == 4 && login.substring(0, 1) != 'r') {
        document.getElementById("login").value = "0" + login;
      }
    }
  }
</script>
</body>
</html>
