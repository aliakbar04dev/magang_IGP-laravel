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
                      <a style="color: black" href="{{ route('qprs.indexstatus', base64_encode('2')) }}">
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
                      <a style="color: black" href="{{ route('qprs.indexstatus', base64_encode('4')) }}">
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
                      <a style="color: black" href="{{ route('qprs.indexstatus', base64_encode('5')) }}">
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
                      <a style="color: black" href="{{ route('picas.indexstatus', base64_encode('D')) }}">
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
                      <a style="color: black" href="{{ route('picas.indexstatus', base64_encode('S')) }}">
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
                      <a style="color: black" href="{{ route('qprs.indexstatus', base64_encode('7')) }}">
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
                      <a style="color: black" href="{{ route('picas.indexstatus', base64_encode('A')) }}">
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
                      <a style="color: black" href="{{ route('picas.indexstatus', base64_encode('R')) }}">
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
                      <a style="color: black" href="{{ route('picas.indexstatus', base64_encode('BJ')) }}">
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
                      <a style="color: black" href="{{ route('picas.indexstatus', base64_encode('RS')) }}">
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
                      <a style="color: black" href="{{ route('picas.indexstatus', base64_encode('C')) }}">
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
                      <a style="color: black" href="{{ route('picas.indexstatus', base64_encode('BC')) }}">
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
                      <a style="color: black" href="{{ route('picas.indexstatus', base64_encode('OD')) }}">
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
                      <a style="color: black" href="{{ route('picas.indexstatus', base64_encode('E')) }}">
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
                      <a style="color: black" href="{{ route('picas.indexstatus', base64_encode('DM')) }}">
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
                      <a style="color: black" href="{{ route('picas.indexstatus', base64_encode('RO')) }}">
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