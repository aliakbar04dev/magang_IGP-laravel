<div class="box-body">
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('no_dpr') ? ' has-error' : '' }}">
      {!! Form::label('no_dpr', 'No. DEPR') !!}
      @if (empty($ppctdpr->no_dpr))
        {!! Form::text('no_dpr', null, ['class'=>'form-control','placeholder' => 'No. DEPR', 'disabled'=>'']) !!}
      @else
        {!! Form::text('no_dpr2', $ppctdpr->no_dpr, ['class'=>'form-control','placeholder' => 'No. DEPR', 'required', 'disabled'=>'']) !!}
        {!! Form::hidden('no_dpr', null, ['class'=>'form-control','placeholder' => 'No. DEPR', 'required', 'readonly'=>'readonly']) !!}
      @endif
      {!! Form::hidden('st_submit', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'st_submit']) !!}
      {!! $errors->first('no_dpr', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('tgl_dpr') ? ' has-error' : '' }}">
      {!! Form::label('tgl_dpr', 'Tanggal DEPR (*)') !!}
      @if (empty($ppctdpr->tgl_dpr))
        {!! Form::date('tgl_dpr', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl DEPR', 'required']) !!}
      @else
        {!! Form::date('tgl_dpr', \Carbon\Carbon::parse($ppctdpr->tgl_dpr), ['class'=>'form-control','placeholder' => 'Tgl DEPR', 'required', 'readonly'=>'readonly']) !!}
      @endif
      {!! $errors->first('tgl_dpr', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('kd_site') ? ' has-error' : '' }}">
      {!! Form::label('kd_site', 'Site (*)') !!}
      @if (empty($ppctdpr->no_dpr))
        {!! Form::select('kd_site', ['IGPJ' => 'IGP - JAKARTA', 'IGPK' => 'IGP - KARAWANG'], null, ['class'=>'form-control select2', 'required', 'id' => 'kd_site']) !!}
      @else
        {!! Form::select('kd_site', ['IGPJ' => 'IGP - JAKARTA', 'IGPK' => 'IGP - KARAWANG'], null, ['class'=>'form-control select2', 'required', 'id' => 'kd_site', 'readonly'=>'readonly']) !!}
      @endif
      {!! $errors->first('kd_site', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-2 {{ $errors->has('kd_bpid') ? ' has-error' : '' }}">
      {!! Form::label('kd_bpid', 'Kode Supplier (*) (F9)') !!}
      <div class="input-group">
        {!! Form::text('kd_bpid', null, ['class'=>'form-control','placeholder' => 'Kode Supplier', 'onkeydown' => 'keyPressedKdSupp(event)', 'maxlength' => 9, 'required', 'onchange' => 'validateSupplier()', 'id' => 'kd_bpid']) !!}
        <span class="input-group-btn">
          <button id="btnpopupsupplier" type="button" class="btn btn-info" data-toggle="modal" data-target="#supplierModal">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
      {!! $errors->first('kd_bpid', '<p class="help-block">:message</p>') !!}
    </div>
    <!-- /.form-group -->
    <div class="col-sm-5 {{ $errors->has('nm_supp') ? ' has-error' : '' }}">
      {!! Form::label('nm_supp', 'Nama Supplier') !!}
      {!! Form::text('nm_supp', null, ['class'=>'form-control', 'placeholder' => 'Nama Supplier', 'disabled' => '']) !!}
      {!! $errors->first('nm_supp', '<p class="help-block">:message</p>') !!}
    </div>
    <!-- /.form-group -->
  </div>
  <!-- /.row -->
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('problem_st') ? ' has-error' : '' }}">
      {!! Form::label('problem_st', 'Problem Status (*)') !!}
      {!! Form::select('problem_st', ['DELAY ARRIVAL TIME' => 'DELAY ARRIVAL TIME', 'SHORTAGE PARTS' => 'SHORTAGE PARTS', 'MISPACKING PARTS' => 'MISPACKING PARTS', 'OTHERS' => 'OTHERS'], null, ['class'=>'form-control select2', 'required', 'id' => 'problem_st', 'onchange' => 'changeProblemSt()']) !!}
      {!! $errors->first('problem_st', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-4 {{ $errors->has('problem_oth') ? ' has-error' : '' }}">
      {!! Form::label('problem_oth', 'Problem Others (*)') !!}
      {!! Form::textarea('problem_oth', null, ['class'=>'form-control', 'placeholder' => 'Problem Others', 'rows' => '3', 'maxlength'=>'50', 'style' => 'resize:vertical', 'readonly' => 'readonly']) !!}
      {!! $errors->first('problem_oth', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('st_ls') ? ' has-error' : '' }}">
      {!! Form::label('st_ls', 'Line Stop (*)') !!}
      {!! Form::select('st_ls', ['F' => 'TIDAK', 'T' => 'YA'], null, ['class'=>'form-control select2', 'required', 'id' => 'st_ls', 'onchange' => 'changeStLs()']) !!}
      {!! $errors->first('st_ls', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('jml_ls_menit') ? ' has-error' : '' }}">
      {!! Form::label('jml_ls_menit', 'Jumlah Menit') !!}
      @if (empty($ppctdpr->no_dpr))
        {!! Form::number('jml_ls_menit', null, ['class'=>'form-control', 'placeholder' => 'Jumlah Menit', 'min'=>'0.1', 'max'=>'9999999.99', 'step'=>'any', 'style' => 'text-align:right']) !!}
      @else
        {!! Form::number('jml_ls_menit', numberFormatterForm(0, 2)->format($ppctdpr->jml_ls_menit), ['class'=>'form-control', 'placeholder' => 'Jumlah Menit', 'min'=>'0.1', 'max'=>'9999999.99', 'step'=>'any', 'style' => 'text-align:right']) !!}
      @endif
      {!! $errors->first('jml_ls_menit', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-5 {{ $errors->has('problem_title') ? ' has-error' : '' }}">
      {!! Form::label('problem_title', 'Problem Tittle (*)') !!}
      {!! Form::textarea('problem_title', null, ['class'=>'form-control', 'placeholder' => 'Problem Tittle', 'rows' => '3', 'maxlength'=>'100', 'style' => 'resize:vertical', 'required']) !!}
      {!! $errors->first('problem_title', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-5 {{ $errors->has('problem_ket') ? ' has-error' : '' }}">
      {!! Form::label('problem_ket', 'Problem Keterangan (*)') !!}
      {!! Form::textarea('problem_ket', null, ['class'=>'form-control', 'placeholder' => 'Problem Keterangan', 'rows' => '3', 'maxlength'=>'2000', 'style' => 'resize:vertical', 'required']) !!}
      {!! $errors->first('problem_ket', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-5 {{ $errors->has('problem_std') ? ' has-error' : '' }}">
      {!! Form::label('problem_std', 'Problem Standard (*)') !!}
      {!! Form::textarea('problem_std', null, ['class'=>'form-control', 'placeholder' => 'Problem Standard', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical', 'required']) !!}
      {!! $errors->first('problem_std', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-5 {{ $errors->has('problem_act') ? ' has-error' : '' }}">
      {!! Form::label('problem_act', 'Problem Actual (*)') !!}
      {!! Form::textarea('problem_act', null, ['class'=>'form-control', 'placeholder' => 'Problem Actual', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical', 'required']) !!}
      {!! $errors->first('problem_act', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="row form-group">
    <div class="col-sm-5 {{ $errors->has('problem_pict') ? ' has-error' : '' }}">
      {!! Form::label('problem_pict', 'Picture (jpeg,png,jpg)') !!}
      {!! Form::file('problem_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
      @if (!empty($ppctdpr->problem_pict))
        <p>
          <img src="{{ $ppctdpr->problemPict() }}" alt="File Not Found" class="img-rounded img-responsive">
          <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('ppctdprs.deleteimage', base64_encode($ppctdpr->no_dpr)) }}"><span class="glyphicon glyphicon-remove"></span></a>
        </p>
      @endif
      {!! $errors->first('problem_pict', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
</div>
<!-- /.box-body -->

<div class="box-footer">
  {!! Form::submit('Save DEPR', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  @if (!empty($ppctdpr->no_dpr))
    @if (Auth::user()->can('ppc-dpr-submit'))
      &nbsp;&nbsp;
      <button id="btn-submit" type="button" class="btn btn-success">Save & Submit DEPR</button>
    @endif
    &nbsp;&nbsp;
    <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
  @endif
  &nbsp;&nbsp;
  <a class="btn btn-warning" href="{{ route('ppctdprs.create') }}">Add DEPR</a>
  &nbsp;&nbsp;
  <a class="btn btn-default" href="{{ route('ppctdprs.index') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong. Max size file 8 MB', ['style'=>'color:red']) !!}</p>
</div>

<!-- Modal Supplier -->
@include('ppc.dpr.popup.supplierModal')

@section('scripts')
<script type="text/javascript">

  document.getElementById("tgl_dpr").focus();

  changeProblemSt();
  changeStLs();

  //Initialize Select2 Elements
  $(".select2").select2();

  $("#btn-delete").click(function(){
    var no_dpr = document.getElementById("no_dpr").value.trim();
    var msg = 'Anda yakin menghapus No. DEPR: ' + no_dpr + '?';
    var txt = '';
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
      var urlRedirect = "{{ route('ppctdprs.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_dpr));
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
  });

  $('#form_id').submit(function (e, params) {
    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();
      var valid = "T";
      var msg = "";
      if(valid !== "T") {
        var info = msg;
        swal(info, "Perhatikan inputan anda!", "warning");
      } else {
        //additional input validations can be done hear
        swal({
          title: 'Are you sure?',
          text: '',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, save it!',
          cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
          allowOutsideClick: true,
          allowEscapeKey: true,
          allowEnterKey: true,
          reverseButtons: false,
          focusCancel: false,
        }).then(function () {
          $(e.currentTarget).trigger(e.type, { 'send': true });
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

  $("#btn-submit").click(function(){
    var no_dpr = document.getElementById("no_dpr").value.trim();
    var tgl_dpr = document.getElementById("tgl_dpr").value;
    var kd_bpid = document.getElementById("kd_bpid").value.trim();
    var kd_site = document.getElementById("kd_site").value.trim();
    var problem_st = document.getElementById("problem_st").value.trim();
    var problem_oth = document.getElementById("problem_oth").value.trim();
    var problem_title = document.getElementById("problem_title").value.trim();
    var problem_ket = document.getElementById("problem_ket").value.trim();
    var problem_std = document.getElementById("problem_std").value.trim();
    var problem_act = document.getElementById("problem_act").value.trim();

    valid_problem_st = "T";
    if(problem_st.toUpperCase() === "OTHERS") {
      if(problem_oth === "") {
        valid_problem_st = "F";
      }
    } else {
      document.getElementById("problem_oth").value = "";
      $('#problem_oth').removeAttr('required');
      $('#problem_oth').attr('readonly', 'readonly');
    }

    if(no_dpr === "" || tgl_dpr === "" || kd_bpid === "" || kd_site === "" || problem_st === "" || valid_problem_st === "F" || problem_title === "" || problem_ket === "" || problem_std === "" || problem_act === "") {
      var info = "Isi data yang tidak boleh kosong!";
      swal(info, "Perhatikan inputan anda!", "warning");
    } else {
      var msg = 'Anda yakin submit data ini?';
      var txt = 'No. DEPR: ' + no_dpr;
      swal({
        title: msg,
        text: txt,
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, submit it!',
        cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
        allowOutsideClick: true,
        allowEscapeKey: true,
        allowEnterKey: true,
        reverseButtons: false,
        focusCancel: true,
      }).then(function () {
        document.getElementById("st_submit").value = "T";
        document.getElementById("form_id").submit();
      }, function (dismiss) {
        if (dismiss === 'cancel') {
        }
      })
    }
  });

  function keyPressedKdSupp(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupsupplier').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('problem_st').focus();
    }
  }

  $(document).ready(function(){
    $("#btnpopupsupplier").click(function(){
      popupSupplier();
    });
  });

  function popupSupplier() {
    var myHeading = "<p>Popup Supplier</p>";
    $("#supplierModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupSupplierBaans') }}';
    var lookupSupplier = $('#lookupSupplier').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      // "scrollX": true,
      // "scrollY": "500px",
      // "scrollCollapse": true,
      "order": [[1, 'asc']],
      columns: [
        { data: 'kd_supp', name: 'kd_supp'},
        { data: 'nama', name: 'nama'},
        { data: 'email', name: 'email'},
        { data: 'init_supp', name: 'init_supp'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupSupplier tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupSupplier.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("kd_bpid").value = value["kd_supp"];
            document.getElementById("nm_supp").value = value["nama"];
            $('#supplierModal').modal('hide');
            validateSupplier();
          });
        });
        $('#supplierModal').on('hidden.bs.modal', function () {
          var kd_bpid = document.getElementById("kd_bpid").value.trim();
          if(kd_bpid === '') {
            document.getElementById("nm_supp").value = "";
            $('#kd_bpid').focus();
          } else {
            document.getElementById('problem_st').focus();
          }
        });
      },
    });
  }

  function validateSupplier() {
    var kd_bpid = document.getElementById("kd_bpid").value.trim();
    if(kd_bpid !== '') {
      var url = '{{ route('datatables.validasiSupplierBaan', 'param') }}';
      url = url.replace('param', window.btoa(kd_bpid));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("kd_bpid").value = result["kd_supp"];
          document.getElementById("nm_supp").value = result["nama"];
          document.getElementById('problem_st').focus();
        } else {
          document.getElementById("kd_bpid").value = "";
          document.getElementById("nm_supp").value = "";
          document.getElementById("kd_bpid").focus();
          swal("Kode Supplier tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("kd_bpid").value = "";
      document.getElementById("nm_supp").value = "";
    }
  }

  function changeProblemSt() {
    var problem_st = document.getElementById("problem_st").value.trim();
    var problem_oth = document.getElementById("problem_oth").value.trim();

    if(problem_st.toUpperCase() === "OTHERS") {
      $('#problem_oth').attr('required', 'required');
      $('#problem_oth').removeAttr('readonly');
    } else {
      document.getElementById("problem_oth").value = "";
      $('#problem_oth').removeAttr('required');
      $('#problem_oth').attr('readonly', 'readonly');
    }
  }

  function changeStLs() {
    var st_ls = document.getElementById("st_ls").value.trim();
    if(st_ls.toUpperCase() === "T") {
      $('#jml_ls_menit').attr('required', 'required');
      $('#jml_ls_menit').removeAttr('readonly');
    } else {
      document.getElementById("jml_ls_menit").value = "";
      $('#jml_ls_menit').removeAttr('required');
      $('#jml_ls_menit').attr('readonly', 'readonly');
    }
  }
</script>
@endsection