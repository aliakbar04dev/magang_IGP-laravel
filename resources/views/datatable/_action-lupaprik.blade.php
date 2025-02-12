<a  data-toggle="modal" data-target="#modalDetail_{{$mobiles->no_lp}}" type="button" name="detail"  class="btn btn-primary btn-sm glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="bottom" title="Lihat Detail" >  </a>

@if ($mobiles->status==3)
<button class="btn btn-danger btn-xs delete-row icon-trash glyphicon glyphicon-trash" onclick="hapus('{{$mobiles->no_lp}}')" data-toggle="tooltip" data-placement="bottom" title="Hapus"> </button>
@endif

@if ($mobiles->status==1)
<a href="{{ route('mobiles.printlupaprik', $mobiles->no_lp) }}" type=button class="btn btn-primary btn-sm  glyphicon glyphicon-print" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Print"></a>
@endif


@section('detaillp')
<table class="table">
<!-- <table class="table-borderless" style="width:100%;font-size:15px;">    -->
            <tbody>
                    <tr>
                       <th> NPK </th>
                       <td>:  {{$mobiles->npk}}</td>
                    </tr>
                    <tr>
                       <th> Nama Karyawan </th>
                       <td>:  {{$callkar->nama}}  </td>
                    </tr>
                    <tr>
                      <th> Nama PT </th>
                      <td>:  {{$callkar->kd_pt}}  </td>
                    </tr>
                    <tr>
                      <th> Nama Dept. </th>
                      <td>:  {{$callkar->desc_dep}}  </td>
                    </tr>
                  <tr>
                      <th> Nama Atasan </th>
                      <td>:  {{$tampilnamaatasan->nama}} </td>
                    </tr>
                    <tr>
                      <th>Status Pengajuan </th>
                      <td>  
                          @if ($mobiles->status==1) 
                          :  <b style="color:green" >  DISETUJUI </b>
                          @elseif ($mobiles->status==2) 
                          :  <b style="color:red"> DITOLAK </b> 
                          @elseif ($mobiles->status==3) 
                          :  <b style="color:orange"> BELUM APPROVAL </b>  
                          @else 
                          :  <b style="color:orange"> BELUM APPROVAL </b> 
                            <br> *Keterangan : <i> Pengajuan Banding<i> 
                          @endif 
                      </td>
                    </tr>
                    <tr>
                       <th> No. Pengajuan </th>
                       <td>:  <b> {{$mobiles->no_lp}} <b> </td>
                    </tr>                              
                    <tr>
                      <th> Tanggal Tidak Prik </th>
                      <td>:  {!! date('l, d F Y', strtotime($mobiles->tgllupa)); !!} </td>
                    </tr>
                         @if ($mobiles->jamin==null) 
                            <tr>
                                <th> Jam Keluar </th>
                                <td>:  {{$mobiles->jamout}} </td>
                            </tr>
                                            
                          @elseif ($mobiles->jamout==null) 
                              <tr>
                                  <th> Jam Masuk </th>
                                  <td>:  {{$mobiles->jamin}} </td>
                              </tr>

                          @else 
                              <tr>
                                  <th> Jam Masuk </th>
                                  <td>:  {{$mobiles->jamin}} </td>
                              </tr>

                              <tr>
                                  <th> Jam Keluar </th>
                                  <td>:  {{$mobiles->jamout}}   </td>        
                              </tr> 
                          @endif
                              <tr>
                                 <th> Alasan  </th>
                                 <td><textarea readonly="true"  style="width:100%; height:100%; border:none; resize:none;" rows="3">: {{$mobiles->alasanlupa}} </textarea></td>
                              </tr>
                </tbody>
            </table>
@endsection



 <!-- Modal Info Detail-->
 <div id="modalDetail_{{$mobiles->no_lp}}" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Informasi Detail</h4>
      </div>
      <div class="modal-body"> 
      @if ($mobiles->status==4)
      <div class="alert alert-warning">
      <strong>Perhatian!</strong>
      <ul>  
      <li>Silahkan hubungi atasan masing-masing untuk konfirmasi pengajuan</li>
      </div>
      @elseif ($mobiles->status==3)
      <div class="alert alert-warning">
      <strong>Perhatian!</strong>
      <ul>  
      <li>Silahkan hubungi atasan masing-masing untuk konfirmasi pengajuan</li>
      </div>        
      @endif
        @yield('detaillp')
      </div>
      <div class="modal-footer">
           @if ($mobiles->status==1)
                    <a href="{{ route('mobiles.printlupaprik', $mobiles->no_lp)}}" class="btn btn-primary glyphicon glyphicon-print">  Cetak</a>
                    <button type="button" class="btn  btn-default" data-dismiss="modal">Tutup</button>   
            @else
                     <!--  <a class="btn btn-primary glyphicon glyphicon-remove-sign" href="{{ route('mobiles.indexlupaprik') }}"> Batal </a> -->
                      <button type="button" class="btn  btn-default" data-dismiss="modal">Tutup</button>   
            @endif

        
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip();
  });
</script>
 





