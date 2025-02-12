@extends('layouts.app')
@section('content')

<!-- App_IK4 -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Pengajuan Izin
      <small>Izin Terlambat</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Pengajuan Izin Terlambat</li>
    </ol>
  </section>
  
  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <!-- Form Izin Terlambat -->
    <!-- Info boxes -->
    <div id="demo" class="collapse">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Formulir Pengajuan Izin Terlambat</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row form-group">
                <div class="col-sm-12">
                  {!! Form::open(['id' => 'form_id', 'url'=> route('mobiles.itelatsubmit'), 'method' =>'post', 'class'=>'form-horizontal', 'autocomplete' => 'off'])!!}
                      <button id="lihat_prosedur" onclick="prosedur()" class="btn btn-success btn-md" type="button"><span class="glyphicon glyphicon-info-sign"></span> LIHAT PROSEDUR PENGAJUAN</button>
                  <div class="form-group wordwrap" >
                    {!! Form::label('npk', 'NPK', ['class'=>'col-md-4 control-label']) !!}
                    <div class="col-md-3">
                      {!! Form::text('npk', $inputkar->npk,['id' => 'npk','class'=>'form-control','readonly' => 'true']) !!}
                    </div>
                  </div>  
                  <div class="form-group wordwrap" >
                    {!! Form::label('nama', 'Nama Karyawan', ['class'=>'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                      {!! Form::text('nama', $inputkar->nama, ['class'=>'form-control','readonly' => 'true']) !!}
                    </div>
                  </div>
                  <!-- <input id="npk_atasan" name="npk_atasan" type="hidden" value="{{$inputkar->npk_sec_head }}"> -->
                  <div class="form-group wordwrap">
                     {!! Form::label('atasan', 'NPK Atasan', ['class'=>'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                    <select id="npk_atasan" name="npk_atasan" class="form-control select2" style="width:100%;">
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
                  </div>
                  </div>

                  <div class="form-group wordwrap" >
                    {!! Form::label('pt', 'PT', ['class'=>'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                      {!! Form::text('pt', $inputkar->kd_pt, ['class'=>'form-control','readonly' => 'true']) !!}
                    </div>
                  </div>
                  <div class="form-group wordwrap">
                    {!! Form::label('dept', 'Departemen / Divisi', ['class'=>'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                      {!! Form::text('dept', ($inputkar->desc_dep . ' / ' . $inputkar->desc_div ), ['class'=>'form-control','readonly' => 'true']) !!}
                    </div>
                  </div>
                  <hr>
                  <div class="form-group wordwrap">
                      {!! Form::label('atasan', 'Shift', ['class'=>'col-md-4 control-label']) !!}
                     <div class="col-md-6">
                     <select id="shift" name="shift" class="form-control select2" style="width:100%;">
                       <option value="1">SHIFT 1</option>
                       <option value="2">SHIFT 2</option>
                       <option value="3">SHIFT 3</option>
                     </select>
                   </div>
                   </div>
                  <div class="form-group{{ $errors->has('tglijin') ? ' has-error' : '' }}">
                    {!! Form::label('tglijin', 'Tanggal Izin', ['class'=>'col-md-4 control-label']) !!}
                    <div class="col-md-2">
                      {!! Form::text('tglijin', null, ['id' => 'tanggal_text','class'=>'form-control datepicker','style' => 'background-color:#fff;line-height: 15px;padding-left: 15px;', 'readonly']) !!}
                      {!! $errors->first('tglijin', '<p class="help-block">Wajib diisi!</p>') !!}
                    </div>
                  </div>
                  <div class="form-group{{ $errors->has('alasanit') ? ' has-error' : '' }}">
                    {!! Form::label('alasanit', 'Alasan Terlambat', ['class'=>'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                      {!! Form::textarea('alasanit', null, ['id' => 'alasan_text', 'class'=>'form-control', 'rows'=>'2']) !!}
                      {!! $errors->first('alasanit', '<p class="help-block">Wajib diisi!</p>') !!}
                    </div>
                  </div>
                  <div class="form-group{{ $errors->has('jamin') ? ' has-error' : '' }}">
                    {!! Form::label('jamin', 'Jam Masuk', ['class'=>'col-md-4 control-label']) !!}
                    <div class="col-md-2">  
                      {!! Form::time('jamin', \Carbon\Carbon::now()->format('H:i'), ['id' => 'waktu_text','class'=>'form-control', 'style' => 'background-color:#fff;line-height: 15px;']) !!}
                      {!! $errors->first('jamin', '<p class="help-block">Wajib diisi!</p>') !!}         
                    </div>
                  </div>
                  <div class="col-md-6 col-md-offset-4">
                    <button class="btn btn-primary" id="submitklik">
                      <i class="fa fa-btn fa-envelope"></i> Submit
                    </button>
                  </div>
                  {!! Form::close() !!}
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
    </div>
    <!-- Form Izin Terlambat -->
    
    <!-- Riwayat Izin Terlambat -->
    <!-- Info boxes -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Riwayat Pengajuan Izin Terlambat</h3>
            
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <button id="tambahpengajuan" class="btn btn-primary" onclick="showAdd()" style="margin-bottom:8px;"><span class="glyphicon glyphicon-plus"></span> Pengajuan Ijin telat</button>
            <div class="row form-group">
              <div class="col-sm-12">
                <!-- <div class="alert alert-info">
                  <strong>Perhatian!</strong>
                  <ul>
                    <li>Hubungi atasan masing-masing untuk konfirmasi izin melalui sistem pengajuan izin terlambat</li>
                    <li>Setelah permohonan diizinkan, pemohon dapat mencetak konfirmasi sebagai bukti telah diizinkan oleh atasan</li>
                  </div> -->
                  <select autocomplete="off" class="form-control" style="width:150px;float:left;margin: 0px 12px 10px 0px;" id="table-dropdown">           
                    <option value="Menunggu diproses">Belum diproses</option>
                    <option value="Izin ditolak">Ditolak</option>
                    <option value="Izin diterima">Disetujui</option>
                    <option value="">Semua</option>
                  </select>
                  <button id="refreshdata" class="btn btn-success" onclick="refreshList()">Refresh</button>
                  <table id="dtRiwayat" class="table-bordered table-striped" style="width:100%;">
                    <thead>
                      <tr>
                        <th style="width:60px;">Action</th>
                        <th>Tgl Aju</th>
                        <th>Tgl Ijin</th>
                        <th>Status</th>
                        <th>No. IK</th>
                        <th>Masuk</th>
                        <th>Alasan</th>
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
      <!-- Riwayat Izin Terlambat -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection
  
  
  @section('scripts')
  <script type="text/javascript">
    
    
    $(document).ready(function(){
      $('#npk_atasan').select2();

      $("#form_id").on('submit', function(e){
        e.preventDefault();
        var alasan = document.getElementById("alasan_text").value.trim();
        var waktu = document.getElementById("waktu_text").value.trim();
        var tanggal = document.getElementById("tanggal_text").value.trim();
        var refreshTable = document.getElementById("refreshdata");
        var npk = document.getElementById("npk").value.trim();
        var npk_atasan = document.getElementById("npk_atasan").value.trim();
        var token = document.getElementsByName("_token")[0].value.trim();
        
        if(alasan === null || alasan === "" || waktu === null || waktu === "" || tanggal === null || tanggal === ""){
          swal('Input belum lengkap!');
          return;
        }
        
        swal({
          title: 'Anda yakin ingin submit?',
          text: '',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, submit',
          cancelButtonText: 'Batal',
          allowOutsideClick: true,
          allowEscapeKey: true,
          allowEnterKey: true,
          reverseButtons: false,
          focusCancel: false,
        }).then(function () {
          document.getElementById("tanggal_text").value = tanggal.split('-').join('/');
          $('.btn').prop('disabled', true);
          $.ajax({
            url: "{{ route('mobiles.itelatsubmit') }}",
            type: 'post',
            cache: false,
            dataType: 'json',
            data: $('#form_id').serialize(), // Remember that you need to have your csrf token included
            success: function( _response ){
              if (_response.msg == 'OK') {
                swal(
              'Ijin Telat Berhasil Disubmit',
              '<p style="text-align:left;">1.	Hubungi Atasan anda (min. Section Head) terlebih dahulu untuk minta Ijin Telat<br>\
              2.	Pastikan atasan anda menyetujui ijin ini, kemudian input datanya di Aplikasi ini<br>\
              3.	Pastikan atasan anda sudah tahu agar data anda di Approval (Disetujui) di Aplikasi.<br>\
              4.	Jika atasan tidak Approval (Persetujuan) di Aplikasi, maka data ijin anda tidak ter-update di Absensi, oleh karenanya info ke atasan untuk approval setelah data ijin anda input</p>',
              'success'
              )
              console.log(_response);
              $('#tambahpengajuan').show();
              $('.collapse').collapse('hide');
              refreshList();
              $('.btn').prop('disabled', false);
              $('html, body').animate({
                scrollTop: $("body").offset().top
              }, 0);
            } else {
              swal(
              'Info',
              'Pengajuan tidak berhasil, harap hubungi Admin!',
              'info'
              )
              $('.btn').prop('disabled', false);
            }
              
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
      });   
    });

    $('.datepicker').datepicker({
      format : 'dd-mm-yyyy'
    })
    
    var table = $('#dtRiwayat').DataTable({
      responsive: {
        details: {
          type: 'column',
          target: 2
        }
      },
      columnDefs: [ {
        className: 'control',
        orderable: false,
        targets:   []
      } ],
      "order": [[ 1, "desc" ]],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      searching: true,
      ajax: {
        url: '{{ url("/hronline/mobile/izinterlambat/data") }}',
      },
      "deferRender": true,
      columns: [
      {data: 'action', name:'', orderable:false, searchable:false},    
      {data: 'tglpengajuan', name: 'itelatpengajuan.tglpengajuan'},
      {data: 'tglijin', name: 'itelatpengajuan.tglijin'},
      {data: 'status', name: 'itelatpengajuan.status'}, 
      {data: 'no_ik', name: 'itelatpengajuan.no_ik'},
      {data: 'jam_masuk', name: 'itelatpengajuan.jam_masuk'},
      {data: 'alasan_it', name: 'itelatpengajuan.alasan_it'},
      
      ],
      dom: '<"top">flrt<"bottom"pi>'   
    });  
    
    $('#table-dropdown').ready(function(){
      table.column(3).search('Menunggu diproses').draw();   
    });    
    $('#table-dropdown').on('change', function(){
      table.column(3).search(this.value).draw();   
    }); 
    
    function refreshList(){
      table.ajax.reload();
    }
    
    function banding(ths) {
      var no_value = document.getElementById('no_ik_banding'+ths).value.trim();
      var token = document.getElementsByName('_token')[0].value.trim();
      var alasan = document.getElementById('new_alasan'+ths).value;
      var urlappr = "{{ route('mobiles.itelatbanding') }}";
      $.ajax({
        url      : urlappr,
        type     : 'POST',
        dataType : 'json',
        data     : {
          no_ik   : no_value,
          new_alasan : alasan,
          _token  : token,
        },
        success: function(_response){
          console.log(_response);
          if(_response.indctr == '1'){
            swal('Sukses', 'Pengajuan izin terlambat berhasil disubmit!','success'
            )
            $('.modal').modal('hide');
            refreshList();
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
    }

    function hapus_pengajuan(ths){
        var token = document.getElementsByName("_token")[0].value.trim();
        var no_ik = ths;
        var refreshTable = document.getElementById("refreshdata");
        swal({
          title: 'Hapus pengajuan ijin telat? ',
          text: '',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, hapus',
          cancelButtonText: 'Batal',
          allowOutsideClick: true,
          allowEscapeKey: true,
          allowEnterKey: true,
          reverseButtons: false,
          focusCancel: false,
        }).then(function () {
          $('.btn').prop('disabled', true);
          $.ajax({
            url: "{{ route('mobiles.hapusitelat') }}",
            type: 'post',
            cache: false,
            dataType: 'json',
            data: {
              _token : token, // Remember that you need to have your csrf token included
              no_ik : no_ik
            }, 
            success: function( _response ){
              if (_response.msg == 'OK') {
                swal(
              'Sukses',
              'Pengajuan berhasil dihapus',
              'success'
              )
              refreshList();
              $('.btn').prop('disabled', false);
            } else {
              swal(
              'Info',
              'Pengajuan tidak berhasil dihapus, harap hubungi Admin!',
              'info'
              )
              $('.btn').prop('disabled', false);
            }
              
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
    
    function showAdd(){
      $('.collapse').collapse('show');
      $('#tambahpengajuan').hide();
      swal(
          'Prosedur Input Ijin Telat : ',
          '<p style="text-align:left;">1.	Hubungi Atasan anda (min. Section Head) terlebih dahulu untuk minta Ijin Telat<br>\
            2.	Pastikan atasan anda menyetujui ijin ini, kemudian input datanya di Aplikasi ini<br>\
            3.	Pastikan atasan anda sudah tahu agar data anda di Approval (Disetujui) di Aplikasi.<br>\
            4.	Jika atasan tidak Approval (Persetujuan) di Aplikasi, maka data ijin anda tidak ter-update di Absensi, oleh karenanya info ke atasan untuk approval setelah data ijin anda input</p>',
          'info'
          )
    }

    function prosedur(){
      swal(
          'Prosedur Input Ijin Telat : ',
          '<p style="text-align:left;">1.	Hubungi Atasan anda (min. Section Head) terlebih dahulu untuk minta Ijin Telat<br>\
            2.	Pastikan atasan anda menyetujui ijin ini, kemudian input datanya di Aplikasi ini<br>\
            3.	Pastikan atasan anda sudah tahu agar data anda di Approval (Disetujui) di Aplikasi.<br>\
            4.	Jika atasan tidak Approval (Persetujuan) di Aplikasi, maka data ijin anda tidak ter-update di Absensi, oleh karenanya info ke atasan untuk approval setelah data ijin anda input</p>',
          'info'
          )
    }
    
  </script>
  @endsection
