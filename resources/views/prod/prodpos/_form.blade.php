<div class="box-body ">
  <div class="form-group">
      <div class="col-md-4">
        {!! Form::label('id', 'ID') !!}
        {!! Form::text('id', null, ['class'=>'form-control','required','readonly'=>'']) !!}
        
      </div>
  </div>

	<div class="form-group">
    <div class="col-sm-4">
       {!! Form::label('kd_plant', 'Plant') !!}
          <select id="kd_plant" name="kd_plant" class="form-control select2">
            <option value="ALL">ALL</option>         
            @foreach($plants->get() as $kodePlant)
            <option value="{{$kodePlant->kd_plant}}"
            @if (!empty($prodpos->kd_plant))
            {{$kodePlant->kd_plant == $prodpos->kd_plant ? 'selected="selected"' : '' }}
            @endif >{{$kodePlant->nm_plant}}</option>      
            @endforeach
          </select>   
      </div>
     
    </div>

    <div class="form-group">  
      <div class="col-md-2">
        {!! Form::label('kd_wc', 'Work Center (F9)') !!}
        <div class="input-group"> 
          {!! Form::text('kd_wc', null, ['class'=>'form-control','onkeydown' => 'keyPressed(event)','onchange' => 'validateWorkCenter()']) !!}
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
      <div class="form-group">  
        <div class="col-md-2">
          {!! Form::label('pos', 'POS ') !!}
          <div class="input-group"> 
            {!! Form::text('pos', null, ['class'=>'form-control']) !!}
            {!! $errors->first('line', '<p class="help-block">:message</p>') !!}
          </div>
        </div>  
        <div class="col-md-4">
          {!! Form::label('nm_pos', 'Nama POS') !!}
          {!! Form::text('pos_code', null, ['class'=>'form-control']) !!}
          {!! $errors->first('nm_pos', '<p class="help-block">:message</p>') !!}
        </div>   
      </div>
      <div class="form-group">
          <div class="col-sm-4">
           {!! Form::label('skill', 'Skill') !!}
              <select name="skill" aria-controls="filter_status" 
                class="form-control select2">
                  <option value="1" @if (!empty($prodpos->min_skill) &&"1" == $prodpos->min_skill) selected="selected" @endif>1</option>
                  <option value="2" @if (!empty($prodpos->min_skill) &&"2" == $prodpos->min_skill) selected="selected" @endif>2</option>
                  <option value="3" @if (!empty($prodpos->min_skill) &&"3" == $prodpos->min_skill) selected="selected" @endif>3</option>
                  <option value="4" @if (!empty($prodpos->min_skill) &&"4" == $prodpos->min_skill) selected="selected" @endif>4</option>
                </select>
          </div>
        </div>
         <div class="form-group">
          <div class="col-sm-4">
           {!! Form::label('zona', 'Zona') !!}
              <select name="zona" aria-controls="filter_status" 
                class="form-control select2">
                  <option value="G" @if (!empty($prodpos->st_pos) &&"G" == $prodpos->st_pos) selected="selected" @endif>Green</option>
                  <option value="Y" @if (!empty($prodpos->st_pos) &&"Y" == $prodpos->st_pos) selected="selected" @endif>Yellow</option>
                  <option value="R" @if (!empty($prodpos->st_pos) &&"R" == $prodpos->st_pos) selected="selected" @endif>Red</option>
                  
                </select>
          </div>
        </div>
         <div class="form-group">
          <div class="col-sm-4">
           {!! Form::label('status', 'Status') !!}
              <select name="status" aria-controls="filter_status" 
                class="form-control select2">
                  <option value="T" @if (!empty($prodpos->status) &&"T" == $prodpos->status) selected="selected" @endif>Aktif</option>
                  <option value="F" @if (!empty($prodpos->status) &&"F" == $prodpos->status) selected="selected" @endif>Tidak Aktif</option>
                  
                </select>
          </div>
        </div>
        
	
	<!-- /.form-group -->
	<div class="form-group">
		<div class="col-md-4">
			<p class="help-block">(*) tidak boleh kosong</p>
			
		</div>
	</div>
</div>
<div class="box-footer">
  {!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  &nbsp;&nbsp;
  @if (!empty($prodpos->id))
    <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
    &nbsp;&nbsp;
  @endif
  <a href="{{ route('prodpos.index') }}" id="btn-cancel" type="button" class="btn btn-warning">Cancel</a>
  
 
  
</div>


<!-- Modal Line -->
@include('prod.prodpos.popup.workCenterModal')


@section('scripts')
<script type="text/javascript">

	validateWorkCenter();

  function keyPressed(e) {
    if(e.keyCode == 120) { //F9

      popupWorkCenter();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('kd_wc').focus();
    }
  }

    function popupWorkCenter() {
     $('#workCenterModal').modal('show');

    var myHeading = "<p>Popup Work Center</p>";
    $("#workCenterModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupWorkCenter', 'param') }}';
    var plant = $('select[name="kd_plant"]').val();
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
            document.getElementById("kd_wc").value = value["kd_pros"];
            document.getElementById("nm_pros").value = value["nm_pros"];
            $('#workCenterModal').modal('hide');
            validateWorkCenter();
           
          });
        });
        $('#workCenterModal').on('hidden.bs.modal', function () {
          var kd_pros = document.getElementById("kd_wc").value.trim();
          if(kd_pros === '') {
            document.getElementById("nm_pros").value = "";
            $('#kd_wc').focus();
          } else {

          }
        });
      },
    });
  }
  function validateWorkCenter() {
    var kd_pros = document.getElementById('kd_wc').value;

    if(kd_pros !== '') {
      var url = '{{ route('datatables.validasiWorkCenter', ['param']) }}';
      url = url.replace('param', window.btoa(kd_pros));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("kd_wc").value = result["kd_pros"];
          document.getElementById("nm_pros").value = result["nm_pros"];
          document.getElementById('pos').focus();
        } else {
          document.getElementById("kd_wc").value = "";
          document.getElementById("nm_pros").value = "";
          document.getElementById("pos").focus();
          swal("Kode Work Center tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }

      });
    } else {
      document.getElementById("kd_wc").value = "";
      document.getElementById("nm_pros").value = "";
    }
  }



    $('#btnWorkCenter').click(function(){
      popupWorkCenter();
    });


  $("#btn-delete").click(function(){
    var id = document.getElementById("id").value;
    var msg = 'Anda yakin menghapus ID: ' + id + '?';
    var txt = '';
    swal({
      title: msg,
      text: txt,
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
      var urlRedirect = "{{ route('prodpos.destroy', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(id));
      window.location.href = urlRedirect;
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

  
		</script>
		@endsection