@if(isset($datpendidikan))
    {!! Form::model($datpendidikan,['method'=>'put','id'=>'frm']) !!}
@else
    {!! Form::open(['id'=>'frm']) !!}
@endif
<div class="modal-header">
    <h4 class="modal-title">{{isset($datpendidikan)?'Edit':'Create'}} Data Pendidikan</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="form-group row required">
        {!! Form::label("jenjang","Jenjang",["class"=>"col-form-label col-md-3"]) !!}
        <div class="col-md-9">
             {!! Form::select("jenjang",['SD'=>'SD','SMP'=>'SMP','SMA'=>'SMA','SMK'=>'SMK','D1'=>'D1','D2'=>'D2','D3'=>'D3','S1'=>'S1','S2'=>'S2','S3'=>'S3'],null,['class'=>'form-control'], ['id' => 'jenjang']) !!}
            <span id="error-jenjang" class="invalid-feedback"></span>
        </div>
    </div>
    <div class="form-group row">
        {!! Form::label("nama_sekolah","Nama Sekolah/Universitas",["class"=>"col-form-label col-md-3"]) !!}
        <div class="col-md-9">
        {!! Form::text("nama_sekolah", null , ["class"=>"form-control"], ["name"=>"nama_sekolah"], ["id"=>"nama_sekolah"], ["placeholder"=>"Nama Sah/Institusi anda"]) !!}
           <span id="error-nama_sekolah" class="invalid-feedback"></span>          
        </div>
    </div>
    <div class="form-group row">
        {!! Form::label("jurusan","Jurusan/Konsentrasi",["class"=>"col-form-label col-md-3"]) !!}
        <div class="col-md-9">
            {!! Form::text("jurusan",null,["class"=>"form-control","placeholder"=>"Jurusan/Konsentrasi Anda","id"=>"jurusan"]) !!}
             <span id="error-jurusan" class="invalid-feedback"></span> 
        </div>
    </div>
    <div class="form-group row required">
        {!! Form::label("tempat","Tempat",["class"=>"col-form-label col-md-3"]) !!}
        <div class="col-md-9">
            {!! Form::text("tempat",null,["class"=>"form-control","placeholder"=>"Kota institusi/sekolah anda berada", "id"=>"tempat"]) !!}
            <span id="error-tempat" class="invalid-feedback"></span>
        </div>
    </div>
    <div class="form-group row required">
        {!! Form::label("tahun_masuk","Tahun Masuk",["class"=>"col-form-label col-md-3"]) !!}
        <div class="col-md-9">
            {!! Form::text("tahun_masuk",null,["class"=>"form-control","placeholder"=>"Hanya Tahun, e.g : 2009"]) !!}
            <span id="error-tahun_masuk" class="invalid-feedback"></span>
        </div>
    </div>
    <div class="form-group row required">
        {!! Form::label("tahun_lulus","Tahun Lulus",["class"=>"col-form-label col-md-3"]) !!}
        <div class="col-md-9">
            {!! Form::text("tahun_lulus",null,["class"=>"form-control","placeholder"=>"Hanya Tahun, e.g : 2014"]) !!}
            <span id="error-tahun_lulus" class="invalid-feedback"></span>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal"> Close</button>
    {!! Form::submit("Save",["class"=>"btn btn-primary"])!!}
</div>


{!! Form::close() !!}

@section('scripts')
    <script src="{{asset('js/ajax-crud-modal-form.js')}}"></script>
<script src="https://use.fontawesome.com/2c7a93b259.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
@endsection