@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sync
        <small>Sync</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-lock"></i> Admin</li>
        <li class="active"><i class="fa fa-files-o"></i> Sync</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">        
        <div class="box-body form-horizontal">
          <div class="form-group">
            <div class="col-sm-4">
              <select id="select_info" name="select_info" aria-controls="filter_status" class="form-control select2" onchange="changeInfo()">
                <option value="-">List Syntax</option>
                <option value="AGI_DN">AGI DN</option>
                <option value="AGI_VW_PRC_PO_PART_KDBRG">AGI VW_PRC_PO_PART_KDBRG</option>
                <option value="BAAN_MASTER_DATA">BAAN Master data</option>
                <option value="BAAN_FP">BAAN FP</option>
                <option value="BAAN_MASTER_SUPPLIER">BAAN Master Supplier</option>
                <option value="BAAN_PP">BAAN PP</option>
                <option value="BAAN_PO">BAAN PO</option>
                <option value="BAAN_MASTER_DEPT">BAAN Master Departemen</option>
                <option value="BAAN_MASTER_ACC">BAAN Master Acc</option>
                <option value="BAAN_LPB">BAAN LPB</option>
                <option value="BAAN_BPB">BAAN BPB</option>
                <option value="BAAN_TRANSAKSI">BAAN TRANSAKSI</option>
                <option value="BAAN_MASTER">BAAN MASTER</option>
                <option value="BAAN_PIM">BAAN PIM</option>
                <option value="BAAN_DS">BAAN DS</option>
                <option value="BAAN_LHP">BAAN LHP</option>
                <option value="BAAN_SI">BAAN SALES INVOICE</option>
                <option value="BAAN_SM">BAAN NOTA DEBET</option>
                <option value="BAAN_DN">BAAN DN</option>
                <option value="BAAN_SO">BAAN SCLK</option>
                <option value="BAAN_PAG">BAAN PAG</option>
                <option value="BAAN_STOCK_OH">BAAN Stock OH</option>
                <option value="BAAN_HARGA">BAAN HARGA</option>
                <option value="BAAN_PRO">BAAN PRO</option>
                <option value="BAAN_MILKRUN">BAAN MILK RUN</option>
                <option value="BAAN_ASSET">BAAN CIP ASSET</option>
                <option value="BAAN_MONECLAIM">BAAN MONETARY CLAIM</option>
              </select>
            </div>
            <div class="col-sm-8">
              {!! Form::label('info_deskripsi', ' ', ['id'=>'info_deskripsi']) !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <div class="col-sm-5">
              {!! Form::label('lblparam', 'Parameter (*)') !!}
              {!! Form::text('param', null, ['class' => 'form-control', 'placeholder' => 'Parameter', 'required', 'id' => 'param']) !!}
            </div>
            <div class="col-sm-2">
              {!! Form::label('lblsync', 'Action') !!}
              <button id="btn-sync" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Sync">Sync</button>
            </div>
          </div>
          <!-- /.form-group -->
        </div>
        <!-- /.box-body -->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

document.getElementById("param").focus();

//Initialize Select2 Elements
  $(".select2").select2();

  function changeInfo() {
    var select_info = document.getElementById("select_info").value;
    var text = "";
    if(select_info === "AGI_DN") {
      text = "ALL: AGI_DN<BR>1 DN: AGI_DN NO_DN";
    } else if(select_info === "AGI_VW_PRC_PO_PART_KDBRG") {
      text = "AGI_VW_PRC_PO_PART_KDBRG";
    } else if(select_info === "BAAN_MASTER_DATA") {
      text = "BAAN_MASTER_DATA";
    } else if(select_info === "BAAN_FP") {
      text = "BAAN_FP";
    } else if(select_info === "BAAN_MASTER_SUPPLIER") {
      text = "BAAN_MASTER_SUPPLIER";
    } else if(select_info === "BAAN_PP") {
      text = "PERIODE: BAAN_PP YYYYMMDD YYYYMMDD<BR>PER PP: BAAN_PP NO_PP";
    } else if(select_info === "BAAN_PO") {
      text = "PERIODE: BAAN_PO YYYYMMDD YYYYMMDD<BR>PER PO: BAAN_PO NO_PO";
    } else if(select_info === "BAAN_MASTER_DEPT") {
      text = "BAAN_MASTER_DEPT";
    } else if(select_info === "BAAN_MASTER_ACC") {
      text = "BAAN_MASTER_ACC";
    } else if(select_info === "BAAN_LPB") {
      text = "PERIODE: BAAN_LPB YYYYMMDD YYYYMMDD<BR>PER LPB: BAAN_LPB NO_LPB";
    } else if(select_info === "BAAN_BPB") {
      text = "BAAN_BPB YYYYMMDD YYYYMMDD";
    } else if(select_info === "BAAN_TRANSAKSI") {
      text = "BAAN_TRANSAKSI";
    } else if(select_info === "BAAN_MASTER") {
      text = "BAAN_MASTER";
    } else if(select_info === "BAAN_PIM") {
      text = "BAAN_PIM YYYYMMDD YYYYMMDD";
    } else if(select_info === "BAAN_DS") {
      text = "BAAN_DS YYYYMMDD YYYYMMDD";
    } else if(select_info === "BAAN_LHP") {
      text = "BAAN_LHP YYYYMMDD YYYYMMDD";
    } else if(select_info === "BAAN_SI") {
      text = "BAAN_SI YYYYMMDD YYYYMMDD";
    } else if(select_info === "BAAN_SM") {
      text = "BAAN_SM YYYYMMDD YYYYMMDD";
    } else if(select_info === "BAAN_DN") {
      text = "BAAN_DN YYYYMMDD YYYYMMDD";
    } else if(select_info === "BAAN_SO") {
      text = "BAAN_SO YYYYMMDD YYYYMMDD";
    } else if(select_info === "BAAN_PAG") {
      text = "BAAN_PAG YYYYMMDD YYYYMMDD";
    } else if(select_info === "BAAN_STOCK_OH") {
      text = "BAAN_STOCK_OH";
    } else if(select_info === "BAAN_HARGA") {
      text = "BAAN_HARGA";
    } else if(select_info === "BAAN_PRO") {
      text = "BAAN_PRO YYYYMMDD YYYYMMDD";
    } else if(select_info === "BAAN_MILKRUN") {
      text = "BAAN_MILKRUN";
    } else if(select_info === "BAAN_ASSET") {
      text = "BAAN_ASSET";
    } else if(select_info === "BAAN_MONECLAIM") {
      text = "BAAN_MONECLAIM YYYYMMDD YYYYMMDD";
    }
    document.getElementById("info_deskripsi").innerHTML = text;
  }

$("#btn-sync").click(function(){
  var param = document.getElementById("param").value.trim();
  if(param === "") {
    var info = "Parameter tidak boleh kosong!";
    document.getElementById("param").focus();
    swal(info, "Perhatikan inputan anda!", "warning");
  } else {
    var msg = "Anda yakin Sinkronisasi: " + param + "?";
    var txt = "";
    swal({
      title: msg,
      text: txt,
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, sync it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      var urlRedirect = "{{ route('syncs.satu', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(param));
      window.location.href = urlRedirect;
    }, function (dismiss) {
      if (dismiss === 'cancel') {
        //
      }
    })
  }
});
</script>
@endsection