 <!-- Main content -->
    <section class="content">
      @include('layouts._flash')

      <!-- Data Pendidikan -->
        <div class="row">        

          <div class="col-md-12">        
            <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Data Pendidikan</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div id="content">      
                    <div class="box-body">
                      @php
                        $no_reg= Request::segment(5);                       
                      @endphp
                      <div class="float-right">
                        <a href="#modalForm" data-toggle="modal"
                         data-href="/hronline/mobile/form-datapendidikan/{{$seq_number}}/"
                          class="btn btn-primary">Tambah Pendidikan</a>
                        </div>
                        <!-- <p> <a class="btn btn-primary" href="{{ url('/admin/members/create') }}">Tambah</a> </p>  -->  
                        <br>              
                       <table class="table table-bordered bg-light">
                        <thead class="bg-dark" >
                        <tr>
                            <th width="30px" >No</th>
                            <th style="vertical-align: middle">
                                <a href="javascript:ajaxLoad('{{url('laravel-crud-search-sort-ajax-modal-form?field=name&sort='.(request()->session()->get('sort')=='asc'?'desc':'asc'))}}')">
                                    Jenjang
                                </a>
                                {{request()->session()->get('field')=='jenjang'?(request()->session()->get('sort')=='asc'?'&#9652;':'&#9662;'):''}}
                            </th>
                            <th style="vertical-align: middle">
                                <a href="javascript:ajaxLoad('{{url('laravel-crud-search-sort-ajax-modal-form?field=gender&sort='.(request()->session()->get('sort')=='asc'?'desc':'asc'))}}')">
                                    Nama Sekolah
                                </a>
                                {{request()->session()->get('field')=='nama_sekolah'?(request()->session()->get('sort')=='asc'?'&#9652;':'&#9662;'):''}}
                            </th>
                            <th style="vertical-align: middle">
                                <a href="javascript:ajaxLoad('{{url('laravel-crud-search-sort-ajax-modal-form?field=email&sort='.(request()->session()->get('sort')=='asc'?'desc':'asc'))}}')">
                                    Jurusan
                                </a>
                                {{request()->session()->get('field')=='jurusan'?(request()->session()->get('sort')=='asc'?'&#9652;':'&#9662;'):''}}
                            </th>
                            <th style="vertical-align: middle">
                                <a href="javascript:ajaxLoad('{{url('laravel-crud-search-sort-ajax-modal-form?field=created_at&sort='.(request()->session()->get('sort')=='asc'?'desc':'asc'))}}')">
                                    Tempat
                                </a>
                                {{request()->session()->get('field')=='tempat'?(request()->session()->get('sort')=='asc'?'&#9652;':'&#9662;'):''}}
                            </th>
                            <th style="vertical-align: middle">
                                <a href="javascript:ajaxLoad('{{url('laravel-crud-search-sort-ajax-modal-form?field=created_at&sort='.(request()->session()->get('sort')=='asc'?'desc':'asc'))}}')">
                                    Masa (Tahun)
                                </a>
                                {{request()->session()->get('field')=='tempat'?(request()->session()->get('sort')=='asc'?'&#9652;':'&#9662;'):''}}
                            </th>
                          
                           <!--  <th width="130px" style="vertical-align: middle">Action</th> -->
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i=1;
                        @endphp
                        @foreach($datpendidikan as $datpend)                   
                            <tr>
                                <th style="vertical-align: middle;text-align: center">{{$i++}}</th>
                                <td style="vertical-align: middle">{{ $datpend->jenjang }}</td>
                                <td style="vertical-align: middle">{{ $datpend->nama_sekolah}}</td>
                                <td style="vertical-align: middle">{{ $datpend->jurusan}}</td>
                                <td style="vertical-align: middle">{{ $datpend->tempat}}</td>
                                <td style="vertical-align: middle">{{ $datpend->tahun_masuk}} - {{ $datpend->tahun_lulus}}</td>
                               
                                
                                <td style="vertical-align: middle" align="center">
                                   <!--  <a class="btn btn-primary btn-sm" title="Edit" href="#modalForm" data-toggle="modal"
                                       data-href="{{url('laravel-crud-search-sort-ajax-modal-form/update_datpend/'.$datpend->kd_jenjang)}}">
                                        Edit</a> -->
                                    <input type="hidden" name="_method" value="delete"/>
                                    <!-- <a class="btn btn-danger btn-sm" title="Delete" data-toggle="modal"
                                       href="#modalDelete"
                                       data-id="{{$datpend->kd_jenjang}}"
                                       data-token="{{csrf_token()}}">
                                        Delete
                                    </a> -->
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                      </table>     
                      <br> <br>
                       <p style="text-align:center""> Pernyataan : "Registrasi ini saya buat dengan sebenar-benarnya, dan apabila dikemudian hari ternyata ada hal-hal yang bertentangan, maka saya bersedia dituntut sesuai dengan hukum yang berlaku dan status kekaryawanan saya dapat dibatalkan." <br><input type="checkbox" name="disclaimer_datpend" id="disclaimer_datpend"  value="" onclick="check_disc_datpend()">&nbsp; Setujui penyataan diatas<br><br>
                        <button class="btn btn-warning" id="btn_next_pend" style="display: none;" onclick="window.location.href='/hronline/mobile/indexreg_/data_pendukung/{{$seq_number}}/';">
                        <i class="fa fa-btn fa-arrow-right"></i> Isi Data Berikutnya
                        </button>
                        </p>            
                    </div>
                    <!-- /.box-body -->
                  </div>                
              </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

      

    </section>