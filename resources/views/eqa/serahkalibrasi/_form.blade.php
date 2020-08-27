<div class="box-body ">
  <div class="col-md-6">    
   <div class="form-group">          
    <div class="col-md-6{{ $errors->has('no_srhalat') ? ' has-error' : '' }}">
     {!! Form::label('no_srhalat', 'No Pengambilan') !!}      
     {!! Form::text('no_srhalat', null, ['class'=>'form-control','required', 'readonly' => '']) !!}
     {!! Form::hidden('jml_tbl_detail', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_tbl_detail']) !!}
     {!! $errors->first('no_srhalat', '<p class="help-block">:message</p>') !!}
   </div>
   <div class="col-md-6{{ $errors->has('tgl_serah') ? ' has-error' : '' }}">
     {!! Form::label('tgl_serah', 'Tanggal Pengambilan') !!}
     @if (empty($tsrhalat1->tgl_order))
     {!! Form::date('tgl_serah', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => \Carbon\Carbon::now()]) !!}
     @else
     {!! Form::date('tgl_serah', \Carbon\Carbon::parse($tsrhalat1->tgl_serah), ['class'=>'form-control']) !!}
     @endif
     {!! $errors->first('tgl_serah', '<p class="help-block">:message</p>') !!}
   </div>
 </div>
 <div class="form-group"> 
   <div class="col-md-6">
     {!! Form::label('kd_plant', 'Plant (*)') !!}
     <div class="input-group">
      @if (empty($tsrhalat1->kd_plant))
        <select id="kd_plant" name="kd_plant" class="form-control select2">         
         @foreach($plants->get() as $kode)
         <option value="{{$kode->kd_plant}}">{{$kode->nm_plant}}</option>      
       @endforeach
         </select>
       @else
       {!! Form::select('kd_plant', array('1' => 'IGP-1', '2' => 'IGP-2', '3' => 'IGP-3', '4' => 'IGP-4', 'A' => 'KIM-1A', 'B' => 'KIM-1B'), null, ['class'=>'form-control', 'disabled'=>'true']) !!}     
       {!! Form::hidden('kd_plant', null, ['class'=>'form-control','required', 'readonly' => '']) !!}
       @endif 
    </div>
  </div>
  <div class="col-md-6{{ $errors->has('no_wdo') ? ' has-error' : '' }}">
   {!! Form::label('no_wdo', 'No Order (F9) (*)') !!} 
   <div class="input-group">     
     {!! Form::text('no_wdo', null, ['class'=>'form-control','placeholder' => 'No Order','onkeydown' => 'btnpopupNoOrderClick(event)', 'onchange' => 'validateNoOrder()','required']) !!}
     <span class="input-group-btn">
      <button id="btnpopupNoOrder" type="button" class="btn btn-info" data-toggle="modal" data-target="#noorderModal">
        <label class="glyphicon glyphicon-search"></label>
      </button>
    </span>
  </div>
  {!! $errors->first('no_wdo', '<p class="help-block">:message</p>') !!}
</div>
</div>  
<!-- /.form-group -->
<div class="form-group">
  <div class="col-md-4">
   <p class="help-block">(*) tidak boleh kosong</p>
 </div>
</div>
</div>  
<div class="col-md-6">  
  <div class="form-group">
    <center>
      <p>
        {!! Html::image(asset('images/no_image.png'), 'File Not Found', ['id'=>'imgAlatUkur', 'name'=>'imgAlatUkur', 'width'=>'300px', 'height'=>'150px']) !!}        
      </p>
    </center>
  </div>
</div>
<!-- /.box-body -->
<div class="box-body">
  <div class="row">
   <div class="col-md-12">
    <div class="box box-primary">
     <div class="box-header with-border">
      <h3 class="box-title">Detail</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">            
      @include('datatable._action-addrem')
      <table id="tblDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
       <thead>
        <tr>
         <th style="width: 2%;">No</th>
         <th style="width: 16%;">No Seri<font color='red'>&nbsp;(F9)(*)</font></th>
         <th style="width: 20%;">Nama Alat Ukur</th>
         <th style="width: 7%;">Kode Barang</th> 
         <th style="width: 20%;">Nama Barang</th>
         <th style="width: 7%;">Keterangan</th>
       </tr>
     </thead>
     <tbody>
      @if (!empty($tsrhalat1->no_srhalat)) 
        @foreach ($model->tsrhalat1Det($tsrhalat1->no_srhalat)->get() as $tsrhalat2)
        <tr>
         <td>{{ $loop->iteration }}</td>
         <td><input type='hidden' value="row-{{ $loop->iteration }}-no_seri"><input type='text' id="row-{{ $loop->iteration }}-no_seri" name="row-{{ $loop->iteration }}-no_seri" value='{{ $tsrhalat2->no_seri }}' size='16' maxlength='100' onkeydown='popupNoseri(event)' onchange='validateNoseri(event)' required><input type='hidden' id="row-{{ $loop->iteration }}-id" name="row-{{ $loop->iteration }}-id" value='0' readonly='readonly'></td>
         <td><textarea id="row-{{ $loop->iteration }}-nm_alatukur" name="row-{{ $loop->iteration }}-nm_alatukur" rows='2' cols='30' disabled='' style='text-transform:uppercase;resize:vertical'>{{ $model->getNoSeri($tsrhalat2->no_seri, $tsrhalat1->kd_plant) }}</textarea></td>
         <td><input type='text' id="row-{{ $loop->iteration }}-kd_brg" name="row-{{ $loop->iteration }}-kd_brg" value='{{ $tsrhalat2->kd_brg }}' size='8' maxlength='8' readonly='readonly'></td>
         <td><textarea id="row-{{ $loop->iteration }}-nm_brg" name="row-{{ $loop->iteration }}-nm_brg" rows='2' cols='30' disabled='' style='text-transform:uppercase;resize:vertical'>{{ $model->getNmBrg($tsrhalat2->kd_brg) }}</textarea></td>
         <td><input type='text' id="row-{{ $loop->iteration }}-ket" name="row-{{ $loop->iteration }}-ket" value='{{ $tsrhalat2->ket }}' size='30' maxlength='30'><input type='hidden' id="row-{{ $loop->iteration }}-lok_pict" name="row-{{ $loop->iteration }}-lok_pict" value='{{ $model->getImage($tsrhalat2->no_seri) }}' size='30' maxlength='30'></td>       
       </tr>
       @endforeach
     @endif              
   </tbody>
 </table>
</div>
<!-- /.box-body -->
</div>
<!-- /.box -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->
</div>
<!-- /.box-body -->   
</div>
<!-- /.box-body -->
<div class="box-footer">
  {!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  &nbsp;&nbsp;
  @if (empty($tsrhalat1->no_srhalat))
  <button id="btn-delete" type="button" class="btn btn-danger">Delete</button> 
  @endif
  &nbsp;&nbsp;
  <a class="btn btn-default" href="{{ route('serahkalibrasi.index') }}">Cancel</a>
</div>

<!-- Popup NoSeri Modal -->
@include('eqa.serahkalibrasi.popup.noseriModal')
<!-- Popup NoOrder Modal -->
@include('eqa.serahkalibrasi.popup.noorderModal')

@section('scripts')
<script type="text/javascript">

  document.getElementById("no_srhalat").focus();

  function btnpopupNoOrderClick(e) {
    if(e.keyCode == 120) {
      $('#btnpopupNoOrder').click();
    }
  }  

  function autoUpperCase(a){
    a.value = a.value.toUpperCase();
  }   
  //Initialize Select2 Elements
  $(".select2").select2();

  $(document).ready(function(){
    $("#btnpopupNoOrder").click(function(){
      popupNoOrder();
    });
    //MEMBUAT TABEL DETAIL
    var table = $('#tblDetail').DataTable({
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
      //responsive: true,
      'searching': false,
      "scrollX": "true",
      "scrollY": "500px",
      "scrollCollapse": true,
      "paging": false
    });
   document.getElementById("removeRow").disabled = true;

   var counter = table.rows().count();
   document.getElementById("jml_tbl_detail").value = counter;   

   $('#tblDetail tbody').on( 'click', 'tr', function () {
     if ( $(this).hasClass('selected') ) {
      $(this).removeClass('selected');
      document.getElementById("removeRow").disabled = true;      
    } else {
      table.$('tr.selected').removeClass('selected');
      $(this).addClass('selected');
      document.getElementById("removeRow").disabled = false;
      //untuk memunculkan gambar
      var row = table.row('.selected').index();
      changeImage(row);      
    }
  });

   $("#btn-delete").click(function(){
    var no_srhalat = document.getElementById("no_srhalat").value;
    if(no_srhalat !== "") {
      var msg = 'Anda yakin menghapus data ini?';
      var txt = 'No Pengambilan: ' + no_srhalat;
      swal({
        title: msg,
        text: txt,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, delete it!',
        cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
        allowOutsideClick: true,
        allowEscapeKey: true,
        allowEnterKey: true,
        reverseButtons: false,
        focusCancel: true,
      }).then(function () {
        var urlRedirect = "{{ route('serahkalibrasi.delete', 'param') }}";
        urlRedirect = urlRedirect.replace('param', window.btoa(no_srhalat));
        window.location.href = urlRedirect;
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
  });

   $('#addRow').on( 'click', function () {
     counter = table.rows().count();
     counter++;
     document.getElementById("jml_tbl_detail").value = counter;
     var id = 'row-' + counter +'-id';
     var no_seri = 'row-' + counter +'-no_seri';
     var nm_alatukur = 'row-' + counter +'-nm_alatukur';
     var kd_brg = 'row-' + counter +'-kd_brg';
     var nm_brg = 'row-' + counter +'-nm_brg';
     var ket = 'row-' + counter +'-ket';
     var lok_pict = 'row-' + counter +'-lok_pict';
     table.row.add([
      counter,
      "<input type='hidden' value=" + no_seri + "><input type='text' id=" + no_seri + " name=" + no_seri + " size='16' maxlength='100' onkeydown='popupNoseri(event)' onchange='validateNoseri(event)' required><input type='hidden' id=" + id + " name=" + id + " value='0' readonly='readonly'>",
      "<textarea id=" + nm_alatukur + " name=" + nm_alatukur + " rows='2' cols='30' disabled='' style='text-transform:uppercase;resize:vertical'></textarea>",
      "<input type='text' id=" + kd_brg + " name=" + kd_brg + " size='8' maxlength='8' readonly='readonly'>",
      "<textarea id=" + nm_brg + " name=" + nm_brg + " rows='2' cols='30' disabled='' style='text-transform:uppercase;resize:vertical'></textarea>",
      "<input type='text' id=" + ket + " name=" + ket + " size='30' maxlength='30'><input type='hidden' id=" + lok_pict + " name=" + lok_pict + " size='30' maxlength='30'>"      
      ]).draw(false);
   });

   $('#removeRow').click( function () {
     var table = $('#tblDetail').DataTable();
     counter = table.rows().count()-1;
     document.getElementById("jml_tbl_detail").value = counter;
     var index = table.row('.selected').index();
     var row = index;
     if(index == null) {
      swal("Tidak ada data yang dipilih!", "", "warning");
    } else {
        var target = 'row-' + (row+1) + '-';
        var id = document.getElementById(target +'id').value.trim();
        var no_srhalat = document.getElementById("no_srhalat").value;
        var no_wdo = document.getElementById("no_wdo").value;
        var no_seri = document.getElementById(target +'no_seri').value.trim();
        var kd_brg = document.getElementById(target +'kd_brg').value.trim();
        
        
        if(no_srhalat === '') {
          changeId(row);
        } else {
          if(no_seri === '' || kd_brg === '') {
            changeId(row);
          }else{          
            swal({
              title: "Are you sure?",
              text: "No Seri: " + no_seri,
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, delete it!',
              cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
              allowOutsideClick: true,
              allowEscapeKey: true,
              allowEnterKey: true,
              reverseButtons: false,
              focusCancel: true,
            }).then(function () {
      //startcode
      var info = "";
      var info2 = "";
      var info3 = "warning";
      
        //DELETE DI DATABASE
        // remove these events;
        window.onkeydown = null;
        window.onfocus = null;
        var token = document.getElementsByName('_token')[0].value.trim();
        // delete via ajax
        // hapus data detail dengan ajax
        var url = "{{ route('serahkalibrasidet.hapus', ['param', 'param1', 'param2', 'param3'])}}"; 
        url = url.replace('param',  window.btoa(no_srhalat));
        url = url.replace('param1', window.btoa(no_seri));
        url = url.replace('param2', window.btoa(kd_brg));
        url = url.replace('param3',  window.btoa(no_wdo));
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method : 'GET',
            // menambah csrf token dari Laravel
            _token  : token
          },
          success:function(data){
           if(data.status === 'OK'){
            changeId(row);
            info = "Deleted!";
            info2 = data.message;
            info3 = "success";
            swal(info, info2, info3);
          } else {
            info = "Cancelled";
            info2 = data.message;
            info3 = "error";
            swal(info, info2, info3);
          }
        }, error:function(){ 
          info = "System Error!";
          info2 = "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.";
          info3 = "error";
          swal(info, info2, info3);
        }
      });
        //END DELETE DI DATABASE

      //finishcode
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
      }
    });
 });

//POPUP No Order
  function popupNoOrder() {
    var kd_plant = document.getElementById("kd_plant").value.trim();
    var myHeading = "<p>Popup Jenis</p>";
    $("#noorderModalLabel").html(myHeading);

    var url = '{{ route('datatables.popupNoorder', 'param') }}';
    url = url.replace('param', window.btoa(kd_plant));
    var lookupNoorder = $('#lookupNoorder').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      "order": [[0, 'asc']],
          columns: [
          { data: 'no_order', name: 'no_order'},
          { data: 'tgl_order', name: 'tgl_order'}
          ],
          "bDestroy": true,
          "initComplete": function(settings, json) {
            $('div.dataTables_filter input').focus();
            $('#lookupNoorder tbody').on( 'dblclick', 'tr', function () {
              var dataArr = [];
              var rows = $(this);
              var rowData = lookupNoorder.rows(rows).data();
              $.each($(rowData),function(key,value){
                document.getElementById("no_wdo").value = value["no_order"];
                $('#noorderModal').modal('hide');
                validateNoOrder();
              });
            });
            $('#noorderModal').on('hidden.bs.modal', function () {
              var kode = document.getElementById("no_wdo").value.trim();
              if(kode === '') {
                $('#no_wdo').focus();
              }
            });
          },
      });     
  }

    //VALIDASI No Order
    function validateNoOrder() {
      var kode = document.getElementById("no_wdo").value.trim();
      var kd_plant = document.getElementById("kd_plant").value.trim();     
      if(kode !== '') {
        var url = '{{ route('datatables.validasiNoorder', ['param','param1']) }}';
        url = url.replace('param', window.btoa(kd_plant));
        url = url.replace('param1', window.btoa(kode));
          //use ajax to run the check
          $.get(url, function(result){  
            if(result !== 'null'){
              result = JSON.parse(result);
              document.getElementById("no_wdo").value = result["no_order"];
            } else {
              document.getElementById("no_wdo").value = "";
              document.getElementById("no_wdo").focus();
              swal("No Order tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
            }
          });
      } else {
        document.getElementById("no_wdo").value = "";
      }   
  }

//POPUP NOSERI
function popupNoseri(e) {
  if(e.keyCode == 120 || e.keyCode == 13) {
    var no_wdo = document.getElementById("no_wdo").value.trim();
    if(no_wdo === ''){
      swal("No Order Harus Dipilih!", "", "warning");
    }
    else{
      var myHeading = "<p>Popup No Seri</p>";
      $("#noseriModalLabel").html(myHeading);
      var url = '{{ route('datatables.popupNoseriSerah', 'param') }}';
      url = url.replace('param', window.btoa(no_wdo));
      $('#noseriModal').modal('show');
      var lookupNoseri = $('#lookupNoseri').DataTable({
        processing: true, 
        "oLanguage": {
          'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
        }, 
        serverSide: true,
        pagingType: "simple",
        "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
        ajax: url,
        columns: [
        { data: 'no_seri', name: 'no_seri'},
        { data: 'nm_alat', name: 'nm_alat'},
        { data: 'kd_brg', name: 'kd_brg'},
        { data: 'nm_brg', name: 'nm_brg'},
        { data: 'lok_pict', name: 'lok_pict', visible:false}
        ],
        "bDestroy": true,
        "initComplete": function(settings, json) {
         $('div.dataTables_filter input').focus();
         $('#lookupNoseri tbody').on( 'click', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupNoseri.rows(rows).data();
          $.each($(rowData),function(key,value){
           var id = e.target.id.replace('no_seri', '');
           document.getElementById(e.target.id).value = value["no_seri"];
           document.getElementById(id +'nm_alatukur').value = value["nm_alat"];
           document.getElementById(id +'kd_brg').value = value["kd_brg"];
           document.getElementById(id +'nm_brg').value = value["nm_brg"];
           document.getElementById(id +'lok_pict').value = value["lok_pict"];
           //untuk memunculkan gambar
           var row = id.replace('row-', '');
           row = row.replace('-', '');
           row = row-1;
           changeImage(row);
           $('#noseriModal').modal('hide');
           if(validateNoseriDuplicate(e.target.id)) {
            document.getElementById(id +'no_seri').focus();
          } else {
            document.getElementById(e.target.id).value = "";
            document.getElementById(id +'nm_alatukur').value = "";
            document.getElementById(id +'kd_brg').value = "";
            document.getElementById(id +'nm_brg').value = "";
            document.getElementById(id +'lok_pict').value = "";
            document.getElementById(e.target.id).focus();
            swal("No Seri tidak boleh ada yang sama!", "Perhatikan inputan anda!", "warning");
          }
        });
        });
         $('#noseriModal').on('hidden.bs.modal', function () {
          var no_seri = document.getElementById(e.target.id).value.trim();
          if(no_seri === '') {
           document.getElementById(e.target.id).focus();
         } else {
           var id = e.target.id.replace('no_seri', '');
           document.getElementById(id +'no_seri').focus();
         }
       });
       },
     });
    }
  }
}

//VALIDASI NOSERI
function validateNoseri(e){
  var no_wdo = document.getElementById("no_wdo").value.trim();
  if(no_wdo === ''){
    swal("No Order Harus Dipilih!", "", "warning");
  }
  else{
    var id = e.target.id.replace('no_seri', '');    
    var no_seri = document.getElementById(e.target.id).value.trim();
    if(no_seri === '') {
     document.getElementById(e.target.id).value = "";
     document.getElementById(id +'nm_alatukur').value = "";
     document.getElementById(id +'kd_brg').value = "";
     document.getElementById(id +'nm_brg').value = "";
     document.getElementById(id +'lok_pict').value = "";
   }else{
     var url = '{{ route('datatables.validasiNoseriSerah', ['param', 'param1']) }}';
     url = url.replace('param', window.btoa(no_wdo));
     url = url.replace('param1', window.btoa(no_seri));
     $.get(url, function(result){  
      if(result !== 'null'){
       result = JSON.parse(result);
       document.getElementById(id +'nm_alatukur').value = result["nm_alat"];
       document.getElementById(id +'kd_brg').value = result["kd_brg"];
       document.getElementById(id +'nm_brg').value = result["nm_brg"];
       document.getElementById(id +'lok_pict').value = result["lok_pict"];
       //untuk memunculkan gambar
       var row = id.replace('row-', '');
       row = row.replace('-', '');
       row = row-1;
       changeImage(row);
       if(!validateNoseriDuplicate(e.target.id)) {
        document.getElementById(e.target.id).value = "";
        document.getElementById(id +'nm_alatukur').value = "";
        document.getElementById(id +'kd_brg').value = "";
        document.getElementById(id +'nm_brg').value = "";
        document.getElementById(id +'lok_pict').value = "";
        document.getElementById(e.target.id).focus();
        swal("NoSeri dan Proses tidak boleh ada yang sama!", "Perhatikan inputan anda!", "warning");
      }
    } else {
     document.getElementById(e.target.id).value = "";
     document.getElementById(id +'nm_alatukur').value = "";
     document.getElementById(id +'kd_brg').value = "";
     document.getElementById(id +'nm_brg').value = "";
     document.getElementById(id +'lok_pict').value = "";
     document.getElementById(e.target.id).focus();
     swal("NoSeri tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
   }
 });
   }
 }
}

//VALIDASI NOSERI DUPLICATE
function validateNoseriDuplicate(parentId){
  var id = parentId.replace('no_seri', '');
  var no_seri = document.getElementById(parentId).value.trim();

  if(no_seri !== '' ) {
    var table = $('#tblDetail').DataTable();
    var valid = 'T';
    for($i = 0; $i < table.rows().count(); $i++) {
      var data = table.cell($i, 1).data();
      var posisi = data.indexOf("no_seri");
      var target = data.substr(0, posisi);
      target = target.replace('<input type="hidden" value="', '');
      target = target.replace("<input type='hidden' value=", '');
      target = target.replace('<input value="', '');
      target = target.replace("<input value='", '');
      target = target.replace("<input value=", '');
      target = target.replace("<input value=", '');

      var target_no_seri = target +'no_seri';
      if(parentId !== target_no_seri) {
        var no_seri_temp = document.getElementById(target_no_seri).value.trim();
        if(no_seri_temp !== '') {
          if(no_seri_temp === no_seri) {
            valid = 'F';
            $i = table.rows().count();
          }
        }
      }
    }
    if(valid === 'T') {
      return true;
    } else {
      return false;
    }
  } else {
    return true;
  }
}

function changeId(row) {
  var table = $('#tblDetail').DataTable();
  table.row(row).remove().draw(false);
  var jml_row = document.getElementById("jml_tbl_detail").value.trim();
  jml_row = Number(jml_row) + 1;
  nextRow = Number(row) + 1;
  for($i = nextRow; $i <= jml_row; $i++) {
    var id = "#row-" + $i + "-id";
    var id_new = "row-" + ($i-1) + "-id";
    $(id).attr({"id":id_new, "name":id_new});
    var no_seri = "#row-" + $i + "-no_seri";
    var no_seri_new = "row-" + ($i-1) + "-no_seri";
    $(no_seri).attr({"id":no_seri_new, "name":no_seri_new});
    var nm_alatukur = "#row-" + $i + "-nm_alatukur";
    var nm_alatukur_new = "row-" + ($i-1) + "-nm_alatukur";
    $(nm_alatukur).attr({"id":nm_alatukur_new, "name":nm_alatukur_new});
    var kd_brg = "#row-" + $i + "-kd_brg";
    var kd_brg_new = "row-" + ($i-1) + "-kd_brg";
    $(kd_brg).attr({"id":kd_brg_new, "name":kd_brg_new});
    var nm_brg = "#row-" + $i + "-nm_brg";
    var nm_brg_new = "row-" + ($i-1) + "-nm_brg";
    $(nm_brg).attr({"id":nm_brg_new, "name":nm_brg_new});
    var ket = "#row-" + $i + "-ket";
    var ket_new = "row-" + ($i-1) + "-ket";
    $(ket).attr({"id":ket_new, "name":ket_new}); 
    var lok_pict = "#row-" + $i + "-lok_pict";
    var lok_pict_new = "row-" + ($i-1) + "-lok_pict";
    $(lok_pict).attr({"id":lok_pict_new, "name":lok_pict_new});       
  }
  //set ulang no tabel
  for($i = 0; $i < table.rows().count(); $i++) {
    table.cell($i, 0).data($i +1);
  }
  jml_row = jml_row - 1;
  document.getElementById("jml_tbl_detail").value = jml_row;
}

function changeImage(row){
  var index = Number(row) +1;
  var row_lok_pict = "row-" +index + "-lok_pict";
  var lok_pict = document.getElementById(row_lok_pict).value.trim();
  if(lok_pict !== ''){
    var urlImage="{{asset('qcalatukur/param')}}";
    urlImage = urlImage.replace('param', lok_pict);
  }else{
    var urlImage="{{asset('images/no_image.png')}}";
  }
  document.getElementById("imgAlatUkur").src= urlImage;
}
</script>
@endsection