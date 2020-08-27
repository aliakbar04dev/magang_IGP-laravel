@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Environment Performance
        <small></small>
      </h1>
      <ol class="breadcrumb">
          <li>
            <a href="{{ url('/home') }}">
              <i class="fa fa-dashboard"></i> Home</a>
          </li>
          <li>
            <i class="glyphicon glyphicon-info-sign"></i> Environment Performance
          </li>
          <li class="active">
            <i class="fa fa-files-o"></i> Equipment & Facility
          </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')


      <div class="row" id="field_detail">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border" >
                <h3 class="box-title"><b>Monitoring Equipment & Facility</b></h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
       {!! Form::model($mefdetail, ['url' => route('ehsenv.update', base64_encode($mefdetail->no_mef)),
            'method' => 'put', 'files'=>'true', 'role'=>'form', 'id'=>'form_mef']) !!}
          @include('ehs.ep.equipment._form_ef')
        {!! Form::close() !!}
    </div>
  </div>
 </div>




    </section>
</div>

@endsection

@section('scripts')

<script type="text/javascript">

  
</script>

    


@endsection