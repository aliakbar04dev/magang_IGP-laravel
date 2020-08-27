@extends('layouts.app')
@section('content')

<style>
    /* th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    } */
    /* table#mainDataTable{
    margin-left: 300px !important; 
}


div.DTFC_ScrollWrapper div.dataTables_scroll div.dataTables_scrollBody{
    padding-left: 300px;
    left: -300px; 
} */

th {
  border-top: 1px solid #dddddd;
  border-bottom: 1px solid #dddddd;
  border-right: 1px solid #dddddd;
  background-color:#fff;
 }
 
th:first-child {
  border-left: 1px solid #dddddd;
  border-top: 1px solid #dddddd;

}

th.datanya {
        /* white-space: nowrap; */
        /* padding-left: 40px !important; */
        padding-right: 50px !important;
    }

    table.dataTable.no-footer {
    border-bottom: none;
    }
    table.dataTable {
    clear: both;
    margin-top: 6px !important;
    margin-bottom: 0px !important;
    max-width: none !important;
}

#example {
    cursor: grab;
}

#example.active {
    cursor: grabbing;
}

    /* div.dataTables_wrapper {
        width: 800px;
        margin: 0 auto;
    } */
/* .DTFC_LeftBodyLiner{
position: relative;

top: -13px;

left: 0px;

overflow-y: scroll;

height: 160px;

max-height: 160px;

width: 590px;
} */

</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Internal Audit
            <small>Form Auditor</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Form Auditor</li>
        </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
        @include('layouts._flash')
        <!-- Form Izin Terlambat -->
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Daftar Internal Auditor</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div id="refresh">
                            <div id="subclass_refreshHidden">
                                <input type='hidden' value='{{ $get_latest->tahun }}' id="tahun"/>
                                <input type='hidden' value='{{ $get_latest->rev_no }}' id="rev"/>
                            </div>
                            <div class="form-group">
                            </div>
                            <!-- <h4>Input Auditor</h4>
                                <hr style="margin-top: 0px;"> -->
                                <div id="refreshButton">
                                    @if (substr($get_latest->rev_no, 2) == '_D')
                                    <div id="demo">
                                        <div class="row" style="padding-left: 20px;">
                                            <div id="add_sec" style="display:none;" class="col-md-6">
                                                <div class="form-group">
                                                    <label for="npk">NPK</label>
                                                    <div class="input-group">
                                                        <input class="form-control" placeholder="NPK" minlength="5" maxlength="5" required="required" name="npk" type="text" id="npk" onkeydown="keyPressed(event)" onchange="validateKaryawan()">
                                                        <span class="input-group-btn">
                                                            <button id="btnpopupkaryawan" type="button" class="btn btn-info" data-toggle="modal" data-target="#karyawanModal">
                                                                <span class="glyphicon glyphicon-search"></span>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama">Nama</label>
                                                    <input class="form-control" placeholder="Nama" disabled="" name="nama" type="text" id="nama">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inisial">Inisial</label>
                                                    <input maxlength="3" class="form-control" placeholder="Inisial" name="inisial" type="text" id="inisial">
                                                </div>
                                                <div class="form-group">
                                                    <label for="dept">Remark</label>
                                                    <select class="form-control" placeholder="Remark..." name="remark" type="text" id="remark">
                                                        <option value="LEAD AUDITOR">LEAD AUDITOR</option>
                                                        <option value="AUDITOR">AUDITOR</option>
                                                        <option value="OBSERVER">OBSERVER</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <button id="add_auditor" class="btn btn-info" style="float:right;" onclick="addRow()">Tambah</button>
                                                    <button id="hide_add_sec" class="btn btn-danger" style="float:right;  margin-right: 8px">Kembali</button>
                                                </div>
                                            </div>
                                            <div id="training_sec" style="display:none;" class="col-md-6">
                                                @include('audit._required-training')
                                                <button id="hide_training_sec" class="btn btn-danger" style="float:right;  margin-right: 8px">Kembali</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-12">
                                @if (substr($get_latest->rev_no, 2) == '_D')
                                <button id="show_add_sec" class="btn btn-success">TAMBAH AUDITOR</button>
                                <button id="show_training_sec" class="btn btn-primary">DAFTAR TRAINING</button>
                                @endif
                                </div>
                                <div id="refreshTable" class="col-md-12">
                                    <table id="example" class="table stripe row-border order-column cell-border" style="width:100%" onmousedown="return false;">
                                        <thead>
                                            <tr>
                                                <th class="no-sort" rowspan="2" >NO.</th>
                                                <th class="datanya" rowspan="2" class="loc_npk">NAMA</th>
                                                <!-- <th class="datanya" rowspan="2" class="loc_nama">NAMA</th> -->
                                                <!-- <th class="datanya" rowspan="2" class="loc_dept">DEPT</th>
                                                    <th class="datanya" rowspan="2" class="loc_sect">SECT</th> -->
                                                    <th style="border-top: 1px solid #ddd;" class="loc_training" colspan="{{ $list_training->count() }}">TRAINING</th> 
                                                    <th style="border-top: 1px solid #ddd;padding-right: 100px;" rowspan="2" class="loc_remark">REMARK</th>
                                                </tr>
                                                <tr>
                                                    @foreach ($list_training as $trn)
                                                    <th class="no-sort" style="width:50px">{{ $trn->desc_trn }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data_nama as $nama)
                                                <tr id="data{{ $loop->iteration }}">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td style="white-space: nowrap;">{{ $nama->npk }} - {{ $nama->nama }}
                                                        @if (substr($get_latest->rev_no, 2) == '_D')
                                                        <input type='hidden' value='{{ $nama->npk }}' id="npk{{ $loop->iteration }}"/>
                                                        <button id="{{ $loop->iteration }}" class="btn btn-xs btn-danger" onclick="deleteRow(this.id)">HAPUS</button>
                                                        @endif
                                                    </td>
                                                    <!-- <td></td> -->
                                                    <!-- <td>{{ $nama->desc_dep }}</td>
                                                        <td>{{ $nama->desc_sie }}</td> -->
                                                        @for ($a = 0; $a < $data_training2->count(); $a++)
                                                        @if ($data_training2[$a]->npk == $nama->npk)
                                                        @if ($data_training2[$a]->nilai == 1)
                                                        <td style="color: #68b303;font-weight: bold;text-align: center;"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></td>
                                                        @elseif ($data_training2[$a]->nilai == 0)
                                                        <td style="color: #e82d2d;font-weight: bold;text-align: center;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></td>
                                                        @endif
                                                        @endif
                                                        @endfor
                                                        <td>
                                                            @if (substr($get_latest->rev_no, 2) == '_D')
                                                            <select id="editremark{{ $loop->iteration }}" class="form-control" onchange="editremark((this.id).substring(10), this.value)">
                                                                @if ($nama->remark == 'LEAD AUDITOR')
                                                                <option value="LEAD AUDITOR">LEAD AUDITOR</option>
                                                                <option value="AUDITOR">AUDITOR</option>
                                                                <option value="OBSERVER">OBSERVER</option>
                                                                @elseif ($nama->remark == 'AUDITOR')
                                                                <option value="AUDITOR">AUDITOR</option>
                                                                <option value="LEAD AUDITOR">LEAD AUDITOR</option>
                                                                <option value="OBSERVER">OBSERVER</option>
                                                                @elseif ($nama->remark == 'OBSERVER')
                                                                <option value="OBSERVER">OBSERVER</option>
                                                                <option value="LEAD AUDITOR">LEAD AUDITOR</option>
                                                                <option value="AUDITOR">AUDITOR</option>
                                                                @endif
                                                            </select>
                                                            @else
                                                            @if ($nama->remark == 'LEAD AUDITOR')
                                                            LEAD AUDITOR
                                                            @elseif ($nama->remark == 'AUDITOR')
                                                            AUDITOR
                                                            @elseif ($nama->remark == 'OBSERVER')
                                                            OBSERVER
                                                            @endif
                                                            @endif
                                                            
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            
                                        </div>
                                        <div id="refreshButton2">
                                            <div id="subclass_refreshButton2">
                                                @if (substr($get_latest->rev_no, 2) == '_D')
                                                <button id="save" onclick="save()" class="btn btn-info" style="float:right;margin-right:10px">SAVE</button>
                                                @else
                                                <button id="edit" onclick="edit()" class="btn btn-info" style="float:right;margin-right:10px">EDIT</button>
                                                <a href="{{ route('auditors.cetak_daftar_auditor') }}" id="print" class="btn btn-info" style="float:right;margin-right:10px">PRINT</a>           
                                                @endif
                                            </div>
                                        </div>
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
                <!-- Form Izin Terlambat -->
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
      $(".select_training").select2();
            document.body.classList.add("sidebar-collapse");
            document.getElementsByClassName('DTFC_LeftBodyLiner')[0].style.top = "-6px";
            document.getElementsByClassName('DTFC_RightBodyLiner')[0].style.top = "-6px";
            document.getElementsByClassName('DTFC_LeftBodyLiner')[0].style.overflowY = "scroll";
            document.getElementsByClassName('DTFC_Cloned')[0].style.borderTop = "1px solid #ddd";
            document.getElementsByClassName('dataTables_scrollBody')[0].style.maxHeight = "495px";
            $('.DTFC_Cloned thead tr .loc_remark').css('padding-right', '115px');
            if($('#requiredtraining_wrapper').length != 0) {document.getElementById('requiredtraining_wrapper').style.marginTop = "-12px";}
            $('.DTFC_LeftBodyLiner').bind('mousewheel DOMMouseScroll', function(e) {e.preventDefault();});
            
            const slider = document.querySelector('.dataTables_scrollBody');
            let isDown = false;
            let startX;
            let scrollLeft;
            
            slider.addEventListener('mousedown', (e) => {
                isDown = true;
                slider.classList.add('active');
                startX = e.pageX - slider.offsetLeft;
                scrollLeft = slider.scrollLeft;
            });
            slider.addEventListener('mouseleave', () => {
                isDown = false;
                slider.classList.remove('active');
            });
            slider.addEventListener('mouseup', () => {
                isDown = false;
                slider.classList.remove('active');
            });
            slider.addEventListener('mousemove', (e) => {
                if(!isDown) return;
                e.preventDefault();
                const x = e.pageX - slider.offsetLeft;
                const walk = (x - startX) * 1; //scroll-fast
                slider.scrollLeft = scrollLeft - walk;
                //   console.log(walk);
            });
            
            $("#btnpopupkaryawan").click(function(){
                popupKaryawan();
            });
            
            $('#collapseTambah').click(function(){       
                $('.collapse').collapse("toggle");
                $(this).hide();
            });
            
            $('#collapseCancel').click(function(){       
                $('.collapse').collapse("toggle");
                $('#collapseTambah').show();
            });

            $('#show_add_sec').click(function(){
                $('#refreshTable').hide();
                $('#show_training_sec').hide();
                $(this).hide();
                $('#save').hide();
                $('#add_sec').show();
            });

            $('#hide_add_sec').click(function(){
                $('#refreshTable').show();
                $('#show_training_sec').show();
                $('#show_add_sec').show();
                $('#save').show();
                $('#add_sec').hide();
            });

            $('#show_training_sec').click(function(){
                $('#refreshTable').hide();
                $('#show_training_sec').hide();
                $(this).hide();
                $('#save').hide();
                $('#show_add_sec').hide();
                $('#training_sec').show();
            });

            $('#hide_training_sec').click(function(){
                $('#refreshTable').show();
                $('#show_training_sec').show();
                $('#training_sec').hide();
                $('#save').show();
                $('#show_add_sec').show();
                $('#training_sec').hide();
            });
            
        });

    var rev = document.getElementById('rev').value.trim();
    var tahun = document.getElementById('tahun').value.trim();
    var table = $('#example').DataTable({
        bDestroy: true,
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        scrollY: 500,
        fixedHeader: true,
        "pageLength": 5,
        fixedColumns: { leftColumns: 2, rightColumns: 1},
        "order": [[1, 'asc']],
        "columnDefs": [ { orderable: false, targets: ['no-sort'] }],
        dom: '<"top"fr<"keterangan">><"bottom"tip>',
        initComplete: function(){
            $("div.keterangan")
            .html("<div id='keterangan' style='padding-top: 8px;font-size: 18px;'><div id='subclass_keterangan'><b>TAHUN</b> {{ $get_latest->tahun }}\
            &nbsp;&nbsp;<b>REV NO.</b>\
            @if (strlen($get_latest->rev_no) == 2)\
            {{$get_latest->rev_no}}\
            @else\
            {{ substr($get_latest->rev_no, 0, 2)}} <i>(DRAFT)</i>\
            @endif\
            &nbsp;&nbsp;<b>DATE</b> {{ $get_latest->date }} &nbsp;&nbsp;</div></div>");
        },
        });
        
        var table2 = $('#requiredtraining').DataTable({
            "pageLength": 4,
            dom: '<"top"fr<"x">><"bottom"tip>',
            initComplete: function(){
                $("div.x").html('<div style="padding-top: 9px;"><b>DAFTAR TRAINING WAJIB</b></div>');},
            });
            
function keyPressed(e) {
    if(e.keyCode == 120) { //F9
        $('#btnpopupkaryawan').click();
    } else if(e.keyCode == 9) { //TAB
        e.preventDefault();
    }
}

function refreshTable(){
    $('#refreshTable').load("{{route('auditors.auditorform')}} #example", function(){
        $('#example').dataTable().fnDestroy();
        var table = $('#example').DataTable( {
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            scrollY: 500,
            fixedHeader: true,
            fixedColumns: {
                leftColumns: 2,
                rightColumns: 1,        
            },
            "columnDefs": [
                { orderable: false, targets: ['no-sort'] },    
            ],
            "order": [[1, 'asc']],
            dom: '<"top"fr<"keterangan">><"bottom"tip>',
            initComplete: function(){
            $("div.keterangan")
            .html("<div id='keterangan' style='padding-top: 8px;font-size: 18px;'><div id='subclass_keterangan'><b>TAHUN</b> {{ $get_latest->tahun }}\
            &nbsp;&nbsp;<b>REV NO.</b>\
            @if (strlen($get_latest->rev_no) == 2)\
            {{$get_latest->rev_no}}\
            @else\
            {{$get_latest->rev_no}}RAFT\
            @endif\
            &nbsp;&nbsp;<b>DATE</b> {{ $get_latest->date }} &nbsp;&nbsp;</div></div>");
        },
        } );
        
        document.body.classList.add("sidebar-collapse");
        document.getElementsByClassName('DTFC_LeftBodyLiner')[0].style.top = "-6px";
        document.getElementsByClassName('DTFC_RightBodyLiner')[0].style.top = "-6px";
        document.getElementsByClassName('DTFC_LeftBodyLiner')[0].style.overflowY = "scroll";
        document.getElementsByClassName('DTFC_Cloned')[0].style.borderTop = "1px solid #ddd";
        document.getElementsByClassName('dataTables_scrollBody')[0].style.maxHeight = "495px";
        $('.DTFC_Cloned thead tr .loc_remark').css('padding-right', '115px');
        if($('#requiredtraining_wrapper').length != 0) {
            document.getElementById('requiredtraining_wrapper').style.marginTop = "-12px";
        }
        $('.DTFC_LeftBodyLiner').bind('mousewheel DOMMouseScroll', function(e) {
            e.preventDefault();
        });
    });
}

function refreshPage(){
    $('.box-body').load('{{route('auditors.auditorform')}} #refresh', function(){
        $('#example').dataTable().fnDestroy();
        var table = $('#example').DataTable( {
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            scrollY: 500,
            fixedHeader: true,
            fixedColumns: {
                leftColumns: 3,
                rightColumns: 1,        
            },
            "order": [[1, 'asc']],
            "columnDefs": [
                { orderable: false, targets: ['no-sort'] },    
            ],
            dom: '<"top"fr<"keterangan">><"bottom"tip>',
            initComplete: function(){
            $("div.keterangan")
            .html("<div id='keterangan' style='padding-top: 8px;font-size: 18px;'><div id='subclass_keterangan'><b>TAHUN</b> {{ $get_latest->tahun }}\
            &nbsp;&nbsp;<b>REV NO.</b>\
            @if (strlen($get_latest->rev_no) == 2)\
            {{$get_latest->rev_no}}\
            @else\
            {{$get_latest->rev_no}}RAFT\
            @endif\
            &nbsp;&nbsp;<b>DATE</b> {{ $get_latest->date }} &nbsp;&nbsp;</div></div>");
        },
        } );
        var table2 = $('#requiredtraining').DataTable( {
            "pageLength": 4,
            dom: '<"top"fr<"x">><"bottom"tip>',
            initComplete: function(){
                $("div.x")
                .html('<div style="padding-top: 9px;"><b>DAFTAR TRAINING WAJIB</b></div>');        
            }
        });
        document.body.classList.add("sidebar-collapse");
        document.getElementsByClassName('DTFC_LeftBodyLiner')[0].style.top = "-6px";
        document.getElementsByClassName('DTFC_RightBodyLiner')[0].style.top = "-6px";
        document.getElementsByClassName('DTFC_LeftBodyLiner')[0].style.overflowY = "scroll";
        // document.getElementsByClassName('DTFC_RightWrapper')[0].style.display = "none";  
        document.getElementsByClassName('DTFC_Cloned')[0].style.borderTop = "1px solid #ddd";
        document.getElementsByClassName('dataTables_scrollBody')[0].style.maxHeight = "495px";
        $('.DTFC_Cloned thead tr .loc_remark').css('padding-right', '115px');
        if($('#requiredtraining_wrapper').length != 0) {
            document.getElementById('requiredtraining_wrapper').style.marginTop = "-12px";
        }
        $('.DTFC_LeftBodyLiner').bind('mousewheel DOMMouseScroll', function(e) {
            e.preventDefault();
        });
        document.getElementsByTagName("BODY")[0].style.pointerEvents = "";
        popupKaryawan();
    });
}
    
    function popupKaryawan() {
        var myHeading = "<p>Popup Karyawan</p>";
        $("#karyawanModalLabel").html(myHeading);
        var url = "{{ route('datatables.popupKaryawanIA') }}";
        var lookupKaryawan = $('#lookupKaryawan').DataTable({
            processing: true, 
            "oLanguage": {
              'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
          }, 
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
                        document.getElementById("npk").value = value["npk"];
                        document.getElementById("nama").value = value["nama"];
                        $('#karyawanModal').modal('hide');
                        validateKaryawan();
                    });
                });
                $('#karyawanModal').on('hidden.bs.modal', function () {
                    var npk = document.getElementById("npk").value.trim();
                    if(npk === '') {
                        document.getElementById("nama").value = "";
                        $('#npk').focus();
                    }
                });
            },
        });
    }
    
    function validateKaryawan() {
        var npk = document.getElementById('npk').value.trim();
        if(npk !== '') {
            var url = "{{ route('datatables.validasiKaryawanIA', ['param']) }}";
            url = url.replace('param', window.btoa(npk));
            //use ajax to run the check
            $.get(url, function(result){  
                if(result !== 'null'){
                    result = JSON.parse(result);
                    document.getElementById("npk").value = result["npk"];
                    document.getElementById("nama").value = result["nama"];
                } else {
                    document.getElementById("npk").value = "";
                    document.getElementById("nama").value = "";
                    document.getElementById("npk").focus();
                    swal("NPK tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
                }
            });
        } else {
            document.getElementById("npk").value = "";
            document.getElementById("nama").value = "";
        }
    }
    
    function popupAddSuccess(){
        refreshTable();
        swal(
        'Sukses',
        'Berhasil menambahkan ke dalam draft',
        'success'
        )
    }

    function popupRemoveSuccess(){
        refreshTable();
        swal(
        'Sukses',
        'Telah berhasil menghapus',
        'success'
        )
    }

    function popupSaveSuccess(){
        refreshPage();
        swal(
        'Sukses',
        'Berhasil menyimpan, tunggu sebentar lalu OK...',
        'success'
        )
    }

    
    function popupEdit(){
        refreshPage();
        swal(
        'Info',
        'Tunggu sebentar, sedang memuat halaman revisi...',
        'info'
        )
    }
    
    function deleteRow(ths) {
        var npkRow = document.getElementById('npk'+ths).value.trim();
        var tahun = document.getElementById('tahun').value.trim();
        var rev = document.getElementById('rev').value.trim();
        var token = document.getElementsByName('_token')[0].value.trim();
        var url = "{{ route('auditors.draft_data_delete') }}";
        swal({
            title: 'Hapus dari draft?',
            text: 'NPK : ' + npkRow,
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            reverseButtons: false,
            focusCancel: false,
        }).then(function () {
            $(".btn").attr("disabled", true);
            swal({
                title: 'Loading...',
                showConfirmButton: false
            }) 
            $.ajax({
                url      : url,
                type     : 'POST',
                dataType : 'json',
                data     : {
                    npk   : npkRow,
                    tahun : tahun,
                    rev : rev,
                    _token  : token
                },
                success: function( _response ){
                    console.log(_response);
                    popupRemoveSuccess();   
                    $(".btn").attr("disabled", false);  
                    },
                    error: function(){
                        swal(
                            'Terjadi kesalahan',
                            'Segera hubungi Admin!',
                            'info'
                            )
                        }
                    });
                })
                
            }
    
    function addRow(){
        var npk = document.getElementById('npk').value.trim();
        var inisial = document.getElementById('inisial').value.trim();
        var tahun = document.getElementById('tahun').value.trim();
        var rev = document.getElementById('rev').value.trim();
        var remark = document.getElementById('remark').value.trim();
        var token = document.getElementsByName('_token')[0].value.trim();
        var url = "{{ route('auditors.draft_data_byNpk') }}";

        $('.dataTables_filter label input').focus();
        $('.dataTables_filter label input').val('');
        $('.dataTables_filter label input').trigger('keyup');

        var jumlah_auditor = '{{ $data_nama->count() }}'
        if (npk === '' || inisial == '') {
            swal(
                'Info',
                'Input belum lengkap, perhatikan inputan anda!',
                'info'
                )
                return;
        }

        for (i = 0; i < jumlah_auditor; i++) {
            var cek_npk = document.getElementById('npk'+(i + 1));
            if (npk == cek_npk.value){
                swal(
                    'Info',
                    'NPK ' + npk + ' sudah terdaftar dalam tabel!',
                    'info'
                    )
                break;
            } else {
            swal({
            title: 'Tambahkan ke draft?',
            text: 'NPK : ' + npk,
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Tambah',
            cancelButtonText: 'Batal',
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            reverseButtons: false,
            focusCancel: false,
        }).then(function () {
            $(".btn").attr("disabled", true);
            swal({
                title: 'Loading...',
                showConfirmButton: false
            }) 
            $.ajax({
                url      : url,
                type     : 'POST',
                dataType : 'json',
                data     : {
                    npk   : npk,
                    tahun : tahun,
                    rev : rev,
                    remark : remark,
                    inisial : inisial,
                    _token  : token,
                },
                success: function( _response ){
                    console.log(_response); 
                    popupAddSuccess();
                    location.reload();
                    $(".btn").attr("disabled", false);
                    },
                    error: function( _response ){
                        swal(
                            'Terjadi kesalahan',
                            'Segera hubungi Admin!',
                            'info'
                            )
                        }
                    });
                })
            }
            }
        }
        

function editremark(ths, thsval) {
    // var remark = document.getElementById('editremark'+ths).value.trim();
    var npkRow = document.getElementById('npk'+ths).value.trim();
    var tahun = document.getElementById('tahun').value.trim();
    var rev = document.getElementById('rev').value.trim();
    var token = document.getElementsByName('_token')[0].value.trim();
    var url = "{{ route('auditors.data_edit_remark') }}";
    swal({
            title: 'Loading...',
            text: 'Memproses perubahan remark...',
            showConfirmButton: false
        })
    $.ajax({
        url      : url,
        type     : 'POST',
        dataType : 'json',
        data     : {
            remark : thsval,
            npk   : npkRow,
            tahun : tahun,
            rev : rev,
            _token  : token
        },
        success: function( _response ){
            swal.close();
            console.log(_response);
        },
        error: function(){
            swal(
                'Terjadi kesalahan',
                'Segera hubungi Admin!',
                'info'
                )
            }
        });
        
    }

function save(){
    var npk = document.getElementById('npk').value.trim();
    var tahun = document.getElementById('tahun').value.trim();
    var rev = document.getElementById('rev').value.trim();
    var remark = document.getElementById('remark').value.trim();
    var token = document.getElementsByName('_token')[0].value.trim();
    var url = "{{ route('auditors.draft_data_save') }}";
    swal({
        title: 'Konfirmasi',
        text: 'Simpan dan setujui? (Bukan draft)',
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Save',
        cancelButtonText: 'Batal',
        allowOutsideClick: true,
        allowEscapeKey: true,
        allowEnterKey: true,
        reverseButtons: false,
        focusCancel: false,
    }).then(function () {
        swal({
            title: 'Loading...',
            showConfirmButton: false
        })
        $.ajax({
            url      : url,
            type     : 'POST',
            dataType : 'json',
            data     : {
                tahun : tahun,
                rev : rev,
                _token  : token,
            },
            success: function( _response ){
                swal({
                    title : 'Sukses',
                    text : 'Berhasil menyimpan, tunggu sebentar lalu OK...',
                    type : 'success'
                }).then(function (){
                    location.reload();
                    document.getElementsByTagName("BODY")[0].style.pointerEvents = "none";
                    $(".btn").attr("disabled", true);
                })
                },
                error: function( _response ){
                    swal(
                        'Terjadi kesalahan',
                        'Segera hubungi Admin!',
                        'info'
                        )
                    }
                });
            })
        }
 
 function edit(){
    var tahun = document.getElementById('tahun').value.trim();
    var rev = document.getElementById('rev').value.trim();
    var token = document.getElementsByName('_token')[0].value.trim();
    var url = "{{ route('auditors.data_edit') }}";
    swal({
        title: 'Konfirmasi',
        text: 'Ingin edit data? (REVISI)',
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Revisi',
        cancelButtonText: 'Batal',
        allowOutsideClick: true,
        allowEscapeKey: true,
        allowEnterKey: true,
        reverseButtons: false,
        focusCancel: false,
    }).then(function () {
        // document.getElementsByTagName("BODY")[0].style.pointerEvents = "none";
        // $(".btn").attr("disabled", true);
        swal({
            title: 'Loading...',
            showConfirmButton: false
        })
        $.ajax({
            url      : url,
            type     : 'POST',
            dataType : 'json',
            data     : {
                tahun : tahun,
                rev : rev,
                _token  : token,
            },
            success: function( _response ){   
                popupEdit();
                swal({
                    title : 'Loading',
                    text : 'Anda akan dialihkan ke halaman edit daftar auditor',
                    showConfirmButton: false
                })
                location.reload();
                    document.getElementsByTagName("BODY")[0].style.pointerEvents = "none";
                    $(".btn").attr("disabled", true);
                },
                error: function( _response ){
                    swal(
                        'Terjadi kesalahan',
                        'Segera hubungi Admin!',
                        'info'
                        )
                    }
                });
            })
        }

</script>

@endsection
