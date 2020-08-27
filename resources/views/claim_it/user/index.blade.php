@extends('layouts.app')
@section('content')

<style>
    .input-group .form-control {
        position: relative;
        z-index: 2;
        float: left;
        width: 117%;
        margin-bottom: 0;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Daftar
            <small> Claim IT</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><i class="fa fa-files-o"></i> Claim IT</li>
            <li class="active"><i class="fa fa-files-o"></i> Daftar Input</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('layouts._flash')   
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                     <div class="box-header with-border" center>
                        <a href="#" class="btn btn-primary" id="btn-tambah">
                            <i class="fa fa-user-plus">&nbsp; Add New Claim </i>
                        </a>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-lg-1 control-label">Username</label>
                            <div class="col-lg-8">
                                <div class="input-group">
                                <input type="text" class="form-control" name="" id="" value="{{ Auth::user()->username }} - {{ Auth::user()->name }}" readonly>
                                </div>
                            </div>
                        </div>
                        <table id="TableClaim" class="table table-hover table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width:1%"><center>Info</center></th>
                                    <th style="width:5%"><center>Tgl</center></th> 
                                    <th style="width:5%"><center>Status</center></th> 
                                </tr>
                            </thead>   
                        </table>

                            <!-- Modal Tambah Data -->
                            <div class="modal fade" id="pengajuanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-red">
                                        <button type="button" class="btn btn-sm btn-default pull-right" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                                        <h2 class="modal-title"><b>Form Pengajuan Claim IT</b></h2>
                                    </div>
                                    <div class="modal-body">
                                        {!! Form::open(['id' => 'form-claim', 'method' => 'post', 'class'=>'form-horizontal']) !!}
                                        {{ csrf_field() }}
                                            <div class="modal-body mx-3">
                                                <div class="md-form mb-5">
                                                    <label>Username</label>
                                                    <input type="text" class="form-control" name="" id="" value="{{ Auth::user()->username }} - {{ Auth::user()->name }}" readonly>
                                                </div>
                                            </div>    
                                            <div class="modal-body mx-3">
                                                <div class="md-form mb-5">
                                                    <label>Jenis Claim</label>
                                                    <select class="form-control" name="jenis_claim" id="jenis_claim">
                                                        <option value="1"> APLIKASI     </option>
                                                        <option value="2"> NON APLIKASI  </option>
                                                    </select>
                                                </div>
                                            </div>  
                                            <div class="modal-body mx-3">
                                                <div class="md-form mb-5">
                                                    <label>ID PC/Notebook/Lainnya</label>
                                                    <input type="text" class="form-control" name="id_hw" id="id_hw">
                                                </div>
                                                <small class="form-text text-danger">Boleh Dikosongkan</small>
                                            </div>  
                                            <div class="modal-body mx-3">
                                                <div class="md-form mb-5">
                                                    <label>Keterangan Claim</label>
                                                    <textarea class="form-control" name="ket_claim" id="ket_claim" required></textarea>
                                                </div>
                                            </div>  
                                            <div class="modal-body mx-3">
                                                <div class="md-form mb-5">
                                                    <label>Ext</label>
                                                    <input type="number" class="form-control" name="ext" id="ext" required>
                                                </div>
                                            </div>  
                                            <div class="modal-body mx-3">
                                                <div class="md-form mb-5">
                                                    <label>Hp</label>
                                                    <input type="number" class="form-control" name="hp" id="hp" required>
                                                </div>
                                            </div>  
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" id="btn-submit">Submit</button>
                                        </div>
                                    {!! Form::close() !!}  
                                </div>
                                </div>
                            </div>
                            </div>


                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
   
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('scripts')
<script>
        $(document).ready(function () {
            var table = $('#TableClaim').DataTable({
              processing: true, 
            "oLanguage": {
            'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
            }, 
                ajax: {
                    url: '{{ route('user.daftar') }}'
                },
                "order": [[ 1, "desc" ]],
                fixedHeader: {
                    header: true,
                },
                scrollY:        "300px",
                scrollX:        true,
                scrollCollapse: true,
                paging:         false,
                columns: [         
                {data: 'info', name: 'info', orderable:false, searchable:false},   
                {data: 'tgl_claim', name: 'tgl_claim'},  
                {data: 'status', name: 'status'},
              ],
                });      
        });


    $(document).on('click', '#btn-tambah', function() {
        $('#pengajuanModal').modal('show');
    });

    $('#form-claim').submit(function(e) {
        e.preventDefault();
        swal({
            title: 'Anda Yakin Mengirim Claim ini ?',
            text: '',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText:  'Batalkan !',
            confirmButtonText: 'Ya,Kirim !',
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            reverseButtons: false,
            focusCancel: false,
            }).then(function () {
                var data = $('#form-claim').serialize();
                $.ajax({
                    type : "post",
                    url : "{{ route('proses.submit') }}",
                    data : data,
                    dataType : "json",
                    success : function(data) {
                        swal({
                            title: 'Berhasil !',
                            text: 'Claim Berhasil Dikirim',
                            type: 'success',
                        });
                        return [ window.location = '/user/daftar' ]
                    }
                });
        });
    });


   

  
  

  
 
</script>
@endsection
