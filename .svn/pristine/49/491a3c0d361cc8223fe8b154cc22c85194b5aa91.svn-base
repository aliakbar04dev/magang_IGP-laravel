@extends('monitoring.mtc.layouts.app3')
<style>
.widget {
	float: center;
    position: center;
    margin-bottom: 80px;
    width: 70%;
    background: #fff;
    border-color: #f7f8ff;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
     margin-left: 10%;
     margin-right: 10%;
}
</style>

@section('content')
	<div class="container3">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<table width="100%">
							<tr>
								<th style='width: 10%;text-align: center'>&nbsp;</th>
								<th style='text-align: center'>
									{{-- <center> --}}
										<h4>Grafik Level Instalasi Air Limbah {{ \Carbon\Carbon::createFromFormat('Ymd', $tgl)->format('d F Y') }}</h4>
									{{-- </center> --}}
								</th>
								<th style='width: 10%;text-align: right;'>
									<button id="btn-close" name="btn-close" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Close" onclick="window.open('', '_self', ''); window.close();">
										<span class="glyphicon glyphicon-remove"></span>
									</button>
								</th>
							</tr>
						</table>
					</div>

					<div class="panel-body">
						<div class="box-body form-horizontal" id="box-overflow-2">
							<div class="form-group">
								  <div class="col-sm-2">
					              {!! Form::label('tgl', 'Tanggal') !!}
					              @if ($tgl == \Carbon\Carbon::now()) 
					              {!! Form::date('tgl', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Awal', 'id' => 'tgl']) !!}
					              @else
					               {!! Form::date('tgl', \Carbon\Carbon::parse($tgl), ['class'=>'form-control','placeholder'=> 'Tgl Awal', 'id' => 'tgl']) !!}
					              @endif
					            </div>
						
								<div class="col-sm-2" >
									{!! Form::label('lblusername2', 'Action') !!}
									<button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
								</div>
							</div>
							<!-- /.form-group -->
						</div>
						<div>
							<img src="{{ asset('images/green.png') }}" alt="X"> Normal 
							<img src="{{ asset('images/yellow.png') }}" alt="X"> Warning
							<img src="{{ asset('images/red.png') }}" alt="X"> Emergancy
						</div>
						 <div class="widget">
                    	 <canvas id="levelair" class="canvas-container" ></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
<script src="{{asset('js/Chart.min.js')}}"></script>
<script src="{{ asset('js/freeze-table.js') }}"></script>
<script>

	//Initialize Select2 Elements
    $(".select2").select2();

    $(function() {
    	$('.freeze-table').freezeTable({
    		'columnNum' : 2,
    		'columnKeep': true,
    	});
    });

    $('#display').click( function () {
      var str = $('input[name="tgl"]').val();
      var tahun	= str.substring(0,4);
	  var bulan =	str.substring(5,7);
	  var tgl =	str.substring(8.10);
	  var param = tahun + "" + bulan + "" + tgl;
	  var test = 'test'	
	  var urlRedirect = "{{ route('ehsenvreps.grafik_alimbah', 'param') }}";
	  urlRedirect = urlRedirect.replace('param', param);
	  window.location.href = urlRedirect;
    });

    var label_lal = <?php echo $label_lal; ?>;
    var lal_wwt = <?php echo $lal_wwt; ?>;
    var lal_stp = <?php echo $lal_stp; ?>;
    var lal_bs = <?php echo $lal_bs; ?>;
    var lal_et = <?php echo $lal_et; ?>;

	 if (lal_wwt >= 68) {
      var warna = '#FF0000';
      var labelwarna = 'Emergency'; 
    } else if (lal_wwt < 68 && lal_wwt >= 44 ){
      var warna = '#FFFF00';
      var labelwarna = 'Warning'; 
    }
    else if (lal_wwt < 43 && lal_wwt >= 0 ){
      var warna = '#006400'; 
      var labelwarna = 'Normal';
    }

     if (lal_stp >= 39) {
      var warna2= '#FF0000'; 
      var labelwarna2 = 'Emergency'; 
    } else if (lal_stp < 39 && lal_stp >= 35 ){
      var warna2 = 'rgba(253,215,3,5)';
      var labelwarna2 = 'Warning';  
    }
    else if (lal_stp < 35 && lal_stp >= 0 ){
      var warna2 = '#006400'; 
      var labelwarna2 = 'Normal';  
    }

    if (lal_bs >= 11) {
      var warna3= '#FF0000'; 
      var labelwarna3 = 'Emergency'; 
    } else if (lal_bs < 11 && lal_bs >= 8 ){
      var warna3 = '#FFFF00'; 
      var labelwarna3 = 'Warning'; 
    }
    else if (lal_bs < 8 && lal_bs >= 0 ){
      var warna3 = '#006400'; 
      var labelwarna3 = 'Normal';
    }

    if (lal_et >= 4) {
      var warna4= '#FF0000'; 
      var labelwarna4 = 'Emergency'; 
    } else if (lal_et < 4 && lal_et >= 3 ){
      var warna4 = '#FFFF00'; 
      var labelwarna4 = 'Warning'; 
    }
    else if (lal_et < 3 && lal_et >= 0 ){
      var warna4 = '#006400'; 
      var labelwarna4 = 'Normal';
    }

    var asd = [];
    asd.push(lal_wwt.toString());
    asd.push(lal_stp.toString());
    asd.push(lal_bs.toString());
    asd.push(lal_et.toString());
    var asde = [];
    asde.push(warna);
    asde.push(warna2);
    asde.push(warna3);
    asde.push(warna4);
    var asdf = [];
    asdf.push(labelwarna);
    asdf.push(labelwarna2);
    asdf.push(labelwarna3);
    asdf.push(labelwarna4);


    var LalWtpChartData = {
        title : 'Level Instalasi Air Limbah',
        labels: label_lal,
        datasets: [{
            backgroundColor: asde,
            data: asd
        }]
    };


    window.onload = function() {
         var levelair = document.getElementById("levelair").getContext("2d");

 			window.myBar = new Chart(levelair, {
            type: 'bar',
            data: LalWtpChartData,
            options: {
              legend: {
                    display:false,
                   },
                elements: {
                    rectangle: {
                        borderWidth: 0.3,
                        borderColor: 'rgb(0, 0, 0)',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,  
                title : {
                display:false,
                text:'Level Instalasi Air Limbah'
                  },       
                scales: {
                  yAxes:[{
                    scaleLabel: {
                          display: true,
                          labelString: "M3",
                          fontColor: "black"
                        },
                    ticks : {
                      beginAtZero : true
                    }
                  }]
                },      
              }       
        	});
     };
</script>
@endsection