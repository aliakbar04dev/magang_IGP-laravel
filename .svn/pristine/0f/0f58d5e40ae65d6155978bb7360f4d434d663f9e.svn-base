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
    background-color: white;
}





</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Internal Audit
            <small>Grafik Temuan Internal Audit</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Grafik Temuan Internal Audit</li>
        </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
        @include('layouts._flash')
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-7">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Grafik Temuan Internal Audit</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                    <canvas id="myChart" style="width:50%;" width="200" height="200"></canvas>
                   </div>
                    <!-- ./box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="col-md-5">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Detail Temuan Internal Audit</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
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
</script>
<script src="{{ asset('chartjs/Chart.bundle.js') }}"></script>
  <script src="{{ asset('chartjs/utils.js') }}"></script>
<script>
    var div = {!! json_encode($get_data) !!};
    var major = {!! json_encode($get_major) !!};
    var minor = {!! json_encode($get_minor) !!};

window.onload = function() {
    var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'horizontalBar',
    data: {
        // labels: ['PRC', 'HRD', 'ENG', 'MTC', 'QCO', 'PPC', 'PRO R/A', 'PRO PS & 5C', 'PRO HSG', 'PRO A/S', 'PRO IGP1'],
        labels: div,
        datasets: [{
            label: ['MINOR'],
            data: minor,
            backgroundColor: 'rgba(255, 206, 86, 0.2)',
            borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 1,
            barPercentage: 0.5,
            barThickness: 6,
            maxBarThickness: 8,
            minBarLength: 2,
        },{
            label: ['MAJOR'],
            data: major,
            backgroundColor: 'rgba(255,99,132,0.2)',
            borderColor: 'rgba(255,99,132,1)',
            borderWidth: 1,
            barPercentage: 0.5,
            barThickness: 6,
            maxBarThickness: 8,
            minBarLength: 2,
        }]
    },
    options: {
        scales: {
        xAxes: [{
            gridLines: {
                offsetGridLines: true
            },
            ticks: {
                beginAtZero: true
            },
            stacked: true,
        }],
        yAxes : [{
            stacked: true,
        }]
    }
    }
});
}


</script>

@endsection
