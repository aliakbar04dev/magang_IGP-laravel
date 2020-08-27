{{-- {!! Form::open(['url'=>'/admin/aprovalDeptTolak', 'class'=>'form-horizontal', 'onsubmit'=>"return confirm('Anda Yakin Ingin Menolak  $pistandard->no_pis ?');", 'style' =>'display:inline;']) !!}
<input type="hidden" name="no_pis" value="{{ $pistandard->no_pis }}">
<button type="submit" title="Unclock for editing" class="btn btn-succes btn-sm"><i class="glyphicon glyphicon-edit"></i></button> --}}

{!! Form::open(['url'=>'/admin/aprovalstafTolak', 'class'=>'form-horizontal']) !!}
<input type="hidden" name="no_pis" value="{{ $pistandard->no_pis }}">
<button type="submit" data-toggle="tooltip" data-placement="top" title="Unclock for editing" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-edit"></i></button>
{!! Form::close() !!}
