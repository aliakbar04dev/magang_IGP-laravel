@extends('layouts.app')
@section('content')

<style>
.btn-group-sm > .btn, .btn-sm {
    padding: 3px 7px;
}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pengajuan Tidak Prik
        <small></small>
      </h1>
      <ol class="breadcrumb">
          <li>
            <a href="{{ url('/home') }}">
              <i class="fa fa-dashboard"></i> Home</a>
          </li>
          <li>
            <i class="glyphicon glyphicon-info-sign"></i> Tidak Prik
          </li>
          <li class="active">
            <i class="fa fa-files-o"></i> Pengajuan Tidak Prik
          </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')

<div class="collapse" id="showform">
       <div class="row" id="field_detail">
          <div class="col-md-12">
             <div class="box box-primary">
               <div class="box-header with-border" >
                  <h3 class="box-title"  ><b>Formulir Pengajuan Tidak Prik </b></h3>
                    <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                          </button>
                        <!--  <button type="button" class="btn btn-box-tool" data-widget="hide"><i class="fa fa-times"></i></button> -->
                    </div>
              </div>
              <!-- /.box-header -->
              
              <!-- form start -->
        <div class="box-body">
          <div class="form-group">

          <button class="btn btn-md btn-success" onclick="notifikasi()"> <span class="glyphicon glyphicon-info-sign"></span> Lihat Prosedur Pengajuan  </button> <br><br>
         
            {!! Form::open(['url' => route('mobiles.storelupaprik'), 'method' => 'post', 'class'=>'form-horizontal', 'id'=>'form_id']) !!}

            

                  <div class="form-group{{ $errors->has('npk') ? ' has-error' : '' }}">
                     {!! Form::label('npk', 'NPK Pemohon', ['class'=>'col-md-2 control-label']) !!}
                        <div class="col-md-4">
                          {!! Form::text('npk', ($kar->first()->npk), ['class'=>'form-control' , 'readonly' => 'true']) !!}
                          {!! $errors->first('npk', '<p class="help-block">:message</p>') !!}
                        </div>
                  </div>
            
                <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                    {!! Form::label('nama', 'Nama Pemohon', ['class'=>'col-md-2 control-label']) !!}
                      <div class="col-md-4">
                        {!! Form::text('nama', $kar->first()->nama, ['class'=>'form-control' , 'readonly' => 'true']) !!}
                        {!! $errors->first('nama', '<p class="help-block">:message</p>') !!}
                      </div>
                </div>

              <div class="form-group{{ $errors->has('namapt') ? ' has-error' : '' }}">
                   {!! Form::label('namapt', 'Nama PT', ['class'=>'col-md-2 control-label']) !!}
                      <div class="col-md-4">
                        {!! Form::text('namapt', $kar->first()->kd_pt, ['class'=>'form-control' , 'readonly' => 'true']) !!}
                        {!! $errors->first('namapt', '<p class="help-block">:message</p>') !!}
                      </div>
              </div>      

            <div class="form-group{{ $errors->has('namabagian') ? ' has-error' : '' }}">
                 {!! Form::label('namabagian', 'Nama Dept.', ['class'=>'col-md-2 control-label']) !!}
                  <div class="col-md-4">
                    {!! Form::text('namabagian', $kar->first()->desc_dep, ['class'=>'form-control' , 'readonly' => 'true']) !!}
                    {!! $errors->first('namabagian', '<p class="help-block">:message</p>') !!}
                  </div>
            </div>

  

      <hr>

            <div class="form-group has-feedback{{ $errors->has('nolp') ? ' has-error' : '' }}">
              {!! Form::hidden('nolp', 'No Pengajuan', ['class'=>'col-md-2 control-label']) !!}
               <div class="col-md-4">
              {!! Form::hidden('nolp', $nolp , ['class'=>'form-control', 'readonly' => 'true']) !!}
              {!! $errors->first('nolp', '<p class="help-block">:message</p>') !!}
               </div>
           </div>
            
            <div class="form-group{{ $errors->has('tgllupa') ? ' has-error' : '' }}">
              {!! Form::label('tgllupa', 'Tanggal Tidak Prik', ['class'=>'col-md-2 control-label']) !!}
                <div class="col-md-4">
                  {!! Form::date('tgllupa', null, ['class'=>'form-control', 'id'=>'tgllupa']) !!}
                  {!! $errors->first('tgllupa', '<p class="help-block">:message</p>') !!}
                </div>
            </div> 

          <div class="form-group has-feedback{{ $errors->has('atasan') ? ' has-error' : '' }}">
          {!! Form::label('atasan', 'NPK Atasan', ['class'=>'col-md-2 control-label']) !!}
            <div class="col-md-4">
              <select id="npkatasan" name="npkatasan" class="form-control select2" style="width:100%;">
                      @if ($npk_atasan_div != '')
                      <option value="{{ $npk_atasan_div }}" selected>{{ $npk_atasan_div }} - {{ $inputatasan_div }}</option>
                      @endif
                      @if ($npk_atasan_dep != '')
                      <option value="{{ $npk_atasan_dep }}" selected>{{ $npk_atasan_dep }} - {{ $inputatasan_dep }}</option>
                      @endif
                      @if ($npk_atasan_sec != '')
                      <option value="{{ $npk_atasan_sec }}" selected>{{ $npk_atasan_sec }} - {{ $inputatasan_sec }}</option>
                      @endif
                      @foreach ($get_atasan as $atasan)
                      @if ($atasan->npk != $npk_atasan_div && $atasan->npk != $npk_atasan_dep && $atasan->npk != $npk_atasan_sec)
                        <option value="{{ $atasan->npk }}">{{ $atasan->npk }} - {{ $atasan->nama }}</option>
                      @endif
                      @endforeach
                      </option>
              </select>
              {!! $errors->first('npk_atasan', '<p class="help-block">:message</p>') !!}
            </div>
        </div>   

                   <div class="form-group">
               {!! Form::label('shift', 'Shift', ['class'=>'col-md-2 control-label']) !!}
                <div class="col-md-4">
                   <select id="shift" name="shift" class="form-control select2" style="width:100%;">
                      <option value="1">SHIFT 1</option>
                      <option value="2">SHIFT 2</option>
                      <option value="3">SHIFT 3</option>
                    </select>
                {!! $errors->first('shift', '<p class="help-block">:message</p>') !!}
                </div>
            </div>      

            <div class="form-group{{ $errors->has('option') ? ' has-error' : '' }}">
               {!! Form::label('option', 'Jam Tidak Prik', ['class'=>'col-md-2 control-label']) !!}
                <div class="col-md-4">
                    <input type="radio" name="jamlupa" value="1" onclick="javascript:inoutCheck();" id="jammasuk"> Jam Masuk <br>
                    <input type="radio" name="jamlupa" value="2" onclick="javascript:inoutCheck();" id="jamkeluar"> Jam Keluar<br>
                    <input type="radio" name="jamlupa" value="3" onclick="javascript:inoutCheck();" id="jammakel"> Jam Masuk & Jam Keluar<br>
                {!! Form::hidden('ket_jam', null , ['class'=>'form-control', 'readonly' => 'true', 'id'=>'ket_jam']) !!}
                {!! $errors->first('tgllupa', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            
            <div  id="ifjm" style="display:none"> 
              <div class="form-group{{ $errors->has('jamin') ? ' has-error' : '' }}">
                {!! Form::label('jamin', 'Jam Masuk', ['class'=>'col-md-2 control-label']) !!}
                  <div class="col-md-4">
                    {!! Form::time('jamin', null, ['class'=>'form-control ']) !!}   
                    {!! $errors->first('jamin', '<p class="help-block">:message</p>') !!}
                </div>
              </div>    
            </div>

          <div id="ifjk" style="display:none">
            <div class="form-group{{ $errors->has('jamout') ? ' has-error' : '' }}" >
               {!! Form::label('jamout', 'Jam Keluar', ['class'=>'col-md-2 control-label']) !!}
                  <div class="col-md-4">
                    {!! Form::time('jamout', null, ['class'=>'form-control']) !!}
                    {!! $errors->first('jamout', '<p class="help-block">:message</p>') !!}
                  </div>
            </div>
         </div>

        <div class="form-group has-feedback{{ $errors->has('alasan') ? ' has-error' : '' }}">
          {!! Form::label('alasanlupa', 'Alasan', ['class'=>'col-md-2 control-label']) !!}
            <div class="col-md-4">
              {!! Form::textarea('alasanlupa', null, ['class'=>'form-control', 'id'=>'alasanlupa', 'maxlength' => 150, 'rows' => '3']) !!}
              {!! $errors->first('alasanlupa', '<p class="help-block">:message</p>') !!}
            </div>
        </div>




        <div class="box-footer">
          <div class="form-group">
            <div class="col-md-4 col-md-offset-2"> 
                <button type="submit" class="btn btn-primary"><i class="fa fa-btn fa-envelope"> </i> Submit </button>       
               <!--  {!! Form::submit('Submit', ['class'=>'btn btn-primary glyphicon glyphicon-floppy-disk', 'id' => 'btn-save']) !!}     -->
           <!--   <a class="btn btn-default glyphicon glyphicon-remove-sign" href="{{ route('mobiles.indexlupaprik') }}"> Batal </a>  -->
            </div>
          </div>
        </div>
            
  {!! Form::close() !!}

          <script type="text/javascript">
              function inoutCheck() {

                 if (document.getElementById('jammasuk').checked) {
                      document.getElementById('ifjk').style.display = 'none';
                      document.getElementById('ifjm').style.display = 'block'
                      document.getElementById("jamin").required = true;  
                      document.getElementById("jamout").required = false;
                      document.getElementById("jamout").value = null;
                      document.getElementById('ket_jam').value = 'ok';
                  }

                  else if (document.getElementById('jamkeluar').checked) {
                     document.getElementById('ifjm').style.display = 'none';
                     document.getElementById('ifjk').style.display = 'block';
                     document.getElementById("jamin").required = false;  
                     document.getElementById("jamout").required = true;
                     document.getElementById("jamin").value = null;
                     document.getElementById('ket_jam').value = 'ok';
                  }

                  else if (document.getElementById('jammakel').checked) {
                      document.getElementById('ifjm').style.display = 'block';
                      document.getElementById('ifjk').style.display = 'block';
                      document.getElementById("jamin").required = true; 
                      document.getElementById("jamout").required = true;  
                      document.getElementById('ket_jam').value = 'ok';
                  }
              }
          </script>

      
        </div>
      </div>
    </div>
  </div>
</div>
</div>

      <div class="row" id="field_detail">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><b>Daftar Pengajuan Tidak Prik </b></h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="box-header">
                <p> <a class="btn btn-primary" id="inputlupaprik"  >
                    <span class="fa fa-plus"></span>  Pengajuan Tidak Prik  </a>
                </p>
              </div>
     

              <table>
                <td>
                 <div id="filter_status_apr" class="dataTables_length" style="width:180px;margin-left:10px;">
                  <select style="margin-bottom: 8px;" size="1" name="filter_status_apr" aria-controls="filter_status_apr"     class="form-control select2" style="width: 150px;">
                      <option value="ALL" selected="selected">ALL</option>
                      <option value="1">Disetujui</option>
                      <option value="2">Ditolak</option>
                      <option value="3">Belum Approval</option>
                    </select>
                  </div> 
                </td>
                <td style="width:3%"> </td>
                <td>  <button class="btn btn-success" onclick="refresh()">Refresh</button></td>
              </table>
       <br>
               
       <table id="tblDetail" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th style="width:80px;">Action</th>
                    <th>No Pengajuan</th>
                    <th>Status</th>  
                    <th>Tgl Tidak Prik</th>              
                    <th>Alasan</th>
                    <th>Tgl Pengajuan</th>
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

  $(function() {
      $("#tblDetail").on('preXhr.dt', function(e, settings, data) {
         data.status = $('select[name="filter_status_apr"]').val();
      });

      $('select[name="filter_status_apr"]').change(function() {
        tableDetail.ajax.reload();
      });
    });
  });


  
</script>

<script type="text/javascript">

var tableDetail = $('#tblDetail').DataTable({
  responsive: {
    details: {
      type: 'column',
      target: 2
    }
  },
        "columnDefs": [{
        "searchable": false,
        "orderable": false,
     //   "targets": 0,
        render: function (data, type, row, meta) {
       return meta.settings._;
       }
    }],
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
 
      // "searching": false,
      // "scrollX": true,
      // "scrollY": "700px",
      // "scrollCollapse": true,
      // "paging": false,
      // "lengthChange": false,
      // "ordering": true,
      // "info": true,
      // "autoWidth": false,
      "order": [[1, 'desc']],
      processing: true,
      serverSide: true,
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 

      ajax: "{{ route('mobiles.dashboardlupaprik') }}",
      columns: [
    //  {data: null, name: null, orderable: false, searchable: false},
        {data: 'action', name: 'status', orderable: false, searchable: false},
        {data: 'no_lp', name: 'no_lp'},
        {data: 'status', name: 'status'},
        {data: 'tgllupa', name: 'tgllupa'},
        {data: 'alasanlupa', name: 'alasanlupa'},
        {data: 'tglpengajuan', name: 'tglpengajuan'},    
      ]
    });

  function refresh(){
    tableDetail.ajax.reload();
  }

  function notifikasi(){
   var info = "Prosedur Input Tidak Prik:";
      swal(info, "<p align='left'> 1.  Hubungi atasan Anda (min. Section Head) terlebih dahulu untuk info Anda Tidak Prik <br>2.  Pastikan atasan Anda mengetahui pengajuan Tidak Prik agar data Anda di Approval(disetujui) di Aplikasi. <br>3.  Jika atasan tidak Approval di Aplikasi, maka data Tidak Prik Anda tidak ter-update di Absensi. Oleh karenanya cek status di Aplikasi setelah data Anda input. </p>", "info");
  }

 $("#inputlupaprik").click(function(){  
        notifikasi();
        $("#showform").collapse();
        $("#inputlupaprik").hide();
    });
  
  $('#form_id').submit(function (e, params) {
  //  var id =  "<?php echo $nolp ?>";
    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();
      var tgllupa = document.getElementById("tgllupa").value;
      var alasanlupa = document.getElementById("alasanlupa").value;
      var ket_jam = document.getElementById('ket_jam').value;
     if (tgllupa === "" || alasanlupa === "" || ket_jam ==="" && (tgllupa ==="" || alasanlupa === ""||  ket_jam ==="")) {
      var info = "Perhatikan inputan anda!";
      swal(info, "Data tidak boleh kosong, mohon untuk diisi!", "info");
      } else {
        swal({
          title: 'Apakah data pengajuan sudah benar?',
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
        url: "{{route('mobiles.storelupaprik') }}",
        type: 'POST',
        data: $('#form_id').serialize(),
        dataType: 'json',
        success: function( _response ){
          if(_response.indctr == '1'){
            console.log(_response)
          swal(
            'Pengajuan Berhasil Diajukan!',
            "<p align='left'>Perhatian:<br> 1.  Hubungi atasan Anda (min. Section Head) terlebih dahulu untuk info Anda Tidak Prik <br>2.  Pastikan atasan Anda mengetahui pengajuan Tidak Prik agar data Anda di Approval(disetujui) di Aplikasi. <br>3.  Jika atasan tidak Approval di Aplikasi, maka data Tidak Prik Anda tidak ter-update di Absensi. Oleh karenanya cek status di Aplikasi setelah data Anda noteinput. </p>",
            'success'
            ).then(function(){
        var urlRedirect = "{{route('mobiles.indexlupaprik')}}";    
        window.location.href = urlRedirect;
          })
        } else if(_response.indctr == '0'){
            console.log(_response)
            swal('Terjadi kesalahan saat menyimpan', 'Segera hubungi Admin!', 'info'
            )
          }
        },
        error: function( _response ){
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
    }
  });

    function hapus(id)
   {
      var msg = 'Yakin Menghapus Pengajuan Tidak Prik No.'+id+'?';
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
         var urlRedirect = "{{route('mobiles.hapuslupaprik', 'param')}}"; 
          urlRedirect = urlRedirect.replace('param', id);
    
        $.ajax({
          url      : urlRedirect,
          type     : 'GET',
          dataType : 'json',
          success: function(_response){
         if(_response.indctr == '1'){
            console.log(_response)
            swal('Sukses', 'Pengajuan Tidak Prik '+id+' Berhasil Dihapus!','success'
            )
        $('.modal').modal('hide');
           tableDetail.ajax.reload();
          } else if(_response.indctr == '0'){
            console.log(_response)
            swal('Terjadi kesalahan saat menghapus', 'Segera hubungi Admin!', 'info'
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

  function ajukanbanding(id)
     {
      var msg = 'Anda yakin mengajukan banding dengan nomer pengajuan '+id+'?';
      var txt = '';
      //additional input validations can be done hear
      swal({
        title: msg,
        text: txt,
        type: 'warning',
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

        var urlRedirect = "{{route('mobiles.ajuankembalilupaprik', 'param')}}";    
          urlRedirect = urlRedirect.replace('param', id);
       $.ajax({
          url      : urlRedirect,
          type     : 'GET',
          dataType : 'json',
          success: function(_response){
         if(_response.indctr == '1'){
            swal('Sukses', 'Pengajuan Tidak Prik <b>'+id+'</b> berhasil diajukan kembali!','success'
            )
            $('.modal').modal('hide');
             tableDetail.ajax.reload();
          } else if(_response.indctr == '0'){
            console.log(_response)
            swal('Terjadi kesalahan', 'Segera hubungi Admin!', 'error'
            )
          }
        },
        error: function(){
          swal(
            'Terjadi kesalahan',
            'Segera hubungi Admin!',
            'error'
            )
        }
        });
      }, function (dismiss) {
        if (dismiss === 'cancel') {
        }
      })
    }

</script>

@endsection