{!! Form::hidden('mode', $mode, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'mode']) !!}
{!! Form::hidden('mode_approve', "F", ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'mode_approve']) !!}

<div class="box-body">
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('no_dm') ? ' has-error' : '' }}">
      {!! Form::label('no_dm', 'No. DM') !!}
      @if (empty($mtctdftmslh->no_dm))
        {!! Form::text('no_wo', null, ['class'=>'form-control','placeholder' => 'No. DM', 'disabled'=>'']) !!}
      @else
        {!! Form::text('no_dm2', $mtctdftmslh->no_dm, ['class'=>'form-control','placeholder' => 'No. DM', 'required', 'disabled'=>'']) !!}
        {!! Form::hidden('no_dm', null, ['class'=>'form-control','placeholder' => 'No. DM', 'required', 'readonly'=>'readonly']) !!}
      @endif
      {!! $errors->first('no_dm', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('tgl_dm') ? ' has-error' : '' }}">
      {!! Form::label('tgl_dm', 'Tanggal DM (*)') !!}
      @if (empty($mtctdftmslh->tgl_dm))
        {!! Form::date('tgl_dm', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl DM', 'required']) !!}
      @else
        {!! Form::date('tgl_dm', \Carbon\Carbon::parse($mtctdftmslh->tgl_dm), ['class'=>'form-control','placeholder' => 'Tgl DM', 'required', 'readonly'=>'readonly']) !!}
      @endif
      {!! $errors->first('tgl_dm', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('kd_plant') ? ' has-error' : '' }}">
      {!! Form::label('kd_plant', 'Plant (*)') !!}
      @if (empty($mtctdftmslh->no_pi))
        @if ($mode === "PIC" || $mode === "FM")
          {!! Form::hidden('kd_plant', $mtctdftmslh->kd_plant, ['class'=>'form-control','placeholder' => 'Plant', 'required', 'id' => 'kd_plant']) !!}
          {!! Form::select('kd_plant2',  $plant->pluck('nm_plant','kd_plant')->all(), $mtctdftmslh->kd_plant, ['class'=>'form-control select2', 'required', 'onchange' => 'changeKdPlant()', 'id' => 'kd_plant2', 'disabled'=>'']) !!}
        @else
          {!! Form::select('kd_plant',  $plant->pluck('nm_plant','kd_plant')->all(), null, ['class'=>'form-control select2', 'required', 'onchange' => 'changeKdPlant()', 'id' => 'kd_plant']) !!}
        @endif
      @else
        {!! Form::hidden('kd_plant', $mtctdftmslh->kd_plant, ['class'=>'form-control','placeholder' => 'Plant', 'required', 'id' => 'kd_plant']) !!}
        {!! Form::select('kd_plant2',  $plant->pluck('nm_plant','kd_plant')->all(), $mtctdftmslh->kd_plant, ['class'=>'form-control select2', 'required', 'onchange' => 'changeKdPlant()', 'id' => 'kd_plant2', 'disabled'=>'']) !!}
      @endif
      {!! $errors->first('kd_plant', '<p class="help-block">:message</p>') !!}
    </div>
    @if ($mode === "PIC" || $mode === "FM")
      <div class="col-sm-2 {{ $errors->has('tgl_plan_mulai') ? ' has-error' : '' }}">
        {!! Form::label('tgl_plan_mulai', 'Tgl Plan Pengerjaan (*)') !!}
        @if (empty($mtctdftmslh->tgl_plan_mulai))
          {!! Form::date('tgl_plan_mulai', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Plan Pengerjaan', 'required']) !!}
          {!! Form::hidden('tgl_plan_selesai', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'tgl_plan_selesai']) !!}
        @else
          {!! Form::date('tgl_plan_mulai', \Carbon\Carbon::parse($mtctdftmslh->tgl_plan_mulai), ['class'=>'form-control','placeholder' => 'Tgl Plan Pengerjaan', 'required']) !!}
          {!! Form::hidden('tgl_plan_selesai', \Carbon\Carbon::parse($mtctdftmslh->tgl_plan_mulai)->format('Ymd'), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'tgl_plan_selesai']) !!}
        @endif
        {!! $errors->first('tgl_plan_mulai', '<p class="help-block">:message</p>') !!}
      </div>
    @endif
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('kd_line') ? ' has-error' : '' }}">
      {!! Form::label('kd_line', 'Line (F9) (*)') !!}
      <div class="input-group">
        @if (empty($mtctdftmslh->no_pi))
          @if ($mode === "PIC" || $mode === "FM")
            {!! Form::text('kd_line', null, ['class'=>'form-control','placeholder' => 'Line', 'maxlength' => 10, 'onkeydown' => 'keyPressedKdLine(event)', 'onchange' => 'validateKdLine()', 'required', 'id' => 'kd_line', 'readonly' => 'readonly']) !!}
            <span class="input-group-btn">
              <button id="btnpopupline" type="button" class="btn btn-info" data-toggle="modal" data-target="#lineModal" readonly="readonly">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          @else
            {!! Form::text('kd_line', null, ['class'=>'form-control','placeholder' => 'Line', 'maxlength' => 10, 'onkeydown' => 'keyPressedKdLine(event)', 'onchange' => 'validateKdLine()', 'required', 'id' => 'kd_line']) !!}
            <span class="input-group-btn">
              <button id="btnpopupline" type="button" class="btn btn-info" data-toggle="modal" data-target="#lineModal">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          @endif
        @else
          {!! Form::text('kd_line', null, ['class'=>'form-control','placeholder' => 'Line', 'maxlength' => 10, 'onkeydown' => 'keyPressedKdLine(event)', 'onchange' => 'validateKdLine()', 'required', 'id' => 'kd_line', 'readonly' => 'readonly']) !!}
          <span class="input-group-btn">
            <button id="btnpopupline" type="button" class="btn btn-info" data-toggle="modal" data-target="#lineModal" readonly="readonly">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        @endif
      </div>
      {!! $errors->first('kd_line', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-5 {{ $errors->has('nm_line') ? ' has-error' : '' }}">
      {!! Form::label('nm_line', 'Nama Line') !!}
      {!! Form::text('nm_line', null, ['class'=>'form-control','placeholder' => 'Nama Line', 'disabled'=>'', 'id' => 'nm_line']) !!}
      {!! $errors->first('nm_line', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('kd_mesin') ? ' has-error' : '' }}">
      {!! Form::label('kd_mesin', 'Mesin (F9) (*)') !!}
      <div class="input-group">
        @if (empty($mtctdftmslh->no_pi))
          @if ($mode === "PIC" || $mode === "FM")
            {!! Form::text('kd_mesin', null, ['class'=>'form-control','placeholder' => 'Mesin', 'maxlength' => 20, 'onkeydown' => 'keyPressedKdMesin(event)', 'onchange' => 'validateKdMesin()', 'required', 'readonly' => 'readonly']) !!}
            <span class="input-group-btn">
              <button id="btnpopupmesin" type="button" class="btn btn-info" data-toggle="modal" data-target="#mesinModal" readonly="readonly">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          @else
            {!! Form::text('kd_mesin', null, ['class'=>'form-control','placeholder' => 'Mesin', 'maxlength' => 20, 'onkeydown' => 'keyPressedKdMesin(event)', 'onchange' => 'validateKdMesin()', 'required']) !!}
            <span class="input-group-btn">
              <button id="btnpopupmesin" type="button" class="btn btn-info" data-toggle="modal" data-target="#mesinModal">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          @endif
        @else
          {!! Form::text('kd_mesin', null, ['class'=>'form-control','placeholder' => 'Mesin', 'maxlength' => 20, 'onkeydown' => 'keyPressedKdMesin(event)', 'onchange' => 'validateKdMesin()', 'required', 'readonly' => 'readonly']) !!}
          <span class="input-group-btn">
            <button id="btnpopupmesin" type="button" class="btn btn-info" data-toggle="modal" data-target="#mesinModal" readonly="readonly">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        @endif
      </div>
      {!! $errors->first('kd_mesin', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-5 {{ $errors->has('nm_mesin') ? ' has-error' : '' }}">
      {!! Form::label('nm_mesin', 'Nama Mesin') !!}
      {!! Form::text('nm_mesin', null, ['class'=>'form-control','placeholder' => 'Nama Mesin', 'disabled'=>'', 'id' => 'nm_mesin']) !!}
      {!! $errors->first('nm_mesin', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-4 {{ $errors->has('ket_prob') ? ' has-error' : '' }}">
      {!! Form::label('ket_prob', 'Problem (*)') !!}
      @if (empty($mtctdftmslh->no_pi))
        {{-- @if ($mode === "PIC" || $mode === "FM")
          {!! Form::textarea('ket_prob', null, ['class'=>'form-control', 'placeholder' => 'Problem', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical', 'required', 'readonly' => 'readonly']) !!}
        @else --}}
          {!! Form::textarea('ket_prob', null, ['class'=>'form-control', 'placeholder' => 'Problem', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical', 'required']) !!}
        {{-- @endif --}}
      @else
        {!! Form::textarea('ket_prob', null, ['class'=>'form-control', 'placeholder' => 'Problem', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical', 'required', 'readonly' => 'readonly']) !!}
      @endif
      {!! $errors->first('ket_prob', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-4 {{ $errors->has('ket_cm') ? ' has-error' : '' }}">
      @if ($mode === "PIC" || $mode === "FM")
        {!! Form::label('ket_cm', 'Counter Measure (*)') !!}
        {!! Form::textarea('ket_cm', null, ['class'=>'form-control', 'placeholder' => 'Counter Measure', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical', 'required']) !!}
      @else
        {!! Form::label('ket_cm', 'Counter Measure') !!}
        {!! Form::textarea('ket_cm', null, ['class'=>'form-control', 'placeholder' => 'Counter Measure', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical']) !!}
      @endif
      {!! $errors->first('ket_cm', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-4 {{ $errors->has('ket_sp') ? ' has-error' : '' }}">
      {!! Form::label('ket_sp', 'Spare Part') !!}
      {{-- @if ($mode === "PIC" || $mode === "FM")
        {!! Form::textarea('ket_sp', null, ['class'=>'form-control', 'placeholder' => 'Spare Part', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical', 'readonly' => 'readonly']) !!}
      @else --}}
        {!! Form::textarea('ket_sp', null, ['class'=>'form-control', 'placeholder' => 'Spare Part', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical']) !!}
      {{-- @endif --}}
      {!! $errors->first('ket_sp', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-4 {{ $errors->has('ket_eva_hasil') ? ' has-error' : '' }}">
      {!! Form::label('ket_eva_hasil', 'Evaluasi Hasil') !!}
      {{-- @if ($mode === "PIC" || $mode === "FM")
        {!! Form::textarea('ket_eva_hasil', null, ['class'=>'form-control', 'placeholder' => 'Evaluasi Hasil', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical', 'readonly' => 'readonly']) !!}
      @else --}}
        {!! Form::textarea('ket_eva_hasil', null, ['class'=>'form-control', 'placeholder' => 'Evaluasi Hasil', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical']) !!}
      {{-- @endif --}}
      {!! $errors->first('ket_eva_hasil', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-4 {{ $errors->has('ket_remain') ? ' has-error' : '' }}">
      {!! Form::label('ket_remain', 'Remain') !!}
      {{-- @if ($mode === "PIC" || $mode === "FM")
        {!! Form::textarea('ket_remain', null, ['class'=>'form-control', 'placeholder' => 'Remain', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical', 'readonly' => 'readonly']) !!}
      @else --}}
        {!! Form::textarea('ket_remain', null, ['class'=>'form-control', 'placeholder' => 'Remain', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical']) !!}
      {{-- @endif --}}
      {!! $errors->first('ket_remain', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-4 {{ $errors->has('ket_remark') ? ' has-error' : '' }}">
      {!! Form::label('ket_remark', 'Remark') !!}
      {{-- @if ($mode === "PIC" || $mode === "FM")
        {!! Form::textarea('ket_remark', null, ['class'=>'form-control', 'placeholder' => 'Remark', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical', 'readonly' => 'readonly']) !!}
      @else --}}
        {!! Form::textarea('ket_remark', null, ['class'=>'form-control', 'placeholder' => 'Remark', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical']) !!}
      {{-- @endif --}}
      {!! $errors->first('ket_remark', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="row form-group">
    <div class="col-sm-5 {{ $errors->has('lok_pict') ? ' has-error' : '' }}">
      {!! Form::label('lok_pict', 'Picture (jpeg,png,jpg)') !!}
      @if ($mode === "PIC" || $mode === "FM")
        {!! Form::file('lok_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png', 'disabled' => '', ]) !!}
      @else
        {!! Form::file('lok_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
      @endif
      @if (!empty($mtctdftmslh->lok_pict))
        <p>
          <img src="{{ $mtctdftmslh->lokPict() }}" alt="File Not Found" class="img-rounded img-responsive">
          @if ($mode !== "PIC" && $mode !== "FM")
            <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('mtctdftmslhs.deleteimage', base64_encode($mtctdftmslh->no_dm)) }}"><span class="glyphicon glyphicon-remove"></span></a>
          @endif
        </p>
      @endif
      {!! $errors->first('lok_pict', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
</div>
<!-- /.box-body -->

<div class="box-footer">
  {!! Form::submit('Save DM', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  @if (!empty($mtctdftmslh->no_dm))
    @if ($mode === "F")
      &nbsp;&nbsp;
      <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
    @else
      @if ($mode === "PIC")
        &nbsp;&nbsp;
        <button id="btn-approve" type="button" class="btn btn-success">Save & Approve</button>
        &nbsp;&nbsp;
        <button id='btnreject' type='button' class='btn btn-warning' data-toggle='tooltip' data-placement='top' title='Reject DM - PIC {{ $mtctdftmslh->no_dm }}' onclick='reject("{{ $mtctdftmslh->no_dm }}","PIC")'>
          <span class='glyphicon glyphicon-remove'></span> Reject DM - PIC
        </button>
        &nbsp;&nbsp;
        <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
      @elseif($mode === "FM")
        &nbsp;&nbsp;
        <button id="btn-approve" type="button" class="btn btn-success">Save & Approve</button>
        &nbsp;&nbsp;
        <button id='btnreject' type='button' class='btn btn-warning' data-toggle='tooltip' data-placement='top' title='Reject DM - Foreman {{ $mtctdftmslh->no_dm }}' onclick='reject("{{ $mtctdftmslh->no_dm }}","FM")'>
          <span class='glyphicon glyphicon-remove'></span> Reject DM - Foreman
        </button>
      @endif
    @endif
  @endif
  &nbsp;&nbsp;
  <a class="btn btn-default" href="{{ route('mtctdftmslhs.index') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong. Max size file 8 MB', ['style'=>'color:red']) !!}</p>
</div>

<!-- Modal Line -->
@include('mtc.lp.popup.lineModal')
<!-- Modal Mesin -->
@include('mtc.lp.popup.mesinModal')

@section('scripts')
<script type="text/javascript">

  if(document.getElementById("mode").value === "PIC" || document.getElementById("mode").value === "FM") {
    document.getElementById("tgl_plan_mulai").focus();
  } else {
    document.getElementById("tgl_dm").focus();
  }

  //Initialize Select2 Elements
  $(".select2").select2();

  $("#btn-delete").click(function(){
    var no_dm = document.getElementById("no_dm").value.trim();
    var msg = 'Anda yakin menghapus No. DM: ' + no_dm + '?';
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
      var urlRedirect = "{{ route('mtctdftmslhs.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_dm));
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

  function reject(no_dm, status)
  {
    var msg = 'Anda yakin REJECT No. DM ' + no_dm + '?';
    if(status === "PIC") {
      msg = 'Anda yakin REJECT (PIC) No. DM ' + no_dm + '?';
    } else if(status === "FM") {
      msg = 'Anda yakin REJECT (Foreman) No. DM ' + no_dm + '?';
    }
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
              if(value.length > 200) {
                reject('Keterangan Reject Max 200 Karakter!')
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
        var url = "{{ route('mtctdftmslhs.reject')}}";
        $("#loading").show();
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method           : 'POST',
            // menambah csrf token dari Laravel
            _token            : token,
            no_dm             : window.btoa(no_dm),
            status_reject     : window.btoa(status),
            keterangan_reject : result,
          },
          success:function(data){
            $("#loading").hide();
            if(data.status === 'OK'){
              swal("Rejected", data.message, "success");
              var urlRedirect = "{{ route('mtctdftmslhs.show', 'param') }}";
              urlRedirect = urlRedirect.replace('param', window.btoa(no_dm));
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

  $("#btn-approve").click(function(){
    var mode = document.getElementById("mode").value;
    var no_dm = document.getElementById("no_dm").value;
    var tgl_dm = document.getElementById("tgl_dm").value;
    var kd_plant = document.getElementById("kd_plant").value;
    var tgl_plan_mulai = document.getElementById("tgl_plan_mulai").value;
    var kd_line = document.getElementById("kd_line").value;
    var kd_mesin = document.getElementById("kd_mesin").value;
    var ket_prob = document.getElementById("ket_prob").value;
    var ket_cm = document.getElementById("ket_cm").value;

    if(no_dm === "" || tgl_dm === "" || kd_plant === "" || tgl_plan_mulai === "" || kd_line === "" || kd_mesin === "" || ket_prob === "" || ket_cm === "") {
      var info = "Isi data yang tidak boleh kosong!";
      swal(info, "Perhatikan inputan anda!", "warning");
    } else {
      var valid = "T";
      var msg = "";
      var date_tgl_plan = new Date(tgl_plan_mulai);
      var date_now = new Date();

      var tahun_plan = date_tgl_plan.getFullYear();
      var bulan_plan = date_tgl_plan.getMonth() + 1;
      if(bulan_plan < 10) {
        bulan_plan = "0" + bulan_plan;
      }
      var tgl_plan = date_tgl_plan.getDate();
      if(tgl_plan < 10) {
        tgl_plan = "0" + tgl_plan;
      }
      var tanggal_plan = tahun_plan + "" + bulan_plan + "" + tgl_plan;

      var tahun_now = date_now.getFullYear();
      var bulan_now = date_now.getMonth() + 1;
      if(bulan_now < 10) {
        bulan_now = "0" + bulan_now;
      }
      var tgl_now = date_now.getDate();
      if(tgl_now < 10) {
        tgl_now = "0" + tgl_now;
      }
      var tanggal_now = tahun_now + "" + bulan_now + "" + tgl_now;
      var tanggal_saatini = tgl_now + "-" + bulan_now + "-" + tahun_now;

      if(tanggal_plan <= tanggal_now) {
        var tgl_plan_selesai = document.getElementById("tgl_plan_selesai").value;
        if(tanggal_plan != tgl_plan_selesai) {
          valid = "F";
          msg = "Tgl Plan Pengerjaan harus > Tanggal saat ini (" + tanggal_saatini + ")!";
        }
      }

      if(valid !== "T") {
        var info = msg;
        swal(info, "Perhatikan inputan anda!", "warning");
      } else {
        var msg = "Anda yakin menyimpan dan approve data ini?";
        var txt = 'No. DM: ' + no_dm;

        //additional input validations can be done hear
        swal({
          title: msg,
          text: txt,
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, save & approve it!',
          cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
          allowOutsideClick: true,
          allowEscapeKey: true,
          allowEnterKey: true,
          reverseButtons: false,
          focusCancel: true,
        }).then(function () {
          document.getElementById("mode").value = mode;
          document.getElementById("mode_approve").value = mode;
          document.getElementById("form_id").submit();
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

  $('#form_id').submit(function (e, params) {
    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();
      var valid = "T";
      var msg = "";

      var mode = document.getElementById("mode").value;
      if(mode === "PIC" || mode === "FM") {
        var tgl_plan_mulai = document.getElementById("tgl_plan_mulai").value;
        var date_tgl_plan = new Date(tgl_plan_mulai);
        var date_now = new Date();

        var tahun_plan = date_tgl_plan.getFullYear();
        var bulan_plan = date_tgl_plan.getMonth() + 1;
        if(bulan_plan < 10) {
          bulan_plan = "0" + bulan_plan;
        }
        var tgl_plan = date_tgl_plan.getDate();
        if(tgl_plan < 10) {
          tgl_plan = "0" + tgl_plan;
        }
        var tanggal_plan = tahun_plan + "" + bulan_plan + "" + tgl_plan;

        var tahun_now = date_now.getFullYear();
        var bulan_now = date_now.getMonth() + 1;
        if(bulan_now < 10) {
          bulan_now = "0" + bulan_now;
        }
        var tgl_now = date_now.getDate();
        if(tgl_now < 10) {
          tgl_now = "0" + tgl_now;
        }
        var tanggal_now = tahun_now + "" + bulan_now + "" + tgl_now;
        var tanggal_saatini = tgl_now + "-" + bulan_now + "-" + tahun_now;

        if(tanggal_plan <= tanggal_now) {
          var tgl_plan_selesai = document.getElementById("tgl_plan_selesai").value;
          if(tanggal_plan != tgl_plan_selesai) {
            valid = "F";
            msg = "Tgl Plan Pengerjaan harus > Tanggal saat ini (" + tanggal_saatini + ")!";
          }
        }
      }

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

  function changeKdPlant() {
    validateKdLine();
  }

  function keyPressedKdLine(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupline').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('kd_mesin').focus();
    }
  }

  function keyPressedKdMesin(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupmesin').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('ket_prob').focus();
    }
  }

  $(document).ready(function(){

    $("#btnpopupline").click(function(){
      popupKdLine();
    });

    $("#btnpopupmesin").click(function(){
      popupKdMesin();
    });
  });

  function popupKdLine() {
    var myHeading = "<p>Popup Line</p>";
    $("#lineModalLabel").html(myHeading);
    var kd_plant = document.getElementById('kd_plant').value.trim();
    var url = '{{ route('datatables.popupLines', 'param') }}';
    url = url.replace('param', window.btoa(kd_plant));
    var lookupLine = $('#lookupLine').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      "order": [[1, 'asc']],
      columns: [
        { data: 'xkd_line', name: 'xkd_line'},
        { data: 'xnm_line', name: 'xnm_line'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupLine tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupLine.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("kd_line").value = value["xkd_line"];
            document.getElementById("nm_line").value = value["xnm_line"];
            $('#lineModal').modal('hide');
            validateKdLine();
          });
        });
        $('#lineModal').on('hidden.bs.modal', function () {
          var kd_line = document.getElementById("kd_line").value.trim();
          if(kd_line === '') {
            document.getElementById("nm_line").value = "";
            document.getElementById("kd_mesin").value = "";
            document.getElementById("nm_mesin").value = "";
            $('#kd_line').focus();
          } else {
            $('#kd_mesin').focus();
          }
        });
      },
    });
  }

  function validateKdLine() {
    var kd_line = document.getElementById("kd_line").value.trim();
    if(kd_line !== '') {
      var kd_plant = document.getElementById('kd_plant').value.trim();
      var url = '{{ route('datatables.validasiLine', ['param','param2']) }}';
      url = url.replace('param2', window.btoa(kd_line));
      url = url.replace('param', window.btoa(kd_plant));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("kd_line").value = result["xkd_line"];
          document.getElementById("nm_line").value = result["xnm_line"];
          validateKdMesin();
        } else {
          document.getElementById("kd_line").value = "";
          document.getElementById("nm_line").value = "";
          document.getElementById("kd_mesin").value = "";
          document.getElementById("nm_mesin").value = "";
          document.getElementById("kd_line").focus();
          swal("Line tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("kd_line").value = "";
      document.getElementById("nm_line").value = "";
      document.getElementById("kd_mesin").value = "";
      document.getElementById("nm_mesin").value = "";
    }
  }

  function popupKdMesin() {
    var myHeading = "<p>Popup Mesin</p>";
    $("#mesinModalLabel").html(myHeading);
    var kd_plant = document.getElementById('kd_plant').value.trim();
    if(kd_plant === '') {
      kd_plant = "-";
    }
    var kd_line = document.getElementById('kd_line').value.trim();
    if(kd_line === '') {
      kd_line = "-";
    }
    var url = '{{ route('datatables.popupMesins', ['param','param2']) }}';
    url = url.replace('param2', window.btoa(kd_line));
    url = url.replace('param', window.btoa(kd_plant));
    var lookupMesin = $('#lookupMesin').DataTable({
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
        { data: 'kd_mesin', name: 'kd_mesin'},
        { data: 'nm_mesin', name: 'nm_mesin'},
        { data: 'kd_line', name: 'kd_line'},
        { data: 'nm_line', name: 'nm_line'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupMesin tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupMesin.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("kd_mesin").value = value["kd_mesin"];
            document.getElementById("nm_mesin").value = value["nm_mesin"];
            document.getElementById("kd_line").value = value["kd_line"];
            document.getElementById("nm_line").value = value["nm_line"];
            $('#mesinModal').modal('hide');
            validateKdMesin();
          });
        });
        $('#mesinModal').on('hidden.bs.modal', function () {
          var kd_mesin = document.getElementById("kd_mesin").value.trim();
          if(kd_mesin === '') {
            document.getElementById("nm_mesin").value = "";
            $('#kd_mesin').focus();
          } else {
            $('#ket_prob').focus();
          }
        });
      },
    });
  }

  function validateKdMesin() {
    var kd_plant = document.getElementById("kd_plant").value.trim();
    var kd_line = document.getElementById('kd_line').value.trim();
    if(kd_line === '') {
      kd_line = "-";
    }
    var kd_mesin = document.getElementById("kd_mesin").value.trim();
    if(kd_plant !== '' && kd_mesin !== '') {
      var url = '{{ route('datatables.validasiMesin', ['param', 'param2', 'param3']) }}';
      url = url.replace('param3', window.btoa(kd_mesin));
      url = url.replace('param2', window.btoa(kd_line));
      url = url.replace('param', window.btoa(kd_plant));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          if(result["jml_row"] != null) {
            document.getElementById("kd_mesin").value = "";
            document.getElementById("nm_mesin").value = "";
            document.getElementById("kd_line").value = "";
            document.getElementById("nm_line").value = "";
            document.getElementById("kd_mesin").focus();
            swal("Terdapat " + result["jml_row"] + " Line. Pilih dari Popup.", "tekan F9 untuk tampilkan data.", "warning");
          } else {
            document.getElementById("kd_mesin").value = result["kd_mesin"];
            document.getElementById("nm_mesin").value = result["nm_mesin"];
            document.getElementById("kd_line").value = result["kd_line"];
            document.getElementById("nm_line").value = result["nm_line"];
            document.getElementById("ket_prob").focus();
          }
        } else {
          document.getElementById("kd_mesin").value = "";
          document.getElementById("nm_mesin").value = "";
          document.getElementById("kd_mesin").focus();
          swal("Mesin tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("kd_mesin").value = "";
      document.getElementById("nm_mesin").value = "";
    }
  }
</script>
@endsection
