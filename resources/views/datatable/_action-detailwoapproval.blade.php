
<input type="hidden" id="nowo{{ $karyawan->nowo }}" name="nowo{{ $karyawan->nowo }}" value="{{ $karyawan->nowo }}">
<button class="btn btn-danger btn-sm" id="btn-tolak{{ $karyawan->nowo }}" onclick="TolakAtasan((this.id).substring(9))">Tolak</button>

<button type="submit" class="btn btn-info btn-sm" id="detail_{{ $karyawan->nowo }}" data-toggle="modal" data-target="#modalDetail_{{ $karyawan->nowo }}">Detail</button>

<input type="hidden" id="nowo{{ $karyawan->nowo }}" name="nowo{{ $karyawan->nowo }}" value="{{ $karyawan->nowo }}">
<input type="hidden" id="tglwo{{ $karyawan->nowo }}" name="tglwo{{ $karyawan->nowo }}" value="{{ $karyawan->tglwo }}">
<input type="hidden" id="ketwo{{ $karyawan->nowo }}" name="ketwo{{ $karyawan->nowo }}" value="{{ $karyawan->ketwo }}">
<input type="hidden" id="desc_dep{{ $karyawan->nowo }}" name="desc_dep{{ $karyawan->nowo }}" value="{{ $karyawan->desc_dep }}">
<input type="hidden" id="kd_pt{{ $karyawan->nowo }}" name="kd_pt{{ $karyawan->nowo }}" value="{{ $karyawan->kd_pt }}">
<button class="btn btn-success btn-sm" id="btn-setuju{{ $karyawan->nowo }}" onclick="SetujuAtasan((this.id).substring(10))">Setujui</button>
 

<!-- The Modal -->
<div class="modal fade" id="modalDetail_{{ $karyawan->nowo }}">
<div class="modal-dialog modal-lg">
    <div class="modal-content">

    <!-- Modal Header -->
    <div class="modal-header bg-red">
        <button type="button" class="btn btn-xs btn-default pull-right" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
        <h2 class="modal-title"><b>Detail Permintaan WO</b></h2>
    </div>
    <!-- Modal body -->
    <div class="modal-body">
        <table style="width:100%">
            <tr>
                <td style="text-align: right;font-weight:bold;width:40%">No WO</td>
                <td style="width:60%">{{ $karyawan->nowo }}</td>
            </tr>
            <tr>
                <td style="text-align: right;font-weight:bold;">Tgl Dibuat</td>
                <td> {{ date('d F Y  /  H:i A', strtotime($karyawan->tglwo)) }}</td>  
            </tr>
            <tr>
                <td style="text-align: right;font-weight:bold;">Nama Karyawan</td>
                <td>{{ $nama_karyawan }} / {{ $karyawan->npk }}</td>
            </tr>
            <tr>
                <td style="text-align: right;font-weight:bold;">Jenis Pengajuan</td>
                <td>{{ $karyawan->ketwo }}</td>
            </tr>
            <tr>
                <td style="text-align: right;font-weight:bold;">Penjelasan</td>
                <td>{{ $karyawan->penjelasan }}</td>
            </tr>
            <tr>
                <td style="text-align: right;font-weight:bold;">No Ext</td>
                @if($karyawan->ext == "")
                <td>Tidak Ada</td>
                @else
                <td>{{ $karyawan->ext }}</td>
                @endif
            </tr>
            <tr>
                <td style="text-align: right;font-weight:bold;">No Hp</td>
                @if($karyawan->hp == "")
                <td>Tidak Ada</td>
                @else
                <td>{{ $karyawan->hp }}</td>
                @endif
            </tr>
            <tr>
                <td style="text-align: right;font-weight:bold;">Status</td>
                <td><div class="btn btn-sm btn-warning"><i class="fa fa-clock-o"></i> Belum Diapprove Atasan</div></td>
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

