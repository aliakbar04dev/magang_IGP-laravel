<div class="box-body ">
  <div class="form-group">
    <div class="col-sm-3">
      {!! Form::label('no_doc', 'No Doc') !!}
      {!! Form::text('no_doc', null, ['class'=>'form-control', 'placeholder' => 'No LHP', 'required', 'readonly' => '']) !!}
      {!! $errors->first('no_doc', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2">
     {!! Form::label('tgl_doc', 'Tanggal') !!}
      @if (empty($tlhpn01->tgl_doc))
      {!! Form::date('tgl_doc', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => \Carbon\Carbon::now()]) !!}
      @else
      {!! Form::date('tgl_doc', \Carbon\Carbon::parse($tlhpn01->tgl_doc), ['class'=>'form-control']) !!}
      @endif
      {!! $errors->first('tgl_doc', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-1">
      {!! Form::label('shift', 'Shift') !!}
        <div class="input-group"> 
            {!! Form::select('shift', array('1' => '1', '2' => '2', '3' => '3'), null, ['class'=>'form-control', 'onchange' => 'changeShift()']) !!}
        </div>
        {!! $errors->first('shift', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2">    
     {{ $errors->has('awal_kerja') ? ' has-error' : '' }}
     {!! Form::label('awal_kerja', 'Jam Mulai') !!}
     @if (empty($tlhpn01->awal_kerja))
      {!! Form::time('awal_kerja', "00:00", ['class'=>'form-control', 'readonly']) !!}
     @else
      {!! Form::time('awal_kerja', \Carbon\Carbon::parse($tlhpn01->awal_kerja)->format('H:i'), ['class'=>'form-control', 'readonly']) !!}
     @endif              
     {!! $errors->first('awal_kerja', '<p class="help-block">:message</p>') !!}
   </div>
   <div class="col-sm-2">    
     {{ $errors->has('akhir_kerja') ? ' has-error' : '' }}
     {!! Form::label('akhir_kerja', 'Jam Akhir') !!}              
     @if (empty($tlhpn01->akhir_kerja))
      {!! Form::time('akhir_kerja', "07:30", ['class'=>'form-control', 'readonly']) !!}
     @else
      {!! Form::time('akhir_kerja', \Carbon\Carbon::parse($tlhpn01->akhir_kerja)->format('H:i'), ['class'=>'form-control', 'readonly']) !!}
     @endif       
     {!! $errors->first('akhir_kerja', '<p class="help-block">:message</p>') !!}
   </div>
 </div>
 <div class="form-group">   
  <div class="col-sm-2">
   {!! Form::label('kd_plant', 'Plant') !!}   
    <div class="input-group">
    @if (empty($tlhpn01->kd_plant)) 
    <select id="kd_plant" name="kd_plant" class="form-control">
        @foreach($plants->get() as $kode)
        <option value="{{$kode->kd_plant}}">{{$kode->nm_plant}}</option>
        @endforeach
    </select> 
    @else           
    {!! Form::select('kd_plant', array('' => '-', '1' => 'IGP-1', '2' => 'IGP-2', '3' => 'IGP-3', '4' => 'IGP-4', 'A' => 'KIM-1A', 'B' => 'KIM-1B'), null, ['class'=>'form-control', 'disabled'=>'true']) !!}     
    {!! Form::hidden('kd_plant', null, ['class'=>'form-control','required', 'readonly' => '']) !!} 
   @endif 
    </div>
</div>
<div class="col-sm-1">
  {!! Form::label('jml_mp', 'MP') !!}
  @if (empty($tlhpn01->jml_mp))         
  {!! Form::number('jml_mp',0, ['class'=>'form-control', 'required']) !!}
  @else
  {!! Form::number('jml_mp',null, ['class'=>'form-control', 'required']) !!}
  @endif
  {!! $errors->first('jml_mp', '<p class="help-block">:message</p>') !!}
</div>

<div class="col-sm-1">
  {!! Form::label('jml_absen', 'Absen') !!}
  @if (empty($tlhpn01->jml_absen)) 
  {!! Form::number('jml_absen',0, ['class'=>'form-control', 'required']) !!}
  @else
  {!! Form::number('jml_absen',null, ['class'=>'form-control', 'required']) !!}
  @endif
  {!! $errors->first('jml_absen', '<p class="help-block">:message</p>') !!}
</div>
<div class="col-sm-1">
  {!! Form::label('jml_cuti', 'Cuti') !!}
   @if (empty($tlhpn01->jml_cuti)) 
   {!! Form::number('jml_cuti',0, ['class'=>'form-control', 'required']) !!}
   @else
   {!! Form::number('jml_cuti',null, ['class'=>'form-control', 'required']) !!}
   @endif  
  {!! $errors->first('jml_cuti', '<p class="help-block">:message</p>') !!}
</div>
<div class="col-sm-1">
  {!! Form::label('jml_mp_ot', 'OT (Jam)') !!}            
  @if (empty($tlhpn01->jml_mp_ot)) 
  {!! Form::number('jml_mp_ot',0, ['class'=>'form-control', 'required']) !!}
  @else
  {!! Form::number('jml_mp_ot',null, ['class'=>'form-control', 'required']) !!}
  @endif
  {!! $errors->first('jml_mp_ot', '<p class="help-block">:message</p>') !!}
</div>
<div class="col-sm-2">
   {!! Form::label('jml_ls_prod', 'Jumlah LS Produksi (Menit)') !!}
   {!! Form::number('jml_ls_prod',0, ['class'=>'form-control', 'readonly']) !!}
   {!! $errors->first('jml_ls_prod', '<p class="help-block">:message</p>') !!}
</div>
<div class="col-sm-2">
   {!! Form::label('jml_ls_rep', 'Jumlah LS Report (Menit)') !!}
   {!! Form::number('jml_ls_rep',0, ['class'=>'form-control', 'readonly']) !!}
   {!! $errors->first('jml_ls_rep', '<p class="help-block">:message</p>') !!}
</div>  
</div>
<div class="form-group">
 <div class="col-sm-2">
  {!! Form::label('proses', 'Kode Proses (F9)') !!}
  <div class="input-group">
    {!! Form::text('proses', null, ['class'=>'form-control','onkeydown' => 'btnpopupProsesClick(event)', 'required','onchange' => 'validateProses()']) !!}
    <span class="input-group-btn">
      <button id="btnpopupProses" type="button" class="btn btn-info" data-toggle="modal" data-target="#ProsesModal">
        <span class="glyphicon glyphicon-search"></span>
      </button>
    </span>
  </div>
   {!! $errors->first('proses', '<p class="help-block">:message</p>') !!}
  </div>
  <div class="col-sm-4">
    {!! Form::label('nm_proses', 'Nama Proses') !!}
    {!! Form::text('nm_proses', null, ['class'=>'form-control', 'readonly']) !!}
  </div>
  <div class="col-sm-2">
    {!! Form::label('kd_line', 'Kode Line') !!}
    {!! Form::text('kd_line', null, ['class'=>'form-control', 'readonly']) !!}
    {!! $errors->first('kd_line', '<p class="help-block">:message</p>') !!}
  </div>
  <div class="col-sm-4">
    {!! Form::label('nm_line', 'Nama Line') !!}
    {!! Form::text('nm_line', null, ['class'=>'form-control','placeholder' => 'Nama Line', 'readonly']) !!}
  </div>
</div>

{!! Form::hidden('jml_tbl_detail', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_tbl_detail']) !!}
{!! Form::hidden('jml_tbl_details', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_tbl_details']) !!} 
</div>
<!-- /.box-body -->
<div class="box-body">
  <div class="row">
   <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Detail LHP</h3>
      </div>
      <!-- /.box-header -->
        <div class="box-body">
          @include('datatable._action-addrem')
          <table id="tblDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
           <thead>
              <tr>
               <th style="width: 2%;">No</th>
               <th style="width: 2%;">Jam Start</th>
               <th style="width: 2%;">Jam End</th>
               <th style="width: 2%;">Menit</th>
               <th style="width: 15%;">Partno<font color='red'>&nbsp;(F9)</font></th>
               <th style="width: 30%;">Partname</th>
               <th style="width: 10%;">Model</th>
               <th style="width: 2%;">CT</font></th> 
               <th style="width: 2%;">Target</th>                          
               <th style="width: 2%;">OK</th>
               <th style="width: 2%;">Suspect</th>
               <th style="width: 15%;">Mesin<font color='red'>&nbsp;(F9)</font></th>
               <th style="width: 2%;">Selisih</th>
               <th style="width: 2%;">Menit LS</th>
             </tr>
           </thead>
           <tbody>
              @if (!empty($tlhpn01->no_doc)) 
              @foreach ($model->tlhpn01Det($tlhpn01->no_doc)->get() as $tlhpn02)
              <tr>
               <td>{{ $loop->iteration }}</td>
               <td><input type='hidden' value="row-{{ $loop->iteration }}-part_no"><input type='time' id='row-{{ $loop->iteration }}-jam_mulai' name='row-{{ $loop->iteration }}-jam_mulai' value='{{ \Carbon\Carbon::parse($tlhpn02->jam_mulai)->format('H:i') }}' onblur='getMenitAwal(event)' style='width:70px' required readonly></td>
               <td><input type='time' id='row-{{ $loop->iteration }}-jam_selesai' name='row-{{ $loop->iteration }}-jam_selesai' value='{{ \Carbon\Carbon::parse($tlhpn02->jam_selesai)->format('H:i') }}' onblur='getMenit(event)' style='width:70px' required readonly></td>
               <td><input type='number' id="row-{{ $loop->iteration }}-menit_lhp" name="row-{{ $loop->iteration }}-menit_lhp" style='width:60px' value='{{ $model->menitLhp($tlhpn02->no_doc, $tlhpn02->jam_mulai, $tlhpn02->jam_selesai) }}' disabled></td>
               <td><input type='text' id="row-{{ $loop->iteration }}-part_no" name="row-{{ $loop->iteration }}-part_no" style='width:120px' maxlength='40' onkeydown='popupPartno(event)' onchange='validatePartno(event)' value='{{ $tlhpn02->part_no }}' required><input type='hidden' id='row-{{ $loop->iteration }}-id' name='row-{{ $loop->iteration }}-id' readonly><input type='hidden' id='row-{{ $loop->iteration }}-no_seq' name='row-{{ $loop->iteration }}-no_seq' value='{{ $tlhpn02->no_seq }}'></td>
               <td><textarea id="row-{{ $loop->iteration }}-partname" name="row-{{ $loop->iteration }}-partname" rows='2' cols='40' disabled='' style='text-transform:uppercase;resize:vertical'>{{ $model->getPartname($tlhpn02->part_no, $tlhpn01->proses) }}</textarea></td>
               <td><input type='text' id='row-{{ $loop->iteration }}-model' name='row-{{ $loop->iteration }}-model' value='{{ $model->getModel($tlhpn02->part_no, $tlhpn01->proses) }}' style='width:80px' disabled></td>
               <td><input type='number' id='row-{{ $loop->iteration }}-nil_ct' name='row-{{ $loop->iteration }}-nil_ct' value='{{ $tlhpn02->nil_ct }}' style='width:60px' readonly></td>
               <td><input type='number' id='row-{{ $loop->iteration }}-target_lhp' name='row-{{ $loop->iteration }}-target_lhp' value='{{ $tlhpn02->target }}' style='width:60px' readonly></td>
               <td><input type='number' id='row-{{ $loop->iteration }}-jml_mat' name='row-{{ $loop->iteration }}-jml_mat' value='{{ $tlhpn02->jml_mat }}' onblur='getSelisih(event)' style='width:60px' required></td>
               <td><input type='number' id='row-{{ $loop->iteration }}-jml_ng' name='row-{{ $loop->iteration }}-jml_ng' value='{{ $tlhpn02->jml_ng }}' onblur='getSelisihNg(event)' style='width:60px' required></td>
               <td><input type='text' id="row-{{ $loop->iteration }}-kd_mesin" name="row-{{ $loop->iteration }}-kd_mesin" style='width:100px' onkeydown='popupMesin(event)' onchange='validateMesin(event)' value='{{ $tlhpn02->kd_mesin }}'></td>
               <td><input type='number' id='row-{{ $loop->iteration }}-selisih' name='row-{{ $loop->iteration }}-selisih' value='{{ $model->getSelisih($model->getTarget($model->menitLhp($tlhpn02->no_doc, $tlhpn02->jam_mulai, $tlhpn02->jam_selesai), $model->getCtTime($tlhpn02->part_no, $tlhpn01->proses)), $tlhpn02->jml_mat, $tlhpn02->jml_ng) }}' style='width:60px' disabled></td>
               <td><input type='number' id='row-{{ $loop->iteration }}-menit_ls' name='row-{{ $loop->iteration }}-menit_ls' value='{{ $model->getMenitLs($model->getTarget($model->menitLhp($tlhpn02->no_doc, $tlhpn02->jam_mulai, $tlhpn02->jam_selesai), $model->getCtTime($tlhpn02->part_no, $tlhpn01->proses)), $tlhpn02->jml_mat, $tlhpn02->jml_ng, $model->getCtTime($tlhpn02->part_no, $tlhpn01->proses)) }}' style='width:60px' disabled></td>         
             </tr>
             @endforeach
             @endif
             </tbody>
           </table>
        </div>     
      <!-- /.box-body -->
    </div>
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Detail Line Stop</h3>
      </div>
      <!-- /.box-header -->
        <div class="box-body">
          <p>
            <button id="addRows" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Tambah Baris"><span class="glyphicon glyphicon-plus"></span></button>
            &nbsp;&nbsp;
            <button id="removeRows" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Baris"><span class="glyphicon glyphicon-minus"></span></button>
            &nbsp;&nbsp;
            <button id="removeAlls" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Semua Baris"><span class="glyphicon glyphicon-trash"></span></button>
          </p>
          <table id="tblDetails" class="table table-bordered table-hover" cellspacing="0" width="100%">
           <thead>
              <tr>
               <th style="width: 2%;">No</th>
               <th style="width: 10%;">Dept<font color='red'>&nbsp;(F9)</font></th>
               <th style="width: 2%;">Jam Mulai</th>
               <th style="width: 2%;">Jam Selesai</th>
               <th style="width: 2%;">Menit</th>
               <th style="width: 8%;">Main<font color='red'>&nbsp;(F9)</font></th>
               <th style="width: 15%;">Deskripsi</th>
               <th style="width: 8%;">Ctgr<font color='red'>&nbsp;(F9)</font></th>
               <th style="width: 25%;">Deskripsi</th>
               <th style="width: 10%;">Mesin<font color='red'>&nbsp;(F9)</font></th>
               <th style="width: 2%;">Uraian</th>
             </tr>
           </thead>
           <tbody>
              @if (!empty($tlhpn01->no_doc)) 
              @foreach ($model->tlhpn01DetLs($tlhpn01->no_doc)->get() as $tlhpn04)
              <tr>
               <td>{{ $loop->iteration }}</td>
               <td><input type='hidden' value="row-{{ $loop->iteration }}-kd_dept"><input type='hidden' id='row-{{ $loop->iteration }}-ids' name='row-{{ $loop->iteration }}-ids' readonly><input type='text' id="row-{{ $loop->iteration }}-kd_dept" name="row-{{ $loop->iteration }}-kd_dept" style='width:60px' onkeydown='popupDept(event)' onchange='validateDept(event)' value='{{ $tlhpn04->kd_dept }}'></td>
               <td><input type='time' id='row-{{ $loop->iteration }}-ls_mulai' name='row-{{ $loop->iteration }}-ls_mulai' value='{{ \Carbon\Carbon::parse($tlhpn04->ls_mulai)->format('H:i') }}' onblur='getMenitAwalLs(event)' style='width:70px' required></td>
               <td><input type='time' id='row-{{ $loop->iteration }}-ls_selesai' name='row-{{ $loop->iteration }}-ls_selesai' value='{{ \Carbon\Carbon::parse($tlhpn04->ls_selesai)->format('H:i') }}' onblur='getMenitLs(event)' style='width:70px' required></td>
               <td><input type='number' id="row-{{ $loop->iteration }}-ls_menit" name="row-{{ $loop->iteration }}-ls_menit" style='width:60px' value='{{ $model->menitLhp($tlhpn04->no_doc, $tlhpn04->ls_mulai, $tlhpn04->ls_selesai) }}' disabled></td>
               <td><input type='text' id="row-{{ $loop->iteration }}-kd_ls" name="row-{{ $loop->iteration }}-kd_ls" style='width:60px' onkeydown='popupMain(event)' onchange='validateMain(event)' value='{{ $tlhpn04->kd_ls }}'></td>
               <td><input type='text' id="row-{{ $loop->iteration }}-nm_ls" name="row-{{ $loop->iteration }}-nm_ls" style='width:130px' value='{{ $model->getDescMain($tlhpn04->kd_ls) }}' disabled></td>
               <td><input type='text' id="row-{{ $loop->iteration }}-ls_cat" name="row-{{ $loop->iteration }}-ls_cat" style='width:60px' onkeydown='popupKat(event)' onchange='validateKat(event)' value='{{ $tlhpn04->ls_cat }}'></td>
               <td><input type='text' id="row-{{ $loop->iteration }}-nm_cat" name="row-{{ $loop->iteration }}-nm_cat" style='width:220px' value='{{ $model->getDescKat($tlhpn04->kd_ls, $tlhpn04->ls_cat) }}' disabled></td>
               <td><input type='text' id="row-{{ $loop->iteration }}-kd_mesin_ls" name="row-{{ $loop->iteration }}-kd_mesin_ls" style='width:100px' onkeydown='popupMesin(event)' onchange='validateMesin(event)' value='{{ $tlhpn04->kd_mesin }}'></td>
               <td><textarea id="row-{{ $loop->iteration }}-uraian" name="row-{{ $loop->iteration }}-uraian" rows='2' cols='100'>{{ $tlhpn04->uraian }}</textarea></td>
             </tr>
             @endforeach
             @endif
             </tbody>
           </table>
        </div>     
      <!-- /.box-body -->
    </div>
  <!-- /.box -->
  </div>
<!-- /.col -->
</div>
<!-- /.row -->
</div>
<!-- /.box-body -->
<div class="box-footer">
  {!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  &nbsp;&nbsp;
  @if (!empty($tlhpn01->no_doc))
  <button id="btn-delete" type="button" class="btn btn-danger">Delete</button>
  &nbsp;&nbsp;
  @endif
  <a class="btn btn-default" href="{{ route('prodlhp.index') }}">Cancel</a>
</div>

<!-- Modal Proses -->
@include('prod.prodlhp.popup.prosesModal')
<!-- Modal Partno -->
@include('prod.prodlhp.popup.partnoModal')
<!-- Modal Mesin -->
@include('prod.prodlhp.popup.mesinModal')
<!-- Modal Dept -->
@include('prod.prodlhp.popup.deptModal')
<!-- Modal Main -->
@include('prod.prodlhp.popup.mainModal')
<!-- Modal Kat -->
@include('prod.prodlhp.popup.katModal')

@section('scripts')
<script type="text/javascript">

    document.getElementById("tgl_doc").focus();
    function autoUpperCase(a){
      a.value = a.value.toUpperCase();
    }   
    validateProses();
    document.getElementById("removeAll").disabled = true; 
    document.getElementById("removeAlls").disabled = true; 
    getJmlLs();

    $(document).ready(function(){
      //press enter tapi tidak submit
      $(window).keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
      });
      $("#btnpopupProses").click(function(){
        popupProses();
      });

      $('#form_id').submit(function (e, params) {
        var localParams = params || {};
        if (!localParams.send) {
          e.preventDefault();
          var valid = 'T';
          if(valid === 'T') {
            //additional input validations can be done hear
            swal({
              title: 'Are you sure?',
              text: '',
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
              $(e.currentTarget).trigger(e.type, { 'send': true });
            })
          }
        }
      });
    
      //MEMBUAT TABEL DETAIL
      var table = $('#tblDetail').DataTable({
        "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
        "iDisplayLength": 10,
        'searching': false,
        "ordering": false,
        "scrollX": "true",
        "scrollY": "500px",
        "scrollCollapse": true,
        "paging": false
      });
      
      document.getElementById("removeRow").disabled = true;

      var counter = table.rows().count();
      document.getElementById("jml_tbl_detail").value = counter;

      //MEMBUAT TABEL DETAIL
      var tables = $('#tblDetails').DataTable({
        "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
        "iDisplayLength": 10,
          //responsive: true,
          'searching': false,
          'ordering': false,
          "scrollX": "true",
          "scrollY": "500px",
          "scrollCollapse": true,
          "paging": false
      });
      document.getElementById("removeRows").disabled = true;

      var counters = tables.rows().count();
      document.getElementById("jml_tbl_details").value = counters;

      $("#btn-delete").click(function(){
        var no_doc = document.getElementById("no_doc").value;
        if(no_doc !== "") {
          var msg = 'Anda yakin menghapus data ini?';
          var txt = 'No Doc: ' + no_doc;
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
            var urlRedirect = "{{ route('prodlhp.delete', 'param') }}";
            urlRedirect = urlRedirect.replace('param', window.btoa(no_doc));
            window.location.href = urlRedirect;
          }, function (dismiss) {
            if (dismiss === 'cancel') {
            }
          })
        }
      });

      counter = table.rows().count();
      if (counter == 0){
         document.getElementById("addRow").disabled = false; 
        } else {
      } 

      $('#addRow').on( 'click', function () {
       counter = table.rows().count();
       var jml_mp_ot = document.getElementById('jml_mp_ot').value;
        var shift = document.getElementById('shift').value;
        var kd_line = document.getElementById('kd_line').value;
        var url = '{{ route('prodlhp.getWorkingTime', ['param', 'param1','param2']) }}';
        url = url.replace('param', window.btoa(shift));
        url = url.replace('param1', window.btoa(jml_mp_ot));
        url = url.replace('param2', window.btoa(kd_line));
        var record = 1;


         $.get(url, function(result){ 
              
            if(result !== 'null'){

              result = JSON.parse(result);
              var res_count = result.length;  
             console.log(result);
            for (counter = 0; counter < res_count; counter++) {
              var i = counter;
           // counter++;
           document.getElementById("jml_tbl_detail").value = counter;
           var id = 'row-' + counter +'-id';
           var jam_mulai = 'row-' + counter +'-jam_mulai';
           var jam_selesai = 'row-' + counter +'-jam_selesai';
           var menit_lhp = 'row-' + counter +'-menit_lhp';
           var no_seq = 'row-' + counter +'-no_seq';
           var part_no = 'row-' + counter +'-part_no';       
           var partname = 'row-' + counter +'-partname';
           var model = 'row-' + counter +'-model';
           var nil_ct = 'row-' + counter +'-nil_ct';
           var target_lhp = 'row-' + counter +'-target_lhp';
           var jml_mat = 'row-' + counter +'-jml_mat';
           var jml_ng = 'row-' + counter +'-jml_ng';
           var kd_mesin = 'row-' + counter +'-kd_mesin';
           var selisih = 'row-' + counter +'-selisih';
           var menit_ls = 'row-' + counter +'-menit_ls';
           var val_jam_mulai =result[i]["jam_mulai"];
           var val_jam_selesai =  result[i]["jam_selesai"];
           var val_menit = result[i]["menit"];

           table.row.add([
            counter,
            "<input type='hidden' value=" + part_no + "><input type='time' id=" + jam_mulai + " name=" + jam_mulai + " value="+ val_jam_mulai +" onblur='getMenitAwal(event)'  style='width:70px' readonly>",
            "<input type='time' id=" + jam_selesai + " name=" + jam_selesai + " value="+ val_jam_selesai +" style='width:70px' onblur='getMenit(event)' readonly>",
            "<input type='number' id=" + menit_lhp + " name=" + menit_lhp + " style='width:60px' value="+ val_menit +" readonly>",
             // "<input type='number' id=" + menit_lhp + " name=" + menit_lhp + " style='width:60px' value="+ val_menit +"' disabled>",
            "<input type='text' id=" + part_no + " name=" + part_no + " style='width:120px' maxlength='40' onkeydown='popupPartno(event)' onchange='validatePartno(event)' required><input type='hidden' id=" + id + " name=" + id + " readonly='readonly'><input type='hidden' id=" + no_seq + " name=" + no_seq + ">",
            "<textarea id=" + partname + " name=" + partname + " rows='2' cols='40' style='text-transform:uppercase;resize:vertical' disabled></textarea>",
            "<input type='text' id=" + model + " name=" + model + " style='width:80px' disabled>",
            "<input type='number' id=" + nil_ct + " name=" + nil_ct + " style='width:60px' readonly>",
            "<input type='number' id=" + target_lhp + " name=" + target_lhp + " style='width:60px' readonly>",
            "<input type='number' id=" + jml_mat + " name=" + jml_mat + " onblur='getSelisih(event)' value='0' style='width:60px' required>",
            "<input type='number' id=" + jml_ng + " name=" + jml_ng + " onblur='getSelisihNg(event)' value='0' style='width:60px' required>",
            "<input type='text' id=" + kd_mesin + " name=" + kd_mesin + " style='width:100px' onkeydown='popupMesin(event)' onchange='validateMesin(event)'>",
            "<input type='number' id=" + selisih + " name=" + selisih + " style='width:60px' disabled>",
            "<input type='number' id=" + menit_ls + " name=" + menit_ls + " style='width:60px' disabled>"
            ]).draw(false);
            }
            document.getElementById("addRow").disabled = true; 
          } else {
            swal("data tidak ditemukan");
          }
           
          });

      });

      $('#addRows').on( 'click', function () {
       counters = tables.rows().count();
       counters++;
       document.getElementById("jml_tbl_details").value = counters;
       var id = 'row-' + counters +'-ids';
       var kd_dept = 'row-' + counters +'-kd_dept';
       var ls_mulai = 'row-' + counters +'-ls_mulai';
       var ls_selesai = 'row-' + counters +'-ls_selesai';
       var ls_menit = 'row-' + counters +'-ls_menit';
       var kd_ls = 'row-' + counters +'-kd_ls';
       var nm_ls = 'row-' + counters +'-nm_ls';
       var ls_cat = 'row-' + counters +'-ls_cat';
       var nm_cat = 'row-' + counters +'-nm_cat';
       var kd_mesin_ls = 'row-' + counters +'-kd_mesin_ls';
       var uraian = 'row-' + counters +'-uraian';
       tables.row.add([
        counters,
        "<input type='hidden' value=" + kd_dept + "><input type='hidden' id=" + id + " name=" + id + " readonly><input type='text' id="+ kd_dept +" name="+ kd_dept +" style='width:60px' onkeydown='popupDept(event)' onchange='validateDept(event)'>",
        "<input type='time' id=" + ls_mulai + " name=" + ls_mulai + " value='00:00' onblur='getMenitAwalLs(event)' style='width:70px'>",
        "<input type='time' id=" + ls_selesai + " name=" + ls_selesai + " value='00:00' style='width:70px' onblur='getMenitLs(event)'>",
        "<input type='number' id=" + ls_menit + " name=" + ls_menit + " style='width:60px' value='0' disabled>",
        "<input type='text' id=" + kd_ls + " name=" + kd_ls + " style='width:60px' onkeydown='popupMain(event)' onchange='validateMain(event)'>",
        "<input type='text' id=" + nm_ls + " name=" + nm_ls + " style='width:130px' disabled>",
        "<input type='text' id=" + ls_cat + " name=" + ls_cat + " style='width:60px' onkeydown='popupKat(event)' onchange='validateKat(event)'>",
        "<input type='text' id=" + nm_cat + " name=" + nm_cat + " style='width:220px' disabled>",
        "<input type='text' id=" + kd_mesin_ls + " name=" + kd_mesin_ls + " style='width:100px' onkeydown='popupMesin(event)' onchange='validateMesin(event)'>",
        "<textarea id=" + uraian + " name=" + uraian + " rows='2' cols='100'></textarea>"
        ]).draw(false);
      });

      $('#tblDetail tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
          $(this).removeClass('selected');
          document.getElementById("removeRow").disabled = true;      
        } else {
          table.$('tr.selected').removeClass('selected');
          $(this).addClass('selected');
          document.getElementById("removeRow").disabled = false;
          //untuk memunculkan gambar
          var row = table.row('.selected').index();
        }
      });

      $('#tblDetails tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
          $(this).removeClass('selected');
          document.getElementById("removeRows").disabled = true;      
        } else {
          table.$('tr.selected').removeClass('selected');
          $(this).addClass('selected');
          document.getElementById("removeRows").disabled = false;
          //untuk memunculkan gambar
          var row = table.row('.selected').index();
        }
      });

      $('#removeRow').click( function () {
       var table = $('#tblDetail').DataTable();
       var counter = table.rows().count()-1;
       document.getElementById("jml_tbl_detail").value = counter;
       var index = table.row('.selected').index();
       var row = index;
       if(index == null) {
          swal("Tidak ada data yang dipilih!", "", "warning");
        } else {
              var target = 'row-' + (row+1) + '-';
              var id = document.getElementById(target +'id').value.trim();
              var no_doc = document.getElementById("no_doc").value;
              var part_no = document.getElementById(target +'part_no').value.trim();
              var no_seq = document.getElementById(target +'no_seq').value.trim();
              
              
              if(no_doc === '') {
                changeId(row);
              } else {
                if(part_no === '' && no_seq === '') {
                  changeId(row);
                }else{          
                  swal({
                    title: "Are you sure?",
                    text: "Partno: " + part_no,
                    type: "warning",
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
                  //startcode
                  var info = "";
                  var info2 = "";
                  var info3 = "warning";
                  
                //DELETE DI DATABASE
                // remove these events;
                window.onkeydown = null;
                window.onfocus = null;
                var token = document.getElementsByName('_token')[0].value.trim();
                // delete via ajax
                // hapus data detail dengan ajax
                var url = "{{ route('prodlhp.hapus', ['param', 'param1', 'param2'])}}";
                url = url.replace('param',  window.btoa(no_doc));
                url = url.replace('param1', window.btoa(part_no));
                url = url.replace('param2', window.btoa(no_seq));
                $.ajax({
                  type     : 'POST',
                  url      : url,
                  dataType : 'json',
                  data     : {
                    _method : 'GET',
                    // menambah csrf token dari Laravel
                    _token  : token
                  },
                  success:function(data){
                   if(data.status === 'OK'){
                    changeId(row);
                    info = "Deleted!";
                    info2 = data.message;
                    info3 = "success";
                    swal(info, info2, info3);
                  } else {
                    info = "Cancelled";
                    info2 = data.message;
                    info3 = "error";
                    swal(info, info2, info3);
                  }
                }, error:function(){ 
                  info = "System Error!";
                  info2 = "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.";
                  info3 = "error";
                  swal(info, info2, info3);
                }
              });
                //END DELETE DI DATABASE

              //finishcode
            }, function (dismiss) {
                if (dismiss === 'cancel') {
                  swal(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                  )
                }
              })
                }
              }
            }    
      });

      $('#removeRows').click( function () {
       var table = $('#tblDetails').DataTable();
       var counter = table.rows().count()-1;
       document.getElementById("jml_tbl_details").value = counter;
       var index = table.row('.selected').index();
       var row = index;
       if(index == null) {
          swal("Tidak ada data yang dipilih!", "", "warning");
        } else {
              var target = 'row-' + (row+1) + '-';
              var id = document.getElementById(target +'ids').value.trim();
              var no_doc = document.getElementById("no_doc").value;
              var ls_mulai = document.getElementById(target +'ls_mulai').value.trim();              
              
              if(no_doc === '') {
                changeIds(row);
              } else {
                if(ls_mulai === '') {
                  changeIds(row);
                }else{          
                  swal({
                    title: "Are you sure?",
                    text: "Mulai: " + ls_mulai,
                    type: "warning",
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
                  //startcode
                  var info = "";
                  var info2 = "";
                  var info3 = "warning";
                  
                //DELETE DI DATABASE
                // remove these events;
                window.onkeydown = null;
                window.onfocus = null;
                var token = document.getElementsByName('_token')[0].value.trim();
                // delete via ajax
                // hapus data detail dengan ajax
                var url = "{{ route('prodlhp.hapusls', ['param', 'param1'])}}";
                url = url.replace('param',  window.btoa(no_doc));
                url = url.replace('param1', window.btoa(ls_mulai));
                $.ajax({
                  type     : 'POST',
                  url      : url,
                  dataType : 'json',
                  data     : {
                    _method : 'GET',
                    // menambah csrf token dari Laravel
                    _token  : token
                  },
                  success:function(data){
                   if(data.status === 'OK'){
                    changeIds(row);
                    info = "Deleted!";
                    info2 = data.message;
                    info3 = "success";
                    swal(info, info2, info3);
                  } else {
                    info = "Cancelled";
                    info2 = data.message;
                    info3 = "error";
                    swal(info, info2, info3);
                  }
                }, error:function(){ 
                  info = "System Error!";
                  info2 = "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.";
                  info3 = "error";
                  swal(info, info2, info3);
                }
              });
                //END DELETE DI DATABASE

              //finishcode
            }, function (dismiss) {
                // dismiss can be 'cancel', 'overlay',
                // 'close', and 'timer'
                if (dismiss === 'cancel') {
                  swal(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                  )
                }
              })
                }
              }
            }    
      });

      $('#removeAll').click( function () {
        var no_doc = document.getElementById("no_doc").value;
        swal({
          title: "Are you sure?",
          text: "Remove All Detail",
          type: "warning",
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
                              //startcode
                              var info = "";
                              var info2 = "";
                              var info3 = "warning";

                              //DELETE DI DATABASE
                              // remove these events;
                              window.onkeydown = null;
                              window.onfocus = null;
                              var token = document.getElementsByName('_token')[0].value.trim();
                              // delete via ajax
                              // hapus data detail dengan ajax
                              var url = "{{ route('prodlhp.hapusdetail', ['param'])}}";
                              url = url.replace('param',  window.btoa(no_doc));
                              $.ajax({
                                type     : 'POST',
                                url      : url,
                                dataType : 'json',
                                data     : {
                                  _method : 'GET',
                                  // menambah csrf token dari Laravel
                                  _token  : token
                                },
                                success:function(data){
                                  if(data.status === 'OK'){
                                    info = "Deleted!";
                                    info2 = data.message;
                                    info3 = "success";
                                    swal(info, info2, info3);
                                  //clear tabel
                                  var table = $('#tblDetail').DataTable();
                                  table.clear().draw(false);
                                } else {
                                  info = "Cancelled";
                                  info2 = data.message;
                                  info3 = "error";
                                  swal(info, info2, info3);
                                }
                              }, error:function(){ 
                                info = "System Error!";
                                info2 = "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.";
                                info3 = "error";
                                swal(info, info2, info3);
                              }
                            });

                            }, function (dismiss) {
                              if (dismiss === 'cancel') {
                              }
                            })    
      });

      $('#removeAlls').click( function () {
        var no_doc = document.getElementById("no_doc").value;
        swal({
          title: "Are you sure?",
          text: "Remove All Detail",
          type: "warning",
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
                              //startcode
                              var info = "";
                              var info2 = "";
                              var info3 = "warning";

                              //DELETE DI DATABASE
                              // remove these events;
                              window.onkeydown = null;
                              window.onfocus = null;
                              var token = document.getElementsByName('_token')[0].value.trim();
                              // delete via ajax
                              // hapus data detail dengan ajax
                              var url = "{{ route('prodlhp.hapusdetails', ['param'])}}";
                              url = url.replace('param',  window.btoa(no_doc));
                              $.ajax({
                                type     : 'POST',
                                url      : url,
                                dataType : 'json',
                                data     : {
                                  _method : 'GET',
                                  // menambah csrf token dari Laravel
                                  _token  : token
                                },
                                success:function(data){
                                  if(data.status === 'OK'){
                                    info = "Deleted!";
                                    info2 = data.message;
                                    info3 = "success";
                                    swal(info, info2, info3);
                                  //clear tabel
                                  var table = $('#tblDetails').DataTable();
                                  table.clear().draw(false);
                                } else {
                                  info = "Cancelled";
                                  info2 = data.message;
                                  info3 = "error";
                                  swal(info, info2, info3);
                                }
                              }, error:function(){ 
                                info = "System Error!";
                                info2 = "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.";
                                info3 = "error";
                                swal(info, info2, info3);
                              }
                            });

                            }, function (dismiss) {
                              if (dismiss === 'cancel') {
                              }
                            })    
      });

    });

  function btnpopupProsesClick(e) {
      if(e.keyCode == 120) { //F9
        $('#btnpopupProses').click();
      } else if(e.keyCode == 9) { //TAB
        e.preventDefault();
        document.getElementById('btnpopupProses').focus();
      }
  }

  function popupProses() {
     $('#prosesModal').modal('show');

      var myHeading = "<p>Popup Proses</p>";
      $("#prosesModalLabel").html(myHeading);
      var url = '{{ route('datatables.popupProsesLhp', 'param') }}';
      var plant = $('select[name="kd_plant"]').val();
      url = url.replace('param', window.btoa(plant));
      
      var lookupProses = $('#lookupProses').DataTable({
        processing: true, 
        "oLanguage": {
          'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
        }, 
        serverSide: true,
        "pagingType": "numbers",
        ajax: url,
        "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
        responsive: true,
        "order": [[1, 'asc']],
        columns: [
          { data: 'kd_pros', name: 'kd_pros'},
          { data: 'nm_pros', name: 'nm_pros'},
          { data: 'kd_line', name: 'kd_line'},
          { data: 'nm_line', name: 'nm_line'}
        ],
        "bDestroy": true,
        "initComplete": function(settings, json) {
          $('div.dataTables_filter input').focus();
          
          $('#lookupProses tbody').on( 'dblclick', 'tr', function () {
            var dataArr = [];
            var rows = $(this);
            var rowData = lookupProses.rows(rows).data();
            $.each($(rowData),function(key,value){
              document.getElementById("proses").value = value["kd_pros"];
              document.getElementById("nm_proses").value = value["nm_pros"];
              document.getElementById("kd_line").value = value["kd_line"];
              document.getElementById("nm_line").value = value["nm_line"];
              $('#prosesModal').modal('hide');
                validateProses();             
            });
          });
          $('#prosesModal').on('hidden.bs.modal', function () {
            var kd_pros = document.getElementById("proses").value.trim();
            if(kd_pros === '') {
              document.getElementById("nm_proses").value = "";
              document.getElementById("kd_line").value = "";
              document.getElementById("nm_line").value = "";
              $('#proses').focus();
            } else {

            }
          });
        },
      });
  }
  
  function validateProses() {
    var kd_pros = document.getElementById('proses').value.trim();;
    var kd_plant = document.getElementById("kd_plant").value.trim();

    if(kd_pros !== '') {
      var url = '{{ route('datatables.validasiProsesLhp', ['param', 'param2']) }}';
      url = url.replace('param', window.btoa(kd_plant));
      url = url.replace('param2', window.btoa(kd_pros));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("proses").value = result["kd_pros"];
          document.getElementById("nm_proses").value = result["nm_pros"];
          document.getElementById("kd_line").value = result["kd_line"];
          document.getElementById("nm_line").value = result["nm_line"];
          document.getElementById('btnpopupProses').focus();
        } else {
          document.getElementById("proses").value = "";
          document.getElementById("nm_proses").value = "";
          document.getElementById("kd_line").value = "";
          document.getElementById("nm_line").value = "";
          document.getElementById("proses").focus();
          swal("Kode Proses tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }

      });
    } else {
      document.getElementById("proses").value = "";
      document.getElementById("nm_proses").value = "";
      document.getElementById("kd_line").value = "";
      document.getElementById("nm_line").value = "";
    }
  }

  function popupPartno(e) {
      if(e.keyCode == 120 || e.keyCode == 13) {
        var kd_pros = document.getElementById("proses").value.trim();
        if(kd_pros === ''){
           swal("Kode Proses tidak boleh kosong!", "Perhatikan inputan anda!", "warning").then(function () {
              document.getElementById("proses").focus();
           });
           
        } else {
          var myHeading = "<p>Popup Partno</p>";
          $("#partnoModalLabel").html(myHeading);
          var url = '{{ route('datatables.popupPartnoLhp', ['param']) }}';
          url = url.replace('param', window.btoa(kd_pros));
          $('#partnoModal').modal('show');
          var lookupPartno = $('#lookupPartno').DataTable({
            processing: true, 
            "oLanguage": {
              'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
            }, 
            serverSide: true,
            pagingType: "simple",
            "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
            ajax: url,
            columns: [
            { data: 'partno', name: 'partno'},
            { data: 'partname_in', name: 'partname_in'},
            { data: 'model', name: 'model'},          
            { data: 'ct_time', name: 'ct_time'}
            ],
            "bDestroy": true,
            "initComplete": function(settings, json) {
             $('div.dataTables_filter input').focus();
             $('#lookupPartno tbody').on( 'dblclick', 'tr', function () {
              var dataArr = [];
              var rows = $(this);
              var rowData = lookupPartno.rows(rows).data();
              $.each($(rowData),function(key,value){
               var id = e.target.id.replace('part_no', '');
               document.getElementById(e.target.id).value = value["partno"];
               document.getElementById(id +'partname').value = value["partname_in"];
               document.getElementById(id +'model').value = value["model"];
               document.getElementById(id +'nil_ct').value = value["ct_time"];
               getTarget(id);
              $('#partnoModal').modal('hide');               
               document.getElementById(id +'part_no').focus();              
              });
            });
             $('#partnoModal').on('hidden.bs.modal', function () {
              var partno = document.getElementById(e.target.id).value.trim();
              if(partno === '') {
               document.getElementById(e.target.id).focus();
             } else {
               var id = e.target.id.replace('part_no', '');
               document.getElementById(id +'part_no').focus();
             }
           });
           },
         });
        }
      }else if(e.keyCode == 9) {
        var id = e.target.id.replace('part_no', '');
        document.getElementById(id +'target_lhp').focus(); 
      } 
  }

  function validatePartno(e){
    var kd_pros = document.getElementById("proses").value.trim();
      if(kd_pros === ''){
         swal("Kode Proses tidak boleh kosong!", "Perhatikan inputan anda!", "warning").then(function () {
            var id = e.target.id.replace('part_no', '');    
            var partno = document.getElementById(e.target.id).value.trim();
            document.getElementById(e.target.id).value = "";
            document.getElementById(id +'partname').value = "";
            document.getElementById(id +'model').value = "";
            document.getElementById(id +'nil_ct').value = "";
            document.getElementById(id +'target_lhp').value = "";
            document.getElementById("proses").focus();
         });
      } else {
          var id = e.target.id.replace('part_no', '');    
          var partno = document.getElementById(e.target.id).value.trim();
          if(partno === '') {
           document.getElementById(e.target.id).value = "";
           document.getElementById(id +'partname').value = "";
           document.getElementById(id +'model').value = "";
           document.getElementById(id +'nil_ct').value = "";
           document.getElementById(id +'target_lhp').value = "";
          } else {
             var url = '{{ route('datatables.validasiPartnoLhp', ['param', 'param2']) }}';
             url = url.replace('param', window.btoa(kd_pros));
             url = url.replace('param2', window.btoa(partno));
             $.get(url, function(result){  
              if(result !== 'null'){
               result = JSON.parse(result);
               document.getElementById(id +'partname').value = result["partname_in"];
               document.getElementById(id +'model').value = result["model"];
               document.getElementById(id +'nil_ct').value = result["ct_time"];
               getTarget(id);
               document.getElementById(id +'jml_mat').focus();        
                } else {
                 document.getElementById(e.target.id).value = "";
                 document.getElementById(id +'partname').value = "";
                 document.getElementById(id +'model').value = "";
                 document.getElementById(id +'nil_ct').value = "";
                 document.getElementById(id +'target_lhp').value = "";
                 document.getElementById(e.target.id).focus();
                 swal("Partno tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
               }
             });
          } 
      }
  }

  function popupMesin(e) {
    if(e.keyCode == 120 || e.keyCode == 13) {
      var kd_pros = document.getElementById("proses").value.trim();
      if(kd_pros === ''){
         swal("Kode Proses tidak boleh kosong!", "Perhatikan inputan anda!", "warning").then(function () {
            document.getElementById("proses").focus();
         });
      } else {
        var myHeading = "<p>Popup Mesin</p>";
        $("#mesinModalLabel").html(myHeading);
        var url = '{{ route('datatables.popupMesinLhp', ['param']) }}';
        url = url.replace('param', window.btoa(kd_pros));
        $('#mesinModal').modal('show');
        var lookupMesin = $('#lookupMesin').DataTable({
          processing: true, 
          "oLanguage": {
            'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
          }, 
          serverSide: true,
          pagingType: "simple",
          "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
          ajax: url,
          columns: [
          { data: 'kd_mesin', name: 'kd_mesin'},
          { data: 'nama_mesin', name: 'nama_mesin'}
          ],
          "bDestroy": true,
          "initComplete": function(settings, json) {
           $('div.dataTables_filter input').focus();
           $('#lookupMesin tbody').on( 'dblclick', 'tr', function () {
            var dataArr = [];
            var rows = $(this);
            var rowData = lookupMesin.rows(rows).data();
            $.each($(rowData),function(key,value){
             var id = e.target.id.replace('part_no', '');
             document.getElementById(e.target.id).value = value["kd_mesin"];
            $('#mesinModal').modal('hide');             
             document.getElementById(e.target.id).focus();                                       
            });
          });
           $('#mesinModal').on('hidden.bs.modal', function () {
            var mesin = document.getElementById(e.target.id).value.trim();
            if(mesin === '') {
             document.getElementById(e.target.id).focus();
           } else {
             var id = e.target.id.replace('part_no', '');
             document.getElementById(e.target.id).focus(); 
           }
         });
         },
       });
      }
    }
  }

  function validateMesin(e){
    var kd_pros = document.getElementById("proses").value.trim();
      if(kd_pros === ''){
         swal("Kode Proses tidak boleh kosong!", "Perhatikan inputan anda!", "warning").then(function () {
            var id = e.target.id.replace('part_no', '');    
            var mesin = document.getElementById(e.target.id).value.trim();
            document.getElementById(e.target.id).value = "";
            document.getElementById("proses").focus();
         });
      } else {
          var id = e.target.id.replace('part_no', '');    
          var mesin = document.getElementById(e.target.id).value.trim();
          if(mesin === '') {
           document.getElementById(e.target.id).value = "";
          } else {
             var url = '{{ route('datatables.validasiMesinLhp', ['param', 'param2']) }}';
             url = url.replace('param', window.btoa(kd_pros));
             url = url.replace('param2', window.btoa(mesin));
             $.get(url, function(result){  
              if(result !== 'null'){
               result = JSON.parse(result);         
                } else {
                 document.getElementById(e.target.id).value = "";
                 document.getElementById(e.target.id).focus();
                 swal("Mesin tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
               }
             });
          } 
      }
  }

  function changeId(row) {
    var table = $('#tblDetail').DataTable();
    table.row(row).remove().draw(false);
    var jml_row = document.getElementById("jml_tbl_detail").value.trim();
    jml_row = Number(jml_row) + 1;
    nextRow = Number(row) + 1;
    for($i = nextRow; $i <= jml_row; $i++) {
      var id = "#row-" + $i + "-id";
      var id_new = "row-" + ($i-1) + "-id";
      $(id).attr({"id":id_new, "name":id_new});
      var jam_mulai = "#row-" + $i + "-jam_mulai";
      var jam_mulai_new = "row-" + ($i-1) + "-jam_mulai";
      $(jam_mulai).attr({"id":jam_mulai_new, "name":jam_mulai_new});
      var jam_selesai = "#row-" + $i + "-jam_selesai";
      var jam_selesai_new = "row-" + ($i-1) + "-jam_selesai";
      $(jam_selesai).attr({"id":jam_selesai_new, "name":jam_selesai_new});
      var menit_lhp = "#row-" + $i + "-menit_lhp";
      var menit_lhp_new = "row-" + ($i-1) + "-menit_lhp";
      $(menit_lhp).attr({"id":menit_lhp_new, "name":menit_lhp_new});
      var no_seq = "#row-" + $i + "-no_seq";
      var no_seq_new = "row-" + ($i-1) + "-no_seq";
      $(no_seq).attr({"id":no_seq_new, "name":no_seq_new});
      var part_no = "#row-" + $i + "-part_no";
      var part_no_new = "row-" + ($i-1) + "-part_no";
      $(part_no).attr({"id":part_no_new, "name":part_no_new});
      var partname = "#row-" + $i + "-partname";
      var partname_new = "row-" + ($i-1) + "-partname";
      $(partname).attr({"id":partname_new, "name":partname_new});
      var model = "#row-" + $i + "-model";
      var model_new = "row-" + ($i-1) + "-model";
      $(model).attr({"id":model_new, "name":model_new});
      var nil_ct = "#row-" + $i + "-nil_ct";
      var nil_ct_new = "row-" + ($i-1) + "-nil_ct";
      $(nil_ct).attr({"id":nil_ct_new, "name":nil_ct_new});
      var target_lhp = "#row-" + $i + "-target_lhp";
      var target_lhp_new = "row-" + ($i-1) + "-target_lhp";
      $(target_lhp).attr({"id":target_lhp_new, "name":target_lhp_new});
      var jml_mat = "#row-" + $i + "-jml_mat";
      var jml_mat_new = "row-" + ($i-1) + "-jml_mat";
      $(jml_mat).attr({"id":jml_mat_new, "name":jml_mat_new});
      var jml_ng = "#row-" + $i + "-jml_ng";
      var jml_ng_new = "row-" + ($i-1) + "-jml_ng";
      $(jml_ng).attr({"id":jml_ng_new, "name":jml_ng_new});
      var kd_mesin = "#row-" + $i + "-kd_mesin";
      var kd_mesin_new = "row-" + ($i-1) + "-kd_mesin";
      $(kd_mesin).attr({"id":kd_mesin_new, "name":kd_mesin_new});
      var selisih = "#row-" + $i + "-selisih";
      var selisih_new = "row-" + ($i-1) + "-selisih";
      $(selisih).attr({"id":selisih_new, "name":selisih_new});
      var menit_ls = "#row-" + $i + "-menit_ls";
      var menit_ls_new = "row-" + ($i-1) + "-menit_ls";
      $(menit_ls).attr({"id":menit_ls_new, "name":menit_ls_new}); 
    }
    //set ulang no tabel
    for($i = 0; $i < table.rows().count(); $i++) {
      table.cell($i, 0).data($i +1);
    }
    jml_row = jml_row - 1;
    document.getElementById("jml_tbl_detail").value = jml_row;
  }

  function changeIds(row) {
    var table = $('#tblDetails').DataTable();
    table.row(row).remove().draw(false);
    var jml_row = document.getElementById("jml_tbl_details").value.trim();
    jml_row = Number(jml_row) + 1;
    nextRow = Number(row) + 1;
    for($i = nextRow; $i <= jml_row; $i++) {
      var id = "#row-" + $i + "-ids";
      var id_new = "row-" + ($i-1) + "-ids";
      $(id).attr({"id":id_new, "name":id_new});
      var kd_dept = "#row-" + $i + "-kd_dept";
      var kd_dept_new = "row-" + ($i-1) + "-kd_dept";
      $(kd_dept).attr({"id":kd_dept_new, "name":kd_dept_new});
      var ls_mulai = "#row-" + $i + "-ls_mulai";
      var ls_mulai_new = "row-" + ($i-1) + "-ls_mulai";
      $(ls_mulai).attr({"id":ls_mulai_new, "name":ls_mulai_new});
      var ls_selesai = "#row-" + $i + "-ls_selesai";
      var ls_selesai_new = "row-" + ($i-1) + "-ls_selesai";
      $(ls_selesai).attr({"id":ls_selesai_new, "name":ls_selesai_new});
      var ls_menit = "#row-" + $i + "-ls_menit";
      var ls_menit_new = "row-" + ($i-1) + "-ls_menit";
      $(ls_menit).attr({"id":ls_menit_new, "name":ls_menit_new});
      var kd_ls = "#row-" + $i + "-kd_ls";
      var kd_ls_new = "row-" + ($i-1) + "-kd_ls";
      $(kd_ls).attr({"id":kd_ls_new, "name":kd_ls_new});
      var nm_ls = "#row-" + $i + "-nm_ls";
      var nm_ls_new = "row-" + ($i-1) + "-nm_ls";
      $(nm_ls).attr({"id":nm_ls_new, "name":nm_ls_new});
      var kd_cat = "#row-" + $i + "-kd_cat";
      var kd_cat_new = "row-" + ($i-1) + "-kd_cat";
      $(kd_cat).attr({"id":kd_cat_new, "name":kd_cat_new});
      var nm_cat = "#row-" + $i + "-nm_cat";
      var nm_cat_new = "row-" + ($i-1) + "-nm_cat";
      $(nm_cat).attr({"id":nm_cat_new, "name":nm_cat_new});
      var kd_mesin_ls = "#row-" + $i + "-kd_mesin_ls";
      var kd_mesin_ls_new = "row-" + ($i-1) + "-kd_mesin_ls";
      $(kd_mesin_ls).attr({"id":kd_mesin_ls_new, "name":kd_mesin_ls_new});
      var uraian = "#row-" + $i + "-uraian";
      var uraian_new = "row-" + ($i-1) + "-uraian";
      $(uraian).attr({"id":uraian_new, "name":uraian_new});
    }
    //set ulang no tabel
    for($i = 0; $i < table.rows().count(); $i++) {
      table.cell($i, 0).data($i +1);
    }
    jml_row = jml_row - 1;
    document.getElementById("jml_tbl_details").value = jml_row;
  }

  function changeShift() {

  var no_doc = document.getElementById('no_doc').value;
  if (no_doc == ''){  
  //   $('#tblDetail').DataTable().clear();
     var tableg = $('#tblDetail').DataTable();
     tableg.clear().draw(false);
  } 
    var shift = document.getElementById('shift').value;
    if(shift==1){
       $('#awal_kerja').val('00:00');
       $('#akhir_kerja').val('07:30');
    } else if(shift==2){
       $('#awal_kerja').val('07:30');
       $('#akhir_kerja').val('16:15');
    } else if(shift==3){
       $('#awal_kerja').val('16:15');
       $('#akhir_kerja').val('00:00');
     }
  }

  function getMenitAwal(e){
          var no_doc = '-';
          var id = e.target.id.replace('jam_mulai', '');
          var jam_mulai = document.getElementById(e.target.id).value.trim();
          var jam_selesai = document.getElementById(id+'jam_selesai').value.trim();
          if(jam_mulai === '' || jam_selesai === '') {
           document.getElementById(id +'menit_lhp').value = "";
          } else {
             var url = '{{ route('prodlhp.getMenitLhp', ['param', 'param1', 'param2']) }}';
             url = url.replace('param', window.btoa(no_doc));
             url = url.replace('param1', window.btoa(jam_mulai));
             url = url.replace('param2', window.btoa(jam_selesai));
             
             $.get(url, function(result){  
              if(result !== 'null'){
               result = JSON.parse(result);
               document.getElementById(id +'menit_lhp').value = result["menit"];
               var part_no = document.getElementById(id+'part_no').value.trim();
                   if(part_no !== ''){
                    getTarget(id);
                   }
                } else {
                 document.getElementById(e.target.id).value = "";
                 document.getElementById(id +'menit_lhp').value = "";
                 document.getElementById(e.target.id).focus();
               }
             });
          }       
  }

  function getMenit(e){
          var no_doc = '-';
          var id = e.target.id.replace('jam_selesai', '');
          var jam_selesai = document.getElementById(e.target.id).value.trim();
          var jam_mulai = document.getElementById(id+'jam_mulai').value.trim();
          if(jam_mulai === '' || jam_selesai === '') {
           document.getElementById(id +'menit_lhp').value = "";
          } else {
             var url = '{{ route('prodlhp.getMenitLhp', ['param', 'param1', 'param2']) }}';
             url = url.replace('param', window.btoa(no_doc));
             url = url.replace('param1', window.btoa(jam_mulai));
             url = url.replace('param2', window.btoa(jam_selesai));
             
             $.get(url, function(result){  
              if(result !== 'null'){
               result = JSON.parse(result);
               document.getElementById(id +'menit_lhp').value = result["menit"];
               var part_no = document.getElementById(id+'part_no').value.trim();
                   if(part_no !== ''){
                    getTarget(id);
                   }         
                } else {
                 document.getElementById(e.target.id).value = "";
                 document.getElementById(id +'menit_lhp').value = "";
                 document.getElementById(e.target.id).focus();
               }
             });
          }       
  }

  function getTarget(id){
      var menit_lhp = document.getElementById(id +'menit_lhp').value.trim();
      var nil_ct = document.getElementById(id +'nil_ct').value.trim();
      if(menit_lhp === '') {
       document.getElementById(id +'target_lhp').value = "";
      } else {
         var target_lhp = (menit_lhp*60)/nil_ct;
         target_lhp = target_lhp.toFixed(2);
          if(target_lhp !== ''){
           document.getElementById(id +'target_lhp').value = Math.round(target_lhp);         
          } else {
             document.getElementById(id +'target_lhp').value = "";
          }
      }       
  }

  function getSelisih(e){
      var id = e.target.id.replace('jml_mat', '');
      var jml_mat = document.getElementById(e.target.id).value.trim();
      var target_lhp = document.getElementById(id +'target_lhp').value.trim();
      var nil_ct = document.getElementById(id +'nil_ct').value.trim();
      var jml_ng = document.getElementById(id +'jml_ng').value.trim();
      if(target_lhp === '' || jml_mat === '' || jml_ng === '' || nil_ct === '') {
       document.getElementById(id +'selisih').value = "";
       document.getElementById(id +'menit_ls').value = "";
      } else {
         var selisih = target_lhp - jml_mat - jml_ng;
         selisih = selisih.toFixed(2);      
          if(selisih !== ''){
             document.getElementById(id +'selisih').value = selisih;
             if(selisih > 0){
              var menit_ls = (selisih * nil_ct) / 60;
              menit_ls = menit_ls.toFixed(2);
              document.getElementById(id +'menit_ls').value = menit_ls;
             } else {
              document.getElementById(id +'menit_ls').value = "0";
             }      
          } else {
             document.getElementById(id +'selisih').value = "";
             document.getElementById(id +'menit_ls').value = "";
          }
      }       
  }

  function getSelisihNg(e){
      var id = e.target.id.replace('jml_ng', '');
      var jml_ng = document.getElementById(e.target.id).value.trim();
      var target_lhp = document.getElementById(id +'target_lhp').value.trim();
      var nil_ct = document.getElementById(id +'nil_ct').value.trim();
      var jml_mat = document.getElementById(id +'jml_mat').value.trim();
      if(target_lhp === '' || jml_mat === '' || jml_ng === '' || nil_ct === '') {
       document.getElementById(id +'selisih').value = "";
       document.getElementById(id +'menit_ls').value = "";
      } else {
         var selisih = target_lhp - jml_mat - jml_ng;
         selisih = selisih.toFixed(2);
          if(selisih !== ''){
             document.getElementById(id +'selisih').value = selisih;
             if(selisih > 0){
              var menit_ls = (selisih * nil_ct) / 60;
              menit_ls = menit_ls.toFixed(2);
              document.getElementById(id +'menit_ls').value = menit_ls;
             } else {
              document.getElementById(id +'menit_ls').value = "0";
             }      
          } else {
             document.getElementById(id +'selisih').value = "";
             document.getElementById(id +'menit_ls').value = "";
          }
      }       
  }

  //Tabel Detail LS
  function popupDept(e) {
      if(e.keyCode == 120 || e.keyCode == 13) {
        var kd_plant = document.getElementById("kd_plant").value.trim();        
          var myHeading = "<p>Popup Dept</p>";
          $("#deptModalLabel").html(myHeading);
          var url = '{{ route('datatables.popupDepLhp', ['param']) }}';
          url = url.replace('param', window.btoa(kd_plant));
          $('#deptModal').modal('show');
          var lookupDept = $('#lookupDept').DataTable({
            processing: true, 
            "oLanguage": {
              'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
            }, 
            serverSide: true,
            pagingType: "simple",
            "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
            ajax: url,
            columns: [
            { data: 'kd_dep', name: 'kd_dep'},
            { data: 'desc_dep', name: 'desc_dep'}
            ],
            "bDestroy": true,
            "initComplete": function(settings, json) {
             $('div.dataTables_filter input').focus();
             $('#lookupDept tbody').on( 'dblclick', 'tr', function () {
              var dataArr = [];
              var rows = $(this);
              var rowData = lookupDept.rows(rows).data();
              $.each($(rowData),function(key,value){
               var id = e.target.id.replace('kd_dept', '');
               document.getElementById(e.target.id).value = value["kd_dep"];
              $('#deptModal').modal('hide');               
               document.getElementById(id +'kd_dept').focus();              
              });
            });
             $('#deptModal').on('hidden.bs.modal', function () {
              var kd_dept = document.getElementById(e.target.id).value.trim();
              if(kd_dept === '') {
               document.getElementById(e.target.id).focus();
             } else {
               var id = e.target.id.replace('kd_dept', '');
               document.getElementById(id +'kd_dept').focus();
             }
           });
           },
         });
      }
  }

  function validateDept(e){
      var kd_plant = document.getElementById("kd_plant").value.trim();
          var id = e.target.id.replace('kd_dept', '');    
          var kd_dept = document.getElementById(e.target.id).value.trim();
          if(kd_dept === '') {
           document.getElementById(e.target.id).value = "";
          } else {
             var url = '{{ route('datatables.validasiDepLhp', ['param', 'param2']) }}';
             url = url.replace('param', window.btoa(kd_plant));
             url = url.replace('param2', window.btoa(kd_dept));
             $.get(url, function(result){  
              if(result !== 'null'){
               result = JSON.parse(result);  
                } else {
                 document.getElementById(e.target.id).value = "";
                 document.getElementById(e.target.id).focus();
                 swal("Dept tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
               }
             });
          }      
  }

  function popupMain(e) {
      if(e.keyCode == 120 || e.keyCode == 13) {       
          var myHeading = "<p>Popup Main</p>";
          $("#mainModalLabel").html(myHeading);
          var url = '{{ route('datatables.popupMainLhp') }}';
          $('#mainModal').modal('show');
          var lookupMain = $('#lookupMain').DataTable({
            processing: true, 
            "oLanguage": {
              'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
            }, 
            serverSide: true,
            pagingType: "simple",
            "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
            ajax: url,
            columns: [
            { data: 'kd_ls', name: 'kd_ls'},
            { data: 'nm_ls', name: 'nm_ls'}
            ],
            "bDestroy": true,
            "initComplete": function(settings, json) {
             $('div.dataTables_filter input').focus();
             $('#lookupMain tbody').on( 'dblclick', 'tr', function () {
              var dataArr = [];
              var rows = $(this);
              var rowData = lookupMain.rows(rows).data();
              $.each($(rowData),function(key,value){
               var id = e.target.id.replace('kd_ls', '');
               document.getElementById(e.target.id).value = value["kd_ls"];
               document.getElementById(id +'nm_ls').value = value["nm_ls"];
              $('#mainModal').modal('hide');               
               document.getElementById(id +'kd_ls').focus();              
              });
            });
             $('#mainModal').on('hidden.bs.modal', function () {
              var kd_ls = document.getElementById(e.target.id).value.trim();
              if(kd_ls === '') {
               document.getElementById(e.target.id).focus();
             } else {
               var id = e.target.id.replace('kd_ls', '');
               document.getElementById(id +'kd_ls').focus();
             }
           });
           },
         });
      }
  }

  function validateMain(e){
      var id = e.target.id.replace('kd_ls', '');    
      var kd_ls = document.getElementById(e.target.id).value.trim();
      if(kd_ls === '') {
       document.getElementById(e.target.id).value = "";
       document.getElementById(id +'nm_ls').value = "";
      } else {
         var url = '{{ route('datatables.validasiMainLhp', ['param']) }}';
         url = url.replace('param', window.btoa(kd_ls));
         $.get(url, function(result){  
          if(result !== 'null'){
            result = JSON.parse(result);  
            document.getElementById(id +'nm_ls').value = result["nm_ls"];
            } else {
             document.getElementById(e.target.id).value = "";
             document.getElementById(id +'nm_ls').value = "";
             document.getElementById(e.target.id).focus();
             swal("Main tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
           }
         });
      }      
  }

  function popupKat(e) {
      if(e.keyCode == 120 || e.keyCode == 13) {
      var id = e.target.id.replace('ls_cat', ''); 
      var kd_ls = document.getElementById(id +'kd_ls').value.trim();
      if(kd_ls === ''){
        swal("Main tidak boleh kosong!", "Perhatikan inputan anda!", "warning").then(function () {
              document.getElementById(id +'kd_ls').focus();
           });
      } else {
        var myHeading = "<p>Popup Kategori</p>";
        $("#katModalLabel").html(myHeading);
        var url = '{{ route('datatables.popupKatLhp', ['param']) }}';
        url = url.replace('param', window.btoa(kd_ls));
        $('#katModal').modal('show');
        var lookupKat = $('#lookupKat').DataTable({
        processing: true, 
        "oLanguage": {
          'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
        }, 
        serverSide: true,
        pagingType: "simple",
        "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
        ajax: url,
        columns: [
        { data: 'ls_cat', name: 'ls_cat'},
        { data: 'deskripsi', name: 'deskripsi'}
        ],
        "bDestroy": true,
        "initComplete": function(settings, json) {
         $('div.dataTables_filter input').focus();
         $('#lookupKat tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupKat.rows(rows).data();
          $.each($(rowData),function(key,value){
           var id = e.target.id.replace('ls_cat', '');
           document.getElementById(e.target.id).value = value["ls_cat"];
           document.getElementById(id +'nm_cat').value = value["deskripsi"];
          $('#katModal').modal('hide');               
           document.getElementById(id +'ls_cat').focus();              
          });
        });
         $('#katModal').on('hidden.bs.modal', function () {
          var ls_cat = document.getElementById(e.target.id).value.trim();
          if(ls_cat === '') {
           document.getElementById(e.target.id).focus();
         } else {
           var id = e.target.id.replace('ls_cat', '');
           document.getElementById(id +'ls_cat').focus();
         }
         });
         },
       });
     }
      }
  }

  function validateKat(e){
      var id = e.target.id.replace('ls_cat', ''); 
      var kd_ls = document.getElementById(id +'kd_ls').value.trim();
      if(kd_ls === ''){
        swal("Main tidak boleh kosong!", "Perhatikan inputan anda!", "warning").then(function () {
              document.getElementById(id +'kd_ls').focus();
           });
      } else {
        var ls_cat = document.getElementById(e.target.id).value.trim();   
        if(ls_cat === '') {
         document.getElementById(e.target.id).value = "";
         document.getElementById(id +'nm_cat').value = "";
        } else {
           var url = '{{ route('datatables.validasiKatLhp', ['param', 'param2']) }}';
           url = url.replace('param', window.btoa(kd_ls));
           url = url.replace('param2', window.btoa(ls_cat));
           $.get(url, function(result){  
            if(result !== 'null'){
              result = JSON.parse(result);  
              document.getElementById(id +'nm_cat').value = result["deskripsi"];
              } else {
               document.getElementById(e.target.id).value = "";
               document.getElementById(id +'nm_cat').value = "";
               document.getElementById(e.target.id).focus();
               swal("Kat tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
             }
           });
        } 
      }     
  }

  function getMenitAwalLs(e){
          var no_doc = '-';
          var id = e.target.id.replace('ls_mulai', '');
          var ls_mulai = document.getElementById(e.target.id).value.trim();
          var ls_selesai = document.getElementById(id+'ls_selesai').value.trim();
          if(ls_mulai === '' || ls_selesai === '') {
           document.getElementById(id +'ls_menit').value = "";
          } else {
             var url = '{{ route('prodlhp.getMenitLhp', ['param', 'param1', 'param2']) }}';
             url = url.replace('param', window.btoa(no_doc));
             url = url.replace('param1', window.btoa(ls_mulai));
             url = url.replace('param2', window.btoa(ls_selesai));
             
             $.get(url, function(result){  
              if(result !== 'null'){
               result = JSON.parse(result);
               document.getElementById(id +'ls_menit').value = result["menit"];               
              } else {
                 document.getElementById(e.target.id).value = "";
                 document.getElementById(id +'ls_menit').value = "";
                 document.getElementById(e.target.id).focus();
               }
             });
          }       
  }

  function getMenitLs(e){
          var no_doc = '-';
          var id = e.target.id.replace('ls_selesai', '');
          var ls_selesai = document.getElementById(e.target.id).value.trim();
          var ls_mulai = document.getElementById(id+'ls_mulai').value.trim();
          if(ls_mulai === '' || ls_selesai === '') {
           document.getElementById(id +'ls_menit').value = "";
          } else {
             var url = '{{ route('prodlhp.getMenitLhp', ['param', 'param1', 'param2']) }}';
             url = url.replace('param', window.btoa(no_doc));
             url = url.replace('param1', window.btoa(ls_mulai));
             url = url.replace('param2', window.btoa(ls_selesai));
             $.get(url, function(result){  
              if(result !== 'null'){
               result = JSON.parse(result);
               document.getElementById(id +'ls_menit').value = result["menit"];
               } else {
                 document.getElementById(e.target.id).value = "";
                 document.getElementById(id +'ls_menit').value = "";
                 document.getElementById(e.target.id).focus();
               }
             });
          }       
  }

  function getJmlLs(){
    var no_doc = document.getElementById('no_doc').value.trim();
    if(no_doc !== '') {
       var url = '{{ route('prodlhp.getJmlLs', ['param']) }}';
       url = url.replace('param', window.btoa(no_doc));
       $.get(url, function(result){  
        if(result !== 'null'){
         result = JSON.parse(result);
         var m_jml_ls_rep = Math.abs(result["jml_ls_rep"]);
         var m_jml_ls_prod = Math.abs(result["jml_ls_prod"]);
         document.getElementById('jml_ls_rep').value = m_jml_ls_rep;
         document.getElementById('jml_ls_prod').value = m_jml_ls_prod;
         var jml_ls_rep = document.getElementById('jml_ls_rep').value.trim();
         var jml_ls_prod = document.getElementById('jml_ls_prod').value.trim();

           if(jml_ls_prod != jml_ls_rep){
            swal("Warning!", "Jumlah LS Produksi Tidak Sama Dengan Jumlah LS Report", "warning");
           }
         } else {
           document.getElementById('jml_ls_rep').value = "";
           document.getElementById('jml_ls_prod').value = "";
         }
       });
    }       
  }

</script>
@endsection