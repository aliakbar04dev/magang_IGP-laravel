@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        PICA DEPR
        <small>Detail PICA DEPR</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> PPC - Transaksi</li>
        <li><a href="{{ route('ppctdprpicas.all') }}"><i class="fa fa-exchange"></i> PICA DEPR</a></li>
        <li class="active">Detail {{ $ppctdprpica->no_dpr }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detail PICA DEPR</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%" style="table-layout: fixed">
                <tbody>
                  <tr>
                    <td style="width: 10%;"><b>No. PICA DEPR</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">{{ $ppctdprpica->no_dpr }}</td>
                    <td style="width: 10%;"><b>Tgl PICA DEPR</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ \Carbon\Carbon::parse($ppctdprpica->tgl_rev)->format('d/m/Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>No. DEPR</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">
                      <a href="{{ route('ppctdprs.show', base64_encode($ppctdprpica->no_dpr)) }}" data-toggle="tooltip" data-placement="top" title="Show Detail DEPR {{ $ppctdprpica->no_dpr }}">{{ $ppctdprpica->no_dpr }}</a>
                    </td>
                    <td style="width: 10%;"><b>No. Revisi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      {{ $ppctdprpica->no_rev }}
                    </td>
                  </tr>
                  @if (!empty($ppctdprpica->submit_tgl))
                    <tr>
                      <td style="width: 10%;"><b>Tgl Submit</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        @if (!empty($ppctdprpica->submit_tgl))
                          {{ \Carbon\Carbon::parse($ppctdprpica->submit_tgl)->format('d/m/Y H:i') }}
                        @endif  
                      </td>
                      <td style="width: 10%;"><b>PIC Submit</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $ppctdprpica->submit_pic." - ".$ppctdprpica->nama($ppctdprpica->submit_pic) }}</td>
                    </tr>
                  @endif
                  @if (!empty($ppctdprpica->prc_dtaprov))
                    <tr>
                      <td style="width: 10%;"><b>Tgl Approve</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        @if (!empty($ppctdprpica->prc_dtaprov))
                          {{ \Carbon\Carbon::parse($ppctdprpica->prc_dtaprov)->format('d/m/Y H:i') }}
                        @endif  
                      </td>
                      <td style="width: 10%;"><b>PIC Approve</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $ppctdprpica->prc_aprov." - ".$ppctdprpica->nama($ppctdprpica->prc_aprov) }}</td>
                    </tr>
                  @endif
                  @if (!empty($ppctdprpica->prc_dtreject))
                    <tr>
                      <td style="width: 10%;"><b>Tgl Reject</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        @if (!empty($ppctdprpica->prc_dtreject))
                          {{ \Carbon\Carbon::parse($ppctdprpica->prc_dtreject)->format('d/m/Y H:i') }}
                        @endif  
                      </td>
                      <td style="width: 10%;"><b>PIC Reject</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $ppctdprpica->prc_reject." - ".$ppctdprpica->nama($ppctdprpica->prc_reject) }}</td>
                    </tr>
                    <tr>
                      <td style="width: 10%;"><b>Ket. Reject</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4" style="word-wrap: break-word">{{ $ppctdprpica->prc_ketreject }}</td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
            
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active">
                <a href="#pc" aria-controls="pc" role="tab" data-toggle="tab" title="Problem Cause">
                  I. Problem Cause
                </a>
              </li>
              <li role="presentation">
                <a href="#ta" aria-controls="ta" role="tab" data-toggle="tab" title="Temporary Action">
                  II. Temporary Action
                </a>
              </li>
              <li role="presentation">
                <a href="#cm" aria-controls="cm" role="tab" data-toggle="tab" title="Countermeasure">
                  III. Countermeasure
                </a>
              </li>
              <li role="presentation">
                <a href="#is" aria-controls="is" role="tab" data-toggle="tab" title="Improvement Suggestion">
                  IV. Improvement Suggestion
                </a>
              </li>
              <li role="presentation">
                <a href="#oth" aria-controls="oth" role="tab" data-toggle="tab" title="Others">
                  V. Others
                </a>
              </li>
            </ul>
            <!-- /.tablist -->

            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="pc">
                <div class="box-body">
                  <div class="row form-group">
                    <div class="col-sm-6">
                      {!! Form::label('pc_man', 'Man (*)') !!}
                      {!! Form::textarea('pc_man', $ppctdprpica->pc_man, ['class'=>'form-control', 'placeholder' => 'Man', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'required', 'readonly' => 'readonly']) !!}
                    </div>
                    <div class="col-sm-6">
                      {!! Form::label('pc_material', 'Material (*)') !!}
                      {!! Form::textarea('pc_material', $ppctdprpica->pc_material, ['class'=>'form-control', 'placeholder' => 'Material', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'required', 'readonly' => 'readonly']) !!}
                    </div>
                  </div>
                  <!-- /.form-group -->
                  <div class="row form-group">
                    <div class="col-sm-6">
                      {!! Form::label('pc_machine', 'Machine (*)') !!}
                      {!! Form::textarea('pc_machine', $ppctdprpica->pc_machine, ['class'=>'form-control', 'placeholder' => 'Machine', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'required', 'readonly' => 'readonly']) !!}
                    </div>
                    <div class="col-sm-6">
                      {!! Form::label('pc_metode', 'Methode (*)') !!}
                      {!! Form::textarea('pc_metode', $ppctdprpica->pc_metode, ['class'=>'form-control', 'placeholder' => 'Methode', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'required', 'readonly' => 'readonly']) !!}
                    </div>
                  </div>
                  <!-- /.form-group -->
                  <div class="row form-group">
                    <div class="col-sm-6">
                      {!! Form::label('pc_environ', 'Environment (*)') !!}
                      {!! Form::textarea('pc_environ', $ppctdprpica->pc_environ, ['class'=>'form-control', 'placeholder' => 'Environment', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'required', 'readonly' => 'readonly']) !!}
                    </div>
                  </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.tabpanel -->
              <div role="tabpanel" class="tab-pane" id="ta">
                <div class="box-body">
                  <div class="row form-group">
                    <div class="col-sm-6">
                      {!! Form::label('ta_ket', 'Temporary Action (*)') !!}
                      {!! Form::textarea('ta_ket', $ppctdprpica->ta_ket, ['class'=>'form-control', 'placeholder' => 'Temporary Action', 'rows' => '5', 'maxlength' => 500, 'style' => 'resize:vertical', 'required', 'readonly' => 'readonly']) !!}
                    </div>
                    <div class="col-sm-6">
                      {!! Form::label('ta_pict', 'File Image (jpeg,png,jpg)') !!}
                      @if (!empty($ppctdprpica->ta_pict))
                        <p>
                          <img src="{{ $ppctdprpica->taPict() }}" alt="File Not Found" class="img-rounded img-responsive">
                        </p>
                      @endif
                    </div>
                  </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.tabpanel -->
              <div role="tabpanel" class="tab-pane" id="cm">
                <div class="box-body">
                  <div class="row form-group">
                    <div class="col-sm-6">
                      {!! Form::label('cm_ket', 'Countermeasure (*)') !!}
                      {!! Form::textarea('cm_ket', $ppctdprpica->cm_ket, ['class'=>'form-control', 'placeholder' => 'Countermeasure', 'rows' => '5', 'maxlength' => 500, 'style' => 'resize:vertical', 'required', 'readonly' => 'readonly']) !!}
                    </div>
                    <div class="col-sm-6">
                      {!! Form::label('cm_pict', 'File Image (jpeg,png,jpg)') !!}
                      @if (!empty($ppctdprpica->cm_pict))
                        <p>
                          <img src="{{ $ppctdprpica->cmPict() }}" alt="File Not Found" class="img-rounded img-responsive">
                        </p>
                      @endif
                    </div>
                  </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.tabpanel -->
              <div role="tabpanel" class="tab-pane" id="is">
                <div class="box-body">
                  <div class="row form-group">
                    <div class="col-sm-6">
                      {!! Form::label('is_man', 'Man (*)') !!}
                      {!! Form::textarea('is_man', $ppctdprpica->is_man, ['class'=>'form-control', 'placeholder' => 'Man', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'required', 'readonly' => 'readonly']) !!}
                    </div>
                    <div class="col-sm-6">
                      {!! Form::label('is_material', 'Material (*)') !!}
                      {!! Form::textarea('is_material', $ppctdprpica->is_material, ['class'=>'form-control', 'placeholder' => 'Material', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'required', 'readonly' => 'readonly']) !!}
                    </div>
                  </div>
                  <!-- /.form-group -->
                  <div class="row form-group">
                    <div class="col-sm-6">
                      {!! Form::label('is_machine', 'Machine (*)') !!}
                      {!! Form::textarea('is_machine', $ppctdprpica->is_machine, ['class'=>'form-control', 'placeholder' => 'Machine', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'required', 'readonly' => 'readonly']) !!}
                    </div>
                    <div class="col-sm-6">
                      {!! Form::label('is_metode', 'Methode (*)') !!}
                      {!! Form::textarea('is_metode', $ppctdprpica->is_metode, ['class'=>'form-control', 'placeholder' => 'Methode', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'required', 'readonly' => 'readonly']) !!}
                    </div>
                  </div>
                  <!-- /.form-group -->
                  <div class="row form-group">
                    <div class="col-sm-6">
                      {!! Form::label('is_environ', 'Environment (*)') !!}
                      {!! Form::textarea('is_environ', $ppctdprpica->is_environ, ['class'=>'form-control', 'placeholder' => 'Environment', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'required', 'readonly' => 'readonly']) !!}
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
                    <div class="col-sm-6">
                      {!! Form::label('rem_ket', 'Remarks (*)') !!}
                      {!! Form::textarea('rem_ket', $ppctdprpica->rem_ket, ['class'=>'form-control', 'placeholder' => 'Remarks', 'rows' => '5', 'maxlength' => 500, 'style' => 'resize:vertical', 'required', 'readonly' => 'readonly']) !!}
                    </div>
                    <div class="col-sm-6">
                      {!! Form::label('rem_pict', 'File Image (jpeg,png,jpg)') !!}
                      @if (!empty($ppctdprpica->rem_pict))
                        <p>
                          <img src="{{ $ppctdprpica->remPict() }}" alt="File Not Found" class="img-rounded img-responsive">
                        </p>
                      @endif
                    </div>
                  </div>
                  <!-- /.form-group -->
                  <div class="row form-group">
                    <div class="col-sm-6">
                      {!! Form::label('com_ket', 'Comment (*)') !!}
                      {!! Form::textarea('com_ket', $ppctdprpica->com_ket, ['class'=>'form-control', 'placeholder' => 'Comment', 'rows' => '5', 'maxlength' => 500, 'style' => 'resize:vertical', 'required', 'readonly' => 'readonly']) !!}
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
      <div class="box-footer">
        @if (Auth::user()->can(['ppc-dpr-*']))
          <a class="btn btn-primary" href="{{ route('ppctdprpicas.all') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard PICA DEPR">Kembali ke Dashboard PICA DEPR</a>
        @else
          <a class="btn btn-primary" href="{{ route('ppctdprpicas.index') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard PICA DEPR">Kembali ke Dashboard PICA DEPR</a>
        @endif
        &nbsp;&nbsp;
        <a class="btn btn-primary" href="#" onclick="window.open('', '_self', ''); window.close();" data-toggle="tooltip" data-placement="top" title="Close Tab">Close</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection