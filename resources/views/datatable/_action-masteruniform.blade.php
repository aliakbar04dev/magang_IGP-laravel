<style>
    .modal-vertical-centered {
  transform: translate(0, 130%) !important;
  -ms-transform: translate(0, 130%) !important; /* IE 9 */
  -webkit-transform: translate(0, 130%) !important; /* Safari and Chrome */
}
</style>
<button href="#detail" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modalHapusMasterUniform_{{ $getMaster->kd_uni }}"><span class="glyphicon glyphicon-remove"></span> </button>  
<button href="#detail" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalDetail_{{ $getMaster->kd_uni }}"><div style="font-size:12px;font-weight:900">&nbsp; E &nbsp;</div> </button>

<div id="modalDetail_{{ $getMaster->kd_uni }}" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-md">   
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Masster Data</h4>
            </div>
            {!! Form::open(['url'=>route("mobiles.uniformappr_ga_master_edit"), 'method' =>'post'])!!}
            <div class="modal-body">
                <table class="table-borderless" style="width:100%">
                    <tr>
                        <td style="font-weight: bold">Jenis </td>
                        <td>{{ $getMaster->kode }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold">Kode </td>
                        <td><input class="form-control" type="hidden" name="kd_uni"  value="{{ $getMaster->kd_uni }}">{{ $getMaster->kd_uni }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold">PT </td>
                        <td>{{ $getMaster->pt }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold">Nama Uniform </td>
                        <td><input class="form-control" type="text" name="new_nama"  value="{{ $getMaster->nm_uni }}" style="width:100%" required></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold">Penjelasan </td>
                        <td><textarea class="form-control" type="text" name="new_desc" style="width:100%" required>{{ $getMaster->desc_uni }}</textarea></td>
                    </tr>
                </table>
            </div> 
            <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Ubah</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <!-- </form> -->
            </div>
            {!! Form::close() !!} 
        </div>       
    </div>
</div>

<div id="modalHapusMasterUniform_{{ $getMaster->kd_uni }}" class="modal fade" role="dialog" data-backdrop="static">
                <div class="modal-dialog modal-vertical-centered">   
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Konfirmasi</h4>
                        </div>
                        <div class="modal-body">
                            Hapus data master uniform dengan kode <strong>{{ $getMaster->kd_uni }}</strong>?
                        </div> 
                        <div class="modal-footer">
                                {!! Form::open(['url'=>route("mobiles.uniformappr_ga_master_delete"), 'method' =>'post', 'style' => 'display:inline;'])!!}
                                <input type="hidden" name="kd_uni" value="{{$getMaster->kd_uni}}">
                                <button class="btn btn-danger" type="submit">Hapus</button>
                                {!! Form::close() !!} 
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        </div>
                    </div>       
                </div>
            </div>