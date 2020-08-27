@extends('layouts.app')
@section('content')
<style>
  /* css zoomgambar */

  .zoomgambar {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
  width:100px;
  height: 60px;
}

.zoomgambar:hover {opacity: 0.7;}

/* The Modal (background) */
.modal2 {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index:9999; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content2 {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  padding-bottom: 100px;
}

/* Caption of Modal Image */

/* Add Animation */
.modal-content2 {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
  
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close2 {
  position: absolute;
  top: 60px;
  right: 230px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close2:hover,
.close2:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content2 {
    width: 100%;
  }
}
/* end css zoom gambar */
  
  .container {
    background: #ff851b;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    overflow: hidden;
    text-align: center;
    width: 70px;
    min-height: 70px;
  }

  .checkbox-container {
    display: inline-block;
    position: relative;
  }

  .checkbox-container label {
    background-color: #ff851b;
    border: 1px solid #fff;
    border-radius: 20px;
    display: inline-block;
    position: relative;
    transition: all 0.3s ease-out;
    width: 45px;
    height: 25px;
    z-index: 2;
  }

  .checkbox-container label::after {
    content: ' ';
    background-color: #fff;
    border-radius: 50%;
    position: absolute;
    top: 1.5px;
    left: 1px;
    transform: translateX(0);
    transition: transform 0.3s linear;
    width: 20px;
    height: 20px;
    z-index: 3;
  }

  .checkbox-container input {
    visibility: hidden;
    position: absolute;
    z-index: 2;
  }

  .checkbox-container input:checked+label+.active-circle {
    transform: translate(-50%, -50%) scale(15);
  }

  .checkbox-container input:checked+label::after {
    transform: translateX(calc(100% + 0.5px));
  }

  .active-circle {
    border-radius: 50%;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(calc(-50% - 10px), calc(-50% - 2px)) scale(0);
    transition: transform 0.6s ease-out;
    width: 30px;
    height: 30px;
    z-index: 1;
  }

  .checkbox-container.green .active-circle,
  .checkbox-container.green input:checked+label {
    background-color: #00a65a;
  }

  .checkbox-container.yellow .active-circle,
  .checkbox-container.yellow input:checked+label {
    background-color: #ff851b;
  }

  .checkbox-container.purple .active-circle,
  .checkbox-container.purple input:checked+label {
    background-color: #605ca8;
  }


  
  /* css spin menyimpan */
  .textarea_col {
    margin-bottom: 30px;
  }

  .form-control[disabled],
  .form-control[readonly],
  fieldset[disabled] .form-control {
    background-color: #fff;
  }

  textarea {
    resize: none;
  }

  label.header {
    display: block;
    margin-bottom: 0px;
    text-align: center;
    background-color: #f7644c;
    color: white;
    border-radius: 2px 2px 0px 0px;
    padding-bottom: 5px;
    padding-top: 5px;
    font-weight: 600;
  }

  textarea {
    display: block;
  }

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
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  input[readonly] {
    background-color: #f6f6f6 !important;
  }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Daftar Masalah Alat Angkut
      <small>Daftar Masalah</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><i class="fa fa-files-o"></i> Transaksi</li>
      <li class="active"><i class="fa fa-files-o"></i> Daftar Masalah Alat Angkut</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- /.box-header -->
          <div class="box-body form-horizontal">
            <div class="form-group">
              <div class="col-sm-3">
                {!! Form::label('tgl_awal', 'Tanggal Awal') !!}
                {!! Form::date('tgl_awal', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Awal',
                'id' => 'tgl_awal']) !!}
              </div>
              <div class="col-sm-3">
                {!! Form::label('tgl_akhir', 'Tanggal Akhir') !!}
                {!! Form::date('tgl_akhir', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl
                Akhir', 'id' => 'tgl_akhir']) !!}
              </div>
            </div>
            <!-- /.form-group -->
            <div class="form-group">
              <div class="col-sm-3">
                {!! Form::label('kd_unit', 'Kode Unit (F9)') !!}
                <div class="input-group">
                  @if (isset($kd_unit))
                  {!! Form::text('kd_unit', $kd_unit, ['class'=>'form-control','placeholder' => 'Kode Unit', 'maxlength'
                  => 10, 'id' => 'kd_unit']) !!}
                  @else
                  {!! Form::text('kd_unit', null, ['class'=>'form-control','placeholder' => 'Kode Unit', 'maxlength' =>
                  10, 'id' => 'kd_unit']) !!}
                  @endif
                  <span class="input-group-btn">
                    <button id="btnpopupunit" type="button" class="btn btn-info" data-toggle="modal"
                      data-target="#unitModal">
                      <span class="glyphicon glyphicon-search"></span>
                    </button>
                  </span>
                </div>
              </div>
              <div class="col-sm-3">
                {!! Form::label('display', 'Action') !!}
                <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip"
                  data-placement="top" title="Display">Display</button>
              </div>
              @permission(['mtc-dmaa-close'])
              <div class="col-sm-3">
                {!! Form::label('close', 'Pilih yang mau di close, lalu klik') !!}
                <button id="close" type="button" class="form-control btn bg-purple" data-toggle="tooltip"
                  data-placement="top" title="Close">Close</button>
              </div>
              @endpermission
              <div class="col-sm-3" >
                {!! Form::label('reload', 'Refresh') !!}
                <br>
                <button class="form-control btn btn-sm btn-success reload" style="width:40px;"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
              </div>


            </div>
            <!-- /.form-group -->
          </div>
          <!-- /.box-body -->
          <div class="box-body">
            <div class="col-sm-12" style="padding:0;">
              {!! Form::label('keterangan', 'Keterangan Warna (Khusus Close)') !!}
              <br>
              <button id="keterangan" type="button" style="width:5px; height:5px;" class="form-control  btn btn-success"
                style="background-color:#F7D154;" data-toggle="tooltip" data-placement="top" title="Close"></button>
              Close belum tersimpan di database &nbsp;&nbsp;
              <button id="keterangan" type="button" style="width:5px; height:5px;" class="form-control btn bg-orange"
                data-toggle="tooltip" data-placement="top" title="Close"></button> Belum close &nbsp;&nbsp;
              <button id="keterangan" type="button" style="width:5px; height:5px;" class="form-control btn bg-purple"
                data-toggle="tooltip" data-placement="top" title="Close"></button> Close
                &nbsp;&nbsp;
                <div id="loading_icon" style="display: none;">
                <div class="loader" style="display: inline-block;margin-bottom: -5px;"></div> Menyimpan perubahan...
              </div>
            </div>
            <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th style="width: 1%;">No</th>
                  <th style="width: 5%;">Tgl Temuan</th>
                  <th style="width: 5%;">Kode Unit</th>
                  <th style="width: 10%;">Item Check</th>
                  <th style="width: 15%;">Uraian Masalah</th>
                  <th style="width: 150px;">Foto Ilustrasi</th>
                  <th style="width: 20%;">Last Progress</th>
                  <th style="width: 20%;">Maintenance Judgement</th>
                  <th style="width: 1%;">Close</th>
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
<!-- The Modal -->
<div id="modalgambar" class="modal2" >
    <span class="close2">&times;</span>
    <img class="modal-content2" id="img01">
</div>
@include('mtc.mtctmslhangkut.popup.unitModal')
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  $(document).ready(function () {
    $("#btnpopupline").click(function () {
      popupKdLine();
    });

    var url = '{{ route('dashboard.mtctmslhangkut', 'param') }}';
    url = url.replace('param', window.btoa("F"));

    var tableMaster = $('#tblMaster').DataTable({
      "columnDefs": [{
        "searchable": false,
        "orderable": false,
        "targets": 0,
        render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      }, {
        "targets": [7, 8],
        "createdCell": function (td, cellData, rowData, row, col) {
          $(td).css('padding', '0px')
        }
      },{
        "targets": [5],
        "createdCell": function (td, cellData, rowData, row, col) {
          $(td).css('padding', '5px')
        }
      }, ],
      "aLengthMenu": [
        [5, 10, 25, 50, 75, 100, -1],
        [5, 10, 25, 50, 75, 100, "All"]
      ],
      "iDisplayLength": 10,
      responsive: true,
      "order": [
        [2, 'desc'],
        [1, 'desc']
      ],
      processing: true,
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      },
      serverSide: true,
      ajax: url,
      columns: [{
          data: null,
          name: null
        },
        {
          data: 'tgl',
          name: 'tgl'
        },
        {
          data: 'kd_forklif',
          name: 'kd_forklif'
        },
        {
          data: 'nm_is',
          name: 'nm_is'
        },
        {
          data: 'uraian_masalah',
          name: 'uraian_masalah'
        },
        {
          data: 'pict_masalah',
          name: 'pict_masalah'
        },
        {
          data: 'ket_progress',
          name: 'ket_progress'
        },
        {
          data: 'st_blh_jln',
          name: 'st_blh_jln'
        },
        {
          data: 'action',
          name: 'action',
          orderable: false,
          searchable: false
        }
      ]
    });

    $("#tblMaster").on('preXhr.dt', function (e, settings, data) {
      data.tgl_awal = $('input[name="tgl_awal"]').val();
      data.tgl_akhir = $('input[name="tgl_akhir"]').val();
      data.kd_unit = $('input[name="kd_unit"]').val();
    });

    $('#display').click(function () {
      tableMaster.ajax.reload();
    });

    $("#btnpopupunit").click(function () {
      popupKdUnit();
    });

    $(".reload").on('click', function(e) {
       tableMaster.ajax.reload()
     });

    function popupKdUnit() {
      var myHeading = "<p>Popup Unit</p>";
      $("#unitModalLabel").html(myHeading);
      var url = '{{ route('datatables.popupUnits') }}';
      var lookupUnit = $('#lookupUnit').DataTable({
        processing: true,
        "oLanguage": {
          'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
        },
        serverSide: true,
        "pagingType": "numbers",
        ajax: url,
        "aLengthMenu": [
          [5, 10, 25, 50, 75, 100, -1],
          [5, 10, 25, 50, 75, 100, "All"]
        ],
        responsive: true,
        // "scrollX": true,
        // "scrollY": "500px",
        // "scrollCollapse": true,
        "order": [
          [1, 'asc']
        ],
        columns: [{
            data: 'kd_mesin',
            name: 'kd_mesin'
          },
          {
            data: 'nm_mesin',
            name: 'nm_mesin'
          },
          {
            data: 'maker',
            name: 'maker'
          },
          {
            data: 'mdl_type',
            name: 'mdl_type'
          },
          {
            data: 'mfd_thn',
            name: 'mfd_thn'
          }
        ],
        "bDestroy": true,
        "initComplete": function (settings, json) {
          // $('div.dataTables_filter input').focus();
          $('#lookupUnit tbody').on('dblclick', 'tr', function () {
            var dataArr = [];
            var rows = $(this);
            var rowData = lookupUnit.rows(rows).data();
            $.each($(rowData), function (key, value) {
              document.getElementById("kd_unit").value = value["kd_mesin"];
              $('#unitModal').modal('hide');
            });
          });
          $('#unitModal').on('hidden.bs.modal', function () {
            var kd_unit = document.getElementById("kd_unit").value.trim();
            if (kd_unit === '') {
              // document.getElementById("nm_unit").value = "";
              $('#form-group-foto').removeAttr('style');
              $('#form-group-foto').attr('style', 'display: none;');
              $('#lok_pict').removeAttr('src');
              $('#kd_unit').focus();
            } else {
              $('#btn-display').focus();
            }
          });
        },
      });
    }

  });

  function ubahWarna(data) {
    if ($('#selectst_blh_jln' + data + ' :selected').val() == "T") {
      $('#selectst_blh_jln' + data).css("background-color", '#00a65a');
    } else if ($('#selectst_blh_jln' + data + ' :selected').val() == "F") {
      $('#selectst_blh_jln' + data).css("background-color", 'red');
    } else {
      $('#selectst_blh_jln' + data).css("background-color", '#0575E6');
    }
  }

  function saveChange(data1, data2) {
    document.getElementById('loading_icon').style.display = "inline-block";
    var ket_progress = $('#selectket_progress' + data1 + data2).val();
    var mt_judge = $('#selectst_blh_jln' + data1 + data2).val();
    var mtct_lch_forklif1_id = data1;
    var no_is = data2;
    var _token = $('meta[name="csrf-token"]').attr('content');
    var url = "{{ route('mtctmslhangkut.update','test') }}"
    $.ajax({
      url: url,
      type: 'POST',
      dataType: 'json',
      data: {
        ket_progress: ket_progress,
        mt_judge: mt_judge,
        mtct_lch_forklif1_id: mtct_lch_forklif1_id,
        no_is: no_is,
        _token: _token,
        _method: 'PUT',
      },
      success: function (_response) {

        document.getElementById('loading_icon').style.display = "none";
      },
      error: function (_response) {
        swal(
          'Terjadi kesalahan',
          'Segera hubungi Admin!',
          'error'
        )
      }
    });
  }

  $('#close').on('click', function (e) {
    e.preventDefault();
    var a = [];
    var b = [];
    $("[name='chk[]']:checked").each(function () {
      a.push(this.value);
      b.push($(this).attr('data'));
    });
    if (a.length == 0) {
      swal(
        'Warning',
        'Silahkan Pilih Data yang ingin di close terlebih dahulu',
        'error'
      )
    } else {
            swal({ 
            text: "Apakah anda yakin mengclose data ini?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Close!',
            cancelButtonText: 'Tidak, Batalkan!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: true
          }).then(function() {
            var url = "{{ route('close.mtctmslhangkut')}}";
            var _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type     : 'POST',
                url      : url,
                dataType : 'json',
                data     : {
                  id:a.toString(),
                  no_is:b.toString(),
                  _token            : _token,
                },
                success:function(data){
                  // $("#loading").hide();
                  if(data['pesan'] === 'Sukses'){
                    $(".reload").trigger('click')
                  } else {
                    swal("Gagal!", 'Mohon coba lagi atau hubungi administrator', "info");
                  }
                  
                }, error:function(){ 
                  swal("Info!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "info");
                }
              });
            
          }, function(dismiss) { 
            if (dismiss === 'cancel') {
              swal('Cancelled', 'Dibatalkan', 'error');
            }
          }) 

        }

        

      
  });

  function zoomGambar(id){
          // js modal gambar
        // Get the modal
        var modal = document.getElementById("modalgambar");

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        // var img = document.getElementsByClassName("zoomgambar");
        var modalImg = document.getElementById('img01');
        $('.zoomgambar').on('click', function (e) {
          modal.style.display = "block";
          modalImg.src = this.src;
        });

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close2")[0];

        // When the user clicks on <span> (x), close the modal
            $('span').on('click', function (e) {
          modal.style.display = "none";
})
        }
</script>
@endsection