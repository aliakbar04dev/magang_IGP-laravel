@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ijin Kerja
        <small>Daftar Ijin Kerja</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> EHS - Transaksi</li>
        <li class="active"><i class="fa fa-files-o"></i> Ijin Kerja</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
    		<div class="box-body form-horizontal">
    		  <div class="form-group">
    		    <div class="col-sm-2">
  		      	{!! Form::label('lblawal', 'Tgl Awal') !!}
  		      	{!! Form::date('filter_status_awal', \Carbon\Carbon::now()->startOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Awal', 'id' => 'filter_status_awal']) !!}
    		    </div>
    		    <div class="col-sm-2">
  		      	{!! Form::label('lblakhir', 'Tgl Akhir') !!}
  		      	{!! Form::date('filter_status_akhir', \Carbon\Carbon::now()->endOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Akhir', 'id' => 'filter_status_akhir']) !!}
    		    </div>
    		    <div class="col-sm-2">
  		      	{!! Form::label('lblstatus', 'Status') !!}
  		      	<select name="filter_status_status" aria-controls="filter_status" class="form-control select2">
	              <option value="ALL" selected="selected">ALL</option>
                {{-- <option value="DRAFT">DRAFT</option> --}}
                <option value="SUBMIT">SUBMIT</option>
                <option value="APPROVE">APPROVE</option>
                <option value="REJECT">REJECT</option>
                <option value="PRC">APPROVE PRC</option>
                <option value="RPRC">REJECT PRC</option>
                <option value="USER">APP. PRO. OWNER</option>
                <option value="RUSER">REJECT PRO. OWNER</option>
                <option value="EHS">APPROVE EHS</option>
                <option value="REHS">REJECT EHS</option>
                <option value="SCAN_IN">SCAN IN SECURITY</option>
                <option value="SCAN_OUT">SCAN OUT SECURITY</option>
  	          </select>
    		    </div>
    		  </div>
    		  <!-- /.form-group -->
    		  <div class="form-group">
    		    <div class="col-sm-4">
  		      	{!! Form::label('lblsupplier', 'Supplier') !!}
  		      	<select name="filter_status_supplier" aria-controls="filter_status" class="form-control select2">
              	@if (strlen(Auth::user()->username) <= 5)
              		<option value="ALL" selected="selected">Semua</option>
  			        @endif
  			        @foreach ($suppliers->get() as $supplier)
		            	<option value={{ $supplier->kd_supp }}>{{ $supplier->nama.' - '.$supplier->kd_supp }}</option>
  		          @endforeach
  		       	</select>
    		    </div>
            <div class="col-sm-2">
              {!! Form::label('lblusername2', ' ') !!}
              <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
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
                <th style="width: 8%;">No. WP</th>
                <th style="width: 5%;">Tgl WP</th>
                <th style="width: 8%;">No. PP</th>
                <th>Site</th>
                <th>Status PO</th>
                <th>No. PO</th>
                <th style="width: 20%;">Nama Proyek</th>
                <th>No. Revisi</th>
                <th>Lokasi Proyek</th>
                <th>PIC</th>
                <th>Tgl Pelaksanaan</th>
                <th>Perpanjangan</th>
                <th>Jam</th>
                <th>Kategori Pekerjaan</th>
                <th>Keterangan</th>
                <th>Alat yg digunakan</th>
                <th>Jenis Pekerjaan</th>
                <th>Creaby</th>
                <th>Modiby</th>
                <th>Submitted</th>
                <th>Tgl Expired</th>
                <th>Tgl Close</th>
                <th>Pic Close</th>
                <th>Scan IN Security</th>
                <th>Scan OUT Security</th>
                <th style="width: 12%;">Status</th>
                <th style="width: 10%;">Action</th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <p>
            <a target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Download User Guide" href="{{ route('ehstwp1s.userguide') }}"><span class="fa fa-book"></span> Download User Guide</a>
          </p>
        </div>
        <!-- /.box-footer -->
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

  function approveIjinKerja(id, no_wp, pic_pp, nm_pic, status)
  {
    var no_wp = window.atob(no_wp);
    var pic_pp = window.atob(pic_pp);
    var nm_pic = window.atob(nm_pic);
    var msg = 'Anda yakin APPROVE data ini?';
    var txt = 'No. WP: ' + no_wp;
    if(status === "PRC") {
      msg = 'Anda yakin APPROVE No. WP: ' + no_wp + '?';
      //additional input validations can be done hear
      swal({
        title: msg, 
        html:
          'PIC saat ini: ' + pic_pp + ' - ' + nm_pic + '<BR>' +
          '<select class="form-control select2" required="required" id="swal-input1" name="swal-input1">' +
            '<option value="-">Pilih PIC jika Anda ingin mengubah PIC saat ini</option>' +
            @foreach($ehsmwppics->get() as $ehsmwppic)
              '<option value="{{$ehsmwppic->npk}}">{{ $ehsmwppic->nama }} - {{ $ehsmwppic->npk }} - {{ $ehsmwppic->bagian }}</option>' +
            @endforeach
          '</select>',
        preConfirm: function () {
          return new Promise(function (resolve, reject) {
            resolve([
              $('#swal-input1').val()
            ])
          })
        }
      }).then(function (result) {
        if(result[0] == null || result[0] == "") {
          result[0] = "-";
        }
        var token = document.getElementsByName('_token')[0].value.trim();
        // save via ajax
        // create data detail dengan ajax
        var url = "{{ route('ehstwp1s.approve')}}";
        $("#loading").show();
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method      : 'POST',
            // menambah csrf token dari Laravel
            _token       : token,
            id           : id,
            status       : window.btoa(status),
            new_pic      : window.btoa(result[0]),
          },
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
    } else if(status === "EHS") {
      //additional input validations can be done hear
      swal({
        title: msg,
        text: txt,
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
          title: 'APD / Peralatan yang wajib dibawa',
          html:
            '<select class="form-control select2" required="required" id="swal-input4" name="swal-input4"><option selected="selected" value="">Pilih Jenis Pekerjaan</option><option value="H">High Risk</option><option value="M">Medium Risk</option><option value="L">Low Risk</option></select><BR>' +
            '<select multiple class="form-control" id="swal-input1" name="swal-input1" style="height: 180px">' +
              '<option value="Helmet">1. Helmet</option>' +
              '<option value="Topi">2. Topi</option>' +
              '<option value="Full Body Hardness 2 Hock">3. Full Body Hardness 2 Hock</option>' +
              '<option value="Kacamata Safety / Welding Face">4. Kacamata Safety / Welding Face</option>' +
              '<option value="Masker Biasa / Respirator">5. Masker Biasa / Respirator</option>' +
              '<option value="Sarung Tangan (Katun/Kulit/Karet)">6. Sarung Tangan (Katun/Kulit/Karet)</option>' +
              '<option value="Sepatu Safety / Biasa">7. Sepatu Safety / Biasa</option>' +
              '<option value="Tanda Peringatan / Petunjuk">8. Tanda Peringatan / Petunjuk</option>' +
              '<option value="Partisi / Karung Basah / Cover">9. Partisi / Karung Basah / Cover</option>' +
            '</select><br>' + 
            '<textarea id="swal-input2" class="form-control" maxlength="300" rows="3" cols="20" placeholder="10. Alat Pemadam Kebakaran\nAPAR jenis ... jumlah ... buah (Max. 300 Karakter)" style="resize:vertical"></textarea><br>' + 
            '<textarea id="swal-input3" class="form-control" maxlength="300" rows="3" cols="20" placeholder="11. Dll. (Alat Kebersihan/Breathing Aparatus/Tali) (Max. 300 Karakter)" style="resize:vertical"></textarea>',
          preConfirm: function () {
            return new Promise(function (resolve, reject) {
              if ($('#swal-input4').val()) {
                resolve([
                  $('#swal-input1').val(),
                  $('#swal-input2').val(),
                  $('#swal-input3').val(),
                  $('#swal-input4').val()
                ])
              } else {
                reject('Jenis Pekerjaan tidak boleh kosong!')
              }
            })
          }
        }).then(function (result) {
          if(result[0] == null || result[0] == "") {
            result[0] = "-";
          }
          if(result[1] == null || result[1] == "") {
            result[1] = "-";
          }
          if(result[2] == null || result[2] == "") {
            result[2] = "-";
          }
          if(result[3] == null || result[3] == "") {
            result[3] = "L";
          }
          var token = document.getElementsByName('_token')[0].value.trim();
          // save via ajax
          // create data detail dengan ajax
          var url = "{{ route('ehstwp1s.approveehs')}}";
          $("#loading").show();
          $.ajax({
            type     : 'POST',
            url      : url,
            dataType : 'json',
            data     : {
              _method      : 'POST',
              // menambah csrf token dari Laravel
              _token        : token,
              id            : id,
              status        : window.btoa(status),
              apd1          : window.btoa(result[0]),
              apd2          : window.btoa(result[1]),
              apd3          : window.btoa(result[2]),
              jns_pekerjaan : window.btoa(result[3]),
            },
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
    } else {
      //additional input validations can be done hear
      swal({
        title: msg,
        text: txt,
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
        var token = document.getElementsByName('_token')[0].value.trim();
        // save via ajax
        // create data detail dengan ajax
        var url = "{{ route('ehstwp1s.approve')}}";
        $("#loading").show();
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method      : 'POST',
            // menambah csrf token dari Laravel
            _token       : token,
            id           : id,
            status       : window.btoa(status),
            new_pic      : window.btoa("-"),
          },
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

  function rejectIjinKerja(id, no_wp, status)
  {
    var no_wp = window.atob(no_wp);
    var msg = 'Anda yakin REJECT data ini?';
    var txt = 'No. WP: ' + no_wp;
    //additional input validations can be done hear
    swal({
      title: msg,
      text: txt,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, reject it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      swal({
        title: 'Input Keterangan Reject',
        html:
          '<select class="form-control select2" required="required" id="swal-input1" name="swal-input1"><option selected="selected" value="">Pilih Status</option><option value="S">Request Supplier</option><option value="O">Others</option></select><BR>' +
          '<textarea id="swal-input2" class="form-control" maxlength="500" rows="3" cols="20" placeholder="Keterangan Reject (Max. 500 Karakter)" style="text-transform:uppercase;resize:vertical">',
        preConfirm: function () {
          return new Promise(function (resolve, reject) {
            if ($('#swal-input1').val()) {
              if ($('#swal-input2').val()) {
                if($('#swal-input2').val().length > 500) {
                  reject('Keterangan Reject Max 500 Karakter!')
                } else {
                  resolve([
                    $('#swal-input1').val(),
                    $('#swal-input2').val()
                  ])
                }
              } else {
                reject('Keterangan Reject tidak boleh kosong!')
              }
            } else {
              reject('Status Reject tidak boleh kosong!')
            }
          })
        }
      }).then(function (result) {
        var token = document.getElementsByName('_token')[0].value.trim();
        // save via ajax
        // create data detail dengan ajax
        var url = "{{ route('ehstwp1s.reject')}}";
        $("#loading").show();
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method      : 'POST',
            // menambah csrf token dari Laravel
            _token       : token,
            id           : id,
            status       : window.btoa(status),
            keterangan   : window.btoa(result[1]),
            reject_st    : window.btoa(result[0]),
          },
          success:function(data){
            $("#loading").hide();
            if(data.status === 'OK'){
              swal("Rejected", data.message, "success");
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
      // "searching": false,
      // "scrollX": true,
      // "scrollY": "700px",
      // "scrollCollapse": true,
      // "paging": false,
      // "lengthChange": false,
      // "ordering": true,
      // "info": true,
      // "autoWidth": false,
      "order": [[2, 'desc'],[1, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('dashboardall.ehstwp1s') }}",
      columns: [
        {data: null, name: null},
        {data: 'no_wp', name: 'no_wp'},
        {data: 'tgl_wp', name: 'tgl_wp'},
        {data: 'no_pp', name: 'no_pp'},
        {data: 'kd_site', name: 'kd_site', className: "none", orderable: false, searchable: false},
        {data: 'status_po', name: 'status_po', className: "none", orderable: false, searchable: false},
        {data: 'no_po', name: 'no_po', className: "none"},
        {data: 'nm_proyek', name: 'nm_proyek'},
        {data: 'no_rev', name: 'no_rev', className: "none"},
        {data: 'lok_proyek', name: 'lok_proyek', className: "none"},
        {data: 'pic_pp', name: 'pic_pp', className: "none"},
        {data: 'tgl_laksana1', name: 'tgl_laksana1', className: "none"},
        {data: 'no_perpanjang', name: 'no_perpanjang', className: "none"},
        {data: 'jam_laksana', name: 'jam_laksana', className: "none"},
        {data: 'kat_kerja', name: 'kat_kerja', className: "none", orderable: false, searchable: false},
        {data: 'kat_kerja_ket', name: 'kat_kerja_ket', className: "none"},
        {data: 'alat_pakai', name: 'alat_pakai', className: "none"},
        {data: 'jns_pekerjaan', name: 'jns_pekerjaan', className: "none", orderable: false, searchable: false},
        {data: 'creaby', name: 'creaby', className: "none"},
        {data: 'modiby', name: 'modiby', className: "none"},
        {data: 'submit_tgl', name: 'submit_tgl', className: "none"},
        {data: 'tgl_expired', name: 'tgl_expired', className: "none"},
        {data: 'tgl_close', name: 'tgl_close', className: "none"},
        {data: 'pic_close', name: 'pic_close', className: "none"},
        {data: 'scan_sec_in_npk', name: 'scan_sec_in_npk', className: "none", orderable: false, searchable: false},
        {data: 'scan_sec_out_npk', name: 'scan_sec_out_npk', className: "none", orderable: false, searchable: false},
        {data: 'status', name: 'status'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
      ]
    });

    $(function() {
      $('\
        <div id="filter_site" class="dataTables_length" style="display: inline-block; margin-left:10px;">\
          <label>Site\
          <select size="1" name="filter_site" aria-controls="filter_status" \
            class="form-control select2" style="width: 150px;">\
              <option value="ALL" selected="selected">ALL</option>\
              <option value="IGPJ">IGP - JAKARTA</option>\
              <option value="IGPK">IGP - KARAWANG</option>\
            </select>\
          </label>\
        </div>\
      ').insertAfter('.dataTables_length');

      $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
        data.site = $('select[name="filter_site"]').val();
        data.awal = $('input[name="filter_status_awal"]').val();
        data.akhir = $('input[name="filter_status_akhir"]').val();
        data.status = $('select[name="filter_status_status"]').val();
        data.supplier = $('select[name="filter_status_supplier"]').val();
      });

      $('select[name="filter_site"]').change(function() {
        tableMaster.ajax.reload();
      });
    });

    $('#display').click( function () {
      tableMaster.ajax.reload();
    });

    $('#display').click();
  });
</script>
@endsection