 <!-- Main content -->
    <section class="content">
      @include('layouts._flash') 
      <!-- Data Marital -->
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Data Orang Tua</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-row">         
                <div class="form-group" style="padding-left:15px;">
                  <label for="alamat_mertua"><i class="fa fa-info-circle"></i> Data Orang Tua</label><br>
                </div>
                <form id="form_dataorgtua" method="post" action="javascript:void(0)">
                   {!! Form::text('no_reg',$seq_number, [ 'name'=>'no_reg', 'id'=>'no_reg', 'hidden']) !!} 
                  <div class="form-group col-md-4">
                    <label for="nama_orangtua">Nama Ayah *</label>        
                     {!! Form::text('nama_ayah', null , ['class'=>'form-control','required', 'name'=>'nama_ayah', 'id'=>'nama_ayah']) !!}                 
                     {!! $errors->first('nama_ayah', '<p class="help-block">Wajib diisi!</p>') !!}

                  </div>
                  <div class="form-group col-md-2">
                     {!! Form::label('Inputtmp_lahir', 'Tempat Lahir *') !!}                
                        {!! Form::text('tmp_lahir_ayah', null , ['class'=>'form-control', 'name'=>'tmp_lahir_ayah', 'id'=>'tmp_lahir_ayah', 'required','placeholder'=>'Kota Kelahiran']) !!}                       
                    {!! $errors->first('tmp_lahir_ayah', '<p class="help-block">Wajib diisi!</p>') !!}
                  </div>
                  <div class="form-group col-md-3">
                     <label for="tgl_lahir_ayah">Tanggal Lahir *</label>   
                                    
                         {!! Form::date('tgl_lahir_ayah',null, ['class'=>'form-control', 'required','id'=>'tgl_lahir_ayah','style' => 'background-color:#fff;line-height: 15px;']) !!}
                                       
                      {!! $errors->first('tgl_lahir_ayah', '<p class="help-block">Wajib diisi!</p>') !!}
                  </div>
                  <div class="form-group col-md-2">
                    <label for="pekerjaan_ayah">Pekerjaan *</label>                      
                
                      {!! Form::text('pekerjaan_ayah',null, ['class'=>'form-control', 'name'=>'pekerjaan_ayah', 'required','id'=>'pekerjaan_ayah']) !!}
                     
                    
                      {!! $errors->first('pekerjaan_ayah', '<p class="help-block">Wajib diisi!</p>') !!}
                  </div>
                 
                </div> 
                <!-- Ibu -->              
                <div class="form-row">         
                  
                  <div class="form-group col-md-4">
                    <label for="nama_orangtua">Nama Ibu*</label>        
                     {!! Form::text('nama_ibu', null , ['class'=>'form-control','required', 'name'=>'nama_ibu', 'id'=>'nama_ibu']) !!}                 
                     {!! $errors->first('nama_ibu', '<p class="help-block">Wajib diisi!</p>') !!}

                  </div>
                  <div class="form-group col-md-2">
                     {!! Form::label('Inputtmp_lahir', 'Tempat Lahir *') !!}                
                        {!! Form::text('tmp_lahir_ibu', null , ['class'=>'form-control', 'name'=>'tmp_lahir_ibu', 'id'=>'tmp_lahir_ibu', 'required','placeholder'=>'Kota Kelahiran']) !!}                       
                    {!! $errors->first('tmp_lahir_ibu', '<p class="help-block">Wajib diisi!</p>') !!}
                  </div>
                  <div class="form-group col-md-3">
                     <label for="tgl_lahir_ibu">Tanggal Lahir *</label>                                     
                         {!! Form::date('tgl_lahir_ibu',null, ['class'=>'form-control', 'required','id'=>'tgl_lahir_ibu','style' => 'background-color:#fff;line-height: 15px;']) !!}             
                      {!! $errors->first('tgl_lahir_ibu', '<p class="help-block">Wajib diisi!</p>') !!}
                  </div>
                  <div class="form-group col-md-2">
                    <label for="pekerjaan_ibu">Pekerjaan *</label>                      
                      {!! Form::text('pekerjaan_ibu',null, ['class'=>'form-control', 'name'=>'pekerjaan_ibu', 'required','id'=>'pekerjaan_ibu']) !!}
                      {!! $errors->first('pekerjaan_ibu', '<p class="help-block">Wajib diisi!</p>') !!}
                  </div>               
                </div> 


                <div class="form-row">                
                    <div class="form-group col-md-10">
                      <div class="form-group" >
                         <br>
                       <label for="alamat_orgtua"><i class="fa fa-info-circle"></i> Tempat Tinggal Orang Tua</label>
                      </div>
                    </div>  
                    <div class="form-group col-md-10">
                      <label for="alamat_orgtua">Alamat *</label><br>                                            
                           {!! Form::textarea('alamat_orgtua', null, ['class'=>'form-control', 'rows'=>'1', 'name'=>'alamat_orgtua' ,'required','placeholder'=>'Contoh : Jl. Burangrang III, no 215, Perumahan Harapan Indah', 'id'=>'alamat_orgtua']) !!}                         
                     
                      {!! $errors->first('alamat_orgtua', '<p class="help-block">Wajib diisi!</p>') !!}
                    </div>
                    <div class="form-group col-md-1">
                      <label for="rt_orgtua">RT</label>                    
                        {!! Form::text('rt_orgtua', null , ['class'=>'form-control', 'name'=>'rt_orgtua', 'id'=>'rt_orgtua']) !!}
                    
                       
                      {!! $errors->first('rt_orgtua', '<p class="help-block">Wajib diisi!</p>') !!}
                    </div>
                    <div class="form-group col-md-1">
                      <label for="rw_orgtua">RW</label>                      
                    
                        {!! Form::text('rw_orgtua', null , ['class'=>'form-control', 'name'=>'rw_orgtua', 'id'=>'rw_orgtua']) !!}
                      {!! $errors->first('rw_orgtua', '<p class="help-block">Wajib diisi!</p>') !!}
                    </div>                      
                  </div>

                  <div class="form-row">                   
                    <div class="form-group col-md-3">
                      <label for="kelurahan_orgtua">Kelurahan *</label>                       
                       {!! Form::text('kelurahan_orgtua', null , ['class'=>'form-control','required', 'name'=>'kelurahan_orgtua', 'id'=>'kelurahan_orgtua']) !!}
                       {!! $errors->first('kelurahan_orgtua', '<p class="help-block">Wajib diisi!</p>') !!}

                    </div>
                    <div class="form-group col-md-3">
                      <label for="kecamatan_orgtua">Kecamatan *</label>                      
                     
                        {!! Form::text('kecamatan_orgtua', null , ['class'=>'form-control', 'name'=>'kecamatan_orgtua','required', 'id'=>'kecamatan_orgtua']) !!}                                         
                       {!! $errors->first('kecamatan_orgtua', '<p class="help-block">Wajib diisi!</p>') !!}
                    </div>
                    <div class="form-group col-md-4">
                      <label for="kota_orgtua">Kota *</label>                       
                    
                        {!! Form::text('kota_orgtua',null, ['class'=>'form-control', 'name'=>'kota_orgtua', 'required','id'=>'kota_orgtua']) !!}
                    
                        {!! $errors->first('kota_orgtua', '<p class="help-block">Wajib diisi!</p>') !!}
                    </div>
                     <div class="form-group col-md-2">
                      <label for="kode_pos_orgtua">Kode Pos</label>                       
                     
                        {!! Form::text('kode_pos_orgtua', null , ['class'=>'form-control', 'name'=>'kode_pos_orgtua', 'id'=>'kode_pos_orgtua']) !!}
                      
                       {!! $errors->first('kode_pos_orgtua', '<p class="help-block">Wajib diisi!</p>') !!}
                    </div>
                  </div>  
                  <div class="form-row">                   
                    <div class="form-group col-md-6">
                    <label for="no_telp_hp_orgtua">Telepon / No Handphone *</label>
                        {!! Form::text('no_telp_hp_orgtua', null , ['class'=>'form-control', 'name'=>'no_telp_hp_orgtua', 'required','id'=>'no_telp_hp_orgtua']) !!}
                                 
                    </div>
                  </div> 
                <hr>
                <br>
                <div class="form-row">
                  <div class="form-group" style="padding-left:15px;">
                     <label for="alamat_orgtua"><i class="fa fa-info-circle"></i> Data Mertua</label>
                  </div>                   
                  <div class="form-group col-md-4">
                    <label for="kelurahan_orgtua">Nama Ayah Mertua*</label>                       
                 
                     {!! Form::text('nama_ayah_mertua', null , ['class'=>'form-control','required', 'name'=>'nama_ayah_mertua', 'id'=>'nama_ayah_mertua']) !!}                 
                   
                    

                  </div>
                    <div class="form-group col-md-2">
                       {!! Form::label('tmp_lahir_ayah_mertua', 'Tempat Lahir *') !!}
                       
                          {!! Form::text('tmp_lahir_ayah_mertua', null , ['class'=>'form-control', 'name'=>'tmp_lahir_ayah_mertua', 'id'=>'tmp_lahir_ayah_mertua', 'required','placeholder'=>'Kota Kelahiran']) !!}
                           
                    </div>
                    <div class="form-group col-md-3">
                       <label for="tgl_lahir_ayah_mertua">Tanggal Lahir *</label>   
                                            
                           {!! Form::date('tgl_lahir_ayah_mertua',null, ['class'=>'form-control', 'required','id'=>'tgl_lahir_ayah_mertua','style' => 'background-color:#fff;line-height: 15px;']) !!}
                                       
                       
                    </div>
                    <div class="form-group col-md-2">
                      <label for="pekerjaan_ayah_mertua">Pekerjaan *</label>                       
                   
                        {!! Form::text('pekerjaan_ayah_mertua',null, ['class'=>'form-control', 'name'=>'pekerjaan_ayah_mertua', 'required','id'=>'pekerjaan_ayah_mertua']) !!}
                      
                      
                     
                    </div>                 
                  </div> 
                  <!-- Ibu -->
                  <div class="form-row">                   
                    <div class="form-group col-md-4">
                      <label for="nama_ibu_mertua">Nama Ibu Mertua*</label>                        
                      
                       {!! Form::text('nama_ibu_mertua', null , ['class'=>'form-control','required', 'name'=>'nama_ibu_mertua', 'id'=>'nama_ibu_mertua']) !!}                  
                     
                      

                    </div>
                    <div class="form-group col-md-2">
                         {!! Form::label('tmp_lahir_ibu_mertua', 'Tempat Lahir *') !!}
                        
                            {!! Form::text('tmp_lahir_ibu_mertua', null , ['class'=>'form-control', 'name'=>'tmp_lahir_ibu_mertua', 'id'=>'tmp_lahir', 'required','placeholder'=>'Kota Kelahiran']) !!}
                              
                      
                    </div>
                    <div class="form-group col-md-3">
                       <label for="tgl_lahir_ibu_mertua">Tanggal Lahir *</label>   
                                       
                           {!! Form::date('tgl_lahir_ibu_mertua',null, ['class'=>'form-control', 'required','id'=>'tgl_lahir_ibu_mertua','style' => 'background-color:#fff;line-height: 15px;']) !!}
                                       
                    </div>  
                    <div class="form-group col-md-2">
                      <label for="pekerjaan_ibu_mertua">Pekerjaan *</label>                       
                      
                        {!! Form::text('pekerjaan_ibu_mertua',null, ['class'=>'form-control', 'name'=>'pekerjaan_ibu_mertua', 'required','id'=>'pekerjaan_ibu_mertua']) !!}
                      
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-md-10">
                     <label for="alamat_mertua"><i class="fa fa-info-circle"></i> Tempat Tinggal Mertua</label> <br>
                     
                    </div>
                    <div class="form-group col-md-10">
                        <label for="alamat_mertua">Alamat</label><br>                       
                      
                          {!! Form::textarea('alamat_mertua', null, ['class'=>'form-control', 'rows'=>'1', 'name'=>'alamat_mertua' ,'placeholder'=>'Contoh : Jl. Burangrang III, no 215, Perumahan Harapan Indah', 'id'=>'alamat_mertua']) !!}
                      
                    </div>
                    <div class="form-group col-md-1">
                      <label for="rt_mertua">RT</label>                        
                     
                      {!! Form::text('rt_mertua', null , ['class'=>'form-control', 'name'=>'rt_mertua', 'id'=>'rt_mertua']) !!}
                     
                  
                    </div>
                    <div class="form-group col-md-1">
                      <label for="rw_mertua">RW</label>               
                      
                          {!! Form::text('rw_mertua', null , ['class'=>'form-control', 'name'=>'rw_mertua', 'id'=>'rw_mertua']) !!}
                    </div>
                      
                  </div>

                  <div class="form-row">                   
                    <div class="form-group col-md-3">
                      <label for="kelurahan_mertua">Kelurahan</label>                        
                       
                     {!! Form::text('kelurahan_mertua', null , ['class'=>'form-control', 'name'=>'kelurahan_mertua', 'id'=>'kelurahan_mertua']) !!}
                    
                    </div>
                    <div class="form-group col-md-3">
                      <label for="kecamatan_mertua">Kecamatan</label>                        
                    
                        {!! Form::text('kecamatan_mertua', null , ['class'=>'form-control', 'name'=>'kecamatan_mertua', 'id'=>'kecamatan_mertua']) !!}

                    </div>
                    <div class="form-group col-md-4">
                      <label for="kota_mertua">Kota</label>                        
                     
                        {!! Form::text('kota_mertua',null, ['class'=>'form-control', 'name'=>'kota_mertua', 'id'=>'kota_mertua']) !!}
                    
                    </div>
                     <div class="form-group col-md-2">
                      <label for="kode_pos_mertua">Kode Pos</label>                        
                      
                        {!! Form::text('kode_pos_mertua', null , ['class'=>'form-control', 'name'=>'kode_pos_mertua', 'id'=>'kode_pos_mertua']) !!}

                    </div>
                  </div>  
                  <div class="form-row">                   
                    <div class="form-group col-md-6">
                    <label for="no_telp_hp_mertua">Telepon / No Handphone</label><br>
                      
                        {!! Form::text('no_telp_hp_mertua', null , ['class'=>'form-control', 'name'=>'no_telp_hp_mertua', 'id'=>'no_telp_hp_mertua']) !!}
                              
                    </div>
                  </div>                      
                
                <hr>
                <div class="form-group" style="padding-right:50px;">
                    <div class="col-md-10 col-md-offset-8">
                      <p><i class="fa fa-info-circle "> Apabila ada perubahan alamat akan segera saya informasikan</i></p>                      
                    </div>
                     <p style="text-align:center;">Pernyataan : "Registrasi ini saya buat dengan sebenar-benarnya, dan apabila dikemudian hari ternyata ada hal-hal yang bertentangan, maka saya bersedia dituntut sesuai dengan hukum yang berlaku dan status kekaryawanan saya dapat dibatalkan." <br><input type="checkbox" name="disclaimer_datalmtklrg" id="disclaimer_datalmtklrg" value="">  Setujui penyataan diatas <br> <button class="btn btn-primary confirm" onclick="return confirm('Apakah data sudah benar? Anda tidak diperkenankan untuk merubah kembali.')" type="submit" id="submit_almtklrg" name="submit_almtklrg" style="display: none;">
                      <i class="fa fa-btn fa-save"></i> Simpan Data
                      </button></p> 
                </div> 
            </div>
            {!! Form::close() !!}
            <!-- ./box-body -->
            <p style="text-align: center; padding-bottom: 25px;">
              <button class="btn btn-warning" id="btn-selesai" style="display: none;" onclick="window.location.href='/hronline/mobile/indexreg/';">
              <i class="fa fa-btn fa-arrow-right"></i> Klik Untuk Selesai
              </button>
            </p>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>