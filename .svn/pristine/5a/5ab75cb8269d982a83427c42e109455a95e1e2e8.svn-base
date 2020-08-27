@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Daftar
            <small>Work Order</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><i class="fa fa-files-o"></i> Work Order</li>
            <li class="active"><i class="fa fa-files-o"></i> Daftar Work Order</li>
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

                     <div class="box-header" center>
                        <a href="{{ route('view.pengajuan') }}" class="btn btn-primary">
                            <i class="fa fa-user-plus">&nbsp; Add Pengajuan WO</i>
                        </a>
                    </div>


                    <div class="box-body">
                       <table class="table table-hover table-bordered table-striped" id="datatables" style="width:100%">
                        <thead class="text-center">
                            <tr class="text-center">
                                <th style="width:1%;">No</th>
                               
                                <th>Pembuat WO</th>
                                <th>Approve Atasan Ybs</th>                        
                                <th>Approve IT</th>  
                                <th>No WO</th>
                                <th>Tgl Dibuat</th>
                                <th>Permintaan</th>   
                              
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($karyawan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                             
                                <td>{{ $item->nama }} - {{ $item->npk }}</td>

                                @if($item->status == '0')    
                                <td><div class="btn btn-xs btn-warning"><i class="fa fa-clock-o"></i> <b>Belum Approve</b></div></td>
                                @elseif($item->status == '1' or $item->status == '3' or $item->status == '4' or $item->status == '9')
                                <td><div class="btn btn-xs btn-success"><i class="fa fa-check"></i> <b>Disetujui</b></div></td>
                                @else($item->status == '2')
                                <td><div class="btn btn-xs btn-danger"><i class="fa fa-remove"></i> <b>Ditolak</b></div></td>
                                @endif
                                
                                @if($item->status == '1')    
                                <td><div class="btn btn-xs btn-warning"><i class="fa fa-clock-o"></i> <b>Belum Approve</b></div></td>
                                @elseif($item->status == '3')
                                <td><div class="btn btn-xs btn-success"><i class="fa fa-check"></i> <b>Disetujui</b></div></td>
                                @elseif($item->status == '4')
                                <td><div class="btn btn-xs btn-danger"><i class="fa fa-remove"></i> <b>Ditolak</b></div></td>
                                @elseif($item->status == '9')
                                <td><div class="btn btn-xs btn-default"><i class="fa fa-check"></i> <b>Sudah Close</b></div></td>
                                @else($item->status == '0')
                                <td></td>
                                @endif

                                <td>{{ $item->nowo }}</td>

                                <td>{{ date('d/m/Y', strtotime($item->tglwo)) }}</td>     

                                <td>{{ $item->ketwo }}</td>

                              
                                
                            </tr>                       
                            @endforeach                                                 
                        </tbody>
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
        $(document).ready( function () {
          $('#datatables').DataTable({
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            fixedHeader: {
                header: true,
            },
            scrollY:        "300px",
            scrollX:        true,
            scrollCollapse: true,
            paging:         false,
            responsive:     false,
            "order": [[ 4, "desc" ]]
          });
        } );

</script>
@endsection 
