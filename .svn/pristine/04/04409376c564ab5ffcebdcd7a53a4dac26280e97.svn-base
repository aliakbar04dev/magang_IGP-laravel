<div class="box-body">
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('no_ssr') ? ' has-error' : '' }}">
      {!! Form::label('no_ssr', 'No. SSR') !!}
      @if (empty($prctssr1->no_ssr))
        {!! Form::text('no_ssr', null, ['class'=>'form-control','placeholder' => 'No. SSR', 'disabled'=>'', 'id' => 'no_ssr']) !!}
      @else
        {!! Form::text('no_ssr2', $prctssr1->no_ssr, ['class'=>'form-control','placeholder' => 'No. SSR', 'required', 'disabled'=>'', 'id' => 'no_ssr2']) !!}
        {!! Form::hidden('no_ssr', null, ['class'=>'form-control','placeholder' => 'No. SSR', 'required', 'readonly'=>'readonly', 'id' => 'no_ssr']) !!}
      @endif
      {!! Form::hidden('st_submit', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'st_submit']) !!}
      {!! $errors->first('no_ssr', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('tgl_ssr') ? ' has-error' : '' }}">
      {!! Form::label('tgl_ssr', 'Tanggal SSR (*)') !!}
      @if (empty($prctssr1->tgl_ssr))
        {!! Form::date('tgl_ssr', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl SSR', 'required']) !!}
      @else
        {!! Form::date('tgl_ssr', \Carbon\Carbon::parse($prctssr1->tgl_ssr), ['class'=>'form-control','placeholder' => 'Tgl SSR', 'required', 'readonly'=>'readonly']) !!}
      @endif
      {!! $errors->first('tgl_ssr', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-5 {{ $errors->has('nm_model') ? ' has-error' : '' }}">
      {!! Form::label('nm_model', 'Model (*)') !!}
      {!! Form::text('nm_model', null, ['class'=>'form-control', 'placeholder' => 'Model', 'maxlength'=>'40', 'required']) !!}
      {!! $errors->first('nm_model', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-5 {{ $errors->has('nm_drawing') ? ' has-error' : '' }}">
      {!! Form::label('nm_drawing', 'Drawing No. / Part No.') !!}
      {!! Form::text('nm_drawing', null, ['class'=>'form-control', 'placeholder' => 'Drawing No. / Part No.', 'maxlength'=>'50']) !!}
      {!! $errors->first('nm_drawing', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('dd_quot') ? ' has-error' : '' }}">
      {!! Form::label('dd_quot', 'Due Date Quotation (*)') !!}
      @if (empty($prctssr1->dd_quot))
        {!! Form::date('dd_quot', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Due Date Quotation', 'required']) !!}
      @else
        {!! Form::date('dd_quot', \Carbon\Carbon::parse($prctssr1->dd_quot), ['class'=>'form-control','placeholder' => 'Due Date Quotation', 'required']) !!}
      @endif
      {!! $errors->first('dd_quot', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-5 {{ $errors->has('support_doc') ? ' has-error' : '' }}">
      {!! Form::label('support_doc', 'Supporting Document') !!}
      {!! Form::text('support_doc', null, ['class'=>'form-control', 'placeholder' => 'Supporting Document', 'maxlength'=>'50']) !!}
      {!! $errors->first('support_doc', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-5 {{ $errors->has('tech_no') ? ' has-error' : '' }}">
      {!! Form::label('tech_no', 'Technical No.') !!}
      {!! Form::text('tech_no', null, ['class'=>'form-control', 'placeholder' => 'Technical No.', 'maxlength'=>'50']) !!}
      {!! $errors->first('tech_no', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('vol_prod_year') ? ' has-error' : '' }}">
      {!! Form::label('vol_prod_year', 'Volume Prod. / Years (*)') !!}
      {!! Form::number('vol_prod_year', null, ['class'=>'form-control', 'placeholder' => 'Volume Prod. / Years', 'min'=>'0', 'max'=>9999999999.99999, 'step'=>'any', 'required']) !!}
      {!! $errors->first('vol_prod_year', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('start_maspro') ? ' has-error' : '' }}">
      {!! Form::label('start_maspro', 'Start of Mass Prod. (*)') !!}
      @if (empty($prctssr1->start_maspro))
        {!! Form::date('start_maspro', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Due Date Quotation', 'required']) !!}
      @else
        {!! Form::date('start_maspro', \Carbon\Carbon::parse($prctssr1->start_maspro), ['class'=>'form-control','placeholder' => 'Due Date Quotation', 'required']) !!}
      @endif
      {!! $errors->first('start_maspro', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-5 {{ $errors->has('reason_of_req') ? ' has-error' : '' }}">
      {!! Form::label('reason_of_req', 'Reason of Request') !!}
      {!! Form::textarea('reason_of_req', null, ['class'=>'form-control', 'placeholder' => 'Reason of Request', 'rows' => '3', 'maxlength'=>'100', 'style' => 'resize:vertical']) !!}
      {!! $errors->first('reason_of_req', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-4 {{ $errors->has('subcont1') ? ' has-error' : '' }}">
      {!! Form::label('subcont1', 'Subcontractor References 1') !!}
      {!! Form::text('subcont1', null, ['class'=>'form-control', 'placeholder' => 'Subcontractor References 1', 'maxlength'=>'50']) !!}
      {!! $errors->first('subcont1', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-4 {{ $errors->has('subcont2') ? ' has-error' : '' }}">
      {!! Form::label('subcont2', 'Subcontractor References 2') !!}
      {!! Form::text('subcont2', null, ['class'=>'form-control', 'placeholder' => 'Subcontractor References 2', 'maxlength'=>'50']) !!}
      {!! $errors->first('subcont2', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-4 {{ $errors->has('subcont3') ? ' has-error' : '' }}">
      {!! Form::label('subcont3', 'Subcontractor References 3') !!}
      {!! Form::text('subcont3', null, ['class'=>'form-control', 'placeholder' => 'Subcontractor References 3', 'maxlength'=>'50']) !!}
      {!! $errors->first('subcont3', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-2 {{ $errors->has('er_usd') ? ' has-error' : '' }}">
      {!! Form::label('er_usd', 'Exchange Rate USD') !!}
      {!! Form::number('er_usd', null, ['class'=>'form-control', 'placeholder' => 'Exchange Rate USD', 'min'=>'0', 'max'=>9999999999.99999, 'step'=>'any']) !!}
      {!! $errors->first('er_usd', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('er_thb') ? ' has-error' : '' }}">
      {!! Form::label('er_thb', 'Exchange Rate THB') !!}
      {!! Form::number('er_thb', null, ['class'=>'form-control', 'placeholder' => 'Exchange Rate THB', 'min'=>'0', 'max'=>9999999999.99999, 'step'=>'any']) !!}
      {!! $errors->first('er_thb', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('er_krw') ? ' has-error' : '' }}">
      {!! Form::label('er_krw', 'Exchange Rate KRW') !!}
      {!! Form::number('er_krw', null, ['class'=>'form-control', 'placeholder' => 'Exchange Rate KRW', 'min'=>'0', 'max'=>9999999999.99999, 'step'=>'any']) !!}
      {!! $errors->first('er_krw', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('er_jpy') ? ' has-error' : '' }}">
      {!! Form::label('er_jpy', 'Exchange Rate JPY') !!}
      {!! Form::number('er_jpy', null, ['class'=>'form-control', 'placeholder' => 'Exchange Rate JPY', 'min'=>'0', 'max'=>9999999999.99999, 'step'=>'any']) !!}
      {!! $errors->first('er_jpy', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('er_cny') ? ' has-error' : '' }}">
      {!! Form::label('er_cny', 'Exchange Rate CNY') !!}
      {!! Form::number('er_cny', null, ['class'=>'form-control', 'placeholder' => 'Exchange Rate CNY', 'min'=>'0', 'max'=>9999999999.99999, 'step'=>'any']) !!}
      {!! $errors->first('er_cny', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('er_eur') ? ' has-error' : '' }}">
      {!! Form::label('er_eur', 'Exchange Rate EUR') !!}
      {!! Form::number('er_eur', null, ['class'=>'form-control', 'placeholder' => 'Exchange Rate EUR', 'min'=>'0', 'max'=>9999999999.99999, 'step'=>'any']) !!}
      {!! $errors->first('er_eur', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
</div>
<!-- /.box-body -->

<div class="box-body" id="field-detail">
  @if (!empty($prctssr1->no_ssr))
    @foreach ($prctssr1->prctSsr2s()->orderBy("dtcrea")->get() as $model)
      <div class="row" id="field_{{ $loop->iteration }}">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title" id="box_{{ $loop->iteration }}">Part Ke-{{ $loop->iteration }} ({{ $model->part_no }})</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
                <button id="btndelete_{{ $loop->iteration }}" name="btndelete_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Part" onclick="deleteDetail(this)">
                  <i class="fa fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row form-group">
                <div class="col-sm-3">
                  <label name="part_no_{{ $loop->iteration }}">Part No (*)</label>
                  <div class="input-group">
                    <input type="hidden" id="partno_{{ $loop->iteration }}" name="partno_{{ $loop->iteration }}" value="{{ $model->part_no }}" readonly="readonly">
                    <input type="text" id="part_no_{{ $loop->iteration }}" name="part_no_{{ $loop->iteration }}" required class="form-control" placeholder="Part No" onkeydown="keyPressedPart(this, event)" onchange="validatePart(this)" required maxlength="40" value="{{ $model->part_no }}" readonly="readonly">
                    <span class="input-group-btn">
                      <button id="btnpopuppartno_{{ $loop->iteration }}" name="btnpopuppartno_{{ $loop->iteration }}" type="button" class="btn btn-info" onclick="popupPart(this)" data-toggle="modal" data-target="#partModal" disabled="">
                        <span class="glyphicon glyphicon-search"></span>
                      </button>
                    </span>
                  </div>
                </div>
                <div class="col-sm-7">
                  <label name="part_name_{{ $loop->iteration }}">Part Name (*)</label>
                  <input type="text" id="part_name_{{ $loop->iteration }}" name="part_name_{{ $loop->iteration }}" class="form-control" placeholder="Part Name" required maxlength="100" readonly="readonly" value="{{ $model->nm_part }}">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-sm-3">
                  <label name="vol_month_{{ $loop->iteration }}">Vol/Month (*)</label>
                  <input type="number" id="vol_month_{{ $loop->iteration }}" name="vol_month_{{ $loop->iteration }}" required class="form-control" placeholder="Vol/Month" min="0" max="9999999999.99" step="any" value="{{ $model->vol_month }}">
                </div>
                <div class="col-sm-3">
                  <label name="nil_qpu_{{ $loop->iteration }}">QPU (*)</label>
                  <input type="number" id="nil_qpu_{{ $loop->iteration }}" name="nil_qpu_{{ $loop->iteration }}" required class="form-control" placeholder="QPU" min="0" max="9999999999.99" step="any" value="{{ $model->nil_qpu }}">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-sm-6">
                  <label name="nm_mat_{{ $loop->iteration }}">Material</label>
                  <textarea id="nm_mat_{{ $loop->iteration }}" name="nm_mat_{{ $loop->iteration }}" class="form-control" placeholder="Material" rows="3" maxlength="200" style="resize:vertical">{{ $model->nm_mat }}</textarea>
                </div>
                <div class="col-sm-6">
                  <label name="condition_{{ $loop->iteration }}">Condition</label>
                  {!! Form::select('condition_'.$loop->iteration.'[]', ['ASSEMBLING' => 'ASSEMBLING', 'CASTING' => 'CASTING', 'FORGING' => 'FORGING', 'STAMPING' => 'STAMPING', 'MACHINING' => 'MACHINING', 'PAINTING' => 'PAINTING', 'PLATING' => 'PLATING', 'PACKAGING' => 'PACKAGING', 'WELDING' => 'WELDING', 'PLASTIC' => 'PLASTIC', 'HEAT TREATMENT' => 'HEAT TREATMENT', 'SINTERING' => 'SINTERING', 'TUBE' => 'TUBE', 'ASSY PART' => 'ASSY PART'], $prctssr1->nmProses($model->part_no), ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Condition', 'id' => 'condition_'.$loop->iteration.'[]']) !!}
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    @endforeach
    {!! Form::hidden('jml_row', $prctssr1->prctSsr2s()->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row']) !!}
  @else
    {!! Form::hidden('jml_row', 0, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row']) !!}
  @endif
</div>
<!-- /.box-body -->

<div class="box-body">
  <p class="pull-right">
    <button id="addRow" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Detail"><span class="glyphicon glyphicon-plus"></span> Add Detail</button>
  </p>
</div>
<!-- /.box-body -->

<div class="box-footer">
  {!! Form::submit('Save SSR', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  @if (!empty($prctssr1->no_ssr))
    &nbsp;&nbsp;
    <button id="btn-submit" type="button" class="btn btn-success">Save & Submit SSR</button>
    &nbsp;&nbsp;
    <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
  @endif
  &nbsp;&nbsp;
  <a class="btn btn-default" href="{{ route('prctssr1s.index') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

<!-- Modal Part -->
@include('eproc.ssr.popup.partModal')

@section('scripts')
<script type="text/javascript">

  document.getElementById("tgl_ssr").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  $("#btn-delete").click(function(){
    var no_ssr = document.getElementById("no_ssr").value.trim();
    var msg = 'Anda yakin menghapus No. SSR: ' + no_ssr + '?';
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
      var urlRedirect = "{{ route('prctssr1s.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_ssr));
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
    var no_ssr = document.getElementById("no_ssr").value.trim();
    var tgl_ssr = document.getElementById("tgl_ssr").value;
    var nm_model = document.getElementById("nm_model").value.trim();
    var dd_quot = document.getElementById("dd_quot").value.trim();
    var vol_prod_year = document.getElementById("vol_prod_year").value.trim();
    var start_maspro = document.getElementById("start_maspro").value.trim();

    if(no_ssr === "" || tgl_ssr === "" || nm_model === "" || dd_quot === "" || vol_prod_year === "" || start_maspro === "") {
      var info = "Isi data yang tidak boleh kosong!";
      swal(info, "Perhatikan inputan anda!", "warning");
    } else {
      var msg = 'Anda yakin submit data ini?';
      var txt = 'No. SSR: ' + no_ssr;
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

  $(document).ready(function(){
    
  });

  function popupPart(ths) {
    var myHeading = "<p>Popup Part</p>";
    $("#partModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupBaanMpartPostgre') }}';
    var lookupPart = $('#lookupPart').DataTable({
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
        { data: 'item', name: 'item'},
        { data: 'desc1', name: 'desc1'},
        { data: 'itemdesc', name: 'itemdesc'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupPart tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupPart.rows(rows).data();
          $.each($(rowData),function(key,value){
            var row = ths.id.replace('btnpopuppartno_', '');
            var id_part_no = "part_no_" + row;
            var id_part_name = "part_name_" + row;
            document.getElementById(id_part_no).value = value["item"];
            if(value["desc1"] != null && value["desc1"].trim() != "") {
              document.getElementById(id_part_name).value = value["desc1"];
            } else {
              document.getElementById(id_part_name).value = value["itemdesc"];
            }
            $('#' + id_part_name).removeAttr('readonly');
            $('#' + id_part_name).attr('readonly', 'readonly');
            $('#partModal').modal('hide');
          });
        });
        $('#partModal').on('hidden.bs.modal', function () {
          var row = ths.id.replace('btnpopuppartno_', '');
          var id_part_no = "part_no_" + row;
          var id_part_name = "part_name_" + row;
          var id_vol_month = 'vol_month_'+row;
          var part_no = document.getElementById(id_part_no).value.trim();
          if(part_no === '') {
            document.getElementById(id_part_no).value = "";
            document.getElementById(id_part_name).value = "";
            $('#' + id_part_name).removeAttr('readonly');
            $('#' + id_part_name).attr('readonly', 'readonly');
            document.getElementById(id_part_no).focus();
          } else {
            document.getElementById(id_vol_month).focus();
          }
        });
      },
    });
  }

  function validatePart(ths) {
    var row = ths.id.replace('part_no_', '');
    var id_part_no = "part_no_" + row;
    var id_part_name = "part_name_" + row;
    var part_no = document.getElementById(id_part_no).value.trim();
    if(part_no !== '') {
      var url = '{{ route('datatables.validasiBaanMpartPostgre', 'param') }}';
      url = url.replace('param', window.btoa(part_no));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById(id_part_no).value = result["item"];
          if(result["desc1"] != null && result["desc1"].trim() != "") {
            document.getElementById(id_part_name).value = result["desc1"];
          } else {
            document.getElementById(id_part_name).value = result["itemdesc"];
          }
          $('#' + id_part_name).removeAttr('readonly');
          $('#' + id_part_name).attr('readonly', 'readonly');
        } else {
          document.getElementById(id_part_name).value = "";
          $('#' + id_part_name).removeAttr('readonly');
          document.getElementById(id_part_name).focus();
        }
      });
    } else {
      document.getElementById(id_part_no).value = "";
      document.getElementById(id_part_name).value = "";
      $('#' + id_part_name).removeAttr('readonly');
      $('#' + id_part_name).attr('readonly', 'readonly');
    }
  }

  function keyPressedPart(ths, e) {
    if(e.keyCode == 120) { //F9
      var row = ths.id.replace('part_no_', '');
      var id_btn = "#btnpopuppartno_" + row;
      $(id_btn).click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      var row = ths.id.replace('part_no_', '');
      row = Number(row);
      var part_name = 'part_name_'+row;
      document.getElementById(part_name).focus();
    }
  }

  $("#addRow").click(function(){
    var jml_row = document.getElementById("jml_row").value.trim();
    jml_row = Number(jml_row) + 1;
    document.getElementById("jml_row").value = jml_row;
    var partno = 'partno_'+jml_row;
    var part_no = 'part_no_'+jml_row;
    var part_name = 'part_name_'+jml_row;
    var vol_month = 'vol_month_'+jml_row;
    var nil_qpu = 'nil_qpu_'+jml_row;
    var nm_mat = 'nm_mat_'+jml_row;
    var condition = 'condition_'+jml_row + '[]';
    var btndelete = 'btndelete_'+jml_row;
    var id_field = 'field_'+jml_row;
    var id_box = 'box_'+jml_row;
    var btnpopuppartno = 'btnpopuppartno_'+jml_row;

    $("#field-detail").append(
      '<div class="row" id="'+id_field+'">\
        <div class="col-md-12">\
          <div class="box box-primary">\
            <div class="box-header with-border">\
              <h3 class="box-title" id="'+id_box+'">Part Ke-'+ jml_row +'</h3>\
              <div class="box-tools pull-right">\
                <button type="button" class="btn btn-success btn-sm" data-widget="collapse">\
                  <i class="fa fa-minus"></i>\
                </button>\
                <button id="' + btndelete + '" name="' + btndelete + '" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Part" onclick="deleteDetail(this)">\
                  <i class="fa fa-times"></i>\
                </button>\
              </div>\
            </div>\
            <div class="box-body">\
              <div class="row form-group">\
                <div class="col-sm-3">\
                  <label name="' + part_no + '">Part No (*)</label>\
                  <div class="input-group">\
                    <input type="hidden" id="' + partno + '" name="' + partno + '" value="0" readonly="readonly">\
                    <input type="text" id="' + part_no + '" name="' + part_no + '" required class="form-control" placeholder="Part No" onkeydown="keyPressedPart(this, event)" onchange="validatePart(this)" required maxlength="40">\
                    <span class="input-group-btn">\
                      <button id="' + btnpopuppartno + '" name="' + btnpopuppartno + '" type="button" class="btn btn-info" onclick="popupPart(this)" data-toggle="modal" data-target="#partModal">\
                        <span class="glyphicon glyphicon-search"></span>\
                      </button>\
                    </span>\
                  </div>\
                </div>\
                <div class="col-sm-7">\
                  <label name="' + part_name + '">Part Name (*)</label>\
                  <input type="text" id="' + part_name + '" name="' + part_name + '" class="form-control" placeholder="Part Name" required maxlength="100" readonly="readonly">\
                </div>\
              </div>\
              <div class="row form-group">\
                <div class="col-sm-3">\
                  <label name="' + vol_month + '">Vol/Month (*)</label>\
                  <input type="number" id="' + vol_month + '" name="' + vol_month + '" required class="form-control" placeholder="Vol/Month" min="0" max="9999999999.99" step="any">\
                </div>\
                <div class="col-sm-3">\
                  <label name="' + nil_qpu + '">QPU (*)</label>\
                  <input type="number" id="' + nil_qpu + '" name="' + nil_qpu + '" required class="form-control" placeholder="QPU" min="0" max="9999999999.99" step="any">\
                </div>\
              </div>\
              <div class="row form-group">\
                <div class="col-sm-6">\
                  <label name="' + nm_mat + '">Material</label>\
                  <textarea id="' + nm_mat + '" name="' + nm_mat + '" class="form-control" placeholder="Material" rows="3" maxlength="200" style="resize:vertical"></textarea>\
                </div>\
                <div class="col-sm-6">\
                  <label name="' + condition + '">Condition</label>\
                  <select id="' + condition + '" name="' + condition + '" class="form-control select2" multiple="multiple" data-placeholder="Pilih Condition">\
                    <option value="ASSEMBLING">ASSEMBLING</option>\
                    <option value="CASTING">CASTING</option>\
                    <option value="FORGING">FORGING</option>\
                    <option value="STAMPING">STAMPING</option>\
                    <option value="MACHINING">MACHINING</option>\
                    <option value="PAINTING">PAINTING</option>\
                    <option value="PLATING">PLATING</option>\
                    <option value="PACKAGING">PACKAGING</option>\
                    <option value="WELDING">WELDING</option>\
                    <option value="PLASTIC">PLASTIC</option>\
                    <option value="HEAT TREATMENT">HEAT TREATMENT</option>\
                    <option value="SINTERING">SINTERING</option>\
                  </select>\
                </div>\
              </div>\
            </div>\
          </div>\
        </div>\
      </div>'
    );
    $(".select2").select2();
    document.getElementById(part_no).focus();
  });

  function changeId(row) {
    var id_div = "#field_" + row;
    $(id_div).remove();
    var jml_row = document.getElementById("jml_row").value.trim();
    jml_row = Number(jml_row);
    nextRow = Number(row) + 1;
    for($i = nextRow; $i <= jml_row; $i++) {
      var partno = "#partno_" + $i;
      var partno_new = "partno_" + ($i-1);
      $(partno).attr({"id":partno_new, "name":partno_new});
      var part_no = "#part_no_" + $i;
      var part_no_new = "part_no_" + ($i-1);
      $(part_no).attr({"id":part_no_new, "name":part_no_new});
      var part_name = "#part_name_" + $i;
      var part_name_new = "part_name_" + ($i-1);
      $(part_name).attr({"id":part_name_new, "name":part_name_new});
      var vol_month = "#vol_month_" + $i;
      var vol_month_new = "vol_month_" + ($i-1);
      $(vol_month).attr({"id":vol_month_new, "name":vol_month_new});
      var nil_qpu = "#nil_qpu_" + $i;
      var nil_qpu_new = "nil_qpu_" + ($i-1);
      $(nil_qpu).attr({"id":nil_qpu_new, "name":nil_qpu_new});
      var nm_mat = "#nm_mat_" + $i;
      var nm_mat_new = "nm_mat_" + ($i-1);
      $(nm_mat).attr({"id":nm_mat_new, "name":nm_mat_new});
      var condition = document.getElementById("condition_" + $i + "[]");
      var condition_new = "condition_" + ($i-1) + "[]";
      condition.id = condition_new;
      condition.name = condition_new;
      var btndelete = "#btndelete_" + $i;
      var btndelete_new = "btndelete_" + ($i-1);
      $(btndelete).attr({"id":btndelete_new, "name":btndelete_new});
      var id_field = "#field_" + $i;
      var id_field_new = "field_" + ($i-1);
      $(id_field).attr({"id":id_field_new, "name":id_field_new});
      var id_box = "#box_" + $i;
      var id_box_new = "box_" + ($i-1);
      $(id_box).attr({"id":id_box_new, "name":id_box_new});
      var btnpopuppartno = "#btnpopuppartno_" + $i;
      var btnpopuppartno_new = "btnpopuppartno_" + ($i-1);
      $(btnpopuppartno).attr({"id":btnpopuppartno_new, "name":btnpopuppartno_new});
      var text = document.getElementById(id_box_new).innerHTML;
      text = text.replace($i, ($i-1));
      document.getElementById(id_box_new).innerHTML = text;
    }
    jml_row = jml_row - 1;
    document.getElementById("jml_row").value = jml_row;
  }

  function deleteDetail(ths) {
    var msg = 'Anda yakin menghapus Part ini?';
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
      var row = ths.id.replace('btndelete_', '');
      var info = "";
      var info2 = "";
      var info3 = "warning";
      var partno = document.getElementById("partno_" + row).value.trim();
      var part_no = document.getElementById("part_no_" + row).value.trim();
      var no_ssr = document.getElementById("no_ssr").value.trim();
      if(partno === "" || partno === "0") {
        changeId(row);
      } else {
        //DELETE DI DATABASE
        // remove these events;
        window.onkeydown = null;
        window.onfocus = null;
        var token = document.getElementsByName('_token')[0].value.trim();
        // delete via ajax
        // hapus data detail dengan ajax
        var url = "{{ route('prctssr1s.deletedetail', ['param','param2']) }}";
        url = url.replace('param2', window.btoa(part_no));
        url = url.replace('param', window.btoa(no_ssr));
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method : 'DELETE',
            // menambah csrf token dari Laravel
            _token  : token
          },
          success:function(data){
            if(data.status === 'OK'){
              changeId(row);
              info = "Deleted!";
              info2 = data.message;
              info3 = "success";
              swal(info, info2, info3);
            } else {
              info = "Cancelled";
              info2 = data.message;
              info3 = "error";
              swal(info, info2, info3);
            }
          }, error:function(){ 
            info = "System Error!";
            info2 = "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.";
            info3 = "error";
            swal(info, info2, info3);
          }
        });
        //END DELETE DI DATABASE
      }
      //finishcode
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