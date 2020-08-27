@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Individual Development Plan
        <small>Detail IDP <b>{{ $hrdtidp1->npk }} - {{ $hrdtidp1->tahun }}</b></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('hrdtidp1s.index') }}"><i class="fa fa-files-o"></i> Daftar IDP</a></li>
        <li class="active">Detail IDP {{ $hrdtidp1->npk }} - {{ $hrdtidp1->tahun }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detail IDP {{ $hrdtidp1->npk }} - {{ $hrdtidp1->tahun }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body box-profile">
              <img src="{{ $hrdtidp1->fotoKaryawan() }}" class="profile-user-img img-responsive img-circle" alt="User profile picture">
              <p class="text-muted text-center"></p>
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 12%;"><b>Year</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">
                      {{ $hrdtidp1->tahun }}
                      {!! Form::hidden('year', $hrdtidp1->tahun, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'year']) !!}
                      {!! Form::hidden('id', base64_encode($hrdtidp1->id), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'id']) !!}
                    </td>
                    <td style="width: 13%;"><b>Revisi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if ($hrdtidp1->hrdtIdp1Rejects()->get()->count() > 0)
                        {{ $hrdtidp1->revisi }}
                        @foreach ($hrdtidp1->hrdtIdp1Rejects()->get() as $hrdtidp1Reject)
                          @if (Auth::user()->can(['hrd-idp-view','hrd-idp-create','hrd-idp-delete','hrd-idp-submit']))
                            {{ "&nbsp;-&nbsp;&nbsp;" }}<a target="_blank" href="{{ route('hrdtidp1s.showrevisi', base64_encode($hrdtidp1Reject->id)) }}" data-toggle="tooltip" data-placement="top" title="Show History IDP No. Revisi {{ $hrdtidp1Reject->revisi }}">{{ $hrdtidp1Reject->revisi }}</a>
                          @else
                            {{ "&nbsp;-&nbsp;&nbsp;".$hrdtidp1Reject->revisi }}
                          @endif
                        @endforeach
                      @else
                        {{ $hrdtidp1->revisi }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>NPK / Name</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">
                      {{ $hrdtidp1->npk." - ".$hrdtidp1->masKaryawan($hrdtidp1->npk)->nama }}
                    </td>
                    <td style="width: 13%;"><b>Level & Sub Level</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      {{ $hrdtidp1->kd_gol }}
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Company</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">
                      {{ $hrdtidp1->kd_pt." - ".$hrdtidp1->nm_pt }}
                    </td>
                    <td style="width: 13%;"><b>Div / Department</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      {{ $hrdtidp1->kd_div." - ".$hrdtidp1->namaDivisi($hrdtidp1->kd_div) }} / {{ $hrdtidp1->kd_dep." - ".$hrdtidp1->namaDepartemen($hrdtidp1->kd_dep) }}
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Current Position</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">
                      {{ $hrdtidp1->cur_pos }}
                    </td>
                    <td style="width: 13%;"><b>Projected Position</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      {{ $hrdtidp1->proj_pos }}
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Date of Birth</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">
                      {{ \Carbon\Carbon::parse($hrdtidp1->masKaryawan($hrdtidp1->npk)->tgl_lahir)->format('d/m/Y') }}
                    </td>
                    <td style="width: 13%;"><b>Date Entry in Astra</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      {{ \Carbon\Carbon::parse($hrdtidp1->masKaryawan($hrdtidp1->npk)->tgl_masuk_gkd)->format('d/m/Y') }}
                    </td>
                  </tr>
                  @if (!empty($hrdtidp1->submit_tgl))
                    <tr>
                      <td style="width: 12%;"><b>Tgl Submit</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        @if (!empty($hrdtidp1->submit_tgl))
                          {{ \Carbon\Carbon::parse($hrdtidp1->submit_tgl)->format('d/m/Y H:i') }}
                        @endif  
                      </td>
                      <td style="width: 13%;"><b>PIC Submit</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $hrdtidp1->submit_pic." - ".$hrdtidp1->nama($hrdtidp1->submit_pic) }}</td>
                    </tr>
                  @endif
                  @if (!empty($hrdtidp1->approve_div_tgl))
                    <tr>
                      <td style="width: 12%;"><b>Tgl Approve Div</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        @if (!empty($hrdtidp1->approve_div_tgl))
                          {{ \Carbon\Carbon::parse($hrdtidp1->approve_div_tgl)->format('d/m/Y H:i') }}
                        @endif  
                      </td>
                      <td style="width: 13%;"><b>PIC Approve Div</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $hrdtidp1->approve_div." - ".$hrdtidp1->nama($hrdtidp1->approve_div) }}</td>
                    </tr>
                  @endif
                  @if (!empty($hrdtidp1->approve_hr_tgl))
                    <tr>
                      <td style="width: 12%;"><b>Tgl Approve HRD</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        @if (!empty($hrdtidp1->approve_hr_tgl))
                          {{ \Carbon\Carbon::parse($hrdtidp1->approve_hr_tgl)->format('d/m/Y H:i') }}
                        @endif  
                      </td>
                      <td style="width: 13%;"><b>PIC Approve HRD</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $hrdtidp1->approve_hr." - ".$hrdtidp1->nama($hrdtidp1->approve_hr) }}</td>
                    </tr>
                  @endif
                  @if (!empty($hrdtidp1->reject_tgl))
                    <tr>
                      <td style="width: 8%;"><b>Tgl Reject</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        @if (!empty($hrdtidp1->reject_tgl))
                          {{ \Carbon\Carbon::parse($hrdtidp1->reject_tgl)->format('d/m/Y H:i') }}
                        @endif  
                      </td>
                      <td style="width: 8%;"><b>PIC Reject</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $hrdtidp1->reject_pic." - ".$hrdtidp1->nama($hrdtidp1->reject_pic) }}</td>
                    </tr>
                    <tr>
                      <td style="width: 10%;"><b>Ket. Reject</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">{{ $hrdtidp1->reject_ket }}</td>
                    </tr>
                  @endif
                  @if (!empty($hrdtidp1->submit_mid_tgl))
                    <tr>
                      <td style="width: 12%;"><b>Tgl Submit (MID)</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        @if (!empty($hrdtidp1->submit_mid_tgl))
                          {{ \Carbon\Carbon::parse($hrdtidp1->submit_mid_tgl)->format('d/m/Y H:i') }}
                        @endif  
                      </td>
                      <td style="width: 13%;"><b>PIC Submit (MID)</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $hrdtidp1->submit_mid_pic." - ".$hrdtidp1->nama($hrdtidp1->submit_mid_pic) }}</td>
                    </tr>
                  @endif
                  @if (!empty($hrdtidp1->approve_mid_div_tgl))
                    <tr>
                      <td style="width: 12%;"><b>Tgl Approve Div (MID)</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        @if (!empty($hrdtidp1->approve_mid_div_tgl))
                          {{ \Carbon\Carbon::parse($hrdtidp1->approve_mid_div_tgl)->format('d/m/Y H:i') }}
                        @endif  
                      </td>
                      <td style="width: 13%;"><b>PIC Approve Div (MID)</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $hrdtidp1->approve_mid_div." - ".$hrdtidp1->nama($hrdtidp1->approve_mid_div) }}</td>
                    </tr>
                  @endif
                  @if (!empty($hrdtidp1->approve_mid_hr_tgl))
                    <tr>
                      <td style="width: 12%;"><b>Tgl Approve HRD (MID)</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        @if (!empty($hrdtidp1->approve_mid_hr_tgl))
                          {{ \Carbon\Carbon::parse($hrdtidp1->approve_mid_hr_tgl)->format('d/m/Y H:i') }}
                        @endif  
                      </td>
                      <td style="width: 13%;"><b>PIC Approve HRD (MID)</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $hrdtidp1->approve_mid_hr." - ".$hrdtidp1->nama($hrdtidp1->approve_mid_hr) }}</td>
                    </tr>
                  @endif
                  @if (!empty($hrdtidp1->reject_mid_tgl))
                    <tr>
                      <td style="width: 8%;"><b>Tgl Reject (MID)</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        @if (!empty($hrdtidp1->reject_mid_tgl))
                          {{ \Carbon\Carbon::parse($hrdtidp1->reject_mid_tgl)->format('d/m/Y H:i') }}
                        @endif  
                      </td>
                      <td style="width: 8%;"><b>PIC Reject (MID)</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $hrdtidp1->reject_mid_pic." - ".$hrdtidp1->nama($hrdtidp1->reject_mid_pic) }}</td>
                    </tr>
                    <tr>
                      <td style="width: 10%;"><b>Ket. Reject (MID)</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">{{ $hrdtidp1->reject_mid_ket }}</td>
                    </tr>
                  @endif
                  @if (!empty($hrdtidp1->submit_one_tgl))
                    <tr>
                      <td style="width: 12%;"><b>Tgl Submit (ONE)</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        @if (!empty($hrdtidp1->submit_one_tgl))
                          {{ \Carbon\Carbon::parse($hrdtidp1->submit_one_tgl)->format('d/m/Y H:i') }}
                        @endif  
                      </td>
                      <td style="width: 13%;"><b>PIC Submit (ONE)</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $hrdtidp1->submit_one_pic." - ".$hrdtidp1->nama($hrdtidp1->submit_one_pic) }}</td>
                    </tr>
                  @endif
                  @if (!empty($hrdtidp1->approve_one_div_tgl))
                    <tr>
                      <td style="width: 12%;"><b>Tgl Approve Div (ONE)</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        @if (!empty($hrdtidp1->approve_one_div_tgl))
                          {{ \Carbon\Carbon::parse($hrdtidp1->approve_one_div_tgl)->format('d/m/Y H:i') }}
                        @endif  
                      </td>
                      <td style="width: 13%;"><b>PIC Approve Div (ONE)</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $hrdtidp1->approve_one_div." - ".$hrdtidp1->nama($hrdtidp1->approve_one_div) }}</td>
                    </tr>
                  @endif
                  @if (!empty($hrdtidp1->approve_one_hr_tgl))
                    <tr>
                      <td style="width: 12%;"><b>Tgl Approve HRD (ONE)</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        @if (!empty($hrdtidp1->approve_one_hr_tgl))
                          {{ \Carbon\Carbon::parse($hrdtidp1->approve_one_hr_tgl)->format('d/m/Y H:i') }}
                        @endif  
                      </td>
                      <td style="width: 13%;"><b>PIC Approve HRD (ONE)</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $hrdtidp1->approve_one_hr." - ".$hrdtidp1->nama($hrdtidp1->approve_one_hr) }}</td>
                    </tr>
                  @endif
                  @if (!empty($hrdtidp1->reject_one_tgl))
                    <tr>
                      <td style="width: 8%;"><b>Tgl Reject (ONE)</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        @if (!empty($hrdtidp1->reject_one_tgl))
                          {{ \Carbon\Carbon::parse($hrdtidp1->reject_one_tgl)->format('d/m/Y H:i') }}
                        @endif  
                      </td>
                      <td style="width: 8%;"><b>PIC Reject (ONE)</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $hrdtidp1->reject_one_pic." - ".$hrdtidp1->nama($hrdtidp1->reject_one_pic) }}</td>
                    </tr>
                    <tr>
                      <td style="width: 10%;"><b>Ket. Reject (ONE)</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">{{ $hrdtidp1->reject_one_ket }}</td>
                    </tr>
                  @endif
                  <tr>
                    <td style="width: 8%;"><b>Status</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">{{ $hrdtidp1->status }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
  
            @if ($hrdtidp1->hrdtIdp2sByStatus("S")->get()->count() > 0 || $hrdtidp1->hrdtIdp2sByStatus("W")->get()->count() > 0)
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="box box-primary collapsed-box">
                      <div class="box-header with-border">
                        <h3 class="box-title"><font color="red"><b>I. Individual Profile for Future Job</b></font></h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body form-horizontal">
                      </div>
                      <!-- /.box-body -->
                      <div class="col-md-6">
                        <div class="box-body" id="field-alc-s">
                          @foreach ($hrdtidp1->hrdtIdp2sByStatus("S")->get() as $model)
                            <div class="row" id="field_s_{{ $loop->iteration }}">
                              <div class="col-md-12">
                                <div class="box box-primary collapsed-box">
                                  <div class="box-header with-border">
                                    <h3 class="box-title" id="box_s_{{ $loop->iteration }}">{{ $model->alc }} (Strength-{{ $loop->iteration }})</h3>
                                    <div class="box-tools pull-right">
                                      <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                      </button>
                                    </div>
                                  </div>
                                  <!-- /.box-header -->
                                  <div class="box-body">
                                    <div class="row form-group">
                                      <div class="col-sm-12">
                                        <textarea id="deskripsi_s_{{ $loop->iteration }}" name="deskripsi_s_{{ $loop->iteration }}" required class="form-control" placeholder="Keterangan (*)" rows="5" maxlength="2000" style="resize:vertical" readonly="readonly">{{ $model->deskripsi }}</textarea>
                                        <input type="hidden" id="hrdt_idp2_id_s_{{ $loop->iteration }}" name="hrdt_idp2_id_s_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ base64_encode($model->id) }}">
                                        <input type="hidden" id="alc_s_{{ $loop->iteration }}" name="alc_s_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ $model->alc }}">
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
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="box-body" id="field-alc-w">
                          @foreach ($hrdtidp1->hrdtIdp2sByStatus("W")->get() as $model)
                            <div class="row" id="field_w_{{ $loop->iteration }}">
                              <div class="col-md-12">
                                <div class="box box-primary collapsed-box">
                                  <div class="box-header with-border">
                                    <h3 class="box-title" id="box_w_{{ $loop->iteration }}">{{ $model->alc }} (Development-{{ $loop->iteration }})</h3>
                                    <div class="box-tools pull-right">
                                      <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                      </button>
                                    </div>
                                  </div>
                                  <!-- /.box-header -->
                                  <div class="box-body">
                                    <div class="row form-group">
                                      <div class="col-sm-12">
                                        <textarea id="deskripsi_w_{{ $loop->iteration }}" name="deskripsi_w_{{ $loop->iteration }}" required class="form-control" placeholder="Keterangan (*)" rows="5" maxlength="2000" style="resize:vertical" readonly="readonly">{{ $model->deskripsi }}</textarea>
                                        <input type="hidden" id="hrdt_idp2_id_w_{{ $loop->iteration }}" name="hrdt_idp2_id_w_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ base64_encode($model->id) }}">
                                        <input type="hidden" id="alc_w_{{ $loop->iteration }}" name="alc_w_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ $model->alc }}">
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
                        </div>
                      </div>
                    </div>
                    <!-- /.box -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- /.box-body -->
            @endif

            @if ($hrdtidp1->hrdtIdp2sByStatus("W")->get()->count() > 0)
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="box box-primary collapsed-box">
                      <div class="box-header with-border">
                        <h3 class="box-title"><font color="red"><b>II. Development Program</b></font></h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body" id="field-alc-dev">
                        @foreach ($hrdtidp1->hrdtIdp2sByStatus("W")->get() as $model)
                          <div class="row" id="field_dev_{{ $loop->iteration }}">
                            <div class="col-md-12">
                              <div class="box box-primary collapsed-box">
                                <div class="box-header with-border">
                                  <h3 class="box-title" id="box_dev_{{ $loop->iteration }}">{{ $model->alc }}</h3>
                                  <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                                      <i class="fa fa-minus"></i>
                                    </button>
                                  </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                  @foreach ($model->hrdtIdp3s()->get() as $hrdtIdp3)
                                    @if (!empty($hrdtIdp3->program))
                                      <div class="row form-group">
                                        <div class="col-sm-4">
                                          {!! Form::label('program_'.$model->id.'_'.$loop->iteration, 'Program ('.$loop->iteration.')') !!}
                                          <textarea id="program_{{ $model->id }}_{{ $loop->iteration }}" name="program_{{ $model->id }}_{{ $loop->iteration }}" class="form-control" placeholder="Program" rows="3" maxlength="2000" style="resize:vertical" readonly="readonly">{{ $hrdtIdp3->program }}</textarea>
                                          <input type="hidden" id="hrdt_idp3_id_{{ $model->id }}_{{ $loop->iteration }}" name="hrdt_idp3_id_{{ $model->id }}_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ base64_encode($hrdtIdp3->id) }}">
                                        </div>
                                        <div class="col-sm-4">
                                          {!! Form::label('target_'.$model->id.'_'.$loop->iteration, 'Target ('.$loop->iteration.')') !!}
                                          <textarea id="target_{{ $model->id }}_{{ $loop->iteration }}" name="target_{{ $model->id }}_{{ $loop->iteration }}" class="form-control" placeholder="Target" rows="3" maxlength="2000" style="resize:vertical" readonly="readonly">{{ $hrdtIdp3->target }}</textarea>
                                        </div>
                                        <div class="col-sm-3">
                                          {!! Form::label('tgl_'.$model->id.'_'.$loop->iteration, 'Due Date ('.$loop->iteration.')') !!}
                                          <div class="input-group">
                                            <div class="input-group-addon">
                                              <i class="fa fa-calendar"></i>
                                            </div>
                                            {!! Form::text('tgl_'.$model->id.'_'.$loop->iteration, \Carbon\Carbon::parse($hrdtIdp3->tgl_start)->format('d/m/Y')." - ".\Carbon\Carbon::parse($hrdtIdp3->tgl_finish)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date', 'id' => 'tgl_'.$model->id.'_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                          </div>
                                          <!-- /.input group -->
                                        </div>
                                      </div>
                                      <!-- /.form-group -->
                                      <HR></HR>
                                    @endif
                                  @endforeach
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.box -->
                            </div>
                            <!-- /.col -->
                          </div>
                          <!-- /.row -->
                        @endforeach
                      </div>
                    </div>
                    <!-- /.box -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- /.box-body -->
            @endif

            @if ($hrdtidp1->hrdtIdp4s()->get()->count() > 0)
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="box box-primary collapsed-box">
                      <div class="box-header with-border">
                        <h3 class="box-title"><font color="red"><b>III. Mid Year Review</b></font></h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body" id="field-mid">
                        @foreach ($hrdtidp1->hrdtIdp4s()->get() as $hrdtIdp4)
                          <div class="row" id="field_mid_{{ $loop->iteration }}">
                            <div class="col-md-12">
                              <div class="box box-primary collapsed-box">
                                <div class="box-header with-border">
                                  <h3 class="box-title" id="box_mid_{{ $loop->iteration }}">Mid Year Review ({{ $loop->iteration }})</h3>
                                  <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                                      <i class="fa fa-minus"></i>
                                    </button>
                                  </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                  <div class="row form-group">
                                    <div class="col-sm-4">
                                      {!! Form::label('program_mid_'.$loop->iteration, 'Development Program') !!}
                                      <textarea id="program_mid_{{ $loop->iteration }}" name="program_mid_{{ $loop->iteration }}" class="form-control" placeholder="Development Program" rows="3" maxlength="2000" style="resize:vertical" required readonly="readonly">{{ $hrdtIdp4->program }}</textarea>
                                      <input type="hidden" id="hrdt_idp4_id_{{ $loop->iteration }}" name="hrdt_idp4_id_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ base64_encode($hrdtIdp4->id) }}">
                                    </div>
                                    <div class="col-sm-2">
                                      {!! Form::label('tanggal_program_mid_'.$loop->iteration, 'Tanggal Program') !!}
                                      {!! Form::date('tanggal_program_mid_'.$loop->iteration, \Carbon\Carbon::parse($hrdtIdp4->tgl_program), ['class'=>'form-control','placeholder' => 'Tgl Program', 'required', 'id'=>'tanggal_program_mid_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                    </div>
                                    <div class="col-sm-3">
                                      {!! Form::label('achievement_mid_'.$loop->iteration, 'Achievement') !!}
                                      <textarea id="achievement_mid_{{ $loop->iteration }}" name="achievement_mid_{{ $loop->iteration }}" class="form-control" placeholder="Achievement" rows="3" maxlength="2000" style="resize:vertical" required readonly="readonly">{{ $hrdtIdp4->achievement }}</textarea>
                                    </div>
                                    <div class="col-sm-3">
                                      {!! Form::label('next_action_mid_'.$loop->iteration, 'Next Action') !!}
                                      <textarea id="next_action_mid_{{ $loop->iteration }}" name="next_action_mid_{{ $loop->iteration }}" class="form-control" placeholder="Next Action" rows="3" maxlength="2000" style="resize:vertical" required readonly="readonly">{{ $hrdtIdp4->next_action }}</textarea>
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
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- /.box-body -->
            @endif

            @if ($hrdtidp1->hrdtIdp5s()->get()->count() > 0)
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="box box-primary collapsed-box">
                      <div class="box-header with-border">
                        <h3 class="box-title"><font color="red"><b>IV. One Year Review</b></font></h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body" id="field-one">
                        @foreach ($hrdtidp1->hrdtIdp5s()->get() as $hrdtIdp5)
                          <div class="row" id="field_one_{{ $loop->iteration }}">
                            <div class="col-md-12">
                              <div class="box box-primary collapsed-box">
                                <div class="box-header with-border">
                                  <h3 class="box-title" id="box_one_{{ $loop->iteration }}">One Year Review ({{ $loop->iteration }})</h3>
                                  <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                                      <i class="fa fa-minus"></i>
                                    </button>
                                  </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                  <div class="row form-group">
                                    <div class="col-sm-4">
                                      {!! Form::label('program_one_'.$loop->iteration, 'Development Program') !!}
                                      <textarea id="program_one_{{ $loop->iteration }}" name="program_one_{{ $loop->iteration }}" class="form-control" placeholder="Development Program" rows="3" maxlength="2000" style="resize:vertical" required readonly="readonly">{{ $hrdtIdp5->program }}</textarea>
                                      <input type="hidden" id="hrdt_idp5_id_{{ $loop->iteration }}" name="hrdt_idp5_id_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ base64_encode($hrdtIdp5->id) }}">
                                    </div>
                                    <div class="col-sm-2">
                                      {!! Form::label('tanggal_program_one_'.$loop->iteration, 'Tanggal Program') !!}
                                      {!! Form::date('tanggal_program_one_'.$loop->iteration, \Carbon\Carbon::parse($hrdtIdp5->tgl_program), ['class'=>'form-control','placeholder' => 'Tgl Program', 'required', 'id'=>'tanggal_program_one_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                    </div>
                                    <div class="col-sm-6">
                                      {!! Form::label('evaluation_one_'.$loop->iteration, 'Evaluation Result') !!}
                                      <textarea id="evaluation_one_{{ $loop->iteration }}" name="evaluation_one_{{ $loop->iteration }}" class="form-control" placeholder="Evaluation Result" rows="3" maxlength="2000" style="resize:vertical" required readonly="readonly">{{ $hrdtIdp5->evaluation }}</textarea>
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
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- /.box-body -->
            @endif
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="box-footer">
        @if ($hrdtidp1->checkEdit() === "T")
          @if (Auth::user()->can('hrd-idp-create'))
            <a class="btn btn-primary" href="{{ route('hrdtidp1s.edit', base64_encode($hrdtidp1->id)) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
            &nbsp;&nbsp;
          @endif
        @endif
        <a target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Print IDP {{ $hrdtidp1->npk }}" href="{{ route('hrdtidp1s.print', base64_encode($hrdtidp1->id)) }}"><span class='glyphicon glyphicon-print'></span> Print IDP</a>
          &nbsp;&nbsp;
        <a class="btn btn-primary" href="{{ route('hrdtidp1s.index') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection