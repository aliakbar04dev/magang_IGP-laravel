 <!-- Main content -->
    <section class="content">
      @include('layouts._flash') 
      <!-- Data Marital -->
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Data Marital & Keluarga</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
                <div class="row form-group">                     
                  <div class="form-row"> 
                   <form id="form_datamarital" method="post" action="javascript:void(0)">  
                     {!! Form::text('no_reg',$seq_number, [ 'name'=>'no_reg', 'id'=>'no_reg', 'hidden']) !!}    
                     <div class="form-group col-md-4">
                       {!! Form::label('InputMarital', 'Status Marital') !!}<br>
                      <select id="marital" name="marital" class="form-control">
                        <option value="TK" <?php if($datkar->marital == "TK") echo 'selected="selected"'; ?>>TK (Belum Menikah)</option>
                        <option value="K0" <?php if($datkar->marital == "K0") echo 'selected="selected"'; ?>>Sudah Menikah, belum punya anak</option>
                        <option value="K1" <?php if($datkar->marital == "K1") echo 'selected="selected"'; ?>>Sudah Menikah, punya anak 1</option>
                        <option value="K2" <?php if($datkar->marital == "K2") echo 'selected="selected"'; ?>>Sudah Menikah, punya anak 2 </option>
                        <option value="K3" <?php if($datkar->marital == "K3") echo 'selected="selected"'; ?>>Sudah Menikah, punya anak 3</option>
                      </select>
                    </div> 
                    @if (empty($datmarriage->marriage))
                    <div id="data-marriage"  style="display:none ;"> 
                    @else
                    <div id="data-marriage"  style="display: inline;"> 
          
                    @endif  
                      <div class="form-group col-md-4" >

                         {!! Form::label('InputMarital', 'Tanggal Pernikahan') !!}<br>
                          @if (empty($datmarriage->marriage))
                            {!! Form::date('marriage',null, ['class'=>'form-control', 'name'=>'marriage', 'id'=>'marriage']) !!}
                          @else
                          <?php 
                            $old_date_timestamp = strtotime($datmarriage->marriage);
                            $marriage_date = date('Y-m-d', $old_date_timestamp); 
                            alert($marriage_date);
                             
                          ?> 
                            {!! Form::date('marriage', $marriage_date , ['class'=>'form-control',  'name'=>'marriage', 'id'=>'marriage']) !!}
                          @endif                              
                              <span id="error-marriage" class="invalid-feedback"></span>                      
                        </div>   
                       </div> 
                       <br>    
                       <button type="submit" onclick="return confirm('simpan data?')" id="send_formmarital" class="btn btn-primary" style="margin-top: 5px;" > <i class="fa fa-btn fa-save"></i> Simpan Data
                      </button>                                       
                    {!! Form::close() !!} 
                </div>
                <br>  
                <hr> 
                  @if ($datkar->marital == "TK")
                    <div id="data-marital"  style="display: none;"> 
                  @else
                     <div id="data-marital"  style="display: inline;"> 
                  @endif  
                    {!! Form::text('no_reg',$seq_number, [ 'name'=>'no_reg', 'id'=>'no_reg', 'hidden']) !!} 
                    
                      <div class="col-sm-12"> 
                        <div class="float-right">
                          <a href="#modalForm" data-toggle="modal"
                           data-href="/hronline/mobile/form-datamarital/{{$seq_number}}/"
                            class="btn btn-primary">Tambah Data Keluarga</a>
                        </div> 
                        <br>                                   
                         <table class="table table-bordered bg-light">
                        <thead class="bg-dark" >
                        <tr>
                            <th width="30px" >No</th>
                            <th style="vertical-align: middle">
                                <a href="javascript:ajaxLoad('{{url('laravel-crud-search-sort-ajax-modal-form?field=name&sort='.(request()->session()->get('sort')=='asc'?'desc':'asc'))}}')">
                                    Keluarga
                                </a>
                                {{request()->session()->get('field')=='status_klg'?(request()->session()->get('sort')=='asc'?'&#9652;':'&#9662;'):''}}
                            </th>
                            <th style="vertical-align: middle">
                                <a href="javascript:ajaxLoad('{{url('laravel-crud-search-sort-ajax-modal-form?field=gender&sort='.(request()->session()->get('sort')=='asc'?'desc':'asc'))}}')">
                                    Nama
                                </a>
                                {{request()->session()->get('field')=='nama'?(request()->session()->get('sort')=='asc'?'&#9652;':'&#9662;'):''}}
                            </th>
                            <th style="vertical-align: middle">
                                <a href="javascript:ajaxLoad('{{url('laravel-crud-search-sort-ajax-modal-form?field=email&sort='.(request()->session()->get('sort')=='asc'?'desc':'asc'))}}')">
                                    Tempat, Tanggal Lahir
                                </a>
                                {{request()->session()->get('field')=='tmp_lahir'?(request()->session()->get('sort')=='asc'?'&#9652;':'&#9662;'):''}}
                            </th>                            
                            <th style="vertical-align: middle">
                                <a href="javascript:ajaxLoad('{{url('laravel-crud-search-sort-ajax-modal-form?field=created_at&sort='.(request()->session()->get('sort')=='asc'?'desc':'asc'))}}')">
                                    Jenis Kelamin
                                </a>
                                {{request()->session()->get('field')=='kelamin'?(request()->session()->get('sort')=='asc'?'&#9652;':'&#9662;'):''}}
                            </th>
                            <th style="vertical-align: middle">
                                <a href="javascript:ajaxLoad('{{url('laravel-crud-search-sort-ajax-modal-form?field=created_at&sort='.(request()->session()->get('sort')=='asc'?'desc':'asc'))}}')">
                                    Pendidikan 
                                </a>
                                {{request()->session()->get('field')=='pendidikan'?(request()->session()->get('sort')=='asc'?'&#9652;':'&#9662;'):''}}
                            </th>
                            <th style="vertical-align: middle">
                                <a href="javascript:ajaxLoad('{{url('laravel-crud-search-sort-ajax-modal-form?field=created_at&sort='.(request()->session()->get('sort')=='asc'?'desc':'asc'))}}')">
                                    Pekerjaan
                                </a>
                                {{request()->session()->get('field')=='pekerjaan'?(request()->session()->get('sort')=='asc'?'&#9652;':'&#9662;'):''}}
                            </th>
                          
                           <!--  <th width="130px" style="vertical-align: middle">Action</th> -->
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i=1;
                        @endphp
                        @foreach($datmarital as $datmarital)                   
                            <tr>
                                <th style="vertical-align: middle;text-align: center">{{$i++}}</th>
                                <td style="vertical-align: middle">{{ $datmarital->status_klg_desc }}</td>
                                <td style="vertical-align: middle">{{ $datmarital->nama}}</td>
                                <td style="vertical-align: middle">{{ $datmarital->tmp_lahir}} - {{ $datmarital->tgl_lahir}}</td>
                                <td style="vertical-align: middle">{{ $datmarital->kelamin}}</td>
                                <td style="vertical-align: middle">{{ $datmarital->pendidikan}}</td>
                                <td style="vertical-align: middle">{{ $datmarital->pekerjaan}}</td>

                               
                                
                                <td style="vertical-align: middle" align="center">
                                   <!--  <a class="btn btn-primary btn-sm" title="Edit" href="#modalForm" data-toggle="modal"
                                       data-href="{{url('laravel-crud-search-sort-ajax-modal-form/update_datpend/'.$datmarital->status_klg)}}">
                                        Edit</a> -->
                                    <input type="hidden" name="_method" value="delete"/>
                                    <!-- <a class="btn btn-danger btn-sm" title="Delete" data-toggle="modal"
                                       href="#modalDelete"
                                       data-id="{{$datmarital->status_klg}}"
                                       data-token="{{csrf_token()}}">
                                        Delete
                                    </a> -->
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                      </table> 
                        <br>
                         
                        <br>

                        <hr>                  
                        <div class="form-group" style="padding-right:50px;">                        
                           <p style="text-align:center;">Pernyataan : "Registrasi ini saya buat dengan sebenar-benarnya, dan apabila dikemudian hari ternyata ada hal-hal yang bertentangan, maka saya bersedia dituntut sesuai dengan hukum yang berlaku dan status kekaryawanan saya dapat dibatalkan." <br><input type="checkbox" name="disclaimer_datamarital" id="disclaimer_datamarital" value="" onclick="check_disc_datmarit()">&nbsp;  Setujui penyataan diatas <br><br> <button class="btn btn-warning" onclick="window.location.href='/hronline/mobile/indexreg_/data_orangtua/{{$seq_number}}/';" type="submit" id="submit_marital" name="submit_marital" style="display: none;">
                            <i class="fa fa-btn fa-arrow-right"></i> Isi Data Berikutnya
                            </button></p> 
                        </div>                  

                      </div>
                    </div>  
                  </div> 
                </div>
                <p style="text-align: center; padding-bottom: 25px;">
                <button class="btn btn-warning" id="btn_next_marital" style="display: none;" onclick="window.location.href='/hronline/mobile/indexreg_/data_orangtua/{{$seq_number}}/';">
                <i class="fa fa-btn fa-arrow-right"></i> Isi Data Berikutnya
                </button>
            </p>
              </div>
              <!-- /.form-group -->
            </div>

          
            <!-- ./box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>