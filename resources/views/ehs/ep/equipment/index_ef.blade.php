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
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
       <div class="row" id="field_detail">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
               <h3 class="box-title"><b>Monitoring Equipment & Facility</b></h3>
             
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
              <div class="box-header">
                 <p> <a class="btn btn-primary" id="create_mef" href="{{ route('ehsenv.create_ef') }}" >
                    <span class="fa fa-plus"></span> Add Data </a>
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

             <div class="col-sm-2">
                     {!! Form::label('Action', 'Action') !!}
                    <button id="display_mef" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
                </p>
             </div>
          
            <div class="box-body">
              <div class="form-group" style="margin-top:70px;">
                 <table id="table_equipfacility" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead  valign="center">
                  <tr>
                    <th style='width: 1%; text-align: center;' rowspan="2" valign="center" >No</th>
                    <th style='width: 3%;' rowspan="2">No MEF</th>
                    <th style='width: 3%;' rowspan="2">Tanggal</th>
                    <th style='width: 3%;' rowspan="2">Lokasi</th>
                    <th style='width: 30%;' colspan="5"> <center>Status</center></th>
                     <th style='width: 1%;' rowspan="2">Action</th>                     
                  </tr>
                  <tr>
                    <th>Valve</th>
                    <th>Pompa</th>
                    <th>Radar</th>
                    <th>Bak</th>
                    <th>Saluran Pit</th>
                  </tr>
                </thead>
              </table> 
</div>
            </div>
          </div>
        </div>
      </div>


    </section>
</div>

@endsection

@section('scripts')
<script type="text/javascript" >

 

var tableDetail = $('#table_equipfacility').DataTable({
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
    
      ajax: "{{ route('ehsenv.dashboard_ef') }}",
      columns: [
        {data: null, name: null, orderable: false, searchable: false},
        {data: 'no_mef', name: 'no_mef'},
        {data: 'tgl_mon', name: 'tgl_mon'},
        {data: 'kd_ot', name: 'kd_ot'},
        {data: 'status_valve', name: 'status_valve'},
        {data: 'status_pompa', name: 'status_pompa'},
        {data: 'status_radar', name: 'status_radar'},
        {data: 'status_bak', name: 'status_bak'},
        {data: 'status_spit', name: 'status_spit'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
     /*   {data: 'action', name: 'status'},*/
      ]
    });

   $("#table_equipfacility").on('preXhr.dt', function(e, settings, data) {
        data.filter_tahun = $('select[name="filter_tahun"]').val();
        data.filter_bulan = $('select[name="filter_bulan"]').val();
      });

   $('#display_mef').click( function () {
      tableDetail.ajax.reload();
      });

 

function refresh(){
  tableDetail.ajax.reload();
}



 
 function hapus_mef(id)
   {
      var msg = 'Yakin hapus data Monitoring Equipment Facility '+id+'?';
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
          var urlRedirect = "{{route('ehsenv.delete_ef', 'param')}}";    
          urlRedirect = urlRedirect.replace('param', id);
        $.ajax({
          url      : urlRedirect,
          type     : 'GET',
          dataType : 'json',
          success: function(_response){
         if(_response.indctr == '1'){
            swal('Sukses', 'MEF Dengan Kode '+id+' Berhasil Dihapus!','success').then(function(){
             tableDetail.ajax.reload();
          })
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



      
</script>


@endsection