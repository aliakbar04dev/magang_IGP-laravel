@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        PICA
        <small>Detail PICA</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('picas.index') }}"><i class="fa fa-exchange"></i> PICA</a></li>
        <li class="active">Detail {{ $pica->no_pica }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detail PICA</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 10%;"><b>No. PICA</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">{{ $pica->no_pica }}</td>
                    <td style="width: 10%;"><b>Tgl PICA</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ \Carbon\Carbon::parse($pica->tgl_pica)->format('d/m/Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>No. QPR</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">
                      @if (Auth::user()->can(['qpr-create','qpr-view']))
                        <a href="{{ route('qprs.show', base64_encode($pica->issue_no)) }}" data-toggle="tooltip" data-placement="top" title="Show Detail QPR {{ $pica->issue_no }}">{{ $pica->issue_no }}</a>
                      @else
                        {{ $pica->issue_no }}
                      @endif
                    </td>
                    <td style="width: 10%;"><b>No. Revisi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if ($pica->picaRejects()->get()->count() > 0)
                        {{ $pica->no_revisi }}
                        @foreach ($pica->picaRejects()->get() as $picaReject)
                          @if (Auth::user()->can('pica-*'))
                            {{ "&nbsp;-&nbsp;&nbsp;" }}<a target="_blank" href="{{ route('picas.showrevisi', base64_encode($picaReject->id)) }}" data-toggle="tooltip" data-placement="top" title="Show History PICA No. Revisi {{ $picaReject->no_revisi }}">{{ $picaReject->no_revisi }}</a>
                          @else
                            {{ "&nbsp;-&nbsp;&nbsp;".$picaReject->no_revisi }}
                          @endif
                        @endforeach
                      @else
                        {{ $pica->no_revisi }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Status</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">{{ $pica->status }}</td>
                  </tr>
                  @if (!empty($pica->submit_tgl))
                    <tr>
                      <td style="width: 10%;"><b>Tgl Submit</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        @if (!empty($pica->submit_tgl))
                          {{ \Carbon\Carbon::parse($pica->submit_tgl)->format('d/m/Y H:i') }}
                        @endif  
                      </td>
                      <td style="width: 10%;"><b>PIC Submit</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $pica->submit_pic." - ".$pica->nama($pica->submit_pic) }}</td>
                    </tr>
                  @endif
                  @if (!empty($pica->approve_tgl))
                    <tr>
                      <td style="width: 10%;"><b>Tgl Approve</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        @if (!empty($pica->approve_tgl))
                          {{ \Carbon\Carbon::parse($pica->approve_tgl)->format('d/m/Y H:i') }}
                        @endif  
                      </td>
                      <td style="width: 10%;"><b>PIC Approve</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $pica->approve_pic." - ".$pica->nama($pica->approve_pic) }}</td>
                    </tr>
                  @endif
                  @if (!empty($pica->reject_tgl))
                    <tr>
                      <td style="width: 10%;"><b>Tgl Reject</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        @if (!empty($pica->reject_tgl))
                          {{ \Carbon\Carbon::parse($pica->reject_tgl)->format('d/m/Y H:i') }}
                        @endif  
                      </td>
                      <td style="width: 10%;"><b>PIC Reject</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $pica->reject_pic." - ".$pica->nama($pica->reject_pic) }}</td>
                    </tr>
                    <tr>
                      <td style="width: 10%;"><b>Ket. Reject</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">{{ $pica->reject_ket }}</td>
                    </tr>
                  @endif
                  @if (!empty($pica->close_tgl))
                    <tr>
                      <td style="width: 10%;"><b>Tgl Close</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        @if (!empty($pica->close_tgl))
                          {{ \Carbon\Carbon::parse($pica->close_tgl)->format('d/m/Y H:i') }}
                        @endif  
                      </td>
                      <td style="width: 10%;"><b>PIC Close</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $pica->close_pic." - ".$pica->nama($pica->close_pic) }}</td>
                    </tr>
                  @endif
                  @if (!empty($pica->efektif_tgl))
                    <tr>
                      <td style="width: 10%;"><b>Tgl Efektif</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        @if (!empty($pica->efektif_tgl))
                          {{ \Carbon\Carbon::parse($pica->efektif_tgl)->format('d/m/Y H:i') }}
                        @endif  
                      </td>
                      <td style="width: 10%;"><b>PIC Efektif</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $pica->efektif_pic." - ".$pica->nama($pica->efektif_pic) }}</td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
            
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active">
                <a href="#fp" aria-controls="fp" role="tab" data-toggle="tab" title="Flow Process">
                  4. Flow Process
                </a>
              </li>
              <li role="presentation">
                <a href="#sa" aria-controls="sa" role="tab" data-toggle="tab" title="Supplier Action">
                  5. Supplier Action
                </a>
              </li>
              <li role="presentation">
                <a href="#rca" aria-controls="rca" role="tab" data-toggle="tab" title="Rootcause Analyze">
                  6. Rootcause Analyze
                </a>
              </li>
              <li role="presentation">
                <a href="#cop" aria-controls="cop" role="tab" data-toggle="tab" title="Countermeasure Of Problem">
                  7. COP
                </a>
              </li>
              <li role="presentation">
                <a href="#fpimp" aria-controls="fpimp" role="tab" data-toggle="tab" title="Flow Process After Improvement">
                  8. FP After Improvement
                </a>
              </li>
              <li role="presentation">
                <a href="#evaluation" aria-controls="evaluation" role="tab" data-toggle="tab" title="Evaluation">
                  9. Evaluation
                </a>
              </li>
              <li role="presentation">
                <a href="#std" aria-controls="std" role="tab" data-toggle="tab" title="Standardization">
                  10. Standardization
                </a>
              </li>
              <li role="presentation">
                <a href="#yokotenkai" aria-controls="yokotenkai" role="tab" data-toggle="tab" title="Yokotenkai">
                  11. Yokotenkai
                </a>
              </li>
            </ul>
            <!-- /.tablist -->

            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="fp">
                <div class="box-body">
                  <div class="row form-group">
                    <div class="col-sm-5">
                      {!! Form::label('fp_pict_general', 'General Flow Process') !!}
                      @if (!empty($pica->fp_pict_general))
                        <p>
                          <img src="{{ $pica->pict("fp_pict_general") }}" alt="File Not Found" class="img-rounded img-responsive">
                        </p>
                      @endif
                    </div>
                    <div class="col-sm-5">
                      {!! Form::label('fp_pict_detail', 'Detail Flow Process') !!}
                      @if (!empty($pica->fp_pict_detail))
                        <p>
                          <img src="{{ $pica->pict("fp_pict_detail") }}" alt="File Not Found" class="img-rounded img-responsive">
                        </p>
                      @endif
                    </div>
                  </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.tabpanel -->
              <div role="tabpanel" class="tab-pane" id="sa">
                <ul class="nav nav-tabs" role="tablist">
                  <li role="presentation" class="active">
                    <a href="#sa2" aria-controls="sa2" role="tab" data-toggle="tab" title="Supplier Action">
                      Supplier Action
                    </a>
                  </li>
                  <li role="presentation">
                    <a href="#iop" aria-controls="iop" role="tab" data-toggle="tab" title="Investigasi Of Problem">
                      5.A. Investigasi Of Problem
                    </a>
                  </li>
                  <li role="presentation">
                    <a href="#ioptm" aria-controls="ioptm" role="tab" data-toggle="tab" title="Interview & Observasi Pengamatan Terhadap Member">
                      5.B. Interview & Observasi
                    </a>
                  </li>
                  <li role="presentation">
                    <a href="#hp" aria-controls="hp" role="tab" data-toggle="tab" title="Henkaten Process / Changing Point Process">
                      5.C. Henkaten Process / Changing Point Process
                    </a>
                  </li>
                </ul>
                <!-- /.tablist -->
                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane active" id="sa2">
                    <div class="box-body">
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('sa_pict', 'File Image') !!}
                          @if (!empty($pica->sa_pict))
                            <p>
                              <img src="{{ $pica->pict("sa_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                            </p>
                          @endif
                        </div>
                      </div>
                      <!-- /.form-group -->
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.tabpanel -->
                  <div role="tabpanel" class="tab-pane" id="iop">
                    <ul class="nav nav-tabs" role="tablist">
                      <li role="presentation" class="active">
                        <a href="#ioptools" aria-controls="ioptools" role="tab" data-toggle="tab">
                          <i class="fa fa-pencil-square-o"></i> Machine/Tools
                        </a>
                      </li>
                      <li role="presentation">
                        <a href="#iopmat" aria-controls="iopmat" role="tab" data-toggle="tab">
                          <i class="fa fa-pencil-square-o"></i> Material
                        </a>
                      </li>
                      <li role="presentation">
                        <a href="#iopman" aria-controls="iopman" role="tab" data-toggle="tab">
                          <i class="fa fa-pencil-square-o"></i> Man
                        </a>
                      </li>
                      <li role="presentation">
                        <a href="#iopmet" aria-controls="iopmet" role="tab" data-toggle="tab">
                          <i class="fa fa-pencil-square-o"></i> Methode
                        </a>
                      </li>
                      <li role="presentation">
                        <a href="#iopenv" aria-controls="iopenv" role="tab" data-toggle="tab">
                          <i class="fa fa-pencil-square-o"></i> Environment
                        </a>
                      </li>
                    </ul>
                    <!-- /.tablist -->
                    <div class="tab-content">
                      <div role="tabpanel" class="tab-pane active" id="ioptools">
                        <div class="box-body">
                          <div class="row form-group">
                            <div class="col-sm-5">
                              {!! Form::label('iop_tools_subject', 'Subject') !!}
                              {!! Form::textarea('iop_tools_subject', $pica->iop_tools_subject, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                            </div>
                            <div class="col-sm-5">
                              {!! Form::label('iop_tools_pc', 'Point Check') !!}
                              {!! Form::textarea('iop_tools_pc', $pica->iop_tools_pc, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-5">
                              {!! Form::label('iop_tools_std', 'Standard') !!}
                              {!! Form::textarea('iop_tools_std', $pica->iop_tools_std, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                            </div>
                            <div class="col-sm-5">
                              {!! Form::label('iop_tools_act', 'Actual') !!}
                              {!! Form::textarea('iop_tools_act', $pica->iop_tools_act, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-3">
                              {!! Form::label('iop_tools_status', 'Status') !!}
                              {!! Form::select('iop_tools_status', ['O' => 'OK Sesuai Standard', 'P' => 'Potensi Problem', 'N' => 'NG / Tidak Standard'], $pica->iop_tools_status, ['class'=>'form-control select2','placeholder' => '-', 'disabled'=>'']) !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                        </div>
                        <!-- /.box-body -->
                      </div>
                      <!-- /.tabpanel -->
                      <div role="tabpanel" class="tab-pane" id="iopmat">
                        <div class="box-body">
                          <div class="row form-group">
                            <div class="col-sm-5">
                              {!! Form::label('iop_mat_subject', 'Subject') !!}
                              {!! Form::textarea('iop_mat_subject', $pica->iop_mat_subject, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                            </div>
                            <div class="col-sm-5">
                              {!! Form::label('iop_mat_pc', 'Point Check') !!}
                              {!! Form::textarea('iop_mat_pc', $pica->iop_mat_pc, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-5">
                              {!! Form::label('iop_mat_std', 'Standard') !!}
                              {!! Form::textarea('iop_mat_std', $pica->iop_mat_std, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                            </div>
                            <div class="col-sm-5">
                              {!! Form::label('iop_mat_act', 'Actual') !!}
                              {!! Form::textarea('iop_mat_act', $pica->iop_mat_act, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-3">
                              {!! Form::label('iop_mat_status', 'Status') !!}
                              {!! Form::select('iop_mat_status', ['O' => 'OK Sesuai Standard', 'P' => 'Potensi Problem', 'N' => 'NG / Tidak Standard'], $pica->iop_mat_status, ['class'=>'form-control select2','placeholder' => '-', 'disabled'=>'']) !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                        </div>
                        <!-- /.box-body -->
                      </div>
                      <!-- /.tabpanel -->
                      <div role="tabpanel" class="tab-pane" id="iopman">
                        <div class="box-body">
                          <div class="row form-group">
                            <div class="col-sm-5">
                              {!! Form::label('iop_man_subject', 'Subject') !!}
                              {!! Form::textarea('iop_man_subject', $pica->iop_man_subject, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                            </div>
                            <div class="col-sm-5">
                              {!! Form::label('iop_man_pc', 'Point Check') !!}
                              {!! Form::textarea('iop_man_pc', $pica->iop_man_pc, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-5">
                              {!! Form::label('iop_man_std', 'Standard') !!}
                              {!! Form::textarea('iop_man_std', $pica->iop_man_std, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                            </div>
                            <div class="col-sm-5">
                              {!! Form::label('iop_man_act', 'Actual') !!}
                              {!! Form::textarea('iop_man_act', $pica->iop_man_act, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-3">
                              {!! Form::label('iop_man_status', 'Status') !!}
                              {!! Form::select('iop_man_status', ['O' => 'OK Sesuai Standard', 'P' => 'Potensi Problem', 'N' => 'NG / Tidak Standard'], $pica->iop_man_status, ['class'=>'form-control select2','placeholder' => '-', 'disabled'=>'']) !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                        </div>
                        <!-- /.box-body -->
                      </div>
                      <!-- /.tabpanel -->
                      <div role="tabpanel" class="tab-pane" id="iopmet">
                        <div class="box-body">
                          <div class="row form-group">
                            <div class="col-sm-5">
                              {!! Form::label('iop_met_subject', 'Subject') !!}
                              {!! Form::textarea('iop_met_subject', $pica->iop_met_subject, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                            </div>
                            <div class="col-sm-5">
                              {!! Form::label('iop_met_pc', 'Point Check') !!}
                              {!! Form::textarea('iop_met_pc', $pica->iop_met_pc, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-5">
                              {!! Form::label('iop_met_std', 'Standard') !!}
                              {!! Form::textarea('iop_met_std', $pica->iop_met_std, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                            </div>
                            <div class="col-sm-5">
                              {!! Form::label('iop_met_act', 'Actual') !!}
                              {!! Form::textarea('iop_met_act', $pica->iop_met_act, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-3">
                              {!! Form::label('iop_met_status', 'Status') !!}
                              {!! Form::select('iop_met_status', ['O' => 'OK Sesuai Standard', 'P' => 'Potensi Problem', 'N' => 'NG / Tidak Standard'], $pica->iop_met_status, ['class'=>'form-control select2','placeholder' => '-', 'disabled'=>'']) !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                        </div>
                        <!-- /.box-body -->
                      </div>
                      <!-- /.tabpanel -->
                      <div role="tabpanel" class="tab-pane" id="iopenv">
                        <div class="box-body">
                          <div class="row form-group">
                            <div class="col-sm-5">
                              {!! Form::label('iop_env_subject', 'Subject') !!}
                              {!! Form::textarea('iop_env_subject', $pica->iop_env_subject, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                            </div>
                            <div class="col-sm-5">
                              {!! Form::label('iop_env_pc', 'Point Check') !!}
                              {!! Form::textarea('iop_env_pc', $pica->iop_env_pc, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-5">
                              {!! Form::label('iop_env_std', 'Standard') !!}
                              {!! Form::textarea('iop_env_std', $pica->iop_env_std, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                            </div>
                            <div class="col-sm-5">
                              {!! Form::label('iop_env_act', 'Actual') !!}
                              {!! Form::textarea('iop_env_act', $pica->iop_env_act, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-3">
                              {!! Form::label('iop_env_status', 'Status') !!}
                              {!! Form::select('iop_env_status', ['O' => 'OK Sesuai Standard', 'P' => 'Potensi Problem', 'N' => 'NG / Tidak Standard'], $pica->iop_env_status, ['class'=>'form-control select2','placeholder' => '-', 'disabled'=>'']) !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                        </div>
                        <!-- /.box-body -->
                      </div>
                      <!-- /.tabpanel -->
                    </div>
                    <!-- /.tab-content -->
                  </div>
                  <!-- /.tabpanel -->
                  <div role="tabpanel" class="tab-pane" id="ioptm">
                    <div class="box-body">
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('ioptm_pict', 'Foto MP') !!}
                          @if (!empty($pica->ioptm_pict))
                            <p>
                              <img src="{{ $pica->pict("ioptm_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                            </p>
                          @endif
                        </div>
                      </div>
                      <!-- /.form-group -->
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('ioptm_pk', 'Product Knowledge') !!}
                          {!! Form::textarea('ioptm_pk', $pica->ioptm_pk, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                        </div>
                        <div class="col-sm-3">
                          {!! Form::label('ioptm_pk_status', 'Status Product Knowledge') !!}
                          {!! Form::select('ioptm_pk_status', ['O' => 'OK Sesuai Standard', 'P' => 'Potensi Problem', 'N' => 'NG / Tidak Standard'], $pica->ioptm_pk_status, ['class'=>'form-control select2','placeholder' => '-', 'disabled'=>'']) !!}
                        </div>
                      </div>
                      <!-- /.form-group -->
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('ioptm_qk', 'Quality Knowledge') !!}
                          {!! Form::textarea('ioptm_qk', $pica->ioptm_qk, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                        </div>
                        <div class="col-sm-3">
                          {!! Form::label('ioptm_qk_status', 'Status Quality Knowledge') !!}
                          {!! Form::select('ioptm_qk_status', ['O' => 'OK Sesuai Standard', 'P' => 'Potensi Problem', 'N' => 'NG / Tidak Standard'], $pica->ioptm_qk_status, ['class'=>'form-control select2','placeholder' => '-', 'disabled'=>'']) !!}
                        </div>
                      </div>
                      <!-- /.form-group -->
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('ioptm_kp', 'Kesulitan Proses') !!}
                          {!! Form::textarea('ioptm_kp', $pica->ioptm_kp, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                        </div>
                        <div class="col-sm-3">
                          {!! Form::label('ioptm_kp_status', 'Status Kesulitan Proses') !!}
                          {!! Form::select('ioptm_kp_status', ['O' => 'OK Sesuai Standard', 'P' => 'Potensi Problem', 'N' => 'NG / Tidak Standard'], $pica->ioptm_kp_status, ['class'=>'form-control select2','placeholder' => '-', 'disabled'=>'']) !!}
                        </div>
                      </div>
                      <!-- /.form-group -->
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('ioptm_sr', 'SCW Rule') !!}
                          {!! Form::textarea('ioptm_sr', $pica->ioptm_sr, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                        </div>
                        <div class="col-sm-3">
                          {!! Form::label('ioptm_sr_status', 'SCW Rule') !!}
                          {!! Form::select('ioptm_sr_status', ['O' => 'OK Sesuai Standard', 'P' => 'Potensi Problem', 'N' => 'NG / Tidak Standard'], $pica->ioptm_sr_status, ['class'=>'form-control select2','placeholder' => '-', 'disabled'=>'']) !!}
                        </div>
                      </div>
                      <!-- /.form-group -->
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('ioptm_it', 'Ijiwaru Test') !!}
                          {!! Form::textarea('ioptm_it', $pica->ioptm_it, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                        </div>
                        <div class="col-sm-3">
                          {!! Form::label('ioptm_it_status', 'Status Ijiwaru Test') !!}
                          {!! Form::select('ioptm_it_status', ['O' => 'OK Sesuai Standard', 'P' => 'Potensi Problem', 'N' => 'NG / Tidak Standard'], $pica->ioptm_it_status, ['class'=>'form-control select2','placeholder' => '-', 'disabled'=>'']) !!}
                        </div>
                      </div>
                      <!-- /.form-group -->
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('ioptm_jd', 'Job Desc') !!}
                          {!! Form::textarea('ioptm_jd', $pica->ioptm_jd, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                        </div>
                        <div class="col-sm-3">
                          {!! Form::label('ioptm_jd_status', 'Status Job Desc') !!}
                          {!! Form::select('ioptm_jd_status', ['O' => 'OK Sesuai Standard', 'P' => 'Potensi Problem', 'N' => 'NG / Tidak Standard'], $pica->ioptm_jd_status, ['class'=>'form-control select2','placeholder' => '-', 'disabled'=>'']) !!}
                        </div>
                      </div>
                      <!-- /.form-group -->
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.tabpanel -->
                  <div role="tabpanel" class="tab-pane" id="hp">
                    <div class="box-body">
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('hp_pict', 'File Image') !!}
                          @if (!empty($pica->hp_pict))
                            <p>
                              <img src="{{ $pica->pict("hp_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                            </p>
                          @endif
                        </div>
                      </div>
                      <!-- /.form-group -->
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.tabpanel -->
                </div>
                <!-- /.tab-content -->
              </div>
              <div role="tabpanel" class="tab-pane" id="rca">
                <div class="box-body">
                  <div class="row form-group">
                    <div class="col-sm-5">
                      {!! Form::label('rca_why_occured', 'Why Occured') !!}
                      {!! Form::textarea('rca_why_occured', $pica->rca_why_occured, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                    </div>
                    <div class="col-sm-5">
                      {!! Form::label('rca_why_outflow', 'Why Out Flow') !!}
                      {!! Form::textarea('rca_why_outflow', $pica->rca_why_outflow, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                    </div>
                  </div>
                  <!-- /.form-group -->
                  <div class="row form-group">
                    <div class="col-sm-5">
                      {!! Form::label('rca_pict_occured', 'Ilustration Occured') !!}
                      @if (!empty($pica->rca_pict_occured))
                        <p>
                          <img src="{{ $pica->pict("rca_pict_occured") }}" alt="File Not Found" class="img-rounded img-responsive">
                        </p>
                      @endif
                    </div>
                    <div class="col-sm-5">
                      {!! Form::label('rca_pict_outflow', 'Ilustration Out Flow') !!}
                      @if (!empty($pica->rca_pict_outflow))
                        <p>
                          <img src="{{ $pica->pict("rca_pict_outflow") }}" alt="File Not Found" class="img-rounded img-responsive">
                        </p>
                      @endif
                    </div>
                  </div>
                  <!-- /.form-group -->
                  <div class="row form-group">
                    <div class="col-sm-5">
                      {!! Form::label('rca_root1', 'Root/Primary Causes of Problem (1)') !!}
                      {!! Form::textarea('rca_root1', $pica->rca_root1, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                    </div>
                    <div class="col-sm-5">
                      {!! Form::label('rca_root2', 'Root/Primary Causes of Problem (2)') !!}
                      {!! Form::textarea('rca_root2', $pica->rca_root2, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                    </div>
                  </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.tabpanel -->
              <div role="tabpanel" class="tab-pane" id="cop">
                <ul class="nav nav-tabs" role="tablist">
                  <li role="presentation" class="active">
                    <a href="#coptemp" aria-controls="coptemp" role="tab" data-toggle="tab">
                      <i class="fa fa-pencil-square-o"></i> A. Temporary Action
                    </a>
                  </li>
                  <li role="presentation">
                    <a href="#copperm" aria-controls="copperm" role="tab" data-toggle="tab">
                      <i class="fa fa-pencil-square-o"></i> B. Fix Countermeasure
                    </a>
                  </li>
                </ul>
                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane active" id="coptemp">
                    <div class="box-body">
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('cop_temp_action1', 'Temporary Action (1)') !!}
                          {!! Form::textarea('cop_temp_action1', $pica->cop_temp_action1, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                        </div>
                        <div class="col-sm-2">
                          {!! Form::label('cop_temp_action1_date', 'Tgl Temp. Action (1)') !!}
                          {!! Form::date('cop_temp_action1_date', $pica->cop_temp_action1_date, ['class'=>'form-control', 'disabled'=>'']) !!}
                        </div>
                        <div class="col-sm-5">
                          {!! Form::label('cop_temp_action1_pic', 'PIC Temp. Action (1)') !!}
                          {!! Form::text('cop_temp_action1_pic', $pica->cop_temp_action1_pic, ['class'=>'form-control', 'disabled'=>'', 'maxlength' => 50, 'style' => 'text-transform:uppercase']) !!}
                        </div>
                      </div>
                      <!-- /.form-group -->
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('cop_temp_action1_pict', 'Ilustration (1)') !!}
                          @if (!empty($pica->cop_temp_action1_pict))
                            <p>
                              <img src="{{ $pica->pict("cop_temp_action1_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                            </p>
                          @endif
                        </div>
                      </div>
                      <!-- /.form-group -->
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('cop_temp_action2', 'Temporary Action (2)') !!}
                          {!! Form::textarea('cop_temp_action2', $pica->cop_temp_action2, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                        </div>
                        <div class="col-sm-2">
                          {!! Form::label('cop_temp_action2_date', 'Tgl Temp. Action (2)') !!}
                          {!! Form::date('cop_temp_action2_date', $pica->cop_temp_action2_date, ['class'=>'form-control', 'disabled'=>'']) !!}
                        </div>
                        <div class="col-sm-5">
                          {!! Form::label('cop_temp_action2_pic', 'PIC Temp. Action (2)') !!}
                          {!! Form::text('cop_temp_action2_pic', $pica->cop_temp_action2_pic, ['class'=>'form-control', 'disabled'=>'', 'maxlength' => 50, 'style' => 'text-transform:uppercase']) !!}
                        </div>
                      </div>
                      <!-- /.form-group -->
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('cop_temp_action2_pict', 'Ilustration (2)') !!}
                          @if (!empty($pica->cop_temp_action2_pict))
                            <p>
                              <img src="{{ $pica->pict("cop_temp_action2_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                            </p>
                          @endif
                        </div>
                      </div>
                      <!-- /.form-group -->
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('cop_temp_action3', 'Temporary Action (3)') !!}
                          {!! Form::textarea('cop_temp_action3', $pica->cop_temp_action3, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                        </div>
                        <div class="col-sm-2">
                          {!! Form::label('cop_temp_action3_date', 'Tgl Temp. Action (3)') !!}
                          {!! Form::date('cop_temp_action3_date', $pica->cop_temp_action3_date, ['class'=>'form-control', 'disabled'=>'']) !!}
                        </div>
                        <div class="col-sm-5">
                          {!! Form::label('cop_temp_action3_pic', 'PIC Temp. Action (3)') !!}
                          {!! Form::text('cop_temp_action3_pic', $pica->cop_temp_action3_pic, ['class'=>'form-control', 'disabled'=>'', 'maxlength' => 50, 'style' => 'text-transform:uppercase']) !!}
                        </div>
                      </div>
                      <!-- /.form-group -->
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('cop_temp_action3_pict', 'Ilustration (3)') !!}
                          @if (!empty($pica->cop_temp_action3_pict))
                            <p>
                              <img src="{{ $pica->pict("cop_temp_action3_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                            </p>
                          @endif
                        </div>
                      </div>
                      <!-- /.form-group -->
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('cop_temp_action4', 'Temporary Action (4)') !!}
                          {!! Form::textarea('cop_temp_action4', $pica->cop_temp_action4, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                        </div>
                        <div class="col-sm-2">
                          {!! Form::label('cop_temp_action4_date', 'Tgl Temp. Action (4)') !!}
                          {!! Form::date('cop_temp_action4_date', $pica->cop_temp_action4_date, ['class'=>'form-control', 'disabled'=>'']) !!}
                        </div>
                        <div class="col-sm-5">
                          {!! Form::label('cop_temp_action4_pic', 'PIC Temp. Action (4)') !!}
                          {!! Form::text('cop_temp_action4_pic', $pica->cop_temp_action4_pic, ['class'=>'form-control', 'disabled'=>'', 'maxlength' => 50, 'style' => 'text-transform:uppercase']) !!}
                        </div>
                      </div>
                      <!-- /.form-group -->
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('cop_temp_action4_pict', 'Ilustration (4)') !!}
                          @if (!empty($pica->cop_temp_action4_pict))
                            <p>
                              <img src="{{ $pica->pict("cop_temp_action4_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                            </p>
                          @endif
                        </div>
                      </div>
                      <!-- /.form-group -->
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('cop_temp_action5', 'Temporary Action (5)') !!}
                          {!! Form::textarea('cop_temp_action5', $pica->cop_temp_action5, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                        </div>
                        <div class="col-sm-2">
                          {!! Form::label('cop_temp_action5_date', 'Tgl Temp. Action (5)') !!}
                          {!! Form::date('cop_temp_action5_date', $pica->cop_temp_action5_date, ['class'=>'form-control', 'disabled'=>'']) !!}
                        </div>
                        <div class="col-sm-5">
                          {!! Form::label('cop_temp_action5_pic', 'PIC Temp. Action (5)') !!}
                          {!! Form::text('cop_temp_action5_pic', $pica->cop_temp_action5_pic, ['class'=>'form-control', 'disabled'=>'', 'maxlength' => 50, 'style' => 'text-transform:uppercase']) !!}
                        </div>
                      </div>
                      <!-- /.form-group -->
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('cop_temp_action5_pict', 'Ilustration (5)') !!}
                          @if (!empty($pica->cop_temp_action5_pict))
                            <p>
                              <img src="{{ $pica->pict("cop_temp_action5_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                            </p>
                          @endif
                        </div>
                      </div>
                      <!-- /.form-group -->
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.tabpanel -->
                  <div role="tabpanel" class="tab-pane" id="copperm">
                    <div class="box-body">
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('cop_fix_action1', 'Fix Countermeasure (1)') !!}
                          {!! Form::textarea('cop_fix_action1', $pica->cop_fix_action1, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                        </div>
                        <div class="col-sm-2">
                          {!! Form::label('cop_fix_action1_date', 'Tgl FC (1)') !!}
                          {!! Form::date('cop_fix_action1_date', $pica->cop_fix_action1_date, ['class'=>'form-control', 'disabled'=>'']) !!}
                        </div>
                        <div class="col-sm-5">
                          {!! Form::label('cop_fix_action1_pic', 'PIC FC (1)') !!}
                          {!! Form::text('cop_fix_action1_pic', $pica->cop_fix_action1_pic, ['class'=>'form-control', 'disabled'=>'', 'maxlength' => 50, 'style' => 'text-transform:uppercase']) !!}
                        </div>
                      </div>
                      <!-- /.form-group -->
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('cop_fix_action1_pict', 'Ilustration (1)') !!}
                          @if (!empty($pica->cop_fix_action1_pict))
                            <p>
                              <img src="{{ $pica->pict("cop_fix_action1_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                            </p>
                          @endif
                        </div>
                      </div>
                      <!-- /.form-group -->
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('cop_fix_action2', 'Fix Countermeasure (2)') !!}
                          {!! Form::textarea('cop_fix_action2', $pica->cop_fix_action2, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                        </div>
                        <div class="col-sm-2">
                          {!! Form::label('cop_fix_action2_date', 'Tgl FC (2)') !!}
                          {!! Form::date('cop_fix_action2_date', $pica->cop_fix_action2_date, ['class'=>'form-control', 'disabled'=>'']) !!}
                        </div>
                        <div class="col-sm-5">
                          {!! Form::label('cop_fix_action2_pic', 'PIC FC (2)') !!}
                          {!! Form::text('cop_fix_action2_pic', $pica->cop_fix_action2_pic, ['class'=>'form-control', 'disabled'=>'', 'maxlength' => 50, 'style' => 'text-transform:uppercase']) !!}
                        </div>
                      </div>
                      <!-- /.form-group -->
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('cop_fix_action2_pict', 'Ilustration (2)') !!}
                          @if (!empty($pica->cop_fix_action2_pict))
                            <p>
                              <img src="{{ $pica->pict("cop_fix_action2_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                            </p>
                          @endif
                        </div>
                      </div>
                      <!-- /.form-group -->
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('cop_fix_action3', 'Fix Countermeasure (3)') !!}
                          {!! Form::textarea('cop_fix_action3', $pica->cop_fix_action3, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                        </div>
                        <div class="col-sm-2">
                          {!! Form::label('cop_fix_action3_date', 'Tgl FC (3)') !!}
                          {!! Form::date('cop_fix_action3_date', $pica->cop_fix_action3_date, ['class'=>'form-control', 'disabled'=>'']) !!}
                        </div>
                        <div class="col-sm-5">
                          {!! Form::label('cop_fix_action3_pic', 'PIC FC (3)') !!}
                          {!! Form::text('cop_fix_action3_pic', $pica->cop_fix_action3_pic, ['class'=>'form-control', 'disabled'=>'', 'maxlength' => 50, 'style' => 'text-transform:uppercase']) !!}
                        </div>
                      </div>
                      <!-- /.form-group -->
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('cop_fix_action3_pict', 'Ilustration (3)') !!}
                          @if (!empty($pica->cop_fix_action3_pict))
                            <p>
                              <img src="{{ $pica->pict("cop_fix_action3_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                            </p>
                          @endif
                        </div>
                      </div>
                      <!-- /.form-group -->
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('cop_fix_action4', 'Fix Countermeasure (4)') !!}
                          {!! Form::textarea('cop_fix_action4', $pica->cop_fix_action4, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                        </div>
                        <div class="col-sm-2">
                          {!! Form::label('cop_fix_action4_date', 'Tgl FC (4)') !!}
                          {!! Form::date('cop_fix_action4_date', $pica->cop_fix_action4_date, ['class'=>'form-control', 'disabled'=>'']) !!}
                        </div>
                        <div class="col-sm-5">
                          {!! Form::label('cop_fix_action4_pic', 'PIC FC (4)') !!}
                          {!! Form::text('cop_fix_action4_pic', $pica->cop_fix_action4_pic, ['class'=>'form-control', 'disabled'=>'', 'maxlength' => 50, 'style' => 'text-transform:uppercase']) !!}
                        </div>
                      </div>
                      <!-- /.form-group -->
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('cop_fix_action4_pict', 'Ilustration (4)') !!}
                          @if (!empty($pica->cop_fix_action4_pict))
                            <p>
                              <img src="{{ $pica->pict("cop_fix_action4_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                            </p>
                          @endif
                        </div>
                      </div>
                      <!-- /.form-group -->
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('cop_fix_action5', 'Fix Countermeasure (5)') !!}
                          {!! Form::textarea('cop_fix_action5', $pica->cop_fix_action5, ['class'=>'form-control', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                        </div>
                        <div class="col-sm-2">
                          {!! Form::label('cop_fix_action5_date', 'Tgl FC (5)') !!}
                          {!! Form::date('cop_fix_action5_date', $pica->cop_fix_action5_date, ['class'=>'form-control', 'disabled'=>'']) !!}
                        </div>
                        <div class="col-sm-5">
                          {!! Form::label('cop_fix_action5_pic', 'PIC FC (5)') !!}
                          {!! Form::text('cop_fix_action5_pic', $pica->cop_fix_action5_pic, ['class'=>'form-control', 'disabled'=>'', 'maxlength' => 50, 'style' => 'text-transform:uppercase']) !!}
                        </div>
                      </div>
                      <!-- /.form-group -->
                      <div class="row form-group">
                        <div class="col-sm-5">
                          {!! Form::label('cop_fix_action5_pict', 'Ilustration (5)') !!}
                          @if (!empty($pica->cop_fix_action5_pict))
                            <p>
                              <img src="{{ $pica->pict("cop_fix_action5_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                            </p>
                          @endif
                        </div>
                      </div>
                      <!-- /.form-group -->
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.tabpanel -->
                </div>
                <!-- /.tab-content -->
              </div>
              <!-- /.tabpanel -->
              <div role="tabpanel" class="tab-pane" id="fpimp">
                <div class="box-body">
                  <div class="row form-group">
                    <div class="col-sm-5">
                      {!! Form::label('fp_improve_pict', 'Flow Process After Improvement') !!}
                      @if (!empty($pica->fp_improve_pict))
                        <p>
                          <img src="{{ $pica->pict("fp_improve_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                        </p>
                      @endif
                    </div>
                  </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.tabpanel -->
              <div role="tabpanel" class="tab-pane" id="evaluation">
                <div class="box-body">
                  <div class="row form-group">
                    <div class="col-sm-5">
                      {!! Form::label('evaluation', 'Evaluation') !!}
                      {!! Form::textarea('evaluation', $pica->evaluation, ['class'=>'form-control', 'rows' => '7', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                    </div>
                    <div class="col-sm-5">
                      {!! Form::label('evaluation_pict', 'File Image') !!}
                      @if (!empty($pica->evaluation_pict))
                        <p>
                          <img src="{{ $pica->pict("evaluation_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                        </p>
                      @endif
                    </div>
                  </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.tabpanel -->
              <div role="std" class="tab-pane" id="std">
                <div class="box-body">
                  <div class="row form-group">
                    <div class="col-sm-1">
                      @if (empty($pica->std_sop))
                        {!! Form::checkbox('std_sop', 'T', null, ['disabled'=>'']) !!} SOP
                      @else
                        @if ($pica->std_sop === "T")
                          {!! Form::checkbox('std_sop', 'T', true, ['disabled'=>'']) !!} SOP
                        @else
                          {!! Form::checkbox('std_sop', 'T', false, ['disabled'=>'']) !!} SOP
                        @endif
                      @endif
                    </div>
                    <div class="col-sm-2">
                      @if (empty($pica->std_point))
                        {!! Form::checkbox('std_point', 'T', null, ['disabled'=>'']) !!} Point Penting
                      @else
                        @if ($pica->std_point === "T")
                          {!! Form::checkbox('std_point', 'T', true, ['disabled'=>'']) !!} Point Penting
                        @else
                          {!! Form::checkbox('std_point', 'T', false, ['disabled'=>'']) !!} Point Penting
                        @endif
                      @endif
                    </div>
                  </div>
                  <!-- /.form-group -->
                  <div class="row form-group">
                    <div class="col-sm-1">
                      @if (empty($pica->std_wi))
                        {!! Form::checkbox('std_wi', 'T', null, ['disabled'=>'']) !!} WI
                      @else
                        @if ($pica->std_wi === "T")
                          {!! Form::checkbox('std_wi', 'T', true, ['disabled'=>'']) !!} WI
                        @else
                          {!! Form::checkbox('std_wi', 'T', false, ['disabled'=>'']) !!} WI
                        @endif
                      @endif
                    </div>
                    <div class="col-sm-2">
                      @if (empty($pica->std_warning))
                        {!! Form::checkbox('std_warning', 'T', null, ['disabled'=>'']) !!} Warning
                      @else
                        @if ($pica->std_warning === "T")
                          {!! Form::checkbox('std_warning', 'T', true, ['disabled'=>'']) !!} Warning
                        @else
                          {!! Form::checkbox('std_warning', 'T', false, ['disabled'=>'']) !!} Warning
                        @endif
                      @endif
                    </div>
                  </div>
                  <!-- /.form-group -->
                  <div class="row form-group">
                    <div class="col-sm-1">
                      @if (empty($pica->std_qcpc))
                        {!! Form::checkbox('std_qcpc', 'T', null, ['disabled'=>'']) !!} QCPC
                      @else
                        @if ($pica->std_qcpc === "T")
                          {!! Form::checkbox('std_qcpc', 'T', true, ['disabled'=>'']) !!} QCPC
                        @else
                          {!! Form::checkbox('std_qcpc', 'T', false, ['disabled'=>'']) !!} QCPC
                        @endif
                      @endif
                    </div>
                    <div class="col-sm-2">
                      @if (empty($pica->std_check_sheet))
                        {!! Form::checkbox('std_check_sheet', 'T', null, ['disabled'=>'']) !!} Check Sheet
                      @else
                        @if ($pica->std_check_sheet === "T")
                          {!! Form::checkbox('std_check_sheet', 'T', true, ['disabled'=>'']) !!} Check Sheet
                        @else
                          {!! Form::checkbox('std_check_sheet', 'T', false, ['disabled'=>'']) !!} Check Sheet
                        @endif
                      @endif
                    </div>
                  </div>
                  <!-- /.form-group -->
                  <div class="row form-group">
                    <div class="col-sm-1">
                      @if (empty($pica->std_fmea))
                        {!! Form::checkbox('std_fmea', 'T', null, ['disabled'=>'']) !!} FMEA
                      @else
                        @if ($pica->std_fmea === "T")
                          {!! Form::checkbox('std_fmea', 'T', true, ['disabled'=>'']) !!} FMEA
                        @else
                          {!! Form::checkbox('std_fmea', 'T', false, ['disabled'=>'']) !!} FMEA
                        @endif
                      @endif
                    </div>
                    <div class="col-sm-2">
                      @if (empty($pica->std_others))
                        {!! Form::checkbox('std_others', 'T', null, ['disabled'=>'']) !!} Others
                      @else
                        @if ($pica->std_others === "T")
                          {!! Form::checkbox('std_others', 'T', true, ['disabled'=>'']) !!} Others
                        @else
                          {!! Form::checkbox('std_others', 'T', false, ['disabled'=>'']) !!} Others
                        @endif
                      @endif
                    </div>
                  </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.tabpanel -->
              <div role="yokotenkai" class="tab-pane" id="yokotenkai">
                <div class="box-body">
                  <div class="row form-group">
                    <div class="col-sm-5">
                      {!! Form::label('yokotenkai', 'Yokotenkai') !!}
                      {!! Form::textarea('yokotenkai', $pica->yokotenkai, ['class'=>'form-control', 'rows' => '7', 'maxlength' => 500, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                    </div>
                  </div>
                  <!-- /.form-group -->
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
      @if ($pica->kd_supp == Auth::user()->kd_supp)
        <div class="box-footer">
        @if ($pica->status === 'DRAFT')
          @if (Auth::user()->can(['pica-create','pica-submit']))
            <a class="btn btn-primary" href="{{ route('picas.edit', base64_encode($pica->id)) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
            &nbsp;&nbsp;
          @endif
          @if (Auth::user()->can('pica-delete'))
            <button id="btn-delete" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data">Hapus Data</button>
            &nbsp;&nbsp;
          @endif
        @elseif ($pica->status === 'REJECT')
          @if (Auth::user()->can(['pica-create','pica-submit']))
            <button id='btnrevisi' type='button' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Revisi PICA {{ $pica->no_pica }}' onclick='revisiPica("{{ $pica->no_pica }}")'>
              <span class='glyphicon glyphicon-repeat'></span> Revisi PICA
            </button>
            &nbsp;&nbsp;
          @endif
        @endif
        <a target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Print PICA {{ $pica->no_pica }}" href="{{ route('picas.print', base64_encode($pica->id)) }}"><span class='glyphicon glyphicon-print'></span> Print PICA</a>
          &nbsp;&nbsp;
        <a class="btn btn-primary" href="{{ route('picas.index') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard PICA">Cancel</a>
        </div>
      @endif
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  function revisiPica(no_pica)
  {
    var msg = 'Anda yakin membuat Revisi data ini?';
    var txt = 'No. PICA: ' + no_pica;
    //additional input validations can be done hear
    swal({
      title: msg,
      text: txt,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, revisi it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      var urlRedirect = "{{ route('picas.revisi', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_pica));
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

  $("#btn-delete").click(function(){
    var no_pica = "{{ $pica->no_pica }}";
    var msg = 'Anda yakin menghapus data ini?';
    var txt = 'No. PICA: ' + no_pica;
    //additional input validations can be done hear
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
      var urlRedirect = "{{ route('picas.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_pica));
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
</script>
@endsection