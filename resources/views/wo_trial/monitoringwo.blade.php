@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="a">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Monitoring
            <small>Work Order</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><i class="fa fa-files-o"></i> Work Order</li>
            <li class="active"><i class="fa fa-files-o"></i> Monitoring Work Order</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('layouts._flash')
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    @permission(['it-wo-create'])
                    <div class="box-header">
                        <p>
                            <a class="btn btn-primary" href="{{ route('wos.create') }}">
                                <span class="fa fa-plus"></span> Add Daftar Work Order
                            </a>
                        </p>
                    </div>
                    <!-- /.box-header -->
                    @endpermission


                   {{--  DI LUAR PERMISSION  --}}
                    <div class="box-header" center>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary">Lihat Daftar Status WO</button>
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('workorders/atasanbelumapproval')}}">Belum Diapprove Atasan</a></li>       
                                    <li><a href="{{ url('workorders/atasansudahapproval')}}">Sudah Diapprove Atasan</a></li>                             
                                    <li><a href="{{ url('workorders/atasantolakapproval')}}">Ditolak Atasan</a></li>
                                    <li class="divider"></li>
                                    <li><a href="{{ url('workorders/ITbelumapproval ')}}">Belum Diapprove IT</a></li>       
                                    <li><a href="{{ url('workorders/ITsudahapproval ')}}">Sudah Diapprove IT</a></li>                             
                                    <li><a href="{{ url('workorders/ITtolakapproval ')}}">Ditolak IT</a></li>
                                    <li class="divider"></li>
                                    <li><a href="{{ url('workorders/sudahclosing ')}}">Sudah Close</a></li>
                                </ul>
                            </div>
                    </div>


                    <div class="box-body">
                    <div>
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <table id="datatables" class="table table-hover table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                  
                                    <th>Nomor WO</th>
                                    <th>Action</th>                         
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
        var table = $('#datatables').DataTable({
            processing: true, 
        "oLanguage": {
          'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
        }, 
            searching: true,
            ajax: {
            url: '{{ url("/workorders/viewmonitoring") }}'
            },
            "order": [[ 0, "desc" ]],
            fixedHeader: {
            header: true,
            },
            scrollY:        "300px",
            scrollX:        true,
            scrollCollapse: true,
            paging:         false,
            responsive:     false,
            columns: [              
            {data: 'nowo', name: 'wo_it.nowo'}, 
            {data: 'action', name: 'action', orderable:false, searchable:false},
            ],
            }); 
        });
</script>

<script>
        function OnCloseClick(ths){
            var msg = 'Anda yakin ingin mengeclose  ' + ths + '?';
            var txt = '';
            swal({
                title: msg,
                text: txt,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya !',
                cancelButtonText: 'Cancel !',
                allowOutsideClick: true,
                allowEscapeKey: true,
                allowEnterKey: true,
                reverseButtons: false,
                focusCancel: true,
            }).then(function () {
                var nowo = document.getElementById('nowo' + ths).value.trim();
                var token = document.getElementsByName('_token')[0].value.trim();
                $.ajax({
                    url      : "{{ route('proses.selesai')}}",
                    type     : 'POST',
                    dataType : 'json',
                    data     : {
                      nowo   : nowo,
                      _token  : token,
                    },
                    success: function(_response){
                      if(_response.indctr == '1'){
                      location.reload();
                    } else if(_response.indctr == '0'){
                      console.log(_response)
                      swal('Terjadi kesalahan', 'Segera hubungi IT!', 'error')
                    }
                  },
                  error: function(){
                    swal(
                      'Terjadi kesalahan',
                      'Segera hubungi IT!',
                      'error'
                      )
                  }
                  });
            }, function (dismiss) {
                // dismiss can be 'cancel', 'overlay',
                // 'close', and 'timer'
                if (dismiss === 'cancel') {
                // swal(
                //   'Cancelled',
                //   'Your imaginary file is safe :)',
                //   'error'
                // )
                }
        });
    }
</script>
@endsection 
