<!DOCTYPE html>
<html>
<head>
  @include ('layouts.head')
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="{{ url('/') }}"><b>{{ config('app.env', 'local') === 'production' ? config('app.name', 'Laravel') : config('app.name', 'Laravel').' TRIAL' }}</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Reset Password</p>
    
    {!! Form::open(['url'=>'/password/reset']) !!}
      <input type="hidden" name="token" value="{{ $token }}">
      <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
        {!! Form::email('email', isset($email) ? $email : null, ['class'=>'form-control', 'placeholder'=>'Email', 'id' => 'email']) !!}
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
      </div>   
      <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
        {!! Form::password('password', ['class'=>'form-control', 'placeholder'=>'Password']) !!}
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
      </div>
      <div class="form-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        {!! Form::password('password_confirmation', ['class'=>'form-control', 'placeholder'=>'Konfirmasi Password']) !!}
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        {!! $errors->first('password_confirmation', '<p class="help-block">:message</p>') !!}
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-4">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-btn fa-refresh"></i> Reset Password
            </button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<script>
  document.getElementById("email").focus();
</script>
</body>
</html>