@extends('layouts.app')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Festronik
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
            <i class="fa fa-files-o"></i> Approval Festronik
          </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row" id="field_detail">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
               <h3 class="box-title"><b>Monitoring Festronik</b></h3>
               <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <p> <a class="btn btn-primary" href="{{ route('ehsspaccidents.index_angkutlimb3') }}" ><span class="fa fa-plus"></span> Add Pengangkutan Limbah </a>
                </p>
          <div class="col-sm-2">
              {!! Form::label('filter_tahun', 'Tahun') !!}
              <select id="filter_tahun" name="filter_tahun" aria-controls="filter_status" 
              class="form-control select2">
              
                @for ($i = \Carbon\Carbon::now()->format('Y'); $i > \Carbon\Carbon::now()->format('Y')-5; $i--)
                  @if ($i == \Carbon\Carbon::now()->format('Y'))
                    <option value={{ $i }} selected="selected" >{{ $i }}</option>
                  @else
                    <option value={{ $i }}>{{ $i }}</option>
                  @endif
                @endfor
              </select>
            </div>

            <div class="col-sm-2">
              {!! Form::label('filter_bulan', 'Bulan') !!}
              <select id="filter_bulan" name="filter_bulan" aria-controls="filter_status" class="form-control select2">
                   <option value="01" @if ("01" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Januari</option>
                    <option value="02" @if ("02" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Februari</option>
                    <option value="03" @if ("03" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Maret</option>
                    <option value="04" @if ("04" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>April</option>
                    <option value="05" @if ("05" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Mei</option>
                    <option value="06" @if ("06" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Juni</option>
                    <option value="07" @if ("07" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Juli</option>
                    <option value="08" @if ("08" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Agustus</option>
                    <option value="09" @if ("09" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>September</option>
                    <option value="10" @if ("10" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Oktober</option>
                    <option value="11" @if ("11" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>November</option>
                    <option value="12" @if ("12" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Desember</option>
              </select>
            </div>

              <div class="col-sm-2" >
                    {!! Form::label('lblusername2', 'Action') !!}
                    <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
              </div>
            <br><br>
            <br><br>

    
          <div class="col-sm-2">
          {!! Form::label('jenislimbah', 'Jenis Limbah') !!}
          <select style="margin-bottom: 8px;"  name="plant" aria-controls="filter_limbah" id="filter_limbah"  class="form-control select2">
              <option value="" selected="selected">ALL</option>
               @foreach($jenislimbah as $row)  
                            <option value="{{$row->jenislimbah}}" name="{{$row->kd_limbah}}" id="{{$row->kd_limbah}}"> {{$row->jenislimbah}} </option> 
              @endforeach  
            </select>
         </div> 
       
         <div class="col-sm-2">
          {!! Form::label('pt', 'PT') !!}
          <select style="margin-bottom: 8px;" name="pt" aria-controls="filter_pt" id="filter_pt"    class="form-control select2">
              <option value="" selected="selected">ALL</option>
              <option value="IGPJ">IGP-Jakarta</option>
              <option value="IGPK">IGP-Karawang</option>
              <option value="GKDJ">GKD-Jakarta</option>
              <option value="GKDK">GKD-Karawang</option>
              <option value="AGIJ">AGI-Jakarta</option>
              <option value="AGIK">AGI-Karawang</option>
            </select>
         </div> 
       
          <div class="col-sm-2">
            {!! Form::label('status', 'Status') !!}
          <select style="margin-bottom: 8px;" size="1" name="status" aria-controls="filter_status" id="filter_status"  class="form-control select2">
              <option value="" selected="selected">ALL</option>
              <option value="1">Belum Approval</option>
              <option value="2">Approval Transporter </option>
              <option value="3">Approval Penghasil</option>
              <option value="4">Approval Penerima</option>
            </select>
         </div> 
         
        <div class="col-sm-2" style="display:none">
          {!! Form::label('refresh', ' ') !!}
          <br><br>
         <button class="btn btn-success" style="margin-bottom: 8px;" onclick="refresh()"><i class="fa fa-btn fa-refresh"> </i></button>
         </div>
       
<br>
</div>
      
            <div id="filter_status" class="dataTables_length" style="display: inline-block; margin-left:850px;">
            <label> Keterangan : </label>
            <i class="fa fa-check" style="font-size:25px;color:green"></i> OK
            <i class="fa fa-circle-o" style="font-size:25px;color:red"></i> NG
          </div>

             <div class="form-group" style="margin-left:10px; margin-right:10px;">
               <table id="table_angkutb3" class="table table-bordered table-striped" width="100%">
                        <thead>
                          <tr>
                            <th style='width: 1%; text-align: center; vertical-align: middle;' rowspan="2" >No</th>
                            <th style='width: 3%; vertical-align: middle;' rowspan="2">Tanggal</th>
                            <th style='width: 10%; vertical-align: middle;' rowspan="2">Jenis Limbah</th>
                            <th style='width: 5%; vertical-align: middle;' rowspan="2">No. Festronik</th>
                             <th style='width: 5%;vertical-align: middle;' rowspan="2">PT</th>
                             <th style='width: 2%; vertical-align: middle;' rowspan="2">Qty(ton)</th>
                            <th style='width: 30%; vertical-align: middle;' colspan="3"> <center>Status Festronik</center></th>
                             <th style='width: 1%; vertical-align: middle;' rowspan="2">Action</th>                     
                          </tr>
                          <tr>
                           <th>Transpoter</th>
                            <th>Penghasil</th>
                            <th>Penerima</th>
                          </tr>
                        </thead>
                </table> 
        </div>
      </div>
    </div>
    </div>
 

    </section>
</div>

@endsection

@section('scripts')
<script type="text/javascript" >

var tableDetail = $('#table_angkutb3').DataTable({
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
      "order": [[1, 'desc']],
      processing: true,
      serverSide: true,
       "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
    
      ajax: "{{ route('ehsspaccidents.dashboard_festronik') }}",
      columns: [
        {data: null, name: null, orderable: false, searchable: false},
        {data: 'tgl_angkut', name: 'tgl_angkut'},
        {data: 'jenislimbah', name: 'master_limbah.jenislimbah'},
        {data: 'no_festronik', name: 'no_festronik'},
        {data: 'pt', name: 'pt'},
        {data: 'qty', name: 'qty'},
        {data: 'statustransporter', name: 'status', orderable: false},
         {data: 'statuspenghasil', name: 'status', orderable: false},
        {data: 'statuspenerima', name: 'status', orderable: false},
        {data: 'action', name: 'status', orderable: false, searchable: false},
    
      ]
    });
  $('#filter_limbah').on('change', function(){
        tableDetail.column(2).search(this.value).draw();   
    });
  $('#filter_pt').on('change', function(){
        tableDetail.column(4).search(this.value).draw();   
    });
  $('#filter_status').on('change', function(){
     tableDetail.column(6).search(this.value).draw();   
     tableDetail.column(7).search(this.value).draw();   
     tableDetail.column(8).search(this.value).draw();   
    });
   $("#table_angkutb3").on('preXhr.dt', function(e, settings, data) {
        data.filter_tahun = $('select[name="filter_tahun"]').val();
        data.filter_bulan = $('select[name="filter_bulan"]').val();
    });

    $('#display').click( function () {
      tableDetail.ajax.reload();
    });

  function refresh(){
  tableDetail.ajax.reload();
}
 

 function approv_penghasil(id, id2, id3)
   {
      var msg = 'Yakin approval penghasil?';
      var txt = 'Pastikan inputan Anda sudah benar';
      var date_penghasil = document.getElementById("date_penghasil_"+id+"_"+id2+"_"+id3).value;
      if( date_penghasil ==null || date_penghasil == ""){
         swal('Data Tidak Boleh Kosong', 'Mohon untuk diisi!', 'info')
      }else{
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
          var urlRedirect = "{{route('ehsspaccidents.approv_penghasil', ['param', 'param2', 'param3'])}}";    
          urlRedirect = urlRedirect.replace('param', id);
          urlRedirect = urlRedirect.replace('param2', id2);
          urlRedirect = urlRedirect.replace('param3', id3);
        $.ajax({
          url      : urlRedirect,
          type     : 'GET',
         // data     : $('#date_penghasil').serialize(),
         data : {
          date_penghasil:date_penghasil
         },
          dataType : 'json',
          success: function(_response){
         if(_response.indctr == '1'){
            swal('Sukses', 'Festronik Berhasil Diapprov Penghasil!','success'
            )
            $('.modal').modal('hide');
            tableDetail.ajax.reload();
          } else if(_response.indctr == '0'){
            console.log(_response)
            swal('Terjadi kesalahan',  _response.msg  , 'info'
            )
          }
          else if(_response.indctr == '2'){
            console.log(_response)
            swal('Tanggal approval tidak sesuai', 'Mohon dicek kembali!', 'info')
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
  }

    function approv_transporter(id, id2, id3)
   {
      var msg = 'Yakin approval transporter?';
      var txt = 'Pastikan inputan Anda sudah benar';
      var date_transporter = document.getElementById("date_transporter_"+id+"_"+id2+"_"+id3).value;
      var no_festronik = document.getElementById("no_festronik_"+id+"_"+id2+"_"+id3).value;
      if( date_transporter ==null || no_festronik == null || date_transporter =="" || no_festronik == ""){
         swal('Data Tidak Boleh Kosong', 'Mohon untuk diisi!', 'info')
      }else{
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
          var urlRedirect = "{{route('ehsspaccidents.approv_transporter', ['param', 'param2', 'param3'])}}";    
          urlRedirect = urlRedirect.replace('param', id);
          urlRedirect = urlRedirect.replace('param2', id2);
          urlRedirect = urlRedirect.replace('param3', id3);
        $.ajax({
          url      : urlRedirect,
          type     : 'GET',
          data : {
          date_transporter:date_transporter,
          no_festronik:no_festronik,
         },
          dataType : 'json',
          success: function(_response){
          if(_response.indctr == '1'){
            swal('Sukses', 'Festronik Berhasil Diapprov Transporter!','success'
            )
            $('.modal').modal('hide');
            tableDetail.ajax.reload();
          } else if(_response.indctr == '0'){
            console.log(_response)
            swal('Terjadi kesalahan saat menyimpan', _response.msg , 'info'
            )
          } else if(_response.indctr == '2'){
            console.log(_response)
            swal('Tanggal approval tidak sesuai', 'Mohon dicek kembali!', 'info')
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
}


 function approv_penerima(id, id2, id3)
   {
      var msg = 'Yakin approval penerima?';
      var txt = 'Pastikan inputan Anda sudah benar';
      var date_penerima = document.getElementById("date_penerima_"+id+"_"+id2+"_"+id3).value;
      if( date_penerima ==null || date_penerima == ""){
         swal('Data Tidak Boleh Kosong', 'Mohon untuk diisi!', 'info')
      }else{
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
          var urlRedirect = "{{route('ehsspaccidents.approv_penerima', ['param', 'param2', 'param3'])}}";    
          urlRedirect = urlRedirect.replace('param', id);
          urlRedirect = urlRedirect.replace('param2', id2);
          urlRedirect = urlRedirect.replace('param3', id3);
        $.ajax({
          url      : urlRedirect,
          type     : 'GET',
          data : {
          date_penerima:date_penerima
         },
          dataType : 'json',
          success: function(_response){
         if(_response.indctr == '1'){
            swal('Sukses', 'Festronik Berhasil Diapprov Penerima!','success'
            )
            $('.modal').modal('hide');
            tableDetail.ajax.reload();
          } else if(_response.indctr == '0'){
            console.log(_response)
            swal('Terjadi kesalahan',  _response.msg , 'info'
            )
          }
          else if(_response.indctr == '2'){
            console.log(_response)
           swal('Tanggal approval tidak sesuai', 'Mohon dicek kembali!', 'info')
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
}
</script>

@endsection