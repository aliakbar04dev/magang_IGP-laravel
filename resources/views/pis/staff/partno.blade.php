
@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      PART INSPECTION STANDARD (PIS)
      <small>Staff Aproval</small>
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
           {{-- SHORT BY --}}
           <div class="box-body col-md-12">
            <div class="col-sm-3">
              <div class="box-header" center>
                <div class="btn-group">
                  <button type="button" class="btn btn-info">SHORT BY</button>
                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ route('pisstaff.aprovalstaf') }}">ALL</a></li>       
                    <li><a href="{{ route('pisstaff.aprovalstafmodel') }}">MODEL NAME</a></li>                             
                    <li><a href="{{ route('pisstaff.aprovalstafpartname') }}">PART NAME</a></li>
                   <li><a href="{{ route('pisstaff.aprovalstafpartno') }}">PART NO.</a></li>
                    <li><a href="{{ route('pisstaff.aprovalstafsupplier') }}">SUPPLIER NAME</a></li>
                  </ul>
                </div>
              </div>
            </div>
            {{-- <div class="col-sm-3">
              {{--  PAGE  --}}
              {{-- <div class="box-header" center>
                <div class="btn-group">
                  <button type="button" class="btn btn-info">PAGE</button>
                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="">1</a></li>       
                    <li><a href="">2</a></li>                             
                    <li><a href="">3</a></li>
                    <li><a href="">4</a></li>
                    <li><a href="">5</a></li>
                  </ul>
                </div>
              </div>
            </div> --}} 
            <div class="col-sm-3">

            </div>
            <p align="right"> 
            </a>
          </p>
        </div>
        &nbsp;&nbsp;
        <!-- /.box-header -->
        
        <div class="box-body">
          <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="width: 1%;">NO</th>
                <th style="width: 10%">PART NO</th>
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
      "searchable": true,
      "orderable": true,
      "targets": 0,
      render: function (data, type, row, meta) {
        return meta.row + meta.settings._iDisplayStart + 1;
      }
    }],
    "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
    "iDisplayLength": 10,
    processing: true,
    deferRender: true,
    searching: true,

    ajax: {
      url: '{{ url("/admin/aprovalstafpartno") }}',
      type: 'GET',
    },
    "order": [[ 0, "asc" ]],  
    columns: [
    {data: null, name: null},
    {data: 'part_no', name: 'part_no'},    
    ]
  });      
});
</script>

@endsection


