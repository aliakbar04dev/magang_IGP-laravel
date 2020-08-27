@extends('layouts.app')
@section('content')
<style>
td {
  padding: 8px 10px;
}
table {
    counter-reset: rowNumber;
}

table tr:not(:first-child) {
    counter-increment: rowNumber;
}

table.autonumber tr.autonumber td:first-child::before {
    content: counter(rowNumber);
    min-width: 1em;
    margin-right: 0.5em;
}
select.form-control {
    -moz-appearance: none;
   appearance: none;
}
</style>
<!-- App_UN4 -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Pengajuan
      <small>Permintaan Uniform</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Permintaan Uniform</li>
    </ol>
  </section>
  
  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <!-- Form Utama Perm. Uniform -->
    <!-- Info boxes -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Permintaan Uniform</h3>
            
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
          @if($cekRecentSubmit != 0 or $cekTglNOk != null)
          <b style="font-size:20px;">@if($cekTglNOk != null or $cekTglGA != null)Pengajuan Terakhir @else Status Permintaan @endif</b><br> 
          <p>No. Permintaan : {{$cekUniStatus}} | <a href="#" data-toggle="modal" data-target="#modalPendingUniform">Detail</a></p>
          @if($cekTglNOk != null)
          <p style="margin-top: -10px;">Status : <i>Ditolak oleh atasan</i></p>
          @endif
          @if($cekTglNOk == null)
          <div class="progress" style="height: 3px;">
          @if($cekTglSubmit == null)
            <div class="progress-bar" role="progressbar" style="width: 25%;background-color: #83d537;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            @elseif($cekTglOk == null)
            <div class="progress-bar" role="progressbar" style="width: 50%;background-color: #83d537;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>]
            @elseif($cekTglGA == null)
            <div class="progress-bar" role="progressbar" style="width: 75%;background-color: #83d537;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
            @endif
            </div>
            @endif
            @if($cekTglSubmit == null or $cekTglNOk == null)
            <table style="width:100%;margin-top: -22px;">
            @else
            <table style="width:100%;">
            @endif
            <tr>
            @if($cekTglSubmit == null and $cekTglNOk == null)
            <td style="width:25%;padding: 8px 0px;"><p style="font-weight:400;font-size:100%;color: #73994f;">Simpan <span class="glyphicon glyphicon-ok" aria-hidden="true"></span></p></td>
            <td style="width:25%;padding: 8px 0px;"><p style="font-weight:400;font-size:100%;color:grey;">Belum<br>Submit</p></td>
              <td style="width:25%;padding: 8px 0px;"><p style="font-weight:400;font-size:100%;color:grey;">Belum<br>Approval Atasan</p></td>
              <td style="width:25%;padding: 8px 0px;"><p style="font-weight:400;font-size:100%;color:grey;">Belum<br>Approval GA</p></td>
            @elseif($cekTglOk == null and $cekTglNOk == null)
            <td style="width:25%;padding: 8px 0px;"><p style="font-weight:400;font-size:100%;color: #73994f;">Simpan <span class="glyphicon glyphicon-ok" aria-hidden="true"></span></p></td>
            <td style="width:25%;padding: 8px 0px;"><p style="font-weight:400;font-size:100%;color: #73994f;">Submit <span class="glyphicon glyphicon-ok" aria-hidden="true"></span></p></td>
            <td style="width:25%;padding: 8px 0px;"><p style="font-weight:400;font-size:100%;color:grey;">Belum<br>Approval Atasan</p></td>
            <td style="width:25%;padding: 8px 0px;"><p style="font-weight:400;font-size:100%;color:grey;">Belum<br>Approval GA</p></td>
            @elseif($cekTglGA == null and $cekTglNOk == null)
            <td style="width:25%;padding: 8px 0px;"><p style="font-weight:400;font-size:100%;color: #73994f;">Simpan <span class="glyphicon glyphicon-ok" aria-hidden="true"></span></p></td>
            <td style="width:25%;padding: 8px 0px;"><p style="font-weight:400;font-size:100%;color: #73994f;">Submit <span class="glyphicon glyphicon-ok" aria-hidden="true"></span></p></td>
              <td style="width:25%;padding: 8px 0px;"><p style="font-weight:400;font-size:100%;color:green;color: #73994f;">Approval<br>Atasan <span class="glyphicon glyphicon-ok" aria-hidden="true"></span></p></td>
              <td style="width:25%;padding: 8px 0px;"><p style="font-weight:400;font-size:100%;color:grey;">Belum<br>Approval GA</p></td>
            @endif
            </tr>
            </table>
          @endif
            <div class="row form-group">
              <div class="col-sm-12">
                
                <table id="dtPUniform" class="table-bordered table-striped" style="width:100%;">
                  <thead>
                    <tr>
                      <th style="width:1%">No</th>
                      <th>Tanggal</th>
                      <th>Item</th>
                      <th>Jumlah</th>
                    </tr>
                  </thead>
                </table>
                *Data yang ditampilkan adalah 10 data terakhir
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

@if($cekRecentSubmit != 0 or $cekRecentSubmit == 0 or $cekTglNOk != null)
<!-- Modal Add Permintaan Uniform -->
<div id="modalAddUniform" class="modal fade" role="dialog" data-backdrop="static">
  <div class="modal-dialog">   
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Permintaan Uniform</h4>
      </div>
      <div class="modal-body">
        <!-- <form method="post" id="f_uniform"> -->
        {!! Form::open(['url'=>route("mobiles.saveuniform"), 'method' =>'post'])!!}
        <input type="hidden" name="npk" value="{{ $inputkar->npk }}">
        <input type="hidden" name="npk_atasan" value="{{ $inputkar->npk_sec_head }}">
        <input type="hidden" name="tglsave" value="{{ \Carbon\Carbon::now() }}">
        <table id="dt" class="table-borderless" style="width:100%;font-size:15px;">   
          <tr>
            <td style="text-align:right;width:50%;"><b>Nama Karyawan : </b></td>
            <td>{{ $inputkar->nama }}</td>
          </tr>
          <tr>
            <td style="text-align:right;"><b>Nama Atasan : </b></td>
            <td>{{ $inputatasan }}</td>
          </tr>
          <tr>
            <td style="text-align:right;"><b>Tanggal Pengajuan :  </b></td>
            <td>{{ \Carbon\Carbon::now()->format('Y-m-d')}}</td>
          </tr>
          <tr>
            <td style="text-align:right;"><b>Status Permintaan : </b></td>
            <td>Belum Approval</td>
          </tr>
          <tr>
            <td colspan="2" style="text-align:right;">
            </td>
          </tr>
        </table>
          <p style="font-size:20px;float:left;"><b>List Uniform</b></p>
          <input type="hidden" id="listcount" name="listcount" value="0">
          <button type="button" name="add" id="add" class="btn btn-success btn-sm" style="float:right;margin-right: 8px;">Tambah Uniform <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
          <table class="autonumber table-striped" id="dynamic_field" style="width:100%">
            <tr>
              <th style="padding-left: 10px;width:1%">No.</th>
              <th style="padding-left: 10px;width:60%">Item</th>
              <th style="padding-left: 10px;width:10%">Qty</th>
              <th style="padding-left: 10px;width:15%"></th>
            </tr>
          </table>
          <br> 
        </div> 
        <div class="modal-footer">
          <!-- <div id="confirmdiv" class="checkbox" style="float:left;"><label><input id="confirm" type="checkbox" onclick="konfirmasiCheck()" required>List pengajuan sudah benar</label></div> -->
          <input type="submit" name="saveuniform" id="saveuniform" class="btn btn-info" value="Simpan"/>
          {!! Form::close() !!}   
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <!-- </form> -->
      </div>
    </div>       
  </div>
</div>
    <!-- Modal Add Permintaan Uniform -->
<div id="modalPendingUniform" class="modal fade" role="dialog" data-backdrop="static">
  <div class="modal-dialog">   
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detail Permintaan Uniform</h4>
      </div>
      <div class="modal-body">
        <!-- <form method="post" id="f_uniform"> -->
        {!! Form::open(['url'=>route("mobiles.submituniform"), 'method' =>'post'])!!}
        <input type="hidden" name="nouni" value="{{ $cekUniStatus }}">
        <table id="dt" class="table-borderless" style="width:100%;font-size:15px;">   
          <tr>
            <td style="text-align:right;width:50%;"><b>No. Permintaan : </b></td>
            <td><b style="color:red">{{ $cekUniStatus }}</b></td>
          </tr>
          <tr>
            <td style="text-align:right;width:50%;"><b>Nama Karyawan : </b></td>
            <td>{{ $inputkar->nama }}</td>
          </tr>
          <tr>
            <td style="text-align:right;"><b>Nama Atasan : </b></td>
            <td>{{ $inputatasan }}</td>
          </tr>
          <tr>
            <td style="text-align:right;"><b>Tanggal Pengajuan :  </b></td>
            <td>{{ $cekTglSave }}</td>
          </tr>
          <tr>
            <td style="text-align:right;"><b>Status Permintaan : </b></td>
            <td>
            @if($cekTglSubmit == null)
            Belum Submit
            @elseif($cekTglOk == null)
              @if($cekTglNOk == null)
            Belum Approval Atasan
              @elseif($cekTglNOk != null)
            Approval ditolak
              @endif
            @elseif($cekTglGA == null)
            Belum Approval GA
            @endif
            </td>
          </tr>
          <tr>
            <td colspan="2" style="text-align:right;">
            </td>
          </tr>
        </table>
          <p style="font-size:20px;float:left;"><b>List Uniform</b></p>
          <table class="autonumber table-striped" style="width:100%">
            <tr>
              <th style="padding-left: 10px;width:1%">No.</th>
              <th style="padding-left: 10px;width:60%">Item</th>
              <th style="padding-left: 10px;width:20%">Qty</th>
            </tr>
            @foreach($cekPendingData as $data)
            <tr class="autonumber">
              <td></td>
              <td> {{ $data->desc_uni}} </td>
              <td> {{ $data->qty}} </td>
            </tr>
            @endforeach
          </table>
          <br> 
        </div> 
        <div class="modal-footer">
          @if($cekTglSubmit == null)
          <input type="submit" name="submituniform" id="submituniform" class="btn btn-info" value="Submit"/>
          @endif
          {!! Form::close() !!}   
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <!-- </form> -->
      </div>
    </div>       
  </div>
</div>
@endif
@endsection


@section('scripts')
<script type="text/javascript">
$(document).ready( function () {
  var table = $('#dtPUniform').DataTable({
    "order": [[ 1, "desc" ]],
    processing: true,
    searching: true,
    ajax: {
      url: '{{ route("mobiles.permintaanuniform") }}'
    },
    "deferRender": true,
    "pageLength": 10,
    columns: [               
      {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable:false, searchable:false},
      {data: 'tgluni', name: 'uniform1.tgluni', orderable:false, searchable:false}, 
      {data: 'desc_uni', name: 'muniform2.desc_uni', orderable:false, searchable:false},
      {data: 'qty', name: 'muniform2.qty', orderable:false, searchable:false},
    ],
    dom: '<"top""<"btnRef">"<"toolbar">>rt<"bottom">',
    initComplete: function(){
      $("div.toolbar")
      .html(
        '@if($cekRecentSubmit == 0 or $cekTglNOk != null)\
        <button type="button" class="btn btn-success btn-md"\
        data-toggle="modal" data-target="#modalAddUniform"\
        style="margin-bottom:6px;float:right;">Pengajuan Baru <span class="glyphicon glyphicon-plus" aria-hidden="true">\
        </span></button>\
        @endif'
        )
        $("div.btnRef")
        .html(
          '<b style="float: left;font-size: 20px;">Data Histori</b>'
          );          
        },     
      });      
    });
    </script>
    
    <script type="text/javascript">
    var countAfter = 1; // Primary Count
    var countBefore = 0; // Count helper
    var countLoop = countBefore; // Loop Count
    var actual_id = 1; // Append boolean
    $(document).ready(function(){
      document.getElementById('saveuniform').disabled = true;
      $('#dynamic_field').append('<tr id="row0" class="dynamic-added">\
      <td colspan="4" style="text-align:center">Klik Add untuk tambah jenis uniform</td>\
      </tr>');
      $(document).on('click', '#add', function(){
        document.getElementById('listcount').value = countAfter;
        if(countAfter < 6){
          countLoop = countBefore;
          actual_id = countAfter
          reAssignID();
          $('#row0').remove();
          $('#dynamic_field').append('\
          <tr class="autonumber" id="row'+actual_id+'" class="dynamic-added">\
          <td></td>\
          <td style="display:initial;"><select required class="form-control input-sm"  id="listitem'+actual_id+'"  style="padding: 0px;font-size:15px;line-height:0px;" onchange="refreshList(this.id)" name="data[]">\
          <option id="kosong" name="kosong" value="" disabled selected>Pilih uniform...</option>\
          @foreach ($getUniform as $gu)\
            <option id="{{ $gu->kd_uni }}" tanggal="{{ $gu->tglga }}" value="{{ $gu->kd_uni }}">{{ $gu->desc_uni }}</option>\
          @endforeach\
          </select><small id="ketriwayat'+actual_id+'" class="w-100">Permintaan Terakhir : -</small></td>\
          <td><input type="tel" id="itemjumlah'+actual_id+'" name="jumlah[]" maxlength="2" onkeypress="validate(event)" class="form-control input-sm" style="width:40px;font-size:15px;line-height: 0px;" required></td>\
          <td><button type="button" name="remove" id="'+actual_id+'" class="btn btn-danger btn_remove btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td>\
          </tr>\
          ');
          countAfter++;
          countBefore++;
        }
        if(countAfter == 6){
          $('#add').hide();
        } else {
          document.getElementById('saveuniform').disabled = false;
        }
        if (countAfter != 2){
          refreshList();
        }

      });

      
      $(document).on('click', '.btn_remove', function(){
        countBefore--;
        countAfter--;
        if(countAfter != 6){
          $('#add').show();
        }
        document.getElementById('listcount').value = countAfter - 1;
          var button_id = $(this).attr("id"); 
          $('#row'+button_id+'').remove(); 
          var rowCount = $("#dynamic_field td").closest("tr").length;
          if(rowCount == 0){
            document.getElementById('saveuniform').disabled = true;
            $('#dynamic_field').append('<tr class="noclass" id="row0" class="dynamic-added">\
            <td colspan="5" style="text-align:center">Tekan <b>Tambah Uniform</b> untuk memulai</td>\
            </tr>');
          }else if (rowCount == 1){
            $('#row0').remove();
          }
          refreshList()
      }
      
      );
    
    });  
    </script>
    
    <script>
    function refreshList(select_id) {
        $("select").find("option").show();
        for (countLoop = 0; countLoop < 6; countLoop++) {
        var selectElement = document.getElementById("listitem"+(countLoop));
        if(typeof(selectElement) != 'undefined' && selectElement != null){
          } else {
            continue;
          }
        var selectedHiddenInput = document.getElementById('listitem'+(countLoop)).value;
        if (selectedHiddenInput != ""){
          var selectedCode = selectedHiddenInput.substring(0, 2); // berdasarkan kode awal (BJ, CL, HL, TP, SP)
        $("select").find("option[value^=" + selectedCode + "]").hide();
        $('#listitem'+(countLoop)).find("option[value^=" + selectedCode + "]").show();
        }
        }
        try {
          // alert('ketriwayat'+select_id.substring(8,10));
          var tglterakhir = $('#listitem'+(select_id.substring(8,10))+ ' option:selected').attr("tanggal");
          document.getElementById('ketriwayat'+select_id.substring(8,10)).innerHTML = 'Permintaan Terakhir : ' + tglterakhir;
        }
        catch (e) {
          //continue on error (on error resume next)
        }
        
    }

    function reAssignID(){
      c = countAfter;
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
    
    function validate(evt) {
      var theEvent = evt || window.event;
      
      // Handle paste
      if (theEvent.type === 'paste') {
        key = event.clipboardData.getData('text/plain');
      } else {
        // Handle key press
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
      }
      var regex = /[0-9]|\./;
      if( !regex.test(key) ) {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
      }
    }
    </script>
    
    <script>
      $(window).on('load', function() {
      var sessionModal = document.getElementById("sessionModal");
      var addButton = document.getElementById("add");
      $(sessionModal).click();
      // $(addButton).click();
      });
    </script>

@endsection