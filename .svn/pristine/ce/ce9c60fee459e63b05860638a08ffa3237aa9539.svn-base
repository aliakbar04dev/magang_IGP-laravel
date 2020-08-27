@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  
  <section class="content-header">
      <h1>
        Detail Pengajuan Lupa Prik
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="glyphicon glyphicon-info-sign"></i> Lupa Prik</li>
        <li><a href="{{ route('mobiles.indexlupaprik') }}"><i class="fa fa-files-o"></i> Daftar Pengajuan </a></li>
      <li class="active">Detail Lupa Prik</li>
      </ol>
  </section>
  
    <!-- Main content -->
  <section class="content">
     @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Detail Pengajuan Lupa Prik</h3>
        </div>
        <!-- /.box-header -->   
        <!-- form start -->
      <div class="box-body">
        <div class="form-group">
          <div class="table-responsive">
            <form method="POST" accept-charset="UTF-8" style="display:inline">
              {{ csrf_field() }}
                <table class="table">
                  <tbody>
                    <tr>
                       <th> NPK </th>
                       <td>:  {{$LupaPPengajuans->npk}}</td>
                    </tr>
                    <tr>
                       <th> Nama Karyawan </th>
                       <td>:  {{$kar->first()->nama}}  </td>
                    </tr>
                    <tr>
                      <th> Nama PT </th>
                      <td>:  {{$kar->first()->kd_pt}}  </td>
                    </tr>
                    <tr>
                      <th> Nama Dept. </th>
                      <td>:  {{$kar->first()->desc_dep}}  </td>
                    </tr>
                    <tr>
                      <th> Nama Atasan </th>
                      <td>:  {{$namaatasan->first()->nama}} </td>
                    </tr>
                    <tr>
                      <th> Status Pengajuan </th>
                      <td>  
                          @if ($LupaPPengajuans->status==1) 
                            <b class="btn-xs btn-success btn-icon-pg" >  Disetujui </b>
                          @elseif ($LupaPPengajuans->status==2) 
                            <b class="btn-xs btn-danger btn-icon-pg"  > Ditolak  </b> 
                          @elseif ($LupaPPengajuans->status==3) 
                            <b class="btn-xs btn-info btn-icon-pg" action="disable"> Belum Approval </b>  
                          @else 
                            <b class="btn-xs btn-info btn-icon-pg" action="disable"> Belum Approval </b> 
                            <br> *Keterangan : <i> Pengajuan Ulang <i> 
                          @endif 
                      </td>
                    </tr>
                    <tr>
                       <th> No. Pengajuan </th>
                       <td>:  <b> {{$LupaPPengajuans->no_lp}} <b> </td>
                    </tr>                              
                    <tr>
                      <th> Tanggal Lupa </th>
                      <td>:  {!! date('l, d F Y', strtotime($LupaPPengajuans->tgllupa)); !!} </td>
                    </tr>
                         @if ($LupaPPengajuans->jamin==null) 
                            <tr>
                                <th> Jam Keluar </th>
                                <td>:  {{$LupaPPengajuans->jamout}} </td>
                            </tr>
                                            
                          @elseif ($LupaPPengajuans->jamout==null) 
                              <tr>
                                  <th> Jam Masuk </th>
                                  <td>:  {{$LupaPPengajuans->jamin}} </td>
                              </tr>

                          @else 
                              <tr>
                                  <th> Jam Masuk </th>
                                  <td>:  {{$LupaPPengajuans->jamin}} </td>
                              </tr>

                              <tr>
                                  <th> Jam Keluar </th>
                                  <td>:  {{$LupaPPengajuans->jamout}}   </td>        
                           @endif
                              </tr> 
                      
                              <tr>
                                 <th> Alasan Lupa </th>
                                 <td>:  {{$LupaPPengajuans->alasanlupa}}</td>
                              </tr>
                </tbody>
              </table>
          <div class="modal-footer">
                  @if ($LupaPPengajuans->status==1)
                    <a href="/hr/mobile/lupaprik/{{$LupaPPengajuans->no_lp}}/print" class="btn btn-primary glyphicon glyphicon-print">  Cetak</a>
                    <a class="btn btn-primary glyphicon glyphicon-remove-sign" href="{{ route('mobiles.indexlupaprik') }}">  Batal </a>
                  @elseif ($LupaPPengajuans->status==2)
                    <a onclick="ajukanbanding('{{$LupaPPengajuans->no_lp}}')" class="btn btn-primary glyphicon glyphicon-modal-window" >  Ajukan Banding</a>
                    <a class="btn btn-primary glyphicon glyphicon-remove-sign" href="{{ route('mobiles.indexlupaprik') }}">  Batal </a>
                  @else
                      <a class="btn btn-primary glyphicon glyphicon-remove-sign" href="{{ route('mobiles.indexlupaprik') }}"> Batal </a>
                  @endif
          </div>                                          
        </form>
      </div>
    </div>
  </div>
 </div>
  <!-- /.box -->
</section>
    <!-- /.content -->
</div>
  <!-- /.content-wrapper -->
@endsection


@section('scripts')
<script type="text/javascript">

function ajukanbanding(id)
     {
      var msg = 'Anda yakin mengajukan banding dengan nomer pengajuan '+id+'?';
      var txt = '';
      //additional input validations can be done hear
      swal({
        title: msg,
        text: txt,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: 'grey',
        confirmButtonText: '<i class="fa fa-check-circle" ></i> Yes',
        cancelButtonText: '<i  class="fa fa-times" ></i> No',
        allowOutsideClick: true,
        allowEscapeKey: true,
        allowEnterKey: true,
        reverseButtons: false,
        focusCancel: true,
      }).then(function () {
       var urlRedirect = "/hr/mobile/lupaprik/"+id+"/pk/";
       window.location.href = urlRedirect;
       //window.open(urlRedirect);
        swal({
              position: 'top-end',
              type: 'success',
              title: 'Berhasil Mengajukan Banding! ',
              showConfirmButton: false,
              timer: 2000
            })
        table.ajax.reload();
      }, function (dismiss) {
     
        if (dismiss === 'cancel') {
         
        }
      })
    }
</script>


                                    </tr>
                                    <tr>
                                        <th> No. Pengajuan </th>
                                       	 <td> <b> {{$LupaPPengajuans->no_lp}} <b> </td>
                                    </tr>
                                    
                                    <tr>
	                                    <th> Tanggal Lupa </th>
	                                    <td> {!! date('l, d F Y', strtotime($LupaPPengajuans->tgllupa)); !!} </td>
                                   </tr>

                                   <tr>
	                                    <th> Jam Masuk </th>
	                                    <td> {{$LupaPPengajuans->jamin}} </td>
                                   </tr>

                                   <tr>
	                                    <th> Jam Keluar </th>
	                                    <td> {{$LupaPPengajuans->jamout}} </td>
                                   </tr>

                                   <tr>
	                                    <th> Alasan Lupa </th>
	                                    <td> {{$LupaPPengajuans->alasanlupa}}</td>
                                   </tr>
                                </tbody>
                            </table>
					<div class="modal-footer">
					@if ($LupaPPengajuans->status==1)
						<a href="/hronline/mobile/lupaprik/{{$LupaPPengajuans->no_lp}}/print"" class="btn btn-primary glyphicon glyphicon-print" target="_blank">  Cetak</a>
						<a class="btn btn-primary glyphicon glyphicon-remove-sign" href="{{ route('mobiles.indexlupaprik') }}">  Batal </a>
					@else
					    <a class="btn btn-primary glyphicon glyphicon-remove-sign" href="{{ route('mobiles.indexlupaprik') }}"> Batal </a>
					@endif
                    </div> 
                                  
								  
				</form>
               </div>

</div>
</div>


      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection