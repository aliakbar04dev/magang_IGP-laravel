@include('audit.temuanaudit._detail')
<div class="form-group">
        <div class="col-md-12">
<table class="table-borderless" style="width: 100%;">
<tr>
    <td>
        <div class="checkbox">
            <input type="hidden" id="id" value="{{ $get_temuan->id }}">
            <label><input type="checkbox" id="sign" name="sign" value="2">Dengan ini saya menandatangani temuan audit diatas</label>
        </div>
    </td>
    <td style="text-align: right;" colspan="2">
      <button type="button" id="batal_tolak" class="btn btn-danger" style="margin-left:8px; display:none;">BATAL</button>
        <button type="button" id="tolak" class="btn btn-danger" style="margin-left:8px;">TOLAK</button>
        <button type="submit" id="submit" class="btn btn-primary">SETUJUI</button>
    </td>
</tr>
</table>
</div>
</div>

@section('scripts')
<script type="text/javascript">
    $('#form_id').submit(function(event) {
    event.preventDefault();
    var sign = document.getElementById('sign').checked;

    if (sign == ''){
        swal(
            'Info',
            'Form yang diisi belum lengkap!',
            'info'
            )        
            return;
    }

    var id = document.getElementById('id').value.trim();
    var url = "{{ route('auditors.temuanaudit_sign_auditor_submit', 'param') }}";
    url = url.replace('param', id);
    swal({
          title: 'Setujui (tanda tangan) temuan audit ini?',
          text: '',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, setujui',
          cancelButtonText: 'Batal',
          allowOutsideClick: true,
          allowEscapeKey: true,
          allowEnterKey: true,
          reverseButtons: false,
          focusCancel: false,
        }).then(function () {
        $.ajax({
        url: url,
        type: 'post',
        data: $('#form_id').serialize(), // Remember that you need to have your csrf token included
        dataType: 'json',
        success: function( _response ){
          swal(
            'Sukses',
            'Berhasil disetujui!',
            'success'
            ).then(function (){
                $(".btn").prop("disabled", true);                
                // Simulate an HTTP redirect:
                window.location.replace("{{ route('auditors.daftartemuan') }}");
            });
        },
        error: function( _response ){
          swal(
            'Terjadi kesalahan',
            'Segera hubungi Admin!',
            'error'
            )
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
});

var tolak_change = 1;

$('#batal_tolak').click(function(){
      $('#tolak_sec').hide();
      $('#submit').show();
      $('#batal_tolak').hide();
      $('#tolak').text('TOLAK');
      $('#tolak').removeClass('btn-primary');
      $('#tolak').addClass('btn-danger');
      tolak_change = 1;
      $('.checkbox').show();
    });

$('#tolak').click(function() {
  if (tolak_change == 1){
      $('#tolak_sec').show();
      $('#submit').hide();
      $('#batal_tolak').show();
      $(this).text('SUBMIT TOLAK');
      $(this).removeClass('btn-danger');
      $(this).addClass('btn-primary');
      $('#alasan_reject').focus();
      $('.checkbox').hide();
      tolak_change = 2;
  } else if (tolak_change == 2) {
    var sign = document.getElementById('sign').checked;
    var id = document.getElementById('id').value.trim();
    var url = "{{ route('auditors.temuanaudit_sign_auditor_tolak', 'param') }}";
    url = url.replace('param', id);
    swal({
          title: 'Tolak Containment of Action temuan audit ini?',
          text: '',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, tolak',
          cancelButtonText: 'Batal',
          allowOutsideClick: true,
          allowEscapeKey: true,
          allowEnterKey: true,
          reverseButtons: false,
          focusCancel: false,
        }).then(function () {
        $.ajax({
        url: url,
        type: 'post',
        data: $('#form_id').serialize(), // Remember that you need to have your csrf token included
        dataType: 'json',
        success: function( _response ){
          swal(
            'Sukses',
            'Berhasil ditolak!',
            'success'
            ).then(function (){
                $(".btn").prop("disabled", true);                
                // Simulate an HTTP redirect:
                window.location.replace("{{ route('auditors.daftartemuan') }}");
            });
        },
        error: function( _response ){
          swal(
            'Terjadi kesalahan',
            'Segera hubungi Admin!',
            'error'
            )
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
});

</script>

@endsection

