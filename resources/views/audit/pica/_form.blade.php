    <div id="header_form" class="col-md-12">
        <div style="width:78%;display: inline-block;" class="alert alert-info" role="alert">
            Item PICA ini masih sebuah draft!
        </div>
        @if (substr($get_pica_no, 0, 5) !== 'DRAFT')
       <button onclick="submit_pica()" style="line-height: 2.8;width:20%;margin-top: -2px;margin-left: 4px;" class="btn btn-md btn-primary">SUBMIT PICA</button>
        @else
        <button style="line-height: 2.8;width:20%;margin-top: -2px;margin-left: 4px;" class="btn btn-md btn-primary" disabled>SUBMIT PICA</button>
        @endif
    </div>
    <div id="pica_title">
            <div class="col-md-6" style="margin-bottom:10px;">
                    <label>PICA TEMUAN NO.</label>
                    <input autocomplete="off" id="pica_temuan" class="form-control" type="text" value="@if (substr($get_pica_no, 0, 5) !== 'DRAFT') {{ $get_pica_no }} @else Temuan audit belum dipilih! @endif" readonly>
                    <input id="pica_id" type="hidden" value="{{ $get_pica_id }}" readonly>
                </div>
                <div class="col-md-6" style="margin-bottom:10px;">
                        <label>AUDITOR</label>
                        <input autocomplete="off" id="pica_auditor" class="form-control" type="text" value="@if ($get_audteetor->count() != 0) @foreach($get_audteetor as $auditor) @if($auditor->status == 'Auditor'){{$auditor->nama}}, @endif @endforeach @else Temuan audit belum dipilih! @endif" readonly>
                    </div>
                <div class="col-md-6" style="margin-bottom:10px;">
                    <label>DIV / DEPT / SIE</label>
                    <input autocomplete="off" id="pica_dept" class="form-control" type="text" value="@if ($get_area->count() != 0 ) {{ $get_area->first()->desc_div }} / {{ $get_area->first()->desc_dep }} / {{ $get_area->first()->desc_sie }} @else Temuan audit belum dipilih! @endif " readonly>
                </div>
                <div class="col-md-6" style="margin-bottom:10px;">
                    <label>AUDITEE</label>
                    <input autocomplete="off" id="pica_auditee" class="form-control" type="text" value="@if ($get_audteetor->count() != 0) @foreach($get_audteetor as $auditee) @if($auditee->status == 'Auditee'){{$auditee->nama}}, @endif @endforeach @else Temuan audit belum dipilih! @endif" readonly>
                </div>
            <div class="col-md-12" id="added_pica" style="margin-bottom:10px;">
                <label>TEMUAN AUDIT PICA YANG DIPILIH</label>
                <table id="daftarpica" class="table table-bordered table-hover"  style="width:100%;margin-top: -12px;">
                    <thead>
                        <tr>
                            <th>FINDING NO.</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>                           
                </table>
            </div>

    <!-- <div class="col-md-12"><label>DAFTAR TEMUAN AUDIT <div style="font-weight: normal;" id="keterangan_filter"><i>Ditampilkan semua</i></div></label></div>       -->
    <div id="formtemuan" class="collapse">
    <label class="bubble">DAFTAR TEMUAN AUDIT</label><button onclick="scrollToForm()" class="btn btn-xs btn-danger">Close</button>
    <div class="col-md-12 bubble-content">
    <div class="col-md-4" id="selector_audit">
    <label>DIVISI</label>
    <select autocomplete="off" class="form-control select2" id="kd_div" name="kd_div" style="width:100%;">
            <option value="all">SEMUA</option>
            @foreach ($getdiv as $div)
             @if ($div->desc_div != null)
                <option value="{{ $div->kd_div }}">{{ $div->desc_div }}</option>
            @endif
            @endforeach
        </select>
    </div>
    <div class="col-md-4" id="selector_audit">
    <label>DEPARTEMEN</label>
    <select autocomplete="off" class="form-control select2" id="kd_dep" name="kd_dep" style="width:100%;margin-bottom:8px;">
            <option value="all">SEMUA</option>
            @foreach ($getdep as $dep)
            <option value="{{ $dep->kd_dep }}">{{ $dep->desc_dep }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4" id="selector_audit">
    <label>SEKSI</label>
    <select autocomplete="off" class="form-control select2" id="kd_sie" name="kd_sie" style="width:100%;">
            <option value="all">SEMUA</option>
            @foreach ($getsie as $sie)
            <option value="{{ $sie->kd_sie }}">{{ $sie->desc_sie }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4" id="selector_audit" style="margin-top:8px;">
        <label>PERIODE</label>
        <select autocomplete="off" class="form-control select2" id="periode" name="periode" style="width:100%;">
            <option></option>
            <option value="/I/">SATU</option>
            <option value="/II/">DUA</option>
        </select>
    </div>
    <div class="col-md-12">
    <button id="display_filter" type="button" style="margin-bottom:8px;margin-top:8px;" class="btn btn-md btn-primary">Filter</button>
    <button id="show_all" type="button" class="btn btn-md btn-primary">Tampilkan semua</button><br>
</div>
<div class="col-md-12" id="selector_audit" style="margin-bottom:10px;">
    <table id="daftartemuan" class="table table-bordered table-hover"  style="width:100%;margin-top: -12px;">
            <thead>
                <tr>
                    <th style="width:1%">NO.</th>
                    <th>FINDING NO.</th>
                    <th>DIV / DEP / SIE</th>
                    <th>ACTION</th>
                </tr>
            </thead>                           
        </table>
    </div>
</div>
</div>
<a href="{{ route('auditors.daftar_pica') }}" class="btn btn-primary" style="float:right;">KEMBALI KE HALAMAN DAFTAR PICA</a>

</div>



    {!! Form::open(['method' => 'post', 'id'=>'form_id', 'autocomplete' => 'off']) !!}    
    <div id="part1" style="display:none;">
            <input id="pica_no" name="pica_no" class="form-control" type="hidden" value="{{$get_pica_no}}" readonly>
        <div class="form-group">
            <div class="row">
                <div class="col-md-1">
            <button id="back_btn" class="btn btn-danger" type="button" style="margin-left:18px;line-height: 5;margin-bottom:8px;display:none;">CANCEL</button>
        </div>
            <div class="col-md-2" style="margin-bottom:8px;margin-left: 20px;">
                <label class="bubble">REFF NO.</label>
                <div class="bubble-content" id="finding_no"></div>
                <input type="hidden" id="finding" name="finding" value="">
                <div style="display:none;" id="finding_id"></div>
            </div>
            <div class="col-md-2" style="margin-bottom:8px;">
                <label class="bubble">CLASS</label>
                <div class="bubble-content" id="class"></div>
            </div>
            </div>
            <div class="col-md-12" style="margin-bottom:8px;">
                <label class="bubble">STATEMENT OF NC</label>
                <div style="height:150px;overflow-y:scroll;" id="soc" class="bubble-content"></div>
            </div>
            <div class="col-md-6" style="margin-bottom:8px;">
                <label class="bubble">SCALE OF PROBLEM</label>
                <div style="height:200px;overflow-y:scroll;" id="dop" class="bubble-content"></div>
            </div>
            <div class="col-md-6" style="margin-bottom:8px;">

            <div id="containment_container">
                
            </div>
            </div>

            <div class="col-md-12" style="margin-bottom:8px;">
                <div id="rca_content">
                    <div id="content_1">
                        <input type="hidden" id="analysis_no" name="analysis_no[]" value="1">
                <label style="background-color: #74bb7a;color:white;" class="bubble">ROOT CAUSE ANALYSIS</label>
                <button onclick="add_rca()" type="button" class="btn btn-success btn-sm" style="margin-bottom: 5px;">Add Analysis</button>
                    <div class="bubble-content">
                        <div id="title_root" style="text-align: center;font-weight: bold;font-size: 40px;">
                            <select class="form-control input-lg" id="selector_title" name="analysis_type[]" style="width:150px;margin-left:40%;">
                                <option value="METHOD">METHOD</option>
                                <option value="MAN">MAN</option>
                                <option value="MATERIAL">MATERIAL</option>
                                <option value="MACHINE">MACHINE</option>
                            </select>
                            <button id="p_1" onclick="prev_rca((this.id).substring(1))" type="button" class="btn btn-success btn-sm" style="margin-bottom: 5px;float:left;" disabled><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></button>
                            <button id="n_1" onclick="next_rca((this.id).substring(1))" type="button" class="btn btn-success btn-sm" style="margin-bottom: 5px;float:right;"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></button>
                        </div>
                        <table id="table_data" class="table-borderless" style="width:100%;">
                            <tr class="why1_1">
                                <td rowspan="2"><label>Why 1</label><textarea rows="6" class="form-control" name="why[]"></textarea></td>
                                <td colspan="2"><label>Corrective & Preventive Action</label><textarea name="ca[]" class="form-control"></textarea></td>
                                <td colspan="2"><label>Correction Action Impact (Yokoten)</label><textarea name="ya[]" class="form-control"></textarea></td>
                            </tr>
                            <tr class="why1_1">
                                <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_containment[]" data-toggle="modal" data-target="#karyawanModal" readonly></td>
                                <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_containment[]"></td>
                                <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_yokoten[]" data-toggle="modal" data-target="#karyawanModal" readonly></td>
                                <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_yokoten[]"></td>
                            </tr>
                            <tr class="why2_1" style="display:none;">
                                <td rowspan="2"><label>Why 2</label><textarea rows="6" class="form-control" name="why[]"></textarea></td>
                                <td colspan="2"><label>Corrective & Preventive Action</label><textarea name="ca[]" class="form-control"></textarea></td>
                                <td colspan="2"><label>Correction Action Impact (Yokoten)</label><textarea name="ya[]" class="form-control"></textarea></td>
                            </tr>
                            <tr class="why2_1" style="display:none;">
                                <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_containment[]" data-toggle="modal" data-target="#karyawanModal" readonly></td>
                                <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_containment[]"></td>
                                <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_yokoten[]" data-toggle="modal" data-target="#karyawanModal" readonly></td>
                                <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_yokoten[]"></td>
                            </tr>
                            <tr class="why3_1" style="display:none;">
                                <td rowspan="2"><label>Why 3</label><textarea rows="6" class="form-control" name="why[]"></textarea></td>
                                <td colspan="2"><label>Corrective & Preventive Action</label><textarea name="ca[]" class="form-control"></textarea></td>
                                <td colspan="2"><label>Correction Action Impact (Yokoten)</label><textarea name="ya[]" class="form-control"></textarea></td>
                            </tr>
                            <tr class="why3_1" style="display:none;">
                                <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_containment[]" data-toggle="modal" data-target="#karyawanModal" readonly></td>
                                <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_containment[]"></td>
                                <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_yokoten[]" data-toggle="modal" data-target="#karyawanModal" readonly></td>
                                <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_yokoten[]"></td>
                            </tr>
                            <tr class="why4_1" style="display:none;">
                                <td rowspan="2"><label>Why 4</label><textarea rows="6" class="form-control" name="why[]"></textarea></td>
                                <td colspan="2"><label>Corrective & Preventive Action</label><textarea name="ca[]" class="form-control"></textarea></td>
                                <td colspan="2"><label>Correction Action Impact (Yokoten)</label><textarea name="ya[]" class="form-control"></textarea></td>
                            </tr>
                            <tr class="why4_1" style="display:none;">
                                <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_containment[]" data-toggle="modal" data-target="#karyawanModal" readonly></td>
                                <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_containment[]"></td>
                                <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_yokoten[]" data-toggle="modal" data-target="#karyawanModal" readonly></td>
                                <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_yokoten[]"></td>
                            </tr>
                            <tr class="why5_1" style="display:none;">
                                <td rowspan="2"><label>Why 5</label><textarea rows="6" class="form-control" name="why[]"></textarea></td>
                                <td colspan="2"><label>Corrective & Preventive Action</label><textarea name="ca[]" class="form-control"></textarea></td>
                                <td colspan="2"><label>Correction Action Impact (Yokoten)</label><textarea name="ya[]" class="form-control"></textarea></td>
                            </tr>
                            <tr class="why5_1" style="display:none;">
                                <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_containment[]" data-toggle="modal" data-target="#karyawanModal" readonly></td>
                                <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_containment[]"></td>
                                <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_yokoten[]" data-toggle="modal" data-target="#karyawanModal" readonly></td>
                                <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_yokoten[]"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
                <button type="submit" class="btn btn-primary" style="float :right;margin-right:8px;">SIMPAN</button>
                </div>
        {!! Form::close() !!}
    </div>
     <!-- Modal Karyawan -->
     @include('audit.popup.karyawanModal')
    
