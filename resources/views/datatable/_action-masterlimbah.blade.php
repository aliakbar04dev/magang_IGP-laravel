<style>
    .modal-vertical-centered {
  transform: translate(0, 130%) !important;
  -ms-transform: translate(0, 130%) !important; /* IE 9 */
  -webkit-transform: translate(0, 130%) !important; /* Safari and Chrome */
}
</style>
<button class="btn btn-success btn-xs delete-row icon-trash glyphicon glyphicon-edit" data-toggle="modal" data-target="#modaleditlimbah_{{$limbah->kd_limbah}}" data-toggle="tooltip" data-placement="bottom" title="Edit"  > </button>  

<button class="btn btn-danger btn-xs delete-row icon-trash glyphicon glyphicon-trash" onclick="hapus_limbah('{{$limbah->kd_limbah}}')" data-toggle="tooltip" data-placement="bottom" title="Hapus"> </button>  



 <div id="modaleditlimbah_{{$limbah->kd_limbah}}" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">   
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Master Limbah B3</h4>
            </div>
             {!! Form::open(['url' => route('ehsspaccidents.update_masterlimbah'), 'method' => 'post', 'class'=>'form-horizontal', 'id'=>'form_master_update']) !!}
            <div class="modal-body">
                <!-- <form method="post" id="f_uniform"> -->
                    <table class="table-borderless" style="width:100%">
  
                             <tr>
                                <td style="font-weight: bold;padding: 15px 10px;">Kode Limbah </td>
                                <td><input class="form-control" type="text" name="kd_limbah" style="width:100%" value="{{$limbah->kd_limbah}}" required readonly="true"> </td>
                            </tr>    
                           
                            <tr>
                                <td style="font-weight: bold;padding: 15px 10px;">Jenis Limbah </td>
                                <td><input class="form-control" type="text" name="jenislimbah" style="width:100%" value="{{$limbah->jenislimbah}}" required> </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;padding: 32px 10px;">Deskripsi </td>
                                <td><textarea class="form-control" type="text" name="desc" style="width:100%" required> {{$limbah->desc}}</textarea></td>
                            </tr>
                            <tr>
                            <td style="font-weight: bold;padding: 15px 10px;">Kategori </td>
                                <td>
                                    <select class="form-control" style="width:150px;" name="kategori">
                                    @If ($limbah->kategori == 'Buang')
                                    <option value="Buang">Buang</option>
                                    <option value="Proses">Proses</option>
                                    @elseif ($limbah->kategori == 'Proses')
                                    <option value="Proses">Proses</option>
                                    <option value="Buang">Buang</option>
                                     @endif
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div> 
                    <div class="modal-footer">
                        <input type="submit" name="savemaster" id="savemaster" class="btn btn-info" value="Save" onclick="update_limbah('{{$limbah->kd_limbah}}')"/>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <!-- </form> -->
                    </div>
                    {!! Form::close() !!}   
                </div>       
            </div>
        </div>

