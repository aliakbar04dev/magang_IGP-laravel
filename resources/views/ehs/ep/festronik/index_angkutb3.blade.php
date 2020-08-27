@extends('layouts.app')
@section('content')
<style>
  table{
    counter-reset:  (rowNumber);
  }
  table tr:not(:first-child) {
    counter-increment:  rowNumber;
  }
  table.autonumber tr.autonumber td:first-child::before{
    content:counter(rowNumber);
  }
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pengangkutan Limbah B3
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
            <i class="fa fa-files-o"></i> Pengangkutan Limbah B3
          </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')

      



       <div class="row" id="field_detail">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border" >
               <h3 class="box-title"><b>Pengangkutan Limbah B3
  </b></h3>        
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">


             <div class="form-group">
            {!! Form::open(['url' => route('ehsspaccidents.store_angkutlimb3'), 'method' => 'post', 'class'=>'form-horizontal', 'id'=>'form_angkutlimb3']) !!}

<!--             <div class="form-group{{ $errors->has('no_angkut') ? ' has-error' : '' }}">
              {!! Form::label('no_angkut', 'No.Pengangkutan', ['class'=>'col-md-2 control-label']) !!}
                <div class="col-md-4">
                   <input style="width:150px;"  type="text" readonly="yes"  class="form-control col-md-2"   name="noangkut" id="noangkut" value="{{$noid}}"/> 
                </div>          
            </div>    -->

            <div class="form-group{{ $errors->has('tgl_monitoring') ? ' has-error' : '' }}">
              {!! Form::label('tgl_angkut', 'Tanggal Pengangkutan', ['class'=>'col-md-2 control-label']) !!}
                <div class="col-md-4">
                  {!! Form::date('tgl_angkut', \Carbon\Carbon::now(), ['class'=>'form-control', 'style'=>'width:150px;']) !!}
                  {!! $errors->first('tgl_angkut', '<p class="help-block">:message</p>') !!}
                </div>
            </div>   
         
        <div class="row">     
           <div class="col-md-12">
             <table class="autonumber table table-hover" id="dinamis" style="width:90%;">
                   <tr align="center">
                      <th align="center" style="width: 3%"> <center> No </center></th>
                      <th style="width: 40%"> <center> Jenis Limbah </center></th>
                      <th style="width: 10%"> <center> PT</center></th>
                      <th style="width: 10%"> <center> Qty (ton)</center></th>
                      <th style="width: 10%"> <!-- <center> Rata-Rata {{\Carbon\Carbon::now()->subYear(1)->format('Y')}}</center> --></th>
                      <th style="width: 10%"> <!-- <center> Rata-Rata {{\Carbon\Carbon::now()->format('Y')}} </center> --></th>
                      <th><button type="button" id="add" class="btn btn-blue add-row glyphicon glyphicon-plus"></button><input type="hidden" id="listcount" name="listcount" value="0"></th> 
                  </tr>
                  <tr class="autonumber" id="row1">
                      <td width="5px"></td>
                      <td> 
                        <select size="1" name="limbah[0]"  id="limbah1" onchange="refreshList()"   class="form-control">
                          <option value="" disabled selected>-Pilihan-</option>  

                          @foreach($jenislimbah as $row)  
                            <option value="{{$row->kd_limbah}}" name="{{$row->kd_limbah}}" id="{{$row->kd_limbah}}"> {{$row->jenislimbah}} </option> 
                          @endforeach  
                       
                       </select>
                      </td> 
                      <td>
                        <select size="1" name="pt[0]" style="width:150px; float:center;"  id="pt1"  class="form-control" >
                      <option value="IGPJ">IGP-Jakarta</option>
                      <option value="IGPK">IGP-Karawang</option>
                      <option value="GKDJ">GKD-Jakarta</option>
                      <option value="GKDK">GKD-Karawang</option>
                      <option value="AGIJ">AGI-Jakarta</option>
                      <option value="AGIK">AGI-Karawang</option>
                    </select>
                      </td> 
                      <td align="center">
                          <div class="form-group">
                            <div class="col-md-4">
                               <input style="width:100px; float:center;" align="center" type="number"  class="form-control col-md-2"   name="qty[0]" id="qty1" step="0.001" min="0"/> 
                               <text style="color:red;" id="ketsatuan1"></text>
                            </div>
                          </div>
                      </td>

                      <td align="center">
                          <div class="form-group">
                            <div class="col-md-4">
                                <!-- <input type="number" align="center" readonly="true" class="form-control col-md-2"  name="tahunlalu[0]"  id="tahunlalu1" style="width:100px;" /> -->
                            </div>
                          </div>
                      </td>
                       <td align="center">
                          <div class="form-group">
                            <div class="col-md-4">
                               <!--  <input type="number" align="center" readonly="true" class="form-control col-md-2"  name="tahunini[0]"  id="tahunini1" style="width:100px;" /> -->
                            </div>
                          </div>
                      </td>
                      <td>
                          <button type="button" class="btn btn-danger delete-row icon-trash glyphicon glyphicon-trash"></button>
                      </td>
                  </tr>
          </table>

          <div class="modal-footer">
             <button type="submit" class="btn btn-primary" id="tombolsumbit" title="Submit"> <i class="fa fa-btn fa-paper-plane"> </i> Submit</button>
            {{--  {!! Form::submit('Submit', ['class'=>'btn btn-primary glyphicon glyphicon-floppy-disk', 'id' => 'btn-save']) !!}  --}}
          </div>
      </div>

     
        </div>
          {!! Form::close() !!}
</div>
      </div>
    </div>
    </div>
      </div>



      <div class="row" id="field_detail">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
               <h3 class="box-title"><b>Daftar Pengangkutan Limbah</b></h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

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
                    {!! Form::label('action', 'Action') !!}
                    <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
              </div>
            <br><br>
            <br><br>
             <div class="dataTables_length" >   
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
         
        <div class="col-sm-2">
          {!! Form::label('refresh', ' ') !!}
          <br>
        <!--  <button class="btn btn-success" style="margin-bottom: 8px;" onclick="refresh()"><i class="fa fa-btn fa-refresh"> </i></button> -->
         </div>    
<br><br>
<br>
</div>
      


             <div class="form-group" style="margin-top:20px">
  <div class="col-sm-2"> </div>
       <table  id="table_angkutb3" class="table table-bordered table-striped" cellspacing="0" width="100%" >
                <thead>
                  <tr>
                    <th style='width: 1%; text-align: center;' >No</th>
                    <th style='width: 5%;'>Tanggal</th>
                    <th style='width: 10%;' >Jenis Limbah</th>
                    <th style='width: 3%;'>PT</th>
                    <th style='width: 3%;'>Qty</th>
                    <th style='width: 4%;'> <center>Status Festronik</center></th>  
                     <th style='width: 1%; text-align: center;' >Action</th>         
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
    
      ajax: "{{ route('ehsspaccidents.dashboard_angkutlimb3') }}",
      columns: [
        {data: null, name: null, orderable: false, searchable: false},
        {data: 'tgl_angkut', name: 'tgl_angkut'},
        {data: 'jenislimbah', name: 'master_limbah.jenislimbah'},
        {data: 'pt', name: 'pt'},
        {data: 'qty', name: 'qty'},
        {data: 'status', name: 'status', orderable: false},
        {data: 'action', name: 'action', orderable: false, searchable: false},
      ]
    });
  $('#filter_limbah').on('change', function(){
        tableDetail.column(2).search(this.value).draw();   
    });
  $('#filter_pt').on('change', function(){
        tableDetail.column(3).search(this.value).draw();   
    });
  $('#filter_status').on('change', function(){ 
     tableDetail.column(5).search(this.value).draw();   
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
 

 $('#form_angkutlimb3').submit(function (e, params) {

    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault(); 
      for (countLoop = 1; countLoop < i; countLoop++) { 
      var qty = document.getElementById("qty"+(countLoop)).value;
      var limbah = document.getElementById("limbah"+(countLoop)).value; }
      if (qty === "" || limbah === "" && (qty === "" || limbah === "")) {
      var info = "Perhatikan inputan anda!";
      swal(info, "Data tidak boleh kosong, mohon untuk diisi!", "info");
      } else {
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
        url: "{{ route('ehsspaccidents.store_angkutlimb3') }}",
        type: 'POST',
        data: $('#form_angkutlimb3').serialize(),
        dataType: 'json',
        success: function( _response ){
           if(_response.indctr == '1'){
              console.log(_response)
              swal(
              'Sukses',
              'Pengangkutan Limbah Berhasil Ditambahkan!',
              'success'
              )
             var urlRedirect = "{{route('ehsspaccidents.index_angkutlimb3')}}";    
             window.location.href = urlRedirect;
            }else if (_response.indctr == '0') {
            console.log(_response)
            swal('Terjadi kesalahan saat menyimpan', 'Mohon hubungi Admin!', 'info'
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

 function hapus_angkut(id,id2, id3)
   {
      var msg = 'Yakin hapus data?';
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
          var urlRedirect = "{{route('ehsspaccidents.delete_angkutlimb3', ['param', 'param2', 'param3'])}}";    
          urlRedirect = urlRedirect.replace('param', id);
          urlRedirect = urlRedirect.replace('param2', id2);
          urlRedirect = urlRedirect.replace('param3', id3);
        $.ajax({
          url      : urlRedirect,
          type     : 'GET',
          dataType : 'json',
          success: function(_response){
         if(_response.indctr == '1'){
            swal('Sukses', 'Data Berhasil Dihapus!','success'
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


</script>

<script>

  var i = 2;
  var actual_id = i;
    $(document).ready(function(){        
        $('#dinamis .add-row').click(function () {   
         /*  $('#dinamis tr').ready(function(){  
             $("select").change(function() {   
             $("select").not(this).find("option[value="+ $(this).val() + "]").hide();
             });
          });*/
          reAssignID(); 
          var template = '<tr class="autonumber" id="row'+actual_id+'"><td width="5px"></td><td><select size="1" name="limbah[]"  id="limbah'+actual_id+'" onchange="refreshList()" class="form-control"> <option value="" disabled selected>-Pilihan-</option>   @foreach($jenislimbah as $row) <option value="{{$row->kd_limbah}}" name="{{$row->kd_limbah}}" id="{{$row->kd_limbah}}"> {{$row->jenislimbah}} </option> @endforeach </select></td><td> <select class="form-control" size="1" name="pt[]" style="width:150px; float:center;" id="pt'+actual_id+'" class="form-control" >  <option value="IGPJ">IGP-Jakarta</option><option value="IGPK">IGP-Karawang</option> <option value="GKDJ">GKD-Jakarta</option><option value="GKDK">GKD-Karawang</option><option value="AGIJ">AGI-Jakarta</option> <option value="AGIK">AGI-Karawang</option> </select> </select></td><td align="center"><div class="form-group"><div class="col-md-4"> <input style="width:100px; float:center;" align="center" type="number"  class="form-control col-md-2"  name="qty[]" id="qty'+actual_id+'" step="0.001" min="0"/> <text style="color:red;" id="ketsatuan'+actual_id+'"></text></div></div></td><td align="center"><div class="form-group"><div class="col-md-4"></div></div></td><td align="center"><div class="form-group"><div class="col-md-4"> </div></div></td><td><button type="button" class="btn btn-danger delete-row icon-trash glyphicon glyphicon-trash"></button></td></tr>';
            $('#dinamis').append(template);
                i++
                refreshList();
            });
                    
            $('#dinamis').on('click', '.delete-row', function () {
                $(this).parent().parent().remove();
                i--;
                refreshList();
             });
      })                 
</script>

<script>

function reAssignID(){
  c = i;
    do {
      var rowElement = document.getElementById("row"+c);
      if(typeof(rowElement) != 'undefined' && rowElement != null){
          } else {
            actual_id = c;
            break;
          }
          c--;
          }  
      while (c > 0)
}




function refreshList(){



    $("select").find("option").show();
     $("select").find("option").show();
        for (countLoop = 0; countLoop < i; countLoop++) {
        var selectElement = document.getElementById("limbah"+(countLoop));
        if(typeof(selectElement) != 'undefined' && selectElement != null){
          } else {
            continue;
          }
        var selectedHiddenInput = document.getElementById('limbah'+(countLoop)).value;
        if (selectedHiddenInput != ""){
        $("select").find("option[value=" + selectedHiddenInput + "]").hide();
        $("select").find("option[value=" + selectedHiddenInput + "]").removeAttr('disabled');
        $('#limbah'+(countLoop)).find("option[value=" + selectedHiddenInput + "]").show();
        }
        }
  }


   function validateNilai() {

   }

</script>



@endsection