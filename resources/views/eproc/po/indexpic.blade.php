@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Approval PO PIC
        <small>Approval PO PIC</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> PROCUREMENT - TRANSAKSI - PO</li>
        <li class="active"><i class="fa fa-files-o"></i> Approval PO PIC</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      {!! Form::hidden('kode_sync', base64_encode('BAAN_PO'), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'kode_sync']) !!}
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Approval PO PIC</h3>
        </div>
        <!-- /.box-header -->
        
    		<div class="box-body form-horizontal">
    		  <div class="form-group">
    		    <div class="col-sm-2">
  		      	{!! Form::label('lblawal', 'Tgl Awal') !!}
  		      	{!! Form::date('filter_tgl_awal', \Carbon\Carbon::now()->startOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Awal', 'id' => 'filter_tgl_awal']) !!}
    		    </div>
    		    <div class="col-sm-2">
  		      	{!! Form::label('lblakhir', 'Tgl Akhir') !!}
  		      	{!! Form::date('filter_tgl_akhir', \Carbon\Carbon::now()->endOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Akhir', 'id' => 'filter_tgl_akhir']) !!}
    		    </div>
    		  </div>
    		  <!-- /.form-group -->
          <div class="form-group">
            <div class="col-sm-2">
              {!! Form::label('lblsite', 'Site') !!}
              <select name="filter_site" aria-controls="filter_status" class="form-control select2">
                <option value="ALL" selected="selected">ALL</option>
                <option value="IGPJ">IGP - JAKARTA</option>
                <option value="IGPK">IGP - KARAWANG</option>
              </select>
            </div>
            <div class="col-sm-2">
              {!! Form::label('lbldep', 'Departemen') !!}
              <select name="filter_dep" aria-controls="filter_status" class="form-control select2">
                <option value="ALL" selected="selected">ALL</option>
                @foreach($deps->get() as $dep)
                  <option value="{{$dep->kd_dep}}">{{$dep->nm_dep}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-2">
              {!! Form::label('lblusername2', 'Action') !!}
              <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
            </div>
            <div class="col-sm-2">
              {!! Form::label('lblusername3', 'Sync') !!}
              <button id="btn-sync" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Sinkronisasi (BAAN to IGPro)"><span class="glyphicon glyphicon-refresh"></span> Sinkronisasi (BAAN to IGPro)</button>
            </div>
          </div>
          <!-- /.form-group -->
    		</div>
    		<!-- /.box-body -->

        <div class="box-body">
          <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="width: 1%;">No</th>
                <th style="width: 10%;">No. PO</th>
                <th style="width: 10%;">Tgl PO</th>
                <th style="width: 25%;">Supplier</th>
                <th style="width: 11%;">Mata Uang</th>
                <th>Ref A</th>
                <th style="width: 8%;">Revisi</th>
                <th style="width: 10%;">Action</th>
                <th>Pembuat PO</th>
                <th>Jenis PO</th>
                <th>Approve PIC</th>
                <th>Reject PIC</th>
                <th>Approve Section</th>
                <th>Reject Section</th>
                <th>Approve Dep Head</th>
                <th>Reject Dep Head</th>
                <th>Approve Div Head</th>
                <th>Reject Div Head</th>
                <th>Status Tampil</th>
                <th>PIC Print</th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- /.box-body -->

        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><p id="info-detail">Detail</p></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <table id="tblDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th style="width: 1%;">No</th>
                        <th style="width: 5%;">PONO</th>
                        <th style="width: 10%;">No PP</th>
                        <th style="width: 15%;">Item No</th>
                        <th>Description</th>
                        <th style="width: 10%;">Qty PO</th>
                        <th style="width: 5%;">Satuan</th>
                        <th style="width: 12%;">Harga Unit</th>
                        <th style="width: 12%;">Jumlah</th>
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
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  //Initialize Select2 Elements
  $(".select2").select2();

  $("#btn-sync").click(function(){

    var monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    var date_awal = new Date($('input[name="filter_tgl_awal"]').val());
    var tgl_awal;
    if(date_awal.getDate() < 10) {
      tgl_awal = "0" + date_awal.getDate();
    } else {
      tgl_awal = date_awal.getDate();
    }
    var periode_awal_name = tgl_awal + " " + monthNames[date_awal.getMonth()] + " " + date_awal.getFullYear();
    var periode_awal;
    if((date_awal.getMonth() + 1) < 10) {
      periode_awal = date_awal.getFullYear() + "0" + (date_awal.getMonth() + 1) + "" + tgl_awal;
    } else {
      periode_awal = date_awal.getFullYear() + "" + (date_awal.getMonth() + 1) + "" + tgl_awal;
    }

    var date_akhir = new Date($('input[name="filter_tgl_akhir"]').val());
    var tgl_akhir;
    if(date_akhir.getDate() < 10) {
      tgl_akhir = "0" + date_akhir.getDate();
    } else {
      tgl_akhir = date_akhir.getDate();
    }
    var periode_akhir_name = tgl_akhir + " " + monthNames[date_akhir.getMonth()] + " " + date_akhir.getFullYear();
    var periode_akhir;
    if((date_akhir.getMonth() + 1) < 10) {
      periode_akhir = date_akhir.getFullYear() + "0" + (date_akhir.getMonth() + 1) + "" + tgl_akhir;
    } else {
      periode_akhir = date_akhir.getFullYear() + "" + (date_akhir.getMonth() + 1) + "" + tgl_akhir;
    }

    if(periode_awal != periode_akhir) {
      swal("Tgl Awal harus sama dengan Tgl Akhir!", "Perhatikan inputan anda!", "error");
    } else {
      var msg = "Anda yakin Sinkronisasi data PO Tgl: " + periode_awal_name + " s/d " + periode_akhir_name + "?";
      var txt = "";
      swal({
        title: msg,
        text: txt,
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, sync it!',
        cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
        allowOutsideClick: true,
        allowEscapeKey: true,
        allowEnterKey: true,
        reverseButtons: false,
        focusCancel: true,
      }).then(function () {
        var kode_sync = document.getElementById("kode_sync").value;
        var urlRedirect = "{{ route('syncs.tiga', ['param','param2','param3']) }}";
        urlRedirect = urlRedirect.replace('param3', window.btoa(periode_akhir));
        urlRedirect = urlRedirect.replace('param2', window.btoa(periode_awal));
        urlRedirect = urlRedirect.replace('param', kode_sync);
        window.location.href = urlRedirect;
      }, function (dismiss) {
        if (dismiss === 'cancel') {
          //
        }
      })
    }
  });

  function approvepic(no_po)
  {
    var msg = 'Anda yakin APPROVE (PIC) No. PO ' + no_po + '?';
    //additional input validations can be done hear
    swal({
      title: msg,
      text: "",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, approve it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      swal({
        title: 'Upload File',
        html:
          '<select class="form-control select2" required="required" id="swal-input" name="swal-input"><option selected="selected" value="">Pilih Jenis PO</option><option value="REGULER">REGULER</option><option value="REPEAT">REPEAT</option></select><BR>' +
          '<label>File 1: PP Instruction</label><br><input name="lok_file1" type="file" id="lok_file1"><br>' + 
          '<label>File 2: Quotation 1</label><br><input name="lok_file2" type="file" id="lok_file2"><br>' + 
          '<label>File 3: Quotation 2</label><br><input name="lok_file3" type="file" id="lok_file3"><br>' + 
          '<label>File 4: Quotation 3</label><br><input name="lok_file4" type="file" id="lok_file4"><br>' + 
          '<label>File 5: Drawing</label><br><input name="lok_file5" type="file" id="lok_file5">',
        showCancelButton: true,
        preConfirm: function () {
          return new Promise(function (resolve, reject) {
            if ($('#swal-input').val()) {
              if ($('#lok_file1').val()) {
                resolve([
                  document.getElementById("lok_file1").files[0],
                  document.getElementById("lok_file2").files[0],
                  document.getElementById("lok_file3").files[0],
                  document.getElementById("lok_file4").files[0],
                  document.getElementById("lok_file5").files[0],
                  $('#swal-input').val()
                ])
              } else {
                reject('File PP Instruction tidak boleh kosong!')
              }
            } else {
              reject('Jenis PO tidak boleh kosong!')
            }
          })
        }
      }).then(function (result) {

        var token = document.getElementsByName('_token')[0].value.trim();

        var formData = new FormData();
        formData.append('_method', 'POST');
        formData.append('_token', token);
        formData.append('no_po', window.btoa(no_po));
        formData.append('file_1', result[0]);
        formData.append('file_2', result[1]);
        formData.append('file_3', result[2]);
        formData.append('file_4', result[3]);
        formData.append('file_5', result[4]);
        formData.append('jns_po', result[5]);

        var url = "{{ route('baanpo1s.approvepic')}}";
        $("#loading").show();
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : formData,
          cache: false,
          contentType: false,
          processData: false,
          success:function(data){
            $("#loading").hide();
            if(data.status === 'OK'){
              swal("Approved", data.message, "success");
              var table = $('#tblMaster').DataTable();
              table.ajax.reload(null, false);
            } else {
              swal("Cancelled", data.message, "error");
            }
          }, error:function(){ 
            $("#loading").hide();
            swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");
          }
        });
      }).catch(swal.noop)
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

  function revisipic(no_po)
  {
    var msg = 'Anda yakin membuat REVISI untuk No. PO ' + no_po + '?';
    //additional input validations can be done hear
    swal({
      title: msg,
      text: "",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, revisi it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      swal({
        title: 'Input Keterangan Revisi',
        input: 'textarea',
        showCancelButton: true,
        inputValidator: function (value) {
          return new Promise(function (resolve, reject) {
            if (value) {
              if(value.length > 500) {
                reject('Keterangan Revisi Max 500 Karakter!')
              } else {
                resolve()
              }
            } else {
              reject('Keterangan Revisi tidak boleh kosong!')
            }
          })
        }
      }).then(function (resultRevisi) {
        swal({
          title: 'Upload File',
          html:
            '<select class="form-control select2" required="required" id="swal-input" name="swal-input"><option selected="selected" value="">Pilih Jenis PO</option><option value="REGULER">REGULER</option><option value="REPEAT">REPEAT</option></select><BR>' +
            '<label>File 1: PP Instruction</label><br><input name="lok_file1" type="file" id="lok_file1"><br>' + 
            '<label>File 2: Quotation 1</label><br><input name="lok_file2" type="file" id="lok_file2"><br>' + 
            '<label>File 3: Quotation 2</label><br><input name="lok_file3" type="file" id="lok_file3"><br>' + 
            '<label>File 4: Quotation 3</label><br><input name="lok_file4" type="file" id="lok_file4"><br>' + 
            '<label>File 5: Drawing</label><br><input name="lok_file5" type="file" id="lok_file5">',
          showCancelButton: true,
          preConfirm: function () {
            return new Promise(function (resolve, reject) {
              if ($('#swal-input').val()) {
                if ($('#lok_file1').val()) {
                  resolve([
                    document.getElementById("lok_file1").files[0],
                    document.getElementById("lok_file2").files[0],
                    document.getElementById("lok_file3").files[0],
                    document.getElementById("lok_file4").files[0],
                    document.getElementById("lok_file5").files[0],
                    $('#swal-input').val()
                  ])
                } else {
                  reject('File PP Instruction tidak boleh kosong!')
                }
              } else {
                reject('Jenis PO tidak boleh kosong!')
              }
            })
          }
        }).then(function (result) {

          var token = document.getElementsByName('_token')[0].value.trim();

          var formData = new FormData();
          formData.append('_method', 'POST');
          formData.append('_token', token);
          formData.append('no_po', window.btoa(no_po));
          formData.append('ket_revisi', resultRevisi);
          formData.append('file_1', result[0]);
          formData.append('file_2', result[1]);
          formData.append('file_3', result[2]);
          formData.append('file_4', result[3]);
          formData.append('file_5', result[4]);
          formData.append('jns_po', result[5]);

          var url = "{{ route('baanpo1s.revisipic')}}";
          $("#loading").show();
          $.ajax({
            type     : 'POST',
            url      : url,
            dataType : 'json',
            data     : formData,
            cache: false,
            contentType: false,
            processData: false,
            success:function(data){
              $("#loading").hide();
              if(data.status === 'OK'){
                swal("Revised", data.message, "success");
                var table = $('#tblMaster').DataTable();
                table.ajax.reload(null, false);
              } else {
                swal("Cancelled", data.message, "error");
              }
            }, error:function(){ 
              $("#loading").hide();
              swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");
            }
          });
        }).catch(swal.noop)
      }).catch(swal.noop)
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

  $(document).ready(function(){

    var tableMaster = $('#tblMaster').DataTable({
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
      "order": [[2, 'asc'],[1, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('baanpo1s.dashboardpic') }}",
      columns: [
        {data: null, name: null, className: "dt-center"},
        {data: 'no_po', name: 'no_po'},
        {data: 'tgl_po', name: 'tgl_po', className: "dt-center"},
        {data: 'nm_supp', name: 'nm_supp'},
        {data: 'kd_curr', name: 'kd_curr', className: "dt-center"},
        {data: 'refa', name: 'refa'},
        {data: 'no_revisi', name: 'no_revisi', className: "dt-center", orderable: false, searchable: false},
        {data: 'action', name: 'action', orderable: false, searchable: false},
        {data: 'usercreate', name: 'usercreate', className: "none", orderable: false, searchable: false},
        {data: 'jns_po', name: 'jns_po', className: "none", orderable: false, searchable: false},
        {data: 'apr_pic_npk', name: 'apr_pic_npk', className: "none", orderable: false, searchable: false},
        {data: 'rjt_pic_npk', name: 'rjt_pic_npk', className: "none", orderable: false, searchable: false},
        {data: 'apr_sh_npk', name: 'apr_sh_npk', className: "none", orderable: false, searchable: false},
        {data: 'rjt_sh_npk', name: 'rjt_sh_npk', className: "none", orderable: false, searchable: false},
        {data: 'apr_dep_npk', name: 'apr_dep_npk', className: "none", orderable: false, searchable: false},
        {data: 'rjt_dep_npk', name: 'rjt_dep_npk', className: "none", orderable: false, searchable: false},
        {data: 'apr_div_npk', name: 'apr_div_npk', className: "none", orderable: false, searchable: false},
        {data: 'rjt_div_npk', name: 'rjt_div_npk', className: "none", orderable: false, searchable: false},
        {data: 'st_tampil', name: 'st_tampil', className: "none", orderable: false, searchable: false}, 
        {data: 'print_supp_pic', name: 'print_supp_pic', className: "none", orderable: false, searchable: false}
      ],
    });

    $('#tblMaster tbody').on( 'click', 'tr', function () {
      if ($(this).hasClass('selected') ) {
        $(this).removeClass('selected');
        document.getElementById("info-detail").innerHTML = 'Detail PO';
        initTable(window.btoa('-'));
      } else {
        tableMaster.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        if(tableMaster.rows().count() > 0) {
          var index = tableMaster.row('.selected').index();
          var no_po = tableMaster.cell(index, 1).data();
          document.getElementById("info-detail").innerHTML = 'Detail PO (' + no_po + ')';
          var regex = /(<([^>]+)>)/ig;
          initTable(window.btoa(no_po.replace(regex, "")));
        }
      }
    });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.awal = $('input[name="filter_tgl_awal"]').val();
      data.akhir = $('input[name="filter_tgl_akhir"]').val();
      data.kd_site = $('select[name="filter_site"]').val();
      data.kd_dep = $('select[name="filter_dep"]').val();
    });

    var url = '{{ route('baanpo1s.detail', ['param','param2']) }}';
    url = url.replace('param2', window.btoa("O"));
    url = url.replace('param', window.btoa("-"));
    var tableDetail = $('#tblDetail').DataTable({
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
      "order": [[1, 'asc'],[2, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
        { data: null, name: null, className: "dt-center"},
        { data: 'pono_po', name: 'pono_po', className: "dt-center"},
        { data: 'no_pp', name: 'no_pp'},
        { data: 'item_no', name: 'item_no'},
        { data: 'item_name', name: 'item_name'},
        { data: 'qty_po', name: 'qty_po', className: "dt-right"},
        { data: 'unit', name: 'unit', className: "dt-center"},
        { data: 'hrg_unit', name: 'hrg_unit', className: "dt-right"},
        { data: 'jumlah', name: 'jumlah', className: "dt-right"}
      ],
    });

    function initTable(data) {
      tableDetail.search('').columns().search('').draw();
      var url = '{{ route('baanpo1s.detail', ['param','param2']) }}';
      url = url.replace('param2', window.btoa("O"));
      url = url.replace('param', data);
      tableDetail.ajax.url(url).load();
    }

    $('#display').click( function () {
      document.getElementById("info-detail").innerHTML = 'Detail PO';
      tableMaster.ajax.reload( function ( json ) {
        if(tableMaster.rows().count() > 0) {
          $('#tblMaster tbody tr:eq(0)').click(); 
        } else {
          initTable(window.btoa('-'));
        }
      });
    });

    $('#display').click();
  });
</script>
@endsection