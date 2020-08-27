<style>
  .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
    border: 1px solid #000000;
  }
  img {
    width: 100%;
    height: auto;
  }
</style>
<div class="panel panel-default">
  <div class="panel-body" >
   <div class="box-header with-border" style="background-color: #FF6347">
    <h2 class="box-title" >CHECK PART INSPECTION STANDARD (PIS). NO.{{ $pistandards->no_pis }}</h2>
  </div>

  <div class="box-body" >
    <div class="col-md-12">
      
      <div class="box-body col-md-6">
        <div class="panel-heading" style="background-color:#F0F8FF">
          <h3 class="panel-title"><b>OUTPUT PIS. NO.{{ $pistandards->no_pis }}</b></h3>
        </div>
        {{-- ===================================OUTPUT============================================ --}}
        <!-- /.LOGO-->
        <div class="form-group"  id="">
          <div class="col-sm-12">
            <div class="col-sm-12 {{ $errors->has('creaby') ? ' has-error' : '' }}">
              {!! Form::label('no_pis', 'LOGO SUPPLIER') !!}
              <div class="input-group ">
               <table class="table table-bordered" style="width: 1000%;height:190px;">
                 <tr>
                   <td colspan="12" style="width: 1000px;">
                      <center>
                      
                       @if($pistandards->logo_supplier!="")
                       <img src="{{ $logo_supplier }}" alt="" class="img-rounded img-responsive" style="height: 155px;">
                       @else()
                       <img src="images/no_image.png" width="10px" border="0">
                       @endif
                      </center>
                   </td>
                 </tr>
               </table>
              {{--  <span class="input-group-btn">
                  @if($pistandards->c_nopis == '' || $pistandards->c_nopis == null)
                  <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                    <span ><i class="fa fa-check"></i></span>
                  </button>
                  @else
                  <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                    <span ><i class="fa fa-remove"></i></span>
                  </button>
                  @endif
               </span> --}}
              </div>
               {!! $errors->first('c_model', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
        </div>
        <!-- /.PIS NO-->
        <div class="form-group">
          <div class="col-sm-12">
            <div class="col-sm-12 {{ $errors->has('tgl_doc') ? ' has-error' : '' }}">
              {!! Form::label('no_pis', 'PIS NO') !!}
              {!! Form::text('no_pis',null, ['class'=>'form-control' , 'readonly' => 'readonly']) !!}
              {!! $errors->first('tgl_doc', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
        </div>
        <!-- /.Plant-->
        <div class="form-group">
          <div class="col-sm-12">
            <div class="col-sm-12 {{ $errors->has('no_doc') ? ' has-error' : '' }}">
              {!! Form::label('nama_supplier', 'SUPPLIER NAME') !!}
              {!! Form::text('nama_supplier', null, ['class'=>'form-control', 'min'=>1 , 'readonly' => 'readonly' ]) !!}
              {!! Form::hidden('email', null, ['class'=>'form-control', ]) !!}
              {!! Form::hidden ('kode_supp',null, ['class'=>'form-control', ]) !!}
              {!! $errors->first('nama_supplier', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
        </div>
        <!-- /.DATE OF ISSUED -->
        <div class="form-group">
          <div class="col-sm-12">
            <div class="col-sm-12 {{ $errors->has('no_doc') ? ' has-error' : '' }}">
              {!! Form::label('date_issue', 'DATE OF ISSUED') !!}
              {!! Form::text('date_issue', null, ['class'=>'form-control', 'min'=>1 , 'readonly' => 'readonly']) !!}
              {!! $errors->first('date_issue', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
        </div>
        <!-- /.MODEL -->
        <div class="form-group">
          <div class="col-sm-12">
            <div class="col-sm-12 {{ $errors->has('no_doc') ? ' has-error' : '' }}">
              {!! Form::label('model', 'MODEL') !!}
              {!! Form::text('model', null, ['class'=>'form-control', 'min'=>1 , 'readonly' => 'readonly' ]) !!}
              {!! $errors->first('model', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
        </div>
        <!-- /.REFF. NO-->
        <div class="form-group">
          <div class="col-sm-12">
            <div class="col-sm-12 {{ $errors->has('creaby') ? ' has-error' : '' }}">
              {!! Form::label('reff_no', 'REFF. NO') !!}
              {!! Form::text('reff_no',null, ['class'=>'form-control' , 'readonly' => 'readonly']) !!}
              {!! $errors->first('reff_no', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
        </div>
         <!-- /.MATERIAL-->
        <div class="form-group">
          <div class="col-sm-12">
              <div class="col-sm-12 {{ $errors->has('creaby') ? ' has-error' : '' }}">
                {!! Form::label('material', 'MATERIAL') !!}
                {!! Form::text('material',null, ['class'=>'form-control' , 'readonly' => 'readonly']) !!}
                {!! $errors->first('material', '<p class="help-block">:message</p>') !!}
              </div>
          </div>
        </div>
        <!-- /.GENERAL TOL-->
        <div class="form-group">
          <div class="col-sm-12">
            <div class="col-sm-12 {{ $errors->has('creaby') ? ' has-error' : '' }}">
              {!! Form::label('material', 'GENERAL TOL') !!}
              @if($pistandards->general_tol == '' || $pistandards->general_tol == '[""]' || $pistandards->general_tol == null )
               {!! Form::text('general_tol[]',null, ['class'=>'form-control',]) !!}
                @elseif($pistandards->general_tol !== '[""]' || $pistandards->general_tol !== '' || $pistandards->general_tol !== null )
                @foreach(json_decode($pistandards->general_tol) as $key => $value)
                  {!! Form::text('general_tol[]',$value, ['class'=>'form-control','readonly' => 'readonly']) !!}
                @endforeach
              @endif
              {!! $errors->first('material', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
        </div>
         <!-- /.WEIGHT-->
        <div class="form-group">
          <div class="col-sm-12">
            <div class="col-sm-12 {{ $errors->has('creaby') ? ' has-error' : '' }}">
              {!! Form::label('weight', 'WEIGHT') !!}
              {!! Form::text('weight',null, ['class'=>'form-control', 'readonly' => 'readonly']) !!}
              {!! $errors->first('material', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
        </div>
          <!-- /.PART NO-->
        <div class="form-group">
          <div class="col-sm-12">
            <div class="col-sm-12 {{ $errors->has('creaby') ? ' has-error' : '' }}">
              {!! Form::label('part_no', 'PART NO') !!}
              {!! Form::text('part_no',null, ['class'=>'form-control','readonly' => 'readonly']) !!}
              {!! $errors->first('part_no', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
        </div>
        <!-- /.PART NAME-->
        <div class="form-group">
          <div class="col-sm-12">
            <div class="col-sm-12 {{ $errors->has('creaby') ? ' has-error' : '' }}">
              {!! Form::label('part_name', 'PART NAME') !!}
              {!! Form::text('part_name',null, ['class'=>'form-control','readonly' => 'readonly']) !!}
              {!! $errors->first('part_name', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
        </div>
        <!-- /.Draft/Final-->
        <div class="form-group">
          <div class="col-sm-12">
            <div class="col-sm-12 {{ $errors->has('creaby') ? ' has-error' : '' }}">
              {!! Form::label('status_doc', 'Draft/Final') !!}
              {!! Form::text('status_doc', null, ['class'=>'form-control','readonly' => 'readonly']) !!}
              {!! $errors->first('status_doc', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
        </div>
        <!-- /.SUPPLIER DEPT-->
        <div class="form-group">
          <div class="col-sm-12">
            <div class="col-sm-12 {{ $errors->has('creaby') ? ' has-error' : '' }}">
              {!! Form::label('supp_dept', 'SUPPLIER DEPT') !!}
              {!! Form::text('supp_dept',null,['class'=>'form-control','readonly' => 'readonly']) !!}
              {!! $errors->first('supp_dept', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
        </div>
        
      </div>
      {{-- ===================================================================================================================================================== --}}
      <div class="box-body col-md-6">
          <div class="panel-heading" style="background-color:#F0F8FF">
           <h3 class="panel-title"><b>NOTES</b></h3>
          </div>
          <!-- /.LOGO-->
          <div class="form-group"  id="">
            <div class="col-sm-12">
              <div class="col-sm-12 {{ $errors->has('creaby') ? ' has-error' : '' }}">
                {!! Form::label('c_logosupplier', 'LOGO SUPPLIER') !!}
                <div class="input-group ">
                   {!! Form::textarea('c_logosupplier', null, ['class'=>'form-control', 'style' => 'width : 450px']) !!}
                  
                </div>
                {!! $errors->first('c_model', '<p class="help-block">:message</p>') !!}
              </div>
            </div>
          </div>
          <!-- /.PIS NO -->
          <div class="form-group"  id="">
            <div class="col-sm-12">
              <div class="col-sm-12 {{ $errors->has('creaby') ? ' has-error' : '' }}">
                {!! Form::label('c_nopis', 'PIS NO') !!}
                <div class="input-group ">
                  {!! Form::text('c_nopis', null, ['class'=>'form-control',]) !!}
                  <span class="input-group-btn">
                    @if($pistandards->no_pis == $pistandards->c_nopis)
                    <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                      <span ><i class="fa fa-check"></i></span>
                    </button>
                    @elseif($pistandards->c_nopis == null ||$pistandards->c_nopis == "")
                    <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                      <span ><i class="fa fa-check"></i></span>
                    </button>
                    @elseif($pistandards->c_nopis !== null && $pistandards->no_pis !== $pistandards->c_nopis)
                    <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                      <span ><i class="fa fa-remove"></i></span>
                    </button>
                    @endif
                  </span>

                </div>
                {!! $errors->first('c_model', '<p class="help-block">:message</p>') !!}
              </div>
            </div>
          </div>
          <!-- /.c_supname -->
          <div class="form-group"  id="">
            <div class="col-sm-12">
              <div class="col-sm-12 {{ $errors->has('creaby') ? ' has-error' : '' }}">
                {!! Form::label('c_supname', 'SUPPLIER NAME') !!}
                <div class="input-group ">
                  {!! Form::text('c_supname', null, ['class'=>'form-control',]) !!}
                   <span class="input-group-btn">
                    @if($pistandards->nama_supplier == $pistandards->c_supname)
                    <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                      <span ><i class="fa fa-check"></i></span>
                    </button>
                    @elseif($pistandards->c_supname == null || $pistandards->c_supname == "")
                    <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                      <span ><i class="fa fa-check"></i></span>
                    </button>
                    @elseif($pistandards->c_supname !== null && $pistandards->nama_supplier !== $pistandards->c_supname)
                    <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                      <span ><i class="fa fa-remove"></i></span>
                    </button>
                    @endif
                  </span>
                  
                </div>
                {!! $errors->first('c_model', '<p class="help-block">:message</p>') !!}
              </div>
            </div>
          </div>
          <!-- /.DATE OF ISSUED-->
          <div class="form-group"  id="">
            <div class="col-sm-12">
              <div class="col-sm-12 {{ $errors->has('creaby') ? ' has-error' : '' }}">
                {!! Form::label('c_dateissue', 'DATE OF ISSUED') !!}
                <div class="input-group ">
                  {!! Form::text('c_dateissue', null, ['class'=>'form-control',]) !!}
                   <span class="input-group-btn">
                    @if($pistandards->date_issue == $pistandards->c_dateissue)
                    <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                      <span ><i class="fa fa-check"></i></span>
                    </button>
                    @elseif($pistandards->c_dateissue == null || $pistandards->c_dateissue == "")
                    <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                      <span ><i class="fa fa-check"></i></span>
                    </button>
                    @elseif($pistandards->c_dateissue !== null && $pistandards->date_issue !== $pistandards->c_dateissue)
                    <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                      <span ><i class="fa fa-remove"></i></span>
                    </button>
                    @endif
                  </span>
                 
                </div>
                {!! $errors->first('c_model', '<p class="help-block">:message</p>') !!}
              </div>
            </div>
          </div>        
          <!-- /.c_model -->
          <div class="form-group"  id="">
            <div class="col-sm-12">
              <div class="col-sm-12 {{ $errors->has('creaby') ? ' has-error' : '' }}">
                {!! Form::label('c_model', 'MODEL') !!}
                <div class="input-group ">
                  {!! Form::text('c_model', null, ['class'=>'form-control', ]) !!}
                  <span class="input-group-btn">
                    @if($pistandards->model == $pistandards->c_model)
                    <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                      <span ><i class="fa fa-check"></i></span>
                    </button>
                    @elseif($pistandards->c_model == null || $pistandards->c_model == "")
                    <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                      <span ><i class="fa fa-check"></i></span>
                    </button>
                    @elseif($pistandards->c_model !== null && $pistandards->model !== $pistandards->c_model)
                    <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                      <span ><i class="fa fa-remove"></i></span>
                    </button>
                    @endif
                  </span>
                 
                </div>
                {!! $errors->first('c_model', '<p class="help-block">:message</p>') !!}
              </div>
            </div>
          </div>
          <!-- /.REFF. NO' -->
          <div class="form-group"  id="">
            <div class="col-sm-12">
              <div class="col-sm-12 {{ $errors->has('creaby') ? ' has-error' : '' }}">
                {!! Form::label('c_refno', 'REFF. NO') !!}
                <div class="input-group ">
                  {!! Form::text('c_refno', null, ['class'=>'form-control', ]) !!}
                  <span class="input-group-btn">
                      @if($pistandards->reff_no == $pistandards->c_refno)
                    <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                      <span ><i class="fa fa-check"></i></span>
                    </button>
                    @elseif($pistandards->c_refno == null ||$pistandards->c_refno == "")
                    <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                      <span ><i class="fa fa-check"></i></span>
                    </button>
                   @elseif($pistandards->c_refno !== null && $pistandards->reff_no !== $pistandards->c_refno)
                    <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                      <span ><i class="fa fa-remove"></i></span>
                    </button>
                    @endif
                  </span>
                </div>
                {!! $errors->first('c_model', '<p class="help-block">:message</p>') !!}
              </div>
            </div>
          </div>
           <!-- /.MATERIAL-->
          <div class="form-group"  id="">
            <div class="col-sm-12">
              <div class="col-sm-12 {{ $errors->has('creaby') ? ' has-error' : '' }}">
                {!! Form::label('c_material', 'MATERIAL') !!}
                <div class="input-group ">
                  {!! Form::text('c_material', null, ['class'=>'form-control',]) !!}
                  <span class="input-group-btn">
                     @if($pistandards->material == $pistandards->c_material)
                    <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                      <span ><i class="fa fa-check"></i></span>
                    </button>
                    @elseif($pistandards->c_material == null ||$pistandards->c_material == "")
                    <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                      <span ><i class="fa fa-check"></i></span>
                    </button>
                     @elseif($pistandards->c_material !== null && $pistandards->material !== $pistandards->c_material)
                    <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                      <span ><i class="fa fa-remove"></i></span>
                    </button>
                    @endif
                  </span>
                </div>
                {!! $errors->first('c_model', '<p class="help-block">:message</p>') !!}
              </div>
            </div>
          </div>
          <!-- /.GENERAL TOL-->

          
          <div class="form-group"  id="id_field">
              <div class="col-sm-12">
                 <div class="col-sm-12 {{ $errors->has('creaby') ? ' has-error' : '' }}">
                   {!! Form::label('c_generaltol', 'GENERAL TOL') !!}
                   <div class="input-group ">
                     @if($pistandards->c_generaltol == '' || $pistandards->c_generaltol == null || json_decode($pistandards->c_generaltol)== '')

                     {!! Form::text('c_generaltol[]',null, ['class'=>'form-control', ]) !!}

                     @elseif($pistandards->c_generaltol !== ''|| $pistandards->c_generaltol !== null || $pistandards->c_generaltol !== '[""]')

                       @foreach(json_decode($pistandards->c_generaltol) as $key => $nilai)
                          {!! Form::text('c_generaltol[]',$nilai, ['class'=>'form-control', ]) !!}
                       @endforeach

                     @endif
                     <span class="input-group-btn">
                     <button id="addLine" name="addLine" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Add Column">
                        <span >+</span>
                      </button>
                       @if($pistandards->c_generaltol == '[""]' || $pistandards->c_generaltol == null)

                       <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                         <span ><i class="fa fa-check"></i></span>
                       </button>
                       @elseif($pistandards->general_tol == $pistandards->c_generaltol)
                       <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                         <span ><i class="fa fa-check"></i></span>
                       </button>
                       @elseif($pistandards->general_tol !== $pistandards->c_generaltol && $pistandards->c_generaltol !== null && $pistandards->c_generaltol !== '[""]')
                       <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                         <span ><i class="fa fa-remove"></i></span>
                       </button>
                       @endif
                     </span>
                      {!! Form::hidden('jml_general', 1, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_general']) !!}
                   </div>
                 </div>
              </div>
          </div>
          <!-- /.WEIGHT-->
          <div class="form-group"  id="">
            <div class="col-sm-12">
              <div class="col-sm-12 {{ $errors->has('creaby') ? ' has-error' : '' }}">
                {!! Form::label('c_weight', 'WEIGHT') !!}
                <div class="input-group ">
                  {!! Form::text('c_weight', null, ['class'=>'form-control', ]) !!}
                   <span class="input-group-btn">
                      @if($pistandards->weight == $pistandards->c_weight)
                      <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                        <span ><i class="fa fa-check"></i></span>
                      </button>
                      @elseif($pistandards->c_weight == null ||$pistandards->c_weight == "")
                      <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                        <span ><i class="fa fa-check"></i></span>
                      </button>
                      @elseif($pistandards->c_weight !== null && $pistandards->weight !== $pistandards->c_weight)
                      <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                        <span ><i class="fa fa-remove"></i></span>
                      </button>
                      @endif
                    </span>
                </div>
                {!! $errors->first('c_model', '<p class="help-block">:message</p>') !!}
              </div>
            </div>
          </div>
          <!-- /.PART NO-->
          <div class="form-group"  id="">
              <div class="col-sm-12">
                <div class="col-sm-12 {{ $errors->has('creaby') ? ' has-error' : '' }}">
                {!! Form::label('c_partno', 'PART NO') !!}
                  <div class="input-group ">
                    {!! Form::text('c_partno', null, ['class'=>'form-control', ]) !!}
                    <span class="input-group-btn">
                      @if($pistandards->part_no == $pistandards->c_partno)
                      <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                        <span ><i class="fa fa-check"></i></span>
                      </button>
                      @elseif($pistandards->c_partno == null ||$pistandards->c_partno == "")
                      <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                        <span ><i class="fa fa-check"></i></span>
                      </button>
                      @elseif($pistandards->c_partno !== null && $pistandards->part_no !== $pistandards->c_partno)
                      <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                        <span ><i class="fa fa-remove"></i></span>
                      </button>
                      @endif
                    </span>
                  </div>
                  {!! $errors->first('c_model', '<p class="help-block">:message</p>') !!}
                </div>
              </div>
          </div>
          <!-- /.PART NAME-->
          <div class="form-group"  id="">
              <div class="col-sm-12">
                <div class="col-sm-12 {{ $errors->has('creaby') ? ' has-error' : '' }}">
                  {!! Form::label('c_partname', 'PART NAME') !!}
                  <div class="input-group ">
                    {!! Form::text('c_partname', null, ['class'=>'form-control',]) !!}
                    <span class="input-group-btn">
                      @if($pistandards->part_name == $pistandards->c_partname)
                      <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                        <span ><i class="fa fa-check"></i></span>
                      </button>
                      @elseif($pistandards->c_partname == null ||$pistandards->c_partname == "")
                      <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                        <span ><i class="fa fa-check"></i></span>
                      </button>
                      @elseif($pistandards->c_partname !== null && $pistandards->part_name !== $pistandards->c_partname)
                      <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                        <span ><i class="fa fa-remove"></i></span>
                      </button>
                      @endif
                    </span>
                  </div>
                  {!! $errors->first('c_model', '<p class="help-block">:message</p>') !!}
                </div>
              </div>
          </div>
          <!-- /.Draft/Final-->
          <div class="form-group"  id="">
            <div class="col-sm-12">
              <div class="col-sm-12 {{ $errors->has('creaby') ? ' has-error' : '' }}">
                {!! Form::label('c_stat_doc', 'Draft/Final') !!}
                <div class="input-group ">
                  {!! Form::text('c_stat_doc', null, ['class'=>'form-control', ]) !!}
                   <span class="input-group-btn">
                      @if($pistandards->status_doc == $pistandards->c_stat_doc)
                      <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                        <span ><i class="fa fa-check"></i></span>
                      </button>
                      @elseif($pistandards->c_stat_doc == null ||$pistandards->c_stat_doc == "")
                      <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                        <span ><i class="fa fa-check"></i></span>
                      </button>
                      @elseif($pistandards->c_stat_doc !== null && $pistandards->status_doc !== $pistandards->c_stat_doc)
                      <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                        <span ><i class="fa fa-remove"></i></span>
                      </button>
                      @endif
                    </span>
                </div>
                {!! $errors->first('c_model', '<p class="help-block">:message</p>') !!}
              </div>
            </div>
          </div>
          <!-- /.SUPPLIER DEPT-->
          <div class="form-group"  id="">
            <div class="col-sm-12">
              <div class="col-sm-12 {{ $errors->has('creaby') ? ' has-error' : '' }}">
                {!! Form::label('c_supp_dept', 'SUPPLIER DEPT') !!}
                <div class="input-group ">
                  {!! Form::text('c_supp_dept', null, ['class'=>'form-control',]) !!}

                  <span class="input-group-btn">
                      @if($pistandards->supp_dept == $pistandards->c_stat_doc)
                      <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                        <span ><i class="fa fa-check"></i></span>
                      </button>
                      @elseif($pistandards->c_stat_doc == null ||$pistandards->c_stat_doc == "")
                      <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                        <span ><i class="fa fa-check"></i></span>
                      </button>
                      @elseif($pistandards->c_stat_doc !== null && $pistandards->supp_dept !== $pistandards->c_stat_doc)
                      <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                        <span ><i class="fa fa-remove"></i></span>
                      </button>
                      @endif
                    </span>
                </div>
                {!! $errors->first('c_model', '<p class="help-block">:message</p>') !!}
              </div>
            </div>
          </div>
       </div>
    </div>
  </div>
  <!-- {{-- detail --}} -->
  <!-- {{-- A. CHEMICAL COMPOSITION --}} -->
  <div class="panel-body" >
       <div class="box box-primary">
         <div class="panel-heading" style="background-color: #DD4B39">
           <h2 class="panel-title" ><b>I. MATERIAL PERFORMANCE</b></h2>
         </div>
         {{-- A. CHEMICAL COMPOSITION --}}
         <div class="panel-heading" style="background-color:#F0F8FF" id="c_composition">
           <h3 class="panel-title">A. CHEMICAL COMPOSITION</h3>
         </div>
         <div class="panel-body col-md-12">
           <div class="box-body" >
             <div class="col-md-12">
              {{-- ========= --}}
               <div class="box-body col-md-6" >
                   <div class="panel-heading" style="background-color:#F0F8FF">
                      <h3 class="panel-title"><b>OUTPUT</b></h3>
                   </div>
                   <div  style="overflow:auto;width:auto; height:200px;margin:bottom 200px;">
                     <!-- /.Table Input-->
                     <table class="table table-bordered"  style="width: 1800px;">
                       <tr>
                         <th width="90px" rowspan="2" align="center"><br>NO</th>
                         <th align="middle-center" rowspan="2" width="220px"><br>INSPECTION ITEM</th>
                         <th colspan="2"><p align="center">STANDARD VALUE</p></th>
                         <th rowspan="2" width="200px"><br>&nbsp;INSPECTION INSTRUMENT</th>
                         <th rowspan="2" width="60px"><p align="center"><br> RANK</p></th>
                         <th colspan="2"><p align="center">SAMPLING PLAN</p></th>
                         <th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
                       </tr>
                       <tr>
                         <th width="150px">NOMINAL</th>
                         <th width="150px">TOLERANCE</th>
                         <th width="200px">IN PROSES</th>
                         <th width="220px">AT DELIVERY</th>
                       </tr> 
                       @if (!empty($composition->no_pisigp))
                         @foreach ($entity->getLines($composition->no_pisigp)->get() as $model)
                           <tr id="">
                             <div class="">
                               <div class=""> 
                                 <td>
                                   <input type="text" id="cno_{{ $loop->iteration }}" name="cno_{{ $loop->iteration }}" placeholder="" class="form-control name_list" readonly="true" value="{{ $model->no }}" align="center"/>
                                 </td>

                                 <td>
                                   <div class="input-group">
                                     <input type="text" id="citem_{{ $loop->iteration }}" name="citem_{{ $loop->iteration }}" placeholder="" class="form-control name_list" value="{{ $model->item }}" readonly="true"/>
                                     <span class="input-group-btn">
                                         @if($model->item == $model->a_item)
                                           <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                           </button>
                                         @elseif($model->a_item == null ||$model->a_item == "")
                                           <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                           </button>
                                         @elseif($model->a_item !== null && $model->item !== $model->a_item)
                                           <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                             <span ><i class="fa fa-remove"></i></span>
                                           </button>
                                        @endif
                                    </span>

                                   </div>
                                 </td>

                                 <td>
                                   <div class="input-group">
                                     <input type="text" id="cnom_{{ $loop->iteration }}" name="cnom_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->nominal }}" readonly="true"/>
                                     <span class="input-group-btn">
                                        @if($model->nominal == $model->a_nominal)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->a_nominal == null ||$model->a_nominal == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->a_nominal !== null && $model->nominal !== $model->a_nominal)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                    </span>
                                   </div>
                                 </td>

                                 <td>
                                   <div class="input-group">
                                     <input type="text" id="ctol_{{ $loop->iteration }}" name="ctol_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->tolerance }}" readonly="true"/>
                                     <span class="input-group-btn">
                                        @if($model->tolerance == $model->a_tolerance)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->a_tolerance == null ||$model->a_tolerance == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->a_tolerance !== null && $model->tolerance !== $model->a_tolerance)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                   </div>
                                 </td>

                                 <td>
                                   <div class="input-group">
                                     <input type="text" id="cins_{{ $loop->iteration }}" name="cins_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->instrument }}" readonly="true"/>
                                     <span class="input-group-btn">
                                        @if($model->instrument == $model->a_instrument)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->a_instrument == null ||$model->a_instrument == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->a_instrument !== null && $model->instrument !== $model->a_instrument)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                   </div>
                                 </td>

                                 <td>
                                   <div class="input-group">
                                     <input type="text" id="crank_{{ $loop->iteration }}" name="crank_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->rank }}" readonly="true"/>
                                     <span class="input-group-btn">
                                        @if($model->rank == $model->a_rank)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->a_rank == null ||$model->a_rank == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->a_rank !== null && $model->rank !== $model->a_rank)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                   </div>
                                 </td>

                                 <td>
                                   <div class="input-group">
                                     <input type="text" id="cpro_{{ $loop->iteration }}" name="cpro_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->proses }}" readonly="true"/>
                                      <span class="input-group-btn">
                                        @if($model->proses == $model->a_proses)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->a_proses == null ||$model->a_proses == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->a_proses !== null && $model->proses !== $model->a_proses)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                   </div>
                                 </td>

                                 <td>
                                    <div class="input-group">
                                     <input type="text" id="cdel_{{ $loop->iteration }}" name="cdel_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->delivery }}" readonly="true"/>
                                     <span class="input-group-btn">
                                        @if($model->delivery == $model->a_delivery)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->a_delivery == null ||$model->a_delivery == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->a_delivery !== null && $model->delivery !== $model->a_delivery)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                    </div>
                                 </td>

                                 <td>
                                   <div class="input-group">
                                     <input type="text" id="crem_{{ $loop->iteration }}" name="crem_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->remarks }}" readonly="true"/>
                                     <span class="input-group-btn">
                                        @if($model->remarks == $model->a_remarks)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->a_remarks == null ||$model->a_remarks == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->a_remarks !== null && $model->remarks !== $model->a_remarks)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                   </div>
                                 </td>
                               </div>
                             </div>      
                           </tr>
                         @endforeach
                       @else
                       @endif
                     </table>
                   </div>
               </div>
               {{-- ====================================== --}}
                <div class="box-body col-md-6">
                   <div class="panel-heading" style="background-color:#F0F8FF">
                       <h3 class="panel-title"><b>NOTES  </b></h3>
                   </div>
                   <div  style="padding:3px;overflow:auto;width:auto;height:200px;">
                     <!-- /.Table Input-->
                     <table class="table table-bordered" id="append1" style="width: 1800px;">
                       <tr>
                         <th width="90px" rowspan="2" align="center"><br>NO</th>
                         <th align="middle-center" rowspan="2" width="220px"><br>INSPECTION ITEM</th>
                         <th colspan="2"><p align="center">STANDARD VALUE</p></th>
                         <th rowspan="2" width="200px"><br>&nbsp;INSPECTION INSTRUMENT</th>
                         <th rowspan="2" width="60px"><p align="center"><br> RANK</p></th>
                         <th colspan="2"><p align="center">SAMPLING PLAN</p></th>
                         <th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
                       </tr>
                       <tr>
                         <th width="150px">NOMINAL</th>
                         <th width="150px">TOLERANCE</th>
                         <th width="200px">IN PROSES</th>
                         <th width="220px">AT DELIVERY</th>
                       </tr> 
                       @if (!empty($composition->no_pisigp))
                         @foreach ($entity->getLines($composition->no_pisigp)->get() as $test)
                           <tr id="id_linehidden_{{ $loop->iteration }}">
                             <div class="">
                               <div class=""> 
                                 <td>
                                   <input type="text" id="cno_{{ $loop->iteration }}" name="cno_{{ $loop->iteration }}" placeholder="" class="form-control name_list" readonly="true" value="{{ $test->no }}" align="center"/>
                                 </td>

                                 <td>
                                   <div class="input-group">
                                     <input type="text" id="a_item_{{ $loop->iteration }}" name="a_item_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $test->a_item }}" />
                                     
                                   </div>
                                 </td>

                                 <td>
                                   <div class="input-group">
                                     <input type="text" id="a_nominal_{{ $loop->iteration }}" name="a_nominal_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->a_nominal }}"/>
                                   </div>
                                 </td>

                                 <td>
                                   <input type="text" id="a_tolerance_{{ $loop->iteration }}" name="a_tolerance_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->a_tolerance }}"/>
                                 </td>

                                 <td>
                                   <input type="text" id="a_instrument_{{ $loop->iteration }}" name="a_instrument_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->a_instrument }}"/>
                                 </td>

                                 <td>
                                   <input type="text" id="a_rank_{{ $loop->iteration }}" name="a_rank_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->a_rank }}"/>
                                 </td>

                                 <td>
                                   <input type="text" id="a_proses_{{ $loop->iteration }}" name="a_proses_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->a_proses }}"/>
                                 </td>

                                 <td>
                                   <input type="text" id="a_delivery_{{ $loop->iteration }}" name="a_delivery_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->a_delivery }}"/>
                                 </td>

                                 <td>
                                   <input type="text" id="a_remarks_{{ $loop->iteration }}" name="a_remarks_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->a_remarks }}"/>
                                 </td>

                                 
                               </div>
                             </div>      
                           </tr>
                         @endforeach
                         {!! Form::hidden('linehidden', $entity->getLines($composition->no_pisigp)->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'linehidden']) !!}
                         @else
                         {!! Form::hidden('linehidden', 0, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'linehidden']) !!}
                       @endif
                     </table>
                   </div>
                   {{-- <button type="button" name="add1" id="add1" class="btn btn-success">+</button> --}}
               </div>
             </div>
           </div>

         </div>

       </div>
  </div>
  <!-- {{-- B.MECHANICAL PROPERTIES --}} -->
  <div class="panel-body" >                 
      {{-- B.MECHANICAL PROPERTIES --}}
      <div class="panel-heading" style="background-color:#F0F8FF" >
        <h3 class="panel-title">B.MECHANICAL PROPERTIES</h3>
      </div>
      <div class="panel-body col-md-12">
        <div class="box-body" >
          <div class="col-md-12">
           {{-- ========= --}}
            <div class="box-body col-md-6" >
                <div class="panel-heading" style="background-color:#F0F8FF">
                   <h3 class="panel-title"><b>OUTPUT</b></h3>
                </div>
                <div  style="overflow:auto;width:auto; height:200px;margin:bottom 200px;">
                  <!-- /.Table Input-->
                  <table class="table table-bordered"  style="width: 1800px;">
                    <tr>
                      <th width="120px" rowspan="2" align="center"><br>NO</th>
                      <th align="middle-center" rowspan="2" width="220px"><br>INSPECTION ITEM</th>
                      <th colspan="2"><p align="center">STANDARD VALUE</p></th>
                      <th rowspan="2" width="200px"><br>&nbsp;INSPECTION INSTRUMENT</th>
                      <th rowspan="2" width="60px"><p align="center"><br> RANK</p></th>
                      <th colspan="2"><p align="center">SAMPLING PLAN</p></th>
                      <th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
                    </tr>
                    <tr>
                      <th width="150px">NOMINAL</th>
                      <th width="150px">TOLERANCE</th>
                      <th width="200px">IN PROSES</th>
                      <th width="220px">AT DELIVERY</th>
                    </tr> 
                    @if (!empty($properties->no_pisigp))
                        @foreach ($entity->getLines1($properties->no_pisigp)->get() as $model)
                          <tr id="">
                            <div class="">
                              <div class=""> 
                                <td>
                                  <input type="text" id="mno_{{ $loop->iteration }}" name="mno_{{ $loop->iteration }}" placeholder="" class="form-control name_list" readonly="true" value="{{ $model->no }}" align="center"/>
                                </td>

                                <td>
                                  <div class="input-group">
                                    <input type="text" id="mitem_{{ $loop->iteration }}" name="mitem_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->item }}" readonly="true" />
                                     <span class="input-group-btn">
                                        @if($model->item == $model->b_item)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->b_item == null ||$model->b_item == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->b_item !== null && $model->item !== $model->b_item)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>

                                  </div>
                                </td>

                                <td>
                                  <div class="input-group">
                                    <input type="text" id="mnom_{{ $loop->iteration }}" name="mnom_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->nominal }}" readonly="true"/>
                                    <span class="input-group-btn">
                                        @if($model->nominal == $model->b_nominal)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->b_nominal == null ||$model->b_nominal == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->b_nominal !== null && $model->nominal !== $model->b_nominal)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                  </div>
                                </td>

                                <td>
                                  <div class="input-group">
                                    <input type="text" id="mtol_{{ $loop->iteration }}" name="mtol_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->tolerance }}" readonly="true" />
                                    <span class="input-group-btn">
                                        @if($model->tolerance == $model->b_tolerance)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->b_nominal == null ||$model->b_nominal == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->b_nominal !== null && $model->nominal !== $model->b_nominal)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                  </div>
                                </td>

                                <td>
                                  <div class="input-group">
                                    <input type="text" id="mins_{{ $loop->iteration }}" name="mins_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->instrument }}" readonly="true"/>
                                     <span class="input-group-btn">
                                        @if($model->instrument == $model->b_instrument)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->b_instrument == null ||$model->b_instrument == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->b_instrument !== null && $model->instrument !== $model->b_instrument)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                  </div>
                                </td>

                                <td>
                                  <div class="input-group">
                                    <input type="text" id="mrank_{{ $loop->iteration }}" name="mrank_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->rank }}" readonly="true"/>
                                    <span class="input-group-btn">
                                        @if($model->rank == $model->b_rank)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->b_rank == null ||$model->b_rank == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->b_rank !== null && $model->rank !== $model->b_rank)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                  </div>
                                </td>

                                <td>
                                  <div class="input-group">
                                    <input type="text" id="mpro_{{ $loop->iteration }}" name="mpro_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->proses }}" readonly="true"/>
                                    <span class="input-group-btn">
                                        @if($model->proses == $model->b_proses)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->b_proses == null ||$model->b_proses == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->b_proses !== null && $model->proses !== $model->b_proses)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                  </div>
                                </td>

                                <td>
                                  <div class="input-group">
                                    <input type="text" id="mdel_{{ $loop->iteration }}" name="mdel_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->delivery }}" readonly="true"/>
                                    <span class="input-group-btn">
                                        @if($model->delivery == $model->b_delivery)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->b_delivery == null ||$model->b_delivery == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->b_delivery !== null && $model->delivery !== $model->b_delivery)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                  </div>
                                </td>

                                <td>
                                  <div class="input-group">
                                    <input type="text" id="mrem_{{ $loop->iteration }}" name="mrem_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->remarks }}" readonly="true"/>
                                    <span class="input-group-btn">
                                        @if($model->remarks == $model->b_remarks)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->b_remarks == null ||$model->b_remarks == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->b_remarks !== null && $model->remarks !== $model->b_remarks)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                  </div>
                                </td>
                              </div>
                            </div>      
                          </tr>
                        @endforeach
                        @else
                    @endif
                  </table>
                </div>
            </div>
            {{-- ====================================== --}}
            <div class="box-body col-md-6">
                <div class="panel-heading" style="background-color:#F0F8FF">
                    <h3 class="panel-title"><b>NOTES  </b></h3>
                </div>
                <div  style="padding:3px;overflow:auto;width:auto;height:200px;">
                  <!-- /.Table Input-->
                  <table class="table table-bordered" id="dynamic_field2" style="width: 1800px;">
                     <tr>
                         <th width="120px" rowspan="2" align="center"><br>NO</th>
                         <th align="middle-center" rowspan="2" width="220px"><br>INSPECTION ITEM</th>
                         <th colspan="2"><p align="center">STANDARD VALUE</p></th>
                         <th rowspan="2" width="200px"><br>&nbsp;INSPECTION INSTRUMENT</th>
                         <th rowspan="2" width="60px"><p align="center"><br> RANK</p></th>
                         <th colspan="2"><p align="center">SAMPLING PLAN</p></th>
                         <th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
                       </tr>
                       <tr>
                         <th width="150px">NOMINAL</th>
                         <th width="150px">TOLERANCE</th>
                         <th width="200px">IN PROSES</th>
                         <th width="220px">AT DELIVERY</th>
                       </tr> 
                    @if (!empty($properties->no_pisigp))
                      @foreach ($entity->getLines1($properties->no_pisigp)->get() as $model)
                        <tr id="id_linehidden1_{{ $loop->iteration }}">
                          <div class="">
                            <div class=""> 
                              <td>
                                <input type="text" id="mno_{{ $loop->iteration }}" name="mno_{{ $loop->iteration }}" placeholder="" class="form-control name_list" readonly="true" value="{{ $model->no }}" align="center"/>
                              </td>

                              <td>
                                <div class="input-group">
                                  <input type="text" id="b_item_{{ $loop->iteration }}" name="b_item_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->b_item }}" />
                                </div>
                              </td>

                              <td>
                                <div class="input-group">
                                  <input type="text" id="b_nominal_{{ $loop->iteration }}" name="b_nominal_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->b_nominal }}"/>
                                </div> 
                              </td>

                              <td>
                                <input type="text" id="b_tolerance_{{ $loop->iteration }}" name="b_tolerance_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->b_tolerance }}"/>
                              </td>

                              <td>
                                <input type="text" id="b_instrument_{{ $loop->iteration }}" name="b_instrument_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->b_instrument }}"/>
                              </td>

                              <td>
                                <input type="text" id="b_rank_{{ $loop->iteration }}" name="b_rank_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->b_rank }}"/>
                              </td>

                              <td>
                                <input type="text" id="b_proses_{{ $loop->iteration }}" name="b_proses_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->b_proses }}"/>
                              </td>

                              <td>
                                <input type="text" id="b_delivery_{{ $loop->iteration }}" name="b_delivery_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->b_delivery }}"/>
                              </td>

                              <td>
                                <input type="text" id="b_remarks_{{ $loop->iteration }}" name="b_remarks_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->b_remarks }}"/>
                              </td>

                              
                            </div>
                          </div>      
                        </tr>
                      @endforeach
                      {!! Form::hidden('linehidden1', $entity->getLines1($properties->no_pisigp)->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'linehidden1']) !!}
                      @else
                      {!! Form::hidden('linehidden1', 0, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'linehidden']) !!}
                    @endif
                  </table>
                  
                </div>
                {{-- <button type="button" name="addd" id="addd" class="btn btn-success">+</button> --}}
            </div>
          </div>
        </div>

      </div>
  </div>
  <!-- {{-- C. WELDING PERFORMANCE (IF ANY) --}} -->
  <div class="panel-body" >
      {{-- B.MECHANICAL PROPERTIES --}}
      <div class="panel-heading" style="background-color:#F0F8FF" >
        <h3 class="panel-title"> C. WELDING PERFORMANCE (IF ANY) </h3>
      </div>
      <div class="panel-body col-md-12">
        <div class="box-body" >
          <div class="col-md-12">
           {{-- ========= --}}
            <div class="box-body col-md-6" >
                <div class="panel-heading" style="background-color:#F0F8FF">
                   <h3 class="panel-title"><b>OUTPUT</b></h3>
                </div>
                <div  style="overflow:auto;width:auto; height:200px;margin:bottom 200px;">
                  <!-- /.Table Input-->
                  <table class="table table-bordered"  style="width: 1800px;">
                    <tr>
                      <th width="120px" rowspan="2" align="center"><br>NO</th>
                      <th align="middle-center" rowspan="2" width="220px"><br>INSPECTION ITEM</th>
                      <th colspan="2"><p align="center">STANDARD VALUE</p></th>
                      <th rowspan="2" width="200px"><br>&nbsp;INSPECTION INSTRUMENT</th>
                      <th rowspan="2" width="60px"><p align="center"><br> RANK</p></th>
                      <th colspan="2"><p align="center">SAMPLING PLAN</p></th>
                      <th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
                    </tr>
                    <tr>
                      <th width="150px">NOMINAL</th>
                      <th width="150px">TOLERANCE</th>
                      <th width="200px">IN PROSES</th>
                      <th width="220px">AT DELIVERY</th>
                    </tr> 
                    @if (!empty($performances->no_pisigp))
                        @foreach ($entity->getLines2($performances->no_pisigp)->get() as $model)
                          <tr id="">
                            <div class="">
                              <div class=""> 
                                <td>
                                  <input type="text" id="mno_{{ $loop->iteration }}" name="mno_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->no }}" align="center" readonly="true"/>
                                </td>

                                <td>
                                  <div class="input-group">
                                    <input type="text" id="mitem_{{ $loop->iteration }}" name="mitem_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->item }}" readonly="true"/>
                                     <span class="input-group-btn">
                                        @if($model->item == $model->c_item)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->c_item == null ||$model->c_item == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->c_item !== null && $model->item !== $model->c_item)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>

                                  </div>
                                </td>

                                <td>
                                  <div class="input-group">
                                    <input type="text" id="mnom_{{ $loop->iteration }}" name="mnom_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->nominal }}" readonly="true"/>
                                     <span class="input-group-btn">
                                        @if($model->nominal == $model->c_nominal)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->c_nominal == null ||$model->c_nominal == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->c_nominal !== null && $model->nominal !== $model->c_nominal)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                  </div>
                                </td>

                                <td>
                                 <div class="input-group">

                                   <input type="text" id="mtol_{{ $loop->iteration }}" name="mtol_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->tolerance }}" readonly="true"/>
                                   <span class="input-group-btn">
                                        @if($model->tolerance == $model->c_tolerance)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->c_tolerance == null ||$model->c_tolerance == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->c_tolerance !== null && $model->tolerance !== $model->c_tolerance)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                  </div>
                                </td>

                                <td>
                                 <div class="input-group">
                                  <input type="text" id="mins_{{ $loop->iteration }}" name="mins_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->instrument }}" readonly="true"/>
                                  <span class="input-group-btn">
                                        @if($model->instrument == $model->c_instrument)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->c_instrument == null ||$model->c_instrument == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->c_instrument !== null && $model->instrument !== $model->c_instrument)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                  </div>
                                </td>

                                <td>
                                 <div class="input-group">
                                  <input type="text" id="mrank_{{ $loop->iteration }}" name="mrank_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->rank }}" readonly="true"/>
                                   <span class="input-group-btn">
                                        @if($model->rank == $model->c_rank)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->c_rank == null ||$model->c_rank == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->c_rank !== null && $model->rank !== $model->c_rank)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                  </div>
                                </td>

                                <td>
                                 <div class="input-group">
                                  <input type="text" id="mpro_{{ $loop->iteration }}" name="mpro_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->proses }}" readonly="true"/>
                                   <span class="input-group-btn">
                                        @if($model->proses == $model->c_proses)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->c_proses == null ||$model->c_proses == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->c_proses !== null && $model->proses !== $model->c_proses)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                  </div>
                                </td>

                                <td>
                                  <div class="input-group">
                                  <input type="text" id="mdel_{{ $loop->iteration }}" name="mdel_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->delivery }}" readonly="true"/>
                                  <span class="input-group-btn">
                                        @if($model->delivery == $model->c_delivery)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->c_delivery == null ||$model->c_delivery == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->c_delivery !== null && $model->delivery !== $model->c_delivery)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                  </div>
                                </td>

                                <td>
                                 <div class="input-group">
                                  <input type="text" id="mrem_{{ $loop->iteration }}" name="mrem_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->remarks }}" readonly="true"/>
                                  <span class="input-group-btn">
                                        @if($model->remarks == $model->c_remarks)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->c_remarks == null ||$model->c_remarks == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->c_remarks !== null && $model->remarks !== $model->c_remarks)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                 </div>
                                </td>
                              </div>
                            </div>      
                          </tr>
                        @endforeach
                        @else
                    @endif
                  </table>
                </div>
            </div>
            {{-- ====================================== --}}
            <div class="box-body col-md-6">
                <div class="panel-heading" style="background-color:#F0F8FF">
                    <h3 class="panel-title"><b>NOTES  </b></h3>
                </div>
                <div  style="padding:3px;overflow:auto;width:auto;height:200px;">
                  <!-- /.Table Input-->
                  <table class="table table-bordered" id="dynamic_field3" style="width: 1800px;">
                    <tr>
                         <th width="120px" rowspan="2" align="center"><br>NO</th>
                         <th align="middle-center" rowspan="2" width="220px"><br>INSPECTION ITEM</th>
                         <th colspan="2"><p align="center">STANDARD VALUE</p></th>
                         <th rowspan="2" width="200px"><br>&nbsp;INSPECTION INSTRUMENT</th>
                         <th rowspan="2" width="60px"><p align="center"><br> RANK</p></th>
                         <th colspan="2"><p align="center">SAMPLING PLAN</p></th>
                         <th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
                       </tr>
                       <tr>
                         <th width="150px">NOMINAL</th>
                         <th width="150px">TOLERANCE</th>
                         <th width="200px">IN PROSES</th>
                         <th width="220px">AT DELIVERY</th>
                       </tr> 
                    @if (!empty($performances->no_pisigp))
                        @foreach ($entity->getLines2($performances->no_pisigp)->get() as $model)
                          <tr id="">
                            <div class="">
                              <div class=""> 
                                <td>
                                   <input type="text" id="wno_{{ $loop->iteration }}" name="wno_{{ $loop->iteration }}" placeholder="" class="form-control name_list" readonly="true" value="{{ $model->no }}" align="center"/>
                                </td>

                                <td>
                                  <div class="input-group">
                                  <input type="text" id="c_item_{{ $loop->iteration }}" name="c_item_{{ $loop->iteration }}" placeholder="" class="form-control name_list"   value="{{ $model->c_item }}" />
                                  </div>
                                </td>

                                <td>
                                  <div class="input-group">
                                    <input type="text" id="c_nominal_{{ $loop->iteration }}" name="c_nominal_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->c_nominal }}"/>
                                  </div>
                                </td>

                                <td>
                                  <input type="text" id="c_tolerance_{{ $loop->iteration }}" name="c_tolerance_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->c_tolerance }}"/>
                                </td>

                                <td>
                                  <input type="text" id="c_instrument_{{ $loop->iteration }}" name="c_instrument_{{ $loop->iteration }}" placeholder="" class="form-control name_list" value="{{ $model->c_instrument }}"/>
                                </td>

                                <td>
                                  <input type="text" id="c_rank_{{ $loop->iteration }}" name="c_rank_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->c_rank }}"/>
                                </td>

                                <td>
                                  <input type="text" id="c_proses_{{ $loop->iteration }}" name="c_proses_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->c_proses }}"/>
                                </td>

                                <td>
                                  <input type="text" id="c_delivery_{{ $loop->iteration }}" name="c_delivery_{{ $loop->iteration }}" placeholder="" class="form-control name_list" value="{{ $model->c_delivery }}"/>
                                </td>

                                <td>
                                  <input type="text" id="c_remarks_{{ $loop->iteration }}" name="c_remarks_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->c_remarks }}"/>
                                </td>

                              </div>
                            </div>      
                          </tr>
                        @endforeach
                         {!! Form::hidden('linehidden2', $entity->getLines2($performances->no_pisigp)->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'linehidden2']) !!}
                        @else
                         {!! Form::hidden('linehidden2', 0, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'linehidden']) !!}
                    @endif
                  </table>
                     
                </div>
                {{-- <button type="button" name="add3" id="add3" class="btn btn-success">+</button> --}}
            </div>
          </div>
        </div>

      </div>
  </div>
  <!-- {{-- D. SURFACE TREATMENT (IF ANY) --}} -->
  <div class="panel-body" >
     {{-- D. SURFACE TREATMENT (IF ANY) --}}
     <div class="panel-heading" style="background-color:#F0F8FF" >
       <h3 class="panel-title"> D. SURFACE TREATMENT (IF ANY) </h3>
     </div>
     <div class="panel-body col-md-12">
       <div class="box-body" >
         <div class="col-md-12">
          {{-- ========= --}}
           <div class="box-body col-md-6" >
               <div class="panel-heading" style="background-color:#F0F8FF">
                  <h3 class="panel-title"><b>OUTPUT</b></h3>
               </div>
               <div  style="overflow:auto;width:auto; height:200px;margin:bottom 200px;">
                 <!-- /.Table Input-->
                 <table class="table table-bordered"  style="width: 1800px;">
                   <tr>
                     <th width="120px" rowspan="2" align="center"><br>NO</th>
                     <th align="middle-center" rowspan="2" width="220px"><br>INSPECTION ITEM</th>
                     <th colspan="2"><p align="center">STANDARD VALUE</p></th>
                     <th rowspan="2" width="200px"><br>&nbsp;INSPECTION INSTRUMENT</th>
                     <th rowspan="2" width="60px"><p align="center"><br> RANK</p></th>
                     <th colspan="2"><p align="center">SAMPLING PLAN</p></th>
                     <th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
                   </tr>
                   <tr>
                     <th width="150px">NOMINAL</th>
                     <th width="150px">TOLERANCE</th>
                     <th width="200px">IN PROSES</th>
                     <th width="220px">AT DELIVERY</th>
                   </tr> 
                   @if (!empty($treatements->no_pisigp))
                       @foreach ($entity->getLines3($treatements->no_pisigp)->get() as $model)
                         <tr id="">
                           <div class="">
                             <div class=""> 
                               <td>
                                 <input type="text" id="sno_{{ $loop->iteration }}" name="sno_{{ $loop->iteration }}" placeholder="" class="form-control name_list" readonly="true" value="{{ $model->no }}" align="center"/>
                               </td>

                               <td>
                                 <div class="input-group">
                                   <input type="text" id="sitem_{{ $loop->iteration }}" name="sitem_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->item }}" readonly="true"/>
                                   <span class="input-group-btn">
                                        @if($model->item == $model->d_item)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->d_item == null ||$model->d_item == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->d_item !== null && $model->item !== $model->d_item)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                 </div>
                               </td>

                               <td>
                                 <div class="input-group">
                                   <input type="text" id="snominal_{{ $loop->iteration }}" name="snominal_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->nominal }}" readonly="true"/>
                                      <span class="input-group-btn">
                                        @if($model->nominal == $model->d_nominal)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->d_nominal == null ||$model->d_nominal == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->d_nominal !== null && $model->nominal !== $model->d_nominal)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                 </div>
                               </td>

                               <td>
                               <div class="input-group">
                                 <input type="text" id="stolerance_{{ $loop->iteration }}" name="stolerance_{{ $loop->iteration }}" placeholder="" class="form-control name_list" value="{{ $model->tolerance }}" readonly="true"/>
                                 <span class="input-group-btn">
                                        @if($model->tolerance == $model->d_tolerance)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->d_tolerance == null ||$model->d_tolerance == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->d_tolerance !== null && $model->tolerance !== $model->d_tolerance)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                 </div>
                               </td>

                               <td>
                               <div class="input-group">
                                 <input type="text" id="sinstrument_{{ $loop->iteration }}" name="sinstrument_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->instrument }}" readonly="true"/>
                                  <span class="input-group-btn">
                                        @if($model->instrument == $model->d_instrument)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->d_instrument == null ||$model->d_instrument == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->d_instrument !== null && $model->instrument !== $model->d_instrument)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                 </div>
                               </td>

                               <td>
                               <div class="input-group">
                                 <input type="text" id="srank_{{ $loop->iteration }}" name="srank_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->rank }}" readonly="true"/>
                                  <span class="input-group-btn">
                                        @if($model->rank == $model->d_rank)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->d_rank == null ||$model->d_rank == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->d_rank !== null && $model->rank !== $model->d_rank)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                 </div>
                               </td>

                               <td>
                               <div class="input-group">
                                 <input type="text" id="sproses_{{ $loop->iteration }}" name="sproses_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->proses }}" readonly="true"/>
                                  <span class="input-group-btn">
                                        @if($model->proses == $model->d_proses)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->d_proses == null ||$model->d_proses == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->d_proses !== null && $model->proses !== $model->d_proses)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                 </div>
                               </td>

                               <td>
                               <div class="input-group">
                                 <input type="text" id="sdelivery_{{ $loop->iteration }}" name="sdelivery_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->delivery }}" readonly="true"/>
                                  <span class="input-group-btn">
                                        @if($model->delivery == $model->d_delivery)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->d_delivery == null ||$model->d_delivery == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->d_delivery !== null && $model->delivery !== $model->d_delivery)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                 </div>
                               </td>

                               <td>
                               <div class="input-group">
                                 <input type="text" id="sremarks_{{ $loop->iteration }}" name="sremarks_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->remarks }}" readonly="true"/>
                                  <span class="input-group-btn">
                                        @if($model->remarks == $model->d_remarks)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->d_remarks == null ||$model->d_remarks == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->d_remarks !== null && $model->remarks !== $model->d_remarks)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                 </div>
                               </td>
                             </div>
                           </div>      
                         </tr>
                       @endforeach
                       @else
                   @endif
                 </table>
               </div>
           </div>
           {{-- ====================================== --}}
           <div class="box-body col-md-6">
               <div class="panel-heading" style="background-color:#F0F8FF">
                   <h3 class="panel-title"><b>NOTES  </b></h3>
               </div>
               <div  style="padding:3px;overflow:auto;width:auto;height:200px;">
                 <!-- /.Table Input-->
                 <table class="table table-bordered" id="dynamic_field4" style="width: 1800px;">
                    <tr>
                         <th width="120px" rowspan="2" align="center"><br>NO</th>
                         <th align="middle-center" rowspan="2" width="220px"><br>INSPECTION ITEM</th>
                         <th colspan="2"><p align="center">STANDARD VALUE</p></th>
                         <th rowspan="2" width="200px"><br>&nbsp;INSPECTION INSTRUMENT</th>
                         <th rowspan="2" width="60px"><p align="center"><br> RANK</p></th>
                         <th colspan="2"><p align="center">SAMPLING PLAN</p></th>
                         <th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
                       </tr>
                       <tr>
                         <th width="150px">NOMINAL</th>
                         <th width="150px">TOLERANCE</th>
                         <th width="200px">IN PROSES</th>
                         <th width="220px">AT DELIVERY</th>
                       </tr> 
                   @if (!empty($treatements->no_pisigp))
                       @foreach ($entity->getLines3($treatements->no_pisigp)->get() as $model)
                         <tr id="">
                           <div class="">
                             <div class=""> 
                               <td>
                                 <input type="text" id="sno_{{ $loop->iteration }}" name="sno_{{ $loop->iteration }}" placeholder="" class="form-control name_list" readonly="true" value="{{ $model->no }}" align="center"/>
                               </td>

                               <td>
                                 <div class="input-group">
                                 <input type="text" id="d_item_{{ $loop->iteration }}" name="d_item_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->d_item }}" />
                                 </div>
                               </td>

                               <td>
                                 <div class="input-group">
                                   <input type="text" id="d_nominal_{{ $loop->iteration }}" name="d_nominal_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->d_nominal }}"/>
                                 </div>
                               </td>

                               <td>
                                 <input type="text" id="d_tolerance_{{ $loop->iteration }}" name="d_tolerance_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->d_tolerance }}"/>
                               </td>

                               <td>
                                 <input type="text" id="d_instrument_{{ $loop->iteration }}" name="d_instrument_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->d_instrument }}"/>
                               </td>

                               <td>
                                 <input type="text" id="d_rank_{{ $loop->iteration }}" name="d_rank_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->d_rank }}"/>
                               </td>

                               <td>
                                 <input type="text" id="d_proses_{{ $loop->iteration }}" name="d_proses_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->d_proses }}"/>
                               </td>

                               <td>
                                 <input type="text" id="d_delivery_{{ $loop->iteration }}" name="d_delivery_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->d_delivery }}"/>
                               </td>

                               <td>
                                 <input type="text" id="d_remarks_{{ $loop->iteration }}" name="d_remarks_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->d_remarks }}"/>
                               </td>

                             </div>
                           </div>      
                         </tr>
                       @endforeach
                        {!! Form::hidden('linehidden3', $entity->getLines3($treatements->no_pisigp)->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'linehidden3']) !!}
                       @else
                        {!! Form::hidden('linehidden3', 0, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'linehidden']) !!}
                   @endif
                 </table>
               </div>
               {{-- <button type="button" name="add4" id="add4" class="btn btn-success">+</button> --}}
           </div>
         </div>
       </div>

     </div>
  </div>
  <!-- {{-- E. HEAT TREATMENT (IF ANY) --}} -->
  <div class="panel-body" >
      {{-- E. HEAT TREATMENT (IF ANY) --}}
      <div class="panel-heading" style="background-color:#F0F8FF" >
        <h3 class="panel-title"> E. HEAT TREATMENT (IF ANY) </h3>
      </div>
      <div class="panel-body col-md-12">
        <div class="box-body" >
          <div class="col-md-12">
           {{-- ========= --}}
            <div class="box-body col-md-6" >
                <div class="panel-heading" style="background-color:#F0F8FF">
                   <h3 class="panel-title"><b>OUTPUT</b></h3>
                </div>
                <div  style="overflow:auto;width:auto; height:200px;margin:bottom 200px;">
                  <!-- /.Table Input-->
                  <table class="table table-bordered"  style="width: 1800px;">
                    <tr>
                      <th width="120px" rowspan="2" align="center"><br>NO</th>
                      <th align="middle-center" rowspan="2" width="220px"><br>INSPECTION ITEM</th>
                      <th colspan="2"><p align="center">STANDARD VALUE</p></th>
                      <th rowspan="2" width="200px"><br>&nbsp;INSPECTION INSTRUMENT</th>
                      <th rowspan="2" width="60px"><p align="center"><br> RANK</p></th>
                      <th colspan="2"><p align="center">SAMPLING PLAN</p></th>
                      <th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
                    </tr>
                    <tr>
                      <th width="150px">NOMINAL</th>
                      <th width="150px">TOLERANCE</th>
                      <th width="200px">IN PROSES</th>
                      <th width="220px">AT DELIVERY</th>
                    </tr> 
                   @if (!empty($htreatements->no_pisigp))
                      @foreach ($entity->getLines4($htreatements->no_pisigp)->get() as $model)
                          <tr id="">
                            <div class="">
                              <div class=""> 
                                <td>
                                  <input type="text" id="mno_{{ $loop->iteration }}" name="mno_{{ $loop->iteration }}" placeholder="" class="form-control name_list" readonly="true" value="{{ $model->no }}" align="center"/>
                                </td>

                                <td>
                                  <div class="input-group">
                                    <input type="text" id="mitem_{{ $loop->iteration }}" name="mitem_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->item }}" readonly="true"/>
                                     <span class="input-group-btn">
                                        @if($model->item == $model->e_item)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->e_item == null ||$model->e_item == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->e_item !== null && $model->item !== $model->e_item)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>

                                  </div>
                                </td>

                                <td>
                                  <div class="input-group">
                                    <input type="text" id="mnom_{{ $loop->iteration }}" name="mnom_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->nominal }}" readonly="true"/>
                                    <span class="input-group-btn">
                                        @if($model->nominal == $model->e_nominal)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->e_nominal == null ||$model->e_nominal == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->e_nominal !== null && $model->nominal !== $model->e_nominal)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                  </div>
                                </td>

                                <td>
                                  <div class="input-group">
                                    <input type="text" id="mtol_{{ $loop->iteration }}" name="mtol_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->tolerance }}" readonly="true"/>
                                     <span class="input-group-btn">
                                        @if($model->tolerance == $model->e_tolerance)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->e_tolerance == null ||$model->e_tolerance == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->e_tolerance !== null && $model->tolerance !== $model->e_tolerance)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                  </div>
                                </td>

                                <td>
                                  <div class="input-group">
                                    <input type="text" id="mins_{{ $loop->iteration }}" name="mins_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->instrument }}" readonly="true"/>
                                    <span class="input-group-btn">
                                        @if($model->instrument == $model->e_instrument)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->e_instrument == null ||$model->e_instrument == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->e_instrument !== null && $model->instrument !== $model->e_instrument)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                  </div>
                                </td>

                                <td>
                                  <div class="input-group">
                                    <input type="text" id="mrank_{{ $loop->iteration }}" name="mrank_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->rank }}" readonly="true"/>
                                    <span class="input-group-btn">
                                        @if($model->rank == $model->e_rank)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->e_rank == null ||$model->e_rank == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->e_rank !== null && $model->rank !== $model->e_rank)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                  </div>
                                </td>

                                <td>
                                  <div class="input-group">
                                    <input type="text" id="mpro_{{ $loop->iteration }}" name="mpro_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->proses }}" readonly="true"/>
                                    <span class="input-group-btn">
                                        @if($model->proses == $model->e_proses)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->e_proses == null ||$model->e_proses == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->e_proses !== null && $model->proses !== $model->e_proses)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                  </div>
                                </td>

                                <td>
                                  <div class="input-group">
                                    <input type="text" id="mdel_{{ $loop->iteration }}" name="mdel_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->delivery }}" readonly="true"/>
                                    <span class="input-group-btn">
                                        @if($model->delivery == $model->e_delivery)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->e_delivery == null ||$model->e_delivery == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->e_delivery !== null && $model->delivery !== $model->e_delivery)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                  </div>
                                </td>

                                <td>
                                  <div class="input-group">
                                    <input type="text" id="mrem_{{ $loop->iteration }}" name="mrem_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->remarks }}" readonly="true"/>
                                    <span class="input-group-btn">
                                        @if($model->remarks == $model->e_remarks)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->e_remarks == null ||$model->e_remarks == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->e_remarks !== null && $model->remarks !== $model->e_remarks)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                  </div>
                                </td>
                              </div>
                            </div>      
                          </tr>
                        @endforeach
                        @else
                    @endif
                  </table>
                </div>
            </div>
            {{-- ====================================== --}}
            <div class="box-body col-md-6">
                <div class="panel-heading" style="background-color:#F0F8FF">
                    <h3 class="panel-title"><b>NOTES  </b></h3>
                </div>
                <div  style="padding:3px;overflow:auto;width:auto;height:200px;">
                  <!-- /.Table Input-->
                  <table class="table table-bordered" id="dynamic_field5" style="width: 1800px;">
                    <tr>
                         <th width="120px" rowspan="2" align="center"><br>NO</th>
                         <th align="middle-center" rowspan="2" width="220px"><br>INSPECTION ITEM</th>
                         <th colspan="2"><p align="center">STANDARD VALUE</p></th>
                         <th rowspan="2" width="200px"><br>&nbsp;INSPECTION INSTRUMENT</th>
                         <th rowspan="2" width="60px"><p align="center"><br> RANK</p></th>
                         <th colspan="2"><p align="center">SAMPLING PLAN</p></th>
                         <th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
                       </tr>
                       <tr>
                         <th width="150px">NOMINAL</th>
                         <th width="150px">TOLERANCE</th>
                         <th width="200px">IN PROSES</th>
                         <th width="220px">AT DELIVERY</th>
                       </tr> 
                   @if (!empty($htreatements->no_pisigp))
                      @foreach ($entity->getLines4($htreatements->no_pisigp)->get() as $model)
                          <tr id="">
                            <div class="">
                              <div class=""> 
                                <td>
                                  <input type="text" id="hno_{{ $loop->iteration }}" name="hno_{{ $loop->iteration }}" placeholder="" class="form-control name_list" readonly="true" value="{{ $model->no }}" align="center"/>
                                </td>

                                <td>
                                  <div class="input-group">
                                  <input type="text" id="e_item_{{ $loop->iteration }}" name="e_item_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->e_item }}" />
                                  </div>
                                </td>

                                <td>
                                  <div class="input-group">
                                    <input type="text" id="e_nominal_{{ $loop->iteration }}" name="e_nominal_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->e_nominal }}"/>
                                  </div>
                                </td>

                                <td>
                                  <input type="text" id="e_tolerance_{{ $loop->iteration }}" name="e_tolerance_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->e_tolerance }}"/>
                                </td>

                                <td>
                                  <input type="text" id="e_instrument_{{ $loop->iteration }}" name="e_instrument_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->e_instrument }}"/>
                                </td>

                                <td>
                                  <input type="text" id="e_rank_{{ $loop->iteration }}" name="e_rank_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->e_rank }}"/>
                                </td>

                                <td>
                                  <input type="text" id="e_proses_{{ $loop->iteration }}" name="e_proses_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->e_proses }}"/>
                                </td>

                                <td>
                                  <input type="text" id="e_delivery_{{ $loop->iteration }}" name="e_delivery_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->e_delivery }}"/>
                                </td>

                                <td>
                                  <input type="text" id="e_remarks_{{ $loop->iteration }}" name="e_remarks_{{ $loop->iteration }}" placeholder="" class="form-control name_list" value="{{ $model->e_remarks }}"/>
                                </td>

                              </div>
                            </div>      
                          </tr>
                        @endforeach
                         {!! Form::hidden('linehidden4', $entity->getLines4($htreatements->no_pisigp)->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'linehidden4']) !!}
                        @else
                         {!! Form::hidden('linehidden4', 0, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'linehidden']) !!}
                    @endif
                  </table>
                </div>
                {{-- <button type="button" name="add5" id="add5" class="btn btn-success">+</button> --}}
            </div>
          </div>
        </div>

      </div>
  </div>
  <!-- {{-- II. APPEARENCE --}} -->
  <div class="panel-body" >
     <div class="box box-primary">
       {{-- II. APPEARENCE --}}
       <div class="panel-heading" style="background-color: #DD4B39">
         <h3 class="panel-title"> II. APPEARENCE </h3>
       </div>
       <div class="panel-body col-md-12">
         <div class="box-body" >
           <div class="col-md-12">
            {{-- ========= --}}
             <div class="box-body col-md-6" >
                 <div class="panel-heading" style="background-color:#F0F8FF">
                    <h3 class="panel-title"><b>OUTPUT</b></h3>
                 </div>
                 <div  style="overflow:auto;width:auto; height:200px;margin:bottom 200px;">
                   <!-- /.Table Input-->
                   <table class="table table-bordered"  style="width: 1800px;">
                     <tr>
                       <th width="120px" rowspan="2" align="center"><br>NO</th>
                       <th align="middle-center" rowspan="2" width="220px"><br>INSPECTION ITEM</th>
                       <th colspan="2"><p align="center">STANDARD VALUE</p></th>
                       <th rowspan="2" width="200px"><br>&nbsp;INSPECTION INSTRUMENT</th>
                       <th rowspan="2" width="60px"><p align="center"><br> RANK</p></th>
                       <th colspan="2"><p align="center">SAMPLING PLAN</p></th>
                       <th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
                     </tr>
                     <tr>
                       <th width="150px">NOMINAL</th>
                       <th width="150px">TOLERANCE</th>
                       <th width="200px">IN PROSES</th>
                       <th width="220px">AT DELIVERY</th>
                     </tr> 
                     @if (!empty($appearences->no_pisigp))
                        @foreach ($entity->getLines5($appearences->no_pisigp)->get() as $model)   
                            <tr id="">
                             <div class="">
                               <div class=""> 
                                 <td>
                                   <input type="text" id="apno_{{ $loop->iteration }}" name="apno_{{ $loop->iteration }}" placeholder="" class="form-control name_list" readonly="true" value="{{ $model->no }}" align="center"/>
                                 </td>

                                 <td>
                                   <div class="input-group">
                                     <input type="text" id="mitem_{{ $loop->iteration }}" name="mitem_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->item }}" readonly="true"/>
                                      <span class="input-group-btn">
                                        @if($model->item == $model->f_item)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->f_item == null ||$model->f_item == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->f_item !== null && $model->item !== $model->f_item)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>

                                   </div>
                                 </td>

                                 <td>
                                   <div class="input-group">
                                     <input type="text" id="mnom_{{ $loop->iteration }}" name="mnom_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->nominal }}" readonly="true"/>
                                     <span class="input-group-btn">
                                        @if($model->nominal == $model->f_nominal)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->f_nominal == null ||$model->f_nominal == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->f_nominal !== null && $model->nominal !== $model->f_nominal)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>

                                   </div>
                                 </td>

                                 <td>
                                  <div class="input-group">
                                   <input type="text" id="mtol_{{ $loop->iteration }}" name="mtol_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->tolerance }}" readonly="true"/>
                                   <span class="input-group-btn">
                                        @if($model->tolerance == $model->f_tolerance)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->f_tolerance == null ||$model->f_tolerance == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->f_tolerance !== null && $model->tolerance !== $model->f_tolerance)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                   </div>
                                 </td>

                                 <td>
                                  <div class="input-group">
                                   <input type="text" id="mins_{{ $loop->iteration }}" name="mins_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->instrument }}" readonly="true"/>
                                   <span class="input-group-btn">
                                        @if($model->instrument == $model->f_instrument)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->f_instrument == null ||$model->f_instrument == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->f_instrument !== null && $model->instrument !== $model->f_instrument)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                   </div>
                                 </td>

                                 <td>
                                  <div class="input-group">
                                   <input type="text" id="mrank_{{ $loop->iteration }}" name="mrank_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->rank }}" readonly="true"/>
                                   <span class="input-group-btn">
                                        @if($model->rank == $model->f_rank)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->f_rank == null ||$model->f_rank == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->f_rank !== null && $model->instrument !== $model->f_rank)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                   </div>
                                 </td>

                                 <td>
                                  <div class="input-group">
                                   <input type="text" id="mpro_{{ $loop->iteration }}" name="mpro_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->proses }}" readonly="true"/>
                                    <span class="input-group-btn">
                                        @if($model->proses == $model->f_proses)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->f_proses == null ||$model->f_proses == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->f_proses !== null && $model->proses !== $model->f_proses)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                   </div>
                                 </td>

                                 <td>
                                  <div class="input-group">
                                   <input type="text" id="mdel_{{ $loop->iteration }}" name="mdel_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->delivery }}" readonly="true"/>
                                    <span class="input-group-btn">
                                        @if($model->delivery == $model->f_delivery)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->f_delivery == null ||$model->f_delivery == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->f_delivery !== null && $model->delivery !== $model->f_delivery)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                   </div>
                                 </td>

                                 <td>
                                  <div class="input-group">
                                   <input type="text" id="mrem_{{ $loop->iteration }}" name="mrem_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->remarks }}" readonly="true"/>
                                   <span class="input-group-btn">
                                        @if($model->remarks == $model->f_remarks)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->f_remarks == null ||$model->f_remarks == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->f_remarks !== null && $model->remarks !== $model->f_remarks)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                   </div>
                                 </td>
                               </div>
                             </div>      
                           </tr>
                         @endforeach
                         @else
                     @endif
                   </table>
                 </div>
             </div>
             {{-- ====================================== --}}
             <div class="box-body col-md-6">
                 <div class="panel-heading" style="background-color:#F0F8FF">
                     <h3 class="panel-title"><b>NOTES  </b></h3>
                 </div>
                 <div  style="padding:3px;overflow:auto;width:auto;height:200px;">
                   <!-- /.Table Input-->
                   <table class="table table-bordered" id="dynamic_field6"  style="width: 1800px;">
                     <tr>
                       <th width="120px" rowspan="2" align="center"><br>NO</th>
                       <th align="middle-center" rowspan="2" width="220px"><br>INSPECTION ITEM</th>
                       <th colspan="2"><p align="center">STANDARD VALUE</p></th>
                       <th rowspan="2" width="200px"><br>&nbsp;INSPECTION INSTRUMENT</th>
                       <th rowspan="2" width="60px"><p align="center"><br> RANK</p></th>
                       <th colspan="2"><p align="center">SAMPLING PLAN</p></th>
                       <th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
                     </tr>
                     <tr>
                       <th width="150px">NOMINAL</th>
                       <th width="150px">TOLERANCE</th>
                       <th width="200px">IN PROSES</th>
                       <th width="220px">AT DELIVERY</th>
                     </tr> 
                     @if (!empty($appearences->no_pisigp))
                        @foreach ($entity->getLines5($appearences->no_pisigp)->get() as $model)  
                           <tr id="">
                             <div class="">
                               <div class=""> 
                                <td>
                                 <input type="text" id="apno_{{ $loop->iteration }}" name="apno_{{ $loop->iteration }}" placeholder="" class="form-control name_list" readonly="true" value="{{ $model->no }}" align="center"/>
                                </td>

                                 <td>
                                   <div class="input-group">
                                   <input type="text" id="f_item_{{ $loop->iteration }}" name="f_item_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->f_item }}" />
                                   </div>
                                 </td>

                                 <td>
                                   <div class="input-group">
                                     <input type="text" id="f_nominal_{{ $loop->iteration }}" name="f_nominal_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->f_nominal }}"/>
                                   </div>
                                 </td>

                                 <td>
                                   <input type="text" id="f_tolerance_{{ $loop->iteration }}" name="f_tolerance_{{ $loop->iteration }}" placeholder="" class="form-control name_list" value="{{ $model->f_tolerance }}"/>
                                 </td>

                                 <td>
                                   <input type="text" id="f_instrument_{{ $loop->iteration }}" name="f_instrument_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->f_instrument }}"/>
                                 </td>

                                 <td>
                                   <input type="text" id="f_rank_{{ $loop->iteration }}" name="f_rank_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->f_rank }}"/>
                                 </td>

                                 <td>
                                   <input type="text" id="f_proses_{{ $loop->iteration }}" name="f_proses_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->f_proses }}"/>
                                 </td>

                                 <td>
                                   <input type="text" id="f_delivery_{{ $loop->iteration }}" name="f_delivery_{{ $loop->iteration }}" placeholder="" class="form-control name_list" value="{{ $model->f_delivery }}"/>
                                 </td>

                                 <td>
                                   <input type="text" id="f_remarks_{{ $loop->iteration }}" name="f_remarks_{{ $loop->iteration }}" placeholder="" class="form-control name_list" value="{{ $model->f_remarks }}"/>
                                 </td>

                               </div>
                             </div>      
                           </tr>
                         @endforeach
                          {!! Form::hidden('linehidden5', $entity->getLines5($appearences->no_pisigp)->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'linehidden5']) !!}
                         @else
                          {!! Form::hidden('linehidden5', 0, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'linehidden']) !!}
                     @endif
                   </table>
                 </div>
                 {{-- <button type="button" name="tambah" id="tambah" class="btn btn-success">+</button> --}}
             </div>
           </div>
         </div>

       </div>
     </div>
  </div>
  <!-- {{-- IIII. DIMENSION--}} -->
  <div class="panel-body" >
      <div class="box box-primary">
        {{-- IIII. DIMENSION --}}
        <div class="panel-heading" style="background-color: #DD4B39">
          <h3 class="panel-title"> III. DIMENSION  </h3>
        </div>
        <div class="panel-body col-md-12">
          <div class="box-body" >
            <div class="col-md-12">
             {{-- ========= --}}
              <div class="box-body col-md-6" >
                  <div class="panel-heading" style="background-color:#F0F8FF">
                     <h3 class="panel-title"><b>OUTPUT</b></h3>
                  </div>
                  <div  style="overflow:auto;width:auto; height:200px;margin:bottom 200px;">
                    <!-- /.Table Input-->
                    <table class="table table-bordered"  style="width: 1800px;">
                      <tr>
                        <th width="120px" rowspan="2" align="center"><br>NO</th>
                        <th align="middle-center" rowspan="2" width="220px"><br>INSPECTION ITEM</th>
                        <th colspan="2"><p align="center">STANDARD VALUE</p></th>
                        <th rowspan="2" width="200px"><br>&nbsp;INSPECTION INSTRUMENT</th>
                        <th rowspan="2" width="60px"><p align="center"><br> RANK</p></th>
                        <th colspan="2"><p align="center">SAMPLING PLAN</p></th>
                        <th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
                      </tr>
                      <tr>
                        <th width="150px">NOMINAL</th>
                        <th width="150px">TOLERANCE</th>
                        <th width="200px">IN PROSES</th>
                        <th width="220px">AT DELIVERY</th>
                      </tr> 
                      @if (!empty($dimentions->no_pisigp))
                         @foreach ($entity->getLines6($dimentions->no_pisigp)->get() as $model)
                            <tr id="">
                              <div class="">
                                <div class=""> 
                                  <td>
                                    <input type="text" id="dno_{{ $loop->iteration }}" name="dno_{{ $loop->iteration }}" placeholder="" class="form-control name_list" readonly="true" value="{{ $model->no }}" align="center"/>
                                  </td>

                                  <td>
                                    <div class="input-group">
                                      <input type="text" id="ditem_{{ $loop->iteration }}" name="ditem_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->item }}" readonly="true"/>
                                       <span class="input-group-btn">
                                        @if($model->item == $model->g_item)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->g_item == null ||$model->g_item == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->g_item !== null && $model->item !== $model->g_item)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>

                                    </div>
                                  </td>

                                  <td>
                                    <div class="input-group">
                                      <input type="text" id="dnominal_{{ $loop->iteration }}" name="dnominal_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->nominal }}" readonly="true"/>
                                      <span class="input-group-btn">
                                        @if($model->nominal == $model->g_nominal)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->g_nominal == null ||$model->g_nominal == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->g_nominal !== null && $model->nominal !== $model->g_nominal)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                    </div>
                                  </td>

                                  <td>
                                   <div class="input-group">
                                    <input type="text" id="dtolerance_{{ $loop->iteration }}" name="dtolerance_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->tolerance }}" readonly="true"/>
                                     <span class="input-group-btn">
                                        @if($model->tolerance == $model->g_tolerance)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->g_tolerance == null ||$model->g_tolerance == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->g_tolerance !== null && $model->tolerance !== $model->g_tolerance)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                    </div>
                                  </td>

                                  <td>
                                   <div class="input-group">
                                    <input type="text" id="dinstrument_{{ $loop->iteration }}" name="dinstrument_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->instrument }}" readonly="true"/>
                                    <span class="input-group-btn">
                                        @if($model->instrument == $model->g_instrument)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->g_instrument == null ||$model->g_instrument == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->g_instrument !== null && $model->instrument !== $model->g_instrument)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                    </div>
                                  </td>

                                  <td>
                                   <div class="input-group">
                                    <input type="text" id="drank_{{ $loop->iteration }}" name="drank_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->rank }}" readonly="true"/>
                                     <span class="input-group-btn">
                                        @if($model->rank == $model->g_rank)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->g_rank == null ||$model->g_rank == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->g_rank !== null && $model->rank !== $model->g_rank)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                    </div>
                                  </td>

                                  <td>
                                   <div class="input-group">
                                    <input type="text" id="dproses_{{ $loop->iteration }}" name="dproses_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->proses }}" readonly="true"/>
                                     <span class="input-group-btn">
                                        @if($model->proses == $model->g_proses)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->g_proses == null ||$model->g_proses == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->g_proses !== null && $model->proses !== $model->g_proses)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                    </div>
                                  </td>

                                  <td>
                                   <div class="input-group">
                                    <input type="text" id="ddelivery_{{ $loop->iteration }}" name="ddelivery_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->delivery }}" readonly="true"/>
                                     <span class="input-group-btn">
                                        @if($model->delivery == $model->g_proses)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->g_proses == null ||$model->g_proses == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->g_proses !== null && $model->delivery !== $model->g_proses)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                    </div>
                                  </td>

                                  <td>
                                   <div class="input-group">
                                    <input type="text" id="dremarks_{{ $loop->iteration }}" name="dremarks_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->remarks }}" readonly="true"/>
                                    <span class="input-group-btn">
                                        @if($model->remarks == $model->g_remarks)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->g_remarks == null ||$model->g_remarks == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->g_remarks !== null && $model->remarks !== $model->g_remarks)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                    </div>
                                  </td>

                                 {{--  <td>
                                    <button id="dline_btndelete_{{ $loop->iteration }}" name="dline_btndelete_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" onclick="deleteLine(this)">
                                      <i class="fa fa-times"></i>
                                    </button>
                                  </td> --}}
                                </div>
                              </div>      
                            </tr>
                          @endforeach
                          @else
                      @endif
                    </table>
                  </div>
              </div>
              {{-- ====================================== --}}
              <div class="box-body col-md-6">
                  <div class="panel-heading" style="background-color:#F0F8FF">
                      <h3 class="panel-title"><b>NOTES  </b></h3>
                  </div>
                  <div  style="padding:3px;overflow:auto;width:auto;height:200px;">
                    <!-- /.Table Input-->
                   <table class="table table-bordered" id="dynamic_field7" style="width: 1800px;">
                      <tr>
                        <th width="120px" rowspan="2" align="center"><br>NO</th>
                        <th align="middle-center" rowspan="2" width="220px"><br>INSPECTION ITEM</th>
                        <th colspan="2"><p align="center">STANDARD VALUE</p></th>
                        <th rowspan="2" width="200px"><br>&nbsp;INSPECTION INSTRUMENT</th>
                        <th rowspan="2" width="60px"><p align="center"><br> RANK</p></th>
                        <th colspan="2"><p align="center">SAMPLING PLAN</p></th>
                        <th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
                      </tr>
                      <tr>
                        <th width="150px">NOMINAL</th>
                        <th width="150px">TOLERANCE</th>
                        <th width="200px">IN PROSES</th>
                        <th width="220px">AT DELIVERY</th>
                      </tr> 
                     @if (!empty($dimentions->no_pisigp))
                       @foreach ($entity->getLines6($dimentions->no_pisigp)->get() as $model)
                            <tr id="">
                              <div class="">
                                <div class=""> 
                                <td>
                                    <input type="text" id="dno_{{ $loop->iteration }}" name="dno_{{ $loop->iteration }}" placeholder="" class="form-control name_list" readonly="true" value="{{ $model->no }}" align="center"/>
                                  </td>

                                  <td>
                                    <div class="input-group">
                                    <input type="text" id="g_item_{{ $loop->iteration }}" name="g_item_{{ $loop->iteration }}" placeholder="" class="form-control name_list" value="{{ $model->g_item }}" />
                                    </div>
                                  </td>

                                  <td>
                                    <div class="input-group">
                                      <input type="text" id="g_nominal_{{ $loop->iteration }}" name="g_nominal_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->g_nominal }}"/>
                                    </div>
                                  </td>

                                  <td>
                                    <input type="text" id="g_tolerance_{{ $loop->iteration }}" name="g_tolerance_{{ $loop->iteration }}" placeholder="" class="form-control name_list" value="{{ $model->g_tolerance }}"/>
                                  </td>

                                  <td>
                                    <input type="text" id="g_instrument_{{ $loop->iteration }}" name="g_instrument_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->g_instrument }}"/>
                                  </td>

                                  <td>
                                    <input type="text" id="g_rank_{{ $loop->iteration }}" name="g_rank_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->g_rank }}"/>
                                  </td>

                                  <td>
                                    <input type="text" id="g_proses_{{ $loop->iteration }}" name="g_proses_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->g_proses }}"/>
                                  </td>

                                  <td>
                                    <input type="text" id="g_delivery_{{ $loop->iteration }}" name="g_delivery_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->g_delivery }}"/>
                                  </td>

                                  <td>
                                    <input type="text" id="g_remarks_{{ $loop->iteration }}" name="g_remarks_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->g_remarks }}"/>
                                  </td>

                                </div>
                              </div>      
                            </tr>
                          @endforeach
                           {!! Form::hidden('linehidden6', $entity->getLines6($dimentions->no_pisigp)->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'linehidden6']) !!}
                          @else
                           {!! Form::hidden('linehidden6', 0, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'linehidden']) !!}
                      @endif
                    </table>
                    {{-- {!! Form::hidden('jml_input1', 1, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_input1']) !!} --}}
                  </div>
                  {{-- <button type="button" name="dimention" id="dimention" class="btn btn-success">+</button> --}}
              </div>
            </div>
          </div>

        </div>
      </div>
  </div>
  <!-- {{-- IV. SOC FREE--}} -->
  <div class="panel-body" >
       <div class="box box-primary">
         {{-- IV. SOC FREE --}}
         <div class="panel-heading" style="background-color: #DD4B39">
           <h3 class="panel-title"> IV. SOC FREE</h3>
         </div>
         <div class="panel-body col-md-12">
           <div class="box-body" >
             <div class="col-md-12">
                  {{-- ============= --}}
               <div class="box-body col-md-6" >
                   <div class="panel-heading" style="background-color:#F0F8FF">
                      <h3 class="panel-title"><b>OUTPUT</b></h3>
                   </div>
                   <div  style="overflow:auto;width:auto; height:200px;margin:bottom 200px;">
                     <!-- /.Table Input-->
                    <table class="table table-bordered" style="width: 1000px;">
                       <tr>
                         <th width="100px">NO.</th>
                         <th width="300px"><center>INSPECTION ITEM</center></th>
                         <th width="300px"><center>STANDARD VALUE</center></th>
                         <th width="300px"><center>I.INSTRUMENT<center></th>
                         <th width="300px"><center>RANK</center></th>
                         <th width="300px"><center>SAMPLING PLAN</center></th>
                         <th width="300px"><center>REMARKS</center></th>
                         {{-- <th width="50px">Hapus</th> --}}
                       </tr> 
                       @if (!empty($socfs->no_pisigp))
                         @foreach ($entity->getLines7($socfs->no_pisigp)->get() as $model)
                           <tr id="line_field8_{{ $loop->iteration }}">
                             <div class="">
                               <div class=""> 
                                 <td>
                                   <input type="text" id="scno_{{ $loop->iteration }}" name="scno_{{ $loop->iteration }}" placeholder="" class="form-control name_list" readonly="true" value="{{ $model->no }}" align="center"/>
                                 </td>

                                 <td>
                                   <div class="input-group">
                                     <input type="text" id="scitem_{{ $loop->iteration }}" name="scitem_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->item }}" readonly="true"/>
                                      <span class="input-group-btn">
                                        @if($model->item == $model->h_item)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->h_item == null ||$model->h_item == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->h_item !== null && $model->item !== $model->h_item)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>

                                   </div>
                                 </td>

                                 <td>
                                 <div class="input-group">
                                   <input type="text" id="scinstrument_{{ $loop->iteration }}" name="scinstrument_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->instrument }}" readonly="true"/>
                                   <span class="input-group-btn">
                                        @if($model->instrument == $model->h_instrument)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->h_instrument == null ||$model->h_instrument == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->h_instrument !== null && $model->instrument !== $model->h_instrument)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                   </div>
                                 </td>

                                 <td>
                                 <div class="input-group">
                                   <input type="text" id="scrank_{{ $loop->iteration }}" name="scrank_{{ $loop->iteration }}" placeholder="" class="form-control name_list" value="{{ $model->rank }}" readonly="true"/>
                                   <span class="input-group-btn">
                                        @if($model->rank == $model->h_rank)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->h_rank == null ||$model->h_rank == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->h_rank !== null && $model->rank !== $model->h_rank)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                   </div>
                                 </td>

                                 <td>
                                 <div class="input-group">

                                   <input type="text" id="scproses_{{ $loop->iteration }}" name="scproses_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->proses }}" readonly="true"/>
                                   <span class="input-group-btn">
                                        @if($model->proses == $model->h_proses)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->h_proses == null ||$model->h_proses == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->h_proses !== null && $model->proses !== $model->h_proses)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                   </div>
                                 </td>

                                 <td>
                                 <div class="input-group">

                                   <input type="text" id="scdeivery_{{ $loop->iteration }}" name="scdeivery_{{ $loop->iteration }}" placeholder="" class="form-control name_list" value="{{ $model->delivery }}" readonly="true"/>
                                    <span class="input-group-btn">
                                        @if($model->delivery == $model->h_delivery)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->h_delivery == null ||$model->h_delivery == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->h_delivery !== null && $model->delivery !== $model->h_delivery)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                   </div>
                                 </td>

                                 <td>
                                 <div class="input-group">
                                   <input type="text" id="scremarks_{{ $loop->iteration }}" name="scremarks_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->remarks }}" readonly="true"/>
                                    <span class="input-group-btn">
                                        @if($model->remarks == $model->h_remarks)
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->h_remarks == null ||$model->h_remarks == "")
                                          <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-check"></i></span>
                                          </button>
                                        @elseif($model->h_remarks !== null && $model->remarks !== $model->h_remarks)
                                          <button id="" name="" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="">
                                            <span ><i class="fa fa-remove"></i></span>
                                          </button>
                                        @endif
                                     </span>
                                   </div>
                                 </td>
                               </div>
                             </div>      
                           </tr>
                         @endforeach
                       @else
                       @endif 
                     </table>
                   </div>
               </div>
               {{-- ====================================== --}}
               <div class="box-body col-md-6">
                   <div class="panel-heading" style="background-color:#F0F8FF">
                       <h3 class="panel-title"><b>NOTES  </b></h3>
                   </div>
                   <div  style="padding:3px;overflow:auto;width:auto;height:200px;">
                       <!-- /.Table Input-->
                     <table class="table table-bordered" id="dynamic_field8" style="width: 1000px;">
                       <tr>
                         <th width="100px">NO.</th>
                         <th width="300px"><center>INSPECTION ITEM</center></th>
                         <th width="300px"><center>STANDARD VALUE</center></th>
                         <th width="300px"><center>I.INSTRUMENT<center></th>
                         <th width="300px"><center>RANK</center></th>
                         <th width="300px"><center>SAMPLING PLAN</center></th>
                         <th width="300px"><center>REMARKS</center></th>
                         {{-- <th width="50px">Hapus</th> --}}
                       </tr> 
                        @if (!empty($socfs->no_pisigp))
                           @foreach ($entity->getLines7($socfs->no_pisigp)->get() as $model)
                             <tr id="">
                               <div class="">
                                 <div class=""> 
                                  <td>
                                   <input type="text" id="scno_{{ $loop->iteration }}" name="scno_{{ $loop->iteration }}" placeholder="" class="form-control name_list" readonly="true" value="{{ $model->no }}" align="center"/>
                                 </td>

                                 <td>
                                   <div class="input-group">
                                     <input type="text" id="h_item_{{ $loop->iteration }}" name="h_item_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->h_item }}" />

                                   </div>
                                 </td>

                                 <td>
                                   <input type="text" id="h_instrument_{{ $loop->iteration }}" name="h_instrument_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->h_instrument }}"/>
                                 </td>

                                 <td>
                                   <input type="text" id="h_rank_{{ $loop->iteration }}" name="h_rank_{{ $loop->iteration }}" placeholder="" class="form-control name_list" value="{{ $model->h_rank }}"/>
                                 </td>

                                 <td>
                                   <input type="text" id="h_proses_{{ $loop->iteration }}" name="h_proses_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->h_proses }}"/>
                                 </td>

                                 <td>
                                   <input type="text" id="h_delivery_{{ $loop->iteration }}" name="h_delivery_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->h_delivery }}"/>
                                 </td>

                                 <td>
                                   <input type="text" id="h_remarks_{{ $loop->iteration }}" name="h_remarks_{{ $loop->iteration }}" placeholder="" class="form-control name_list"  value="{{ $model->h_remarks }}"/>
                                 </td>

                                 </div>
                               </div>      
                             </tr>
                           @endforeach
                            {!! Form::hidden('linehidden7', $entity->getLines7($socfs->no_pisigp)->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'linehidden7']) !!}
                           @else
                            {!! Form::hidden('linehidden7', 0, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'linehidden']) !!}
                       @endif
                     </table>
                     
                   </div>
                 {{-- <button type="button" name="socfree" id="socfree" class="btn btn-success">+</button> --}}
               </div>
             </div>
           </div>

         </div>
       </div>
  </div>

    {{-- V. PART ROUTING--}}
  <div class="panel-body" >
    <div class="box box-primary">
      {{-- V. PART ROUTING --}}
      <div class="panel-heading" style="background-color: #FF6347">
        <h3 class="panel-title"> V. PART ROUTING</h3>
      </div>
      <div class="panel-body col-md-12">
        <div class="box-body" >
          <div class="col-md-12">
           {{-- ========= --}}
            <div class="box-body col-md-12" >
                <div class="panel-heading" style="background-color:#F0F8FF">
                   <h3 class="panel-title"><b>OUTPUT</b></h3>
                </div>
                <div  style="">
                  <!-- /.Table Input-->
                 <table class="table table-bordered" style="width: 100%;">
                   <tr>
                     <td colspan="12">
                      <table  cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                          <td colspan="12" height="250" >
                            <center>
                              @if($pistandards->part_routing!="")
                                <img src="{{$part_routing }}" width="20%" style="height: 500px;">
                              @endif
                            </center>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  </table>
                </div>
            </div>
            {{-- ====================================== --}}
            <div class="box-body col-md-12">
                <div class="panel-heading" style="background-color:#F0F8FF">
                    <h3 class="panel-title"><b>NOTES  </b></h3>
                </div>
                <div  style="">
                    <!-- /.Table Input-->
                  {!! Form::textarea('c_partrouting', null, ['class'=>'form-control']) !!}
                </div>
              
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  {{-- Skecth Drawing --}}
  <div class="panel-body" >
    <div class="box box-primary">
      {{-- Skecth Drawing --}}
      <div class="panel-heading" style="background-color: #FF6347">
        <h3 class="panel-title"> SKETCH DRAWING</h3>
      </div>
      <div class="panel-body col-md-12">
         {{-- SKETCH DRAWING WITH BALON: --}}
        <div class="box-body" >
          <div class="col-md-12">
           {{-- Gambar--}}
            <div class="box-body col-md-12" >
                <div class="panel-heading" style="background-color:#F0F8FF">
                   <h3 class="panel-title"><b>SKETCH DRAWING WITH BALON:</b></h3>
                </div>
                <div  style="">
                  <!-- /.Table Input-->
                 <table class="table table-bordered" style="width: 100%;">
                   <tr>
                     <td colspan="12">
                      <table  cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                          <td colspan="12" height="250" >
                            <center>
                              @if($pistandards->sketchdrawing!="")
                                <img src="{{$sketchdrawing }}" width="20%" style="height: 500px;">
                              @endif
                            </center>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  </table>
                </div>
            </div>
            {{-- Catatan --}}
            <div class="box-body col-md-12">
                <div class="panel-heading" style="background-color:#F0F8FF">
                    <h3 class="panel-title"><b>NOTES  </b></h3>
                </div>
                <div  style="">
                    <!-- /.Table Input-->
                  {!! Form::textarea('c_skecthdrawing', null, ['class'=>'form-control']) !!}
                </div>
              
            </div>
          </div>
        </div>
          {{-- SKETCH SPECIAL MEASURING METHODE (IF ANY) --}}
        <div class="box-body" >
          <div class="col-md-12">
           {{-- ========= --}}
            <div class="box-body col-md-12" >
                <div class="panel-heading" style="background-color:#F0F8FF">
                   <h3 class="panel-title"><b>SKETCH SPECIAL MEASURING METHODE (IF ANY)</b></h3>
                </div>
                <div  style="">
                  <!-- /.Table Input-->
                 <table class="table table-bordered" style="width: 100%;">
                   <tr>
                     <td colspan="12">
                      <table  cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                          <td colspan="12" height="250" >
                            <center>
                              @if($pistandards->sketchmmethode!="")
                               <img src="{{$sketchmmethode }}" width="50%" style="height: 500px;">
                              @endif
                            </center>
                          </td>
                        </tr>
                      </table>
                    </td>
                    </tr>
                 </table>
                </div>
            </div>
            {{-- ====================================== --}}
            <div class="box-body col-md-12">
                <div class="panel-heading" style="background-color:#F0F8FF">
                    <h3 class="panel-title"><b>NOTES  </b></h3>
                </div>
                <div  style="">
                    <!-- /.Table Input-->
                  {!! Form::textarea('c_sketchmethod', null, ['class'=>'form-control']) !!}
                </div>
              
            </div>
          </div>
        </div>

        {{-- SKETCH APPEARANCE/PRODUCTION CODE --}}
        <div class="box-body" >
          <div class="col-md-12">
           {{-- ========= --}}
            <div class="box-body col-md-12" >
                <div class="panel-heading" style="background-color:#F0F8FF">
                   <h3 class="panel-title"><b>SKETCH APPEARANCE/PRODUCTION CODE</b></h3>
                </div>
                <div  style="">
                  <!-- /.Table Input-->
                 <table class="table table-bordered" style="width: 100%;">
                   <tr>
                     <td colspan="12">
                      <table  cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                          <td colspan="12" height="250px" > 
                            <center>
                              @if($pistandards->sketchappearance!="")
                                <img src="{{$sketchappearance }}" width="50%" style="height: 500px;">
                              @endif
                            </center>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  </table>
                </div>
            </div>
            {{-- ====================================== --}}
            <div class="box-body col-md-12">
                <div class="panel-heading" style="background-color:#F0F8FF">
                    <h3 class="panel-title"><b>NOTES  </b></h3>
                </div>
                <div  style="">
                    <!-- /.Table Input-->
                  {!! Form::textarea('c_sketchappearence', null, ['class'=>'form-control']) !!}
                </div>
              
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  {{-- UPLOAD ELEKTRONIK SIGN--}}
  <div class="panel-body" >
    <div class="box box-primary">
      {{-- UPLOAD ELEKTRONIK SIGN --}}
      <div class="panel-heading" style="background-color: #FF6347">
        <h3 class="panel-title"> UPLOAD ELEKTRONIK SIGN </h3>
      </div>
      <div class="panel-body col-md-12">
        <div class="box-body" >
          <div class="col-md-12">
           {{-- ========= --}}
            <div class="form-group">
              {!! Form::label('approve_staff ', 'UPLOAD TTD', ['class'=>'col-md-2 control-label']) !!}
              <div class="col-md-4">
                   {!! Form::file('approve_staff') !!}
                   {!! $errors->first('approve_staff', '<p class="help-block">:message</p>') !!}
              </div>
            </div>
            
             <br>
             <br>

             <div class="form-group">
               <div class="col-md-2">
                 {!! Form::label('notestaff', 'NAMA', ['class'=>'col-md-2 control-label']) !!}
               </div>
               <div class="col-md-4">
                 {!! Form::text('igpstaff_nm', null, ['class'=>'form-control']) !!}
               </div>
             </div>

              {!! Form::hidden('no_pisigp', null, ['class'=>'form-control']) !!}
             {!! Form::hidden('norev', null, ['class'=>'form-control']) !!}
          </div>
        </div>

      </div>
    </div>
  </div>


   <div class="box-footer col-md-12">
              {!! Form::submit('SUBMIT', ['class'=>'btn btn-success', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'SUBMIT TO NEXT PROCESS']) !!}
              &nbsp;&nbsp;
              <a class="btn btn-danger" href="{{ route('pisstaff.aprovalstaf') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Staff Approval" id="btn-cancel">Back</a>
              &nbsp;&nbsp;
   </div>

</div>



@section('scripts')
  <script type="text/javascript">
    // generaltol\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    $("#addLine").click(function(){
    var jml_general = document.getElementById("jml_general").value.trim();
    jml_general = Number(jml_general) + 1;
    document.getElementById("jml_general").value = jml_general;
    var c_generaltol  = 'c_generaltol_'+jml_general;
    var id_field = 'line_field_'+jml_general;
    var button_id = 'button_id'+jml_general;

    $("#id_field").append(
           '<div class="form-group" id="'+id_field+'">\
              <div class="col-sm-12 {{ $errors->has('generaltol') ? ' has-error' : '' }}">\
                 <div class="col-sm-12 {{ $errors->has('generaltol') ? ' has-error' : '' }}">\
                    <div class="input-group" >\
                     {!! Form::text('c_generaltol[]',null, ['class'=>'form-control name_list',]) !!}\
                      <span class="input-group-btn">\
                        <button id="' + button_id + '" name="' + button_id + '" type="button" class="btn btn-info " data-toggle="tooltip" data-placement="top" title="">\
                          <span ><i class="">+</i></span>\
                        </button>\
                      </span>\
                    </div>\
                  </div>\
              </div>\
            </div>'
        );

  });

  </script>
@endsection