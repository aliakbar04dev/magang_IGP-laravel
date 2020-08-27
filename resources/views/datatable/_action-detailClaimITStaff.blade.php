<?php
    $hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
?>

<button type="button" class="btn btn-info btn-sm" id="detail_{{ $claim->no_claim }}" data-toggle="modal" data-target="#modalDetail_{{ $claim->no_claim }}"><i class="fa fa-info"></i>
</button>


   
 
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
                            <td><div class="btn btn-sm btn-danger"><b>Belum Direspon</b></div></td>
                            @elseif ($claim->status == "2")
                            <td><div class="btn btn-sm btn-warning"><b>Sudah Direspon</b></div></td>
                            @elseif ($claim->status == "3")
                            <td><div class="btn btn-sm btn-info"><b>Sedang Dikerjakan</b></div></td>
                            @elseif ($claim->status == "4")
                            <td><div class="btn btn-sm btn-success"><b>Selesai</b></div></td>
                            @elseif ($claim->status == "5")
                            <td><div class="btn btn-sm btn-secondary"><b>Approval User</b></div></td>
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
            <button type="button" class="btn btn-success" data-dismiss="modal">Respon</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

        </div>
    </div>
</div>
