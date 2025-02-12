@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Dashboard</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      
      @if (isset($rekapabsen))
        <!-- Informasi Absen -->
        <!-- Info boxes -->
        <div class="row">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Informasi Absen {{ namaBulan((int) \Carbon\Carbon::now()->format('m')) }} {{ \Carbon\Carbon::now()->format('Y') }}</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="row">
                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <a style="color: black" href="{{ route('mobiles.absen') }}">
                      <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-file-text"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">TAK</span>
                          <span class="info-box-number">
                            {{ $rekapabsen->tdk_ada_ket }}
                          </span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </a>
                  </div>
                  <!-- /.col -->
                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <a style="color: black" href="{{ route('mobiles.absen') }}">
                      <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-file-text"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">Telat</span>
                          <span class="info-box-number">
                            {{ $rekapabsen->telat }}
                          </span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </a>
                  </div>
                  <!-- /.col -->

                  <!-- fix for small devices only -->
                  <div class="clearfix visible-sm-block"></div>

                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <a style="color: black" href="{{ route('mobiles.absen') }}">
                      <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-file-text"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">Satu Prik</span>
                          <span class="info-box-number">
                            {{ $rekapabsen->satu_prik }}
                          </span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </a>
                  </div>
                  <!-- /.col -->
                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <a style="color: black" href="{{ route('mobiles.absen') }}">
                      <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-file-text"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">Ijin Telat</span>
                          <span class="info-box-number">
                            {{ $rekapabsen->ijin_telat }}
                          </span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </a>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- End Informasi Absen -->
      @endif

      @if (isset($andon) && isset($tgl_andon))
        {{-- @if($andon->mtcAndons("1", $tgl_andon)->count() > 0) --}}
          <!-- Informasi ANDON IGP 2-->
          <!-- Info boxes -->
          <div class="row" id="box-body-andon-igp1" name="box-body-andon-igp1">
            @include ('mtc.andon.andon1')
          </div>
          <!-- /.row -->
          <!-- End Informasi ANDON IGP 1-->
        {{-- @endif --}}

        {{-- @if($andon->mtcAndons("2", $tgl_andon)->count() > 0) --}}
          <!-- Informasi ANDON IGP 2-->
          <!-- Info boxes -->
          <div class="row" id="box-body-andon-igp2" name="box-body-andon-igp2">
            @include ('mtc.andon.andon2')
          </div>
          <!-- /.row -->
          <!-- End Informasi ANDON IGP 2-->
        {{-- @endif --}}
        
        {{-- @if($andon->mtcAndons("3", $tgl_andon)->count() > 0) --}}
          <!-- Informasi ANDON IGP 3-->
          <!-- Info boxes -->
          <div class="row" id="box-body-andon-igp3" name="box-body-andon-igp3">
            @include ('mtc.andon.andon3')
          </div>
          <!-- /.row -->
          <!-- End Informasi ANDON IGP 3-->
        {{-- @endif --}}
      @endif

      @if (isset($qpr))
        @permission(['qpr-*','pica-*'])
          <!-- Informasi QPR -->
          <!-- Info boxes -->
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Informasi QPR</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                      <a style="color: black" href="{{ route('qprs.indexbystatus', base64_encode('2')) }}">
                        <div class="info-box" style="min-height: 60px;">
                          <span class="info-box-icon" style="line-height: 0px;background: white;height: 60px;">
                            <img src="{{ asset('images/qpr-blue.png') }}">
                          </span>

                          <div class="info-box-content">
                            <span class="info-box-text">Belum APPROVE Supplier</span>
                            <span class="info-box-number">{{ numberFormatter(0, 2)->format($qpr->qprByStatus("2")->count()) }} / {{ numberFormatter(0, 2)->format($qpr->qprByStatus("0")->count()) }}</span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </a>
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix visible-sm-block"></div>
                    
                    <div class="col-md-4 col-sm-6 col-xs-12">
                      <a style="color: black" href="{{ route('qprs.indexbystatus', base64_encode('4')) }}">
                        <div class="info-box" style="min-height: 60px;">
                          <span class="info-box-icon" style="line-height: 0px;background: white;height: 60px;">
                            <img src="{{ asset('images/qpr-green.png') }}">
                          </span>

                          <div class="info-box-content">
                            <span class="info-box-text">Approve Supplier</span>
                            <span class="info-box-number">{{ numberFormatter(0, 2)->format($qpr->qprByStatus("4")->count()) }} / {{ numberFormatter(0, 2)->format($qpr->qprByStatus("0")->count()) }}</span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </a>
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix visible-sm-block"></div>

                    <div class="col-md-4 col-sm-6 col-xs-12">
                      <a style="color: black" href="{{ route('qprs.indexbystatus', base64_encode('5')) }}">
                        <div class="info-box" style="min-height: 60px;">
                          <span class="info-box-icon" style="line-height: 0px;background: white;height: 60px;">
                            <img src="{{ asset('images/qpr-red.png') }}">
                          </span>

                          <div class="info-box-content">
                            <span class="info-box-text">Reject Supplier</span>
                            <span class="info-box-number">{{ numberFormatter(0, 2)->format($qpr->qprByStatus("5")->count()) }} / {{ numberFormatter(0, 2)->format($qpr->qprByStatus("0")->count()) }}</span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </a>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
                <!-- ./box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <!-- End Informasi QPR -->
        @endpermission
      @endif

      @if (isset($pica) && isset($qpr))
        @permission(['qpr-*','pica-*'])
          <!-- Informasi Submit PICA -->
          <!-- Info boxes -->
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Informasi Submit PICA</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                      <a style="color: black" href="{{ route('picas.indexbystatus', base64_encode('D')) }}">
                        <div class="info-box" style="min-height: 60px;">
                          <span class="info-box-icon" style="line-height: 0px;background: white;height: 60px;">
                            <img src="{{ asset('images/qpr-blue.png') }}">
                          </span>

                          <div class="info-box-content">
                            <span class="info-box-text">DRAFT</span>
                            <span class="info-box-number">{{ numberFormatter(0, 2)->format($pica->picaByStatus("D")->count()) }} / {{ numberFormatter(0, 2)->format($qpr->qprByStatus("4")->count()) }}</span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </a>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-xs-12">
                      <a style="color: black" href="{{ route('picas.indexbystatus', base64_encode('S')) }}">
                        <div class="info-box" style="min-height: 60px;">
                          <span class="info-box-icon" style="line-height: 0px;background: white;height: 60px;">
                            <img src="{{ asset('images/qpr-brown.png') }}">
                          </span>

                          <div class="info-box-content">
                            <span class="info-box-text">Submit</span>
                            <span class="info-box-number">{{ numberFormatter(0, 2)->format($pica->picaByStatus("S")->count() + $pica->picaByStatus("A")->count() + $pica->picaByStatus("R")->count() + $pica->picaByStatus("C")->count() + $pica->picaByStatus("E")->count()) }} / {{ numberFormatter(0, 2)->format($qpr->qprByStatus("4")->count()) }}</span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </a>
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix visible-sm-block"></div>

                    <div class="col-md-4 col-sm-6 col-xs-12">
                      <a style="color: black" href="{{ route('qprs.indexbystatus', base64_encode('7')) }}">
                        <div class="info-box" style="min-height: 60px;">
                          <span class="info-box-icon" style="line-height: 0px;background: white;height: 60px;">
                            <img src="{{ asset('images/qpr-green.png') }}">
                          </span>

                          <div class="info-box-content">
                            <span class="info-box-text">BELUM DIRESPON</span>
                            <span class="info-box-number">{{ numberFormatter(0, 2)->format($qpr->qprByStatus("4")->count() - $pica->picaByStatus("D")->count() - ($pica->picaByStatus("S")->count() + $pica->picaByStatus("A")->count() + $pica->picaByStatus("R")->count() + $pica->picaByStatus("C")->count() + $pica->picaByStatus("E")->count())) }} / {{ numberFormatter(0, 2)->format($qpr->qprByStatus("4")->count()) }}</span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </a>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
                <!-- ./box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <!-- End Informasi Submit PICA -->

          <!-- Informasi Judgement PICA -->
          <!-- Info boxes -->
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Informasi Judgement PICA</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <a style="color: black" href="{{ route('picas.indexbystatus', base64_encode('A')) }}">
                        <div class="info-box" style="min-height: 60px;">
                          <span class="info-box-icon" style="line-height: 0px;background: white;height: 60px;">
                            <img src="{{ asset('images/qpr-blue.png') }}">
                          </span>

                          <div class="info-box-content">
                            <span class="info-box-text">APPROVE</span>
                            <span class="info-box-number">{{ numberFormatter(0, 2)->format($pica->picaByStatus("A")->count() + $pica->picaByStatus("C")->count() + $pica->picaByStatus("E")->count()) }} / {{ numberFormatter(0, 2)->format($pica->picaByStatus("S")->count() + $pica->picaByStatus("A")->count() + $pica->picaByStatus("R")->count() + $pica->picaByStatus("C")->count() + $pica->picaByStatus("E")->count()) }}</span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </a>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <a style="color: black" href="{{ route('picas.indexbystatus', base64_encode('R')) }}">
                        <div class="info-box" style="min-height: 60px;">
                          <span class="info-box-icon" style="line-height: 0px;background: white;height: 60px;">
                            <img src="{{ asset('images/qpr-red.png') }}">
                          </span>

                          <div class="info-box-content">
                            <span class="info-box-text">REVISI</span>
                            <span class="info-box-number">{{ numberFormatter(0, 2)->format($pica->picaByStatus("R")->count()) }} / {{ numberFormatter(0, 2)->format($pica->picaByStatus("S")->count() + $pica->picaByStatus("A")->count() + $pica->picaByStatus("R")->count() + $pica->picaByStatus("C")->count() + $pica->picaByStatus("E")->count()) }}</span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </a>
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix visible-sm-block"></div>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <a style="color: black" href="{{ route('picas.indexbystatus', base64_encode('BJ')) }}">
                        <div class="info-box" style="min-height: 60px;">
                          <span class="info-box-icon" style="line-height: 0px;background: white;height: 60px;">
                            <img src="{{ asset('images/qpr-green.png') }}">
                          </span>

                          <div class="info-box-content">
                            <span class="info-box-text">BELUM JUDGEMENT</span>
                            <span class="info-box-number">{{ numberFormatter(0, 2)->format($pica->picaByStatus("FS")->count()) }} / {{ numberFormatter(0, 2)->format($pica->picaByStatus("S")->count() + $pica->picaByStatus("A")->count() + $pica->picaByStatus("R")->count() + $pica->picaByStatus("C")->count() + $pica->picaByStatus("E")->count()) }}</span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </a>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <a style="color: black" href="{{ route('picas.indexbystatus', base64_encode('RS')) }}">
                        <div class="info-box" style="min-height: 60px;">
                          <span class="info-box-icon" style="line-height: 0px;background: white;height: 60px;">
                            <img src="{{ asset('images/qpr-brown.png') }}">
                          </span>

                          <div class="info-box-content">
                            <span class="info-box-text">RESUBMIT REVISI</span>
                            <span class="info-box-number">{{ numberFormatter(0, 2)->format($pica->picaByStatus("RS")->count()) }} / {{ numberFormatter(0, 2)->format($pica->picaByStatus("S")->count() + $pica->picaByStatus("A")->count() + $pica->picaByStatus("R")->count() + $pica->picaByStatus("C")->count() + $pica->picaByStatus("E")->count()) }}</span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </a>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
                <!-- ./box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <!-- End Informasi Judgement PICA -->

          <!-- Informasi Monitoring PICA -->
          <!-- Info boxes -->
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Monitoring PICA</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                      <a style="color: black" href="{{ route('picas.indexbystatus', base64_encode('C')) }}">
                        <div class="info-box" style="min-height: 60px;">
                          <span class="info-box-icon" style="line-height: 0px;background: white;height: 60px;">
                            <img src="{{ asset('images/qpr-blue.png') }}">
                          </span>

                          <div class="info-box-content">
                            <span class="info-box-text">CLOSE</span>
                            <span class="info-box-number">{{ numberFormatter(0, 2)->format($pica->picaByStatus("C")->count() + $pica->picaByStatus("E")->count()) }} / {{ numberFormatter(0, 2)->format($pica->picaByStatus("A")->count() + $pica->picaByStatus("C")->count() + $pica->picaByStatus("E")->count()) }}</span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </a>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-xs-12">
                      <a style="color: black" href="{{ route('picas.indexbystatus', base64_encode('BC')) }}">
                        <div class="info-box" style="min-height: 60px;">
                          <span class="info-box-icon" style="line-height: 0px;background: white;height: 60px;">
                            <img src="{{ asset('images/qpr-brown.png') }}">
                          </span>

                          <div class="info-box-content">
                            <span class="info-box-text">BELUM CLOSE</span>
                            <span class="info-box-number">{{ numberFormatter(0, 2)->format($pica->picaByStatus("BC")->count()) }} / {{ numberFormatter(0, 2)->format($pica->picaByStatus("A")->count() + $pica->picaByStatus("C")->count() + $pica->picaByStatus("E")->count()) }}</span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </a>
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix visible-sm-block"></div>

                    <div class="col-md-4 col-sm-6 col-xs-12">
                      <a style="color: black" href="{{ route('picas.indexbystatus', base64_encode('OD')) }}">
                        <div class="info-box" style="min-height: 60px;">
                          <span class="info-box-icon" style="line-height: 0px;background: white;height: 60px;">
                            <img src="{{ asset('images/qpr-red.png') }}">
                          </span>

                          <div class="info-box-content">
                            <span class="info-box-text">DUE DATE TERLEWATI</span>
                            <span class="info-box-number">{{ numberFormatter(0, 2)->format($pica->picaByStatus("OD")->count()) }} / {{ numberFormatter(0, 2)->format($pica->picaByStatus("A")->count() + $pica->picaByStatus("C")->count() + $pica->picaByStatus("E")->count()) }}</span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </a>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
                <!-- ./box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <!-- End Informasi Monitoring PICA -->

          <!-- Informasi Monitoring KEEFEKTIFAN -->
          <!-- Info boxes -->
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Monitoring KEEFEKTIFAN</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                      <a style="color: black" href="{{ route('picas.indexbystatus', base64_encode('E')) }}">
                        <div class="info-box" style="min-height: 60px;">
                          <span class="info-box-icon" style="line-height: 0px;background: white;height: 60px;">
                            <img src="{{ asset('images/qpr-blue.png') }}">
                          </span>

                          <div class="info-box-content">
                            <span class="info-box-text">EFEKTIF</span>
                            <span class="info-box-number">{{ numberFormatter(0, 2)->format($pica->picaByStatus("E")->count()) }} / {{ numberFormatter(0, 2)->format($pica->picaByStatus("C")->count() + $pica->picaByStatus("E")->count()) }}</span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </a>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-xs-12">
                      <a style="color: black" href="{{ route('picas.indexbystatus', base64_encode('DM')) }}">
                        <div class="info-box" style="min-height: 60px;">
                          <span class="info-box-icon" style="line-height: 0px;background: white;height: 60px;">
                            <img src="{{ asset('images/qpr-brown.png') }}">
                          </span>

                          <div class="info-box-content">
                            <span class="info-box-text">DALAM MONITORING</span>
                            <span class="info-box-number">{{ numberFormatter(0, 2)->format($pica->picaByStatus("C")->count() - $pica->picaByStatus("RO")->count()) }} / {{ numberFormatter(0, 2)->format($pica->picaByStatus("C")->count() + $pica->picaByStatus("E")->count()) }}</span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </a>
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix visible-sm-block"></div>

                    <div class="col-md-4 col-sm-6 col-xs-12">
                      <a style="color: black" href="{{ route('picas.indexbystatus', base64_encode('RO')) }}">
                        <div class="info-box" style="min-height: 60px;">
                          <span class="info-box-icon" style="line-height: 0px;background: white;height: 60px;">
                            <img src="{{ asset('images/qpr-red.png') }}">
                          </span>

                          <div class="info-box-content">
                            <span class="info-box-text">REOCCUREN</span>
                            <span class="info-box-number">{{ numberFormatter(0, 2)->format($pica->picaByStatus("RO")->count()) }} / {{ numberFormatter(0, 2)->format($pica->picaByStatus("C")->count() + $pica->picaByStatus("E")->count()) }}</span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </a>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
                <!-- ./box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <!-- End Informasi Monitoring PICA -->
        @endpermission
      @endif

      @if (isset($pis))
        @permission(['pica-*'])
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">PART INSPECTION STANDARD</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <div class="info-box">
                        <span class="info-box-text">DRAFT
                          <span class="info-box-number">{{ numberFormatter(0, 2)->format($pis->pisByStatus("0")->count()) }}</span>
                          <img src="images/folder1.png" width="90" border="0">
                          <div class="info-box-content">
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </div>
                      <!-- /.col -->
                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                          <span class="info-box-text">Submit</span>
                          <span class="info-box-number">{{ numberFormatter(0, 2)->format($pis->pisByStatus("1")->count()) }}</span>
                          <img src="images/folder1.png" width="90" border="0">
                          <div class="info-box-content">
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </div>
                      <!-- /.col -->
                      <!-- fix for small devices only -->
                      <div class="clearfix visible-sm-block"></div>
                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                         <span class="info-box-text">Approve</span>
                         <span class="info-box-number">{{ numberFormatter(0, 2)->format($pis->pisByStatus("2")->count()) }}</span>
                         <img src="images/folder1.png" width="90" border="0">
                         <div class="info-box-content">
                         </div>
                         <!-- /.info-box-content -->
                       </div>
                       <!-- /.info-box -->
                     </div>
                     <!-- /.col -->
                     <div class="col-md-3 col-sm-6 col-xs-12">
                      <div class="info-box">
                        <span class="info-box-text">Reject</span>
                        <span class="info-box-number">{{ numberFormatter(0, 2)->format($pis->pisByStatus("3")->count()) }}</span>
                        <img src="images/folder1.png" width="90" border="0">
                        <div class="info-box-content">
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
                <!-- ./box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">QUALITY CONTROL PROCESS CHART</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <div class="info-box">
                        <span class="info-box-text">DRAFT</span>
                        <span class="info-box-number">{{ numberFormatter(0, 2)->format($pis->pisByStatus("0")->count()) }}</span>
                        <img src="images/folder2.png" width="90" border="0">
                        <div class="info-box-content">
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <div class="info-box">
                        <span class="info-box-text">Submit</span>
                        <span class="info-box-number">{{ numberFormatter(0, 2)->format($pis->pisByStatus("1")->count()) }}</span>
                        <img src="images/folder2.png" width="90" border="0">
                      </div>
                      <div class="info-box-content">
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <!-- fix for small devices only -->
                    <div class="clearfix visible-sm-block"></div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <div class="info-box">
                       <span class="info-box-text">Approve</span>
                       <span class="info-box-number">{{ numberFormatter(0, 2)->format($pis->pisByStatus("2")->count()) }}</span>
                       <img src="images/folder2.png" width="90" border="0">
                       <div class="info-box-content">
                       </div>
                       <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                   <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <div class="info-box">
                        <span class="info-box-text">Reject</span>
                        <span class="info-box-number">{{ numberFormatter(0, 2)->format($pis->pisByStatus("3")->count()) }}</span>
                        <img src="images/folder2.png" width="90" border="0">
                        <div class="info-box-content">
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
                <!-- ./box-body -->
              </div>
              <!-- ./box-body -->
            </div>
            <!-- /.box -->
          </div>
        @endpermission
      @endif

      @permission(['ehs-*'])
        <div class="row">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">EHS Performance</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6 col-sm-2 col-xs-12">
                    <a style="color: black" href="{{route('ehsspaccidents.grafik_sp_accident')}}">
                      <div class="info-box" style="min-height: 60px;">
                        <span class="info-box-icon" style="line-height: 0px;background: white;height: 60px;">
                          <img src="{{ asset('images/qpr-blue.png') }}">
                        </span>
                        <div class="info-box-content">
                          <span class="info-box-text">Safety Performance</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </a>
                  </div>
                  <!-- /.col -->
                  <!-- fix for small devices only -->
                  <div class="clearfix visible-sm-block"></div>
                  <div class="col-md-6 col-sm-2 col-xs-12">
                    <a style="color: black" href="{{ route('ehsspaccidents.index_kikenyoochi') }}">
                      <div class="info-box" style="min-height: 60px;">
                        <span class="info-box-icon" style="line-height: 0px;background: white;height: 60px;">
                          <img src="{{ asset('images/qpr-green.png') }}">
                        </span>
                        <div class="info-box-content">
                          <span class="info-box-text">Environment Performance</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </a>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- ./row -->
              </div>
              <!-- ./box-body -->
            </div>
            <!-- ./box -->
          </div>
          <!-- ./col -->
        </div>
        <!-- ./row -->
      @endpermission
      
      @if (isset($kd_plant_pmsachievement))
        @if(Auth::user()->can(['mtc-dm-*','mtc-lp-*','mtc-apr-pic-dm','mtc-apr-fm-dm','mtc-apr-pic-lp','mtc-apr-sh-lp','dashboar-mtc']))
          <!-- PMS Achievement Per-Plant -->
          <!-- Info boxes -->
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">PMS Achievement Per-Plant {{ namaBulan((int) \Carbon\Carbon::now()->format('m')) }} {{ \Carbon\Carbon::now()->format('Y') }} {!! $label_pmsachievement !!}</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <canvas id="canvas-pmsachievement" width="1100" height="300"></canvas>
                </div>
                <!-- ./box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <!-- PMS Achievement Per-Plant -->

          <!-- Pareto Breakdown Per-Plant -->
          <!-- Info boxes -->
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Pareto Breakdown Per-Plant {{ namaBulan((int) \Carbon\Carbon::now()->format('m')) }} {{ \Carbon\Carbon::now()->format('Y') }} {!! $label_paretobreakdown !!}</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <canvas id="canvas-paretobreakdown" width="1100" height="300"></canvas>
                </div>
                <!-- ./box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <!-- Pareto Breakdown Per-Plant -->

          <!-- Ratio Breakdown vs Preventive Per-Plant -->
          <!-- Info boxes -->
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Ratio Breakdown vs Preventive Per-Plant {{ namaBulan((int) \Carbon\Carbon::now()->format('m')) }} {{ \Carbon\Carbon::now()->format('Y') }} {!! $label_ratiobreakdownpreventive !!}</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <canvas id="canvas-ratiobreakdownpreventive" width="1100" height="300"></canvas>
                </div>
                <!-- ./box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <!-- Ratio Breakdown vs Preventive Per-Plant -->
        @endif
      @endif

      <!-- Kalender Kerja -->
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Kalender Kerja IGP Group</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row form-group">
                <div class="col-sm-12">
                  <p>
                    {!! Html::image(asset('images/Kalender.jpg'), 'File Not Found', ['class'=>'img-responsive']) !!}
                  </p>
                </div>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- ./box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- Kalender Kerja -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

{{-- @section('scripts')
AdminLTE dashboard demo (This is only for demo purposes)
<script src="{{ asset('dist/js/pages/dashboard2.js') }}"></script>
@endsection --}}

@if (isset($kd_plant_pmsachievement))
  @section('scripts')
    @if (isset($kd_plant_pmsachievement))
      @if(Auth::user()->can(['mtc-dm-*','mtc-lp-*','mtc-apr-pic-dm','mtc-apr-fm-dm','mtc-apr-pic-lp','mtc-apr-sh-lp','dashboar-mtc']))
        <script src="{{ asset('chartjs/Chart.bundle.js') }}"></script>
        <script src="{{ asset('chartjs/utils.js') }}"></script>
      @endif
    @endif
    <script>
      @if(Auth::user()->can(['mtc-dm-*','mtc-lp-*','mtc-apr-pic-dm','mtc-apr-fm-dm','mtc-apr-pic-lp','mtc-apr-sh-lp','dashboar-mtc']))
        var chartDataPmsAchievement = {
          labels: {!! json_encode($kd_plant_pmsachievement) !!}, 
          datasets: 
          [
            {
              type: 'bar',
              label: 'Plan',
              backgroundColor: window.chartColors.red,
              data: {!! json_encode($plans) !!}, 
              borderColor: 'white',
              borderWidth: 2
            }, 
            {
              type: 'bar',
              label: 'Actual',
              backgroundColor: window.chartColors.blue,
              data: {!! json_encode($acts) !!}, 
              borderColor: 'white',
              borderWidth: 2
            }
          ]
        };

        var chartDataParetoBreakdown = {
          labels: {!! json_encode($kd_plant_paretobreakdown) !!}, 
          datasets: 
          [
            {
              type: 'bar',
              label: 'Total Line Stop',
              backgroundColor: window.chartColors.red,
              data: {!! json_encode($sum_jml_ls) !!}, 
              borderColor: 'white',
              borderWidth: 2
            }
          ]
        };

        var chartDataRatioBreakdownPreventive = {
          labels: {!! json_encode($kd_plant_ratiobreakdownpreventive) !!}, 
          datasets: 
          [
            {
              type: 'bar',
              label: 'Line Stop',
              backgroundColor: window.chartColors.red,
              data: {!! json_encode($sum_jml_ls) !!}, 
              borderColor: 'white',
              borderWidth: 2
            }, 
            {
              type: 'bar',
              label: 'PMS',
              backgroundColor: window.chartColors.blue,
              data: {!! json_encode($sum_jml_pms) !!}, 
              borderColor: 'white',
              borderWidth: 2
            }
          ]
        };

        window.onload = function() {
          Chart.Legend.prototype.afterFit = function() {
            this.height = this.height + 15;
          };
          
          var ctx_pmsachievement = document.getElementById('canvas-pmsachievement').getContext('2d');
          window.myMixedChart_pmsachievement = new Chart(ctx_pmsachievement, {
            type: 'bar',
            data: chartDataPmsAchievement,
            options: {
              responsive: true,
              maintainAspectRatio: true,
              scales: {
                yAxes: [{
                  ticks: {
                    beginAtZero:true,
                    // max: 100, 
                    // stepSize: 50
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

                      return format(value);
                    }
                  },
                  gridLines: {
                    display:true
                  }
                }],
                xAxes: [{
                  ticks: {
                    fontSize: 18
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
                text: 'PMS Achievement',
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
                mode: 'index',
                intersect: true, 
                callbacks: {
                  title: function(tooltipItem, data) {
                    return data['labels'][tooltipItem[0].index];
                  },
                  label: function(tooltipItem, data) {
                    var label = tooltipItem.yLabel;
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    label = intVal(label);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    label = format(label);
                    return data.datasets[tooltipItem.datasetIndex].label + ": " + label;
                  },
                },
              }, 
              events: ['click'], 
              onClick: function(event, element) {
                var activeElement = element[0];
                if(activeElement != null) {
                  var data = activeElement._chart.data;
                  var barIndex = activeElement._index;
                  var datasetIndex = activeElement._datasetIndex;

                  var datasetLabel = data.datasets[datasetIndex].label;
                  var xLabel = data.labels[barIndex];
                  var yLabel = data.datasets[datasetIndex].data[barIndex];

                  // console.log(datasetLabel, xLabel, yLabel);
                  
                  var tahun = "{{ \Carbon\Carbon::now()->format('Y') }}";
                  var bulan = "{{ \Carbon\Carbon::now()->format('m') }}";
                  var kd_plant = xLabel;
                  if(kd_plant == "IGP-1") {
                    kd_plant = "1";
                  } else if(kd_plant == "IGP-2") {
                    kd_plant = "2";
                  } else if(kd_plant == "IGP-3") {
                    kd_plant = "3";
                  } else if(kd_plant == "IGP-4") {
                    kd_plant = "4";
                  } else if(kd_plant == "KIM-1A") {
                    kd_plant = "A";
                  } else if(kd_plant == "KIM-1B") {
                    kd_plant = "B";
                  }
                  var urlRedirect = "{{ route('mtctpmss.pmsachievement', ['param','param2','param3']) }}";
                  urlRedirect = urlRedirect.replace('param3', window.btoa(kd_plant));
                  urlRedirect = urlRedirect.replace('param2', window.btoa(bulan));
                  urlRedirect = urlRedirect.replace('param', window.btoa(tahun));
                  window.open(urlRedirect, '_blank');
                }
              }, 
            }
          });

          var ctx_paretobreakdown = document.getElementById('canvas-paretobreakdown').getContext('2d');
          window.myMixedChart_paretobreakdown = new Chart(ctx_paretobreakdown, {
            type: 'bar',
            data: chartDataParetoBreakdown,
            options: {
              responsive: true,
              maintainAspectRatio: true,
              scales: {
                yAxes: [{
                  ticks: {
                    beginAtZero:true,
                    // max: 100, 
                    // stepSize: 50
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

                      return format(value);
                    }
                  },
                  gridLines: {
                    display:true
                  }
                }],
                xAxes: [{
                  ticks: {
                    fontSize: 18
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
                text: 'Pareto Breakdown',
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
                mode: 'index',
                intersect: true, 
                callbacks: {
                  title: function(tooltipItem, data) {
                    return data['labels'][tooltipItem[0].index];
                  },
                  label: function(tooltipItem, data) {
                    var label = tooltipItem.yLabel;
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    label = intVal(label);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    label = format(label);
                    return data.datasets[tooltipItem.datasetIndex].label + ": " + label;
                  },
                },
              }, 
              events: ['click'], 
              onClick: function(event, element) {
                var activeElement = element[0];
                if(activeElement != null) {
                  var data = activeElement._chart.data;
                  var barIndex = activeElement._index;
                  var datasetIndex = activeElement._datasetIndex;

                  var datasetLabel = data.datasets[datasetIndex].label;
                  var xLabel = data.labels[barIndex];
                  var yLabel = data.datasets[datasetIndex].data[barIndex];

                  // console.log(datasetLabel, xLabel, yLabel);
                  
                  var tahun = "{{ \Carbon\Carbon::now()->format('Y') }}";
                  var bulan = "{{ \Carbon\Carbon::now()->format('m') }}";
                  var kd_plant = xLabel;
                  if(kd_plant == "IGP-1") {
                    kd_plant = "1";
                  } else if(kd_plant == "IGP-2") {
                    kd_plant = "2";
                  } else if(kd_plant == "IGP-3") {
                    kd_plant = "3";
                  } else if(kd_plant == "IGP-4") {
                    kd_plant = "4";
                  } else if(kd_plant == "KIM-1A") {
                    kd_plant = "A";
                  } else if(kd_plant == "KIM-1B") {
                    kd_plant = "B";
                  }
                  var urlRedirect = "{{ route('tmtcwo1s.paretobreakdown', ['param','param2','param3']) }}";
                  urlRedirect = urlRedirect.replace('param3', window.btoa(kd_plant));
                  urlRedirect = urlRedirect.replace('param2', window.btoa(bulan));
                  urlRedirect = urlRedirect.replace('param', window.btoa(tahun));
                  window.open(urlRedirect, '_blank');
                }
              }, 
            }
          });

          var ctx_ratiobreakdownpreventive = document.getElementById('canvas-ratiobreakdownpreventive').getContext('2d');
          window.myMixedChart_ratiobreakdownpreventive = new Chart(ctx_ratiobreakdownpreventive, {
            type: 'bar',
            data: chartDataRatioBreakdownPreventive,
            options: {
              responsive: true,
              maintainAspectRatio: true,
              scales: {
                yAxes: [{
                  ticks: {
                    beginAtZero:true,
                    // max: 100, 
                    // stepSize: 50
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

                      return format(value);
                    }
                  },
                  gridLines: {
                    display:true
                  }
                }],
                xAxes: [{
                  ticks: {
                    fontSize: 18
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
                text: 'Ratio Breakdown vs Preventive',
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
                mode: 'index',
                intersect: true, 
                callbacks: {
                  title: function(tooltipItem, data) {
                    return data['labels'][tooltipItem[0].index];
                  },
                  label: function(tooltipItem, data) {
                    var label = tooltipItem.yLabel;
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    label = intVal(label);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    label = format(label);
                    return data.datasets[tooltipItem.datasetIndex].label + ": " + label;
                  },
                },
              }, 
              events: ['click'], 
              onClick: function(event, element) {
                var activeElement = element[0];
                if(activeElement != null) {
                  var data = activeElement._chart.data;
                  var barIndex = activeElement._index;
                  var datasetIndex = activeElement._datasetIndex;

                  var datasetLabel = data.datasets[datasetIndex].label;
                  var xLabel = data.labels[barIndex];
                  var yLabel = data.datasets[datasetIndex].data[barIndex];

                  // console.log(datasetLabel, xLabel, yLabel);
                  
                  var tahun = "{{ \Carbon\Carbon::now()->format('Y') }}";
                  var bulan = "{{ \Carbon\Carbon::now()->format('m') }}";
                  var kd_plant = xLabel;
                  if(kd_plant == "IGP-1") {
                    kd_plant = "1";
                  } else if(kd_plant == "IGP-2") {
                    kd_plant = "2";
                  } else if(kd_plant == "IGP-3") {
                    kd_plant = "3";
                  } else if(kd_plant == "IGP-4") {
                    kd_plant = "4";
                  } else if(kd_plant == "KIM-1A") {
                    kd_plant = "A";
                  } else if(kd_plant == "KIM-1B") {
                    kd_plant = "B";
                  }
                  var urlRedirect = "{{ route('tmtcwo1s.ratiobreakdownpreventive', ['param','param2','param3']) }}";
                  urlRedirect = urlRedirect.replace('param3', window.btoa(kd_plant));
                  urlRedirect = urlRedirect.replace('param2', window.btoa(bulan));
                  urlRedirect = urlRedirect.replace('param', window.btoa(tahun));
                  window.open(urlRedirect, '_blank');
                }
              }, 
            }
          });
        };
      @endif
    </script>
  @endsection
@endif