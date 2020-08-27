
<a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalDetail_{{$riwayatik->no_ik}}">
  <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></a>
  @if($riwayatik->status =='2' or $riwayatik->status =='3')  
  {!! Form::open(['url'=>'/hronline/mobile/izinterlambat/cetak', 'method' =>'post', 'style' => 'display:inline;'])!!}
  <input type="hidden" name="no_ik" value="{{$riwayatik->no_ik}}">
  <button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-print"></span></button>   
  {!! Form::close() !!}
  @elseif ($riwayatik->status =='0')
  <button id="hapus_{{$riwayatik->no_ik}}" class="btn btn-danger btn-sm" type="button" onclick="hapus_pengajuan((this.id).substring(6))"><span class="glyphicon glyphicon-trash"></span></button>   
  @endif  

<!-- Yield untuk menampilkan detail IK (modal dan collapse)-->
@section('detailik')
<table class="table-borderless" style="width:100%;font-size:15px;">   
            <tr>
                <td style="text-align:right;width:40%;"><b>Nama / NPK : </b></td>
                <td>{{ $riwayatik->nama }} / {{ $riwayatik->npk }} </td>
            </tr>  
            <tr>
            <td style="text-align:right;width:40%;"><b>Nama Atasan : </b></td>
            <td>{{ $namaatasan }} </td>
            </tr>       
            <tr>
                <td style="text-align:right;" ><b>Bagian : <b></td>
                <td>{{ $riwayatik->desc_dep }} / {{ $riwayatik->desc_div }}</td>
            </tr>
            <tr>
                <td style="text-align:right;"><b>Status : </b></td>
                @if($riwayatik->status =='2')         
                <td><b style='color:green;'>IZIN DITERIMA</b></td>
                @elseif($riwayatik->status =='3')         
                <td><b style='color:green;'>IZIN DITERIMA <span class="glyphicon glyphicon-print" style="color:green" aria-hidden="true"></span>  
                </b></td>
                @elseif($riwayatik->status =='1')  
                <td><b style='color:red;'>IZIN DITOLAK</b></td> 
                @elseif($riwayatik->status =='0')  
                <td><b style='color:orange;'>MENUNGGU DIPROSES</b></td>      
                @endif
            </tr>
            <tr>
                <td style="text-align:right;"><b>No. IK : </b></td>
                <td>{{ $riwayatik->no_ik }}</td>
            </tr>
            <tr>
                <td style="text-align:right;"><b>Tanggal Izin : </b></td>
                <td>{{ $riwayatik->tglijin }}</td>
            </tr>
            <tr>
                <td style="text-align:right;"><b>Jam Masuk : </b></td>
                <td>{{ $riwayatik->jam_masuk }}</td>
            </tr>
            <tr>
                <td style="text-align:right;"><b>Alasan : </b></td>
                <td>{{ $riwayatik->alasan_it }}</td>
            </tr>
            </table>
@endsection



 <!-- Modal Info Detail-->
 <div id="modalDetail_{{$riwayatik->no_ik}}" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Informasi Detail</h4>
      </div>
      <div class="modal-body"> 
      @if($riwayatik->status =='0')     
      <div class="alert alert-warning">
      <strong>Perhatian!</strong>
      <ul>  
      <li>Silahkan hubungi atasan masing-masing untuk konfirmasi izin</li>
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

<!-- Modal Aju Banding-->
<div id="modalBanding_{{$riwayatik->no_ik}}" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Pengajuan Banding Ulang</h4>
      </div>
      <div class="modal-body"> 
      <div class="alert alert-warning">
      <strong>Perhatian!</strong>
      <ul>
      <li>Aju banding ulang hanya bisa dilakukan satu kali, tulislah alasan dan permohonan yang tepat</li>
      </div>
        @yield('detailik')
        <table class="table-borderless" style="width:100%;font-size:15px;">   
        <tr>
        <td style="text-align:right;width:40%;"><b>Alasan Banding :</b></td>
        <td><textarea id="new_alasan{{ $riwayatik->no_ik }}" name="new_alasan" class="form-control" placeholder="Tulis alasan yang tepat..."></textarea>
        </td>
        </tr>
        </table>
      </div>
      <div class="modal-footer">
      <input id="no_ik_banding{{$riwayatik->no_ik}}" type="hidden" name="no_ik" value="{{$riwayatik->no_ik}}">        
      <button id="{{$riwayatik->no_ik}}" type="button" class="btn btn-info" onclick="banding(this.id)">Submit</button>       
      <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>       
      </div>
    </div>
  </div>
</div>

<script>
        $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip();
        });
        </script>
 





