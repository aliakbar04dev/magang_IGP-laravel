<div class="modal fade" id="isModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="isModalLabel" aria-hidden="true">
  {{-- <div class="modal-dialog" style="width:800px"> --}}
  <div class="modal-dialog" style="width:80%">
    <div class="modal-content">
      {!! Form::open(['url' => route('mtctpmss.store'), 'method' => 'post', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_is']) !!}
        {!! Form::hidden('no_pms', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'no_pms']) !!}
        {!! Form::hidden('kd_plant', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'kd_plant']) !!}
        {!! Form::hidden('kd_line', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'kd_line']) !!}
        {!! Form::hidden('kd_mesin', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'kd_mesin']) !!}
        {!! Form::hidden('nm_ic', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'nm_ic']) !!}
        {!! Form::hidden('jml_row', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="isModalLabel">Popup</h4> <b><font color="red">Klik 2x untuk memilih</font></b>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="box box-primary collapsed-box">
              <div class="box-header with-border">
                <h3 class="box-title" id="boxtitle">Foto</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <center>
                  <img src="" class="img-rounded img-responsive" alt="File Not Found" id="lok_pict">
                </center>
                <p class="text-muted text-center"></p>
              </div>
              <!-- ./box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="modal-body">
          <table id="tblDetail" class="table table-bordered table-striped" cellspacing="0" width="115%">
            <thead>
              <tr>
                <th>Item Check</th>
                <th>Ketentuan</th>
                <th>Metode</th>
                <th>Alat</th>
                <th>Waktu (M)</th>
                <th style="width: 5%;">Status</th>
                <th>Uraian Masalah</th>
                <th>Picture (jpeg,png,jpg)</th>
              </tr>
            </thead>
          </table>
        </div>
        <div class="box-footer">
          {!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-simpan']) !!}
          &nbsp;&nbsp;
          <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
          &nbsp;&nbsp;
          <p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
        </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>