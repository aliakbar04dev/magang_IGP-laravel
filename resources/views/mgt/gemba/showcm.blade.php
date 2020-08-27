@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Genba BOD - Countermeasure
        <small>Detail Genba BOD - Countermeasure</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> MANAGEMENT - Transaksi</li>
        <li><a href="{{ route('mgmtgembas.indexcm') }}"><i class="fa fa-files-o"></i> Daftar Genba BOD - CM</a></li>
        <li class="active">Detail {{ $mgmtgemba->no_gemba }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detail Genba BOD</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 12%;"><b>No. Genba</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $mgmtgemba->no_gemba }}</td>
                    <td style="width: 10%;"><b>Tgl Genba</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ \Carbon\Carbon::parse($mgmtgemba->tgl_gemba)->format('d/m/Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Site</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">
                      @if ($mgmtgemba->kd_site === "IGPJ")
                        IGP - JAKARTA
                      @elseif ($mgmtgemba->kd_site === "IGPK")
                        IGP - KARAWANG
                      @else 
                        {{ $mgmtgemba->kd_site }}
                      @endif
                    </td>
                    <td style="width: 10%;"><b>PIC Genba</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mgmtgemba->npk_pic }} - {{ $mgmtgemba->initial }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Area</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $mgmtgemba->kd_area }}</td>
                    <td style="width: 10%;"><b>Lokasi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mgmtgemba->lokasi }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Detail</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $mgmtgemba->det_gemba }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Picture</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($mgmtgemba->pict_gemba))
                        <p>
                          <img src="{{ $mgmtgemba->pictGemba() }}" alt="File Not Found" class="img-rounded img-responsive">
                        </p>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Countermeasure</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $mgmtgemba->cm_ket }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>CM Picture</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($mgmtgemba->cm_pict))
                        <p>
                          <img src="{{ $mgmtgemba->cmPict() }}" alt="File Not Found" class="img-rounded img-responsive">
                        </p>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Status Close</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if ($mgmtgemba->st_gemba === "T")
                        YES
                      @else
                        NO
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Creaby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($mgmtgemba->dtcrea))
                        {{ $mgmtgemba->creaby }} - {{ Auth::user()->namaByUsername($mgmtgemba->creaby) }} - {{ \Carbon\Carbon::parse($mgmtgemba->dtcrea)->format('d/m/Y H:i') }}
                      @else
                        {{ $mgmtgemba->creaby }} - {{ Auth::user()->namaByUsername($mgmtgemba->creaby) }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Modiby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($mgmtgemba->dtmodi))
                        {{ $mgmtgemba->modiby }} - {{ Auth::user()->namaByUsername($mgmtgemba->modiby) }} - {{ \Carbon\Carbon::parse($mgmtgemba->dtmodi)->format('d/m/Y H:i') }}
                      @else
                        {{ $mgmtgemba->modiby }} - {{ Auth::user()->namaByUsername($mgmtgemba->modiby) }}
                      @endif
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="box-footer">
        @if ($mgmtgemba->npk_pic === Auth::user()->username && $mgmtgemba->st_gemba !== "T")
          <a class="btn btn-primary" href="{{ route('mgmtgembas.inputcm', base64_encode($mgmtgemba->no_gemba)) }}" data-toggle="tooltip" data-placement="top" title="Input Countermeasure">Input Countermeasure</a>
          &nbsp;&nbsp;
        @endif
        <a class="btn btn-primary" href="{{ route('mgmtgembas.indexcm') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard Daftar Genba BOD - CM">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection