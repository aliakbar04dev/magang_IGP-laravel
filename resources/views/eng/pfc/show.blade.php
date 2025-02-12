@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        PFC
        <small>Detail Process Flow Chart</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> ENGINEERING - TRANSAKSI - PFC</li>
        <li><a href="{{ route('engttpfc1s.index') }}"><i class="fa fa-files-o"></i> Daftar PFC</a></li>
        <li class="active">Detail PFC</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">PFC</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 10%;"><b>Customer</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="7" style="white-space:pre;">{{ $engttpfc1->kd_cust }} - {{ $engttpfc1->nm_cust }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Model Name</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="7" style="white-space:pre;">{{ $engttpfc1->kd_model }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Line</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="7" style="white-space:pre;">{{ $engttpfc1->kd_line }} - {{ $engttpfc1->nm_line }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Part</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="7">
                      @foreach ($engttpfc1->engtTpfc3s()->orderBy("id")->get() as $model)
                        {{ $loop->iteration }}. {{ $model->part_no }} - {{ $model->nm_part }} <br>
                      @endforeach
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Doc. Type</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="7" style="white-space:pre;">{{ $engttpfc1->reg_doc_type }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Status</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="7" style="white-space:pre;">{{ $engttpfc1->st_pfc }}</td>
                  </tr>
                  @if (!empty($engttpfc1->dtcrea))
                    <tr>
                      <td style="width: 10%;"><b>Prepared</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="7">
                        {{ $engttpfc1->creaby }} - {{ $engttpfc1->nama($engttpfc1->creaby) }} - {{ \Carbon\Carbon::parse($engttpfc1->dtcrea)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($engttpfc1->dtcheck))
                    <tr>
                      <td style="width: 10%;"><b>Checked</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="7">
                        {{ $engttpfc1->checkby }} - {{ $engttpfc1->nama($engttpfc1->checkby) }} - {{ \Carbon\Carbon::parse($engttpfc1->dtcheck)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($engttpfc1->dtapprov))
                    <tr>
                      <td style="width: 10%;"><b>Approved</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="7">
                        {{ $engttpfc1->approvby }} - {{ $engttpfc1->nama($engttpfc1->approvby) }} - {{ \Carbon\Carbon::parse($engttpfc1->dtapprov)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 10%;"><b>Registrasi Doc</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 15%;">{{ $engttpfc1->reg_no_doc }}</td>
                      <td style="width: 5%;"><b>Revisi</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 10%;">{{ $engttpfc1->reg_no_rev }}</td>
                      <td style="width: 5%;"><b>Tgl</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ \Carbon\Carbon::parse($engttpfc1->reg_tgl_rev)->format('d/m/Y H:i') }}</td>
                    </tr>
                    @if (!empty($engttpfc1->reg_ket_rev))
                      <tr>
                        <td style="width: 10%;"><b>Ket. Revisi</b></td>
                        <td style="width: 1%;"><b>:</b></td>
                        <td colspan="7" style="white-space:pre;">{{ $engttpfc1->reg_ket_rev }}</td>
                      </tr>
                    @endif
                  @endif
                  <tr>
                    <td style="width: 10%;"><b>Creaby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="7">
                      @if (!empty($engttpfc1->dtcrea))
                        {{ $engttpfc1->creaby }} - {{ $engttpfc1->nama($engttpfc1->creaby) }} - {{ \Carbon\Carbon::parse($engttpfc1->dtcrea)->format('d/m/Y H:i') }}
                      @else
                        {{ $engttpfc1->creaby }} - {{ $engttpfc1->nama($engttpfc1->creaby) }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Modiby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="7">
                      @if (!empty($engttpfc1->dtmodi))
                        {{ $engttpfc1->modiby }} - {{ $engttpfc1->nama($engttpfc1->modiby) }} - {{ \Carbon\Carbon::parse($engttpfc1->dtmodi)->format('d/m/Y H:i') }}
                      @else
                        {{ $engttpfc1->modiby }} - {{ $engttpfc1->nama($engttpfc1->modiby) }}
                      @endif
                    </td>
                  </tr>
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
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detail PFC</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="field" data-field-id="{{ $engttpfc1->id }}">
              <table id="tblDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th style="width: 1%;">No</th>
                    <th style="width: 1%;">OP</th>
                    <th style="width: 15%;">M/C Code</th>
                    <th style="width: 15%;">Flow Process</th>
                    <th style="width: 15%;">Process Name</th>
                    <th style="width: 5%">CT</th>
                    <th style="width: 5%;">Machine</th>
                    <th style="width: 5%;">Tooling</th>
                    <th>Machine Type</th>
                    <th>Machine Name</th>
                    <th>Ilustration Process</th>
                  </tr>
                </thead>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="box-footer">
        @if ($engttpfc1->dtcheck == null)
          @if (Auth::user()->can(['eng-pfc-create','eng-pfc-delete']) && $engttpfc1->checkEdit() === "T")
            @if (Auth::user()->can('eng-pfc-create'))
              <a class="btn btn-primary" href="{{ route('engttpfc1s.edit', base64_encode($engttpfc1->id)) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
              &nbsp;&nbsp;
            @endif
            @if (Auth::user()->can('eng-pfc-delete'))
              <button id="btn-delete" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data">Hapus Data</button>
              &nbsp;&nbsp;
            @endif
          @endif
        @elseif($engttpfc1->dtapprov == null)
          @if (Auth::user()->can('eng-pfc-approve'))
            <button id='btnapprove' type='button' class='btn btn-success' data-toggle='tooltip' data-placement='top' title='Approve PFC' onclick='approve("{{ base64_encode($engttpfc1->id) }}","Approve PFC Customer: {{ $engttpfc1->kd_cust }} - {{ $engttpfc1->nm_cust }}, Model: {{ $engttpfc1->kd_model }}, Line: {{ $engttpfc1->kd_line }} - {{ $engttpfc1->nm_line }}")'>
              <span class='glyphicon glyphicon-check'></span> Approve PFC
            </button>
            &nbsp;&nbsp;
          @endif
        @endif
        <button id='btnprint' type='button' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Print PFC' onclick='printPfc("{{ base64_encode($engttpfc1->id) }}")'>
          <span class='glyphicon glyphicon-print'></span> Print PFC
        </button>
        &nbsp;&nbsp;
        <a class="btn btn-primary" href="{{ route('engttpfc1s.index') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard PFC">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  function approve(id, info)
  {
    var msg = "Anda yakin " + info + "?";
    //additional input validations can be done hear
    swal({
      title: msg,
      text: "",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, approve it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      var token = document.getElementsByName('_token')[0].value.trim();
      // save via ajax
      // create data detail dengan ajax
      var url = "{{ route('engttpfc1s.approve')}}";
      $("#loading").show();
      $.ajax({
        type     : 'POST',
        url      : url,
        dataType : 'json',
        data     : {
          _method        : 'POST',
          // menambah csrf token dari Laravel
          _token         : token,
          id             : id
        },
        success:function(data){
          $("#loading").hide();
          if(data.status === 'OK'){
            swal("Approved", data.message, "success");
            var urlRedirect = "{{ route('engttpfc1s.show', 'param') }}";
            urlRedirect = urlRedirect.replace('param', id);
            window.location.href = urlRedirect;
          } else {
            swal("Cancelled", data.message, "error");
          }
        }, error:function(){ 
          $("#loading").hide();
          swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");
        }
      });
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

  function printPfc(id)
  {
    swal({
      title: "Internal atau Eksternal?",
      text: "",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="glyphicon glyphicon-resize-small"></i> Internal',
      cancelButtonText: '<i class="glyphicon glyphicon-resize-full"></i> Eksternal',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      var urlRedirect = '{{ route('engttpfc1s.print', ['param','param2']) }}';
      urlRedirect = urlRedirect.replace('param2', window.btoa("IN"));
      urlRedirect = urlRedirect.replace('param', id);
      window.open(urlRedirect, '_blank');
    }, function (dismiss) {
      // dismiss can be 'cancel', 'overlay',
      // 'close', and 'timer'
      if (dismiss === 'cancel') {
        var urlRedirect = '{{ route('engttpfc1s.print', ['param','param2']) }}';
        urlRedirect = urlRedirect.replace('param2', window.btoa("OUT"));
        urlRedirect = urlRedirect.replace('param', id);
        window.open(urlRedirect, '_blank');
      }
    })
  }

  $("#btn-delete").click(function(){
    var kd_cust = "{{ $engttpfc1->kd_cust }} - {{ $engttpfc1->nm_cust }}";
    var kd_model = "{{ $engttpfc1->kd_model }}";
    var line = "{{ $engttpfc1->kd_line }}  - {{ $engttpfc1->nm_line }}";
    var id = "{{ $engttpfc1->id }}";
    var info = "Customer: " + kd_cust + ", Model: " + kd_model + ", Line: " + line;
    var msg = 'Anda yakin menghapus PFC ' + info + '?';
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
      var urlRedirect = "{{ route('engttpfc1s.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(id));
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

  $(document).ready(function(){
    var engt_tpfc1_id = $('#field').data("field-id");
    var url = '{{ route('engttpfc1s.detail', 'param') }}';
    url = url.replace('param', window.btoa(engt_tpfc1_id));
    var tableDetail = $('#tblDetail').DataTable({
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
      responsive: true,
      "order": [[0, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
        { data: 'no_urut', name: 'no_urut', className: "dt-center"}, 
        { data: 'no_op', name: 'no_op', className: "dt-center"}, 
        { data: 'kd_mesin', name: 'kd_mesin'}, 
        { data: 'engt_msimbol_id', name: 'engt_msimbol_id', className: "dt-center", orderable: false, searchable: false}, 
        { data: 'nm_pros', name: 'nm_pros'}, 
        { data: 'nil_ct', name: 'nil_ct', className: "dt-right"},
        { data: 'st_mesin', name: 'st_mesin', className: "dt-center"}, 
        { data: 'st_tool', name: 'st_tool', className: "dt-center"}, 
        { data: 'nm_proses', name: 'nm_proses'}, 
        { data: 'nm_mesin', name: 'nm_mesin', className: "none"}, 
        { data: 'pros_draw_pict', name: 'pros_draw_pict', className: "none", orderable: false, searchable: false}
      ],
    });
  });
</script>
@endsection