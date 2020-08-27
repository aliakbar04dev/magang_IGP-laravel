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
          {!! Form::text('mesin', null, ['class'=>'form-control','placeholder' => 'Pilih Mesin', 'id' => 'mesin', 'required', 'readonly' => 'readonly']) !!}
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
            {!! Form::text('partno', null, ['class'=>'form-control','placeholder' => 'Part NO', 'required', 'id' => 'partno', 'readonly' => 'readonly']) !!}
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
          {!! Form::text('tanggal', null, ['class'=>'form-control','placeholder' => 'Tanggal', 'id' => 'tanggal', 'readonly' => 'readonly']) !!}
          {!! $errors->first('tanggal', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-4">
      </div>
      <div class="col-md-2">
        <div class="form-group">
          {!! Form::label('shift', 'Shift (*)') !!}
          {!! Form::text('shift', null, ['class'=>'form-control','placeholder' => 'Pilih Shift', 'id' => 'shift', 'required', 'readonly' => 'readonly']) !!}
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
          {!! Form::number('coil_rh', null, ['class'=>'form-control','placeholder' => 'Coil RH', 'id' => 'coil_rh', 'required', 'readonly' => 'readonly']) !!}
          {!! $errors->first('coil_rh', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-4">
      </div>
      <div class="col-md-2">
        <div class="form-group {{ $errors->has('coil_lh') ? ' has-error' : '' }}">
          {!! Form::label('coil_lh', 'Coil LH (*)') !!}
          {!! Form::number('coil_lh', null, ['class'=>'form-control','placeholder' => 'Coil LH', 'id' => 'coil_lh', 'required', 'readonly' => 'readonly']) !!}
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
          {!! Form::text('qty', null, ['class'=>'form-control','placeholder' => 'Pilih qty', 'id' => 'qty', 'required', 'readonly' => 'readonly']) !!}
          {!! $errors->first('qty', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-4">
      </div>
      <div class="col-md-2">
        <div class="form-group">
          {!! Form::label('posisi', 'Posisi (*)') !!}
          {!! Form::text('posisi', null, ['class'=>'form-control','placeholder' => 'Pilih Posisi', 'id' => 'posisi', 'required', 'readonly' => 'readonly']) !!}
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
          {!! Form::number('qw_pressure_act', null, ['class'=>'form-control', 'id' => 'qw_pressure_act', 'required', 'readonly' => 'readonly']) !!}
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
          {!! Form::number('cw_pressure_act', null, ['class'=>'form-control', 'id' => 'cw_pressure_act', 'required', 'readonly' => 'readonly']) !!}
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
          {!! Form::number('coil_gap', null, ['class'=>'form-control', 'id' => 'coil_gap', 'required', 'readonly' => 'readonly']) !!}
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
      <div class="col-md-2">
      </div>
      <div class="col-md-2">
        Judge
      </div>
      <div class="col-md-1">
        <div class="form-group {{ $errors->has('judge') ? ' has-error' : '' }}">
          {!! Form::text('judge', null, ['class'=>'form-control', 'id' => 'judge', 'required', 'readonly' => 'readonly']) !!}
          {!! $errors->first('judge', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-3">
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
          {!! Form::number('qfl_std', null, ['class'=>'form-control', 'id' => 'qfl_std', 'required', 'readonly' => 'readonly']) !!}
          {!! $errors->first('qfl_std', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group {{ $errors->has('qfl_act') ? ' has-error' : '' }}">
          {!! Form::number('qfl_act', null, ['class'=>'form-control', 'id' => 'qfl_act', 'required', 'readonly' => 'readonly']) !!}
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
          {!! Form::number('consentration_act', null, ['class'=>'form-control', 'id' => 'consentration_act', 'required', 'readonly' => 'readonly']) !!}
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
    <div class="col-md-2"> 
      <button id="btnUpdateData" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Follow Up Data">Follow Up Data</button>
    </div>
    <div class="col-md-1"> 
      <a class="btn btn-default" href="{{ route('mtcparamhardenfollow.index') }}">Cancel</a>
    </div>
    <div class="col-md-3"> 
    </div>
    <div class="col-md-6">
      <p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
    </div>
  </div>
</div>

@section('scripts')
<script type="text/javascript">
  document.getElementById("no_doc").focus();

  //Initialize Select2 Elements
  $(".select2").select2();


  $(document).ready(function(){

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

    }

  });

  $("#btnUpdateData").click(function(){
    var no_doc = $("#no_doc").val();
    swal({
      title: 'Are you sure to follow ?' + no_doc,
      text: '',
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, Follow Up',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: false,
    }).then(function () {
      var urlRedirect = "{{ route('mtcparamhardenfollow.UpdateFollow', 'param1') }}";
      urlRedirect = urlRedirect.replace('param1', window.btoa(no_doc));
      window.location.href = urlRedirect;
    }, function (dismiss) {

    });
  });

</script>
@endsection
