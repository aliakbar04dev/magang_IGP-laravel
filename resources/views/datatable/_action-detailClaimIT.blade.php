<?php
    $hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
?>

<center><button type="button" class="btn btn-info btn-sm" id="detail_{{ $claim->no_claim }}" data-toggle="modal" data-target="#modalDetail_{{ $claim->no_claim }}"><i class="fa fa-info"></i>
</button>
<input type="hidden" id="no_claim{{ $claim->no_claim }}" name="no_claim{{ $claim->no_claim }}" value="{{ $claim->no_claim }}">
<button class="btn btn-danger btn-sm" id="btnHapus{{ $claim->no_claim }}" onclick="HapusClaim((this.id).substring(8))"><i class="fa fa-times"></i></button>
</center>

   
 
<div class="modal fade" id="modalDetail_{{ $claim->no_claim }}">
    <div class="modal-dialog">
        <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header bg-red">
            <button type="button" class="btn btn-sm btn-default pull-right" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            <h2 class="modal-title"><b>Detail Claim IT</b></h2>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
                <table id="tableInfoPkl" class="table table-striped">
                        <tr>
                            <td style="font-weight:bold;">No Claim IT</td>
                            <td style="width:70%">{{ $claim->no_claim }}</td> 
                        </tr>  
                        <tr>
                            <td style="font-weight:bold;">Tgl Claim</td>
                            <td>{{ $hari[date('w', strtotime($claim->tgl_claim))] }} ,
                                    {{ date('d/m/Y', strtotime($claim->tgl_claim))  }} </td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;">ID PC/Notebook/Lainnya</td>
                            <td style="width:70%">{{ $claim->id_hw }}</td> 
                        </tr>  
                        <tr>
                            <td style="font-weight:bold;">Deskripsi Claim</td>
                            <td style="width:70%">{{ $claim->ket_claim }}</td> 
                        </tr>  
                        <tr>
                            <td style="font-weight:bold;">Ext</td>
                            <td style="width:70%">{{ $claim->ext }}</td> 
                        </tr>  
                        <tr>
                            <td style="font-weight:bold;">No HP</td>
                            <td style="width:70%">{{ $claim->hp }}</td> 
                        </tr>  
                        <tr>
                            <td style="font-weight:bold;">Status</td>
                            @if($claim->status == "1")
                            <td><div style="color:red;"><b>BELUM DIRESPON</b></div></td>
                            @elseif ($claim->status == "2")
                            <td><div style="color:orange;"><b>SUDAH DIRESPON</b></div></td>
                            @elseif ($claim->status == "3")
                            <td><div style="color:Blue;"><b>SEDANG DIKERJAKAN</b></div></td>
                            @elseif ($claim->status == "4")
                            <td><div style="color:LimeGreen;"><b>SELESAI</b></div></td>
                            @elseif ($claim->status == "5")
                            <td><div style="color:DimGrey;"><b>APPROVAL USER</b></div></td>
                            @else
                            <td><div>  </div></td>
                            @endif
                        </tr>  
                        <tr>
                            <td style="font-weight:bold;">Staff IT</td>
                            <td style="width:70%"></td> 
                        </tr>  

                    </table>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

        </div>
    </div>
</div>
