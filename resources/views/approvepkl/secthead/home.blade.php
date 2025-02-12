@extends('layouts.app')
@section('content')

<style>

    /* The switch - the box around the slider */
 .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
  }
  
  /* Hide default HTML checkbox */
  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }
  
  /* The slider */
  .slider {
    position: absolute;
    cursor: pointer;
    top: 5px;
    left: -2px;
    right: 3px;
    bottom: 0;
    background-color: #DF2D36;
    -webkit-transition: .4s;
    transition: .4s;
  }
  
  .slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 17px;
    left: 10px;
    bottom: 5px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }
  
  input:checked + .slider {
    background-color: #62CA29;;
  }
  
  input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
  }
  
  input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }
  
  /* Rounded sliders */
  .slider.round {
    border-radius: 34px;
  }
  
  .slider.round:before {
    border-radius: 50%;
  } 

    
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <section class="content-header">
        <h1> Approval 
            <small> Perintah Kerja Lembur ( PKL )  </small></h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><i class="fa fa-files-o"></i> Approval</li>
            <li class="active"><i class="fa fa-files-o"></i> PKL</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        @include('layouts._flash')
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title text-center"> <strong>SECTION HEAD</strong> </h3>
                        </div>
                        <div class="box-body">
                            {!! Form::open(['method' => 'post', 'class'=>'form-horizontal']) !!}
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="col-lg-1 control-label">Username</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                        <input type="text" class="form-control" name="" id="" value="{{ Auth::user()->username }} - {{ Auth::user()->name }}" readonly required>
                                    </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-1 control-label">Periode Tahun</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                        <select id="filter_tahun" name="filter_tahun" aria-controls="filter_status" 
                                        class="form-control select2">
                                        @for ($i = \Carbon\Carbon::now()->format('Y'); $i > \Carbon\Carbon::now()->format('Y')-5; $i--)
                                          @if ($i == \Carbon\Carbon::now()->format('Y'))
                                            <option value={{ $i }} selected="selected">{{ $i }}</option>
                                          @else
                                            <option value={{ $i }}>{{ $i }}</option>
                                          @endif
                                        @endfor
                                        </select>
                                    </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-1 control-label">Periode Bulan</label>
                                    <div id="filter" class="col-lg-8">
                                        <div class="input-group">
                                            <select style="cursor:pointer;" id="filter_bulan" name="filter_bulan" aria-controls="filter_status" class="form-control">
                                                    <option value="01" @if ("01" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Januari</option>
                                                    <option value="02" @if ("02" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Februari</option>
                                                    <option value="03" @if ("03" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Maret</option>
                                                    <option value="04" @if ("04" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>April</option>
                                                    <option value="05" @if ("05" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Mei</option>
                                                    <option value="06" @if ("06" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Juni</option>
                                                    <option value="07" @if ("07" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Juli</option>
                                                    <option value="08" @if ("08" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Agustus</option>
                                                    <option value="09" @if ("09" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>September</option>
                                                    <option value="10" @if ("10" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Oktober</option>
                                                    <option value="11" @if ("11" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>November</option>
                                                    <option value="12" @if ("12" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Desember</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-1 control-label">Status PKL</label>
                                    <div id="filter" class="col-lg-8">
                                        <div class="input-group">
                                            <select style="cursor:pointer;" id="filter_statuspkl" name="filter_statuspkl" aria-controls="filter_status" class="form-control">
                                                    <option value="">Semua</option>
                                                    <option value="BELUM DI APPROVE" selected>Belum Approve</option>
                                                    <option value="SUDAH DI APPROVE">Sudah Approve</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            {!! Form::close() !!}  

                            {!! Form::open(['id'=>'FormDaftarPKL', 'method' => 'post', 'class'=>'form-horizontal']) !!}
                                {{ csrf_field() }}
                                <table id="TableLembur" class="table table-hover table-bordered table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            {{-- <th style="width:1%">No</th>  --}}
                                            <th style="width:10%"><center>Nama</center></th>
                                            <th style="width:1%"><center>Jml OT</center></th>  
                                            <th style="width:8%"><center>Pilih (*)</center></th>
                                            <th style="width:1%"><center>Info</center></th>
                                            <th><center>No Pkl</center></th>  
                                            <th><center>Tgl Pkl</center></th> 
                                        </tr>
                                    </thead>   
                                </table>
                                <br>
                            {!! Form::close() !!} 
                            <div>
                                <center> <strong> Pilih (*) : 
                                <img src="{{ asset('images/green.png') }}" alt="X"> Di Approve
                                <img src="{{ asset('images/red.png') }}" alt="X"> Di Batalkan
                                </center>
                            </div>
                            <br>
                            <div> 
                                <button type="button" onclick="ApprovePKL()" class="btn btn-primary center-block"> Approve </button>
                            </div>
                        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

    <div style="display: none">
        <form action="javascript:void(0)" method="post" id="form_sementara">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="isi" id="isi">
            <input type="submit" name="submitPKL" id="submitPKL">
        </form>
    </div>
@endsection


@section('scripts')
<script>

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            cache: false,
            headers: { "cache-control": "no-cache" },
        });
        
        var tablepkl = $('#TableLembur').DataTable({
            processing: true, 
            "oLanguage": {
            'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
            }, 
            //serverSide: true,
           // "pagingType": "numbers",
            fixedHeader: {
            header: true,
            },
            scrollY:        "300px",
            scrollX:        true,
            scrollCollapse: true,
            paging:         false,
            ajax: {
                url: '{{ route('sect.viewhome') }}',
                },
            "order": [[ 4, "desc" ]],
           // responsive: true,
            columns: [    
           // {data: 'DT_Row_Index', name: 'DT_Row_Index', searchable:false, orderable:false},
            {data: 'nama', name: 'nama'},
            {data: 'jam_lembur', name: 'jam_lembur'},
            {data: 'action', name: 'action', sortable:false,searchable:false},
            {data: 'info', name: 'info', sortable:false,searchable:true},
            {data: 'no_pkl', name: 'tpkla.no_pkl'},   
            {data: 'tgl_pkl', name: 'tgl_pkl'},
            ],
            }); 

            $('#filter_statuspkl').change(function(){
                tablepkl.column(3).search(this.value).ajax.reload();   
            });  

            $("#TableLembur").on('preXhr.dt', function(e, settings, data) {
                data.filter_tahun = $('select[name="filter_tahun"]').val();
                data.filter_bulan = $('select[name="filter_bulan"]').val();
            });

            $('select[name="filter_tahun"]').change(function() { tablepkl.ajax.reload();  });
            $('select[name="filter_bulan"]').change(function() { tablepkl.ajax.reload();  }); 
    }); 


    function checkData(no_pkl) {
        if ($(".action"+no_pkl).prop("checked") == true) {
            $(".action"+no_pkl).prop('checked', true);
        } else if ($(".action"+no_pkl).prop("checked") == false) {
            $(".action"+no_pkl).prop('checked', false);
        }
    }
        

    function ApprovePKL() {
        var a = [];
        $("[name='chk[]']:checked").each(function() {
            a.push(this.value);
        });
        if(a.length == 0 ){
            swal(
                'Perhatian !',
                'Pilih PKL Yang Ingin Di Approve Terlebih Dahulu',
                'error'
            )
        }else{
            $("#isi").val(a);
            $('#submitPKL').click();
        }
    }
  

    $('#form_sementara').submit(function(e) {
        e.preventDefault();
        swal({
            title: 'Anda Yakin Ingin Mengapprove PKL Ini ?',
            text: '',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText:  'Batalkan !',
            confirmButtonText: 'Ya,Approve !',
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            reverseButtons: false,
            focusCancel: false,
            }).then(function () {
                var data = $('#form_sementara').serialize();
                $.ajax({
                    type : "post",
                    url : "{{ route('update.sect') }}",
                    data : data,
                    dataType : "json",
                    success : function(data) {
                        swal({
                            title: 'Berhasil !',
                            text: 'PKL Telah Diapprove',
                            type: 'success',
                        });
                        $('#filter_statuspkl').trigger('change');
                    }
                });
        });
    });
 
</script>
@endsection


