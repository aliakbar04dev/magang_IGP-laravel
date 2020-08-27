@extends('layouts.app2')

@section('content')
<div class="container3">
    <div class="row">
        <div class="login-logo">
            <a href="{{ url('/') }}"><b>{{ config('app.env', 'local') === 'production' ? config('app.name', 'Laravel') : config('app.name', 'Laravel')." TRIAL" }}</b></a>
        </div>
        <div class="col-md-8 col-md-offset-2">
            @include('layouts._flash')
            <div class="panel panel-default">
                <div class="panel-heading">Register (Khusus Karyawan {{ config('app.kd_pt', 'XXX')." - ".strtoupper(config('app.nm_pt', 'XXX')) }})</div>
                <div class="panel-body">
                    {!! Form::open(['url'=>'/register/karyawan', 'class'=>'form-horizontal', 'id'=>'form_id']) !!}
                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            {!! Form::label('username', 'NPK (*)', ['class'=>'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => 'NPK', 'minlength' => 5, 'maxlength' => 5, 'required', 'style' => 'text-transform:lowercase', 'onchange' => 'autoLowerCase(this)', 'onchange' => 'validateKaryawan()']) !!}
                                {!! $errors->first('username', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {!! Form::label('name', 'Nama (*)', ['class'=>'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nama', 'required', 'readonly' => 'readonly']) !!}
                                {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            {!! Form::label('email', 'Email (*)', ['class'=>'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::email('email', null, ['class'=>'form-control', 'placeholder' => 'Email', 'maxlength' => 255, 'required', 'style' => 'text-transform:lowercase', 'onchange' => 'autoLowerCase(this)']) !!}
                                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('tgl_lahir') ? ' has-error' : '' }}">
                            {!! Form::label('tgl_lahir', 'Tgl Lahir (*)', ['class'=>'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::date('tgl_lahir', \Carbon\Carbon::now(), ['class' => 'form-control', 'placeholder' => 'Tgl Lahir', 'required']) !!}
                                {!! $errors->first('tgl_lahir', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('tgl_masuk') ? ' has-error' : '' }}">
                            {!! Form::label('tgl_masuk', 'Tgl Masuk IGP Group (*)', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::date('tgl_masuk', \Carbon\Carbon::now(), ['class' => 'form-control', 'placeholder' => 'Tgl Masuk IGP Group', 'required']) !!}
                                {!! $errors->first('tgl_masuk', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            {!! Form::label('password', 'Password (*)', ['class'=>'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::password('password', ['class'=>'form-control', 'placeholder'=>'Password', 'required']) !!}
                                {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            {!! Form::label('password_confirmation', 'Konfirmasi Password (*)', ['class'=>'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::password('password_confirmation', ['class'=>'form-control', 'placeholder'=>'Konfirmasi Password', 'required']) !!}
                                {!! $errors->first('password_confirmation', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        {{-- <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                            <div class="col-md-offset-4 col-md-6">
                                {!! app('captcha')->display() !!}
                                {!! $errors->first('g-recaptcha-response', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div> --}}
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Daftar
                                </button>
                                &nbsp;&nbsp;
                                <a class="btn btn-primary" href="{{ url('/') }}">
                                    <i class="fa fa-btn fa-remove"></i> Cancel
                                </a>
                                &nbsp;&nbsp;
                                <p class="help-block pull-right has-error">
                                    {!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}
                                </p>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">

    document.getElementById("username").focus();

    function autoUpperCase(a){
        a.value = a.value.toUpperCase();
    }

    function autoLowerCase(a){
        a.value = a.value.toLowerCase();
    }

    function validateKaryawan() {
        var username = document.getElementById("username").value.trim();
        if(username !== '') {
            var url = '{{ route('datatables.validasiKaryawan', 'param') }}';
            url = url.replace('param', window.btoa(username));
            $.get(url, function(result){  
                if(result !== 'null'){
                    result = JSON.parse(result);
                    document.getElementById("username").value = result["npk"];
                    document.getElementById("name").value = result["nama"];
                } else {
                    document.getElementById("username").value = "";
                    document.getElementById("name").value = "";
                    document.getElementById("username").focus();
                    swal("Npk tidak valid!", "Perhatikan inputan anda!", "error");
                }
            });
        } else {
            document.getElementById("username").value = "";
            document.getElementById("name").value = "";
        }
    }

    $('#form_id').submit(function (e, params) {
        var localParams = params || {};
        if (!localParams.send) {
            e.preventDefault();
            //additional input validations can be done hear
            swal({
                title: 'Apakah data yang Anda masukkan sudah benar?',
                text: 'Pastikan email yang Anda masukkan aktif',
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="fa fa-thumbs-up"></i> Ya!',
                cancelButtonText: '<i class="fa fa-thumbs-down"></i> Tidak!',
                allowOutsideClick: true,
                allowEscapeKey: true,
                allowEnterKey: true,
                reverseButtons: false,
                focusCancel: false,
            }).then(function () {
              $(e.currentTarget).trigger(e.type, { 'send': true });
            }, function (dismiss) {
              // dismiss can be 'cancel', 'overlay',
              // 'close', and 'timer'
              if (dismiss === 'cancel') {
                // swal(
                //   'Cancelled',
                //   'Your imaginary file is safe :)',
                //   'error'
                // )
              }
            })
        }
      });
</script>
@endsection