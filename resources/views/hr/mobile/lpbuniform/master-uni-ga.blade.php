@extends('layouts.app')
@section('content')

<!-- App_UN4 -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Uniform
        <!-- <small>Permintaan Uniform</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Master Uniform</li>
      </ol>
    </section>

   <!-- Main content -->
   <section class="content">
      @include('layouts._flash')
       <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Master Data Uniform</h3>
                    
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
                <select class="form-control" placeholder="Cari..." style="float:left;width:125px;margin: 0px 12px 10px 0px;" type="text" id="table-select-un">
                <option value="">Semua Jenis</option>
                <option value="BJ">Baju</option>
                <option value="CL">Celana</option>
                <option value="HL">Helm</option>
                <option value="SP">Sepatu</option>
                <option value="TP">Topi</option>
                </select>
                <select class="form-control" placeholder="Cari..." style="float:left;width:120px;margin: 0px 12px 10px 0px;" type="text" id="table-select-pt">
                <option value="">Semua PT</option>
                <option value="IGP">IGP</option>
                <option value="GKD">GKD</option>
                <option value="AGI">AGI</option>
                <option value="ANDIN">ANDIN</option>
                </select>
                <button class="btn btn-success" data-toggle="modal" data-target="#modalAddUniform" style="float:right;">Add <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                <table id="dtMasterUniform" class="autonumber table-bordered table-striped" style="width:100%;">
                <thead>
                    <tr>
                      <!-- <th style="width:1%">No</th> -->
                      <th style="width:1px;">Kode</th>
                      <th style="width:30%">Item</th>
                      <th>Deskripsi</th>
                      <th>Action</th>
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
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  
  <div id="modalAddUniform" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">   
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">New Master Uniform</h4>
            </div>
            {!! Form::open(['url'=>route("mobiles.uniformappr_ga_master_add"), 'method' =>'post'])!!}
            <div class="modal-body">
                <!-- <form method="post" id="f_uniform"> -->
                    <table class="table-borderless" style="width:100%">
                        <tr>
                            <td style="font-weight: bold;padding: 15px 10px;">Jenis </td>
                                <td>
                                    <select class="form-control" name="kd_uni" style="width:150px;">
                                            <option value="BJ">Baju</option>
                                            <option value="CL">Celana</option>
                                            <option value="HL">Helm</option>
                                            <option value="SP">Sepatu</option>
                                            <option value="TP">Topi</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                    <td style="font-weight: bold;padding: 15px 10px;">PT </td>
                                        <td>
                                            <select class="form-control" name="pt" style="width:150px;">
                                                    <option value="Semua">Semua</option>    
                                                    <option value="IGP">IGP</option>
                                                    <option value="GKD">GKD</option>
                                                    <option value="AGI">AGI</option>
                                                    <option value="ANDIN">ANDIN</option>
                                            </select>
                                        </td>
                                    </tr>
                            <!-- <tr>
                                <td style="font-weight: bold;padding: 15px 10px;;">Kode </td>
                                <td><input class="form-control" type="text" name="kd_uni"></td>
                            </tr> -->
                            <tr>
                                <td style="font-weight: bold;padding: 15px 10px;">Nama Uniform </td>
                                <td><input class="form-control" type="text" name="new_nama" style="width:100%" required></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;padding: 32px 10px;">Penjelasan </td>
                                <td><textarea class="form-control" type="text" name="new_desc" style="width:100%" required></textarea></td>
                            </tr>
                        </table>
                    </div> 
                    <div class="modal-footer">
                        <input type="submit" name="saveuniform" id="saveuniform" class="btn btn-info" value="Save"/>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <!-- </form> -->
                    </div>
                    {!! Form::close() !!}   
                </div>       
            </div>
        </div>

  
@endsection


@section('scripts')
<script type="text/javascript">
$(document).ready( function () {


        var table2 = $('#dtMasterUniform').DataTable({
            processing: true,
            searching: true,
            ajax: {
                url: '{{ route("mobiles.uniformappr_ga_master") }}'
            },
            "deferRender": true,
            "pageLength": 10,
            columns: [
            {data: 'kd_uni', name: 'kd_uni'},
            {data: 'nm_uni', name: 'nm_uni'},
            {data: 'desc_uni', name: 'nm_uni'},
            {data: 'action', name: 'action', orderable:false},
        ],
        destroy: true,
        dom: '<"top">rt<"bottom"pi>',  
        }); 

    $('#table-text-un').on('keyup', function(){
        table.column(3).search(this.value).draw();   
    }); 

    $('#table-select-un').on('change', function(){
        table2.column(0).search(this.value).draw();   
    });   

        $('#table-select-pt').on('change', function(){
        table2.column([1, 2]).search(this.value).draw();   
    });    
    });
    
    
</script>

<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
</script>

@endsection