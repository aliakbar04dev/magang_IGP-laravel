<div class="box-body" id="field-part">

  <div class="row">    
    <div class="col-md-12">  
      <!-- /.form-group -->
      <div class="col-md-4">
        <div class="form-group">
          {!! Form::label('no_doc', 'No Doc') !!}
          {!! Form::text('no_doc', null, ['class'=>'form-control', 'id' => 'no_doc', 'readonly' => 'readonly']) !!}
        </div>
      </div>
      <div class="col-md-2">
      </div>
      <!-- ./form-group -->
      <div class="col-md-4">         
        <div class="form-group {{ $errors->has('mesin') ? ' has-error' : '' }}"> 
          {!! Form::label('mesin', 'Mesin (*)') !!}
          {!! Form::select('mesin', ['12-9-1A' => '12-9-1A', '12-9-2A' => '12-9-2A', '12-9-3A' => '12-9-3A', '12-9D' => '12-9D', '12-9E' => '12-9E'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Mesin', 'id' => 'mesin', 'required']) !!}
          {!! $errors->first('mesin', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-2">
      </div>
    </div>
  </div>

  <div class="row">    
    <div class="col-md-12">  
      <div class="col-md-4">
        <div class="form-group {{ $errors->has('partno') ? ' has-error' : '' }}">
          {!! Form::label('partno', 'Part No (F9) (*)') !!}
          <div class="input-group">
            {!! Form::text('partno', null, ['class'=>'form-control','placeholder' => 'Part NO', 'onkeydown' => 'keyPressedPartNo(event)', 'onchange' => 'validatePartNo()', 'required', 'id' => 'partno']) !!}
            <span class="input-group-btn">
              <button id="btnpopuppartno" type="button" class="btn btn-info" data-toggle="modal" data-target="#modelPartno" >
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          </div>
          {!! $errors->first('partno', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-2">
      </div>
      <div class="col-md-4">
        <div class="form-group">
          {!! Form::label('kd_model', 'Model') !!}
          {!! Form::text('kd_model', null, ['class'=>'form-control', 'id' => 'kd_model', 'readonly' => 'readonly']) !!}
        </div>
      </div>
      <div class="col-md-2">
      </div>
    </div>
  </div>

  <div class="row">    
    <div class="col-md-12">  
      <div class="col-md-2">
        <div class="form-group {{ $errors->has('tanggal') ? ' has-error' : '' }}">
          {!! Form::label('tanggal', 'Tanggal') !!}
      @if (empty($qct_par_harden01->tanggal))
          {!! Form::date('tanggal', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tanggal', 'id' => 'tanggal']) !!}
      @else
        {!! Form::date('tanggal', \Carbon\Carbon::parse($qct_par_harden01->tanggal), ['class'=>'form-control','placeholder' => 'tanggal', 'required', 'id' => 'tanggal']) !!}
      @endif
          {!! $errors->first('tanggal', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-4">
      </div>
      <div class="col-md-2">
        <div class="form-group">
          {!! Form::label('shift', 'Shift (*)') !!}
          {!! Form::select('shift', ['1' => '1', '2' => '2', '3' => '3'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Shift', 'id' => 'shift', 'required']) !!}
          {!! $errors->first('shift', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-4">
      </div>
    </div>
  </div>

  <div class="row">    
    <div class="col-md-12">  
      <div class="col-md-2">
        <div class="form-group {{ $errors->has('coil_rh') ? ' has-error' : '' }}">
          {!! Form::label('coil_rh', 'Coil RH (*)') !!}
          {!! Form::number('coil_rh', null, ['class'=>'form-control','placeholder' => 'Coil RH', 'id' => 'coil_rh', 'required']) !!}
          {!! $errors->first('coil_rh', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-4">
      </div>
      <div class="col-md-2">
        <div class="form-group {{ $errors->has('coil_lh') ? ' has-error' : '' }}">
          {!! Form::label('coil_lh', 'Coil LH (*)') !!}
          {!! Form::number('coil_lh', null, ['class'=>'form-control','placeholder' => 'Coil LH', 'id' => 'coil_lh', 'required']) !!}
          {!! $errors->first('coil_lh', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-4">
      </div>
    </div>
  </div>

  <div class="row">    
    <div class="col-md-12">  
      <div class="col-md-2">
        <div class="form-group">
          {!! Form::label('qty', 'Qty (*)') !!}
          {!! Form::select('qty', ['1' => '1', '2' => '2'], null, ['class'=>'form-control select2','placeholder' => 'Pilih qty', 'id' => 'qty', 'required']) !!}
          {!! $errors->first('qty', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-4">
      </div>
      <div class="col-md-2">
        <div class="form-group">
          {!! Form::label('posisi', 'Posisi (*)') !!}
          {!! Form::select('posisi', ['RH' => 'RH', 'LH' => 'LH', 'RH LH' => 'RH & LH'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Posisi', 'id' => 'posisi', 'required']) !!}
          {!! $errors->first('posisi', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-4">
      </div>
    </div>
  </div>

  <div class="row">    
    <div class="col-md-12">  
      <div class="col-md-2">
        <b>PRESS & TEMP</b>
      </div>
      <div class="col-md-1">
        <b>STD</b>
      </div>
      <div class="col-md-1">
        <b>ACT</b>
      </div>
      <div class="col-md-2">
      </div>
      <div class="col-md-2">
        <b>PRESS & TEMP</b>
      </div>
      <div class="col-md-1">
        <b>STD</b>
      </div>
      <div class="col-md-3">
      </div>
    </div>
  </div>

  <div class="row">    
    <div class="col-md-12">  
      <div class="col-md-2">
        Q.W. Pressure (Kgf/cm2)
      </div>
      <div class="col-md-1">
        <div class="form-group {{ $errors->has('qw_pressure_std') ? ' has-error' : '' }}">
          {!! Form::number('qw_pressure_std', 5, ['class'=>'form-control', 'id' => 'qw_pressure_std', 'required', 'readonly' => 'readonly']) !!}
          {!! $errors->first('qw_pressure_std', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group {{ $errors->has('qw_pressure_act') ? ' has-error' : '' }}">
          {!! Form::number('qw_pressure_act', null, ['class'=>'form-control', 'id' => 'qw_pressure_act', 'required', 'step' => '0.001']) !!}
          {!! $errors->first('qw_pressure_act', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-2">
      </div>
      <div class="col-md-2">
        Home Position
      </div>
      <div class="col-md-1">
        <div class="form-group {{ $errors->has('home_pos') ? ' has-error' : '' }}">
          {!! Form::number('home_pos', null, ['class'=>'form-control', 'id' => 'home_pos', 'required', 'readonly' => 'readonly']) !!}
          {!! $errors->first('home_pos', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-3">
      </div>
    </div>
  </div>

  <div class="row">    
    <div class="col-md-12">  
      <div class="col-md-2">
        Q.W. Temp (&#8451;)
      </div>
      <div class="col-md-1">
        <div class="form-group {{ $errors->has('qw_temp_std') ? ' has-error' : '' }}">
          {!! Form::text('qw_temp_std', null, ['class'=>'form-control', 'id' => 'qw_temp_std', 'required', 'readonly' => 'readonly']) !!}
          {!! $errors->first('qw_temp_std', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group {{ $errors->has('qw_temp_act') ? ' has-error' : '' }}">
          {!! Form::number('qw_temp_act', null, ['class'=>'form-control', 'id' => 'qw_temp_act', 'required', 'readonly' => 'readonly']) !!}
          {!! $errors->first('qw_temp_act', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-2">
      </div>
      <div class="col-md-2">
        Start Position
      </div>
      <div class="col-md-1">
        <div class="form-group {{ $errors->has('start_pos') ? ' has-error' : '' }}">
          {!! Form::number('start_pos', null, ['class'=>'form-control', 'id' => 'start_pos', 'required', 'readonly' => 'readonly']) !!}
          {!! $errors->first('start_pos', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-3">
      </div>
    </div>
  </div>

  <div class="row">    
    <div class="col-md-12">  
      <div class="col-md-2">
        C.W. Pressure (Kgf/cm2)
      </div>
      <div class="col-md-1">
        <div class="form-group {{ $errors->has('cw_pressure_std') ? ' has-error' : '' }}">
          {!! Form::number('cw_pressure_std', 4, ['class'=>'form-control', 'id' => 'cw_pressure_std', 'required', 'readonly' => 'readonly']) !!}
          {!! $errors->first('cw_pressure_std', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group {{ $errors->has('cw_pressure_act') ? ' has-error' : '' }}">
          {!! Form::number('cw_pressure_act', null, ['class'=>'form-control', 'id' => 'cw_pressure_act', 'required']) !!}
          {!! $errors->first('cw_pressure_act', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-2">
      </div>
      <div class="col-md-2">
        Upper Limit
      </div>
      <div class="col-md-1">
        <div class="form-group {{ $errors->has('upper_lim') ? ' has-error' : '' }}">
          {!! Form::number('upper_lim', null, ['class'=>'form-control', 'id' => 'upper_lim', 'required', 'readonly' => 'readonly']) !!}
          {!! $errors->first('upper_lim', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-3">
      </div>
    </div>
  </div>

  <div class="row">    
    <div class="col-md-12">  
      <div class="col-md-2">
        C.W. Temp (&#8451;)
      </div>
      <div class="col-md-1">
        <div class="form-group {{ $errors->has('cw_temp_std') ? ' has-error' : '' }}">
          {!! Form::text('cw_temp_std', null, ['class'=>'form-control', 'id' => 'cw_temp_std', 'required', 'readonly' => 'readonly']) !!}
          {!! $errors->first('cw_temp_std', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group {{ $errors->has('cw_temp_act') ? ' has-error' : '' }}">
          {!! Form::number('cw_temp_act', null, ['class'=>'form-control', 'id' => 'cw_temp_act', 'required', 'readonly' => 'readonly']) !!}
          {!! $errors->first('cw_temp_act', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-2">
      </div>
      <div class="col-md-2">
        Lower Limit
      </div>
      <div class="col-md-1">
        <div class="form-group {{ $errors->has('lower_lim') ? ' has-error' : '' }}">
          {!! Form::number('lower_lim', null, ['class'=>'form-control', 'id' => 'lower_lim', 'required', 'readonly' => 'readonly']) !!}
          {!! $errors->first('lower_lim', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-3">
      </div>
    </div>
  </div>

  <div class="row">    
    <div class="col-md-12">  
      <div class="col-md-6">
      </div>
      <div class="col-md-2">
        Coil Gap
      </div>
      <div class="col-md-1">
        <div class="form-group {{ $errors->has('coil_gap') ? ' has-error' : '' }}">
          {!! Form::number('coil_gap', null, ['class'=>'form-control', 'id' => 'coil_gap', 'required', 'step' => '0.001']) !!}
          {!! $errors->first('coil_gap', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-3">
      </div>
    </div>
  </div>

  <div class="row">    
    <div class="col-md-12">  
      <div class="col-md-2">
        <b>Data</b>
      </div>
      <div class="col-md-1">
        <b>STD</b>
      </div>
      <div class="col-md-1">
        <b>ACT</b>
      </div>
      <div class="col-md-8">
      </div>
    </div>
  </div>

  <div class="row">    
    <div class="col-md-12">  
      <div class="col-md-2">
        Cycle Time
      </div>
      <div class="col-md-1">
        <div class="form-group {{ $errors->has('ct_std') ? ' has-error' : '' }}">
          {!! Form::number('ct_std', null, ['class'=>'form-control', 'id' => 'ct_std', 'required', 'readonly' => 'readonly']) !!}
          {!! $errors->first('ct_std', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group {{ $errors->has('ct_act') ? ' has-error' : '' }}">
          {!! Form::number('ct_act', null, ['class'=>'form-control', 'id' => 'ct_act', 'required', 'readonly' => 'readonly']) !!}
          {!! $errors->first('ct_act', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-8">
      </div>
    </div>
  </div>

  <div class="row">    
    <div class="col-md-12">  
      <div class="col-md-2">
        Quenching Flow +- 20 (I/min) R
      </div>
      <div class="col-md-1">
        <div class="form-group {{ $errors->has('qfr_std') ? ' has-error' : '' }}">
          {!! Form::number('qfr_std', null, ['class'=>'form-control', 'id' => 'qfr_std', 'required', 'readonly' => 'readonly']) !!}
          {!! $errors->first('qfr_std', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group {{ $errors->has('qfr_act') ? ' has-error' : '' }}">
          {!! Form::number('qfr_act', null, ['class'=>'form-control', 'id' => 'qfr_act', 'required', 'readonly' => 'readonly']) !!}
          {!! $errors->first('qfr_act', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-8">
      </div>
    </div>
  </div>

  <div class="row">    
    <div class="col-md-12">  
      <div class="col-md-2">
        Quenching Flow +- 20 (I/min) L
      </div>
      <div class="col-md-1">
        <div class="form-group {{ $errors->has('qfl_std') ? ' has-error' : '' }}">
          {!! Form::number('qfl_std', null, ['class'=>'form-control', 'id' => 'qfl_std', 'required']) !!}
          {!! $errors->first('qfl_std', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group {{ $errors->has('qfl_act') ? ' has-error' : '' }}">
          {!! Form::number('qfl_act', null, ['class'=>'form-control', 'id' => 'qfl_act', 'required']) !!}
          {!! $errors->first('qfl_act', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-8">
      </div>
    </div>
  </div>

  <div class="row">    
    <div class="col-md-12">  
      <div class="col-md-2">
        Concentration
      </div>
      <div class="col-md-1">
        <div class="form-group {{ $errors->has('consentration_std') ? ' has-error' : '' }}">
          {!! Form::text('consentration_std', '3 - 4', ['class'=>'form-control', 'id' => 'consentration_std', 'required', 'readonly' => 'readonly']) !!}
          {!! $errors->first('consentration_std', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group {{ $errors->has('consentration_act') ? ' has-error' : '' }}">
          {!! Form::number('consentration_act', null, ['class'=>'form-control', 'id' => 'consentration_act', 'required']) !!}
          {!! $errors->first('consentration_act', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-8">
      </div>
    </div>
  </div>

  <div class="row">    
    <div class="col-md-12">  
      <div class="col-md-8">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th rowspan="2">STEP</th>
              <th colspan="2">Timer (sec)</th>
              <th rowspan="2">POS (mm)</th>
              <th colspan="2">Speed (mm/s)</th>  
              <th colspan="2">Power (KW)</th>  
            </tr>
            <tr>
              <th>STD</th>
              <th>ACT</th>
              <th>STD</th>
              <th>ACT</th>
              <th>STD</th>
              <th>ACT</th>
            </tr>
          </thead>
          <tbody>
            @for ($i = 0; $i < 14; $i++)
                <tr>
                  <td>
                    {{ $i + 1  }}
                  </td>
                  <td>
                    <div class="form-group {{ $errors->has('timer_std_$i') ? ' has-error' : '' }}">
                      {!! Form::number('timer_std_'.$i, null, ['class'=>'form-control', 'id' => 'timer_std_'.$i, 'required', 'readonly' => 'readonly']) !!}
                      {!! $errors->first('timer_std_'.$i, '<p class="help-block">:message</p>') !!}
                    </div>
                  </td>
                  <td>
                    <div class="form-group {{ $errors->has('timer_act_$i') ? ' has-error' : '' }}">
                      {!! Form::number('timer_act_'.$i, null, ['class'=>'form-control', 'id' => 'timer_act_'.$i, 'required', 'readonly' => 'readonly']) !!}
                      {!! $errors->first('timer_act_'.$i, '<p class="help-block">:message</p>') !!}
                    </div>
                  </td>
                  <td>
                    <div class="form-group {{ $errors->has('pos_$i') ? ' has-error' : '' }}">
                      {!! Form::number('pos_'.$i, null, ['class'=>'form-control', 'id' => 'pos_'.$i, 'required', 'readonly' => 'readonly']) !!}
                      {!! $errors->first('pos_'.$i, '<p class="help-block">:message</p>') !!}
                    </div>
                  </td>
                  <td>
                    <div class="form-group {{ $errors->has('speed_std_$i') ? ' has-error' : '' }}">
                      {!! Form::number('speed_std_'.$i, null, ['class'=>'form-control', 'id' => 'speed_std_'.$i, 'required', 'readonly' => 'readonly']) !!}
                      {!! $errors->first('speed_std_'.$i, '<p class="help-block">:message</p>') !!}
                    </div>
                  </td>
                  <td>
                    <div class="form-group {{ $errors->has('speed_act_$i') ? ' has-error' : '' }}">
                      {!! Form::number('speed_act_'.$i, null, ['class'=>'form-control', 'id' => 'speed_act_'.$i, 'required', 'readonly' => 'readonly']) !!}
                      {!! $errors->first('speed_act_'.$i, '<p class="help-block">:message</p>') !!}
                    </div>
                  </td>
                  <td>
                    <div class="form-group {{ $errors->has('power_std_$i') ? ' has-error' : '' }}">
                      {!! Form::number('power_std_'.$i, null, ['class'=>'form-control', 'id' => 'power_std_'.$i, 'required', 'readonly' => 'readonly']) !!}
                      {!! $errors->first('power_std_'.$i, '<p class="help-block">:message</p>') !!}
                    </div>
                  </td>
                  <td>
                    <div class="form-group {{ $errors->has('power_act_$i') ? ' has-error' : '' }}">
                      {!! Form::number('power_act_'.$i, null, ['class'=>'form-control', 'id' => 'power_act_'.$i, 'required', 'readonly' => 'readonly']) !!}
                      {!! $errors->first('power_act_'.$i, '<p class="help-block">:message</p>') !!}
                    </div>
                  </td>
                </tr>
            @endfor
          </tbody>
        </table>
      </div>
      <div class="col-md-6">
          {!! Form::hidden('UpdatedData', null, ['class'=>'form-control', 'id' => 'UpdatedData', 'readonly' => 'readonly']) !!}
      </div>
    </div>
  </div>

</div>

<div class="box-footer">
  <div class="col-md-12">
    <div class="col-md-1"> 
      {!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
    </div>
    <div class="col-md-1"> 
      <a class="btn btn-default" href="{{ route('prodparamharden.index') }}">Cancel</a>
    </div>
    <div class="col-md-2"> 
      <button id="btn-delete" type="button" class="btn btn-danger" style="display: none">Hapus Data</button>
    </div>
    <div class="col-md-2"> 
      <button id="btnUpdateData" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Update Data">Update Data</button>
    </div>
    <div class="col-md-6">
      <p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
    </div>
  </div>
</div>

@include('prod.paramharden.popup.partModal')
@section('scripts')
<script type="text/javascript">
  document.getElementById("no_doc").focus();

  //Initialize Select2 Elements
  $(".select2").select2();


  $("#btn-delete").click(function(){
    var no_doc = document.getElementById("no_doc").value.trim();
    var msg = 'Anda yakin menghapus no doc : ' + no_doc + '?';
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
      var urlRedirect = "{{ route('prodparamharden.deletenodoc', 'param1') }}";
      urlRedirect = urlRedirect.replace('param1', window.btoa(no_doc));
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

  function keyPressedPartNo(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopuppartno').click();
    }
  }

  $(document).ready(function(){

    $("#btnpopuppartno").click(function(){
      popupKdPartNo();
    });

    if($("#partno").val() != ''){
      validatePartNo();
    }

    if($("#no_doc").val() != ''){
      @if(!empty($qct_par_harden02))
        var qct_par_harden02 = <?php echo json_encode($qct_par_harden02); ?>;
      @else
        var qct_par_harden02 = [];
      @endif

      for (i = 0; i < qct_par_harden02.length; i++){
          var seq = qct_par_harden02[i]["no_seq"];
          $("#timer_std_"+seq).val(qct_par_harden02[i]["timer_std"]);
          $("#timer_act_"+seq).val(qct_par_harden02[i]["timer_act"]);
          $("#pos_"+seq).val(qct_par_harden02[i]["pos"]);
          $("#speed_std_"+seq).val(qct_par_harden02[i]["speed_std"]);
          $("#speed_act_"+seq).val(qct_par_harden02[i]["speed_act"]);
          $("#power_std_"+seq).val(qct_par_harden02[i]["power_std"]);
          $("#power_act_"+seq).val(qct_par_harden02[i]["power_act"]);        
      }

      $('#btn-delete').css("display", "block");
    }

    if($("#home_pos").val() != ''){
      // document.getElementById('btnUpdateData').style.display = 'none';
      $('#btnUpdateData').css("display", "none");
      $('#btnUpdateData').attr("disabled", true);
    }

  });

  function popupKdPartNo() {
    var myHeading = "<p>Popup Part No</p>";
    $("#lineModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupEngtMpartsAll') }}';
    var lookupPartNo = $('#lookupPartNo').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      "order": [[0, 'asc']],
      columns: [
        { data: 'part_no', name: 'part_no'},
        { data: 'kd_model', name: 'kd_model'},
        { data: 'nm_part', name: 'nm_part'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupPartNo tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupPartNo.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("kd_model").value = value["kd_model"];
            document.getElementById("partno").value = value["part_no"];
            $('#modelPartno').modal('hide');
            validatePartNo();
          });
        });
      },
    });
  }

  function validatePartNo() { 
    var partno = document.getElementById("partno").value.trim();
    if(partno !== '') {
      var url = '{{ route('datatables.validasiEngtMpartFirst', 'param') }}';
      url = url.replace('param', window.btoa(partno));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("partno").value = result["part_no"];
          document.getElementById("kd_model").value = result["kd_model"];
        } else {
          document.getElementById("partno").value = "";
          document.getElementById("kd_model").value = "";
          document.getElementById("partno").focus();
          swal("Part No tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("partno").value = "";
    }
  }

  $("#btnUpdateData").click(function(){
    swal({
        title: 'Loading',
        text: 'Sedang memuat data...',
        showConfirmButton: false,
        animation: false 
    })
    $.ajax({
      url        :"{{ route('prodparamharden.getdatasqlserv') }}",
      type       :'GET',
      success    :function(result){
        var parseddata = JSON.parse(result);
        var master = parseddata.master;
        var detail = parseddata.detail;
        console.log(result);

        if(master != null) {
          $("#ct_act").val(master["ct_act"]);
          $("#ct_std").val(master["ct_std"]);
          $("#cw_temp_act").val(master["cw_temp_act"]);
          $("#cw_temp_std").val(master["cw_temp_std"]);
          $("#home_pos").val(master["home_pos"]);
          $("#lower_lim").val(master["lower_lim"]);
          $("#qfr_act").val(master["qfr_act"]);
          $("#qfr_std").val(master["qfr_std"]);
          $("#qw_temp_std").val(master["qw_temp_std"]);
          $("#qw_temp_act").val(master["qw_temp_act"]);
          $("#start_pos").val(master["start_pos"]);
          $("#upper_lim").val(master["upper_lim"]);

          for (i = 0 ; i < detail.length; i ++){
            $("#timer_std_"+i).val(detail[i]["timer_std"]);
            $("#timer_act_"+i).val(detail[i]["timer_act"]);
            $("#pos_"+i).val(detail[i]["pos"]);
            $("#speed_std_"+i).val(detail[i]["speed_std"]);
            $("#speed_act_"+i).val(detail[i]["speed_act"]);
            $("#power_std_"+i).val(detail[i]["power_std"]);
            $("#power_act_"+i).val(detail[i]["power_act"]);
          }

          $("#UpdatedData").val("yes");
          // document.getElementById('btnUpdateData').style.display = 'none';
          $('#btnUpdateData').css("display", "none");
          $('#btnUpdateData').attr("disabled", true);
        } else {
          alert("data tarikan tidak ada");
        }

        swal.close();
      },
      error: function(e) { 
        console.log(e);
      }
    });
  });


</script>
@endsection
