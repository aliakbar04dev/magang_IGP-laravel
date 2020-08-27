{!! Form::hidden('st_submit', null, ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'st_submit']) !!}
<div class="box-body">
  <div class="form-group">
    <div class="col-sm-2 {{ $errors->has('thn') ? ' has-error' : '' }}">
      {!! Form::label('thn', 'Year (*)') !!}
      <select id="thn" name="thn" class="form-control select2" onchange="updateRate()" required>
        @foreach ($years->get() as $year)
          @if (empty($bgttcrregis->id))
            <option value={{ $year->thn_period }} @if($loop->last) selected="selected" @endif>{{ $year->thn_period }}</option>
          @else 
            <option value={{ $year->thn_period }} @if($bgttcrregis->thn === $year->thn_period) selected="selected" @endif>{{ $year->thn_period }}</option>
          @endif
        @endforeach
      </select>
      {!! $errors->first('thn', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-10 {{ $errors->has('kd_dep') ? ' has-error' : '' }}">
      {!! Form::label('kd_dep', 'Department # Division (*)') !!}
      {!! Form::select('kd_dep',  $vw_dep_budgets->pluck('desc_dep','kd_dep')->all(), null, ['class' => 'form-control select2', 'placeholder' => 'Select Department # Division', 'required', 'id' => 'kd_dep']) !!}
      {!! $errors->first('kd_dep', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
	<div class="form-group">
		<div class="col-sm-12 {{ $errors->has('nm_aktivitas') ? ' has-error' : '' }}">
      {!! Form::label('nm_aktivitas', 'Activities Name (*)') !!}
      {!! Form::text('nm_aktivitas', null, ['class'=>'form-control','placeholder' => 'Activities Name', 'maxlength'=>'200', 'id' => 'nm_aktivitas', 'style' => 'text-transform:uppercase', 'required']) !!}
      {!! $errors->first('nm_aktivitas', '<p class="help-block">:message</p>') !!}
    </div>
	</div>
	<!-- /.form-group -->
	<div class="form-group">
    <div class="col-sm-6 {{ $errors->has('nm_klasifikasi') ? ' has-error' : '' }}">
      {!! Form::label('nm_klasifikasi', 'Classification (*)') !!}
      {!! Form::select('nm_klasifikasi',  App\BgttCrKlasifi::where('st_aktif', 'T')->orderBy('nm_klasifikasi')->pluck('nm_klasifikasi','nm_klasifikasi')->all(), null, ['class' => 'form-control select2', 'placeholder' => 'Select Classification', 'required', 'onchange' => 'changeKlasifikasi()', 'id' => 'nm_klasifikasi']) !!}
      {!! $errors->first('nm_klasifikasi', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-6 {{ $errors->has('nm_kategori') ? ' has-error' : '' }}">
      {!! Form::label('nm_kategori', 'Categories (*)') !!}
      @if (empty($bgttcrregis->id))
        {!! Form::select('nm_kategori', [], null, ['class' => 'form-control select2', 'placeholder' => 'Select Categories', 'required', 'id' => 'nm_kategori']) !!}
      @else
        {!! Form::select('nm_kategori', App\BgttCrKategor::where('st_aktif', 'T')->where('nm_klasifikasi', $bgttcrregis->nm_klasifikasi)->orderBy('nm_kategori')->pluck('nm_kategori','nm_kategori')->all(), null, ['class' => 'form-control select2', 'placeholder' => 'Select Categories', 'required', 'id' => 'nm_kategori']) !!}
      @endif
      {!! $errors->first('nm_kategori', '<p class="help-block">:message</p>') !!}
    </div>
	</div>
	<!-- /.form-group -->

  <div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title" id="boxtitle">Detail</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
      </button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body" id="field">
    <table id="tblDetail" class="table table-bordered table-striped" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th rowspan="2" style="width: 5%;text-align: center">No</th>
          <th rowspan="2">Bulan</th>
          <th colspan="2" style="width: 35%;text-align: center">Plan</th>
        </tr>
        <tr>
          <th style="width: 15%;text-align: right;">Man Power</th>
          <th style="width: 20%;text-align: right;">Amount</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th></th>
          <th></th>
          <th>
            <input type='text' id="row-jml-sum" name="row-jml-sum" class="form-control" style='text-align:right;' disabled="">
          </th>
          <th>
            <input type='text' id="row-amount-sum" name="row-amount-sum" class="form-control" style='text-align:right;' disabled="">
          </th>
        </tr>
      </tfoot>
      @if (!empty($bgttcrregis->id))
        @foreach($bgttcrregis->details()->orderBy("bulan")->get() as $detail)
          <tr>
            <td style="text-align: center;">{{ $loop->iteration }}</td>
            <td>{{ strtoupper(namaBulan((int) $detail->bulan)) }}</td>
            <td style="text-align: right;">
              @if($bgttcrregis->nm_klasifikasi === "MAN") 
                <input type='number' id="row-jml-{{ $loop->iteration }}" name="row-jml-{{ $loop->iteration }}" class="form-control" style='width: 10em;text-align:right;' min=0 max=999 step='1' onchange="updateRate()" value="{{ numberFormatterForm(0, 0)->format($detail->jml_mp) }}">
              @else 
                <input type='number' id="row-jml-{{ $loop->iteration }}" name="row-jml-{{ $loop->iteration }}" class="form-control" style='width: 10em;text-align:right;' min=0 max=999 step='1' onchange="updateRate()" value="{{ numberFormatterForm(0, 0)->format($detail->jml_mp) }}" readonly="readonly">
              @endif
            </td>
            <td style="text-align: right;">
              @if($bgttcrregis->nm_klasifikasi === "MAN") 
                <input type='number' id="row-amount-{{ $loop->iteration }}" name="row-amount-{{ $loop->iteration }}" class="form-control" style='width: 15em;text-align:right;' min=0 max=999999999999999999.999999 step='any' onchange="updateTotal()" value="{{ numberFormatterForm(0, 2)->format($detail->amount) }}" readonly="readonly">
              @else 
                <input type='number' id="row-amount-{{ $loop->iteration }}" name="row-amount-{{ $loop->iteration }}" class="form-control" style='width: 15em;text-align:right;' min=0 max=999999999999999999.999999 step='any' onchange="updateTotal()" value="{{ numberFormatterForm(0, 2)->format($detail->amount) }}">
              @endif
            </td>
          </tr>
        @endforeach
      @else 
        <tbody>
          @for($i=1;$i<=12;$i++)
            <tr>
              <td style="text-align: center;">{{ $i }}</td>
              <td>{{ strtoupper(namaBulan((int) $i)) }}</td>
              <td style="text-align: right;">
                <input type='number' id="row-jml-{{ $i }}" name="row-jml-{{ $i }}" class="form-control" style='width: 10em;text-align:right;' min=0 max=999 step='1' onchange="updateRate()" readonly="readonly">
              </td>
              <td style="text-align: right;">
                <input type='number' id="row-amount-{{ $i }}" name="row-amount-{{ $i }}" class="form-control" style='width: 15em;text-align:right;' min=0 max=999999999999999999.999999 step='any' onchange="updateTotal()" readonly="readonly">
              </td>
            </tr>
          @endfor
        </tbody>
      @endif
    </table>
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->
</div>
<!-- /.box-body -->

<div class="box-footer">
  {!! Form::submit('Save as Draft', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  @if (!empty($bgttcrregis->id))
    &nbsp;&nbsp;
    <button id="btn-submit" type="button" class="btn btn-success">Save & Submit</button>
    &nbsp;&nbsp;
    <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
    &nbsp;&nbsp;
    <a class="btn btn-info" href="{{ route('bgttcrregiss.create') }}">New Data</a>
  @endif
  &nbsp;&nbsp;
  <a class="btn btn-default" href="{{ route('bgttcrregiss.index') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

@section('scripts')
<script type="text/javascript">

	document.getElementById("nm_aktivitas").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  function changeKlasifikasi() {
    var nm_klasifikasi = document.getElementById("nm_klasifikasi").value;
    $('#nm_kategori').children('option').remove();
    $('#nm_kategori').append('<option value="">Select Categories</option>');
    if(nm_klasifikasi === "MACHINE") {
      @foreach(\DB::table("bgtt_cr_kategors")->selectRaw("nm_klasifikasi, nm_kategori, st_aktif")->where('st_aktif', 'T')->where('nm_klasifikasi', 'MACHINE')->orderBy('nm_kategori')->get() as $bgtt_cr_kategor)  
        $("#nm_kategori").append('<option value="{{ $bgtt_cr_kategor->nm_kategori }}">{{ $bgtt_cr_kategor->nm_kategori }}</option>');
      @endforeach
    } else if(nm_klasifikasi === "MAN") {
      @foreach(\DB::table("bgtt_cr_kategors")->selectRaw("nm_klasifikasi, nm_kategori, st_aktif")->where('st_aktif', 'T')->where('nm_klasifikasi', 'MAN')->orderBy('nm_kategori')->get() as $bgtt_cr_kategor)  
        $("#nm_kategori").append('<option value="{{ $bgtt_cr_kategor->nm_kategori }}">{{ $bgtt_cr_kategor->nm_kategori }}</option>');
      @endforeach
    } else if(nm_klasifikasi === "MATERIAL") {
      @foreach(\DB::table("bgtt_cr_kategors")->selectRaw("nm_klasifikasi, nm_kategori, st_aktif")->where('st_aktif', 'T')->where('nm_klasifikasi', 'MATERIAL')->orderBy('nm_kategori')->get() as $bgtt_cr_kategor)  
        $("#nm_kategori").append('<option value="{{ $bgtt_cr_kategor->nm_kategori }}">{{ $bgtt_cr_kategor->nm_kategori }}</option>');
      @endforeach
    } else if(nm_klasifikasi === "METHODE") {
      @foreach(\DB::table("bgtt_cr_kategors")->selectRaw("nm_klasifikasi, nm_kategori, st_aktif")->where('st_aktif', 'T')->where('nm_klasifikasi', 'METHODE')->orderBy('nm_kategori')->get() as $bgtt_cr_kategor)  
        $("#nm_kategori").append('<option value="{{ $bgtt_cr_kategor->nm_kategori }}">{{ $bgtt_cr_kategor->nm_kategori }}</option>');
      @endforeach
    }
    refreshJmlMp();
  }

  @if (!empty($bgttcrregis->id))
    $("#btn-delete").click(function(){
      var thn = "{{ $bgttcrregis->thn }}";
      var nm_aktivitas = "{{ $bgttcrregis->nm_aktivitas }}";
      var nm_klasifikasi = "{{ $bgttcrregis->nm_klasifikasi }}";
      var nm_kategori = "{{ $bgttcrregis->nm_kategori }}";
      var id_pk = "{{ $bgttcrregis->id }}";
      var msg = "Anda yakin menghapus Activity: " + nm_aktivitas + ", Tahun: " + thn + ", Classification: " + nm_klasifikasi + ", CR Categories: " + nm_kategori + '?';
      //additional input validations can be done hear
      swal({
        title: msg,
        text: "",
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
        var urlRedirect = "{{ route('bgttcrregiss.delete', 'param') }}";
        urlRedirect = urlRedirect.replace('param', window.btoa(id_pk));
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
  @endif

  $("#btn-submit").click(function(){
      var thn = document.getElementById("thn").value.trim();
      var kd_dep = document.getElementById("kd_dep").value.trim();
      var nm_aktivitas = document.getElementById("nm_aktivitas").value;
      var nm_klasifikasi = document.getElementById("nm_klasifikasi").value.trim();
      var nm_kategori = document.getElementById("nm_kategori").value.trim();

      if(thn === "" || kd_dep === "" || nm_aktivitas === "" || nm_klasifikasi === "" || nm_kategori === "") {
        var info = "Isi data yang tidak boleh kosong!";
        swal(info, "Perhatikan inputan anda!", "warning");
      } else {
        var msg = 'Anda yakin submit data ini?';
        var txt = "Activity: " + nm_aktivitas + ", Tahun: " + thn + ", Classification: " + nm_klasifikasi + ", CR Categories: " + nm_kategori;
        swal({
            title: msg,
            text: txt,
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, submit it!',
            cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            reverseButtons: false,
            focusCancel: true,
        }).then(function () {
            document.getElementById("st_submit").value = "T";
            document.getElementById("form_id").submit();
        }, function (dismiss) {
            if (dismiss === 'cancel') {
            }
        })
      }
  });

  $('#form_id').submit(function (e, params) {
  	var localParams = params || {};
  	if (!localParams.send) {
  		e.preventDefault();

  		var validasi = "T";
  		var msg = "";

  		if(validasi !== "T") {
  			var info = msg;
  			swal(info, "Perhatikan inputan anda!", "warning");
  		} else {
  			var valid = 'T';
  			var msg = "Anda yakin menyimpan data ini?";
  			var txt = "";

  			if(valid === 'T') {
  				swal({
  					title: msg,
  					text: txt,
  					type: 'question',
  					showCancelButton: true,
  					confirmButtonColor: '#3085d6',
  					cancelButtonColor: '#d33',
  					confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, save it!',
  					cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
  					allowOutsideClick: true,
  					allowEscapeKey: true,
  					allowEnterKey: true,
  					reverseButtons: false,
  					focusCancel: false,
  				}).then(function () {
  					$(e.currentTarget).trigger(e.type, { 'send': true });
  				}, function (dismiss) {
  					if (dismiss === 'cancel') {
  					}
  				})
  			} else {
  				swal(msg, txt, "warning");
  			}
  		}
  	}
  });
	
  $(document).ready(function(){
  	
  });

  function refreshJmlMp() {
    var nm_klasifikasi = document.getElementById("nm_klasifikasi").value;
    if(nm_klasifikasi !== "MAN") {
      for($i = 1; $i <= 12; $i++) {
        var id_jml_mp = "row-jml-" + $i;
        var id_amount = "row-amount-" + $i;
        document.getElementById(id_jml_mp).value = null;
        document.getElementById(id_amount).value = null;
        $("#row-jml-" + $i).attr('readonly', 'readonly');
        $("#row-amount-" + $i).removeAttr('readonly');
      }
    } else {
      for($i = 1; $i <= 12; $i++) {
        var id_jml_mp = "row-jml-" + $i;
        var id_amount = "row-amount-" + $i;
        document.getElementById(id_jml_mp).value = null;
        document.getElementById(id_amount).value = null;
        $("#row-jml-" + $i).removeAttr('readonly');
        $("#row-amount-" + $i).attr('readonly', 'readonly');
      }
    }
    updateTotal();
  }

  function updateRate() {
    var nm_klasifikasi = document.getElementById("nm_klasifikasi").value;
    if(nm_klasifikasi === "MAN") {
      var rate = 0;
      var thn = document.getElementById("thn").value.trim();
      if(thn != "") {
        var url = '{{ route('datatables.rateMpBudget', 'param') }}';
        url = url.replace('param', window.btoa(thn));
        $.get(url, function(result){  
          if(result !== 'null'){
            result = JSON.parse(result);
            rate = result["rate_mp"];
            rate = Number(rate);
          }
          for($i = 1; $i <= 12; $i++) {
            var id_jml_mp = "row-jml-" + $i;
            var id_amount = "row-amount-" + $i;
            var jml_mp = document.getElementById(id_jml_mp).value.trim();
            jml_mp = Number(jml_mp);
            var value_amount = (jml_mp*rate*(13-$i)/12).toFixed(2);
            document.getElementById(id_amount).value = value_amount;
          }
          updateTotal();
        });
      } else {
        for($i = 1; $i <= 12; $i++) {
          var id_jml_mp = "row-jml-" + $i;
          var id_amount = "row-amount-" + $i;
          var jml_mp = document.getElementById(id_jml_mp).value.trim();
          jml_mp = Number(jml_mp);
          var value_amount = (jml_mp*rate*(13-$i)/12).toFixed(2);
          document.getElementById(id_amount).value = value_amount;
        }
        updateTotal();
      }
    }
  }

  function updateTotal() {
    var total_mp = 0;
    var total_amount = 0;
    for($i = 1; $i <= 12; $i++) {
      var id_jml_mp = "row-jml-" + $i;
      var id_amount = "row-amount-" + $i;
      
      var jml_mp = document.getElementById(id_jml_mp).value.trim();
      jml_mp = Number(jml_mp);
      
      var amount = document.getElementById(id_amount).value.trim();
      amount = Number(amount);

      total_mp = total_mp + jml_mp;
      total_amount = total_amount + amount;
    }
    document.getElementById("row-jml-sum").value = total_mp.toFixed(0).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
    document.getElementById("row-amount-sum").value = total_amount.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
  }

  updateTotal();
</script>
@endsection