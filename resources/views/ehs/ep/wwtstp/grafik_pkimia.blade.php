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
										<h4>Grafik Pemakaian Bahan Kimia {{ \Carbon\Carbon::createFromFormat('Ymd', $tgl)->format('d F Y') }}</h4>
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
							<img src="{{ asset('images/red.png') }}" alt="X"> Emergancy
						</div>
						 <div class="widget">
							
             
                   
                      <canvas id="pbkimia" class="canvas-container" ></canvas>

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
	  var urlRedirect = "{{ route('ehsenvreps.grafik_pkimia', 'param') }}";
	  urlRedirect = urlRedirect.replace('param', param);
	  window.location.href = urlRedirect;
    });


    var pembk1 = <?php echo $pembk1; ?>;
    var pembk2 = <?php echo $pembk2; ?>;
    var pembk3 = <?php echo $pembk3; ?>;
    var pembk4 = <?php echo $pembk4; ?>;
    var pembk5 = <?php echo $pembk5; ?>;
    var pembk6 = <?php echo $pembk6; ?>;
    var pembk7 = <?php echo $pembk7; ?>;
    var label_pk = <?php echo $label_pk; ?>;

    //Pemakaian Bahan Kimia
	if (pembk1 > 100) {
	      var w1= '#FF0000'; 
	    } else{
	      var w1 = '#006400'; 
	    }
	if (pembk2 > 350) {
	      var w2= '#FF0000'; 
	    } else{
	      var w2 = '#006400'; 
	    }
	if (pembk3 > 50) {
	      var w3= '#FF0000'; 
	     } else{
	      var w3 = '#006400'; 
	     }
	if (pembk4 > 0.20) {
	      var w4= '#FF0000'; 
	     } else{
	      var w4 = '#006400'; 
	     }
	if (pembk5 > 8) {
	      var w5= '#FF0000'; 
	     } else{
	      var w5 = '#006400'; 
	     }
	if (pembk6 > 2) {
	      var w6= '#FF0000'; 
	     } else{
	      var w6 = '#006400'; 
	     }
	if (pembk7 > 2) {
	      var w7= '#FF0000'; 
	     } else{
	      var w7 = '#006400'; 
	     }
   var PembkChartData = {
        title : 'Pemakaian Bahan Kimia',
        labels: ['Ca(OH)2', 'AL2O3', 'H2SO4', 'Polimer', 'Clevpro 103', 'Bacteria Booster', 'Metal Remove'],
        datasets: [{
            backgroundColor: [w1, w2, w3, w4, w5, w6, w7 ],
            data:  [pembk1.toString(), pembk2.toString(), pembk3.toString(), pembk4.toString(), pembk5.toString(), pembk6.toString(), pembk7.toString() ],
        }]
    };

    window.onload = function() {
        var pbkimia = document.getElementById("pbkimia").getContext("2d");

           window.myBar = new Chart(pbkimia, {
            type: 'bar',
            data: PembkChartData,
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
                text:'Pemakaian Bahan Kimia'
                  },       
                scales: {
                  yAxes:[{
                    scaleLabel: {
                          display: true,
                          labelString: "Kg",
                          fontColor: "black"
                        },
                    barPercentage :5,
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