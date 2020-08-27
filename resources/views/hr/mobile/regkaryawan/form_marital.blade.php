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
        {!! Form::label("status","Status",["class"=>"col-form-label col-md-3"]) !!}
        <div class="col-md-9">
             {!! Form::select("status_klg",['I'=>'Istri','A'=>'Anak','S'=>'Suami'],null,['class'=>'form-control'], ['id' => 'status_klg', 'name' => 'status_klg' ]) !!}
            <span id="error-status_klg" class="invalid-feedback"></span>
        </div>
    </div>
    <div id='data-marriage' style="display: none;">
        <div class="form-group">
          {!! Form::label("marriage","Tanggal Nikah") !!}    
            <div class="col-md-9">                     
             {!! Form::date("marriage",null,["class"=>"form-control","placeholder"=>"Tanggal Nikah", "id"=>"marriage"]) !!}
            </div>
          <span id="error-marriage" class="invalid-feedback"></span>
      
        </div>  
     </div>   
    <div class="form-group row required">
        {!! Form::label("nama","Nama",["class"=>"col-form-label col-md-3"]) !!}
        <div class="col-md-9">
        {!! Form::text("nama", null , ["class"=>"form-control"], ["name"=>"nama"], ["id"=>"nama"], ["placeholder"=>"Nama Lengkap"]) !!}
           <span id="error-nama" class="invalid-feedback"></span>          
        </div>
    </div>
    <div class="form-group row required">
        {!! Form::label("tempat","Tempat Lahir",["class"=>"col-form-label col-md-3"]) !!}
        <div class="col-md-9">
            {!! Form::text("tempat",null,["class"=>"form-control","placeholder"=>"Tempat Lahir","id"=>"tempat"])!!}
             <span id="error-tempat" class="invalid-feedback"></span> 
        </div>
    </div>
    <div class="form-group row required">
        {!! Form::label("tanggal_lahir","Tanggal Lahir",["class"=>"col-form-label col-md-3"]) !!}
        <div class="col-md-9">
            {!! Form::date("tgl_lahir",null,["class"=>"form-control","placeholder"=>"Tanggal Lahir", "id"=>"tgl_lahir"]) !!}
            <span id="error-tgl_lahir" class="invalid-feedback"></span>
        </div>
    </div>
     <div class="form-group row required">
        {!! Form::label("kelamin"," Jenis Kelamin",["class"=>"col-form-label col-md-3"]) !!}
        <div class="col-md-9">
             {!! Form::select("kelamin",['L'=>'Laki-laki','P'=>'Perempuan'],null,['class'=>'form-control'], ['id' => 'kelamin']) !!}
            <span id="error-kelamin" class="invalid-feedback"></span>
        </div>
    </div>
    <div class="form-group row required">
        {!! Form::label("pendidikan","Pendidikan",["class"=>"col-form-label col-md-3"]) !!}
        <div class="col-md-9">
             {!! Form::select("pendidikan",['K01'=>'PLAYGROUP','L01'=>'TK', 'A01'=>'SD','B01'=>'SMP','B01'=>'SLTA','C04'=>'SMA','C17'=>'SMK','D04'=>'D1','E04'=>'D2','F08'=>'D3','G06'=>'S1','H01'=>'S2'],null,['class'=>'form-control'], ['id' => 'pendidikan']) !!}
            <span id="error-pendidikan" class="invalid-feedback"></span>
        </div>
    </div>
    <div class="form-group row required">
        {!! Form::label("pekerjaan","Pekerjaan",["class"=>"col-form-label col-md-3"]) !!}
        <div class="col-md-9">
            {!! Form::text("pekerjaan",null,["class"=>"form-control","placeholder"=>"Contoh : Pelajar"]) !!}
            <span id="error-pekerjaan" class="invalid-feedback"></span>
        </div>
    </div>
     <!-- <div class="form-group row required">
        {!! Form::label("marital","Marital",["class"=>"col-form-label col-md-3"]) !!}
        <div class="col-md-9">
            {!! Form::text("marital",null,["class"=>"form-control","placeholder"=>"Hanya Tahun, e.g : 2014"]) !!}
            <span id="error-marital" class="invalid-feedback"></span>
        </div>
    </div> -->
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