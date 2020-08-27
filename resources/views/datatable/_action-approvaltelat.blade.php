
  @if($listAppTelat->status =='0')  
  <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalApprove_{{$listAppTelat->no_ik}}"><span class="glyphicon glyphicon-ok"
  aria-hidden="true"></span></a>
  <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalDetail_{{$listAppTelat->no_ik}}">
  <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></a>
  <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTolak_{{$listAppTelat->no_ik}}"><span class="glyphicon glyphicon-remove" 
  aria-hidden="true"></span></a>
  @else
  <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalDetail_{{$listAppTelat->no_ik}}">
  <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></a>
  @endif


<!-- Yield untuk menampilkan detail IK (modal dan collapse)-->
@section('detailik')
<table class="table-borderless" style="width:100%;font-size:15px;">   
            <tr>
            <td colspan="2" style="text-align:center;font-size:20px;"><b>Info Detail</b></td>
            <tr>
                <td style="text-align:right;width:40%;"><b>Nama / NPK : </b></td>
                <td>{{ $listAppTelat->nama }} / {{ $listAppTelat->npk }} </td>
            </tr>         
            <tr>
                <td style="text-align:right;" ><b>Bagian : <b></td>
                <td>{{ $listAppTelat->desc_dep }} / {{ $listAppTelat->desc_div }}</td>
            </tr>
            <tr>
                <td style="text-align:right;"><b>Status : </b></td>
                @if($listAppTelat->status =='2')         
                <td><b style='color:green;'>IZIN DITERIMA</b></td>
                @elseif($listAppTelat->status =='3')         
                <td><b style='color:green;'>IZIN DITERIMA <span class="glyphicon glyphicon-print" style="color:green" aria-hidden="true"></span>  
                </b></td>
                @elseif($listAppTelat->status =='1')  
                <td><b style='color:red;'>IZIN DITOLAK</b></td> 
                @elseif($listAppTelat->status =='0')  
                <td><b style='color:orange;'>MENUNGGU DIPROSES</b></td>      
                @endif
            </tr>
            <tr>
                <td style="text-align:right;"><b>No. IK : </b></td>
                <td>{{ $listAppTelat->no_ik }}</td>
            </tr>
            <tr>
                <td style="text-align:right;"><b>Tanggal Izin : </b></td>
                <td>{{ $listAppTelat->tglijin }}</td>
            </tr>
            <tr>
                <td style="text-align:right;"><b>Jam Masuk : </b></td>
                <td>{{ $listAppTelat->jam_masuk }}</td>
            </tr>
            <tr>
                <td style="text-align:right;"><b>Alasan : </b></td>
                <td>{{ $listAppTelat->alasan_it }}</td>
            </tr>
            </table>
@endsection



 <!-- Modal Info Detail-->
 <div id="modalDetail_{{$listAppTelat->no_ik}}" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Informasi Detail</h4>
      </div>
      <div class="modal-body"> 
      @if($listAppTelat->status =='3')
      <div class="alert alert-info">
      Permohonan ini <strong>sudah dicetak</strong> oleh pemohon
      </div>
      @elseif($listAppTelat->status =='2')
      <div class="alert alert-warning">
      Permohonan ini <strong>belum dicetak</strong> oleh pemohon
      </div>
      @endif
      @yield('detailik')
      </div>
      <div class="modal-footer">
      
      <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>       
      </div>
    </div>

  </div>
</div>
 
  <!-- Modal Konfirmasi approve-->
<div id="modalApprove_{{$listAppTelat->no_ik}}" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi</h4>
      </div>
      <div class="modal-body">   
           Konfirmasi izin pengajuan terlambat oleh <b>{{ $listAppTelat->nama }}</b>?  
           <br><br>   
            @yield('detailik')
            <input id="no_ik_approve{{$listAppTelat->no_ik}}" type="hidden" name="no_ik" value="{{$listAppTelat->no_ik}}">        
      </div>
      <div class="modal-footer">
        <button id="apprv_{{$listAppTelat->no_ik}}" type="submit" class="btn btn-success" onclick="approve((this.id).substring(6))">Izinkan</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>       
      </div>
    </div>
  </div>
</div>

 <!-- Modal Konfirmasi tolak-->
 <div id="modalTolak_{{$listAppTelat->no_ik}}" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi</h4>
      </div>
      <div class="modal-body">
      Konfirmasi tolak pengajuan terlambat oleh <b>{{ $listAppTelat->nama }}</b>?
          <br><br>
            @yield('detailik')
            <input id="no_ik_decline{{$listAppTelat->no_ik}}" type="hidden" name="no_ik" value="{{$listAppTelat->no_ik}}">         
        </table>
      </div>
      <div class="modal-footer">
        <button id="dclne_{{$listAppTelat->no_ik}}" type="submit" class="btn btn-danger" onclick="decline((this.id).substring(6))">Tolak</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Ubah Hasil Keputusan-->
<div id="modalEdit_{{$listAppTelat->no_ik}}" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi (Ubah Keputusan)</h4>
      </div>
      <div class="modal-body">   
      <div class="alert alert-danger">
  <strong>Perhatian!</strong>
  <ul>
  <li>Ubah keputusan hanya bisa dilakukan <strong>satu kali</strong></li>
  <li>Setelah karyawan melakukan cetak, maka perubahan tidak bisa dilakukan</li>
</div>
           Konfirmasi mengubah keputusan approval izin terlambat oleh <b>{{ $listAppTelat->nama }}</b>?  
            @yield('detailik')
            @if($listAppTelat->status =='2')         
            <input id="no_ik_approve{{$listAppTelat->no_ik}}" type="hidden" name="no_ik" value="{{$listAppTelat->no_ik}}">        
            @elseif($listAppTelat->status =='1')  
            <input id="no_ik_decline{{$listAppTelat->no_ik}}" type="hidden" name="no_ik" value="{{$listAppTelat->no_ik}}">         
            @endif
      </div>
      <div class="modal-footer">
        @if($listAppTelat->status =='2')         
        <button id="dclne_{{$listAppTelat->no_ik}}" type="submit" class="btn btn-danger" onclick="decline((this.id).substring(6))">Ubah (TOLAK)</button>
        @elseif($listAppTelat->status =='1')  
        <button id="apprv_{{$listAppTelat->no_ik}}" type="submit" class="btn btn-success" onclick="approve((this.id).substring(6))">Ubah (IZINKAN)</button>
        @endif
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>       
      </div>
    </div>
  </div>
</div>








