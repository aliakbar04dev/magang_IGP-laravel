@extends('layouts.app')
@section('content')

<style>
    
    td, th {
        padding: 8px 10px 8px 0px;;
    }
    
    .tabledetail > thead > tr > th, .tabledetail > tbody > tr > th, .tabledetail > tfoot > tr > th, .tabledetail > thead > tr > td, .tabledetail > tbody > tr > td, .tabledetail > tfoot > tr > td {
        border: 1px solid #130d0d;
    }
    
    .bubble{
        background-color: #f2f2f2;
        color:black;
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
        box-shadow: 0px 0px 10px -5px gray;
        margin-bottom:10px;
    }
    
    textarea{
        resize:none;
        
    }
    
    
    
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Internal Audit
            <small>Edit PICA Audit</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Edit PICA Audit</li>
        </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
        @include('layouts._flash')
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit PICA Audit</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        {!! Form::open(['method' => 'post', 'id'=>'form_id', 'autocomplete' => 'off']) !!}    
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2" style="margin-bottom:8px;margin-left: 20px;">
                                    <label class="bubble">REFF NO.</label>
                                    <div class="bubble-content" id="finding_no">{{ $get_temuan->finding_no }}</div>
                                    <input type="hidden" id="finding" name="finding" value="{{ $get_temuan->finding_no }}">
                                    <div style="display:none;" id="finding_id">{{ $get_temuan->id }}</div>
                                </div>
                                <div class="col-md-2" style="margin-bottom:8px;">
                                    <label class="bubble">CLASS</label>
                                    <div class="bubble-content" id="class">{{ $get_temuan->cat }}</div>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-bottom:8px;">
                                <label class="bubble">STATEMENT OF NC</label>
                                <div style="height:150px;overflow-y:scroll;" id="soc" class="bubble-content">{{ $get_temuan->statement_of_nc }}</div>
                            </div>
                            <div class="col-md-6" style="margin-bottom:8px;">
                                <label class="bubble">SCALE OF PROBLEM</label>
                                <div style="height:240px;overflow-y:scroll;" id="dop" class="bubble-content">{{ $get_temuan->detail_problem }}</div>
                            </div>
                            <div class="col-md-6" style="margin-bottom:8px;"> 
                                <div id="containment_container">
                                    @foreach ($get_containment as $cont)             
                                    @if ($loop->iteration == 1)    
                                    <div id="containment_item_{{$loop->iteration}}" style="margin-bottom:8px;">
                                        @else
                                        <div id="containment_item_{{$loop->iteration}}" style="margin-bottom:8px;display:none;">    
                                            @endif
                                            <label class="bubble">CONT. OF ACTION &nbsp;<small style="display:inline-flex;">{{ $loop->iteration }} of {{$loop->count}} </small></label>
                                            <button type="button" style="margin-left: 10px;margin-bottom: 4px;cursor: pointer;line-height: 1.3;" class="btn btn-sm btn-primary prev_coa"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></button>
                                            <button type="button" style="margin-bottom: 4px;line-height: 1.3;cursor: pointer;" class="btn btn-sm btn-primary next_coa"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></button>
                                            <div style="height:240px;overflow-y:scroll;" class="bubble-content">
                                                <div id="coa" name="coa">{{ $cont->containment_of_action }}</div>
                                                <label>PIC</label>
                                                <input class="form-control" id="pic" name="pic" value="{{ $cont->pic }}" readonly>
                                                <label>DUE DATE</label>
                                                <input class="form-control" id="due_date" name="due_date" value="{{ $cont->due_date }}" readonly>
                                            </div>
                                        </div>  
                                        @endforeach
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-bottom:8px;">
                                <div id="rca_content">
                                    @php
                                    $actual_count = $get_detail->count() / 5;
                                    @endphp
                                    @foreach ($get_detail as $detail)
                                    
                                    @php
                                    $seq = 1;
                                    
                                    $rca_type[$loop->iteration] = $detail->rca_type;
                                    $why_value[$loop->iteration] = $detail->why_value;
                                    $corrective_action[$loop->iteration] = $detail->corrective_action;
                                    $corrective_pic[$loop->iteration] = $detail->corrective_pic;
                                    $corrective_due_date[$loop->iteration] = $detail->corrective_due_date;
                                    $yokoten_action[$loop->iteration] = $detail->yokoten_action;
                                    $yokoten_pic[$loop->iteration] = $detail->yokoten_pic;
                                    $yokoten_due_date[$loop->iteration] = $detail->yokoten_due_date;
                                    
                                    @endphp
                                    @endforeach
                                    @php $current_no = 1; $current_why = 1; @endphp
                                    @foreach ($get_detail as $detail)
                                    @if (($loop->iteration % 5) == 1)
                                    <div id="content_{{$current_no}}">
                                        <input type="hidden" id="analysis_no" name="analysis_no[]" value="{{$current_no}}">
                                        <label style="background-color: #74bb7a;color:white;" class="bubble">ROOT CAUSE ANALYSIS</label>
                                        @if ($loop->iteration == 1)
                                        <button onclick="add_rca()" type="button" class="btn btn-success btn-sm" style="margin-bottom: 5px;">Add Analysis</button>
                                        @else
                                        <button id="d_{{$current_no}}" onclick="delete_rca((this.id).substring(2))" type="button" class="btn btn-danger btn-sm" style="margin-bottom: 5px;">Hapus</button>
                                        @endif
                                        <div class="bubble-content">
                                            <div id="title_root" style="text-align: center;font-weight: bold;font-size: 40px;">
                                                <select class="form-control input-lg" id="selector_title" name="analysis_type[]" style="width:150px;margin-left:40%;">
                                                    <option value="{{$rca_type[$seq]}}">{{$rca_type[$seq]}}</option>
                                                    @if ($rca_type[$seq] == 'METHOD')
                                                    <option value="MAN">MAN</option>
                                                    <option value="MATERIAL">MATERIAL</option>
                                                    <option value="MACHINE">MACHINE</option>
                                                    @elseif ($rca_type[$seq] == 'MAN')
                                                    <option value="METHOD">METHOD</option>
                                                    <option value="MATERIAL">MATERIAL</option>
                                                    <option value="MACHINE">MACHINE</option>
                                                    @elseif ($rca_type[$seq] == 'MATERIAL')
                                                    <option value="METHOD">METHOD</option>
                                                    <option value="MAN">MAN</option>
                                                    <option value="MACHINE">MACHINE</option>
                                                    @elseif ($rca_type[$seq] == 'MACHINE')
                                                    <option value="METHOD">METHOD</option>
                                                    <option value="MAN">MAN</option>
                                                    <option value="MATERIAL">MATERIAL</option>
                                                    @endif
                                                </select>
                                                <!-- <h2>{{$rca_type[$seq]}}</h2><input type="hidden" name="analysis_type[]" value="{{$rca_type[$seq]}}"> -->
                                                <button id="p_{{$current_no}}" onclick="prev_rca((this.id).substring(1))" type="button" class="btn btn-success btn-sm" style="margin-bottom: 5px;float:left;" disabled><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></button>
                                                <button id="n_{{$current_no}}" onclick="next_rca((this.id).substring(1))" type="button" class="btn btn-success btn-sm" style="margin-bottom: 5px;float:right;"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></button>
                                            </div>
                                            <table id="table_data" class="table-borderless" style="width:100%;">
                                                <tr class="why1_{{$current_no}}">
                                                    <td rowspan="2"><label>Why 1</label><textarea rows="6" class="form-control" name="why[]">{{$why_value[$seq]}}</textarea></td>
                                                    <td colspan="2"><label>Corrective & Preventive Action</label><textarea name="ca[]" class="form-control">{{$corrective_action[$seq]}}</textarea></td>
                                                    <td colspan="2"><label>Correction Action Impact (Yokoten)</label><textarea name="ya[]" class="form-control">{{$yokoten_action[$seq]}}</textarea></td>
                                                </tr>
                                                <tr class="why1_{{$current_no}}">
                                                    <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_containment[]" value="{{$corrective_pic[$seq]}}" data-toggle="modal" data-target="#karyawanModal" readonly></td>
                                                    <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_containment[]" value="{{$corrective_due_date[$seq]}}"></td>
                                                    <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_yokoten[]" value="{{$yokoten_pic[$seq]}}" data-toggle="modal" data-target="#karyawanModal" readonly></td>
                                                    <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_yokoten[]" value="{{$yokoten_due_date[$seq]}}">@php $seq++; @endphp</td>
                                                </tr>
                                                <tr class="why2_{{$current_no}}" style="display:none;">
                                                    <td rowspan="2"><label>Why 2</label><textarea rows="6" class="form-control" name="why[]">{{$why_value[$seq]}}</textarea></td>
                                                    <td colspan="2"><label>Corrective & Preventive Action</label><textarea name="ca[]" class="form-control">{{$corrective_action[$seq]}}</textarea></td>
                                                    <td colspan="2"><label>Correction Action Impact (Yokoten)</label><textarea name="ya[]" class="form-control">{{$yokoten_action[$seq]}}</textarea></td>
                                                </tr>
                                                <tr class="why2_{{$current_no}}" style="display:none;">
                                                    <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_containment[]" value="{{$corrective_pic[$seq]}}" data-toggle="modal" data-target="#karyawanModal" readonly></td>
                                                    <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_containment[]" value="{{$corrective_due_date[$seq]}}"></td>
                                                    <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_yokoten[]" value="{{$yokoten_pic[$seq]}}" data-toggle="modal" data-target="#karyawanModal" readonly></td>
                                                    <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_yokoten[]" value="{{$yokoten_due_date[$seq]}}">@php $seq++; @endphp</td>
                                                </tr>
                                                <tr class="why3_{{$current_no}}" style="display:none;">
                                                    <td rowspan="2"><label>Why 3</label><textarea rows="6" class="form-control" name="why[]">{{$why_value[$seq]}}</textarea></td>
                                                    <td colspan="2"><label>Corrective & Preventive Action</label><textarea name="ca[]" class="form-control">{{$corrective_action[$seq]}}</textarea></td>
                                                    <td colspan="2"><label>Correction Action Impact (Yokoten)</label><textarea name="ya[]" class="form-control">{{$yokoten_action[$seq]}}</textarea></td>
                                                </tr>
                                                <tr class="why3_{{$current_no}}" style="display:none;">
                                                    <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_containment[]" value="{{$corrective_pic[$seq]}}" data-toggle="modal" data-target="#karyawanModal" readonly></td>
                                                    <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_containment[]" value="{{$corrective_due_date[$seq]}}"></td>
                                                    <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_yokoten[]" value="{{$yokoten_pic[$seq]}}" data-toggle="modal" data-target="#karyawanModal" readonly></td>
                                                    <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_yokoten[]" value="{{$yokoten_due_date[$seq]}}">@php $seq++; @endphp</td>
                                                </tr>
                                                <tr class="why4_{{$current_no}}" style="display:none;">
                                                    <td rowspan="2"><label>Why 4</label><textarea rows="6" class="form-control" name="why[]">{{$why_value[$seq]}}</textarea></td>
                                                    <td colspan="2"><label>Corrective & Preventive Action</label><textarea name="ca[]" class="form-control">{{$corrective_action[$seq]}}</textarea></td>
                                                    <td colspan="2"><label>Correction Action Impact (Yokoten)</label><textarea name="ya[]" class="form-control">{{$yokoten_action[$seq]}}</textarea></td>
                                                </tr>
                                                <tr class="why4_{{$current_no}}" style="display:none;">
                                                    <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_containment[]" value="{{$corrective_pic[$seq]}}" data-toggle="modal" data-target="#karyawanModal" readonly></td>
                                                    <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_containment[]" value="{{$corrective_due_date[$seq]}}"></td>
                                                    <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_yokoten[]" value="{{$yokoten_pic[$seq]}}" data-toggle="modal" data-target="#karyawanModal" readonly></td>
                                                    <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_yokoten[]" value="{{$yokoten_due_date[$seq]}}">@php $seq++; @endphp</td>
                                                </tr>
                                                <tr class="why5_{{$current_no}}" style="display:none;">
                                                    <td rowspan="2"><label>Why 5</label><textarea rows="6" class="form-control" name="why[]">{{$why_value[$seq]}}</textarea></td>
                                                    <td colspan="2"><label>Corrective & Preventive Action</label><textarea name="ca[]" class="form-control">{{$corrective_action[$seq]}}</textarea></td>
                                                    <td colspan="2"><label>Correction Action Impact (Yokoten)</label><textarea name="ya[]" class="form-control">{{$yokoten_action[$seq]}}</textarea></td>
                                                </tr>
                                                <tr class="why5_{{$current_no}}" style="display:none;">
                                                    <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_containment[]" value="{{$corrective_pic[$seq]}}" data-toggle="modal" data-target="#karyawanModal" readonly></td>
                                                    <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_containment[]" value="{{$corrective_due_date[$seq]}}"></td>
                                                    <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_yokoten[]" value="{{$yokoten_pic[$seq]}}" data-toggle="modal" data-target="#karyawanModal" readonly></td>
                                                    <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_yokoten[]" value="{{$yokoten_due_date[$seq]}}">@php $seq++; @endphp</td>
                                                </tr>
                                                @php $current_no++; @endphp
                                            </table>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                <button type="submit" class="btn btn-primary" style="float :right;margin-right:8px;">SIMPAN PERUBAHAN</button>
                                <button type="button" class="btn btn-danger" style="float :right;margin-right:8px;" onclick="window.history.go(-1); return false;">BATAL</button>
                            </div>
                            <!-- /.box -->
                        </div>
                        {!! Form::close() !!}
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

             <!-- Modal Karyawan -->
     @include('audit.popup.karyawanModal')
            
            @endsection
            
            
            @section('scripts')
            <script type="text/javascript">
                $(document).ready(function(){
                    $(".select2").select2();
                });
                
                var count = "{{ $get_containment->count() }}";
                var current = 1;
                if (count == 1){
                    $('.next_coa').prop('disabled', true);
                }
                $('.prev_coa').prop('disabled', true);
                $('.next_coa').click(function(){
                    current++;
                    $('#containment_item_'+current).show();
                    $('#containment_item_'+(current - 1)).hide();
                    if ((current) == count){
                        $('.next_coa').prop('disabled', true);
                        $('.prev_coa').prop('disabled', false);
                        
                        
                    }
                });
                
                $('.prev_coa').click(function(){
                    current--;
                    $('#containment_item_'+current).show();
                    $('#containment_item_'+(current + 1)).hide();
                    if ((current) == 1){
                        $('.prev_coa').prop('disabled', true);
                        $('.next_coa').prop('disabled', false);
                        
                    }
                });
                
                var rca_no = 1;
                function next_rca(ths){
                    $('.why'+rca_no+ths).hide();
                    rca_no++;
                    $('.why'+rca_no+ths).show();
                    if (rca_no == 5){
                        $('#n'+ths).attr('disabled', true);
                    } else {
                        $('#n'+ths).attr('disabled', false);
                        $('#p'+ths).attr('disabled', false);
                    }
                }
                
                function prev_rca(ths){
                    $('.why'+rca_no+ths).hide();
                    rca_no--;
                    $('.why'+rca_no+ths).show();
                    if (rca_no == 1){
                        $('#p'+ths).attr('disabled', true);   
                    } else {
                        $('#n'+ths).attr('disabled', false);
                        $('#p'+ths).attr('disabled', false);
                    }
                }
                
                var rca_count = "{{ $actual_count }}";
                
                
                function add_rca(){
                    rca_count++;
                    $('#rca_content').append('\
                    <div id="content_'+rca_count+'">\
                        <input type="hidden" id="analysis_no" name="analysis_no[]" value="'+rca_count+'">\
                        <label style="background-color: #74bb7a;color:white;" class="bubble">ROOT CAUSE ANALYSIS</label>\
                        <button id="d_'+rca_count+'" onclick="delete_rca((this.id).substring(2))" type="button" class="btn btn-danger btn-sm" style="margin-bottom: 5px;">Hapus</button>\
                        <div class="bubble-content">\
                            <div id="title_root" style="text-align: center;font-weight: bold;font-size: 40px;">\
                                <select class="form-control input-lg" id="selector_title" name="analysis_type[]" style="width:150px;margin-left:40%;">\
                                    <option value="METHOD">METHOD</option>\
                                    <option value="MAN">MAN</option>\
                                    <option value="MATERIAL">MATERIAL</option>\
                                    <option value="MACHINE">MACHINE</option>\
                                </select>\
                                <button id="p_'+rca_count+'" onclick="prev_rca((this.id).substring(1))" type="button" class="btn btn-success btn-sm" style="margin-bottom: 5px;float:left;" disabled><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></button>\
                                <button id="n_'+rca_count+'" onclick="next_rca((this.id).substring(1))" type="button" class="btn btn-success btn-sm" style="margin-bottom: 5px;float:right;"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></button>\
                            </div>\
                            <table id="table_data" class="table-borderless" style="width:100%;">\
                                <tr class="why1_'+rca_count+'">\
                                    <td rowspan="2"><label>Why 1</label><textarea rows="6" class="form-control" name="why[]"></textarea></td>\
                                    <td colspan="2"><label>Corrective & Preventive Action</label><textarea name="ca[]" class="form-control"></textarea></td>\
                                    <td colspan="2"><label>Correction Action Impact (Yokoten)</label><textarea name="ya[]" class="form-control"></textarea></td>\
                                </tr>\
                                <tr class="why1_'+rca_count+'">\
                                    <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_containment[]"></td>\
                                    <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_containment[]"></td>\
                                    <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_yokoten[]"></td>\
                                    <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_yokoten[]"></td>\
                                </tr>\
                                <tr class="why2_'+rca_count+'" style="display:none;">\
                                    <td rowspan="2"><label>Why 2</label><textarea rows="6" class="form-control" name="why[]"></textarea></td>\
                                    <td colspan="2"><label>Corrective & Preventive Action</label><textarea name="ca[]" class="form-control"></textarea></td>\
                                    <td colspan="2"><label>Correction Action Impact (Yokoten)</label><textarea name="ya[]" class="form-control"></textarea></td>\
                                </tr>\
                                <tr class="why2_'+rca_count+'" style="display:none;">\
                                    <td><label>PIC</label><input class="form-control  pic" id="pic" name="pic_containment[]"></td>\
                                    <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_containment[]"></td>\
                                    <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_yokoten[]"></td>\
                                    <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_yokoten[]"></td>\
                                </tr>\
                                <tr class="why3_'+rca_count+'" style="display:none;">\
                                    <td rowspan="2"><label>Why 3</label><textarea rows="6" class="form-control" name="why[]"></textarea></td>\
                                    <td colspan="2"><label>Corrective & Preventive Action</label><textarea name="ca[]" class="form-control"></textarea></td>\
                                    <td colspan="2"><label>Correction Action Impact (Yokoten)</label><textarea name="ya[]" class="form-control"></textarea></td>\
                                </tr>\
                                <tr class="why3_'+rca_count+'" style="display:none;">\
                                    <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_containment[]"></td>\
                                    <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_containment[]"></td>\
                                    <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_yokoten[]"></td>\
                                    <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_yokoten[]"></td>\
                                </tr>\
                                <tr class="why4_'+rca_count+'" style="display:none;">\
                                    <td rowspan="2"><label>Why 4</label><textarea rows="6" class="form-control" name="why[]"></textarea></td>\
                                    <td colspan="2"><label>Corrective & Preventive Action</label><textarea name="ca[]" class="form-control"></textarea></td>\
                                    <td colspan="2"><label>Correction Action Impact (Yokoten)</label><textarea name="ya[]" class="form-control"></textarea></td>\
                                </tr>\
                                <tr class="why4_'+rca_count+'" style="display:none;">\
                                    <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_containment[]"></td>\
                                    <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_containment[]"></td>\
                                    <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_yokoten[]"></td>\
                                    <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_yokoten[]"></td>\
                                </tr>\
                                <tr class="why5_'+rca_count+'" style="display:none;">\
                                    <td rowspan="2"><label>Why 5</label><textarea rows="6" class="form-control" name="why[]"></textarea></td>\
                                    <td colspan="2"><label>Corrective & Preventive Action</label><textarea name="ca[]" class="form-control"></textarea></td>\
                                    <td colspan="2"><label>Correction Action Impact (Yokoten)</label><textarea name="ya[]" class="form-control"></textarea></td>\
                                </tr>\
                                <tr class="why5_'+rca_count+'" style="display:none;">\
                                    <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_containment[]"></td>\
                                    <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_containment[]"></td>\
                                    <td><label>PIC</label><input class="form-control pic" id="pic" name="pic_yokoten[]"></td>\
                                    <td><label>DUE DATE</label><input type="date" class="form-control tgl" id="due_date" name="due_date_yokoten[]"></td>\
                                </tr>\
                            </table>\
                        </div>\
                    </div>\
                    ');
                }
                
                function delete_rca(ths){
                    $('#content_'+ths).remove();
                }

                $('#form_id').on('submit', function(event){
                    event.preventDefault();
                    var pica_no = "{{$get_detail->first()->id}}"
                    var finding_no = document.getElementById('finding_no').innerHTML;   
                    var finding_id = document.getElementById('finding_id').innerHTML;
                    var url = "{{ route('auditors.picadaftarinput_byid_edit', ['param', 'param2']) }}";
                    url = url.replace('param', pica_no);
                    url = url.replace('param2', finding_id);
                    swal({
                        title: 'Konfirmasi?',
                        text: 'Simpan Perubahan PICA Temuan?',
                        type: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Simpan',
                        cancelButtonText: 'Cek kembali',
                        allowOutsideClick: true,
                        allowEscapeKey: true,
                        allowEnterKey: true,
                        reverseButtons: false,
                        focusCancel: false,
                    }).then(function () {
                        $.ajax({
                            url      : url,
                            type     : 'POST',
                            dataType : 'json',
                            data     : $('#form_id').serialize(),
                            success: function( _response ){
                                swal(
                                'Sukses',
                                'Berhasil disubmit!',
                                'success'
                                ).then(function (){
                                    $(".btn").prop("disabled", true);                
                                    // Simulate an HTTP redirect:
                                    $('html, body').animate({
                                        scrollTop: $("body").offset().top
                                    }, 500);
                                    window.location.href = "{{ route('auditors.daftar_pica')}}";
                                });
                            },
                            error: function( _response ){
                                swal(
                                'Terjadi kesalahan',
                                'Segera hubungi Admin!',
                                'error'
                                )
                            }
                        });
                    })
                });

$('.pic').click(function(){
    var thisid = $(this);
    var myHeading = "<p>Popup Karyawan AUDITEE</p>";
    $("#karyawanModalLabel").html(myHeading);
    var url = "{{ route('datatables.popupKaryawanIA') }}";
    var lookupKaryawan = $('#lookupKaryawan').DataTable({
        processing: true,
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
            { data: 'npk', name: 'npk'},
            { data: 'nama', name: 'nama'},
            { data: 'desc_dep', name: 'desc_dep'}
        ],
        "bDestroy": true,
        "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupKaryawan tbody').on( 'dblclick', 'tr', function () {
            var dataArr = [];
            var rows = $(this);
            var rowData = lookupKaryawan.rows(rows).data();
            $.each($(rowData),function(key,value){
                thisid.val(value['npk'] + ' - ' + value['nama']);
                // document.getElementById('nama'+nama).innerHTML = value["nama"];
                // document.getElementById('listauditee').value += value["nama"] + ',  ';
                $('#karyawanModal').modal('hide');
            });
        });
        // $('#karyawanModal').on('hidden.bs.modal', function () {
        // });
    },
    });
}); 
                
                
            </script>
            
            @endsection
