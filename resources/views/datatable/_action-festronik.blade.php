
@if ($limbah->status <= 3 )  
  <a  data-toggle="modal" data-target="#modalDetail_{{$limbah->tgl_angkut}}_{{$limbah->limbah}}_{{$limbah->pt}}" type="button" name="detail"  class="btn btn-primary btn-sm glyphicon glyphicon-check" data-toggle="tooltip" data-placement="bottom" title="Approval Festronik" >  </a>
@elseif ($limbah->status == 4 )
  <a  data-toggle="modal" data-target="#modalDetail_{{$limbah->tgl_angkut}}_{{$limbah->limbah}}_{{$limbah->pt}}" type="button" name="detail"  class="btn btn-primary btn-sm glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="bottom" title="Lihat Detail" >  </a>
@endif


@section('detaillp')
<table class="table">

            <tbody>
             <tr>
                       <th style="width:50%;"> Tanggal Pengangkutan </th>
                       <td style="width:50%;">:   {!! date('d F Y', strtotime($limbah->tgl_angkut)); !!}</td>
                    </tr>
                    <tr>
                       <th> Jenis Limbah </th>
                       <td>:  {{$limbah->jenislimbah}}</td>
                    </tr>
                     <tr>
                       <th> PT </th>
                       <td>
                        @if ($limbah->pt=='IGPJ') 
                          :  IGP-Jakarta
                        @elseif ($limbah->pt=='IGPK') 
                          :  IGP-Karawang
                        @elseif ($limbah->pt=='GKDJ') 
                          :  GKD-Jakarta
                        @elseif ($limbah->pt=='GKDK') 
                          :  GKD-Karawang
                        @elseif ($limbah->pt=='AGIJ') 
                          :  AGI-Jakarta
                        @elseif ($limbah->pt=='AGIK') 
                          :  AGI-Karawang
                        @endif
                       </td>
                    </tr>
                      <tr>
                       <th> Quality </th>
                       <td>:  {{$limbah->qty}} Ton</td>
                    </tr>
                     @if ($limbah->status == 3 )  
                            <tr>
                                <th> Status Transporter </th>
                                <td>:  <b style="color:green">OK </b> </td>
                            </tr>
                            <tr>
                                <th> Persetujuan Transporter</th>
                                <td>:  {!! date('d F Y', strtotime($limbah->tglok_transporter)); !!} / {{$limbah->approv_transporter}}-{{$approv_transporter}}
                                </td>
                            </tr>   
                            <tr>
                            <tr>
                                <th> No. Festronik</th>
                                <td>:  {{$limbah->no_festronik}}
                                </td>
                            </tr> 
                                <th> Status Penghasil </th>
                                <td>:  <b style="color:green">OK </b> </td>
                            </tr>
                            <tr>
                                <th> Persetujuan Penghasil</th>
                                <td>:  {!! date('d F Y', strtotime($limbah->tglok_penghasil)); !!} /  {{$limbah->approv_penghasil}}-{{$approv_penghasil}}
                                </td>
                            </tr>
                             <tr>
                                <th> Tanggal Approval Penerima </th>
                                <td>:  <input type="date" name="date_penerima_{{$limbah->no_angkut}}_{{$limbah->limbah}}_{{$limbah->pt}}" class="form-control" id="date_penerima_{{$limbah->no_angkut}}_{{$limbah->limbah}}_{{$limbah->pt}}" required="true"></input>


                                </td>
                            </tr>
    
                         @elseif ($limbah->status == 2 ) 
                           <tr>
                                <th> Status Transporter </th>
                                <td>:  <b style="color:green">OK </b> </td>
                            </tr>
                            <tr>
                                <th> Persetujuan Transporter</th>
                                <td>:  {!! date('d F Y', strtotime($limbah->tglok_transporter)); !!} / {{$limbah->approv_transporter}}-{{$approv_transporter}}
                                </td>
                            </tr> 
                            <tr>
                                <th> No. Festronik</th>
                                <td>:  {{$limbah->no_festronik}}
                                </td>
                            </tr>
                             <tr>
                                <th> Tanggal Approval Penghasil </th>
                                <td>:  <input type="date" name="date_penghasil_{{$limbah->no_angkut}}_{{$limbah->limbah}}_{{$limbah->pt}}" class="form-control" id="date_penghasil_{{$limbah->no_angkut}}_{{$limbah->limbah}}_{{$limbah->pt}}" required="true"></input>
                                </td>
                            </tr>

                           @elseif ($limbah->status == 4 )
                            <tr>
                                <th> Status Transporter </th>
                                <td>:  <b style="color:green">OK </b> </td>
                            </tr>
                            <tr>
                                <th> Persetujuan Transporter</th>
                                <td>:  {!! date('d F Y', strtotime($limbah->tglok_transporter)); !!} / {{$limbah->approv_transporter}}-{{$approv_transporter}}
                                </td>
                            </tr> 
                            <tr>
                                <th> No. Festronik</th>
                                <td>:  {{$limbah->no_festronik}}
                                </td>
                            </tr>  
                           <tr>
                                <th> Status Penghasil </th>
                                <td>:  <b style="color:green">OK </b> </td>
                            </tr>
                            <tr>
                                <th> Persetujuan Penghasil</th>
                                <td>:  {!! date('d F Y', strtotime($limbah->tglok_penghasil)); !!} / {{$limbah->approv_penghasil}}-{{$approv_penghasil}}
                                </td>
                            </tr>  
                              <tr>
                                <th> Status Penerima </th>
                                <td>:  <b style="color:green">OK </b> </td>
                            </tr>
                            <tr>
                                <th> Persetujuan Penerima</th>
                                <td>:  {!! date('d F Y', strtotime($limbah->tglok_penerima)); !!} / {{$limbah->approv_penerima}}-{{$approv_penerima}}
                                </td>
                            </tr>     
                            @elseif ($limbah->status == 1 )    
                            <tr>
                                <th> Status Festronik </th>
                                <td>:  <b style="color:red">NG </b> </td>
                            </tr>
                          
                             <tr>
                                <th> Tanggal Approval Transporter </th>
                                <td>:   <input type="date" name="date_transporter_{{$limbah->no_angkut}}_{{$limbah->limbah}}_{{$limbah->pt}}" class="form-control" id="date_transporter_{{$limbah->no_angkut}}_{{$limbah->limbah}}_{{$limbah->pt}}" required="true"></input>
                               </td>
                            </tr>
                            <tr>
                                <th> No. Festronik </th>
                                <td>:   
                                <input type="text" name="no_festronik_{{$limbah->no_angkut}}_{{$limbah->limbah}}_{{$limbah->pt}}" class="form-control" id="no_festronik_{{$limbah->no_angkut}}_{{$limbah->limbah}}_{{$limbah->pt}}" required="true"></input>
                              </td>
                            </tr>
                          
                      
                         @endif

                  
                </tbody>
            </table>          
@endsection



 <!-- Modal Info Detail-->
 <div id="modalDetail_{{$limbah->tgl_angkut}}_{{$limbah->limbah}}_{{$limbah->pt}}" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Informasi Detail Festronik</h4>
      </div>
      <div class="modal-body"> 
        @yield('detaillp')
      </div>
      <div class="modal-footer">
      @if ($limbah->status == 2 ) 
       <a  onclick="approv_penghasil('{{$limbah->no_angkut}}','{{$limbah->limbah}}','{{$limbah->pt}}')" type="button" name="detail"  class="btn  btn-success btn_edit" ><i class="fa fa-btn fa-check"> </i>  Approve Penghasil </a>
       @elseif ($limbah->status == 1 ) 
       <a  onclick="approv_transporter('{{$limbah->no_angkut}}','{{$limbah->limbah}}','{{$limbah->pt}}')" type="button" name="detail"  class="btn  btn-success btn_edit" ><i class="fa fa-btn fa-check"> </i>  Approve Transpoter </a>
       @elseif ($limbah->status == 3 ) 
      <a onclick="approv_penerima('{{$limbah->no_angkut}}','{{$limbah->limbah}}','{{$limbah->pt}}')"  type="button" name="detail"  class="btn  btn-success btn_edit" ><i class="fa fa-btn fa-check"> </i>  Approve Penerima </a>
      @endif

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
 





