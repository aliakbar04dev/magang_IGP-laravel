@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Production 
      <small>POS</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ route('prodpos.index') }}"><i class="fa fa-files-o"></i>Production - POS</a></li>
      <li class="active">Skill per POS</li> 
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Skill Per POS</h3>
      </div>
      <!-- /.box-header -->
      
      <div class="box-body form-horizontal"> 
        @permission('prod-pos')
        <p>
          <a class="btn btn-primary" href="{{ route('prodpos.create') }}"><span class="fa fa-plus"></span> Add POS</a>
        </p>
        @endpermission        
        <!-- /.form-group -->
        <div class="form-group">
          <div class="col-sm-4">
           {!! Form::label('plant', 'Plant') !!}
              <select id="plant" name="plant" class="form-control select2">
                <option value="ALL">ALL</option>         
                @foreach($plants->get() as $kodePlant)
                <option value="{{$kodePlant->kd_plant}}"
                @if (!empty($plant))
                {{base64_decode($kodePlant->kd_plant) == base64_decode($plant) ? 'selected="selected"' : '' }}
                @endif >{{$kodePlant->nm_plant}}</option>      
                @endforeach
              </select>   
          </div>
         
        </div>

        <div class="form-group">  
          <div class="col-md-2">
            {!! Form::label('work_center', 'Work Center (F9)') !!}
            <div class="input-group"> 
              {!! Form::text('work_center', null, ['class'=>'form-control','onkeydown' => 'keyPressed(event)','onchange' => 'validateWorkCenter()']) !!}
               <span class="input-group-btn">
                    <button id="btnWorkCenter" type="button" class="btn btn-info" >
                    <label class="glyphicon glyphicon-search"></label>
                    </button>
                  </span>
              {!! $errors->first('line', '<p class="help-block">:message</p>') !!}
            </div>
          </div>  
          <div class="col-md-4">
            {!! Form::label('nm_pros', 'Nama Work Center') !!}
            {!! Form::text('nm_pros', null, ['class'=>'form-control','readonly'=>'true']) !!}
            {!! $errors->first('nm_pros', '<p class="help-block">:message</p>') !!}
          </div>    
          
          
        </div>

        <!-- /.form-group -->
        <div class="form-group">
          <div class="col-sm-2">
            <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
          </div>
        </div>
        <!-- /.form-group -->
      </div>
      <!-- /.box-body -->

      <div class="box-body">
        <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
          <thead> 
            <tr>
              <th style="width: 1%;" rowspan="1">NO </th>
              <th style="width: 5%;" rowspan="1">ID </th>
              <th style="width: 5%;" rowspan="1">KODE PLANT</th>
              <th style="width: 5%;" rowspan="1">KODE WORKCENTER</th>
              <th style="width: 5%;" rowspan="1">POS</th>
              <th style="width: 5%;" rowspan="1">POS CODE</th>
              <th style="width: 5%;" rowspan="1">MIN SKILL</th> 
              <th style="width: 5%;" rowspan="1">ZONA</th>
              <th style="width: 5%;" rowspan="1">STATUS</th>                         
            </tr>
           
          </thead>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->
  @include('prod.prodpos.popup.workCenterModal')

</div>
<!-- /.content-wrapper -->
@endsection
<!-- Modal Line -->

@section('scripts')
<script type="text/javascript">

  //Initialize Select2 Elements
  $(".select2").select2();

  function keyPressed(e) {
    if(e.keyCode == 120) { //F9

      popupWorkCenter();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('work_center').focus();
    }
  }

    function popupWorkCenter() {
     $('#workCenterModal').modal('show');

    var myHeading = "<p>Popup Work Center</p>";
    $("#workCenterModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupWorkCenter', 'param') }}';
    var plant = $('select[name="plant"]').val();
    url = url.replace('param', window.btoa(plant));
    
    var lookupWorkCenter = $('#lookupWorkCenter').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
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
        { data: 'kd_pros', name: 'kd_pros'},
        { data: 'nm_pros', name: 'nm_pros'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        
        $('#lookupWorkCenter tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupWorkCenter.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("work_center").value = value["kd_pros"];
            document.getElementById("nm_pros").value = value["nm_pros"];
            $('#workCenterModal').modal('hide');
            validateWorkCenter();
           
          });
        });
        $('#workCenterModal').on('hidden.bs.modal', function () {
          var kd_pros = document.getElementById("work_center").value.trim();
          if(kd_pros === '') {
            document.getElementById("nm_pros").value = "";
            $('#work_center').focus();
          } else {

          }
        });
      },
    });
  }
  function validateWorkCenter() {
    var kd_pros = document.getElementById('work_center').value;

    if(kd_pros !== '') {
      var url = '{{ route('datatables.validasiWorkCenter', ['param']) }}';
      url = url.replace('param', window.btoa(kd_pros));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("work_center").value = result["kd_pros"];
          document.getElementById("nm_pros").value = result["nm_pros"];
          //document.getElementById('kd_mesin').focus();
        } else {
          document.getElementById("work_center").value = "";
          document.getElementById("nm_pros").value = "";
          //document.getElementById("kd_line").focus();
          swal("Kode Work Center tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }

      });
    } else {
      document.getElementById("work_center").value = "";
      document.getElementById("nm_pros").value = "";
    }
  }



    $('#btnWorkCenter').click(function(){
      popupWorkCenter();
    });


  //document.getElementById("site").focus();
  $(document).ready(function(){
    var url = '{{ route('prodpos.dashboard') }}';
    var tableMaster = $('#tblMaster').DataTable({
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
      "order": [[1, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
      {data: null, name: null},
      {data: 'id', name: 'id'},
      {data: 'kd_plant', name: 'kd_plant'},
      {data: 'nm_pros', name: 'nm_pros'},
      {data: 'pos', name: 'pos'},
      {data: 'pos_code', name: 'pos_code'},
      {data: 'min_skill', name: 'min_skill'},
      {data: 'zona', name: 'zona'},    
      {data: 'status', name: 'status'} ,  
      ],
    });
   
    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.plant = $('select[name="plant"]').val();
      data.workCenter = $('#work_center').val();
      
    });
    //firstLoad
    tableMaster.ajax.reload();

    $('#display').click( function () {
      tableMaster.ajax.reload();
    });   

  });

</script>
@endsection