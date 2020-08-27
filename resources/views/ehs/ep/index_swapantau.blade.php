@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        SWAPANTAU
        <small></small>
      </h1>
      <ol class="breadcrumb">
          <li>
            <a href="{{ url('/home') }}">
              <i class="fa fa-dashboard"></i> Home</a>
          </li>
          <li>
            <i class="glyphicon glyphicon-info-sign"></i> EHS 
          </li>
          <li class="active">
            <i class="fa fa-files-o"></i> SWAPANTAU
          </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')


       
      <div class="row" id="field_detail">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border" >
                <h3 class="box-title"><b>SWAPANTAU Harian</b></h3>
             
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>


              </div>

       
            </div>
            <!-- /.box-header -->
            <div class="box-body">


             <div class="form-group">
            {!! Form::open(['url' => route('ehsspaccidents.store_swapantau'), 'method' => 'post', 'class'=>'form-horizontal', 'id'=>'form_swapantau']) !!}

            
            <div class="form-group{{ $errors->has('tgl_pantau') ? ' has-error' : '' }}">
              {!! Form::label('tgl_pantau', 'Tanggal', ['class'=>'col-md-2 control-label']) !!}
                <div class="col-md-4">
                  {!! Form::date('tgl_pantau', \Carbon\Carbon::now(), ['class'=>'form-control']) !!}
                  {!! $errors->first('tgl_pantau', '<p class="help-block">:message</p>') !!}
                </div>
            </div>   


          <div class="form-group{{ $errors->has('outlet') ? ' has-error' : '' }}">
              {!! Form::label('outlet', 'Outlet', ['class'=>'col-md-2 control-label']) !!}
             <div class="col-sm-4">   
                  <select size="1" name="outlet"  
                    class="form-control">
                      <option value="WWT">WWT</option>
                      <option value="STP">STP</option>
                    </select>
                    {!! $errors->first('outlet', '<p class="help-block">:message</p>') !!}
                </div>   
            </div>    




       <div class="form-group has-feedback{{ $errors->has('ph') ? ' has-error' : '' }}">
          {!! Form::label('ph', 'PH', ['class'=>'col-md-2 control-label']) !!}
            <div class="col-md-4">
              <input type="number"  class="form-control col-md-2" id="ph"  name="ph" min="0" max="14" step="0.01"/> 
              {!! $errors->first('ph', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
      

       <div class="form-group has-feedback{{ $errors->has('debit') ? ' has-error' : '' }}">
          {!! Form::label('debit', 'Debit', ['class'=>'col-md-2 control-label']) !!}
            <div class="col-md-4">
              <input type="number"  class="form-control col-md-2" id="debit"  name="debit" min="0" step="0.01" /> 
              {!! $errors->first('debit', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        
          <div class="form-group">
            <div class="col-md-4 col-md-offset-2"> 

                <button style="align:right;"  type="submit" class="btn btn-primary"> <i class="fa fa-btn fa-paper-plane"> </i> Submit</button>       
               <!--  {!! Form::submit('Submit', ['class'=>'btn btn-primary glyphicon glyphicon-floppy-disk', 'id' => 'btn-save']) !!}     -->
           <!--   <a class="btn btn-default glyphicon glyphicon-remove-sign" href="{{ route('mobiles.indexlupaprik') }}"> Batal </a>  -->
            </div>


 
      
      
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
       

          {!! Form::close() !!}

        <!-- /.col -->
      </div>
      <!-- /.row -->

</div>
<div class="box box-primary">
<div class="box-header">
          <h3 class="box-title"><b>Daftar SWAPANTAU</b></h3>
        </div>  
       <div class="box-body">

            <div class="col-sm-2">
              {!! Form::label('filter_tahun', 'Tanggal Awal') !!}
              {!! Form::date('tgl_awal', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Awal', 'id' => 'tgl_awal']) !!}
            </div>

            <div class="col-sm-2">
              {!! Form::label('filter_bulan', 'Tanggal Akhir') !!}
              {!! Form::date('tgl_akhir', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Akhir', 'id' => 'tgl_akhir']) !!}
            </div>

             <div class="col-sm-2">
              {!! Form::label('Action', 'Action') !!}
              <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
                </p>
             </div>
             <br><br><br><br>
 <div class="col-sm-2">
<div class="dataTables_length" style="margin-bottom:30px;" >   
        <table>
       <tr>
       <th><label  style="margin-left:10px;">Outlet</label></th>
       <th></th>
       </tr>
       <tr>
       <td>
         <div id="filter"  style="width:180px;margin-left:10px;">
          <select style="margin-bottom: 8px;" size="1" name="plant" aria-controls="filter_outlet" id="filter_outlet"    class="form-control" style="width: 150px;">
              <option value="" selected="selected">ALL</option>
              <option value="WWT">WWT</option>
              <option value="STP">STP</option>
            </select>
         </div> 
        </td>
        <td style="width:3%"></td>
        <td >  <button class="btn btn-success" style="margin-bottom: 8px;" onclick="refresh()"><i class="fa fa-btn fa-refresh"> </i></button></td>
        </tr>
</table>

</div>
</div>

          <div class="form-group">
        <table id="table_swapantau" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th style='width: 5%;'>No</th>
                    <th style='width: 25%;'>Tanggal</th>
                    <th style='width: 25%;'>Outlet</th>
                    <th style='width: 20%;'>Ph</th>
                    <th style='width: 20%;'>Debit</th>    
                    <th style='width: 5%;'>Action</th>             
                    
                  </tr>
                </thead>
              </table> 
        </div>
      </div>
    </div>
   </div>
  </div>
 </section>
</div>

@endsection

@section('scripts')
<script type="text/javascript" >

  var tableDetail = $('#table_swapantau').DataTable({
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
      "order": [[1, 'asc']],
      processing: true,
      serverSide: true,
       "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
    
      ajax: "{{ route('ehsspaccidents.dashboard_swapantau') }}",
      columns: [
        {data: null, name: null, orderable: false, searchable: false},
        {data: 'tgl_pantau', name: 'tgl_pantau'},
        {data: 'outlet', name: 'outlet'},
        {data: 'ph', name: 'ph'},
        {data: 'debit', name: 'debit'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
      ]
    });

  $("#table_swapantau").on('preXhr.dt', function(e, settings, data) {
        data.tgl_awal = $('input[name="tgl_awal"]').val();
        data.tgl_akhir = $('input[name="tgl_akhir"]').val();
      });

  $('#filter_outlet').on('change', function(){
        tableDetail.column(2).search(this.value).draw();   
    });

   $('#display').click( function () {
      tableDetail.ajax.reload();
      });
  
  function refresh(){
  tableDetail.ajax.reload();
}





  function delete_swapantau(id)
   {
      var msg = 'Yakin hapus data SWAPANTAU?';
      var txt = '';
      //additional input validations can be done hear
      swal({
        title: msg,
        text: txt,
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: 'grey',
        confirmButtonText: '<i class="fa fa-check-circle" ></i> Yes',
        cancelButtonText: '<i  class="fa fa-times" ></i> No',
        allowOutsideClick: true,
        allowEscapeKey: true,
        allowEnterKey: true,
        reverseButtons: false,
        focusCancel: true,
      }).then(function () {
          var urlRedirect = "{{route('ehsspaccidents.delete_swapantau', 'param')}}";    
          urlRedirect = urlRedirect.replace('param', id);
        $.ajax({
          url      : urlRedirect,
          type     : 'GET',
          dataType : 'json',
          success: function(_response){
         if(_response.indctr == '1'){
            swal('Sukses', 'Data Berhasil Dihapus!','success'
            )
        $('.modal').modal('hide');
        tableDetail.ajax.reload();
          } else if(_response.indctr == '0'){
            console.log(_response)
            swal('Terjadi kesalahan saat menghapus', 'Segera hubungi Admin!', 'info'
            )
          }
        },
        error: function(){
          swal(
            'Terjadi kesalahan',
            'Segera hubungi Admin!',
            'info'
            )
        }
        });
       
      }, function (dismiss) {    
        if (dismiss === 'cancel') {
        }
      })
  }

  $('#form_swapantau').submit(function (e, params) {

    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();
      var ph = document.getElementById("ph").value;
    var debit = document.getElementById("debit").value;
      if (ph === "" || debit === "" && (ph ==="" || debit === "")) {
      var info = "Perhatikan inputan anda!";
      swal(info, "Data tidak boleh kosong, mohon untuk diisi!", "info");
      } else {
        swal({
          title: 'Apakah data sudah benar?',
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
        url: "{{ route('ehsspaccidents.store_swapantau') }}",
        type: 'POST',
        data: $('#form_swapantau').serialize(),
        dataType: 'json',
        success: function( _response ){
        if(_response.indctr == '1'){
          swal(
            'Sukses',
            'Data SWAPANTAU Berhasil Ditambahkan!',
            'success'
            )
        var urlRedirect = "{{route('ehsspaccidents.index_swapantau')}}";    
        window.location.href = urlRedirect;
        }  else if(_response.indctr == '2'){
            console.log(_response)
            swal('Data sudah pernah diinput', 'Mohon dicek kembali!', 'info'
            )
        } else if(_response.indctr == '0'){
            console.log(_response)
            swal('Terjadi kesalahan saat menyimpan', 'Mohon hubungi Admin!', 'info'
            )
          }

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
          if (dismiss === 'cancel') {
          }
        })
      }
    }
  });   

      
</script>


@endsection