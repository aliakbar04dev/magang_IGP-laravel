<div class="box-body ">
  <div class="col-md-6"> 
   <div class="form-group">
    <div class="col-md-8">
     {!! Form::label('no_ws', 'No Worksheet (*)') !!}
     {!! Form::text('no_ws', null, ['class'=>'form-control', 'placeholder' => 'No Worksheet', 'required', 'readonly' => '']) !!}
     {!! $errors->first('no_ws', '<p class="help-block">:message</p>') !!}			
   </div>    
 </div> 
 <div class="form-group">
  <div class="col-md-4">
   {!! Form::label('no_order', 'No Order (F9) (*)') !!}
   @if (isset($noOrder))     
   {!! Form::text('no_order', $noOrder, ['class'=>'form-control','placeholder' => 'No Order','onkeydown' => 'btnpopupNoOrderClick(event)', 'onchange' => 'validateNoOrder()','required', 'readonly' => '']) !!}
   @else
   {!! Form::text('no_order', null, ['class'=>'form-control','placeholder' => 'No Order','onkeydown' => 'btnpopupNoOrderClick(event)', 'onchange' => 'validateNoOrder()','required', 'readonly' => '']) !!} 
   @endif
   {!! $errors->first('no_order', '<p class="help-block">:message</p>') !!}			
 </div>	
 <div class="col-md-4">
  {!! Form::label('no_serti', 'No Sertifikat') !!}     
  {!! Form::text('no_serti', null, ['class'=>'form-control', 'placeholder' => 'No Sertifikat', 'required', 'readonly' => '']) !!}      
  {!! $errors->first('no_serti', '<p class="help-block">:message</p>') !!}     
</div>  	
</div>
<div class="form-group">
  <div class="col-md-4">
    {!! Form::label('no_seri', 'No Seri') !!} 
    @if (isset($noSeri)) 
    {!! Form::text('no_seri', $noSeri, ['class'=>'form-control', 'placeholder' => 'No Seri', 'required', 'readonly' => '']) !!}
    @else    
    {!! Form::text('no_seri', null, ['class'=>'form-control', 'placeholder' => 'No Seri', 'required', 'readonly' => '']) !!}
    @endif      
    {!! $errors->first('no_seri', '<p class="help-block">:message</p>') !!}     
  </div>
  <div class="col-md-8">
    {!! Form::label('nm_alat', 'Nama Alat') !!}
    {!! Form::text('nm_alat', null, ['class'=>'form-control', 'placeholder' => 'Nama Alat', 'readonly' => '']) !!}
    {!! $errors->first('nm_alat', '<p class="help-block">:message</p>') !!}     
  </div>    
</div>
<div class="form-group">
  <div class="col-md-4">
    {!! Form::label('nm_type', 'Tipe') !!}
    {!! Form::text('nm_type', null, ['class'=>'form-control', 'placeholder' => 'Tipe', 'readonly' => '']) !!}
    {!! $errors->first('nm_type', '<p class="help-block">:message</p>') !!}     
  </div>
  <div class="col-md-4">
    {!! Form::label('nm_merk', 'Merk') !!}
    {!! Form::text('nm_merk', null, ['class'=>'form-control', 'placeholder' => 'Merk', 'readonly' => '']) !!}
    {!! $errors->first('nm_merk', '<p class="help-block">:message</p>') !!}     
  </div>    
</div>
<div class="form-group">
  <div class="col-md-4">
    {!! Form::label('rentang_ukur', 'Rentang Ukur') !!}
    {!! Form::text('rentang_ukur', null, ['class'=>'form-control', 'placeholder' => 'Rentang Ukur', 'readonly' => '']) !!}
    {!! $errors->first('rentang_ukur', '<p class="help-block">:message</p>') !!}     
  </div>
  <div class="col-md-4">
    {!! Form::label('resolusi', 'Resolusi') !!}
    {!! Form::text('resolusi', null, ['class'=>'form-control', 'placeholder' => 'Resolusi', 'readonly' => '']) !!}
    {!! $errors->first('resolusi', '<p class="help-block">:message</p>') !!} 
  </div>
</div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <div class="col-md-4">
      {!! Form::label('tgl_terima', 'Tanggal Terima') !!}
      @if (isset($tglTerima))
      {!! Form::date('tgl_terima', \Carbon\Carbon::parse($tglTerima), ['class'=>'form-control']) !!}
      @else
      @if (empty($mcalworksheet->tgl_terima))
      {!! Form::date('tgl_terima', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => \Carbon\Carbon::now()]) !!}
      @else
      {!! Form::date('tgl_terima', \Carbon\Carbon::parse($mcalworksheet->tgl_terima), ['class'=>'form-control']) !!}
      @endif
      @endif
      {!! $errors->first('tgl_terima', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-md-4">
     {!! Form::label('tgl_kalibrasi', 'Tanggal Kalibrasi') !!}     
     @if (empty($mcalworksheet->tgl_kalibrasi))
     {!! Form::date('tgl_kalibrasi', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => \Carbon\Carbon::now()]) !!}
     @else
     {!! Form::date('tgl_kalibrasi', \Carbon\Carbon::parse($mcalworksheet->tgl_kalibrasi), ['class'=>'form-control']) !!}
     @endif
     {!! $errors->first('tgl_kalibrasi', '<p class="help-block">:message</p>') !!}
   </div>    
 </div> 
 <div class="form-group">
  <div class="col-md-6">
    {!! Form::label('no_seri_kal', 'No Seri Kalibrator (F9) (*)') !!}
    <div class="input-group">       
      {!! Form::text('no_seri_kal', null, ['class'=>'form-control', 'placeholder' => 'No Seri','onkeydown' => 'btnpopupNoKalibratorClick(event)', 'onchange' => 'validateNoKalibrator()', 'readonly', 'required']) !!}  
      <span class="input-group-btn">
        <button id="btnpopupNoKalibrator" type="button" class="btn btn-info" data-toggle="modal" data-target="#nokalibratorModal">
          <label class="glyphicon glyphicon-search"></label>
        </button>
      </span> 
    </div>   
    {!! $errors->first('no_seri_kal', '<p class="help-block">:message</p>') !!}     
  </div>  
  <div class="col-md-4">
    {!! Form::label('jenis_ruang', 'Ruangan') !!}
    {!! Form::select('jenis_ruang', ['TH01' => 'TH01', 'TH02' => 'TH02', 'TH03' => 'TH03'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Ruangan', 'required', 'id' => 'jenis_ruang', 'onchange' => 'validateNoRuang();validateSuhu();validateHumi()']) !!}   
  </div>     
</div>
<div class="form-group">
  <div class="col-md-6">
   {!! Form::label('no_kalibrator', 'Sertifikat Kalibrator') !!} 
   {!! Form::text('no_kalibrator', null, ['class'=>'form-control','placeholder' => 'Kalibrator', 'readonly']) !!}    
   {!! $errors->first('no_kalibrator', '<p class="help-block">:message</p>') !!}     
 </div>
 <div class="col-md-6">
   {!! Form::label('no_temphumi', 'Sertifikat Suhu & Kelembapan') !!} 
   {!! Form::text('no_temphumi', null, ['class'=>'form-control','placeholder' => 'Sertifikat Suhu & kelembapan', 'readonly']) !!}    
   {!! $errors->first('no_temphumi', '<p class="help-block">:message</p>') !!}     
 </div>      
</div>
<div class="form-group">
  <div class="col-md-6">
    {!! Form::label('nm_alat_kal', 'Nama Alat Kalibrator') !!}
    {!! Form::text('nm_alat_kal', null, ['class'=>'form-control', 'placeholder' => 'Nama Alat', 'readonly' => '']) !!}
    {!! $errors->first('nm_alat_kal', '<p class="help-block">:message</p>') !!}     
  </div> 
  <div class="col-md-3">
    {!! Form::label('nm_merk_kal', 'Merk') !!}
    {!! Form::text('nm_merk_kal', null, ['class'=>'form-control', 'placeholder' => 'Merk', 'readonly' => '']) !!}
    {!! $errors->first('nm_merk_kal', '<p class="help-block">:message</p>') !!}     
  </div>
  <div class="col-md-3">
    {!! Form::label('nm_type_kal', 'Tipe') !!}
    {!! Form::text('nm_type_kal', null, ['class'=>'form-control', 'placeholder' => 'Tipe', 'readonly' => '']) !!}
    {!! $errors->first('nm_type_kal', '<p class="help-block">:message</p>') !!}     
  </div>   
</div>
<div class="form-group">
  <div class="col-md-6">
    {!! Form::label('rentang_ukur_kal', 'Rentang Ukur Kalibrator') !!}
    {!! Form::text('rentang_ukur_kal', null, ['class'=>'form-control', 'placeholder' => 'Rentang Ukur', 'readonly' => '']) !!}
    {!! $errors->first('rentang_ukur_kal', '<p class="help-block">:message</p>') !!}     
  </div>
  <div class="col-md-6">
    {!! Form::label('resolusi_kal', 'Resolusi Kalibrator') !!}
    {!! Form::text('resolusi_kal', null, ['class'=>'form-control', 'placeholder' => 'Resolusi', 'readonly' => '']) !!}
    {!! $errors->first('resolusi_kal', '<p class="help-block">:message</p>') !!} 
  </div>
</div>
</div>
<div class="col-md-6"> 
  <div class="form-group">
    <div class="col-md-4">
      {!! Form::label('suhu_awal', 'Suhu Awal') !!}
      {!! Form::text('suhu_awal', null, ['class'=>'form-control', 'placeholder' => 'Suhu Awal', 'required', 'onchange' => 'validateSuhu()']) !!}
      {!! $errors->first('suhu_awal', '<p class="help-block">:message</p>') !!}     
    </div>
    <div class="col-md-4">
      {!! Form::label('suhu_akhir', 'Suhu Akhir') !!}
      {!! Form::text('suhu_akhir', null, ['class'=>'form-control', 'placeholder' => 'Suhu Akhir', 'required', 'onchange' => 'validateSuhu()']) !!}
      {!! $errors->first('suhu_akhir', '<p class="help-block">:message</p>') !!} 
    </div>
    <div class="col-md-4">
      {!! Form::label('suhu_rata', 'Suhu Rata-Rata') !!}
      {!! Form::text('suhu_rata', null, ['class'=>'form-control', 'placeholder' => 'Suhu Rata-Rata', 'readonly']) !!}
      {!! $errors->first('suhu_rata', '<p class="help-block">:message</p>') !!} 
    </div>
  </div>
</div>
<div class="col-md-6"> 
  <div class="form-group">
    <div class="col-md-4">
      {!! Form::label('humi_awal', 'Humi Awal') !!}
      {!! Form::text('humi_awal', null, ['class'=>'form-control', 'placeholder' => 'Humi Awal', 'required', 'onchange' => 'validateHumi()']) !!}
      {!! $errors->first('humi_awal', '<p class="help-block">:message</p>') !!}     
    </div>
    <div class="col-md-4">
      {!! Form::label('humi_akhir', 'Humi Akhir') !!}
      {!! Form::text('humi_akhir', null, ['class'=>'form-control', 'placeholder' => 'Humi Akhir', 'required', 'onchange' => 'validateHumi()']) !!}
      {!! $errors->first('humi_akhir', '<p class="help-block">:message</p>') !!} 
    </div>
    <div class="col-md-4">
      {!! Form::label('humi_rata', 'Humi Rata-Rata') !!}
      {!! Form::text('humi_rata', null, ['class'=>'form-control', 'placeholder' => 'Humi Rata-Rata', 'readonly']) !!}
      {!! $errors->first('humi_rata', '<p class="help-block">:message</p>') !!} 
    </div>
  </div>
</div>
<div class="form-group">
  <div class="col-md-12">
    <div class="col-md-6">
      {!! Form::label('cek_kondisi', 'Kondisi Alat (Bebas karat, bebas cacat, & skala dapat dibaca)') !!}     
      {!! Form::text('cek_kondisi', null, ['class'=>'form-control', 'placeholder' => 'Kondisi Alat', 'maxlength'=>'100', 'required']) !!}    
      {!! $errors->first('cek_kondisi', '<p class="help-block">:message</p>') !!}     
    </div>
    <div class="col-md-6">
      {!! Form::label('cek_lengkap', 'Kelangkapan Alat (Lengkap)') !!}     
      {!! Form::text('cek_lengkap', null, ['class'=>'form-control', 'placeholder' => 'Kelangkapan Alat', 'maxlength'=>'100', 'required']) !!}  
      {!! $errors->first('cek_kelengkapan', '<p class="help-block">:message</p>') !!}     
    </div>
  </div>
</div>
<div class="form-group">
  <div class="col-md-12">
    <div class="col-md-6">
      {!! Form::label('cek_fungsi', 'Fungsi Alat (Bergerak lancar maju & mundur 3-5 kali)') !!}     
      {!! Form::text('cek_fungsi', null, ['class'=>'form-control', 'placeholder' => 'Fungsi Alat', 'maxlength'=>'100', 'required']) !!}     
      {!! $errors->first('cek_fungsi', '<p class="help-block">:message</p>') !!}   
    </div>
    <div class="col-md-3">
      {!! Form::label('sat_ins', 'Satuan') !!}     
      {!! Form::text('sat_ins', null, ['class'=>'form-control', 'placeholder' => 'Satuan', 'maxlength'=>'20', 'required']) !!}     
      {!! $errors->first('sat_ins', '<p class="help-block">:message</p>') !!}   
    </div>
    <div class="col-md-3">
      {!! Form::label('sat_cor', 'Satuan Koreksi') !!}     
      {!! Form::text('sat_cor', null, ['class'=>'form-control', 'placeholder' => 'Satuan Koreksi', 'maxlength'=>'20', 'required']) !!}     
      {!! $errors->first('sat_cor', '<p class="help-block">:message</p>') !!}   
    </div>
  </div>
</div>
<div class="form-group">
  <div class="col-md-12">
    <div class="col-md-2">
      {!! Form::label('repeat1', 'Repeatability 1') !!}     
      {!! Form::text('repeat1', null, ['class'=>'form-control', 'placeholder' => '0', 'maxlength'=>'7']) !!}     
      {!! $errors->first('repeat1', '<p class="help-block">:message</p>') !!}   
    </div>
    <div class="col-md-2">
      {!! Form::label('repeat2', 'Repeatability 2') !!}     
      {!! Form::text('repeat2', null, ['class'=>'form-control', 'placeholder' => '0', 'maxlength'=>'7']) !!}     
      {!! $errors->first('repeat2', '<p class="help-block">:message</p>') !!}   
    </div>
    <div class="col-md-2">
      {!! Form::label('repeat3', 'Repeatability 3') !!}     
      {!! Form::text('repeat3', null, ['class'=>'form-control', 'placeholder' => '0', 'maxlength'=>'7']) !!}     
      {!! $errors->first('repeat3', '<p class="help-block">:message</p>') !!}   
    </div>
    <div class="col-md-2">
      {!! Form::label('repeat4', 'Repeatability 4') !!}     
      {!! Form::text('repeat4', null, ['class'=>'form-control', 'placeholder' => '0', 'maxlength'=>'7']) !!}     
      {!! $errors->first('repeat4', '<p class="help-block">:message</p>') !!}   
    </div>
    <div class="col-md-2">
      {!! Form::label('repeat5', 'Repeatability 5') !!}     
      {!! Form::text('repeat5', null, ['class'=>'form-control', 'placeholder' => '0', 'maxlength'=>'7']) !!}     
      {!! $errors->first('repeat5', '<p class="help-block">:message</p>') !!}   
    </div>
  </div>
</div>
<div class="form-group">
  <div class="col-md-12">
    <div class="col-md-2">
      {!! Form::label('repeat6', 'Repeatability 6') !!}     
      {!! Form::text('repeat6', null, ['class'=>'form-control', 'placeholder' => '0', 'maxlength'=>'7']) !!}     
      {!! $errors->first('repeat6', '<p class="help-block">:message</p>') !!}   
    </div>
    <div class="col-md-2">
      {!! Form::label('repeat7', 'Repeatability 7') !!}     
      {!! Form::text('repeat7', null, ['class'=>'form-control', 'placeholder' => '0', 'maxlength'=>'7']) !!}     
      {!! $errors->first('repeat7', '<p class="help-block">:message</p>') !!}   
    </div>
    <div class="col-md-2">
      {!! Form::label('repeat8', 'Repeatability 8') !!}     
      {!! Form::text('repeat8', null, ['class'=>'form-control', 'placeholder' => '0', 'maxlength'=>'7']) !!}     
      {!! $errors->first('repeat8', '<p class="help-block">:message</p>') !!}   
    </div>
    <div class="col-md-2">
      {!! Form::label('repeat9', 'Repeatability 9') !!}     
      {!! Form::text('repeat9', null, ['class'=>'form-control', 'placeholder' => '0', 'maxlength'=>'7']) !!}     
      {!! $errors->first('repeat9', '<p class="help-block">:message</p>') !!}   
    </div>
    <div class="col-md-2">
      {!! Form::label('repeat10', 'Repeatability 10') !!}     
      {!! Form::text('repeat10', null, ['class'=>'form-control', 'placeholder' => '0', 'maxlength'=>'7']) !!}     
      {!! $errors->first('repeat10', '<p class="help-block">:message</p>') !!}   
    </div>
  </div>
</div>
<div class="form-group">
  <div class="col-md-12">
    <div class="col-md-2">
      {!! Form::label('wide_range', 'Wide Range') !!}     
      {!! Form::text('wide_range', null, ['class'=>'form-control', 'placeholder' => '0', 'readonly']) !!}     
      {!! $errors->first('wide_range', '<p class="help-block">:message</p>') !!}   
    </div>
    <div class="col-md-2">
      {!! Form::label('adj_error', 'Adjacent Error') !!}     
      {!! Form::text('adj_error', null, ['class'=>'form-control', 'placeholder' => '0', 'readonly']) !!}     
      {!! $errors->first('adj_error', '<p class="help-block">:message</p>') !!}   
    </div>
    <div class="col-md-2">
      {!! Form::label('ketidakpastian', 'Uncertainty') !!}     
      {!! Form::text('ketidakpastian', null, ['class'=>'form-control', 'placeholder' => '0', 'readonly']) !!}     
      {!! $errors->first('ketidakpastian', '<p class="help-block">:message</p>') !!}   
    </div>
    <div class="col-md-6">
      {!! Form::label('catatan', 'Catatan') !!}     
      {!! Form::text('catatan', null, ['class'=>'form-control', 'placeholder' => 'catatan', 'maxlength'=>'300']) !!}     
      {!! $errors->first('catatan', '<p class="help-block">:message</p>') !!}   
    </div>
  </div>
</div>
<div class="form-group">
  <div class="col-md-12">
    <div class="col-md-4">
      {!! Form::label('approve_by', 'PIC Submit') !!}     
      @if (empty($mcalworksheet->approve_by))     
      {!! Form::text('approve_by', null, ['class'=>'form-control', 'readonly']) !!} 
      @else    
      {!! Form::text('approve_by', $model->getNamaKaryawan($mcalworksheet->approve_by), ['class'=>'form-control', 'readonly']) !!} 
      @endif   
      {!! $errors->first('approve_by', '<p class="help-block">:message</p>') !!}   
    </div>
    <div class="col-md-2">
      {!! Form::label('dt_approve', 'Tanggal Submit') !!}
      @if (empty($mcalworksheet->dt_approve))
      {!! Form::text('dt_approve', null, ['class'=>'form-control', 'readonly']) !!}
      @else
      {!! Form::text('dt_approve', \Carbon\Carbon::parse($mcalworksheet->dt_approve), ['class'=>'form-control', 'readonly']) !!}
      @endif
      {!! $errors->first('tgl_terima', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-md-6">
      {!! Form::label('nm_file', 'Lampiran (pdf)') !!}
      @if (!empty($mcalworksheet->nm_file))
      {!! Form::file('nm_file', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.pdf']) !!}
      <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('kalworksheet.deletefile', base64_encode($mcalworksheet->no_ws)) }}"><span class="glyphicon glyphicon-remove"></span></a>
      <u>
        <a data-toggle="tooltip" data-placement="top" title="Download File" href="{{ $file_lampiran }}" download>Download File</a>
      </u>      
      @else
      {!! Form::file('nm_file', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.pdf']) !!}
      @endif
      {!! $errors->first('nm_file', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
</div>       
<!-- /.form-group -->
<div class="form-group">
  <div class="col-md-4">
   <p class="help-block">(*) tidak boleh kosong</p>
   {!! Form::hidden('jml_tbl_detail', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_tbl_detail']) !!}  
 </div>
</div>
</div>

<div class="box-body">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Detail Titik Ukur</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">            
          <table id="tblDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="width: 2%;">No</th>
                <th style="width: 10%;">Titik Ukur</th>
                <th style="width: 10%;">Arah Naik</th>                
                <th style="width: 10%;">Koreksi Naik</th>
                <th style="width: 10%;">Arah Turun</th>
                <th style="width: 10%;">Koreksi Turun</th>
                <th style="width: 48%;"></th>
              </tr>
            </thead>
            <tbody>
              @if (!empty($mcalworksheetDet)) 
              @foreach ($mcalworksheetDet->get() as $data)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td><input type='hidden' value="row-{{ $loop->iteration }}-titik_ukur"><input type='text' id="row-{{ $loop->iteration }}-titik_ukur" name="row-{{ $loop->iteration }}-titik_ukur" value='{{ $data->titik_ukur }}' size='20' maxlength='10' style='background: #eee' readonly><input type='hidden' id="row-{{ $loop->iteration }}-id" name="row-{{ $loop->iteration }}-id" value='0' readonly='readonly'></td>
                <td><input type='text' id="row-{{ $loop->iteration }}-arah_naik" name="row-{{ $loop->iteration }}-arah_naik" value='{{ $data->arah_naik }}' size='20' maxlength='10' onchange='validateKoreksiNaik(event)'></td>
                <td><input type='text' id="row-{{ $loop->iteration }}-koreksi_naik" name="row-{{ $loop->iteration }}-koreksi_naik" value='{{ $data->koreksi_naik }}' size='20' style='background: #eee' readonly></td>
                <td><input type='text' id="row-{{ $loop->iteration }}-arah_turun" name="row-{{ $loop->iteration }}-arah_turun" value='{{ $data->arah_turun }}' size='20' maxlength='10' onchange='validateKoreksiTurun(event)'></td>
                <td><input type='text' id="row-{{ $loop->iteration }}-koreksi_turun" name="row-{{ $loop->iteration }}-koreksi_turun" value='{{ $data->koreksi_turun }}' size='20' style='background: #eee' readonly></td>
                <td></td>
              </tr>
              @endforeach
              @endif               
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</div>

<!-- /.box-body -->
<div class="box-footer">
	{!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
	&nbsp;&nbsp;
  @if (!empty($mcalworksheet->no_ws))
  @if (empty($mcalworksheet->dt_approve))
  {!! Form::button('Delete', ['class'=>'btn btn-danger', 'id' => 'btn-delete']) !!}
  &nbsp;&nbsp;
  {!! Form::button('Submit', ['class'=>'btn btn-primary', 'id' => 'btn-approve']) !!}
  &nbsp;&nbsp;
  @endif
  {!! Form::button('Print', ['class'=>'btn btn-primary', 'id' => 'btn-print']) !!}
  &nbsp;&nbsp;
  @endif 
  <a class="btn btn-default" href="{{ route('kalworksheet.index') }}">Cancel</a>
</div>
<!-- Popup Modal -->
@include('eqa.kalworksheet.popup.nokalibratorModal')

@section('scripts')
<script type="text/javascript">

  function btnpopupNoKalibratorClick(e) {
    if(e.keyCode == 120) {
     $('#btnpopupNoKalibrator').click();
   }
 }

 document.getElementById("tgl_terima").focus();
  //Initialize Select2 Elements
  $(".select2").select2();

  $(document).ready(function(){
    $("#btnpopupNoKalibrator").click(function(){
      popupNoKalibartor();
    });

    $("#btn-delete").click(function(){
      var no_ws = document.getElementById("no_ws").value;
      if(no_ws !== "") {
       var msg = 'Anda yakin menghapus data ini?';
       var txt = 'Nomor Worksheet: ' + no_ws;
       swal({
        title: msg,
        text: txt,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, delete it!',
        cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
        allowOutsideClick: true,
        allowEscapeKey: true,
        allowEnterKey: true,
        reverseButtons: false,
        focusCancel: true,
      }).then(function () {
        var urlRedirect = "{{ route('kalworksheet.destroy', 'param') }}";
        urlRedirect = urlRedirect.replace('param', window.btoa(no_ws));
        window.location.href = urlRedirect;
      }, function (dismiss) {
        if (dismiss === 'cancel') {
        }
      })
    }
  });

    $("#btn-approve").click(function(){
      var no_ws = document.getElementById("no_ws").value;
      var param1 = document.getElementById("tgl_kalibrasi").value;
      var param2 = document.getElementById("no_order").value;
      var param3 = document.getElementById("no_seri").value;
      if(no_ws !== "") {
       var msg = 'Anda yakin submit data ini (generate sertifikat) ?';
       var txt = 'Nomor Worksheet: ' + no_ws;
       swal({
        title: msg,
        text: txt,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, Approve it!',
        cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
        allowOutsideClick: true,
        allowEscapeKey: true,
        allowEnterKey: true,
        reverseButtons: false,
        focusCancel: true,
      }).then(function () {
        var urlRedirect = "{{ route('kalworksheet.approvews', ['param','param1','param2','param3']) }}";
        urlRedirect = urlRedirect.replace('param', window.btoa(no_ws));
        urlRedirect = urlRedirect.replace('param1', window.btoa(param1));
        urlRedirect = urlRedirect.replace('param2', window.btoa(param2));
        urlRedirect = urlRedirect.replace('param3', window.btoa(param3));
        window.location.href = urlRedirect;
      }, function (dismiss) {
        if (dismiss === 'cancel') {
        }
      })
    }
  });

    $("#btn-print").click(function(){
      printPdf();
    });

    //MEMBUAT TABEL DETAIL
    var table = $('#tblDetail').DataTable({
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
        //responsive: true,
        'searching': false,
        "ordering": false,
        "scrollX": "true",
        "scrollY": "500px",
        "scrollCollapse": true,
        "paging": false
      });

    var counter = table.rows().count();
    document.getElementById("jml_tbl_detail").value = counter;

    $('#tblDetail tbody').on( 'click', 'tr', function () {
      if ( $(this).hasClass('selected') ) {
        $(this).removeClass('selected');    
      } else {
        table.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
            //untuk memunculkan gambar
            var row = table.row('.selected').index();  
          }
        });

    var no_ws = document.getElementById("no_ws").value.trim();
    if(no_ws !== ''){
      validateNoKalibrator();
      validateSuhu();
      validateHumi();
    } 

    var no_order = document.getElementById("no_order").value.trim(); 
    var no_seri = document.getElementById("no_seri").value.trim(); 
    if(no_order !== '' && no_seri !== ''){
      validateNoOrder();
    }

  });

  //VALIDASI No Order
  function validateNoOrder() {
   var kode = document.getElementById("no_order").value.trim();
   var no_seri = document.getElementById("no_seri").value.trim();    
   if(kode !== '') {
    var url = '{{ route('datatables.validasiNowdoWs', ['param','param1']) }}';
    url = url.replace('param', window.btoa(kode));
    url = url.replace('param1', window.btoa(no_seri));
          //use ajax to run the check
          $.get(url, function(result){  
          	if(result !== 'null'){
          		result = JSON.parse(result);
              document.getElementById("no_order").value = result["no_order"];
              document.getElementById("no_seri").value = result["no_seri"];
              document.getElementById("no_serti").value = result["no_serti"];
              document.getElementById("nm_alat").value = result["nm_alat"];
              document.getElementById("nm_type").value = result["nm_type"];
              document.getElementById("nm_merk").value = result["nm_merk"];
              document.getElementById("rentang_ukur").value = result["rentang_ukur"];
              document.getElementById("resolusi").value = result["resolusi"];              
            } else {
              document.getElementById("no_order").value = "";
              document.getElementById("no_seri").value = "";
              document.getElementById("no_serti").value = "";
              document.getElementById("nm_alat").value = "";
              document.getElementById("nm_type").value = "";
              document.getElementById("nm_merk").value = "";
              document.getElementById("rentang_ukur").value = "";
              document.getElementById("resolusi").value = "";
            }
          });
        } else {
         document.getElementById("no_order").value = "";
         document.getElementById("no_seri").value = "";
         document.getElementById("no_serti").value = "";
         document.getElementById("nm_alat").value = "";
         document.getElementById("nm_type").value = "";
         document.getElementById("nm_merk").value = "";
         document.getElementById("rentang_ukur").value = "";
         document.getElementById("resolusi").value = "";
       }   
     }

  //POPUP No Kalibrator
  function popupNoKalibartor() {
    var myHeading = "<p>Popup No Kalibrator</p>";
    $("#nokalibratorModalLabel").html(myHeading);

    var url = '{{ route('datatables.popupNoKalibrator') }}';
    var lookupNokalibrator = $('#lookupNokalibrator').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      "order": [[0, 'asc']],
      columns: [            
      { data: 'no_seri', name: 'no_seri'},
      { data: 'nama_alat', name: 'nama_alat'},
      { data: 'merk', name: 'merk'},
      { data: 'type', name: 'type'},
      { data: 'kapasitas', name: 'kapasitas'},
      { data: 'kecermatan', name: 'kecermatan'},
      { data: 'nomor', name: 'nomor'},
      { data: 'tanggal', name: 'tanggal'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        $('div.dataTables_filter input').focus();
        $('#lookupNokalibrator tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupNokalibrator.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("no_kalibrator").value = value["nomor"];
            $('#nokalibratorModal').modal('hide');
            validateNoKalibrator();
          });
        });
        $('#nokalibratorModal').on('hidden.bs.modal', function () {
          var kode = document.getElementById("no_kalibrator").value.trim();
          if(kode === '') {
            $('#no_kalibrator').focus();
          }
        });
      },
    });     
  }

  //VALIDASI No Kalibrator
  function validateNoKalibrator() {
   var kode = document.getElementById("no_kalibrator").value.trim();
   if(kode !== '') {
    var url = '{{ route('datatables.validasiNoKalibrator', 'param') }}';
    url = url.replace('param', window.btoa(kode));
            //use ajax to run the check
            $.get(url, function(result){  
              if(result !== 'null'){
                result = JSON.parse(result);
                document.getElementById("no_kalibrator").value = result["nomor"];
                document.getElementById("no_seri_kal").value = result["no_seri"];
                document.getElementById("nm_alat_kal").value = result["nama_alat"];
                document.getElementById("nm_merk_kal").value = result["merk"];
                document.getElementById("nm_type_kal").value = result["type"];
                document.getElementById("rentang_ukur_kal").value = result["kapasitas"];
                document.getElementById("resolusi_kal").value = result["kecermatan"];
              } else {
                document.getElementById("no_kalibrator").value = "";
                document.getElementById("no_seri_kal").value = "";
                document.getElementById("nm_alat_kal").value = "";
                document.getElementById("nm_merk_kal").value = "";
                document.getElementById("nm_type_kal").value = "";
                document.getElementById("rentang_ukur_kal").value = "";
                document.getElementById("resolusi_kal").value = "";
              }
            });
          } else {
           document.getElementById("no_kalibrator").value = "";
           document.getElementById("no_seri_kal").value = "";
           document.getElementById("nm_alat_kal").value = "";
           document.getElementById("nm_merk_kal").value = "";
           document.getElementById("nm_type_kal").value = "";
           document.getElementById("rentang_ukur_kal").value = "";
           document.getElementById("resolusi_kal").value = "";
         }   
       }

       function validateSuhu() {
         var suhu_awal = document.getElementById("suhu_awal").value.trim();
         var suhu_akhir = document.getElementById("suhu_akhir").value.trim();
         var no_temphumi = document.getElementById("no_temphumi").value.trim();   
         if(suhu_awal !== '' && suhu_akhir !== '' & no_temphumi !== '') {
          var url = '{{ route('datatables.validasiSuhu', ['param','param1','param2']) }}';
          url = url.replace('param', window.btoa(suhu_awal));
          url = url.replace('param1', window.btoa(suhu_akhir));
          url = url.replace('param2', window.btoa(no_temphumi));
            //use ajax to run the check
            $.get(url, function(result){  
              if(result !== 'null'){
                result = JSON.parse(result);
                var suhu_rata = result["suhu_rata"];
                var suhu_itpr = result["suhu_itpr"];
                if(suhu_itpr < 1 && suhu_itpr > 0){
                  document.getElementById("suhu_rata").value = suhu_rata+' ± 0'+suhu_itpr+' °C';
                } else if(suhu_itpr > -1 && suhu_itpr < 0){
                  suhu_itpr = suhu_itpr.replace('-', '');
                  document.getElementById("suhu_rata").value = suhu_rata+'-0'+suhu_itpr+' °C';  
                } else{
                  document.getElementById("suhu_rata").value = suhu_rata+' ± '+suhu_itpr+' °C';  
                }
              } else {
                document.getElementById("suhu_rata").value = "";
              }
            });
          } else {
           document.getElementById("suhu_rata").value = "";
         }   
       }

       function validateHumi() {
         var humi_awal = document.getElementById("humi_awal").value.trim();
         var humi_akhir = document.getElementById("humi_akhir").value.trim();
         var no_temphumi = document.getElementById("no_temphumi").value.trim();   
         if(humi_awal !== '' && humi_akhir !== '' & no_temphumi !== '') {
          var url = '{{ route('datatables.validasiHumi', ['param','param1','param2']) }}';
          url = url.replace('param', window.btoa(humi_awal));
          url = url.replace('param1', window.btoa(humi_akhir));
          url = url.replace('param2', window.btoa(no_temphumi));
        //use ajax to run the check
        $.get(url, function(result){  
          if(result !== 'null'){
            result = JSON.parse(result);
            var humi_rata = result["humi_rata"];
            var humi_itpr = result["humi_itpr"];
            if(humi_itpr < 1 && humi_itpr > 0){
              document.getElementById("humi_rata").value = humi_rata+' ± 0'+humi_itpr+' %';
            } else if(humi_itpr > -1 && humi_itpr < 0){
              humi_itpr = humi_itpr.replace('-', '');
              document.getElementById("humi_rata").value = humi_rata+'-0'+humi_itpr+' %';  
            } else{
              document.getElementById("humi_rata").value = humi_rata+' ± '+humi_itpr+' %';  
            }
          } else {
            document.getElementById("humi_rata").value = "";
          }
        });
      } else {
       document.getElementById("humi_rata").value = "";
     }   
   }

   function validateNoRuang() {
     var jenis_ruang = document.getElementById("jenis_ruang").value.trim();   
     if(jenis_ruang !== '') {
      var url = '{{ route('datatables.validasiNoRuang', 'param') }}';
      url = url.replace('param', window.btoa(jenis_ruang));
        //use ajax to run the check
        $.get(url, function(result){  
          if(result !== 'null'){
            result = JSON.parse(result);
            document.getElementById("no_temphumi").value = result["nomor"];
          } else {
            document.getElementById("no_temphumi").value = "";
          }
        });
      } else {
       document.getElementById("no_temphumi").value = "";
     }   
   }

   function validateKoreksiNaik(e){
    var no_kalibrator = document.getElementById("no_kalibrator").value.trim();
    var id = e.target.id.replace('arah_naik', '');
    var arah_naik = document.getElementById(e.target.id).value.trim();
    var titik_ukur = document.getElementById(id +'titik_ukur').value.trim();
    if(arah_naik === '') {
      document.getElementById(e.target.id).value = "";
      document.getElementById(id +'koreksi_naik').value = "";
    }else{
      var url = '{{ route('datatables.validasiKoreksi', ['param','param1','param2']) }}';
      url = url.replace('param', window.btoa(titik_ukur));
      url = url.replace('param1', window.btoa(arah_naik));
      url = url.replace('param2', window.btoa(no_kalibrator));
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          var koreksi_naik = result["koreksi_naik"];
          if(koreksi_naik < 1 && koreksi_naik > 0){
            document.getElementById(id +'koreksi_naik').value = '0'+koreksi_naik;
          } else if(koreksi_naik > -1 && koreksi_naik < 0){
            koreksi_naik = koreksi_naik.replace('-', '');
            document.getElementById(id +'koreksi_naik').value = '-0'+koreksi_naik;  
          } else{
            document.getElementById(id +'koreksi_naik').value = koreksi_naik;  
          }
        } else {
          document.getElementById(e.target.id).value = "";
          document.getElementById(id +'koreksi_naik').value = "";
          document.getElementById(e.target.id).focus();
          swal("Koreksi naik tidak valid!", "Perhatikan inputan anda!", "error");
        }
      });
    } 
  }

  function validateKoreksiTurun(e){
    var no_kalibrator = document.getElementById("no_kalibrator").value.trim();
    var id = e.target.id.replace('arah_turun', '');
    var arah_turun = document.getElementById(e.target.id).value.trim();
    var titik_ukur = document.getElementById(id +'titik_ukur').value.trim();
    if(arah_turun === '') {
      document.getElementById(e.target.id).value = "";
      document.getElementById(id +'koreksi_turun').value = "";
    }else{
      var url = '{{ route('datatables.validasiKoreksi', ['param','param1','param2']) }}';
      url = url.replace('param', window.btoa(titik_ukur));
      url = url.replace('param1', window.btoa(arah_turun));
      url = url.replace('param2', window.btoa(no_kalibrator));
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          var koreksi_turun = result["koreksi_turun"];
          if(koreksi_turun < 1 && koreksi_turun > 0){
            document.getElementById(id +'koreksi_turun').value = '0'+koreksi_turun;
          } else if(koreksi_turun > -1 && koreksi_turun < 0){
            koreksi_turun = koreksi_turun.replace('-', '');
            document.getElementById(id +'koreksi_turun').value = '-0'+koreksi_turun;  
          } else{
            document.getElementById(id +'koreksi_turun').value = koreksi_turun;  
          }
        } else {
          document.getElementById(e.target.id).value = "";
          document.getElementById(id +'koreksi_turun').value = "";
          document.getElementById(e.target.id).focus();
          swal("Koreksi turun tidak valid!", "Perhatikan inputan anda!", "error");
        }
      });
    } 
  }

  //CETAK DOKUMEN
  function printPdf(){
    var param = document.getElementById("no_ws").value.trim();

    var url = '{{ route('kalworksheet.print', ['param']) }}';
    url = url.replace('param', window.btoa(param));
    window.open(url);
  }

</script>
@endsection