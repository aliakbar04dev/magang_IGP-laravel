<html>
<head>
    
    <title>Print PICA Satuan</title>
    <style>
        @page { 
            margin : 15px;
             }
        h1 {
        font-weight: bold;
        font-size: 20pt;
        text-align: center;
    }
 
    table {
        border-collapse: collapse;
        width: auto;
        font-size: 8px;
        /* display: block; */
        overflow-x: auto;
        /* white-space: nowrap; */
    }
 
    .table th {
        /* padding: 8px 8px; */
        border:1px solid #000000;
        text-align: center;
        font-size: 7px;
    }
 
    .table td {
        /* padding: 4px 4px; */
        border:1px solid #000000;
        border-bottom: none !important;
        font-size: 8px;
        padding-top: 3px;
        padding-bottom: 3px;
        padding-left: 3px;
    }
 
    .text-center {
        text-align: center;
    }

    body { 
        font-family: 'Times New Roman', Times, serif;
        font-size: 13px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .header_table {
        padding-bottom: 5px !important;
        text-align: center !important;
        font-size: 13px !important;
        padding-top: 5px !important;
    }
    
    </style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>

<body>
        @if (count($gethari) == 0) @php $count_span = 8; @endphp @else @php $count_span = count($gethari) + 7; @endphp @endif
        <div style="width:1080px;">
        <table class="table" style="width:100%;border-bottom: 1px solid black;">
            <tr>
                <td rowspan="2" width="50px" style="border-bottom: double;text-align: center;"><img style="width: 50px;" src="{{ asset('images/logo.png') }}"></td>
                <td class="header_table" colspan="{{ $count_span - 1 }}" style="padding-bottom: 10px;text-align: center;">DETAIL SCHEDULE INTERNAL QUALITY AUDIT</td>
            </tr>
            <tr>
                <td style="background-color: white;text-align: center;" colspan="{{ $count_span - 1 }}">PERIODE {{$data_schedule->first()->periode}} - {{$data_schedule->first()->tahun}} (REVISI {{$data_schedule->first()->rev_no}}, {{ date('d-m-Y', strtotime($data_schedule->first()->created_date)) }})</td>
            </tr>
        </table>
        <table class="table" style="width:100%;border-bottom: 1px solid black;">
                <thead>
                    <tr>
                        <th rowspan="4" width="10px">NO</th>
                        <th rowspan="4" colspan="2" style="width:30%;border-right:none;">AREA/PROC</th>
                        <th rowspan="4">AUDITEE</th>
                        <th rowspan="2" colspan="2">AUDITOR</th>
                        <th colspan="{{ count($gethari) }}">{{$data_schedule->first()->tahun}}</th>
                        <th rowspan="4">KETERANGAN</th>z
                    </tr>
                    <tr style="background-color: white;">
                        @foreach ($getbulan as $bulan)
                        @php $total_row_bulan = 0; @endphp
                        @foreach ($gethari as $tanggal)
                        @if ($tanggal->bulan == $bulan->bulan)
                        @php $total_row_bulan++; @endphp
                        @php 
                        switch ($bulan->bulan) {
                            case "01":
                            $nama_bulan = 'JAN';
                            break;
                            case "02":
                            $nama_bulan = 'FEB';
                            break;
                            case "03":
                            $nama_bulan = 'MAR';
                            break;
                            case "04":
                            $nama_bulan = 'APR';
                            break;
                            case "05":
                            $nama_bulan = 'MAY';
                            break;
                            case "06":
                            $nama_bulan = 'JUN';
                            break;
                            case "07":
                            $nama_bulan = 'JUL';
                            break;
                            case "08":
                            $nama_bulan = 'AUG';
                            break;
                            case "09":
                            $nama_bulan = 'SEP';
                            break;
                            case "10":
                            $nama_bulan = 'OCT';
                            break;
                            case "11":
                            $nama_bulan = 'NOV';
                            break;
                            case "12":
                            $nama_bulan = 'DES';
                            break;
                            default:
                            $nama_bulan = '';
                        }
                        @endphp
                        @endif
                        @endforeach
                        <th colspan="{{ $total_row_bulan }}">{{$nama_bulan}}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th rowspan="2">LEAD AUDITOR</th>
                        <th rowspan="2">AUDITOR</th>
                        @foreach ($gethari as $hari)
                        <th>{{ $hari->tanggal }}</th>
                        @endforeach
                    </tr>
                    <tr style="background-color: white;">
                        @foreach ($gethari as $hari)
                        @php $nama_hari = date("D", strtotime($hari->tahun . '-' . $hari->bulan . '-' . $hari->tanggal)); @endphp
                        @php 
                        switch ($nama_hari) {
                            case "Mon":
                            $nama_hari = 'SEN';
                            break;
                            case "Tue":
                            $nama_hari = 'SEL';
                            break;
                            case "Wed":
                            $nama_hari = 'RAB';
                            break;
                            case "Thu":
                            $nama_hari = 'KAM';
                            break;
                            case "Fri":
                            $nama_hari = 'JUM';
                            break;
                            case "Sat":
                            $nama_hari = 'SAB';
                            break;
                            case "Sun":
                            $nama_hari = 'MIN';
                            break;
                            default:
                            $nama_hari = 'Kosong';
                        }
                        @endphp
                        <th>{{ $nama_hari }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @if ($data_schedule->first()->plant == "igpj")
                    <tr>   
                        <td colspan="{{ $count_span }}">IGP PLANT JAKARTA</td>
                    </tr>
                    @else
                    <tr>
                        <td colspan="{{ $count_span }}">IGP PLANT KARAWANG</td>
                    </tr>
                    @endif
                    @php $current_no = 1; @endphp
                    @if (count($date) == 0)
                    <tr>
                        <td style="text-align: center;" colspan="8">Belum ada jadwal bulan ini</td>
                    </tr>
                    @else
                    @foreach ($date as $tanggal)
                    @if ($tanggal->flag_reschedule == null)
                    <tr>
                        <td>{{ $current_no }}. @php $current_no++; @endphp</td>
                        <td style="white-space: nowrap;border-right:none;" class="hapus_td"><div>@if ($tanggal->div == 'AO') <i>OPENING MEETING</i> @elseif ($tanggal->div == 'AC') <i>CLOSING MEETING</i> @else {{ $tanggal->desc_dep . ' - ' . $tanggal->desc_sie }} @endif</div>
                        </td>
                        <td style="white-space: nowrap;border-left:none;">
                            <!-- @if ($data_schedule->first()->status == 0)
                            <button class="btn btn-danger btn-sm hapus_btn" id="{{ $tanggal->id2 }}" style="float:right;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                            @endif
                            @if ($tanggal->flag_selesai == null && $data_schedule->first()->status == 1)
                                <button id="btn_re{{ $tanggal->id2 }}" class="btn btn-sm bg-olive batal_btn"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></button>
                                <button class="btn btn-sm bg-olive selesai_btn" id="{{ $tanggal->id2 }}"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
                            @endif -->
                        </td>
                        @if (count($auditor) == 0)
                        @php $all_auditee = "All.."; @endphp 
                        @else
                        @php $all_auditee = ""; @endphp 
                        @endif
                        @foreach ($auditor as $data_auditee)
                        @if ($tanggal->div == 'AO' || $tanggal->div == 'AC')
                        @php $all_auditee = "All//"; @endphp
                        @else
                        @if ($data_auditee->role_audit == 'AUDITEE' && $data_auditee->id2 == $tanggal->id2) 
                        @if ($tanggal->tanggal == $data_auditee->tanggal) 
                        @php 
                        $list_auditee = DB::table('v_mas_karyawan')
                        ->select('nama')
                        ->join('ia_schedule3', 'v_mas_karyawan.npk', 'ia_schedule3.npk')
                        ->where('ia_schedule3.npk', '=', $data_auditee->npk)
                        ->where('tanggal', '=', $tanggal->tanggal)
                        ->value('nama');
                        
                        $words = explode(" ", $list_auditee);
                        $akronim_auditee = "";
                        $count = 1;
                        foreach ($words as $w) {
                            if ($count == 1){
                                $akronim_auditee .= $w.' ';
                            } else {    
                                $akronim_auditee .= $w[0];
                            }
                            $count++;
                        }
                        
                        $all_auditee .= $akronim_auditee . ', ';
                        
                        @endphp 
                        @endif @endif @endif @endforeach
                        <td style="white-space: nowrap;">{{ substr($all_auditee, 0, -2) }}</td>
                        @if (count($auditor) == 0)
                        @php $akronim_leadauditor = "All"; $all_auditor = "All.." ; @endphp
                        @else
                        @php $akronim_leadauditor = ""; $all_auditor = "" ; @endphp
                        @endif
                        @foreach ($auditor as $data_auditee)
                        @if ($tanggal->div == 'AO' || $tanggal->div == 'AC')
                        @php $akronim_leadauditor = "All"; $all_auditor = "All//" @endphp
                        @else
                        @if ($tanggal->tanggal == $data_auditee->tanggal && $tanggal->bulan == $data_auditee->bulan)
                        @if ($data_auditee->role_audit == 'LEAD AUDITOR') 
                        @php 
                        $leadauditor = DB::table('v_mas_karyawan')
                        ->select('nama')
                        ->join('ia_schedule3', 'v_mas_karyawan.npk', 'ia_schedule3.npk')
                        ->where('ia_schedule3.npk', '=', $data_auditee->npk)
                        ->where('tanggal', '=', $tanggal->tanggal)
                        ->value('nama');
                        
                        $words = explode(" ", $leadauditor);
                        $count = 1;
                        foreach ($words as $w) {
                            if ($count == 1){
                                $akronim_leadauditor .= $w.' ';
                            } else {    
                                $akronim_leadauditor .= $w[0];
                            }
                            $count++;
                        }            
                        @endphp 
                        @elseif ($data_auditee->role_audit == 'AUDITOR' && $data_auditee->id2 == $tanggal->id2)
                        @php
                        $nama_auditor = DB::table('v_mas_karyawan')
                        ->select('nama')
                        ->join('ia_schedule3', 'v_mas_karyawan.npk', 'ia_schedule3.npk')
                        ->where('ia_schedule3.npk', '=', $data_auditee->npk)
                        ->where('tanggal', '=', $tanggal->tanggal)
                        ->value('nama');
                        
                        $words = explode(" ", $nama_auditor);
                        $count = 1;
                        $akronim_auditor = "";
                        
                        if (count($words) == 1){
                            if ($words[0] == '' || $words[0] == null) {
                                $all_auditor .= $akronim_auditor;                
                            } else {
                                $akronim_auditor = $words[0];
                                $all_auditor .= $akronim_auditor . ', ';
                            }
                        } else if (count($words) > 1) {
                            foreach ($words as $w) {
                                if ($count == 1){
                                    $akronim_auditor .= $w.' ';
                                } else {    
                                    $akronim_auditor .= $w[0];
                                }
                                $count++;
                            }
                            $all_auditor .= $akronim_auditor . ', ';
                        }
                        @endphp
                        @endif @endif @endif @endforeach
                        <td style="white-space: nowrap;">{{ $akronim_leadauditor }}</td>
                        <td style="white-space: nowrap;">{{ substr($all_auditor, 0, -2) }}</td>
                        @php $tgl_before = ''; $tgl_act = ''; @endphp
                        @foreach ($gethari as $hari)
                        @foreach ($date2 as $tgl)
                        @php  @endphp
                        @if ($hari->tanggal == $tgl->tanggal)
                        @if ($tgl->tanggal == $tanggal->tanggal && $tgl->bulan == $tanggal->bulan)
                        @if ($tanggal->flag_selesai == null)
                        @if ($tgl_before != $tgl_act)
                        <td style="text-align: center;">O</td>
                        @break
                        @else
                        <td style="text-align: center;">O</td>
                        @endif
                        @elseif ($tanggal->flag_selesai == 'S')
                        @if ($tgl_before != $tgl_act || $tgl_before == '')
                        <td style="text-align: center;"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></td>
                        @break
                        @endif
                        @else
                        <td style="text-align: center;"><b>X</b></td>
                        @endif
                        @else
                        @if ($tanggal->div == $tgl->div && $tanggal->dep == $tgl->dep && $tanggal->sie == $tgl->sie)
                        @if ($tgl_before != $tgl_act || $tgl_before == '')
                        <td style="text-align: center;"><b>X</b></td>
                        @break
                        @elseif ($tgl_before != '')
                        <td style="white-space: nowrap;"></td>
                        @endif
                        @else
                        @if ($tgl_before != $tgl_act || $tgl_before == '')
                        <td style="white-space: nowrap;"></td>
                        @break
                        @endif
                        @endif
                        @endif
                        @endif
                        @endforeach
                        @php $tgl_act = $tgl_before; $tgl_before = $hari->tanggal; @endphp
                        @endforeach
                        <td id="keterangan_{{ $tanggal->id2 }}" style="white-space: nowrap;text-align: center;">{{ $tanggal->keterangan }} </td>
                    </tr>
                    @endif
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    <script>
        // $(document).ready(function(){
        //     $('.rotate').css('height', $('.rotate').width());
        // });
        
        // window.addEventListener('load', function () {
        //     var rotates = document.getElementsByClassName('rotate');
        //     for (var i = 0; i < rotates.length; i++) {
        //         rotates[i].style.height = rotates[i].offsetWidth + 'px';
        //     }
        // });

    </script>
    
</body>

</html>