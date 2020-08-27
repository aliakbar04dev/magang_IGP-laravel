<div class="box-body">
  <div class="form-group">
    <div class="col-sm-4 {{ $errors->has('no_certi') ? ' has-error' : '' }}">
      {!! Form::label('no_certi', 'Barcode (*)') !!}
      {!! Form::text('no_certi', null, ['class' => 'form-control', 'placeholder' => 'Barcode', 'onchange' => 'validateNoCerti()', 'required']) !!}
      {!! $errors->first('no_certi', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-3 {{ $errors->has('no_sj') ? ' has-error' : '' }}">
      {!! Form::label('no_sj', 'No. Surat Jalan') !!}
      {!! Form::text('no_sj', null, ['class' => 'form-control', 'placeholder' => 'No. Surat Jalan', 'disabled' => '']) !!}
      {!! $errors->first('no_sj', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('tgl_sj') ? ' has-error' : '' }}">
      {!! Form::label('tgl_sj', 'Tanggal SJ') !!}
      {!! Form::text('tgl_sj', null, ['class' => 'form-control', 'placeholder' => 'Tanggal SJ', 'disabled' => '']) !!}
      {!! $errors->first('tgl_sj', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-4">
      {!! Form::label('no_dn', 'No. DN') !!}
      {!! Form::text('no_dn', null, ['class' => 'form-control', 'placeholder' => 'No. DN', 'disabled' => '']) !!}
      {!! $errors->first('no_dn', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
</div>
<!-- /.box-body -->

<div class="box-body" id="field-detail">
  <table id="tblDetail" class="table table-bordered table-striped" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th rowspan="2" style="width: 1%;">Check</th>
        <th rowspan="2" style="width: 5%;">No. POS</th>
        <th rowspan="2" style="width: 15%;">Item</th>
        <th rowspan="2" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">Deskripsi</th>
        <th rowspan="2" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">Keterangan</th>
        <th colspan="3" style="text-align:center;">QTY</th>
      </tr>
      <tr>
        <th style="width: 10%;">DN</th>
        <th style="width: 10%;">Kirim IGP</th>
        <th style="width: 10%;">SJ</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="text-align: center;">
          <input type="checkbox" name="row-1-chk" id="row-1-chk" value="1" class="icheckbox_square-blue">
        </td>
        <td style="text-align: center;">
          <input type="hidden" id="row-1-no_pos" name="row-1-no_pos" class="form-control" readonly="readonly" value="1">
          1
        </td>
        <td style="white-space: nowrap;overflow: auto;text-overflow: clip;">
          1
        </td>
        <td style="white-space: nowrap;max-width: 200px;overflow: auto;text-overflow: clip;">
          1
        </td>
        <td style="white-space: nowrap;max-width: 200px;overflow: auto;text-overflow: clip;">
          1
        </td>
        <td style="text-align: right;">
          {{ numberFormatter(0, 2)->format(1) }}
        </td>
        <td style="text-align: right;">
          {{ numberFormatter(0, 2)->format(1) }}
        </td>
        <td style="text-align: right;">
          {{ numberFormatter(0, 2)->format(1) }}
        </td>
      </tr>
    </tbody>
  </table>
</div>
<!-- /.box-body -->


<div class="box-footer">
  <button id='btnapprove' type='button' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Approve' onclick='approve()'>
    <span class='glyphicon glyphicon-check'></span> Approve
  </button>
  &nbsp;&nbsp;
  <button id='btnreject' type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Reject' onclick='reject()'>
    <span class='glyphicon glyphicon-remove'></span> Reject
  </button>
  &nbsp;&nbsp;
  <a class="btn btn-default" href="{{ route('ppctdnclaimsj1s.all') }}">Cancel</a>
</div>

@section('scripts')
<script type="text/javascript">

  document.getElementById("no_certi").focus();

  function approve()
  {
    var no_certi = document.getElementById("no_certi").value.trim();
    if(no_certi === "") {
      document.getElementById("no_certi").focus();
      swal("Barcode tidak boleh kosong!", "", "warning");
    } else if(validasi() !== "T") {
      swal("Semua data harus di-check!", "", "warning");
    } else {
      var msg = 'Anda yakin APPROVE Barcode: ' + no_certi + '?';
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
        var token = document.getElementsByName('_token')[0].value.trim();
        // save via ajax
        // create data detail dengan ajax
        var url = "{{ route('ppctdnclaimsj1s.approvereject')}}";
        $("#loading").show();
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method           : 'POST',
            // menambah csrf token dari Laravel
            _token            : token,
            no_certi          : window.btoa(no_certi),
            status_approve    : window.btoa("T"), 
            keterangan_reject : "-",
          },
          success:function(data){
            $("#loading").hide();
            if(data.status === 'OK'){
              document.getElementById("no_certi").value = "";
              document.getElementById("no_sj").value = "";
              document.getElementById("tgl_sj").value = "";
              document.getElementById("no_dn").value = "";
              var table = $('#tblDetail').DataTable();
              table.clear().draw();
              document.getElementById("no_certi").focus();
              swal("Approved", data.message, "success");
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

  function reject()
  {
    var no_certi = document.getElementById("no_certi").value.trim();
    if(no_certi === "") {
      document.getElementById("no_certi").focus();
      swal("Barcode tidak boleh kosong!", "", "warning");
    } else if(validasi() !== "T") {
      swal("Semua data harus di-check!", "", "warning");
    } else {
      var msg = 'Anda yakin REJECT Barcode: ' + no_certi + '?';
      //additional input validations can be done hear
      swal({
        title: msg,
        text: "",
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
          input: 'textarea',
          showCancelButton: true,
          inputValidator: function (value) {
            return new Promise(function (resolve, reject) {
              if (value) {
                if(value.length > 100) {
                  reject('Keterangan Reject Max 100 Karakter!')
                } else {
                  resolve()
                }
              } else {
                reject('Keterangan Reject tidak boleh kosong!')
              }
            })
          }
        }).then(function (result) {
          var token = document.getElementsByName('_token')[0].value.trim();
          // save via ajax
          // create data detail dengan ajax
          var url = "{{ route('ppctdnclaimsj1s.approvereject')}}";
          $("#loading").show();
          $.ajax({
            type     : 'POST',
            url      : url,
            dataType : 'json',
            data     : {
              _method           : 'POST',
              // menambah csrf token dari Laravel
              _token            : token,
              no_certi          : window.btoa(no_certi),
              status_approve    : window.btoa("F"), 
              keterangan_reject : result,
            },
            success:function(data){
              $("#loading").hide();
              if(data.status === 'OK'){
                document.getElementById("no_certi").value = "";
                document.getElementById("no_sj").value = "";
                document.getElementById("tgl_sj").value = "";
                document.getElementById("no_dn").value = "";
                var table = $('#tblDetail').DataTable();
                table.clear().draw();
                document.getElementById("no_certi").focus();
                swal("Rejected", data.message, "success");
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
  }

  $(document).ready(function(){
    var table = $('#tblDetail').DataTable({
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
      // 'responsive': true,
      "ordering": false, 
      'searching': false,
      "scrollX": true,
      "scrollY": "500px",
      "scrollCollapse": true,
      "paging": false, 
      columns: [
        {className: "dt-center"},
        {className: "dt-center"},
        {className: "dt-left"},
        {className: "dt-left"},
        {className: "dt-left"},
        {className: "dt-right"},
        {className: "dt-right"},
        {className: "dt-right"}
      ]
    });

    table.clear().draw();
  });

  function validasi() {
    var validasi = "";
    var table = $('#tblDetail').DataTable();
    table.search('').columns().search('').draw();
    for($i = 0; $i < table.rows().count(); $i++) {
      if(validasi !== "F") {
        var no = $i + 1;
        var data = table.cell($i, 0).data();
        var posisi = data.indexOf("chk");
        var target = data.substr(0, posisi);
        target = target.replace('<input type="checkbox" name="', '');
        target = target.replace("<input type='checkbox' name='", '');
        target = target.replace("<input type='checkbox' name=", '');
        target = target.replace('<input name="', '');
        target = target.replace("<input name='", '');
        target = target.replace("<input name=", '');
        target = target +'chk';
        if(document.getElementById(target) != null) {
          var checkedOld = document.getElementById(target).checked;
          data = data.replace(target, 'row-' + no + '-chk');
          data = data.replace(target, 'row-' + no + '-chk');
          table.cell($i, 0).data(data);
          posisi = data.indexOf("chk");
          target = data.substr(0, posisi);
          target = target.replace('<input type="checkbox" name="', '');
          target = target.replace("<input type='checkbox' name='", '');
          target = target.replace("<input type='checkbox' name=", '');
          target = target.replace('<input name="', '');
          target = target.replace("<input name='", '');
          target = target.replace("<input name=", '');
          target = target +'chk';
          document.getElementById(target).checked = checkedOld;
          var checked = document.getElementById(target).checked;
          if(checked == true) {
            validasi = "T";
          } else {
            validasi = "F";
            $i = table.rows().count();
          }
        }
      }
    }
    return validasi;
  }

  function validateNoCerti() {
    var no_certi = document.getElementById("no_certi").value.trim();
    if(no_certi !== '') {
      var url = '{{ route('ppctdnclaimsj1s.validasiNoCerti', 'param') }}';
      url = url.replace('param', window.btoa(no_certi));
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          var table = $('#tblDetail').DataTable();
          table.clear().draw();
          var counter = 0;
          $.each(result, function(i, item) {
            document.getElementById("no_sj").value = item.no_sj;
            document.getElementById("tgl_sj").value = item.tgl_sj;
            document.getElementById("no_dn").value = item.no_dn;

            counter++;
            table.row.add([
              '<input type="checkbox" name="row-'+ counter +'-chk" id="row-'+ counter +'-chk" value="' + item.no_pos + '" class="icheckbox_square-blue">', 
              item.no_pos,
              item.kd_item,
              item.item_name,
              item.nm_trket,
              item.qty_dn,
              item.qty_kirim,
              item.qty_sj
            ]).draw(false);

            document.getElementById("row-1-chk").focus();
          });
        } else {
          document.getElementById("no_certi").value = "";
          document.getElementById("no_sj").value = "";
          document.getElementById("tgl_sj").value = "";
          document.getElementById("no_dn").value = "";
          var table = $('#tblDetail').DataTable();
          table.clear().draw();
          document.getElementById("no_certi").focus();
          swal("Barcode tidak valid!", "Perhatikan inputan anda!", "error");
        }
      });
    } else {
      document.getElementById("no_sj").value = "";
    }
  }
</script>
@endsection