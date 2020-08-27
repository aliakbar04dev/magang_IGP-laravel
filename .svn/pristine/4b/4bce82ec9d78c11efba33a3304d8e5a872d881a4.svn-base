 <!-- Main content -->
    <section class="content">
      @include('layouts._flash') 
      <!-- Form -->
      <!-- data pribadi -->
      <!-- Info boxes -->
      <div class="row">

        <div class="col-md-12">
          
        <!-- collapsed-box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Data Pribadi</h3>                    
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div id="data-pribadi">
              <div class="box-body">
                <div class="row form-group">
                    <div class="col-sm-12">                   
                      <form id="form_datapribadi" method="post" action="javascript:void(0)">
                       {!! Form::text('no_reg',$seq_number, [ 'name'=>'no_reg', 'id'=>'no_reg', 'readonly', 'hidden']) !!}    
                      <div class="form-row">  
                                         
                        <div class="form-group col-md-6">
                         {!! Form::label('InputNama', 'Nama *') !!}
                          @if (empty($datkar->nama))
                            {!! Form::text('nama',null, ['class'=>'form-control', 'required', 'name'=>'nama', 'id'=>'nama', 'placeholder'=>'Nama Lengkap']) !!}
                          @else
                            {!! Form::text('nama', $datkar->nama , ['class'=>'form-control', 'required',  'name'=>'nama', 'id'=>'nama', 'placeholder'=>'Nama Lengkap']) !!}
                          @endif
                        {!! $errors->first('nama', '<p class="help-block">Wajib diisi!</p>') !!}
                       
                        </div>
                        <div class="form-group col-md-3">                      
                           {!! Form::label('InputKtp', 'No. KTP *') !!}
                            @if (empty($datkar->no_ktp))
                              {!! Form::text('no_ktp', null , ['class'=>'form-control', 'name'=>'no_ktp', 'id'=>'no_ktp', 'required', 'placeholder'=>'Nomor Induk Kependudukan']) !!}
                            @else
                              {!! Form::text('no_ktp', $datkar->no_ktp , ['class'=>'form-control', 'name'=>'no_ktp', 'id'=>'no_ktp','required', 'placeholder'=>'Nomor Induk Kependudukan']) !!}
                            @endif
                           {!! $errors->first('no_ktp', '<p class="help-block">Wajib diisi!</p>') !!}
                        </div>
                          <div class="form-group col-md-3">                      
                             {!! Form::label('npk_lc', 'NPK LC *') !!}
                              @if (empty($datkar->npk_lc))
                                {!! Form::text('npk_lc', null , ['class'=>'form-control', 'name'=>'npk_lc', 'id'=>'npk_lc', 'required', 'placeholder'=>'NPK LC']) !!}
                              @else
                                {!! Form::text('npk_lc', $datkar->npk_lc , ['class'=>'form-control', 'name'=>'npk_lc', 'id'=>'npk_lc','required', 'placeholder'=>'NPK LC']) !!}
                              @endif
                             {!! $errors->first('npk_lc', '<p class="help-block">Wajib diisi!</p>') !!}
                          </div>   
                      </div>


                      <div class="form-row">              
                        <div class="form-group col-md-3">
                             {!! Form::label('Inputtmp_lahir', 'Tempat Lahir *') !!}
                              @if (empty($datkar->tmp_lahir))
                                {!! Form::text('tmp_lahir', null , ['class'=>'form-control', 'name'=>'tmp_lahir', 'id'=>'tmp_lahir', 'required','placeholder'=>'Kota Kelahiran']) !!}
                              @else
                                {!! Form::text('tmp_lahir', $datkar->tmp_lahir , ['class'=>'form-control', 'name'=>'tmp_lahir','required', 'id'=>'tmp_lahir', 'placeholder'=>'Kota Kelahiran']) !!}
                              @endif        
                          {!! $errors->first('tmp_lahir', '<p class="help-block">Wajib diisi!</p>') !!}
                        </div>
                        <div class="form-group col-md-3">
                           <label for="tgl_lahir">Tanggal Lahir</label>   
                              @if (empty($datkar->tgl_lahir))                     
                               {!! Form::date('tgl_lahir',null, ['class'=>'form-control', 'required','id'=>'tgl_lahir','style' => 'background-color:#fff;line-height: 15px;']) !!}
                              @else
                                {!! Form::date('tgl_lahir',$datkar->tgl_lahir, ['class'=>'form-control', 'id'=>'tgl_lahir','required','style' => 'background-color:#fff;line-height: 15px;']) !!}
                              @endif                   
                            {!! $errors->first('tgl_lahir', '<p class="help-block">Wajib diisi!</p>') !!}
                        </div>  
                        <div class="form-group col-md-3">
                          <label for="kelamin">Jenis Kelamin *</label><br>
                            <input type="radio" name="kelamin" value="L" required <?php if($datkar->kelamin == "L") echo 'checked="checked"'; ?>> Laki-laki &nbsp;
                            <input type="radio" name="kelamin" value="P" required <?php if($datkar->kelamin == "P") echo 'checked="checked"'; ?>> Perempuan<br>
                        </div>
                        
                        <div class="form-group col-md-3">
                           {!! Form::label('InputAgama', 'Agama') !!}<br>
                          <select id="agama" name="agama" class="form-control">
                            <option value="1" <?php if($datkar->agama == "1") echo 'selected="selected"'; ?>>Islam</option>
                            <option value="2" <?php if($datkar->agama == "2") echo 'selected="selected"'; ?>>Katolik</option>
                            <option value="3" <?php if($datkar->agama == "3") echo 'selected="selected"'; ?>>Protestan</option>
                            <option value="4" <?php if($datkar->agama == "4") echo 'selected="selected"'; ?>>Hindu</option>
                            <option value="5" <?php if($datkar->agama == "5") echo 'selected="selected"'; ?>>Budha</option>
                        </select>
                        </div>   
                      </div>
                      <div class="form-row">                                   
                         <div class="form-group col-md-3 ">

                          {!! Form::label('InputKewarganegaraan', 'Kewarganegaraan') !!}<br>
                          <select id="kd_warga" name="kd_warga" class="form-control">
                            <option value="1" <?php if($datkar->kd_warga == "1") echo 'selected="selected"'; ?>>WNI</option>
                            <option value="2" <?php if($datkar->kd_warga == "2") echo 'selected="selected"'; ?>>WNA</option>
                          </select>
                        </div>
                        <div class="form-group col-md-3">
                          {!! Form::label('InputGolDar', 'Golongan Darah') !!}<br>
                          <select id="gol_darah" name="gol_darah" class="form-control">
                            <option value="A" <?php if($datkar->gol_darah == "A") echo 'selected="selected"'; ?>>A</option>
                            <option value="B" <?php if($datkar->gol_darah == "B") echo 'selected="selected"'; ?>>B</option>
                            <option value="AB" <?php if($datkar->gol_darah == "AB") echo 'selected="selected"'; ?> >AB</option>
                            <option value="O" <?php if($datkar->gol_darah == "O") echo 'selected="selected"'; ?> >O</option>
                          </select>
                          <br>
                        </div>
                      </div>

                      <hr>
                      <div class="form-row">
                      <br>
                        <div class="form-group" style="padding-left:15px;">
                         <label for="alamat_domi">Tempat Tinggal Domisili</label>
                        </div>
                        <div class="form-group col-md-10">
                          <label for="alamat_dom">Alamat *</label><br>
                          @if (empty($alamatdom->desc_alam))                        
                               {!! Form::textarea('alamat_dom', null, ['class'=>'form-control', 'rows'=>'1', 'name'=>'alamat_dom' ,'required','placeholder'=>'Contoh : Jl. Burangrang III, no 215, Perumahan Harapan Indah', 'id'=>'alamat_dom']) !!}
                          @else
                             {!! Form::text('alamat_dom', $alamatdom->desc_alam , ['class'=>'form-control', 'name'=>'alamat_dom','required', 'id'=>'alamat_dom']) !!}
                          @endif              
                         
                          {!! $errors->first('alamat_dom', '<p class="help-block">Wajib diisi!</p>') !!}
                          <!-- <input type="text" class="form-control" id="alamat_dom" placeholder="Nama jalan, nomor rumah"> -->
                        </div>
                        <div class="form-group col-md-1">
                          <label for="rt_dom">RT</label>
                          @if (empty($alamatdom->rt))
                            {!! Form::text('rt_dom', null , ['class'=>'form-control', 'name'=>'rt_dom', 'id'=>'rt_dom']) !!}
                           
                          @else
                            {!! Form::text('rt_dom', $alamatdom->rt , ['class'=>'form-control', 'name'=>'rt_dom', 'id'=>'rt_dom']) !!}
                          @endif
                           
                          {!! $errors->first('rt_dom', '<p class="help-block">Wajib diisi!</p>') !!}
                        </div>
                        <div class="form-group col-md-1">
                          <label for="rw_dom">RW</label>                         
                          @if (empty($alamatdom->rw))
                            {!! Form::text('rw_dom', null , ['class'=>'form-control', 'name'=>'rw_dom', 'id'=>'rw_dom']) !!}
                           
                          @else
                            {!! Form::text('rw_dom', $alamatdom->rw , ['class'=>'form-control', 'name'=>'rw_dom', 'id'=>'rw_dom']) !!}
                        @endif                       
                          
                          {!! $errors->first('rw_dom', '<p class="help-block">Wajib diisi!</p>') !!}
                        </div>                      
                      </div>

                      <div class="form-row">                   
                        <div class="form-group col-md-3">
                          <label for="kelurahan_dom">Kelurahan *</label>                        
                          @if (empty($alamatdom->kelurahan))
                           {!! Form::text('kelurahan_dom', null , ['class'=>'form-control','required', 'name'=>'kelurahan_dom', 'id'=>'kelurahan_dom']) !!}
                          @else
                           {!! Form::text('kelurahan_dom', $alamatdom->kelurahan , ['class'=>'form-control', 'required','name'=>'kelurahan_dom', 'id'=>'kelurahan_dom']) !!}
                          @endif 
                         
                           {!! $errors->first('kelurahan_dom', '<p class="help-block">Wajib diisi!</p>') !!}

                        </div>
                        <div class="form-group col-md-3">
                          <label for="kecamatan_dom">Kecamatan *</label>                       
                          @if(empty($alamatdom->kecamatan))
                            {!! Form::text('kecamatan_dom', null , ['class'=>'form-control', 'name'=>'kecamatan_dom','required', 'id'=>'kecamatan_dom']) !!}
                          @else
                             {!! Form::text('kecamatan_dom', $alamatdom->kecamatan , ['class'=>'form-control', 'name'=>'kecamatan_dom', 'required','id'=>'kecamatan_dom']) !!}
                          @endif                       
                           {!! $errors->first('kecamatan_dom', '<p class="help-block">Wajib diisi!</p>') !!}
                        </div>
                        <div class="form-group col-md-4">
                          <label for="kota_dom">Kota *</label>                       
                          @if(empty($alamatdom->kota))
                            {!! Form::text('kota_dom',null, ['class'=>'form-control', 'name'=>'kota_dom', 'required','id'=>'kota_dom']) !!}
                          @else
                            {!! Form::text('kota_dom',$alamatdom->kota, ['class'=>'form-control', 'name'=>'kota_dom','required', 'id'=>'kota_dom']) !!}
                          @endif 
                          
                            {!! $errors->first('kota_dom', '<p class="help-block">Wajib diisi!</p>') !!}
                        </div>
                         <div class="form-group col-md-2">
                          <label for="kode_pos_dom">Kode Pos</label>                       
                          @if(empty($alamatdom->kd_pos))
                            {!! Form::text('kode_pos_dom', null , ['class'=>'form-control', 'name'=>'kode_pos_dom', 'id'=>'kode_pos_dom']) !!}
                          @else
                            {!! Form::text('kode_pos_dom',$alamatdom->kd_pos, ['class'=>'form-control', 'name'=>'kode_pos_dom', 'id'=>'kode_pos_dom']) !!}
                          @endif 
                          
                           {!! $errors->first('kode_pos_dom', '<p class="help-block">Wajib diisi!</p>') !!}
                        </div>
                      </div>  
                      <div class="form-row">                   
                        <div class="form-group col-md-6">
                        <label for="no_telp_hp_dom">Telepon / No Handphone *</label>
                         @if(empty($alamatdom->kd_pos))
                            {!! Form::text('no_telp_hp_dom', null , ['class'=>'form-control', 'name'=>'no_telp_hp_dom', 'required','id'=>'no_telp_hp_dom']) !!}
                          @else
                            {!! Form::text('no_telp_hp_dom',$alamatdom->kd_pos, ['class'=>'form-control', 'name'=>'no_telp_hp_dom', 'required','id'=>'no_telp_hp_dom']) !!}
                          @endif                  
                        </div>
                      </div>                  
                   
                    <hr>
                    <div class="form-row">
                      <div class="form-group" style="padding-left:15px;">
                       <label for="alamat_domi">Tempat Tinggal Sesuai KTP</label> <br>
                       <a href="#" onClick="autoFill(); return false;" role="button">*Klik disini apabila Alamat KTP sama dengan alamat Domisili</a>
                      </div>
                      <div class="form-group col-md-10">
                          <label for="alamat_ktp">Alamat</label><br>                       
                          @if (empty($alamatktp->desc_alam))
                            {!! Form::textarea('alamat_ktp', null, ['class'=>'form-control', 'rows'=>'1', 'name'=>'alamat_ktp' ,'placeholder'=>'Contoh : Jl. Burangrang III, no 215, Perumahan Harapan Indah', 'id'=>'alamat_ktp']) !!}
                          @else
                             {!! Form::text('alamat_ktp', $alamatktp->desc_alam , ['class'=>'form-control', 'name'=>'alamat_ktp', 'id'=>'alamat_ktp']) !!}
                          @endif
                         
                          {!! $errors->first('alamat_ktp', '<p class="help-block">Wajib diisi!</p>') !!}
                        </div>
                        <div class="form-group col-md-1">
                          <label for="rt_ktp">RT</label>                        
                          @if (empty($alamatktp->rt))
                          {!! Form::text('rt_ktp', null , ['class'=>'form-control', 'name'=>'rt_ktp', 'id'=>'rt_ktp']) !!}
                         
                          @else
                            {!! Form::text('rt_ktp', $alamatktp->rt , ['class'=>'form-control', 'name'=>'rt_ktp', 'id'=>'rt_ktp']) !!}
                          @endif                        
                         
                          {!! $errors->first('rt_ktp', '<p class="help-block">Wajib diisi!</p>') !!}
                        </div>
                        <div class="form-group col-md-1">
                          <label for="rw_ktp">RW</label>                      
                            @if (empty($alamatktp->rw))
                              {!! Form::text('rw_ktp', null , ['class'=>'form-control', 'name'=>'rw_ktp', 'id'=>'rw_ktp']) !!}
                             
                            @else
                              {!! Form::text('rw_ktp', $alamatktp->rw , ['class'=>'form-control', 'name'=>'rw_ktp', 'id'=>'rw_ktp']) !!}
                            @endif
                             {!! $errors->first('rw_ktp', '<p class="help-block">Wajib diisi!</p>') !!}
                        </div>
                        
                      </div>

                      <div class="form-row">                   
                        <div class="form-group col-md-3">
                          <label for="kelurahan_ktp">Kelurahan</label>                        
                           @if (empty($alamatktp->kelurahan))
                         {!! Form::text('kelurahan_ktp', null , ['class'=>'form-control', 'name'=>'kelurahan_ktp', 'id'=>'kelurahan_ktp']) !!}
                        @else
                         {!! Form::text('kelurahan_ktp', $alamatktp->kelurahan , ['class'=>'form-control', 'name'=>'kelurahan_ktp', 'id'=>'kelurahan_ktp']) !!}
                        @endif 
                           {!! $errors->first('kelurahan_ktp', '<p class="help-block">Wajib diisi!</p>') !!}
                        </div>
                        <div class="form-group col-md-3">
                          <label for="kecamatan_ktp">Kecamatan</label>                        
                          @if(empty($alamatktp->kecamatan))
                            {!! Form::text('kecamatan_ktp', null , ['class'=>'form-control', 'name'=>'kecamatan_ktp', 'id'=>'kecamatan_ktp']) !!}
                          @else
                             {!! Form::text('kecamatan_ktp', $alamatktp->kecamatan , ['class'=>'form-control', 'name'=>'kecamatan_ktp', 'id'=>'kecamatan_ktp']) !!}
                          @endif
                          
                           {!! $errors->first('kecamatan_ktp', '<p class="help-block">Wajib diisi!</p>') !!}
                        </div>
                        <div class="form-group col-md-4">
                          <label for="kota_ktp">Kota</label>                        
                          @if(empty($alamatktp->kota))
                            {!! Form::text('kota_ktp',null, ['class'=>'form-control', 'name'=>'kota_ktp', 'id'=>'kota_ktp']) !!}
                          @else
                            {!! Form::text('kota_ktp',$alamatktp->kota, ['class'=>'form-control', 'name'=>'kota_ktp', 'id'=>'kota_ktp']) !!}
                          @endif 
                         
                            {!! $errors->first('kota_ktp', '<p class="help-block">Wajib diisi!</p>') !!}
                        </div>
                         <div class="form-group col-md-2">
                          <label for="kode_pos_dom">Kode Pos</label>                        
                          @if(empty($alamatktp->kd_pos))
                            {!! Form::text('kode_pos_ktp', null , ['class'=>'form-control', 'name'=>'kode_pos_ktp', 'id'=>'kode_pos_ktp']) !!}
                          @else
                            {!! Form::text('kode_pos_ktp',$alamatktp->kd_pos, ['class'=>'form-control', 'name'=>'kode_pos_ktp', 'id'=>'kode_pos_ktp']) !!}
                          @endif                     
                           {!! $errors->first('kode_pos_ktp', '<p class="help-block">Wajib diisi!</p>') !!}
                        </div>
                      </div>  
                      <div class="form-row">                   
                        <div class="form-group col-md-6">
                        <label for="no_telp_hp_ktp">Telepon / No Handphone</label><br>
                          @if(empty($alamatdom->kd_pos))
                            {!! Form::text('no_telp_hp_ktp', null , ['class'=>'form-control', 'name'=>'no_telp_hp_ktp', 'id'=>'no_telp_hp_ktp']) !!}
                          @else
                            {!! Form::text('no_telp_hp_ktp',$alamatdom->kd_pos, ['class'=>'form-control', 'name'=>'no_telp_hp_ktp', 'id'=>'no_telp_hp_ktp']) !!}
                          @endif                  
                                              
                        </div>
                      </div>                            
                  
                  <hr>
                  <div class="col-md-6 col-md-offset-6">
                          <div class="alert alert-success-2" id="msg_div" style="display: none;">
                              <span id="res_message"></span>
                          </div>
                          <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                      </div>
                     <p style="text-align:center""> Pernyataan : "Registrasi ini saya buat dengan sebenar-benarnya, dan apabila dikemudian hari ternyata ada hal-hal yang bertentangan, maka saya bersedia dituntut sesuai dengan hukum yang berlaku dan status kekaryawanan saya dapat dibatalkan." <br><input type="checkbox" name="disclaimer_datprib" id="disclaimer_datprib" value="">&nbsp; Setujui penyataan diatas<br><button class="btn btn-primary confirm" onclick="return confirm('Apakah data sudah benar? Anda tidak diperkenankan untuk untuk merubah kembali.')" type="submit" id="submit_datprib"  style="display: none;">
                        <i class="fa fa-btn fa-save" style="display: none;"></i> Simpan Data
                        </button>
                        </p> 
                    <!-- <div class="form-group" style="padding-right:25px;">       
                      <div class="col-md-6 col-md-offset-11">                  
                       
                        <button class="btn btn-warning" data-confirm=Apakah data sudah benar?" type="submit" >
                        <i class="fa fa-btn fa-undo"></i> Reset
                        </button>
                      </div>
                    </div>   -->   
                  {!! Form::close() !!}
                  </div>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- ./box-body -->
            </div>
            <!-- ./id data_pribadi -->
           <p style="text-align: center; padding-bottom: 25px;">
                <button class="btn btn-warning" id="btn_next_pribadi" style="display: none;" onclick="window.location.href='/hronline/mobile/indexreg_/data_pendidikan/{{$seq_number}}/';">
                <i class="fa fa-btn fa-arrow-right"></i> Isi Data Berikutnya
                </button>
            </p>
          
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- Form -->      

    </section>