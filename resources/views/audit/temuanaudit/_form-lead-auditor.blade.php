@include('audit.temuanaudit._detail')
<div class="form-group">
    <div class="col-md-12">
<div class="col-md-12">
<input type="hidden" id="id" value="{{ $get_temuan->id }}">
<table class="table-borderless" style="width: 100%;">
<tr>
    <td style="text-align: right;" colspan="2">
    @if ($get_temuan->status_reject == "R")
        <a href="{{ route('auditors.daftartemuan') }}" id="back_btn" class="btn btn-danger">KEMBALI</a>
        <button type="button" id="submit_revisi" class="btn btn-primary">SUBMIT REVISI</button>
    @else
        <button type="button" id="batal_tolak" class="btn btn-danger" style="margin-left:8px; display:none;">BATAL</button>
        <button type="button" id="tolak" class="btn btn-danger" style="margin-left:8px;">TOLAK TEMUAN</button>
        <button type="submit" id="submit" class="btn btn-primary">SETUJUI TEMUAN</button>
    @endif
    </td>
</tr>
</table>
</div>
</div>
</div>

@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
       
    });


    var tolak_change = 1;

    $('#batal_tolak').click(function(){
      $('#tolak_sec').hide();
      $('#submit').show();
      $('#batal_tolak').hide();
      $('#tolak').text('TOLAK TEMUAN');
      $('#tolak').removeClass('btn-primary');
      $('#tolak').addClass('btn-danger');
      tolak_change = 1;
    });

    $('#tolak').click(function(){
    if (tolak_change == 1){
      $('#tolak_sec').show();
      $('#submit').hide();
      $('#batal_tolak').show();
      $(this).text('SUBMIT TOLAK');
      $(this).removeClass('btn-danger');
      $(this).addClass('btn-primary');
      $('#alasan_reject').focus();
      tolak_change = 2;
    } else if (tolak_change == 2){
    var alasan_tolak_value = document.getElementById('alasan_reject').value.trim();
    var id = document.getElementById('id').value.trim();
    var url = "{{ route('auditors.temuanaudit_sign_lead_tolak', 'param') }}";
    url = url.replace('param', id);

    if (alasan_tolak_value == ''){
      swal(
            'Info',
            'Input alasan yang jelas agar auditee merevisi dengan baik!',
            'info'
            )
    } else {
    swal({
          title: 'TOLAK DAN REVISI?',
          text: '',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, revisi',
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
            'Temuan ini ditolak oleh anda, hubungi pengaju untuk melakukan revisi!',
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
    }
      });

    $('#form_id').submit(function(event) {
    event.preventDefault();

    var id = document.getElementById('id').value.trim();
    var url = "{{ route('auditors.temuanaudit_sign_lead_submit', 'param') }}";
    url = url.replace('param', id);
    swal({
          title: 'Setujui Temuan?',
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

$('#submit_revisi').click(function(){
    var dop = document.getElementById('dop').value.trim();
    var snc = document.getElementById('dop').value.trim();

    var id = document.getElementById('id').value.trim();
    var url = "{{ route('auditors.temuanaudit_sign_lead_revisi', 'param') }}";
    url = url.replace('param', id);

    if (dop == '' || snc == ''){
      swal(
          'Info',
          'Inputan revisi masih kosong! Perhatikan inputan anda!',
          'info'
          )
    } else {
    swal({
          title: 'Submit Revisi Temuan?',
          text: '',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, submit',
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
            'Berhasil disubmit!',
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

