{!! Form::hidden('st_submit', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'st_submit']) !!}
{!! Form::hidden('status', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'status']) !!}
{!! Form::hidden('st_input', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'st_input']) !!}
<div class="box-body box-profile">
  <img src="{{ $hrdtidpdep1->fotoKaryawan() }}" class="profile-user-img img-responsive img-circle" alt="User profile picture">
  <p class="text-muted text-center"></p>
  <table class="table table-striped" cellspacing="0" width="100%">
    <tbody>
      <tr>
        <td style="width: 12%;"><b>Year</b></td>
        <td style="width: 1%;"><b>:</b></td>
        <td style="width: 20%;">
          {{ $hrdtidpdep1->tahun }}
          {!! Form::hidden('year', $hrdtidpdep1->tahun, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'year']) !!}
          {!! Form::hidden('id', base64_encode($hrdtidpdep1->id), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'id']) !!}
        </td>
        <td style="width: 13%;"><b>Revisi</b></td>
        <td style="width: 1%;"><b>:</b></td>
        <td>
          {{ $hrdtidpdep1->revisi }}
        </td>
      </tr>
      <tr>
        <td style="width: 12%;"><b>NPK / Name</b></td>
        <td style="width: 1%;"><b>:</b></td>
        <td style="width: 20%;">
          {{ $hrdtidpdep1->npk." - ".$hrdtidpdep1->masKaryawan($hrdtidpdep1->npk)->nama }}
        </td>
        <td style="width: 13%;"><b>Level & Sub Level</b></td>
        <td style="width: 1%;"><b>:</b></td>
        <td>
          {{ $hrdtidpdep1->kd_gol }}
        </td>
      </tr>
      <tr>
        <td style="width: 12%;"><b>Company</b></td>
        <td style="width: 1%;"><b>:</b></td>
        <td style="width: 20%;">
          {{ $hrdtidpdep1->kd_pt." - ".$hrdtidpdep1->nm_pt }}
        </td>
        <td style="width: 13%;"><b>Div / Department</b></td>
        <td style="width: 1%;"><b>:</b></td>
        <td>
          {{ $hrdtidpdep1->kd_div." - ".$hrdtidpdep1->namaDivisi($hrdtidpdep1->kd_div) }} / {{ $hrdtidpdep1->kd_dep." - ".$hrdtidpdep1->namaDepartemen($hrdtidpdep1->kd_dep) }}
        </td>
      </tr>
      <tr>
        <td style="width: 12%;"><b>Current Position</b></td>
        <td style="width: 1%;"><b>:</b></td>
        <td style="width: 20%;">
          {{ $hrdtidpdep1->cur_pos }}
        </td>
        <td style="width: 13%;"><b>Projected Position</b></td>
        <td style="width: 1%;"><b>:</b></td>
        <td>
          {{ $hrdtidpdep1->proj_pos }}
        </td>
      </tr>
      <tr>
        <td style="width: 12%;"><b>Date of Birth</b></td>
        <td style="width: 1%;"><b>:</b></td>
        <td style="width: 20%;">
          {{ \Carbon\Carbon::parse($hrdtidpdep1->masKaryawan($hrdtidpdep1->npk)->tgl_lahir)->format('d/m/Y') }}
        </td>
        <td style="width: 13%;"><b>Date Entry in Astra</b></td>
        <td style="width: 1%;"><b>:</b></td>
        <td>
          {{ \Carbon\Carbon::parse($hrdtidpdep1->masKaryawan($hrdtidpdep1->npk)->tgl_masuk_gkd)->format('d/m/Y') }}
        </td>
      </tr>
      <tr>
        <td style="width: 8%;"><b>Status</b></td>
        <td style="width: 1%;"><b>:</b></td>
        <td colspan="4">{{ $hrdtidpdep1->status }}</td>
      </tr>
    </tbody>
  </table>
</div>
<!-- /.box-body -->

<div class="box-body">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary{{ $hrdtidpdep1->status !== "DRAFT" ? " collapsed-box" : "" }}">
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
          <div class="form-group">
            <div class="col-sm-3">
              <select id="select_alc" name="select_alc" aria-controls="filter_status" class="form-control select2" onchange="changeAlc()" @if ($hrdtidpdep1->status !== "DRAFT") disabled="" @endif>
                <option value="-">Pilih Kompetensi</option>
                <option value="VISION & BUSINESS SENSE">Vision & Business Sense</option>
                <option value="CUSTOMER FOCUS">Customer Focus</option>
                <option value="INTERPERSONAL SKILL">Interpersonal Skill</option>
                <option value="ANALYSIS & JUDGEMENT">Analysis & Judgement</option>
                <option value="PLANNING & DRIVING ACTION">Planning & Driving Action</option>
                <option value="LEADING & MOTIVATING">Leading & Motivating</option>
                <option value="TEAM WORK">Team Work</option>
                <option value="DRIVE, COURAGE & INTEGRITY">Drive, Courage & Integrity</option>
              </select>
            </div>
            <div class="col-sm-9">
              <button id="btn-strength" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Strength" @if ($hrdtidpdep1->status !== "DRAFT") disabled="" @endif>Add Strength</button>
              &nbsp;
              <button id="btn-weakness" type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Add Development" @if ($hrdtidpdep1->status !== "DRAFT") disabled="" @endif>Add Development</button>
            </div>
          </div>
          <!-- /.form-group -->
          @if ($hrdtidpdep1->status === "DRAFT") 
            <div class="form-group">
              <div class="col-sm-12">
                {!! Form::label('alc_deskripsi', ' ', ['id'=>'alc_deskripsi']) !!}
              </div>
            </div>
            <!-- /.form-group -->
          @endif 
        </div>
        <!-- /.box-body -->
        <div class="col-md-6">
          <div class="box-body" id="field-alc-s">
            @foreach ($hrdtidpdep1->hrdtIdpdep2sByStatus("S")->get() as $model)
              <div class="row" id="field_s_{{ $loop->iteration }}">
                <div class="col-md-12">
                  <div class="box box-primary{{ $hrdtidpdep1->status !== "DRAFT" ? " collapsed-box" : "" }}">
                    <div class="box-header with-border">
                      <h3 class="box-title" id="box_s_{{ $loop->iteration }}">{{ $model->alc }} (Strength-{{ $loop->iteration }})</h3>
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                          <i class="fa fa-minus"></i>
                        </button>
                        @if ($hrdtidpdep1->status === "DRAFT" && ($hrdtidpdep1->npk_div_head === \Auth::user()->username))
                          <button id="btndeletealc_s_{{ $loop->iteration }}" name="btndeletealc_s_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Kompetensi" onclick="deleteKategori(this,'s')">
                            <i class="fa fa-times"></i>
                          </button>
                        @else 
                          <button id="btndeletealc_s_{{ $loop->iteration }}" name="btndeletealc_s_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Kompetensi" onclick="deleteKategori(this,'s')" disabled="">
                            <i class="fa fa-times"></i>
                          </button>
                        @endif
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div class="row form-group">
                        <div class="col-sm-10">
                          @if ($hrdtidpdep1->status === "DRAFT" && ($hrdtidpdep1->npk_div_head === \Auth::user()->username))
                            <textarea id="deskripsi_s_{{ $loop->iteration }}" name="deskripsi_s_{{ $loop->iteration }}" required class="form-control" placeholder="Keterangan (*)" rows="5" maxlength="2000" style="resize:vertical" readonly="readonly">{{ $model->deskripsi }}</textarea>
                          @else 
                            <textarea id="deskripsi_s_{{ $loop->iteration }}" name="deskripsi_s_{{ $loop->iteration }}" required class="form-control" placeholder="Keterangan (*)" rows="5" maxlength="2000" style="resize:vertical" readonly="readonly">{{ $model->deskripsi }}</textarea>
                          @endif
                          <input type="hidden" id="hrdt_idpdep2_id_s_{{ $loop->iteration }}" name="hrdt_idpdep2_id_s_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ base64_encode($model->id) }}">
                          <input type="hidden" id="alc_s_{{ $loop->iteration }}" name="alc_s_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ $model->alc }}">
                        </div>
                        <div class="col-sm-1 pull-left">
                          @if ($hrdtidpdep1->status === "DRAFT" && ($hrdtidpdep1->npk_div_head === \Auth::user()->username))
                            <button id="btnpopupdeskripsi_s_{{ $loop->iteration }}" name="btnpopupdeskripsi_s_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih Value" onclick="popupAlc(this,'s')" data-toggle="modal" data-target="#alcModal"><span class="glyphicon glyphicon-search"></span></button>
                          @else 
                            <button id="btnpopupdeskripsi_s_{{ $loop->iteration }}" name="btnpopupdeskripsi_s_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih Value" onclick="popupAlc(this,'s')" data-toggle="modal" data-target="#alcModal" disabled=""><span class="glyphicon glyphicon-search"></span></button>
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
            {!! Form::hidden('jml_row_s', $hrdtidpdep1->hrdtIdpdep2sByStatus("S")->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_s']) !!}
          </div>
        </div>
        <div class="col-md-6">
          <div class="box-body" id="field-alc-w">
            @foreach ($hrdtidpdep1->hrdtIdpdep2sByStatus("W")->get() as $model)
              <div class="row" id="field_w_{{ $loop->iteration }}">
                <div class="col-md-12">
                  <div class="box box-primary{{ $hrdtidpdep1->status !== "DRAFT" ? " collapsed-box" : "" }}">
                    <div class="box-header with-border">
                      <h3 class="box-title" id="box_w_{{ $loop->iteration }}">{{ $model->alc }} (Development-{{ $loop->iteration }})</h3>
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                          <i class="fa fa-minus"></i>
                        </button>
                        @if ($hrdtidpdep1->status === "DRAFT" && ($hrdtidpdep1->npk_div_head === \Auth::user()->username))
                          <button id="btndeletealc_w_{{ $loop->iteration }}" name="btndeletealc_w_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Kompetensi" onclick="deleteKategori(this,'w')">
                            <i class="fa fa-times"></i>
                          </button>
                        @else 
                          <button id="btndeletealc_w_{{ $loop->iteration }}" name="btndeletealc_w_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Kompetensi" onclick="deleteKategori(this,'w')" disabled="">
                            <i class="fa fa-times"></i>
                          </button>
                        @endif
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div class="row form-group">
                        <div class="col-sm-10">
                          @if ($hrdtidpdep1->status === "DRAFT" && ($hrdtidpdep1->npk_div_head === \Auth::user()->username))
                            <textarea id="deskripsi_w_{{ $loop->iteration }}" name="deskripsi_w_{{ $loop->iteration }}" required class="form-control" placeholder="Keterangan (*)" rows="5" maxlength="2000" style="resize:vertical" readonly="readonly">{{ $model->deskripsi }}</textarea>
                          @else 
                            <textarea id="deskripsi_w_{{ $loop->iteration }}" name="deskripsi_w_{{ $loop->iteration }}" required class="form-control" placeholder="Keterangan (*)" rows="5" maxlength="2000" style="resize:vertical" readonly="readonly">{{ $model->deskripsi }}</textarea>
                          @endif
                          <input type="hidden" id="hrdt_idpdep2_id_w_{{ $loop->iteration }}" name="hrdt_idpdep2_id_w_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ base64_encode($model->id) }}">
                          <input type="hidden" id="alc_w_{{ $loop->iteration }}" name="alc_w_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ $model->alc }}">
                        </div>
                        <div class="col-sm-1 pull-left">
                          @if ($hrdtidpdep1->status === "DRAFT" && ($hrdtidpdep1->npk_div_head === \Auth::user()->username))
                            <button id="btnpopupdeskripsi_w_{{ $loop->iteration }}" name="btnpopupdeskripsi_w_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih Value" onclick="popupAlc(this,'w')" data-toggle="modal" data-target="#alcModal"><span class="glyphicon glyphicon-search"></span></button>
                          @else 
                            <button id="btnpopupdeskripsi_w_{{ $loop->iteration }}" name="btnpopupdeskripsi_w_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih Value" onclick="popupAlc(this,'w')" data-toggle="modal" data-target="#alcModal" disabled=""><span class="glyphicon glyphicon-search"></span></button>
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
            {!! Form::hidden('jml_row_w', $hrdtidpdep1->hrdtIdpdep2sByStatus("W")->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_w']) !!}
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

@if ($hrdtidpdep1->hrdtIdpdep2sByStatus("W")->get()->count() > 0)
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary{{ $hrdtidpdep1->status !== "DRAFT" ? " collapsed-box" : "" }}">
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
            @foreach ($hrdtidpdep1->hrdtIdpdep2sByStatus("W")->get() as $model)
              <div class="row" id="field_dev_{{ $loop->iteration }}">
                <div class="col-md-12">
                  <div class="box box-primary{{ $hrdtidpdep1->status !== "DRAFT" ? " collapsed-box" : "" }}">
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
                      @foreach ($model->hrdtIdpdep3s()->get() as $hrdtIdpdep3)
                        @if ($hrdtidpdep1->status === "DRAFT" || ($hrdtidpdep1->status !== "DRAFT" && !empty($hrdtIdpdep3->program)))
                          <div class="row form-group">
                            <div class="col-sm-4">
                              {!! Form::label('program_'.$model->id.'_'.$loop->iteration, 'Program ('.$loop->iteration.')') !!}
                              @if ($hrdtidpdep1->status === "DRAFT" && ($hrdtidpdep1->npk_div_head === \Auth::user()->username))
                                <textarea id="program_{{ $model->id }}_{{ $loop->iteration }}" name="program_{{ $model->id }}_{{ $loop->iteration }}" class="form-control" placeholder="Program" rows="3" maxlength="2000" style="resize:vertical">{{ $hrdtIdpdep3->program }}</textarea>
                              @else 
                                <textarea id="program_{{ $model->id }}_{{ $loop->iteration }}" name="program_{{ $model->id }}_{{ $loop->iteration }}" class="form-control" placeholder="Program" rows="3" maxlength="2000" style="resize:vertical" readonly="readonly">{{ $hrdtIdpdep3->program }}</textarea>
                              @endif
                              <input type="hidden" id="hrdt_idpdep3_id_{{ $model->id }}_{{ $loop->iteration }}" name="hrdt_idpdep3_id_{{ $model->id }}_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ base64_encode($hrdtIdpdep3->id) }}">
                            </div>
                            <div class="col-sm-1">
                              {!! Form::label('lm_'.$model->id.'_'.$loop->iteration, 'Learning Methode') !!}
                              @if ($hrdtidpdep1->status === "DRAFT" && ($hrdtidpdep1->npk_div_head === \Auth::user()->username))
                                <button id="btnpopuplm_{{ $model->id }}_{{ $loop->iteration }}" name="btnpopuplm_{{ $model->id }}_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih Learning Methode" onclick="popupLm(this,'{{ $model->id }}')" data-toggle="modal" data-target="#lmModal"><span class="glyphicon glyphicon-search"></span></button>
                              @else 
                                <button id="btnpopuplm_{{ $model->id }}_{{ $loop->iteration }}" name="btnpopuplm_{{ $model->id }}_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih Learning Methode" onclick="popupLm(this,'{{ $model->id }}')" data-toggle="modal" data-target="#lmModal" disabled=""><span class="glyphicon glyphicon-search"></span></button>
                              @endif
                            </div>
                            <div class="col-sm-4">
                              {!! Form::label('target_'.$model->id.'_'.$loop->iteration, 'Target ('.$loop->iteration.')') !!}
                              @if ($hrdtidpdep1->status === "DRAFT" && ($hrdtidpdep1->npk_div_head === \Auth::user()->username))
                                <textarea id="target_{{ $model->id }}_{{ $loop->iteration }}" name="target_{{ $model->id }}_{{ $loop->iteration }}" class="form-control" placeholder="Target" rows="3" maxlength="2000" style="resize:vertical">{{ $hrdtIdpdep3->target }}</textarea>
                              @else 
                                <textarea id="target_{{ $model->id }}_{{ $loop->iteration }}" name="target_{{ $model->id }}_{{ $loop->iteration }}" class="form-control" placeholder="Target" rows="3" maxlength="2000" style="resize:vertical" readonly="readonly">{{ $hrdtIdpdep3->target }}</textarea>
                              @endif
                            </div>
                            <div class="col-sm-3">
                              {!! Form::label('tgl_'.$model->id.'_'.$loop->iteration, 'Due Date ('.$loop->iteration.')') !!}
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                @if ($hrdtidpdep1->status === "DRAFT" && ($hrdtidpdep1->npk_div_head === \Auth::user()->username))
                                  {!! Form::text('tgl_'.$model->id.'_'.$loop->iteration, \Carbon\Carbon::parse($hrdtIdpdep3->tgl_start)->format('d/m/Y')." - ".\Carbon\Carbon::parse($hrdtIdpdep3->tgl_finish)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date', 'id' => 'tgl_'.$model->id.'_'.$loop->iteration]) !!}
                                @else 
                                  {!! Form::text('tgl_'.$model->id.'_'.$loop->iteration, \Carbon\Carbon::parse($hrdtIdpdep3->tgl_start)->format('d/m/Y')." - ".\Carbon\Carbon::parse($hrdtIdpdep3->tgl_finish)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date', 'id' => 'tgl_'.$model->id.'_'.$loop->iteration, 'readonly'=>'readonly']) !!}
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

@if ($hrdtidpdep1->status === "APPROVE HRD" || $hrdtidpdep1->status === "APPROVE HRD (MID)")
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary{{ $hrdtidpdep1->status === "APPROVE HRD (MID)" ? " collapsed-box" : "" }}">
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
            @foreach ($hrdtidpdep1->hrdtIdpdep4s()->get() as $hrdtIdpdep4)
              <div class="row" id="field_mid_{{ $loop->iteration }}">
                <div class="col-md-12">
                  <div class="box box-primary{{ $hrdtidpdep1->status === "APPROVE HRD (MID)" ? " collapsed-box" : "" }}">
                    <div class="box-header with-border">
                      <h3 class="box-title" id="box_mid_{{ $loop->iteration }}">Mid Year Review ({{ $loop->iteration }})</h3>
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                          <i class="fa fa-minus"></i>
                        </button>
                        @if ($hrdtidpdep1->status === "APPROVE HRD")
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
                          @if ($hrdtidpdep1->status === "APPROVE HRD" && ($hrdtidpdep1->npk_div_head === \Auth::user()->username))
                            <textarea id="program_mid_{{ $loop->iteration }}" name="program_mid_{{ $loop->iteration }}" class="form-control" placeholder="Development Program" rows="3" maxlength="2000" style="resize:vertical" required>{{ $hrdtIdpdep4->program }}</textarea>
                          @else 
                            <textarea id="program_mid_{{ $loop->iteration }}" name="program_mid_{{ $loop->iteration }}" class="form-control" placeholder="Development Program" rows="3" maxlength="2000" style="resize:vertical" required readonly="readonly">{{ $hrdtIdpdep4->program }}</textarea>
                          @endif
                          <input type="hidden" id="hrdt_idpdep4_id_{{ $loop->iteration }}" name="hrdt_idpdep4_id_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ base64_encode($hrdtIdpdep4->id) }}">
                        </div>
                        <div class="col-sm-1">
                          {!! Form::label('tr_'.$loop->iteration, 'Training') !!}
                          @if ($hrdtidpdep1->status === "APPROVE HRD" && ($hrdtidpdep1->npk_div_head === \Auth::user()->username))
                            <button id="btnpopuptr_mid_{{ $loop->iteration }}" name="btnpopuptr_mid_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih Training" onclick="popupTrMid(this)" data-toggle="modal" data-target="#trModal"><span class="glyphicon glyphicon-search"></span></button>
                          @else 
                            <button id="btnpopuptr_mid_{{ $loop->iteration }}" name="btnpopuptr_mid_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih Training" onclick="popupTrMid(this)" data-toggle="modal" data-target="#trModal" disabled=""><span class="glyphicon glyphicon-search"></span></button>
                          @endif
                        </div>
                        <div class="col-sm-2">
                          {!! Form::label('tanggal_program_mid_'.$loop->iteration, 'Tanggal Program') !!}
                          @if ($hrdtidpdep1->status === "APPROVE HRD" && ($hrdtidpdep1->npk_div_head === \Auth::user()->username))
                            @if (!empty($hrdtIdpdep4->tgl_program))
                              {!! Form::date('tanggal_program_mid_'.$loop->iteration, \Carbon\Carbon::parse($hrdtIdpdep4->tgl_program), ['class'=>'form-control','placeholder' => 'Tgl Program', 'required', 'id'=>'tanggal_program_mid_'.$loop->iteration]) !!}
                            @else 
                              {!! Form::date('tanggal_program_mid_'.$loop->iteration, null, ['class'=>'form-control','placeholder' => 'Tgl Program', 'required', 'id'=>'tanggal_program_mid_'.$loop->iteration]) !!}
                            @endif
                          @else 
                            @if (!empty($hrdtIdpdep4->tgl_program))
                              {!! Form::date('tanggal_program_mid_'.$loop->iteration, \Carbon\Carbon::parse($hrdtIdpdep4->tgl_program), ['class'=>'form-control','placeholder' => 'Tgl Program', 'required', 'id'=>'tanggal_program_mid_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                            @else 
                              {!! Form::date('tanggal_program_mid_'.$loop->iteration, null, ['class'=>'form-control','placeholder' => 'Tgl Program', 'required', 'id'=>'tanggal_program_mid_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                            @endif
                          @endif
                        </div>
                        <div class="col-sm-3">
                          {!! Form::label('achievement_mid_'.$loop->iteration, 'Achievement') !!}
                          @if ($hrdtidpdep1->status === "APPROVE HRD" && ($hrdtidpdep1->npk_div_head === \Auth::user()->username))
                            <textarea id="achievement_mid_{{ $loop->iteration }}" name="achievement_mid_{{ $loop->iteration }}" class="form-control" placeholder="Achievement" rows="3" maxlength="2000" style="resize:vertical" required>{{ $hrdtIdpdep4->achievement }}</textarea>
                          @else 
                            <textarea id="achievement_mid_{{ $loop->iteration }}" name="achievement_mid_{{ $loop->iteration }}" class="form-control" placeholder="Achievement" rows="3" maxlength="2000" style="resize:vertical" required readonly="readonly">{{ $hrdtIdpdep4->achievement }}</textarea>
                          @endif
                        </div>
                        <div class="col-sm-3">
                          {!! Form::label('next_action_mid_'.$loop->iteration, 'Next Action') !!}
                          @if ($hrdtidpdep1->status === "APPROVE HRD" && ($hrdtidpdep1->npk_div_head === \Auth::user()->username))
                            <textarea id="next_action_mid_{{ $loop->iteration }}" name="next_action_mid_{{ $loop->iteration }}" class="form-control" placeholder="Next Action" rows="3" maxlength="2000" style="resize:vertical" required>{{ $hrdtIdpdep4->next_action }}</textarea>
                          @else 
                            <textarea id="next_action_mid_{{ $loop->iteration }}" name="next_action_mid_{{ $loop->iteration }}" class="form-control" placeholder="Next Action" rows="3" maxlength="2000" style="resize:vertical" required readonly="readonly">{{ $hrdtIdpdep4->next_action }}</textarea>
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
          <div class="box-body">
            <p class="pull-right">
              @if ($hrdtidpdep1->status === "APPROVE HRD" && ($hrdtidpdep1->npk_div_head === \Auth::user()->username))
                <button id="addRowMid" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Development Program"><span class="glyphicon glyphicon-plus"></span> Add Development Program</button>
              @endif
            </p>
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

@if ($hrdtidpdep1->status === "APPROVE HRD (MID)")
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
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
            @foreach ($hrdtidpdep1->hrdtIdpdep5s()->get() as $hrdtIdpdep5)
              <div class="row" id="field_one_{{ $loop->iteration }}">
                <div class="col-md-12">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title" id="box_one_{{ $loop->iteration }}">One Year Review ({{ $loop->iteration }})</h3>
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                          <i class="fa fa-minus"></i>
                        </button>
                        <button id="btndeleteone_{{ $loop->iteration }}" name="btndeleteone_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Program" onclick="deleteOneReview(this)">
                          <i class="fa fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div class="row form-group">
                        <div class="col-sm-4">
                          {!! Form::label('program_one_'.$loop->iteration, 'Development Program') !!}
                          @if ($hrdtidpdep1->status === "APPROVE HRD (MID)" && ($hrdtidpdep1->npk_div_head === \Auth::user()->username))
                            <textarea id="program_one_{{ $loop->iteration }}" name="program_one_{{ $loop->iteration }}" class="form-control" placeholder="Development Program" rows="3" maxlength="2000" style="resize:vertical" required>{{ $hrdtIdpdep5->program }}</textarea>
                          @else 
                            <textarea id="program_one_{{ $loop->iteration }}" name="program_one_{{ $loop->iteration }}" class="form-control" placeholder="Development Program" rows="3" maxlength="2000" style="resize:vertical" required readonly="readonly">{{ $hrdtIdpdep5->program }}</textarea>
                          @endif
                          <input type="hidden" id="hrdt_idpdep5_id_{{ $loop->iteration }}" name="hrdt_idpdep5_id_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ base64_encode($hrdtIdpdep5->id) }}">
                        </div>
                        <div class="col-sm-1">
                          {!! Form::label('tr_'.$loop->iteration, 'Training') !!}
                          @if ($hrdtidpdep1->status === "APPROVE HRD (MID)" && ($hrdtidpdep1->npk_div_head === \Auth::user()->username))
                            <button id="btnpopuptr_one_{{ $loop->iteration }}" name="btnpopuptr_one_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih Training" onclick="popupTrOne(this)" data-toggle="modal" data-target="#trModal"><span class="glyphicon glyphicon-search"></span></button>
                          @else 
                            <button id="btnpopuptr_one_{{ $loop->iteration }}" name="btnpopuptr_one_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih Training" onclick="popupTrOne(this)" data-toggle="modal" data-target="#trModal" disabled=""><span class="glyphicon glyphicon-search"></span></button>
                          @endif
                        </div>
                        <div class="col-sm-2">
                          {!! Form::label('tanggal_program_one_'.$loop->iteration, 'Tanggal Program') !!}
                          @if ($hrdtidpdep1->status === "APPROVE HRD (MID)" && ($hrdtidpdep1->npk_div_head === \Auth::user()->username))
                            @if (!empty($hrdtIdpdep4->tgl_program))
                              {!! Form::date('tanggal_program_one_'.$loop->iteration, \Carbon\Carbon::parse($hrdtIdpdep5->tgl_program), ['class'=>'form-control','placeholder' => 'Tgl Program', 'required', 'id'=>'tanggal_program_one_'.$loop->iteration]) !!}
                            @else 
                              {!! Form::date('tanggal_program_one_'.$loop->iteration, null, ['class'=>'form-control','placeholder' => 'Tgl Program', 'required', 'id'=>'tanggal_program_one_'.$loop->iteration]) !!}
                            @endif
                          @else 
                            @if (!empty($hrdtIdpdep4->tgl_program))
                              {!! Form::date('tanggal_program_one_'.$loop->iteration, \Carbon\Carbon::parse($hrdtIdpdep5->tgl_program), ['class'=>'form-control','placeholder' => 'Tgl Program', 'required', 'id'=>'tanggal_program_one_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                            @else 
                              {!! Form::date('tanggal_program_one_'.$loop->iteration, null, ['class'=>'form-control','placeholder' => 'Tgl Program', 'required', 'id'=>'tanggal_program_one_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                            @endif
                          @endif
                        </div>
                        <div class="col-sm-5">
                          {!! Form::label('evaluation_one_'.$loop->iteration, 'Evaluation Result') !!}
                          @if ($hrdtidpdep1->status === "APPROVE HRD (MID)" && ($hrdtidpdep1->npk_div_head === \Auth::user()->username))
                            <textarea id="evaluation_one_{{ $loop->iteration }}" name="evaluation_one_{{ $loop->iteration }}" class="form-control" placeholder="Evaluation Result" rows="3" maxlength="2000" style="resize:vertical" required>{{ $hrdtIdpdep5->evaluation }}</textarea>
                          @else 
                            <textarea id="evaluation_one_{{ $loop->iteration }}" name="evaluation_one_{{ $loop->iteration }}" class="form-control" placeholder="Evaluation Result" rows="3" maxlength="2000" style="resize:vertical" required readonly="readonly">{{ $hrdtIdpdep5->evaluation }}</textarea>
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
          <div class="box-body">
            <p class="pull-right">
              @if ($hrdtidpdep1->status === "APPROVE HRD (MID)" && ($hrdtidpdep1->npk_div_head === \Auth::user()->username))
                <button id="addRowOne" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Development Program"><span class="glyphicon glyphicon-plus"></span> Add Development Program</button>
              @else 
                <button id="addRowOne" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Development Program" disabled=""><span class="glyphicon glyphicon-plus"></span> Add Development Program</button>
              @endif
            </p>
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

{!! Form::hidden('jml_row_mid', $hrdtidpdep1->hrdtIdpdep4s()->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_mid']) !!}
{!! Form::hidden('jml_row_one', $hrdtidpdep1->hrdtIdpdep5s()->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_one']) !!}

<div class="box-footer">
  @if ($hrdtidpdep1->status === "DRAFT")
    {!! Form::submit('Save as Draft', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
    @if (Auth::user()->can('hrd-idpdep-submit'))
      &nbsp;&nbsp;
      <button id="btn-submit" type="button" class="btn btn-success">Submit IDP</button>
    @endif
    @if (Auth::user()->can('hrd-idpdep-delete'))
      &nbsp;&nbsp;
      <button id="btn-delete" type="button" class="btn btn-danger">Delete IDP</button>
    @endif
  @elseif ($hrdtidpdep1->status === "APPROVE HRD")
    {!! Form::submit('Save (Mid Year Review)', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
    @if (Auth::user()->can('hrd-idpdep-submit'))
      &nbsp;&nbsp;
      <button id="btn-submit" type="button" class="btn btn-success">Submit IDP (Mid Year Review)</button>
    @endif
  @elseif ($hrdtidpdep1->status === "APPROVE HRD (MID)")
    {!! Form::submit('Save (One Year Review)', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
    @if (Auth::user()->can('hrd-idpdep-submit'))
      &nbsp;&nbsp;
      <button id="btn-submit" type="button" class="btn btn-success">Submit IDP (One Year Review)</button>
    @endif
  @endif
  &nbsp;&nbsp;
  <a class="btn btn-primary" href="{{ route('hrdtidpdep1s.index') }}">Cancel</a>
  &nbsp;&nbsp;
  <p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

<!-- Modal ALC -->
@include('hr.idpdep.popup.alcModal')
<!-- Modal LM -->
@include('hr.idpdep.popup.lmModal')
<!-- Modal TR -->
@include('hr.idpdep.popup.trModal')

@section('scripts')
<script type="text/javascript">

  //Initialize Select2 Elements
  $(".select2").select2();

  function changeAlc() {
    var select_alc = document.getElementById("select_alc").value;
    var text = "";
    if(select_alc === "VISION & BUSINESS SENSE") {
      text = "Menunjukkan pemahaman yang mendalam tentang bisnis utama perusahaan dan pemahaman tentang arah bisnis perusahaan di masa datang.  Mampu merumuskan obyektif organisasi/perusahaan secara jelas dan terukur, dimana hal tersebut merupakan refleksi dari kebutuhan 'pasar', yang diharapkan dapat mendatangkan /meningkatkan keuntungan bagi organisasi.";
    } else if(select_alc === "CUSTOMER FOCUS") {
      text = "Konsentrasi pada kebutuhan pelanggan sampai kepada tingkatan 'proactively customer driven'. Tidak hanya mengatasi keluhan pelanggan tetapi secara aktif mencari umpan balik dan mengembangkan pengukuran yang dapat secara preventive menyelesaikan permasalahan pelanggan. Terus membagikan nilai tersebut kepada yang lain.";
    } else if(select_alc === "INTERPERSONAL SKILL") {
      text = "Memiliki ketrampilan komunikasi yang baik sehingga dapat mempengaruhi orang lain, mampu membangun hubungan baik dengan berbagai orang dari berbagai tingkatan. Ybs juga mampu untuk beradaptasi dan menyesuaikan diri dengan berbagai situasi.";
    } else if(select_alc === "ANALYSIS & JUDGEMENT") {
      text = "Mampu membuat keputusan dengan cepat dan tepat, memikirkan seluruh konsekuensi dari keputusannya. Mencari data dan masukan-masukan dari berbagai sumber saat akan membuat keputusan, namun demikian, apabila dibutuhkan, ybs mampu membuat keputusan dengan cepat walaupun data yang dimilikinya kurang lengkap atau memiliki makna ganda.";
    } else if(select_alc === "PLANNING & DRIVING ACTION") {
      text = "Tetap fokus pada hal yang penting di bisnis. Sistematis dalam pendekatan. Menetapkan obyektif & rencana yang jelas dan memanfaatkan sumber daya guna mencapai hasil yang diinginkan.";
    } else if(select_alc === "LEADING & MOTIVATING") {
      text = "Menjalani peran sebagai pemimpin dengan nyaman, menghargai kebutuhan dan perasaan orang lain (termasuk bawahan) dan menggunakan gaya memimpin dan memotivasi yang sesuai dengan kebutuhan bawahan.";
    } else if(select_alc === "TEAM WORK") {
      text = "Proses bekerja secara bersama-sama dengan sekelompok orang untuk mencapai tujuan tertentu.";
    } else if(select_alc === "DRIVE, COURAGE & INTEGRITY") {
      text = "Secara proaktive dan terus menerus membawa bisnis ke arah visi perusahaan. Berkeinginan untuk belajar dan fokus pada unjuk kerja. Tidak takut untuk berhadapan langsung dengan hal-hal yang belum jelas, bertentangan dan memiliki resiko langsung, serta bersedia mengambil tindakan berdasarkan apa yang diyakininya.";
    }
    document.getElementById("alc_deskripsi").innerHTML = text;
  }

  function updateAlc(kat_alc) {

    var strength = "F";
    var jml_row_s = document.getElementById("jml_row_s").value.trim();
    jml_row_s = Number(jml_row_s);
    for($i = 1; $i <= jml_row_s; $i++) {
      var key = "s";
      var id = 'alc_'+key+'_'+$i;
      var kat_alc_temp = document.getElementById(id).value.trim();
      if(kat_alc_temp === kat_alc) {
        strength = "T";
      }
    }

    var weakness = "F";
    var jml_row_w = document.getElementById("jml_row_w").value.trim();
    jml_row_w = Number(jml_row_w);
    for($i = 1; $i <= jml_row_w; $i++) {
      var key = "w";
      var id = 'alc_'+key+'_'+$i;
      var kat_alc_temp = document.getElementById(id).value.trim();
      if(kat_alc_temp === kat_alc) {
        weakness = "T";
      }
    }

    if(strength === "T" && weakness === "T") {
      $("#select_alc option[value='"+kat_alc+"']").attr("disabled","disabled");
    }
  }

  function refreshAlc() {
    var select_alcs = document.getElementById("select_alc"), select_alc, i;
    for(i = 0; i < select_alcs.length; i++) {
      select_alc = select_alcs[i];
      updateAlc(select_alc.value);
    }
  }

  refreshAlc();

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

  $("#btn-submit").click(function(){
    var valid_data = "T";
    var info = "";
    if(valid_data === "F") {
      swal(info, "Perhatikan inputan anda!", "warning");
    } else {
      var msg = "Anda yakin submit IDP ini?";
      var txt = "Data yang tidak valid (lengkap) tidak akan diproses.";
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
        document.getElementById("st_input").value = "DIV";
        document.getElementById("form_id").submit();
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
  });

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
        var msg = "Anda yakin menyimpan IDP ini?";
        var txt = "Data yang tidak valid (lengkap) tidak akan diproses.";
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
          //document.getElementById("idtables").value = targets;
          document.getElementById("st_submit").value = "F";
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

  $("#btn-delete").click(function(){
    var id = document.getElementById("id").value.trim();
    var tahun = document.getElementById("year").value.trim();
    var msg = 'Anda yakin menghapus IDP tahun: ' + tahun + '?';
    var txt = 'data yang sudah di-Submit atau di-Approve tidak bisa dihapus.';
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
      var urlRedirect = "{{ route('hrdtidpdep1s.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', id);
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

  $("#btn-strength").click(function(){
    add("S");
  });

  $("#btn-weakness").click(function(){
    add("W");
  });

  function add(kategori) {
    var key = kategori.toLowerCase();
    var key_param;
    var kat;
    if(kategori === "S") {
      key_param = "'s'";
      kat = "Strength";
    } else {
      key_param = "'w'";
      kat = "Development";
    }
    var jml_row = document.getElementById("jml_row_"+key).value.trim();
    jml_row = Number(jml_row) + 1;
    if(jml_row > 3) {
      var info = "";
      info = "Max. untuk Kompetensi " + kat + " adalah 3!"
      swal(info, "Perhatikan inputan anda!", "warning");
    } else {
      var kat_alc = $('select[name="select_alc"]').val();
      if(kat_alc !== "-") {

        var double = "F";
        for($i = 1; $i < jml_row; $i++) {
          var id = 'alc_'+key+'_'+$i;
          var kat_alc_temp = document.getElementById(id).value.trim();
          if(kat_alc_temp === kat_alc) {
            double = "T";
          }
        }

        if(double === "T") {
          var info = "Kompetensi tsb sudah dipilih pada kategori " + kat + "!";
          swal(info, "Perhatikan inputan anda!", "warning");
        } else {

          document.getElementById("jml_row_"+key).value = jml_row;
          
          var id_field = 'field_'+key+'_'+jml_row;
          var id_box = 'box_'+key+'_'+jml_row;
          var btndeletealc = 'btndeletealc_'+key+'_'+jml_row;

          var hrdt_idpdep2_id = 'hrdt_idpdep2_id_'+key+'_'+jml_row;
          var alc = 'alc_'+key+'_'+jml_row;
          var deskripsi = 'deskripsi_'+key+'_'+jml_row;
          var deskripsi_btn = 'btnpopupdeskripsi_'+key+'_'+jml_row;
          
          var field_alc = "#field-alc-" + key;
          $(field_alc).append(
            '<div class="row" id="'+id_field+'">\
              <div class="box box-primary">\
                <div class="box-header with-border">\
                  <h3 class="box-title" id="'+id_box+'">' + kat_alc + ' ('+ kat + '-' + jml_row +')</h3>\
                  <div class="box-tools pull-right">\
                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse">\
                      <i class="fa fa-minus"></i>\
                    </button>\
                    <button id="' + btndeletealc + '" name="' + btndeletealc + '" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Kompetensi" onclick="deleteKategori(this,' + key_param + ')">\
                      <i class="fa fa-times"></i>\
                    </button>\
                  </div>\
                </div>\
                <div class="box-body">\
                  <div class="row form-group">\
                    <div class="col-sm-10">\
                      <textarea id="' + deskripsi + '" name="' + deskripsi + '" required class="form-control" placeholder="Keterangan (*)" rows="5" maxlength="2000" style="resize:vertical" readonly="readonly"></textarea>\
                      <input type="hidden" id="' + hrdt_idpdep2_id + '" name="' + hrdt_idpdep2_id + '" class="form-control" readonly="readonly" value="0">\
                      <input type="hidden" id="' + alc + '" name="' + alc + '" class="form-control" readonly="readonly" value="' + kat_alc + '">\
                    </div>\
                    <div class="col-sm-1 pull-left">\
                      <button id="' + deskripsi_btn + '" name="' + deskripsi_btn + '" type="button" class="btn btn-info" title="Pilih Value" onclick="popupAlc(this,' + key_param + ')" data-toggle="modal" data-target="#alcModal"><span class="glyphicon glyphicon-search"></span></button>\
                    </div>\
                  </div>\
                </div>\
              </div>\
            </div>'
          );

          $("#select_alc").val("-").select2();
          updateAlc(kat_alc);
          changeAlc();

          document.getElementById(deskripsi_btn).focus();
        }
      } else {
        var info = "";
        info = "Pilih Kompetensi terlebih dahulu!"
        swal(info, "Perhatikan inputan anda!", "warning");
      }
    }
  }

  function deleteKategori(ths, param) {
    if(param === "s" || param === "w") {
      var row = ths.id.replace('btndeletealc_' + param + '_', '');
      var kat_alc = document.getElementById("alc_" + param + "_" + row).value.trim();
      var msg = 'Anda yakin menghapus Kompetensi ' + kat_alc + '?';
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
        var hrdt_idpdep2_id = "hrdt_idpdep2_id_" + param + "_" + row;
        var hrdt_idpdep2_id_value = document.getElementById(hrdt_idpdep2_id).value.trim();

        if(hrdt_idpdep2_id_value === "0" || hrdt_idpdep2_id_value === "") {
          changeId(param, row, "F");
        } else {
          //DELETE DI DATABASE
          // remove these events;
          window.onkeydown = null;
          window.onfocus = null;
          var token = document.getElementsByName('_token')[0].value.trim();
          // delete via ajax
          // hapus data detail dengan ajax
          var url = "{{ route('hrdtidpdep2s.destroy', 'param') }}";
          url = url.replace('param', hrdt_idpdep2_id_value);
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
                changeId(param, row, "T");
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
  }

  function changeId(param, row, database) {
    var id_div = "#field_" + param + "_" + row;
    var kat_alc = document.getElementById("alc_" + param + "_" + row).value.trim();
    $(id_div).remove();

    if(database === "T") {
      var id_div_dev = "#field_dev_" + row;
      $(id_div_dev).remove();
    }
    
    var jml_row = document.getElementById("jml_row_"+param).value.trim();
    jml_row = Number(jml_row);
    nextRow = Number(row) + 1;
    for($i = nextRow; $i <= jml_row; $i++) {
      var id_field = "#field_" + param + "_" + $i;
      var id_field_new = "field_" + param + "_" + ($i-1);
      $(id_field).attr({"id":id_field_new, "name":id_field_new});
      var id_box = "#box_" + param + "_" + $i;
      var id_box_new = "box_" + param + "_" + ($i-1);
      $(id_box).attr({"id":id_box_new, "name":id_box_new});
      var btndeletealc = "#btndeletealc_" + param + "_" + $i;
      var btndeletealc_new = "btndeletealc_" + param + "_" + ($i-1);
      $(btndeletealc).attr({"id":btndeletealc_new, "name":btndeletealc_new});

      var hrdt_idpdep2_id = "#hrdt_idpdep2_id_" + param + "_" + $i;
      var hrdt_idpdep2_id_new = "hrdt_idpdep2_id_" + param + "_" + ($i-1);
      $(hrdt_idpdep2_id).attr({"id":hrdt_idpdep2_id_new, "name":hrdt_idpdep2_id_new});
      var alc = "#alc_" + param + "_" + $i;
      var alc_new = "alc_" + param + "_" + ($i-1);
      $(alc).attr({"id":alc_new, "name":alc_new});
      var deskripsi = "#deskripsi_" + param + "_" + $i;
      var deskripsi_new = "deskripsi_" + param + "_" + ($i-1);
      $(deskripsi).attr({"id":deskripsi_new, "name":deskripsi_new});
      var deskripsi_btn = "#btnpopupdeskripsi_" + param + "_" + $i;
      var deskripsi_btn_new = "btnpopupdeskripsi_" + param + "_" + ($i-1);
      $(deskripsi_btn).attr({"id":deskripsi_btn_new, "name":deskripsi_btn_new});

      var text = document.getElementById(id_box_new).innerHTML;
      text = text.replace($i, ($i-1));
      document.getElementById(id_box_new).innerHTML = text;
    }
    jml_row = jml_row - 1;
    document.getElementById("jml_row_"+param).value = jml_row;

    $("#select_alc").val("-").select2();
    $("#select_alc option[value='"+kat_alc+"']").removeAttr("disabled");
    changeAlc();
  }

  function popupAlc(ths, param) {
    var myHeading = "<p>Popup Astra Leadership Compentence</p>";
    $("#alcModalLabel").html(myHeading);

    var row = ths.id.replace('btnpopupdeskripsi_' + param + '_', '');
    var kat_alc = document.getElementById("alc_" + param + "_" + row).value.trim();

    var url = '{{ route('datatables.popupAlcs', 'param') }}';
    url = url.replace('param', window.btoa(kat_alc));
    var lookupAlc = $('#lookupAlc').DataTable({
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
      "order": [],
      columns: [
        { data: 'ket_alc', name: 'ket_alc'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupAlc tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupAlc.rows(rows).data();
          $.each($(rowData),function(key,value){
            var row = ths.id.replace('btnpopupdeskripsi_' + param + '_', '');
            var deskripsi = "deskripsi_" + param + "_" + row;
            var deskripsi_value = document.getElementById(deskripsi).value.trim();
            if(deskripsi_value === "") {
              document.getElementById(deskripsi).value = value["ket_alc"];
            } else {
              document.getElementById(deskripsi).value += "\n" + value["ket_alc"];
            }
            $('#alcModal').modal('hide');
          });
        });
        $('#alcModal').on('hidden.bs.modal', function () {
          // 
        });
      },
    });
  }

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
    url = url.replace('param', window.btoa('{{ $hrdtidpdep1->npk }}'));
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

    var hrdt_idpdep4_id = 'hrdt_idpdep4_id_'+jml_row_mid;
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
                  <input type="hidden" id="' + hrdt_idpdep4_id + '" name="' + hrdt_idpdep4_id + '" class="form-control" readonly="readonly" value="0">\
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
      var hrdt_idpdep4_id = "hrdt_idpdep4_id_" + row;
      var hrdt_idpdep4_id_value = document.getElementById(hrdt_idpdep4_id).value.trim();

      if(hrdt_idpdep4_id_value === "0" || hrdt_idpdep4_id_value === "") {
        changeIdMid(row);
      } else {
        //DELETE DI DATABASE
        // remove these events;
        window.onkeydown = null;
        window.onfocus = null;
        var token = document.getElementsByName('_token')[0].value.trim();
        // delete via ajax
        // hapus data detail dengan ajax
        var url = "{{ route('hrdtidpdep4s.destroy', 'param') }}";
        url = url.replace('param', hrdt_idpdep4_id_value);
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
      var hrdt_idpdep4_id = "#hrdt_idpdep4_id_" + $i;
      var hrdt_idpdep4_id_new = "hrdt_idpdep4_id_" + ($i-1);
      $(hrdt_idpdep4_id).attr({"id":hrdt_idpdep4_id_new, "name":hrdt_idpdep4_id_new});
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
    url = url.replace('param', window.btoa('{{ $hrdtidpdep1->npk }}'));
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

    var hrdt_idpdep5_id = 'hrdt_idpdep5_id_'+jml_row_one;
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
                  <input type="hidden" id="' + hrdt_idpdep5_id + '" name="' + hrdt_idpdep5_id + '" class="form-control" readonly="readonly" value="0">\
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
      var hrdt_idpdep5_id = "hrdt_idpdep5_id_" + row;
      var hrdt_idpdep5_id_value = document.getElementById(hrdt_idpdep5_id).value.trim();

      if(hrdt_idpdep5_id_value === "0" || hrdt_idpdep5_id_value === "") {
        changeIdOne(row);
      } else {
        //DELETE DI DATABASE
        // remove these events;
        window.onkeydown = null;
        window.onfocus = null;
        var token = document.getElementsByName('_token')[0].value.trim();
        // delete via ajax
        // hapus data detail dengan ajax
        var url = "{{ route('hrdtidpdep5s.destroy', 'param') }}";
        url = url.replace('param', hrdt_idpdep5_id_value);
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
      var hrdt_idpdep5_id = "#hrdt_idpdep5_id_" + $i;
      var hrdt_idpdep5_id_new = "hrdt_idpdep5_id_" + ($i-1);
      $(hrdt_idpdep5_id).attr({"id":hrdt_idpdep5_id_new, "name":hrdt_idpdep5_id_new});
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
</script>
@endsection