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
                       {!! Form::text('no_reg',$seq_number, [ 'name'=>'no_reg', 'id'=>'no_reg', 'readonly']) !!}    
                      <div class="form-row">                        
                        <div class="form-group col-md-6">
                         {!! Form::label('InputNama', 'Nama') !!}
                          @if (empty($datkar->nama))
                            {!! Form::text('nama',null, ['class'=>'form-control', 'name'=>'nama', 'id'=>'nama', 'placeholder'=>'Nama Lengkap']) !!}
                          @else
                            {!! Form::text('nama', $datkar->nama , ['class'=>'form-control', 'name'=>'nama', 'id'=>'nama', 'placeholder'=>'Nama Lengkap']) !!}
                          @endif
                        {!! $errors->first('nama', '<p class="help-block">Wajib diisi!</p>') !!}
                       
                        </div>
                        <div class="form-group col-md-6">                      
                           {!! Form::label('InputKtp', 'No. KTP') !!}
                            @if (empty($datkar->no_ktp))
                              {!! Form::text('no_ktp', null , ['class'=>'form-control', 'name'=>'no_ktp', 'id'=>'no_ktp', 'placeholder'=>'Nomor Induk Kependudukan']) !!}
                            @else
                              {!! Form::text('no_ktp', $datkar->no_ktp , ['class'=>'form-control', 'name'=>'no_ktp', 'id'=>'no_ktp', 'placeholder'=>'Nomor Induk Kependudukan']) !!}
                            @endif
                           {!! $errors->first('no_ktp', '<p class="help-block">Wajib diisi!</p>') !!}
                        </div>
                      </div>


                      <div class="form-row">              
                        <div class="form-group col-md-3">
                             {!! Form::label('Inputtmp_lahir', 'Tempat Lahir') !!}
                              @if (empty($datkar->tmp_lahir))
                                {!! Form::text('tmp_lahir', null , ['class'=>'form-control', 'name'=>'tmp_lahir', 'id'=>'tmp_lahir', 'placeholder'=>'Kota Kelahiran']) !!}
                              @else
                                {!! Form::text('tmp_lahir', $datkar->tmp_lahir , ['class'=>'form-control', 'name'=>'tmp_lahir', 'id'=>'tmp_lahir', 'placeholder'=>'Kota Kelahiran']) !!}
                              @endif        
                          {!! $errors->first('tmp_lahir', '<p class="help-block">Wajib diisi!</p>') !!}
                        </div>
                        <div class="form-group col-md-3">
                           <label for="tgl_lahir">Tanggal Lahir</label>   
                              @if (empty($datkar->tgl_lahir))                     
                               {!! Form::date('tgl_lahir',null, ['class'=>'form-control', 'id'=>'tgl_lahir','style' => 'background-color:#fff;line-height: 15px;']) !!}
                              @else
                                {!! Form::date('tgl_lahir',$datkar->tgl_lahir, ['class'=>'form-control', 'id'=>'tgl_lahir','style' => 'background-color:#fff;line-height: 15px;']) !!}
                              @endif                   
                            {!! $errors->first('tgl_lahir', '<p class="help-block">Wajib diisi!</p>') !!}
                        </div>  
                        <div class="form-group col-md-3">
                          <label for="kelamin">Jenis Kelamin</label><br>
                            <input type="radio" name="kelamin" value="L" <?php if($datkar->kelamin == "L") echo 'checked="checked"'; ?>> Laki-laki &nbsp;
                            <input type="radio" name="kelamin" value="P" <?php if($datkar->kelamin == "P") echo 'checked="checked"'; ?>> Perempuan<br>
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
                          <label for="alamat_dom">Alamat</label><br>
                          @if (empty($alamatdom->desc_alam))                        
                               {!! Form::textarea('alamat_dom', null, ['class'=>'form-control', 'rows'=>'1', 'name'=>'alamat_dom' ,'placeholder'=>'Contoh : Jl. Burangrang III, no 215, Perumahan Harapan Indah', 'id'=>'alamat_dom']) !!}
                          @else
                             {!! Form::text('alamat_dom', $alamatdom->desc_alam , ['class'=>'form-control', 'name'=>'alamat_dom', 'id'=>'alamat_dom']) !!}
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
                          <label for="kelurahan_dom">Kelurahan</label>                        
                          @if (empty($alamatdom->kelurahan))
                           {!! Form::text('kelurahan_dom', null , ['class'=>'form-control', 'name'=>'kelurahan_dom', 'id'=>'kelurahan_dom']) !!}
                          @else
                           {!! Form::text('kelurahan_dom', $alamatdom->kelurahan , ['class'=>'form-control', 'name'=>'kelurahan_dom', 'id'=>'kelurahan_dom']) !!}
                          @endif 
                         
                           {!! $errors->first('kelurahan_dom', '<p class="help-block">Wajib diisi!</p>') !!}

                        </div>
                        <div class="form-group col-md-3">
                          <label for="kecamatan_dom">Kecamatan</label>                       
                          @if(empty($alamatdom->kecamatan))
                            {!! Form::text('kecamatan_dom', null , ['class'=>'form-control', 'name'=>'kecamatan_dom', 'id'=>'kecamatan_dom']) !!}
                          @else
                             {!! Form::text('kecamatan_dom', $alamatdom->kecamatan , ['class'=>'form-control', 'name'=>'kecamatan_dom', 'id'=>'kecamatan_dom']) !!}
                          @endif                       
                           {!! $errors->first('kecamatan_dom', '<p class="help-block">Wajib diisi!</p>') !!}
                        </div>
                        <div class="form-group col-md-4">
                          <label for="kota_dom">Kota</label>                       
                          @if(empty($alamatdom->kota))
                            {!! Form::text('kota_dom',null, ['class'=>'form-control', 'name'=>'kota_dom', 'id'=>'kota_dom']) !!}
                          @else
                            {!! Form::text('kota_dom',$alamatdom->kota, ['class'=>'form-control', 'name'=>'kota_dom', 'id'=>'kota_dom']) !!}
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
                        <label for="no_telp_hp_dom">Telepon / No Handphone</label>
                         @if(empty($alamatdom->kd_pos))
                            {!! Form::text('no_telp_hp_dom', null , ['class'=>'form-control', 'name'=>'no_telp_hp_dom', 'id'=>'no_telp_hp_dom']) !!}
                          @else
                            {!! Form::text('no_telp_hp_dom',$alamatdom->kd_pos, ['class'=>'form-control', 'name'=>'no_telp_hp_dom', 'id'=>'no_telp_hp_dom']) !!}
                          @endif                  
                        </div>
                      </div>                  
                   
                    <hr>
                    <div class="form-row">
                      <div class="form-group" style="padding-left:15px;">
                       <label for="alamat_domi">Tempat Tinggal Sesuai KTP</label> <br>
                       <a href="#" onClick="autoFill(); return false;" role="button">*Klik apabila Alamat KTP sama dengan alamat Domisili</a>
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
                        <i class="fa fa-btn fa-save" style="display: none;"></i> Submit
                        </button></p> 
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
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- Form -->      

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
                      <div class="float-right">
                        <a href="#modalForm" data-toggle="modal" data-href="{{url('laravel-crud-search-sort-ajax-modal-form/create_datpend/'.$seq_number)}}"
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
                    </div>
                    <!-- /.box-body -->
                  </div>                
              </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

      <!-- Data Penunjang -->  
      <div class="row">
        <div class="col-md-12">
          <div class="box">
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
                                      
                    <div class="form-row">
                    
                      <div class="form-group col-md-6">
                        {!! Form::label('InputBPJSkes', 'BPJS Kesehatan') !!}
                        {!! Form::text('bpjskes', null , ['class'=>'form-control', 'name'=>'bpjskes', 'id'=>'bpjskes', 'placeholder'=>'Nomor Kartu Peserta BPJS Kesehatan']) !!}
                         {!! $errors->first('bpjskes', '<p class="help-block">Wajib diisi!</p>') !!}
                         <span class="text-danger">{{ $errors->first('bpjskes') }}</span>
                       <!--   <input class="form-control" style="resize:vertical" accept=".jpg,.jpeg,.png" name="pict_gemba" type="file" id="pict_gemba"> -->
                        <input id="bpjskes_file" name="bpjskes_file" type="file" data-toggle="tooltip" data-placement="top" title="Upload">
                      </div>                        

                      <div class="form-group col-md-6">                        
                        {!! Form::label('InputBPJSket', 'BPJS Ketenagakerjaan') !!}
                        {!! Form::text('bpjsket', null , ['class'=>'form-control', 'name'=>'bpjsket', 'id'=>'bpjsket', 'placeholder'=>'Nomor Kartu Peserta BPJS Ketenagakerjaan']) !!}
                        {!! $errors->first('bpjsket', '<p class="help-block">Wajib diisi!</p>') !!}
                        <span class="text-danger">{{ $errors->first('bpjsket') }}</span>
                        <input id="bpjskes_file" name="upload-bpjskes" type="file" data-toggle="tooltip" data-placement="top" title="Upload">
                      </div
                      </div>
                    </div>

                    <div class="form-row">
                      <div class="form-group col-md-6">                       
                        {!! Form::label('InputNorek_mandiri', 'Rekening Bank Mandiri') !!}
                        {!! Form::text('rek_mandiri', null , ['class'=>'form-control', 'name'=>'rek_mandiri', 'id'=>'rek_mandiri', 'placeholder'=>'Nomor Rekening Bank Mandiri']) !!}
                        {!! $errors->first('rek_mandiri', '<p class="help-block">Wajib diisi!</p>') !!}
                         <span class="text-danger">{{ $errors->first('rek_mandiri') }}</span>
                          <input id="rek_mandiri_file" name="rek_mandiri_file" type="file" data-toggle="tooltip" data-placement="top" title="Upload">
                      </div
                      </div>
                    </div>
                    <br>

                    
                    <div class="form-row">
                      <div class="form-group col-md-3">
                        <label for="npwp">Sudah Pernah memiliki NPWP</label><br>                          
                          <input type="radio" name="npwp" id="have" value="have" > Ya &nbsp;
                          <input type="radio" name="npwp" id="not_have" value="not_have" > Tidak<br>
                      </div>
                      <div class="form-group col-md-3">
                        {!! Form::label('inputNPWP', 'Nomor Pokok Wajib Pajak (NPWP)', array('id'=>'inputNPWP')) !!}
                        {!! Form::text('no_npwp', null , ['class'=>'form-control', 'name'=>'no_npwp', 'id'=>'no_npwp', 'placeholder'=>'Nomor NPWP']) !!}
                        {!! $errors->first('no_npwp', '<p class="help-block">Wajib diisi!</p>') !!}
                      </div>
                    </div>  
                    <div class="col-md-6 col-md-offset-6">
                        <div class="alert alert-success-2" id="msg_div" style="display: none;">
                            <span id="res_message"></span>
                        </div>
                        <div class="alert alert-danger print-error-msg" style="display:none">
                          <ul></ul>
                      </div>
                    </div>
                   <hr>
                   <p style="text-align:center""> Pernyataan : "Registrasi ini saya buat dengan sebenar-benarnya, dan apabila dikemudian hari ternyata ada hal-hal yang bertentangan, maka saya bersedia dituntut sesuai dengan hukum yang berlaku dan status kekaryawanan saya dapat dibatalkan." <br> <input type="checkbox" name="disclaimer_datpendu" id="disclaimer_datpendu" value="">&nbsp; Setujui penyataan diatas<br>  <button type="submit" onclick="return confirm('Apakah data sudah benar? Anda tidak diperkenankan untuk merubah kembali.')" id="send_form" class="btn btn-primary" style="display: none;">                                    <i class="fa fa-btn fa-save"></i> Submit
                      </button> </p>   
                      <!-- <div class="form-group" style="padding-right:25px;"> 
                        <div class="col-md-6 col-md-offset-11">                     
                         
                        </div>
                      </div>   -->  
                                    
                   {!! Form::close() !!}
                </div>
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
                <div class="col-sm-12"> 
                        
                <table id="tblMarital" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width:2%;text-align:center;">Keluarga</th>
                            <th style="width:5%;text-align:center;">Nama</th>
                            <th style="width:10%;text-align:center;">Tempat/Tgl Lahir</th>
                            <th style="width:10%;text-align:center;">L/P</th>
                            <th style="width:10%;text-align:center;">Pendidikan</th>
                            <th style="width:5%;text-align:center;">Pekerjaan</th>
                            <th style="width:5%;text-align:center;">Marital</th>                           

                        </tr>
                    </thead>
                </table>
                <br>
                <br>
                <hr>
                    <div class="form-row">
                      <div class="form-group" style="padding-left:15px;">
                       <label for="alamat_domi">Tempat Tinggal Orang Tua</label>
                      </div>
                      <div class="form-group col-md-10">
                        <label for="alamat_dom">Alamat</label><br>
                        {!! Form::textarea('alamat_dom',null, ['class'=>'form-control', 'rows'=>'1', 'name'=>'alamat_dom' ,'placeholder'=>'Nama Jalan, Nomor rumah', 'id'=>'alamat_dom']) !!}
                        {!! $errors->first('alamat_dom', '<p class="help-block">Wajib diisi!</p>') !!}
                        <!-- <input type="text" class="form-control" id="alamat_dom" placeholder="Nama jalan, nomor rumah"> -->
                      </div>
                      <div class="form-group col-md-1">
                        <label for="rt_dom">RT</label>
                        <!-- <input type="text" class="form-control rt_dom" id="rt_dom"> -->
                        {!! Form::text('rt_dom', null , ['class'=>'form-control', 'name'=>'rt_dom', 'id'=>'rt_dom']) !!}
                        {!! $errors->first('rt_dom', '<p class="help-block">Wajib diisi!</p>') !!}

                      </div>
                      <div class="form-group col-md-1">
                        <label for="rw_dom">RW</label>
                        {!! Form::text('rw_dom',null , ['class'=>'form-control', 'name'=>'rw_dom', 'id'=>'rw_dom']) !!}
                        {!! $errors->first('rw_dom', '<p class="help-block">Wajib diisi!</p>') !!}
                      </div>
                    </div>

                    <div class="form-row">                   
                      <div class="form-group col-md-3">
                        <label for="kelurahan_dom">Kelurahan</label><!-- 
                        <input type="text" class="form-control kelurahan_dom" id="kelurahan_dom"> -->
                         {!! Form::text('kelurahan_dom', null , ['class'=>'form-control', 'name'=>'kelurahan_dom', 'id'=>'kelurahan_dom']) !!}
                         {!! $errors->first('kelurahan_dom', '<p class="help-block">Wajib diisi!</p>') !!}

                      </div>
                      <div class="form-group col-md-3">
                        <label for="kecamatan_dom">Kecamatan</label>
                         {!! Form::text('kecamatan_dom', null , ['class'=>'form-control', 'name'=>'kecamatan_dom', 'id'=>'kecamatan_dom']) !!}
                         {!! $errors->first('kecamatan_dom', '<p class="help-block">Wajib diisi!</p>') !!}
                      </div>
                      <div class="form-group col-md-4">
                        <label for="kota_dom">Kota</label>
                         {!! Form::text('kota_dom', null, ['class'=>'form-control', 'name'=>'kota_dom', 'id'=>'kota_dom']) !!}
                         {!! $errors->first('kota_dom', '<p class="help-block">Wajib diisi!</p>') !!}
                      </div>
                       <div class="form-group col-md-2">
                        <label for="kode_pos_dom">Kode Pos</label>
                         {!! Form::text('kode_pos_dom', null , ['class'=>'form-control', 'name'=>'kode_pos_dom', 'id'=>'kode_pos_dom']) !!}
                         {!! $errors->first('kode_pos_dom', '<p class="help-block">Wajib diisi!</p>') !!}
                      </div>
                    </div>                               
                  <hr>
                  <div class="form-row">
                    <div class="form-group" style="padding-left:15px;">
                     <label for="alamat_domi">Tempat Tinggal Mertua</label> <br>
                     
                    </div>
                    <div class="form-group col-md-10">
                      <label for="alamat_ktp">Alamat</label>
                      {!! Form::textarea('alamat_ktp', null, ['class'=>'form-control', 'name'=>'alamat_ktp', 'rows'=>'1',  'placeholder'=>'Nama Jalan, Nomor Rumah', 'id'=>'alamat_ktp']) !!}
                      {!! $errors->first('alamat_ktp', '<p class="help-block">Wajib diisi!</p>') !!}
                    </div>
                    <div class="form-group col-md-1">
                      <label for="rt_ktp">RT</label>
                       {!! Form::text('rt_ktp',null, ['class'=>'form-control', 'name'=>'rt_ktp', 'id'=>'rt_ktp']) !!}
                       {!! $errors->first('rt_ktp', '<p class="help-block">Wajib diisi!</p>') !!}
                    </div>
                    <div class="form-group col-md-1">
                      <label for="rw_ktp">RW</label>
                        {!! Form::text('rw_ktp', null , ['class'=>'form-control', 'name'=>'rw_ktp', 'id'=>'rw_ktp']) !!}
                         {!! $errors->first('rt_ktp', '<p class="help-block">Wajib diisi!</p>') !!}
                    </div>
                  </div>

                  <div class="form-row">
                  <hr>
                    <div class="form-group col-md-3">
                      {!! Form::label('kelurahan_ktp', 'Kelurahan') !!}
                      {!! Form::text('kelurahan_ktp',null, ['class'=>'form-control', 'name'=>'kelurahan_ktp', 'id'=>'kelurahan_ktp']) !!}
                       {!! $errors->first('rt_ktp', '<p class="help-block">Wajib diisi!</p>') !!}     
                    </div>
                    <div class="form-group col-md-3">  
                      {!! Form::label('kecamatan_ktp', 'Kecamatan') !!}                   
                      {!! Form::text('kecamatan_ktp', null , ['class'=>'form-control', 'name'=>'kecamatan_ktp', 'id'=>'kecamatan_ktp']) !!}
                        {!! $errors->first('kecamatan_ktp', '<p class="help-block">Wajib diisi!</p>') !!}
                    </div>
                    <div class="form-group col-md-4">
                      <label for="kota_ktp">Kota</label>
                      {!! Form::text('kota_ktp', null , ['class'=>'form-control', 'name'=>'kota_ktp', 'id'=>'kota_ktp']) !!}
                       {!! $errors->first('kota_ktp', '<p class="help-block">Wajib diisi!</p>') !!}
                    </div>

                    <div class="form-group col-md-2">
                        {!! Form::label('kode_pos_ktp', 'Kode Pos') !!}

                        @if (empty($alamatktp->kd_pos))
                          {!! Form::text('kode_pos_ktp', null , ['class'=>'form-control', 'name'=>'kode_pos_ktp', 'id'=>'kode_pos_ktp']) !!}
                        @else
                           {!! Form::text('kode_pos_ktp', $alamatktp->kd_pos , ['class'=>'form-control', 'name'=>'kode_pos_ktp', 'id'=>'kode_pos_ktp']) !!}
                        @endif
                       
                         {!! $errors->first('kode_pos_ktp', '<p class="help-block">Wajib diisi!</p>') !!}
                      </div>
                  </div>                     
                
                <hr>
                <div class="form-group" style="padding-right:50px;">
                    <div class="col-md-10 col-md-offset-8">
                      <p><i class="fa fa-info-circle "> Apabila ada perubahan alamat akan segera saya informasikan</i></p>                      
                    </div>
                     <p style="text-align:center;">Pernyataan : "Registrasi ini saya buat dengan sebenar-benarnya, dan apabila dikemudian hari ternyata ada hal-hal yang bertentangan, maka saya bersedia dituntut sesuai dengan hukum yang berlaku dan status kekaryawanan saya dapat dibatalkan." <br><input type="checkbox" name="disclaimer_datalmtklrg" id="disclaimer_datalmtklrg" value="">  Setujui penyataan diatas <br> <button class="btn btn-primary confirm" onclick="return confirm('Apakah data sudah benar? Anda tidak diperkenankan untuk merubah kembali.')" type="submit" id="submit_almtklrg" name="submit_almtklrg" style="display: none;">
                      <i class="fa fa-btn fa-save"></i> Submit
                      </button></p> 
                  </div> 
                 
                 <!--  <div class="form-group" style="padding-right:15px;">                  
                    <div class="col-md-10 col-md-offset-10">
                      
                      
                    </div>
                  </div>  -->
                </div>
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