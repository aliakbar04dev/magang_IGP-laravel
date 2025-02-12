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
        Operasional WWT & SPT
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
           <li>
            <i class="glyphicon glyphicon-info-sign"></i> Operasional WWT & SPT
          </li>
          <li class="active">
            <i class="fa fa-files-o"></i> Pemakaian Bahan Kimia
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
               <h3 class="box-title"><b>Form Oprasional Pemakaian Bahan Kimia
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
            {!! Form::open(['url' => route('ehsspaccidents.store_pbhnkimia'), 'method' => 'post', 'class'=>'form-horizontal', 'id'=>'form_bhnkimia']) !!}

            
            <div class="form-group{{ $errors->has('tgl_monitoring') ? ' has-error' : '' }}">
              {!! Form::label('tgl_monitoring', 'Tanggal Monitoring', ['class'=>'col-md-2 control-label']) !!}
                <div class="col-md-4">
                  {!! Form::date('tgl_monitoring', \Carbon\Carbon::now(), ['class'=>'form-control']) !!}
                  {!! $errors->first('tgl_monitoring', '<p class="help-block">:message</p>') !!}
                </div>
            </div>   
         
        <div class="row">     
           <div class="col-md-12">
             <table class="autonumber table table-hover" id="dinamis" style="width:80%;">
                   <tr align="center">
                      <th align="center" style="width: 3%"> <center> No </center></th>
                      <th style="width: 40%"> <center> Chemical </center></th>
                      <th style="width: 17%"> <center> Pemakaian</center></th>
                      <th style="width: 17%"> <center> Total Pemakaian </center></th>
                      <th><button type="button" id="add" class="btn btn-blue add-row glyphicon glyphicon-plus"></button><input type="hidden" id="listcount" name="listcount" value="0"></th> 
                  </tr>
                  <tr class="autonumber" id="row1">
                      <td width="5px"></td>
                      <td> 
                        <select size="1" name="chemical[0]"  id="chemical1" onchange="refreshList()"   class="form-control">
                          <option value="" disabled selected>-Pilihan-</option>  

                          @foreach($jenischemical as $row)
                            <option value="{{$row->kd_mon}}" name="{{$row->kd_mon}}" id="{{$row->kd_mon}}"> {!! $row->jenis_mon !!} </option> 
                          @endforeach  
                       
                       </select>
                      </td>  
                      <td align="center">
                          <div class="form-group">
                            <div class="col-md-4">
                               <input style="width:100px; float:center;" align="center" type="number"  class="form-control col-md-2" onclick="konversi()" onkeyup="konversi()"  name="pemakaian[0]" id="pemakaian1" step="0.01" min="0"/> 
                               <text style="color:red;" id="ketsatuan1"></text>
                            </div>
                          </div>
                      </td>

                      <td align="center">
                          <div class="form-group">
                            <div class="col-md-4">
                                <input type="number" align="center" readonly="true" class="form-control col-md-2"  name="totalpakai[0]"  id="totalpakai1" style="width:100px; float:center;" />
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
               <h3 class="box-title"><b>Monitoring Pemakaian Bahan Kimia
  </b></h3>
             
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">


           <div class="col-sm-2">
              {!! Form::label('tgl_awal', 'Tanggal Awal') !!}
              {!! Form::date('tgl_awal', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Awal', 'id' => 'tgl_awal']) !!}
            </div>

            <div class="col-sm-2">
              {!! Form::label('tgl_akhir', 'Tanggal Akhir') !!}
              {!! Form::date('tgl_akhir', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Akhir', 'id' => 'tgl_akhir']) !!}
            </div>

             <div class="col-sm-2">
                     {!! Form::label('Action', 'Action') !!}
                    <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
                </p>
             </div>

  
          <br>
             <div class="form-group" style="margin-top:50px">
            <div id="filter_status" class="dataTables_length" style="display: inline-block; margin-left:0px;margin-top:8px;margin-bottom:8px">
            <img src="{{ asset('images/red.png') }}" alt="X"> Emergency
            <img src="{{ asset('images/green.png') }}" alt="X"> Normal
          </div>
       <table id="table_pakaikimia" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th style='width: 1%;'>No</th>
                    <th style='width: 7%;'>Tanggal</th>
                    <th style='width: 7%;'>Nama Chemical</th>
                    <th style='width: 10%;'>Pemakaian</th>                  
                    <th style='width: 10%;'>Total Pemakaian (kg)</th>
                    <th style='width: 10%;'>Status</th>   
                    <th style='width: 1%;'>Action</th>      
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

var tableDetail = $('#table_pakaikimia').DataTable({
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
    
      ajax: "{{ route('ehsspaccidents.dashboard_pbhnkimia') }}",
      columns: [
        {data: null, name: null, orderable: false, searchable: false},
        {data: 'tanggal', name: 'tanggal'},
        {data: 'jenis_mon', name: 'jenis_mon'},
        {data: 'pemakaian', name: 'pemakaian'},
        {data: 'total_pakai', name: 'total_pakai'},
        {data: 'status', name: 'totalpakai',  orderable: false, searchable: false},
        {data: 'action', name: 'action',  orderable: false, searchable: false},
      ]
    });
 $("#table_pakaikimia").on('preXhr.dt', function(e, settings, data) {
        data.tgl_awal = $('input[name="tgl_awal"]').val();
        data.tgl_akhir = $('input[name="tgl_akhir"]').val();
      });

   $('#display').click( function () {
      tableDetail.ajax.reload();
      });

  function refresh(){
  tableDetail.ajax.reload();
}
 

  function konversi(){
  for (countLoop = 1; countLoop < i; countLoop++) {     
         var chemical = document.getElementById("chemical"+(countLoop)).value;
           var pemakaian = parseFloat($('#pemakaian'+(countLoop)).val());
           if (chemical === "ML005") {
            satuan = "*Satuan Karung";
              var hasil =  pemakaian * 25;
            $('#totalpakai'+(countLoop)).val(hasil);
           }
            else if (chemical === "ML006") {
              satuan = "*Satuan Liter";
              var hasil =  pemakaian * 17.28 ;
            $('#totalpakai'+(countLoop)).val(hasil);
           }
            else if (chemical === "ML007") {
              satuan = "*Satuan Jerigen";
              var hasil =  pemakaian * 25 ;
            $('#totalpakai'+(countLoop)).val(hasil);
           }
            else if (chemical === "ML008") {
              satuan = "*Satuan Liter";
              var hasil =  pemakaian * 0.0064 ;
            $('#totalpakai'+(countLoop)).val(hasil);
           }  
            else if (chemical === "ML009") {
              satuan = "*Satuan Liter";
              var hasil =  pemakaian * 0.65 ;
            $('#totalpakai'+(countLoop)).val(hasil);
           } 
            else if (chemical === "ML010") {
              satuan = "*Satuan Liter";
              var hasil =  pemakaian * 1 ;
            $('#totalpakai'+(countLoop)).val(hasil);
           } 
            else if (chemical === "ML011") {
              satuan = "*Satuan Jerigen";
              var hasil =  pemakaian * 25 ;
            $('#totalpakai'+(countLoop)).val(hasil);
           } 
           else if (chemical === "") {
              satuan = " ";
           }  
            document.getElementById("ketsatuan"+(countLoop)).innerHTML = satuan;
      }   
}





$(document).ready(function() {
});  


$('#form_bhnkimia').submit(function (e, params) {

    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();
       for (countLoop = 1; countLoop < i; countLoop++) { 
      var chemical = document.getElementById("chemical"+(countLoop)).value;
      var pemakaian = document.getElementById("pemakaian"+(countLoop)).value; }
      if (chemical === "" || pemakaian === "" && (chemical === "" || pemakaian === "")) {
      var info = "Perhatikan inputan anda!";
      swal(info, "Data tidak boleh kosong, mohon untuk diisi!", "info");
      } else {
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
        url: "{{ route('ehsspaccidents.store_pbhnkimia') }}",
        type: 'POST',
        data: $('#form_bhnkimia').serialize(),
        dataType: 'json',
        success: function( _response ){
        if(_response.indctr == '1'){
          swal(
            'Sukses',
            'Pemakaian Bahan Kimia Harian Berhasil Ditambahkan!',
            'success'
            )
          var urlRedirect = "{{route('ehsspaccidents.index_pbhnkimia')}}";    
          window.location.href = urlRedirect;
        }  else if(_response.indctr == '2'){
            console.log(_response)
            swal('Terdapat data yang sama di tanggal yang sama', 'Mohon dicek kembali!', 'info'
            )
        } else if(_response.indctr == '0'){
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


  function hapus_pkimia(id, id2)
   {
      var msg = 'Yakin ingin menghapus data?';
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
          var urlRedirect = "{{route('ehsspaccidents.delete_pbhnkimia', ['param', 'param2'])}}";
          urlRedirect = urlRedirect.replace('param', id);
          urlRedirect = urlRedirect.replace('param2', id2);
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
          var template = 
'<tr class="autonumber" id="row'+actual_id+'"><td ></td><td> <select size="1" name="chemical[]"  id="chemical'+actual_id+'"  onchange="refreshList()" class="form-control" > <option value="" disabled selected>-Pilihan-</option>  @foreach($jenischemical as $row)  <option value="{{$row->kd_mon}}" name="{{$row->kd_mon}}" id="{{$row->kd_mon}}"> {!!$row->jenis_mon!!} </option>  @endforeach </select></td> <td> <div class="form-group"> <div class="col-md-4"> <input type="number" onclick="konversi()" onkeyup="konversi()" class="form-control col-md-2"  name="pemakaian[]" id="pemakaian'+actual_id+'" step="0.01" style="width:100px;"/>  <text style="color:red;" id="ketsatuan'+actual_id+'"></text> </div> </div> </td> <td><div class="form-group"><div class="col-md-4"><input type="number" readonly="true" class="form-control col-md-2"   name="totalpakai[]"  id="totalpakai'+actual_id+'"  style="width:100px;" /></div></div></td><td><button type="button" class="btn btn-danger delete-row icon-trash glyphicon glyphicon-trash"></button></td></tr>'; 
          //    $('#row0').remove();
          if (i!=8) {
            $('#dinamis').append(template);
                i++;
              }
            else{
                $('#add').hide();
            }
                refreshList();
            });
                    
            $('#dinamis').on('click', '.delete-row', function () {
                $(this).parent().parent().remove();
                i--;
                if (i!=8) {
                  $('#add').show();
                }
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

  konversi();

    $("select").find("option").show();
     $("select").find("option").show();
        for (countLoop = 0; countLoop < i; countLoop++) {
        var selectElement = document.getElementById("chemical"+(countLoop));
        if(typeof(selectElement) != 'undefined' && selectElement != null){
          } else {
            continue;
          }
        var selectedHiddenInput = document.getElementById('chemical'+(countLoop)).value;
        if (selectedHiddenInput != ""){
        $("select").find("option[value=" + selectedHiddenInput + "]").hide();
        $("select").find("option[value=" + selectedHiddenInput + "]").removeAttr('disabled');
        $('#chemical'+(countLoop)).find("option[value=" + selectedHiddenInput + "]").show();
        }
        }
  }


</script>



@endsection