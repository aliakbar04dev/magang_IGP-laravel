<div class="box-body">
  {!! Form::hidden('no_rfq', null, ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'no_rfq']) !!}
  {!! Form::hidden('no_rev', null, ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'no_rev']) !!}
  {!! Form::hidden('st_rm', null, ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'st_rm']) !!}
  {!! Form::hidden('st_proses', null, ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'st_proses']) !!}
  {!! Form::hidden('st_ht', null, ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'st_ht']) !!}
  {!! Form::hidden('st_pur_part', null, ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'st_pur_part']) !!}
  {!! Form::hidden('st_tool', null, ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'st_tool']) !!}
  {!! Form::hidden('st_submit', null, ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'st_submit']) !!}
  {!! Form::hidden('jml_row_proses', $prctrfq->prctRfqProsess()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_proses']) !!}
  {!! Form::hidden('jml_row_ppart', $prctrfq->prctRfqPparts()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_ppart']) !!}
  {!! Form::hidden('jml_row_tool', $prctrfq->prctRfqTools()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_tool']) !!}
  <table class="table table-striped" cellspacing="0" width="100%">
    <tbody>
      <tr>
        <td style="width: 14%;"><b>No. RFQ</b></td>
        <td style="width: 1%;"><b>:</b></td>
        <td style="width: 15%;">{{ $prctrfq->no_rfq }}</td>
        <td style="width: 10%;"><b>Tgl RFQ</b></td>
        <td style="width: 1%;"><b>:</b></td>
        <td>{{ \Carbon\Carbon::parse($prctrfq->tgl_rfq)->format('d/m/Y') }}</td>
      </tr>
      <tr>
        <td style="width: 14%;"><b>No. Revisi</b></td>
        <td style="width: 1%;"><b>:</b></td>
        <td style="width: 15%;">{{ $prctrfq->no_rev }}</td>
        <td style="width: 10%;"><b>Tgl Revisi</b></td>
        <td style="width: 1%;"><b>:</b></td>
        <td>{{ \Carbon\Carbon::parse($prctrfq->tgl_rev)->format('d/m/Y') }}</td>
      </tr>
      <tr>
        <td style="width: 14%;"><b>No. SSR</b></td>
        <td style="width: 1%;"><b>:</b></td>
        <td style="width: 15%;">{{ $prctrfq->no_ssr }}</td>
        <td style="width: 10%;"><b>Condition</b></td>
        <td style="width: 1%;"><b>:</b></td>
        <td>{{ $prctrfq->nm_proses }}</td>
      </tr>
      <tr>
        <td style="width: 14%;"><b>Part No</b></td>
        <td style="width: 1%;"><b>:</b></td>
        <td style="width: 15%;">{{ $prctrfq->part_no }}</td>
        <td style="width: 10%;"><b>Part Name</b></td>
        <td style="width: 1%;"><b>:</b></td>
        <td>{{ $prctrfq->nm_part }}</td>
      </tr>
      <tr>
        <td style="width: 14%;"><b>Vol./Month</b></td>
        <td style="width: 1%;"><b>:</b></td>
        <td style="width: 15%;">{{ numberFormatter(0, 2)->format($prctrfq->vol_month) }}</td>
        <td style="width: 10%;"><b>Model</b></td>
        <td style="width: 1%;"><b>:</b></td>
        <td>{{ $prctrfq->ssr_nm_model }}</td>
      </tr>
      <tr>
        <td style="width: 14%;"><b>Exchange Rate</b></td>
        <td style="width: 1%;"><b>:</b></td>
        <td colspan="4">
          <table cellspacing="0" width="100%">
            <tr>
              <th style="width: 5%;text-align: center;">1 USD</th>
              <td style="width: 5%;text-align: center;">=</td>
              <td style="width: 10%;text-align: right;">{{ numberFormatter(0, 5)->format($prctrfq->ssr_er_usd) }}</td>
              <td style="width: 5%;text-align: center;">IDR</td>
              <th style="width: 10%;text-align: right;">1 THB</th>
              <td style="width: 5%;text-align: center;">=</td>
              <td style="width: 10%;text-align: right;">{{ numberFormatter(0, 5)->format($prctrfq->ssr_er_thb) }}</td>
              <td style="width: 5%;text-align: center;">IDR</td>
              <th style="width: 10%;text-align: right;">1 KRW</th>
              <td style="width: 5%;text-align: center;">=</td>
              <td style="width: 10%;text-align: right;">{{ numberFormatter(0, 5)->format($prctrfq->ssr_er_krw) }}</td>
              <td style="text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;IDR</td>
            </tr>
            <tr>
              <th style="width: 5%;text-align: center;">1 JPY</th>
              <td style="width: 5%;text-align: center;">=</td>
              <td style="width: 10%;text-align: right;">{{ numberFormatter(0, 5)->format($prctrfq->ssr_er_jpy) }}</td>
              <td style="width: 5%;text-align: center;">IDR</td>
              <th style="width: 10%;text-align: right;">1 CNY</th>
              <td style="width: 5%;text-align: center;">=</td>
              <td style="width: 10%;text-align: right;">{{ numberFormatter(0, 5)->format($prctrfq->ssr_er_cny) }}</td>
              <td style="width: 5%;text-align: center;">IDR</td>
              <th style="width: 10%;text-align: right;">1 EUR</th>
              <td style="width: 5%;text-align: center;">=</td>
              <td style="width: 10%;text-align: right;">{{ numberFormatter(0, 5)->format($prctrfq->ssr_er_eur) }}</td>
              <td style="text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;IDR</td>
            </tr>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
</div>
<!-- /.box-body -->

<ul class="nav nav-tabs" role="tablist">
  <li role="presentation" id="nav_rm">
    <a href="#rm" aria-controls="rm" role="tab" data-toggle="tab" title="1. Raw Material">
      1. Raw Material
    </a>
  </li>
  <li role="presentation" class="active" id="nav_proses">
    <a href="#proses" aria-controls="proses" role="tab" data-toggle="tab" title="2. Process">
      2. Process
    </a>
  </li>
  <li role="presentation" id="nav_ppart">
    <a href="#ppart" aria-controls="ppart" role="tab" data-toggle="tab" title="4. Purchase Part">
      3. Purchase Part
    </a>
  </li>
  <li role="presentation" id="nav_tool">
    <a href="#tool" aria-controls="tool" role="tab" data-toggle="tab" title="5. Tooling">
      4. Tooling
    </a>
  </li>
  <li role="presentation" id="nav_oth">
    <a href="#oth" aria-controls="oth" role="tab" data-toggle="tab" title="Others">
      Others
    </a>
  </li>
  <li role="presentation" id="nav_imp">
    <a href="#imp" aria-controls="imp" role="tab" data-toggle="tab" title="Others">
      For Import Part Only
    </a>
  </li>
</ul>
<!-- /.tablist -->

<div class="tab-content">
  <div role="tabpanel" class="tab-pane" id="rm">
    <div class="box-body">
      <div class="row form-group">
        <div class="col-sm-4 {{ $errors->has('ttl_mat') ? ' has-error' : '' }} pull-right">
          {!! Form::label('ttl_mat', 'Total (IDR)') !!}
          {!! Form::text('ttl_mat', !empty($prctrfq->prctRfqRm()) ? numberFormatter(0, 2)->format($prctrfq->prctRfqRm()->ttl_mat) : null, ['class'=>'form-control', 'placeholder' => 'Total (IDR)', 'id' => 'ttl_mat', 'disabled' => '', 'style' => 'text-align:right;']) !!}
          {!! $errors->first('ttl_mat', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.tabpanel -->
  <div role="tabpanel" class="tab-pane active" id="proses">
    <div class="box-body" id="field-proses">
      @foreach ($prctrfq->prctRfqProsess() as $model)
        <div class="row form-group" id="proses_field_{{ $loop->iteration }}">
          <div class="col-sm-2">
            <label name="proses_no_urut_{{ $loop->iteration }}">No. Urut (*)</label>
            <input type="number" id="proses_no_urut_{{ $loop->iteration }}" name="proses_no_urut_{{ $loop->iteration }}" required class="form-control" placeholder="No. Urut" min="1" max="9999999999" value="{{ $model->no_urut }}">
            <input type="hidden" id="proses_no_proses_{{ $loop->iteration }}" name="proses_no_proses_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ $model->no_proses }}">
          </div>
          <div class="col-sm-9">
            <label name="proses_nm_proses_{{ $loop->iteration }}">Nama Proses (*)</label>
            <input type="text" id="proses_nm_proses_{{ $loop->iteration }}" name="proses_nm_proses_{{ $loop->iteration }}" required class="form-control" placeholder="Nama Proses" maxlength="50" value="{{ $model->nm_proses }}">
          </div>
          <div class="col-sm-1">
            <label name="proses_btndelete_{{ $loop->iteration }}">Action</label>
            <button id="proses_btndelete_{{ $loop->iteration }}" name="proses_btndelete_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Proses" onclick="deleteProses(this)">
              <i class="fa fa-times"></i>
            </button>
          </div>
        </div>
        <!-- /.form-group -->
        <div class="row form-group" id="proses_field2_{{ $loop->iteration }}">
          <div class="col-sm-4">
            <label name="proses_mesin_type_{{ $loop->iteration }}">Machine Type/ Spec</label>
            <input type="text" id="proses_mesin_type_{{ $loop->iteration }}" name="proses_mesin_type_{{ $loop->iteration }}" class="form-control" placeholder="Machine Type/ Spec" maxlength="50" value="{{ $model->mesin_type }}">
          </div>
          <div class="col-sm-2">
            <label name="proses_ct_proses_dtk_{{ $loop->iteration }}">Cycle Time</label>
            <input type="number" id="proses_ct_proses_dtk_{{ $loop->iteration }}" name="proses_ct_proses_dtk_{{ $loop->iteration }}" class="form-control" placeholder="Cycle Time" max="9999999999.99" step="any" onchange="refreshTotal()" style="text-align:right;" value="{{ numberFormatterForm(0, 2)->format($model->ct_proses_dtk) }}">
          </div>
          <div class="col-sm-3">
            <label name="proses_pric_pros_idr_{{ $loop->iteration }}">Rate (IDR)</label>
            <input type="number" id="proses_pric_pros_idr_{{ $loop->iteration }}" name="proses_pric_pros_idr_{{ $loop->iteration }}" class="form-control" placeholder="Rate (IDR)" max="9999999999.99" step="any" onchange="refreshTotal()" style="text-align:right;" value="{{ numberFormatterForm(0, 2)->format($model->pric_pros_idr) }}">
          </div>
          <div class="col-sm-3">
            <label name="proses_ttl_proses_{{ $loop->iteration }}">Total (IDR)</label>
            <input type="text" id="proses_ttl_proses_{{ $loop->iteration }}" name="proses_ttl_proses_{{ $loop->iteration }}" class="form-control" placeholder="Total (IDR)" disabled="" style="text-align:right;" value="{{ numberFormatter(0, 2)->format($model->ttl_proses) }}">
          </div>
        </div>
        <!-- /.form-group -->
        <HR id="proses_hr_{{ $loop->iteration }}">
      @endforeach
    </div>
    <!-- /.box-body -->
    <div class="box-body">
      <p class="pull-right">
      <button id="addRowProses" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Proses"><span class="glyphicon glyphicon-plus"></span> Add Proses</button>
      </p>
    </div>
    <!-- /.box-body -->
    <div class="box-body">
      <div class="row form-group">
        <div class="col-sm-4 pull-right">
          <label name="proses_sub_total">Sub Total (IDR)</label>
          <input type="text" id="proses_sub_total" name="proses_sub_total" class="form-control" placeholder="Sub Total (IDR)" disabled="" style="text-align:right;">
        </div>
      </div>
      <!-- /.form-group -->
      <div class="row form-group">
        <div class="col-sm-4 pull-right">
          <label name="rm_proses_total">Material + Process Cost (IDR)</label>
          <input type="text" id="rm_proses_total" name="rm_proses_total" class="form-control" placeholder="Material + Process Cost (IDR)" disabled="" style="text-align:right;">
        </div>
      </div>
      <!-- /.form-group -->
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.tabpanel -->
  <div role="tabpanel" class="tab-pane" id="ppart">
    <div class="box-body" id="field-ppart">
      @foreach ($prctrfq->prctRfqPparts() as $model)
        <div class="row form-group" id="ppart_field_{{ $loop->iteration }}">
          <div class="col-sm-2">
            <label name="ppart_no_urut_{{ $loop->iteration }}">No. Urut (*)</label>
            <input type="number" id="ppart_no_urut_{{ $loop->iteration }}" name="ppart_no_urut_{{ $loop->iteration }}" required class="form-control" placeholder="No. Urut" min="1" max="9999999999" value="{{ $model->no_urut }}">
            <input type="hidden" id="ppart_no_ppart_{{ $loop->iteration }}" name="ppart_no_ppart_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ $model->no_ppart }}">
          </div>
          <div class="col-sm-5">
            <label name="ppart_nm_ppart_{{ $loop->iteration }}">Part Name (*)</label>
            <input type="text" id="ppart_nm_ppart_{{ $loop->iteration }}" name="ppart_nm_ppart_{{ $loop->iteration }}" required class="form-control" placeholder="Part Name" maxlength="50" value="{{ $model->nm_ppart }}">
          </div>
          <div class="col-sm-5">
            <label name="ppart_nm_spec_{{ $loop->iteration }}">Spec</label>
            <input type="text" id="ppart_nm_spec_{{ $loop->iteration }}" name="ppart_nm_spec_{{ $loop->iteration }}" class="form-control" placeholder="Spec" maxlength="50" value="{{ $model->nm_spec }}">
          </div>
        </div>
        <div class="row form-group" id="ppart_field2_{{ $loop->iteration }}">
          <div class="col-sm-2">
            <label name="ppart_pric_part_idr_{{ $loop->iteration }}">Price (IDR)</label>
            <input type="number" id="ppart_pric_part_idr_{{ $loop->iteration }}" name="ppart_pric_part_idr_{{ $loop->iteration }}" class="form-control" placeholder="Price (IDR)" max="9999999999.99" step="any" onchange="refreshTotal()" style="text-align:right;" value="{{ numberFormatterForm(0, 2)->format($model->pric_part_idr) }}">
          </div>
          <div class="col-sm-2">
            <label name="ppart_prs_fee_{{ $loop->iteration }}">Fee (%)</label>
            <input type="number" id="ppart_prs_fee_{{ $loop->iteration }}" name="ppart_prs_fee_{{ $loop->iteration }}" class="form-control" placeholder="Fee (%)" max="100" min="0" step="any" onchange="refreshTotal()" style="text-align:right;" value="{{ numberFormatterForm(0, 2)->format($model->prs_fee) }}">
          </div>
          <div class="col-sm-2">
            <label name="ppart_nil_fee_{{ $loop->iteration }}">Fee (IDR)</label>
            <input type="text" id="ppart_nil_fee_{{ $loop->iteration }}" name="ppart_nil_fee_{{ $loop->iteration }}" class="form-control" placeholder="Fee (IDR)" disabled="" style="text-align:right;" value="{{ numberFormatter(0, 2)->format($model->nil_fee) }}">
          </div>
          <div class="col-sm-2">
            <label name="ppart_qty_ppart_{{ $loop->iteration }}">QTY</label>
            <input type="number" id="ppart_qty_ppart_{{ $loop->iteration }}" name="ppart_qty_ppart_{{ $loop->iteration }}" class="form-control" placeholder="QTY" max="9999999999.99" step="any" onchange="refreshTotal()" style="text-align:right;" value="{{ numberFormatterForm(0, 2)->format($model->qty_ppart) }}">
          </div>
          <div class="col-sm-3">
            <label name="ppart_ttl_ppart_{{ $loop->iteration }}">Total (IDR)</label>
            <input type="text" id="ppart_ttl_ppart_{{ $loop->iteration }}" name="ppart_ttl_ppart_{{ $loop->iteration }}" class="form-control" placeholder="Total (IDR)" disabled="" style="text-align:right;" value="{{ numberFormatter(0, 2)->format($model->ttl_ppart) }}">
          </div>
          <div class="col-sm-1">
            <label name="ppart_btndelete_{{ $loop->iteration }}">Action</label>
            <button id="ppart_btndelete_{{ $loop->iteration }}" name="ppart_btndelete_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Purchase Part" onclick="deletePpart(this)">
              <i class="fa fa-times"></i>
            </button>
          </div>
        </div>
        <HR id="ppart_hr_{{ $loop->iteration }}">
      @endforeach
    </div>
    <!-- /.box-body -->
    <div class="box-body">
      <p class="pull-right">
      <button id="addRowPpart" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Purchase Part"><span class="glyphicon glyphicon-plus"></span> Add Purchase Part</button>
      </p>
    </div>
    <!-- /.box-body -->
    <div class="box-body">
      <div class="row form-group">
        <div class="col-sm-4 pull-right">
          <label name="ppart_sub_total">Sub Total (IDR)</label>
          <input type="text" id="ppart_sub_total" name="ppart_sub_total" class="form-control" placeholder="Sub Total (IDR)" disabled="" style="text-align:right;">
        </div>
      </div>
      <!-- /.form-group -->
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.tabpanel -->
  <div role="tabpanel" class="tab-pane" id="tool">
    <div class="box-body" id="field-tool">
      @foreach ($prctrfq->prctRfqTools() as $model)
        <div class="row form-group" id="tool_field_{{ $loop->iteration }}">
          <div class="col-sm-1">
            <label name="tool_no_urut_{{ $loop->iteration }}">Urut (*)</label>
            <input type="number" id="tool_no_urut_{{ $loop->iteration }}" name="tool_no_urut_{{ $loop->iteration }}" required class="form-control" placeholder="No. Urut" min="1" max="9999999999" value="{{ $model->no_urut }}">
            <input type="hidden" id="tool_no_tool_{{ $loop->iteration }}" name="tool_no_tool_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ $model->no_tool }}">
          </div>
          <div class="col-sm-4">
            <label name="tool_nm_tool_{{ $loop->iteration }}">Nama (*)</label>
            <input type="text" id="tool_nm_tool_{{ $loop->iteration }}" name="tool_nm_tool_{{ $loop->iteration }}" required class="form-control" placeholder="Nama" maxlength="50" value="{{ $model->nm_tool }}">
          </div>
          <div class="col-sm-2">
            <label name="tool_pric_tool_idr_{{ $loop->iteration }}">Price (IDR)</label>
            <input type="number" id="tool_pric_tool_idr_{{ $loop->iteration }}" name="tool_pric_tool_idr_{{ $loop->iteration }}" class="form-control" placeholder="Price (IDR)" max="9999999999.99" step="any" onchange="refreshTotal()" style="text-align:right;" value="{{ numberFormatterForm(0, 2)->format($model->pric_tool_idr) }}">
          </div>
          <div class="col-sm-2">
            <label name="tool_life_time_{{ $loop->iteration }}">Tool Life</label>
            <input type="number" id="tool_life_time_{{ $loop->iteration }}" name="tool_life_time_{{ $loop->iteration }}" class="form-control" placeholder="Tool Life" max="9999999999.99" step="any" onchange="refreshTotal()" style="text-align:right;" value="{{ numberFormatterForm(0, 2)->format($model->life_time) }}">
          </div>
          <div class="col-sm-2">
            <label name="tool_ttl_tool_{{ $loop->iteration }}">Total (IDR)</label>
            <input type="text" id="tool_ttl_tool_{{ $loop->iteration }}" name="tool_ttl_tool_{{ $loop->iteration }}" class="form-control" placeholder="Total (IDR)" disabled="" style="text-align:right;" value="{{ numberFormatter(0, 2)->format($model->ttl_tool) }}">
          </div>
          <div class="col-sm-1">
            <label name="tool_btndelete_{{ $loop->iteration }}">Action</label>
            <button id="tool_btndelete_{{ $loop->iteration }}" name="tool_btndelete_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Tooling" onclick="deleteTool(this)">
              <i class="fa fa-times"></i>
            </button>
          </div>
        </div>
        <HR id="tool_hr_{{ $loop->iteration }}">
      @endforeach
    </div>
    <!-- /.box-body -->
    <div class="box-body">
      <p class="pull-right">
      <button id="addRowTool" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Tooling"><span class="glyphicon glyphicon-plus"></span> Add Tooling</button>
      </p>
    </div>
    <!-- /.box-body -->
    <div class="box-body">
      <div class="row form-group">
        <div class="col-sm-4 pull-right">
          <label name="tool_sub_total">Sub Total (IDR)</label>
          <input type="text" id="tool_sub_total" name="tool_sub_total" class="form-control" placeholder="Sub Total (IDR)" disabled="" style="text-align:right;">
        </div>
      </div>
      <!-- /.form-group -->
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.tabpanel -->
  <div role="tabpanel" class="tab-pane" id="oth">
    <div class="box-body">
      <div class="row form-group">
        <div class="col-sm-2 {{ $errors->has('nil_transpor') ? ' has-error' : '' }}">
          {!! Form::label('nil_transpor', '5. Transport Cost') !!}
          {!! Form::number('nil_transpor', !empty($prctrfq) ? numberFormatterForm(0, 2)->format($prctrfq->nil_transpor) : null, ['class'=>'form-control', 'placeholder' => 'Transport Cost', 'max' => 9999999999.99, 'step' => 'any', 'id' => 'nil_transpor', 'onchange' => 'refreshTotal()', 'style' => 'text-align:right;']) !!}
          {!! $errors->first('nil_transpor', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-2 {{ $errors->has('nil_pack') ? ' has-error' : '' }}">
          {!! Form::label('nil_pack', '6. Packaging Cost') !!}
          {!! Form::number('nil_pack', !empty($prctrfq) ? numberFormatterForm(0, 2)->format($prctrfq->nil_pack) : null, ['class'=>'form-control', 'placeholder' => 'Packaging Cost', 'max' => 9999999999.99, 'step' => 'any', 'id' => 'nil_pack', 'onchange' => 'refreshTotal()', 'style' => 'text-align:right;']) !!}
          {!! $errors->first('nil_pack', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-2 {{ $errors->has('prs_admin') ? ' has-error' : '' }}">
          {!! Form::label('prs_admin', 'Admin Cost (%)') !!}
          {!! Form::number('prs_admin', !empty($prctrfq) ? numberFormatterForm(0, 2)->format($prctrfq->prs_admin) : null, ['class'=>'form-control', 'placeholder' => 'Admin Cost (%)', 'max' => 100, 'min' => 0, 'step' => 'any', 'id' => 'prs_admin', 'onchange' => 'refreshTotal()', 'style' => 'text-align:right;']) !!}
          {!! $errors->first('prs_admin', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-2 {{ $errors->has('nil_admin') ? ' has-error' : '' }}">
          {!! Form::label('nil_admin', '7. Administration Cost') !!}
          {!! Form::text('nil_admin', !empty($prctrfq) ? numberFormatter(0, 2)->format($prctrfq->nil_admin) : null, ['class'=>'form-control', 'placeholder' => '8. Administration Cost', 'id' => 'nil_admin', 'style' => 'text-align:right;', 'disabled' => '']) !!}
          {!! $errors->first('nil_admin', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-2 {{ $errors->has('prs_profit') ? ' has-error' : '' }}">
          {!! Form::label('prs_profit', 'Profit (%)') !!}
          {!! Form::number('prs_profit', !empty($prctrfq) ? numberFormatterForm(0, 2)->format($prctrfq->prs_profit) : null, ['class'=>'form-control', 'placeholder' => 'Profit (%)', 'max' => 100, 'min' => 0, 'step' => 'any', 'id' => 'prs_profit', 'onchange' => 'refreshTotal()', 'style' => 'text-align:right;']) !!}
          {!! $errors->first('prs_profit', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-2 {{ $errors->has('nil_profit') ? ' has-error' : '' }}">
          {!! Form::label('nil_profit', '8. Profit') !!}
          {!! Form::text('nil_profit', !empty($prctrfq) ? numberFormatter(0, 2)->format($prctrfq->nil_profit) : null, ['class'=>'form-control', 'placeholder' => '9. Profit', 'id' => 'nil_profit', 'style' => 'text-align:right;', 'disabled' => '']) !!}
          {!! $errors->first('nil_profit', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
      <div class="row form-group">
        <div class="col-sm-4 pull-right">
          <label name="part_price">Total (IDR)</label>
          <input type="text" id="part_price" name="part_price" class="form-control" placeholder="Total (IDR)" disabled="" style="text-align:right;">
        </div>
      </div>
      <!-- /.form-group -->
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.tabpanel -->
  <div role="tabpanel" class="tab-pane" id="imp">
    <div class="box-body">
      <div class="row form-group">
        <div class="col-sm-3 {{ $errors->has('nil_fob_usd') ? ' has-error' : '' }}">
          {!! Form::label('nil_fob_usd', '9. In-line Cost (FOB) (USD)') !!}
          {!! Form::number('nil_fob_usd', !empty($prctrfq) ? numberFormatterForm(0, 2)->format($prctrfq->nil_fob_usd) : null, ['class'=>'form-control', 'placeholder' => 'In-line Cost (FOB) (USD)', 'max' => 9999999999.99, 'step' => 'any', 'id' => 'nil_fob_usd', 'onchange' => 'refreshTotal()', 'style' => 'text-align:right;']) !!}
          {!! $errors->first('nil_fob_usd', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-3 {{ $errors->has('nil_fob') ? ' has-error' : '' }}">
          {!! Form::label('nil_fob', 'In-line Cost (FOB) (IDR)') !!}
          {!! Form::text('nil_fob', !empty($prctrfq) ? numberFormatter(0, 2)->format($prctrfq->nil_fob) : null, ['class'=>'form-control', 'placeholder' => 'In-line Cost (FOB) (IDR)', 'id' => 'nil_fob', 'style' => 'text-align:right;', 'disabled' => '']) !!}
          {!! $errors->first('nil_fob', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-3 {{ $errors->has('nil_cif_usd') ? ' has-error' : '' }}">
          {!! Form::label('nil_cif_usd', '10. Freight Cost (CIF) (USD)') !!}
          {!! Form::number('nil_cif_usd', !empty($prctrfq) ? numberFormatterForm(0, 2)->format($prctrfq->nil_cif_usd) : null, ['class'=>'form-control', 'placeholder' => 'Freight Cost (CIF) (USD)', 'max' => 9999999999.99, 'step' => 'any', 'id' => 'nil_cif_usd', 'onchange' => 'refreshTotal()', 'style' => 'text-align:right;']) !!}
          {!! $errors->first('nil_cif_usd', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-3 {{ $errors->has('nil_cif') ? ' has-error' : '' }}">
          {!! Form::label('nil_cif', 'Freight Cost (CIF) (IDR)') !!}
          {!! Form::text('nil_cif', !empty($prctrfq) ? numberFormatter(0, 2)->format($prctrfq->nil_cif) : null, ['class'=>'form-control', 'placeholder' => 'Freight Cost (CIF) (IDR)', 'id' => 'nil_cif', 'style' => 'text-align:right;', 'disabled' => '']) !!}
          {!! $errors->first('nil_cif', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.tabpanel -->
</div>
<!-- /.tab-content -->

<HR>

<div class="box-body">
  <div class="row form-group">
    <div class="col-sm-4 {{ $errors->has('nil_diskon') ? ' has-error' : '' }} pull-right">
      {!! Form::label('nil_diskon', 'Diskon (IDR)') !!}
      {!! Form::number('nil_diskon', !empty($prctrfq) ? numberFormatterForm(0, 2)->format($prctrfq->nil_diskon) : null, ['class'=>'form-control', 'placeholder' => 'Diskon (IDR)', 'max' => 9999999999.99, 'step' => 'any', 'id' => 'nil_diskon', 'onchange' => 'refreshTotal()', 'style' => 'text-align:right;']) !!}
      {!! $errors->first('nil_diskon', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="row form-group">
    <div class="col-sm-4 pull-right">
      <label name="nil_total">Grand Total (IDR)</label>
      <input type="text" id="nil_total" name="nil_total" class="form-control" placeholder="Grand Total (IDR)" disabled="" style="text-align:right;">
    </div>
  </div>
  <!-- /.form-group -->
</div>
<!-- /.box-body -->

<div class="box-footer">
  {!! Form::submit('Save Quotation', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  &nbsp;&nbsp;
  <button id="btn-submit" type="button" class="btn btn-success">Submit Quotation</button>
  &nbsp;&nbsp;
  <a class="btn btn-default" href="{{ route('prctrfqs.indexall') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

@section('scripts')
<script type="text/javascript">

  $("#btn-submit").click(function(){
    var no_rfq = document.getElementById('no_rfq').value.trim();
    var no_rev = document.getElementById('no_rev').value.trim();

    var msg = 'Anda yakin Submit Quotation ini?';
    var txt = 'No. RFQ: ' + no_rfq + ', No. Revisi: ' + no_rev;
    swal({
      title: msg,
      text: txt,
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, Submit Quotation!',
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
          document.getElementById("st_submit").value = "F";
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

  function refreshTab() {
    var st_rm = document.getElementById("st_rm").value.trim();
    var st_proses = document.getElementById("st_proses").value.trim();
    var st_pur_part = document.getElementById("st_pur_part").value.trim();
    var st_tool = document.getElementById("st_tool").value.trim();

    if(st_proses === "T") {
      $("#rm").removeClass("active");
      $("#proses").addClass("active");
      $("#ppart").removeClass("active");
      $("#tool").removeClass("active");
      $("#oth").removeClass("active");
      $("#imp").removeClass("active");

      $("#nav_rm").removeClass("active");
      $("#nav_proses").addClass("active");
      $("#nav_ppart").removeClass("active");
      $("#nav_tool").removeClass("active");
      $("#nav_oth").removeClass("active");
      $("#nav_imp").removeClass("active");

      document.getElementById("addRowProses").focus();
    } else if(st_pur_part === "T") {
      $("#rm").removeClass("active");
      $("#proses").removeClass("active");
      $("#ppart").addClass("active");
      $("#tool").removeClass("active");
      $("#oth").removeClass("active");
      $("#imp").removeClass("active");

      $("#nav_rm").removeClass("active");
      $("#nav_proses").removeClass("active");
      $("#nav_ppart").addClass("active");
      $("#nav_tool").removeClass("active");
      $("#nav_oth").removeClass("active");
      $("#nav_imp").removeClass("active");
    } else if(st_tool === "T") {
      $("#rm").removeClass("active");
      $("#proses").removeClass("active");
      $("#ppart").removeClass("active");
      $("#tool").addClass("active");
      $("#oth").removeClass("active");
      $("#imp").removeClass("active");

      $("#nav_rm").removeClass("active");
      $("#nav_proses").removeClass("active");
      $("#nav_ppart").removeClass("active");
      $("#nav_tool").addClass("active");
      $("#nav_oth").removeClass("active");
      $("#nav_imp").removeClass("active");
    }
  }

  refreshTab();

  $(document).ready(function(){
    
  });

  // Menghilangkan format currency
  // .replace(/,(?=.*\.\d+)/g, '')

  function refreshTotal() {
    var ssr_er_usd = {{ $prctrfq->ssr_er_usd }};
    ssr_er_usd = Number(ssr_er_usd);

    //1. Raw Material
    var ttl_mat = 0;
    document.getElementById("ttl_mat").value = ttl_mat.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

    //2. Process
    var jml_row_proses = document.getElementById("jml_row_proses").value.trim();
    jml_row_proses = Number(jml_row_proses);

    var proses_sub_total = 0;
    for($i = 1; $i <= jml_row_proses; $i++) {
      var ct_proses_dtk = document.getElementById("proses_ct_proses_dtk_" + $i).value.trim();
      ct_proses_dtk = Number(ct_proses_dtk);
      var pric_pros_idr = document.getElementById("proses_pric_pros_idr_" + $i).value.trim();
      pric_pros_idr = Number(pric_pros_idr);

      var ttl_proses = ct_proses_dtk * pric_pros_idr;
      document.getElementById("proses_ttl_proses_" + $i).value = ttl_proses.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

      proses_sub_total = proses_sub_total + ttl_proses;
    }

    document.getElementById("proses_sub_total").value = proses_sub_total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

    var rm_proses_total = ttl_mat + proses_sub_total;
    document.getElementById("rm_proses_total").value = rm_proses_total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

    //3. Purchase Part
    var jml_row_ppart = document.getElementById("jml_row_ppart").value.trim();
    jml_row_ppart = Number(jml_row_ppart);

    var ppart_sub_total = 0;
    for($i = 1; $i <= jml_row_ppart; $i++) {
      var pric_part_idr = document.getElementById("ppart_pric_part_idr_" + $i).value.trim();
      pric_part_idr = Number(pric_part_idr);

      var prs_fee = document.getElementById("ppart_prs_fee_" + $i).value.trim();
      prs_fee = Number(prs_fee);

      var nil_fee = pric_part_idr * prs_fee / 100;
      document.getElementById("ppart_nil_fee_" + $i).value = nil_fee.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

      var qty_ppart = document.getElementById("ppart_qty_ppart_" + $i).value.trim();
      qty_ppart = Number(qty_ppart);

      var ttl_ppart = (pric_part_idr + nil_fee) * qty_ppart;
      document.getElementById("ppart_ttl_ppart_" + $i).value = ttl_ppart.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

      ppart_sub_total = ppart_sub_total + ttl_ppart;
    }
    document.getElementById("ppart_sub_total").value = ppart_sub_total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

    //4. Tooling
    var jml_row_tool = document.getElementById("jml_row_tool").value.trim();
    jml_row_tool = Number(jml_row_tool);

    var tool_sub_total = 0;
    for($i = 1; $i <= jml_row_tool; $i++) {
      var pric_tool_idr = document.getElementById("tool_pric_tool_idr_" + $i).value.trim();
      pric_tool_idr = Number(pric_tool_idr);
      var life_time = document.getElementById("tool_life_time_" + $i).value.trim();
      life_time = Number(life_time);      

      var ttl_tool = 0;
      if(life_time > 0) {
        ttl_tool = pric_tool_idr / life_time;
      }
      document.getElementById("tool_ttl_tool_" + $i).value = ttl_tool.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

      tool_sub_total = tool_sub_total + ttl_tool;
    }
    document.getElementById("tool_sub_total").value = tool_sub_total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

    //Others
    var nil_transpor = document.getElementById("nil_transpor").value.trim();
    nil_transpor = Number(nil_transpor);
    var nil_pack = document.getElementById("nil_pack").value.trim();
    nil_pack = Number(nil_pack);

    var prs_admin = document.getElementById("prs_admin").value.trim();
    prs_admin = Number(prs_admin);

    var nil_admin = rm_proses_total * prs_admin / 100;
    document.getElementById("nil_admin").value = nil_admin.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

    var prs_profit = document.getElementById("prs_profit").value.trim();
    prs_profit = Number(prs_profit);

    var nil_profit = proses_sub_total * prs_profit / 100;
    document.getElementById("nil_profit").value = nil_profit.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

    var part_price = ttl_mat + proses_sub_total + ppart_sub_total + tool_sub_total + nil_transpor + nil_pack + nil_admin + nil_profit;
    document.getElementById("part_price").value = part_price.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

    //For import part only
    var nil_fob_usd = document.getElementById("nil_fob_usd").value.trim();
    nil_fob_usd = Number(nil_fob_usd);
    var nil_fob = nil_fob_usd * ssr_er_usd;
    document.getElementById("nil_fob").value = nil_fob.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

    var nil_cif_usd = document.getElementById("nil_cif_usd").value.trim();
    nil_cif_usd = Number(nil_cif_usd);
    var nil_cif = nil_cif_usd * ssr_er_usd;
    document.getElementById("nil_cif").value = nil_cif.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

    var nil_diskon = document.getElementById("nil_diskon").value.trim();
    nil_diskon = Number(nil_diskon);

    var nil_total = part_price + nil_fob + nil_cif - nil_diskon;
    document.getElementById("nil_total").value = nil_total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
  }

  refreshTotal();

  $("#addRowProses").click(function(){
    var jml_row_proses = document.getElementById("jml_row_proses").value.trim();
    jml_row_proses = Number(jml_row_proses) + 1;
    document.getElementById("jml_row_proses").value = jml_row_proses;

    var proses_no_proses = 'proses_no_proses_'+jml_row_proses;
    var proses_no_urut = 'proses_no_urut_'+jml_row_proses;
    var proses_nm_proses = 'proses_nm_proses_'+jml_row_proses;
    var proses_mesin_type = 'proses_mesin_type_'+jml_row_proses;
    var proses_ct_proses_dtk = 'proses_ct_proses_dtk_'+jml_row_proses;
    var proses_pric_pros_idr = 'proses_pric_pros_idr_'+jml_row_proses;
    var proses_ttl_proses = 'proses_ttl_proses_'+jml_row_proses;
    var proses_btndelete = 'proses_btndelete_'+jml_row_proses;
    var proses_id_field = 'proses_field_'+jml_row_proses;
    var proses_id_field2 = 'proses_field2_'+jml_row_proses;
    var proses_id_hr = 'proses_hr_'+jml_row_proses;

    $("#field-proses").append(
      '<div class="row form-group" id="' + proses_id_field + '">\
        <div class="col-sm-2">\
          <label name="' + proses_no_urut + '">No. Urut (*)</label>\
          <input type="number" id="' + proses_no_urut + '" name="' + proses_no_urut + '" required class="form-control" placeholder="No. Urut" min="1" max="9999999999">\
          <input type="hidden" id="' + proses_no_proses + '" name="' + proses_no_proses + '" class="form-control" readonly="readonly">\
        </div>\
        <div class="col-sm-9">\
          <label name="' + proses_nm_proses + '">Nama Proses (*)</label>\
          <input type="text" id="' + proses_nm_proses + '" name="' + proses_nm_proses + '" required class="form-control" placeholder="Nama Proses" maxlength="50">\
        </div>\
        <div class="col-sm-1">\
          <label name="' + proses_btndelete + '">Action</label>\
          <button id="' + proses_btndelete + '" name="' + proses_btndelete + '" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Proses" onclick="deleteProses(this)">\
            <i class="fa fa-times"></i>\
          </button>\
        </div>\
      </div>\
      <div class="row form-group" id="' + proses_id_field2 + '">\
        <div class="col-sm-4">\
          <label name="' + proses_mesin_type + '">Machine Type/ Spec</label>\
          <input type="text" id="' + proses_mesin_type + '" name="' + proses_mesin_type + '" class="form-control" placeholder="Machine Type/ Spec" maxlength="50">\
        </div>\
        <div class="col-sm-2">\
          <label name="' + proses_ct_proses_dtk + '">Cycle Time</label>\
          <input type="number" id="' + proses_ct_proses_dtk + '" name="' + proses_ct_proses_dtk + '" class="form-control" placeholder="Cycle Time" max="9999999999.99" step="any" onchange="refreshTotal()" style="text-align:right;">\
        </div>\
        <div class="col-sm-3">\
          <label name="' + proses_pric_pros_idr + '">Rate (IDR)</label>\
          <input type="number" id="' + proses_pric_pros_idr + '" name="' + proses_pric_pros_idr + '" class="form-control" placeholder="Rate (IDR)" max="9999999999.99" step="any" onchange="refreshTotal()" style="text-align:right;">\
        </div>\
        <div class="col-sm-3">\
          <label name="' + proses_ttl_proses + '">Total (IDR)</label>\
          <input type="text" id="' + proses_ttl_proses + '" name="' + proses_ttl_proses + '" class="form-control" placeholder="Total (IDR)" disabled="" style="text-align:right;">\
        </div>\
      </div>\
      <HR id="' + proses_id_hr + '">'
    );
    document.getElementById(proses_no_urut).focus();
  });

  function changeIdProses(row) {
    var id_field = "#proses_field_" + row;
    $(id_field).remove();
    var id_field2 = "#proses_field2_" + row;
    $(id_field2).remove();
    var id_hr = "#proses_hr_" + row;
    $(id_hr).remove();

    var proses_ttl_proses = 'proses_ttl_proses_'+jml_row_proses;
    var proses_btndelete = 'proses_btndelete_'+jml_row_proses;
    var proses_id_field = 'proses_field_'+jml_row_proses;
    var proses_id_field2 = 'proses_field2_'+jml_row_proses;
    var proses_id_hr = 'proses_hr_'+jml_row_proses;

    var jml_row_proses = document.getElementById("jml_row_proses").value.trim();
    jml_row_proses = Number(jml_row_proses);
    nextRow = Number(row) + 1;
    for($i = nextRow; $i <= jml_row_proses; $i++) {
      var id_no_proses = "#proses_no_proses_" + $i;
      var id_no_proses_new = "proses_no_proses_" + ($i-1);
      $(id_no_proses).attr({"id":id_no_proses_new, "name":id_no_proses_new});
      var id_no_urut = "#proses_no_urut_" + $i;
      var id_no_urut_new = "proses_no_urut_" + ($i-1);
      $(id_no_urut).attr({"id":id_no_urut_new, "name":id_no_urut_new});
      var id_nm_proses = "#proses_nm_proses_" + $i;
      var id_nm_proses_new = "proses_nm_proses_" + ($i-1);
      $(id_nm_proses).attr({"id":id_nm_proses_new, "name":id_nm_proses_new});
      var id_mesin_type = "#proses_mesin_type_" + $i;
      var id_mesin_type_new = "proses_mesin_type_" + ($i-1);
      $(id_mesin_type).attr({"id":id_mesin_type_new, "name":id_mesin_type_new});
      var id_ct_proses_dtk = "#proses_ct_proses_dtk_" + $i;
      var id_ct_proses_dtk_new = "proses_ct_proses_dtk_" + ($i-1);
      $(id_ct_proses_dtk).attr({"id":id_ct_proses_dtk_new, "name":id_ct_proses_dtk_new});
      var id_pric_pros_idr = "#proses_pric_pros_idr_" + $i;
      var id_pric_pros_idr_new = "proses_pric_pros_idr_" + ($i-1);
      $(id_pric_pros_idr).attr({"id":id_pric_pros_idr_new, "name":id_pric_pros_idr_new});
      var id_ttl_proses = "#proses_ttl_proses_" + $i;
      var id_ttl_proses_new = "proses_ttl_proses_" + ($i-1);
      $(id_ttl_proses).attr({"id":id_ttl_proses_new, "name":id_ttl_proses_new});
      var btndelete = "#proses_btndelete_" + $i;
      var btndelete_new = "proses_btndelete_" + ($i-1);
      $(btndelete).attr({"id":btndelete_new, "name":btndelete_new});
      var id_field = "#proses_field_" + $i;
      var id_field_new = "proses_field_" + ($i-1);
      $(id_field).attr({"id":id_field_new, "name":id_field_new});
      var id_field2 = "#proses_field2_" + $i;
      var id_field2_new = "proses_field2_" + ($i-1);
      $(id_field2).attr({"id":id_field2_new, "name":id_field2_new});
      var id_hr = "#proses_hr_" + $i;
      var id_hr_new = "proses_hr_" + ($i-1);
      $(id_hr).attr({"id":id_hr_new, "name":id_hr_new});
    }
    jml_row_proses = jml_row_proses - 1;
    document.getElementById("jml_row_proses").value = jml_row_proses;

    refreshTotal();
  }

  function deleteProses(ths) {
    var msg = 'Anda yakin menghapus Proses ini?';
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
      var row = ths.id.replace('proses_btndelete_', '');
      var info = "";
      var info2 = "";
      var info3 = "warning";
      var no_rfq = document.getElementById("no_rfq").value.trim();
      var no_rev = document.getElementById("no_rev").value.trim();
      var no_proses = document.getElementById("proses_no_proses_" + row).value.trim();      
      if(no_proses === "") {
        changeIdProses(row);
      } else {
        //DELETE DI DATABASE
        // remove these events;
        window.onkeydown = null;
        window.onfocus = null;
        var token = document.getElementsByName('_token')[0].value.trim();
        // delete via ajax
        // hapus data detail dengan ajax
        var url = "{{ route('prctrfqs.deleteproses', ['param','param2','param3']) }}";
        url = url.replace('param3', window.btoa(no_proses));
        url = url.replace('param2', window.btoa(no_rev));
        url = url.replace('param', window.btoa(no_rfq));
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
              changeIdProses(row);
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

  $("#addRowPpart").click(function(){
    var jml_row_ppart = document.getElementById("jml_row_ppart").value.trim();
    jml_row_ppart = Number(jml_row_ppart) + 1;
    document.getElementById("jml_row_ppart").value = jml_row_ppart;

    var ppart_no_ppart = 'ppart_no_ppart_'+jml_row_ppart;
    var ppart_no_urut = 'ppart_no_urut_'+jml_row_ppart;
    var ppart_nm_ppart = 'ppart_nm_ppart_'+jml_row_ppart;
    var ppart_nm_spec = 'ppart_nm_spec_'+jml_row_ppart;
    var ppart_pric_part_idr = 'ppart_pric_part_idr_'+jml_row_ppart;
    var ppart_prs_fee = 'ppart_prs_fee_'+jml_row_ppart;
    var ppart_nil_fee = 'ppart_nil_fee_'+jml_row_ppart;
    var ppart_qty_ppart = 'ppart_qty_ppart_'+jml_row_ppart;
    var ppart_ttl_ppart = 'ppart_ttl_ppart_'+jml_row_ppart;
    var ppart_btndelete = 'ppart_btndelete_'+jml_row_ppart;
    var ppart_id_field = 'ppart_field_'+jml_row_ppart;
    var ppart_id_field2 = 'ppart_field2_'+jml_row_ppart;
    var ppart_id_hr = 'ppart_hr_'+jml_row_ppart;

    $("#field-ppart").append(
      '<div class="row form-group" id="' + ppart_id_field + '">\
        <div class="col-sm-2">\
          <label name="' + ppart_no_urut + '">No. Urut (*)</label>\
          <input type="number" id="' + ppart_no_urut + '" name="' + ppart_no_urut + '" required class="form-control" placeholder="No. Urut" min="1" max="9999999999">\
          <input type="hidden" id="' + ppart_no_ppart + '" name="' + ppart_no_ppart + '" class="form-control" readonly="readonly">\
        </div>\
        <div class="col-sm-5">\
          <label name="' + ppart_nm_ppart + '">Part Name (*)</label>\
          <input type="text" id="' + ppart_nm_ppart + '" name="' + ppart_nm_ppart + '" required class="form-control" placeholder="Part Name" maxlength="50">\
        </div>\
        <div class="col-sm-5">\
          <label name="' + ppart_nm_spec + '">Spec</label>\
          <input type="text" id="' + ppart_nm_spec + '" name="' + ppart_nm_spec + '" class="form-control" placeholder="Spec" maxlength="50">\
        </div>\
      </div>\
      <div class="row form-group" id="' + ppart_id_field2 + '">\
        <div class="col-sm-2">\
          <label name="' + ppart_pric_part_idr + '">Price (IDR)</label>\
          <input type="number" id="' + ppart_pric_part_idr + '" name="' + ppart_pric_part_idr + '" class="form-control" placeholder="Price (IDR)" max="9999999999.99" step="any" onchange="refreshTotal()" style="text-align:right;">\
        </div>\
        <div class="col-sm-2">\
          <label name="' + ppart_prs_fee + '">Fee (%)</label>\
          <input type="number" id="' + ppart_prs_fee + '" name="' + ppart_prs_fee + '" class="form-control" placeholder="Fee (%)" max="100" min="0" step="any" onchange="refreshTotal()" style="text-align:right;">\
        </div>\
        <div class="col-sm-2">\
          <label name="' + ppart_nil_fee + '">Fee (IDR)</label>\
          <input type="text" id="' + ppart_nil_fee + '" name="' + ppart_nil_fee + '" class="form-control" placeholder="Fee (IDR)" disabled="" style="text-align:right;">\
        </div>\
        <div class="col-sm-2">\
          <label name="' + ppart_qty_ppart + '">QTY</label>\
          <input type="number" id="' + ppart_qty_ppart + '" name="' + ppart_qty_ppart + '" class="form-control" placeholder="QTY" max="9999999999.99" step="any" onchange="refreshTotal()" style="text-align:right;">\
        </div>\
        <div class="col-sm-3">\
          <label name="' + ppart_ttl_ppart + '">Total (IDR)</label>\
          <input type="text" id="' + ppart_ttl_ppart + '" name="' + ppart_ttl_ppart + '" class="form-control" placeholder="Total (IDR)" disabled="" style="text-align:right;">\
        </div>\
        <div class="col-sm-1">\
          <label name="' + ppart_btndelete + '">Action</label>\
          <button id="' + ppart_btndelete + '" name="' + ppart_btndelete + '" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Purchase Part" onclick="deletePpart(this)">\
            <i class="fa fa-times"></i>\
          </button>\
        </div>\
      </div>\
      <HR id="' + ppart_id_hr + '">'
    );
    document.getElementById(ppart_no_urut).focus();
  });

  function changeIdPpart(row) {
    var id_field = "#ppart_field_" + row;
    $(id_field).remove();
    var id_field2 = "#ppart_field2_" + row;
    $(id_field2).remove();
    var id_hr = "#ppart_hr_" + row;
    $(id_hr).remove();

    var jml_row_ppart = document.getElementById("jml_row_ppart").value.trim();
    jml_row_ppart = Number(jml_row_ppart);
    nextRow = Number(row) + 1;
    for($i = nextRow; $i <= jml_row_ppart; $i++) {
      var id_no_ppart = "#ppart_no_ppart_" + $i;
      var id_no_ppart_new = "ppart_no_ppart_" + ($i-1);
      $(id_no_ppart).attr({"id":id_no_ppart_new, "name":id_no_ppart_new});
      var id_no_urut = "#ppart_no_urut_" + $i;
      var id_no_urut_new = "ppart_no_urut_" + ($i-1);
      $(id_no_urut).attr({"id":id_no_urut_new, "name":id_no_urut_new});
      var id_nm_ppart = "#ppart_nm_ppart_" + $i;
      var id_nm_ppart_new = "ppart_nm_ppart_" + ($i-1);
      $(id_nm_ppart).attr({"id":id_nm_ppart_new, "name":id_nm_ppart_new});
      var id_nm_spec = "#ppart_nm_spec_" + $i;
      var id_nm_spec_new = "ppart_nm_spec_" + ($i-1);
      $(id_nm_spec).attr({"id":id_nm_spec_new, "name":id_nm_spec_new});
      var id_pric_part_idr = "#ppart_pric_part_idr_" + $i;
      var id_pric_part_idr_new = "ppart_pric_part_idr_" + ($i-1);
      $(id_pric_part_idr).attr({"id":id_pric_part_idr_new, "name":id_pric_part_idr_new});
      var id_prs_fee = "#ppart_prs_fee_" + $i;
      var id_prs_fee_new = "ppart_prs_fee_" + ($i-1);
      $(id_prs_fee).attr({"id":id_prs_fee_new, "name":id_prs_fee_new});
      var id_nil_fee = "#ppart_nil_fee_" + $i;
      var id_nil_fee_new = "ppart_nil_fee_" + ($i-1);
      $(id_nil_fee).attr({"id":id_nil_fee_new, "name":id_nil_fee_new});
      var id_qty_ppart = "#ppart_qty_ppart_" + $i;
      var id_qty_ppart_new = "ppart_qty_ppart_" + ($i-1);
      $(id_qty_ppart).attr({"id":id_qty_ppart_new, "name":id_qty_ppart_new});
      var id_ttl_ppart = "#ppart_ttl_ppart_" + $i;
      var id_ttl_ppart_new = "ppart_ttl_ppart_" + ($i-1);
      $(id_ttl_ppart).attr({"id":id_ttl_ppart_new, "name":id_ttl_ppart_new});
      var btndelete = "#ppart_btndelete_" + $i;
      var btndelete_new = "ppart_btndelete_" + ($i-1);
      $(btndelete).attr({"id":btndelete_new, "name":btndelete_new});
      var id_field = "#ppart_field_" + $i;
      var id_field_new = "ppart_field_" + ($i-1);
      $(id_field).attr({"id":id_field_new, "name":id_field_new});
      var id_field2 = "#ppart_field2_" + $i;
      var id_field2_new = "ppart_field2_" + ($i-1);
      $(id_field2).attr({"id":id_field2_new, "name":id_field2_new});
      var id_hr = "#ppart_hr_" + $i;
      var id_hr_new = "ppart_hr_" + ($i-1);
      $(id_hr).attr({"id":id_hr_new, "name":id_hr_new});
    }
    jml_row_ppart = jml_row_ppart - 1;
    document.getElementById("jml_row_ppart").value = jml_row_ppart;

    refreshTotal();
  }

  function deletePpart(ths) {
    var msg = 'Anda yakin menghapus Purchase Part ini?';
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
      var row = ths.id.replace('ppart_btndelete_', '');
      var info = "";
      var info2 = "";
      var info3 = "warning";
      var no_rfq = document.getElementById("no_rfq").value.trim();
      var no_rev = document.getElementById("no_rev").value.trim();
      var no_ppart = document.getElementById("ppart_no_ppart_" + row).value.trim();      
      if(no_ppart === "") {
        changeIdPpart(row);
      } else {
        //DELETE DI DATABASE
        // remove these events;
        window.onkeydown = null;
        window.onfocus = null;
        var token = document.getElementsByName('_token')[0].value.trim();
        // delete via ajax
        // hapus data detail dengan ajax
        var url = "{{ route('prctrfqs.deleteppart', ['param','param2','param3']) }}";
        url = url.replace('param3', window.btoa(no_ppart));
        url = url.replace('param2', window.btoa(no_rev));
        url = url.replace('param', window.btoa(no_rfq));
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
              changeIdPpart(row);
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

  $("#addRowTool").click(function(){
    var jml_row_tool = document.getElementById("jml_row_tool").value.trim();
    jml_row_tool = Number(jml_row_tool) + 1;
    document.getElementById("jml_row_tool").value = jml_row_tool;

    var tool_no_tool = 'tool_no_tool_'+jml_row_tool;
    var tool_no_urut = 'tool_no_urut_'+jml_row_tool;
    var tool_nm_tool = 'tool_nm_tool_'+jml_row_tool;
    var tool_pric_tool_idr = 'tool_pric_tool_idr_'+jml_row_tool;
    var tool_life_time = 'tool_life_time_'+jml_row_tool;
    var tool_ttl_tool = 'tool_ttl_tool_'+jml_row_tool;
    var tool_btndelete = 'tool_btndelete_'+jml_row_tool;
    var tool_id_field = 'tool_field_'+jml_row_tool;
    var tool_id_hr = 'tool_hr_'+jml_row_tool;

    $("#field-tool").append(
      '<div class="row form-group" id="' + tool_id_field + '">\
        <div class="col-sm-1">\
          <label name="' + tool_no_urut + '">Urut (*)</label>\
          <input type="number" id="' + tool_no_urut + '" name="' + tool_no_urut + '" required class="form-control" placeholder="No. Urut" min="1" max="9999999999">\
          <input type="hidden" id="' + tool_no_tool + '" name="' + tool_no_tool + '" class="form-control" readonly="readonly">\
        </div>\
        <div class="col-sm-4">\
          <label name="' + tool_nm_tool + '">Nama (*)</label>\
          <input type="text" id="' + tool_nm_tool + '" name="' + tool_nm_tool + '" required class="form-control" placeholder="Nama" maxlength="50">\
        </div>\
        <div class="col-sm-2">\
          <label name="' + tool_pric_tool_idr + '">Price (IDR)</label>\
          <input type="number" id="' + tool_pric_tool_idr + '" name="' + tool_pric_tool_idr + '" class="form-control" placeholder="Price (IDR)" max="9999999999.99" step="any" onchange="refreshTotal()" style="text-align:right;">\
        </div>\
        <div class="col-sm-2">\
          <label name="' + tool_life_time + '">Tool Life</label>\
          <input type="number" id="' + tool_life_time + '" name="' + tool_life_time + '" class="form-control" placeholder="Tool Life" max="9999999999.99" step="any" onchange="refreshTotal()" style="text-align:right;">\
        </div>\
        <div class="col-sm-2">\
          <label name="' + tool_ttl_tool + '">Total (IDR)</label>\
          <input type="text" id="' + tool_ttl_tool + '" name="' + tool_ttl_tool + '" class="form-control" placeholder="Total (IDR)" disabled="" style="text-align:right;">\
        </div>\
        <div class="col-sm-1">\
          <label name="' + tool_btndelete + '">Action</label>\
          <button id="' + tool_btndelete + '" name="' + tool_btndelete + '" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Tooling" onclick="deleteTool(this)">\
            <i class="fa fa-times"></i>\
          </button>\
        </div>\
      </div>\
      <HR id="' + tool_id_hr + '">'
    );
    document.getElementById(tool_no_urut).focus();
  });

  function changeIdTool(row) {
    var id_field = "#tool_field_" + row;
    $(id_field).remove();
    var id_hr = "#tool_hr_" + row;
    $(id_hr).remove();

    var jml_row_tool = document.getElementById("jml_row_tool").value.trim();
    jml_row_tool = Number(jml_row_tool);
    nextRow = Number(row) + 1;
    for($i = nextRow; $i <= jml_row_tool; $i++) {
      var id_no_tool = "#tool_no_tool_" + $i;
      var id_no_tool_new = "tool_no_tool_" + ($i-1);
      $(id_no_tool).attr({"id":id_no_tool_new, "name":id_no_tool_new});
      var id_no_urut = "#tool_no_urut_" + $i;
      var id_no_urut_new = "tool_no_urut_" + ($i-1);
      $(id_no_urut).attr({"id":id_no_urut_new, "name":id_no_urut_new});
      var id_nm_tool = "#tool_nm_tool_" + $i;
      var id_nm_tool_new = "tool_nm_tool_" + ($i-1);
      $(id_nm_tool).attr({"id":id_nm_tool_new, "name":id_nm_tool_new});
      var id_pric_tool_idr = "#tool_pric_tool_idr_" + $i;
      var id_pric_tool_idr_new = "tool_pric_tool_idr_" + ($i-1);
      $(id_pric_tool_idr).attr({"id":id_pric_tool_idr_new, "name":id_pric_tool_idr_new});
      var id_life_time = "#tool_life_time_" + $i;
      var id_life_time_new = "tool_life_time_" + ($i-1);
      $(id_life_time).attr({"id":id_life_time_new, "name":id_life_time_new});
      var id_ttl_tool = "#tool_ttl_tool_" + $i;
      var id_ttl_tool_new = "tool_ttl_tool_" + ($i-1);
      $(id_ttl_tool).attr({"id":id_ttl_tool_new, "name":id_ttl_tool_new});
      var btndelete = "#tool_btndelete_" + $i;
      var btndelete_new = "tool_btndelete_" + ($i-1);
      $(btndelete).attr({"id":btndelete_new, "name":btndelete_new});
      var id_field = "#tool_field_" + $i;
      var id_field_new = "tool_field_" + ($i-1);
      $(id_field).attr({"id":id_field_new, "name":id_field_new});
      var id_hr = "#tool_hr_" + $i;
      var id_hr_new = "tool_hr_" + ($i-1);
      $(id_hr).attr({"id":id_hr_new, "name":id_hr_new});
    }
    jml_row_tool = jml_row_tool - 1;
    document.getElementById("jml_row_tool").value = jml_row_tool;

    refreshTotal();
  }

  function deleteTool(ths) {
    var msg = 'Anda yakin menghapus Tooling ini?';
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
      var row = ths.id.replace('tool_btndelete_', '');
      var info = "";
      var info2 = "";
      var info3 = "warning";
      var no_rfq = document.getElementById("no_rfq").value.trim();
      var no_rev = document.getElementById("no_rev").value.trim();
      var no_tool = document.getElementById("tool_no_tool_" + row).value.trim();      
      if(no_tool === "") {
        changeIdTool(row);
      } else {
        //DELETE DI DATABASE
        // remove these events;
        window.onkeydown = null;
        window.onfocus = null;
        var token = document.getElementsByName('_token')[0].value.trim();
        // delete via ajax
        // hapus data detail dengan ajax
        var url = "{{ route('prctrfqs.deletetool', ['param','param2','param3']) }}";
        url = url.replace('param3', window.btoa(no_tool));
        url = url.replace('param2', window.btoa(no_rev));
        url = url.replace('param', window.btoa(no_rfq));
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
              changeIdTool(row);
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