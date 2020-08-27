@extends('layouts.app')
@section('content')
<style type="text/css">

    hr {
       margin-top: 20px;
       margin-bottom: 20px;
       border: 0;
       height: 1px;
       width: 96%;  
       border-top: 1px solid #eeeeee;
    }
  .help-block{
      color: #ff6060;
  }
  .loading {
      background: lightgrey;
      padding: 15px;
      position: fixed;
      border-radius: 4px;
      left: 50%;
      top: 50%;
      text-align: center;
      margin: -40px 0 0 -50px;
      z-index: 2000;
      display: none;
  }

  a, a:hover {
      color: black;
  }

  .form-group.required label:after {
      content: " *";
      color: red;
      font-weight: bold;
  }  

 .error{ color:red; } 
 
    
</style>
<!-- App_IK4 -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        REGISTRASI KARYAWAN
        <small>Karyawan Baru</small>
      </h1>      
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Registrasi Karyawan Baru</li>
      </ol>
    </section>

    <div class="modal fade" id="modalForm" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="modal_content"></div>
        </div>
    </div>
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to delete?</p>
                    <input type="hidden" id="delete_token"/>
                    <input type="hidden" id="delete_id"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger"
                            onclick="ajaxDelete('{{url('laravel-crud-search-sort-ajax-modal-form/delete')}}/'+$('#delete_id').val(),$('#delete_token').val())">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>   

    <div id="content">        
        @include('hr.mobile.regkaryawan.'.$page)
    </div>
    <!-- /.content -->
    <!-- </div> -->
    <!-- /.content-wrapper -->
 
 <div class="loading">
    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i><br/>
    <span>Loading</span>
  </div>   
</div>       
@endsection



@section('scripts')
<script type="text/javascript"> 

function check_disc_datpend(){
  if ($('#disclaimer_datpend').is(':checked')) {    
      $("#btn_next_pend").show();

  }else{
      $("#btn_next_pend").hide();
  }        
}

function check_disc_datmarit(){
  if ($('#disclaimer_datamarital').is(':checked')) {    
      $("#submit_marital").show();

  }else{
      $("#submit_marital").hide();
  }        
}

$('input[type=radio][name=npwp]').change(function() {     
    if ($(this).is(':checked') && $(this).val() == 'have') {
         $("#divinputnpwp").show();
    }else if ($(this).is(':checked') && $(this).val() == 'not_have') {    
        $("#divinputnpwp").hide();
    }
});

$('input[type=radio][name=bpjskes_rad]').change(function() {     
    if ($(this).is(':checked') && $(this).val() == 'have') {
        $('#divinputbpjskes').show();
    }else if ($(this).is(':checked') && $(this).val() == 'not_have') {
        $("#divinputbpjskes").hide();
    }
});

$('input[type=radio][name=bpjsket_rad]').change(function() {     
    if ($(this).is(':checked') && $(this).val() == 'have') {
       $('#divinputbpjsket').show();
    }else if ($(this).is(':checked') && $(this).val() == 'not_have') {
        $('#divinputbpjsket').hide();
    }
});

$("#marital").change(function() {  
    if ($(this).val() == 'TK') {    
        $("#data-marital").hide();
        $("#data-marriage").hide();
        $("#btn_next_marital").show();
    }else {
        $("#data-marriage").show();
        $("#data-marital").show();
        $("#btn_next_marital").hide();
    }
});

$("#status_klg").change(function() {  
    if (($(this).val() == 'I')||($(this).val() == 's')) {    
        $("#data-marriage").show();
        //$("#btn_next_pribadi").show();
    }else {
        $("##data-marriage").hide();
        //$("#btn_next_pribadi").hide();
    }
});

function autoFill() {
  var alamat =  $('#alamat_dom').val();
  var rt =  $('#rt_dom').val();
  var rw =  $('#rw_dom').val();
  var kelurahan =  $('#kelurahan_dom').val();
  var kecamatan =  $('#kecamatan_dom').val();
  var kota =  $('#kota_dom').val();
  var kode_pos =  $('#kode_pos_dom').val();
  $('#alamat_ktp').val(alamat);
  $('#rt_ktp').val(rt);
  $('#rw_ktp').val(rw);
  $('#kelurahan_ktp').val(kelurahan);
  $('#kecamatan_ktp').val(kecamatan);
  $('#kota_ktp').val(kota);
  $('#kode_pos_ktp').val(kode_pos);
};


$(document).on('submit', '#form_datapribadi', function(){
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $('#submit_datprib').html('Saving . .');
    var url = "{{ route('save.datapribadi') }}";
    $.ajax({
        url: url,
        type: 'post',
        data: $('#form_datapribadi').serialize(),
        success: function(data) {
          if($.isEmptyObject(data.error)){
              $(".print-error-msg").hide();
              $("#submit_datprib").hide();
              $("#data-pribadi *").attr("disabled", "disabled").off('click');
              $("#btn_next_pribadi").show();
          }else{
              printErrorMsg(data.error);
          }           
        }
    });
    // }
    function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $('#submit_datprib').html('Submit');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }

})


$(document).on('submit', '#form_dataorgtua', function(){
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $('#submit_almtklrg').html('Saving . .');
    var url = "{{ route('save.dataorgtua') }}";
    $.ajax({
        url: url,
        type: 'post',
        data: $('#form_dataorgtua').serialize(),
        success: function(data) {
          if($.isEmptyObject(data.error)){
              $(".print-error-msg").hide();
              printSuccessMsg();
              $('#submit_almtklrg').hide();
              $("#data-pribadi *").attr("disabled", "disabled").off('click');
              $("#btn-selesai").show();
          }else{
              printErrorMsg(data.error);
          }           
        }
    });
    // }

    var $success_msg = $(".print-success-msg");
    var $error_msg = $(".print-error-msg");

    function printSuccessMsg() {
        $success_msg.html('Data telah berhasil disimpan!');
        $success_msg.css('display','block');
        $success_msg.delay(5000).fadeOut(350);
        //$('#contact-form')[0].reset();
    }

    function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $('#submit_datprib').html('Submit');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }

})

//data pendukung
 $(document).on('submit', '#form_datapendukung', function(){
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $('#submit_datapendukung').html('Saving . .');
    var url = "{{ route('save.datapendukung') }}";
    $.ajax({
        url: url,
        type: 'post',
        data: $('#form_datapendukung').serialize(),
        success: function(data) {
          if($.isEmptyObject(data.error)){
              $("#submit_datprib").hide();
              $("#data-pribadi *").attr("disabled", "disabled").off('click');
          }else{
              printErrorMsg(data.error);
          }           
        }
    });
    // }
    function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $('#send_form').html('Submit');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }

})
    
$('#disclaimer_datprib').change(function() {
    if(this.checked) {
        $("#submit_datprib").show();
        $("#submit_datprib").html('Submit');
    }else{
        $("#submit_datprib").hide();
    }        
});

// $('#disclaimer_datpend').change(function() {
//     if(this.checked) {
//         $("#btn_next_pend").show();

//     }else{
//         $("#btn_next_pend").hide();
//     }        
// });




 $('#disclaimer_datpendu').change(function() {
    if(this.checked) {
        $("#send_form").show();
        $("#send_form").html('Submit');
    }else{
        $("#send_form").hide();
    }        
});

$('#disclaimer_datalmtklrg').change(function() {
    if(this.checked) {
        $("#submit_almtklrg").show();
    }else{
        $("#submit_almtklrg").hide();
    }        
});


</script>

<script>
$(document).on('submit', '#form_datapendukung', function(){
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $('#send_form').html('Sending..');
    var url = "{{ route('save.datapendukung') }}";
    $.ajax({
        url: url,
        type: 'post',
        data: $('#form_datapendukung').serialize(),
        success: function(data) {
        if($.isEmptyObject(data.error)){
             printSuccessMsg();
            $(".print-error-msg").hide();
            $("#send_form").hide();
            $("#btn_next_pendukung").show();
            $("#data-pendukung *").attr("disabled", "disabled").off('click');
        }else{
            printErrorMsg(data.error);
        }
       
        }
    });
    // }
    var $success_msg = $(".print-success-msg");
    var $error_msg = $(".print-error-msg");

    function printSuccessMsg() {
        $success_msg.html('Data telah berhasil disimpan!');
        $success_msg.css('display','block');
        $success_msg.delay(5000).fadeOut(350);
        //$('#contact-form')[0].reset();
    }

    function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $('#send_form').html('Submit');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }
})

//data marital
$(document).on('submit', '#form_datamarital', function(){
  $.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
  });
  $('#submit_marital').html('Saving . .');
  var url = "{{ route('save.datamarital') }}";
  $.ajax({
      url: url,
      type: 'post',
      data: $('#form_datamarital').serialize(),
      success: function(data) {
        if($.isEmptyObject(data.error)){
            $(".print-error-msg").hide();
            $("#submit_marital").hide();
            $("#btn_next_marital").show();
            
        }else{
            printErrorMsg(data.error);
        }           
      }
  });
  // }
  function printErrorMsg (msg) {
      $(".print-error-msg").find("ul").html('');
      $(".print-error-msg").css('display','block');
      $('#send_form').html('Submit');
      $.each( msg, function( key, value ) {
          $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
      });
  }

})



</script>
@endsection
