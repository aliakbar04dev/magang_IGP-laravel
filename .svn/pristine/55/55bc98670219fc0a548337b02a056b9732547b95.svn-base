{!! Form::hidden('st_submit', null, ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'st_submit']) !!}
<div class="box-body">
	<div class="form-group">
		<div class="col-sm-2 {{ $errors->has('no_komite') ? ' has-error' : '' }}">
			{!! Form::label('no_komite', 'No. Komite') !!}
			@if (empty($bgttkomite1->no_komite))
				{!! Form::text('no_komite', null, ['class'=>'form-control','placeholder' => 'No. Komite', 'disabled'=>'']) !!}
			@else
				{!! Form::text('no_komite2', $bgttkomite1->no_komite, ['class'=>'form-control','placeholder' => 'No. Komite', 'required', 'disabled'=>'']) !!}
				{!! Form::hidden('no_komite', null, ['class'=>'form-control','placeholder' => 'No. Komite', 'required', 'readonly'=>'readonly']) !!}
			@endif
			{!! $errors->first('no_komite', '<p class="help-block">:message</p>') !!}
		</div>
        <div class="col-sm-2 {{ $errors->has('dtcrea') ? ' has-error' : '' }}">
            {!! Form::label('dtcrea', 'Tgl Daftar') !!}
            @if (empty($bgttkomite1->dtcrea))
                {!! Form::text('dtcrea', \Carbon\Carbon::now()->format('d/m/Y'), ['class'=>'form-control','placeholder' => 'Tgl Daftar', 'disabled'=>'']) !!}
            @else
                {!! Form::text('dtcrea', \Carbon\Carbon::parse($bgttkomite1->dtcrea)->format('d/m/Y'), ['class'=>'form-control','placeholder' => 'Tgl Daftar', 'disabled'=>'']) !!}
            @endif
            {!! $errors->first('dtcrea', '<p class="help-block">:message</p>') !!}
        </div>
		<div class="col-sm-3 {{ $errors->has('tgl_pengajuan') ? ' has-error' : '' }}">
			{!! Form::label('tgl_pengajuan', 'Tanggal Pengajuan (*)') !!}
			@if (empty($bgttkomite1->tgl_pengajuan))
				{!! Form::date('tgl_pengajuan', null, ['class'=>'form-control','placeholder' => 'Tgl Pengajuan', 'required', 'id' => 'tgl_pengajuan', 'onchange' => 'validateTgl()']) !!}
			@else
				{!! Form::date('tgl_pengajuan', \Carbon\Carbon::parse($bgttkomite1->tgl_pengajuan), ['class'=>'form-control','placeholder' => 'Tgl Pengajuan', 'required', 'id' => 'tgl_pengajuan', 'onchange' => 'validateTgl()']) !!}
			@endif
			{!! $errors->first('tgl_pengajuan', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<!-- /.form-group -->
	<div class="form-group">
		<div class="col-sm-7 {{ $errors->has('kd_dept') ? ' has-error' : '' }}">
			{!! Form::label('kd_dept', 'Departemen') !!}
			@if (empty($bgttkomite1->no_komite))
				{!! Form::text('kd_dept', \Auth::user()->masKaryawan()->kode_dep." - ".\Auth::user()->masKaryawan()->desc_dep, ['class'=>'form-control','placeholder' => 'Departemen', 'disabled'=>'']) !!}
				{!! Form::hidden('kode_dep', \Auth::user()->masKaryawan()->kode_dep, ['class'=>'form-control','placeholder' => 'Dept.', 'required', 'readonly'=>'readonly', 'id' => 'kode_dep']) !!}
			@else
				{!! Form::text('kd_dept', $bgttkomite1->kd_dept." - ".$bgttkomite1->namaDepartemen($bgttkomite1->kd_dept), ['class'=>'form-control','placeholder' => 'Departemen', 'disabled'=>'']) !!}
				{!! Form::hidden('kode_dep', $bgttkomite1->kd_dept, ['class'=>'form-control','placeholder' => 'Dept.', 'required', 'readonly'=>'readonly', 'id' => 'kode_dep']) !!}
			@endif
			{!! $errors->first('kd_dept', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<!-- /.form-group -->
	<div class="form-group">
		<div class="col-sm-2 {{ $errors->has('npk_presenter') ? ' has-error' : '' }}">
          {!! Form::label('npk_presenter', 'Presenter (*) (F9)') !!}
          <div class="input-group">
          	@if (empty($bgttkomite1->no_komite))
          		{!! Form::text('npk_presenter', \Auth::user()->username, ['class'=>'form-control','placeholder' => 'Presenter', 'maxlength' => 50, 'onkeydown' => 'keyPressedKaryawan(event)', 'onchange' => 'validateKaryawan()', 'id' => 'npk_presenter', 'required']) !!}
			@else
				{!! Form::text('npk_presenter', null, ['class'=>'form-control','placeholder' => 'Presenter', 'maxlength' => 50, 'onkeydown' => 'keyPressedKaryawan(event)', 'onchange' => 'validateKaryawan()', 'id' => 'npk_presenter', 'required']) !!}
			@endif
            <span class="input-group-btn">
              <button id="btnpopupkaryawan" type="button" class="btn btn-info" data-toggle="modal" data-target="#karyawanModal">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          </div>
          {!! $errors->first('npk_presenter', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-5 {{ $errors->has('nm_presenter') ? ' has-error' : '' }}">
          {!! Form::label('nm_presenter', 'Nama Presenter') !!}
          @if (empty($bgttkomite1->no_komite))
          	{!! Form::text('nm_presenter', \Auth::user()->name, ['class'=>'form-control','placeholder' => 'Nama Presenter', 'disabled'=>'', 'id' => 'nm_presenter']) !!}
          @else
          	{!! Form::text('nm_presenter', null, ['class'=>'form-control','placeholder' => 'Nama Presenter', 'disabled'=>'', 'id' => 'nm_presenter']) !!}
          @endif
          {!! $errors->first('nm_presenter', '<p class="help-block">:message</p>') !!}
        </div>
	</div>
	<!-- /.form-group -->
	<div class="form-group">
		<div class="col-sm-7 {{ $errors->has('topik') ? ' has-error' : '' }}">
      {!! Form::label('Topik', 'Topik (*)') !!}
      {!! Form::textarea('topik', null, ['class'=>'form-control', 'placeholder' => 'Topik', 'rows' => '3', 'maxlength' => 200, 'style' => 'resize:vertical', 'required', 'id' => 'topik']) !!}
      {!! $errors->first('topik', '<p class="help-block">:message</p>') !!}
    </div>
	</div>
	<!-- /.form-group -->
	<div class="form-group">
    <div class="col-sm-3 {{ $errors->has('jns_komite') ? ' has-error' : '' }}">
      {!! Form::label('jns_komite', 'Jenis Komite (*)') !!}
      {!! Form::select('jns_komite', ['IA' => 'IA', 'OPS' => 'OPS', 'HARGA' => 'HARGA'], null, ['class'=>'form-control select2', 'placeholder' => 'Pilih Jenis Komite', 'required', 'onchange' => 'changeJnsKomite()', 'id' => 'jns_komite']) !!}
      {!! $errors->first('jns_komite', '<p class="help-block">:message</p>') !!}
    </div>
		<div class="col-sm-4 {{ $errors->has('no_ie_ea') ? ' has-error' : '' }}">
    	{!! Form::label('no_ie_ea', 'No. IA/EA (*) (F9)') !!}
    	<div class="input-group">
    		{!! Form::text('no_ie_ea', null, ['class'=>'form-control','placeholder' => 'No. IA/EA', 'maxlength' => 20, 'onkeydown' => 'keyPressedNoIa(event)', 'onchange' => 'validateNoIa()', 'required']) !!}
    		<span class="input-group-btn">
    			<button id="btnpopupnoia" name="btnpopupnoia" type="button" class="btn btn-info" data-toggle="modal" data-target="#noiaModal">
    				<span class="glyphicon glyphicon-search"></span>
    			</button>
                <button id="btnmonitoring" name="btnmonitoring" type="button" class="btn btn-warning" data-toggle="modal" data-target="#monitoringModal">
                    <span class="glyphicon glyphicon-eye-open"></span>
                </button>
    		</span>
    	</div>
    	{!! $errors->first('no_ie_ea', '<p class="help-block">:message</p>') !!}
    </div>
	</div>
	<!-- /.form-group -->
	<div class="form-group">
    <div class="col-sm-7 {{ $errors->has('catatan') ? ' has-error' : '' }}">
      {!! Form::label('catatan', 'Catatan') !!}
      {!! Form::textarea('catatan', null, ['class'=>'form-control', 'placeholder' => 'Catatan', 'rows' => '3', 'maxlength' => 200, 'style' => 'resize:vertical', 'id' => 'catatan']) !!}
      {!! $errors->first('catatan', '<p class="help-block">:message</p>') !!}
    </div>
	</div>
	<!-- /.form-group -->
	<div class="form-group">
		<div class="col-sm-7 {{ $errors->has('support') ? ' has-error' : '' }}">
			{!! Form::label('support', 'Support User') !!}
			{!! Form::select('support[]', \DB::connection('oracle-usrbrgcorp')->table(DB::raw("usrhrcorp.v_mas_karyawan"))->select(DB::raw("npk||'-'||nama as nama, npk"))->whereRaw('tgl_keluar is null')->orderBy('npk')->pluck('nama', 'npk')->all(), null, ['class'=>'form-control select2', 'multiple'=>'multiple', 'data-placeholder' => 'Pilih User']) !!}
			{!! $errors->first('support', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<!-- /.form-group -->
    <div class="form-group">
        <div class="col-sm-7 {{ $errors->has('lok_file') ? ' has-error' : '' }}">
            {!! Form::label('lok_file', 'File') !!}
            {!! Form::file('lok_file', ['class'=>'form-control', 'style' => 'resize:vertical']) !!}
            @if (!empty($bgttkomite1->lok_file))
                <div class="box box-primary collapsed-box">
                    <div class="box-header with-border">
                      <h3 class="box-title" id="boxtitle">File</h3>
                      <div class="box-tools pull-right">
                        <a target="_blank" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Download File" href="{{ route('bgttkomite1s.downloadfile', base64_encode($bgttkomite1->no_komite)) }}">
                            <span class='glyphicon glyphicon-download-alt'></span>
                        </a>
                        <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button id="btndeletefile" name="btndeletefile" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus File" onclick="deleteFile()">
                            <i class="fa fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div class="row form-group">
                        <div class="col-sm-12">
                            <p>
                                <center>
                                    <iframe src="{{ $bgttkomite1->file($bgttkomite1->lok_file) }}" width="100%" height="300px"></iframe>
                                </center>
                            </p>
                        </div>
                      </div>
                      <!-- /.form-group -->
                    </div>
                    <!-- ./box-body -->
                </div>
                <!-- /.box -->
            @endif
            {!! $errors->first('lok_file', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <!-- /.form-group -->
</div>
<!-- /.box-body -->

<div class="box-footer">
  {!! Form::submit('Save as Draft', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  @if (!empty($bgttkomite1->no_komite))
    &nbsp;&nbsp;
    <button id="btn-submit" type="button" class="btn btn-success">Save & Submit</button>
    &nbsp;&nbsp;
    <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
  @endif
  &nbsp;&nbsp;
  <a class="btn btn-default" href="{{ route('bgttkomite1s.index') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

<!-- Modal Karyawan -->
@include('budget.komite.popup.karyawanModal')
<!-- Modal No. IA/EA -->
@include('budget.komite.popup.noiaModal')
@include('budget.komite.popup.noohModal')
@include('budget.komite.popup.monitoringModal')

@section('scripts')
<script type="text/javascript">

	document.getElementById("tgl_pengajuan").focus();

    HTMLTextAreaElement.prototype.getCaretPosition = function () { //return the caret position of the textarea
        return this.selectionStart;
    };
    HTMLTextAreaElement.prototype.setCaretPosition = function (position) { //change the caret position of the textarea
        this.selectionStart = position;
        this.selectionEnd = position;
        this.focus();
    };
    HTMLTextAreaElement.prototype.hasSelection = function () { //if the textarea has selection then return true
        if (this.selectionStart == this.selectionEnd) {
          return false;
      } else {
          return true;
      }
    };
    HTMLTextAreaElement.prototype.getSelectedText = function () { //return the selection text
        return this.value.substring(this.selectionStart, this.selectionEnd);
    };
    HTMLTextAreaElement.prototype.setSelection = function (start, end) { //change the selection area of the textarea
        this.selectionStart = start;
        this.selectionEnd = end;
        this.focus();
    };

    var topik = document.getElementById("topik");

    topik.onkeydown = function(event) {
        //support tab on textarea
        if (event.keyCode == 9) { //tab was pressed
          var newCaretPosition;
          newCaretPosition = topik.getCaretPosition() + "    ".length;
          topik.value = topik.value.substring(0, topik.getCaretPosition()) + "    " + topik.value.substring(topik.getCaretPosition(), topik.value.length);
          topik.setCaretPosition(newCaretPosition);
          return false;
        }
        if(event.keyCode == 8){ //backspace
          if (topik.value.substring(topik.getCaretPosition() - 4, topik.getCaretPosition()) == "    ") { //it's a tab space
            var newCaretPosition;
            newCaretPosition = topik.getCaretPosition() - 3;
            topik.value = topik.value.substring(0, topik.getCaretPosition() - 3) + topik.value.substring(topik.getCaretPosition(), topik.value.length);
            topik.setCaretPosition(newCaretPosition);
          }
        }
        if(event.keyCode == 37){ //left arrow
          var newCaretPosition;
          if (topik.value.substring(topik.getCaretPosition() - 4, topik.getCaretPosition()) == "    ") { //it's a tab space
            newCaretPosition = topik.getCaretPosition() - 3;
            topik.setCaretPosition(newCaretPosition);
          }
        }
        if(event.keyCode == 39){ //right arrow
          var newCaretPosition;
          if (topik.value.substring(topik.getCaretPosition() + 4, topik.getCaretPosition()) == "    ") { //it's a tab space
            newCaretPosition = topik.getCaretPosition() + 3;
            topik.setCaretPosition(newCaretPosition);
          }
        } 
    }

    var catatan = document.getElementById("catatan");

    catatan.onkeydown = function(event) {
        //support tab on textarea
        if (event.keyCode == 9) { //tab was pressed
          var newCaretPosition;
          newCaretPosition = catatan.getCaretPosition() + "    ".length;
          catatan.value = catatan.value.substring(0, catatan.getCaretPosition()) + "    " + catatan.value.substring(catatan.getCaretPosition(), catatan.value.length);
          catatan.setCaretPosition(newCaretPosition);
          return false;
        }
        if(event.keyCode == 8){ //backspace
          if (catatan.value.substring(catatan.getCaretPosition() - 4, catatan.getCaretPosition()) == "    ") { //it's a tab space
            var newCaretPosition;
            newCaretPosition = catatan.getCaretPosition() - 3;
            catatan.value = catatan.value.substring(0, catatan.getCaretPosition() - 3) + catatan.value.substring(catatan.getCaretPosition(), catatan.value.length);
            catatan.setCaretPosition(newCaretPosition);
          }
        }
        if(event.keyCode == 37){ //left arrow
          var newCaretPosition;
          if (catatan.value.substring(catatan.getCaretPosition() - 4, catatan.getCaretPosition()) == "    ") { //it's a tab space
            newCaretPosition = catatan.getCaretPosition() - 3;
            catatan.setCaretPosition(newCaretPosition);
          }
        }
        if(event.keyCode == 39){ //right arrow
          var newCaretPosition;
          if (catatan.value.substring(catatan.getCaretPosition() + 4, catatan.getCaretPosition()) == "    ") { //it's a tab space
            newCaretPosition = catatan.getCaretPosition() + 3;
            catatan.setCaretPosition(newCaretPosition);
          }
        } 
    }

	//Initialize Select2 Elements
    $(".select2").select2();

    function validasiSize() {
        $("input[name^='lok_file']").bind('change', function() {
            let filesize = this.files[0].size // On older browsers this can return NULL.
            let filesizeMB = (filesize / (1024*1024)).toFixed(2);
            if(filesizeMB > 8) {
                var info = "Size File tidak boleh > 8 MB";
                swal(info, "Perhatikan inputan anda!", "warning");
                this.value = null;
            }
        });
    }

    validasiSize();

    $("#btn-delete").click(function(){
    	var no_komite = document.getElementById("no_komite").value.trim();
    	var msg = 'Anda yakin menghapus No. Komite: ' + no_komite + '?';
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
    		var urlRedirect = "{{ route('bgttkomite1s.delete', 'param') }}";
    		urlRedirect = urlRedirect.replace('param', window.btoa(no_komite));
    		window.location.href = urlRedirect;
    	}, function (dismiss) {
    		if (dismiss === 'cancel') {
    		}
    	})
    });

    $("#btn-submit").click(function(){
        var no_komite = document.getElementById("no_komite").value.trim();
        var tgl_pengajuan = document.getElementById("tgl_pengajuan").value;
        var npk_presenter = document.getElementById("npk_presenter").value.trim();
        var topik = document.getElementById("topik").value.trim();
        var jns_komite = document.getElementById("jns_komite").value.trim();
        var no_ie_ea = document.getElementById("no_ie_ea").value.trim();

        valid_ia_ea = "T";
        if(jns_komite.toUpperCase() === "OPS" || jns_komite.toUpperCase() === "IA") {
          if(no_ie_ea === "") {
            valid_ia_ea = "F";
          }
        } else {
          document.getElementById("no_ie_ea").value = "";
          $('#no_ie_ea').removeAttr('required');
          $('#no_ie_ea').attr('readonly', 'readonly');
        }

        if(no_komite === "" || tgl_pengajuan === "" || npk_presenter === "" || topik === "" || jns_komite === "" || valid_ia_ea === "F") {
          var info = "Isi data yang tidak boleh kosong!";
          swal(info, "Perhatikan inputan anda!", "warning");
        } else {
            var info = "";
            var valid_tgl = "T";
            var tgl_pengajuan = document.getElementById("tgl_pengajuan").value.trim();
            if(tgl_pengajuan !== "") {
                var date_pengajuan = new Date(tgl_pengajuan);
                if(date_pengajuan.getDay() != 2 && date_pengajuan.getDay() != 4) {
                    document.getElementById("tgl_pengajuan").value = null;
                    setTglPengajuan();
                    document.getElementById("tgl_pengajuan").focus();
                    valid_tgl = "F";
                    info = "Tanggal Pengajuan harus hari selasa atau kamis!";
                } else {
                    var date_now = new Date();

                    var tahun_pengajuan = date_pengajuan.getFullYear();
                    var bulan_pengajuan = date_pengajuan.getMonth() + 1;
                    if(bulan_pengajuan < 10) {
                        bulan_pengajuan = "0" + bulan_pengajuan;
                    }
                    var tgl_pengajuan = date_pengajuan.getDate();
                    if(tgl_pengajuan < 10) {
                        tgl_pengajuan = "0" + tgl_pengajuan;
                    }
                    var tanggal_pengajuan = tahun_pengajuan + "" + bulan_pengajuan + "" + tgl_pengajuan;

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

                    if(tanggal_pengajuan <= tanggal_now) {
                        document.getElementById("tgl_pengajuan").value = null;
                        setTglPengajuan();
                        document.getElementById("tgl_pengajuan").focus();
                        valid_tgl = "F";
                        info = "Tanggal Pengajuan harus > Tanggal saat ini (" + tanggal_saatini + ")!";
                    }
                }
            } else {
                valid_tgl = "F";
                info = "Tanggal Pengajuan tidak boleh kosong!";
            }

            if(valid_tgl !== "T") {
                swal(info, "Perhatikan inputan anda!", "warning");
            } else {
                var msg = 'Anda yakin submit data ini?';
                var txt = 'No. Komite: ' + no_komite;
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
        }
    });

    $('#form_id').submit(function (e, params) {
    	var localParams = params || {};
    	if (!localParams.send) {
    		e.preventDefault();

    		var validasi = "T";
    		var msg = "";

    		if(validasi !== "T") {
    			var info = msg;
    			swal(info, "Perhatikan inputan anda!", "warning");
    		} else {
    			var valid = 'T';
    			var msg = "Anda yakin menyimpan data ini?";
    			var txt = "";

    			if(valid === 'T') {
    				swal({
    					title: msg,
    					text: txt,
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
    					if (dismiss === 'cancel') {
    					}
    				})
    			} else {
    				swal(msg, txt, "warning");
    			}
    		}
    	}
    });

    function refreshModal() {
        var jns_komite = document.getElementById('jns_komite').value.trim();
        if(jns_komite === "") {
            jns_komite = "-";
        }
        if(jns_komite === "OPS") {
            $('#btnpopupnoia').removeAttr('disabled');
            $('#btnpopupnoia').attr('data-target', '#noohModal');
            $('#no_ie_ea').removeAttr('readonly');
            $('#no_ie_ea').attr('required', 'required');
            $('#btnmonitoring').removeAttr('disabled');
        } else if(jns_komite === "IA") {
            $('#btnpopupnoia').removeAttr('disabled');
            $('#btnpopupnoia').attr('data-target', '#noiaModal');
            $('#no_ie_ea').removeAttr('readonly');
            $('#no_ie_ea').attr('required', 'required');
            $('#btnmonitoring').removeAttr('disabled');
        } else {
            $('#btnpopupnoia').attr('disabled', '');
            $('#no_ie_ea').attr('readonly', 'readonly');
            $('#no_ie_ea').removeAttr('required');
            $('#btnmonitoring').attr('disabled', '');
            document.getElementById("no_ie_ea").value = "";
        }
    }

    function changeJnsKomite() {
        refreshModal();
        validateNoIa();
    }

    refreshModal();

    function validateTgl() {
        var tgl_pengajuan = document.getElementById("tgl_pengajuan").value.trim();
        if(tgl_pengajuan !== "") {
            var date_pengajuan = new Date(tgl_pengajuan);
            if(date_pengajuan.getDay() != 2 && date_pengajuan.getDay() != 4) {
                document.getElementById("tgl_pengajuan").value = null;
                setTglPengajuan();
                document.getElementById("tgl_pengajuan").focus();
                swal("Tgl Pengajuan harus hari selasa atau kamis!", "Perhatikan inputan anda!", "error");
            } else {
                var date_now = new Date();

                var tahun_pengajuan = date_pengajuan.getFullYear();
                var bulan_pengajuan = date_pengajuan.getMonth() + 1;
                if(bulan_pengajuan < 10) {
                    bulan_pengajuan = "0" + bulan_pengajuan;
                }
                var tgl_pengajuan = date_pengajuan.getDate();
                if(tgl_pengajuan < 10) {
                    tgl_pengajuan = "0" + tgl_pengajuan;
                }
                var tanggal_pengajuan = tahun_pengajuan + "" + bulan_pengajuan + "" + tgl_pengajuan;

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

                if(tanggal_pengajuan <= tanggal_now) {
                    document.getElementById("tgl_pengajuan").value = null;
                    setTglPengajuan();
                    document.getElementById("tgl_pengajuan").focus();
                    var msg = "Tgl Pengajuan harus > Tanggal saat ini (" + tanggal_saatini + ")!";
                    swal(msg, "Perhatikan inputan anda!", "error");
                }
            }
        }
    }

    function setTglPengajuan() {
        var tgl_pengajuan = document.getElementById("tgl_pengajuan").value.trim();
        if(tgl_pengajuan == "") {
            var date_tomorrow = new Date();
            date_tomorrow.setDate(date_tomorrow.getDate() + 1);

            if(date_tomorrow.getDay() != 2 && date_tomorrow.getDay() != 4) {
                var valid = "T";
                if(date_tomorrow.getDay() == 0) {
                    date_tomorrow.setDate(date_tomorrow.getDate() + 2);
                } else if(date_tomorrow.getDay() == 1) {
                    date_tomorrow.setDate(date_tomorrow.getDate() + 1);
                } else if(date_tomorrow.getDay() == 3) {
                    date_tomorrow.setDate(date_tomorrow.getDate() + 1);
                } else if(date_tomorrow.getDay() == 5) {
                    date_tomorrow.setDate(date_tomorrow.getDate() + 4);
                } else if(date_tomorrow.getDay() == 6) {
                    date_tomorrow.setDate(date_tomorrow.getDate() + 3);
                } else {
                    valid = "F";
                }

                if(valid === "F") {
                    document.getElementById("tgl_pengajuan").value = null;
                } else {
                    var tahun = date_tomorrow.getFullYear();
                    var bulan = date_tomorrow.getMonth() + 1;
                    if(bulan < 10) {
                        bulan = "0" + bulan;
                    }
                    var tgl = date_tomorrow.getDate();
                    if(tgl < 10) {
                        tgl = "0" + tgl;
                    }
                    document.getElementById("tgl_pengajuan").value = tahun + "-" + bulan + "-" + tgl;
                }
            } else {
                var tahun = date_tomorrow.getFullYear();
                var bulan = date_tomorrow.getMonth() + 1;
                if(bulan < 10) {
                    bulan = "0" + bulan;
                }
                var tgl = date_tomorrow.getDate();
                if(tgl < 10) {
                    tgl = "0" + tgl;
                }
                document.getElementById("tgl_pengajuan").value = tahun + "-" + bulan + "-" + tgl;
            }
        }
    }

    setTglPengajuan();

    function keyPressedKaryawan(e) {
	    if(e.keyCode == 120) { //F9
	    	$('#btnpopupkaryawan').click();
	    } else if(e.keyCode == 9) { //TAB
	    	e.preventDefault();
	    	document.getElementById('topik').focus();
	    }
	}

	function keyPressedNoIa(e) {
	    if(e.keyCode == 120) { //F9
	    	$('#btnpopupnoia').click();
	    } else if(e.keyCode == 9) { //TAB
	    	e.preventDefault();
	    	document.getElementById('catatan').focus();
	    }
	}

    $(document).ready(function(){
    	$("#btnpopupkaryawan").click(function(){
    		popupKaryawan();
    	});

    	$("#btnpopupnoia").click(function(){
    		popupNoIa();
    	});

        $("#btnmonitoring").click(function(){
            popupMonitoring();
        });
	});

    function popupKaryawan() {
    	var myHeading = "<p>Popup Presenter</p>";
    	$("#karyawanModalLabel").html(myHeading);
    	var url = '{{ route('datatables.popupKaryawans') }}';
    	var lookupKaryawan = $('#lookupKaryawan').DataTable({
    		processing: true,
    		serverSide: true,
    		"pagingType": "numbers",
    		ajax: url,
    		"aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
    		responsive: true,
    		"order": [[1, 'asc']],
    		columns: [
    		{ data: 'npk', name: 'npk'},
    		{ data: 'nama', name: 'nama'},
    		{ data: 'kd_pt', name: 'kd_pt', className: 'none'},
    		{ data: 'desc_dep', name: 'desc_dep'},
    		{ data: 'desc_div', name: 'desc_div'},
    		{ data: 'email', name: 'email', className: 'none'}
    		],
    		"bDestroy": true,
    		"initComplete": function(settings, json) {
    			$('#lookupKaryawan tbody').on( 'dblclick', 'tr', function () {
    				var dataArr = [];
    				var rows = $(this);
    				var rowData = lookupKaryawan.rows(rows).data();
    				$.each($(rowData),function(key,value){
    					document.getElementById("npk_presenter").value = value["npk"];
    					document.getElementById("nm_presenter").value = value["nama"];
    					$('#karyawanModal').modal('hide');
    					validateKaryawan();
    				});
    			});
    			$('#karyawanModal').on('hidden.bs.modal', function () {
    				var npk_presenter = document.getElementById("npk_presenter").value.trim();
    				if(npk_presenter === '') {
    					document.getElementById("npk_presenter").value = "";
    					document.getElementById("nm_presenter").value = "";
    					$('#npk_presenter').focus();
    				} else {
    					$('#topik').focus();
    				}
    			});
    		},
    	});
    }

    function validateKaryawan() {
    	var npk_presenter = document.getElementById("npk_presenter").value.trim();
    	if(npk_presenter !== '') {
    		var url = '{{ route('datatables.validasiKaryawan', 'param') }}';
    		url = url.replace('param', window.btoa(npk_presenter));
    		$.get(url, function(result){  
    			if(result !== 'null'){
    				result = JSON.parse(result);
    				document.getElementById("npk_presenter").value = result["npk"];
    				document.getElementById("nm_presenter").value = result["nama"];
    			} else {
    				document.getElementById("npk_presenter").value = "";
    				document.getElementById("nm_presenter").value = "";
    				document.getElementById("npk_presenter").focus();
    				swal("Npk Presenter tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
    			}
    		});
    	} else {
    		document.getElementById("npk_presenter").value = "";
    		document.getElementById("nm_presenter").value = "";
    	}
	}

	function popupNoIa() {
        var kode_dep = document.getElementById('kode_dep').value.trim();
        var jns_komite = document.getElementById('jns_komite').value.trim();
        if(jns_komite === "") {
            jns_komite = "-";
        }
        if(jns_komite === "OPS") {
            var myHeading = "<p>Popup No. OH</p>";
            $("#noohModalLabel").html(myHeading);
            var url = '{{ route('datatables.popupNoIa', ['param','param2']) }}';
            url = url.replace('param2', window.btoa(jns_komite));
            url = url.replace('param', window.btoa(kode_dep));
            var lookupNooh = $('#lookupNooh').DataTable({
                processing: true,
                serverSide: true,
                "pagingType": "numbers",
                ajax: url,
                "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
                responsive: true,
                "order": [],
                columns: [
                { data: 'no_oh', name: 'no_oh'},
                { data: 'no_ia', name: 'no_ia'}
                ],
                "bDestroy": true,
                "initComplete": function(settings, json) {
                    $('#lookupNooh tbody').on( 'dblclick', 'tr', function () {
                        var dataArr = [];
                        var rows = $(this);
                        var rowData = lookupNooh.rows(rows).data();
                        $.each($(rowData),function(key,value){
                            document.getElementById("no_ie_ea").value = value["no_oh"];
                            $('#noohModal').modal('hide');
                        });
                    });
                    $('#noohModal').on('hidden.bs.modal', function () {
                        var no_ie_ea = document.getElementById("no_ie_ea").value.trim();
                        if(no_ie_ea === '') {
                            document.getElementById("no_ie_ea").value = "";
                            $('#no_ie_ea').focus();
                        } else {
                            $('#catatan').focus();
                        }
                    });
                },
            });
        } else {
    		var myHeading = "<p>Popup No. IA/EA</p>";
    		$("#noiaModalLabel").html(myHeading);
    		var url = '{{ route('datatables.popupNoIa', ['param','param2']) }}';
            url = url.replace('param2', window.btoa(jns_komite));
    		url = url.replace('param', window.btoa(kode_dep));
    		var lookupNoia = $('#lookupNoia').DataTable({
    			processing: true,
    			serverSide: true,
    			"pagingType": "numbers",
    			ajax: url,
    			"aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
    			responsive: true,
    			"order": [[2, 'desc'],[1, 'asc']],
    			columns: [
    			{ data: 'no_ia_ea', name: 'no_ia_ea'},
    			{ data: 'tgl_ia_ea', name: 'tgl_ia_ea'},
    			{ data: 'st_ia_ea', name: 'st_ia_ea'},
    			{ data: 'nm_jenis', name: 'nm_jenis'},
    			],
    			"bDestroy": true,
    			"initComplete": function(settings, json) {
    				$('#lookupNoia tbody').on( 'dblclick', 'tr', function () {
    					var dataArr = [];
    					var rows = $(this);
    					var rowData = lookupNoia.rows(rows).data();
    					$.each($(rowData),function(key,value){
    						document.getElementById("no_ie_ea").value = value["no_ia_ea"];
    						$('#noiaModal').modal('hide');
    					});
    				});
    				$('#noiaModal').on('hidden.bs.modal', function () {
    					var no_ie_ea = document.getElementById("no_ie_ea").value.trim();
    					if(no_ie_ea === '') {
    						document.getElementById("no_ie_ea").value = "";
    						$('#no_ie_ea').focus();
    					} else {
    						$('#catatan').focus();
    					}
    				});
    			},
    		});
        }
	}

	function validateNoIa() {
		var no_ie_ea = document.getElementById("no_ie_ea").value.trim();
		if(no_ie_ea !== '') {
            var kode_dep = document.getElementById('kode_dep').value.trim();
            var jns_komite = document.getElementById('jns_komite').value.trim();
            if(jns_komite === "") {
                jns_komite = "-";
            }
            if(jns_komite === "OPS") {
                var url = '{{ route('datatables.validasiNoIa', ['param','param2','param3']) }}';
                url = url.replace('param3', window.btoa(no_ie_ea));
                url = url.replace('param2', window.btoa(jns_komite));
                url = url.replace('param', window.btoa(kode_dep));
                $.get(url, function(result){  
                    if(result !== 'null'){
                        result = JSON.parse(result);
                        document.getElementById("no_ie_ea").value = result["no_oh"];
                    } else {
                        document.getElementById("no_ie_ea").value = "";
                        document.getElementById("no_ie_ea").focus();
                        swal("No. IA/EA tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
                    }
                });
            } else {
                var url = '{{ route('datatables.validasiNoIa', ['param','param2','param3']) }}';
                url = url.replace('param3', window.btoa(no_ie_ea));
                url = url.replace('param2', window.btoa(jns_komite));
                url = url.replace('param', window.btoa(kode_dep));
                $.get(url, function(result){  
                    if(result !== 'null'){
                        result = JSON.parse(result);
                        document.getElementById("no_ie_ea").value = result["no_ia_ea"];
                    } else {
                        document.getElementById("no_ie_ea").value = "";
                        document.getElementById("no_ie_ea").focus();
                        swal("No. IA/EA tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
                    }
                });
            }
		} else {
			document.getElementById("no_ie_ea").value = "";
		}
	}

    function popupMonitoring() {
        var no_ie_ea = document.getElementById('no_ie_ea').value.trim();
        if(no_ie_ea === "") {
            no_ie_ea = "-";
        }
        var jns_komite = document.getElementById('jns_komite').value.trim();
        var myHeading;
        var url;
        if(jns_komite === "OPS") {
            myHeading = "<p>Monitoring OH (" + no_ie_ea + ")</p>";
            url = '{{ route('datatables.popupMonitoringOH', 'param') }}';
        } else {
            myHeading = "<p>Monitoring IA/EA (" + no_ie_ea + ")</p>";
            url = '{{ route('datatables.popupMonitoringIA', 'param') }}';
        }
        $("#monitoringModalLabel").html(myHeading);
        url = url.replace('param', window.btoa(no_ie_ea));
        var lookupMonitoring = $('#lookupMonitoring').DataTable({
            processing: true,
            serverSide: true,
            paging: false, 
            searching: false, 
            "pagingType": "numbers",
            ajax: url,
            "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
            responsive: true,
            "order": [[0, 'asc']],
            columns: [
                { data: 'no_urut', name: 'no_urut', className: 'dt-right'},
                { data: 'progress', name: 'progress'}, 
                { data: 'npk_approve', name: 'npk_approve'}, 
                { data: 'tgl_approve', name: 'tgl_approve'}, 
                { data: 'remark', name: 'remark'}, 
                { data: 'std_hari', name: 'std_hari', className: 'dt-right'}, 
                { data: 'act_hari', name: 'act_hari', className: 'dt-right'}
            ],
            "bDestroy": true,
        });
    }

    function deleteFile() {
        var msg = 'Anda yakin menghapus File ini?';
        swal({
          title: msg,
          text: "",
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
          //startcode
          var no_komite = document.getElementById("no_komite").value.trim();

          var urlRedirect = "{{ route('bgttkomite1s.deletefile', 'param') }}";
          urlRedirect = urlRedirect.replace('param', window.btoa(no_komite));
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
</script>
@endsection