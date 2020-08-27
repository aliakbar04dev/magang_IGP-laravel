 <!-- Main content -->
    <section class="content">
      @include('layouts._flash') 

      <!-- Data Penunjang -->  
      <div class="row">
        <div class="col-md-12">        
          <div class="box">
            <div id="data-pendukung">
              <div class="box-header with-border">
                <h3 class="box-title">Data Pendukung</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="row form-group">

                  <div class="col-sm-12">
                      <form id="form_datapendukung" method="post" action="javascript:void(0)">
                        {!! Form::text('no_reg',$seq_number, [ 'name'=>'no_reg', 'id'=>'no_reg', 'hidden']) !!}          
                      <div class="form-row">                        
                        <div class="form-group col-md-7">                       
                          {!! Form::label('InputNorek_mandiri', 'Rekening Bank Mandiri') !!}
                          {!! Form::text('rek_mandiri', null , ['class'=>'form-control', 'name'=>'rek_mandiri', 'id'=>'rek_mandiri', 'placeholder'=>'Nomor Rekening Bank Mandiri']) !!}
                          {!! $errors->first('rek_mandiri', '<p class="help-block">Wajib diisi!</p>') !!}
                           <span class="text-danger">{{ $errors->first('rek_mandiri') }}</span>
                            <input id="rek_mandiri_file" name="rek_mandiri_file" type="file" data-toggle="tooltip" data-placement="top" title="Upload">
                        </div>
                      </div>
                  </div>
                  <div class="col-sm-12">        
                    <div class="form-group col-md-3">
                      <label for="  ">Memiliki BPJS Kesehatan ? </label><br>                          
                        <input type="radio" name="bpjskes_rad" id="have" value="have" > Ya &nbsp;
                        <input type="radio" name="bpjskes_rad" id="not_have" value="not_have" > Tidak<br>
                    </div>
                    <div id="divinputbpjskes" style="display: none;" class="form-group col-md-4">
                      {!! Form::label('InputBPJSkes', 'BPJS Kesehatan') !!}
                      {!! Form::text('bpjskes', null , ['class'=>'form-control', 'name'=>'bpjskes', 'id'=>'bpjskes', 'placeholder'=>'Nomor Kartu Peserta BPJS Kesehatan', 'hidden']) !!}
                       {!! $errors->first('bpjskes', '<p class="help-block">Wajib diisi!</p>') !!}
                       <span class="text-danger">{{ $errors->first('bpjskes') }}</span>
                      <input id="bpjskes_file" name="bpjskes_file" type="file" data-toggle="tooltip" data-placement="top" title="Upload">
                    </div>    
                  </div>
                  <div class="col-sm-12"> 
                      <div class="form-row">
                        <div class="form-group col-md-3">
                          <label for="bpjsket_rad">Memiliki BPJS Ketenagakerjaan?</label><br>                          
                            <input type="radio" name="bpjsket_rad" id="have" value="have" > Ya &nbsp;
                            <input type="radio" name="bpjsket_rad" id="not_have" value="not_have" > Tidak<br>
                        </div>
                        <!-- <div id="divinputnpwp" style="display: none;"> -->
                        <div id="divinputbpjsket" style="display: none; "class="form-group col-md-4">                       
                          {!! Form::label('InputBPJSket', 'BPJS Ketenagakerjaan') !!}
                          {!! Form::text('bpjsket', null , ['class'=>'form-control', 'name'=>'bpjsket', 'id'=>'bpjsket', 'placeholder'=>'Nomor Kartu Peserta BPJS Ketenagakerjaan', 'hidden']) !!}
                          {!! $errors->first('bpjsket', '<p class="help-block">Wajib diisi!</p>') !!}
                          <span class="text-danger">{{ $errors->first('bpjsket') }}</span>
                          <input id="bpjsket_file" name="bpjsket_file" type="file" data-toggle="tooltip" data-placement="top" title="Upload">
                        </div>
                      </div>  
                  </div>
                  <div class="col-sm-12">                             
                      <div class="form-row">
                        <div class="form-group col-md-3">
                          <label for="npwp">Memiliki NPWP ?</label><br>                          
                            <input type="radio" name="npwp" id="have" value="have" > Ya &nbsp;
                            <input type="radio" name="npwp" id="not_have" value="not_have" > Tidak<br>
                        </div>
                        <div id="divinputnpwp" style="display: none;">
                          <div class="form-group col-md-4">
                            {!! Form::label('inputNPWP', 'Nomor Pokok Wajib Pajak (NPWP)', array('id'=>'inputNPWP')) !!}
                            {!! Form::text('no_npwp', null , ['class'=>'form-control', 'name'=>'no_npwp', 'id'=>'no_npwp', 'placeholder'=>'Nomor NPWP', 'display'=>'none']) !!}
                            {!! $errors->first('no_npwp', '<p class="help-block">Wajib diisi!</p>') !!}
                          </div>
                        </div>  
                      </div>  
                      <div class="col-md-6 col-md-offset-6">
                          <div class="alert alert-success print-success-msg" id="msg_div" style="display: none;">
                              <span id="res_message"></span>
                          </div>
                          <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        <br>
                      </div>
                     <hr>
                     <p style="text-align:center""> Pernyataan : "Registrasi ini saya buat dengan sebenar-benarnya, dan apabila dikemudian hari ternyata ada hal-hal yang bertentangan, maka saya bersedia dituntut sesuai dengan hukum yang berlaku dan status kekaryawanan saya dapat dibatalkan." <br> <input type="checkbox" name="disclaimer_datpendu" id="disclaimer_datpendu" value="">&nbsp; Setujui penyataan diatas<br> 
                     <button type="submit" onclick="return confirm('Apakah data sudah benar? Anda tidak diperkenankan untuk merubah kembali.')" id="send_form" class="btn btn-primary" style="display: none;">                                    <i class="fa fa-btn fa-save"></i> Submit
                        </button> </p>   
                                      
                     {!! Form::close() !!}
                  </div>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- ./box-body -->
            </div>
            <!-- ./id data_pribadi --> 
              <p style="text-align: center; padding-bottom: 25px;">
                <button class="btn btn-warning" id="btn_next_pendukung" style="display: none;" onclick="window.location.href='/hronline/mobile/indexreg_/data_marital/{{$seq_number}}/';">
                <i class="fa fa-btn fa-arrow-right"></i> Isi Data Berikutnya
                </button>
            </p>                        
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->


    </section>