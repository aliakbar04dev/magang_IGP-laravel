$(document).ready(function () {

  // Encode the String
  // var encodedString = btoa(string);
  // Decode the String
  // var decodedString = atob(encodedString);
  
  // confirm delete
  $(document.body).on('submit', '.js-confirm', function (event, params) {
    var $el  = $(this);
    var text = $el.data('confirm') ? $el.data('confirm') : 'Anda yakin melakukan tindakan ini?';

    var localParams = params || {};
    if (!localParams.send) {
        event.preventDefault();
        //additional input validations can be done hear
        swal({
        title: text,
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
        // swal(
        //   'Deleted!',
        //   'Your file has been deleted.',
        //   'success'
        // )
        //remove these events;
        //window.onkeydown = null;
        //window.onfocus = null;
        $(event.currentTarget).trigger(event.type, { 'send': true });
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

 $('[data-toggle="tooltip"]').tooltip();

  // add selectize to select element
  // $('.js-selectize').selectize({
  //   sortField: 'text'
  // });

  // delete menggunakan ajax
  $(document.body).on('submit', '.js-ajax-delete', function (event, params) {
    
    var $el  = $(this);
    var id_table = $(this).attr('id-table');
    var text = $el.data('confirm') ? $el.data('confirm') : 'Anda yakin melakukan tindakan ini?';

    var localParams = params || {};
    if (!localParams.send) {
        event.preventDefault();
        //additional input validations can be done hear
        swal({
        title: text,
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
        // swal(
        //   'Deleted!',
        //   'Your file has been deleted.',
        //   'success'
        // )
        //remove these events;
        //window.onkeydown = null;
        //window.onfocus = null;
        $(event.currentTarget).trigger(event.type, { 'send': true });
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
    } else {
      // disable behaviour default dari tombol submit
      event.preventDefault();
      // hapus data buku dengan ajax
      $.ajax({
        type     : 'POST',
        url      : $(this).attr('action'),
        dataType : 'json',
        data     : {
          _method : 'DELETE',
          // menambah csrf token dari Laravel
          _token  : $( this ).children( 'input[name=_token]' ).val()
        },
        success:function(data){
          if(data.status === 'OK'){
            //auto expand collapse
            if(id_table != null && id_table != '') {
              var table = $('#' + id_table).DataTable();
              for($i = 0; $i < table.rows().count(); $i++) {
                var row = table.row($i);
                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                }
              }
              $('#' + id_table).removeClass('shown');
            }
            var form_id = data.id;
            form_id = form_id.split('-').join('');
            form_id = form_id.split('/').join('');
            form_id = form_id.split('=').join('');
            // cari baris yang dihapus
            baris = $('#form-'+form_id).closest('tr');
            // hilangkan baris (fadeout kemudian remove)
            baris.fadeOut(300, function() {$(this).remove()});
            swal("Deleted!", data.message, "success");
          } else {
            swal("Cancelled", data.message, "error");
          }
        }, error:function(){ 
          swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");
        }
      });
    }
  });
});