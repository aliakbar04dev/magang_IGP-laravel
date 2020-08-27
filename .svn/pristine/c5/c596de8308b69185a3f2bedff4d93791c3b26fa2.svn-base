<div class="box-body">
  <div class="form-group"> 
    <div class="col-sm-3 {{ $errors->has('no_wo') ? ' has-error' : '' }}">
      {!! Form::label('no_wo', 'No. WO') !!}
      @if (empty($wos->no_wo))
        {!! Form::text('no_wo', null, ['class'=>'form-control','placeholder' => 'No. WO', 'disabled'=>'']) !!}
      @else
        {!! Form::text('no_wo2', $wos->no_wo, ['class'=>'form-control','placeholder' => 'No. WO', 'required', 'disabled'=>'']) !!}
        {!! Form::hidden('no_wo', null, ['class'=>'form-control','placeholder' => 'No. WO', 'required', 'readonly'=>'readonly']) !!}
      @endif
      {!! $errors->first('no_wo', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="col-sm-2 {{ $errors->has('tgl_wo') ? ' has-error' : '' }}">
      {!! Form::label('tgl_wo', 'Tanggal WO (*)') !!}
      @if (empty($wo->tgl_wo))
        {!! Form::date('tgl_wo', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl WO', 'required']) !!}
      @else
        {!! Form::date('tgl_wo', \Carbon\Carbon::parse($wo->tgl_wo), ['class'=>'form-control','placeholder' => 'Tgl WO', 'required', 'readonly'=>'readonly']) !!}
      @endif
      {!! $errors->first('tgl_wo', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('kd_pt') ? ' has-error' : '' }}">
      {!! Form::label('kd_pt', 'PT') !!}
      @if (empty($wo->kd_pt))
        {!! Form::select('kd_pt', ['IGP' => 'PT INTI GANDA PERDANA', 'WEP' => 'PT WAHANA EKA PARAMITRA'], null, ['class'=>'form-control select2']) !!}
      @else
        {!! Form::select('kd_pt', ['IGP' => 'PT INTI GANDA PERDANA', 'WEP' => 'PT WAHANA EKA PARAMITRA'], null, ['class'=>'form-control select2', 'disabled'=>'']) !!}
      @endif
      {!! $errors->first('kd_pt', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('ext') ? ' has-error' : '' }}">
      {!! Form::label('ext', 'EXT (*)') !!}
      {!! Form::number('ext', null, ['class'=>'form-control', 'placeholder' => 'Extention','required', 'maxlength'=>'5']) !!}
      {!! $errors->first('ext', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('jenis_orders') ? ' has-error' : '' }}">
      {!! Form::label('jenis_orders', 'Permintaan/Problem (*)') !!}
      {!! Form::select('jenis_orders',array('Internet/E-mail' => 'Internet/E-mail', 'Jaringan dan Peripheral' => 'Jaringan dan Peripheral', 'Login User/Hak Aplikasi' => 'Login User/Hak Aplikasi', 'Pembelian Hardware Baru' => 'Pembelian Hardware Baru', 'Program Aplikasi' => 'Program Aplikasi', 'Service Komputer dan Peripheral' => 'Service Komputer dan Peripheral','Service Printer/Scanner' => 'Service Printer/Scanner','Software Paket/Utility/Operating System' => 'Software Paket/Utility/Operating System'), null, ['class'=>'form-control select2', 'required',  'onchange' => 'detail()']) !!}
      {!! $errors->first('jenis_orders', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-3 {{ $errors->has('detail_orders') ? ' has-error' : '' }}">
      {!! Form::label('detail_orders', 'Detail Permintaan/Problem') !!}
      {!! Form::select('detail_orders',['-' => '-', 'Mutasi' => 'Mutasi', 'Penambahan' => 'Penambahan', 'Pengurangan' => 'Pengurangan', 'Modifikasi/Penambahan' => 'Modifikasi/Penambahan', 'Permintaan Data' => 'Permintaan Data', 'Program Baru' => 'Program Baru'],null, ['id' => 'detail_orders', 'class'=>'form-control select2', 'required']) !!}
      {!! $errors->first('detail_orders', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-3 {{ $errors->has('id_hw') ? ' has-error' : '' }}">
      {!! Form::label('id_hw', 'ID Hardware') !!}
      {!! Form::text('id_hw', null, ['class'=>'form-control', 'placeholder' => 'ID Hardware']) !!}
      {!! $errors->first('id_hw', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-9 {{ $errors->has('uraian') ? ' has-error' : '' }}">
      {!! Form::label('uraian', 'Penjelasan (*)') !!}
      {!! Form::textarea('uraian', null, ['class'=>'form-control', 'placeholder' => 'uraian', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical', 'required']) !!}
      {!! $errors->first('uraian', '<p class="help-block">:message</p>') !!}
    </div>
  </div>  
</div>
<div class="box-footer">
  {!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  &nbsp;&nbsp;
  @if (!empty($wo->no_wo))
    <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
    &nbsp;&nbsp;
  @endif
  <a class="btn btn-default" href="{{ route('wos.index') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
   detail2();
  });

  function detail(){
    var jenis_orders = document.getElementById("jenis_orders").value;
    if(jenis_orders === "Login User/Hak Aplikasi") {
      $("#detail_orders option[value='Mutasi']").removeAttr("disabled");
      $("#detail_orders option[value='Penambahan']").removeAttr("disabled");
      $("#detail_orders option[value='Pengurangan']").removeAttr("disabled");
      
      $("#detail_orders").val("Mutasi").select2();

      $("#detail_orders option[value='-']").attr("disabled","disabled");
      $("#detail_orders option[value='Modifikasi/Penambahan']").attr("disabled","disabled");
      $("#detail_orders option[value='Permintaan Data']").attr("disabled","disabled");
      $("#detail_orders option[value='Program Baru']").attr("disabled","disabled");


    } else if(jenis_orders === "Program Aplikasi") {   

      $("#detail_orders option[value='Modifikasi/Penambahan']").removeAttr("disabled");
      $("#detail_orders option[value='Permintaan Data']").removeAttr("disabled");
      $("#detail_orders option[value='Program Baru']").removeAttr("disabled");

      $("#detail_orders").val("Modifikasi/Penambahan").select2();

      $("#detail_orders option[value='-']").attr("disabled","disabled");
      $("#detail_orders option[value='Mutasi']").attr("disabled","disabled");
      $("#detail_orders option[value='Penambahan']").attr("disabled","disabled");
      $("#detail_orders option[value='Pengurangan']").attr("disabled","disabled");

    } else {
      $("#detail_orders option[value='-']").removeAttr("disabled");
      $("#detail_orders").val("-").select2();
      $("#detail_orders option[value='Modifikasi/Penambahan']").attr("disabled","disabled");
      $("#detail_orders option[value='Permintaan Data']").attr("disabled","disabled");
      $("#detail_orders option[value='Program Baru']").attr("disabled","disabled");
      $("#detail_orders option[value='Mutasi']").attr("disabled","disabled");
      $("#detail_orders option[value='Penambahan']").attr("disabled","disabled");
      $("#detail_orders option[value='Pengurangan']").attr("disabled","disabled");
    }
  }

  function detail2(){
    var jenis_orders = document.getElementById("jenis_orders").value;
    if(jenis_orders === "Login User/Hak Aplikasi") {
      $("#detail_orders option[value='-']").attr("disabled","disabled");
      $("#detail_orders option[value='Modifikasi/Penambahan']").attr("disabled","disabled");
      $("#detail_orders option[value='Permintaan Data']").attr("disabled","disabled");
      $("#detail_orders option[value='Program Baru']").attr("disabled","disabled");
    } else if(jenis_orders === "Program Aplikasi") {   
      $("#detail_orders option[value='-']").attr("disabled","disabled");
      $("#detail_orders option[value='Mutasi']").attr("disabled","disabled");
      $("#detail_orders option[value='Penambahan']").attr("disabled","disabled");
      $("#detail_orders option[value='Pengurangan']").attr("disabled","disabled");
    } else {
      $("#detail_orders option[value='Modifikasi/Penambahan']").attr("disabled","disabled");
      $("#detail_orders option[value='Permintaan Data']").attr("disabled","disabled");
      $("#detail_orders option[value='Program Baru']").attr("disabled","disabled");
      $("#detail_orders option[value='Mutasi']").attr("disabled","disabled");
      $("#detail_orders option[value='Penambahan']").attr("disabled","disabled");
      $("#detail_orders option[value='Pengurangan']").attr("disabled","disabled");
    }
  }

  $(".select2").select2();

  $("#btn-delete").click(function(){
    var no_wo = document.getElementById("no_wo").value.trim();
    var msg = 'Anda yakin menghapus No. WO: ' + no_wo + '?';
    var txt = '';
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
      var urlRedirect = "{{ route('wos.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_wo));
      window.location.href = urlRedirect;
    }, function (dismiss) {
      // dismiss can be 'cancel', 'overlay',
      // 'close', and 'timer'
      if (dismiss === 'cancel') {
        // swal(
        //   'Cancelled',
        //   'Your imaginary file is safe :)',
        //   'error'
        // )
      }
    })
  });

</script>
@endsection
