@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pengisian Oli
        <small>Detail Pengisian Oli</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Transaksi</li>
        <li><a href="{{ route('mtctisioli1s.index') }}"><i class="fa fa-files-o"></i> Pengisian Oli</a></li>
        <li class="active">Detail {{ $mtctisioli1->no_isi }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Pengisian Oli</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 10%;"><b>No. Pengisian</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 25%;">{{ $mtctisioli1->no_isi }}</td>
                    <td style="width: 5%;"><b>Tgl Isi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ \Carbon\Carbon::parse($mtctisioli1->tgl_isi)->format('d/m/Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Site</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 25%;">{{ $mtctisioli1->kd_site }}</td>
                    <td style="width: 5%;"><b>Plant</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mtctisioli1->kd_plant }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Line</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 25%;">{{ $mtctisioli1->kd_line }} - {{ $mtctisioli1->nm_line }}</td>
                    <td style="width: 5%;"><b>Mesin</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mtctisioli1->kd_mesin }} - {{ $mtctisioli1->nm_mesin }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Creaby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 25%;">
                      @if (!empty($mtctisioli1->dtcrea))
                        {{ $mtctisioli1->creaby }} - {{ $mtctisioli1->nama($mtctisioli1->creaby) }} - {{ \Carbon\Carbon::parse($mtctisioli1->dtcrea)->format('d/m/Y H:i') }}
                      @else
                        {{ $mtctisioli1->creaby }} - {{ $mtctisioli1->nama($mtctisioli1->creaby) }}
                      @endif
                    </td>
                    <td style="width: 5%;"><b>Modiby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if (!empty($mtctisioli1->dtmodi))
                        {{ $mtctisioli1->modiby }} - {{ $mtctisioli1->nama($mtctisioli1->modiby) }} - {{ \Carbon\Carbon::parse($mtctisioli1->dtmodi)->format('d/m/Y H:i') }}
                      @else
                        {{ $mtctisioli1->modiby }} - {{ $mtctisioli1->nama($mtctisioli1->modiby) }}
                      @endif
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-body" id="field-detail">
              @foreach ($mtctisioli1->details()->get() as $model)
                <div class="row" id="field_{{ $loop->iteration }}">
                  <div class="col-md-12">
                    <div class="box box-primary">
                      <div class="box-header with-border">
                        <h3 class="box-title" id="box_{{ $loop->iteration }}">Oli Ke-{{ $loop->iteration }}</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <div class="row form-group">
                          <div class="col-sm-3">
                            <input type="hidden" id="no_seq_{{ $loop->iteration }}" name="no_seq_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ base64_encode($model->no_seq) }}">
                            <label name="item_no_{{ $loop->iteration }}">Part No</label>
                            <input type="text" id="item_no_{{ $loop->iteration }}" name="item_no_{{ $loop->iteration }}" required class="form-control" placeholder="Part No" value="{{ $model->item_no }}" readonly="readonly">
                          </div>
                          <div class="col-sm-7">
                            <label name="item_name_{{ $loop->iteration }}">Deskripsi</label>
                            <input type="text" id="item_name_{{ $loop->iteration }}" name="item_name_{{ $loop->iteration }}" class="form-control" placeholder="Deskripsi" disabled="" value="{{ $model->item_name }}">
                          </div>
                          <div class="col-sm-2">
                            <label name="qty_isi_{{ $loop->iteration }}">Qty (Liter) (*)</label>
                            <input type="number" id="qty_isi_{{ $loop->iteration }}" name="qty_isi_{{ $loop->iteration }}" required class="form-control" placeholder="Qty (Liter)" min="0.1" step="any" onkeydown="keyPressedQty(this, event)" value="{{ $model->qty_isi }}" readonly="readonly">
                          </div>
                        </div>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              @endforeach
              {!! Form::hidden('jml_row', $mtctisioli1->details()->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row']) !!}
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="box-footer">
        @if ($mtctisioli1->checkEdit() === "T")
          @if (Auth::user()->can('mtc-oli-create'))
            <a class="btn btn-primary" href="{{ route('mtctisioli1s.edit', base64_encode($mtctisioli1->no_isi)) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
            &nbsp;&nbsp;
          @endif
          @if (Auth::user()->can('mtc-oli-delete'))
            <button id="btn-delete" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data">Hapus Data</button>
            &nbsp;&nbsp;
          @endif
        @endif
        <a class="btn btn-primary" href="{{ route('mtctisioli1s.index') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard Pengisian Oli" id="btn-cancel">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">
  $("#btn-delete").click(function(){
    var no_isi = "{{ $mtctisioli1->no_isi }}";
    var msg = 'Anda yakin menghapus No. Pengisian Oli: ' + no_isi + '?';
    var txt = '';
    //additional input validations can be done hear
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
      var urlRedirect = "{{ route('mtctisioli1s.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_isi));
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

  function keyPressedQty(ths, e) {
    if(e.keyCode == 9) { //TAB
      e.preventDefault();
      var row = ths.id.replace('qty_isi_', '');
      row = Number(row);
      var jml_row = document.getElementById("jml_row").value.trim();
      jml_row = Number(jml_row);
      if(row < jml_row) {
        row = row + 1;
        var item_no = 'item_no_'+row;
        document.getElementById(item_no).focus();
      } else {
        document.getElementById('btn-cancel').focus();
      }
    }
  }
</script>
@endsection