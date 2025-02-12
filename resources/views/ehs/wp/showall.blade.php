@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ijin Kerja
        <small>Detail Ijin Kerja</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> EHS - Transaksi</li>
        <li><a href="{{ route('ehstwp1s.all') }}"><i class="fa fa-files-o"></i> Ijin Kerja</a></li>
        <li class="active">Detail {{ $ehstwp1->no_wp }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detail Ijin Kerja</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 10%;"><b>No. WP</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 30%;">{{ $ehstwp1->no_wp }}</td>
                    <td style="width: 10%;"><b>Tgl WP</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ \Carbon\Carbon::parse($ehstwp1->tgl_wp)->format('d/m/Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Tgl Revisi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 30%;">
                      {{ \Carbon\Carbon::parse($ehstwp1->tgl_rev)->format('d/m/Y') }}
                    </td>
                    <td style="width: 10%;"><b>No. Revisi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if ($ehstwp1->historys()->get()->count() > 0)
                          {{ $ehstwp1->no_rev }}
                        @foreach ($ehstwp1->historys()->get() as $history)
                          @if (Auth::user()->can(['ehs-wp-view','ehs-wp-create','ehs-wp-delete','ehs-wp-approve-*','ehs-wp-reject-*']))
                            {{ "&nbsp;-&nbsp;&nbsp;" }}<a target="_blank" href="{{ route('ehstwp1s.showrevisi', base64_encode($history->id)) }}" data-toggle="tooltip" data-placement="top" title="Show History WP No. Revisi {{ $history->no_rev }}">{{ $history->no_rev }}</a>
                          @else
                            {{ "&nbsp;-&nbsp;&nbsp;".$history->no_rev }}
                          @endif
                        @endforeach
                      @else
                        {{ $ehstwp1->no_rev }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Site</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 30%;">{{ $ehstwp1->kd_site }} ({{ $ehstwp1->nm_site }})</td>
                    <td style="width: 10%;"><b>Status PO</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if ($ehstwp1->status_po === "T")
                        PO
                      @else
                        NON PO
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>No. PP</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 30%;">{{ $ehstwp1->no_pp }}</td>
                    <td style="width: 10%;"><b>No. PO</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $ehstwp1->no_po }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Nama Proyek</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 30%;">{{ $ehstwp1->nm_proyek }}</td>
                    <td style="width: 10%;"><b>Lokasi Proyek</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $ehstwp1->lok_proyek }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>PIC</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 30%;">{{ $ehstwp1->pic_pp }}</td>
                    <td style="width: 10%;"><b>Nama PIC</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if (!empty($ehstwp1->pic_pp))
                        {{ $ehstwp1->masKaryawan($ehstwp1->pic_pp)->nama }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Bagian PIC</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($ehstwp1->pic_pp))
                        {{ $ehstwp1->masKaryawan($ehstwp1->pic_pp)->desc_div." - ".$ehstwp1->masKaryawan($ehstwp1->pic_pp)->desc_dep }} ({{ $ehstwp1->masKaryawan($ehstwp1->pic_pp)->kode_dep }})
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Pelaksanaan</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 30%;">
                      {{ \Carbon\Carbon::parse($ehstwp1->tgl_laksana1)->format('d M Y H:i')." s/d ".\Carbon\Carbon::parse($ehstwp1->tgl_laksana2)->format('d M Y H:i') }}
                    </td>
                    <td style="width: 10%;"><b>Perpanjangan</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $ehstwp1->no_perpanjang }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Kategori Pekerjaan</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      <input type="checkbox" name="kat_kerja_sfp" id="kat_kerja_sfp" value="{{ $ehstwp1->kat_kerja_sfp }}" class="icheckbox_square-blue" disabled @if ($ehstwp1->kat_kerja_sfp === "T") checked @endif>Safe Work Permit
                      &nbsp;
                      <input type="checkbox" name="kat_kerja_hwp" id="kat_kerja_hwp" value="{{ $ehstwp1->kat_kerja_hwp }}" class="icheckbox_square-blue" disabled @if ($ehstwp1->kat_kerja_hwp === "T") checked @endif>Hot Work Permit
                      &nbsp;
                      <input type="checkbox" name="kat_kerja_csp" id="kat_kerja_csp" value="{{ $ehstwp1->kat_kerja_csp }}" class="icheckbox_square-blue" disabled @if ($ehstwp1->kat_kerja_csp === "T") checked @endif>Confined Space Permit
                      &nbsp;
                      <input type="checkbox" name="kat_kerja_hpp" id="kat_kerja_hpp" value="{{ $ehstwp1->kat_kerja_hpp }}" class="icheckbox_square-blue" disabled @if ($ehstwp1->kat_kerja_hpp === "T") checked @endif>High Place Permit
                      &nbsp;
                      <input type="checkbox" name="kat_kerja_ele" id="kat_kerja_ele" value="{{ $ehstwp1->kat_kerja_ele }}" class="icheckbox_square-blue" disabled @if ($ehstwp1->kat_kerja_ele === "T") checked @endif>Electrical
                      &nbsp;
                      <input type="checkbox" name="kat_kerja_oth" id="kat_kerja_oth" value="{{ $ehstwp1->kat_kerja_oth }}" class="icheckbox_square-blue" disabled @if ($ehstwp1->kat_kerja_oth === "T") checked @endif>Others
                    </td>
                  </tr>
                  @if ($ehstwp1->kat_kerja_oth === "T") 
                    <tr>
                      <td style="width: 10%;"><b>Keterangan Kat. Pekerjaan</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $ehstwp1->kat_kerja_ket }}
                      </td>
                    </tr>
                  @endif
                  <tr>
                    <td style="width: 10%;"><b>Alat yg digunakan</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 30%;">{{ $ehstwp1->alat_pakai }}</td>
                    <td style="width: 10%;"><b>Tgl Expired</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if (!empty($ehstwp1->tgl_expired))
                        {{ \Carbon\Carbon::parse($ehstwp1->tgl_expired)->format('d/m/Y H:i') }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Creaby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 30%;">{{ $ehstwp1->creaby." - ".$ehstwp1->nama($ehstwp1->creaby)." - ".\Carbon\Carbon::parse($ehstwp1->dtcrea)->format('d/m/Y H:i') }}</td>
                    <td style="width: 10%;"><b>Modiby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $ehstwp1->modiby." - ".$ehstwp1->nama($ehstwp1->modiby)." - ".\Carbon\Carbon::parse($ehstwp1->dtmodi)->format('d/m/Y H:i') }}</td>
                  </tr>
                  @if (!empty($ehstwp1->submit_tgl))
                    <tr>
                      <td style="width: 8%;"><b>Tgl Submit</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        @if (!empty($ehstwp1->submit_tgl))
                          {{ \Carbon\Carbon::parse($ehstwp1->submit_tgl)->format('d/m/Y H:i') }}
                        @endif  
                      </td>
                      <td style="width: 8%;"><b>PIC Submit</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $ehstwp1->submit_pic." - ".$ehstwp1->nama($ehstwp1->submit_pic) }}</td>
                    </tr>
                  @endif
                  @if (!empty($ehstwp1->approve_prc_tgl))
                    <tr>
                      <td style="width: 8%;"><b>Tgl Approve PRC</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        {{ \Carbon\Carbon::parse($ehstwp1->approve_prc_tgl)->format('d/m/Y H:i') }}
                      </td>
                      <td style="width: 8%;"><b>PIC Approve PRC</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $ehstwp1->approve_prc_pic." - ".$ehstwp1->nama($ehstwp1->approve_prc_pic) }}</td>
                    </tr>
                  @endif
                  @if (!empty($ehstwp1->reject_prc_tgl))
                    <tr>
                      <td style="width: 8%;"><b>Tgl Reject PRC</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        {{ \Carbon\Carbon::parse($ehstwp1->reject_prc_tgl)->format('d/m/Y H:i') }}
                      </td>
                      <td style="width: 8%;"><b>PIC Reject PRC</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>
                        {{ $ehstwp1->reject_prc_pic." - ".$ehstwp1->nama($ehstwp1->reject_prc_pic) }}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 10%;"><b>Ket. Reject PRC</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $ehstwp1->statusReject($ehstwp1->reject_prc_st)." - ".$ehstwp1->reject_prc_ket }}
                        </td>
                    </tr>
                  @endif
                  @if (!empty($ehstwp1->approve_user_tgl))
                    <tr>
                      <td style="width: 8%;"><b>Tgl Approve Project Owner</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        {{ \Carbon\Carbon::parse($ehstwp1->approve_user_tgl)->format('d/m/Y H:i') }}
                      </td>
                      <td style="width: 8%;"><b>PIC Approve Project Owner</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $ehstwp1->approve_user_pic." - ".$ehstwp1->nama($ehstwp1->approve_user_pic) }}</td>
                    </tr>
                  @endif
                  @if (!empty($ehstwp1->reject_user_tgl))
                    <tr>
                      <td style="width: 8%;"><b>Tgl Reject Project Owner</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        {{ \Carbon\Carbon::parse($ehstwp1->reject_user_tgl)->format('d/m/Y H:i') }}
                      </td>
                      <td style="width: 8%;"><b>PIC Reject Project Owner</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>
                        {{ $ehstwp1->reject_user_pic." - ".$ehstwp1->nama($ehstwp1->reject_user_pic) }}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 10%;"><b>Ket. Reject Project Owner</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $ehstwp1->statusReject($ehstwp1->reject_user_st)." - ".$ehstwp1->reject_user_ket }}
                        </td>
                    </tr>
                  @endif
                  @if (!empty($ehstwp1->approve_ehs_tgl))
                    <tr>
                      <td style="width: 8%;"><b>Tgl Approve EHS</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        {{ \Carbon\Carbon::parse($ehstwp1->approve_ehs_tgl)->format('d/m/Y H:i') }}
                      </td>
                      <td style="width: 8%;"><b>PIC Approve EHS</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $ehstwp1->approve_ehs_pic." - ".$ehstwp1->nama($ehstwp1->approve_ehs_pic) }}</td>
                    </tr>
                  @endif
                  @if (!empty($ehstwp1->reject_ehs_tgl))
                    <tr>
                      <td style="width: 8%;"><b>Tgl Reject EHS</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        {{ \Carbon\Carbon::parse($ehstwp1->reject_ehs_tgl)->format('d/m/Y H:i') }}
                      </td>
                      <td style="width: 8%;"><b>PIC Reject EHS</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>
                        {{ $ehstwp1->reject_ehs_pic." - ".$ehstwp1->nama($ehstwp1->reject_ehs_pic) }}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 10%;"><b>Ket. Reject EHS</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $ehstwp1->statusReject($ehstwp1->reject_ehs_st)." - ".$ehstwp1->reject_ehs_ket }}
                        </td>
                    </tr>
                  @endif
                  @if (!empty($ehstwp1->tgl_close))
                    <tr>
                      <td style="width: 8%;"><b>Tgl Close</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        @if (!empty($ehstwp1->tgl_close))
                          {{ \Carbon\Carbon::parse($ehstwp1->tgl_close)->format('d/m/Y H:i') }}
                        @endif  
                      </td>
                      <td style="width: 8%;"><b>PIC Close</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $ehstwp1->pic_close." - ".$ehstwp1->nama($ehstwp1->pic_close) }}</td>
                    </tr>
                  @endif
                  @if (!empty($ehstwp1->scan_sec_in_tgl))
                    <tr>
                      <td style="width: 8%;"><b>Tgl Scan IN</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        @if (!empty($ehstwp1->scan_sec_in_tgl))
                          {{ \Carbon\Carbon::parse($ehstwp1->scan_sec_in_tgl)->format('d/m/Y H:i') }}
                        @endif  
                      </td>
                      <td style="width: 8%;"><b>PIC Scan IN</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $ehstwp1->scan_sec_in_npk." - ".$ehstwp1->masKaryawan($ehstwp1->scan_sec_in_npk)->nama }}</td>
                    </tr>
                  @endif
                  @if (!empty($ehstwp1->scan_sec_out_tgl))
                    <tr>
                      <td style="width: 8%;"><b>Tgl Scan OUT</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        @if (!empty($ehstwp1->scan_sec_out_tgl))
                          {{ \Carbon\Carbon::parse($ehstwp1->scan_sec_out_tgl)->format('d/m/Y H:i') }}
                        @endif  
                      </td>
                      <td style="width: 8%;"><b>PIC Scan OUT</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $ehstwp1->scan_sec_out_npk." - ".$ehstwp1->masKaryawan($ehstwp1->scan_sec_out_npk)->nama }}</td>
                    </tr>
                  @endif
                  <tr>
                    <td style="width: 8%;"><b>Status</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">{{ $ehstwp1->ket_status }}</td>
                  </tr>
                  @if (!empty($ehstwp1->approve_ehs_tgl))
                    <tr>
                      <td style="width: 8%;"><b>Jenis Pekerjaan</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        @if ($ehstwp1->jns_pekerjaan === "H")
                          High Risk
                        @elseif ($ehstwp1->jns_pekerjaan === "M")
                          Medium Risk
                        @else
                          Low Risk
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 8%;"><b>APD / Peralatan yang wajib dibawa</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        @if (!empty($ehstwp1->apd_1))
                          - {{ $ehstwp1->apd_1 }} <BR>
                        @endif
                        @if (!empty($ehstwp1->apd_2))
                          - {{ $ehstwp1->apd_2 }} <BR>
                        @endif
                        @if (!empty($ehstwp1->apd_3))
                          - {{ $ehstwp1->apd_3 }} <BR>
                        @endif
                        @if (!empty($ehstwp1->apd_4))
                          - {{ $ehstwp1->apd_4 }} <BR>
                        @endif
                        @if (!empty($ehstwp1->apd_5))
                          - {{ $ehstwp1->apd_5 }} <BR>
                        @endif
                        @if (!empty($ehstwp1->apd_6))
                          - {{ $ehstwp1->apd_6 }} <BR>
                        @endif
                        @if (!empty($ehstwp1->apd_7))
                          - {{ $ehstwp1->apd_7 }} <BR>
                        @endif
                        @if (!empty($ehstwp1->apd_8))
                          - {{ $ehstwp1->apd_8 }} <BR>
                        @endif
                        @if (!empty($ehstwp1->apd_9))
                          - {{ $ehstwp1->apd_9 }} <BR>
                        @endif
                        @if (!empty($ehstwp1->apd_10))
                          - {{ $ehstwp1->apd_10 }} <BR>
                        @endif
                        @if (!empty($ehstwp1->apd_11))
                          - {{ $ehstwp1->apd_11 }} <BR>
                        @endif
                      </td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
            
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active" id="nav_mp">
                <a href="#mp" aria-controls="mp" role="tab" data-toggle="tab" title="List Member">
                  B. List Member
                </a>
              </li>
              <li role="presentation" id="nav_k3">
                <a href="#k3" aria-controls="k3" role="tab" data-toggle="tab" title="Identifikasi Bahaya">
                  C. Identifikasi Bahaya
                </a>
              </li>
              <li role="presentation" id="nav_env">
                <a href="#env" aria-controls="env" role="tab" data-toggle="tab" title="Identifikasi Aspek Dampak Lingkungan">
                  D. Identifikasi Aspek Dampak Lingkungan
                </a>
              </li>
            </ul>
            <!-- /.tablist -->

            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="mp">
                <div class="box-body" id="field-mp">
                  @foreach ($ehstwp1->ehstWp2MpsNotNull()->get() as $ehstWp2Mp)
                    <div class="row" id="field_mp_{{ $loop->iteration }}">
                      <div class="col-md-12">
                        <div class="box box-primary">
                          <div class="box-header with-border">
                            <h3 class="box-title" id="box_mp_{{ $loop->iteration }}">Member Ke-{{ $loop->iteration }}</h3>
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
                                {!! Form::label('nm_mp_'.$loop->iteration, 'Nama') !!}
                                {!! Form::text('nm_mp_'.$loop->iteration, $ehstWp2Mp->nm_mp, ['class'=>'form-control', 'placeholder' => 'Nama', 'maxlength' => 50, 'readonly'=>'readonly']) !!}
                                {!! Form::hidden('ehst_wp2_mp_id'.$loop->iteration, base64_encode($ehstWp2Mp->id), ['class'=>'form-control', 'readonly'=>'readonly']) !!}
                                {!! Form::hidden('ehst_wp2_mp_seq'.$loop->iteration, $ehstWp2Mp->no_seq, ['class'=>'form-control', 'readonly'=>'readonly']) !!}
                              </div>
                              <div class="col-sm-3">
                                {!! Form::label('no_id_'.$loop->iteration, 'No. Identitas') !!}
                                {!! Form::text('no_id_'.$loop->iteration, $ehstWp2Mp->no_id, ['class'=>'form-control', 'placeholder' => 'No. Identitas', 'maxlength' => 20, 'readonly'=>'readonly']) !!}
                              </div>
                              {{-- <div class="col-sm-2">
                                {!! Form::label('st_ap_'.$loop->iteration, 'Status') !!}
                                {!! Form::select('st_ap_'.$loop->iteration, ['A' => 'Aktif', 'P' => 'Penambahan'], $ehstWp2Mp->st_ap, ['class'=>'form-control select2', 'required', 'readonly'=>'readonly']) !!}
                              </div> --}}
                              <div class="col-sm-5">
                                {!! Form::label('ket_remarks_'.$loop->iteration, 'Remarks') !!}
                                {!! Form::text('ket_remarks_'.$loop->iteration, $ehstWp2Mp->ket_remarks, ['class'=>'form-control', 'placeholder' => 'Remarks', 'maxlength' => 50, 'readonly'=>'readonly']) !!}
                              </div>
                            </div>
                            <!-- /.form-group -->
                            @if (!empty($ehstWp2Mp->pict_id))
                              <div class="row form-group">
                                <div class="col-sm-4">
                                  <label name="pict_id_{{ $loop->iteration }}">Foto Identitas (KTP)</label>
                                  <p>
                                    <img src="{{ $ehstWp2Mp->pictId() }}" alt="File Not Found" class="img-rounded img-responsive">
                                  </p>
                                </div>
                              </div>
                              <!-- /.form-group -->
                            @endif
                          </div>
                          <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- /.row -->
                  @endforeach
                  {!! Form::hidden('jml_row_mp', $ehstwp1->ehstWp2Mps()->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_mp']) !!}
                </div>
                <!-- /.box-body -->
                <div class="box-body">
                  <p class="pull-right">
                    <button id="nextRowMp" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Next to Identifikasi Bahaya"><span class="glyphicon glyphicon-arrow-right"></span> Next to Identifikasi Bahaya</button>
                  </p>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.tabpanel -->
              <div role="tabpanel" class="tab-pane" id="k3">
                <div class="box-body" id="field-k3">
                  @foreach ($ehstwp1->ehstWp2K3sNotNull()->get() as $ehstWp2K3)
                    <div class="row" id="field_k3_{{ $loop->iteration }}">
                      <div class="col-md-12">
                        <div class="box box-primary">
                          <div class="box-header with-border">
                            <h3 class="box-title" id="box_k3_{{ $loop->iteration }}">Identifikasi Bahaya Ke-{{ $loop->iteration }}</h3>
                            <div class="box-tools pull-right">
                              <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                              </button>
                            </div>
                          </div>
                          <!-- /.box-header -->
                          <div class="box-body">
                            <div class="row form-group">
                              <div class="col-sm-3">
                                {!! Form::label('ket_aktifitas_'.$loop->iteration, 'Aktifitas / Produk / Jasa') !!}
                                {!! Form::textarea('ket_aktifitas_'.$loop->iteration, $ehstWp2K3->ket_aktifitas, ['class'=>'form-control', 'placeholder' => 'Aktifitas / Produk / Jasa', 'rows' => '3', 'maxlength' => 100, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                                {!! Form::hidden('ehst_wp2_k3_id'.$loop->iteration, base64_encode($ehstWp2K3->id), ['class'=>'form-control', 'readonly'=>'readonly']) !!}
                                {!! Form::hidden('ehst_wp2_k3_seq'.$loop->iteration, $ehstWp2K3->no_seq, ['class'=>'form-control', 'readonly'=>'readonly']) !!}
                              </div>
                              <div class="col-sm-3">
                                {!! Form::label('ib_potensi_'.$loop->iteration, 'Potensi Bahaya') !!}
                                {!! Form::textarea('ib_potensi_'.$loop->iteration, $ehstWp2K3->ib_potensi, ['class'=>'form-control', 'placeholder' => 'Potensi Bahaya', 'rows' => '3', 'maxlength' => 200, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                              </div>
                              <div class="col-sm-3">
                                {!! Form::label('ib_resiko_'.$loop->iteration, 'Resiko') !!}
                                {!! Form::textarea('ib_resiko_'.$loop->iteration, $ehstWp2K3->ib_resiko, ['class'=>'form-control', 'placeholder' => 'Resiko', 'rows' => '3', 'maxlength' => 200, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                              </div>
                              <div class="col-sm-3">
                                {!! Form::label('pencegahan_'.$loop->iteration, 'Tindakan Pencegahan') !!}
                                {!! Form::textarea('pencegahan_'.$loop->iteration, $ehstWp2K3->pencegahan, ['class'=>'form-control', 'placeholder' => 'Tindakan Pencegahan', 'rows' => '3', 'maxlength' => 200, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
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
                  {!! Form::hidden('jml_row_k3', $ehstwp1->ehstWp2K3s()->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_k3']) !!}
                </div>
                <!-- /.box-body -->
                <div class="box-body">
                  <p class="pull-right">
                    <button id="nextRowK3" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Next to Identifikasi Aspek Dampak Lingkungan"><span class="glyphicon glyphicon-arrow-right"></span> Next to Identifikasi Aspek Dampak Lingkungan</button>
                  </p>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.tabpanel -->
              <div role="tabpanel" class="tab-pane" id="env">
                <div class="box-body" id="field-env">
                  @foreach ($ehstwp1->ehstWp2EnvsNotNull()->get() as $ehstWp2Env)
                    <div class="row" id="field_env_{{ $loop->iteration }}">
                      <div class="col-md-12">
                        <div class="box box-primary">
                          <div class="box-header with-border">
                            <h3 class="box-title" id="box_env_{{ $loop->iteration }}">Identifikasi Aspek Dampak Lingkungan Ke-{{ $loop->iteration }}</h3>
                            <div class="box-tools pull-right">
                              <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                              </button>
                            </div>
                          </div>
                          <!-- /.box-header -->
                          <div class="box-body">
                            <div class="row form-group">
                              <div class="col-sm-3">
                                {!! Form::label('ket_aktifitas_env_'.$loop->iteration, 'Aktifitas / Produk / Jasa') !!}
                                {!! Form::textarea('ket_aktifitas_env_'.$loop->iteration, $ehstWp2Env->ket_aktifitas, ['class'=>'form-control', 'placeholder' => 'Aktifitas / Produk / Jasa', 'rows' => '3', 'maxlength' => 100, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                                {!! Form::hidden('ehst_wp2_env_id'.$loop->iteration, base64_encode($ehstWp2Env->id), ['class'=>'form-control', 'readonly'=>'readonly']) !!}
                                {!! Form::hidden('ehst_wp2_env_seq'.$loop->iteration, $ehstWp2Env->no_seq, ['class'=>'form-control', 'readonly'=>'readonly']) !!}
                              </div>
                              <div class="col-sm-3">
                                {!! Form::label('ket_aspek_'.$loop->iteration, 'Aspek Dampak') !!}
                                {!! Form::textarea('ket_aspek_'.$loop->iteration, $ehstWp2Env->ket_aspek, ['class'=>'form-control', 'placeholder' => 'Aspek Dampak', 'rows' => '3', 'maxlength' => 200, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                              </div>
                              <div class="col-sm-3">
                                {!! Form::label('ket_dampak_'.$loop->iteration, 'Dampak Lingkungan') !!}
                                {!! Form::textarea('ket_dampak_'.$loop->iteration, $ehstWp2Env->ket_dampak, ['class'=>'form-control', 'placeholder' => 'Dampak Lingkungan', 'rows' => '3', 'maxlength' => 200, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
                              </div>
                              <div class="col-sm-3">
                                {!! Form::label('pencegahan_env_'.$loop->iteration, 'Tindakan Pencegahan') !!}
                                {!! Form::textarea('pencegahan_env_'.$loop->iteration, $ehstWp2Env->pencegahan, ['class'=>'form-control', 'placeholder' => 'Tindakan Pencegahan', 'rows' => '3', 'maxlength' => 200, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
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
                  {!! Form::hidden('jml_row_env', $ehstwp1->ehstWp2Envs()->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_env']) !!}
                </div>
                <!-- /.box-body -->
                <div class="box-body">
                  <p class="pull-right">
                    <button id="nextRowEnv" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Back to List Member"><span class="glyphicon glyphicon-arrow-right"></span> Back to List Member</button>
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
      @if (strtoupper($ehstwp1->status) === 'SUBMIT')
        @if (Auth::user()->can('ehs-wp-approve-prc'))
          <button id='btnapprove' type='button' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Approve PRC WP: {{ $ehstwp1->no_wp }}' onclick='approveIjinKerja("{{ base64_encode($ehstwp1->id) }}", "{{ base64_encode($ehstwp1->no_wp) }}", "{{ base64_encode($ehstwp1->pic_pp) }}", "{{ base64_encode($ehstwp1->nm_pic) }}", "PRC")'>
            <span class='glyphicon glyphicon-check'></span> Approve PRC WP
          </button>
          &nbsp;&nbsp;
        @endif
        @if (Auth::user()->can('ehs-wp-reject-prc'))
          <button id='btnreject' type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Reject PRC WP: {{ $ehstwp1->no_wp }}' onclick='rejectIjinKerja("{{ base64_encode($ehstwp1->id) }}", "{{ base64_encode($ehstwp1->no_wp) }}", "PRC")'>
            <span class='glyphicon glyphicon-remove'></span> Reject PRC WP
          </button>
          &nbsp;&nbsp;
        @endif
      @elseif (strtoupper($ehstwp1->status) === 'PRC')
        @if (Auth::user()->can('ehs-wp-approve-user') && $ehstwp1->pic_pp === Auth::user()->username)
          <button id='btnapprove' type='button' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Approve Project Owner WP: {{ $ehstwp1->no_wp }}' onclick='approveIjinKerja("{{ base64_encode($ehstwp1->id) }}", "{{ base64_encode($ehstwp1->no_wp) }}", "{{ base64_encode($ehstwp1->pic_pp) }}", "{{ base64_encode($ehstwp1->nm_pic) }}", "USER")'>
            <span class='glyphicon glyphicon-check'></span> Approve Project Owner WP
          </button>
          &nbsp;&nbsp;
        @endif
        @if (Auth::user()->can('ehs-wp-reject-user') && $ehstwp1->pic_pp === Auth::user()->username)
          {{-- &nbsp;&nbsp; --}}
          <button id='btnreject' type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Reject Project Owner WP: {{ $ehstwp1->no_wp }}' onclick='rejectIjinKerja("{{ base64_encode($ehstwp1->id) }}", "{{ base64_encode($ehstwp1->no_wp) }}", "USER")'>
            <span class='glyphicon glyphicon-remove'></span> Reject Project Owner WP
          </button>
          &nbsp;&nbsp;
        @endif
      @elseif (strtoupper($ehstwp1->status) === 'USER')
        @if (Auth::user()->can('ehs-wp-approve-ehs'))
          <button id='btnapprove' type='button' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Approve EHS WP: {{ $ehstwp1->no_wp }}' onclick='approveIjinKerja("{{ base64_encode($ehstwp1->id) }}", "{{ base64_encode($ehstwp1->no_wp) }}", "{{ base64_encode($ehstwp1->pic_pp) }}", "{{ base64_encode($ehstwp1->nm_pic) }}", "EHS")'>
            <span class='glyphicon glyphicon-check'></span> Approve EHS WP
          </button>
          &nbsp;&nbsp;
        @endif
        @if (Auth::user()->can('ehs-wp-reject-ehs'))
          {{-- &nbsp;&nbsp; --}}
          <button id='btnreject' type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Reject EHS WP: {{ $ehstwp1->no_wp }}' onclick='rejectIjinKerja("{{ base64_encode($ehstwp1->id) }}", "{{ base64_encode($ehstwp1->no_wp) }}", "EHS")'>
            <span class='glyphicon glyphicon-remove'></span> Reject EHS WP
          </button>
          &nbsp;&nbsp;
        @endif
      @elseif (strtoupper($ehstwp1->status) === 'EHS')
        <a target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Print Ijin Kerja {{ $ehstwp1->no_wp }}" href="{{ route('ehstwp1s.print', base64_encode($ehstwp1->id)) }}"><span class='glyphicon glyphicon-print'></span> Print Ijin Kerja</a>
        &nbsp;&nbsp;
      @elseif (strtoupper($ehstwp1->status) === 'SCAN_IN' || strtoupper($ehstwp1->status) === 'SCAN_OUT')
        <a target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Print Ijin Kerja {{ $ehstwp1->no_wp }}" href="{{ route('ehstwp1s.print', base64_encode($ehstwp1->id)) }}"><span class='glyphicon glyphicon-print'></span> Print Ijin Kerja</a>
        &nbsp;&nbsp;
      @endif
      <a class="btn btn-primary" href="{{ route('ehstwp1s.all') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard Ijin Kerja">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">
  
  function approveIjinKerja(id, no_wp, pic_pp, nm_pic, status)
  {
    var no_wp = window.atob(no_wp);
    var pic_pp = window.atob(pic_pp);
    var nm_pic = window.atob(nm_pic);
    var msg = 'Anda yakin APPROVE data ini?';
    var txt = 'No. WP: ' + no_wp;
    if(status === "PRC") {
      msg = 'Anda yakin APPROVE No. WP: ' + no_wp + '?';
      //additional input validations can be done hear
      swal({
        title: msg, 
        html:
          'PIC saat ini: ' + pic_pp + ' - ' + nm_pic + '<BR>' +
          '<select class="form-control select2" required="required" id="swal-input1" name="swal-input1">' +
            '<option value="-">Pilih PIC jika Anda ingin mengubah PIC saat ini</option>' +
            @foreach($ehsmwppics->get() as $ehsmwppic)
              '<option value="{{$ehsmwppic->npk}}">{{ $ehsmwppic->nama }} - {{ $ehsmwppic->npk }} - {{ $ehsmwppic->bagian }}</option>' +
            @endforeach
          '</select>',
        preConfirm: function () {
          return new Promise(function (resolve, reject) {
            resolve([
              $('#swal-input1').val()
            ])
          })
        }
      }).then(function (result) {
        if(result[0] == null || result[0] == "") {
          result[0] = "-";
        }
        var token = document.getElementsByName('_token')[0].value.trim();
        // save via ajax
        // create data detail dengan ajax
        var url = "{{ route('ehstwp1s.approve')}}";
        $("#loading").show();
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method      : 'POST',
            // menambah csrf token dari Laravel
            _token       : token,
            id           : id,
            status       : window.btoa(status),
            new_pic      : window.btoa(result[0]),
          },
          success:function(data){
            $("#loading").hide();
            if(data.status === 'OK'){
              swal("Approved", data.message, "success");
              var urlRedirect = "{{ route('ehstwp1s.showall', 'param') }}";
              urlRedirect = urlRedirect.replace('param', id);
              window.location.href = urlRedirect;
            } else {
              swal("Cancelled", data.message, "error");
            }
          }, error:function(){ 
            $("#loading").hide();
            swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");
          }
        });
      }).catch(swal.noop)
    } else if(status === "EHS") {
      //additional input validations can be done hear
      swal({
        title: msg,
        text: txt,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, approve it!',
        cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
        allowOutsideClick: true,
        allowEscapeKey: true,
        allowEnterKey: true,
        reverseButtons: false,
        focusCancel: true,
      }).then(function () {
        swal({
          title: 'APD / Peralatan yang wajib dibawa',
          html:
            '<select class="form-control select2" required="required" id="swal-input4" name="swal-input4"><option selected="selected" value="">Pilih Jenis Pekerjaan</option><option value="H">High Risk</option><option value="M">Medium Risk</option><option value="L">Low Risk</option></select><BR>' +
            '<select multiple class="form-control" id="swal-input1" name="swal-input1" style="height: 180px">' +
              '<option value="Helmet">1. Helmet</option>' +
              '<option value="Topi">2. Topi</option>' +
              '<option value="Full Body Hardness 2 Hock">3. Full Body Hardness 2 Hock</option>' +
              '<option value="Kacamata Safety / Welding Face">4. Kacamata Safety / Welding Face</option>' +
              '<option value="Masker Biasa / Respirator">5. Masker Biasa / Respirator</option>' +
              '<option value="Sarung Tangan (Katun/Kulit/Karet)">6. Sarung Tangan (Katun/Kulit/Karet)</option>' +
              '<option value="Sepatu Safety / Biasa">7. Sepatu Safety / Biasa</option>' +
              '<option value="Tanda Peringatan / Petunjuk">8. Tanda Peringatan / Petunjuk</option>' +
              '<option value="Partisi / Karung Basah / Cover">9. Partisi / Karung Basah / Cover</option>' +
            '</select><br>' + 
            '<textarea id="swal-input2" class="form-control" maxlength="300" rows="3" cols="20" placeholder="10. Alat Pemadam Kebakaran\nAPAR jenis ... jumlah ... buah (Max. 300 Karakter)" style="resize:vertical"></textarea><br>' + 
            '<textarea id="swal-input3" class="form-control" maxlength="300" rows="3" cols="20" placeholder="11. Dll. (Alat Kebersihan/Breathing Aparatus/Tali) (Max. 300 Karakter)" style="resize:vertical"></textarea>',
          preConfirm: function () {
            return new Promise(function (resolve, reject) {
              if ($('#swal-input4').val()) {
                resolve([
                  $('#swal-input1').val(),
                  $('#swal-input2').val(),
                  $('#swal-input3').val(),
                  $('#swal-input4').val()
                ])
              } else {
                reject('Jenis Pekerjaan tidak boleh kosong!')
              }
            })
          }
        }).then(function (result) {
          if(result[0] == null || result[0] == "") {
            result[0] = "-";
          }
          if(result[1] == null || result[1] == "") {
            result[1] = "-";
          }
          if(result[2] == null || result[2] == "") {
            result[2] = "-";
          }
          if(result[3] == null || result[3] == "") {
            result[3] = "L";
          }

          var token = document.getElementsByName('_token')[0].value.trim();
          // save via ajax
          // create data detail dengan ajax
          var url = "{{ route('ehstwp1s.approveehs')}}";
          $("#loading").show();
          $.ajax({
            type     : 'POST',
            url      : url,
            dataType : 'json',
            data     : {
              _method      : 'POST',
              // menambah csrf token dari Laravel
              _token        : token,
              id            : id,
              status        : window.btoa(status),
              apd1          : window.btoa(result[0]),
              apd2          : window.btoa(result[1]),
              apd3          : window.btoa(result[2]),
              jns_pekerjaan : window.btoa(result[3]),
            },
            success:function(data){
              $("#loading").hide();
              if(data.status === 'OK'){
                swal("Approved", data.message, "success");
                var urlRedirect = "{{ route('ehstwp1s.showall', 'param') }}";
                urlRedirect = urlRedirect.replace('param', id);
                window.location.href = urlRedirect;
              } else {
                swal("Cancelled", data.message, "error");
              }
            }, error:function(){ 
              $("#loading").hide();
              swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");
            }
          });
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
    } else {
      //additional input validations can be done hear
      swal({
        title: msg,
        text: txt,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, approve it!',
        cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
        allowOutsideClick: true,
        allowEscapeKey: true,
        allowEnterKey: true,
        reverseButtons: false,
        focusCancel: true,
      }).then(function () {
        var token = document.getElementsByName('_token')[0].value.trim();
        // save via ajax
        // create data detail dengan ajax
        var url = "{{ route('ehstwp1s.approve')}}";
        $("#loading").show();
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method      : 'POST',
            // menambah csrf token dari Laravel
            _token       : token,
            id           : id,
            status       : window.btoa(status),
            new_pic      : window.btoa("-"),
          },
          success:function(data){
            $("#loading").hide();
            if(data.status === 'OK'){
              swal("Approved", data.message, "success");
              var urlRedirect = "{{ route('ehstwp1s.showall', 'param') }}";
              urlRedirect = urlRedirect.replace('param', id);
              window.location.href = urlRedirect;
            } else {
              swal("Cancelled", data.message, "error");
            }
          }, error:function(){ 
            $("#loading").hide();
            swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");
          }
        });
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

  function rejectIjinKerja(id, no_wp, status)
  {
    var no_wp = window.atob(no_wp);
    var msg = 'Anda yakin REJECT data ini?';
    var txt = 'No. WP: ' + no_wp;
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
          '<select class="form-control select2" required="required" id="swal-input1" name="swal-input1"><option selected="selected" value="">Pilih Status</option><option value="S">Request Supplier</option><option value="O">Others</option></select><BR>' +
          '<textarea id="swal-input2" class="form-control" maxlength="500" rows="3" cols="20" placeholder="Keterangan Reject (Max. 500 Karakter)" style="text-transform:uppercase;resize:vertical">',
        preConfirm: function () {
          return new Promise(function (resolve, reject) {
            if ($('#swal-input1').val()) {
              if ($('#swal-input2').val()) {
                if($('#swal-input2').val().length > 500) {
                  reject('Keterangan Reject Max 500 Karakter!')
                } else {
                  resolve([
                    $('#swal-input1').val(),
                    $('#swal-input2').val()
                  ])
                }
              } else {
                reject('Keterangan Reject tidak boleh kosong!')
              }
            } else {
              reject('Status Reject tidak boleh kosong!')
            }
          })
        }
      }).then(function (result) {
        var token = document.getElementsByName('_token')[0].value.trim();
        // save via ajax
        // create data detail dengan ajax
        var url = "{{ route('ehstwp1s.reject')}}";
        $("#loading").show();
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method      : 'POST',
            // menambah csrf token dari Laravel
            _token       : token,
            id           : id,
            status       : window.btoa(status),
            keterangan   : window.btoa(result[1]),
            reject_st    : window.btoa(result[0]),
          },
          success:function(data){
            $("#loading").hide();
            if(data.status === 'OK'){
              swal("Rejected", data.message, "success");
              var urlRedirect = "{{ route('ehstwp1s.showall', 'param') }}";
              urlRedirect = urlRedirect.replace('param', id);
              window.location.href = urlRedirect;
            } else {
              swal("Cancelled", data.message, "error");
            }
          }, error:function(){ 
            $("#loading").hide();
            swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");
          }
        });
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

  function keyPressedNext(param) {
    if(param === "MP") {
      $("#mp").removeClass("active"); // add class to the one we clicked 
      $("#k3").addClass("active");
      $("#nav_mp").removeClass("active"); // add class to the one we clicked 
      $("#nav_k3").addClass("active");
      var key = "k3";
      var jml_row = document.getElementById("jml_row_"+key).value.trim();
      jml_row = Number(jml_row);
      if(jml_row > 0) {
        var no = jml_row-jml_row+1;
        document.getElementById('ket_aktifitas_'+no).focus();
      }
    } else if(param === "K3") {
      $("#k3").removeClass("active"); // add class to the one we clicked 
      $("#env").addClass("active");
      $("#nav_k3").removeClass("active"); // add class to the one we clicked 
      $("#nav_env").addClass("active");
      var key = "env";
      var jml_row = document.getElementById("jml_row_"+key).value.trim();
      jml_row = Number(jml_row);
      if(jml_row > 0) {
        var no = jml_row-jml_row+1;
        document.getElementById('ket_aktifitas_env_'+no).focus();
      }
    } else if(param === "ENV") {
      $("#env").removeClass("active"); // add class to the one we clicked 
      $("#mp").addClass("active");
      $("#nav_env").removeClass("active"); // add class to the one we clicked 
      $("#nav_mp").addClass("active");
      var key = "mp";
      var jml_row = document.getElementById("jml_row_"+key).value.trim();
      jml_row = Number(jml_row);
      if(jml_row > 0) {
        var no = jml_row-jml_row+1;
        document.getElementById('nm_mp_'+no).focus();
      }
    }
  }

  $("#nextRowMp").click(function(){
    keyPressedNext("MP");
  });

  $("#nextRowK3").click(function(){
    keyPressedNext("K3");
  });

  $("#nextRowEnv").click(function(){
    keyPressedNext("ENV");
  });
</script>
@endsection