<div class="modal fade" id="fcm3Modal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="fcm3ModalLabel" aria-hidden="true">
  {{-- <div class="modal-dialog" style="width:800px"> --}}
  <div class="modal-dialog" style="width:80%">
    <div class="modal-content">
      {{-- {!! Form::open(['url' => route('engtfcm1s.store'), 'method' => 'post', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_fcm3']) !!} --}}
      {!! Form::hidden('engt_fcm2_id', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'engt_fcm2_id']) !!}
      {!! Form::hidden('jml_row_fcm3', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_fcm3']) !!}
      {!! Form::hidden('jml_st_pros', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_st_pros']) !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="fcm3ModalLabel">Popup</h4> <b><font color="red">Klik 2x untuk memilih</font></b>
      </div>
      <div class="modal-body">
        <table id="tblDetail" class="table table-bordered table-striped" cellspacing="0" width="105%">
          <thead>
            <tr>
              <th rowspan="2" style="width: 25%;">Tolerance</th>
              <th rowspan="2" style="width: 25%;">Dimension/Note Status</th>
              <th colspan="{{ $engttpfc2s->get()->count() }}" style="text-align:center;">Process No</th>
              <th rowspan="2" style="text-align:center;">Delete</th>
            </tr>
            <tr>
              @foreach ($engttpfc2s->orderBy("no_op")->get() as $engttpfc2)
                <th style="text-align:center;width: 2%;">{{ $engttpfc2->no_op }}</th>
              @endforeach
            </tr>
          </thead>
        </table>
      </div>
      <div class="box-footer">
        {!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-simpan-fcm3']) !!}
        &nbsp;&nbsp;
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
        &nbsp;&nbsp;
        <p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
      </div>
      {{-- {!! Form::close() !!} --}}
    </div>
  </div>
</div>