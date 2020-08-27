@extends('layouts.app')
@section('content')
<style>
  .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
    border: 1px solid #000000;
  }
</style>
<style>
  @page { 
    size: A4; 
    margin-left: 1cm;
    margin-right: 1cm;
    margin-top: 3cm;
    margin-bottom: 0.5cm;
  }

  thead {display: table-header-group;}

  h1 {
    font-weight: bold;
    font-size: 20pt;
    text-align: center;
  }

  table {
    border-collapse: collapse;
    width: 100%;
    word-break:break-all; 
    word-wrap:break-word;
  }

  .table th {
    padding: 8px 8px;
    border:1px solid #000000;
    text-align: center;
  }

  .table td {
    padding: 2px 2px;
    border:1px solid #000000;
  }

  .text-center {
    text-align: center;
  }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <p align="left">PART INSPECTION STANDARD (PIS)</p>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><i class="fa fa-files-o"></i> Master</li>
      <li><a href="{{ route('pistandards.index') }}"><i class="fa fa-files-o"></i> PART INSPECTION STANDARD (PIS)</a></li>
      
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border" style="background-color: #FF6347">
              <h3 class="box-title">DETAIL PART INSPECTION STANDARD (PIS). NO.{{ $pistandards->no_pis }}</h3>
            </div>
            <div class="panel-body">
              <div class="box-body col-md-12"  style="padding:3px;overflow:auto;width:auto;height:200px;">
                <!-- /.Table Input-->
                <table class="table table-bordered table-responsive" width="100px" >
                    <body>
                        <tr>
                            <th colspan="2"  width="60px" height="5px"><p align="center"><img src="{{ $logo_supplier }}" alt="File Not Found" class="img-rounded img-responsive" height="5px" width="80px"></p></th>
                            <th colspan="3"  width="100px" height="5px"><font size="5px"><br>MODEL:&nbsp;&nbsp; {{ $pistandards->model }}</font> </th>
                            <th colspan="4"  width="100px" height="5px"> <font size="2px" ><br>DATE OF ISSUED:&nbsp; {{ $pistandards->date_issue }}<br>REFF NO:&nbsp;{{ $pistandards->reff_no }}  </font> </font> </th>
                        </tr>
                        <tr>
                          <td  colspan="3" height="35px"><font size="2px">SUPPLIER:<br>{{ $pistandards->nama_supplier }}</font></td>
                          <td  colspan="2" height="35px"><font size="2px">MATERIAL:<br>{{ $pistandards->material }}</font></td>
                          <td  colspan="2" height="35px">
                             <font size="2px">GENERAL TOL:<br>
                               @foreach(json_decode($pistandards->general_tol) as $key => $value)
                               {{$value}}<br>
                               @endforeach
                             </font>
                          </td>
                          <td colspan="2" height="35px"> <font size="2px">WEIGHT:<br>{{ $pistandards->weight }}</font></td>
                        </tr> 
                        <tr>
                           <td colspan="9" height="300px">
                             <br>
                             <center> 
                               <h3>
                                 <b>PART INSPECTION STANDARD</b>
                               </h3>
                               (FOR PURCHASED PART)
                             </center>
                              <br>
                              <table  cellspacing="0" cellpadding="5" height="80" >
                                  <center> 
                                      <font size="4px"> 
                                        <b>PART NO&nbsp;&nbsp;:</b>&nbsp;&nbsp;{{ $pistandards->part_no }}<br>
                                        <b> PART NAME&nbsp;&nbsp;:</b>&nbsp;&nbsp;{{ $pistandards->part_name }}<br>
                                        <b>DOC.NO&nbsp;&nbsp;:</b>&nbsp;&nbsp;{{ $pistandards->no_pis }}
                                      </font>
                                  </center>
                              </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="12">SKETCH DRAWING  WITH BALON<
                              <table  cellspacing="0" cellpadding="0" width="100%" >
                                <tr>
                                  <td colspan="12" height="350" >
                                    <center><img src="{{$sketchdrawing }}"  height="380" width="100%">
                                    </td>
                                  </tr>
                                </table>
                              </td>
                        </tr> 
                        <tr>
                            <td colspan="12">SKETCH SPECIAL MEASURING METHODE
                              <table  cellspacing="0" cellpadding="0" width="100%" >
                                <tr>
                                  <td colspan="12" height="350" >
                                    <center>
                                      <img src="{{$sketchmmethode }}"  height="380" width="100%">
                                    </center>
                                  </td>
                                </tr>
                              </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="12">SKETCH APPEARANCE / PRODUCTION CODE
                              <table  cellspacing="0" cellpadding="0" width="100%" >
                                <tr>
                                  <td colspan="12" height="350" >
                                    <center>
                                      <img src="{{$sketchappearance }}"  height="380" width="100%">
                                    </center>
                                  </td>
                                </tr>
                              </table>
                            </td>
                        </tr>
                        <tr> 
                           <th width="150px" colspan="9" style="">
                             <p align="left"><b>I. MATERIAL PERFORMANCE</b></p> 
                           </th>
                        </tr>
                        <tr> 
                            <th width="150px" colspan="9" style="">
                              <p align="left"><b>A. CHEMICAL COMPOSITION</b></p>
                            </th>
                        </tr>
                        <tr>
                            <th width="60px" rowspan="2" align="center"><br>NO</th>
                            <th align="center" rowspan="2" width="220px" ><br><p align="center">INSPECTION ITEM</p></th>
                            <th colspan="2"><p align="center">STANDARD VALUE</p></th>
                            <th rowspan="2" align="midle-center" width="200px"><br><p align="center">I.INSTRUMENT</p></th>
                            <th rowspan="2" width="80px"><p align="center"><br>RANK</p></th>
                            <th colspan="2"><p align="center">SAMPLING PLAN</p></th>
                            <th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
                        </tr>
                        <tr>
                            <th width="150px"><p align="center">NOMINAL</p></th>
                            <th width="150px"><p align="center">TOLERANCE</p></th>
                            <th width="200px"><p align="center">IN PROSES</p></th>
                            <th width="220px"><p align="center">AT DELIVERY</p></th>
                        </tr>
                          @if (!empty($composition->no_pisigp))
                            @foreach ($entity->getLines($composition->no_pisigp)->get() as $model)
                              <tr id="line_field1_{{ $loop->iteration }}">
                                <div class="box-body col-md-3">
                                  <div class="form-group"> 
                                    <td>{{ $model->no }}</td>
                                    <td>{{ $model->item }}</td>
                                    <td>{{ $model->nominal }}</td>
                                    <td>{{ $model->tolerance }}</td>
                                    <td>{{ $model->instrument }}</td>
                                    <td>{{ $model->rank }}</td>
                                    <td>{{ $model->proses }}</td>
                                    <td>{{ $model->delivery }} </td>
                                    <td>{{ $model->remarks }} </td>
                                  </div>
                                </div>      
                              </tr>
                            @endforeach
                          @endif
                        <tr>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                        </tr> 
                        <tr >
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                        </tr> 
                        <tr> 
                            <th width="150px" colspan="9" style="">
                              <p align="left"><b>B.MECHANICAL PROPERTIES</b></p>
                            </th>
                        </tr>
                        <tr>
                            <th width="60px" rowspan="2" align="center"><br>NO</th>
                            <th align="center" rowspan="2" width="220px" ><br><p align="center">INSPECTION ITEM</p></th>
                            <th colspan="2"><p align="center">STANDARD VALUE</p></th>
                            <th rowspan="2" align="midle-center" width="200px"><br><p align="center">I.INSTRUMENT</p></th>
                            <th rowspan="2" width="80px"><p align="center"><br>RANK</p></th>
                            <th colspan="2"><p align="center">SAMPLING PLAN</p></th>
                            <th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
                        </tr>
                        <tr>
                            <th width="150px"><p align="center">NOMINAL</p></th>
                            <th width="150px"><p align="center">TOLERANCE</p></th>
                            <th width="200px"><p align="center">IN PROSES</p></th>
                            <th width="220px"><p align="center">AT DELIVERY</p></th>
                        </tr>
                        @if (!empty($properties->no_pisigp))
                          @foreach ($entity->getLines1($properties->no_pisigp)->get() as $model)
                            <tr>
                               <td>{{ $model->no }}</td>
                               <td>{{ $model->item }}</td>
                               <td>{{ $model->nominal }}</td>
                               <td>{{ $model->tolerance }}</td>
                               <td>{{ $model->instrument }}</td>
                               <td>{{ $model->rank }}</td>
                               <td>{{ $model->proses }}</td>
                               <td>{{ $model->delivery }} </td>
                               <td>{{ $model->remarks }}
                               </td>
                            </tr>
                          @endforeach
                        @endif
                        <tr>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                        </tr> 
                        <tr>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                        </tr> 
                        <tr> 
                            <th width="150px" colspan="9" style="">
                              <p align="left"><b>C. WELDING PERFORMANCE (IF ANY)</b></p>
                            </th>
                        </tr>
                        <tr>
                            <th width="60px" rowspan="2" align="center"><br>NO</th>
                            <th align="center" rowspan="2" width="220px" ><br><p align="center">INSPECTION ITEM</p></th>
                            <th colspan="2"><p align="center">STANDARD VALUE</p></th>
                            <th rowspan="2" align="midle-center" width="200px"><br><p align="center">I.INSTRUMENT</p></th>
                            <th rowspan="2" width="80px"><p align="center"><br>RANK</p></th>
                            <th colspan="2"><p align="center">SAMPLING PLAN</p></th>
                            <th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
                        </tr>
                        <tr>
                          <th width="150px"><p align="center">NOMINAL</p></th>
                          <th width="150px"><p align="center">TOLERANCE</p></th>
                          <th width="200px"><p align="center">IN PROSES</p></th>
                          <th width="220px"><p align="center">AT DELIVERY</p></th>
                        </tr>
                        @if (!empty($performances->no_pisigp))
                          @foreach ($entity->getLines2($performances->no_pisigp)->get() as $model)
                            <tr>
                               <td>{{ $model->no }}</td>
                               <td>{{ $model->item }}</td>
                               <td>{{ $model->nominal }}</td>
                               <td>{{ $model->tolerance }}</td>
                               <td>{{ $model->instrument }}</td>
                               <td>{{ $model->rank }}</td>
                               <td>{{ $model->proses }}</td>
                               <td>{{ $model->delivery }} </td>
                               <td>{{ $model->remarks }}
                               </td>
                            </tr>
                          @endforeach
                        @endif
                        <tr>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                        </tr> 
                        <tr>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                        </tr> 
                        <tr> 
                            <th width="150px" colspan="9" style="">
                              <p align="left"><b>D. SURFACE TREATMENT (IF ANY)</b></p>
                            </th>
                        </tr>
                        <tr>
                            <th width="60px" rowspan="2" align="center"><br>NO</th>
                            <th align="center" rowspan="2" width="220px" ><br><p align="center">INSPECTION ITEM</p></th>
                            <th colspan="2"><p align="center">STANDARD VALUE</p></th>
                            <th rowspan="2" align="midle-center" width="200px"><br><p align="center">I.INSTRUMENT</p></th>
                            <th rowspan="2" width="80px"><p align="center"><br>RANK</p></th>
                            <th colspan="2"><p align="center">SAMPLING PLAN</p></th>
                            <th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
                        </tr>
                        <tr>
                            <th width="150px"><p align="center">NOMINAL</p></th>
                            <th width="150px"><p align="center">TOLERANCE</p></th>
                            <th width="200px"><p align="center">IN PROSES</p></th>
                            <th width="220px"><p align="center">AT DELIVERY</p></th>
                        </tr>
                        @if (!empty($treatements->no_pisigp))
                          @foreach ($entity->getLines3($treatements->no_pisigp)->get() as $model)
                            <tr>
                               <td>{{ $model->no }}</td>
                               <td>{{ $model->item }}</td>
                               <td>{{ $model->nominal }}</td>
                               <td>{{ $model->tolerance }}</td>
                               <td>{{ $model->instrument }}</td>
                               <td>{{ $model->rank }}</td>
                               <td>{{ $model->proses }}</td>
                               <td>{{ $model->delivery }} </td>
                               <td>{{ $model->remarks }}</td>
                            </tr>
                          @endforeach
                        @endif
                        <tr>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                        </tr> 
                        <tr>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                        </tr> 
                        <tr> 
                          <th width="150px" colspan="9" style="">
                            <p align="left"><b>E. HEAT TREATMENT (IF ANY)</b></p>
                          </th>
                        </tr>
                        <tr>
                          <th width="60px" rowspan="2" align="center"><br>NO</th>
                          <th align="center" rowspan="2" width="220px" ><br><p align="center">INSPECTION ITEM</p></th>
                          <th colspan="2"><p align="center">STANDARD VALUE</p></th>
                          <th rowspan="2" align="midle-center" width="200px"><br><p align="center">I.INSTRUMENT</p></th>
                          <th rowspan="2" width="80px"><p align="center"><br>RANK</p></th>
                          <th colspan="2"><p align="center">SAMPLING PLAN</p></th>
                          <th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
                        </tr>
                        <tr>
                          <th width="150px"><p align="center">NOMINAL</p></th>
                          <th width="150px"><p align="center">TOLERANCE</p></th>
                          <th width="200px"><p align="center">IN PROSES</p></th>
                          <th width="220px"><p align="center">AT DELIVERY</p></th>
                        </tr>
                        @if (!empty($htreatements->no_pisigp))
                          @foreach ($entity->getLines4($htreatements->no_pisigp)->get() as $model)  
                            <tr>
                               <td>{{ $model->no }}</td>
                               <td>{{ $model->item }}</td>
                               <td>{{ $model->nominal }}</td>
                               <td>{{ $model->tolerance }}</td>
                               <td>{{ $model->instrument }}</td>
                               <td>{{ $model->rank }}</td>
                               <td>{{ $model->proses }}</td>
                               <td>{{ $model->delivery }} </td>
                               <td>{{ $model->remarks }}</td>
                            </tr>
                          @endforeach
                        @endif
                        <tr>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                        </tr> 
                        <tr>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                        </tr> 
                        <tr> 
                          <th width="150px" colspan="9" style="">
                            <p align="left"><b>II. APPEARENCE</b></p>
                          </th>
                        </tr>
                        <tr>
                          <th width="60px" rowspan="2" align="center"><br>NO</th>
                          <th align="center" rowspan="2" width="220px" ><br><p align="center">INSPECTION ITEM</p></th>
                          <th colspan="2"><p align="center">STANDARD VALUE</p></th>
                          <th rowspan="2" align="midle-center" width="200px"><br><p align="center">I.INSTRUMENT</p></th>
                          <th rowspan="2" width="80px"><p align="center"><br>RANK</p></th>
                          <th colspan="2"><p align="center">SAMPLING PLAN</p></th>
                          <th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
                        </tr>
                        <tr>
                          <th width="150px"><p align="center">NOMINAL</p></th>
                          <th width="150px"><p align="center">TOLERANCE</p></th>
                          <th width="200px"><p align="center">IN PROSES</p></th>
                          <th width="220px"><p align="center">AT DELIVERY</p></th>
                        </tr>
                        @if (!empty($appearences->no_pisigp))
                          @foreach ($entity->getLines5($appearences->no_pisigp)->get() as $model)
                            <tr>
                               <td>{{ $model->no }}</td>
                               <td>{{ $model->item }}</td>
                               <td>{{ $model->nominal }}</td>
                               <td>{{ $model->tolerance }}</td>
                               <td>{{ $model->instrument }}</td>
                               <td>{{ $model->rank }}</td>
                               <td>{{ $model->proses }}</td>
                               <td>{{ $model->delivery }} </td>
                               <td>{{ $model->remarks }}</td>
                            </tr>
                          @endforeach
                        @endif
                        <tr>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                        </tr> 
                        <tr>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                        </tr> 
                        <tr> 
                          <th width="150px" colspan="9" style="">
                            <p align="left"><b>III. DIMENSION</b></p>
                          </th>
                        </tr>
                        <tr>
                          <th width="60px" rowspan="2" align="center"><br>NO</th>
                          <th align="center" rowspan="2" width="220px" ><br><p align="center">INSPECTION ITEM</p></th>
                          <th colspan="2"><p align="center">STANDARD VALUE</p></th>
                          <th rowspan="2" align="midle-center" width="200px"><br><p align="center">I.INSTRUMENT</p></th>
                          <th rowspan="2" width="80px"><p align="center"><br>RANK</p></th>
                          <th colspan="2"><p align="center">SAMPLING PLAN</p></th>
                          <th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
                        </tr>
                        <tr>
                          <th width="150px"><p align="center">NOMINAL</p></th>
                          <th width="150px"><p align="center">TOLERANCE</p></th>
                          <th width="200px"><p align="center">IN PROSES</p></th>
                          <th width="220px"><p align="center">AT DELIVERY</p></th>
                        </tr>
                        @if (!empty($dimentions->no_pisigp))
                          @foreach ($entity->getLines6($dimentions->no_pisigp)->get() as $model)
                            <tr>
                               <td>{{ $model->no }}</td>
                               <td>{{ $model->item }}</td>
                               <td>{{ $model->nominal }}</td>
                               <td>{{ $model->tolerance }}</td>
                               <td>{{ $model->instrument }}</td>
                               <td>{{ $model->rank }}</td>
                               <td>{{ $model->proses }}</td>
                               <td>{{ $model->delivery }} </td>
                               <td>{{ $model->remarks }}</td>
                           </tr>
                          @endforeach
                        @endif
                        <tr>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                          <td  height="35px"></td>
                        </tr> 
                        <tr>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                            <td  height="35px"></td>
                        </tr> 
                    </body>
                </table>
                <table class="table table-bordered" width="100px" >
                  <body>  
                      <tr> 
                        <th width="150px" colspan="9" style="">
                          <p align="left"><b>IV. SoC FREE</b></p>
                        </th>
                      </tr>
                      <tr>
                        <th height="100%" width="100px">NO.</th>
                        <th height="10%" width="300px" colspan="2"><center>INSPECTION ITEM</center></th>
                        <th height="10%" width="300px" colspan="2"><center>STANDARD VALUE</center></th>
                        <th height="10%" width="300px"><center>I.INSTRUMENT<center></th>
                        <th height="10%" width="300px"><center>RANK</center></th>
                        <th height="10%" width="300px"><center>SAMPLING PLAN</center></th>
                        <th height="10%" width="300px"><center>REMARKS</center></th>
                      </tr> 
                      @if (!empty($socfs->no_pisigp))   
                        @foreach ($entity->getLines7($socfs->no_pisigp)->get() as $model) 
                          <tr>
                             <td>{{ $model->no }}</td>
                             <td>{{ $model->item }}</td>
                             <td>{{ $model->instrument }}</td>
                             <td>{{ $model->rank }}</td>
                             <td>{{ $model->proses }}</td>
                             <td>{{ $model->delivery }} </td>
                             <td>{{ $model->remarks }}</td>
                          </tr>
                        @endforeach
                      @endif
                      <tr>
                        <td height="35px"></td>
                        <td height="35px" colspan="2"></td>
                        <td height="35px" colspan="2"></td>
                        <td height="35px"></td>
                        <td height="35px"></td>
                        <td height="35px"></td>
                        <td height="35px"></td>
                      </tr> 
                      <tr >
                          <td height="35px"></td>
                          <td height="35px" colspan="2"></td>
                          <td height="35px" colspan="2"></td>
                          <td height="35px"></td>
                          <td height="35px"></td>
                          <td height="35px"></td>
                          <td height="35px"></td>
                      </tr> 
                      <tr> 
                        <th width="150px" colspan="9" style="">
                          <p align="left"><b>REVISION COLUMN</b></p>
                        </th>
                      </tr>
                      <tr>
                        <th colspan="2" width="15%" height="10px"><p align="center">REV NO</p></th>
                        <th colspan="3" width="30%" height="10px"><p align="center">DATE</p></th>
                        <th colspan="2" width="30%" height="10px"><p align="center">REVISION RECORD</p></th>
                        <th colspan="2" width="30%" height="10px"><p align="center">PCR/ECI/ECRNO.</p></th>
                      </tr> 
                      @if (!empty($routs->no_pisigp))
                        @foreach ($entity->getLines9($routs->no_pisigp)->get() as $model)
                          <tr>
                            <td>{{ $model->rev_no}}</td>
                            <td>{{ $model->tanggal}}</td>
                            <td>{{ $model->rev_doc}}</td>
                            <td>{{ $model->ecrno}}</td>
                          </tr>
                        @endforeach
                      @endif
                      <tr>
                        <td colspan="2" height="35px"></td>
                        <td colspan="3" height="35px"></td>
                        <td colspan="2" height="35px"></td>
                        <td colspan="2" height="35px"></td>
                      </tr>
                      <tr>
                        <td colspan="2" height="35px"></td>
                        <td colspan="3" height="35px"></td>
                        <td colspan="2" height="35px"></td>
                        <td colspan="2" height="35px"></td>
                      </tr>                
                  </body>
                </table>
                <table class="table table-bordered" width="100px" >
                    <body> 
                        <tr>
                          <td colspan="3" ><center><font size="3px" ><b>PT. INTI GANDA PERDANA</b></font></center></td>
                          <td height="10px" width="20%" colspan="6" rowspan="3"></td>
                          <td colspan="3" ><center><font size="3px"> <b>{{ $pistandards->nama_supplier }}</b></font></center> </td>
                        </tr>
                        <tr>
                          <td width="10%" height="10%"><center><img src="{{$approve_dept }}"  width="60"></center></td>
                          <td width="10%" height="10%"><center><img src="{{$approve_sect }}"  width="60"></center></td>
                          <td width="10%" height="10%"><center><img src="{{$approve_staff }}"  width="60"></center></td>
                          <td width="10%" height="10%"><center><img src="{{$manager_spy}}"  width="60"></center></td>
                          <td width="10%" height="10%"><center><img src="{{$supervisor_spy }}"  width="60"></center></td>
                          <td width="10%" height="10%"><center><img src="{{$staff_spy}}"  width="60"></center></td>
                        </tr>
                        <tr>
                          <td width="10%"><center> <font size="2px"><b>Dept Head</b></font></center></td>
                          <td width="10%"><center><font size="2px"><b>Sect Head</b></font></center></td>
                          <td width="10%"><center><font size="2px"><b>Staff</b></font></center></td>
                          <td width="10%"><center><font size="2px"><b>Division</b></font></center></td>
                          <td width="10%"><center><font size="2px"><b>Manager</b></font></center></td>
                          <td width="10%"><center><font size="2px"><b>Staff</b></font></center></td>
                        </tr>
                    </body>
                </table>
                <table class="table table-bordered" width="100px" height="3%">
                  <body> 
                    <tr>
                      <td colspan="3" rowspan="2" height="2" width="20%">
                        <font size="3px">
                        <br>
                        <br>
                          <center>
                            @if($pistandards->status_doc == "")
                            @elseif($pistandards->status_doc !== "")
                            <img src="/images/ceklis.jpg" width="7%">
                            <b>{{$pistandards->status_doc}}</b>
                            @endif
                          </center>
                        </font>
                      </td>
                      <td colspan="2">
                        <br>
                        <font size="3px">
                          <center>
                            <b>PT.IGP</b>
                          </center>
                        </font>
                      </td>
                      <td colspan="7">
                      <br>
                        <center>QUALITY ASSURANCE DIVISION</center>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2"><font size="3px">
                        <br>
                        <center>
                          <b>SUPPLIER</b>
                        </center>
                      </td>
                      <td colspan="7">
                        <br>
                        <font size="3px">
                          <center>{{ $pistandards->supp_dept}}</center>
                        </font>
                      </td>
                    </tr>
                  </body>
                </table>
              </div>
            </div>
            <!-- /.box-body -->
            <!-- /.row -->
            <div class="box-footer">
              <a class="btn btn-primary" href="{{route('pisstaff.edit', [base64_encode($pistandards->no_pisigp),base64_encode($pistandards->norev)])}}" data-toggle="tooltip" data-placement="top" title="Next To Upload Electronic Sign/Note ">
                Next
              </a>
              &nbsp;&nbsp;
              &nbsp;&nbsp;
              <a class="btn btn-danger" href="{{ route('pisstaff.aprovalstaf') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Staff Approval" id="btn-cancel"> Back
              </a>
            </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('scripts')

</script>
@endsection