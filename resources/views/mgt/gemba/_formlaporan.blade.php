<div class="box-body form-horizontal">
  <div class="form-group">
    <div class="col-sm-2 {{ $errors->has('tgl_awal') ? ' has-error' : '' }}">
      {!! Form::label('tgl_awal', 'Tanggal Awal (*)') !!}
      {!! Form::date('tgl_awal', \Carbon\Carbon::now()->startOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Awal', 'required']) !!}
      {!! $errors->first('tgl_awal', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('tgl_akhir') ? ' has-error' : '' }}">
      {!! Form::label('tgl_akhir', 'Tanggal Akhir (*)') !!}
      {!! Form::date('tgl_akhir', \Carbon\Carbon::now()->endOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Akhir', 'required']) !!}
      {!! $errors->first('tgl_akhir', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('kd_site') ? ' has-error' : '' }}">
      {!! Form::label('kd_site', 'Site') !!}
      {!! Form::select('kd_site', ['IGPJ' => 'IGP - JAKARTA', 'IGPK' => 'IGP - KARAWANG'], null, ['class'=>'form-control select2']) !!}
      {!! $errors->first('kd_site', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-6 {{ $errors->has('npk_pic') ? ' has-error' : '' }}">
      {!! Form::label('npk_pic', 'PIC Genba') !!}
      {!! Form::select('npk_pic', \DB::table("mgmt_pics")->selectRaw("npk, npk||' - '||coalesce((select coalesce(v.initial, split_part(v.nama,' ',1)) from v_mas_karyawan v where v.npk = mgmt_pics.npk limit 1),'-') initial")->where('st_aktif', 'T')->where('st_bod', 'T')->orderBy('npk')->pluck('initial','npk')->all(), null, ['class'=>'form-control select2', 'placeholder' => 'ALL']) !!}
      {!! $errors->first('npk_pic', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
</div>
<!-- /.box-body -->

<div class="box-footer">
  <button id='btnprint' type='button' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Print Laporan Genba BOD' onclick='printLaporanGemba()'>
    <span class='glyphicon glyphicon-print'></span> Print Laporan Genba BOD
  </button>
  &nbsp;&nbsp;
  <p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

@section('scripts')
<script type="text/javascript">
  document.getElementById("tgl_awal").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  function printLaporanGemba()
  {
    var tgl_awal = document.getElementById("tgl_awal").value;
    var tgl_akhir = document.getElementById("tgl_akhir").value;
    if(tgl_awal == "" || tgl_akhir == "") {
      swal("Tgl Awal & Akhir tidak boleh kosong!", "Perhatikan inputan anda!", "error");
    } else {
      var msg = 'Anda yakin print data ini?';
      var txt = '';
      //additional input validations can be done hear
      swal({
        title: msg,
        text: txt,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, print it!',
        cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
        allowOutsideClick: true,
        allowEscapeKey: true,
        allowEnterKey: true,
        reverseButtons: false,
        focusCancel: true,
      }).then(function () {
        var kd_site = document.getElementById("kd_site").value;
        if(kd_site == "") {
          kd_site = "-";
        }
        var npk_pic = document.getElementById("npk_pic").value;
        if(npk_pic == "") {
          npk_pic = "-";
        }
        var urlRedirect = "{{ route('mgmtgembas.printlaporan', ['param','param2','param3','param4']) }}";
        urlRedirect = urlRedirect.replace('param4', window.btoa(npk_pic));
        urlRedirect = urlRedirect.replace('param3', window.btoa(kd_site));
        urlRedirect = urlRedirect.replace('param2', window.btoa(tgl_akhir));
        urlRedirect = urlRedirect.replace('param', window.btoa(tgl_awal));
        // window.location.href = urlRedirect;
        window.open(urlRedirect, '_blank');
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
    }
  }

  $(document).ready(function(){

  });
</script>
@endsection
