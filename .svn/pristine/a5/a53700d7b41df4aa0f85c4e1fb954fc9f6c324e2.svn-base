<style>
    .modal-vertical-centered {
  transform: translate(0, 130%) !important;
  -ms-transform: translate(0, 130%) !important; /* IE 9 */
  -webkit-transform: translate(0, 130%) !important; /* Safari and Chrome */
}
</style>
<button href="#detail" class="btn btn-default btn-md" data-toggle="modal" data-target="#modalDetail_{{$getList->nouni}}"><div style="font-size:12px;font-weight:900"><span class="glyphicon glyphicon-cog"></span></div> </button>  
<div id="modalDetail_{{ $getList->nouni }}" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">   
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detail Permintaan Uniform</h4>
            </div>
            {!! Form::open(['url'=>route("mobiles.uniformappr_ga_acc"), 'method' =>'post'])!!}
            <div class="modal-body">
            <input type="hidden" id="loopcount" name="loopcount" value="{{ count($getDetailappr) }}">
            <input type="hidden" id="nouni" name="nouni" value="{{ $getList->nouni }}">
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
                            <td>{{ $nama_atasan }}</td>
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
                            <th style="padding-left: 10px;width:20%">Qty Plan</th>
                            <th style="padding-left: 10px;width:20%">Qty Act</th>
                            <th>Confirm</th>

                        </tr>
                        @foreach($getDetailappr as $data)
                        <tr>
                            <td> {{ $loop->index+1 }}</td>
                            <td><input type="hidden" id="kd_uni_hidden_{{ $loop->index+1 }}" name="kd_uni_hidden[]" value="{{ $data->kd_uni }}"> {{ $data->desc_uni}} </td>
                            <td> {{ $data->qty}} </td>
                            <td>
                            <input type="tel" class="form-control" style="width:40px;" maxlength="2" id="qty_act_{{ $loop->index+1 }}" name="qty_act_raw"></td>
                            <td><input class="checkbox_confirm" type="checkbox" style="width: 30px; height: 30px;" id="{{ $loop->index+1 }}" name="ceklis_{{ $loop->index+1 }}" value="" required></div></td>
                        </tr>
                        @endforeach
                    </table>
                    <br> 
                </div> 
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Selesaikan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <!-- </form> -->
                </div>
                {!! Form::close() !!}

            </div>       
        </div>
    </div>

    <script>
    $(document).on('click', '.checkbox_confirm', function(){ 
        var checkbox_id = $(this).attr("id");
        var checkBox = document.getElementById(checkbox_id);
        var qty_box = document.getElementById('qty_act_'+checkbox_id);
        if (checkBox.checked == true){
            if (qty_box.value == '0' || qty_box.value == ''){
            $(qty_box).replaceWith('\
            <div id="textQty_'+checkbox_id+'">Kosong</div>\
            <input type="hidden" id="qty_act_'+checkbox_id+'" name="qty_act[]" value="0">\
            ');
        }else {
            $(qty_box).replaceWith('\
            <div id="textQty_'+checkbox_id+'">'+qty_box.value+'</div>\
            <input type="hidden" id="qty_act_'+checkbox_id+'" name="qty_act[]" value="'+qty_box.value+'">\
            ');
        }
        } else if(checkBox.checked == false) {
            $("#qty_act_"+checkbox_id).remove();
            $("#textQty_"+checkbox_id).replaceWith('\
            <input class="form-control" style="width:40px;" id="qty_act_'+checkbox_id+'" name="qty_act[]" value="0">\
            ');
      }
    })
    </script>