@extends('layouts.app')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Daftar Respon
            <small> Claim IT</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><i class="fa fa-files-o"></i> Claim IT</li>
            <li class="active"><i class="fa fa-files-o"></i> Daftar Respon</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('layouts._flash')   
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                     <div class="box-header with-border" center>
                            Daftar Claim Untuk Direspon Staff IT
                    </div>
                    <div class="box-body">
                        <table id="TableClaimRespon" class="table table-hover table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width:1%">No</th>
                                    <th style="width:1%">Tgl</th>
                                    <th style="width:5%">Claim</th> 
                                    <th style="width:5%">Info</th> 
                                </tr>
                            </thead>   
                        </table>
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
            var table = $('#TableClaimRespon').DataTable({
              processing: true, 
            "oLanguage": {
            'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
            }, 
                ajax: {
                    url: '{{ route('staff.daftar') }}'
                },
                "order": [[ 0, "asc" ]],
                fixedHeader: {
                    header: true,
                },
                scrollY:        "300px",
                scrollX:        true,
                scrollCollapse: true,
                paging:         false,
                columns: [         
                {data: 'DT_Row_Index', name: 'DT_Row_Index', searchable:false, orderable:false},
                {data: 'tgl_claim', name: 'tgl_claim'},  
                {data: 'ket_claim', name: 'ket_claim'}, 
                {data: 'info', name: 'info', orderable:false, searchable:false},   
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
