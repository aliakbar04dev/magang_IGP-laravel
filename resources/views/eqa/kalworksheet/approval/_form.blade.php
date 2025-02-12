<div class="box-body ">
  <div class="col-md-6"> 
   <div class="form-group">
    <div class="col-md-8">
     {!! Form::label('no_ws', 'No Worksheet') !!}
     {!! Form::text('no_ws', null, ['class'=>'form-control', 'placeholder' => 'No Worksheet', 'required', 'readonly' => '']) !!}
     {!! $errors->first('no_ws', '<p class="help-block">:message</p>') !!}			
   </div>    
 </div> 
 <div class="form-group">
  <div class="col-md-4">
   {!! Form::label('no_order', 'No Order') !!}     
   {!! Form::text('no_order', null, ['class'=>'form-control','placeholder' => 'No Order', 'readonly' => '']) !!} 
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
      {!! Form::date('tgl_terima', \Carbon\Carbon::parse($mcalworksheet->tgl_terima), ['class'=>'form-control', 'readonly']) !!}
      {!! $errors->first('tgl_terima', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-md-4">
     {!! Form::label('tgl_kalibrasi', 'Tanggal Kalibrasi') !!}
     {!! Form::date('tgl_kalibrasi', \Carbon\Carbon::parse($mcalworksheet->tgl_kalibrasi), ['class'=>'form-control', 'readonly']) !!}
     {!! $errors->first('tgl_kalibrasi', '<p class="help-block">:message</p>') !!}
   </div>    
 </div> 
 <div class="form-group">
  <div class="col-md-6">
    {!! Form::label('no_seri_kal', 'No Seri Kalibrator') !!}
    {!! Form::text('no_seri_kal', null, ['class'=>'form-control', 'placeholder' => 'No Seri', 'readonly']) !!} 
    {!! $errors->first('no_seri_kal', '<p class="help-block">:message</p>') !!}     
  </div>  
  <div class="col-md-4">
    {!! Form::label('jenis_ruang', 'Ruangan') !!}
    {!! Form::select('jenis_ruang', ['TH01' => 'TH01', 'TH02' => 'TH02', 'TH03' => 'TH03'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Ruangan', 'required', 'id' => 'jenis_ruang', 'disabled']) !!}   
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
      {!! Form::text('suhu_awal', null, ['class'=>'form-control', 'placeholder' => 'Suhu Awal', 'required', 'readonly']) !!}
      {!! $errors->first('suhu_awal', '<p class="help-block">:message</p>') !!}     
    </div>
    <div class="col-md-4">
      {!! Form::label('suhu_akhir', 'Suhu Akhir') !!}
      {!! Form::text('suhu_akhir', null, ['class'=>'form-control', 'placeholder' => 'Suhu Akhir', 'required', 'readonly']) !!}
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
      {!! Form::text('humi_awal', null, ['class'=>'form-control', 'placeholder' => 'Humi Awal', 'required', 'readonly']) !!}
      {!! $errors->first('humi_awal', '<p class="help-block">:message</p>') !!}     
    </div>
    <div class="col-md-4">
      {!! Form::label('humi_akhir', 'Humi Akhir') !!}
      {!! Form::text('humi_akhir', null, ['class'=>'form-control', 'placeholder' => 'Humi Akhir', 'required', 'readonly']) !!}
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
      {!! Form::text('cek_kondisi', null, ['class'=>'form-control', 'placeholder' => 'Kondisi Alat', 'maxlength'=>'100', 'readonly']) !!}    
      {!! $errors->first('cek_kondisi', '<p class="help-block">:message</p>') !!}     
    </div>
    <div class="col-md-6">
      {!! Form::label('cek_lengkap', 'Kelangkapan Alat (Lengkap)') !!}     
      {!! Form::text('cek_lengkap', null, ['class'=>'form-control', 'placeholder' => 'Kelangkapan Alat', 'maxlength'=>'100', 'readonly']) !!}  
      {!! $errors->first('cek_kelengkapan', '<p class="help-block">:message</p>') !!}     
    </div>
  </div>
</div>
<div class="form-group">
  <div class="col-md-12">
    <div class="col-md-6">
      {!! Form::label('cek_fungsi', 'Fungsi Alat (Bergerak lancar maju & mundur 3-5 kali)') !!}     
      {!! Form::text('cek_fungsi', null, ['class'=>'form-control', 'placeholder' => 'Fungsi Alat', 'maxlength'=>'100', 'readonly']) !!}     
      {!! $errors->first('cek_fungsi', '<p class="help-block">:message</p>') !!}   
    </div>
    <div class="col-md-3">
      {!! Form::label('sat_ins', 'Satuan') !!}     
      {!! Form::text('sat_ins', null, ['class'=>'form-control', 'placeholder' => 'Satuan', 'maxlength'=>'20', 'readonly']) !!}     
      {!! $errors->first('sat_ins', '<p class="help-block">:message</p>') !!}   
    </div>
    <div class="col-md-3">
      {!! Form::label('sat_cor', 'Satuan Koreksi') !!}     
      {!! Form::text('sat_cor', null, ['class'=>'form-control', 'placeholder' => 'Satuan Koreksi', 'maxlength'=>'20', 'readonly']) !!}     
      {!! $errors->first('sat_cor', '<p class="help-block">:message</p>') !!}   
    </div>
  </div>
</div>
<div class="form-group">
  <div class="col-md-12">
    <div class="col-md-2">
      {!! Form::label('repeat1', 'Repeatability 1') !!}     
      {!! Form::text('repeat1', null, ['class'=>'form-control', 'placeholder' => '0', 'maxlength'=>'7', 'readonly']) !!}     
      {!! $errors->first('repeat1', '<p class="help-block">:message</p>') !!}   
    </div>
    <div class="col-md-2">
      {!! Form::label('repeat2', 'Repeatability 2') !!}     
      {!! Form::text('repeat2', null, ['class'=>'form-control', 'placeholder' => '0', 'maxlength'=>'7', 'readonly']) !!}     
      {!! $errors->first('repeat2', '<p class="help-block">:message</p>') !!}   
    </div>
    <div class="col-md-2">
      {!! Form::label('repeat3', 'Repeatability 3') !!}     
      {!! Form::text('repeat3', null, ['class'=>'form-control', 'placeholder' => '0', 'maxlength'=>'7', 'readonly']) !!}     
      {!! $errors->first('repeat3', '<p class="help-block">:message</p>') !!}   
    </div>
    <div class="col-md-2">
      {!! Form::label('repeat4', 'Repeatability 4') !!}     
      {!! Form::text('repeat4', null, ['class'=>'form-control', 'placeholder' => '0', 'maxlength'=>'7', 'readonly']) !!}     
      {!! $errors->first('repeat4', '<p class="help-block">:message</p>') !!}   
    </div>
    <div class="col-md-2">
      {!! Form::label('repeat5', 'Repeatability 5') !!}     
      {!! Form::text('repeat5', null, ['class'=>'form-control', 'placeholder' => '0', 'maxlength'=>'7', 'readonly']) !!}     
      {!! $errors->first('repeat5', '<p class="help-block">:message</p>') !!}   
    </div>
  </div>
</div>
<div class="form-group">
  <div class="col-md-12">
    <div class="col-md-2">
      {!! Form::label('repeat6', 'Repeatability 6') !!}     
      {!! Form::text('repeat6', null, ['class'=>'form-control', 'placeholder' => '0', 'maxlength'=>'7', 'readonly']) !!}     
      {!! $errors->first('repeat6', '<p class="help-block">:message</p>') !!}   
    </div>
    <div class="col-md-2">
      {!! Form::label('repeat7', 'Repeatability 7') !!}     
      {!! Form::text('repeat7', null, ['class'=>'form-control', 'placeholder' => '0', 'maxlength'=>'7', 'readonly']) !!}     
      {!! $errors->first('repeat7', '<p class="help-block">:message</p>') !!}   
    </div>
    <div class="col-md-2">
      {!! Form::label('repeat8', 'Repeatability 8') !!}     
      {!! Form::text('repeat8', null, ['class'=>'form-control', 'placeholder' => '0', 'maxlength'=>'7', 'readonly']) !!}     
      {!! $errors->first('repeat8', '<p class="help-block">:message</p>') !!}   
    </div>
    <div class="col-md-2">
      {!! Form::label('repeat9', 'Repeatability 9') !!}     
      {!! Form::text('repeat9', null, ['class'=>'form-control', 'placeholder' => '0', 'maxlength'=>'7', 'readonly']) !!}     
      {!! $errors->first('repeat9', '<p class="help-block">:message</p>') !!}   
    </div>
    <div class="col-md-2">
      {!! Form::label('repeat10', 'Repeatability 10') !!}     
      {!! Form::text('repeat10', null, ['class'=>'form-control', 'placeholder' => '0', 'maxlength'=>'7', 'readonly']) !!}     
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
    <div class="col-md-8">
      {!! Form::label('catatan', 'Catatan') !!}     
      {!! Form::text('catatan', null, ['class'=>'form-control', 'placeholder' => 'catatan', 'maxlength'=>'300', 'readonly']) !!}     
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
  </div>
</div>      
<!-- /.form-group -->
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
                <td>{{ $data->titik_ukur }}</td>
                <td>{{ $data->arah_naik }}</td>
                <td>{{ $data->koreksi_naik }}</td>
                <td>{{ $data->arah_turun }}</td>
                <td>{{ $data->koreksi_turun }}</td>
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
  @if (empty($mcalworksheet->dt_approve))
	{!! Form::button('Approve', ['class'=>'btn btn-primary', 'id' => 'btn-approve']) !!}
  @endif
	&nbsp;&nbsp;
  <a class="btn btn-default" href="{{ route('kalworksheet.indexws') }}">Cancel</a>
</div>
<!-- Popup Modal -->
@include('eqa.kalworksheet.popup.nokalibratorModal')

@section('scripts')
<script type="text/javascript">
  document.getElementById("tblDetail").focus();  

  $(document).ready(function(){
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
      validateNoOrder();
      validateNoKalibrator();      
    }

    $("#btn-approve").click(function(){
      var no_ws = document.getElementById("no_ws").value;
      var param1 = document.getElementById("tgl_kalibrasi").value;
      var param2 = document.getElementById("no_order").value;
      var param3 = document.getElementById("no_seri").value;
      if(no_ws !== "") {
       var msg = 'Anda yakin approve data ini?';
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

</script>
@endsection