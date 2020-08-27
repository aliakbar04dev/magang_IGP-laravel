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
          <th rowspan="2" style="width:10%;color: white;text-align: center;">
            <img src="{{ asset('images/logo_ori.png') }}" style="width: 100px;">
          </th>
          <th rowspan="2" style="width:75%;color: white;text-align: center;font-size:22px;">
            DASHBOARD CR REPORT
          </th>
          <th style="width:15%;color: white;text-align: center;">
            REPORT PERIOD: 
          </th>
        </tr>
        <tr>
          <th style="color: white;text-align: center;font-size:20px;">
            YTD {{ $nm_bulan }} {{ $nm_tahun }}
          </th>
        </tr>
      </thead>
    </table>
    <table cellspacing="0" style="width: 100%;height:100%;">
      <thead>
        <tr>
          <td style="width:30%;">
            <table cellspacing="0" style="width: 100%;height:100%;">
              <tr>
                <th style="border-color: white;border-top: 2px solid;border-bottom: 2px solid;border-left: 2px solid;border-right: 2px solid;text-align: center;color: white;">
                  <canvas id="canvas-total" style="height:40vh; width:20vw"></canvas>
                </th>
              </tr>
            </table>
          </td>
          <td style="width:70%">
            <table cellspacing="0" style="width: 100%;height:100%;">
              @for($i=1;$i<=$jml_divisi;$i++)
                @if($i == 1 || ($i % 4) == 1) 
                  <tr>
                @endif
                  @if($i <= 4)
                    <th style="border-color: white;border-top: 2px solid;border-bottom: 2px solid;border-left: 2px solid;border-right: 2px solid;text-align: center;color: white;width: 25%;">
                      <canvas id="canvas-{{ $i }}" style="height:17vh; width:10vw"></canvas>
                    </th>
                  @else
                    <th style="border-color: white;border-bottom: 2px solid;border-left: 2px solid;border-right: 2px solid;text-align: center;color: white;width: 25%;">
                      <canvas id="canvas-{{ $i }}" style="height:17vh; width:10vw"></canvas>
                    </th>
                  @endif
                @if($i % 4 == 0 || $i == $jml_divisi) 
                  </tr>
                @endif
              @endfor
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

      var chartDataTotal = {
        labels: ["ACTUAL: Rp. {{ numberFormatter(0, 2)->format($act) }} ({{ $persen_act }}%)", "PLAN: Rp. {{ numberFormatter(0, 2)->format($plan) }}"], 
        datasets: 
        [
          {
            backgroundColor: ["blue", "white"],
            borderWidth: [2, 2, 2, 2],
            borderAlign: 'center',
            borderColor: 'white', 
            data: ["{{ $persen_act }}", "{{ $persen_plan }}"]
          }
        ]
      };

      @for($i=1;$i<=$jml_divisi;$i++)
        var chartData{{ $i }} = {
          labels: ["ACTUAL: Rp. {{ numberFormatter(0, 2)->format($act_details[$i-1]) }} ({{ $persen_act_details[$i-1] }}%)", "PLAN: Rp. {{ numberFormatter(0, 2)->format($plan_details[$i-1]) }}"], 
          datasets: 
          [
            {
              backgroundColor: ["blue", "white"],
              borderWidth: [2, 2, 2, 2],
              borderAlign: 'center',
              borderColor: 'white', 
              data: ["{{ $persen_act_details[$i-1] }}", "{{ $persen_plan_details[$i-1] }}"]
            }
          ]
        };
      @endfor

      window.onload = function() {
        // Chart.Legend.prototype.afterFit = function() {
        //   this.height = this.height + 15;
        // };
        var ctxTotal = document.getElementById('canvas-total').getContext('2d');
        var myPieChartTotal = new Chart(ctxTotal, {
          type: 'doughnut', //pie, doughnut
          data: chartDataTotal,
          options: {
            responsive: true,
            title: {
              display: true,
              position: "top",
              text: "TOTAL",
              fontSize: 18,
              fontColor: "white"
            },
            legend: {
              display: true,
              position: "bottom",
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

                  if(data.labels[tooltipItem.index] == "PLAN: Rp. {{ numberFormatter(0, 2)->format($plan) }}") {
                    percentage = {{ $persen_plan }};
                    currentValue = {{ $plan }};
                    return format(currentValue) + ' (' + percentage + '%)';
                  } else {
                    percentage = {{ $persen_act }};
                    currentValue = {{ $act }};
                    return format(currentValue) + ' (' + percentage + '%)';
                  }
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

        @for($i=1;$i<=$jml_divisi;$i++)
          var ctx{{ $i }} = document.getElementById('canvas-{{ $i }}').getContext('2d');
          var title = "{{ $label_divs[$i-1] }}";
          title = title.replace(/&amp;/g, '&');

          var myPieChart{{ $i }} = new Chart(ctx{{ $i }}, {
            type: 'doughnut', //pie, doughnut
            data: chartData{{ $i }},
            options: {
              responsive: true,
              title: {
                display: true,
                position: "top",
                text: title,
                fontSize: 14,
                fontColor: "white"
              },
              legend: {
                display: true,
                position: "bottom",
                labels: {
                  fontColor: "white",
                  fontSize: 12
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

                    if(data.labels[tooltipItem.index] == "PLAN: Rp. {{ numberFormatter(0, 2)->format($plan_details[$i-1]) }}") {
                      percentage = {{ $persen_plan_details[$i-1] }};
                      currentValue = {{ $plan_details[$i-1] }};
                      return format(currentValue) + ' (' + percentage + '%)';
                    } else {
                      percentage = {{ $persen_act_details[$i-1] }};
                      currentValue = {{ $act_details[$i-1] }};
                      return format(currentValue) + ' (' + percentage + '%)';
                    }
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
        @endfor
      };

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