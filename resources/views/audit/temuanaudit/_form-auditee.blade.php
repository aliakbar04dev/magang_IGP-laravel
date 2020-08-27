@include('audit.temuanaudit._detail')
<div class="form-group">
<div class="col-md-12">
    <input type="hidden" id="jumlah_coa" name="jumlah_coa" value="1">
    <input type="hidden" id="id" name="id" value="{{ $get_temuan->id }}">
    <input type="hidden" id="finding_id" name="finding_id" value="{{ $get_temuan->finding_no }}">
<table id="containment" class="table-borderless" style="width: 100%;">
<tr>
    <td colspan="3">
        <label>CONTAINMENT ACTION</label>
        <textarea rows="4" style="background-color: #fff" id="coa" name="coa[]" class="form-control" required></textarea>
    </td>
</tr>
<tr>
    <td>
        <label>PIC : <div style="display: inline;color:green;" id="nama1"> - </div></label>
        <input style="background-color:white;" class="form-control" id="pic1" name="pic[]" onclick="popupKaryawan(this.id)" data-toggle="modal" data-target="#karyawanModal" onkeydown="return false" required>
    </td>
    <td>
        <label>DUE DATE</label>
        <input type="date" class="form-control" id="due_date" name="due_date[]" style="padding-top: 0px;" required>
    </td>
    <td>
        <label>TARGET ROOT CAUSE & CORRECTIVE ACTION must be submit at (date)</label>
        <input type="date" class="form-control" id="target_date" name="target_date[]" style="padding-top: 0px;" required>
    </td>
</tr>
</table>
<button id="add_coa" type="button" class="btn btn-success">ADD ANOTHER CONTAINMENT OF ACTION</button>

<table class="table-borderless" style="width: 100%;">
<tr>
    <td>
        <div class="checkbox">
            <label><input type="checkbox" id="sign" name="sign" value="1">Dengan ini saya menandatangani temuan audit diatas</label>
        </div>
    </td>
    <td style="text-align: right;" colspan="2">
        <button type="submit" id="submit" class="btn btn-primary">SUBMIT</button>
    </td>
</tr>
</table>
</div>
</div>

        <!-- Modal Karyawan -->
        @include('audit.popup.karyawanModal')

@section('scripts')
<script type="text/javascript">
       var i = 2;
        var jumlah_coa = 1;
    $(document).ready(function(){
 
        $(document).on('click', '#add_coa', function(){
          $('#containment').append('\
          <tr class="row'+i+'">\
    <td colspan="3">\
        <label>CONTAINMENT ACTION<button id="'+i+'" type="button" class="btn btn-danger btn-xs" onclick="delete_row(this.id)">DELETE</button></label>\
        <textarea rows="4" style="background-color: #fff" id="coa" name="coa[]" class="form-control" required></textarea>\
    </td>\
</tr>\
<tr class="row'+i+'">\
    <td>\
        <label>PIC : <div style="display: inline;color:green;" id="nama'+i+'"> - </div></label>\
        <input style="background-color:white;" class="form-control" id="pic'+i+'" name="pic[]" onclick="popupKaryawan(this.id)" data-toggle="modal" data-target="#karyawanModal" onkeydown="return false" required>\
    </td>\
    <td>\
        <label>DUE DATE</label>\
        <input type="date" class="form-control" id="due_date" name="due_date[]" style="padding-top: 0px;" required>\
    </td>\
    <td>\
        <label>TARGET ROOT CAUSE & CORRECTIVE ACTION must be submit at (date)</label>\
        <input type="date" class="form-control" id="target_date" name="target_date[]" style="padding-top: 0px;" required>\
    </td>\
</tr>\
          ');
          i++;
          jumlah_coa++;
          document.getElementById('jumlah_coa').value = jumlah_coa;
      });
    });

    $('#form_id').submit(function(event) {
    event.preventDefault();
    // var coa = document.getElementById('coa').value;
    // var pic = document.getElementById('pic').value;
    // var due_date = document.getElementById('due_date').value;
    // var target_date = document.getElementById('target_date').value;
    var sign = document.getElementById('sign').checked;
    
    const due_date_val = new Date(due_date);
    const target_date_val = new Date(target_date);
    // const diffTime = Math.abs(target_date_val - due_date_val);
    // const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
    // console.log(diffDays);
    // coa == '' || pic == '' || due_date == '' || target_date == '' || 
    if (sign == ''){
        swal(
            'Info',
            'Form yang diisi belum lengkap!',
            'info'
            )        
            return;
    }

    if (target_date_val < due_date_val){
        swal(
            'Info',
            'Perhatikan inputan pada Target Root dan Due Date!',
            'info'
            )        
            return;
    }

    var id = document.getElementById('id').value.trim();
    var url = "{{ route('auditors.temuanaudit_sign_auditee_submit', 'param') }}";
    url = url.replace('param', id);
    // alert(id);
    // alert(url);
    swal({
          title: 'Periksa sebelum tanda tangan, yakin ingin submit?',
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
});

 function delete_row(ths){
    var id = ths;
    $('.row'+id).remove();
    jumlah_coa--;
    document.getElementById('jumlah_coa').value = jumlah_coa;

     }

function popupKaryawan(ths) {
    var nama = ths.substring(3);
    var myHeading = "<p>Popup Karyawan AUDITEE</p>";
    $("#karyawanModalLabel").html(myHeading);
    var url = "{{ route('datatables.popupKaryawanIA') }}";
    var lookupKaryawan = $('#lookupKaryawan').DataTable({
        processing: true,
        serverSide: true,
        "pagingType": "numbers",
        ajax: url,
        "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
        responsive: true,
        // "scrollX": true,
        // "scrollY": "500px",
        // "scrollCollapse": true,
        "order": [[1, 'asc']],
        columns: [
            { data: 'npk', name: 'npk'},
            { data: 'nama', name: 'nama'},
            { data: 'desc_dep', name: 'desc_dep'}
        ],
        "bDestroy": true,
        "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupKaryawan tbody').on( 'dblclick', 'tr', function () {
            var dataArr = [];
            var rows = $(this);
            var rowData = lookupKaryawan.rows(rows).data();
            $.each($(rowData),function(key,value){
                document.getElementById(ths).value = value["npk"];
                document.getElementById('nama'+nama).innerHTML = value["nama"];
                // document.getElementById('listauditee').value += value["nama"] + ',  ';
                $('#karyawanModal').modal('hide');
            });
        });
        // $('#karyawanModal').on('hidden.bs.modal', function () {
        // });
    },
    });
}

</script>

@endsection

