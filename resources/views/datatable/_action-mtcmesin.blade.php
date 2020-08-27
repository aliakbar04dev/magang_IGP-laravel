{!! Form::model($model, ['url' => 'javascript:void(0)', 'method' => 'delete', 'class' => $class, 'id' => $form_id, 'id-table' => $id_table] ) !!}
	<center>
	<a class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Ubah Data" href="{{ $edit_url }}"><span class="glyphicon glyphicon-edit"></span></a>
	@if (!empty($print_url))
	    <a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Print Data" href="{{ $print_url }}"><span class="glyphicon glyphicon-print"></span></a>
	@endif
	@if (!empty($download_url))
	    <a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Download Data" href="{{ $download_url }}"><span class="glyphicon glyphicon-download-alt"></span></a>
	@endif
	@if (empty($kdMesinDel))
    	{{ Form::button('<span class="glyphicon glyphicon-trash"></span>', array('class'=>'btn btn-xs btn-danger','type'=>'submit', 'id'=>'btn_del_submit','data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Hapus Data')) }}
    @endif
    </center>
{!! Form::close()!!}
<script type="text/javascript">
$( document ).ready(function() {
    $("#btn_del_submit").on('click', function(e) {
    e.preventDefault();
      var data = $("#{{$form_id}}").serialize();
    swal({
        html: `<ul>
            <li style='text-align:left;'>Apakah anda yakin menghapus data mesin ini?.</li>
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
        url: '{{$form_url}}',
        data: data,
        dataType: "json",
        success: function(data) {
          if(data['status'] == 'OK'){
            swal({
                title: "Berhasil!",
                text: data['message'],
                html:
                  'Data Berhasil Dihapus',
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
                title: "Mungkin anda tidak berhak menghapus data ini",
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



