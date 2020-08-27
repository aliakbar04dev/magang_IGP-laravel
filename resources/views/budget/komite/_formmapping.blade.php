<div class="box-body">
	<div class="form-group">
		<div class="col-sm-2 {{ $errors->has('no_komite') ? ' has-error' : '' }}">
			{!! Form::label('no_komite', 'No. Komite') !!}
			{!! Form::text('no_komite', null, ['class'=>'form-control','placeholder' => 'No. Komite', 'required', 'disabled'=>'']) !!}
			{!! $errors->first('no_komite', '<p class="help-block">:message</p>') !!}
		</div>
    <div class="col-sm-2 {{ $errors->has('dtcrea') ? ' has-error' : '' }}">
      {!! Form::label('dtcrea', 'Tgl Daftar') !!}
      {!! Form::text('dtcrea', \Carbon\Carbon::parse($bgttkomite1->dtcrea)->format('d/m/Y'), ['class'=>'form-control','placeholder' => 'Tgl Daftar', 'disabled'=>'']) !!}
      {!! $errors->first('dtcrea', '<p class="help-block">:message</p>') !!}
    </div>
		<div class="col-sm-2 {{ $errors->has('tgl_pengajuan') ? ' has-error' : '' }}">
			{!! Form::label('tgl_pengajuan', 'Tanggal Pengajuan (*)') !!}
      {!! Form::text('dtcrea', \Carbon\Carbon::parse($bgttkomite1->tgl_pengajuan)->format('d/m/Y'), ['class'=>'form-control','placeholder' => 'Tanggal Pengajuan', 'disabled'=>'']) !!}
			{!! $errors->first('tgl_pengajuan', '<p class="help-block">:message</p>') !!}
		</div>
      <div class="col-sm-3 {{ $errors->has('tgl_komite_act') ? ' has-error' : '' }}">
        {!! Form::label('tgl_komite_act', 'Tanggal Komite Aktual') !!}
        @if (empty($bgttkomite1->tgl_komite_act))
          {!! Form::datetimelocal('tgl_komite_act', null, ['class'=>'form-control','placeholder' => 'Tgl Komite Aktual']) !!}
        @else
          {!! Form::datetimelocal('tgl_komite_act', \Carbon\Carbon::parse($bgttkomite1->tgl_komite_act), ['class'=>'form-control','placeholder' => 'Tgl Komite Aktual']) !!}
        @endif
        {!! $errors->first('tgl_komite_act', '<p class="help-block">:message</p>') !!}
      </div>
	</div>
	<!-- /.form-group -->
	<div class="form-group">
		<div class="col-sm-6 {{ $errors->has('kd_dept') ? ' has-error' : '' }}">
			{!! Form::label('kd_dept', 'Departemen') !!}
			{!! Form::text('kd_dept', $bgttkomite1->kd_dept." - ".$bgttkomite1->namaDepartemen($bgttkomite1->kd_dept), ['class'=>'form-control','placeholder' => 'Departemen', 'disabled'=>'']) !!}
      {!! Form::hidden('kode_dep', $bgttkomite1->kd_dept, ['class'=>'form-control','placeholder' => 'Dept.', 'required', 'readonly'=>'readonly', 'id' => 'kode_dep']) !!}
			{!! $errors->first('kd_dept', '<p class="help-block">:message</p>') !!}
		</div>
      <div class="col-sm-4 {{ $errors->has('lok_komite_act') ? ' has-error' : '' }}">
        {!! Form::label('lok_komite_act', 'Lokasi Komite') !!}
        {!! Form::select('lok_komite_act', \DB::connection('oracle-usrbrgcorp')->table(DB::raw("usrintra.meeting_mstr_ruangan"))->select(DB::raw("nama||' - '||id_ruangan as nama, id_ruangan"))->orderBy('id_ruangan')->pluck('nama', 'id_ruangan')->all(), null, ['class'=>'form-control select2', 'placeholder' => 'Pilih Lokasi Komite']) !!}
        {!! $errors->first('lok_komite_act', '<p class="help-block">:message</p>') !!}
      </div>
	</div>
	<!-- /.form-group -->
	<div class="form-group">
		<div class="col-sm-2 {{ $errors->has('npk_presenter') ? ' has-error' : '' }}">
          {!! Form::label('npk_presenter', 'Presenter (*) (F9)') !!}
          <div class="input-group">
          	{!! Form::text('npk_presenter', null, ['class'=>'form-control','placeholder' => 'Presenter', 'maxlength' => 50, 'onkeydown' => 'keyPressedKaryawan(event)', 'onchange' => 'validateKaryawan()', 'id' => 'npk_presenter', 'required', 'disabled'=>'']) !!}
            <span class="input-group-btn">
              <button id="btnpopupkaryawan" type="button" class="btn btn-info" data-toggle="modal" data-target="#karyawanModal" disabled="">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          </div>
          {!! $errors->first('npk_presenter', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-4 {{ $errors->has('nm_presenter') ? ' has-error' : '' }}">
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
		<div class="col-sm-6 {{ $errors->has('topik') ? ' has-error' : '' }}">
      {!! Form::label('Topik', 'Topik (*)') !!}
      {!! Form::textarea('topik', null, ['class'=>'form-control', 'placeholder' => 'Topik', 'rows' => '3', 'maxlength' => 200, 'style' => 'resize:vertical', 'required', 'id' => 'topik', 'disabled'=>'']) !!}
      {!! $errors->first('topik', '<p class="help-block">:message</p>') !!}
    </div>
	</div>
	<!-- /.form-group -->
	<div class="form-group">
    <div class="col-sm-3 {{ $errors->has('jns_komite') ? ' has-error' : '' }}">
      {!! Form::label('jns_komite', 'Jenis Komite (*)') !!}
      {!! Form::select('jns_komite', ['IA' => 'IA', 'OPS' => 'OPS', 'HARGA' => 'HARGA'], null, ['class'=>'form-control select2', 'placeholder' => 'Pilih Jenis Komite', 'required', 'disabled' => '']) !!}
      {!! $errors->first('jns_komite', '<p class="help-block">:message</p>') !!}
    </div>
		<div class="col-sm-3 {{ $errors->has('no_ie_ea') ? ' has-error' : '' }}">
    	{!! Form::label('no_ie_ea', 'No. IA/EA (*) (F9)') !!}
    	<div class="input-group">
    		{!! Form::text('no_ie_ea', null, ['class'=>'form-control','placeholder' => 'No. IA/EA', 'maxlength' => 20, 'onkeydown' => 'keyPressedNoIa(event)', 'onchange' => 'validateNoIa()', 'required', 'disabled'=>'']) !!}
    		<span class="input-group-btn">
    			<button id="btnpopupnoia" type="button" class="btn btn-info" data-toggle="modal" data-target="#noiaModal" disabled="">
    				<span class="glyphicon glyphicon-search"></span>
    			</button>
          <button id="btnmonitoring" name="btnmonitoring" type="button" class="btn btn-warning" data-toggle="modal" data-target="#monitoringModal" disabled="">
            <span class="glyphicon glyphicon-eye-open"></span>
          </button>
    		</span>
    	</div>
    	{!! $errors->first('no_ie_ea', '<p class="help-block">:message</p>') !!}
    </div>
	</div>
	<!-- /.form-group -->
	<div class="form-group">
    <div class="col-sm-6 {{ $errors->has('catatan') ? ' has-error' : '' }}">
      {!! Form::label('catatan', 'Catatan') !!}
      {!! Form::textarea('catatan', null, ['class'=>'form-control', 'placeholder' => 'Catatan', 'rows' => '3', 'maxlength' => 200, 'style' => 'resize:vertical', 'id' => 'catatan', 'disabled'=>'']) !!}
      {!! $errors->first('catatan', '<p class="help-block">:message</p>') !!}
    </div>
	</div>
	<!-- /.form-group -->
	<div class="form-group">
		<div class="col-sm-6 {{ $errors->has('support') ? ' has-error' : '' }}">
			{!! Form::label('support', 'Support User') !!}
			{!! Form::select('support[]', \DB::connection('oracle-usrbrgcorp')->table(DB::raw("usrhrcorp.v_mas_karyawan"))->select(DB::raw("npk||'-'||nama as nama, npk"))->whereRaw('tgl_keluar is null')->orderBy('npk')->pluck('nama', 'npk')->all(), null, ['class'=>'form-control select2', 'multiple'=>'multiple', 'data-placeholder' => 'Pilih User', 'disabled'=>'']) !!}
			{!! $errors->first('support', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<!-- /.form-group -->
  @if (!empty($bgttkomite1->lok_file))
    <div class="form-group">
      <div class="col-sm-6">
        <div class="box box-primary collapsed-box">
          <div class="box-header with-border">
            <h3 class="box-title" id="boxtitle">File</h3>
            <div class="box-tools pull-right">
              <a target="_blank" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Download File" href="{{ route('bgttkomite1s.downloadfile', base64_encode($bgttkomite1->no_komite)) }}">
                <span class='glyphicon glyphicon-download-alt'></span>
              </a>
              <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
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
      </div>
    </div>
    <!-- /.form-group -->
  @endif
</div>
<!-- /.box-body -->

<div class="box-footer">
  {!! Form::submit('Save Mapping Komite', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  &nbsp;&nbsp;
  <a class="btn btn-default" href="{{ route('bgttkomite1s.all') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

@include('budget.komite.popup.monitoringModal')

@section('scripts')
<script type="text/javascript">

	document.getElementById("tgl_komite_act").focus();

  function refreshModal() {
    var jns_komite = document.getElementById('jns_komite').value.trim();
    if(jns_komite === "") {
      jns_komite = "-";
    }
    if(jns_komite === "OPS") {
      $('#btnmonitoring').removeAttr('disabled');
    } else if(jns_komite === "IA") {
      $('#btnmonitoring').removeAttr('disabled');
    } else {
      $('#btnmonitoring').attr('disabled', '');
    }
  }

  refreshModal();

	//Initialize Select2 Elements
  $(".select2").select2();

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

  $(document).ready(function(){
    $("#btnmonitoring").click(function(){
      popupMonitoring();
    });
  });

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
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
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
</script>
@endsection