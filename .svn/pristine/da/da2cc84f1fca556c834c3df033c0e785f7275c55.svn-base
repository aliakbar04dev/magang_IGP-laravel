<!-- <div class="dropdown" id="dropdown">
  <button class="btn btn-primary dropdown-toggle btn-sm" type="button" data-toggle="dropdown">
  <span class="glyphicon glyphicon-cog"></span> <span class="glyphicon glyphicon-chevron-down"></span></button>
  <ul class="dropdown-menu" style="left: -110;">
  {!! Form::open(['url'=>'/hr/mobile/uniform/approval/acc', 'method' =>'post'])!!}
  <input type="hidden" name="nouni" value="{{$getList->nouni}}">
  <li><button type="submit"><span class="glyphicon glyphicon-ok"></span></button></li>
  {!! Form::close() !!} 
  {!! Form::open(['url'=>'/hr/mobile/uniform/approval/dcln', 'method' =>'post'])!!}
  <input type="hidden" name="nouni" value="{{$getList->nouni}}">
  <li><button class="btn btn-xs btn-danger" type="submit"><span class="glyphicon glyphicon-remove"></span></button></li>
  {!! Form::close() !!} 
  <li class="divider"></li>
  <li><button href="#detail" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalDetail_{{$getList->nouni}}"><span class="glyphicon glyphicon-info-sign"></span></button></li>   
  </ul>
</div>  -->
<style>
    .modal-vertical-centered {
  transform: translate(0, 130%) !important;
  -ms-transform: translate(0, 130%) !important; /* IE 9 */
  -webkit-transform: translate(0, 130%) !important; /* Safari and Chrome */
}
</style>
<button id="remove{{ $getList->nouni }}" href="#detail" class="btn btn-danger btn-xs" onclick="declineApproval((this.id).substring(6))"><span class="glyphicon glyphicon-remove"></span> </button>  
<button href="#detail" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalDetail_{{$getList->nouni}}"><div style="font-size:12px;font-weight:900">&nbsp; i &nbsp;</div> </button>  
<button id="ok{{ $getList->nouni }}" href="#detail" class="btn btn-success btn-xs" onclick="accApproval((this.id).substring(2))"><span class="glyphicon glyphicon-ok"></span> </button>  
<input id="nouni{{ $getList->nouni }}" type="hidden" name="nouni{{ $getList->nouni }}" value="{{$getList->nouni}}">
<div id="modalDetail_{{ $getList->nouni }}" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">   
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detail Permintaan Uniform</h4>
            </div>
            <div class="modal-body">
                <!-- <form method="post" id="f_uniform"> -->
                    <table id="dt" class="table-borderless" style="width:100%;font-size:15px;">   
                        <tr>
                            <td style="text-align:right;width:50%;"><b>No. Permintaan : </b></td>
                            <td><b style="color:red">{{ $getList->nouni }}</b></td>
                        </tr>
                        <tr>
                            <td style="text-align:right;width:50%;"><b>Nama Karyawan : </b></td>
                            <td>{{ $getList->nama }} / {{ $getList->npk }}</td>
                        </tr>
                        <tr>
                            <td style="text-align:right;"><b>Nama Atasan : </b></td>
                            <td>{{ $getList->nama_atasan }}</td>
                        </tr>
                        <tr>
                            <td style="text-align:right;"><b>Tanggal Pengajuan :  </b></td>
                            <td>{{ $getList->tglsave }}</td>
                        </tr>
                        <!-- <tr>
                            <td style="text-align:right;"><b>Status Permintaan : </b></td>
                            <td>
                            </td>
                        </tr> -->
                        <tr>
                            <td colspan="2" style="text-align:right;">
                            </td>
                        </tr>
                    </table>
                    <p style="font-size:20px;float:left;"><b>List Uniform</b></p>
                    <table class="autonumber table-striped" style="width:100%">
                        <tr>
                            <th style="padding-left: 10px;width:1%">No.</th>
                            <th style="padding-left: 10px;width:60%">Item</th>
                            <th style="padding-left: 10px;width:20%">Tgl Terakhir</th>
                            <th style="padding-left: 10px;width:20%">Qty</th>
                        </tr>
                        @foreach($getDetailappr as $data)
                        <tr>
                            <td> {{ $loop->index+1 }}</td>
                            <td> {{ $data->desc_uni}} </td>
                            <td> {{ $data->tgl_lalu}} </td>
                            <td> {{ $data->qty}} </td>
                        </tr>
                        @endforeach
                    </table>
                    <br> 
                </div> 
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <!-- </form> -->
                </div>
            </div>       
        </div>
    </div>
