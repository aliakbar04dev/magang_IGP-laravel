
{!! Form::open(['url'=>'/admin/aprovalstafTolak', 'class'=>'form-horizontal', 'onsubmit'=>"return confirm('Anda Yakin Ingin Menolak  $pistandard->no_pis ?');", 'style' =>'display:inline;']) !!}
<input type="hidden" name="no_pis" value="{{ $pistandard->no_pis }}">
<button type="submit" title="Click untuk reject" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i></button>
{!! Form::close() !!}  

{{-- <button type='submit' class="btn btn-info btn-sm" id="detail_{{ $pistandard->no_pis }}" data-toggle="modal" data-target="#modalDetail_{{ $pistandard->no_pis }}">Detail</button> --}}

{!! Form::open(['url'=>'/admin/aprovalstafSetujui' , 'class'=>'form-horizontal', 'onsubmit'=>"return confirm('Anda Yakin Ingin Menyetujui $pistandard->no_pis ?');", 'style' =>'display:inline;']) !!}
<input type="hidden" name="no_pis" value="{{ $pistandard->no_pis }}">
<button type="submit"  title="Click untuk menyetujui" class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>
{!! Form::close() !!}

