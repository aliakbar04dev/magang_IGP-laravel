<?php
    $hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
?>

<center><button type="button" class="btn btn-info btn-sm" id="detail_{{ $pkl->npk.$pkl->no_pkl }}" data-toggle="modal" data-target="#modalDetail_{{ $pkl->npk.$pkl->no_pkl }}"><i class="fa fa-info"></i>
</button></center>


   
 
<div class="modal fade" id="modalDetail_{{ $pkl->npk.$pkl->no_pkl }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header bg-red">
            <button type="button" class="btn btn-sm btn-default pull-right" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            <h2 class="modal-title"><b>Detail Data PKL</b></h2>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
            <table id="tableInfoPkl" class="table table-striped">
                <tr>
                    <td style="font-weight:bold;">No PKL</td>
                    <td style="width:70%">{{ $pkl->no_pkl }}</td> 
                </tr>  
                <tr>
                    <td style="font-weight:bold;">Nama</td>
                    <td>{{ $pkl->nama }} - {{ $pkl->npk }}</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Jenis PKL</td>
                    @if($pkl->jns_pkl == "AW")
                    <td>Lembur Awal (Awal Shift Kerja)</td>
                    @elseif($pkl->jns_pkl == "AK")
                    <td>Lembur Akhir (Akhir Shift Kerja)</td>
                    @elseif($pkl->jns_pkl == "AA")
                    <td>Lembur Awal Dan Akhir</td>
                    @elseif($pkl->jns_pkl == "LB")
                    <td>Lembur Hari Libur + Hari Biasa</td>
                    @elseif($pkl->jns_pkl == "BL")
                    <td>Lembur Hari Biasa+Libur</td>
                    @elseif($pkl->jns_pkl == "HL")
                    <td>Lembur Hari Libur</td>
                    @elseif($pkl->jns_pkl == "")
                    <td>-</td>
                    @else
                    <td></td>
                    @endif
                </tr>
                <tr>
                    <td style="font-weight:bold;">Tgl PKL</td>
                    <td>{{ $hari[date('w', strtotime($pkl->tgl_pkl))] }} ,
                        {{ date('d/m/Y', strtotime($pkl->tgl_pkl))  }} </td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Ket PKL</td>
                    <td>{{ $pkl->ket }}</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Jumlah Jam Lembur</td>
                    @if($pkl->jam_lembur == "")
                    <td> <i> Tidak di input </i></td>
                    @else
                    <td>{{ $pkl->jam_lembur }}</td>
                    @endif
                </tr>
                <tr>
                    <td style="font-weight:bold;">Jam Absen</td>
                    <td>{{ $pkl->jam_prik_submit }}</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Jam Awal</td>
                    <td>{{ $pkl->jam_in }} . {{ $pkl->menit_in }}</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Jam Akhir</td>
                    <td>{{ $pkl->jam_out }} . {{ $pkl->menit_out }}</td>
                </tr>
              
                <tr>
                    <td style="font-weight:bold;">Shift Kerja</td>
                    <td>{{ $pkl->shift }}</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Shift Lembur</td>
                    <td>{{ $pkl->shift }}</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Uang Makan 1</td>
                    <td>{{ $pkl->makan }}</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Uang Makan 2</td>
                    <td>{{ $pkl->makan2 }}</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Hari Libur</td>
                    @if($pkl->libur == "Y")
                    <td>Ya</td>
                    @elseif($pkl->libur == "T")
                    <td>Tidak</td>
                    @else
                    <td></td>
                    @endif
                </tr>
                <tr>
                    <td style="font-weight:bold;">Transport</td>
                    @if($pkl->transp == "Y")
                    <td>Ya</td>
                    @elseif($pkl->transp == "T")
                    <td>Tidak</td>
                    @else
                    <td></td>
                    @endif
                </tr>
                <tr>
                    <td style="font-weight:bold;">Status Approval</td>
                    <td>@php if ($pkl->dtapp_sie == "")
                        { $status_pkl = 'Belum Di Approve'; } 
                        else 
                        { $status_pkl = 'Sudah Di Approve'; } 
                        @endphp 
                        {{ $status_pkl }}
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Div Head</td>
                    @if($pkl->app_div_code == "")
                    <td> <i> Tidak di input </i></td>
                    @else
                    <td>{{ $pkl->app_div_code }}</td>
                    @endif
                </tr>
                <tr>
                    <td style="font-weight:bold;">Tgl Approve Div Head</td>
                    @if($pkl->dtapp_div == "")
                    <td> <i> Tidak di input </i></td>
                    @else
                    <td>{{date('d/m/Y - H:i:s A', strtotime($pkl->dtapp_div))  }}</td>
                    @endif
                </tr>
                <tr>
                    <td style="font-weight:bold;">Dept Head</td>
                    @if($pkl->app_dep_code == "")
                    <td> <i> Tidak di input </i></td>
                    @else
                    <td>{{ $pkl->app_dep_code }}</td>
                    @endif
                </tr>
                <tr>
                    <td style="font-weight:bold;">Tgl Approve Dept Head</td>
                    @if($pkl->dtapp_dep == "")
                    <td> <i> Tidak di input </i></td>
                    @else
                    <td>{{date('d/m/Y - H:i:s A', strtotime($pkl->dtapp_dep))  }}</td>
                    @endif
                </tr>
                <tr>
                    <td style="font-weight:bold;">Sect Head</td>
                    @if($pkl->app_sie_code == "")
                    <td> <i> Tidak di input </i></td>
                    @else
                    <td>{{ $pkl->app_sie_code }}</td>
                    @endif
                </tr>
                <tr>
                    <td style="font-weight:bold;">Tgl Approve Sect Head</td>
                    @if($pkl->dtapp_sie == "")
                    <td> <i> Tidak di input </i></td>
                    @else
                    <td>{{date('d/m/Y - H:i:s A', strtotime($pkl->dtapp_sie)) }}</td>
                    @endif
                </tr>
                <tr>
                    <td style="font-weight:bold;">User Submit</td>
                    <td>{{date('d/m/Y', strtotime($pkl->tgl_input)) }}</td>
                </tr>
            </table>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

        </div>
    </div>
</div>
