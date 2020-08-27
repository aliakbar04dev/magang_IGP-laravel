<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Detail RFQ</h3>
      </div>
      <!-- /.box-header -->
      
      {!! Form::hidden('jml_row_rm', $prctrfq->prctRfqRms()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_rm']) !!}
      {!! Form::hidden('jml_row_proses', $prctrfq->prctRfqProsess()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_proses']) !!}
      {!! Form::hidden('jml_row_ppart', $prctrfq->prctRfqPparts()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_ppart']) !!}
      {!! Form::hidden('jml_row_tool', $prctrfq->prctRfqTools()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_tool']) !!}

      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active" id="nav_rm">
          <a href="#rm" aria-controls="rm" role="tab" data-toggle="tab" title="1. Raw Material">
            1. Raw Material
          </a>
        </li>
        <li role="presentation" id="nav_proses">
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
        <div role="tabpanel" class="tab-pane active" id="rm">
          <div class="box-body" id="field-rm">
            @foreach ($prctrfq->prctRfqRms() as $model)
              <div class="row form-group" id="rm_field_{{ $loop->iteration }}">
                <div class="col-sm-2">
                  <label name="rm_no_urut_{{ $loop->iteration }}">No. Urut (*)</label>
                  <input type="number" id="rm_no_urut_{{ $loop->iteration }}" name="rm_no_urut_{{ $loop->iteration }}" required class="form-control" placeholder="No. Urut" min="1" max="9999999999" value="{{ $model->no_urut }}" readonly="readonly">
                  <input type="hidden" id="rm_no_rm_{{ $loop->iteration }}" name="rm_no_rm_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ $model->no_rm }}">
                </div>
                <div class="col-sm-6">
                  <label name="rm_mat_spec_{{ $loop->iteration }}">Material Spec & Mills (*)</label>
                  <input type="text" id="rm_mat_spec_{{ $loop->iteration }}" name="rm_mat_spec_{{ $loop->iteration }}" required class="form-control" placeholder="Material Spec & Mills" maxlength="50" value="{{ $model->mat_spec }}" readonly="readonly">
                </div>
                <div class="col-sm-4">
                  <label name="rm_mat_pric_period_{{ $loop->iteration }}">Material Price Period</label>
                  <input type="text" id="rm_mat_pric_period_{{ $loop->iteration }}" name="rm_mat_pric_period_{{ $loop->iteration }}" class="form-control" placeholder="Material Price Period" maxlength="30" value="{{ $model->mat_pric_period }}" readonly="readonly">
                </div>
              </div>
              <div class="row form-group" id="rm_field2_{{ $loop->iteration }}">
                <div class="col-sm-3">
                  <label name="rm_mat_sheet_p_mm_{{ $loop->iteration }}">Sheet (P)</label>
                  <input type="number" id="rm_mat_sheet_p_mm_{{ $loop->iteration }}" name="rm_mat_sheet_p_mm_{{ $loop->iteration }}" class="form-control" placeholder="Sheet (P)" max="9999999999.99" step="any" onchange="refreshTotal()" style="text-align:right;" value="{{ numberFormatterForm(0, 2)->format($model->mat_sheet_p_mm) }}" readonly="readonly">
                </div>
                <div class="col-sm-3">
                  <label name="rm_mat_sheet_l_mm_{{ $loop->iteration }}">Sheet (L)</label>
                  <input type="number" id="rm_mat_sheet_l_mm_{{ $loop->iteration }}" name="rm_mat_sheet_l_mm_{{ $loop->iteration }}" class="form-control" placeholder="Sheet (L)" max="9999999999.99" step="any" onchange="refreshTotal()" style="text-align:right;" value="{{ numberFormatterForm(0, 2)->format($model->mat_sheet_l_mm) }}" readonly="readonly">
                </div>
                <div class="col-sm-3">
                  <label name="rm_mat_sheet_t_mm_{{ $loop->iteration }}">Sheet (T)</label>
                  <input type="number" id="rm_mat_sheet_t_mm_{{ $loop->iteration }}" name="rm_mat_sheet_t_mm_{{ $loop->iteration }}" class="form-control" placeholder="Sheet (T)" max="9999999999.99" step="any" onchange="refreshTotal()" style="text-align:right;" value="{{ numberFormatterForm(0, 2)->format($model->mat_sheet_t_mm) }}" readonly="readonly">
                </div>
                <div class="col-sm-3">
                  <label name="rm_qty_per_sheet_{{ $loop->iteration }}">Qty / Sheet</label>
                  <input type="number" id="rm_qty_per_sheet_{{ $loop->iteration }}" name="rm_qty_per_sheet_{{ $loop->iteration }}" class="form-control" placeholder="Qty / Sheet" max="9999999999.99" step="any" onchange="refreshTotal()" style="text-align:right;" value="{{ numberFormatterForm(0, 2)->format($model->qty_per_sheet) }}" readonly="readonly">
                </div>
              </div>
              <div class="row form-group" id="rm_field3_{{ $loop->iteration }}">
                <div class="col-sm-4">
                  <label name="rm_nil_consump_kg_{{ $loop->iteration }}">Consumption (Kg)</label>
                  <input type="text" id="rm_nil_consump_kg_{{ $loop->iteration }}" name="rm_nil_consump_kg_{{ $loop->iteration }}" class="form-control" placeholder="Consumption (Kg)" disabled="" style="text-align:right;" value="{{ numberFormatter(0, 2)->format($model->nil_consump_kg) }}">
                </div>
                <div class="col-sm-4">
                  <label name="rm_pric_per_kg_idr_{{ $loop->iteration }}">Price / Kg (IDR)</label>
                  <input type="number" id="rm_pric_per_kg_idr_{{ $loop->iteration }}" name="rm_pric_per_kg_idr_{{ $loop->iteration }}" class="form-control" placeholder="Price / Kg (IDR)" max="9999999999.99" step="any" onchange="refreshTotal()" style="text-align:right;" value="{{ numberFormatterForm(0, 2)->format($model->pric_per_kg_idr) }}" readonly="readonly">
                </div>
                <div class="col-sm-4">
                  <label name="rm_sub_ttl_{{ $loop->iteration }}">Total (IDR)</label>
                  <input type="text" id="rm_sub_ttl_{{ $loop->iteration }}" name="rm_sub_ttl_{{ $loop->iteration }}" class="form-control" placeholder="Total (IDR)" disabled="" style="text-align:right;" value="{{ numberFormatter(0, 2)->format($model->sub_ttl) }}">
                </div>
              </div>
              <div class="row form-group" id="rm_field4_{{ $loop->iteration }}">
                <div class="col-sm-4">
                  <label name="rm_scrap_kg_{{ $loop->iteration }}">Scrap (Kg)</label>
                  <input type="text" id="rm_scrap_kg_{{ $loop->iteration }}" name="rm_scrap_kg_{{ $loop->iteration }}" class="form-control" placeholder="Scrap (Kg)" disabled="" style="text-align:right;" value="{{ numberFormatter(0, 2)->format($model->scrap_kg) }}">
                </div>
                <div class="col-sm-4">
                  <label name="rm_scrap_pric_per_kg_{{ $loop->iteration }}">Scrap / Kg (IDR)</label>
                  <input type="number" id="rm_scrap_pric_per_kg_{{ $loop->iteration }}" name="rm_scrap_pric_per_kg_{{ $loop->iteration }}" class="form-control" placeholder="Scrap / Kg (IDR)" max="9999999999.99" step="any" onchange="refreshTotal()" style="text-align:right;" value="{{ numberFormatterForm(0, 2)->format($model->scrap_pric_per_kg) }}" readonly="readonly">
                </div>
                <div class="col-sm-4">
                  <label name="rm_scrap_ttl_mat_{{ $loop->iteration }}">Total (IDR)</label>
                  <input type="text" id="rm_scrap_ttl_mat_{{ $loop->iteration }}" name="rm_scrap_ttl_mat_{{ $loop->iteration }}" class="form-control" placeholder="Total (IDR)" disabled="" style="text-align:right;" value="{{ numberFormatter(0, 2)->format($model->scrap_ttl_mat) }}">
                </div>
              </div>
              <HR id="rm_id_hr_{{ $loop->iteration }}">
            @endforeach
          </div>
          <!-- /.box-body -->
          <div class="box-body">
            <div class="row form-group">
              <div class="col-sm-4 pull-right">
                <label name="rm_sub_total">Sub Total (IDR)</label>
                <input type="text" id="rm_sub_total" name="rm_sub_total" class="form-control" placeholder="Sub Total (IDR)" disabled="" style="text-align:right;">
              </div>
            </div>
            <!-- /.form-group -->
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.tabpanel -->
        <div role="tabpanel" class="tab-pane" id="proses">
          <div class="box-body" id="field-proses">
            @foreach ($prctrfq->prctRfqProsess() as $model)
              <div class="row form-group" id="proses_field_{{ $loop->iteration }}">
                <div class="col-sm-2">
                  <label name="proses_no_urut_{{ $loop->iteration }}">No. Urut (*)</label>
                  <input type="number" id="proses_no_urut_{{ $loop->iteration }}" name="proses_no_urut_{{ $loop->iteration }}" required class="form-control" placeholder="No. Urut" min="1" max="9999999999" value="{{ $model->no_urut }}" readonly="readonly">
                  <input type="hidden" id="proses_no_proses_{{ $loop->iteration }}" name="proses_no_proses_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ $model->no_proses }}">
                </div>
                <div class="col-sm-10">
                  <label name="proses_nm_proses_{{ $loop->iteration }}">Nama Proses (*)</label>
                  <input type="text" id="proses_nm_proses_{{ $loop->iteration }}" name="proses_nm_proses_{{ $loop->iteration }}" required class="form-control" placeholder="Nama Proses" maxlength="50" value="{{ $model->nm_proses }}" readonly="readonly">
                </div>
              </div>
              <!-- /.form-group -->
              <div class="row form-group" id="proses_field2_{{ $loop->iteration }}">
                <div class="col-sm-2">
                  <label name="proses_mesin_tonage_{{ $loop->iteration }}">Machine tonage</label>
                  <input type="number" id="proses_mesin_tonage_{{ $loop->iteration }}" name="proses_mesin_tonage_{{ $loop->iteration }}" class="form-control" placeholder="Machine tonage" max="9999999999.99" step="any" onchange="refreshTotal()" style="text-align:right;" value="{{ numberFormatterForm(0, 2)->format($model->mesin_tonage) }}" readonly="readonly">
                </div>
                <div class="col-sm-2">
                  <label name="proses_nil_rate_{{ $loop->iteration }}">RATE</label>
                  <input type="number" id="proses_nil_rate_{{ $loop->iteration }}" name="proses_nil_rate_{{ $loop->iteration }}" class="form-control" placeholder="RATE" max="9999999999.99" step="any" onchange="refreshTotal()" style="text-align:right;" value="{{ numberFormatterForm(0, 2)->format($model->nil_rate) }}" readonly="readonly">
                </div>
                <div class="col-sm-3">
                  <label name="proses_pric_pros_idr_{{ $loop->iteration }}">Price (IDR)</label>
                  <input type="text" id="proses_pric_pros_idr_{{ $loop->iteration }}" name="proses_pric_pros_idr_{{ $loop->iteration }}" class="form-control" placeholder="Price (IDR)" disabled="" style="text-align:right;" value="{{ numberFormatter(0, 2)->format($model->pric_pros_idr) }}">
                </div>
                <div class="col-sm-2">
                  <label name="proses_qty_pros_{{ $loop->iteration }}">QTY</label>
                  <input type="number" id="proses_qty_pros_{{ $loop->iteration }}" name="proses_qty_pros_{{ $loop->iteration }}" class="form-control" placeholder="QTY" max="9999999999.99" step="any" onchange="refreshTotal()" style="text-align:right;" value="{{ numberFormatterForm(0, 2)->format($model->qty_pros) }}" readonly="readonly">
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
                  <input type="number" id="ppart_no_urut_{{ $loop->iteration }}" name="ppart_no_urut_{{ $loop->iteration }}" required class="form-control" placeholder="No. Urut" min="1" max="9999999999" value="{{ $model->no_urut }}" readonly="readonly">
                  <input type="hidden" id="ppart_no_ppart_{{ $loop->iteration }}" name="ppart_no_ppart_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ $model->no_ppart }}">
                </div>
                <div class="col-sm-5">
                  <label name="ppart_nm_ppart_{{ $loop->iteration }}">Part Name (*)</label>
                  <input type="text" id="ppart_nm_ppart_{{ $loop->iteration }}" name="ppart_nm_ppart_{{ $loop->iteration }}" required class="form-control" placeholder="Part Name" maxlength="50" value="{{ $model->nm_ppart }}" readonly="readonly">
                </div>
                <div class="col-sm-5">
                  <label name="ppart_nm_spec_{{ $loop->iteration }}">Spec</label>
                  <input type="text" id="ppart_nm_spec_{{ $loop->iteration }}" name="ppart_nm_spec_{{ $loop->iteration }}" class="form-control" placeholder="Spec" maxlength="50" value="{{ $model->nm_spec }}" readonly="readonly">
                </div>
              </div>
              <div class="row form-group" id="ppart_field2_{{ $loop->iteration }}">
                <div class="col-sm-2">
                  <label name="ppart_pric_part_idr_{{ $loop->iteration }}">Price (IDR)</label>
                  <input type="number" id="ppart_pric_part_idr_{{ $loop->iteration }}" name="ppart_pric_part_idr_{{ $loop->iteration }}" class="form-control" placeholder="Price (IDR)" max="9999999999.99" step="any" onchange="refreshTotal()" style="text-align:right;" value="{{ numberFormatterForm(0, 2)->format($model->pric_part_idr) }}" readonly="readonly">
                </div>
                <div class="col-sm-2">
                  <label name="ppart_prs_fee_{{ $loop->iteration }}">Fee (%)</label>
                  <input type="number" id="ppart_prs_fee_{{ $loop->iteration }}" name="ppart_prs_fee_{{ $loop->iteration }}" class="form-control" placeholder="Fee (%)" max="100" min="0" step="any" onchange="refreshTotal()" style="text-align:right;" value="{{ numberFormatterForm(0, 2)->format($model->prs_fee) }}" readonly="readonly">
                </div>
                <div class="col-sm-2">
                  <label name="ppart_nil_fee_{{ $loop->iteration }}">Fee (IDR)</label>
                  <input type="text" id="ppart_nil_fee_{{ $loop->iteration }}" name="ppart_nil_fee_{{ $loop->iteration }}" class="form-control" placeholder="Fee (IDR)" disabled="" style="text-align:right;" value="{{ numberFormatter(0, 2)->format($model->nil_fee) }}">
                </div>
                <div class="col-sm-2">
                  <label name="ppart_qty_ppart_{{ $loop->iteration }}">QTY</label>
                  <input type="number" id="ppart_qty_ppart_{{ $loop->iteration }}" name="ppart_qty_ppart_{{ $loop->iteration }}" class="form-control" placeholder="QTY" max="9999999999.99" step="any" onchange="refreshTotal()" style="text-align:right;" value="{{ numberFormatterForm(0, 2)->format($model->qty_ppart) }}" readonly="readonly">
                </div>
                <div class="col-sm-4">
                  <label name="ppart_ttl_ppart_{{ $loop->iteration }}">Total (IDR)</label>
                  <input type="text" id="ppart_ttl_ppart_{{ $loop->iteration }}" name="ppart_ttl_ppart_{{ $loop->iteration }}" class="form-control" placeholder="Total (IDR)" disabled="" style="text-align:right;" value="{{ numberFormatter(0, 2)->format($model->ttl_ppart) }}">
                </div>
              </div>
              <HR id="ppart_hr_{{ $loop->iteration }}">
            @endforeach
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
                <div class="col-sm-2">
                  <label name="tool_no_urut_{{ $loop->iteration }}">Urut (*)</label>
                  <input type="number" id="tool_no_urut_{{ $loop->iteration }}" name="tool_no_urut_{{ $loop->iteration }}" required class="form-control" placeholder="No. Urut" min="1" max="9999999999" value="{{ $model->no_urut }}" readonly="readonly">
                  <input type="hidden" id="tool_no_tool_{{ $loop->iteration }}" name="tool_no_tool_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ $model->no_tool }}">
                </div>
                <div class="col-sm-10">
                  <label name="tool_nm_tool_{{ $loop->iteration }}">Nama (*)</label>
                  <input type="text" id="tool_nm_tool_{{ $loop->iteration }}" name="tool_nm_tool_{{ $loop->iteration }}" required class="form-control" placeholder="Nama" maxlength="50" value="{{ $model->nm_tool }}" readonly="readonly">
                </div>
              </div>
              <div class="row form-group" id="tool_field2_{{ $loop->iteration }}">
                <div class="col-sm-3">
                  <label name="tool_pric_tool_idr_{{ $loop->iteration }}">Price (IDR)</label>
                  <input type="number" id="tool_pric_tool_idr_{{ $loop->iteration }}" name="tool_pric_tool_idr_{{ $loop->iteration }}" class="form-control" placeholder="Price (IDR)" max="9999999999.99" step="any" onchange="refreshTotal()" style="text-align:right;" value="{{ numberFormatterForm(0, 2)->format($model->pric_tool_idr) }}" readonly="readonly">
                </div>
                <div class="col-sm-3">
                  <label name="tool_jml_depre_bln_{{ $loop->iteration }}">Depreciation period (month)</label>
                  <input type="number" id="tool_jml_depre_bln_{{ $loop->iteration }}" name="tool_jml_depre_bln_{{ $loop->iteration }}" class="form-control" placeholder="Depreciation period (month)" max="9999999999.99" step="any" onchange="refreshTotal()" style="text-align:right;" value="{{ numberFormatterForm(0, 2)->format($model->jml_depre_bln) }}" readonly="readonly">
                </div>
                <div class="col-sm-2">
                  <label name="tool_qty_per_bln_{{ $loop->iteration }}">QTY/ month</label>
                  <input type="number" id="tool_qty_per_bln_{{ $loop->iteration }}" name="tool_qty_per_bln_{{ $loop->iteration }}" class="form-control" placeholder="QTY/ month" max="9999999999.99" step="any" onchange="refreshTotal()" style="text-align:right;" value="{{ numberFormatterForm(0, 2)->format($model->qty_per_bln) }}" readonly="readonly">
                </div>
                <div class="col-sm-4">
                  <label name="tool_ttl_tool_{{ $loop->iteration }}">Total (IDR)</label>
                  <input type="text" id="tool_ttl_tool_{{ $loop->iteration }}" name="tool_ttl_tool_{{ $loop->iteration }}" class="form-control" placeholder="Total (IDR)" disabled="" style="text-align:right;" value="{{ numberFormatter(0, 2)->format($model->ttl_tool) }}">
                </div>
              </div>
              <HR id="tool_hr_{{ $loop->iteration }}">
            @endforeach
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
                {!! Form::number('nil_transpor', !empty($prctrfq) ? numberFormatterForm(0, 2)->format($prctrfq->nil_transpor) : null, ['class'=>'form-control', 'placeholder' => 'Transport Cost', 'max' => 9999999999.99, 'step' => 'any', 'id' => 'nil_transpor', 'onchange' => 'refreshTotal()', 'style' => 'text-align:right;', 'readonly' => 'readonly']) !!}
                {!! $errors->first('nil_transpor', '<p class="help-block">:message</p>') !!}
              </div>
              <div class="col-sm-2 {{ $errors->has('nil_pack') ? ' has-error' : '' }}">
                {!! Form::label('nil_pack', '6. Packaging Cost') !!}
                {!! Form::number('nil_pack', !empty($prctrfq) ? numberFormatterForm(0, 2)->format($prctrfq->nil_pack) : null, ['class'=>'form-control', 'placeholder' => 'Packaging Cost', 'max' => 9999999999.99, 'step' => 'any', 'id' => 'nil_pack', 'onchange' => 'refreshTotal()', 'style' => 'text-align:right;', 'readonly' => 'readonly']) !!}
                {!! $errors->first('nil_pack', '<p class="help-block">:message</p>') !!}
              </div>
              <div class="col-sm-2 {{ $errors->has('prs_admin') ? ' has-error' : '' }}">
                {!! Form::label('prs_admin', 'Admin Cost (%)') !!}
                {!! Form::number('prs_admin', !empty($prctrfq) ? numberFormatterForm(0, 2)->format($prctrfq->prs_admin) : null, ['class'=>'form-control', 'placeholder' => 'Admin Cost (%)', 'max' => 100, 'min' => 0, 'step' => 'any', 'id' => 'prs_admin', 'onchange' => 'refreshTotal()', 'style' => 'text-align:right;', 'readonly' => 'readonly']) !!}
                {!! $errors->first('prs_admin', '<p class="help-block">:message</p>') !!}
              </div>
              <div class="col-sm-2 {{ $errors->has('nil_admin') ? ' has-error' : '' }}">
                {!! Form::label('nil_admin', '7. Administration Cost') !!}
                {!! Form::text('nil_admin', !empty($prctrfq) ? numberFormatter(0, 2)->format($prctrfq->nil_admin) : null, ['class'=>'form-control', 'placeholder' => '8. Administration Cost', 'id' => 'nil_admin', 'style' => 'text-align:right;', 'disabled' => '']) !!}
                {!! $errors->first('nil_admin', '<p class="help-block">:message</p>') !!}
              </div>
              <div class="col-sm-2 {{ $errors->has('prs_profit') ? ' has-error' : '' }}">
                {!! Form::label('prs_profit', 'Profit (%)') !!}
                {!! Form::number('prs_profit', !empty($prctrfq) ? numberFormatterForm(0, 2)->format($prctrfq->prs_profit) : null, ['class'=>'form-control', 'placeholder' => 'Profit (%)', 'max' => 100, 'min' => 0, 'step' => 'any', 'id' => 'prs_profit', 'onchange' => 'refreshTotal()', 'style' => 'text-align:right;', 'readonly' => 'readonly']) !!}
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
                {!! Form::number('nil_fob_usd', !empty($prctrfq) ? numberFormatterForm(0, 2)->format($prctrfq->nil_fob_usd) : null, ['class'=>'form-control', 'placeholder' => 'In-line Cost (FOB) (USD)', 'max' => 9999999999.99, 'step' => 'any', 'id' => 'nil_fob_usd', 'onchange' => 'refreshTotal()', 'style' => 'text-align:right;', 'readonly' => 'readonly']) !!}
                {!! $errors->first('nil_fob_usd', '<p class="help-block">:message</p>') !!}
              </div>
              <div class="col-sm-3 {{ $errors->has('nil_fob') ? ' has-error' : '' }}">
                {!! Form::label('nil_fob', 'In-line Cost (FOB) (IDR)') !!}
                {!! Form::text('nil_fob', !empty($prctrfq) ? numberFormatter(0, 2)->format($prctrfq->nil_fob) : null, ['class'=>'form-control', 'placeholder' => 'In-line Cost (FOB) (IDR)', 'id' => 'nil_fob', 'style' => 'text-align:right;', 'disabled' => '']) !!}
                {!! $errors->first('nil_fob', '<p class="help-block">:message</p>') !!}
              </div>
              <div class="col-sm-3 {{ $errors->has('nil_cif_usd') ? ' has-error' : '' }}">
                {!! Form::label('nil_cif_usd', '10. Freight Cost (CIF) (USD)') !!}
                {!! Form::number('nil_cif_usd', !empty($prctrfq) ? numberFormatterForm(0, 2)->format($prctrfq->nil_cif_usd) : null, ['class'=>'form-control', 'placeholder' => 'Freight Cost (CIF) (USD)', 'max' => 9999999999.99, 'step' => 'any', 'id' => 'nil_cif_usd', 'onchange' => 'refreshTotal()', 'style' => 'text-align:right;', 'readonly' => 'readonly']) !!}
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
            {!! Form::number('nil_diskon', !empty($prctrfq) ? numberFormatterForm(0, 2)->format($prctrfq->nil_diskon) : null, ['class'=>'form-control', 'placeholder' => 'Diskon (IDR)', 'max' => 9999999999.99, 'step' => 'any', 'id' => 'nil_diskon', 'onchange' => 'refreshTotal()', 'style' => 'text-align:right;', 'readonly' => 'readonly']) !!}
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
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->

@section('scripts')
<script type="text/javascript">

  function refreshTotal() {
    var ssr_er_usd = {{ $prctrfq->ssr_er_usd }};
    ssr_er_usd = Number(ssr_er_usd);

    //1. Raw Material
    var jml_row_rm = document.getElementById("jml_row_rm").value.trim();
    jml_row_rm = Number(jml_row_rm);

    var rm_sub_total = 0;
    for($i = 1; $i <= jml_row_rm; $i++) {
      var mat_sheet_p_mm = document.getElementById("rm_mat_sheet_p_mm_" + $i).value.trim();
      mat_sheet_p_mm = Number(mat_sheet_p_mm);
      var mat_sheet_l_mm = document.getElementById("rm_mat_sheet_l_mm_" + $i).value.trim();
      mat_sheet_l_mm = Number(mat_sheet_l_mm);
      var mat_sheet_t_mm = document.getElementById("rm_mat_sheet_t_mm_" + $i).value.trim();
      mat_sheet_t_mm = Number(mat_sheet_t_mm);
      var qty_per_sheet = document.getElementById("rm_qty_per_sheet_" + $i).value.trim();
      qty_per_sheet = Number(qty_per_sheet);

      var nil_consump_kg = 0;
      if(qty_per_sheet > 0) {
        nil_consump_kg = mat_sheet_p_mm * mat_sheet_l_mm * mat_sheet_t_mm * 0.785 / 100000 / qty_per_sheet;
      }
      document.getElementById("rm_nil_consump_kg_" + $i).value = nil_consump_kg.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

      var pric_per_kg_idr = document.getElementById("rm_pric_per_kg_idr_" + $i).value.trim();
      pric_per_kg_idr = Number(pric_per_kg_idr);
      
      var sub_ttl = nil_consump_kg * pric_per_kg_idr;
      document.getElementById("rm_sub_ttl_" + $i).value = sub_ttl.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
      
      var scrap_kg = nil_consump_kg;
      document.getElementById("rm_scrap_kg_" + $i).value = scrap_kg.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

      var scrap_pric_per_kg = document.getElementById("rm_scrap_pric_per_kg_" + $i).value.trim();
      scrap_pric_per_kg = Number(scrap_pric_per_kg);

      var scrap_ttl_mat = scrap_kg * scrap_pric_per_kg;
      document.getElementById("rm_scrap_ttl_mat_" + $i).value = scrap_ttl_mat.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

      var ttl_mat = sub_ttl - scrap_ttl_mat;
      rm_sub_total = rm_sub_total + ttl_mat;
    }
    document.getElementById("rm_sub_total").value = rm_sub_total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

    //2. Process
    var jml_row_proses = document.getElementById("jml_row_proses").value.trim();
    jml_row_proses = Number(jml_row_proses);

    var proses_sub_total = 0;
    for($i = 1; $i <= jml_row_proses; $i++) {
      var mesin_tonage = document.getElementById("proses_mesin_tonage_" + $i).value.trim();
      mesin_tonage = Number(mesin_tonage);
      var nil_rate = document.getElementById("proses_nil_rate_" + $i).value.trim();
      nil_rate = Number(nil_rate);

      var pric_pros_idr = mesin_tonage * nil_rate;
      document.getElementById("proses_pric_pros_idr_" + $i).value = pric_pros_idr.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

      var qty_pros = document.getElementById("proses_qty_pros_" + $i).value.trim();
      qty_pros = Number(qty_pros);

      var ttl_proses = 0;
      if(qty_pros > 0) {
        ttl_proses = pric_pros_idr / qty_pros;
      }
      document.getElementById("proses_ttl_proses_" + $i).value = ttl_proses.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

      proses_sub_total = proses_sub_total + ttl_proses;
    }

    document.getElementById("proses_sub_total").value = proses_sub_total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

    var rm_proses_total = rm_sub_total + proses_sub_total;
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
      var jml_depre_bln = document.getElementById("tool_jml_depre_bln_" + $i).value.trim();
      jml_depre_bln = Number(jml_depre_bln);
      var qty_per_bln = document.getElementById("tool_qty_per_bln_" + $i).value.trim();
      qty_per_bln = Number(qty_per_bln);
      

      var ttl_tool = 0;
      if(jml_depre_bln > 0 && qty_per_bln > 0) {
        ttl_tool = pric_tool_idr / jml_depre_bln / qty_per_bln;
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

    var part_price = rm_sub_total + proses_sub_total + ppart_sub_total + tool_sub_total + nil_transpor + nil_pack + nil_admin + nil_profit;
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

  function approveRfq(no_rfq, mode)
  {
    var msg = 'Anda yakin APPROVE No. RFQ: ' + no_rfq + '?';
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
      var url = "{{ route('prctrfqs.approve')}}";
      $("#loading").show();
      $.ajax({
        type     : 'POST',
        url      : url,
        dataType : 'json',
        data     : {
          _method        : 'POST',
          // menambah csrf token dari Laravel
          _token         : token,
          no_rfq         : window.btoa(no_rfq),
          mode           : window.btoa(mode)
        },
        success:function(data){
          $("#loading").hide();
          if(data.status === 'OK'){
            swal("Approved", data.message, "success");
            if(mode === "PRC") {
              var urlRedirect = "{{ route('prctrfqs.showdetail', 'param') }}";
              urlRedirect = urlRedirect.replace('param', window.btoa(no_rfq));
              window.location.href = urlRedirect;
            } else {
              var urlRedirect = "{{ route('prctrfqs.show', 'param') }}";
              urlRedirect = urlRedirect.replace('param', window.btoa(no_rfq));
              window.location.href = urlRedirect;
            }
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

  function rejectRfq(no_rfq, mode)
  {
    var msg = 'Anda yakin REJECT No. RFQ: ' + no_rfq + '?';
    var txt = '';
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
          '<textarea id="swal-input2" class="form-control" maxlength="100" rows="3" cols="20" placeholder="Keterangan Reject (Max. 100 Karakter)" style="text-transform:uppercase;resize:vertical">',
        preConfirm: function () {
          return new Promise(function (resolve, reject) {
            if ($('#swal-input2').val()) {
              if($('#swal-input2').val().length > 100) {
                reject('Keterangan Reject Max 100 Karakter!')
              } else {
                resolve([
                  $('#swal-input2').val()
                ])
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
        var url = "{{ route('prctrfqs.reject')}}";
        $("#loading").show();
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method        : 'POST',
            // menambah csrf token dari Laravel
            _token         : token,
            no_rfq         : window.btoa(no_rfq),
            mode           : window.btoa(mode), 
            keterangan     : window.btoa(result[0]),
          },
          success:function(data){
            $("#loading").hide();
            if(data.status === 'OK'){
              swal("Rejected", data.message, "success");
              var urlRedirect = "{{ route('prctrfqs.showdetail', 'param') }}";
              urlRedirect = urlRedirect.replace('param', window.btoa(no_rfq));
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
</script>
@endsection