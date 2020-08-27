@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Safety Performance
        <small></small>
      </h1>
      <ol class="breadcrumb">
          <li>
            <a href="{{ url('/home') }}">
              <i class="fa fa-dashboard"></i> Home</a>
          </li>
          <li>
            <i class="glyphicon glyphicon-info-sign"></i> Safety Performance 
          </li>
          <li class="active">
            <i class="fa fa-files-o"></i> Accident
          </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')

    <div class="collapse" id="showform">
       <div class="row" id="safety_performance">
          <div class="col-md-12">
             <div class="box box-primary">
               <div class="box-header with-border">
                  <h3 class="box-title" > Accident </h3>
                    <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                          </button>
                    </div>
              </div>
              <!-- /.box-header -->
              
              <!-- form start -->
            <div class="box-body">
              <div class="form-group">
                {!! Form::open(['url' => route('ehsspaccidents.store_sp_accident'), 'method' => 'post', 'class'=>'form-horizontal', 'id'=>'form_accident']) !!}

                <div class="form-group{{ $errors->has('no_accident') ? ' has-error' : '' }}">
                  {!! Form::label('no_accident', 'No. Accident', ['class'=>'col-md-2 control-label']) !!}
                  <div class="col-md-4">
                  {!! Form::text('no_accident', $noid, ['class'=>'form-control', 'readonly'=>'true']) !!}
                  {!! $errors->first('no_accident', '<p class="help-block">:message</p>') !!}
                  </div>
                </div>  

                <div class="form-group{{ $errors->has('tgl_accident') ? ' has-error' : '' }}">
                  {!! Form::label('tgl_accident', 'Tanggal Accident', ['class'=>'col-md-2 control-label']) !!}
                  <div class="col-md-4">
                  {!! Form::date('tgl_accident', \Carbon\Carbon::now(), ['class'=>'form-control']) !!}
                  {!! $errors->first('tgl_accident', '<p class="help-block">:message</p>') !!}
                  </div>
                </div>   

                <div class="form-group{{ $errors->has('pt') ? ' has-error' : '' }}">
                    {!! Form::label('pt', 'PT', ['class'=>'col-md-2 control-label']) !!}
                   <div class="col-sm-4">   
                     <select size="1" name="pt"   class="form-control">
                      <option value="IGP">IGP</option>
                      <option value="GKD">GKD</option>
                      <option value="AGI">AGI</option>
                     </select>
                    {!! $errors->first('pt', '<p class="help-block">:message</p>') !!}
                  </div>   
                </div>    

               <div class="form-group{{ $errors->has('plant') ? ' has-error' : '' }}">
                {!! Form::label('plant', 'Plant', ['class'=>'col-md-2 control-label']) !!}
                <div class="col-sm-4">   
                    <select size="1" name="plant"  class="form-control" >
                    <option value="Jakarta">Jakarta</option>
                    <option value="Karawang">Karawang</option>
                    </select>
                  </div>   
               </div>   

              <div class="form-group has-feedback{{ $errors->has('kecelakaan') ? ' has-error' : '' }}">
                {!! Form::label('kecelakaan', 'Kecelakaan', ['class'=>'col-md-2 control-label']) !!}
                  <div class="col-md-4">
                  {!! Form::textarea('kecelakaan', null, ['class'=>'form-control col-md-2', 'placeholder' => 'Kecelakaan', 'rows' => '3',  'style' => 'resize:vertical', 'id'=>'kecelakaan']) !!}
                  {!! $errors->first('kecelakaan', '<p class="help-block">:message</p>') !!}
                  </div>
              </div>

              <div class="form-group{{ $errors->has('rank') ? ' has-error' : '' }}">
              {!! Form::label('rank', 'Rank', ['class'=>'col-md-2 control-label']) !!}
                  <div class="col-sm-4">   
                    <select size="1" name="rank" class="form-control" >
                    <option value="Rank A">Rank A</option>
                    <option value="Rank B">Rank B</option>
                    <option value="Rank C">Rank C</option>
                    </select>
                  </div>   
              </div> 

              <div class="form-group has-feedback{{ $errors->has('kronologi') ? ' has-error' : '' }}">
              {!! Form::label('kronologi', 'Kronologi', ['class'=>'col-md-2 control-label']) !!}
                <div class="col-md-4">
                {!! Form::textarea('kronologi', null, ['class'=>'form-control col-md-2', 'placeholder' => 'Kronologi Kejadian', 'rows' => '3',  'style' => 'resize:vertical', 'id'=>'kronologi', 'maxlength' => 150,]) !!}
                {!! $errors->first('kronologi', '<p class="help-block">:message</p>') !!}
               </div>
              </div>
      
          <div class="box-footer">
            <div class="form-group">
              <div class="col-md-4 col-md-offset-2"> 
                  <button style="align:right;"  type="submit" class="btn btn-primary" id="btn-submit"> <i class="fa fa-btn fa-paper-plane"> </i> Submit</button>
                    </div>
                  </div>
                </div>     
              {!! Form::close() !!}
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
               <h3 class="box-title">Daftar Accident </h3>  
                <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
                </button>
                </div>
            </div>
            <div class="box-header">
              <div class="col-sm-2">
                 <a class="form-control btn btn-primary" id="inputaccident" >
                 <span class="fa fa-plus"></span> Add Accident </a>
              </div>
            </div>

            <div class="box-body">
              <div class="form-group">

                <div class="col-sm-2">
                {!! Form::label('filter_tahun', 'Tahun') !!}
                <select id="filter_tahun" name="filter_tahun" aria-controls="filter_status" class="form-control select2">
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
              {!! Form::label('lblusername2', 'Action') !!}
              <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
              </div>

              <br><br><br><br>

              <table id="table_accident" class="table table-bordered table-striped" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th style='width: 1%;'>No</th>
                          <th style='width: 7%;'>No. Kejadian</th>
                          <th style='width: 7%;'>Tgl Kejadian</th>
                          <th style='width: 7%;'>PT</th>
                          <th style='width: 10%;'>Plant</th>  
                          <th style='width: 10%;'>Rank</th>                
                          <th style='width: 10%;'>Kecelakaan</th>
                          <th style='width: 7%;'>Kronologi</th>
                        </tr>
                      </thead>
              </table>       
            </div>
          </div>
        </div>
    </section>
  </div>

@endsection

@section('scripts')
<script type="text/javascript" >



var tableDetail = $('#table_accident').DataTable({
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
    
      ajax: "{{ route('ehsspaccidents.dashboard_sp_accident') }}",
      columns: [
        {data: null, name: null, orderable: false, searchable: false},
        {data: 'no_accident', name: 'no_accident'},
        {data: 'tglkejadian', name: 'tglkejadian'},
        {data: 'pt', name: 'pt'},
        {data: 'plant', name: 'plant'},
        {data: 'rank', name: 'rank'},
        {data: 'kecelakaan', name: 'kecelakaan'},
        {data: 'kronologi', name: 'kronologi', className: "none", orderable: false},
     /*   {data: 'action', name: 'status'},*/
    
      ]
    });


$(function() {
      $('\
       <div class="dataTables_length" >\
        <table>\
       <tr>\
       <th style="width: 25%;"><label  style="margin-left:10px;"><b>PT</b></label></th>\
       <th style="width: 25%;"><label  style="margin-left:10px;"><b>Plant</b></label></th>\
       <th style="width: 25%;"><label  style="margin-left:10px;"><b>Rank</b></label></th>\
       <th></th>\
       </tr>\
       <tr>\
       <td>\
         <div id="filter" style="margin-left:10px;">\
          <select style="margin-bottom: 8px;width:100%;" size="1" name="pt" aria-controls="filter_pt" id="filter_pt"    class="form-control">\
              <option value="" selected="selected">ALL</option>\
              <option value="IGP">IGP</option>\
              <option value="GKD">GKD</option>\
              <option value="AGI">AGI</option>\
            </select>\
         </div> \
        </td>\
       <td>\
         <div id="filter"  style="margin-left:10px;">\
          <select style="margin-bottom: 8px;width:100%;" size="1" name="plant" aria-controls="filter_plant" id="filter_plant"    class="form-control" >\
              <option value="" selected="selected">ALL</option>\
              <option value="Jakarta">Jakarta</option>\
              <option value="Karawang">Karawang</option>\
            </select>\
         </div> \
        </td>\
        <td>\
         <div id="filter"  style="margin-left:10px;">\
          <select style="margin-bottom: 8px;width:100%;" size="1" name="rank" aria-controls="filter_rank" id="filter_rank"    class="form-control" >\
              <option value="" selected="selected">ALL</option>\
              <option value="Rank A">Rank A</option>\
              <option value="Rank B">Rank B</option>\
              <option value="Rank C">Rank C</option>\
            </select>\
         </div> \
        </td>\
        <td style="width:3%"></td>\
        <td >  <button class="btn btn-success" style="margin-bottom: 8px;" onclick="refresh()"><i class="fa fa-btn fa-refresh"> </i></button></td>\
        </tr>\
</table>\
<br>\
</div>\
      ').insertBefore('.dataTables_length');

  $("#table_accident").on('preXhr.dt', function(e, settings, data) {
        data.filter_tahun = $('select[name="filter_tahun"]').val();
        data.filter_bulan = $('select[name="filter_bulan"]').val();
  });
  $('#filter_pt').on('change', function(){
        tableDetail.column(3).search(this.value).draw();   
  });
  $('#filter_plant').on('change', function(){
        tableDetail.column(4).search(this.value).draw();   
  });
  $('#filter_rank').on('change', function(){
        tableDetail.column(5).search(this.value).draw();   
  });
});

 $('#display').click( function () {
      tableDetail.ajax.reload();
    });

$('#form_accident').submit(function (e, params) {
    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();
    var kecelakaan = document.getElementById("kecelakaan").value;
    var kronologi = document.getElementById("kronologi").value;
      if (kecelakaan === "" || kronologi === "" && (kecelakaan ==="" || kronologi === "")) {
      var info = "Perhatikan inputan anda!";
      swal(info, "Data tidak boleh kosong, mohon untuk diisi", "info");
      }
      else{
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
           //$(e.currentTarget).trigger(e.type, { 'send': true });
           $.ajax({
        url: "{{route('ehsspaccidents.store_sp_accident')}}",
        type: 'POST',
        data: $('#form_accident').serialize(),
        dataType: 'json',
        success: function( _response ){
         if(_response.indctr == '1'){
          swal(
            'Sukses',
            'Accident Berhasil Ditambahkan!',
            'success'
            )
          var urlRedirect = "{{route('ehsspaccidents.index_sp_accident')}}";    
          window.location.href = urlRedirect;
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

  
 function refresh(){
    tableDetail.ajax.reload();
  }

$("#inputaccident").click(function(){  
        $("#showform").collapse();
        $("#inputaccident").hide();
});
      
</script>


@endsection