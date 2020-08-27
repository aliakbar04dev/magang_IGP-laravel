@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Line
      <small>Daftar Line</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><i class="fa fa-files-o"></i> ENGINEERING - MASTER</li>
      <li class="active"><i class="fa fa-files-o"></i> Line</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
   @include('layouts._flash')
   <div class="row">
     <div class="col-md-12">
       <div class="box box-primary">
        <div class="box-body form-horizontal"> 
        @permission('eng-msteng-create')
        <div class="box-header">
          <p> 
            <a class="btn btn-primary" href="{{ route('engtmlines.create') }}">
              <span class="fa fa-plus"></span> Add Line
            </a>
          </p>
        </div>
        <!-- /.box-header -->
        @endpermission
        <div class="form-group">
          <div class="col-sm-2">
            {!! Form::label('kd_plant', 'Plant (*)') !!}
            <div class="input-group">
              <select id="kd_plant" name="kd_plant" class="form-control select2">
                @foreach($plants->get() as $plant)
                <option value="{{$plant->kd_plant}}">{{$plant->nm_plant}}</option>      
                @endforeach
              </select>       
            </div>
          </div>
        </div>
        <!-- /.form-group -->
        <div class="form-group">
          <div class="col-sm-2">
            <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
          </div>
        </div>
      </div>
        <!-- /.form-group -->
        <div class="box-body">
         <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
           <thead>
             <tr>
              <th style="width: 1%;">No</th>
              <th>Kode Line</th>
              <th>Nama line</th>
              <th>Status</th>
              <th style="width: 5%;">Action</th>
            </tr>
          </thead>
        </table>
      </div>
      <!-- /.box-body -->
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

    var tableMaster = $('#tblMaster').DataTable({
      "columnDefs": [{
        "searchable": false,
        "orderable": false,
        "targets": 0,
        render: function (data, type, row, meta) {
         return meta.row + meta.settings._iDisplayStart + 1;
       }
     }],
     "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
     "iDisplayLength": 10,
     responsive: true,
     "order": [[1, 'asc']],
     processing: true, 
     "oLanguage": {
      'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
    }, 
     serverSide: true,
     ajax: "{{ route('dashboard.engtmlines') }}",
     columns: [
     {data: null, name: null},
     {data: 'kd_line', name: 'kd_line'},
     {data: 'nm_line', name: 'nm_line'},
     {data: 'st_aktif', name: 'st_aktif'},
     {data: 'action', name: 'action', orderable: false, searchable: false}
     ]
   });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.plant = $('select[name="kd_plant"]').val();
    });

    $('#display').click( function () {
      tableMaster.ajax.reload();
    });
  });
</script>
@endsection