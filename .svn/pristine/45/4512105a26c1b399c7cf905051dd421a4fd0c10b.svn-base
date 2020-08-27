<!DOCTYPE html>
<html>
  {{-- <head>
    @include ('layouts.head')  
  </head> --}}
  <body>
    <table width="95%" align="center" valign="top" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="70%" align="center" valign="top">
          <table style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;" cellspacing="0" cellpadding="0" width="100%">
            <thead>
              <tr>
                <td colspan="5">
                  <table width="100%" cellspacing="0" cellpadding="5">
                    <tr>
                      <td colspan="2" align="center" width="10%" style="border-bottom:1px solid black;"><IMG src="{{ asset('images/logo.png') }}"></td>
                      <td align="center" style="border-bottom:1px solid black;">
                        <table width="100%">
                          <tr>
                            <th align="center"><font size="3">SUPPLIER QUALITY PERFORMACE</font></th>
                          </tr>
                          <tr>
                            <th align="center"><font size="3">QPR STATUS</font></th>
                          </tr>
                          <tr>
                            <th align="center"><font size="1">PERIODE {{ strtoupper(namaBulan((int) $bulan)) }} {{ $tahun }}</font></th>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <th width="4%" align="left" style="padding-left: 5px;"><font size="2">SUPPLIER</font></th>
                <th width="1%" align="center" style="padding-left: 5px;"><font size="2">:</font></th>
                <th width="45%" align="left" style="padding-left: 5px;border-right:1px solid black;">
                  @if (!empty($baan_mbp->nm_bpid))
                    <font size="2">{{ $baan_mbp->nm_bpid }}</font>
                  @endif
                </th>
                <td width="10%" align="center" style="padding: 5px;border-bottom:1px solid black;border-right:1px solid black;">RESPONSE</td>
                <td width="10%" align="center" style="padding: 5px;border-bottom:1px solid black;">CLOSE</td>
              </tr>
              <tr>
                <th width="4%" align="left" style="padding-left: 5px;padding-top: 10px;"><font size="2">ATT.</font></th>
                <th width="1%" align="center" style="padding-left: 5px;padding-top: 10px;"><font size="2">:</font></th>
                <th width="45%" align="left" style="padding-left: 5px;padding-top: 10px;border-right:1px solid black;">
                  @if (!empty($baan_mbp->contact))
                    <font size="2">{{ $baan_mbp->contact }}</font>
                  @endif
                </th>
                <td width="10%" rowspan="2" align="center" style="border-right:1px solid black;">
                  @if (!empty($qprt_mutasi->prs_respone))
                    {{ $qprt_mutasi->prs_respone }}%
                  @endif
                </td>
                <td width="10%" rowspan="2" align="center">
                  @if (!empty($qprt_mutasi->prs_close))
                    {{ $qprt_mutasi->prs_close }}%
                  @endif
                </td>
              </tr>
              <tr>
                <th width="4%" align="left" style="padding-left: 5px;"><font size="2">PRODUCT</font></th>
                <th width="1%" align="center" style="padding-left: 5px;"><font size="2">:</font></th>
                <th width="45%" align="left" style="padding-left: 5px;border-right:1px solid black;"><font size="2">&nbsp;</font></th>
              </tr>
            </thead>
          </table>
        </td>
        <td width="30%" align="center" valign="top" style="border-bottom:1px solid black;border-right:1px solid black;">
          <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
              <th align="center" style="padding-bottom: 1px;border-top:1px solid black;border-bottom:1px solid black;border-right:1px solid black;">Approved</th>
              <th align="center" style="padding-bottom: 1px;border-top:1px solid black;border-bottom:1px solid black;border-right:1px solid black;">Checked</th>
              <th align="center" style="padding-bottom: 1px;border-top:1px solid black;border-bottom:1px solid black;">Prepared</th>
            </tr>
            <tr>
              <td align="center" style="padding: 21px;border-bottom:1px solid black;border-right:1px solid black;">&nbsp;</td>
              <td align="center" style="padding: 21px;border-bottom:1px solid black;border-right:1px solid black;">&nbsp;</td>
              <td align="center" style="padding: 21px;border-bottom:1px solid black;">&nbsp;</td>
            </tr>
            <tr>
              <td align="center" valign="center" style="padding-top: 10px;border-bottom:1px solid black;border-right:1px solid black;">&nbsp;</td>
              <td align="center" valign="center" style="padding-top: 10px;border-bottom:1px solid black;border-right:1px solid black;">&nbsp;</td>
              <td align="center" valign="center" style="padding-top: 10px;border-bottom:1px solid black;">&nbsp;</td>
            </tr>
            <tr>
              <td style="padding: 5px;" colspan="3">
                Date: 
                @if (!empty($qprt_mutasi->tgl_proses))
                  {{ \Carbon\Carbon::parse($qprt_mutasi->tgl_proses)->format('d F Y') }}
                @endif
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="2" align="center" valign="top" style="padding: 10px;border-bottom:1px solid black;border-left:1px solid black;border-right:1px solid black;">
          <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
              <td>
                <canvas id="canvas" width="1100" height="300" style="border:1px solid #000000;"></canvas>
              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td style="padding: 5px;border-top:1px solid black;border-bottom:1px solid black;border-left:1px solid black;border-right:1px solid black;">
                Requirements for CLOSE status : <br>
                <b>1</b>. Response OK &nbsp;&nbsp;<b>2</b>. Planning coorective action has implemented &nbsp;&nbsp;<b>3</b>. No reoccurence problem in five times successive delivery
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="2" align="center" valign="top" style="padding: 10px;border-bottom:1px solid black;border-left:1px solid black;border-right:1px solid black;">
          <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
              <td>
                <table id="tbl1" border="1" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th rowspan="2" style="text-align: center;">SUBJECT</th>
                      <th rowspan="2" style="text-align: center;width: 8%;" id="th-thnlalu">TAHUN-1</th>
                      <th colspan="12" style="text-align: center;" id="th-thn">TAHUN</th>
                      <th rowspan="2" style="text-align: center;width: 8%;">TOTAL</th>
                    </tr>
                    <tr>
                      <th style="text-align: center;width: 6%;">JAN</th>
                      <th style="text-align: center;width: 6%;">PEB</th>
                      <th style="text-align: center;width: 6%;">MAR</th>
                      <th style="text-align: center;width: 6%;">APR</th>
                      <th style="text-align: center;width: 6%;">MAY</th>
                      <th style="text-align: center;width: 6%;">JUN</th>
                      <th style="text-align: center;width: 6%;">JUL</th>
                      <th style="text-align: center;width: 6%;">AUG</th>
                      <th style="text-align: center;width: 6%;">SEPT</th>
                      <th style="text-align: center;width: 6%;">OCT</th>
                      <th style="text-align: center;width: 6%;">NOV</th>
                      <th style="text-align: center;width: 6%;">DEC</th>
                    </tr>
                  </thead>
                  @if (!empty($claim_rekaps1))
                    <tbody>
                      @foreach ($claim_rekaps1 as $key => $value)
                        <tr>
                          <td>{{ $value['subject'] }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['tahun_lalu']) }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['jan']) }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['feb']) }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['mar']) }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['apr']) }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['mei']) }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['jun']) }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['jul']) }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['aug']) }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['sept']) }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['oct']) }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['nov']) }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['des']) }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['total']) }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  @endif
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="2" align="center" valign="top" style="padding: 10px;border-bottom:1px solid black;border-left:1px solid black;border-right:1px solid black;">
          <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
              <td>
                <canvas id="canvas-2" width="1100" height="300" style="border:1px solid #000000;"></canvas>
              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td style="padding: 5px;border-top:1px solid black;border-bottom:1px solid black;border-left:1px solid black;border-right:1px solid black;">
                Requirements for CLOSE status : <br>
                <b>1</b>. Response OK &nbsp;&nbsp;<b>2</b>. Planning coorective action has implemented &nbsp;&nbsp;<b>3</b>. No reoccurence problem in five times successive delivery
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="2" align="center" valign="top" style="padding: 10px;border-bottom:1px solid black;border-left:1px solid black;border-right:1px solid black;">
          <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
              <td>
                <table id="tbl2" border="1" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th rowspan="2" style="text-align: center;">SUBJECT</th>
                      <th rowspan="2" style="text-align: center;width: 8%;" id="th-thnlalu-2">TAHUN-1</th>
                      <th colspan="12" style="text-align: center;" id="th-thn-2">TAHUN</th>
                      <th rowspan="2" style="text-align: center;width: 8%;">TOTAL</th>
                    </tr>
                    <tr>
                      <th style="text-align: center;width: 6%;">JAN</th>
                      <th style="text-align: center;width: 6%;">PEB</th>
                      <th style="text-align: center;width: 6%;">MAR</th>
                      <th style="text-align: center;width: 6%;">APR</th>
                      <th style="text-align: center;width: 6%;">MAY</th>
                      <th style="text-align: center;width: 6%;">JUN</th>
                      <th style="text-align: center;width: 6%;">JUL</th>
                      <th style="text-align: center;width: 6%;">AUG</th>
                      <th style="text-align: center;width: 6%;">SEPT</th>
                      <th style="text-align: center;width: 6%;">OCT</th>
                      <th style="text-align: center;width: 6%;">NOV</th>
                      <th style="text-align: center;width: 6%;">DEC</th>
                    </tr>
                  </thead>
                  @if (!empty($claim_rekaps2))
                    <tbody>
                      @foreach ($claim_rekaps2 as $key => $value)
                        <tr>
                          <td>{{ $value['subject'] }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['tahun_lalu']) }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['jan']) }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['feb']) }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['mar']) }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['apr']) }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['mei']) }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['jun']) }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['jul']) }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['aug']) }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['sept']) }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['oct']) }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['nov']) }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['des']) }}</td>
                          <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['total']) }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  @endif
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="center" valign="top" style="border-top:1px solid black;border-bottom:1px solid black;border-left:1px solid black;border-right:1px solid black;">
          <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
              <td>
                <table id="tbl3" border="0" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th style="text-align: center;width: 1%;border-bottom:1px solid black;border-right:1px solid black;">NO</th>
                      <th style="text-align: center;width: 13%;border-bottom:1px solid black;border-right:1px solid black;">QPR</th>
                      <th style="text-align: center;width: 10%;border-bottom:1px solid black;border-right:1px solid black;">PART NO</th>
                      <th style="text-align: center;width: 15%;border-bottom:1px solid black;border-right:1px solid black;">PART NAME</th>
                      <th style="text-align: center;width: 5%;border-bottom:1px solid black;border-right:1px solid black;">QTY</th>
                      <th style="text-align: center;border-bottom:1px solid black;border-right:1px solid black;">PROBLEM</th>
                      <th style="text-align: center;width: 5%;border-bottom:1px solid black;border-right:1px solid black;">RESPONSE</th>
                      <th style="text-align: center;width: 5%;border-bottom:1px solid black;border-right:1px solid black;">STATUS</th>
                      <th style="text-align: center;width: 10%;border-bottom:1px solid black;border-right:1px solid black;">MODEL</th>
                    </tr>
                  </thead>
                  @if (!empty($mutasi2))
                    <tbody>
                      @foreach ($mutasi2->get() as $model)
                        <tr>
                          <td style="text-align: center;border-right:1px solid black;">{{ numberFormatter(0, 0)->format($loop->iteration) }}</td>
                          <td style="text-align: center;border-right:1px solid black;">{{ $model->no_qpr }}</td>
                          <td style="text-align: left;border-right:1px solid black;">{{ $model->part_no }}</td>
                          <td style="text-align: left;border-right:1px solid black;">{{ $model->part_name }}</td>
                          <td style="text-align: right;border-right:1px solid black;">{{ numberFormatter(0, 1)->format($model->qty) }}</td>
                          <td style="text-align: left;border-right:1px solid black;">{{ $model->problem }}</td>
                          <td style="text-align: center;border-right:1px solid black;">{{ $model->st_respon }}</td>
                          <td style="text-align: center;border-right:1px solid black;">{{ $model->st_close }}</td>
                          <td style="text-align: left;border-right:1px solid black;">{{ $model->kd_model }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  @endif
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <script src="{{ asset('chartjs/Chart.bundle.js') }}"></script>
    <script src="{{ asset('chartjs/utils.js') }}"></script>
    <script>
      document.getElementById("th-thnlalu").innerHTML = '{{ $tahun }}' - 1;
      document.getElementById("th-thn").innerHTML = '{{ $tahun }}';
      document.getElementById("th-thnlalu-2").innerHTML = '{{ $tahun }}' - 1;
      document.getElementById("th-thn-2").innerHTML = '{{ $tahun }}';

      var chartData = {
        labels: ["JAN", "PEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEPT", "OCT", "NOV", "DEC"],
        datasets: [{
          type: 'bar',
          label: 'PPM',
          backgroundColor: window.chartColors.red,
          data: {!! json_encode($nilai) !!},
          borderColor: 'white',
          borderWidth: 2
        }, {
          type: 'line',
          label: 'TARGET',
          borderColor: window.chartColors.blue,
          borderWidth: 2,
          fill: false, //[false, 'origin', 'start', 'end']
          data: {!! json_encode($target) !!}
        }]
      };

      var chartData2 = {
        labels: ["JAN", "PEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEPT", "OCT", "NOV", "DEC"],
        datasets: [{
          type: 'bar',
          label: 'RESPONSE',
          backgroundColor: window.chartColors.gray,
          data: {!! json_encode($prs_respone) !!},
          borderColor: 'black',
          borderWidth: 2
        }, {
          type: 'line',
          label: 'CLOSE',
          borderColor: window.chartColors.red,
          borderWidth: 2,
          fill: false, //[false, 'origin', 'start', 'end']
          data: {!! json_encode($prs_close) !!}
        }, {
          type: 'line',
          label: 'TARGET',
          borderColor: window.chartColors.green,
          borderWidth: 2,
          fill: false, //[false, 'origin', 'start', 'end']
          data: {!! json_encode($prs_target) !!}
        }]
      };

      window.onload = function() {
        Chart.Legend.prototype.afterFit = function() {
          this.height = this.height + 15;
        };
        
        var ctx = document.getElementById('canvas').getContext('2d');
        window.myMixedChart = new Chart(ctx, {
          type: 'bar',
          data: chartData,
          options: {
            responsive: true,
            maintainAspectratio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  stepSize: 20
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

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultfontSize, Chart.defaults.global.defaultfontStyle, Chart.defaults.global.defaultfontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                  var data = dataset.data[index];
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'CLAIM RATIO',
              fontSize: 14,
            },
            legend: {
              position: 'right', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              mode: 'index',
              intersect: true
            }
          }
        });

        ctx = document.getElementById('canvas-2').getContext('2d');
        window.myMixedChart2 = new Chart(ctx, {
          type: 'bar',
          data: chartData2,
          options: {
            responsive: true,
            maintainAspectratio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  max: 120, 
                  stepSize: 20
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

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultfontSize, Chart.defaults.global.defaultfontStyle, Chart.defaults.global.defaultfontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                  var data = dataset.data[index];
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'QPR STATUS',
              fontSize: 14,
            },
            legend: {
              position: 'right', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              mode: 'index',
              intersect: true
            }
          }
        });
      };
    </script>
  </body>
</html>