@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        QPR
        <small>Detail QPR</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('qprs.index') }}"><i class="fa fa-exchange"></i> QPR</a></li>
        <li class="active">Detail {{ $qpr->issue_no }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detail QPR</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 10%;"><b>No. QPR</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $qpr->issue_no }}</td>
                    <td style="width: 10%;"><b>Tgl QPR</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ \Carbon\Carbon::parse($qpr->issue_date)->format('d/m/Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Part No</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $qpr->part_no }}</td>
                    <td style="width: 10%;"><b>Part Name</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $qpr->nm_part }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Model</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $qpr->model }}</td>
                    <td style="width: 10%;"><b>Problem</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $qpr->problem }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Tgl Submit</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ \Carbon\Carbon::parse($qpr->portal_sh_tgl)->format('d/m/Y H:i') }}</td>
                    <td style="width: 10%;"><b>PIC Submit</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $qpr->portal_sh_pic." - ".$qpr->nama($qpr->portal_sh_pic) }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Tgl Received</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">
                      @if (!empty($qpr->portal_tgl_terima))
                        {{ \Carbon\Carbon::parse($qpr->portal_tgl_terima)->format('d/m/Y H:i') }}
                      @endif  
                    </td>
                    <td style="width: 10%;"><b>PIC Received</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $qpr->portal_pic_terima }}</td>
                  </tr>
                  @if (!empty($qpr->portal_tgl_reject))
                    <tr>
                      <td style="width: 10%;"><b>Tgl Complain</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 15%;">
                        @if (!empty($qpr->portal_tgl_reject))
                          {{ \Carbon\Carbon::parse($qpr->portal_tgl_reject)->format('d/m/Y H:i') }}
                        @endif  
                      </td>
                      <td style="width: 10%;"><b>PIC Complain</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $qpr->portal_pic_reject }}</td>
                    </tr>
                    <tr>
                      <td style="width: 10%;"><b>Ket. Complain</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4" style="white-space:pre;">{{ $qpr->status_reject." - ".$qpr->portal_ket_reject }}</td>
                    </tr>
                  @endif
                  @if (!empty($qpr->pica()))
                    <tr>
                      <td style="width: 10%;"><b>No. PICA</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 15%;">
                        @if (Auth::user()->can('pica-*'))
                          <a href="{{ route('picas.show', base64_encode($qpr->pica()->id)) }}" data-toggle="tooltip" data-placement="top" title="Show Detail PICA {{ $qpr->pica()->no_pica }}">{{ $qpr->pica()->no_pica }}</a>
                        @else
                          {{ $qpr->pica()->no_pica }}
                        @endif
                      </td>
                      <td style="width: 10%;"><b>Tgl PICA</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ \Carbon\Carbon::parse($qpr->pica()->tgl_pica)->format('d/m/Y') }}</td>
                    </tr>
                  @endif
                  <tr>
                    <td style="width: 10%;"><b>File</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if ($image_codes !== "")
                        <div class="row" id="field_1">
                          <div class="col-md-12">
                            <div class="box box-primary">
                              <div class="box-header with-border">
                                <h3 class="box-title" id="box_1">File QPR</h3>
                                <div class="box-tools pull-right">
                                  <a target="_blank" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Download File" href="{{ route('qprs.download', base64_encode($qpr->issue_no)) }}"><span class='glyphicon glyphicon-download-alt'></span></a>
                                  <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                  </button>
                                </div>
                              </div>
                              <!-- /.box-header -->
                              <div class="box-body">
                                <iframe src="{{ $image_codes }}" width="80%" height="300px"></iframe>
                              </div>
                              <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                          </div>
                          <!-- /.col -->
                        </div>
                        <!-- /.row -->
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
      @if ($qpr->kd_supp == Auth::user()->kd_supp && !empty($qpr->portal_sh_tgl))
        <div class="box-footer">
          @if (!empty($qpr->portal_pict))
            <a class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Download File {{ $qpr->issue_no }}" href="{{ route('qprs.download', base64_encode($qpr->issue_no)) }}"><span class="glyphicon glyphicon-download-alt"></span> Download File</a>
          @endif
          @if (!empty($qpr->pica()))
            @if (Auth::user()->can('pica-*'))
              &nbsp;&nbsp;
              <a class="btn btn-primary bg-black" href="{{ route("picas.show", base64_encode($qpr->pica()->id)) }}" data-toggle="tooltip" data-placement="top" title="Show PICA {{ $qpr->pica()->no_pica }}"><span class='glyphicon glyphicon-transfer'></span> Show PICA</a>
            @endif
          @else
            @if (empty($qpr->portal_tgl_reject))
              @if (empty($qpr->portal_tgl_terima))
                @if (Auth::user()->can('qpr-approve'))
                  &nbsp;&nbsp;
                  <button id='btnapprove' type='button' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Approve QPR {{ $qpr->issue_no }}' onclick='approveQpr("{{ $qpr->issue_no }}", "SP")'>
                    <span class='glyphicon glyphicon-check'></span> Approve QPR
                  </button>
                @endif
                @if (Auth::user()->can('qpr-reject'))
                  &nbsp;&nbsp;
                  <button id='btnreject' type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Complain QPR {{ $qpr->issue_no }}' onclick='rejectQpr("{{ $qpr->issue_no }}", "SP")'>
                    <span class='glyphicon glyphicon-remove'></span> Complain QPR
                  </button>
                @endif
              @else
                @if (Auth::user()->can('pica-create'))
                  &nbsp;&nbsp;
                  <button id='btncreate' type='button' class='btn bg-navy' data-toggle='tooltip' data-placement='top' title='Create PICA {{ $qpr->issue_no }}' onclick='createPica("{{ $qpr->issue_no }}")'>
                    <span class='glyphicon glyphicon-transfer'></span> Create PICA
                  </button>
                @endif
                @if (Auth::user()->can('qpr-reject'))
                  &nbsp;&nbsp;
                  <button id='btnreject' type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Complain QPR {{ $qpr->issue_no }}' onclick='rejectQpr("{{ $qpr->issue_no }}", "SP")'>
                    <span class='glyphicon glyphicon-remove'></span> Complain QPR
                  </button>
                @endif
              @endif
            @elseif ($qpr->portal_apr_reject === "F")
              @if (empty($qpr->portal_tgl_terima))
                @if (Auth::user()->can('qpr-approve'))
                  &nbsp;&nbsp;
                  <button id='btnapprove' type='button' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Approve QPR {{ $qpr->issue_no }}' onclick='approveQpr("{{ $qpr->issue_no }}", "SP")'>
                    <span class='glyphicon glyphicon-check'></span> Approve QPR
                  </button>
                @endif
              @else
                @if (Auth::user()->can('pica-create'))
                  &nbsp;&nbsp;
                  <button id='btncreate' type='button' class='btn bg-navy' data-toggle='tooltip' data-placement='top' title='Create PICA {{ $qpr->issue_no }}' onclick='createPica("{{ $qpr->issue_no }}")'>
                    <span class='glyphicon glyphicon-transfer'></span> Create PICA
                  </button>
                @endif
              @endif
            @endif
          @endif
          &nbsp;&nbsp;
          <a class="btn btn-primary" href="{{ route('qprs.index') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard QPR">Cancel</a>
        </div>
      @endif
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  function createPica(issue_no)
  {
    var msg = 'Anda yakin membuat PICA untuk data ini?';
    var txt = 'No. QPR: ' + issue_no;
    //additional input validations can be done hear
    swal({
      title: msg,
      text: txt,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, create it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      var urlRedirect = "{{ route('picas.edit', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(issue_no));
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
  }

  function approveQpr(issue_no, mode)
  {
    var msg = 'Anda yakin APPROVE No. QPR: ' + issue_no + '?';
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
      var url = "{{ route('qprs.approve')}}";
      $("#loading").show();
      $.ajax({
        type     : 'POST',
        url      : url,
        dataType : 'json',
        data     : {
          _method        : 'POST',
          // menambah csrf token dari Laravel
          _token         : token,
          issue_no       : window.btoa(issue_no),
          mode           : window.btoa(mode)
        },
        success:function(data){
          $("#loading").hide();
          if(data.status === 'OK'){
            swal("Approved", data.message, "success");
            var urlRedirect = "{{ route('qprs.show', 'param') }}";
            urlRedirect = urlRedirect.replace('param', window.btoa(issue_no));
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

  function rejectQpr(issue_no, mode)
  {
    var msg = 'Anda yakin Complain data ini?';
    var txt = 'No. QPR: ' + issue_no;
    //additional input validations can be done hear
    swal({
      title: msg,
      text: txt,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, complain it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      swal({
        title: 'Input Keterangan Complain',
        html:
          '<select class="form-control select2" required="required" id="swal-input1" name="swal-input1"><option selected="selected" value="">Pilih Status</option><option value="I">Request IGP</option><option value="O">Others</option></select><BR>' +
          '<textarea id="swal-input2" class="form-control" maxlength="500" rows="3" cols="20" placeholder="Keterangan Complain (Max. 500 Karakter)" style="text-transform:uppercase;resize:vertical">',
        preConfirm: function () {
          return new Promise(function (resolve, reject) {
            if ($('#swal-input1').val()) {
              if ($('#swal-input2').val()) {
                if($('#swal-input2').val().length > 500) {
                  reject('Keterangan Complain Max 500 Karakter!')
                } else {
                  resolve([
                    $('#swal-input1').val(),
                    $('#swal-input2').val()
                  ])
                }
              } else {
                reject('Keterangan Complain tidak boleh kosong!')
              }
            } else {
              reject('Status Complain tidak boleh kosong!')
            }
          })
        }
      }).then(function (result) {
        var token = document.getElementsByName('_token')[0].value.trim();
        // save via ajax
        // create data detail dengan ajax
        var url = "{{ route('qprs.reject')}}";
        $("#loading").show();
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method           : 'POST',
            // menambah csrf token dari Laravel
            _token            : token,
            issue_no          : window.btoa(issue_no),
            mode              : window.btoa(mode),
            keterangan        : result[1],
            st_reject         : window.btoa(result[0])
          },
          success:function(data){
            $("#loading").hide();
            if(data.status === 'OK'){
              swal("Rejected", data.message, "success");
              var urlRedirect = "{{ route('qprs.show', 'param') }}";
              urlRedirect = urlRedirect.replace('param', window.btoa(issue_no));
              window.location.href = urlRedirect;
            } else {
              swal("Cancelled", data.message, "error");
            }
          }, error:function(){ 
            $("#loading").hide();
            swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");
          }
        });
      }).catch(swal.noop)
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
</script>
@endsection