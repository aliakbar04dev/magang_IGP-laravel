@extends('layouts.app')
@section('content')
<style>


#lookupInspect tbody td,#lookupInspect  tfoot th,#lookupKatalog tbody td,#lookupKatalog  tfoot th{
  padding-right:0px !important; 
  padding-left:0px !important;
}

.textarea_col{
    margin-bottom:30px;
}

.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
    background-color: #fff;
}

textarea{resize: none;}

label.header {
    display:block;
    margin-bottom: 0px;
    text-align: center;
    background-color:#f7644c;
    color:white;
    border-radius: 2px 2px 0px 0px;
    padding-bottom: 5px;
    padding-top: 5px;
    font-weight:600;
    }
textarea { display:block; }

@media screen and (max-width: 1000px) {
    #arrow1 {
        display: none !important;
    }
}

.loader {
    border: 3px solid #f9eaea;
    border-top: 3px solid #31ff60;
    border-bottom: 3px solid #31ff60;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    animation: spin 0.7s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
input[readonly] {
    background-color: #f6f6f6 !important;
}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="height:100%">
      <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Perawatan Mesin
        <small>Daftar Perawatan Mesin</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Master</li>
        <li class="active"><i class="fa fa-files-o"></i>  Daftar Perawatan Mesin</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
            
    	<div class="row">
	        <div class="col-xl-12">
	          <div class="box box-primary">
              <div class="box-body">
                        <div class="form-group {{ $errors->has('kd_mesin') ? ' has-error' : '' }}">
                            <div class="row">
                                <div class="col-md-3"> 
                                    <div class="form-group">
                                        <label>Kode Mesin</label>
                                    <div class="input-group">
                                        @if (session()->has('upload.kd_mesin'))
                                        <input class="form-control" id="kd_mesin" value="{{ session()->get('upload.kd_mesin') }}" data=""
                                        required="required" 
                                          style="text-transform:uppercase;background-color:white;" onkeypress="showPopupKDMesin()" name="kd_mesin" type="text">
                                        @else
                                        <input class="form-control" id="kd_mesin" value="" data=""
                                        required="required" 
                                          style="text-transform:uppercase;background-color:white;" onkeypress="showPopupKDMesin()" name="kd_mesin" type="text">
                                        @endif
                                        
                                        <span class="input-group-btn">
                                          <button type="button" class="btn btn-info" onclick="showPopupKDMesin()"
                                            data-toggle="modal" data-target="#KDMesinModal" style="height: 34px;">
                                            <span class="glyphicon glyphicon-search"></span>
                                          </button>
                                        </span>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-3"> 
                                    {!! Form::label('nm_mesin', 'Nama Mesin') !!}
                                    {!! Form::text('nm_mesin', null, ['class'=>'form-control', 'oninput'=>'let p = this.selectionStart; this.value = this.value.toUpperCase();this.setSelectionRange(p, p);','placeholder' => 'Nama Mesin', 'maxlength' => '20', 'required','readonly']) !!} {!! $errors->first('nm_mesin', '<p class="help-block">:message</p>') !!}
                                </div>
                                <div class="col-md-2"> 
                                    <button class="btn btn-success" id="tampildata" style="margin-top:25px;">Tampil</button>
                                </div>
                            </div>

                                <div class="row">
                                    <div class="col-md-3"> 
                                        {!! Form::label('tipe', 'Tipe Mesin') !!}
                                        {!! Form::text('tipe', null, ['class'=>'form-control', 'oninput'=>'let p = this.selectionStart; this.value = this.value.toUpperCase();this.setSelectionRange(p, p);','placeholder' => 'Tipe Mesin', 'maxlength' => '20', 'required','readonly']) !!} {!! $errors->first('tipe', '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="col-md-3"> 
                                        {!! Form::label('maker', 'Maker') !!}
                                        {!! Form::text('maker', null, ['class'=>'form-control', 'oninput'=>'let p = this.selectionStart; this.value = this.value.toUpperCase();this.setSelectionRange(p, p);','placeholder' => 'Maker', 'maxlength' => '20', 'required','readonly']) !!} {!! $errors->first('maker', '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="col-md-5"> 
                                        {!! Form::label('line', 'Line') !!}
                                        {!! Form::text('line', null, ['class'=>'form-control', 'oninput'=>'let p = this.selectionStart; this.value = this.value.toUpperCase();this.setSelectionRange(p, p);','placeholder' => 'Line', 'maxlength' => '20', 'required','readonly']) !!} {!! $errors->first('line', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                        </div>
                  <h3><b>Item Pengecekan</b>&nbsp;&nbsp;<div id="loading_icon" style="display: none;"><div class="loader" style="display: inline-block;margin-bottom: -5px;"></div> Menyimpan perubahan...</div></h3>
                  <input class="form-control" placeholder="Cari No Urut" style="float:left;width:150px;margin: 0px 12px 10px 0px;" type="text" id="table-text-urut">
                  <input class="form-control" placeholder="Cari Kode" style="float:left;width:150px;margin: 0px 12px 10px 0px;" type="text" id="table-text-kode">
                  <select autocomplete="off" class="form-control" style="width:150px;float:left;margin: 0px 12px 10px 0px;" id="table-aktif">           
                      <option value="">Aktif & Tidak</option>
                    <option value="T">Aktif</option>
                      <option value="F">Tidak Aktif</option>
                       
                      </select>
                      <select autocomplete="off" class="form-control" style="width:150px;float:left;margin: 0px 12px 10px 0px;" id="table-satuan">           
                          <option value="">Semua Satuan</option>
                        <option value="d">Day</option>
                          <option value="w">Week</option>
                          <option value="m">Month</option>
                          <option value="y">Year</option>
                           
                          </select>
                          <select autocomplete="off" class="form-control" style="width:150px;float:left;margin: 0px 12px 10px 0px;" id="table-pic">           
                            <option value="">Semua Pic</option>
                          <option value="mtc">MTC</option>
                            <option value="pro">PRO</option>
                            <option value="qc">QC</option>
                            <option value="usr">USER</option>
                            </select>
                          
                      <button class="btn btn-success reload" style="margin-left:10px" ><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
	              <table id="tblMaster" class="table table-bordered table-striped compact" cellspacing="0" width="100%">
                 <thead>
                  <tr>
                    <th rowspan="2" style="text-align: center" width="8%">No</th>
                    <th colspan="2" style="text-align: center">Item Pengecekan</th>
                    
                    <th colspan="2" style="text-align: center">Periode</th>
                    
                    <th rowspan="2" style="text-align: center" width="10%">PIC</th>
                    <th rowspan="2" style="text-align: center" width="10%">Keterangan</th>
                    <th rowspan="2" style="text-align: center" width="20%">Aktif</th>
                  </tr>
                  <tr>
                    <th style="text-align: center" width="10%">Kode</th>
                    <th style="text-align: center">Deskripsi</th>
                    <th style="text-align: center" width="10%">Nilai</th>
                    <th style="text-align: center" width="10%">Satuan</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th style="text-align: center"><input type="hidden" class="form-control" value="" name="kd_mesin_add" id="kd_mesin_add" placeholder="kd mesin" style="width:100%"><input type="number" class="form-control" value="" name="no_urut_add" id="no_urut_add" placeholder="No" style="width:100%"></th>
                    <th style="text-align: center"><div class="input-group">
                      <input class="form-control" id="itemcheck_add" value="" data=""
                      required="required"
                        style="text-transform:uppercase;background-color:white;" readonly name="itemcheck_add" type="number">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-info" onclick="showPopupItemCheck('0')"
                          data-toggle="modal" data-target="#KDItemModal" style="height: 34px;">
                          <span class="glyphicon glyphicon-search"></span>
                        </button>
                      </span>
                  </div></th>
                    <th style="text-align: center"><input type="text" class="form-control" value="" id="desc_add" readonly name="desc_add" placeholder="Deskripsi" style="width:100%"></th>
                    <th style="text-align: center" ><input type="number" class="form-control"  id="nil_add" name="nil_add" placeholder="Nilai" value="" style="width:100%"></th>
                    <th style="text-align: center" ><select class="form-control" id="satuan_add" name="satuan_add">
                      <option value="D">DAY</option>
                      <option value="W">WEEK</option>
                      <option value="M">MONTH</option>
                      <option value="Y">YEAR</option>
                    </select></th>
                    <th style="text-align: center" ><select class="form-control" id="pic_add" name="pic_add">
                      <option value="MTC">MTC</option>
                      <option value="PRO">PRO</option>
                      <option value="QC">QC</option>
                      <option value="USR">USER</option>
                    </select></th>
                    <th style="text-align: center" ><input type="text" class="form-control" id="ket_add" name="ket_add" placeholder="Keterangan" value="" style="width:100%"></th>
                    <th style="text-align: center" >
                      <select class="form-control pull-left" id="st_aktif_add" name="st_aktif_add" style="width:70%">
                        <option value="T">Aktif</option>
                        <option value="F">Tidak Aktif</option>
                      </select>
                      <button type="submit" id="btnadditem" name="btnadditem" class="btn btn-success pull-right" style="height: 34px;">
                      <span class="glyphicon glyphicon-plus"></span>
                    </button>
                    </th>
                    </tr>
                </tfoot>
                </table>
                <label>* klik item pengecekan untuk memunculkan No DPM</label>
                <br>
                <div class="clearfix">
                  <input class="form-control" placeholder="No DPM" style="float:left;width:150px;margin: 0px 12px 10px 0px;" type="text" id="no_dpm" readonly >
                  <button type="button" id="deldashboard" name="deldashboard" class="btn btn-danger" style="margin-left: 10px;">
                    Hapus
                  </button>
                    <input class="form-control" placeholder="Item No" style="display:none;float:left;width:150px;margin: 0px 12px 10px 0px;" type="text" id="item_no" readonly>

                    
                    <div class="pull-right">
                        <button type="button" id="munculkatalog" name="munculkatalog" class="btn bg-orange" style="height: 34px; margin-right:15px;">
                            Katalog Spare part
                        </button>
                        <button type="button" id="munculinspect" name="munculinspect" class="btn bg-purple" style="height: 34px;">
                            Inspection Standard
                        </button>
                    </div>
                </div>
                      
                        <form enctype="multipart/form-data" id="formupload" name="formupload" action="{{ route('upload.mtcdpm') }}" method="post" style="display: inline;"> 
                          <div class="form-group" style="width:80%" style="display:inline">
                            <table>
                              <tr>
                                  <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
                                  <input type="hidden" name="kd_mesin_upload" id="kd_mesin_upload" value="" />
                                <td><input type="text" readonly class="form-control" id="currentfoto" style="margin-right:30px; width:300px"></td>
                                <td>
                                  <input type="hidden" id="no_dpm_upload" name="no_dpm_upload" class="form-control" />
                                </td>
                                <td><input type="file" class="form-control"  id="gambar" name="gambar" /></td>
                                
                                <td><input type="submit" value="Submit" class="btn bg-navy" style="margin-left:30px;"/></td>
                              </tr>
                            </table>
                          </div>
                        
                        
                        <div id="targetfoto" style="min-height:300px; border-style: groove; background-color:#d2d6de; width: 100%;
                        height: 400px;
                        vertical-align: middle; 
                        line-height: 390px;
                        text-align: center; 
                        border: 3px dashed #1c87c9;  "><p id="noimage">No Image</p>
                        </div>
                  </form>
                  <input type="hidden" id="reload" class="reload">
              </div>
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
@include('mtc.dpmesin.popup.mesinModal')
@include('mtc.dpmesin.popup.katalogModal')
@include('mtc.dpmesin.popup.inspectModal')
@include('mtc.dpmesin.popup.itemModal')
@include('mtc.dpmesin.popup.itemKatalogModal')
@endsection

@section('scripts')
<script type="text/javascript">
$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		cache: false,
		headers: { "cache-control": "no-cache" },
	});
  $(document).ready(function(){
    
    muncul()

   	function muncul(){

     if($("#kd_mesin").val() !== ''){
      let kd_mesin = $("#kd_mesin").val();
        tableMaster(kd_mesin)
        isikdmesin()
     }else{
      tableMaster('')
     }

     function isikdmesin(){
      let kd_mesin = $("#kd_mesin").val();
       var _token = $('meta[name="csrf-token"]').attr('content');
      $.ajax({
            type: "post",
            url: '{{ route('kdmesin.mtcdpm') }}',
            data: {
              kd_mesin:kd_mesin,
              _token:_token
            },
            success: function(data) {
              $("#kd_mesin").val(data["kd_mesin"]);
              $("#kd_mesin_add").val(data["kd_mesin"]);
              $("#kd_mesin_upload").val(data["kd_mesin"]);
              $("#kd_mesin").attr("data",data["kd_mesin"]);
              $("#nm_mesin").val(data["nm_mesin"]);
              $("#nm_mesin").attr("data",data["nm_mesin"]);
              $("#tipe").val(data["mdl_type"]);
              $("#tipe").attr("data",data["mdl_type"]);
              $("#maker").val(data["maker"]);
              $("#maker").attr("data",data["maker"]);
              $("#line").val(data["xnm_line"]);
              $("#line").attr("data",data["xnm_line"]);
            }

            })
     }
        

       showPopupKDMesin = function () {
      var myHeading = "<p>Daftar Mesin</p>";
      $("#mesinModalLabel").html(myHeading);
      var url = "{{ route('daftarmesin.mtcdpm') }}";
      var lookupMesin = $('#lookupMesin').DataTable({
        processing: true,
        "oLanguage": {
          'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
        },
        serverSide: true,
        "pagingType": "numbers",
        ajax: url,
        "lengthChange": false,
        "aLengthMenu": [
          [5, 10, 25, 50, 75, 100, -1],
          [5, 10, 25, 50, 75, 100, "All"]
        ],
        responsive: true,
        "order": [
          [1, 'asc']
        ],
        columns: [
          {data: 'kd_mesin', name: 'kd_mesin'},
        {data: 'nm_mesin', name: 'nm_mesin',orderable: false},
        {data: 'maker', name: 'maker',orderable: false},
        {data: 'mdl_type', name: 'mdl_type',orderable: false},
        {data: 'mfd_thn', name: 'mfd_thn',orderable: false},
        {data: 'no_seri', name: 'no_seri',orderable: false},
        {data: 'st_aktif', name: 'st_aktif'},
        {data: 'st_me', name: 'st_me',orderable: false},
        {data: 'kd_line', name: 'kd_line',orderable: false},
        {data: 'lok_zona', name: 'lok_zona'},
        ],
        "bDestroy": true,
        "initComplete": function (settings, json) {
          

          $("#no_dpm").val('');

          //mobile device only uses click action triggered 
          $('#lookupMesin tbody').on('dblclick', 'tr', function () {
            var rows = $(this);
            var rowData = lookupMesin.rows(rows).data();
            $.each($(rowData), function (key, value) {
              $("#kd_mesin").val(value["kd_mesin"]);
              $("#kd_mesin_add").val(value["kd_mesin"]);
              $("#kd_mesin_upload").val(value["kd_mesin"]);
              $("#kd_mesin").attr("data",value["kd_mesin"]);
              $("#nm_mesin").val(value["nm_mesin"]);
              $("#nm_mesin").attr("data",value["nm_mesin"]);
              $("#tipe").val(value["mdl_type"]);
              $("#tipe").attr("data",value["mdl_type"]);
              $("#maker").val(value["maker"]);
              $("#maker").attr("data",value["maker"]);
              $("#line").val(value["xnm_line"]);
              $("#line").attr("data",value["xnm_line"]);
              
              tableMaster(value["kd_mesin"])

              $('#KDMesinModal').modal('hide');
            });
          });
        },
      });
    }

    showPopupItemCheck = function (id) {
      var myHeading = "<p>Daftar Item Pengecekan</p>";
      $("#itemModalLabel").html(myHeading);
      var url = "{{ route('daftaritem.mtcdpm') }}";
      var lookupItem = $('#lookupItem').DataTable({
        processing: true,
        "oLanguage": {
          'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
        },
        serverSide: true,
        "pagingType": "numbers",
        ajax: url,
        "lengthChange": false,
        "aLengthMenu": [
          [5, 10, 25, 50, 75, 100, -1],
          [5, 10, 25, 50, 75, 100, "All"]
        ],
        responsive: true,
        "order": [
          [1, 'asc']
        ],
        columns: [
          {data: 'no_ic', name: 'no_ic'},
        {data: 'nm_ic', name: 'nm_ic',orderable: false},
        {data: 'st_aktif', name: 'st_aktif',orderable: false},
        ],
        "bDestroy": true,
        "initComplete": function (settings, json) {
          // $('#lookupItem tbody').on('dblclick', 'tr', function () {
          //   var dataArr = [];
          //   var rows = $(this);
          //   var rowData = lookupItem.rows(rows).data();
          //   $.each($(rowData), function (key, value) {

          //   });
          // });

          //mobile device only uses click action triggered 
          $('#lookupItem tbody').on('dblclick', 'tr', function () {
            var rows = $(this);
            var rowData = lookupItem.rows(rows).data();
            $.each($(rowData), function (key, value) {
              
              if(id == '0'){
                $("#itemcheck_add").val(value["no_ic"]).trigger('change');
                $("#desc_add").val(value["nm_ic"]).trigger('change');
              }else{
                $("#selectnoic"+id).val(value["no_ic"]).trigger('change');
                $("#selectnmic"+id).val(value["nm_ic"]).trigger('change');
              }

              $('#KDItemModal').modal('hide');
            });
          });

          $('#KDItemModal').on('hidden.bs.modal', function () {
          });

    
        },
      });
    }

    showPopupItemKatalog = function (id) {
      var myHeading = "<p>Daftar Item</p>";
      $("#itemKatalogModalLabel").html(myHeading);
      var url = "{{ route('daftaritemkatalog.mtcdpm') }}";
      var lookupItemKatalog = $('#lookupItemKatalog').DataTable({
        processing: true,
        "oLanguage": {
          'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
        },
        serverSide: true,
        "pagingType": "numbers",
        ajax: url,
        "lengthChange": false,
        "aLengthMenu": [
          [5, 10, 25, 50, 75, 100, -1],
          [5, 10, 25, 50, 75, 100, "All"]
        ],
        responsive: true,
        "order": [
          [1, 'asc']
        ],
        columns: [
          {data: 'item', name: 'item'},
        {data: 'desc1', name: 'desc1',orderable: false},
        {data: 'itemdesc', name: 'itemdesc',orderable: false},
        {data: 'unit', name: 'unit',orderable: false},
        {data: 'sk', name: 'sk',orderable: false},
        ],
        "bDestroy": true,
        "initComplete": function (settings, json) {
          // $('#lookupItem tbody').on('dblclick', 'tr', function () {
          //   var dataArr = [];
          //   var rows = $(this);
          //   var rowData = lookupItem.rows(rows).data();
          //   $.each($(rowData), function (key, value) {

          //   });
          // });

          //mobile device only uses click action triggered 
          $('#lookupItemKatalog tbody').on('dblclick', 'tr', function () {
            var rows = $(this);
            var rowData = lookupItemKatalog.rows(rows).data();
            $.each($(rowData), function (key, value) {
              
              if(id == '0'){
                $("#item_no_add").val(value["item"]).trigger('change');
                $("#desc1_add").val(value["desc1"]).trigger('change');
              }else{
                let item_no = $("#item_no_oper").val();
                let isi;
                if(item_no == ''){
                  isi = id
                }else{
                  isi = $("#item_no_oper").val();
                }
                $("#item_no_oper").val(isi);
                $("#item_no_update"+id).val(value["item"]).trigger('change');
                $("#desc1_update"+id).val(value["desc1"]).trigger('change');
                $("#item_no_oper").val(value["item"]);
              }
              

              $('#KDItemKatalogModal').modal('hide');
            });
          });

          $('#KDItemKatalogModal').on('hidden.bs.modal', function () {
          });

    
        },
      });

      
    }

    
    $('#tampildata').on('click', function () {
      let kd_mesin_val = $("#kd_mesin").val();
      tableMaster(kd_mesin_val)
      isikdmesin()
    });

      function tableMaster(kd_mesin){
        var tableMaster = $('#tblMaster').DataTable({
          
      "scrollY":        "200px",
        "scrollCollapse": true,
        "paging":         false,
      // responsive: true,
      "order": [[0, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      bDestroy: true,
      ajax: {
        url: "{{ route('dashboard.mtcdpm') }}",
        type: 'GET',
        data: {
          isi:kd_mesin
        }},
        searching:true,
      columns: [
        {data: 'no_urut', name: 'no_urut'},
        {data: 'no_ic', name: 'no_ic',orderable: false},
        {data: 'nmic', name: 'nmic',orderable: false,searchable:false},
        {data: 'nil_period', name: 'nil_period',orderable: false},
        {data: 'sat_period', name: 'sat_period',orderable: false},
        {data: 'pic_dpm', name: 'pic_dpm',orderable: false},
        {data: 'ket_dpm', name: 'ket_dpm'},
        {data: 'st_aktif', name: 'st_aktif',orderable: false},
	    ],
      dom: 'ltir',
      'initComplete': function (settings, json) {
             //mobile device only uses click action triggered 
          $('#tblMaster tbody').on('click', 'tr', function () {
            var rows = $(this);
            var rowData = tableMaster.rows(rows).data();
            $.each($(rowData), function (key, value) {
              $("#no_dpm").val(value["no_dpm"]).trigger('change');
              $("#currentfoto").val(value["lok_pict"]).trigger('change');
              if(value["tampilgambar"] !== 'kosong'){
                $("#noimage").html('<img id="preview" src="'+value["tampilgambar"]+'" alt="" style="max-height:390px;">');
              }else{
                $("#noimage").html('No Image');
              }
            });
          });

        },
    });


    $('#table-text-urut').on('keyup', function(){
      tableMaster.column(0).search(this.value).draw();   
    });

    $('#table-text-kode').on('keyup', function(){
      tableMaster.column(1).search(this.value).draw();   
    });

    $('#table-aktif').ready(function(){
              tableMaster.column(7).search('').draw(); 
        });    

        $('#table-aktif').on('change', function(){
            tableMaster.column(7).search(this.value).draw();            
        }); 

        $('#table-satuan').ready(function(){
              tableMaster.column(4).search('').draw(); 
        });    

        $('#table-satuan').on('change', function(){
            tableMaster.column(4).search(this.value).draw();            
        }); 

        $('#table-pic').ready(function(){
              tableMaster.column(5).search('').draw(); 
        });    

        $('#table-pic').on('change', function(){
            tableMaster.column(5).search(this.value).draw();            
        }); 

        $(".reload").on('click', function(e) {
       tableMaster.ajax.reload()
     });

      $('#no_dpm').on('change', function () {
          let no_dpm_val = $("#no_dpm").val();
          $("#no_dpm_upload").val(no_dpm_val);
      });

      $('#kd_mesin').on('change', function () {
          let kd_mesin_val = $("#kd_mesin").val();
          $("#kd_mesin_upload").val(kd_mesin_val);
      });


      // katalog
     $("#munculkatalog").on('click', function(e) {
        e.preventDefault();
        var myHeading = "<p>Daftar Katalog Spare part</p>";
        $("#katalogModalLabel").html(myHeading);
        $("#KDKatalogModal").modal('show');
        var nodpm = $("#no_dpm").val();
        var _token = $('meta[name="csrf-token"]').attr('content');
        var tableKatalog = $('#lookupKatalog').DataTable({
          "scrollY":        "200px",
            "scrollCollapse": true,
            "paging":         false,
          // responsive: true,
          processing: true, 
          "oLanguage": {
            'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
          }, 
          serverSide: true,
          bDestroy: true,
          ajax: {
            url: "{{ route('katalog.mtcdpm') }}",
            type: 'POST',
            data: {
              nodpm:nodpm,
              _token:_token
            },
            },
            searching:true,
          columns: [
            {data: 'item_no', name: 'item_no'},
            {data: 'desc1', name: 'desc1',orderable: false},
            {data: 'nil_qpu', name: 'nil_qpu',orderable: false,searchable:false},
            {data: 'qty_life_time', name: 'qty_life_time',orderable: false},
            {data: 'ket', name: 'ket',orderable: false},
          ],
          dom: 'ltir',
          'initComplete': function (settings, json) {
                 //mobile device only uses click action triggered 
              $('#lookupKatalog tbody').on('click', 'tr', function () {
                var rows = $(this);
                var rowData = tableKatalog.rows(rows).data();
                $.each($(rowData), function (key, value) {
                  let item_no = $("#item_no_update"+value['item_no_oper']).val();
                  $("#item_no2").val(item_no);
                  $("#item_no_oper").val(item_no);
                });
              });
            },
        });

        
      });

      $("#delkatalog").on('click', function(e) {
        e.preventDefault();
            swal({ 
            text: "Apakah anda yakin menyetujui menghapus data katalog ini?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak, Batalkan!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: true
          }).then(function() {
            var no_dpm = $("#no_dpm").val();
            var item_no = $("#item_no2").val();
            var _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
              type: "post",
              url: '{{ route('delkatalog.mtcdpm') }}',
              data: {
                no_dpm:no_dpm,
                item_no:item_no,
                _token:_token
              },
              success: function(data) {
                if(data['status'] == false){
                swal(
                      'Terjadi kesalahan',
                      'Data tidak terhapus mohon hubungi admin!',
                      'error'
                      )
              }
              $("#munculkatalog").trigger('click')
              },
              error: function(error) {
                swal('Warning!', 'Gagal!', 'error');
                }
              });
            
          }, function(dismiss) { 
            if (dismiss === 'cancel') {
              swal('Cancelled', 'Dibatalkan', 'error');
            }
          }) 

        });



        
      

        $("#btnadditemkatalog").on('click', function(e) {
        e.preventDefault();
        var no_dpm = $("#no_dpm").val();
          var item_no_add = $("#item_no_add").val();
          var desc1_add = $("#desc1_add").val();
          var nil_qpu_add = $("#nil_qpu_add").val();
          var qty_life_add = $("#qty_life_add").val();
          var kete_add = $("#kete_add").val();
          var _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
            type: "post",
            url: '{{ route('mtcdpm.additemkatalog') }}',
            data: {
              item_no_add:item_no_add,
              desc1_add:desc1_add,
              nil_qpu_add:nil_qpu_add,
              qty_life_add:qty_life_add,
              kete_add:kete_add,
              no_dpm:no_dpm,
              _token:_token
            },
            success: function(data) {
              if(data['status'] == false){
                swal(
                      'Terjadi kesalahan',
                      'No Item Duplicate',
                      'error'
                      )
              }
              $("#nil_qpu_add").val('');
              $("#qty_life_add").val('');
              $("#kete_add").val('');
              $("#munculkatalog").trigger('click')
              
            }

            })
      });

      $("#munculinspect").on('click', function(e) {
        e.preventDefault();
        var myHeading = "<p>Daftar Inspection Spare part</p>";
        $("#inspectModalLabel").html(myHeading);
        $("#KDInspectModal").modal('show');
        var nodpm = $("#no_dpm").val();
        var _token = $('meta[name="csrf-token"]').attr('content');
        
        var tableInspect = $('#lookupInspect').DataTable({
          "scrollY":        "200px",
            "scrollCollapse": true,
            "paging":         false,
          // responsive: true,
          processing: true, 
          "oLanguage": {
            'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
          }, 
          serverSide: true,
          bDestroy: true,
          ajax: {
            url: "{{ route('inspect.mtcdpm') }}",
            type: 'POST',
            data: {
              nodpm:nodpm,
              _token:_token
            },
            },
            searching:true,
          columns: [
            {data: 'no_urut', name: 'no_urut'},
            {data: 'nm_is', name: 'nm_is',orderable: false},
            {data: 'ketentuan', name: 'ketentuan',orderable: false,searchable:false},
            {data: 'metode', name: 'metode',orderable: false},
            {data: 'alat', name: 'alat',orderable: false},
            {data: 'waktu_menit', name: 'waktu_menit',orderable: false},
            {data: 'keterangan', name: 'keterangan',orderable: false},
            {data: 'nm_status', name: 'nm_status',orderable: false},
            {data: 'st_aktif', name: 'st_aktif',orderable: false},
          ],
          dom: 'ltir',
          'initComplete': function (settings, json) {
                 //mobile device only uses click action triggered 
              $('#lookupInspect tbody').on('click', 'tr', function () {
                var rows = $(this);
                var rowData = tableInspect.rows(rows).data();
                $.each($(rowData), function (key, value) {
                  $("#no_is_oper").val(value["no_is_oper"]);
                });
              });
            },
        });

        
      });

      $("#delinspect").on('click', function(e) {
        e.preventDefault();
            swal({ 
            text: "Apakah anda yakin menyetujui menghapus data inspect standard ini?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak, Batalkan!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: true
          }).then(function() {
            var no_is = $("#no_is_oper").val();
            var _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
              type: "post",
              url: '{{ route('delinspect.mtcdpm') }}',
              data: {
                no_is:no_is,
                _token:_token
              },
              success: function(data) {
                if(data['status'] == false){
                swal(
                      'Terjadi kesalahan',
                      data['pesan'],
                      'error'
                      )
              }
              $("#munculinspect").trigger('click')
              },
              error: function(error) {
                swal('Warning!', 'Gagal!', 'error');
                }
              });
            
          }, function(dismiss) { 
            if (dismiss === 'cancel') {
              swal('Cancelled', 'Dibatalkan', 'error');
            }
          }) 

        });

        $("#btnadditeminspect").on('click', function(e) {
        e.preventDefault();
        var no_dpm = $("#no_dpm").val();
          var no_uruti_add = $("#no_uruti_add").val();
          var nm_is_add = $("#nm_is_add").val();
          var ketentuan_add = $("#ketentuan_add").val();
          var metode_add = $("#metode_add").val();
          var alat_add = $("#alat_add").val();
          var waktu_add = $("#waktu_add").val();
          var keterangan_add = $("#keterangan_add").val();
          var statusi_add = $("#statusi_add").val();
          var st_aktifi_add = $("#st_aktifi_add").val();
          var _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
            type: "post",
            url: '{{ route('mtcdpm.additeminspect') }}',
            data: {
              no_uruti_add:no_uruti_add,
              nm_is_add:nm_is_add,
              ketentuan_add:ketentuan_add,
              metode_add:metode_add,
              alat_add:alat_add,
              waktu_add:waktu_add,
              keterangan_add:keterangan_add,
              statusi_add:statusi_add,
              st_aktifi_add:st_aktifi_add,
              no_dpm:no_dpm,
              _token:_token
            },
            success: function(data) {
              $("#no_uruti_add").val('');
              $("#nm_is_add").val('');
              $("#ketentuan_add").val('');
              $("#metode_add").val('');
              $("#alat_add").val('');
              $("#waktu_add").val('');
              $("#keterangan_add").val('');
              $("#munculinspect").trigger('click')
            }

            })
      });

      }

     }

     $("#btnadditem").on('click', function(e) {
        e.preventDefault();
          var kd_mesin_add = $("#kd_mesin_add").val();
          var no_urut_add = $("#no_urut_add").val();
          var itemcheck_add = $("#itemcheck_add").val();
          var nil_add = $("#nil_add").val();
          var pic_add = $("#pic_add").val();
          var satuan_add = $("#satuan_add").val();
          var ket_add = $("#ket_add").val();
          var st_aktif_add = $("#st_aktif_add").val();
          var _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
            type: "post",
            url: '{{ route('mtcdpm.additem') }}',
            data: {
              kd_mesin_add:kd_mesin_add,
              no_urut_add:no_urut_add,
              itemcheck_add:itemcheck_add,
              nil_add:nil_add,
              pic_add:pic_add,
              satuan_add:satuan_add,
              ket_add:ket_add,
              st_aktif_add:st_aktif_add,
              _token:_token
            },
            success: function(data) {
              $("#no_urut_add").val('');
              $("#nil_add").val('');
              $("#ket_add").val('');
              $("#tampildata").trigger('click')
            }

            })
      });

     
     

     
   
  });

  function saveChange(){
        var nodpm = $("#no_dpm").val();
        document.getElementById('loading_icon').style.display = "inline-block";
        var selectnourut = $("#selectnourut"+nodpm).val();
        var selectnoic = $("#selectnoic"+nodpm).val();
        var selectaktif = $("#selectaktif"+nodpm).val();
        var selectnilai = $("#selectnilai"+nodpm).val();
        var selectsat = $("#selectsat"+nodpm).val();
        var selectket_dpm = $("#selectket_dpm"+nodpm).val();
        var selectpicdpm = $("#selectpicdpm"+nodpm).val();
        var _token = $('meta[name="csrf-token"]').attr('content');
          var url = "{{ route('mtcdpm.update',"nodpm") }}"
              $.ajax({
                  url      : url,
                  type     : 'POST',
                  dataType : 'json',
                  data     : {
                      selectnourut   : selectnourut,
                      selectnoic : selectnoic,
                      selectaktif : selectaktif,
                      selectnilai : selectnilai,
                      selectsat : selectsat,
                      selectket_dpm : selectket_dpm,
                      selectpicdpm : selectpicdpm,
                      nodpm : nodpm,
                      _token  : _token,
                      _method  :'PUT',
                  },
                  success: function( _response ){
                    
                      document.getElementById('loading_icon').style.display = "none";
                  },
                  error: function( _response ){
                      swal(
                      'Terjadi kesalahan',
                      'Segera hubungi Admin!',
                      'error'
                      )
                  }
              });
      }


      function saveKatalog(id){
        let nodpm = $("#no_dpm").val();
        let item_no = $("#item_no_oper").val() ;
        document.getElementById('loadingkatalog').style.display = "inline-block";
        let item_no_update = $("#item_no_update"+id).val();
        let nil_qpu_update = $("#nil_qpu_update"+id).val();
        let qty_life_time_update = $("#qty_life_time_update"+id).val();
        let kete_update = $("#kete_update"+id).val();
        let _token = $('meta[name="csrf-token"]').attr('content');
          let url = "{{ route('updatekatalog.mtcdpm') }}"
              $.ajax({
                  url      : url,
                  type     : 'POST',
                  dataType : 'json',
                  data     : {
                      item_no   : item_no,
                      item_no_update   : item_no_update,
                      nil_qpu_update : nil_qpu_update,
                      qty_life_time_update : qty_life_time_update,
                      kete_update : kete_update,
                      nodpm : nodpm,
                      _token  : _token,
                  },
                  success: function( data ){
                    if(data['status'] == false){
                      swal(
                            'Terjadi kesalahan',
                            'No Item Duplicate',
                            'error'
                            )
                    }
                      document.getElementById('loadingkatalog').style.display = "none"; 
                      // $("#item_no_oper").val(item_no_update);
                      $("#item_no2").val(item_no_update);
                  },
                  error: function( _response ){
                      swal(
                      'Terjadi kesalahan',
                      'Segera hubungi Admin!',
                      'error'
                      )
                  }
              });
      }

      function saveInspect(id){
        let no_is = $("#no_is_oper").val();
        document.getElementById('loadinginspect').style.display = "inline-block";
        let no_uruti_update = $("#no_uruti_update"+id).val();
        let nmi_is_update = $("#nmi_is_update"+id).val();
        let ketentuani_update = $("#ketentuani_update"+id).val();
        let metodei_update = $("#metodei_update"+id).val();
        let alati_update = $("#alati_update"+id).val();
        let waktui_update = $("#waktui_update"+id).val();
        let keterangani_update = $("#keterangani_update"+id).val();
        let selectaktifi_update = $("#selectaktifi_update"+id).val();
        let statusi_update = $("#statusi_update"+id).val();
        let _token = $('meta[name="csrf-token"]').attr('content');
          let url = "{{ route('updateinspect.mtcdpm') }}"
              $.ajax({
                  url      : url,
                  type     : 'POST',
                  dataType : 'json',
                  data     : {
                      no_uruti_update   : no_uruti_update,
                      nmi_is_update : nmi_is_update,
                      ketentuani_update : ketentuani_update,
                      metodei_update : metodei_update,
                      alati_update : alati_update,
                      waktui_update : waktui_update,
                      keterangani_update : keterangani_update,
                      selectaktifi_update : selectaktifi_update,
                      statusi_update : statusi_update,
                      no_is : no_is,
                      _token  : _token,
                  },
                  success: function( data ){
                      document.getElementById('loadinginspect').style.display = "none"; 
                      // $("#no_is").val(item_no_update);
                      // $("#item_no2").val(item_no_update);
                  },
                  error: function( _response ){
                      swal(
                      'Terjadi kesalahan',
                      'Segera hubungi Admin!',
                      'error'
                      )
                  }
              });
      }
      $('#tblMaster').on('click', 'tr', function () {
          $('#tblMaster tr').css("background-color", "white");
          $(this).css("background-color", "#eeeeee");
      });

      $('#lookupKatalog').on('click', 'tr', function () {
          $('#lookupKatalog tr').css("background-color", "white");
          $(this).css("background-color", "#eeeeee");
      });

      $('#lookupInspect').on('click', 'tr', function () {
          $('#lookupInspect tr').css("background-color", "white");
          $(this).css("background-color", "#eeeeee");
      });

      $("#deldashboard").on('click', function(e) {
        e.preventDefault();
            swal({ 
            text: "Apakah anda yakin menyetujui menghapus data item ini?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak, Batalkan!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: true
          }).then(function() {
            var no_dpm = $("#no_dpm").val();
            var _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
              type: "post",
              url: '{{ route('deldashboard.mtcdpm') }}',
              data: {
                no_dpm:no_dpm,
                _token:_token
              },
              success: function(data) {
                if(data['status'] == false){
                swal(
                      'Terjadi Kesalahan!',
                      data['pesan'],
                      'error'
                      )
              }
              $("#tampildata").trigger('click')
              },
              error: function(error) {
                swal('Warning!', 'Gagal!', 'error');
                }
              });
            
          }, function(dismiss) { 
            if (dismiss === 'cancel') {
              swal('Cancelled', 'Dibatalkan', 'error');
            }
          }) 

        });
  
</script>
@endsection