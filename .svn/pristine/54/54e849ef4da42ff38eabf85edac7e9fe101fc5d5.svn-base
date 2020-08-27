    <style>
        .bubble{
            background-color: #f2f2f2;
            
            padding: 8px;
            /* box-shadow: 0px 0px 15px -5px gray; */
            /* border-radius: 10px 10px 0px 0px; */
        }
        
        .bubble-content{
            background-color: #fff;
            padding: 10px;
            margin-top: -5px;
            /* border-radius: 0px 10px 10px 10px; */
            /* box-shadow: 2px 2px #dfdfdf; */
            box-shadow: 0px 0px 15px -5px gray;
            margin-bottom:10px;
        }
    </style>
    
    
    <div class="col-md-6" style="padding-right: 30px;">
        <div class="row">
            <label class="bubble">AREA AUDIT</label>
            <div class="bubble-content">
                <table class="table-borderless">
                    <tr>
                        <td><b>PLANT</b></td>
                        <td style="width:1px;">:</td>
                        <td>
                            @if ($get_temuan->plant == 1)IGP-1
                            @elseif($get_temuan->plant == 2)IGP-2
                            @elseif($get_temuan->plant == 3)IGP-3
                            @elseif($get_temuan->plant == 4)IGP-4
                            @elseif($get_temuan->plant == A)KIM-A
                            @elseif($get_temuan->plant == B)KIM-B
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><b>DIVISI</b></td>
                        <td style="width:1px;">:</td>
                        <td>{{ $get_temuan->desc_div }}</td>
                    </tr>
                    <tr>
                        <td><b>DEPARTEMEN</b></td>
                        <td style="width:1px;">:</td>
                        <td>{{ $get_temuan->desc_dep }}</td>
                    </tr>
                    <tr>
                        <td><b>SEKSI</b></td>
                        <td style="width:1px;">:</td>
                        <td>{{ $get_temuan->desc_sie }}</td>
                    </tr>
                    <tr>
                        <td><b>LINE</b></td>
                        <td style="width:1px;">:</td>
                        <td>{{ $get_temuan->xnm_line }}</td>
                    </tr>
                    <tr>
                        <td><b>SEKSI</b></td>
                        <td style="width:1px;">:</td>
                        <td>{{ $get_temuan->xnama_proses }}</td>
                    </tr>
                    
                    
                </table>
            </div>
        </div>
        <div class="row">
            <label class="bubble">AUDITOR & AUDITEE</label>
            <div class="bubble-content">
                <table>
                    <td><b>AUDITOR</b></td>
                    <td style="width:1px;">:</td>
                    <td>
                        @foreach($get_audteetor as $auditor) 
                        @if($auditor->status == 'Auditor')
                        {{$auditor->nama}},
                        @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td><b>AUDITEE</b></td>
                    <td style="width:1px;">:</td>
                    <td>
                        @foreach($get_audteetor as $auditee) 
                        @if($auditee->status == 'Auditee')
                        {{$auditee->nama}},
                        @endif
                        @endforeach
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        @if ($get_temuan->status_reject == "R")
        <label class="bubble">STATEMENT OF NC (DITOLAK LEAD AUDITOR)</label>
        @else
        <label class="bubble">STATEMENT OF NC</label>
        @endif
        <div style="height:190px;overflow-y: scroll;margin-bottom:10px;" class="bubble-content">{!! str_replace("\n","<br>", $get_temuan->statement_of_nc) !!}</div>
        
    </div>
</div>

<div class="col-md-6">
        <div class="row">
    <label class="bubble">DETAIL</label>
    <div class="bubble-content">
        <table class="table-borderless" style="width:100%;">
            <tr>
                <td style="width:30%;"><b>FINDING NO</b></td>
                <td style="width:1px;">:</td>
                <td>{{ $get_temuan->finding_no }}</td>
            </tr>
            <tr>
                <td><b>TANGGAL</b></td>
                <td style="width:1px;">:</td>
                <td>{{ $get_temuan->tanggal }}</td>
            </tr>
            <tr>
                <td style="width:30%;"><b>CATEGORY</b></td>
                <td style="width:1px;">:</td>
                <td>{{ $get_temuan->cat }}</td>
            </tr>
            <tr>
                <tr>
                    <td><b>AUDIT TYPE</b></td>
                    <td style="width:1px;">:</td>
                    <td>{{ $get_temuan->a_type }}</td>
                </tr>
                <tr>
                    <td><b>SHIFT</b></td>
                    <td style="width:1px;">:</td>
                    <td>{{ $get_temuan->shift }}</td>
                </tr>
                <tr>
                    <td><b>PERIODE</b></td>
                    <td style="width:1px;">:</td>
                    <td>{{ $get_temuan->periode }} @if ($get_temuan->periode == 'I')(SATU) @else (DUA) @endif</td>
                </tr>
            </table>
        </div>
        </div>
        <div class="row">
                <label class="bubble">REFERENCE OR STANDARD</label>
                <div class="bubble-content">
                    <table>
                        <tr>
                            <td style="white-space:nowrap;"><b>&nbsp;&nbsp;QMS DOC REF</b></td>
                            <td>:</td>
                            <td>{{ $get_temuan->qms_doc_ref }}</td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap;"><b>&nbsp;&nbsp;IATF 16949</b></td>
                            <td>:</td>
                            <td>{{ $get_temuan->iatf_ref }}</td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap;"><b>&nbsp;&nbsp;ISO 9001</b></td>
                            <td>:</td>
                            <td>{{ $get_temuan->iso_ref }}</td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap;"><b>&nbsp;&nbsp;CSR</b></td>
                            <td>:</td>
                            <td>{{ $get_temuan->csr }}</td>
                        </tr>
                    </table>
                </div>
        </div>
    </div>
    
    <!-- <div class="col-md-6">
        
    </div> -->
    
    <!-- <div class="col-md-6">
        
    </div> -->
    
    <!-- <div class="col-md-6">
        </div> -->
    <div class="col-md-12">
        <div class="row">
        @if ($get_temuan->status_reject == "R")
        <label class="bubble">DETAIL OF PROBLEM (DITOLAK LEAD AUDITOR)</label>
        @else
        <label class="bubble">DETAIL OF PROBLEM</label>
        @endif
        <div style="height:190px;overflow-y: scroll;margin-bottom:10px;" class="bubble-content">{{ $get_temuan->detail_problem }}</div>
    </div>
    </div>
    
    <!-- <a class="btn btn-primary btn-md" style="cursor: pointer;" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        Lihat Containment Of Action
    </a> -->
    <!-- <div class="collapse" id="collapseExample"> -->
        @if ($get_temuan->status <> null)
        @foreach ($get_containment as $coa)
        <div class="col-md-4">
            <label class="bubble">CONTAINMENT ACTION {{ $loop->iteration }} @if ($get_temuan->status_reject == 'A') (DITOLAK AUDITOR) @endif </label>&nbsp; 
            <div style="height:280px;overflow-y: scroll;" class="bubble-content">{{ $coa->containment_of_action }}<br><br>
                <label>PIC</label>
                <input class="form-control" value="{{ $coa->pic }}" readonly>
                <label>DUE DATE</label>
                <input class="form-control" value="{{ $coa->due_date }}" readonly>
                <label>TARGET ROOT CAUSE & CORRECTIVE ACTION must be submit at</label>
                <input class="form-control" value="{{ $coa->target_date }}" readonly>
            </div>
        </div>
        @endforeach
        @endif
        <!-- </div> -->
        
        @if ($get_temuan->status_reject <> null)
        @php $get_nama_penolak = DB::table('v_mas_karyawan')
        ->select('nama')
        ->where('npk', '=', $get_temuan->npk_reject)
        ->value('nama') @endphp
        <div class="col-md-12">
            <label style="background-color:#dd4b39;color:white;" class="bubble">ALASAN TOLAK oleh {{ $get_nama_penolak }}</label>
            <div style="height:140px;overflow-y: scroll;margin-bottom:10px;" class="bubble-content">{{ $get_temuan->alasan_reject }}</div>
        </div>
        @endif
        
        @if ($get_temuan->status_reject == "R")
        @if ($get_temuan->creaby == Auth::user()->username)
        <div class="col-md-6">
            <label class="bubble" style="background-color: #74bb7a;color:white;">STATEMENT OF NC INPUT REVISI</label>
            <div class="bubble-content">
                <textarea rows="6" style="resize: none;" id="snc" name="snc" class="form-control" required></textarea>
            </div>
        </div>
        
        <div class="col-md-6">
            <label class="bubble" style="background-color: #74bb7a;color:white;">DETAIL OF PROBLEM INPUT REVISI</label>
            <div class="bubble-content">
                <textarea rows="6" style="resize: none;" id="dop" name="dop" class="form-control"></textarea>
            </div>
        </div>
        @endif
        @endif
        
        <div class="col-md-12" id="tolak_sec" style="display:none;">
            <label class="bubble" style="background-color:#dd4b39;color:white;">ALASAN TOLAK</label>
            <div class="bubble-content">
                <textarea rows="6" style="resize: none;" id="alasan_reject" name="alasan_reject" class="form-control"></textarea>
            </div>
        </div>
        
        
        
        <div class="col-md-12">
            @if ($get_temuan->status == 1 )
            <table class="table-borderless" style="width: 100%;">
                <tr>
                    <td style="color:green;">- Telah ditandatangani oleh <i><b>{{ $nama_auditee }}</b></i> sebagai Auditee</td>
                </tr>
                @if ($get_temuan->status == 2)
                <tr>
                    <td style="color:green;">- Telah ditandatangani oleh <i><b>{{ $nama_auditor }}</b></i> sebagai Auditor</td>
                </tr>
                @endif
            </table>
        </div>
        @endif
        
        
