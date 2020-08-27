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
        <li><a href="{{ route('hrdtidp1s.approval') }}"><i class="fa fa-files-o"></i> Daftar IDP</a></li>
        <li class="active">Detail IDP {{ $hrdtidp1->npk }} - {{ $hrdtidp1->tahun }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      {!! Form::model($hrdtidp1, ['url' => route('hrdtidp1s.update', base64_encode($hrdtidp1->id)),
        'method'=>'put', 'files'=>'true', 'role'=>'form', 'id'=>'form_id']) !!}
        {!! Form::hidden('status', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'status']) !!}
        {!! Form::hidden('st_input', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'st_input']) !!}
        {!! Form::hidden('jml_row_w', $hrdtidp1->hrdtIdp2sByStatus("W")->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_w']) !!}
        {!! Form::hidden('jml_row_mid', $hrdtidp1->hrdtIdp4s()->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_mid']) !!}
        {!! Form::hidden('jml_row_one', $hrdtidp1->hrdtIdp5s()->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_one']) !!}
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
                            @if (Auth::user()->can(['hrd-idp-approve-div','hrd-idp-reject-div']))
                              {{ "&nbsp;-&nbsp;&nbsp;" }}<a target="_blank" href="{{ route('hrdtidp1s.showapprovalrevisi', base64_encode($hrdtidp1Reject->id)) }}" data-toggle="tooltip" data-placement="top" title="Show History IDP No. Revisi {{ $hrdtidp1Reject->revisi }}">{{ $hrdtidp1Reject->revisi }}</a>
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
                      <div class="box box-primary{{ !empty($hrdtidp1->id) ? ($hrdtidp1->status !== "SUBMIT" ? " collapsed-box" : "") : "" }}">
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
                                <div class="box box-primary{{ !empty($hrdtidp1->id) ? ($hrdtidp1->status !== "SUBMIT" ? " collapsed-box" : "") : "" }}">
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
                                      @if ($hrdtidp1->status === "SUBMIT" || ($hrdtidp1->status !== "SUBMIT" && !empty($hrdtIdp3->program)))
                                        <div class="row form-group">
                                          <div class="col-sm-4">
                                            {!! Form::label('program_'.$model->id.'_'.$loop->iteration, 'Program ('.$loop->iteration.')') !!}
                                            @if ($hrdtidp1->status === "SUBMIT" && Auth::user()->can('hrd-idp-approve-div'))
                                              <textarea id="program_{{ $model->id }}_{{ $loop->iteration }}" name="program_{{ $model->id }}_{{ $loop->iteration }}" class="form-control" placeholder="Program" rows="3" maxlength="2000" style="resize:vertical">{{ $hrdtIdp3->program }}</textarea>
                                            @else 
                                              <textarea id="program_{{ $model->id }}_{{ $loop->iteration }}" name="program_{{ $model->id }}_{{ $loop->iteration }}" class="form-control" placeholder="Program" rows="3" maxlength="2000" style="resize:vertical" readonly="readonly">{{ $hrdtIdp3->program }}</textarea>
                                            @endif
                                            <input type="hidden" id="hrdt_idp3_id_{{ $model->id }}_{{ $loop->iteration }}" name="hrdt_idp3_id_{{ $model->id }}_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ base64_encode($hrdtIdp3->id) }}">
                                          </div>
                                          <div class="col-sm-1">
                                            {!! Form::label('lm_'.$model->id.'_'.$loop->iteration, 'Learning Methode') !!}
                                            @if ($hrdtidp1->status === "SUBMIT" && Auth::user()->can('hrd-idp-approve-div'))
                                              <button id="btnpopuplm_{{ $model->id }}_{{ $loop->iteration }}" name="btnpopuplm_{{ $model->id }}_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih Learning Methode" onclick="popupLm(this,'{{ $model->id }}')" data-toggle="modal" data-target="#lmModal"><span class="glyphicon glyphicon-search"></span></button>
                                            @else 
                                              <button id="btnpopuplm_{{ $model->id }}_{{ $loop->iteration }}" name="btnpopuplm_{{ $model->id }}_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih Learning Methode" onclick="popupLm(this,'{{ $model->id }}')" data-toggle="modal" data-target="#lmModal" disabled=""><span class="glyphicon glyphicon-search"></span></button>
                                            @endif
                                          </div>
                                          <div class="col-sm-4">
                                            {!! Form::label('target_'.$model->id.'_'.$loop->iteration, 'Target ('.$loop->iteration.')') !!}
                                            @if ($hrdtidp1->status === "SUBMIT" && Auth::user()->can('hrd-idp-approve-div'))
                                              <textarea id="target_{{ $model->id }}_{{ $loop->iteration }}" name="target_{{ $model->id }}_{{ $loop->iteration }}" class="form-control" placeholder="Target" rows="3" maxlength="2000" style="resize:vertical">{{ $hrdtIdp3->target }}</textarea>
                                            @else 
                                              <textarea id="target_{{ $model->id }}_{{ $loop->iteration }}" name="target_{{ $model->id }}_{{ $loop->iteration }}" class="form-control" placeholder="Target" rows="3" maxlength="2000" style="resize:vertical" readonly="readonly">{{ $hrdtIdp3->target }}</textarea>
                                            @endif
                                          </div>
                                          <div class="col-sm-3">
                                            {!! Form::label('tgl_'.$model->id.'_'.$loop->iteration, 'Due Date ('.$loop->iteration.')') !!}
                                            <div class="input-group">
                                              <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                              </div>
                                              @if ($hrdtidp1->status === "SUBMIT" && Auth::user()->can('hrd-idp-approve-div'))
                                                {!! Form::text('tgl_'.$model->id.'_'.$loop->iteration, \Carbon\Carbon::parse($hrdtIdp3->tgl_start)->format('d/m/Y')." - ".\Carbon\Carbon::parse($hrdtIdp3->tgl_finish)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date', 'id' => 'tgl_'.$model->id.'_'.$loop->iteration]) !!}
                                              @else 
                                                {!! Form::text('tgl_'.$model->id.'_'.$loop->iteration, \Carbon\Carbon::parse($hrdtIdp3->tgl_start)->format('d/m/Y')." - ".\Carbon\Carbon::parse($hrdtIdp3->tgl_finish)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date', 'id' => 'tgl_'.$model->id.'_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                              @endif
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
                      <div class="box box-primary{{ !empty($hrdtidp1->id) ? ($hrdtidp1->status !== "SUBMIT (MID)" ? " collapsed-box" : "") : "" }}">
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
                                <div class="box box-primary{{ !empty($hrdtidp1->id) ? ($hrdtidp1->status !== "SUBMIT (MID)" ? " collapsed-box" : "") : "" }}">
                                  <div class="box-header with-border">
                                    <h3 class="box-title" id="box_mid_{{ $loop->iteration }}">Mid Year Review ({{ $loop->iteration }})</h3>
                                    <div class="box-tools pull-right">
                                      <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                      </button>
                                      @if ($hrdtidp1->status === "SUBMIT (MID)" && Auth::user()->can('hrd-idp-approve-div') && $hrdtidp1->npk_div_head === Auth::user()->username)
                                        <button id="btndeletemid_{{ $loop->iteration }}" name="btndeletemid_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Program" onclick="deleteMidReview(this)">
                                          <i class="fa fa-times"></i>
                                        </button>
                                      @endif
                                    </div>
                                  </div>
                                  <!-- /.box-header -->
                                  <div class="box-body">
                                    <div class="row form-group">
                                      <div class="col-sm-3">
                                        {!! Form::label('program_mid_'.$loop->iteration, 'Development Program') !!}
                                        @if ($hrdtidp1->status === "SUBMIT (MID)" && Auth::user()->can('hrd-idp-approve-div'))
                                          <textarea id="program_mid_{{ $loop->iteration }}" name="program_mid_{{ $loop->iteration }}" class="form-control" placeholder="Development Program" rows="3" maxlength="2000" style="resize:vertical" required>{{ $hrdtIdp4->program }}</textarea>
                                        @else 
                                          <textarea id="program_mid_{{ $loop->iteration }}" name="program_mid_{{ $loop->iteration }}" class="form-control" placeholder="Development Program" rows="3" maxlength="2000" style="resize:vertical" required readonly="readonly">{{ $hrdtIdp4->program }}</textarea>
                                        @endif
                                        <input type="hidden" id="hrdt_idp4_id_{{ $loop->iteration }}" name="hrdt_idp4_id_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ base64_encode($hrdtIdp4->id) }}">
                                      </div>
                                      <div class="col-sm-1">
                                        {!! Form::label('tr_'.$loop->iteration, 'Training') !!}
                                        @if ($hrdtidp1->status === "SUBMIT (MID)" && Auth::user()->can('hrd-idp-approve-div'))
                                          <button id="btnpopuptr_mid_{{ $loop->iteration }}" name="btnpopuptr_mid_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih Training" onclick="popupTrMid(this)" data-toggle="modal" data-target="#trModal"><span class="glyphicon glyphicon-search"></span></button>
                                        @else 
                                          <button id="btnpopuptr_mid_{{ $loop->iteration }}" name="btnpopuptr_mid_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih Training" onclick="popupTrMid(this)" data-toggle="modal" data-target="#trModal" disabled=""><span class="glyphicon glyphicon-search"></span></button>
                                        @endif
                                      </div>
                                      <div class="col-sm-2">
                                        {!! Form::label('tanggal_program_mid_'.$loop->iteration, 'Tanggal Program') !!}
                                        @if ($hrdtidp1->status === "SUBMIT (MID)" && Auth::user()->can('hrd-idp-approve-div'))
                                          @if (!empty($hrdtIdp4->tgl_program))
                                            {!! Form::date('tanggal_program_mid_'.$loop->iteration, \Carbon\Carbon::parse($hrdtIdp4->tgl_program), ['class'=>'form-control','placeholder' => 'Tgl Program', 'required', 'id'=>'tanggal_program_mid_'.$loop->iteration]) !!}
                                          @else 
                                            {!! Form::date('tanggal_program_mid_'.$loop->iteration, null, ['class'=>'form-control','placeholder' => 'Tgl Program', 'required', 'id'=>'tanggal_program_mid_'.$loop->iteration]) !!}
                                          @endif
                                        @else 
                                          @if (!empty($hrdtIdp4->tgl_program))
                                            {!! Form::date('tanggal_program_mid_'.$loop->iteration, \Carbon\Carbon::parse($hrdtIdp4->tgl_program), ['class'=>'form-control','placeholder' => 'Tgl Program', 'required', 'id'=>'tanggal_program_mid_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                          @else 
                                            {!! Form::date('tanggal_program_mid_'.$loop->iteration, null, ['class'=>'form-control','placeholder' => 'Tgl Program', 'required', 'id'=>'tanggal_program_mid_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                          @endif
                                        @endif
                                      </div>
                                      <div class="col-sm-3">
                                        {!! Form::label('achievement_mid_'.$loop->iteration, 'Achievement') !!}
                                        @if ($hrdtidp1->status === "SUBMIT (MID)" && Auth::user()->can('hrd-idp-approve-div'))
                                          <textarea id="achievement_mid_{{ $loop->iteration }}" name="achievement_mid_{{ $loop->iteration }}" class="form-control" placeholder="Achievement" rows="3" maxlength="2000" style="resize:vertical" required>{{ $hrdtIdp4->achievement }}</textarea>
                                        @else 
                                          <textarea id="achievement_mid_{{ $loop->iteration }}" name="achievement_mid_{{ $loop->iteration }}" class="form-control" placeholder="Achievement" rows="3" maxlength="2000" style="resize:vertical" required readonly="readonly">{{ $hrdtIdp4->achievement }}</textarea>
                                        @endif
                                      </div>
                                      <div class="col-sm-3">
                                        {!! Form::label('next_action_mid_'.$loop->iteration, 'Next Action') !!}
                                        @if ($hrdtidp1->status === "SUBMIT (MID)" && Auth::user()->can('hrd-idp-approve-div'))
                                          <textarea id="next_action_mid_{{ $loop->iteration }}" name="next_action_mid_{{ $loop->iteration }}" class="form-control" placeholder="Next Action" rows="3" maxlength="2000" style="resize:vertical" required>{{ $hrdtIdp4->next_action }}</textarea>
                                        @else 
                                          <textarea id="next_action_mid_{{ $loop->iteration }}" name="next_action_mid_{{ $loop->iteration }}" class="form-control" placeholder="Next Action" rows="3" maxlength="2000" style="resize:vertical" required readonly="readonly">{{ $hrdtIdp4->next_action }}</textarea>
                                        @endif
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
                        @if ($hrdtidp1->status === "SUBMIT (MID)" && Auth::user()->can('hrd-idp-approve-div') && $hrdtidp1->npk_div_head === Auth::user()->username)
                          <div class="box-body">
                            <p class="pull-right">
                              <button id="addRowMid" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Development Program"><span class="glyphicon glyphicon-plus"></span> Add Development Program</button>
                            </p>
                          </div>
                          <!-- /.box-body -->
                        @endif
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
                      <div class="box box-primary{{ !empty($hrdtidp1->id) ? ($hrdtidp1->status !== "SUBMIT (ONE)" ? " collapsed-box" : "") : "" }}">
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
                                <div class="box box-primary{{ !empty($hrdtidp1->id) ? ($hrdtidp1->status !== "SUBMIT (ONE)" ? " collapsed-box" : "") : "" }}">
                                  <div class="box-header with-border">
                                    <h3 class="box-title" id="box_one_{{ $loop->iteration }}">One Year Review ({{ $loop->iteration }})</h3>
                                    <div class="box-tools pull-right">
                                      <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                      </button>
                                      @if ($hrdtidp1->status === "SUBMIT (ONE)" && Auth::user()->can('hrd-idp-approve-div') && $hrdtidp1->npk_div_head === Auth::user()->username)
                                        <button id="btndeleteone_{{ $loop->iteration }}" name="btndeleteone_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Program" onclick="deleteOneReview(this)">
                                          <i class="fa fa-times"></i>
                                        </button>
                                      @endif
                                    </div>
                                  </div>
                                  <!-- /.box-header -->
                                  <div class="box-body">
                                    <div class="row form-group">
                                      <div class="col-sm-4">
                                        {!! Form::label('program_one_'.$loop->iteration, 'Development Program') !!}
                                        @if ($hrdtidp1->status === "SUBMIT (ONE)" && Auth::user()->can('hrd-idp-approve-div'))
                                          <textarea id="program_one_{{ $loop->iteration }}" name="program_one_{{ $loop->iteration }}" class="form-control" placeholder="Development Program" rows="3" maxlength="2000" style="resize:vertical" required>{{ $hrdtIdp5->program }}</textarea>
                                        @else 
                                          <textarea id="program_one_{{ $loop->iteration }}" name="program_one_{{ $loop->iteration }}" class="form-control" placeholder="Development Program" rows="3" maxlength="2000" style="resize:vertical" required readonly="readonly">{{ $hrdtIdp5->program }}</textarea>
                                        @endif
                                        <input type="hidden" id="hrdt_idp5_id_{{ $loop->iteration }}" name="hrdt_idp5_id_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ base64_encode($hrdtIdp5->id) }}">
                                      </div>
                                      <div class="col-sm-1">
                                        {!! Form::label('tr_'.$loop->iteration, 'Training') !!}
                                        @if ($hrdtidp1->status === "SUBMIT (ONE)" && Auth::user()->can('hrd-idp-approve-div'))
                                          <button id="btnpopuptr_one_{{ $loop->iteration }}" name="btnpopuptr_one_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih Training" onclick="popupTrOne(this)" data-toggle="modal" data-target="#trModal"><span class="glyphicon glyphicon-search"></span></button>
                                        @else 
                                          <button id="btnpopuptr_one_{{ $loop->iteration }}" name="btnpopuptr_one_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih Training" onclick="popupTrOne(this)" data-toggle="modal" data-target="#trModal" disabled=""><span class="glyphicon glyphicon-search"></span></button>
                                        @endif
                                      </div>
                                      <div class="col-sm-2">
                                        {!! Form::label('tanggal_program_one_'.$loop->iteration, 'Tanggal Program') !!}
                                        @if ($hrdtidp1->status === "SUBMIT (ONE)" && Auth::user()->can('hrd-idp-approve-div'))
                                          @if (!empty($hrdtIdp4->tgl_program))
                                            {!! Form::date('tanggal_program_one_'.$loop->iteration, \Carbon\Carbon::parse($hrdtIdp5->tgl_program), ['class'=>'form-control','placeholder' => 'Tgl Program', 'required', 'id'=>'tanggal_program_one_'.$loop->iteration]) !!}
                                          @else 
                                            {!! Form::date('tanggal_program_one_'.$loop->iteration, null, ['class'=>'form-control','placeholder' => 'Tgl Program', 'required', 'id'=>'tanggal_program_one_'.$loop->iteration]) !!}
                                          @endif
                                        @else 
                                          @if (!empty($hrdtIdp4->tgl_program))
                                            {!! Form::date('tanggal_program_one_'.$loop->iteration, \Carbon\Carbon::parse($hrdtIdp5->tgl_program), ['class'=>'form-control','placeholder' => 'Tgl Program', 'required', 'id'=>'tanggal_program_one_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                          @else 
                                            {!! Form::date('tanggal_program_one_'.$loop->iteration, null, ['class'=>'form-control','placeholder' => 'Tgl Program', 'required', 'id'=>'tanggal_program_one_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                          @endif
                                        @endif
                                      </div>
                                      <div class="col-sm-5">
                                        {!! Form::label('evaluation_one_'.$loop->iteration, 'Evaluation Result') !!}
                                        @if ($hrdtidp1->status === "SUBMIT (ONE)" && Auth::user()->can('hrd-idp-approve-div'))
                                          <textarea id="evaluation_one_{{ $loop->iteration }}" name="evaluation_one_{{ $loop->iteration }}" class="form-control" placeholder="Evaluation Result" rows="3" maxlength="2000" style="resize:vertical" required>{{ $hrdtIdp5->evaluation }}</textarea>
                                        @else 
                                          <textarea id="evaluation_one_{{ $loop->iteration }}" name="evaluation_one_{{ $loop->iteration }}" class="form-control" placeholder="Evaluation Result" rows="3" maxlength="2000" style="resize:vertical" required readonly="readonly">{{ $hrdtIdp5->evaluation }}</textarea>
                                        @endif
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
                        @if ($hrdtidp1->status === "SUBMIT (ONE)" && Auth::user()->can('hrd-idp-approve-div') && $hrdtidp1->npk_div_head === Auth::user()->username)
                          <div class="box-body">
                            <p class="pull-right">
                              <button id="addRowOne" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Development Program"><span class="glyphicon glyphicon-plus"></span> Add Development Program</button>
                            </p>
                          </div>
                          <!-- /.box-body -->
                        @endif
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
          @if (Auth::user()->can(['hrd-idp-approve-div','hrd-idp-reject-div']) && $hrdtidp1->npk_div_head === Auth::user()->username)
            @if ($hrdtidp1->status === "SUBMIT")
              @if (Auth::user()->can('hrd-idp-approve-div'))
                {!! Form::submit('Approve Divisi', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
                &nbsp;&nbsp;
              @endif
              @if (Auth::user()->can('hrd-idp-reject-div'))
                <button id='btnreject' type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Reject Divisi' onclick='reject("{{ base64_encode($hrdtidp1->id) }}")'>
                  <span class='glyphicon glyphicon-remove'></span> Reject Divisi
                </button>
                &nbsp;&nbsp;
              @endif
            @elseif ($hrdtidp1->status === "SUBMIT (MID)")
              @if (Auth::user()->can('hrd-idp-approve-div'))
                {!! Form::submit('Approve Divisi (MID)', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
                &nbsp;&nbsp;
              @endif
              @if (Auth::user()->can('hrd-idp-reject-div'))
                <button id='btnreject' type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Reject Divisi (MID)' onclick='reject("{{ base64_encode($hrdtidp1->id) }}")'>
                  <span class='glyphicon glyphicon-remove'></span> Reject Divisi (MID)
                </button>
                &nbsp;&nbsp;
              @endif
            @elseif ($hrdtidp1->status === "SUBMIT (ONE)")
              @if (Auth::user()->can('hrd-idp-approve-div'))
                {!! Form::submit('Approve Divisi (ONE)', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
                &nbsp;&nbsp;
              @endif
              @if (Auth::user()->can('hrd-idp-reject-div'))
                <button id='btnreject' type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Reject DivisiDIV (ONE)' onclick='reject("{{ base64_encode($hrdtidp1->id) }}")'>
                  <span class='glyphicon glyphicon-remove'></span> Reject Divisi (ONE)
                </button>
                &nbsp;&nbsp;
              @endif
            @endif
          @endif
          <a target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Print IDP {{ $hrdtidp1->npk }}" href="{{ route('hrdtidp1s.print', base64_encode($hrdtidp1->id)) }}"><span class='glyphicon glyphicon-print'></span> Print IDP</a>
          &nbsp;&nbsp;
          <a class="btn btn-primary" href="{{ route('hrdtidp1s.approval') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard">Cancel</a>
        </div>
      {!! Form::close() !!}
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- Modal LM -->
  @include('hr.idp.popup.lmModal')
  <!-- Modal TR -->
  @include('hr.idp.popup.trModal')
@endsection

@section('scripts')
<script type="text/javascript">

  function daterangepicker() {
    var yyyy = document.getElementById("year").value.trim();
    var minQ1 = "01/01/" + yyyy;
    var maxQ1 = "31/12/" + yyyy;
    //Date range picker
    $("input[name^='tgl_']").daterangepicker(
      {
        minDate: minQ1, 
        maxDate: maxQ1,
        locale: {
          format: 'DD/MM/YYYY'
        }
      }
    );
  }

  daterangepicker();

  $('#form_id').submit(function (e, params) {
    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();
      //additional input validations can be done hear
      var valid_data = "T";
      var info = "";
      if(valid_data === "F") {
        swal(info, "Perhatikan inputan anda!", "warning");
      } else {
        var msg = "Anda yakin APPROVE IDP ini?";
        var txt = "Data yang tidak valid (lengkap) tidak akan diproses.";
        swal({
          title: msg,
          text: txt,
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, approve it!',
          cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
          allowOutsideClick: true,
          allowEscapeKey: true,
          allowEnterKey: true,
          reverseButtons: false,
          focusCancel: false,
        }).then(function () {
          document.getElementById("st_input").value = "DIV";
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

  function popupLm(ths, param) {
    var myHeading = "<p>Popup Learning Methode</p>";
    $("#lmModalLabel").html(myHeading);

    var row = ths.id.replace('btnpopuplm_' + param + '_', '');

    var url = '{{ route('datatables.popupLms') }}';
    var lookupLm = $('#lookupLm').DataTable({
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
      "order": [[0, 'asc']],
      columns: [
        { data: 'nm_lm', name: 'nm_lm'},
        { data: 'ket_lm', name: 'ket_lm'},
        { data: 'cat_lm', name: 'cat_lm'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupLm tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupLm.rows(rows).data();
          $.each($(rowData),function(key,value){
            var row = ths.id.replace('btnpopuplm_' + param + '_', '');
            var program = "program_" + param + "_" + row;
            var program_value = document.getElementById(program).value.trim();
            if(program_value === "") {
              document.getElementById(program).value = value["nm_lm"] + ".";
            } else {
              document.getElementById(program).value += "\n" + value["nm_lm"] + ".";
            }
            $('#lmModal').modal('hide');
          });
        });
        $('#lmModal').on('hidden.bs.modal', function () {
          // 
        });
      },
    });
  }

  function popupTrMid(ths) {
    var myHeading = "<p>Popup History Training</p>";
    $("#trModalLabel").html(myHeading);

    var row = ths.id.replace('btnpopuptr_mid_', '');

    var url = '{{ route('datatables.popupTrainings', 'param') }}';
    url = url.replace('param', window.btoa('{{ !empty($hrdtidp1->id) ? $hrdtidp1->npk : "-" }}'));
    var lookupTr = $('#lookupTr').DataTable({
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
      "order": [[2, 'desc'],[3, 'desc']],
      columns: [
        { data: 'kode_tr', name: 'kode_tr'},
        { data: 'nm_tr', name: 'nm_tr'},
        { data: 'tgl_mulai', name: 'tgl_mulai'},
        { data: 'tgl_selesai', name: 'tgl_selesai'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupTr tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupTr.rows(rows).data();
          $.each($(rowData),function(key,value){
            var row = ths.id.replace('btnpopuptr_mid_', '');
            var program = "program_mid_" + row;
            var program_value = document.getElementById(program).value.trim();
            if(program_value === "") {
              document.getElementById(program).value = value["nm_tr"] + ".";
            } else {
              document.getElementById(program).value += "\n" + value["nm_tr"] + ".";
            }
            var tanggal_program = "tanggal_program_mid_" + row;
            document.getElementById(tanggal_program).value = value["tgl_selesai"].substr(0, 10);
            $('#trModal').modal('hide');
          });
        });
        $('#trModal').on('hidden.bs.modal', function () {
          // 
        });
      },
    });
  }

  $("#addRowMid").click(function(){
    addMid();
  });

  function addMid() {
    var jml_row_mid = document.getElementById("jml_row_mid").value.trim();
    jml_row_mid = Number(jml_row_mid) + 1;
    document.getElementById("jml_row_mid").value = jml_row_mid;

    var id_field = 'field_mid_'+jml_row_mid;
    var id_box = 'box_mid_'+jml_row_mid;
    var btndeletemid = 'btndeletemid_'+jml_row_mid;

    var hrdt_idp4_id = 'hrdt_idp4_id_'+jml_row_mid;
    var program_mid = 'program_mid_'+jml_row_mid;
    var btnpopuptr_mid = 'btnpopuptr_mid_'+jml_row_mid;
    var tanggal_program_mid = 'tanggal_program_mid_'+jml_row_mid;
    var achievement_mid = 'achievement_mid_'+jml_row_mid;
    var next_action_mid = 'next_action_mid_'+jml_row_mid;
    
    $("#field-mid").append(
      '<div class="row" id="'+id_field+'">\
        <div class="col-md-12">\
          <div class="box box-primary">\
            <div class="box-header with-border">\
              <h3 class="box-title" id="'+id_box+'">Mid Year Review ('+ jml_row_mid +')</h3>\
              <div class="box-tools pull-right">\
                <button type="button" class="btn btn-success btn-sm" data-widget="collapse">\
                  <i class="fa fa-minus"></i>\
                </button>\
                <button id="' + btndeletemid + '" name="' + btndeletemid + '" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Program" onclick="deleteMidReview(this)">\
                  <i class="fa fa-times"></i>\
                </button>\
              </div>\
            </div>\
            <div class="box-body">\
              <div class="row form-group">\
                <div class="col-sm-3">\
                  <label>Development Program</label>\
                  <textarea id="' + program_mid + '" name="' + program_mid + '" class="form-control" placeholder="Development Program (*)" rows="3" maxlength="2000" style="resize:vertical" required></textarea>\
                  <input type="hidden" id="' + hrdt_idp4_id + '" name="' + hrdt_idp4_id + '" class="form-control" readonly="readonly" value="0">\
                </div>\
                <div class="col-sm-1">\
                  <label>Training</label>\
                  <button id="' + btnpopuptr_mid + '" name="' + btnpopuptr_mid + '" type="button" class="btn btn-info" title="Pilih Training" onclick="popupTrMid(this)" data-toggle="modal" data-target="#trModal"><span class="glyphicon glyphicon-search"></span></button>\
                </div>\
                <div class="col-sm-2">\
                  <label>Tanggal Program</label>\
                  <input type="date" id="' + tanggal_program_mid + '" name="' + tanggal_program_mid + '" class="form-control" required>\
                </div>\
                <div class="col-sm-3">\
                  <label>Achievement</label>\
                  <textarea id="' + achievement_mid + '" name="' + achievement_mid + '" class="form-control" placeholder="Achievement (*)" rows="3" maxlength="2000" style="resize:vertical" required></textarea>\
                </div>\
                <div class="col-sm-3">\
                  <label>Next Action</label>\
                  <textarea id="' + next_action_mid + '" name="' + next_action_mid + '" class="form-control" placeholder="Next Action (*)" rows="3" maxlength="2000" style="resize:vertical" required></textarea>\
                </div>\
              </div>\
            </div>\
          </div>\
        </div>\
      </div>'
    );

    document.getElementById(program_mid).focus();
  }

  function deleteMidReview(ths) {
    var row = ths.id.replace('btndeletemid_', '');
    var msg = 'Anda yakin menghapus Program ini?';
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
      var info = "";
      var info2 = "";
      var info3 = "warning";
      var hrdt_idp4_id = "hrdt_idp4_id_" + row;
      var hrdt_idp4_id_value = document.getElementById(hrdt_idp4_id).value.trim();

      if(hrdt_idp4_id_value === "0" || hrdt_idp4_id_value === "") {
        changeIdMid(row);
      } else {
        //DELETE DI DATABASE
        // remove these events;
        window.onkeydown = null;
        window.onfocus = null;
        var token = document.getElementsByName('_token')[0].value.trim();
        // delete via ajax
        // hapus data detail dengan ajax
        var url = "{{ route('hrdtidp4s.destroy', 'param') }}";
        url = url.replace('param', hrdt_idp4_id_value);
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
              changeIdMid(row);
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

  function changeIdMid(row) {
    var id_div = "#field_mid_" + row;
    $(id_div).remove();

    var jml_row = document.getElementById("jml_row_mid").value.trim();
    jml_row = Number(jml_row);
    nextRow = Number(row) + 1;
    for($i = nextRow; $i <= jml_row; $i++) {
      var id_field = "#field_mid_" + $i;
      var id_field_new = "field_mid_" + ($i-1);
      $(id_field).attr({"id":id_field_new, "name":id_field_new});
      var id_box = "#box_mid_" + $i;
      var id_box_new = "box_mid_" + ($i-1);
      $(id_box).attr({"id":id_box_new, "name":id_box_new});
      var btndeletemid = "#btndeletemid_" + $i;
      var btndeletemid_new = "btndeletemid_" + ($i-1);
      $(btndeletemid).attr({"id":btndeletemid_new, "name":btndeletemid_new});
      var hrdt_idp4_id = "#hrdt_idp4_id_" + $i;
      var hrdt_idp4_id_new = "hrdt_idp4_id_" + ($i-1);
      $(hrdt_idp4_id).attr({"id":hrdt_idp4_id_new, "name":hrdt_idp4_id_new});
      var program_mid = "#program_mid_" + $i;
      var program_mid_new = "program_mid_" + ($i-1);
      $(program_mid).attr({"id":program_mid_new, "name":program_mid_new});
      var btnpopuptr_mid = "#btnpopuptr_mid_" + $i;
      var btnpopuptr_mid_new = "btnpopuptr_mid_" + ($i-1);
      $(btnpopuptr_mid).attr({"id":btnpopuptr_mid_new, "name":btnpopuptr_mid_new});
      var tanggal_program_mid = "#tanggal_program_mid_" + $i;
      var tanggal_program_mid_new = "tanggal_program_mid_" + ($i-1);
      $(tanggal_program_mid).attr({"id":tanggal_program_mid_new, "name":tanggal_program_mid_new});
      var achievement_mid = "#achievement_mid_" + $i;
      var achievement_mid_new = "achievement_mid_" + ($i-1);
      $(achievement_mid).attr({"id":achievement_mid_new, "name":achievement_mid_new});
      var next_action_mid = "#next_action_mid_" + $i;
      var next_action_mid_new = "next_action_mid_" + ($i-1);
      $(next_action_mid).attr({"id":next_action_mid_new, "name":next_action_mid_new});
      var text = document.getElementById(id_box_new).innerHTML;
      text = text.replace($i, ($i-1));
      document.getElementById(id_box_new).innerHTML = text;
    }
    jml_row = jml_row - 1;
    document.getElementById("jml_row_mid").value = jml_row;
  }

  function popupTrOne(ths) {
    var myHeading = "<p>Popup History Training</p>";
    $("#trModalLabel").html(myHeading);

    var row = ths.id.replace('btnpopuptr_one_', '');

    var url = '{{ route('datatables.popupTrainings', 'param') }}';
    url = url.replace('param', window.btoa('{{ !empty($hrdtidp1->id) ? $hrdtidp1->npk : "-" }}'));
    var lookupTr = $('#lookupTr').DataTable({
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
      "order": [[2, 'desc'],[3, 'desc']],
      columns: [
        { data: 'kode_tr', name: 'kode_tr'},
        { data: 'nm_tr', name: 'nm_tr'},
        { data: 'tgl_mulai', name: 'tgl_mulai'},
        { data: 'tgl_selesai', name: 'tgl_selesai'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupTr tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupTr.rows(rows).data();
          $.each($(rowData),function(key,value){
            var row = ths.id.replace('btnpopuptr_one_', '');
            var program = "program_one_" + row;
            var program_value = document.getElementById(program).value.trim();
            if(program_value === "") {
              document.getElementById(program).value = value["nm_tr"] + ".";
            } else {
              document.getElementById(program).value += "\n" + value["nm_tr"] + ".";
            }
            var tanggal_program = "tanggal_program_one_" + row;
            document.getElementById(tanggal_program).value = value["tgl_selesai"].substr(0, 10);
            $('#trModal').modal('hide');
          });
        });
        $('#trModal').on('hidden.bs.modal', function () {
          // 
        });
      },
    });
  }

  $("#addRowOne").click(function(){
    addOne();
  });

  function addOne() {
    var jml_row_one = document.getElementById("jml_row_one").value.trim();
    jml_row_one = Number(jml_row_one) + 1;
    document.getElementById("jml_row_one").value = jml_row_one;

    var id_field = 'field_one_'+jml_row_one;
    var id_box = 'box_one_'+jml_row_one;
    var btndeleteone = 'btndeleteone_'+jml_row_one;

    var hrdt_idp5_id = 'hrdt_idp5_id_'+jml_row_one;
    var program_one = 'program_one_'+jml_row_one;
    var btnpopuptr_one = 'btnpopuptr_one_'+jml_row_one;
    var tanggal_program_one = 'tanggal_program_one_'+jml_row_one;
    var evaluation_one = 'evaluation_one_'+jml_row_one;
    
    $("#field-one").append(
      '<div class="row" id="'+id_field+'">\
        <div class="col-md-12">\
          <div class="box box-primary">\
            <div class="box-header with-border">\
              <h3 class="box-title" id="'+id_box+'">One Year Review ('+ jml_row_one +')</h3>\
              <div class="box-tools pull-right">\
                <button type="button" class="btn btn-success btn-sm" data-widget="collapse">\
                  <i class="fa fa-minus"></i>\
                </button>\
                <button id="' + btndeleteone + '" name="' + btndeleteone + '" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Program" onclick="deleteOneReview(this)">\
                  <i class="fa fa-times"></i>\
                </button>\
              </div>\
            </div>\
            <div class="box-body">\
              <div class="row form-group">\
                <div class="col-sm-4">\
                  <label>Development Program</label>\
                  <textarea id="' + program_one + '" name="' + program_one + '" class="form-control" placeholder="Development Program (*)" rows="3" maxlength="2000" style="resize:vertical" required></textarea>\
                  <input type="hidden" id="' + hrdt_idp5_id + '" name="' + hrdt_idp5_id + '" class="form-control" readonly="readonly" value="0">\
                </div>\
                <div class="col-sm-1">\
                  <label>Training</label>\
                  <button id="' + btnpopuptr_one + '" name="' + btnpopuptr_one + '" type="button" class="btn btn-info" title="Pilih Training" onclick="popupTrOne(this)" data-toggle="modal" data-target="#trModal"><span class="glyphicon glyphicon-search"></span></button>\
                </div>\
                <div class="col-sm-2">\
                  <label>Tanggal Program</label>\
                  <input type="date" id="' + tanggal_program_one + '" name="' + tanggal_program_one + '" class="form-control" required>\
                </div>\
                <div class="col-sm-5">\
                  <label>Evaluation Result</label>\
                  <textarea id="' + evaluation_one + '" name="' + evaluation_one + '" class="form-control" placeholder="Evaluation Result (*)" rows="3" maxlength="2000" style="resize:vertical" required></textarea>\
                </div>\
              </div>\
            </div>\
          </div>\
        </div>\
      </div>'
    );

    document.getElementById(program_one).focus();
  }

  function deleteOneReview(ths) {
    var row = ths.id.replace('btndeleteone_', '');
    var msg = 'Anda yakin menghapus Program ini?';
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
      var info = "";
      var info2 = "";
      var info3 = "warning";
      var hrdt_idp5_id = "hrdt_idp5_id_" + row;
      var hrdt_idp5_id_value = document.getElementById(hrdt_idp5_id).value.trim();

      if(hrdt_idp5_id_value === "0" || hrdt_idp5_id_value === "") {
        changeIdOne(row);
      } else {
        //DELETE DI DATABASE
        // remove these events;
        window.onkeydown = null;
        window.onfocus = null;
        var token = document.getElementsByName('_token')[0].value.trim();
        // delete via ajax
        // hapus data detail dengan ajax
        var url = "{{ route('hrdtidp5s.destroy', 'param') }}";
        url = url.replace('param', hrdt_idp5_id_value);
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
              changeIdOne(row);
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

  function changeIdOne(row) {
    var id_div = "#field_one_" + row;
    $(id_div).remove();

    var jml_row = document.getElementById("jml_row_one").value.trim();
    jml_row = Number(jml_row);
    nextRow = Number(row) + 1;
    for($i = nextRow; $i <= jml_row; $i++) {
      var id_field = "#field_one_" + $i;
      var id_field_new = "field_one_" + ($i-1);
      $(id_field).attr({"id":id_field_new, "name":id_field_new});
      var id_box = "#box_one_" + $i;
      var id_box_new = "box_one_" + ($i-1);
      $(id_box).attr({"id":id_box_new, "name":id_box_new});
      var btndeleteone = "#btndeleteone_" + $i;
      var btndeleteone_new = "btndeleteone_" + ($i-1);
      $(btndeleteone).attr({"id":btndeleteone_new, "name":btndeleteone_new});
      var hrdt_idp5_id = "#hrdt_idp5_id_" + $i;
      var hrdt_idp5_id_new = "hrdt_idp5_id_" + ($i-1);
      $(hrdt_idp5_id).attr({"id":hrdt_idp5_id_new, "name":hrdt_idp5_id_new});
      var program_one = "#program_one_" + $i;
      var program_one_new = "program_one_" + ($i-1);
      $(program_one).attr({"id":program_one_new, "name":program_one_new});
      var btnpopuptr_one = "#btnpopuptr_one_" + $i;
      var btnpopuptr_one_new = "btnpopuptr_one_" + ($i-1);
      $(btnpopuptr_one).attr({"id":btnpopuptr_one_new, "name":btnpopuptr_one_new});
      var tanggal_program_one = "#tanggal_program_one_" + $i;
      var tanggal_program_one_new = "tanggal_program_one_" + ($i-1);
      $(tanggal_program_one).attr({"id":tanggal_program_one_new, "name":tanggal_program_one_new});
      var evaluation_one = "#evaluation_one_" + $i;
      var evaluation_one_new = "evaluation_one_" + ($i-1);
      $(evaluation_one).attr({"id":evaluation_one_new, "name":evaluation_one_new});
      var text = document.getElementById(id_box_new).innerHTML;
      text = text.replace($i, ($i-1));
      document.getElementById(id_box_new).innerHTML = text;
    }
    jml_row = jml_row - 1;
    document.getElementById("jml_row_one").value = jml_row;
  }

  function reject(id)
  {
    var msg = "Anda yakin REJECT IDP ini?";
    var txt = "";
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
          '<textarea id="swal-input1" class="form-control" maxlength="2000" rows="3" cols="20" placeholder="Keterangan Reject (Max. 2000 Karakter)" style="resize:vertical">',
        preConfirm: function () {
          return new Promise(function (resolve, reject) {
            if ($('#swal-input1').val()) {
              if($('#swal-input1').val().length > 2000) {
                reject('Keterangan Reject Max 2000 Karakter!')
              } else {
                resolve([
                  $('#swal-input1').val()
                ])
              }
            } else {
              reject('Keterangan Reject tidak boleh kosong!')
            }
          })
        }
      }).then(function (result) {
        var urlRedirect = "{{ route('hrdtidp1s.reject', ['param', 'param2', 'param3']) }}";
        urlRedirect = urlRedirect.replace('param3', window.btoa("DIV"));
        urlRedirect = urlRedirect.replace('param2', window.btoa(result[0]));
        urlRedirect = urlRedirect.replace('param', id);
        window.location.href = urlRedirect;
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