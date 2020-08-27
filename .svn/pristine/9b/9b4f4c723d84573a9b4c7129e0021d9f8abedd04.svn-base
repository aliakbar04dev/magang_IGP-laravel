@extends('monitoring.ops.layouts.app')

@section('content')
	<BR>
	<div class="container2">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">

					<div class="panel-heading">
						<center><h4>Grafik Approve OPS per-Bulan</h4></center>
					</div>

					<div class="panel-body">
						{{-- <center><h4>Grafik Total OPS yang Masuk perbulan</h4></center> --}}
						<canvas id="barChart" width="775" height="150"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container2">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">

					<div class="panel-heading">
						<center><h4>Grafik Total OPS yang Masuk Tiap Bulan</h4></center>
					</div>

					<div class="panel-body">
						{{-- <center><h4>Grafik Total OPS yang Masuk perbulan</h4></center> --}}
						<canvas id="barChart2" width="1100" height="150"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{ asset('asset-ops/js/Chart.min.js') }}"></script>
	<script>
	var areaChartData = {
      labels: ["PRC to Bdg", "App Bdg Dept Head", "App Admin&IT Div Head", "Secretary Received Doc", "App Operational Dir", "App Fin Dir", "App Vice Pres Dir", "App Pres Dir", "Bdg Received Doc", "Bdg to PRC", "PRC Received Doc"], 
      datasets: [
        {
          label: "Standar",
          data: {!! json_encode($std) !!},
          backgroundColor: "blue",
		  borderColor: "blue",
        },
        {
          label: "Actual",
          data: {!! json_encode($act) !!},
          backgroundColor: "red",
		  borderColor: "red",
        }
      ]
    };

    var barChartOptions = {
    	responsive: true,
    	maintainAspectRatio: true,
      	scales: {
			yAxes: [{
				ticks: {
					beginAtZero:true,
					// max: 100, 
                	// stepSize: 50
                	callback: function(value, index, values) {
	                  // Remove the formatting to get integer data for summation
	                  var intVal = function (i) {
	                    return typeof i === 'string' ?
	                    i.replace(/[\$,]/g, '')*1 :
	                    typeof i === 'number' ?
	                    i : 0;
	                  };
	                  value = intVal(value);

	                  var format = function formatNumber(num) {
	                    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
	                  };

	                  return format(value);
	                }
				},
				gridLines: {
                    display:true
                }
			}],
			xAxes: [{
                gridLines: {
                    display:true
                }   
            }]
	  	},
	  	"hover": {
	      "animationDuration": 0
	    },
    	"animation": {
      		// "duration": 1,
      		"onComplete": function() {
	        	var chartInstance = this.chart,
	          	ctx = chartInstance.ctx;

		        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
		        ctx.fillStyle = 'black';
		        ctx.textAlign = 'center';
		        ctx.textBaseline = 'bottom';

		        this.data.datasets.forEach(function(dataset, i) {
		        	var meta = chartInstance.controller.getDatasetMeta(i);
		        	meta.data.forEach(function(bar, index) {
		        		var data = dataset.data[index];
	                  	// Remove the formatting to get integer data for summation
	                  	var intVal = function (i) {
		                    return typeof i === 'string' ?
		                    i.replace(/[\$,]/g, '')*1 :
		                    typeof i === 'number' ?
		                    i : 0;
		                };
		                data = intVal(data);

	                  	var format = function formatNumber(num) {
	                    	return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
	                  	};

	                  	data = format(data);
	                  	ctx.fillText(data, bar._model.x, bar._model.y - 5);
		        	});
		        });
      		}
    	},
	    legend: {
	       "display": true,
	       labels: {
	            // This more specific font property overrides the global property
	            fontColor: 'black',
	            //fontSize: 12,
	        }
	    },
	    tooltips: {
            mode: 'index',
            intersect: true, 
            callbacks: {
              title: function(tooltipItem, data) {
                return data['labels'][tooltipItem[0].index];
              },
              label: function(tooltipItem, data) {
                var label = tooltipItem.yLabel;
                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                  return typeof i === 'string' ?
                  i.replace(/[\$,]/g, '')*1 :
                  typeof i === 'number' ?
                  i : 0;
                };
                label = intVal(label);

                var format = function formatNumber(num) {
                  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                };

                label = format(label);
                return data.datasets[tooltipItem.datasetIndex].label + ": " + label;
              },
            },
        }
    };

    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas, {
		type: 'bar',
		data: areaChartData,
		options: barChartOptions
	});

	/////////////////////////////////////////////////////////////////////////////
	
	var areaChartData2 = {
      labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"], 
      datasets: [
        {
          label: "Standar",
          data: {!! json_encode($std2) !!},
          backgroundColor: "blue",
		  borderColor: "blue",
        },
        {
          label: "Actual",
          data: {!! json_encode($act2) !!},
          backgroundColor: "red",
		  borderColor: "red",
        }
      ]
    };

    var barChartOptions2 = {
    	responsive: true,
    	maintainAspectRatio: true,
      	scales: {
			yAxes: [{
				ticks: {
					beginAtZero:true,
					// max: 100, 
                	// stepSize: 50
                	callback: function(value, index, values) {
	                  // Remove the formatting to get integer data for summation
	                  var intVal = function (i) {
	                    return typeof i === 'string' ?
	                    i.replace(/[\$,]/g, '')*1 :
	                    typeof i === 'number' ?
	                    i : 0;
	                  };
	                  value = intVal(value);

	                  var format = function formatNumber(num) {
	                    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
	                  };

	                  return format(value);
	                }
				},
				gridLines: {
                    display:true
                }
			}],
			xAxes: [{
                gridLines: {
                    display:true
                }   
            }]
	  	},
	  	"hover": {
	      "animationDuration": 0
	    },
    	"animation": {
      		// "duration": 1,
      		"onComplete": function() {
	        	var chartInstance = this.chart,
	          	ctx = chartInstance.ctx;

		        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
		        ctx.fillStyle = 'black';
		        ctx.textAlign = 'center';
		        ctx.textBaseline = 'bottom';

		        this.data.datasets.forEach(function(dataset, i) {
		        	var meta = chartInstance.controller.getDatasetMeta(i);
		        	meta.data.forEach(function(bar, index) {
		        		var data = dataset.data[index];
	                  	// Remove the formatting to get integer data for summation
	                  	var intVal = function (i) {
		                    return typeof i === 'string' ?
		                    i.replace(/[\$,]/g, '')*1 :
		                    typeof i === 'number' ?
		                    i : 0;
		                };
		                data = intVal(data);

	                  	var format = function formatNumber(num) {
	                    	return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
	                  	};

	                  	data = format(data);
	                  	ctx.fillText(data, bar._model.x, bar._model.y - 5);
		        	});
	        	});
      		}
    	},
	    legend: {
	       "display": true,
	       labels: {
	            // This more specific font property overrides the global property
	            fontColor: 'black',
	            //fontSize: 12,
	        }
	    },
	    tooltips: {
            mode: 'index',
            intersect: true, 
            callbacks: {
              title: function(tooltipItem, data) {
                return data['labels'][tooltipItem[0].index];
              },
              label: function(tooltipItem, data) {
                var label = tooltipItem.yLabel;
                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                  return typeof i === 'string' ?
                  i.replace(/[\$,]/g, '')*1 :
                  typeof i === 'number' ?
                  i : 0;
                };
                label = intVal(label);

                var format = function formatNumber(num) {
                  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                };

                label = format(label);
                return data.datasets[tooltipItem.datasetIndex].label + ": " + label;
              },
            },
        }
    };

    var barChartCanvas2 = $("#barChart2").get(0).getContext("2d");
    var barChart2 = new Chart(barChartCanvas2, {
		type: 'bar',
		data: areaChartData2,
		options: barChartOptions2
	});

    //auto refresh
    setTimeout(function() {
	  location.reload();
	}, 60000); //1000 = 1 second
	</script>
@endsection