@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      PART INSPECTION STANDARD (PIS)
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><i class="fa fa-files-o"></i> Master</li>
      <li class="active"><i class="fa fa-files-o"></i>PART INSPECTION STANDARD (PIS)
      </li>
    </ol>
  </section>

  <!-- Main content -->

  <section class="content">
    @include('layouts._flash')
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header">
            <div class="box-body col-md-12">
              
              <div class="col-sm-3">
               
                <div class="box-header" center>
                  <div class="btn-group">

                  </div>
                </div>
              </div>
             
              <div class="col-sm-3">
              </p>
            </div>
          </div>
        </div>
        <!-- /.box-header -->

        <div class="box-body" >
          <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%" >
            <thead>
              <tr>
                <th style="width: ;">NO</th>
                <th style="width: ;">NO PIS</th>
                <th style="width: ;">MODEL</th>
                <th style="width: ;">PART NO</th>
                <th style="width: ;">PART NAME</th>
                <th style="width: 5%;">SUPPLIER</th>
                <th style="width: 5%;">STATUS </th>
                <th style="width: 7%;">REV </th>
                <th style="width: 2%;">ACTION</th>
              </tr>
            </thead>
          </table>
        </div>
        <div class="box-footer" class="col-sm-6">
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
  $(function() {
    var table = $('#tblMaster').DataTable({ 
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
    // destroy: true,
    // responsive: {
    //   details: false,
    // },
    processing: true,
    "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
    deferRender: true,
    searching: true,
    serverSide: true,
    ajax: {
      route: "pistandards.index",
      type: 'GET',
    },
    "order": [[ 0, "asc" ]],  
    columns: [
    {data: null, name: null},
    {data: 'no_pis', name: 'no_pis'},
    {data: 'model', name: 'model'},
    {data: 'part_no', name: 'part_no'},
    {data: 'part_name', name: 'part_no'},
    {data: 'nama_supplier', name: 'nama_supplier'},
    {data: 'status', name: 'status'},
    {data: 'rev_doc', name: 'rev_doc'},
    {data: 'action', name: 'action', orderable:false, searchable:false},
    
    ]
    
  });      
  });
</script>

@endsection


