@if( $mobiles->statuscetak == 1 and $mobiles->status == 1 )
  <a href="#"  type="button" name="detail"  class="btn btn-sm btn-success btn_edit glyphicon glyphicon-ok disabled"  data-toggle="tooltip" data-placement="bottom" title="Setujui" ></a>
  <a  data-toggle="modal" data-target="#modalDetail_{{$mobiles->no_lp}}" type="button" name="detail"  class="btn btn-primary btn-sm glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="bottom" title="Lihat Detail" >  </a>
@elseif($mobiles->status == 2)
  <a onclick="konfirmasisetuju('{{$mobiles->no_lp}}')"   type="button" name="detail"  class="btn btn-sm btn-success btn_edit glyphicon glyphicon-ok" data-toggle="tooltip" data-placement="bottom" title="Setujui"   ></a>
  <a  data-toggle="modal" data-target="#modalDetail_{{$mobiles->no_lp}}" type="button" name="detail"  class="btn btn-primary btn-sm glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="bottom" title="Lihat Detail" >  </a>  
@elseif($mobiles->statuscetak == 0 and $mobiles->status == 1)
  <a  data-toggle="modal" data-target="#modalDetail_{{$mobiles->no_lp}}" type="button" name="detail"  class="btn btn-primary btn-sm glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="bottom" title="Lihat Detail" >  </a>
  <a onclick="konfirmasitolak('{{$mobiles->no_lp}}')"   type="button" name="detail" class="btn btn-sm btn-danger btn_hapus glyphicon glyphicon-remove" data-toggle="tooltip" data-placement="bottom" title="Tolak"   id="'.$LupaPPengajuans->no_lp.'"   ></a>
@else 
  <a onclick="konfirmasisetuju('{{$mobiles->no_lp}}')"   type="button" name="detail"  class="btn btn-sm btn-success btn_edit glyphicon glyphicon-ok"  data-toggle="tooltip" data-placement="bottom" title="Setujui" ></a>
  <a  data-toggle="modal" data-target="#modalDetail_{{$mobiles->no_lp}}" type="button" name="detail"  class="btn btn-primary btn-sm glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="bottom" title="Lihat Detail" >  </a>
  <a onclick="konfirmasitolak('{{$mobiles->no_lp}}')"   type="button" name="detail"  class="btn btn-sm btn-danger btn_hapus glyphicon glyphicon-remove"   data-toggle="tooltip" data-placement="bottom" title="Tolak" id="tolak"></a>
@endif


@section('detaillp')
<table class="table">
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
                         @endif
                              </tr> 
                      
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
        <h4 class="modal-title">Informasi Detail Approval</h4>
      </div>
      <div class="modal-body"> 
        @yield('detaillp')
      </div>
      <div class="modal-footer">
<!--                 @if ($mobiles->status==1 and $mobiles->statuscetak==0) 
                  <a onclick="konfirmasitolak('{{$mobiles->no_lp}}')"  type="button" name="detail"  class="btn btn-lg btn-danger btn_hapus glyphicon glyphicon-remove" >  Tolak </a>
                   <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Tutup</button> 
                @elseif ($mobiles->status==2) 
                  <a onclick="konfirmasisetuju('{{$mobiles->no_lp}}')"   type="button" name="detail"  class="btn btn-lg btn-success btn_edit glyphicon glyphicon-ok" > Setuju </a>
                  <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Tutup</button> 
                @elseif ($mobiles->status==3) 
                  <a onclick="konfirmasisetuju('{{$mobiles->no_lp}}')" type="button" name="detail"  class="btn btn-lg btn-success btn_edit glyphicon glyphicon-ok" > Setuju </a>
                  <a onclick="konfirmasitolak('{{$mobiles->no_lp}}')"  type="button" name="detail" class="btn btn-lg btn-danger btn_hapus glyphicon glyphicon-remove" >  Tolak </a> 
                @elseif ($mobiles->status==4) 
                  <a onclick="konfirmasisetuju('{{$mobiles->no_lp}}')" type="button" name="detail"  class="btn btn-lg btn-success btn_edit glyphicon glyphicon-ok" > Setuju </a>
                  <a onclick="konfirmasitolak('{{$mobiles->no_lp}}')"  type="button" name="detail" class="btn btn-lg btn-danger btn_hapus glyphicon glyphicon-remove" >  Tolak </a> 
                @else
                <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Tutup</button> 
                @endif  -->
       <button type="button" class="btn  btn-default" data-dismiss="modal">Tutup</button> 
      </div>
    </div>
  </div>
</div>

<script>
        $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip();
        });
        </script>
