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
    
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    {!! Form::open(['url'=>'/password/email']) !!}
      <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
        {!! Form::email('email', null, ['class'=>'form-control', 'placeholder'=>'Email', 'id' => 'email']) !!}
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-4">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-btn fa-envelope"></i> Kirim link reset password
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