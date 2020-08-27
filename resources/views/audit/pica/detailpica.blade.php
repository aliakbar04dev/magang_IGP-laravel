@extends('layouts.app')
@section('content')

<style>

td, th {
    padding: 8px 10px 8px 0px;;
}

.tabledetail > thead > tr > th, .tabledetail > tbody > tr > th, .tabledetail > tfoot > tr > th, .tabledetail > thead > tr > td, .tabledetail > tbody > tr > td, .tabledetail > tfoot > tr > td {
    border: 1px solid #130d0d;
}

.bubble{
    background-color: #f2f2f2;
    color:black;
    padding: 8px;
    /* box-shadow: 0px 0px 15px -5px gray; */
    /* border-radius: 10px 10px 0px 0px; */
}

.bubble-content{
    background-color: #fff;
    padding: 10px;
    margin-top: -5px;
    /* border-radius: 0px 10px 10px 10px; */
    /* box-shadow: 2px 2px #dfdfdf; */
    box-shadow: 0px 0px 10px -5px gray;
    margin-bottom:10px;
}

textarea{
    resize:none;
    background-color: white;
}

 /* The switch - the box around the slider */
 .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #DF2D36;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #62CA29;;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
} 



</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Internal Audit
            <small>Detail PICA Audit</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Detail PICA Audit</li>
        </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
        @include('layouts._flash')
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Detail PICA Audit</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        @include('audit.pica._detail')
                    </div>
                    <!-- ./box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection


@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
      $(".select2").select2();
});
        var current = 1;
        var total_coa = $('.next_coa').length
        $('.next_coa').click(function(){
            $('#containment_'+current).hide();
                current++;
            $('#containment_'+current).show();
            if(current == total_coa){
                $('.next_coa').attr('disabled', true);
                $('.prev_coa').attr('disabled', false);
            }
        });

        $('.prev_coa').click(function(){
            $('#containment_'+current).hide();
                current--;
            $('#containment_'+current).show();

            if(current == 1){
                $('.next_coa').attr('disabled', false);
                $('.prev_coa').attr('disabled', true);
            }
        });

        $('.detail').click(function(){
            $('html, body').animate({
            scrollTop: $(this).offset().top -20
        }, 500);
            
        });

        // function statusqa1(){
        //     alert('test');
        // }

        // function statusqa2(){
        //     alert('test');
        // }

        $('.statusqa1').change(function(){
            var finding_no = $(this).attr('finding_no');
            var index = $(this).attr('index');
            var token = document.getElementsByName('_token')[0].value.trim();
            var checkboxval = $(this).val();
            var url = "{{ route('auditors.update_statusqa1') }}"
            var ischecked= $(this).is(':checked');
            if(!ischecked){
                checkboxval = null;
            }
            $('.statusqa1').prop('disabled', true);
            $.ajax({
                url      : url,
                type     : 'POST',
                dataType : 'json',
                data     : {
                    finding_no : finding_no,
                    index : index,
                    value : checkboxval,
                    _token : token,
                },
                success: function( _response ){
                    // console.log( _response.indicator );
                    if ( _response.indicator == '1'){
                        $('.statusqa1').prop('disabled', false);
                    } else {
                        swal(
                            'Terjadi kesalahan',
                            'Cek koneksi internet atau hubungi admin!',
                            'info'
                            )
                            location.reload();
                    }
                 },
                    error: function( _response ){
                        swal(
                            'Terjadi kesalahan',
                            'Segera hubungi Admin!',
                            'error'
                            )
                        }
                    });
        });

        $('.statusqa2').change(function(){
            var pica_id = $(this).attr('pica_id');
            var rca = $(this).attr('rca');
            var why = $(this).attr('why');
            var token = document.getElementsByName('_token')[0].value.trim();
            var checkboxval = $(this).val();
            var url = "{{ route('auditors.update_statusqa2') }}"

            var ischecked= $(this).is(':checked');
            if(!ischecked){
                checkboxval = null;
            }
            $('.statusqa2').prop('disabled', true);
            $.ajax({
                url      : url,
                type     : 'POST',
                dataType : 'json',
                data     : {
                    id : pica_id,
                    rca : rca,
                    why : why,
                    value : checkboxval,
                    _token : token,
                },
                success: function( _response ){
                    // console.log( _response.indicator );
                    if ( _response.indicator == '1'){
                        $('.statusqa2').prop('disabled', false);
                    } else {
                        swal(
                            'Terjadi kesalahan',
                            'Cek koneksi internet atau hubungi admin!',
                            'info'
                            )
                            location.reload(); 
                    }

                 },
                    error: function( _response ){
                        swal(
                            'Terjadi kesalahan',
                            'Segera hubungi Admin!',
                            'error'
                            )
                        }
                    });
        });

        $('.statusqa3').change(function(){
            var pica_id = $(this).attr('pica_id');
            var rca = $(this).attr('rca');
            var why = $(this).attr('why');
            var token = document.getElementsByName('_token')[0].value.trim();
            var checkboxval = $(this).val();
            var url = "{{ route('auditors.update_statusqa3') }}"

            var ischecked= $(this).is(':checked');
            if(!ischecked){
                checkboxval = null;
            }
            $('.statusqa3').prop('disabled', true);
            $.ajax({
                url      : url,
                type     : 'POST',
                dataType : 'json',
                data     : {
                    id : pica_id,
                    rca : rca,
                    why : why,
                    value : checkboxval,
                    _token : token,
                },
                success: function( _response ){
                    if ( _response.indicator == '1'){
                        $('.statusqa3').prop('disabled', false);
                    } else {
                        swal(
                            'Terjadi kesalahan',
                            'Cek koneksi internet atau hubungi admin!',
                            'info'
                            )
                            location.reload();
                    }
                 },
                    error: function( _response ){
                        swal(
                            'Terjadi kesalahan',
                            'Segera hubungi Admin!',
                            'error'
                            )
                        }
                    });
        });

</script>

@endsection
