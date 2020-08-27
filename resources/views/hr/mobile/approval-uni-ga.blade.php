@extends('layouts.app')
@section('content')

<!-- App_UN4 -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Approval
        <small>Permintaan Uniform</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Approval Uniform</li>
      </ol>
    </section>

   <!-- Main content -->
   <section class="content">
      @include('layouts._flash')
      <!-- Form Utama Appr. Uniform Atasan -->
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List Approval Uniform</h3>
                    
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row form-group">
                <div class="col-sm-12">
                <!-- <input class="form-control" placeholder="Cari nama..." style="float:left;width:150px;margin: 0px 12px 10px 0px;" type="text" id="table-text-nama"> -->
                <input class="form-control" placeholder="Cari..." style="float:left;width:150px;margin: 0px 12px 10px 0px;" type="text" id="table-text-un">
                <span style="padding-top: 10px;font-size: 15px;margin-left: -5px;color: #737373;" data-toggle="tooltip" title="nama, npk, nomor pengajuan" class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>
                <button class="btn btn-success" onclick="location.reload()" style="float:right;"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
                <table id="dtApprovalUniGA" class="autonumber table-bordered table-striped" style="width:100%;">
                  <thead>
                    <tr>
                      <!-- <th style="width:1%">No</th> -->
                      <th style="width:1px;">No.</th>
                      <th style="width:30%">NPK</th>
                      <th>Nama</th>
                      <th></th>
                    </tr>
                  </thead>
                </table>
                </div>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- ./box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- Form Utama Perm. Uniform -->

       <!-- Info boxes -->
     


  
  
                </div>       
            </div>
        </div>

  
@endsection


@section('scripts')
<script type="text/javascript">
$(document).ready( function () {
    var table = $('#dtApprovalUniGA').DataTable({
            // responsive: true,
            processing: true,
            searching: true,
            ajax: {
                url: '{{ route("mobiles.uniformappr_ga") }}'
            },
            "deferRender": true,
            "pageLength": 10,
            columns: [               
            {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable:false, searchable:false},
            {data: 'npk', name: 'uniform1.npk',orderable:false, searchable:false},
            {data: 'nama', name: 'v_mas_krayawan.nama',orderable:false},
            {data: 'action', name: 'action', orderable:false},
        ],
        destroy: true,
        dom: '<"top">rt<"bottom"pi>',
        
        }); 

      
    
    
</script>

<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
</script>

@endsection