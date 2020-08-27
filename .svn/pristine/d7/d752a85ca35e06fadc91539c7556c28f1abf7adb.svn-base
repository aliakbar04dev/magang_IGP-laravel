@extends('layouts.app')
@section('content')

<!-- App_UN4 -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Limbah B3
   
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Master Limbah B3</li>
      </ol>
    </section>

   <!-- Main content -->
   <section class="content">
      @include('layouts._flash')
       <div class="row" id="tampilan">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Master Data Limbah B3</h3>
                    
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row form-group">
                <div class="col-sm-12">
            
                <p> <a class="btn btn-primary" id="inputaccident" data-toggle="modal" data-target="#modalAddlimbah" aria-hidden="true" >
                    <span class="fa fa-plus"></span> Add Master Limbah </a>
                </p>
                <table id="table_master" class="autonumber table-bordered table-striped" style="width:100%;">
                <thead>
                    <tr>
                      <!-- <th style="width:1%">No</th> -->
                       <th style="width:1px;">No</th>
                      <th style="width:1px;">Kode</th>
                      <th style="width:30%">Nama Limbah</th>
                      <th>Deskripsi</th>
                      <th>Kategori</th>
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

  
  <div id="modalAddlimbah" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">   
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">New Master Limbah B3</h4>
            </div>
             {!! Form::open(['url' => route('ehsspaccidents.store_masterlimbah'), 'method' => 'post', 'class'=>'form-horizontal', 'id'=>'form_master_add']) !!}
            <div class="modal-body">
                <!-- <form method="post" id="f_uniform"> -->
                    <table class="table-borderless" style="width:100%">
  
                           <tr>
                                <td style="font-weight: bold;padding: 15px 10px;">Kode Limbah </td>
                                <td><input class="form-control" type="text" name="kd_limbah" style="width:100%"  required="true" maxlength="7"> </td>
                            </tr>     
                           
                            <tr>
                                <td style="font-weight: bold;padding: 15px 10px;">Jenis Limbah </td>
                                <td><input class="form-control" type="text" name="jenislimbah" style="width:100%" required></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;padding: 32px 10px;">Deskripsi </td>
                                <td><textarea class="form-control" type="text" name="desc" style="width:100%" required></textarea></td>
                            </tr>
                            <tr>
                            <td style="font-weight: bold;padding: 15px 10px;">Kategori </td>
                                <td>
                                    <select class="form-control" style="width:150px;" name="kategori">
                                    <option value="Buang">Buang</option>
                                    <option value="Proses">Proses</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div> 
                    <div class="modal-footer">
                        <input type="submit" name="savemaster" id="savemaster" class="btn btn-info" value="Save"/>
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
var tableDetail = $('#table_master').DataTable({
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
      // "searching": false,
      // "scrollX": true,
      // "scrollY": "700px",
      // "scrollCollapse": true,
      // "paging": false,
      // "lengthChange": false,
      // "ordering": true,
      // "info": true,
      // "autoWidth": false,
      "order": [[1, 'asc']],
      processing: true,
      serverSide: true,
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
    
      ajax: "{{ route('ehsspaccidents.dashboard_masterlimbah') }}",
      columns: [
            {data: null, name: null, orderable: false, searchable: false},
            {data: 'kd_limbah', name: 'kd_limbah'},
            {data: 'jenislimbah', name: 'jenislimbah'},
            {data: 'desc', name: 'desc'},
            {data: 'kategori', name: 'kategori'},
            {data: 'action', name: 'action', orderable:false, searchable: false},  
      ]
    });

$(document).ready( function () {


   
    });

$('#form_master_add').submit(function (e, params) {

    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();
      var valid = 'T';
      if(valid === 'T') {
        //additional input validations can be done hear
        swal({
          title: 'Apakah data sudah benar?',
          text: '',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes!',
          cancelButtonText: '<i class="fa fa-thumbs-down"></i> No!',
          allowOutsideClick: true,
          allowEscapeKey: true,
          allowEnterKey: true,
          reverseButtons: false,
          focusCancel: false,
        }).then(function () {
           $.ajax({
        url: "{{ route('ehsspaccidents.store_masterlimbah') }}",
        type: 'POST',
        data: $('#form_master_add').serialize(),
        dataType: 'json',
        success: function( _response ){
          swal(
            'Sukses',
            'Limbah B3 Berhasil Ditambahkan!',
            'success'
            )
          $('.modal').modal('hide');
       // var urlRedirect = "{{route('ehsspaccidents.index_masterlimbah')}}";    
        //window.location.href = urlRedirect;
         $("#form_master_add").load("{{route('ehsspaccidents.index_masterlimbah')}} #form_master_add");
           tableDetail.ajax.reload();

        },
        error: function( _response ){
          swal(
            'Terjadi kesalahan',
            'Segera hubungi Admin!',
            'error'
            )
        }
    });
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
    }
  });  


  function hapus_limbah(id)
   {
      var msg = 'Yakin hapus data limbah '+id+'?';
      var txt = '';
      //additional input validations can be done hear
      swal({
        title: msg,
        text: txt,
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: 'grey',
        confirmButtonText: '<i class="fa fa-check-circle" ></i> Yes',
        cancelButtonText: '<i  class="fa fa-times" ></i> No',
        allowOutsideClick: true,
        allowEscapeKey: true,
        allowEnterKey: true,
        reverseButtons: false,
        focusCancel: true,
      }).then(function () {
          var urlRedirect = "{{route('ehsspaccidents.delete_masterlimbah', 'param')}}";    
          urlRedirect = urlRedirect.replace('param', id);
      // var urlRedirect = "/hronline/mobile/approvallupaprik/"+id+"/setuju/";
       //window.location.href = urlRedirect;
       //window.open(urlRedirect);
        $.ajax({
          url      : urlRedirect,
          type     : 'GET',
          dataType : 'json',
          success: function(_response){
         if(_response.indctr == '1'){
            swal('Sukses', 'Limbah Dengan Kode '+id+' Berhasil Dihapus!','success'
            )
        $('.modal').modal('hide');
       // var urlRedirect = "{{route('ehsspaccidents.index_masterlimbah')}}";    
       // window.location.href = urlRedirect;
        tableDetail.ajax.reload();
          } else if(_response.indctr == '0'){
            console.log(_response)
            swal('Terjadi kesalahan', 'Segera hubungi Admin!', 'info'
            )
          }
        },
        error: function(){
          swal(
            'Terjadi kesalahan',
            'Segera hubungi Admin!',
            'info'
            )
        }
        });
       
      }, function (dismiss) {    
        if (dismiss === 'cancel') {
        }
      })
  }

  
  $('#form_master_update').submit(function (e, params) {
      var msg = 'Yakin update data limbah '+id+'?';
      var txt = '';
      //additional input validations can be done hear
      swal({
        title: msg,
        text: txt,
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: 'grey',
        confirmButtonText: '<i class="fa fa-check-circle" ></i> Yes',
        cancelButtonText: '<i  class="fa fa-times" ></i> No',
        allowOutsideClick: true,
        allowEscapeKey: true,
        allowEnterKey: true,
        reverseButtons: false,
        focusCancel: true,
      }).then(function () {
          var urlRedirect = "{{route('ehsspaccidents.update_masterlimbah')}}";    
      // var urlRedirect = "/hronline/mobile/approvallupaprik/"+id+"/setuju/";
       //window.location.href = urlRedirect;
       //window.open(urlRedirect);
        $.ajax({
          url      : urlRedirect,
          type     : 'POST',
          data     : $('#form_master_update').serialize(),
          dataType : 'json',
          success: function(_response){
         if(_response.indctr == '1'){
            swal('Sukses', 'Limbah Dengan Kode '+id+' Berhasil Diupdate!','success'
            )
        $('.modal').modal('hide');
        var url = "{{route('ehsspaccidents.index_masterlimbah')}}";    
        window.location.href = url;
          } else if(_response.indctr == '0'){
            console.log(_response)
            swal('Terjadi kesalahan', 'Segera hubungi Admin!', 'info'
            )
          }
        },
        error: function(){
          swal(
            'Terjadi kesalahan',
            'Segera hubungi Admin!',
            'info'
            )
        }
        });
       
      }, function (dismiss) {    
        if (dismiss === 'cancel') {
        }
      })
  });
</script>

<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
</script>

@endsection