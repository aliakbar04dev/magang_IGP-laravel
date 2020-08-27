@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Pengajuan 
            <small>   Work Order </small></h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><i class="fa fa-files-o"></i> Work Order</li>
            <li class="active"><i class="fa fa-files-o"></i> Pengajuan Work Order</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        @include('layouts._flash')
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title text-center">Add Pengajuan WORK ORDER</h3>
                    </div>
                    <div class="box-body">
                        <div>
                            <br>
                            <div>
                                @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                                @endif
                                @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            <div class="col-md-12 col-md-offset ">
            {!! Form::open(['id'=>'formwonih','url' => route('store.pengajuan'),'method' => 'post', 'class'=>'form-horizontal']) !!}
            {{ csrf_field() }}
            {{--  <div class="form-group">
                <h2 class="text-center">Form WORK ORDER</h2>
            </div>  --}}
            <div class="alert alert-info text-center">
                <b>Perhatian !</b>
                <br>
                Segera info atasan anda untuk menyetujui WO ini.
                <br>
                WO yang belum disetujui atasan TIDAK AKAN DI PROSES.
                <br>
                Selalu cek menu <a href="{{ route('view.daftar') }}">Daftar WO</a> untuk mengetahui tahapan approval.
            </div>
                <div class="form-group">
                    <label for="permintaan" class="col-lg-3 control-label">Permintaan (**)</label>
                    <div class="col-lg-6">
                        <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-list-alt"></i></span>
                        <select class="form-control select2" name="kodewo" id="pilihan">
                            <option value="WO_01"> Beli Hardware/Software            </option>
                            <option value="WO_02"> Service Komputer/Printer/Lainnya  </option>
                            <option value="WO_03"> Ganti Komputer/Printer/Lainnya    </option>
                            <option value="WO_04"> Buat/Modifikasi Aplikasi          </option>
                            <option value="WO_05"> Buat User Akses Jaringan Komputer </option>
                            <option value="WO_06"> Buat User Akses Internet          </option>
                            <option value="WO_07"> Buat Akun Email                   </option>
                            <option value="WO_08"> Relayout Posisi Komputer          </option>
                            <option value="WO_09"> Download Data                     </option>
                            <option value="WO_10"> Koreksi Data                      </option>
                            <option value="WO_11"> Install Software                  </option>
                        </select>
                    </div>
                    </div>
                </div>
                <div class="form-group">    
                    <label for="penjelasan"
                        class="col-lg-3 control-label">Penjelasan (*)</label>
                    <div class="col-lg-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <textarea type="text" class="form-control" name="penjelasan" id="penjelasanSet"
                            placeholder="Penjelasan" required /></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">    
                    <label
                        class="col-lg-3 control-label">No Hp (*)</label>
                    <div class="col-lg-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-mobile-phone"></i></span>
                            <input name="hp" class="form-control" id="hpSet" placeholder="No Hp" required 
                            data-inputmask='"mask": "999999999999999"' data-mask />
                        </div>
                    </div>
                </div>
                <div class="form-group">    
                    <label
                        class="col-lg-3 control-label">Ext</label>
                    <div class="col-lg-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                            <input name="ext" class="form-control" id="extSet" placeholder="Ext"
                            data-inputmask='"mask": "999"' data-mask />
                        </div>
                    </div>
                </div>
                {{--  <div class="form-group">
                    <label class="col-lg-3 control-label">Nama Dept Head</label>
                    <div class="col-lg-6">
                        <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" value="{{ $npk_depthead }} - {{ $nama_depthead }}" readonly required>
                    </div>
                    </div>
                </div>  --}}
                <div class="form-group">
                    <label for="approve" class="col-lg-3 control-label">Nama Dept Head/Div Head</label>
                    <div class="col-lg-6">
                        <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <select id="npk_dep_head" name="npk_dep_head" class="form-control select2" style="width:100%;">
                                @if ($npk_atasan_div != '')
                                <option value="{{ $npk_atasan_div }}" selected>{{ $npk_atasan_div }} - {{ $inputatasan_div }}</option>
                                @endif
                                @if ($npk_atasan_dep != '')
                                <option value="{{ $npk_atasan_dep }}" selected>{{ $npk_atasan_dep }} - {{ $inputatasan_dep }}</option>
                                @endif
                          
                                </option>
                        </select>
                    </div>
                    </div>
                </div>
                <br>
                {!! Form::submit('Submit', ['class'=>'btn btn-primary center-block', 'id' => 'btn-save']) !!}
                <br>
            <p class="help-block text-center has-error">{!! Form::label('info', 'WO Di Approve Oleh Min DEPT.HEAD', ['style'=>'color:red']) !!}</p>
            <p class="help-block text-center has-error">{!! Form::label('info', '(*) Tidak Boleh Kosong.', ['style'=>'color:red']) !!}</p>
            <p class="help-block text-center has-error">{!! Form::label('info', '(**) Jika Tidak Tahu Pilihan Permintaan, Call 262 : Budi / Deni / Tri.', ['style'=>'color:red']) !!}</p>
            {!! Form::close() !!}  
            <br>
            
         
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection


@section('scripts')
<script>
    $(document).ready(function(){
        $('#formwonih').submit(function (e, params) {
            var localParams = params || {};
            if (!localParams.send) {
              e.preventDefault();
              var valid = 'T';
              if(valid === 'T') {
                //additional input validations can be done hear
                swal({
                  title: 'Yakin Ingin Mengirim Data WO Ini ?',
                  text: '',
                  type: 'question',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  cancelButtonText:  'Cancel !',
                  confirmButtonText: 'Ya !',
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
    });

    $(".Cari").select2({
        placeholder: "Select a state",
        allowClear: true
    });


    $(function () {
        $('[data-mask]').inputmask()
    });
</script>
@endsection
