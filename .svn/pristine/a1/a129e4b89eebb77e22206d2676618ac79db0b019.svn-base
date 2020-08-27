@extends('layouts.app')
@section('content')

<style>
    
    td, th {
        padding: 8px 10px 8px 0px;;
    }
    
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Internal Audit
            <small>Daftar Temuan Audit</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Daftar Temuan Audit</li>
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
                        <h3 class="box-title">Daftar Temuan Audit</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <a href="{{ route('auditors.temuanauditform') }}" class="btn btn-primary" style="margin-bottom:8px;">Input Temuan Audit</a>
                        <select autocomplete="off" class="form-control" id="sign_filter" style="width: 144px;display: inline;padding-top: 8px;margin-left: 8px;">
                            <option value="action">NEED ACTION</option>
                            <option value="signed">SIGNED</option>
                            <option value="">ALL DATA</option>
                        </select>
                        <select autocomplete="off" class="form-control" id="periode_filter" style="width: 144px;display: inline;padding-top: 8px;margin-left: 8px;">
                            <option value="">SEMUA PERIODE</option>
                            <option value="/I/">I (SATU)</option>
                            <option value="/II/">II (DUA)</option>
                        </select>
                        <table id="daftartemuan" class="table table-bordered table-hover"  style="width:100%;margin-top: -12px;">
                            <thead>
                                <tr>
                                    <th style="width:1%">NO.</th>
                                    <th>FINDING NO.</th>
                                    <th>SUBMIT DATE</th>
                                    <th>SUBMITTED BY</th>
                                    <th>ACTION NEEDED</th>
                                </tr>
                            </thead>                           
                        </table>  
                    </div>
                    <!-- ./box-body -->
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
<script type="text/javascript">

    var table = $('#daftartemuan').DataTable({
    "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
    "iDisplayLength": 10,
    responsive: true,
    "searching": true,
    "paging": true,
    "order": [[2, 'desc'], [4, 'desc']],
    processing: true, 
    "oLanguage": {
      'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
    }, 
    // serverSide: true,
    ajax: "{{ route('auditors.daftartemuan')}}",
    columns: [
        {data: 'DT_Row_Index', name: 'DT_Row_Index', searchable:false, orderable:false},
        {data: 'finding_no', name: 'finding_no'},
        {data: 'tanggal', name: 'tanggal'},
        {data: 'creaby', name: 'creaby'},
        {data: 'status', name: 'status'},
        
        ]
  });

  table.on( 'order.dt search.dt', function () {
    table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

    $('#sign_filter').on('change', function(){
        table.ajax.reload(function(){
        });
        table.column(4).search(this.value).draw();
        });

    $('#periode_filter').on('change', function(){
    table.ajax.reload(function(){
    });
    table.column(2).search(this.value).draw();
    }); 

    $('#sign_filter').ready(function(){
    table.column(4).search('action').draw();   
    });   
    
</script>

@endsection
