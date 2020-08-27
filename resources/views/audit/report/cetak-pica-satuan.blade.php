<html>
<head>
    
    <title>Print PICA Satuan</title>
    <style>
        @page { 
            margin : 1px;
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
    }
 
    .text-center {
        text-align: center;
    }

    body { 
        font-family: 'Times New Roman', Times, serif;
        font-size: 12px;
    }

    .rotate{
        transform: rotate(-90deg);
        
    }

    .vertical-finding {
        font-size: 13px;
        -webkit-transform:rotate(-90deg);
        -ms-transform:rotate(-90deg);
        display:block;
        margin-left: -30px;
        margin-right: -30px;
        /* margin-top: -80px; */
        text-align: right;
    }


    .vertical-severity {
        font-size: 13px;
        -webkit-transform:rotate(-90deg);
        -ms-transform:rotate(-90deg);
        display:block;
        margin-left: -20px;
        margin-right: -20px;
        /* margin-top: -110px; */
        text-align: right;
    }


    .vertical-rca {
        font-size: 13px;
        -webkit-transform:rotate(-90deg);
        -ms-transform:rotate(-90deg);
        display:block;
        margin-left: -20px;
        margin-right: -20px;
    }


    
    </style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>

<body>
<table style="font-size:12px;">
    <tr>
        <td style="padding-right:10px;"><div style="font-weight: bold;">Temuan Internal Audit : Stage {{ $get_detail->first()->periode . ' ' . $get_detail->first()->tahun}}</div></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> 
        <td>Auditee : @if ($get_audteetor->count() != 0) @foreach($get_audteetor as $auditee) @if($auditee->status == 'Auditee'){{$auditee->nama}}, @endif @endforeach @else Temuan audit belum dipilih! @endif</td>
    </tr>
    <tr>
        <td><div style="font-weight: bold;">Division / Department : {{ $get_detail->first()->desc_div }} / {{ $get_detail->first()->desc_dep }}</div></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>    
        <td>Auditor : @if ($get_audteetor->count() != 0) @foreach($get_audteetor as $auditor) @if($auditor->status == 'Auditor'){{$auditor->nama}}, @endif @endforeach @else Temuan audit belum dipilih! @endif</td>
    </tr>
    <tr>
        <td><div>Tanggal : {{ date("d F Y", strtotime($get_detail->first()->tanggal)) }}</td>    
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
</table>

    <div style="width:1080px;">
        @foreach ($get_containment as $containment)
            @php
                $value = 1;
                $cont[$loop->iteration] = $containment->containment_of_action;
                $pic[$loop->iteration] = $containment->pic;
                $due_date[$loop->iteration] = $containment->due_date;
                $status[$loop->iteration] = $containment->status_qa;
            @endphp
        @endforeach
        
        @foreach ($get_detail as $root)
            @php
                $value_root = 1;
                $rca_no[$loop->iteration] = $root->rca_no;
                $rca_type[$loop->iteration] = $root->rca_type;
                $why[$loop->iteration] = $root->why_value;
                $why_no[$loop->iteration] = $root->why_no;
                $cor_action[$loop->iteration] = $root->corrective_action;
                $cor_pic[$loop->iteration] = $root->corrective_pic;
                $cor_due_date[$loop->iteration] = $root->corrective_due_date;
                $yok_action[$loop->iteration] = $root->yokoten_action;
                $yok_pic[$loop->iteration] = $root->yokoten_pic;
                $yok_due_date[$loop->iteration] = $root->yokoten_due_date;
                $status_act[$loop->iteration] = $root->status_qa;
                $status_yok[$loop->iteration] = $root->status_qa_yokoten;
            @endphp
        @endforeach
    <table class="table" style="width:auto;border-bottom: 1px solid black;">
            <tr>
                <th style="padding:0px;" width="5">No.</th>
                <th width="5">Reff</th>
                <th width="5">Severity</th>
                <th width="50">Statement Of NC</th>
                <th width="60">Scale Of Problem</th>
                <th width="55">Containment Action</th>
                <th width="15">PIC</th>
                <th width="15">Due Date</th>
                <th width="15">Status</th>
                <th width="5" style="border-right: none;">&nbsp;</th>
                <th width="5" style="border-right: none;border-left: none;">&nbsp;</th>
                <th width="60" style="border-left: none;">Root Cause Analysis</th>
                <th width="45">Corrective & Preventive Action</th>
                <th width="15" >PIC</th>
                <th width="15">Due Date</th>
                <th width="15">Status</th>
                <th width="45">Corrective Impact Action (Yokoten)</th>
                <th width="15">PIC</th>
                <th width="15">Due Date</th>
                <th width="15">Status</th>
            </tr>
            <!-- STARTING -->
            <tr>
                <td rowspan="{{ $get_detail->count() }}" style="vertical-align: top;font-size: 18px;">1.</td>
                <td rowspan="{{ $get_detail->count() }}" ><span class="vertical-finding">{{ $get_detail->first()->finding_no }}</span></td>
                <td rowspan="{{ $get_detail->count() }}" ><span class="vertical-severity">{{ $get_detail->first()->cat }}</span></td>
                <td rowspan="{{ $get_detail->count() }}" style="vertical-align: top;">{{ $get_detail->first()->statement_of_nc }}<br><br>IATF : <i>{{ $get_detail->first()->iatf_ref }}</i></td>
                <td rowspan="{{ $get_detail->count() }}" style="vertical-align: top;">{{ $get_detail->first()->detail_problem }}</td>
                @if ($get_containment->count() == 1)
                <td style="vertical-align: top;" rowspan="{{ $get_detail->count() }}">{{$cont[$value]}}</td>
                @php
                $get_nama_pic = DB::table('v_mas_karyawan')
                ->select('nama')
                ->where('npk', '=', substr($pic[$value], 0))
                ->value('nama');
                $words = explode(" ", $get_nama_pic);
                $akronim_pic = "";
                $count = 1;
                foreach ($words as $w) {
                    if ($count == 1){
                        $akronim_pic .= $w.' ';
                    } else {
                        $akronim_pic .= $w[0];
                    }
                    $count++;
                }
                @endphp
                <td style="vertical-align: top;" rowspan="{{ $get_detail->count() }}">{{$akronim_pic}}</td>
                <td style="vertical-align: top;" rowspan="{{ $get_detail->count() }}">{{$due_date[$value]}}</td>
                <td rowspan="{{ $get_detail->count() }}" style="vertical-align: top;text-align:center;font-size:13px;">@if ($status[$value] == 1) o @else x @endif @php $value++; @endphp</td>
                @else
                <td style="vertical-align: top;">{{$cont[$value]}}</td>
                @php
                $get_nama_pic = DB::table('v_mas_karyawan')
                ->select('nama')
                ->where('npk', '=', substr($pic[$value], 0))
                ->value('nama');
                $words = explode(" ", $get_nama_pic);
                $akronim_pic = "";
                $count = 1;
                foreach ($words as $w) {
                    if ($count == 1){
                        $akronim_pic .= $w.' ';
                    } else {
                        $akronim_pic .= $w[0];
                    }
                    $count++;
                }
                @endphp
                <td style="vertical-align: top;">{{$akronim_pic}}</td>
                <td style="vertical-align: top;">{{$due_date[$value]}}</td>
                <td style="vertical-align: top;text-align:center;font-size:13px;">@if ($status[$value] == 1) o @else x @endif @php $value++; @endphp</td>
                @endif
                <td rowspan="5" style="width:1%;"><span class="vertical-rca">{{$rca_type[$value_root]}}</span></td>
                <td style="vertical-align: top;text-align: center;height: 20px;">Why {{$why_no[$value_root]}}</td>
                <td style="vertical-align: top;">{{$why[$value_root]}}</td>
                <td style="vertical-align: top;">{{$cor_action[$value_root]}}</td>
                @php
                $words = explode(" ", substr($cor_pic[$value_root], 8));
                $akronim_cor_pic = "";
                $count = 1;
                foreach ($words as $w) {
                    if ($count == 1){
                        $akronim_cor_pic .= $w.' ';
                    } else {
                        $akronim_cor_pic .= $w[0];
                    }
                    $count++;
                }
                @endphp
                <td style="vertical-align: top;">{{ $akronim_cor_pic }}</td>
                <td style="vertical-align: top;">{{$cor_due_date[$value_root]}}</td>
                @if ($cor_action[$value_root] == '' || $cor_action[$value_root] == null)
                <td style="vertical-align: top;font-size:13px;text-align:center;"></td>
                @else
                <td style="vertical-align: top;font-size:13px;text-align:center;">@if ($status_act[$value_root] == 1) o @else x @endif</td>
                @endif                
                <td style="vertical-align: top;">{{$yok_action[$value_root]}}</td>
                @php
                $words = explode(" ", substr($yok_pic[$value_root], 8));
                $akronim_yok_pic = "";
                $count = 1;
                foreach ($words as $w) {
                    if ($count == 1){
                        $akronim_yok_pic .= $w.' ';
                    } else {
                        $akronim_yok_pic .= $w[0];
                    }
                    $count++;
                }
                @endphp
                <td style="vertical-align: top;">{{ $akronim_yok_pic }}</td>
                <td style="vertical-align: top;">{{$yok_due_date[$value_root]}}</td>
                @if ($yok_action[$value_root] == '' || $yok_action[$value_root] == null)
                <td style="vertical-align: top;text-align:center;font-size:13px;">@php $value_root++; @endphp</td>
                @else
                <td style="vertical-align: top;text-align:center;font-size:13px;">@if ($status_yok[$value_root] == 1) o @else x @endif  @php $value_root++; @endphp</td>
                @endif
            </tr> <!-- ENDING -->
            @foreach ($get_detail as $detail)
                @if ($loop->iteration == 1)
                    @continue
                @else
                    @if ($cont[$value] != null)
                        <tr>
                            <td style="vertical-align: top;" rowspan="{{ $loop->count - $loop->iteration + 1 }}">{{$cont[$value]}}</td>
                            @php
                            $get_nama_pic = DB::table('v_mas_karyawan')
                            ->select('nama')
                            ->where('npk', '=', substr($pic[$value],0))
                            ->value('nama');
                            $words = explode(" ", $get_nama_pic);
                            $akronim_pic = "";
                            $count = 1;
                            foreach ($words as $w) {
                                if ($count == 1){
                                    $akronim_pic .= $w.' ';
                                } else {
                                    $akronim_pic .= $w[0];
                                }
                                $count++;
                            }
                            @endphp
                            <td style="vertical-align: top;" rowspan="{{ $loop->count - $loop->iteration + 1 }}">{{$akronim_pic}}</td>
                            <td style="vertical-align: top;" rowspan="{{ $loop->count - $loop->iteration + 1 }}">{{$due_date[$value]}}</td>
                            <td style="vertical-align: top;text-align:center;font-size:13px;" rowspan="{{ $loop->count - $loop->iteration + 1 }}">@if ($status[$value] == 1) o @else x @endif @php $value++; @endphp</td>
                            @if (($loop->iteration % 5) == 1 )
                                <td rowspan="5"><span class="vertical-rca">{{$rca_type[$value_root]}}</span></td>
                            @endif
                            <td style="vertical-align: top;text-align: center;">Why {{$why_no[$value_root]}}</td>
                            <td style="vertical-align: top;height: 20px;">{{$why[$value_root]}}</td>
                            <td style="vertical-align: top;">{{$cor_action[$value_root]}}</td>
                            @php
                            $words = explode(" ", substr($cor_pic[$value_root], 8));
                            $akronim_cor_pic = "";
                            $count = 1;
                            foreach ($words as $w) {
                                if ($count == 1){
                                    $akronim_cor_pic .= $w.' ';
                                } else {
                                    $akronim_cor_pic .= $w[0];
                                }
                                $count++;
                            }
                            @endphp
                            <td style="vertical-align: top;">{{ $akronim_cor_pic }}</td>
                            <td style="vertical-align: top;">{{$cor_due_date[$value_root]}}</td>
                            @if ($cor_action[$value_root] == '' || $cor_action[$value_root] == null)
                            <td style="vertical-align: top;font-size:13px;text-align:center;"></td>
                            @else
                            <td style="vertical-align: top;font-size:13px;text-align:center;">@if ($status_act[$value_root] == 1) o @else x @endif</td>
                            @endif
                            <td style="vertical-align: top;">{{$yok_action[$value_root]}}</td>
                            @php
                            $words = explode(" ", substr($yok_pic[$value_root], 8));
                            $akronim_yok_pic = "";
                            $count = 1;
                            foreach ($words as $w) {
                                if ($count == 1){
                                    $akronim_yok_pic .= $w.' ';
                                } else {
                                    $akronim_yok_pic .= $w[0];
                                }
                                $count++;
                            }
                            @endphp
                            <td style="vertical-align: top;">{{ $akronim_yok_pic }}</td>
                            <td style="vertical-align: top;">{{$yok_due_date[$value_root]}}</td>
                            @if ($yok_action[$value_root] == '' || $yok_action[$value_root] == null)
                            <td style="vertical-align: top;text-align:center;font-size:13px;">@php $value_root++; @endphp</td>
                            @else
                            <td style="vertical-align: top;text-align:center;font-size:13px;">@if ($status_yok[$value_root] == 1) o @else x @endif  @php $value_root++; @endphp</td>
                            @endif
                        </tr>   
                    @elseif ($cont[$value] == null && ($cor_action[$value_root] != null || $cor_action[$value_root] != ''))
                        <tr>
                            <!-- <td width="10" style="vertical-align: top;">Test</td> -->
                            @if (($loop->iteration % 5) == 1 )
                                <td rowspan="5"><span class="vertical-rca">{{$rca_type[$value_root]}}</span></td>
                            @endif
                            <td style="vertical-align: top;text-align: center;">Why {{$why_no[$value_root]}}</td>
                            <td style="vertical-align: top;height: 20px;">{{$why[$value_root]}}</td>
                            <td style="vertical-align: top;">{{$cor_action[$value_root]}}</td>
                            @php
                            $words = explode(" ", substr($cor_pic[$value_root], 8));
                            $akronim_cor_pic = "";
                            $count = 1;
                            foreach ($words as $w) {
                                if ($count == 1){
                                    $akronim_cor_pic .= $w.' ';
                                } else {
                                    $akronim_cor_pic .= $w[0];
                                }
                                $count++;
                            }
                            @endphp
                            <td style="vertical-align: top;">{{$akronim_cor_pic}}</td>
                            <td style="vertical-align: top;">{{$cor_due_date[$value_root]}}</td>
                            <td style="vertical-align: top;font-size:13px;text-align:center;">@if ($status_act[$value_root] == 1) o @else x @endif</td>
                            <td style="vertical-align: top;">{{$yok_action[$value_root]}}</td>
                            @php
                            $words = explode(" ", substr($yok_pic[$value_root], 8));
                            $akronim_yok_pic = "";
                            $count = 1;
                            foreach ($words as $w) {
                                if ($count == 1){
                                    $akronim_yok_pic .= $w.' ';
                                } else {
                                    $akronim_yok_pic .= $w[0];
                                }
                                $count++;
                            }
                            @endphp
                            <td style="vertical-align: top;">{{$akronim_yok_pic}}</td>
                            <td style="vertical-align: top;">{{$yok_due_date[$value_root]}}</td>
                            @if ($yok_action[$value_root] == '' || $yok_action[$value_root] == null)
                                <td style="vertical-align: top;text-align:center;font-size:13px;">@php $value_root++; @endphp</td>
                            @else
                                <td style="vertical-align: top;text-align:center;font-size:13px;">@if ($status_yok[$value_root] == 1) o @else x @endif @php $value_root++; @endphp</td>
                            @endif
                        </tr>
                    @elseif ($cont[$value] == null && $cor_action[$value_root] == null)
                    <tr>
                        <!-- <td width="10" style="vertical-align: top;">Test</td> -->
                        @if (($loop->iteration % 5) == 1 )
                            <td rowspan="5"><span class="vertical-rca">{{$rca_type[$value_root]}}</span></td>
                        @endif
                        <td style="vertical-align: top;text-align: center;">Why {{$why_no[$value_root]}}</td>
                        <td style="vertical-align: top;height: 20px;">{{$why[$value_root]}}</td>
                        <td style="vertical-align: top;border-top: none !important;">{{$cor_action[$value_root]}}</td>
                        @php
                        $words = explode(" ", substr($cor_pic[$value_root], 8));
                        $akronim_cor_pic = "";
                        $count = 1;
                        foreach ($words as $w) {
                            if ($count == 1){
                                $akronim_cor_pic .= $w.' ';
                            } else {
                                $akronim_cor_pic .= $w[0];
                            }
                            $count++;
                        }
                        @endphp
                        <td style="vertical-align: top;border-top: none !important;">{{$akronim_cor_pic}}</td>
                        <td style="vertical-align: top;border-top: none !important;">{{$cor_due_date[$value_root]}}</td>
                        <td style="vertical-align: top;border-top: none !important;font-size:13px;text-align:center;"></td>
                        <td style="vertical-align: top;border-top: none !important;">{{$yok_action[$value_root]}}</td>
                        @php
                            $words = explode(" ", substr($yok_pic[$value_root], 8));
                            $akronim_yok_pic = "";
                            $count = 1;
                            foreach ($words as $w) {
                                if ($count == 1){
                                    $akronim_yok_pic .= $w.' ';
                                } else {
                                    $akronim_yok_pic .= $w[0];
                                }
                                $count++;
                            }
                            @endphp
                        <td style="vertical-align: top;border-top: none !important;">{{$akronim_yok_pic}}</td>
                        <td style="vertical-align: top;border-top: none !important;">{{$yok_due_date[$value_root]}} @php $value_root++; @endphp</td>
                        <td style="vertical-align: top;border-top: none !important;"></td>
                    </tr>
                    @endif
                @endif
            @endforeach
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