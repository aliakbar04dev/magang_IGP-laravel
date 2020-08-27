<form id="{{$form_id}}">
	<center>
      <input name="_method" type="hidden" value="POST">
      @if (empty($model->pic_approv))
  <input name="id" type="hidden" value="{{base64_encode($model->nm_problem)}}">
      @endif
  <input name="_token" type="hidden" value="{{csrf_token()}}">
    @if (empty($model->pic_approv))
    	{{ Form::button('<span class="glyphicon glyphicon-ok"></span>', array('class'=>'btn btn-xs btn-success','type'=>'submit', 'id'=>'btn_approv_submit','data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Approve Data')) }}
    @endif
    </center>
  </form>
{{-- {!! Form::close()!!} --}}
<script type="text/javascript">
$( document ).ready(function() {
    $("#{{$form_id}}").on('submit', function(e) {
    e.preventDefault();
      var data = $("#{{$form_id}}").serialize();
    swal({
        html: `<ul>
            <li style='text-align:left;'>Apakah anda yakin menyetujui data usulan ini?.</li>
            </ul>`,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        cancelButtonText: 'Batal!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: true
      }).then(function () {
        $.ajax({
        type: "post",
        url: '{{$approv_url}}',
        data: data,
        dataType: "json",
        success: function(data) {
          if(data['status'] == 'OK'){
            swal({
                title: "Usulan Berhasil Disetujui",
                text: data['message'],
                html:
                  'Data Berhasil Disetujui',
                type: "success"
            }).then(function() {
            //   window.location.href = "{{ route('mtcmesin.index') }}"
			$('#reload').click();
            });
          }else{
            swal('Warning!', data['message'], 'error');
          }
          
        },
        error: function(error) {
          swal({
                title: "Mungkin anda tidak berhak menyetujui data ini",
                text: 'Periksa Data Kembali',
                type: "error"
            })
            //   swal('Warning!', ' ', 'error');
            }
        });
      }, function (dismiss) {
        if (dismiss === 'cancel') {
          swal('Cancelled', 'Dibatalkan', 'error');
        }
	});
});
});

</script>



