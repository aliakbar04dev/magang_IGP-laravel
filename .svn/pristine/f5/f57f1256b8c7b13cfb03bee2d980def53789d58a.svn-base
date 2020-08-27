<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Q. Anianda -->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.env', 'local') === 'production' ? config('app.name', 'Laravel') : config('app.name', 'Laravel').' TRIAL' }}</title>
    <link rel="shortcut icon" href="{{ asset('images/splash.png') }}"/>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <noscript>
      <H1 align = 'center'>This page needs JavaScript activated to work.</H1>
      <style>nav { display:none; } div { display:none; }</style>
    </noscript>

    <style>
      /*html {
        height:100%
      }*/
      body {
        /*height:97%;*/
        background-color: black;
        font-family: 'Garamond'; /* https://en.wikipedia.org/wiki/Font_family_(HTML) */
      }

      #btn-top {
        display: none;
        position: fixed;
        bottom: 20px;
        right: 5px;
        z-index: 99;
        font-size: 18px;
        border: none;
        outline: none;
        background-color: gray;
        color: white;
        cursor: pointer;
        padding: 15px;
        border-radius: 4px;
      }

      #btn-top:hover {
        background-color: #555;
      }

      /*background-color: black;*/
    </style>
  </head>
  <body>
    <table cellspacing="0" style="width: 100%;height:100%;">
      <thead>
        <tr>
          <th style="width:95%;color: white;text-align: center;font-size:22px;">
            TOTAL POWER CONSUMPTION MDB 1, 2, 3 & 4
          </th>
          <th style="width:5%;color: white;text-align: right;">
            <button id="btn-close" name="btn-close" style="background: red;color: white;" data-toggle="tooltip" data-placement="top" title="Close" onclick="window.open('', '_self', ''); window.close();">
              <strong>X</strong>
            </button>
          </th>
        </tr>
      </thead>
    </table>
    <table cellspacing="0" style="width: 100%;height:100%;">
      <thead>
        <tr>
          <td style="width:70%">
            <table cellspacing="0" style="width: 100%;height:100%;">
              <tr>
                <th style="border-color: white;border-top: 2px solid;border-bottom: 2px solid;border-left: 2px solid;border-right: 2px solid;text-align: center;color: white;width: 100%;">
                  <canvas id="canvas-1" style="height:90vh; width:70vw"></canvas>
                </th>
              </tr>
            </table>
          </td>
          <td style="width:30%;">
            <table cellspacing="0" style="width: 100%;height:100%;">
              <tr>
                <th style="border-color: white;border-top: 2px solid;border-bottom: 2px solid;border-left: 2px solid;border-right: 2px solid;text-align: center;color: white;">
                  <canvas id="canvas-2"></canvas>
                </th>
              </tr>
            </table>
          </td>
        </tr>
      </thead>
    </table>
    <button id="btn-top" name="btn-top" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Go to Top" onclick="topFunction()">
      <span class="glyphicon glyphicon-menu-up"></span>
    </button>
    <!-- Scripts -->
    <script src="{{ asset('chartjs/Chart.bundle.js') }}"></script>
    <script src="{{ asset('chartjs/utils.js') }}"></script>
    <script src="{{ asset('js/Gauge.js') }}"></script>
    <script type="text/javascript">
      // document.body.style.backgroundColor = "black";

      //Get the button
      var mybutton = document.getElementById("btn-top");

      // When the user scrolls down 20px from the top of the document, show the button
      window.onscroll = function() {scrollFunction()};

      function scrollFunction() {
        if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
          mybutton.style.display = "block";
        } else {
          mybutton.style.display = "none";
        }
      }

      // When the user clicks on the button, scroll to the top of the document
      function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
      }

      @if (isset($value_x_1) && isset($value_y_1) && isset($value_x_2) && isset($value_y_2))
        var chartData1 = {
          labels: {!! json_encode($value_x_1) !!}, 
          datasets: 
          [
            {
              type: 'bar',
              label: 'Date',
              backgroundColor: "blue",
              data: {!! json_encode($value_y_1) !!}, 
              borderColor: 'white',
              borderWidth: 2

              // type: 'line',
              // label: 'Date',
              // borderColor: window.chartColors.blue,
              // backgroundColor: window.chartColors.blue,
              // borderWidth: 2,
              // fill: false, //[false, 'origin', 'start', 'end']
              {{-- // data: {!! json_encode($value_y_1) !!} --}}
            }
          ]
        };

        var chartData2 = {
          labels: {!! json_encode($value_x_2) !!}, 
          datasets: 
          [
            {
              backgroundColor: ["blue", "red", "green", "yellow"],
              borderWidth: [2, 2, 2, 2],
              borderAlign: 'center',
              borderColor: 'white', 
              data: {!! json_encode($value_y_2) !!}
            }
          ]
        };
      @endif

      @if (isset($value_x_1) && isset($value_y_1) && isset($value_x_2) && isset($value_y_2))
        window.onload = function() {
          // Chart.Legend.prototype.afterFit = function() {
          //   this.height = this.height + 15;
          // };
          var ctx1 = document.getElementById('canvas-1').getContext('2d');
          window.myMixedChart1 = new Chart(ctx1, {
            type: 'bar',
            data: chartData1,
            options: {
              responsive: true,
              maintainAspectRatio: true,
              scales: {
                yAxes: [{
                  ticks: {
                    fontColor: "white",
                    beginAtZero:true,
                    // max: 100, 
                    // stepSize: 10, 
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
                        return ' ' + num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                      };

                      return format(value) + ' kWh';
                    }
                  },
                  gridLines: {
                    display:true, 
                    color: "#FFFFFF", 
                  }
                }],
                xAxes: [{
                  ticks: {
                    fontColor: "white",
                    callback: function(t) {
                      var maxLabelLength = 20;
                      if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                      else return t;
                    }, 
                    autoSkip: false,
                    maxRotation: 30,
                    // minRotation: 30
                  },
                  gridLines: {
                    display:true, 
                    color: "#FFFFFF", 
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
                  ctx.fillStyle = 'white';
                  ctx.textAlign = 'center';
                  ctx.textBaseline = 'bottom';

                  this.data.datasets.forEach(function(dataset, i) {
                    var meta = chartInstance.controller.getDatasetMeta(i);
                    meta.data.forEach(function(bar, index) {
                      var data = dataset.data[index];
                      // // var data = "";
                      // ctx.fillText(data, bar._model.x, bar._model.y - 5);

                      var intVal = function (i) {
                        return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                        i : 0;
                      };
                      value = intVal(data);

                      var format = function formatNumber(num) {
                        return ' ' + num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                      };

                      ctx.fillText(format(value), bar._model.x, bar._model.y - 5);
                    });
                  });
                }
              },
              title: {
                display: true,
                position: 'top', 
                text: 'TOTAL POWER CONSUMPTION',
                fontSize: 14,
                fontColor: 'white',
              },
              legend: {
                position: 'top', 
                "display": true,
                labels: {
                  // This more specific font property overrides the global property
                  fontColor: 'white',
                  //fontSize: 12,
                }
              },
              tooltips: {
                callbacks: {
                  title: function(t, d) {
                    return d.labels[t[0].index];
                  }
                }, 
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
                    return data.datasets[tooltipItem.datasetIndex].label + ": " + label + " kWh";
                  },
                },
              }
            }
          });

          var ctx2 = document.getElementById('canvas-2').getContext('2d');
          // window.myMixedChart2 = new Chart(ctx2, {
          //   type: 'bar',
          //   data: chartData2,
          //   options: {
          //     responsive: true,
          //     maintainAspectRatio: true,
          //     scales: {
          //       yAxes: [{
          //         ticks: {
          //           fontColor: "white",
          //           beginAtZero:true,
          //           max: 100, 
          //           // stepSize: 10, 
          //           callback: function(value, index, values) {
          //             // Remove the formatting to get integer data for summation
          //             var intVal = function (i) {
          //               return typeof i === 'string' ?
          //               i.replace(/[\$,]/g, '')*1 :
          //               typeof i === 'number' ?
          //               i : 0;
          //             };
          //             value = intVal(value);

          //             var format = function formatNumber(num) {
          //               return ' ' + num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
          //             };

          //             return format(value) + ' %';
          //           }
          //         },
          //         gridLines: {
          //           display:true, 
          //           color: "#FFFFFF", 
          //         }
          //       }],
          //       xAxes: [{
          //         ticks: {
          //           fontColor: "white",
          //           callback: function(t) {
          //             var maxLabelLength = 20;
          //             if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
          //             else return t;
          //           }, 
          //           autoSkip: false,
          //           maxRotation: 30,
          //           // minRotation: 30
          //         },
          //         gridLines: {
          //           display:true, 
          //           color: "#FFFFFF", 
          //         }   
          //       }]
          //     },
          //     "hover": {
          //       "animationDuration": 0
          //     },
          //     "animation": {
          //       // "duration": 1,
          //       "onComplete": function() {
          //         var chartInstance = this.chart,
          //         ctx = chartInstance.ctx;

          //         ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
          //         ctx.fillStyle = 'white';
          //         ctx.textAlign = 'center';
          //         ctx.textBaseline = 'bottom';

          //         this.data.datasets.forEach(function(dataset, i) {
          //           var meta = chartInstance.controller.getDatasetMeta(i);
          //           meta.data.forEach(function(bar, index) {
          //             var data = dataset.data[index];
          //             // // var data = "";
          //             // ctx.fillText(data, bar._model.x, bar._model.y - 5);

          //             var intVal = function (i) {
          //               return typeof i === 'string' ?
          //               i.replace(/[\$,]/g, '')*1 :
          //               typeof i === 'number' ?
          //               i : 0;
          //             };
          //             value = intVal(data);

          //             var format = function formatNumber(num) {
          //               return ' ' + num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
          //             };

          //             ctx.fillText(format(value), bar._model.x, bar._model.y - 5);
          //           });
          //         });
          //       }
          //     },
          //     title: {
          //       display: true,
          //       position: 'top', 
          //       text: 'TOTAL POWER (%)',
          //       fontSize: 14,
          //       fontColor: 'white',
          //     },
          //     legend: {
          //       position: 'top', 
          //       "display": true,
          //       labels: {
          //         // This more specific font property overrides the global property
          //         fontColor: 'white',
          //         //fontSize: 12,
          //       }
          //     },
          //     tooltips: {
          //       callbacks: {
          //         title: function(t, d) {
          //           return d.labels[t[0].index];
          //         }
          //       }, 
          //       mode: 'index',
          //       intersect: true, 
          //       callbacks: {
          //         title: function(tooltipItem, data) {
          //           return data['labels'][tooltipItem[0].index];
          //         },
          //         label: function(tooltipItem, data) {
          //           var label = tooltipItem.yLabel;
          //           // Remove the formatting to get integer data for summation
          //           var intVal = function (i) {
          //             return typeof i === 'string' ?
          //             i.replace(/[\$,]/g, '')*1 :
          //             typeof i === 'number' ?
          //             i : 0;
          //           };
          //           label = intVal(label);

          //           var format = function formatNumber(num) {
          //             return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
          //           };

          //           label = format(label);
          //           return data.datasets[tooltipItem.datasetIndex].label + ": " + label + " %";
          //         },
          //       },
          //     }
          //   }
          // });

          var myPieChart = new Chart(ctx2, {
            type: 'doughnut', //pie, doughnut
            data: chartData2,
            options: {
              responsive: true,
              title: {
                display: true,
                position: "top",
                text: "TOTAL POWER (%)",
                fontSize: 18,
                fontColor: "white"
              },
              legend: {
                display: true,
                position: "right",
                labels: {
                  fontColor: "white",
                  fontSize: 16
                }
              }, 
              tooltips: {
                callbacks: {
                  label: function(tooltipItem, data) {
                    var dataset = data.datasets[tooltipItem.datasetIndex];
                    var meta = dataset._meta[Object.keys(dataset._meta)[0]];
                    var total = meta.total;
                    var currentValue = dataset.data[tooltipItem.index];
                    var percentage = parseFloat((currentValue/total*100).toFixed(1));

                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    currentValue = intVal(currentValue);

                    var format = function formatNumber(num) {
                      return ' ' + num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(currentValue) + ' (' + percentage + '%)';
                  },
                  title: function(tooltipItem, data) {
                    return data.labels[tooltipItem[0].index];
                  }
                }
              }, 
              animation: {
                animateScale: true,
                animateRotate: true, 
                onComplete: function () {
                  var chartInstance = this.chart,
                  ctx = chartInstance.ctx;

                  // ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                  ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                  ctx.fillStyle = 'white';
                  ctx.textAlign = 'center';
                  ctx.textBaseline = 'bottom';

                  this.data.datasets.forEach(function (dataset) {

                    for (var i = 0; i < dataset.data.length; i++) {
                      var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
                      total = dataset._meta[Object.keys(dataset._meta)[0]].total,
                      mid_radius = model.innerRadius + (model.outerRadius - model.innerRadius)/2,
                      start_angle = model.startAngle,
                      end_angle = model.endAngle,
                      mid_angle = start_angle + (end_angle - start_angle)/2;

                      var x = mid_radius * Math.cos(mid_angle);
                      var y = mid_radius * Math.sin(mid_angle);

                      ctx.fillStyle = '#fff';
                      if (i == 3){ // Darker text color for lighter background
                        ctx.fillStyle = '#444';
                      }

                      var val = dataset.data[i];
                      var percent = String(Math.round(val/total*100)) + "%";

                      if(val != 0) {
                        // ctx.fillText(dataset.data[i], model.x + x, model.y + y);
                        // Display percent in another line, line break doesn't work for fillText
                        ctx.fillText(percent, model.x + x, model.y + y + 10);
                      }
                    }
                  });               
                }
              }
            }
          });
        };
      @endif

      //auto refresh
      setTimeout(function() {
        location.reload();
        {{-- // var mdb = "{{ $mdb }}"; --}}
        // var mdb_new = "1";
        // if(mdb == "1") {
        //   mdb_new = "2";
        // } else if(mdb == "2") {
        //   mdb_new = "3";
        // } else if(mdb == "3") {
        //   mdb_new = "4";
        // } else if(mdb == "4") {
        //   mdb_new = "1";
        // }
        {{-- // var urlRedirect = "{{ route('smartmtcs.dpm', 'param') }}"; --}}
        // urlRedirect = urlRedirect.replace('param', mdb_new);
        // window.location.href = urlRedirect;

      }, 1800000); //1000 = 1 second
    </script>
  </body>
</html>