@extends('layouts.app')
@section('content')
<style>
  table{
    counter-reset:  (rowNumber);
  }
  table tr:not(:first-child) {
    counter-increment:  rowNumber;
  }
  table.autonumber tr.autonumber td:first-child::before{
    content:counter(rowNumber);
  }

  </style>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Laporan Penerimaan Uniform</h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li> 
        <li class="active"><i class="fa fa-files-o"></i> Laporan Penerimaan Uniform </li>
      </ol>
    </section>

    <!-- Main content -->
<section class="content">
@include('layouts._flash')


{{-- TAMPILAN INPUT --}}
 <div class="row" id="field_detail">
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border" style="background-color:lightblue">
        <h3 class="box-title"><b>Formulir LPB Uniform</b></h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
           <!--  <button type="button" class="btn btn-box-tool" data-widget="hide"><i class="fa fa-times"></i></button> -->
        </div>
       </div>
                <!-- /.box-header -->
      <div class="box-body">

        {!! Form::open(['url' => route('mobiles.storelpbuni'),'method' => 'post', 'class'=>'form-horizontal', 'id'=>'form_id']) !!}
        
          <div class="form-group">
            {!! Form::label('lpb', 'No. LPB', ['class'=>'col-md-2 control-label']) !!}
            <div class="col-md-4">
             {!! Form::text('nolpb', $nolpb, ['class'=>'form-control' , 'readonly' => 'true']) !!}
            </div>
          </div>

          <div class="form-group{{ $errors->has('tgllpb') ? ' has-error' : '' }}">
            {!! Form::label('tgllpb', 'Tanggal LPB', ['class'=>'col-md-2 control-label']) !!}
            <div class="col-md-4">
              {!! Form::date('tgllpb', null , ['class'=>'form-control']) !!}
              {!! $errors->first('tgllpb', '<p class="help-block">:message</p>') !!}
            </div>
          </div>

          <div class="form-group{{ $errors->has('supplier') ? ' has-error' : '' }}">
              {!! Form::label('supplier', 'Supplier', ['class'=>'col-md-2 control-label']) !!}
              <div class="col-md-4">
               {!! Form::text('supplier', null, ['class'=>'form-control' ]) !!}
               {!! $errors->first('supplier', '<p class="help-block">:message</p>') !!}
              </div>
          </div>

          <div class="form-group{{ $errors->has('noref') ? ' has-error' : '' }}">
              {!! Form::label('noref', 'No Ref', ['class'=>'col-md-2 control-label']) !!}
              <div class="col-md-4">
                {!! Form::text('noref', null , ['class'=>'form-control']) !!}
                {!! $errors->first('noref',  '<p class="help-block">:message</p>') !!}
              </div>
          </div>

        <hr>
                    
        
                
        <div class="row">     
           <div class="col-md-12">
             <table class="autonumber table table-hover" id="dinamis" width="700px">
                   <tr align="center">
                      <th align="center"> <center> No </center></th>
                      <th width="550px" align="center"> <center> Item </center></th>
                      <th > Qty </th>
                      <th><button type="button" class="btn btn-blue add-row glyphicon glyphicon-plus"></button></th>
                    </tr>
                    <tr class="autonumber" id="row1">
                      <td width="5px"></td>
                      <td> 
                          <select id="uniform1" width="3px" class="form-control" name="uniform[0]" onchange="refreshList()" onkeyup="IgnoreAlpha(event);">
                            <option value="" disabled selected>-Pilihan-</option>  
                              @foreach($callseragam as $row)  
                            <option value="{{$row->kd_uni}}" name="{{$row->kd_uni}}" id="{{$row->kd_uni}}"> {{$row->desc_uni}} </option>
                              @endforeach            
                            </select>  
                      </td>  
                      <td>
                          <div class="form-group{{ $errors->has('qty[0]') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                              <input width="3px" class="form-control" type="number" id="qty1" name="qty[0]" oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')">
                              {!! $errors->first('qty[0]', '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                      </td>
                      <td>
                          <button type="button" class="btn btn-danger delete-row icon-trash glyphicon glyphicon-trash"></button>
                      </td>
                  </tr>
          </table>

          <div class="modal-footer">
             <button type="submit" class="btn btn-primary glyphicon glyphicon-floppy-disk" id="tombolsumbit" title="Submit"> Submit</button>
            {{--  {!! Form::submit('Submit', ['class'=>'btn btn-primary glyphicon glyphicon-floppy-disk', 'id' => 'btn-save']) !!}  --}}
          </div>
        </div>
      </div>
       {!! Form::close() !!}
     </div>
    </div>
   </div>
  </div>
        





{{-- TAMPILAN DAFTAR TABLE --}}
  <div class="row" id="field_detail">
   <div class="col-md-12">
     <div class="box box-primary">
       <div class="box-header with-border" style="background-color:lightblue">
         <h3 class="box-title"><b>Daftar Penerimaan Barang </b> </h3>
         <div class="box-tools pull-right">
           <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
           <!--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
          </div>
        </div>
       <div class="box-body">
         <div class="box-header">
           <p> <a class="btn btn-primary" id="inputlpb">
               <span class="fa fa-plus"></span> Tambah Laporan Penerimaan Barang
               </a>
           </p>
         </div> 
         <table id="tblDetail" class="table table-bordered table-striped  table-sm table-dark table-hover" cellspacing="0" width="100%">
           <thead>
              <tr class="autonumber">
                <th style='width: 1%;'>No</th>
                <th style='width: 7%;'>No LPB</th>
                <th style='width: 10%;'>Tgl LPB</th>                  
                <th style='width: 10%;'>Supplier</th>
                <th style='width: 10%;'>No. Ref</th>
                <th style='width: 7%;'>Action</th>   
              </tr>
            </thead>
          </table> 
         </div>
        </div>
       </div>
      </div>
   </section>
</div>
@endsection


@section('scripts')
<script type="text/javascript">

  $(document).ready(function(){

    var tableDetail = $('#tblDetail').DataTable({
      "columnDefs": [{
        "searchable": false,
        "orderable": false,
        "targets": 0,
      render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
      }
      }],
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
      responsive: true,
      // "searching": false,
      // "scrollX": true,
      // "scrollY": "700px",
      // "scrollCollapse": true,
      // "paging": false,
      // "lengthChange": false,
      // "ordering": true,
      // "info": true,
      // "autoWidth": false,
      "order": [[1, 'desc']],
      processing: true,
    
      ajax: "{{ route('mobiles.dashboardlpbuni') }}",
      columns: [
        {data: null, name: null, orderable: false, searchable: false},
        {data: 'nolpb', name: 'nolpb'},
        {data: 'tgl_lpb', name: 'tgl_lpb'},
	     	{data: 'supplier', name: 'supplier'},
		    {data: 'noref', name: 'noref'},
		    {data: 'action', name: 'action', orderable: false, searchable: false},
		
      ]
    });
	
	 
  });


  $(document).ready(function(){
         $("#field_detail").hide();
      $("#inputlpb").click(function(){
        $("#field_detail").show();
        $("#inputlpb").hide();   
      });
  });

</script>

<script type="text/javascript">
  
   $('#form_id').submit(function (e, params) {
    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();
      for (countLoop = 1; countLoop < i; countLoop++) { 
      var qty = document.getElementById("qty"+(countLoop)).value;
      var uniform = document.getElementById("uniform"+(countLoop)).value; }
      if (qty === "" || uniform === "" && (qty ==="" || uniform === "")) {
      var info = "Perhatikan inputan anda!";
      swal(info, "Data tidak boleh kosong, mohon untuk diisi!", "info");
      } else {
        swal({
          title: 'Apakah data pengajuan sudah benar?',
          text: '',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes!',
          cancelButtonText: '<i class="fa fa-thumbs-down"></i> No!',
          allowOutsideClick: true,
          allowEscapeKey: true,
          allowEnterKey: true,
          reverseButtons: false,
          focusCancel: false,
        }).then(function () {
           $.ajax({
        url: "{{route('mobiles.storelpbuni') }}",
        type: 'POST',
        data: $('#form_id').serialize(),
        dataType: 'json',
        success: function( _response ){
          swal(
            'Sukses',
            "Laporan Penerimaan Barang Berhasil Dibuat!",
            'success'
            )
       
        var urlRedirect = "{{route('mobiles.indexlpbuni')}}";    
        window.location.href = urlRedirect;

        },
        error: function( _response ){
          swal(
            'Terjadi kesalahan',
            'Segera hubungi Admin!',
            'info'
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
</script>

<script>
  var i = 2;
  var actual_id = i;
    $(document).ready(function(){        
        $('#dinamis .add-row').click(function () {   
          // $('#dinamis tr').ready(function(){  
          //   $("select").change(function() {   
          //   $("select").not(this).find("option[value="+ $(this).val() + "]").hide();
          //   });
          // });
          reAssignID(); 
          var template = '<tr  class="autonumber" id="row'+actual_id+'">  <td ></td> <td><select width="3x" class="form-control" id="uniform'+actual_id+'" name="uniform[]" onchange="refreshList()" onkeyup="IgnoreAlpha(event);"> <option value="" disabled selected>-Pilihan-</option>@foreach($callseragam as $row)<option name="{{$row->kd_uni}}" id="{{$row->kd_uni}}" value="{{$row->kd_uni}}"> {{$row->desc_uni}} </option>  @endforeach </select> <td>  <div class="form-group{{ $errors->has('qty[]') ? ' has-error' : '' }}"> <div class="col-md-4"><input width="3px" class="form-control" type="number" id="qty'+actual_id+'"  name="qty[]"> {!! $errors->first('qty[]','<p class="help-block">:message</p>') !!}</div> </div></td>  <td>  <button type="button" class="btn btn-danger delete-row icon-trash glyphicon glyphicon-trash"></button></td>   </tr>'  ; 
          //    $('#row0').remove();
            $('#dinamis').append(template);
                i++;
                refreshList();
            });
                    
            $('#dinamis').on('click', '.delete-row', function () {
                $(this).parent().parent().remove();
                i--;
                refreshList();
             });
      })                 
</script>

<script>
function IgnoreAlpha(e) {
  if (!e) {
    e = window.event;
  }
  if (e.keyCode >= 65 && e.keyCode <= 90) // A to Z
  {
    e.returnValue = false;
    e.cancel = true;
  }
}

function reAssignID(){
  c = i;
    do {
      var rowElement = document.getElementById("row"+c);
      if(typeof(rowElement) != 'undefined' && rowElement != null){
          } else {
            actual_id = c;
            break;
          }
          c--;
          } 
      while (c > 0)
}

function refreshList(){
    $("select").find("option").show();
     $("select").find("option").show();
        for (countLoop = 0; countLoop < i; countLoop++) {
        var selectElement = document.getElementById("uniform"+(countLoop));
        if(typeof(selectElement) != 'undefined' && selectElement != null){
          } else {
            continue;
          }
        var selectedHiddenInput = document.getElementById('uniform'+(countLoop)).value;
        if (selectedHiddenInput != ""){
        $("select").find("option[value=" + selectedHiddenInput + "]").hide();
        $("select").find("option[value=" + selectedHiddenInput + "]").removeAttr('disabled');
        $('#uniform'+(countLoop)).find("option[value=" + selectedHiddenInput + "]").show();
        }
        }
  }

</script>

@endsection