@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Resume Pengisian Oli
        <small>Laporan Resume Pengisian Oli</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Laporan</li>
        <li class="active"><i class="fa fa-files-o"></i> Resume Pengisian Oli</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-body form-horizontal">
          <div class="form-group">
            <div class="col-sm-2">
              {!! Form::label('filter_tahun', 'Tahun') !!}
              <select id="filter_tahun" name="filter_tahun" aria-controls="filter_status" 
              class="form-control select2">
                @for ($i = \Carbon\Carbon::now()->format('Y'); $i > \Carbon\Carbon::now()->format('Y')-5; $i--)
                  @if (isset($tahun))
                    @if ($i == $tahun)
                      <option value={{ $i }} selected="selected">{{ $i }}</option>
                    @else
                      <option value={{ $i }}>{{ $i }}</option>
                    @endif
                  @else 
                    @if ($i == \Carbon\Carbon::now()->format('Y'))
                      <option value={{ $i }} selected="selected">{{ $i }}</option>
                    @else
                      <option value={{ $i }}>{{ $i }}</option>
                    @endif
                  @endif
                @endfor
              </select>
            </div>
            <div class="col-sm-2">
              {!! Form::label('filter_bulan', 'Bulan') !!}
              <select id="filter_bulan" name="filter_bulan" aria-controls="filter_status" 
              class="form-control select2">
                @if (isset($bulan))
                  <option value="01" @if ("01" == $bulan) selected="selected" @endif>Januari</option>
                  <option value="02" @if ("02" == $bulan) selected="selected" @endif>Februari</option>
                  <option value="03" @if ("03" == $bulan) selected="selected" @endif>Maret</option>
                  <option value="04" @if ("04" == $bulan) selected="selected" @endif>April</option>
                  <option value="05" @if ("05" == $bulan) selected="selected" @endif>Mei</option>
                  <option value="06" @if ("06" == $bulan) selected="selected" @endif>Juni</option>
                  <option value="07" @if ("07" == $bulan) selected="selected" @endif>Juli</option>
                  <option value="08" @if ("08" == $bulan) selected="selected" @endif>Agustus</option>
                  <option value="09" @if ("09" == $bulan) selected="selected" @endif>September</option>
                  <option value="10" @if ("10" == $bulan) selected="selected" @endif>Oktober</option>
                  <option value="11" @if ("11" == $bulan) selected="selected" @endif>November</option>
                  <option value="12" @if ("12" == $bulan) selected="selected" @endif>Desember</option>
                @else 
                  <option value="01" @if ("01" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Januari</option>
                  <option value="02" @if ("02" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Februari</option>
                  <option value="03" @if ("03" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Maret</option>
                  <option value="04" @if ("04" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>April</option>
                  <option value="05" @if ("05" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Mei</option>
                  <option value="06" @if ("06" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Juni</option>
                  <option value="07" @if ("07" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Juli</option>
                  <option value="08" @if ("08" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Agustus</option>
                  <option value="09" @if ("09" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>September</option>
                  <option value="10" @if ("10" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Oktober</option>
                  <option value="11" @if ("11" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>November</option>
                  <option value="12" @if ("12" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Desember</option>
                @endif
              </select>
            </div>
            <div class="col-sm-2">
              {!! Form::label('kd_plant', 'Plant') !!}
              <select size="1" id="kd_plant" name="kd_plant" class="form-control select2" onchange="changeKdPlant()">
                @if (isset($kd_plant))
                  <option value="ALL">Pilih Plant</option>
                  @foreach($plant->get() as $kode)
                    <option value="{{ $kode->kd_plant }}" @if ($kode->kd_plant == $kd_plant) selected="selected" @endif>{{ $kode->nm_plant }}</option>
                  @endforeach
                @else 
                  <option value="ALL" selected="selected">Pilih Plant</option>
                  @foreach($plant->get() as $kode)
                    <option value="{{ $kode->kd_plant }}">{{ $kode->nm_plant }}</option>
                  @endforeach
                @endif
              </select>
            </div>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <div class="col-sm-2">
              {!! Form::label('kd_line', 'Line (F9)') !!}
              <div class="input-group">
                @if (isset($kd_line))
                  {!! Form::text('kd_line', $kd_line, ['class'=>'form-control','placeholder' => 'Line', 'maxlength' => 10, 'onkeydown' => 'keyPressedKdLine(event)', 'onchange' => 'validateKdLine()', 'id' => 'kd_line']) !!}
                @else 
                  {!! Form::text('kd_line', null, ['class'=>'form-control','placeholder' => 'Line', 'maxlength' => 10, 'onkeydown' => 'keyPressedKdLine(event)', 'onchange' => 'validateKdLine()', 'id' => 'kd_line']) !!}
                @endif
                <span class="input-group-btn">
                  <button id="btnpopupline" type="button" class="btn btn-info" data-toggle="modal" data-target="#lineModal">
                    <span class="glyphicon glyphicon-search"></span>
                  </button>
                </span>
              </div>
            </div>
            <div class="col-sm-4">
              {!! Form::label('nm_line', 'Nama Line') !!}
              @if (isset($nm_line))
                {!! Form::text('nm_line', $nm_line, ['class'=>'form-control','placeholder' => 'Nama Line', 'disabled'=>'', 'id' => 'nm_line']) !!}
              @else 
                {!! Form::text('nm_line', null, ['class'=>'form-control','placeholder' => 'Nama Line', 'disabled'=>'', 'id' => 'nm_line']) !!}
              @endif
            </div>
            <div class="col-sm-2">
              {!! Form::label('lblresume', 'Action') !!}
              <button id="btn-resume" name="btn-resume" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Total Resume">View Total Resume</button>
            </div>
          </div>
          <!-- /.form-group -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
      <div class="box" id="box-mesin" name="box-mesin">
        @if (isset($kd_plant) && isset($kd_line) && isset($kd_mesin))
          @include ('mtc.oil.mesin')
        @endif
      </div>
      <!-- /.box -->
      @if (isset($kd_plant) && isset($kd_line) && isset($kd_mesin))
        <div class="row" id="field_mesin_bulan_hidrolik">
          <div class="col-md-4">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title" id="box-grafik">HIDROLIK</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove">
                    <i class="fa fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <canvas id="canvas-mesin-bulan-hidrolik" width="1100" height="900"></canvas>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
          <div class="col-md-4">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title" id="box-grafik">LUBRIKASI</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove">
                    <i class="fa fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <canvas id="canvas-mesin-bulan-lubrikasi" width="1100" height="900"></canvas>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
          <div class="col-md-4">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title" id="box-grafik">SPINDLE</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove">
                    <i class="fa fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <canvas id="canvas-mesin-bulan-spindle" width="1100" height="900"></canvas>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row" id="field_mesin_hari_hidrolik">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title" id="box-grafik">HIDROLIK</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove">
                    <i class="fa fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <canvas id="canvas-mesin-hari-hidrolik" width="1100" height="400"></canvas>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row" id="field_mesin_hari_lubrikasi">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title" id="box-grafik">LUBRIKASI</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove">
                    <i class="fa fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <canvas id="canvas-mesin-hari-lubrikasi" width="1100" height="400"></canvas>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row" id="field_mesin_hari_spindle">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title" id="box-grafik">SPINDLE</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove">
                    <i class="fa fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <canvas id="canvas-mesin-hari-spindle" width="1100" height="400"></canvas>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      @endif

      @if($igp1 === "T" || $igp2 === "T" || $igp3 === "T") 
        <div class="row" id="field_jkt_hidrolik">
          @if($igp1 === "T") 
            <div class="col-md-{{ 12/$total_jkt }}">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box-grafik">PLANT IGP-1 - HIDROLIK</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <canvas id="canvas-igp1-hidrolik" width="1100" height="900"></canvas>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          @endif
          @if($igp2 === "T") 
            <div class="col-md-{{ 12/$total_jkt }}">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box-grafik">PLANT IGP-2 - HIDROLIK</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <canvas id="canvas-igp2-hidrolik" width="1100" height="900"></canvas>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          @endif
          @if($igp3 === "T") 
            <div class="col-md-{{ 12/$total_jkt }}">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box-grafik">PLANT IGP-3 - HIDROLIK</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <canvas id="canvas-igp3-hidrolik" width="1100" height="900"></canvas>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          @endif
        </div>
        <!-- /.row -->
      @endif
      @if($igp1 === "T" || $igp2 === "T" || $igp3 === "T") 
        <div class="row" id="field_jkt_lubrikasi">
          @if($igp1 === "T")
            <div class="col-md-{{ 12/$total_jkt }}">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box-grafik">PLANT IGP-1 - LUBRIKASI</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <canvas id="canvas-igp1-lubrikasi" width="1100" height="900"></canvas>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          @endif
          @if($igp2 === "T")
            <div class="col-md-{{ 12/$total_jkt }}">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box-grafik">PLANT IGP-2 - LUBRIKASI</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <canvas id="canvas-igp2-lubrikasi" width="1100" height="900"></canvas>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          @endif
          @if($igp3 === "T")
            <div class="col-md-{{ 12/$total_jkt }}">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box-grafik">PLANT IGP-3 - LUBRIKASI</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <canvas id="canvas-igp3-lubrikasi" width="1100" height="900"></canvas>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          @endif
        </div>
        <!-- /.row -->
      @endif
      @if($igp1 === "T" || $igp2 === "T" || $igp3 === "T") 
        <div class="row" id="field_jkt_spindle">
          @if($igp1 === "T")
            <div class="col-md-{{ 12/$total_jkt }}">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box-grafik">PLANT IGP-1 - SPINDLE</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <canvas id="canvas-igp1-spindle" width="1100" height="900"></canvas>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          @endif
          @if($igp2 === "T")
            <div class="col-md-{{ 12/$total_jkt }}">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box-grafik">PLANT IGP-2 - SPINDLE</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <canvas id="canvas-igp2-spindle" width="1100" height="900"></canvas>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          @endif
          @if($igp3 === "T")
            <div class="col-md-{{ 12/$total_jkt }}">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box-grafik">PLANT IGP-3 - SPINDLE</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <canvas id="canvas-igp3-spindle" width="1100" height="900"></canvas>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          @endif
        </div>
        <!-- /.row -->
      @endif
      @if($kima === "T" || $kimb === "T") 
        <div class="row" id="field_kim_hidrolik">
          @if($kima === "T") 
            <div class="col-md-{{ 12/$total_kim }}">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box-grafik">PLANT KIM-1A - HIDROLIK</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <canvas id="canvas-kima-hidrolik" width="1100" height="900"></canvas>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          @endif
          @if($kimb === "T") 
            <div class="col-md-{{ 12/$total_kim }}">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box-grafik">PLANT KIM-1B - HIDROLIK</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <canvas id="canvas-kimb-hidrolik" width="1100" height="900"></canvas>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          @endif
        </div>
        <!-- /.row -->
      @endif
      @if($kima === "T" || $kimb === "T")
        <div class="row" id="field_kim_lubrikasi">
          @if($kima === "T")
            <div class="col-md-{{ 12/$total_kim }}">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box-grafik">PLANT KIM-1A - LUBRIKASI</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <canvas id="canvas-kima-lubrikasi" width="1100" height="900"></canvas>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          @endif
          @if($kimb === "T")
            <div class="col-md-{{ 12/$total_kim }}">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box-grafik">PLANT KIM-1B - LUBRIKASI</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <canvas id="canvas-kimb-lubrikasi" width="1100" height="900"></canvas>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          @endif
        </div>
        <!-- /.row -->
      @endif
      @if($kima === "T" || $kimb === "T")
        <div class="row" id="field_kim_spindle">
          @if($kima === "T")
            <div class="col-md-{{ 12/$total_kim }}">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box-grafik">PLANT KIM-1A - SPINDLE</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <canvas id="canvas-kima-spindle" width="1100" height="900"></canvas>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          @endif
          @if($kimb === "T")
            <div class="col-md-{{ 12/$total_kim }}">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box-grafik">PLANT KIM-1B - SPINDLE</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <canvas id="canvas-kimb-spindle" width="1100" height="900"></canvas>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          @endif
        </div>
        <!-- /.row -->
      @endif
      <!-- Modal Line -->
      @include('mtc.lp.popup.lineModal')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script src="{{ asset('chartjs/Chart.bundle.js') }}"></script>
<script src="{{ asset('chartjs/utils.js') }}"></script>
<script type="text/javascript">
  document.getElementById("filter_tahun").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  function changeKdPlant() {
    validateKdLine();
  }

  function keyPressedKdLine(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupline').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('btn-resume').focus();
    }
  }

  function popupKdLine() {
    var myHeading = "<p>Popup Line</p>";
    $("#lineModalLabel").html(myHeading);
    var kd_plant = document.getElementById('kd_plant').value.trim();
    var url = '{{ route('datatables.popupLines', 'param') }}';
    url = url.replace('param', window.btoa(kd_plant));
    var lookupLine = $('#lookupLine').DataTable({
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
      "order": [[1, 'asc']],
      columns: [
        { data: 'xkd_line', name: 'xkd_line'},
        { data: 'xnm_line', name: 'xnm_line'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupLine tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupLine.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("kd_line").value = value["xkd_line"];
            document.getElementById("nm_line").value = value["xnm_line"];
            $('#lineModal').modal('hide');
            validateKdLine();
          });
        });
        $('#lineModal').on('hidden.bs.modal', function () {
          var kd_line = document.getElementById("kd_line").value.trim();
          if(kd_line === '') {
            document.getElementById("nm_line").value = "";
            $("#box-mesin").html("");
            $('#kd_line').focus();
          } else {
            $('#btn-resume').focus();
          }
        });
      },
    });
  }

  function validateKdLine() {
    var kd_line = document.getElementById("kd_line").value.trim();
    if(kd_line !== '') {
      var kd_plant = document.getElementById('kd_plant').value.trim();
      var url = '{{ route('datatables.validasiLine', ['param','param2']) }}';
      url = url.replace('param2', window.btoa(kd_line));
      url = url.replace('param', window.btoa(kd_plant));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("kd_line").value = result["xkd_line"];
          document.getElementById("nm_line").value = result["xnm_line"];

          var url = "{{ route('mtctolis.daftarmesin', ['param','param2']) }}";
          url = url.replace('param2', window.btoa(kd_line));
          url = url.replace('param', window.btoa(kd_plant));
          $("#box-mesin").load(url);
        } else {
          document.getElementById("kd_line").value = "";
          document.getElementById("nm_line").value = "";
          $("#box-mesin").html("");
          document.getElementById("btn-resume").focus();
          swal("Line tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("kd_line").value = "";
      document.getElementById("nm_line").value = "";
      $("#box-mesin").html("");
    }
  }

  function grafik(kd_mesin) {
    var tahun = $('select[name="filter_tahun"]').val();
    var bulan = $('select[name="filter_bulan"]').val();
    var kd_plant = document.getElementById('kd_plant').value.trim();
    var kd_line = document.getElementById("kd_line").value.trim();
    if(kd_plant !== "ALL" && kd_line !== "") {
      var urlRedirect = "{{ route('mtctolis.resumepengisianoli', ['param','param2','param3','param4','param5']) }}";
      urlRedirect = urlRedirect.replace('param5', kd_mesin);
      urlRedirect = urlRedirect.replace('param4', window.btoa(kd_line));
      urlRedirect = urlRedirect.replace('param3', window.btoa(kd_plant));
      urlRedirect = urlRedirect.replace('param2', window.btoa(bulan));
      urlRedirect = urlRedirect.replace('param', window.btoa(tahun));
      window.location.href = urlRedirect;
    } else {
      if(kd_plant === "ALL" && kd_line === "") {
        document.getElementById("kd_plant").focus();
      } else if(kd_plant === "ALL") {
        document.getElementById("kd_plant").focus();
      } else {
        document.getElementById("kd_line").focus();
      }
      swal("Plant & Line tidak boleh kosong!", "Perhatikan inputan anda!", "warning");
    }
  }

  $(document).ready(function(){

    $("#btnpopupline").click(function(){
      popupKdLine();
    });

    $('#btn-resume').click( function () {
      var tahun = $('select[name="filter_tahun"]').val();
      var bulan = $('select[name="filter_bulan"]').val();
      var urlRedirect = "{{ route('mtctolis.resumepengisianoli', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(tahun));
      window.location.href = urlRedirect;
    });
  });

  @if($igp1 === "T" || $igp2 === "T" || $igp3 === "T" || $kima === "T" || $kimb === "T" || (isset($kd_plant) && isset($kd_line) && isset($kd_mesin)))

    @if($igp1 === "T")
      var chartDataH1 = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_h_igp1) !!}
          }
        ]
      };

      var chartDataL1 = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_l_igp1) !!}
          }
        ]
      };

      var chartDataS1 = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_s_igp1) !!}
          }
        ]
      };
    @endif

    @if($igp2 === "T")
      var chartDataH2 = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_h_igp2) !!}
          }
        ]
      };

      var chartDataL2 = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_l_igp2) !!}
          }
        ]
      };

      var chartDataS2 = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_s_igp2) !!}
          }
        ]
      };
    @endif

    @if($igp3 === "T")
      var chartDataH3 = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_h_igp3) !!}
          }
        ]
      };

      var chartDataL3 = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_l_igp3) !!}
          }
        ]
      };

      var chartDataS3 = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_s_igp3) !!}
          }
        ]
      };
    @endif

    @if($kima === "T")
      var chartDataHA = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_h_kima) !!}
          }
        ]
      };

      var chartDataLA = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_l_kima) !!}
          }
        ]
      };

      var chartDataSA = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_s_kima) !!}
          }
        ]
      };
    @endif

    @if($kimb === "T")
      var chartDataHB = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_h_kimb) !!}
          }
        ]
      };

      var chartDataLB = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_l_kimb) !!}
          }
        ]
      };

      var chartDataSB = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_s_kimb) !!}
          }
        ]
      };
    @endif

    @if (isset($kd_plant) && isset($kd_line) && isset($kd_mesin))
      var chartDataMesinH1 = {
        labels: {!! json_encode($value_bulan) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_bulan_h) !!}
          }
        ]
      };

      var chartDataMesinL1 = {
        labels: {!! json_encode($value_bulan) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_bulan_l) !!}
          }
        ]
      };

      var chartDataMesinS1 = {
        labels: {!! json_encode($value_bulan) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_bulan_s) !!}
          }
        ]
      };

      var chartDataHariH1 = {
        labels: {!! json_encode($value_hari) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_hari_h) !!}
          }
        ]
      };

      var chartDataHariL1 = {
        labels: {!! json_encode($value_hari) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_hari_l) !!}
          }
        ]
      };

      var chartDataHariS1 = {
        labels: {!! json_encode($value_hari) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_hari_s) !!}
          }
        ]
      };
    @endif

    window.onload = function() {
      Chart.Legend.prototype.afterFit = function() {
        this.height = this.height + 15;
      };
      
      @if($igp1 === "T")
        var ctxH1 = document.getElementById('canvas-igp1-hidrolik').getContext('2d');
        window.myMixedChartH1 = new Chart(ctxH1, {
          type: 'bar',
          data: chartDataH1,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI HIDROLIK {{ $tahun }} - IGP 1',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxL1 = document.getElementById('canvas-igp1-lubrikasi').getContext('2d');
        window.myMixedChartL1 = new Chart(ctxL1, {
          type: 'bar',
          data: chartDataL1,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI LUBRIKASI {{ $tahun }} - IGP 1',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxS1 = document.getElementById('canvas-igp1-spindle').getContext('2d');
        window.myMixedChartS1 = new Chart(ctxS1, {
          type: 'bar',
          data: chartDataS1,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI SPINDLE {{ $tahun }} - IGP 1',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });
      @endif
      @if($igp2 === "T")
        var ctxH2 = document.getElementById('canvas-igp2-hidrolik').getContext('2d');
        window.myMixedChartH2 = new Chart(ctxH2, {
          type: 'bar',
          data: chartDataH2,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI HIDROLIK {{ $tahun }} - IGP 2',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxL2 = document.getElementById('canvas-igp2-lubrikasi').getContext('2d');
        window.myMixedChartL2 = new Chart(ctxL2, {
          type: 'bar',
          data: chartDataL2,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI LUBRIKASI {{ $tahun }} - IGP 2',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxS2 = document.getElementById('canvas-igp2-spindle').getContext('2d');
        window.myMixedChartS2 = new Chart(ctxS2, {
          type: 'bar',
          data: chartDataS2,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI SPINDLE {{ $tahun }} - IGP 2',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });
      @endif
      @if($igp3 === "T")
        var ctxH3 = document.getElementById('canvas-igp3-hidrolik').getContext('2d');
        window.myMixedChartH3 = new Chart(ctxH3, {
          type: 'bar',
          data: chartDataH3,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI HIDROLIK {{ $tahun }} - IGP 3',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxL3 = document.getElementById('canvas-igp3-lubrikasi').getContext('2d');
        window.myMixedChartL3 = new Chart(ctxL3, {
          type: 'bar',
          data: chartDataL3,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI LUBRIKASI {{ $tahun }} - IGP 3',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxS3 = document.getElementById('canvas-igp3-spindle').getContext('2d');
        window.myMixedChartS3 = new Chart(ctxS3, {
          type: 'bar',
          data: chartDataS3,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI SPINDLE {{ $tahun }} - IGP 3',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });
      @endif
      @if($kima === "T")
        var ctxHA = document.getElementById('canvas-kima-hidrolik').getContext('2d');
        window.myMixedChartHA = new Chart(ctxHA, {
          type: 'bar',
          data: chartDataHA,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI HIDROLIK {{ $tahun }} - KIM 1A',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxLA = document.getElementById('canvas-kima-lubrikasi').getContext('2d');
        window.myMixedChartLA = new Chart(ctxLA, {
          type: 'bar',
          data: chartDataLA,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI LUBRIKASI {{ $tahun }} - KIM 1A',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxSA = document.getElementById('canvas-kima-spindle').getContext('2d');
        window.myMixedChartSA = new Chart(ctxSA, {
          type: 'bar',
          data: chartDataSA,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI SPINDLE {{ $tahun }} - KIM 1A',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });
      @endif
      @if($kimb === "T")
        var ctxHB = document.getElementById('canvas-kimb-hidrolik').getContext('2d');
        window.myMixedChartHB = new Chart(ctxHB, {
          type: 'bar',
          data: chartDataHB,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI HIDROLIK {{ $tahun }} - KIM 1B',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxLB = document.getElementById('canvas-kimb-lubrikasi').getContext('2d');
        window.myMixedChartLB = new Chart(ctxLB, {
          type: 'bar',
          data: chartDataLB,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI LUBRIKASI {{ $tahun }} - KIM 1B',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxSB = document.getElementById('canvas-kimb-spindle').getContext('2d');
        window.myMixedChartSB = new Chart(ctxSB, {
          type: 'bar',
          data: chartDataSB,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI SPINDLE {{ $tahun }} - KIM 1B',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });
      @endif

      @if (isset($kd_plant) && isset($kd_line) && isset($kd_mesin))
        var ctxMesinH1 = document.getElementById('canvas-mesin-bulan-hidrolik').getContext('2d');
        window.myMixedChartMesinH1 = new Chart(ctxMesinH1, {
          type: 'bar',
          data: chartDataMesinH1,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI HIDROLIK - TAHUN {{ $tahun }} (M/C {{ $kd_mesin }})',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxMesinL1 = document.getElementById('canvas-mesin-bulan-lubrikasi').getContext('2d');
        window.myMixedChartMesinL1 = new Chart(ctxMesinL1, {
          type: 'bar',
          data: chartDataMesinL1,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI LUBRIKASI - TAHUN {{ $tahun }} (M/C {{ $kd_mesin }})',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxMesinS1 = document.getElementById('canvas-mesin-bulan-spindle').getContext('2d');
        window.myMixedChartMesinS1 = new Chart(ctxMesinS1, {
          type: 'bar',
          data: chartDataMesinS1,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI SPINDLE - TAHUN {{ $tahun }} (M/C {{ $kd_mesin }})',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxHariH1 = document.getElementById('canvas-mesin-hari-hidrolik').getContext('2d');
        window.myMixedChartHariH1 = new Chart(ctxHariH1, {
          type: 'bar',
          data: chartDataHariH1,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI HIDROLIK - BULAN {{ strtoupper(namaBulan((int) $bulan)) }} TAHUN {{ $tahun }} (M/C {{ $kd_mesin }})',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxHariL1 = document.getElementById('canvas-mesin-hari-lubrikasi').getContext('2d');
        window.myMixedChartHariL1 = new Chart(ctxHariL1, {
          type: 'bar',
          data: chartDataHariL1,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI LUBRIKASI - BULAN {{ strtoupper(namaBulan((int) $bulan)) }} TAHUN {{ $tahun }} (M/C {{ $kd_mesin }})',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxHariS1 = document.getElementById('canvas-mesin-hari-spindle').getContext('2d');
        window.myMixedChartHariS1 = new Chart(ctxHariS1, {
          type: 'bar',
          data: chartDataHariS1,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI SPINDLE - BULAN {{ strtoupper(namaBulan((int) $bulan)) }} TAHUN {{ $tahun }} (M/C {{ $kd_mesin }})',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });
      @endif
    };
  @endif
</script>
@endsection