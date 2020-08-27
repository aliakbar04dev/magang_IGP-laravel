      <div class="row form-group">
        <div class="col-sm-3 {{ $errors->has('no_mon') ? ' has-error' : '' }}">
          {!! Form::label('no_mef', 'No. WWT & SPT (*)') !!}
           @if (!empty($mefdetail->no_mef))
            {!! Form::text('no_mef', $mefdetail->no_mef, ['class'=>'form-control','placeholder' => 'No. WWT & SPT', 'readonly' ,'id' => 'no_mef']) !!}
           @else
            {!! Form::text('no_mef', null, ['class'=>'form-control','placeholder' => 'No. WWT & SPT', 'readonly', 'id' => 'no_mef']) !!}
          @endif

          {!! $errors->first('no_mef', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-3 {{ $errors->has('tgl_mon') ? ' has-error' : '' }}">
          {!! Form::label('tgl_mon', 'Tanggal (*)') !!}
<!--             {!! Form::date('tgl_mon', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Work Permit']) !!} -->

        @if (!empty($mefdetail->tgl_mon))
           <input type="date" id="tgl_mon" value="{{$mefdetail->tgl_mon}}" name="tgl_mon" class="form-control">
          @else
              <input type="date" id="tgl_mon" name="tgl_mon" class="form-control">
        @endif
        
          {!! $errors->first('tgl_mon', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-3 {{ $errors->has('kd_site') ? ' has-error' : '' }}">
          {!! Form::label('kd_ot', 'Lokasi (*)') !!}
          {!! Form::select('kd_ot', [ 'OT-01-G1'=>'OT-01-G1', 'OT-01-G2'=>'OT-01-G2' , 'OT-02-G'=>'OT-02-G' , 'OT-03-G'=>'OT-03-G' , 'OT-04-G'=>'OT-04-G' , 'OT-01-A'=>'OT-01-A', 'OT-01-I'=>'OT-01-I' , 'OT-02-I'=>'OT-02-I' , 'OT-03-I'=>'OT-03-I', 'OT-05-I'=>'OT-05-I' , 'OT-06-I'=>'OT-06-I', 'OT-07-I'=>'OT-07-I' , 'OT-08-I'=>'OT-08-I', 'OT-09-I'=>'OT-09-I', 'OT-10-I'=>'OT-10-I', 'OT-11-I'=>'OT-11-I', 'OT-12-I'=>'OT-12-I', 'OT-13-I'=>'OT-13-I', 'STP-01-G'=>'STP-01-G', 'STP-02-G'=>'STP-02-G', 'STP-03-G'=>'STP-03-G', 'STP-04-G'=>'STP-04-G', 'STP-05-G'=>'STP-05-G', 'STP-06-G'=>'STP-06-G', 'STP-07-G'=>'STP-07-G', 'STP-01-I'=>'STP-01-I', 'STP-02-I'=>'STP-02-I', 'STP-03-I'=>'STP-03-I', 'STP-04-I'=>'STP-04-I', 'STP-05-I'=>'STP-05-I', 'STP-06-I'=>'STP-06-I', 'STP-07-I'=>'STP-07-I'], 
          null, ['class'=>'form-control select2']) !!}
          {!! $errors->first('kd_ot', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div>
 
       <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">Item Check</th>
                    <th style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">Ketentuan</th>
                    <th style="text-align: center;width: 8%;">Status</th>
                    <th style="width: 15%;">Uraian Masalah</th>
                    <th style="width: 10%;">Picture (jpeg,png,jpg)</th>
                    <th style="width: 10%;">Due Date</th>
                    <th style="width: 15%;">PIC</th>
                  </tr>
                </thead>
                <tbody>
                <!-- Valve -->
                    <tr>
                      <td style="white-space: nowrap;max-width: 250px;overflow: auto;text-overflow: clip;">
                       Valve
                      </td>
                      <td style="white-space: nowrap;max-width: 250px;overflow: auto;text-overflow: clip;">
                      - Tidak bocor <br> - Normaly open <br> - Tidak terganjal sampah
                      </td>
                      <td style="white-space: nowrap;max-width: 200px;overflow: auto;text-overflow: clip;">
                      {!! Form::select('status_valve', [ '1'=>'OK', '0'=>'NG'],  null, ['class'=>'form-control', 'id'=>'status_valve', 'onchange'=>'changevalve()']) !!}

                      </td>
                      <td style="white-space: nowrap;max-width: 200px;overflow: auto;text-overflow: clip;">
                        {!! Form::textarea('prob_valve', null, ['class'=>'form-control', 'placeholder' => 'Keterangan Problem', 'rows' => '3', 'maxlength' => 150, 'style' => 'resize:vertical', 'id'=>'prob_valve']) !!}
                      </td>
                      <td style="text-align: center">
                        <input id="pic_valve" name="pic_valve" type="file" accept=".jpg,.jpeg,.png" >
                         @if (!empty($mefdetail->pic_valve))
                          <img src="{{$img_valve}}" width="50%">
                         @endif
                      </td>
                       <td>
                       @if (!empty($mefdetail->dd_valve))
                          <input type="date" id="dd_valve" value="{{$mefdetail->dd_valve}}" name="dd_valve" class="form-control">
                       @else
                          <input type="date" id="dd_valve" name="dd_valve" class="form-control">
                       @endif
                      </td>
                      <td>
                       <div class="input-group">
                           {!! Form::text('cm_valve', null, ['class'=>'form-control','placeholder' => 'NPK', 'maxlength' => 50, 'onkeydown' => 'keyPressedKaryawan(event)', 'onchange' => 'validateKaryawanValve()', 'id' => 'cm_valve']) !!}
                            <span class="input-group-btn">
                              <button id="btnpopupkaryawanValve" type="button" class="btn btn-info" data-toggle="modal" data-target="#karyawanModal">
                                <span class="glyphicon glyphicon-search"></span>
                              </button>
                            </span>
                        </div> 
                         <br><br>
                             @if (!empty($mefdetail->cm_valve))
                               {!! Form::text('valve_nm_cm', $cmvalve->nama , ['class'=>'form-control','placeholder' => 'Nama', 'readonly', 'id' => 'valve_nm_cm']) !!}
                            @else
                                {!! Form::text('valve_nm_cm', null, ['class'=>'form-control','placeholder' => 'Nama', 'readonly', 'id' => 'valve_nm_cm']) !!}
                            @endif     
                      </td>
                    </tr>

                    <!-- POMPA -->
                     <tr>
                      <td style="white-space: nowrap;max-width: 250px;overflow: auto;text-overflow: clip;">
                       Pompa
                      </td>
                      <td style="white-space: nowrap;max-width: 250px;overflow: auto;text-overflow: clip;">
                        - Tidak Kempos <br> - Manual & automatis normal <br>- Cover terpasang
                      </td>
                      <td style="white-space: nowrap;max-width: 200px;overflow: auto;text-overflow: clip;">
  
                         {!! Form::select('status_pompa', [ '1'=>'OK', '0'=>'NG'],  null, ['class'=>'form-control', 'id'=>'status_pompa', 'onchange'=>'changepompa()']) !!}
                      </td>
                      <td style="white-space: nowrap;max-width: 200px;overflow: auto;text-overflow: clip;">
                        {!! Form::textarea('prob_pompa', null, ['class'=>'form-control', 'placeholder' => 'Keterangan Problem', 'rows' => '3', 'maxlength' => 150, 'style' => 'resize:vertical', 'id'=>'prob_pompa']) !!}
                      </td>
                      <td style="text-align: center">
                        <input id="pic_pompa" name="pic_pompa" type="file" accept=".jpg,.jpeg,.png" >
                         @if (!empty($mefdetail->pic_pompa))
                        <img src="{{$img_pompa}}" width="50%">
                         @endif
                      </td>
                       <td style="white-space: nowrap;max-width: 200px;overflow: auto;text-overflow: clip;">
                       @if (!empty($mefdetail->dd_pompa))
                          <input type="date" id="dd_pompa" value="{{$mefdetail->dd_pompa}}" name="dd_pompa" class="form-control">
                       @else
                          <input type="date" id="dd_pompa" name="dd_pompa" class="form-control">
                       @endif
                      </td>
                      <td style="white-space: nowrap;max-width: 200px;overflow: auto;text-overflow: clip;">
                          <div class="input-group">
                           {!! Form::text('cm_pompa', null, ['class'=>'form-control','placeholder' => 'NPK', 'maxlength' => 50, 'onkeydown' => 'keyPressedKaryawan(event)', 'onchange' => 'validateKaryawanPompa()', 'id' => 'cm_pompa']) !!}
                            <span class="input-group-btn">
                              <button id="btnpopupkaryawanPompa" type="button" class="btn btn-info" data-toggle="modal" data-target="#karyawanModal">
                                <span class="glyphicon glyphicon-search"></span>
                              </button>
                            </span>
                          </div>
                           <br><br>
                             @if (!empty($mefdetail->cm_pompa))
                               {!! Form::text('pompa_nm_cm', $cmpompa->nama , ['class'=>'form-control','placeholder' => 'Nama', 'readonly', 'id' => 'valve_nm_cm']) !!}
                            @else
                                {!! Form::text('pompa_nm_cm', null, ['class'=>'form-control','placeholder' => 'Nama', 'readonly', 'id' => 'pompa_nm_cm']) !!}
                            @endif     
                      </td>
                    </tr>

                     <!-- RADAR -->
                    <tr>
                      <td style="white-space: nowrap;max-width: 250px;overflow: auto;text-overflow: clip;">
                       Radar
                      </td>
                      <td style="white-space: nowrap;max-width: 250px;overflow: auto;text-overflow: clip;">
                        - Manual dan automatis normal <br> - Tidak terganjal sampah <br> - Stoper tidak patah/melengkung
                      </td>
                      <td style="white-space: nowrap;max-width: 200px;overflow: auto;text-overflow: clip;">
                         {!! Form::select('status_radar', [ '1'=>'OK', '0'=>'NG'],  null, ['class'=>'form-control', 'id'=>'status_radar', 'onchange'=>'changeradar()']) !!}
                      </td>
                      <td style="white-space: nowrap;max-width: 200px;overflow: auto;text-overflow: clip;">
                        {!! Form::textarea('prob_radar', null, ['class'=>'form-control', 'placeholder' => 'Keterangan Problem', 'rows' => '3', 'maxlength' => 150, 'style' => 'resize:vertical', 'id'=>'prob_radar']) !!}
                      </td>
                      <td style="text-align: center">
                        <input id="pic_radar" name="pic_radar" type="file" accept=".jpg,.jpeg,.png" >
                         @if (!empty($mefdetail->pic_radar))
                        <img src="{{$img_radar}}" width="50%">
                         @endif
                      </td>
                       <td>
                       @if (!empty($mefdetail->dd_radar))
                          <input type="date" id="dd_radar" value="{{$mefdetail->dd_radar}}" name="dd_radar" class="form-control">
                       @else
                          <input type="date" id="dd_radar" name="dd_radar" class="form-control">
                       @endif
                      </td>
                      <td>
                       <div class="input-group">
                           {!! Form::text('cm_radar', null, ['class'=>'form-control','placeholder' => 'NPK', 'maxlength' => 50, 'onkeydown' => 'keyPressedKaryawan(event)', 'onchange' => 'validateKaryawanRadar()', 'id' => 'cm_radar']) !!}
                            <span class="input-group-btn">
                              <button id="btnpopupkaryawanRadar" type="button" class="btn btn-info" data-toggle="modal" data-target="#karyawanModal">
                                <span class="glyphicon glyphicon-search"></span>
                              </button>
                            </span>
                        </div>   
                         <br><br>
                             @if (!empty($mefdetail->cm_radar))
                               {!! Form::text('radar_nm_cm', $cmradar->nama , ['class'=>'form-control','placeholder' => 'Nama', 'readonly', 'id' => 'radar_nm_cm']) !!}
                            @else
                                {!! Form::text('radar_nm_cm', null, ['class'=>'form-control','placeholder' => 'Nama', 'readonly', 'id' => 'radar_nm_cm']) !!}
                            @endif      
                      </td>
                    </tr>

                    <!-- BAK -->
                     <tr>
                      <td style="white-space: nowrap;max-width: 250px;overflow: auto;text-overflow: clip;">
                       Bak
                      </td>
                      <td style="white-space: nowrap;max-width: 250px;overflow: auto;text-overflow: clip;">
                      - Tidak ada sampah <br> - Tidak ada lumpur <br> - Tidak bocor <br> - Tidak ada ceceran limbah
                      </td>
                      <td style="white-space: nowrap;max-width: 200px;overflow: auto;text-overflow: clip;">
                          {!! Form::select('status_bak', [ '1'=>'OK', '0'=>'NG'],  null, ['class'=>'form-control', 'id'=>'status_bak', 'onchange'=>'changebak()']) !!}
                      </td>
                      <td style="white-space: nowrap;max-width: 200px;overflow: auto;text-overflow: clip;">
                        {!! Form::textarea('prob_bak', null, ['class'=>'form-control', 'placeholder' => 'Keterangan Problem', 'rows' => '3', 'maxlength' => 150, 'style' => 'resize:vertical', 'id'=>'prob_bak']) !!}
                      </td>
                      <td style="text-align: center">
                        <input id="pic_bak" name="pic_bak" type="file" accept=".jpg,.jpeg,.png" >
                         @if (!empty($mefdetail->pic_bak))
                        <img src="{{$img_bak}}" width="50%">
                         @endif
                      </td>
                       <td>
                       @if (!empty($mefdetail->dd_bak))
                          <input type="date" id="dd_bak" value="{{$mefdetail->dd_bak}}" name="dd_bak" class="form-control">
                       @else
                          <input type="date" id="dd_bak" name="dd_bak" class="form-control">
                       @endif
                      </td>
                      <td>
                       <div class="input-group">
                           {!! Form::text('cm_bak', null, ['class'=>'form-control','placeholder' => 'NPK', 'maxlength' => 50, 'onkeydown' => 'keyPressedKaryawan(event)', 'onchange' => 'validateKaryawanBak()', 'id' => 'cm_bak']) !!}
                            <span class="input-group-btn">
                              <button id="btnpopupkaryawanBak" type="button" class="btn btn-info" data-toggle="modal" data-target="#karyawanModal">
                                <span class="glyphicon glyphicon-search"></span>
                              </button>
                            </span>
                        </div>
                        <br><br>
                             @if (!empty($mefdetail->cm_bak))
                               {!! Form::text('bak_nm_cm', $cmbak->nama , ['class'=>'form-control','placeholder' => 'Nama', 'readonly', 'id' => 'bak_nm_cm']) !!}
                            @else
                                {!! Form::text('bak_nm_cm', null, ['class'=>'form-control','placeholder' => 'Nama', 'readonly', 'id' => 'bak_nm_cm']) !!}
                            @endif       
                      </td>
                    </tr>

                     <!-- SALURAN PIT -->
                    <tr>
                      <td style="white-space: nowrap;max-width: 250px;overflow: auto;text-overflow: clip;">
                       Saluran Pit
                      </td>
                      <td style="white-space: nowrap;max-width: 250px;overflow: auto;text-overflow: clip;">
                       - Tidak ada sampah <br> - Tidak ada lumpur
                      </td>
                      <td style="white-space: nowrap;max-width: 200px;overflow: auto;text-overflow: clip;">
                          {!! Form::select('status_spit', [ '1'=>'OK', '0'=>'NG'],  null, ['class'=>'form-control', 'id'=>'status_spit', 'onchange'=>'changespit()']) !!}
                      </td>
                      <td style="white-space: nowrap;max-width: 200px;overflow: auto;text-overflow: clip;">
                        {!! Form::textarea('prob_spit', null, ['class'=>'form-control', 'placeholder' => 'Keterangan Problem', 'rows' => '3', 'maxlength' => 150, 'style' => 'resize:vertical', 'id'=>'prob_spit']) !!}
                      </td>
                      <td style="text-align: center">
                        <input id="pic_spit" name="pic_spit" type="file" accept=".jpg,.jpeg,.png" >
                         @if (!empty($mefdetail->pic_spit))
                        <img src="{{$img_spit}}" width="50%">
                         @endif
                      </td>
                       <td>
                       @if (!empty($mefdetail->dd_spit))
                          <input type="date" id="dd_spit" value="{{$mefdetail->dd_spit}}" name="dd_spit" class="form-control">
                       @else
                          <input type="date" id="dd_spit" name="dd_spit" class="form-control">
                       @endif
                      </td>
                      <td>
                       <div class="input-group">
                           {!! Form::text('cm_spit', null, ['class'=>'form-control','placeholder' => 'NPK', 'maxlength' => 50, 'onkeydown' => 'keyPressedKaryawan(event)', 'onchange' => 'validateKaryawanSpit()', 'id' => 'cm_spit']) !!}
                            <span class="input-group-btn">
                              <button id="btnpopupkaryawanSpit" type="button" class="btn btn-info" data-toggle="modal" data-target="#karyawanModal">
                                <span class="glyphicon glyphicon-search"></span>
                              </button>
                            </span>
                        </div> 
                        <br><br>
                             @if (!empty($mefdetail->cm_spit))
                               {!! Form::text('spit_nm_cm', $cmspit->nama , ['class'=>'form-control','placeholder' => 'Nama', 'readonly', 'id' => 'spit_nm_cm']) !!}
                            @else
                                {!! Form::text('spit_nm_cm', null, ['class'=>'form-control','placeholder' => 'Nama', 'readonly', 'id' => 'spit_nm_cm']) !!}
                            @endif      
                      </td>
                    </tr>
                </tbody>
              </table>
            </div>


  
 <div class="box-footer"> 
   {!! Form::hidden('status', null, ['class'=>'form-control', 'id' => 'status']) !!}
  &nbsp;&nbsp;
  <p class="help-block pull-right has-error">{!! Form::submit('Submit', ['class'=>'btn btn-primary', 'id' => 'btn-submit']) !!}</p>
</div>


@include('ehs.popup.karyawanModal')

@section('scripts')
<script type="text/javascript">

var table = $('#tblMaster').DataTable({
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
      // "responsive": true,
      "ordering": false, 
      "searching": false,
      "scrollX": true,
      //"scrollY": "500px",
      "scrollCollapse": true,
      "paging": false, 
      columns: [
        {orderable: false, searchable: false},
        {orderable: false, searchable: false},
        {orderable: false, searchable: false},
        {orderable: false, searchable: false},
        {orderable: false, searchable: false},
        {orderable: false, searchable: false},
        {orderable: false, searchable: false}, 
      ],
    });



$('#form_mef').submit(function (e, params) {
    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();
      //additional input validations can be done hear
      var tgl_mon = document.getElementById("tgl_mon").value;
      var status_valve = document.getElementById("status_valve").value;
      var prob_valve = document.getElementById("prob_valve").value;
      var pic_valve = document.getElementById("pic_valve").value;
      var dd_valve = document.getElementById("dd_valve").value;
      var cm_valve = document.getElementById("cm_valve").value;
      var status_pompa = document.getElementById("status_pompa").value;
      var prob_pompa = document.getElementById("prob_pompa").value;
      var pic_pompa = document.getElementById("pic_pompa").value;
      var dd_pompa = document.getElementById("dd_pompa").value;
      var cm_pompa = document.getElementById("cm_pompa").value;
      var status_radar = document.getElementById("status_radar").value;
      var prob_radar = document.getElementById("prob_radar").value;
      var pic_radar = document.getElementById("pic_radar").value;
      var dd_radar = document.getElementById("dd_radar").value;
      var cm_radar = document.getElementById("cm_radar").value;
      var status_bak = document.getElementById("status_bak").value;
      var prob_bak = document.getElementById("prob_bak").value;
      var pic_bak = document.getElementById("pic_bak").value;
      var dd_bak = document.getElementById("dd_bak").value;
      var cm_bak = document.getElementById("cm_bak").value;
      var status_spit = document.getElementById("status_spit").value;
      var prob_spit = document.getElementById("prob_spit").value;
      var pic_spit = document.getElementById("pic_spit").value;
      var dd_spit = document.getElementById("dd_spit").value;
      var cm_spit = document.getElementById("cm_spit").value;

   if(tgl_mon==""){
     var info = "Perhatikan inputan anda!";
     swal(info, "Tanggal tidak boleh kosong" , "info");
   }
    else  if(status_valve == "0" && (prob_valve == "" || cm_valve === ""|| dd_valve== "")) {
      var info = "Perhatikan inputan anda!" ;
      swal(info, "Data tidak boleh kosong <br> (Problem Valve, C/M Valve, PIC Valve, DD Valve)", "info");
    }
   else  if(status_pompa === "0" && (prob_pompa === "" || cm_pompa === ""|| dd_pompa=== "")) {
      var info = "Perhatikan inputan anda!" ;
      swal(info, "Data tidak boleh kosong <br> (Problem Pompa, C/M Pompa, PIC Pompa, DD Pompa)", "info");
    } 
    else  if(status_radar === "0" && (prob_radar === "" || cm_radar === ""||dd_radar === "")) {
      var info = "Perhatikan inputan anda!" ;
      swal(info, "Data tidak boleh kosong <br> (Problem Radar, C/M Radar, PIC Radar, DD Radar)", "info");
    }
    else  if(status_bak === "0" && (prob_bak === "" || cm_bak === "" ||dd_bak === "")) {
      var info = "Perhatikan inputan anda!" ;
      swal(info, "Data tidak boleh kosong <br> (Problem Bak, C/M Bak, PIC Bak, DD Bak)", "info");
    }
    else  if(status_spit === "0" && (prob_spit === "" || cm_spit === "" ||dd_spit === "")) {
      var info = "Perhatikan inputan anda!" ;
      swal(info, "Data tidak boleh kosong <br> (Problem Saluran Pit, C/M Saluran Pit, PIC Saluran Pit, DD Saluran Pit)", "info");
    } 
    else  if(( dd_valve != "" && dd_valve < tgl_mon) || (dd_pompa != "" && dd_pompa < tgl_mon) || (dd_radar != "" &&  dd_radar < tgl_mon) || (dd_bak != "" && dd_bak < tgl_mon) || (dd_spit != "" && dd_spit < tgl_mon) ) {
      var info = "Perhatikan inputan anda!" ;
      swal(info, "Due Date tidak boleh kurang dari tanggal monitoring", "info");
    }
    else{
        swal({
          title: 'Konfirmasi',
          text: 'Apakah data sudah benar?',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, save it!',
          cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
          allowOutsideClick: true,
          allowEscapeKey: true,
          allowEnterKey: true,
          reverseButtons: false,
          focusCancel: false,
        }).then(function () {
          //document.getElementById("idtables").value = targets;
        $(e.currentTarget).trigger(e.type, { 'send': true });
 
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


  $(".select2").select2();


  function validasiSize() {
    $("input[name^='pict_id_']").bind('change', function() {
      let filesize = this.files[0].size // On older browsers this can return NULL.
      let filesizeMB = (filesize / (1024*1024)).toFixed(2);
      if(filesizeMB > 8) {
        var info = "Size File tidak boleh > 8 MB";
        swal(info, "Perhatikan inputan anda!", "info");
        this.value = null;
      }
    });
  }

  validasiSize();


 

  function keyPressedKaryawan(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupkaryawanValve').click();
      $('#btnpopupkaryawanPompa').click();
      $('#btnpopupkaryawanRadar').click();
      $('#btnpopupkaryawanBak').click();
      $('#btnpopupkaryawanSpit').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
    }
  }

  $(document).ready(function(){
    changevalve();
    changepompa();
    changeradar();
    changebak();
    changespit();
    /*document.getElementById("status_valve").value = "0";
    document.getElementById("status_pompa").value = "0";
    document.getElementById("status_radar").value = "0";
    document.getElementById("status_bak").value = "0";
    document.getElementById("status_spit").value = "0";
*/
    $("#btnpopupkaryawanValve").click(function(){
      popupKaryawanValve();
    });
    $("#btnpopupkaryawanPompa").click(function(){
      popupKaryawanPompa();
    });
    $("#btnpopupkaryawanRadar").click(function(){
      popupKaryawanRadar();
    });
    $("#btnpopupkaryawanBak").click(function(){
      popupKaryawanBak();
    });
    $("#btnpopupkaryawanSpit").click(function(){
      popupKaryawanSpit();
    });
  });

 


  

 

  function popupKaryawanValve() {
    var myHeading = "<p>Popup PIC</p>";
    $("#karyawanModalLabel").html(myHeading);
    var url = '{{ route('kikenyoochi.popupKaryawanKy') }}';
    var lookupKaryawan = $('#lookupKaryawan').DataTable({
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
        { data: 'npk', name: 'npk'},
        { data: 'nama', name: 'nama'},
        { data: 'kd_pt', name: 'kd_pt'},
        { data: 'desc_dep', name: 'desc_dep'},
        { data: 'desc_div', name: 'desc_div'},
        { data: 'email', name: 'email'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupKaryawan tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupKaryawan.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("cm_valve").value = value["npk"];
            document.getElementById("valve_nm_cm").value = value["nama"];
            $('#karyawanModal').modal('hide');
            validateKaryawanValve();
          });
        });
        $('#karyawanModal').on('hidden.bs.modal', function () {
          var cm_valve = document.getElementById("cm_valve").value.trim();
          if(cm_valve === '') {
            document.getElementById("cm_valve").value = "";
            document.getElementById("valve_nm_cm").value = "";
            $('#cm_valve').focus();
          } 
        });
      },
    });
  }



 function popupKaryawanPompa() {
    var myHeading = "<p>Popup PIC</p>";
    $("#karyawanModalLabel").html(myHeading);
    var url = '{{ route('kikenyoochi.popupKaryawanKy') }}';
    var lookupKaryawan = $('#lookupKaryawan').DataTable({
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
        { data: 'npk', name: 'npk'},
        { data: 'nama', name: 'nama'},
        { data: 'kd_pt', name: 'kd_pt'},
        { data: 'desc_dep', name: 'desc_dep'},
        { data: 'desc_div', name: 'desc_div'},
        { data: 'email', name: 'email'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupKaryawan tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupKaryawan.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("cm_pompa").value = value["npk"];
            document.getElementById("pompa_nm_cm").value = value["nama"];
            $('#karyawanModal').modal('hide');
            validateKaryawanPompa();
          });
        });
        $('#karyawanModal').on('hidden.bs.modal', function () {
          var cm_valve = document.getElementById("cm_pompa").value.trim();
          if(cm_valve === '') {
            document.getElementById("cm_pompa").value = "";
            document.getElementById("pompa_nm_cm").value = "";
            $('#cm_pompa').focus();
          } 
        });
      },
    });
  }



   function popupKaryawanRadar() {
    var myHeading = "<p>Popup PIC</p>";
    $("#karyawanModalLabel").html(myHeading);
    var url = '{{ route('kikenyoochi.popupKaryawanKy') }}';
    var lookupKaryawan = $('#lookupKaryawan').DataTable({
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
        { data: 'npk', name: 'npk'},
        { data: 'nama', name: 'nama'},
        { data: 'kd_pt', name: 'kd_pt'},
        { data: 'desc_dep', name: 'desc_dep'},
        { data: 'desc_div', name: 'desc_div'},
        { data: 'email', name: 'email'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupKaryawan tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupKaryawan.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("cm_radar").value = value["npk"];
            document.getElementById("radar_nm_cm").value = value["nama"];
            $('#karyawanModal').modal('hide');
            validateKaryawanRadar();
          });
        });
        $('#karyawanModal').on('hidden.bs.modal', function () {
          var cm_radar = document.getElementById("cm_radar").value.trim();
          if(cm_radar === '') {
            document.getElementById("cm_radar").value = "";
            document.getElementById("radar_nm_cm").value = "";
            $('#cm_radar').focus();
          } 
        });
      },
    });
  }



    function popupKaryawanBak() {
    var myHeading = "<p>Popup PIC</p>";
    $("#karyawanModalLabel").html(myHeading);
    var url = '{{ route('kikenyoochi.popupKaryawanKy') }}';
    var lookupKaryawan = $('#lookupKaryawan').DataTable({
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
        { data: 'npk', name: 'npk'},
        { data: 'nama', name: 'nama'},
        { data: 'kd_pt', name: 'kd_pt'},
        { data: 'desc_dep', name: 'desc_dep'},
        { data: 'desc_div', name: 'desc_div'},
        { data: 'email', name: 'email'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupKaryawan tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupKaryawan.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("cm_bak").value = value["npk"];
            document.getElementById("bak_nm_cm").value = value["nama"];
            $('#karyawanModal').modal('hide');
            validateKaryawanBak();
          });
        });
        $('#karyawanModal').on('hidden.bs.modal', function () {
          var cm_bak = document.getElementById("cm_bak").value.trim();
          if(cm_bak === '') {
            document.getElementById("cm_bak").value = "";
            document.getElementById("bak_nm_cm").value = "";
            $('#cm_bak').focus();
          } 
        });
      },
    });
  }



  function popupKaryawanSpit() {
    var myHeading = "<p>Popup PIC</p>";
    $("#karyawanModalLabel").html(myHeading);
    var url = '{{ route('kikenyoochi.popupKaryawanKy') }}';
    var lookupKaryawan = $('#lookupKaryawan').DataTable({
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
        { data: 'npk', name: 'npk'},
        { data: 'nama', name: 'nama'},
        { data: 'kd_pt', name: 'kd_pt'},
        { data: 'desc_dep', name: 'desc_dep'},
        { data: 'desc_div', name: 'desc_div'},
        { data: 'email', name: 'email'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupKaryawan tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupKaryawan.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("cm_spit").value = value["npk"];
            document.getElementById("spit_nm_cm").value = value["nama"];
            $('#karyawanModal').modal('hide');
            validateKaryawanSpit();
          });
        });
        $('#karyawanModal').on('hidden.bs.modal', function () {
          var cm_spit = document.getElementById("cm_spit").value.trim();
          if(cm_radar === '') {
            document.getElementById("cm_spit").value = "";
            document.getElementById("spit_nm_cm").value = "";
            $('#cm_spit').focus();
          } 
        });
      },
    });
  }

  function validateKaryawanValve() {
    var cm_valve = document.getElementById("cm_valve").value.trim();
    if(cm_valve !== '') {
      var url = '{{ route('kikenyoochi.validasiKaryawanKy', 'param') }}';
      url = url.replace('param', window.btoa(cm_valve));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("cm_valve").value = result["npk"];
          document.getElementById("valve_nm_cm").value = result["nama"];
        } else {
          document.getElementById("cm_valve").value = "";
          document.getElementById("valve_nm_cm").value = "";
          document.getElementById("cm_valve").focus();
          swal("NPK tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("cm_valve").value = "";
      document.getElementById("valve_nm_cm").value = "";
    }
  }


  function validateKaryawanPompa() {
    var cm_pompa = document.getElementById("cm_pompa").value.trim();
    if(cm_pompa !== '') {
      var url = '{{ route('kikenyoochi.validasiKaryawanKy', 'param') }}';
      url = url.replace('param', window.btoa(cm_pompa));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("cm_pompa").value = result["npk"];
          document.getElementById("pompa_nm_cm").value = result["nama"];
        } else {
          document.getElementById("cm_pompa").value = "";
          document.getElementById("pompa_nm_cm").value = "";
          document.getElementById("cm_pompa").focus();
          swal("NPK tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("cm_pompa").value = "";
      document.getElementById("pompa_nm_cm").value = "";
    }
  }

    function validateKaryawanRadar() {
    var cm_radar = document.getElementById("cm_radar").value.trim();
    if(cm_radar !== '') {
      var url = '{{ route('kikenyoochi.validasiKaryawanKy', 'param') }}';
      url = url.replace('param', window.btoa(cm_radar));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("cm_radar").value = result["npk"];
          document.getElementById("radar_nm_cm").value = result["nama"];
        } else {
          document.getElementById("cm_radar").value = "";
          document.getElementById("radar_nm_cm").value = "";
          document.getElementById("cm_radar").focus();
          swal("NPK tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("cm_radar").value = "";
      document.getElementById("radar_nm_cm").value = "";
    }
  }


    function validateKaryawanBak() {
    var cm_bak = document.getElementById("cm_bak").value.trim();
    if(cm_bak !== '') {
      var url = '{{ route('kikenyoochi.validasiKaryawanKy', 'param') }}';
      url = url.replace('param', window.btoa(cm_bak));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("cm_bak").value = result["npk"];
          document.getElementById("bak_nm_cm").value = result["nama"];
        } else {
          document.getElementById("cm_bak").value = "";
          document.getElementById("bak_nm_cm").value = "";
          document.getElementById("cm_bak").focus();
          swal("NPK tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("cm_bak").value = "";
      document.getElementById("bak_nm_cm").value = "";
    }
  }



    function validateKaryawanSpit() {
    var cm_spit = document.getElementById("cm_spit").value.trim();
    if(cm_spit !== '') {
      var url = '{{ route('kikenyoochi.validasiKaryawanKy', 'param') }}';
      url = url.replace('param', window.btoa(cm_spit));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("cm_spit").value = result["npk"];
          document.getElementById("spit_nm_cm").value = result["nama"];
        } else {
          document.getElementById("cm_spit").value = "";
          document.getElementById("spit_nm_cm").value = "";
          document.getElementById("cm_spit").focus();
          swal("NPK tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("cm_spit").value = "";
      document.getElementById("spit_nm_cm").value = "";
    }
  }

  function changevalve() {
    var status_valve = document.getElementById("status_valve").value;
    if(status_valve == '1')  {
      $('#prob_valve').attr('readonly', true);
      $('#dd_valve').attr('readonly', true);
      $('#cm_valve').attr('readonly', true);
      $('#pic_valve').attr('disabled', true);
      $('#btnpopupkaryawanValve').attr('disabled', true);
      document.getElementById("prob_valve").value = null;
      document.getElementById("cm_valve").value = null;
      document.getElementById("valve_nm_cm").value = null;
    } else {
      $('#prob_valve').attr('readonly', false);
      $('#dd_valve').attr('readonly', false);
      $('#cm_valve').attr('readonly', false);
       $('#pic_valve').attr('disabled', false);
      $('#btnpopupkaryawanValve').attr('disabled', false);
    }
    status();
  }

  function status(){
    var status_valve = document.getElementById("status_valve").value;
    var status_pompa = document.getElementById("status_pompa").value;
    var status_radar = document.getElementById("status_radar").value;
    var status_bak = document.getElementById("status_bak").value;
    var status_spit = document.getElementById("status_spit").value;
if(status_valve === "1" && status_pompa ==="1" && status_radar ==="1" && status_bak ==="1" && status_spit ==="1"){
       document.getElementById("status").value = "1";
   }
   else {
       document.getElementById("status").value = "0";
    } 
  }


    function changepompa() {
      var status_pompa = document.getElementById("status_pompa").value;
      if(status_pompa == '1')  {
      $('#prob_pompa').attr('readonly', true);
      $('#dd_pompa').attr('readonly', true);
      $('#cm_pompa').attr('readonly', true);
      $('#pic_pompa').attr('disabled', true);
      $('#btnpopupkaryawanPompa').attr('disabled', true);
      document.getElementById("prob_pompa").value = null;
      document.getElementById("dd_pompa").value = null;
      document.getElementById("cm_pompa").value = null;
      document.getElementById("pic_pompa").value = null;
    } else {
      $('#prob_pompa').attr('readonly', false);
      $('#dd_pompa').attr('readonly', false);
      $('#cm_pompa').attr('readonly', false);
       $('#pic_pompa').attr('disabled', false);
      $('#btnpopupkaryawanPompa').attr('disabled', false);
    }
    status();
  }



  function changeradar() {
     var status_radar = document.getElementById("status_radar").value;
      if(status_radar == '1')  {
      $('#prob_radar').attr('readonly', true);
      $('#dd_radar').attr('readonly', true);
      $('#cm_radar').attr('readonly', true);
      $('#pic_radar').attr('disabled', true);
      $('#btnpopupkaryawanRadar').attr('disabled', true);
      document.getElementById("prob_radar").value = null;
      document.getElementById("dd_radar").value = null;
      document.getElementById("cm_radar").value = null;
      document.getElementById("pic_radar").value = null;
    } else {
      $('#prob_radar').attr('readonly', false);
      $('#dd_radar').attr('readonly', false);
      $('#cm_radar').attr('readonly', false);
       $('#pic_radar').attr('disabled', false);
      $('#btnpopupkaryawanRadar').attr('disabled', false);
    }
    status();
  }



   function changebak() {
      var status_bak = document.getElementById("status_bak").value;
      if(status_bak == '1')  {
      $('#prob_bak').attr('readonly', true);
      $('#dd_bak').attr('readonly', true);
      $('#cm_bak').attr('readonly', true);
      $('#pic_bak').attr('disabled', true);
      $('#btnpopupkaryawanBak').attr('disabled', true);
      document.getElementById("prob_bak").value = null;
      document.getElementById("dd_bak").value = null;
      document.getElementById("cm_bak").value = null;
      document.getElementById("pic_bak").value =null;
    } else {
      $('#prob_bak').attr('readonly', false);
      $('#dd_bak').attr('readonly', false);
      $('#cm_bak').attr('readonly', false);
      $('#pic_bak').attr('disabled', false);
      $('#btnpopupkaryawanBak').attr('disabled', false);
    }
    status();
  }



    function changespit() {
      var status_spit = document.getElementById("status_spit").value;
      if(status_spit == '1')  {
      $('#prob_spit').attr('readonly', true);
      $('#dd_spit').attr('readonly', true);
      $('#cm_spit').attr('readonly', true);
      $('#pic_spit').attr('disabled', true);
      $('#btnpopupkaryawanSpit').attr('disabled', true);
      document.getElementById("prob_spit").value = null;
      document.getElementById("dd_spit").value = null;
      document.getElementById("cm_spit").value = null;
      document.getElementById("pic_spit").value = null;
    } else {
      $('#prob_spit').attr('readonly', false);
      $('#dd_spit').attr('readonly', false);
      $('#cm_spit').attr('readonly', false);
      $('#pic_spit').attr('disabled', false);
      $('#btnpopupkaryawanSpit').attr('disabled', false);
    }
    status();
  }



</script>
@endsection