@extends('layouts.app')
@section('content')

<style>

td, th {
    padding: 8px 10px 8px 0px;;
}

.bubble{
    background-color: #74bb7a;
    color:white;
    padding: 8px;
    /* box-shadow: 0px 0px 15px -5px gray; */
    /* border-radius: 10px 10px 0px 0px; */
}

.bubble-content{
    background-color: #fff;
    padding: 10px;
    margin-top: -5px;
    /* border-radius: 0px 10px 10px 10px; */
    /* box-shadow: 2px 2px #dfdfdf; */
    box-shadow: 0px 0px 10px -5px gray;
    margin-bottom:10px;
}

.select2-container--default .select2-results__option[aria-disabled=true] {
     display: none;
     }

</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Internal Audit
            <small>Temuan Audit</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Temuan Audit</li>
        </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
        @include('layouts._flash')
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Temuan Audit</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                    {!! Form::open(['url' => route('auditors.temuanauditform_submit'),
                        'method' => 'post', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id', 'autocomplete' => 'off', 'required']) !!}
                        @include('audit.temuanaudit._form')
                        <!-- @yield('auditee_sign') -->
                        @yield('save_button')

                    {!! Form::close() !!}
                    <strong style="color:red;">(*) Tidak boleh kosong
                    <br>(**) Kolom hijau harus diisi sebagai prioritas</strong>
                    </div>
                    <!-- ./box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection


@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
      $(".select2").select2();
});

</script>

@endsection
