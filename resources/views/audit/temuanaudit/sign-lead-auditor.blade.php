@extends('layouts.app')
@section('content')

<style>

td, th {
    padding: 8px 10px 8px 0px;;
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
            <li><a href="{{ route('auditors.daftartemuan') }}"><i class="fa fa-clone"></i> Temuan Audit</a></li>
            @if ($get_temuan->status_reject == "R")
                <li class="active">Revisi</li>
            @else
                <li class="active">Sign (Lead Auditor)</li>
            @endif
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
                        @if ($get_temuan->status_reject == "R")
                            <h3 class="box-title">Revisi Temuan Audit</h3>
                        @else
                            <h3 class="box-title">Sign Temuan Audit (Lead Auditor)</h3>
                        @endif
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                    {!! Form::open(['method' => 'post', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id', 'autocomplete' => 'off', 'required']) !!}
                    @include('audit.temuanaudit._form-lead-auditor')
                    {!! Form::close() !!}
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

