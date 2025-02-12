@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Approval PO PIC
        <small>Detail Approval PO PIC</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> PROCUREMENT - TRANSAKSI - PO</li>
        <li><a href="{{ route('baanpo1s.indexpic') }}"><i class="fa fa-files-o"></i> Approval PO PIC</a></li>
        <li class="active">Detail PO {{ $baanpo1->no_po }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Master PO {{ $baanpo1->no_po }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 13%;"><b>No. PO</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">{{ $baanpo1->no_po }}</td>
                    <td style="width: 9%;"><b>No. Revisi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>-</td>
                  </tr>
                  <tr>
                    <td style="width: 13%;"><b>Tgl PO</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">{{ \Carbon\Carbon::parse($baanpo1->tgl_po)->format('d/m/Y') }}</td>
                    <td style="width: 9%;"><b>Supplier</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $baanpo1->kd_supp }} - {{ Auth::user()->namaSupplier($baanpo1->kd_supp) }}</td>
                  </tr>
                  <tr>
                    <td style="width: 13%;"><b>Mata Uang</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">{{ $baanpo1->kd_curr }}</td>
                    <td style="width: 9%;"><b>Ref A</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $baanpo1->refa }}</td>
                  </tr>
                  <tr>
                    <td style="width: 13%;"><b>Pembuat PO</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($baanpo1->usercreate))
                        @if (strlen($baanpo1->usercreate) >= 5)
                          {{ substr($baanpo1->usercreate,-5) }} - {{ Auth::user()->namaByNpk(substr($baanpo1->usercreate,-5)) }}
                        @else 
                          {{ $baanpo1->usercreate }}
                        @endif
                      @endif
                    </td>
                  </tr>
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
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detail PO {{ $baanpo1->no_po }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="field" data-field-id="{{ $baanpo1->no_po }}">
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
      <div class="box-footer">
        @if (Auth::user()->can('prc-po-apr-pic'))
          @if(empty($baanpo1_postgre))
            <button id='btnapprove' type='button' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Approve PO - PIC {{ $baanpo1->no_po }}' onclick='approvepic("{{ $baanpo1->no_po }}")'>
              <span class='glyphicon glyphicon-check'></span> Approve PO - PIC
            </button>
            &nbsp;&nbsp;
          @else
            <button id='btnrevisi' type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Revisi PO - PIC {{ $baanpo1->no_po }}' onclick='revisipic("{{ $baanpo1->no_po }}")'>
              <span class='glyphicon glyphicon-repeat'></span> Revisi PO - PIC
            </button>
            &nbsp;&nbsp;
          @endif
        @endif
        <a class="btn btn-primary" href="{{ route('baanpo1s.indexpic') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard Approval PO PIC">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">
  
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
              var urlRedirect = "{{ route('baanpo1s.showpic', 'param') }}";
              urlRedirect = urlRedirect.replace('param', window.btoa(no_po));
              window.location.href = urlRedirect;
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
                var urlRedirect = "{{ route('baanpo1s.showpic', 'param') }}";
                urlRedirect = urlRedirect.replace('param', window.btoa(no_po));
                window.location.href = urlRedirect;
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
    var no_po = $('#field').data("field-id");
    var url = '{{ route('baanpo1s.detail', ['param','param2']) }}';    
    url = url.replace('param2', window.btoa("O"));
    url = url.replace('param', window.btoa(no_po));
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
  });
</script>
@endsection