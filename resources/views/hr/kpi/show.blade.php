@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        KPI Division
        <small>Detail KPI Division <b>{{ $hrdtkpi->desc_div." ".$hrdtkpi->tahun }}</b></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('hrdtkpis.index') }}"><i class="fa fa-files-o"></i> KPI Division</a></li>
        <li class="active">Detail KPI Division {{ $hrdtkpi->tahun }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detail KPI Division</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 5%;"><b>Year</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 25%;">{{ $hrdtkpi->tahun }}</td>
                    <td style="width: 10%;"><b>Company Plan</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      <a target="_blank" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Show Activity {{ $hrdtkpi->tahun }}" href="{{ route('hrdtkpis.downloadcp', base64_encode($hrdtkpi->tahun)) }}"><span class="glyphicon glyphicon-download-alt"></span> Show Activity</a>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>PT</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 25%;">{{ $hrdtkpi->kd_pt." - ".$hrdtkpi->nm_pt }}</td>
                    <td style="width: 10%;"><b>Name</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $hrdtkpi->npk." - ".$hrdtkpi->masKaryawan($hrdtkpi->npk)->nama }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Divisi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 25%;">{{ $hrdtkpi->kd_div." - ".$hrdtkpi->desc_div }}</td>
                    <td style="width: 10%;"><b>Superior</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $hrdtkpi->npk_atasan." - ".$hrdtkpi->namaByNpk($hrdtkpi->npk_atasan) }}</td>
                  </tr>
                  @if (!empty($hrdtkpi->submit_tgl))
                    <tr>
                      <td style="width: 5%;"><b>Submit</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $hrdtkpi->submit_pic." - ".$hrdtkpi->nama($hrdtkpi->submit_pic) }} - {{ \Carbon\Carbon::parse($hrdtkpi->submit_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($hrdtkpi->approve_atasan_tgl))
                    <tr>
                      <td style="width: 5%;"><b>Approve Superior</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $hrdtkpi->approve_atasan." - ".$hrdtkpi->nama($hrdtkpi->approve_atasan) }} - {{ \Carbon\Carbon::parse($hrdtkpi->approve_atasan_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($hrdtkpi->approve_hr_tgl))
                    <tr>
                      <td style="width: 5%;"><b>Approve HRD</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $hrdtkpi->approve_hr." - ".$hrdtkpi->nama($hrdtkpi->approve_hr) }} - {{ \Carbon\Carbon::parse($hrdtkpi->approve_hr_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($hrdtkpi->reject_tgl))
                    <tr>
                      <td style="width: 5%;"><b>Reject</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $hrdtkpi->reject_pic." - ".$hrdtkpi->nama($hrdtkpi->reject_pic) }} - {{ \Carbon\Carbon::parse($hrdtkpi->reject_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 5%;"><b>Ket. Reject</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">{{ $hrdtkpi->reject_ket }}</td>
                    </tr>
                  @endif
                  @if (!empty($hrdtkpi->submit_review_q1_tgl))
                    <tr>
                      <td style="width: 5%;"><b>Submit Review Q1</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $hrdtkpi->submit_review_q1_pic." - ".$hrdtkpi->nama($hrdtkpi->submit_review_q1_pic) }} - {{ \Carbon\Carbon::parse($hrdtkpi->submit_review_q1_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($hrdtkpi->approve_review_q1_tgl))
                    <tr>
                      <td style="width: 5%;"><b>Approve Review Q1</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $hrdtkpi->approve_review_q1_pic." - ".$hrdtkpi->nama($hrdtkpi->approve_review_q1_pic) }} - {{ \Carbon\Carbon::parse($hrdtkpi->approve_review_q1_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($hrdtkpi->reject_review_q1_tgl))
                    <tr>
                      <td style="width: 5%;"><b>Reject Review Q1</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $hrdtkpi->reject_review_q1_pic." - ".$hrdtkpi->nama($hrdtkpi->reject_review_q1_pic) }} - {{ \Carbon\Carbon::parse($hrdtkpi->reject_review_q1_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 5%;"><b>Ket. Reject Review Q1/b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">{{ $hrdtkpi->reject_review_q1_ket }}</td>
                    </tr>
                  @endif
                  @if (!empty($hrdtkpi->submit_review_q2_tgl))
                    <tr>
                      <td style="width: 5%;"><b>Submit Review Q2</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $hrdtkpi->submit_review_q2_pic." - ".$hrdtkpi->nama($hrdtkpi->submit_review_q2_pic) }} - {{ \Carbon\Carbon::parse($hrdtkpi->submit_review_q2_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($hrdtkpi->approve_review_q2_tgl))
                    <tr>
                      <td style="width: 5%;"><b>Approve Review Q2</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $hrdtkpi->approve_review_q2_pic." - ".$hrdtkpi->nama($hrdtkpi->approve_review_q2_pic) }} - {{ \Carbon\Carbon::parse($hrdtkpi->approve_review_q2_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($hrdtkpi->reject_review_q2_tgl))
                    <tr>
                      <td style="width: 5%;"><b>Reject Review Q2</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $hrdtkpi->reject_review_q2_pic." - ".$hrdtkpi->nama($hrdtkpi->reject_review_q2_pic) }} - {{ \Carbon\Carbon::parse($hrdtkpi->reject_review_q2_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 5%;"><b>Ket. Reject Review Q2/b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">{{ $hrdtkpi->reject_review_q2_ket }}</td>
                    </tr>
                  @endif
                  @if (!empty($hrdtkpi->submit_review_q3_tgl))
                    <tr>
                      <td style="width: 5%;"><b>Submit Review Q3</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $hrdtkpi->submit_review_q3_pic." - ".$hrdtkpi->nama($hrdtkpi->submit_review_q3_pic) }} - {{ \Carbon\Carbon::parse($hrdtkpi->submit_review_q3_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($hrdtkpi->approve_review_q3_tgl))
                    <tr>
                      <td style="width: 5%;"><b>Approve Review Q3</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $hrdtkpi->approve_review_q3_pic." - ".$hrdtkpi->nama($hrdtkpi->approve_review_q3_pic) }} - {{ \Carbon\Carbon::parse($hrdtkpi->approve_review_q3_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($hrdtkpi->reject_review_q3_tgl))
                    <tr>
                      <td style="width: 5%;"><b>Reject Review Q3</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $hrdtkpi->reject_review_q3_pic." - ".$hrdtkpi->nama($hrdtkpi->reject_review_q3_pic) }} - {{ \Carbon\Carbon::parse($hrdtkpi->reject_review_q3_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 5%;"><b>Ket. Reject Review Q3/b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">{{ $hrdtkpi->reject_review_q3_ket }}</td>
                    </tr>
                  @endif
                  @if (!empty($hrdtkpi->submit_review_q4_tgl))
                    <tr>
                      <td style="width: 5%;"><b>Submit Review Q4</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $hrdtkpi->submit_review_q4_pic." - ".$hrdtkpi->nama($hrdtkpi->submit_review_q4_pic) }} - {{ \Carbon\Carbon::parse($hrdtkpi->submit_review_q4_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($hrdtkpi->approve_review_q4_tgl))
                    <tr>
                      <td style="width: 5%;"><b>Approve Review Q4</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $hrdtkpi->approve_review_q4_pic." - ".$hrdtkpi->nama($hrdtkpi->approve_review_q4_pic) }} - {{ \Carbon\Carbon::parse($hrdtkpi->approve_review_q4_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($hrdtkpi->reject_review_q4_tgl))
                    <tr>
                      <td style="width: 5%;"><b>Reject Review Q4</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $hrdtkpi->reject_review_q4_pic." - ".$hrdtkpi->nama($hrdtkpi->reject_review_q4_pic) }} - {{ \Carbon\Carbon::parse($hrdtkpi->reject_review_q4_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 5%;"><b>Ket. Reject Review Q4/b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">{{ $hrdtkpi->reject_review_q4_ket }}</td>
                    </tr>
                  @endif
                  <tr>
                    <td style="width: 5%;"><b>Status</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 25%;">{{ $hrdtkpi->status }}</td>
                    <td style="width: 10%;"><b>Revisi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if ($hrdtkpi->hrdtKpiRejects()->get()->count() > 0)
                        {{ $hrdtkpi->revisi }}
                        @foreach ($hrdtkpi->hrdtKpiRejects()->get() as $hrdtkpireject)
                          @if (Auth::user()->can(['hrd-kpi-view','hrd-kpi-create','hrd-kpi-delete','hrd-kpi-submit']))
                            {{ "&nbsp;-&nbsp;&nbsp;" }}<a target="_blank" href="{{ route('hrdtkpis.showrevisi', base64_encode($hrdtkpireject->id)) }}" data-toggle="tooltip" data-placement="top" title="Show History KPI Division No. Revisi {{ $hrdtkpireject->revisi }}">{{ $hrdtkpireject->revisi }}</a>
                          @else
                            {{ "&nbsp;-&nbsp;&nbsp;".$hrdtkpireject->revisi }}
                          @endif
                        @endforeach
                      @else
                        {{ $hrdtkpi->revisi }}
                      @endif
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->

            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active" id="nav_fp">
                <a href="#fp" aria-controls="fp" role="tab" data-toggle="tab" title="Financial Performance">
                  I. Financial Performance
                </a>
              </li>
              <li role="presentation" id="nav_cs">
                <a href="#cs" aria-controls="cs" role="tab" data-toggle="tab" title="Customer">
                  II. Customer
                </a>
              </li>
              <li role="presentation" id="nav_ip">
                <a href="#ip" aria-controls="ip" role="tab" data-toggle="tab" title="Internal Process">
                  III. Internal Process
                </a>
              </li>
              <li role="presentation" id="nav_lg">
                <a href="#lg" aria-controls="lg" role="tab" data-toggle="tab" title="Learning & Growth">
                  IV. Learning & Growth
                </a>
              </li>
              <li role="presentation" id="nav_cr">
                <a href="#cr" aria-controls="cr" role="tab" data-toggle="tab" title="Compliance Reporting">
                  V. Compliance Reporting
                </a>
              </li>
            </ul>
            <!-- /.tablist -->

            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="fp">
                <div class="box-body" id="field-fp">
                  @foreach ($hrdtkpi->hrdtKpiActByItem("FP")->get() as $model)
                    <div class="row" id="field_fp_{{ $loop->iteration }}">
                      <div class="col-md-12">
                        <div class="box box-primary">
                          <div class="box-header with-border">
                            <h3 class="box-title" id="box_fp_{{ $loop->iteration }}">Financial Performance - Activity ({{ $loop->iteration }}) (*)</h3>
                            <div class="box-tools pull-right">
                              <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                              </button>
                            </div>
                          </div>
                          <!-- /.box-header -->
                          <div class="box-body">
                            <div class="row form-group">
                              <div class="col-sm-12 {{ $errors->has('kpi_ref_desc_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('kpi_ref_desc_fp_'.$loop->iteration, 'KPI Reference') !!}
                                {!! Form::textarea('kpi_ref_desc_fp_'.$loop->iteration, $model->kpi_ref_desc, ['class'=>'form-control', 'placeholder' => 'KPI Reference (Klik tombol Search)', 'rows' => '5', 'style' => 'resize:vertical', 'id' => 'kpi_ref_desc_fp_'.$loop->iteration, 'disabled' => '', 'required']) !!}
                                {!! Form::hidden('kpi_ref_fp_'.$loop->iteration, base64_encode($model->kpi_ref), ['class'=>'form-control', 'id' => 'kpi_ref_fp_'.$loop->iteration, 'readonly'=>'readonly', 'required']) !!}
                                {!! $errors->first('kpi_ref_desc_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                              </div>
                            </div>
                            <!-- /.form-group -->
                            <div class="row form-group">
                              <div class="col-sm-12 {{ $errors->has('activity_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('activity_fp_'.$loop->iteration, 'Activity') !!}
                                {!! Form::textarea('activity_fp_'.$loop->iteration, $model->activity, ['class'=>'form-control', 'placeholder' => 'Activity', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'activity_fp_'.$loop->iteration, 'required', 'readonly'=>'readonly']) !!}
                                {!! Form::hidden('hrdtkpi_fp_id_'.$loop->iteration, base64_encode($model->id), ['class'=>'form-control', 'id' => 'hrdtkpi_fp_id_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                {!! $errors->first('activity_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                              </div>
                            </div>
                            <!-- /.form-group -->

                            <ul class="nav nav-tabs" role="tablist">
                              <li role="presentation" class="active">
                                <a href="#q1_fp_{{ $loop->iteration }}" aria-controls="q1_fp_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                                  <i class="fa fa-pencil-square-o"></i> Q1
                                </a>
                              </li>
                              <li role="presentation">
                                <a href="#q2_fp_{{ $loop->iteration }}" aria-controls="q2_fp_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                                  <i class="fa fa-pencil-square-o"></i> Q2
                                </a>
                              </li>
                              <li role="presentation">
                                <a href="#q3_fp_{{ $loop->iteration }}" aria-controls="q3_fp_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                                  <i class="fa fa-pencil-square-o"></i> Q3
                                </a>
                              </li>
                              <li role="presentation">
                                <a href="#q4_fp_{{ $loop->iteration }}" aria-controls="q4_fp_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                                  <i class="fa fa-pencil-square-o"></i> Q4
                                </a>
                              </li>
                            </ul>

                            <div class="tab-content">
                              <div role="tabpanel" class="tab-pane active" id="q1_fp_{{ $loop->iteration }}">
                                <div class="box-body">
                                  <div class="row form-group">
                                    <div class="col-sm-9 {{ $errors->has('target_q1_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('target_q1_fp_'.$loop->iteration, 'Q1 Target') !!}
                                      {!! Form::textarea('target_q1_fp_'.$loop->iteration, $model->target_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      {!! $errors->first('target_q1_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="col-sm-3 {{ $errors->has('tgl_start_q1_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('tgl_start_q1_fp_'.$loop->iteration, 'Due Date Q1') !!}
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        {!! Form::text('tgl_start_q1_fp_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q1', 'id' => 'tgl_start_q1_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      </div>
                                      <!-- /.input group -->
                                      {!! $errors->first('tgl_start_q1_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                  </div>
                                  <!-- /.form-group -->
                                  @if ($hrdtkpi->status === "APPROVE HRD" || $hrdtkpi->status === "SUBMIT REVIEW Q1" || $hrdtkpi->status === "SUBMIT REVIEW Q2" || $hrdtkpi->status === "SUBMIT REVIEW Q3" || $hrdtkpi->status === "SUBMIT REVIEW Q4")
                                    <div class="row form-group">
                                      <div class="col-sm-9 {{ $errors->has('target_q1_act_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('target_q1_act_fp_'.$loop->iteration, 'Q1 Actual') !!}
                                        {!! Form::textarea('target_q1_act_fp_'.$loop->iteration, $model->target_q1_act, ['class'=>'form-control', 'placeholder' => 'Q1 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_act_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('target_q1_act_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                      <div class="col-sm-3 {{ $errors->has('tgl_start_act_q1_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('tgl_start_act_q1_fp_'.$loop->iteration, 'Act Date Q1') !!}
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          {!! Form::text('tgl_start_act_q1_fp_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q1', 'id' => 'tgl_start_act_q1_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        </div>
                                        <!-- /.input group -->
                                        {!! $errors->first('tgl_start_act_q1_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="row form-group">
                                      <div class="col-sm-3 {{ $errors->has('persen_q1_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('persen_q1_fp_'.$loop->iteration, 'Q1 Progress (%)') !!}
                                        {!! Form::number('persen_q1_fp_'.$loop->iteration, $model->persen_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Progress', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q1_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('persen_q1_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                  @endif
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.tabpanel -->
                              <div role="tabpanel" class="tab-pane" id="q2_fp_{{ $loop->iteration }}">
                                <div class="box-body">
                                  <div class="row form-group">
                                    <div class="col-sm-9 {{ $errors->has('target_q2_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('target_q2_fp_'.$loop->iteration, 'Q2 Target') !!}
                                      {!! Form::textarea('target_q2_fp_'.$loop->iteration, $model->target_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      {!! $errors->first('target_q2_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="col-sm-3 {{ $errors->has('tgl_start_q2_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('tgl_start_q2_fp_'.$loop->iteration, 'Due Date Q2') !!}
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        {!! Form::text('tgl_start_q2_fp_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q2', 'id' => 'tgl_start_q2_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      </div>
                                      <!-- /.input group -->
                                      {!! $errors->first('tgl_start_q2_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                  </div>
                                  <!-- /.form-group -->
                                  @if ($hrdtkpi->status === "APPROVE HRD" || $hrdtkpi->status === "SUBMIT REVIEW Q1" || $hrdtkpi->status === "SUBMIT REVIEW Q2" || $hrdtkpi->status === "SUBMIT REVIEW Q3" || $hrdtkpi->status === "SUBMIT REVIEW Q4")
                                    <div class="row form-group">
                                      <div class="col-sm-9 {{ $errors->has('target_q2_act_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('target_q2_act_fp_'.$loop->iteration, 'Q2 Actual') !!}
                                        {!! Form::textarea('target_q2_act_fp_'.$loop->iteration, $model->target_q2_act, ['class'=>'form-control', 'placeholder' => 'Q2 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_act_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('target_q2_act_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                      <div class="col-sm-3 {{ $errors->has('tgl_start_act_q2_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('tgl_start_act_q2_fp_'.$loop->iteration, 'Act Date Q2') !!}
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          {!! Form::text('tgl_start_act_q2_fp_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q2', 'id' => 'tgl_start_act_q2_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        </div>
                                        <!-- /.input group -->
                                        {!! $errors->first('tgl_start_act_q2_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="row form-group">
                                      <div class="col-sm-3 {{ $errors->has('persen_q2_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('persen_q2_fp_'.$loop->iteration, 'Q2 Progress (%)') !!}
                                        {!! Form::number('persen_q2_fp_'.$loop->iteration, $model->persen_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Progress', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q2_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('persen_q2_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                  @endif
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.tabpanel -->
                              <div role="tabpanel" class="tab-pane" id="q3_fp_{{ $loop->iteration }}">
                                <div class="box-body">
                                  <div class="row form-group">
                                    <div class="col-sm-9 {{ $errors->has('target_q3_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('target_q3_fp_'.$loop->iteration, 'Q3 Target') !!}
                                      {!! Form::textarea('target_q3_fp_'.$loop->iteration, $model->target_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      {!! $errors->first('target_q3_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="col-sm-3 {{ $errors->has('tgl_start_q3_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('tgl_start_q3_fp_'.$loop->iteration, 'Due Date Q3') !!}
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        {!! Form::text('tgl_start_q3_fp_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q3', 'id' => 'tgl_start_q3_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      </div>
                                      <!-- /.input group -->
                                      {!! $errors->first('tgl_start_q3_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                  </div>
                                  <!-- /.form-group -->
                                  @if ($hrdtkpi->status === "APPROVE HRD" || $hrdtkpi->status === "SUBMIT REVIEW Q1" || $hrdtkpi->status === "SUBMIT REVIEW Q2" || $hrdtkpi->status === "SUBMIT REVIEW Q3" || $hrdtkpi->status === "SUBMIT REVIEW Q4")
                                    <div class="row form-group">
                                      <div class="col-sm-9 {{ $errors->has('target_q3_act_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('target_q3_act_fp_'.$loop->iteration, 'Q3 Actual') !!}
                                        {!! Form::textarea('target_q3_act_fp_'.$loop->iteration, $model->target_q3_act, ['class'=>'form-control', 'placeholder' => 'Q3 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_act_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('target_q3_act_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                      <div class="col-sm-3 {{ $errors->has('tgl_start_act_q3_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('tgl_start_act_q3_fp_'.$loop->iteration, 'Act Date Q3') !!}
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          {!! Form::text('tgl_start_act_q3_fp_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q3', 'id' => 'tgl_start_act_q3_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        </div>
                                        <!-- /.input group -->
                                        {!! $errors->first('tgl_start_act_q3_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="row form-group">
                                      <div class="col-sm-3 {{ $errors->has('persen_q3_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('persen_q3_fp_'.$loop->iteration, 'Q3 Progress (%)') !!}
                                        {!! Form::number('persen_q3_fp_'.$loop->iteration, $model->persen_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Progress', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q3_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('persen_q3_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                  @endif
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.tabpanel -->
                              <div role="tabpanel" class="tab-pane" id="q4_fp_{{ $loop->iteration }}">
                                <div class="box-body">
                                  <div class="row form-group">
                                    <div class="col-sm-9 {{ $errors->has('target_q4_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('target_q4_fp_'.$loop->iteration, 'Q4 Target') !!}
                                      {!! Form::textarea('target_q4_fp_'.$loop->iteration, $model->target_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      {!! $errors->first('target_q4_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="col-sm-3 {{ $errors->has('tgl_start_q4_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('tgl_start_q4_fp_'.$loop->iteration, 'Due Date Q4') !!}
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        {!! Form::text('tgl_start_q4_fp_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q4', 'id' => 'tgl_start_q4_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      </div>
                                      <!-- /.input group -->
                                      {!! $errors->first('tgl_start_q4_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                  </div>
                                  <!-- /.form-group -->
                                  @if ($hrdtkpi->status === "APPROVE HRD" || $hrdtkpi->status === "SUBMIT REVIEW Q1" || $hrdtkpi->status === "SUBMIT REVIEW Q2" || $hrdtkpi->status === "SUBMIT REVIEW Q3" || $hrdtkpi->status === "SUBMIT REVIEW Q4")
                                    <div class="row form-group">
                                      <div class="col-sm-9 {{ $errors->has('target_q4_act_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('target_q4_act_fp_'.$loop->iteration, 'Q4 Actual') !!}
                                        {!! Form::textarea('target_q4_act_fp_'.$loop->iteration, $model->target_q4_act, ['class'=>'form-control', 'placeholder' => 'Q4 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_act_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('target_q4_act_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                      <div class="col-sm-3 {{ $errors->has('tgl_start_act_q4_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('tgl_start_act_q4_fp_'.$loop->iteration, 'Act Date Q4') !!}
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          {!! Form::text('tgl_start_act_q4_fp_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q4', 'id' => 'tgl_start_act_q4_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        </div>
                                        <!-- /.input group -->
                                        {!! $errors->first('tgl_start_act_q4_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="row form-group">
                                      <div class="col-sm-3 {{ $errors->has('persen_q4_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('persen_q4_fp_'.$loop->iteration, 'Q4 Progress (%)') !!}
                                        {!! Form::number('persen_q4_fp_'.$loop->iteration, $model->persen_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Progress', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q4_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('persen_q4_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                  @endif
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.tabpanel -->
                            </div>
                            <!-- /.tab-content -->
                            <hr class="box box-primary">
                            <div class="row form-group">
                              <div class="col-sm-3 {{ $errors->has('weight_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('weight_fp_'.$loop->iteration, 'Weight (%) (*)') !!}
                                {!! Form::number('weight_fp_'.$loop->iteration, $model->weight, ['class'=>'form-control', 'placeholder' => 'Weight', 'onchange' => 'refreshTotalWeight(this)', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'weight_fp_'.$loop->iteration, 'required', 'readonly'=>'readonly']) !!}
                                {!! $errors->first('weight_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                              </div>
                              <div class="col-sm-6 {{ $errors->has('departemen_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('departemen_fp_'.$loop->iteration, 'Department in Charge') !!}
                                {!! Form::select('departemen_fp_'.$loop->iteration.'[]', $departement->pluck('desc_dep','kd_dep')->all(), $model->departemen, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen_fp_'.$loop->iteration.'[]', 'disabled'=>'']) !!}
                                {!! $errors->first('departemen_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                              </div>
                            </div>
                            <!-- /.form-group -->
                            <div class="row form-group">
                              <div class="col-sm-3 {{ $errors->has('total_weight_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('total_weight_fp_'.$loop->iteration, 'Summary Weight (%)') !!}
                                {!! Form::number('total_weight_fp_'.$loop->iteration, $model->total_weight, ['class'=>'form-control', 'placeholder' => 'Summary Weight', 'max'=>'100', 'step'=>'any', 'disabled'=>'', 'id' => 'total_weight_fp_'.$loop->iteration]) !!}
                                {!! $errors->first('total_weight_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                              </div>
                              <div class="col-sm-6 {{ $errors->has('departemen2_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('departemen2_fp_'.$loop->iteration, 'Need Support Others Department') !!}
                                {!! Form::select('departemen2_fp_'.$loop->iteration.'[]', $departement2->pluck('desc_dep','kd_dep')->all(), $model->departemen2, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen2_fp_'.$loop->iteration.'[]', 'disabled'=>'']) !!}
                                {!! $errors->first('departemen2_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
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
                  @endforeach
                  {!! Form::hidden('jml_row_fp', $hrdtkpi->hrdtKpiActByItem("FP")->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_fp']) !!}
                </div>
                <!-- /.box-body -->
                <div class="box-body">
                  <p class="pull-right">
                    <button id="nextRowFp" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Next to Customer"><span class="glyphicon glyphicon-arrow-right"></span> Next to Customer</button>
                  </p>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.tabpanel -->
              <div role="tabpanel" class="tab-pane" id="cs">
                <div class="box-body" id="field-cs">
                  @foreach ($hrdtkpi->hrdtKpiActByItem("CS")->get() as $model)
                    <div class="row" id="field_cs_{{ $loop->iteration }}">
                      <div class="col-md-12">
                        <div class="box box-primary">
                          <div class="box-header with-border">
                            <h3 class="box-title" id="box_cs_{{ $loop->iteration }}">Customer - Activity ({{ $loop->iteration }}) (*)</h3>
                            <div class="box-tools pull-right">
                              <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                              </button>
                            </div>
                          </div>
                          <!-- /.box-header -->
                          <div class="box-body">
                            <div class="row form-group">
                              <div class="col-sm-12 {{ $errors->has('kpi_ref_desc_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('kpi_ref_desc_cs_'.$loop->iteration, 'KPI Reference') !!}
                                {!! Form::textarea('kpi_ref_desc_cs_'.$loop->iteration, $model->kpi_ref_desc, ['class'=>'form-control', 'placeholder' => 'KPI Reference (Klik tombol Search)', 'rows' => '5', 'style' => 'resize:vertical', 'id' => 'kpi_ref_desc_cs_'.$loop->iteration, 'disabled' => '', 'required']) !!}
                                {!! Form::hidden('kpi_ref_cs_'.$loop->iteration, base64_encode($model->kpi_ref), ['class'=>'form-control', 'id' => 'kpi_ref_cs_'.$loop->iteration, 'readonly'=>'readonly', 'required']) !!}
                                {!! $errors->first('kpi_ref_desc_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                              </div>
                            </div>
                            <!-- /.form-group -->
                            <div class="row form-group">
                              <div class="col-sm-12 {{ $errors->has('activity_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('activity_cs_'.$loop->iteration, 'Activity') !!}
                                {!! Form::textarea('activity_cs_'.$loop->iteration, $model->activity, ['class'=>'form-control', 'placeholder' => 'Activity', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'activity_cs_'.$loop->iteration, 'required', 'readonly'=>'readonly']) !!}
                                {!! Form::hidden('hrdtkpi_cs_id_'.$loop->iteration, base64_encode($model->id), ['class'=>'form-control', 'id' => 'hrdtkpi_cs_id_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                {!! $errors->first('activity_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                              </div>
                            </div>
                            <!-- /.form-group -->

                            <ul class="nav nav-tabs" role="tablist">
                              <li role="presentation" class="active">
                                <a href="#q1_cs_{{ $loop->iteration }}" aria-controls="q1_cs_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                                  <i class="fa fa-pencil-square-o"></i> Q1
                                </a>
                              </li>
                              <li role="presentation">
                                <a href="#q2_cs_{{ $loop->iteration }}" aria-controls="q2_cs_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                                  <i class="fa fa-pencil-square-o"></i> Q2
                                </a>
                              </li>
                              <li role="presentation">
                                <a href="#q3_cs_{{ $loop->iteration }}" aria-controls="q3_cs_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                                  <i class="fa fa-pencil-square-o"></i> Q3
                                </a>
                              </li>
                              <li role="presentation">
                                <a href="#q4_cs_{{ $loop->iteration }}" aria-controls="q4_cs_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                                  <i class="fa fa-pencil-square-o"></i> Q4
                                </a>
                              </li>
                            </ul>

                            <div class="tab-content">
                              <div role="tabpanel" class="tab-pane active" id="q1_cs_{{ $loop->iteration }}">
                                <div class="box-body">
                                  <div class="row form-group">
                                    <div class="col-sm-9 {{ $errors->has('target_q1_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('target_q1_cs_'.$loop->iteration, 'Q1 Target') !!}
                                      {!! Form::textarea('target_q1_cs_'.$loop->iteration, $model->target_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      {!! $errors->first('target_q1_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="col-sm-3 {{ $errors->has('tgl_start_q1_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('tgl_start_q1_cs_'.$loop->iteration, 'Due Date Q1') !!}
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        {!! Form::text('tgl_start_q1_cs_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q1', 'id' => 'tgl_start_q1_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      </div>
                                      <!-- /.input group -->
                                      {!! $errors->first('tgl_start_q1_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                  </div>
                                  <!-- /.form-group -->
                                  @if ($hrdtkpi->status === "APPROVE HRD" || $hrdtkpi->status === "SUBMIT REVIEW Q1" || $hrdtkpi->status === "SUBMIT REVIEW Q2" || $hrdtkpi->status === "SUBMIT REVIEW Q3" || $hrdtkpi->status === "SUBMIT REVIEW Q4")
                                    <div class="row form-group">
                                      <div class="col-sm-9 {{ $errors->has('target_q1_act_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('target_q1_act_cs_'.$loop->iteration, 'Q1 Actual') !!}
                                        {!! Form::textarea('target_q1_act_cs_'.$loop->iteration, $model->target_q1_act, ['class'=>'form-control', 'placeholder' => 'Q1 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_act_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('target_q1_act_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                      <div class="col-sm-3 {{ $errors->has('tgl_start_act_q1_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('tgl_start_act_q1_cs_'.$loop->iteration, 'Act Date Q1') !!}
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          {!! Form::text('tgl_start_act_q1_cs_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q1', 'id' => 'tgl_start_act_q1_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        </div>
                                        <!-- /.input group -->
                                        {!! $errors->first('tgl_start_act_q1_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="row form-group">
                                      <div class="col-sm-3 {{ $errors->has('persen_q1_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('persen_q1_cs_'.$loop->iteration, 'Q1 Progress (%)') !!}
                                        {!! Form::number('persen_q1_cs_'.$loop->iteration, $model->persen_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Progress', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q1_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('persen_q1_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                  @endif
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.tabpanel -->
                              <div role="tabpanel" class="tab-pane" id="q2_cs_{{ $loop->iteration }}">
                                <div class="box-body">
                                  <div class="row form-group">
                                    <div class="col-sm-9 {{ $errors->has('target_q2_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('target_q2_cs_'.$loop->iteration, 'Q2 Target') !!}
                                      {!! Form::textarea('target_q2_cs_'.$loop->iteration, $model->target_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      {!! $errors->first('target_q2_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="col-sm-3 {{ $errors->has('tgl_start_q2_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('tgl_start_q2_cs_'.$loop->iteration, 'Due Date Q2') !!}
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        {!! Form::text('tgl_start_q2_cs_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q2', 'id' => 'tgl_start_q2_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      </div>
                                      <!-- /.input group -->
                                      {!! $errors->first('tgl_start_q2_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                  </div>
                                  <!-- /.form-group -->
                                  @if ($hrdtkpi->status === "APPROVE HRD" || $hrdtkpi->status === "SUBMIT REVIEW Q1" || $hrdtkpi->status === "SUBMIT REVIEW Q2" || $hrdtkpi->status === "SUBMIT REVIEW Q3" || $hrdtkpi->status === "SUBMIT REVIEW Q4")
                                    <div class="row form-group">
                                      <div class="col-sm-9 {{ $errors->has('target_q2_act_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('target_q2_act_cs_'.$loop->iteration, 'Q2 Actual') !!}
                                        {!! Form::textarea('target_q2_act_cs_'.$loop->iteration, $model->target_q2_act, ['class'=>'form-control', 'placeholder' => 'Q2 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_act_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('target_q2_act_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                      <div class="col-sm-3 {{ $errors->has('tgl_start_act_q2_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('tgl_start_act_q2_cs_'.$loop->iteration, 'Act Date Q2') !!}
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          {!! Form::text('tgl_start_act_q2_cs_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q2', 'id' => 'tgl_start_act_q2_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        </div>
                                        <!-- /.input group -->
                                        {!! $errors->first('tgl_start_act_q2_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="row form-group">
                                      <div class="col-sm-3 {{ $errors->has('persen_q2_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('persen_q2_cs_'.$loop->iteration, 'Q2 Progress (%)') !!}
                                        {!! Form::number('persen_q2_cs_'.$loop->iteration, $model->persen_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Progress', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q2_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('persen_q2_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                  @endif
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.tabpanel -->
                              <div role="tabpanel" class="tab-pane" id="q3_cs_{{ $loop->iteration }}">
                                <div class="box-body">
                                  <div class="row form-group">
                                    <div class="col-sm-9 {{ $errors->has('target_q3_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('target_q3_cs_'.$loop->iteration, 'Q3 Target') !!}
                                      {!! Form::textarea('target_q3_cs_'.$loop->iteration, $model->target_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      {!! $errors->first('target_q3_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="col-sm-3 {{ $errors->has('tgl_start_q3_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('tgl_start_q3_cs_'.$loop->iteration, 'Due Date Q3') !!}
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        {!! Form::text('tgl_start_q3_cs_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q3', 'id' => 'tgl_start_q3_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      </div>
                                      <!-- /.input group -->
                                      {!! $errors->first('tgl_start_q3_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                  </div>
                                  <!-- /.form-group -->
                                  @if ($hrdtkpi->status === "APPROVE HRD" || $hrdtkpi->status === "SUBMIT REVIEW Q1" || $hrdtkpi->status === "SUBMIT REVIEW Q2" || $hrdtkpi->status === "SUBMIT REVIEW Q3" || $hrdtkpi->status === "SUBMIT REVIEW Q4")
                                    <div class="row form-group">
                                      <div class="col-sm-9 {{ $errors->has('target_q3_act_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('target_q3_act_cs_'.$loop->iteration, 'Q3 Actual') !!}
                                        {!! Form::textarea('target_q3_act_cs_'.$loop->iteration, $model->target_q3_act, ['class'=>'form-control', 'placeholder' => 'Q3 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_act_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('target_q3_act_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                      <div class="col-sm-3 {{ $errors->has('tgl_start_act_q3_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('tgl_start_act_q3_cs_'.$loop->iteration, 'Act Date Q3') !!}
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          {!! Form::text('tgl_start_act_q3_cs_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q3', 'id' => 'tgl_start_act_q3_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        </div>
                                        <!-- /.input group -->
                                        {!! $errors->first('tgl_start_act_q3_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="row form-group">
                                      <div class="col-sm-3 {{ $errors->has('persen_q3_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('persen_q3_cs_'.$loop->iteration, 'Q3 Progress (%)') !!}
                                        {!! Form::number('persen_q3_cs_'.$loop->iteration, $model->persen_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Progress', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q3_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('persen_q3_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                  @endif
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.tabpanel -->
                              <div role="tabpanel" class="tab-pane" id="q4_cs_{{ $loop->iteration }}">
                                <div class="box-body">
                                  <div class="row form-group">
                                    <div class="col-sm-9 {{ $errors->has('target_q4_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('target_q4_cs_'.$loop->iteration, 'Q4 Target') !!}
                                      {!! Form::textarea('target_q4_cs_'.$loop->iteration, $model->target_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      {!! $errors->first('target_q4_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="col-sm-3 {{ $errors->has('tgl_start_q4_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('tgl_start_q4_cs_'.$loop->iteration, 'Due Date Q4') !!}
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        {!! Form::text('tgl_start_q4_cs_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q4', 'id' => 'tgl_start_q4_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      </div>
                                      <!-- /.input group -->
                                      {!! $errors->first('tgl_start_q4_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                  </div>
                                  <!-- /.form-group -->
                                  @if ($hrdtkpi->status === "APPROVE HRD" || $hrdtkpi->status === "SUBMIT REVIEW Q1" || $hrdtkpi->status === "SUBMIT REVIEW Q2" || $hrdtkpi->status === "SUBMIT REVIEW Q3" || $hrdtkpi->status === "SUBMIT REVIEW Q4")
                                    <div class="row form-group">
                                      <div class="col-sm-9 {{ $errors->has('target_q4_act_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('target_q4_act_cs_'.$loop->iteration, 'Q4 Actual') !!}
                                        {!! Form::textarea('target_q4_act_cs_'.$loop->iteration, $model->target_q4_act, ['class'=>'form-control', 'placeholder' => 'Q4 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_act_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('target_q4_act_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                      <div class="col-sm-3 {{ $errors->has('tgl_start_act_q4_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('tgl_start_act_q4_cs_'.$loop->iteration, 'Act Date Q4') !!}
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          {!! Form::text('tgl_start_act_q4_cs_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q4', 'id' => 'tgl_start_act_q4_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        </div>
                                        <!-- /.input group -->
                                        {!! $errors->first('tgl_start_act_q4_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="row form-group">
                                      <div class="col-sm-3 {{ $errors->has('persen_q4_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('persen_q4_cs_'.$loop->iteration, 'Q4 Progress (%)') !!}
                                        {!! Form::number('persen_q4_cs_'.$loop->iteration, $model->persen_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Progress', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q4_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('persen_q4_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                  @endif
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.tabpanel -->
                            </div>
                            <!-- /.tab-content -->
                            <hr class="box box-primary">
                            <div class="row form-group">
                              <div class="col-sm-3 {{ $errors->has('weight_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('weight_cs_'.$loop->iteration, 'Weight (%) (*)') !!}
                                {!! Form::number('weight_cs_'.$loop->iteration, $model->weight, ['class'=>'form-control', 'placeholder' => 'Weight', 'onchange' => 'refreshTotalWeight(this)', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'weight_cs_'.$loop->iteration, 'required', 'readonly'=>'readonly']) !!}
                                {!! $errors->first('weight_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                              </div>
                              <div class="col-sm-6 {{ $errors->has('departemen_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('departemen_cs_'.$loop->iteration, 'Department in Charge') !!}
                                {!! Form::select('departemen_cs_'.$loop->iteration.'[]', $departement->pluck('desc_dep','kd_dep')->all(), $model->departemen, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen_cs_'.$loop->iteration.'[]', 'disabled'=>'']) !!}
                                {!! $errors->first('departemen_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                              </div>
                            </div>
                            <!-- /.form-group -->
                            <div class="row form-group">
                              <div class="col-sm-3 {{ $errors->has('total_weight_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('total_weight_cs_'.$loop->iteration, 'Summary Weight (%)') !!}
                                {!! Form::number('total_weight_cs_'.$loop->iteration, $model->total_weight, ['class'=>'form-control', 'placeholder' => 'Summary Weight', 'max'=>'100', 'step'=>'any', 'disabled'=>'', 'id' => 'total_weight_cs_'.$loop->iteration]) !!}
                                {!! $errors->first('total_weight_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                              </div>
                              <div class="col-sm-6 {{ $errors->has('departemen2_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('departemen2_cs_'.$loop->iteration, 'Need Support Others Department') !!}
                                {!! Form::select('departemen2_cs_'.$loop->iteration.'[]', $departement2->pluck('desc_dep','kd_dep')->all(), $model->departemen2, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen2_cs_'.$loop->iteration.'[]', 'disabled'=>'']) !!}
                                {!! $errors->first('departemen2_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
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
                  @endforeach
                  {!! Form::hidden('jml_row_cs', $hrdtkpi->hrdtKpiActByItem("CS")->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_cs']) !!}
                </div>
                <!-- /.box-body -->
                <div class="box-body">
                  <p class="pull-right">
                    <button id="nextRowCs" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Next to Internal Process"><span class="glyphicon glyphicon-arrow-right"></span> Next to Internal Process</button>
                  </p>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.tabpanel -->
              <div role="tabpanel" class="tab-pane" id="ip">
                <div class="box-body" id="field-ip">
                  @foreach ($hrdtkpi->hrdtKpiActByItem("IP")->get() as $model)
                    <div class="row" id="field_ip_{{ $loop->iteration }}">
                      <div class="col-md-12">
                        <div class="box box-primary">
                          <div class="box-header with-border">
                            <h3 class="box-title" id="box_ip_{{ $loop->iteration }}">Internal Process - Activity ({{ $loop->iteration }}) (*)</h3>
                            <div class="box-tools pull-right">
                              <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                              </button>
                            </div>
                          </div>
                          <!-- /.box-header -->
                          <div class="box-body">
                            <div class="row form-group">
                              <div class="col-sm-12 {{ $errors->has('kpi_ref_desc_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('kpi_ref_desc_ip_'.$loop->iteration, 'KPI Reference') !!}
                                {!! Form::textarea('kpi_ref_desc_ip_'.$loop->iteration, $model->kpi_ref_desc, ['class'=>'form-control', 'placeholder' => 'KPI Reference (Klik tombol Search)', 'rows' => '5', 'style' => 'resize:vertical', 'id' => 'kpi_ref_desc_ip_'.$loop->iteration, 'disabled' => '', 'required']) !!}
                                {!! Form::hidden('kpi_ref_ip_'.$loop->iteration, base64_encode($model->kpi_ref), ['class'=>'form-control', 'id' => 'kpi_ref_ip_'.$loop->iteration, 'readonly'=>'readonly', 'required']) !!}
                                {!! $errors->first('kpi_ref_desc_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                              </div>
                            </div>
                            <!-- /.form-group -->
                            <div class="row form-group">
                              <div class="col-sm-12 {{ $errors->has('activity_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('activity_ip_'.$loop->iteration, 'Activity') !!}
                                {!! Form::textarea('activity_ip_'.$loop->iteration, $model->activity, ['class'=>'form-control', 'placeholder' => 'Activity', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'activity_ip_'.$loop->iteration, 'required', 'readonly'=>'readonly']) !!}
                                {!! Form::hidden('hrdtkpi_ip_id_'.$loop->iteration, base64_encode($model->id), ['class'=>'form-control', 'id' => 'hrdtkpi_ip_id_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                {!! $errors->first('activity_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                              </div>
                            </div>
                            <!-- /.form-group -->

                            <ul class="nav nav-tabs" role="tablist">
                              <li role="presentation" class="active">
                                <a href="#q1_ip_{{ $loop->iteration }}" aria-controls="q1_ip_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                                  <i class="fa fa-pencil-square-o"></i> Q1
                                </a>
                              </li>
                              <li role="presentation">
                                <a href="#q2_ip_{{ $loop->iteration }}" aria-controls="q2_ip_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                                  <i class="fa fa-pencil-square-o"></i> Q2
                                </a>
                              </li>
                              <li role="presentation">
                                <a href="#q3_ip_{{ $loop->iteration }}" aria-controls="q3_ip_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                                  <i class="fa fa-pencil-square-o"></i> Q3
                                </a>
                              </li>
                              <li role="presentation">
                                <a href="#q4_ip_{{ $loop->iteration }}" aria-controls="q4_ip_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                                  <i class="fa fa-pencil-square-o"></i> Q4
                                </a>
                              </li>
                            </ul>

                            <div class="tab-content">
                              <div role="tabpanel" class="tab-pane active" id="q1_ip_{{ $loop->iteration }}">
                                <div class="box-body">
                                  <div class="row form-group">
                                    <div class="col-sm-9 {{ $errors->has('target_q1_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('target_q1_ip_'.$loop->iteration, 'Q1 Target') !!}
                                      {!! Form::textarea('target_q1_ip_'.$loop->iteration, $model->target_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      {!! $errors->first('target_q1_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="col-sm-3 {{ $errors->has('tgl_start_q1_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('tgl_start_q1_ip_'.$loop->iteration, 'Due Date Q1') !!}
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        {!! Form::text('tgl_start_q1_ip_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q1', 'id' => 'tgl_start_q1_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      </div>
                                      <!-- /.input group -->
                                      {!! $errors->first('tgl_start_q1_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                  </div>
                                  <!-- /.form-group -->
                                  @if ($hrdtkpi->status === "APPROVE HRD" || $hrdtkpi->status === "SUBMIT REVIEW Q1" || $hrdtkpi->status === "SUBMIT REVIEW Q2" || $hrdtkpi->status === "SUBMIT REVIEW Q3" || $hrdtkpi->status === "SUBMIT REVIEW Q4")
                                    <div class="row form-group">
                                      <div class="col-sm-9 {{ $errors->has('target_q1_act_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('target_q1_act_ip_'.$loop->iteration, 'Q1 Actual') !!}
                                        {!! Form::textarea('target_q1_act_ip_'.$loop->iteration, $model->target_q1_act, ['class'=>'form-control', 'placeholder' => 'Q1 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_act_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('target_q1_act_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                      <div class="col-sm-3 {{ $errors->has('tgl_start_act_q1_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('tgl_start_act_q1_ip_'.$loop->iteration, 'Act Date Q1') !!}
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          {!! Form::text('tgl_start_act_q1_ip_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q1', 'id' => 'tgl_start_act_q1_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        </div>
                                        <!-- /.input group -->
                                        {!! $errors->first('tgl_start_act_q1_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="row form-group">
                                      <div class="col-sm-3 {{ $errors->has('persen_q1_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('persen_q1_ip_'.$loop->iteration, 'Q1 Progress (%)') !!}
                                        {!! Form::number('persen_q1_ip_'.$loop->iteration, $model->persen_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Progress', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q1_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('persen_q1_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                  @endif
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.tabpanel -->
                              <div role="tabpanel" class="tab-pane" id="q2_ip_{{ $loop->iteration }}">
                                <div class="box-body">
                                  <div class="row form-group">
                                    <div class="col-sm-9 {{ $errors->has('target_q2_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('target_q2_ip_'.$loop->iteration, 'Q2 Target') !!}
                                      {!! Form::textarea('target_q2_ip_'.$loop->iteration, $model->target_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      {!! $errors->first('target_q2_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="col-sm-3 {{ $errors->has('tgl_start_q2_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('tgl_start_q2_ip_'.$loop->iteration, 'Due Date Q2') !!}
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        {!! Form::text('tgl_start_q2_ip_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q2', 'id' => 'tgl_start_q2_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      </div>
                                      <!-- /.input group -->
                                      {!! $errors->first('tgl_start_q2_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                  </div>
                                  <!-- /.form-group -->
                                  @if ($hrdtkpi->status === "APPROVE HRD" || $hrdtkpi->status === "SUBMIT REVIEW Q1" || $hrdtkpi->status === "SUBMIT REVIEW Q2" || $hrdtkpi->status === "SUBMIT REVIEW Q3" || $hrdtkpi->status === "SUBMIT REVIEW Q4")
                                    <div class="row form-group">
                                      <div class="col-sm-9 {{ $errors->has('target_q2_act_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('target_q2_act_ip_'.$loop->iteration, 'Q2 Actual') !!}
                                        {!! Form::textarea('target_q2_act_ip_'.$loop->iteration, $model->target_q2_act, ['class'=>'form-control', 'placeholder' => 'Q2 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_act_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('target_q2_act_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                      <div class="col-sm-3 {{ $errors->has('tgl_start_act_q2_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('tgl_start_act_q2_ip_'.$loop->iteration, 'Act Date Q2') !!}
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          {!! Form::text('tgl_start_act_q2_ip_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q2', 'id' => 'tgl_start_act_q2_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        </div>
                                        <!-- /.input group -->
                                        {!! $errors->first('tgl_start_act_q2_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="row form-group">
                                      <div class="col-sm-3 {{ $errors->has('persen_q2_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('persen_q2_ip_'.$loop->iteration, 'Q2 Progress (%)') !!}
                                        {!! Form::number('persen_q2_ip_'.$loop->iteration, $model->persen_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Progress', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q2_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('persen_q2_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                  @endif
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.tabpanel -->
                              <div role="tabpanel" class="tab-pane" id="q3_ip_{{ $loop->iteration }}">
                                <div class="box-body">
                                  <div class="row form-group">
                                    <div class="col-sm-9 {{ $errors->has('target_q3_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('target_q3_ip_'.$loop->iteration, 'Q3 Target') !!}
                                      {!! Form::textarea('target_q3_ip_'.$loop->iteration, $model->target_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      {!! $errors->first('target_q3_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="col-sm-3 {{ $errors->has('tgl_start_q3_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('tgl_start_q3_ip_'.$loop->iteration, 'Due Date Q3') !!}
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        {!! Form::text('tgl_start_q3_ip_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q3', 'id' => 'tgl_start_q3_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      </div>
                                      <!-- /.input group -->
                                      {!! $errors->first('tgl_start_q3_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                  </div>
                                  <!-- /.form-group -->
                                  @if ($hrdtkpi->status === "APPROVE HRD" || $hrdtkpi->status === "SUBMIT REVIEW Q1" || $hrdtkpi->status === "SUBMIT REVIEW Q2" || $hrdtkpi->status === "SUBMIT REVIEW Q3" || $hrdtkpi->status === "SUBMIT REVIEW Q4")
                                    <div class="row form-group">
                                      <div class="col-sm-9 {{ $errors->has('target_q3_act_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('target_q3_act_ip_'.$loop->iteration, 'Q3 Actual') !!}
                                        {!! Form::textarea('target_q3_act_ip_'.$loop->iteration, $model->target_q3_act, ['class'=>'form-control', 'placeholder' => 'Q3 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_act_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('target_q3_act_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                      <div class="col-sm-3 {{ $errors->has('tgl_start_act_q3_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('tgl_start_act_q3_ip_'.$loop->iteration, 'Act Date Q3') !!}
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          {!! Form::text('tgl_start_act_q3_ip_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q3', 'id' => 'tgl_start_act_q3_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        </div>
                                        <!-- /.input group -->
                                        {!! $errors->first('tgl_start_act_q3_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="row form-group">
                                      <div class="col-sm-3 {{ $errors->has('persen_q3_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('persen_q3_ip_'.$loop->iteration, 'Q3 Progress (%)') !!}
                                        {!! Form::number('persen_q3_ip_'.$loop->iteration, $model->persen_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Progress', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q3_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('persen_q3_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                  @endif
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.tabpanel -->
                              <div role="tabpanel" class="tab-pane" id="q4_ip_{{ $loop->iteration }}">
                                <div class="box-body">
                                  <div class="row form-group">
                                    <div class="col-sm-9 {{ $errors->has('target_q4_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('target_q4_ip_'.$loop->iteration, 'Q4 Target') !!}
                                      {!! Form::textarea('target_q4_ip_'.$loop->iteration, $model->target_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      {!! $errors->first('target_q4_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="col-sm-3 {{ $errors->has('tgl_start_q4_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('tgl_start_q4_ip_'.$loop->iteration, 'Due Date Q4') !!}
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        {!! Form::text('tgl_start_q4_ip_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q4', 'id' => 'tgl_start_q4_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      </div>
                                      <!-- /.input group -->
                                      {!! $errors->first('tgl_start_q4_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                  </div>
                                  <!-- /.form-group -->
                                  @if ($hrdtkpi->status === "APPROVE HRD" || $hrdtkpi->status === "SUBMIT REVIEW Q1" || $hrdtkpi->status === "SUBMIT REVIEW Q2" || $hrdtkpi->status === "SUBMIT REVIEW Q3" || $hrdtkpi->status === "SUBMIT REVIEW Q4")
                                    <div class="row form-group">
                                      <div class="col-sm-9 {{ $errors->has('target_q4_act_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('target_q4_act_ip_'.$loop->iteration, 'Q4 Actual') !!}
                                        {!! Form::textarea('target_q4_act_ip_'.$loop->iteration, $model->target_q4_act, ['class'=>'form-control', 'placeholder' => 'Q4 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_act_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('target_q4_act_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                      <div class="col-sm-3 {{ $errors->has('tgl_start_act_q4_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('tgl_start_act_q4_ip_'.$loop->iteration, 'Act Date Q4') !!}
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          {!! Form::text('tgl_start_act_q4_ip_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q4', 'id' => 'tgl_start_act_q4_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        </div>
                                        <!-- /.input group -->
                                        {!! $errors->first('tgl_start_act_q4_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="row form-group">
                                      <div class="col-sm-3 {{ $errors->has('persen_q4_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('persen_q4_ip_'.$loop->iteration, 'Q4 Progress (%)') !!}
                                        {!! Form::number('persen_q4_ip_'.$loop->iteration, $model->persen_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Progress', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q4_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('persen_q4_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                  @endif
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.tabpanel -->
                            </div>
                            <!-- /.tab-content -->
                            <hr class="box box-primary">
                            <div class="row form-group">
                              <div class="col-sm-3 {{ $errors->has('weight_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('weight_ip_'.$loop->iteration, 'Weight (%) (*)') !!}
                                {!! Form::number('weight_ip_'.$loop->iteration, $model->weight, ['class'=>'form-control', 'placeholder' => 'Weight', 'onchange' => 'refreshTotalWeight(this)', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'weight_ip_'.$loop->iteration, 'required', 'readonly'=>'readonly']) !!}
                                {!! $errors->first('weight_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                              </div>
                              <div class="col-sm-6 {{ $errors->has('departemen_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('departemen_ip_'.$loop->iteration, 'Department in Charge') !!}
                                {!! Form::select('departemen_ip_'.$loop->iteration.'[]', $departement->pluck('desc_dep','kd_dep')->all(), $model->departemen, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen_ip_'.$loop->iteration.'[]', 'disabled'=>'']) !!}
                                {!! $errors->first('departemen_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                              </div>
                            </div>
                            <!-- /.form-group -->
                            <div class="row form-group">
                              <div class="col-sm-3 {{ $errors->has('total_weight_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('total_weight_ip_'.$loop->iteration, 'Summary Weight (%)') !!}
                                {!! Form::number('total_weight_ip_'.$loop->iteration, $model->total_weight, ['class'=>'form-control', 'placeholder' => 'Summary Weight', 'max'=>'100', 'step'=>'any', 'disabled'=>'', 'id' => 'total_weight_ip_'.$loop->iteration]) !!}
                                {!! $errors->first('total_weight_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                              </div>
                              <div class="col-sm-6 {{ $errors->has('departemen2_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('departemen2_ip_'.$loop->iteration, 'Need Support Others Department') !!}
                                {!! Form::select('departemen2_ip_'.$loop->iteration.'[]', $departement2->pluck('desc_dep','kd_dep')->all(), $model->departemen2, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen2_ip_'.$loop->iteration.'[]', 'disabled'=>'']) !!}
                                {!! $errors->first('departemen2_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
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
                  @endforeach
                  {!! Form::hidden('jml_row_ip', $hrdtkpi->hrdtKpiActByItem("IP")->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_ip']) !!}
                </div>
                <!-- /.box-body -->
                <div class="box-body">
                  <p class="pull-right">
                    <button id="nextRowIp" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Next to Learning & Growth"><span class="glyphicon glyphicon-arrow-right"></span> Next to Learning & Growth</button>
                  </p>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.tabpanel -->
              <div role="tabpanel" class="tab-pane" id="lg">
                <div class="box-body" id="field-lg">
                  @foreach ($hrdtkpi->hrdtKpiActByItem("LG")->get() as $model)
                    <div class="row" id="field_lg_{{ $loop->iteration }}">
                      <div class="col-md-12">
                        <div class="box box-primary">
                          <div class="box-header with-border">
                            <h3 class="box-title" id="box_lg_{{ $loop->iteration }}">Learning & Growth - Activity ({{ $loop->iteration }}) (*)</h3>
                            <div class="box-tools pull-right">
                              <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                              </button>
                            </div>
                          </div>
                          <!-- /.box-header -->
                          <div class="box-body">
                            <div class="row form-group">
                              <div class="col-sm-12 {{ $errors->has('kpi_ref_desc_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('kpi_ref_desc_lg_'.$loop->iteration, 'KPI Reference') !!}
                                {!! Form::textarea('kpi_ref_desc_lg_'.$loop->iteration, $model->kpi_ref_desc, ['class'=>'form-control', 'placeholder' => 'KPI Reference (Klik tombol Search)', 'rows' => '5', 'style' => 'resize:vertical', 'id' => 'kpi_ref_desc_lg_'.$loop->iteration, 'disabled' => '', 'required']) !!}
                                {!! Form::hidden('kpi_ref_lg_'.$loop->iteration, base64_encode($model->kpi_ref), ['class'=>'form-control', 'id' => 'kpi_ref_lg_'.$loop->iteration, 'readonly'=>'readonly', 'required']) !!}
                                {!! $errors->first('kpi_ref_desc_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                              </div>
                            </div>
                            <!-- /.form-group -->
                            <div class="row form-group">
                              <div class="col-sm-12 {{ $errors->has('activity_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('activity_lg_'.$loop->iteration, 'Activity') !!}
                                {!! Form::textarea('activity_lg_'.$loop->iteration, $model->activity, ['class'=>'form-control', 'placeholder' => 'Activity', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'activity_lg_'.$loop->iteration, 'required', 'readonly'=>'readonly']) !!}
                                {!! Form::hidden('hrdtkpi_lg_id_'.$loop->iteration, base64_encode($model->id), ['class'=>'form-control', 'id' => 'hrdtkpi_lg_id_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                {!! $errors->first('activity_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                              </div>
                            </div>
                            <!-- /.form-group -->

                            <ul class="nav nav-tabs" role="tablist">
                              <li role="presentation" class="active">
                                <a href="#q1_lg_{{ $loop->iteration }}" aria-controls="q1_lg_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                                  <i class="fa fa-pencil-square-o"></i> Q1
                                </a>
                              </li>
                              <li role="presentation">
                                <a href="#q2_lg_{{ $loop->iteration }}" aria-controls="q2_lg_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                                  <i class="fa fa-pencil-square-o"></i> Q2
                                </a>
                              </li>
                              <li role="presentation">
                                <a href="#q3_lg_{{ $loop->iteration }}" aria-controls="q3_lg_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                                  <i class="fa fa-pencil-square-o"></i> Q3
                                </a>
                              </li>
                              <li role="presentation">
                                <a href="#q4_lg_{{ $loop->iteration }}" aria-controls="q4_lg_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                                  <i class="fa fa-pencil-square-o"></i> Q4
                                </a>
                              </li>
                            </ul>

                            <div class="tab-content">
                              <div role="tabpanel" class="tab-pane active" id="q1_lg_{{ $loop->iteration }}">
                                <div class="box-body">
                                  <div class="row form-group">
                                    <div class="col-sm-9 {{ $errors->has('target_q1_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('target_q1_lg_'.$loop->iteration, 'Q1 Target') !!}
                                      {!! Form::textarea('target_q1_lg_'.$loop->iteration, $model->target_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      {!! $errors->first('target_q1_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="col-sm-3 {{ $errors->has('tgl_start_q1_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('tgl_start_q1_lg_'.$loop->iteration, 'Due Date Q1') !!}
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        {!! Form::text('tgl_start_q1_lg_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q1', 'id' => 'tgl_start_q1_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      </div>
                                      <!-- /.input group -->
                                      {!! $errors->first('tgl_start_q1_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                  </div>
                                  <!-- /.form-group -->
                                  @if ($hrdtkpi->status === "APPROVE HRD" || $hrdtkpi->status === "SUBMIT REVIEW Q1" || $hrdtkpi->status === "SUBMIT REVIEW Q2" || $hrdtkpi->status === "SUBMIT REVIEW Q3" || $hrdtkpi->status === "SUBMIT REVIEW Q4")
                                    <div class="row form-group">
                                      <div class="col-sm-9 {{ $errors->has('target_q1_act_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('target_q1_act_lg_'.$loop->iteration, 'Q1 Actual') !!}
                                        {!! Form::textarea('target_q1_act_lg_'.$loop->iteration, $model->target_q1_act, ['class'=>'form-control', 'placeholder' => 'Q1 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_act_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('target_q1_act_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                      <div class="col-sm-3 {{ $errors->has('tgl_start_act_q1_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('tgl_start_act_q1_lg_'.$loop->iteration, 'Act Date Q1') !!}
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          {!! Form::text('tgl_start_act_q1_lg_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q1', 'id' => 'tgl_start_act_q1_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        </div>
                                        <!-- /.input group -->
                                        {!! $errors->first('tgl_start_act_q1_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="row form-group">
                                      <div class="col-sm-3 {{ $errors->has('persen_q1_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('persen_q1_lg_'.$loop->iteration, 'Q1 Progress (%)') !!}
                                        {!! Form::number('persen_q1_lg_'.$loop->iteration, $model->persen_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Progress', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q1_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('persen_q1_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                  @endif
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.tabpanel -->
                              <div role="tabpanel" class="tab-pane" id="q2_lg_{{ $loop->iteration }}">
                                <div class="box-body">
                                  <div class="row form-group">
                                    <div class="col-sm-9 {{ $errors->has('target_q2_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('target_q2_lg_'.$loop->iteration, 'Q2 Target') !!}
                                      {!! Form::textarea('target_q2_lg_'.$loop->iteration, $model->target_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      {!! $errors->first('target_q2_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="col-sm-3 {{ $errors->has('tgl_start_q2_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('tgl_start_q2_lg_'.$loop->iteration, 'Due Date Q2') !!}
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        {!! Form::text('tgl_start_q2_lg_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q2', 'id' => 'tgl_start_q2_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      </div>
                                      <!-- /.input group -->
                                      {!! $errors->first('tgl_start_q2_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                  </div>
                                  <!-- /.form-group -->
                                  @if ($hrdtkpi->status === "APPROVE HRD" || $hrdtkpi->status === "SUBMIT REVIEW Q1" || $hrdtkpi->status === "SUBMIT REVIEW Q2" || $hrdtkpi->status === "SUBMIT REVIEW Q3" || $hrdtkpi->status === "SUBMIT REVIEW Q4")
                                    <div class="row form-group">
                                      <div class="col-sm-9 {{ $errors->has('target_q2_act_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('target_q2_act_lg_'.$loop->iteration, 'Q2 Actual') !!}
                                        {!! Form::textarea('target_q2_act_lg_'.$loop->iteration, $model->target_q2_act, ['class'=>'form-control', 'placeholder' => 'Q2 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_act_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('target_q2_act_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                      <div class="col-sm-3 {{ $errors->has('tgl_start_act_q2_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('tgl_start_act_q2_lg_'.$loop->iteration, 'Act Date Q2') !!}
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          {!! Form::text('tgl_start_act_q2_lg_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q2', 'id' => 'tgl_start_act_q2_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        </div>
                                        <!-- /.input group -->
                                        {!! $errors->first('tgl_start_act_q2_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="row form-group">
                                      <div class="col-sm-3 {{ $errors->has('persen_q2_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('persen_q2_lg_'.$loop->iteration, 'Q2 Progress (%)') !!}
                                        {!! Form::number('persen_q2_lg_'.$loop->iteration, $model->persen_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Progress', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q2_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('persen_q2_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                  @endif
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.tabpanel -->
                              <div role="tabpanel" class="tab-pane" id="q3_lg_{{ $loop->iteration }}">
                                <div class="box-body">
                                  <div class="row form-group">
                                    <div class="col-sm-9 {{ $errors->has('target_q3_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('target_q3_lg_'.$loop->iteration, 'Q3 Target') !!}
                                      {!! Form::textarea('target_q3_lg_'.$loop->iteration, $model->target_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      {!! $errors->first('target_q3_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="col-sm-3 {{ $errors->has('tgl_start_q3_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('tgl_start_q3_lg_'.$loop->iteration, 'Due Date Q3') !!}
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        {!! Form::text('tgl_start_q3_lg_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q3', 'id' => 'tgl_start_q3_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      </div>
                                      <!-- /.input group -->
                                      {!! $errors->first('tgl_start_q3_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                  </div>
                                  <!-- /.form-group -->
                                  @if ($hrdtkpi->status === "APPROVE HRD" || $hrdtkpi->status === "SUBMIT REVIEW Q1" || $hrdtkpi->status === "SUBMIT REVIEW Q2" || $hrdtkpi->status === "SUBMIT REVIEW Q3" || $hrdtkpi->status === "SUBMIT REVIEW Q4")
                                    <div class="row form-group">
                                      <div class="col-sm-9 {{ $errors->has('target_q3_act_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('target_q3_act_lg_'.$loop->iteration, 'Q3 Actual') !!}
                                        {!! Form::textarea('target_q3_act_lg_'.$loop->iteration, $model->target_q3_act, ['class'=>'form-control', 'placeholder' => 'Q3 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_act_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('target_q3_act_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                      <div class="col-sm-3 {{ $errors->has('tgl_start_act_q3_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('tgl_start_act_q3_lg_'.$loop->iteration, 'Act Date Q3') !!}
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          {!! Form::text('tgl_start_act_q3_lg_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q3', 'id' => 'tgl_start_act_q3_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        </div>
                                        <!-- /.input group -->
                                        {!! $errors->first('tgl_start_act_q3_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="row form-group">
                                      <div class="col-sm-3 {{ $errors->has('persen_q3_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('persen_q3_lg_'.$loop->iteration, 'Q3 Progress (%)') !!}
                                        {!! Form::number('persen_q3_lg_'.$loop->iteration, $model->persen_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Progress', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q3_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('persen_q3_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                  @endif
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.tabpanel -->
                              <div role="tabpanel" class="tab-pane" id="q4_lg_{{ $loop->iteration }}">
                                <div class="box-body">
                                  <div class="row form-group">
                                    <div class="col-sm-9 {{ $errors->has('target_q4_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('target_q4_lg_'.$loop->iteration, 'Q4 Target') !!}
                                      {!! Form::textarea('target_q4_lg_'.$loop->iteration, $model->target_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      {!! $errors->first('target_q4_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="col-sm-3 {{ $errors->has('tgl_start_q4_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('tgl_start_q4_lg_'.$loop->iteration, 'Due Date Q4') !!}
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        {!! Form::text('tgl_start_q4_lg_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q4', 'id' => 'tgl_start_q4_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      </div>
                                      <!-- /.input group -->
                                      {!! $errors->first('tgl_start_q4_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                  </div>
                                  <!-- /.form-group -->
                                  @if ($hrdtkpi->status === "APPROVE HRD" || $hrdtkpi->status === "SUBMIT REVIEW Q1" || $hrdtkpi->status === "SUBMIT REVIEW Q2" || $hrdtkpi->status === "SUBMIT REVIEW Q3" || $hrdtkpi->status === "SUBMIT REVIEW Q4")
                                    <div class="row form-group">
                                      <div class="col-sm-9 {{ $errors->has('target_q4_act_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('target_q4_act_lg_'.$loop->iteration, 'Q4 Actual') !!}
                                        {!! Form::textarea('target_q4_act_lg_'.$loop->iteration, $model->target_q4_act, ['class'=>'form-control', 'placeholder' => 'Q4 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_act_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('target_q4_act_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                      <div class="col-sm-3 {{ $errors->has('tgl_start_act_q4_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('tgl_start_act_q4_lg_'.$loop->iteration, 'Act Date Q4') !!}
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          {!! Form::text('tgl_start_act_q4_lg_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q4', 'id' => 'tgl_start_act_q4_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        </div>
                                        <!-- /.input group -->
                                        {!! $errors->first('tgl_start_act_q4_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="row form-group">
                                      <div class="col-sm-3 {{ $errors->has('persen_q4_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('persen_q4_lg_'.$loop->iteration, 'Q4 Progress (%)') !!}
                                        {!! Form::number('persen_q4_lg_'.$loop->iteration, $model->persen_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Progress', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q4_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('persen_q4_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                  @endif
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.tabpanel -->
                            </div>
                            <!-- /.tab-content -->
                            <hr class="box box-primary">
                            <div class="row form-group">
                              <div class="col-sm-3 {{ $errors->has('weight_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('weight_lg_'.$loop->iteration, 'Weight (%) (*)') !!}
                                {!! Form::number('weight_lg_'.$loop->iteration, $model->weight, ['class'=>'form-control', 'placeholder' => 'Weight', 'onchange' => 'refreshTotalWeight(this)', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'weight_lg_'.$loop->iteration, 'required', 'readonly'=>'readonly']) !!}
                                {!! $errors->first('weight_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                              </div>
                              <div class="col-sm-6 {{ $errors->has('departemen_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('departemen_lg_'.$loop->iteration, 'Department in Charge') !!}
                                {!! Form::select('departemen_lg_'.$loop->iteration.'[]', $departement->pluck('desc_dep','kd_dep')->all(), $model->departemen, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen_lg_'.$loop->iteration.'[]', 'disabled'=>'']) !!}
                                {!! $errors->first('departemen_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                              </div>
                            </div>
                            <!-- /.form-group -->
                            <div class="row form-group">
                              <div class="col-sm-3 {{ $errors->has('total_weight_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('total_weight_lg_'.$loop->iteration, 'Summary Weight (%)') !!}
                                {!! Form::number('total_weight_lg_'.$loop->iteration, $model->total_weight, ['class'=>'form-control', 'placeholder' => 'Summary Weight', 'max'=>'100', 'step'=>'any', 'disabled'=>'', 'id' => 'total_weight_lg_'.$loop->iteration]) !!}
                                {!! $errors->first('total_weight_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                              </div>
                              <div class="col-sm-6 {{ $errors->has('departemen2_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('departemen2_lg_'.$loop->iteration, 'Need Support Others Department') !!}
                                {!! Form::select('departemen2_lg_'.$loop->iteration.'[]', $departement2->pluck('desc_dep','kd_dep')->all(), $model->departemen2, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen2_lg_'.$loop->iteration.'[]', 'disabled'=>'']) !!}
                                {!! $errors->first('departemen2_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
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
                  @endforeach
                  {!! Form::hidden('jml_row_lg', $hrdtkpi->hrdtKpiActByItem("LG")->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_lg']) !!}
                </div>
                <!-- /.box-body -->
                <div class="box-body">
                  <p class="pull-right">
                    <button id="nextRowLg" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Next to Compliance Reporting"><span class="glyphicon glyphicon-arrow-right"></span> Next to Compliance Reporting</button>
                  </p>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.tabpanel -->
              <div role="tabpanel" class="tab-pane" id="cr">
                <div class="box-body" id="field-cr">
                  @foreach ($hrdtkpi->hrdtKpiActByItem("CR")->get() as $model)
                    <div class="row" id="field_cr_{{ $loop->iteration }}">
                      <div class="col-md-12">
                        <div class="box box-primary">
                          <div class="box-header with-border">
                            <h3 class="box-title" id="box_cr_{{ $loop->iteration }}">Compliance Reporting - Activity ({{ $loop->iteration }}) (*)</h3>
                            <div class="box-tools pull-right">
                              <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                              </button>
                            </div>
                          </div>
                          <!-- /.box-header -->
                          <div class="box-body">
                            <div class="row form-group">
                              <div class="col-sm-12 {{ $errors->has('kpi_ref_desc_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('kpi_ref_desc_cr_'.$loop->iteration, 'KPI Reference') !!}
                                {!! Form::textarea('kpi_ref_desc_cr_'.$loop->iteration, $model->kpi_ref_desc, ['class'=>'form-control', 'placeholder' => 'KPI Reference (Klik tombol Search)', 'rows' => '5', 'style' => 'resize:vertical', 'id' => 'kpi_ref_desc_cr_'.$loop->iteration, 'disabled' => '', 'required']) !!}
                                {!! Form::hidden('kpi_ref_cr_'.$loop->iteration, base64_encode($model->kpi_ref), ['class'=>'form-control', 'id' => 'kpi_ref_cr_'.$loop->iteration, 'readonly'=>'readonly', 'required']) !!}
                                {!! $errors->first('kpi_ref_desc_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                              </div>
                            </div>
                            <!-- /.form-group -->
                            <div class="row form-group">
                              <div class="col-sm-12 {{ $errors->has('activity_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('activity_cr_'.$loop->iteration, 'Activity') !!}
                                {!! Form::textarea('activity_cr_'.$loop->iteration, $model->activity, ['class'=>'form-control', 'placeholder' => 'Activity', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'activity_cr_'.$loop->iteration, 'required', 'readonly'=>'readonly']) !!}
                                {!! Form::hidden('hrdtkpi_cr_id_'.$loop->iteration, base64_encode($model->id), ['class'=>'form-control', 'id' => 'hrdtkpi_cr_id_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                {!! $errors->first('activity_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                              </div>
                            </div>
                            <!-- /.form-group -->

                            <ul class="nav nav-tabs" role="tablist">
                              <li role="presentation" class="active">
                                <a href="#q1_cr_{{ $loop->iteration }}" aria-controls="q1_cr_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                                  <i class="fa fa-pencil-square-o"></i> Q1
                                </a>
                              </li>
                              <li role="presentation">
                                <a href="#q2_cr_{{ $loop->iteration }}" aria-controls="q2_cr_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                                  <i class="fa fa-pencil-square-o"></i> Q2
                                </a>
                              </li>
                              <li role="presentation">
                                <a href="#q3_cr_{{ $loop->iteration }}" aria-controls="q3_cr_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                                  <i class="fa fa-pencil-square-o"></i> Q3
                                </a>
                              </li>
                              <li role="presentation">
                                <a href="#q4_cr_{{ $loop->iteration }}" aria-controls="q4_cr_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                                  <i class="fa fa-pencil-square-o"></i> Q4
                                </a>
                              </li>
                            </ul>

                            <div class="tab-content">
                              <div role="tabpanel" class="tab-pane active" id="q1_cr_{{ $loop->iteration }}">
                                <div class="box-body">
                                  <div class="row form-group">
                                    <div class="col-sm-9 {{ $errors->has('target_q1_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('target_q1_cr_'.$loop->iteration, 'Q1 Target') !!}
                                      {!! Form::textarea('target_q1_cr_'.$loop->iteration, $model->target_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      {!! $errors->first('target_q1_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="col-sm-3 {{ $errors->has('tgl_start_q1_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('tgl_start_q1_cr_'.$loop->iteration, 'Due Date Q1') !!}
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        {!! Form::text('tgl_start_q1_cr_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q1', 'id' => 'tgl_start_q1_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      </div>
                                      <!-- /.input group -->
                                      {!! $errors->first('tgl_start_q1_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                  </div>
                                  <!-- /.form-group -->
                                  @if ($hrdtkpi->status === "APPROVE HRD" || $hrdtkpi->status === "SUBMIT REVIEW Q1" || $hrdtkpi->status === "SUBMIT REVIEW Q2" || $hrdtkpi->status === "SUBMIT REVIEW Q3" || $hrdtkpi->status === "SUBMIT REVIEW Q4")
                                    <div class="row form-group">
                                      <div class="col-sm-9 {{ $errors->has('target_q1_act_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('target_q1_act_cr_'.$loop->iteration, 'Q1 Actual') !!}
                                        {!! Form::textarea('target_q1_act_cr_'.$loop->iteration, $model->target_q1_act, ['class'=>'form-control', 'placeholder' => 'Q1 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_act_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('target_q1_act_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                      <div class="col-sm-3 {{ $errors->has('tgl_start_act_q1_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('tgl_start_act_q1_cr_'.$loop->iteration, 'Act Date Q1') !!}
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          {!! Form::text('tgl_start_act_q1_cr_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q1', 'id' => 'tgl_start_act_q1_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        </div>
                                        <!-- /.input group -->
                                        {!! $errors->first('tgl_start_act_q1_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="row form-group">
                                      <div class="col-sm-3 {{ $errors->has('persen_q1_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('persen_q1_cr_'.$loop->iteration, 'Q1 Progress (%)') !!}
                                        {!! Form::number('persen_q1_cr_'.$loop->iteration, $model->persen_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Progress', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q1_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('persen_q1_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                  @endif
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.tabpanel -->
                              <div role="tabpanel" class="tab-pane" id="q2_cr_{{ $loop->iteration }}">
                                <div class="box-body">
                                  <div class="row form-group">
                                    <div class="col-sm-9 {{ $errors->has('target_q2_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('target_q2_cr_'.$loop->iteration, 'Q2 Target') !!}
                                      {!! Form::textarea('target_q2_cr_'.$loop->iteration, $model->target_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      {!! $errors->first('target_q2_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="col-sm-3 {{ $errors->has('tgl_start_q2_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('tgl_start_q2_cr_'.$loop->iteration, 'Due Date Q2') !!}
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        {!! Form::text('tgl_start_q2_cr_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q2', 'id' => 'tgl_start_q2_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      </div>
                                      <!-- /.input group -->
                                      {!! $errors->first('tgl_start_q2_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                  </div>
                                  <!-- /.form-group -->
                                  @if ($hrdtkpi->status === "APPROVE HRD" || $hrdtkpi->status === "SUBMIT REVIEW Q1" || $hrdtkpi->status === "SUBMIT REVIEW Q2" || $hrdtkpi->status === "SUBMIT REVIEW Q3" || $hrdtkpi->status === "SUBMIT REVIEW Q4")
                                    <div class="row form-group">
                                      <div class="col-sm-9 {{ $errors->has('target_q2_act_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('target_q2_act_cr_'.$loop->iteration, 'Q2 Actual') !!}
                                        {!! Form::textarea('target_q2_act_cr_'.$loop->iteration, $model->target_q2_act, ['class'=>'form-control', 'placeholder' => 'Q2 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_act_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('target_q2_act_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                      <div class="col-sm-3 {{ $errors->has('tgl_start_act_q2_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('tgl_start_act_q2_cr_'.$loop->iteration, 'Act Date Q2') !!}
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          {!! Form::text('tgl_start_act_q2_cr_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q2', 'id' => 'tgl_start_act_q2_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        </div>
                                        <!-- /.input group -->
                                        {!! $errors->first('tgl_start_act_q2_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="row form-group">
                                      <div class="col-sm-3 {{ $errors->has('persen_q2_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('persen_q2_cr_'.$loop->iteration, 'Q2 Progress (%)') !!}
                                        {!! Form::number('persen_q2_cr_'.$loop->iteration, $model->persen_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Progress', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q2_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('persen_q2_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                  @endif
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.tabpanel -->
                              <div role="tabpanel" class="tab-pane" id="q3_cr_{{ $loop->iteration }}">
                                <div class="box-body">
                                  <div class="row form-group">
                                    <div class="col-sm-9 {{ $errors->has('target_q3_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('target_q3_cr_'.$loop->iteration, 'Q3 Target') !!}
                                      {!! Form::textarea('target_q3_cr_'.$loop->iteration, $model->target_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      {!! $errors->first('target_q3_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="col-sm-3 {{ $errors->has('tgl_start_q3_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('tgl_start_q3_cr_'.$loop->iteration, 'Due Date Q3') !!}
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        {!! Form::text('tgl_start_q3_cr_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q3', 'id' => 'tgl_start_q3_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      </div>
                                      <!-- /.input group -->
                                      {!! $errors->first('tgl_start_q3_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                  </div>
                                  <!-- /.form-group -->
                                  @if ($hrdtkpi->status === "APPROVE HRD" || $hrdtkpi->status === "SUBMIT REVIEW Q1" || $hrdtkpi->status === "SUBMIT REVIEW Q2" || $hrdtkpi->status === "SUBMIT REVIEW Q3" || $hrdtkpi->status === "SUBMIT REVIEW Q4")
                                    <div class="row form-group">
                                      <div class="col-sm-9 {{ $errors->has('target_q3_act_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('target_q3_act_cr_'.$loop->iteration, 'Q3 Actual') !!}
                                        {!! Form::textarea('target_q3_act_cr_'.$loop->iteration, $model->target_q3_act, ['class'=>'form-control', 'placeholder' => 'Q3 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_act_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('target_q3_act_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                      <div class="col-sm-3 {{ $errors->has('tgl_start_act_q3_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('tgl_start_act_q3_cr_'.$loop->iteration, 'Act Date Q3') !!}
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          {!! Form::text('tgl_start_act_q3_cr_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q3', 'id' => 'tgl_start_act_q3_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        </div>
                                        <!-- /.input group -->
                                        {!! $errors->first('tgl_start_act_q3_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="row form-group">
                                      <div class="col-sm-3 {{ $errors->has('persen_q3_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('persen_q3_cr_'.$loop->iteration, 'Q3 Progress (%)') !!}
                                        {!! Form::number('persen_q3_cr_'.$loop->iteration, $model->persen_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Progress', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q3_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('persen_q3_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                  @endif
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.tabpanel -->
                              <div role="tabpanel" class="tab-pane" id="q4_cr_{{ $loop->iteration }}">
                                <div class="box-body">
                                  <div class="row form-group">
                                    <div class="col-sm-9 {{ $errors->has('target_q4_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('target_q4_cr_'.$loop->iteration, 'Q4 Target') !!}
                                      {!! Form::textarea('target_q4_cr_'.$loop->iteration, $model->target_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      {!! $errors->first('target_q4_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="col-sm-3 {{ $errors->has('tgl_start_q4_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                                      {!! Form::label('tgl_start_q4_cr_'.$loop->iteration, 'Due Date Q4') !!}
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        {!! Form::text('tgl_start_q4_cr_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q4', 'id' => 'tgl_start_q4_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                      </div>
                                      <!-- /.input group -->
                                      {!! $errors->first('tgl_start_q4_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                    </div>
                                  </div>
                                  <!-- /.form-group -->
                                  @if ($hrdtkpi->status === "APPROVE HRD" || $hrdtkpi->status === "SUBMIT REVIEW Q1" || $hrdtkpi->status === "SUBMIT REVIEW Q2" || $hrdtkpi->status === "SUBMIT REVIEW Q3" || $hrdtkpi->status === "SUBMIT REVIEW Q4")
                                    <div class="row form-group">
                                      <div class="col-sm-9 {{ $errors->has('target_q4_act_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('target_q4_act_cr_'.$loop->iteration, 'Q4 Actual') !!}
                                        {!! Form::textarea('target_q4_act_cr_'.$loop->iteration, $model->target_q4_act, ['class'=>'form-control', 'placeholder' => 'Q4 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_act_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('target_q4_act_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                      <div class="col-sm-3 {{ $errors->has('tgl_start_act_q4_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('tgl_start_act_q4_cr_'.$loop->iteration, 'Act Date Q4') !!}
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          {!! Form::text('tgl_start_act_q4_cr_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q4', 'id' => 'tgl_start_act_q4_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        </div>
                                        <!-- /.input group -->
                                        {!! $errors->first('tgl_start_act_q4_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="row form-group">
                                      <div class="col-sm-3 {{ $errors->has('persen_q4_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                                        {!! Form::label('persen_q4_cr_'.$loop->iteration, 'Q4 Progress (%)') !!}
                                        {!! Form::number('persen_q4_cr_'.$loop->iteration, $model->persen_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Progress', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q4_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                        {!! $errors->first('persen_q4_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                                      </div>
                                    </div>
                                    <!-- /.form-group -->
                                  @endif
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.tabpanel -->
                            </div>
                            <!-- /.tab-content -->
                            <hr class="box box-primary">
                            <div class="row form-group">
                              <div class="col-sm-3 {{ $errors->has('weight_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('weight_cr_'.$loop->iteration, 'Weight (%) (*)') !!}
                                {!! Form::number('weight_cr_'.$loop->iteration, $model->weight, ['class'=>'form-control', 'placeholder' => 'Weight', 'onchange' => 'refreshTotalWeight(this)', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'weight_cr_'.$loop->iteration, 'required', 'readonly'=>'readonly']) !!}
                                {!! $errors->first('weight_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                              </div>
                              <div class="col-sm-6 {{ $errors->has('departemen_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('departemen_cr_'.$loop->iteration, 'Department in Charge') !!}
                                {!! Form::select('departemen_cr_'.$loop->iteration.'[]', $departement->pluck('desc_dep','kd_dep')->all(), $model->departemen, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen_cr_'.$loop->iteration.'[]', 'disabled'=>'']) !!}
                                {!! $errors->first('departemen_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                              </div>
                            </div>
                            <!-- /.form-group -->
                            <div class="row form-group">
                              <div class="col-sm-3 {{ $errors->has('total_weight_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('total_weight_cr_'.$loop->iteration, 'Summary Weight (%)') !!}
                                {!! Form::number('total_weight_cr_'.$loop->iteration, $model->total_weight, ['class'=>'form-control', 'placeholder' => 'Summary Weight', 'max'=>'100', 'step'=>'any', 'disabled'=>'', 'id' => 'total_weight_cr_'.$loop->iteration]) !!}
                                {!! $errors->first('total_weight_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                              </div>
                              <div class="col-sm-6 {{ $errors->has('departemen2_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                                {!! Form::label('departemen2_cr_'.$loop->iteration, 'Need Support Others Department') !!}
                                {!! Form::select('departemen2_cr_'.$loop->iteration.'[]', $departement2->pluck('desc_dep','kd_dep')->all(), $model->departemen2, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen2_cr_'.$loop->iteration.'[]', 'disabled'=>'']) !!}
                                {!! $errors->first('departemen2_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
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
                  @endforeach
                  {!! Form::hidden('jml_row_cr', $hrdtkpi->hrdtKpiActByItem("CR")->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_cr']) !!}
                </div>
                <!-- /.box-body -->
                <div class="box-body">
                  <p class="pull-right">
                    <button id="nextRowCr" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Back to Financial Performance"><span class="glyphicon glyphicon-arrow-right"></span> Back to Financial Performance</button>
                  </p>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.tabpanel -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="box-footer">
        @if ($hrdtkpi->checkEdit() === "T" && Auth::user()->can('hrd-kpi-create'))
          <a class="btn btn-primary" href="{{ route('hrdtkpis.edit', base64_encode($hrdtkpi->id)) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
          &nbsp;&nbsp;
        @endif
        @if ((strtoupper($hrdtkpi->status) === 'SUBMIT REVIEW' || strtoupper($hrdtkpi->status) === 'APPROVE REVIEW SUPERIOR' || strtoupper($hrdtkpi->status) === 'APPROVE REVIEW HRD') && Auth::user()->can(['hrd-kpi-view','hrd-kpi-create','hrd-kpi-delete','hrd-kpi-submit']))
          <a class="btn btn-primary" target="_blank" href="{{ route('hrdtkpis.review', base64_encode($hrdtkpi->id)) }}" data-toggle="tooltip" data-placement="top" title="Dashboard Review KPI">Dashboard Review KPI</a>
          &nbsp;&nbsp;
        @endif
        <a class="btn btn-primary" href="{{ route('hrdtkpis.index') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  $("#cr").addClass("active");
  $("#lg").addClass("active");
  $("#ip").addClass("active");
  $("#cs").addClass("active");

  //Initialize Select2 Elements
  $(".select2").select2();

  $(document).ready(function(){
    $("#cr").removeClass("active");
    $("#lg").removeClass("active");
    $("#ip").removeClass("active");
    $("#cs").removeClass("active");
  });

  var jml_row_fp = document.getElementById("jml_row_fp").value.trim();
  jml_row_fp = Number(jml_row_fp);
  var jml_row_cs = document.getElementById("jml_row_cs").value.trim();
  jml_row_cs = Number(jml_row_cs);
  var jml_row_ip = document.getElementById("jml_row_ip").value.trim();
  jml_row_ip = Number(jml_row_ip);
  var jml_row_lg = document.getElementById("jml_row_lg").value.trim();
  jml_row_lg = Number(jml_row_lg);
  var jml_row_cr = document.getElementById("jml_row_cr").value.trim();
  jml_row_cr = Number(jml_row_cr);
  if(jml_row_fp > 0) {
    document.getElementById('kpi_ref_desc_fp_1').focus();
  } else if(jml_row_cs > 0) {
    $("#fp").removeClass("active");
    $("#cs").addClass("active");
    $("#nav_fp").removeClass("active");
    $("#nav_cs").addClass("active");
    document.getElementById('kpi_ref_desc_cs_1').focus();
  } else if(jml_row_ip > 0) {
    $("#fp").removeClass("active");
    $("#ip").addClass("active");
    $("#nav_fp").removeClass("active");
    $("#nav_ip").addClass("active");
    document.getElementById('kpi_ref_desc_ip_1').focus();
  } else if(jml_row_lg > 0) {
    $("#fp").removeClass("active");
    $("#lg").addClass("active");
    $("#nav_fp").removeClass("active");
    $("#nav_lg").addClass("active");
    document.getElementById('kpi_ref_desc_lg_1').focus();
  } else if(jml_row_cr > 0) {
    $("#fp").removeClass("active");
    $("#cr").addClass("active");
    $("#nav_fp").removeClass("active");
    $("#nav_cr").addClass("active");
    document.getElementById('kpi_ref_desc_cr_1').focus();
  }

  function keyPressedTglSelesai(param) {
    if(param === "FP") {
      $("#fp").removeClass("active"); // add class to the one we clicked 
      $("#cs").addClass("active");
      $("#nav_fp").removeClass("active"); // add class to the one we clicked 
      $("#nav_cs").addClass("active");
      var key = "cs";
      var jml_row = document.getElementById("jml_row_"+key).value.trim();
      jml_row = Number(jml_row);
      if(jml_row > 0) {
        var no = jml_row-jml_row+1;
        document.getElementById('kpi_ref_desc_cs_'+no).focus();
      }
    } else if(param === "CS") {
      $("#cs").removeClass("active"); // add class to the one we clicked 
      $("#ip").addClass("active");
      $("#nav_cs").removeClass("active"); // add class to the one we clicked 
      $("#nav_ip").addClass("active");
      var key = "ip";
      var jml_row = document.getElementById("jml_row_"+key).value.trim();
      jml_row = Number(jml_row);
      if(jml_row > 0) {
        var no = jml_row-jml_row+1;
        document.getElementById('kpi_ref_desc_ip_'+no).focus();
      }
    } else if(param === "IP") {
      $("#ip").removeClass("active"); // add class to the one we clicked 
      $("#lg").addClass("active");
      $("#nav_ip").removeClass("active"); // add class to the one we clicked 
      $("#nav_lg").addClass("active");
      var key = "lg";
      var jml_row = document.getElementById("jml_row_"+key).value.trim();
      jml_row = Number(jml_row);
      if(jml_row > 0) {
        var no = jml_row-jml_row+1;
        document.getElementById('kpi_ref_desc_lg_'+no).focus();
      }
    } else if(param === "LG") {
      $("#lg").removeClass("active"); // add class to the one we clicked 
      $("#cr").addClass("active");
      $("#nav_lg").removeClass("active"); // add class to the one we clicked 
      $("#nav_cr").addClass("active");
      var key = "cr";
      var jml_row = document.getElementById("jml_row_"+key).value.trim();
      jml_row = Number(jml_row);
      if(jml_row > 0) {
        var no = jml_row-jml_row+1;
        document.getElementById('kpi_ref_desc_cr_'+no).focus();
      }
    } else if(param === "CR") {
      $("#cr").removeClass("active"); // add class to the one we clicked 
      $("#fp").addClass("active");
      $("#nav_cr").removeClass("active"); // add class to the one we clicked 
      $("#nav_fp").addClass("active");
      var key = "fp";
      var jml_row = document.getElementById("jml_row_"+key).value.trim();
      jml_row = Number(jml_row);
      if(jml_row > 0) {
        var no = jml_row-jml_row+1;
        document.getElementById('kpi_ref_desc_fp_'+no).focus();
      }
    }
  }

  $("#nextRowFp").click(function(){
    keyPressedTglSelesai("FP");
  });

  $("#nextRowCs").click(function(){
    keyPressedTglSelesai("CS");
  });

  $("#nextRowIp").click(function(){
    keyPressedTglSelesai("IP");
  });

  $("#nextRowLg").click(function(){
    keyPressedTglSelesai("LG");
  });

  $("#nextRowCr").click(function(){
    keyPressedTglSelesai("CR");
  });
</script>
@endsection