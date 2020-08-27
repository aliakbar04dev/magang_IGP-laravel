
  <!DOCTYPE html>
  <html>
      <body>
	      <style>
		        .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
		          border: 1px solid #000000;
		        }
		        img {
		          width: 100%;
		          height: auto;
		        }
	      </style>
	   
	      <div class="row">
	            <div class="col-md-12">
	                   <div class="panel panel-default">	                          
	                        <div class="box-body" >
		                            <div class="col-md-12">
		                              
		                              <div class="box-body col-md-6">
		                                <div class="panel-heading" style="background-color:#F0F8FF">
		                                  <h3 class="panel-title"><b></b></h3>
		                                </div>
		                              
		                                <!-- /.LOGO-->
		                                <div class="col-sm-12">
		                                  <div class="col-sm-12 {{ $errors->has('creaby') ? ' has-error' : '' }}">
		                                      {!! Form::label('no_pis', 'LOGO SUPPLIER') !!}
		                                      <div class="input-group ">
		                                            {!! Form::file('logo_supplier') !!}
		                                      </div>
		                                      {!! $errors->first('c_model', '<p class="help-block">:message</p>') !!}
		                                  </div>
		                                </div>
		                               	 <!-- /.PIS NO-->
		                                <div class="col-sm-12">
		                                  <div class="col-sm-12 {{ $errors->has('tgl_doc') ? ' has-error' : '' }}">
		                                      {!! Form::label('PIS NO:', '') !!}
		                                      <div class="input-group">
		                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
		                                        {!! Form::text('no_pis', null, ['class'=>'form-control','required']) !!}
		                                        {!! $errors->first('no_pis', '<p class="help-block">:message</p>') !!}
		                                      </div>
		                                  </div>
		                                </div>
		                                 <!-- /.SUPPLIER NAME-->
		                                <div class="form-group"  id="">
		                                  <div class="col-sm-12">
		                                    <div class="col-sm-12 {{ $errors->has('tgl_doc') ? ' has-error' : '' }}">
		                                      {!! Form::label('SUPPLIER NAME:', '') !!}
		                                      <div class="input-group">
		                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
		                                        {{-- {!! Form::text('nama_supplier', null, ['class'=>'form-control','required' ]) !!} --}}
		                                        {!! Form::text('nama_supplier', Auth::user()->name, ['class'=>'form-control', 'readonly' => 'readonly']) !!}
		                                        {!! Form::hidden('email', Auth::user()->email, ['class'=>'form-control', ]) !!}
		                                        {!! Form::hidden ('kd_supp', Auth::user()->kd_supp, ['class'=>'form-control', ]) !!}
		                                        {!! $errors->first('nama_supplier', '<p class="help-block">:message</p>') !!}
		                                      </div>
		                                    </div>
		                                  </div>
		                                </div>
		                                <!-- /.DATE OF ISSUED -->
		                                <div class="form-group"  id="">
		                                  <div class="col-sm-12">
		                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
		                                      <div class="col-md-12">
		                                        {!! Form::label('DATE OF ISSUED:', '') !!}
		                                      </div>
		                                      <div class="col-md-12">
		                                        <div class="input-group">
		                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

		                                          @if(!empty($pistandard->date_issue)) 
		                                          {!! Form::date('date_issue', \Carbon\Carbon::parse($pistandard->date_issue), ['class'=>'form-control ']) !!}
		                                          @else 
		                                          {!! Form::date('date_issue', \Carbon\Carbon::now(), ['class'=>'form-control ']) !!}
		                                          @endif
		                                          {!! $errors->first('date_issue', '<p class="help-block">:message</p>') !!}
		                                        </div>
		                                      </div>

		                                    </div>
		                                  </div>
		                                </div>
		                                <!-- /.MODEL -->
		                                <div class="form-group"  id="">
		                                  <div class="col-sm-12">
		                                    <div class="col-sm-12 {{ $errors->has('tgl_doc') ? ' has-error' : '' }}">
		                                      {!! Form::label('MODEL:', '') !!}
		                                      <div class="input-group">
		                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
		                                        {!! Form::text('model', null, ['class'=>'form-control','required' ]) !!}
		                                        {!! $errors->first('tgl_doc', '<p class="help-block">:message</p>') !!}
		                                      </div>
		                                    </div>
		                                  </div>
		                                </div>
		                                <!-- /.REFF. NO-->
		                                <div class="form-group"  id="">
		                                  <div class="col-sm-12">
		                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
		                                      <div class="col-md-12">
		                                        {!! Form::label('REFF. NO:', '') !!}
		                                      </div>
		                                      <div class="col-md-12">
		                                        <div class="input-group">
		                                          <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
		                                          {!! Form::text('reff_no', null, ['class'=>'form-control','required' ]) !!}
		                                          {!! $errors->first('reff_no', '<p class="help-block">:message</p>') !!}
		                                        </div>
		                                      </div>
		                                    </div>  
		                                  </div>
		                                </div>
		                                  <!-- /.PT.IGP'. -->
		                                <div class="form-group"  id="">
		                                  <div class="col-sm-12">
		                                    <div class="col-sm-12 {{ $errors->has('tgl_doc') ? ' has-error' : '' }}">
		                                      {!! Form::label('PT.IGP', '') !!}
		                                      <div class="input-group">
		                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
		                                        {!! Form::text('deptigp', 'QUALITY ASSURANCE DIVISION', ['class'=>'form-control','readonly' => 'readonly']) !!}
		                                        {!! $errors->first('no_pis', '<p class="help-block">:message</p>') !!}
		                                      </div>
		                                    </div>

		                                  </div>
		                                </div>


		                                
		                              </div>
		                              {{-- ===================================================================================================================================================== --}}
		                             <div class="box-body col-md-6">
		                                <div class="panel-heading" style="background-color:#F0F8FF">
		                                   <h3 class="panel-title"><b></b></h3>
		                                </div>

		                                  <!-- /.MATERIAL-->
		                                <div class="form-group"  id="">
		                                  <div class="col-sm-12">
		                                    <div class="col-sm-12 {{ $errors->has('tgl_doc') ? ' has-error' : '' }}">
		                                      {!! Form::label('MATERIAL:', '') !!}
		                                      <div class="input-group">
		                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
		                                        {!! Form::text('material', null, ['class'=>'form-control','required' ]) !!}
		                                        {!! $errors->first('material', '<p class="help-block">:message</p>') !!}
		                                      </div>
		                                    </div>
		                                  </div>
		                                </div>
		                      
		                                <!-- /.GENERAL TOL-->
		                                <div class="form-group"  id="id_field">
		                                  <div class="col-sm-12">
		                                    <div class="form-group" id="id_field">
		                                      <div class="col-sm-12 {{ $errors->has('tgl_doc') ? ' has-error' : '' }}">
		                                        {!! Form::label('GENERAL TOL:', '') !!}
		                                        <div class="input-group">
		                                          <input type="text"  name="generaltol[]" required class="form-control"  maxlength="40" value="" >
		                                          <span class="input-group-btn">
		                                            <button id="addLine" name="addLine" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Add Column">
		                                              <span >+</span>
		                                            </button>
		                                          </span>
		                                        </div>
		                                        {!! $errors->first('general_tol', '<p class="help-block">:message</p>') !!} 
		                                      </div>
		                                    </div>
		                                    {!! Form::hidden('jml_general', 1, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_general']) !!}

		                                  </div>
		                                </div>
		                                <!-- /.WEIGHT-->
		                                <div class="form-group"  id="">
		                                  <div class="col-sm-12">
		                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
		                                      <div class="col-md-12">
		                                        {!! Form::label('WEIGHT:', '') !!}
		                                      </div>
		                                      <div class="col-md-12">
		                                        <div class="input-group">
		                                          <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
		                                          {!! Form::text('weight', null, ['class'=>'form-control' ,'required' ]) !!}
		                                          {!! $errors->first('weight', '<p class="help-block">:message</p>') !!}
		                                        </div>
		                                      </div>

		                                    </div>
		                                  </div>
		                                </div>
		                                <!-- /.PART NO-->
		                                <div class="form-group"  id="">
		                                  <div class="col-sm-12">
		                                    <div class="col-sm-12 {{ $errors->has('tgl_doc') ? ' has-error' : '' }}">
		                                      {!! Form::label('PART NO:', '') !!}
		                                      <div class="input-group">
		                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
		                                        {!! Form::text('part_no', null, ['class'=>'form-control','required' ]) !!}
		                                        {!! $errors->first('part_no', '<p class="help-block">:message</p>') !!}
		                                      </div>
		                                    </div>
		                                  </div>
		                                </div>
		                                <!-- /.PART NAME-->
		                                <div class="form-group"  id="">
		                                  <div class="col-sm-12">
		                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
		                                      <div class="col-md-12">
		                                        {!! Form::label('PART NAME:', '') !!}
		                                      </div>
		                                      <div class="col-md-12">
		                                        <div class="input-group">
		                                          <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
		                                          {!! Form::text('part_name', null, ['class'=>'form-control','required' ]) !!}
		                                          {!! $errors->first('part_name', '<p class="help-block">:message</p>') !!}
		                                        </div>
		                                      </div>

		                                    </div>  
		                                  </div>
		                                </div>
		                                <!-- /.Draft/Final-->
		                                <div class="form-group"  id="">
		                                  <div class="col-sm-12">
		                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
		                                      <div class="col-md-12">
		                                        {!! Form::label('Draft/Final:', '') !!}
		                                      </div>
		                                      <div class="col-md-12">
		                                        <div class="input-group">
		                                          <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
		                                          {!! Form::select('status_doc', ['Final' => 'FINAL', 'Draft' => 'DRAFT'], null, ['class'=>'form-control js-selectize','placeholder' => 'Pilih Draft/Final', 'required']) !!}
		                                          {!! $errors->first('part_name', '<p class="help-block">:message</p>') !!}
		                                        </div>
		                                      </div>

		                                    </div>  
		                                  </div>
		                                </div>
		                                <!-- /.SUPPLIER DEPT-->
		                                <div class="form-group"  id="">
		                                  <div class="col-sm-12">
		                                    <div class="col-sm-12 {{ $errors->has('tgl_doc') ? ' has-error' : '' }}">
		                                      {!! Form::label('SUPPLIER DEPT.', '') !!}
		                                      <div class="input-group">
		                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
		                                        {!! Form::text('supp_dept', null, ['class'=>'form-control','required']) !!}
		                                        {!! $errors->first('supp_dept', '<p class="help-block">:message</p>') !!}
		                                      </div>
		                                    </div>
		                                  </div>
		                                </div>
		                             </div>
		                            </div>
	                        </div>
	                        {{-- A. CHEMICAL COMPOSITION --}}
	                        <div class="panel-body" >
	                              <div class="box box-primary">

	                                <div class="panel-heading" style="background-color: #FF6347">
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
	                                      <div class="box-body col-md-12" >
	                                          <div class="panel-heading" style="background-color:#F0F8FF">
	                                             <h3 class="panel-title"><b></b></h3>
	                                          </div>
	                                          <div  style="overflow:auto;width:auto; height:200px;margin:bottom 200px;">
	                                            <!-- /.Table Input-->
	                                            <table class="table order-list table-bordered" id="dynamic_field1">
	                                            	<tr>
	                                            		<th rowspan="2" align="center" width="60px"><br>NO.&nbsp;&nbsp;&nbsp;&nbsp;</th>
	                                            		<th align="center" rowspan="2" width="220px" ><br><p align="center">INSPECTION ITEM</p></th>
	                                            		<th colspan="2"><p align="center">STANDARD VALUE</p></th>
	                                            		<th rowspan="2" align="midle-center" width="200px"><br><p align="center">I.INSTRUMENT</p></th>
	                                            		<th rowspan="2" width="60px"><p align="center"><br>RANK</p></th>
	                                            		<th colspan="2"><p align="center">SAMPLING PLAN</p></th>
	                                            		<th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
	                                            		<th width="20px" rowspan="2"><p align="center"><br>Hapus</p></th>
	                                            	</tr>
	                                            	<tr>
	                                            		<th width="150px"><p align="center">NOMINAL</p></th>
	                                            		<th width="150px"><p align="center">TOLERANCE</p></th>
	                                            		<th width="200px"><p align="center">IN PROSES</p></th>
	                                            		<th width="220px"><p align="center">AT DELIVERY</p></th>
	                                            	</tr> 
	                                            	<tr id="line_field1">
	                                            		<div class="box-body col-md-3">
	                                            			<div class="form-group"> 
	                                            				<td >
	                                            					<input type="text" id="cno_1" name="cno_1" placeholder="" class="form-control name_list"  value="1" align="center"/>
	                                            				</td>

	                                            				<td>
	                                            					<input type="text" id="citem_1" name="citem_1" placeholder="" class="form-control name_list"  value="" />
	                                            				</td>

	                                            				<td>
	                                            					<input type="text" id="cnom_1" name="cnom_1" placeholder="" class="form-control name_list" value=""/>
	                                            				</td>

	                                            				<td>
	                                            					<input type="text" id="ctol_1" name="ctol_1" placeholder="" class="form-control name_list" value=""/>
	                                            				</td>

	                                            				<td>
	                                            					<input type="text" id="cins_1" name="cins_1" placeholder="" class="form-control name_list" value=""/>
	                                            				</td>

	                                            				<td>
	                                            					<input type="text" id="crank_1" name="crank_1" placeholder="" class="form-control name_list" value=""/>
	                                            				</td>

	                                            				<td>
	                                            					<input type="text" id="cpro_1" name="cpro_1" placeholder="" class="form-control name_list" value=""/>
	                                            				</td>

	                                            				<td>
	                                            					<input type="text" id="cdel_1" name="cdel_1" placeholder="" class="form-control name_list" value=""/>
	                                            				</td>

	                                            				<td>
	                                            					<input type="text" id="crem_1" name="crem_1" placeholder="" class="form-control name_list" value=""/>
	                                            				</td>

	                                            				<td>
	                                            					<button id="cbtndelete_1" name="cbtndelete_1" type="button" class="btn btn-danger btn-sm" onclick="deleteLine(this)">
	                                            						<i class="fa fa-times"></i>
	                                            					</button>
	                                            				</td>
	                                            			</div>    
	                                            		</div>      
	                                            	</tr>
	                                            </table>
	                                            {!! Form::hidden('jml_line1', 1, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_line1']) !!}
	                                          </div>
	                                          <button type="button" name="add1" id="add1" class="btn btn-success">+</button>  
	                                      </div>
	                                                 {{-- ====================================== --}}

	                                    </div>
	                                  </div>

	                                </div>

	                              </div>
	                        </div>
	                        {{-- B.MECHANICAL PROPERTIES --}}
	                        <div class="panel-body" >
		                          	{{-- B.MECHANICAL PROPERTIES --}}
		                          	<div class="panel-heading" style="background-color:#F0F8FF" >
		                          		<h3 class="panel-title">B.MECHANICAL PROPERTIES</h3>
		                          	</div>
		                          	<div class="panel-body col-md-12">
		                          		<div class="box-body" >
		                          			<div class="col-md-12">
		                          				{{-- ========= --}}
		                          				<div class="box-body col-md-12" >
		                          					<div class="panel-heading" style="background-color:#F0F8FF">
		                          						<h3 class="panel-title"><b></b></h3>
		                          					</div>
		                          					<div  style="overflow:auto;width:auto; height:200px;margin:bottom 200px;">
		                          						<!-- /.Table Input-->
		                          						<table class="table table-bordered" id="dynamic_field2">
		                          							<tr>
		                          								<th rowspan="2" align="center" width="60px"><br>NO.&nbsp;&nbsp;&nbsp;&nbsp;</th>
		                          								<th align="center" rowspan="2" width="220px" ><br><p align="center">INSPECTION ITEM</p></th>
		                          								<th colspan="2"><p align="center">STANDARD VALUE</p></th>
		                          								<th rowspan="2" align="midle-center" width="200px"><br><p align="center">I.INSTRUMENT</p></th>
		                          								<th rowspan="2" width="60px"><p align="center"><br>RANK</p></th>
		                          								<th colspan="2"><p align="center">SAMPLING PLAN</p></th>
		                          								<th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
		                          								<th width="20px" rowspan="2"><p align="center"><br>Hapus</p></th>
		                          							</tr>
		                          							<tr>
		                          								<th width="150px"><p align="center">NOMINAL</p></th>
		                          								<th width="150px"><p align="center">TOLERANCE</p></th>
		                          								<th width="200px"><p align="center">IN PROSES</p></th>
		                          								<th width="220px"><p align="center">AT DELIVERY</p></th>
		                          							</tr> 
		                          							<tr id="line_field2">
		                          								<div class="">
		                          									<div class=""> 
		                          										<td>
		                          											<input type="text" id="mno_1" name="mno_1" placeholder="" class="form-control name_list"  value="1" align="center"/>
		                          										</td>

		                          										<td>
		                          											<input type="text" id="mitem_1" name="mitem_1" placeholder="" class="form-control name_list"  value="" />
		                          										</td>

		                          										<td>
		                          											<input type="text" id="mnom_1" name="mnom_1" placeholder="" class="form-control name_list" value=""/>
		                          										</td>

		                          										<td>
		                          											<input type="text" id="mtol_1" name="mtol_1" placeholder="" class="form-control name_list" value=""/>
		                          										</td>

		                          										<td>
		                          											<input type="text" id="mins_1" name="mins_1" placeholder="" class="form-control name_list" value=""/>
		                          										</td>

		                          										<td>
		                          											<input type="text" id="mrank_1" name="mrank_1" placeholder="" class="form-control name_list" value=""/>
		                          										</td>

		                          										<td>
		                          											<input type="text" id="mpro_1" name="mpro_1" placeholder="" class="form-control name_list" value=""/>
		                          										</td>

		                          										<td>
		                          											<input type="text" id="mdel_1" name="mdel_1" placeholder="" class="form-control name_list" value=""/>
		                          										</td>

		                          										<td>
		                          											<input type="text" id="mrem_1" name="mrem_1" placeholder="" class="form-control name_list" value=""/>
		                          										</td>

		                          										<td>
		                          											<button id="mbtndelete_1" name="mbtndelete_1" type="button" class="btn btn-danger btn-sm" onclick="deleteLine(this)">
		                          												<i class="fa fa-times"></i>
		                          											</button>
		                          										</td>
		                          									</div>    
		                          								</div>      
		                          							</tr>
		                          						</table>
		                          						{!! Form::hidden('jml_linee', 1, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_linee']) !!}
		                          					</div>
		                          					<button type="button" name="addd" id="addd" class="btn btn-success">+</button>
		                          				</div>
		                          				{{-- ====================================== --}}

		                          			</div>
		                          		</div>

		                          	</div>
	                        </div>
	                        {{-- C. WELDING PERFORMANCE (IF ANY) --}}
	                        <div class="panel-body" >
	                              {{-- B.MECHANICAL PROPERTIES --}}
	                              <div class="panel-heading" style="background-color:#F0F8FF" >
	                                <h3 class="panel-title"> C. WELDING PERFORMANCE (IF ANY) </h3>
	                              </div>
	                              <div class="panel-body col-md-12">
	                                <div class="box-body" >
	                                  <div class="col-md-12">
	                                   {{-- ========= --}}
	                                    <div class="box-body col-md-12" >
	                                        <div class="panel-heading" style="background-color:#F0F8FF">
	                                           <h3 class="panel-title"><b></b></h3>
	                                        </div>
	                                        <div  style="overflow:auto;width:auto; height:200px;margin:bottom 200px;">
	                                          <!-- /.Table Input-->
	                                          <table class="table table-bordered" id="dynamic_field3">
	                                              <tr>
	                                                <th rowspan="2" align="center" width="60px"><br>NO.&nbsp;&nbsp;&nbsp;&nbsp;</th>
	                                                <th align="center" rowspan="2" width="220px" ><br><p align="center">INSPECTION ITEM</p></th>
	                                                <th colspan="2"><p align="center">STANDARD VALUE</p></th>
	                                                <th rowspan="2" align="midle-center" width="200px"><br><p align="center">I.INSTRUMENT</p></th>
	                                                <th rowspan="2" width="60px"><p align="center"><br>RANK</p></th>
	                                                <th colspan="2"><p align="center">SAMPLING PLAN</p></th>
	                                                <th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
	                                                <th width="20px" rowspan="2"><p align="center"><br>Hapus</p></th>
	                                              </tr>
	                                              <tr>
	                                                <th width="150px"><p align="center">NOMINAL</p></th>
	                                                <th width="150px"><p align="center">TOLERANCE</p></th>
	                                                <th width="200px"><p align="center">IN PROSES</p></th>
	                                                <th width="220px"><p align="center">AT DELIVERY</p></th>
	                                              </tr> 
	                                              <tr id="line_field3_">
	                                                <div class="">
	                                                  <div class=""> 
	                                                    <td>
	                                                      <input type="text" id="wno_1" name="wno_1" placeholder="" class="form-control name_list"  value="1" align="center"/>
	                                                    </td>

	                                                    <td>
	                                                      <input type="text" id="witem_1" name="witem_1" placeholder="" class="form-control name_list"  value="" />
	                                                    </td>

	                                                    <td>
	                                                      <input type="text" id="wnom_1" name="wnom_1" placeholder="" class="form-control name_list" value=""/>
	                                                    </td>

	                                                    <td>
	                                                      <input type="text" id="wtol_1" name="wtol_1" placeholder="" class="form-control name_list" value=""/>
	                                                    </td>

	                                                    <td>
	                                                      <input type="text" id="wins_1" name="wins_1" placeholder="" class="form-control name_list" value=""/>
	                                                    </td>

	                                                    <td>
	                                                      <input type="text" id="wrank_1" name="wrank_1" placeholder="" class="form-control name_list" value=""/>
	                                                    </td>

	                                                    <td>
	                                                      <input type="text" id="wpro_1" name="wpro_1" placeholder="" class="form-control name_list" value=""/>
	                                                    </td>

	                                                    <td>
	                                                      <input type="text" id="wdel_1" name="wdel_1" placeholder="" class="form-control name_list" value=""/>
	                                                    </td>

	                                                    <td>
	                                                      <input type="text" id="wrem_1" name="wrem_1" placeholder="" class="form-control name_list" value=""/>
	                                                    </td>

	                                                    <td>
	                                                      <button id="wbtndelete_1" name="wbtndelete_1" type="button" class="btn btn-danger btn-sm" onclick="deleteLine(this)">
	                                                        <i class="fa fa-times"></i>
	                                                      </button>
	                                                    </td>
	                                                  </div>    
	                                                </div>      
	                                              </tr>
	                                          </table>
	                                          {!! Form::hidden('jml_line3', 1, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_line3']) !!}
	                                        </div>
	                                        <button type="button" name="add3" id="add3" class="btn btn-success">+</button>
	                                    </div>
	                                    {{-- ====================================== --}}

	                                  </div>
	                                </div>

	                              </div>
	                        </div>
	                        {{-- D. SURFACE TREATMENT (IF ANY) --}}
	                        <div class="panel-body" >
	                              {{-- D. SURFACE TREATMENT (IF ANY) --}}
	                              <div class="panel-heading" style="background-color:#F0F8FF" >
	                                <h3 class="panel-title"> D. SURFACE TREATMENT (IF ANY) </h3>
	                              </div>
	                              <div class="panel-body col-md-12">
	                                <div class="box-body" >
	                                  <div class="col-md-12">
	                                   {{-- ========= --}}
	                                    <div class="box-body col-md-12" >
	                                        <div class="panel-heading" style="background-color:#F0F8FF">
	                                           <h3 class="panel-title"><b></b></h3>
	                                        </div>
	                                        <div  style="overflow:auto;width:auto; height:200px;margin:bottom 200px;">
	                                          <!-- /.Table Input-->
	                                          <table class="table table-bordered" id="dynamic_field4">
	                                              <tr>
	                                                <th rowspan="2" align="center" width="60px"><br>NO.&nbsp;&nbsp;&nbsp;&nbsp;</th>
	                                                <th align="center" rowspan="2" width="220px" ><br><p align="center">INSPECTION ITEM</p></th>
	                                                <th colspan="2"><p align="center">STANDARD VALUE</p></th>
	                                                <th rowspan="2" align="midle-center" width="200px"><br><p align="center">I.INSTRUMENT</p></th>
	                                                <th rowspan="2" width="60px"><p align="center"><br>RANK</p></th>
	                                                <th colspan="2"><p align="center">SAMPLING PLAN</p></th>
	                                                <th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
	                                                <th width="20px" rowspan="2"><p align="center"><br>Hapus</p></th>
	                                              </tr>
	                                              <tr>
	                                                <th width="150px"><p align="center">NOMINAL</p></th>
	                                                <th width="150px"><p align="center">TOLERANCE</p></th>
	                                                <th width="200px"><p align="center">IN PROSES</p></th>
	                                                <th width="220px"><p align="center">AT DELIVERY</p></th>
	                                              </tr> 
	                                              <tr id="line_field1">
	                                                <div class="box-body col-md-3">
	                                                  <div class="form-group"> 
	                                                    <td>
	                                                      <input type="text" id="sno_1" name="sno_1" placeholder="" class="form-control name_list"  value="1" align="center"/>
	                                                    </td>

	                                                    <td>
	                                                      <input type="text" id="sitem_1" name="sitem_1" placeholder="" class="form-control name_list"  value="" />
	                                                    </td>

	                                                    <td>
	                                                      <input type="text" id="snominal_1" name="snominal_1" placeholder="" class="form-control name_list" value=""/>
	                                                    </td>

	                                                    <td>
	                                                      <input type="text" id="stolerance_1" name="stolerance_1" placeholder="" class="form-control name_list" value=""/>
	                                                    </td>

	                                                    <td>
	                                                      <input type="text" id="sinstrument_1" name="sinstrument_1" placeholder="" class="form-control name_list" value=""/>
	                                                    </td>

	                                                    <td>
	                                                      <input type="text" id="srank_1" name="srank_1" placeholder="" class="form-control name_list" value=""/>
	                                                    </td>

	                                                    <td>
	                                                      <input type="text" id="sproses_1" name="sproses_1" placeholder="" class="form-control name_list" value=""/>
	                                                    </td>

	                                                    <td>
	                                                      <input type="text" id="sdelivery_1" name="sdelivery_1" placeholder="" class="form-control name_list" value=""/>
	                                                    </td>

	                                                    <td>
	                                                      <input type="text" id="sremarks_1" name="sremarks_1" placeholder="" class="form-control name_list" value=""/>
	                                                    </td>

	                                                    <td>
	                                                      <button id="sbtndelete_1" name="sbtndelete_1" type="button" class="btn btn-danger btn-sm" onclick="deleteLine(this)">
	                                                        <i class="fa fa-times"></i>
	                                                      </button>
	                                                    </td>
	                                                  </div>    
	                                                </div>      
	                                              </tr>
	                                          </table>
	                                          {!! Form::hidden('jml_line4', 1, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_line4']) !!}
	                                        </div>
	                                        <button type="button" name="add4" id="add4" class="btn btn-success">+</button>
	                                    </div>
	                                    {{-- ====================================== --}}
	                                   
	                                  </div>
	                                </div>

	                              </div>
	                        </div>
	                        {{-- E. HEAT TREATMENT (IF ANY) --}}
	                        <div class="panel-body" >
	                              {{-- E. HEAT TREATMENT (IF ANY) --}}
	                              <div class="panel-heading" style="background-color:#F0F8FF" >
	                                <h3 class="panel-title"> E. HEAT TREATMENT (IF ANY) </h3>
	                              </div>
	                              <div class="panel-body col-md-12">
	                                <div class="box-body" >
	                                  <div class="col-md-12">
	                                   {{-- ========= --}}
	                                    <div class="box-body col-md-12" >
	                                        <div class="panel-heading" style="background-color:#F0F8FF">
	                                           <h3 class="panel-title"><b></b></h3>
	                                        </div>
	                                        <div  style="overflow:auto;width:auto; height:200px;margin:bottom 200px;">
	                                          <!-- /.Table Input-->
	                                          <table class="table table-bordered" id="dynamic_field5">
	                                              <tr>
	                                                <th rowspan="2" align="center" width="60px"><br>NO.&nbsp;&nbsp;&nbsp;&nbsp;</th>
	                                                <th align="center" rowspan="2" width="220px" ><br><p align="center">INSPECTION ITEM</p></th>
	                                                <th colspan="2"><p align="center">STANDARD VALUE</p></th>
	                                                <th rowspan="2" align="midle-center" width="200px"><br><p align="center">I.INSTRUMENT</p></th>
	                                                <th rowspan="2" width="60px"><p align="center"><br>RANK</p></th>
	                                                <th colspan="2"><p align="center">SAMPLING PLAN</p></th>
	                                                <th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
	                                                <th width="20px" rowspan="2"><p align="center"><br>Hapus</p></th>
	                                              </tr>
	                                              <tr>
	                                                <th width="150px"><p align="center">NOMINAL</p></th>
	                                                <th width="150px"><p align="center">TOLERANCE</p></th>
	                                                <th width="200px"><p align="center">IN PROSES</p></th>
	                                                <th width="220px"><p align="center">AT DELIVERY</p></th>
	                                              </tr> 
	                                              <tr id="line_field1">
	                                                <div class="box-body col-md-3">
	                                                  <div class="form-group"> 
	                                                    <td>
	                                                      <input type="text" id="hno_1" name="hno_1" placeholder="" class="form-control name_list"  value="1" align="center"/>
	                                                    </td>

	                                                    <td>
	                                                      <input type="text" id="hitem_1" name="hitem_1" placeholder="" class="form-control name_list"  value="" />
	                                                    </td>

	                                                    <td>
	                                                      <input type="text" id="hnominal_1" name="hnominal_1" placeholder="" class="form-control name_list" value=""/>
	                                                    </td>

	                                                    <td>
	                                                      <input type="text" id="htolerance_1" name="htolerance_1" placeholder="" class="form-control name_list" value=""/>
	                                                    </td>

	                                                    <td>
	                                                      <input type="text" id="hinstrument_1" name="hinstrument_1" placeholder="" class="form-control name_list" value=""/>
	                                                    </td>

	                                                    <td>
	                                                      <input type="text" id="hrank_1" name="hrank_1" placeholder="" class="form-control name_list" value=""/>
	                                                    </td>

	                                                    <td>
	                                                      <input type="text" id="hproses_1" name="hproses_1" placeholder="" class="form-control name_list" value=""/>
	                                                    </td>

	                                                    <td>
	                                                      <input type="text" id="hdelivery_1" name="hdelivery_1" placeholder="" class="form-control name_list" value=""/>
	                                                    </td>

	                                                    <td>
	                                                      <input type="text" id="hremarks_1" name="hremarks_1" placeholder="" class="form-control name_list" value=""/>
	                                                    </td>

	                                                    <td>
	                                                      <button id="hbtndelete_1" name="hbtndelete_1" type="button" class="btn btn-danger btn-sm" onclick="deleteLine(this)">
	                                                        <i class="fa fa-times"></i>
	                                                      </button>
	                                                    </td>
	                                                  </div>    
	                                                </div>      
	                                              </tr>
	                                          </table>
	                                          {!! Form::hidden('jml_line5', 1, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_line5']) !!}
	                                        </div>
	                                        <button type="button" name="add5" id="add5" class="btn btn-success">+</button>
	                                    </div>
	                                    {{-- ====================================== --}}
	                                   
	                                  </div>
	                                </div>

	                              </div>
	                        </div>
	                        {{-- II. APPEARENCE --}}
	                        <div class="panel-body" >
	                              <div class="box box-primary">
	                                {{-- II. APPEARENCE --}}
	                                <div class="panel-heading" style="background-color: #FF6347">
	                                  <h3 class="panel-title"> II. APPEARENCE </h3>
	                                </div>
	                                <div class="panel-body col-md-12">
	                                  <div class="box-body" >
	                                    <div class="col-md-12">
	                                     {{-- ========= --}}
	                                      <div class="box-body col-md-12" >
	                                          <div class="panel-heading" style="background-color:#F0F8FF">
	                                             <h3 class="panel-title"><b></b></h3>
	                                          </div>
	                                          <div  style="overflow:auto;width:auto; height:200px;margin:bottom 200px;">
	                                            <!-- /.Table Input-->
	                                            <table class="table table-bordered" id="dynamic_field6">
	                                                <tr>
	                                                  <th rowspan="2" align="center" width="60px"><br>NO.&nbsp;&nbsp;&nbsp;&nbsp;</th>
	                                                  <th align="center" rowspan="2" width="220px" ><br><p align="center">INSPECTION ITEM</p></th>
	                                                  <th colspan="2"><p align="center">STANDARD VALUE</p></th>
	                                                  <th rowspan="2" align="midle-center" width="200px"><br><p align="center">I.INSTRUMENT</p></th>
	                                                  <th rowspan="2" width="60px"><p align="center"><br>RANK</p></th>
	                                                  <th colspan="2"><p align="center">SAMPLING PLAN</p></th>
	                                                  <th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
	                                                  <th width="20px" rowspan="2"><p align="center"><br>Hapus</p></th>
	                                                </tr>
	                                                <tr>
	                                                  <th width="150px"><p align="center">NOMINAL</p></th>
	                                                  <th width="150px"><p align="center">TOLERANCE</p></th>
	                                                  <th width="200px"><p align="center">IN PROSES</p></th>
	                                                  <th width="220px"><p align="center">AT DELIVERY</p></th>
	                                                </tr> 
	                                                <tr id="line_field1">
	                                                  <div class="box-body col-md-3">
	                                                    <div class="form-group"> 
	                                                      <td>
	                                                        <input type="text" id="apno_1" name="apno_1" placeholder="" class="form-control name_list"  value="1" align="center"/>
	                                                      </td>

	                                                      <td>
	                                                        <input type="text" id="apitem_1" name="apitem_1" placeholder="" class="form-control name_list"  value="" />
	                                                      </td>

	                                                      <td>
	                                                        <input type="text" id="apnominal_1" name="apnominal_1" placeholder="" class="form-control name_list" value=""/>
	                                                      </td>

	                                                      <td>
	                                                        <input type="text" id="aptolerance_1" name="aptolerance_1" placeholder="" class="form-control name_list" value=""/>
	                                                      </td>

	                                                      <td>
	                                                        <input type="text" id="apinstrument_1" name="apinstrument_1" placeholder="" class="form-control name_list" value=""/>
	                                                      </td>

	                                                      <td>
	                                                        <input type="text" id="aprank_1" name="aprank_1" placeholder="" class="form-control name_list" value=""/>
	                                                      </td>

	                                                      <td>
	                                                        <input type="text" id="approses_1" name="approses_1" placeholder="" class="form-control name_list" value=""/>
	                                                      </td>

	                                                      <td>
	                                                        <input type="text" id="apdelivery_1" name="apdelivery_1" placeholder="" class="form-control name_list" value=""/>
	                                                      </td>

	                                                      <td>
	                                                        <input type="text" id="apremarks_1" name="apremarks_1" placeholder="" class="form-control name_list" value=""/>
	                                                      </td>

	                                                      <td>
	                                                        <button id="apbtndelete_1" name="apbtndelete_1" type="button" class="btn btn-danger btn-sm" onclick="deleteLine(this)">
	                                                          <i class="fa fa-times"></i>
	                                                        </button>
	                                                      </td>
	                                                    </div>    
	                                                  </div>      
	                                                </tr>
	                                          </table>
	                                          {!! Form::hidden('jml_rows', 1, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_rows']) !!}
	                                          </div>
	                                          <button type="button" name="tambah" id="tambah" class="btn btn-success">+</button>
	                                      </div>
	                                      {{-- ====================================== --}}
	                                      
	                                    </div>
	                                  </div>

	                                </div>
	                              </div>
	                        </div>
	                        {{-- IIII. DIMENSION--}}
	                        <div class="panel-body" >
		                            <div class="box box-primary">
		                              {{-- IIII. DIMENSION --}}
		                              <div class="panel-heading" style="background-color: #FF6347">
		                                <h3 class="panel-title"> III. DIMENSION  </h3>
		                              </div>
		                              <div class="panel-body col-md-12">
		                                <div class="box-body" >
		                                  <div class="col-md-12">
		                                   {{-- ========= --}}
		                                    <div class="box-body col-md-12" >
		                                        <div class="panel-heading" style="background-color:#F0F8FF">
		                                           <h3 class="panel-title"><b>OUTPUT</b></h3>
		                                        </div>
		                                        <div  style="overflow:auto;width:auto; height:200px;margin:bottom 200px;">
		                                          <!-- /.Table Input-->
		                                          <table class="table table-bordered" id="dynamic_field7">
		                                              <tr>
		                                                <th rowspan="2" align="center" width="60px"><br>NO.&nbsp;&nbsp;&nbsp;&nbsp;</th>
		                                                <th align="center" rowspan="2" width="220px" ><br><p align="center">INSPECTION ITEM</p></th>
		                                                <th colspan="2"><p align="center">STANDARD VALUE</p></th>
		                                                <th rowspan="2" align="midle-center" width="200px"><br><p align="center">I.INSTRUMENT</p></th>
		                                                <th rowspan="2" width="60px"><p align="center"><br>RANK</p></th>
		                                                <th colspan="2"><p align="center">SAMPLING PLAN</p></th>
		                                                <th rowspan="2" width="150px"><p align="center"><br>REMARKS</p></th>
		                                                <th width="20px" rowspan="2"><p align="center"><br>Hapus</p></th>
		                                              </tr>
		                                              <tr>
		                                                <th width="150px"><p align="center">NOMINAL</p></th>
		                                                <th width="150px"><p align="center">TOLERANCE</p></th>
		                                                <th width="200px"><p align="center">IN PROSES</p></th>
		                                                <th width="220px"><p align="center">AT DELIVERY</p></th>
		                                              </tr> 
		                                              <tr id="line_field1">
		                                                <div class="box-body col-md-3">
		                                                  <div class="form-group"> 
		                                                    <td>
		                                                      <input type="text" id="dno_1" name="dno_1" placeholder="" class="form-control name_list"  value="1" align="center"/>
		                                                    </td>

		                                                    <td>
		                                                      <input type="text" id="ditem_1" name="ditem_1" placeholder="" class="form-control name_list"  value="" />
		                                                    </td>

		                                                    <td>
		                                                      <input type="text" id="dnominal_1" name="dnominal_1" placeholder="" class="form-control name_list" value=""/>
		                                                    </td>

		                                                    <td>
		                                                      <input type="text" id="dtolerance_1" name="dtolerance_1" placeholder="" class="form-control name_list" value=""/>
		                                                    </td>

		                                                    <td>
		                                                      <input type="text" id="dinstrument_1" name="dinstrument_1" placeholder="" class="form-control name_list" value=""/>
		                                                    </td>

		                                                    <td>
		                                                      <input type="text" id="drank_1" name="drank_1" placeholder="" class="form-control name_list" value=""/>
		                                                    </td>

		                                                    <td>
		                                                      <input type="text" id="dproses_1" name="dproses_1" placeholder="" class="form-control name_list" value=""/>
		                                                    </td>

		                                                    <td>
		                                                      <input type="text" id="ddelivery_1" name="ddelivery_1" placeholder="" class="form-control name_list" value=""/>
		                                                    </td>

		                                                    <td>
		                                                      <input type="text" id="dremarks_1" name="dremarks_1" placeholder="" class="form-control name_list" value=""/>
		                                                    </td>

		                                                    <td>
		                                                      <button id="dbtndelete_1" name="dbtndelete_1" type="button" class="btn btn-danger btn-sm" onclick="deleteLine(this)">
		                                                        <i class="fa fa-times"></i>
		                                                      </button>
		                                                    </td>
		                                                  </div>    
		                                                </div>      
		                                              </tr>
		                                          </table>
		                                          {!! Form::hidden('jml_input1', 1, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_input1']) !!}
		                                        </div>
		                                        <button type="button" name="dimention" id="dimention" class="btn btn-success">+</button>
		                                    </div>
		                                    {{-- ====================================== --}}
		                                    
		                                  </div>
		                                </div>

		                              </div>
		                            </div>
	                        </div>
	                        {{-- IV. SOC FREE--}}
	                        <div class="panel-body" >
		                            <div class="box box-primary">
		                              {{-- IV. SOC FREE --}}
		                              <div class="panel-heading" style="background-color: #FF6347">
		                                <h3 class="panel-title"> IV. SOC FREE</h3>
		                              </div>
		                              <div class="panel-body col-md-12">
		                                <div class="box-body" >
		                                  <div class="col-md-12">
		                                       {{-- ============= --}}
		                                    <div class="box-body col-md-12" >
		                                        <div class="panel-heading" style="background-color:#F0F8FF">
		                                           <h3 class="panel-title"><b>OUTPUT</b></h3>
		                                        </div>
		                                        <div  style="overflow:auto;width:auto; height:200px;margin:bottom 200px;">
		                                          <!-- /.Table Input-->
		                                          <table class="table table-bordered" id="dynamic_field8">
		                                              <tr>
		                                                <th width="100px">NO.</th>
		                                                <th width="300px"><center>INSPECTION ITEM</center></th>
		                                                <th width="300px"><center>STANDARD VALUE</center></th>
		                                                <th width="300px"><center>I.INSTRUMENT<center></th>
		                                                <th width="300px"><center>RANK</center></th>
		                                                <th width="300px"><center>SAMPLING PLAN</center></th>
		                                                <th width="300px"><center>REMARKS</center></th>
		                                                <th width="50px">Hapus</th>
		                                              </tr> 
		                                              <tr id="line_field1">
		                                                <div class="box-body col-md-3">
		                                                  <div class="form-group"> 
		                                                    <td>
		                                                      <input type="text" id="scno_1" name="scno_1" placeholder="" class="form-control name_list"  value="1" align="center"/>
		                                                    </td>

		                                                    <td>
		                                                      <input type="text" id="scitem_1" name="scitem_1" placeholder="" class="form-control name_list"  value="" />
		                                                    </td>

		                                                    <td>
		                                                      <input type="text" id="scinstrument_1" name="scinstrument_1" placeholder="" class="form-control name_list" value=""/>
		                                                    </td>

		                                                    <td>
		                                                      <input type="text" id="scrank_1" name="scrank_1" placeholder="" class="form-control name_list" value=""/>
		                                                    </td>

		                                                    <td>
		                                                      <input type="text" id="scproses_1" name="scproses_1" placeholder="" class="form-control name_list" value=""/>
		                                                    </td>

		                                                    <td>
		                                                      <input type="text" id="scdelivery_1" name="scdelivery_1" placeholder="" class="form-control name_list" value=""/>
		                                                    </td>

		                                                    <td>
		                                                      <input type="text" id="scremarks_1" name="scremarks_1" placeholder="" class="form-control name_list" value=""/>
		                                                    </td>

		                                                    <td>
		                                                      <button id="scbtndelete_1" name="scbtndelete_1" type="button" class="btn btn-danger btn-sm" onclick="deleteLine(this)">
		                                                        <i class="fa fa-times"></i>
		                                                      </button>
		                                                    </td>
		                                                  </div>    
		                                                </div>      
		                                              </tr>
		                                          </table>
		                                            {!! Form::hidden('inputhidden', 1, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'inputhidden']) !!}
		                                        </div>
		                                        <button type="button" name="socfree" id="socfree" class="btn btn-success">+</button>
		                                    </div>
		                                    {{-- ====================================== --}}
		                                    
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
		                                           <h3 class="panel-title"><b></b></h3>
		                                        </div>
		                                        <div  style="">
		                                          <!-- /.Table Input-->
		                                         <table class="" style="width: 100%;">
		                                           <tr>
		                                             <td colspan="12">
		                                              <table  cellspacing="0" cellpadding="0" width="100%">
		                                                <tr>
		                                                  <td colspan="12" height="250" style="border: 1px solid #ccc; margin: 0;">
		                                                      {!! Form::file('part_routing', ['style' => 'border: 1px solid #ccc; margin: 0; position: absolute; top: 35px;']) !!}
		                                                    
		                                                  </td>
		                                                </tr>
		                                              </table>
		                                            </td>
		                                          </tr>
		                                          </table>
		                                        </div>
		                                    </div>
		                                    {{-- ====================================== --}}
		                                    
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
		                                             {!! Form::file('sketchdrawing') !!}
		                                        </div>
		                                    </div>
		                                    {{-- Catatan --}}
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
		                                        	{!! Form::file('sketchmmethode') !!}
		                                        </div>
		                                    </div>
		                                    {{-- ====================================== --}}
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
		                                          {!! Form::file('sketchappearance') !!}
		                                        </div>
		                                    </div>
		                                    {{-- ====================================== --}}
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
		                                <h3 class="panel-title"> UPLOAD ELECTRONIC SIGN</h3>
		                              </div>
		                              <div class="panel-body col-md-12">
		                                 {{-- SKETCH DRAWING WITH BALON: --}}
		                                <div class="box-body" >
		                                  <div class="col-md-12">
		                                   {{-- Gambar--}}
		                                    <div class="box-body col-md-12" >
		                                        <div class="panel-heading" style="background-color:#F0F8FF">
		                                           <h3 class="panel-title"><b>STAFF</b></h3>
		                                        </div>
		                                        <div  style="">
		                                          <!-- /.Table Input-->
		                                             {!! Form::file('staff_spy') !!}
		                                             {!! Form::text('staff_name', null,  ['class'=>'col-md-4 control-label','placeholder' => 'Nama Lengkap']) !!}
		                                        </div>
		                                    </div>
		                                    {{-- Catatan --}}
		                                   
		                                  </div>
		                                </div>
		                                  {{-- SKETCH SPECIAL MEASURING METHODE (IF ANY) --}}
		                                <div class="box-body" >
		                                  <div class="col-md-12">
		                                   {{-- ========= --}}
		                                    <div class="box-body col-md-12" >
		                                        <div class="panel-heading" style="background-color:#F0F8FF">
		                                           <h3 class="panel-title"><b>MANAGER</b></h3>
		                                        </div>
		                                        <div  style="">
		                                        	<!-- /.Table Input-->
		                                        	{!! Form::file('supervisor_spy') !!}
		                                        	{!! Form::text('supervisor_name', null,  ['class'=>'col-md-4 control-label','placeholder' => 'Nama Lengkap']) !!}
		                                        </div>
		                                    </div>
		                                    {{-- ====================================== --}}
		                                    
		                                  </div>
		                                </div>

		                                {{-- SKETCH APPEARANCE/PRODUCTION CODE --}}
		                                <div class="box-body" >
		                                  <div class="col-md-12">
		                                   {{-- ========= --}}
		                                    <div class="box-body col-md-12" >
		                                        <div class="panel-heading" style="background-color:#F0F8FF">
		                                           <h3 class="panel-title"><b>DIVISION</b></h3>
		                                        </div>
		                                        <div  style="">
		                                        <!-- /.Table Input-->
		                                          {!! Form::file('manager_spy') !!}
		                                          {!! Form::text('manager_name', null,  ['class'=>'col-md-4 control-label','placeholder' => 'Nama Lengkap']) !!}
		                                        </div>
		                                    </div>
		                                    {{-- ====================================== --}}
		                                    
		                                  </div>
		                                </div>

		                              </div>
		                            </div>
	                        </div>
	                   </div>  

	                  <div class="box-footer">
	                      <form action="{{ route('pistandards.store') }}" method="POST">
		                        <!-- fields -->
		                        <button type="submit" name="action" value="save" class="btn btn-success" data-toggle='tooltip' data-placement='top' title='SUBMIT TO IGP'>Submit</button>
		                        &nbsp;&nbsp;
		                        &nbsp;&nbsp;
		                        <button type="submit" name="action" value="save_draft" class="btn btn-primary" data-toggle='tooltip' data-placement='top' title='SAVE AS DRAFT'>Save Draf</button>
		                        &nbsp;&nbsp;
		                        &nbsp;&nbsp;
		                         <a class="btn btn-danger" href="{{ route('pistandards.index') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Staff Approval" id="btn-cancel">Back</a>
	                      </form>
	                  </div>
	            </div>
	      </div>
      </body>
  </html>

 @section('scripts')
	<script type="text/javascript">

	    $("#addLine").click(function(){
	      var jml_general = document.getElementById("jml_general").value.trim();
	      jml_general = Number(jml_general) + 1;
	      document.getElementById("jml_general").value = jml_general;
	      var general_tol  = 'general_tol_'+jml_general;
	      var id_field = 'line_field_'+jml_general;
	      
	       $("#id_field").append(
	        '<div class="form-group" id="'+id_field+'">\
	          <div class="col-md-12">\
	           <div class="col-sm-12 {{ $errors->has('generaltol') ? ' has-error' : '' }}">\
	             <div class="input-group" >\
	              {!! Form::text('generaltol[]',null, ['class'=>'form-control', 'width'=>'100px']) !!}\
	               <span class="input-group-btn">\
	                  <button id="" name="" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="">\
	                    <span ><i class="fa fa-check"></i></span>\
	                  </button>\
	                </span>\
	            </div>\
	          </div>\
	        </div>'
	      );
	    });
			//SAMPAI SINI
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			// A. CHEMICAL COMPOSITION
	     	// Initialize Select2 Elements
	     	var jml_line1 = document.getElementById("jml_line1").value.trim();
	     	$("#add1").click(function(){
	     		jml_line1 = Number(jml_line1) + 1;
	     		document.getElementById("jml_line1").value = jml_line1  ;

	     		var cno = 'cno_'+jml_line1;
	     		var citem = 'citem_'+jml_line1;
	     		var cnom = 'cnom_'+jml_line1;
	     		var ctol = 'ctol_'+jml_line1;
	     		var cins = 'cins_'+jml_line1;
	     		var crank = 'crank_'+jml_line1;
	     		var cpro = 'cpro_'+jml_line1;
	     		var cdel = 'cdel_'+jml_line1;
	     		var crem = 'crem_'+jml_line1;
	     		var cbtndelete = 'cline_btndelete_'+jml_line1;
	     		var id_field1 = 'line_field1_'+jml_line1;

	     		$("#dynamic_field1").append(
	     			'<tr id="'+id_field1+'">\
	     			<td>\
	     				<input type="text" id="' +cno+ '" name="' +cno+ '" placeholder=""  class="form-control" value="'+jml_line1+'" align="center"/>\
	     			</td>\
	     			<td>\
	     				<div class="input-group">\
	     					<input type="text" id="' +citem+ '" name="' +citem+ '" placeholder="" class="form-control name_list"  value="" />\
	     				</div>\
	     			</td>\
	     			<td>\
	     				<div class="input-group">\
	     					<input type="text" id="' +cnom+ '" name="' +cnom+ '"  placeholder="" class="form-control name_list"  value=""/>\
	     				</div>\
	     			</td>\
	     			<td>\
	     				<input type="text" id="' +ctol+ '" name="' +ctol+ '" placeholder="" class="form-control name_list" />\
	     			</td>\
	     			<td>\
	     				<input type="text" id="' +cins+ '" name="' +cins+ '" placeholder="" class="form-control name_list" />\
	     			</td>\
	     			<td>\
	     				<input type="text" id="' +crank+ '" name="' +crank+ '" placeholder="" class="form-control name_list" />\
	     			</td>\
	     			<td>\
	     				<input type="text" id="' +cpro+ '" name="' +cpro+ '" placeholder="" class="form-control name_list" />\
	     			</td>\
	     			<td>\
	     				<input type="text" id="' +cdel+ '" name="' +cdel+ '" placeholder="" class="form-control name_list" />\
	     			</td>\
	     			<td>\
	     				<input type="text" id="' +crem+ '" name="' +crem+ '" placeholder="" class="form-control name_list" />\
	     			</td>\
	     			<td>\
	     				<button id="' + cbtndelete + '" name="' + cbtndelete + '" type="button" class="btn btn-danger btn-sm" onclick="cbtndelete(this)">\
	     					<i class="fa fa-times"></i>\
	     				</button>\
	     			</td>\
	     		</tr>'
	     		);

	     	}); 

	     	// $("table.order-list").on("click",".buttonDel", function (event){
	     	// 	$(this).closest("tr").remove();
	     	// 	jml_line1 = jml_line1 - 1;
	     	// 	document.getElementById("jml_line1").value = jml_line1;

	     	// });

	     	function cbtndelete(ths) {
	     		var msg = 'Anda yakin menghapus Baris ini?';
	     		swal({
	     			title: msg,
	     			text: "",
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
	          //startcode
	          var row = ths.id.replace('cline_btndelete_', '');
	          var info = "";
	          var info2 = "";
	          var info3 = "warning";
	          var cno = document.getElementById("cno_" + row).value.trim();
	          
	          changeKdLine1(row);
	          //finishcode

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

	     	function changeKdLine1(row) {
	     		var id_field1 = "#line_field1_" + row;
	     		$(id_field1).remove();
	     		var jml_line1 = document.getElementById("jml_line1").value.trim();
	     		jml_line1 = Number(jml_line1);  
	     		nextRow = Number(row) + 1;
	     		for($i = nextRow; $i <= jml_line1; $i++) {

	     			var cno = '#cno_' + $i;
	     			var cno_new = 'cno_' + ($i-1);
	     			$(cno).val(($i-1));
	     			$(cno).attr({"id":cno_new, "name":cno_new});

	     			var citem = '#citem_' + $i;
	     			var citem_new = 'citem_' + ($i-1);
	     			$(citem).attr({"id":citem_new, "name":citem_new});

	     			var cnom = '#cnom_' + $i;
	     			var cnom_new = 'cnom_' + ($i-1);
	     			$(cnom).attr({"id":cnom_new, "name":cnom_new});

	     			var ctol = '#ctol_' + $i;
	     			var ctol_new = 'ctol_' + ($i-1);
	     			$(ctol).attr({"id":ctol_new, "name":ctol_new});

	     			var cins = '#cins_' + $i;
	     			var cins_new = 'cins_' + ($i-1);
	     			$(cins).attr({"id":cins_new, "name":cins_new});

	     			var crank = '#crank_' + $i;
	     			var crank_new = 'crank_' + ($i-1);
	     			$(crank).attr({"id":crank_new, "name":crank_new});

	     			var cpro = '#cpro_' + $i;
	     			var cpro_new = 'cpro_' + ($i-1);
	     			$(cpro).attr({"id":cpro_new, "name":cpro_new});

	     			var cdel = '#cdel_' + $i;
	     			var cdel_new = 'cdel_' + ($i-1);
	     			$(cdel).attr({"id":cdel_new, "name":cdel_new});

	     			var crem = "#crem_" + $i;
	     			var crem_new = "crem_" + ($i-1);
	     			$(crem).attr({"id":crem_new, "name":crem_new});

	     			var cbtndelete = "#cline_btndelete_" + $i;
	     			var cbtndelete_new = "cline_btndelete_" + ($i-1);
	     			$(cbtndelete).attr({"id":cbtndelete_new, "name":cbtndelete_new});

	     			var id_field1 = "#line_field1_" + $i;
	     			var id_field1_new = "line_field1_" + ($i-1);

	     			$(id_field1).attr({"id":id_field1_new, "name":id_field1_new});

	     		}
	     		jml_line1 = jml_line1 - 1;
	     		document.getElementById("jml_line1").value = jml_line1;
	     		console.log(document.getElementById("jml_line1").value);

	     	}

	     	

	      // B.MECHANICAL PROPERTIES\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

	     // Initialize Select2 Elements

	     $("#addd").click(function(){
	     	var jml_linee = document.getElementById("jml_linee").value.trim();
	     	jml_linee = Number(jml_linee) + 1;
	     	document.getElementById("jml_linee").value = jml_linee  ;

	     	var mno = 'mno_'+jml_linee;
	     	var mitem = 'mitem_'+jml_linee;
	     	var mnom = 'mnom_'+jml_linee;
	     	var mtol = 'mtol_'+jml_linee;
	     	var mins = 'mins_'+jml_linee;
	     	var mrank = 'mrank_'+jml_linee;
	     	var mpro = 'mpro_'+jml_linee;
	     	var mdel = 'mdel_'+jml_linee;
	     	var mrem = 'mrem_'+jml_linee;
	     	var mbtndelete = 'mline_btndelete_'+jml_linee;
	     	var id_field2 = 'line_field2_'+jml_linee;

	     	$("#dynamic_field2").append(
	     		'<tr id="'+id_field2+'">\
	     		<td>\
	     			<input type="text" id="' +mno+ '" name="' +mno+ '" placeholder="" class="form-control name_list" value="'+jml_linee+'" align="center"/>\
	     		</td>\
	     		<td>\
	     			<div class="input-group">\
	     				<input type="text" id="' +mitem+ '" name="' +mitem+ '" onchange="validatejam(this)" placeholder="" class="form-control name_list"  value="" />\
	     			</div>\
	     		</td>\
	     		<td>\
	     			<div class="input-group">\
	     				<input type="text" id="' +mnom+ '" name="' +mnom+ '" onchange="validatepart(this)" placeholder="" class="form-control name_list"  value=""/>\
	     			</div>\
	     		</td>\
	     		<td>\
	     			<input type="text" id="' +mtol+ '" name="' +mtol+ '" placeholder="" class="form-control name_list" />\
	     		</td>\
	     		<td>\
	     			<input type="text" id="' +mins+ '" name="' +mins+ '" placeholder="" class="form-control name_list" />\
	     		</td>\
	     		<td>\
	     			<input type="text" id="' +mrank+ '" name="' +mrank+ '" placeholder="" class="form-control name_list" />\
	     		</td>\
	     		<td>\
	     			<input type="text" id="' +mpro+ '" name="' +mpro+ '" placeholder="" class="form-control name_list" />\
	     		</td>\
	     		<td>\
	     			<input type="text" id="' +mdel+ '" name="' +mdel+ '" placeholder="" class="form-control name_list" />\
	     		</td>\
	     		<td>\
	     			<input type="text" id="' +mrem+ '" name="' +mrem+ '" placeholder="" class="form-control name_list" />\
	     		</td>\
	     		<td>\
	     			<button id="' + mbtndelete + '" name="' + mbtndelete + '" type="button" class="btn btn-danger btn-sm" onclick="mbtndelete(this)">\
	     				<i class="fa fa-times"></i>\
	     			</button>\
	     		</td>\
	     	</tr>'
	     	);

	     }); 

	     function mbtndelete(ths) {
	     	var msg = 'Anda yakin menghapus Baris ini?';
	     	swal({
	     		title: msg,
	     		text: "",
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
	          //startcode
	          var row = ths.id.replace('mline_btndelete_', '');
	          var info = "";
	          var info2 = "";
	          var info3 = "warning";
	          var mno = document.getElementById("mno_" + row).value.trim();
	          // var no_pisigp = document.getElementById("no_pisigp").value.trim();
	          changeKdLine2(row);
	          //finishcode

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

	     function changeKdLine2(row) {
	     	var id_field2 = "#line_field2_" + row;
	     	$(id_field2).remove();

	     	var jml_linee = document.getElementById("jml_linee").value.trim();
	     	jml_linee = Number(jml_linee);  
	     	nextRow = Number(row) + 1;
	     	for($i = nextRow; $i <= jml_linee; $i++) {
	     		var mno = '#mno_' + $i;
	     		var mno_new = 'mno_' + ($i-1);
	     		$(mno).val(($i-1));
	     		$(mno).attr({"id":mno_new, "name":mno_new});

	     		var mitem = '#mitem_' + $i;
	     		var mitem_new = 'mitem_' + ($i-1);
	     		$(mitem).attr({"id":mitem_new, "name":mitem_new});

	     		var mnom = '#mnom_' + $i;
	     		var mnom_new = 'mnom_' + ($i-1);
	     		$(mnom).attr({"id":mnom_new, "name":mnom_new});

	     		var mtol = '#mtol_' + $i;
	     		var mtol_new = 'mtol_' + ($i-1);
	     		$(mtol).attr({"id":mtol_new, "name":mtol_new});

	     		var mins = '#mins_' + $i;
	     		var mins_new = 'mins_' + ($i-1);
	     		$(mins).attr({"id":mins_new, "name":mins_new});

	     		var mrank = '#mrank_' + $i;
	     		var mrank_new = 'mrank_' + ($i-1);
	     		$(mrank).attr({"id":mrank_new, "name":mrank_new});

	     		var mpro = '#mpro_' + $i;
	     		var mpro_new = 'mpro_' + ($i-1);
	     		$(mpro).attr({"id":mpro_new, "name":mpro_new});

	     		var mdel = '#mdel_' + $i;
	     		var mdel_new = 'mdel_' + ($i-1);
	     		$(mdel).attr({"id":mdel_new, "name":mdel_new});

	     		var mrem = "#mrem_" + $i;
	     		var mrem_new = "mrem_" + ($i-1);
	     		$(mrem).attr({"id":mrem_new, "name":mrem_new});

	     		var mbtndelete = "#mbtndelete_" + $i;
	     		var mbtndelete_new = "mbtndelete_" + ($i-1);
	     		$(mbtndelete).attr({"id":mbtndelete_new, "name":mbtndelete_new});

	     		var id_field2 = "#line_field2_" + $i;
	     		var id_field2_new = "line_field2_" + ($i-1);
	     		$(id_field2).attr({"id":id_field2_new, "name":id_field2_new});

	     	}
	     	jml_linee = jml_linee - 1;
	     	document.getElementById("jml_linee").value = jml_linee;
	     	console.log(document.getElementById("jml_linee").value);

	     }


	      // C. WELDING PERFORMANCE (IF ANY)
	     // Initialize Select2 Elements

	     $("#add3").click(function(){
	     	var jml_line3 = document.getElementById("jml_line3").value.trim();
	     	jml_line3 = Number(jml_line3) + 1;
	     	document.getElementById("jml_line3").value = jml_line3  ;

	     	var wno = 'wno_'+jml_line3;
	     	var witem = 'witem_'+jml_line3;
	     	var wnom = 'wnom_'+jml_line3;
	     	var wtol = 'wtol_'+jml_line3;
	     	var wins = 'wins_'+jml_line3;
	     	var wrank = 'wrank_'+jml_line3;
	     	var wpro = 'wpro_'+jml_line3;
	     	var wdel = 'wdel_'+jml_line3;
	     	var wrem = 'wrem_'+jml_line3;
	     	var wbtndelete = 'wline_btndelete_'+jml_line3;
	     	var id_field3 = 'line_field3_'+jml_line3;

	     	$("#dynamic_field3").append(
	     		'<tr id="'+id_field3+'">\
	     		<td>\
	     			<input type="text" id="' +wno+ '" name="' +wno+ '" placeholder="" class="form-control name_list" value="'+jml_line3+'" align="center"/>\
	     		</td>\
	     		<td>\
	     			<div class="input-group">\
	     				<input type="text" id="' +witem+ '" name="' +witem+ '" onchange="validatejam(this)" placeholder="" class="form-control name_list"  value="" />\
	     			</div>\
	     		</td>\
	     		<td>\
	     			<div class="input-group">\
	     				<input type="text" id="' +wnom+ '" name="' +wnom+ '" onchange="validatepart(this)" placeholder="" class="form-control name_list"  value=""/>\
	     			</div>\
	     		</td>\
	     		<td>\
	     			<input type="text" id="' +wtol+ '" name="' +wtol+ '" placeholder="" class="form-control name_list" />\
	     		</td>\
	     		<td>\
	     			<input type="text" id="' +wins+ '" name="' +wins+ '" placeholder="" class="form-control name_list" />\
	     		</td>\
	     		<td>\
	     			<input type="text" id="' +wrank+ '" name="' +wrank+ '" placeholder="" class="form-control name_list" />\
	     		</td>\
	     		<td>\
	     			<input type="text" id="' +wpro+ '" name="' +wpro+ '" placeholder="" class="form-control name_list" />\
	     		</td>\
	     		<td>\
	     			<input type="text" id="' +wdel+ '" name="' +wdel+ '" placeholder="" class="form-control name_list" />\
	     		</td>\
	     		<td>\
	     			<input type="text" id="' +wrem+ '" name="' +wrem+ '" placeholder="" class="form-control name_list" />\
	     		</td>\
	     		<td>\
	     			<button id="' + wbtndelete + '" name="' + wbtndelete + '" type="button" class="btn btn-danger btn-sm" onclick="wbtndelete(this)">\
	     				<i class="fa fa-times"></i>\
	     			</button>\
	     		</td>\
	     	</tr>'
	     	);

	     });

	     function wbtndelete(ths) {
	     	var msg = 'Anda yakin menghapus Baris ini?';
	     	swal({
	     		title: msg,
	     		text: "",
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
	          //startcode
	          var row = ths.id.replace('wline_btndelete_', '');
	          var info = "";
	          var info2 = "";
	          var info3 = "warning";
	          var wno = document.getElementById("wno_" + row).value.trim();
	          // var no_pisigp = document.getElementById("no_pisigp").value.trim();
	          changeKdLine3(row);
	          //finishcode

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

	     function changeKdLine3(row) {
	     	var id_field3 = "#line_field3_" + row;
	     	$(id_field3).remove();

	     	var jml_line3 = document.getElementById("jml_line3").value.trim();
	     	jml_line3 = Number(jml_line3);  
	     	nextRow = Number(row) + 1;
	     	for($i = nextRow; $i <= jml_line3; $i++) {
	     		var wno = '#wno_' + $i;
	     		var wno_new = 'wno_' + ($i-1);
	     		$(wno).val(($i-1));
	     		$(wno).attr({"id":wno_new, "name":wno_new});

	     		var witem = '#witem_' + $i;
	     		var witem_new = 'witem_' + ($i-1);
	     		$(witem).attr({"id":witem_new, "name":witem_new});

	     		var wnom = '#wnom_' + $i;
	     		var wnom_new = 'wnom_' + ($i-1);
	     		$(wnom).attr({"id":wnom_new, "name":wnom_new});

	     		var wtol = '#wtol_' + $i;
	     		var wtol_new = 'wtol_' + ($i-1);
	     		$(wtol).attr({"id":wtol_new, "name":wtol_new});

	     		var wins = '#wins_' + $i;
	     		var wins_new = 'wins_' + ($i-1);
	     		$(wins).attr({"id":wins_new, "name":wins_new});

	     		var wrank = '#wrank_' + $i;
	     		var wrank_new = 'wrank_' + ($i-1);
	     		$(wrank).attr({"id":wrank_new, "name":wrank_new});

	     		var wpro = '#wpro_' + $i;
	     		var wpro_new = 'wpro_' + ($i-1);
	     		$(wpro).attr({"id":wpro_new, "name":wpro_new});

	     		var wdel = '#wdel_' + $i;
	     		var wdel_new = 'wdel_' + ($i-1);
	     		$(wdel).attr({"id":wdel_new, "name":wdel_new});

	     		var wrem = "#wrem_" + $i;
	     		var wrem_new = "wrem_" + ($i-1);
	     		$(wrem).attr({"id":wrem_new, "name":wrem_new});

	     		var wbtndelete = "#wbtndelete_" + $i;
	     		var wbtndelete_new = "wbtndelete_" + ($i-1);
	     		$(wbtndelete).attr({"id":wbtndelete_new, "name":wbtndelete_new});

	     		var id_field3 = "#line_field3_" + $i;
	     		var id_field3_new = "line_field3_" + ($i-1);
	     		$(id_field3).attr({"id":id_field3_new, "name":id_field3_new});

	     	}
	     	jml_line3 = jml_line3 - 1;
	     	document.getElementById("jml_line3").value = jml_line3;
	     	console.log(document.getElementById("jml_line3").value);

	     }

	      // D. SURFACE TREATMENT (IF ANY)\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
	     // Initialize Select2 Elements
	     $("#add4").click(function(){
	     	var jml_line4 = document.getElementById("jml_line4").value.trim();
	     	jml_line4 = Number(jml_line4) + 1;
	     	document.getElementById("jml_line4").value = jml_line4  ;

	     	var sno = 'sno_'+jml_line4;
	     	var sitem = 'sitem_'+jml_line4;
	     	var snominal = 'snominal_'+jml_line4;
	     	var stolerance = 'stolerance_'+jml_line4;
	     	var sinstrument = 'sinstrument_'+jml_line4;
	     	var srank = 'srank_'+jml_line4;
	     	var sproses = 'sproses_'+jml_line4;
	     	var sdelivery = 'sdelivery_'+jml_line4;
	     	var sremarks = 'sremarks_'+jml_line4;
	     	var sbtndelete = 'sline_btndelete_'+jml_line4;
	     	var id_field4 = 'line_field4_'+jml_line4;

	     	$("#dynamic_field4").append(
	     		'<tr id="'+id_field4+'">\
	     		<td>\
	     			<input type="text" id="' +sno+ '" name="' +sno+ '" placeholder="" class="form-control name_list" value="'+jml_line4+'" align="center"/>\
	     		</td>\
	     		<td>\
	     			<div class="input-group">\
	     				<input type="text" id="' +sitem+ '" name="' +sitem+ '" onchange="validatejam(this)" placeholder="" class="form-control name_list"  value="" />\
	     			</div>\
	     		</td>\
	     		<td>\
	     			<div class="input-group">\
	     				<input type="text" id="' +snominal+ '" name="' +snominal+ '" onchange="validatepart(this)" placeholder="" class="form-control name_list"  value=""/>\
	     			</div>\
	     		</td>\
	     		<td>\
	     			<input type="text" id="' +stolerance+ '" name="' +stolerance+ '" placeholder="" class="form-control name_list" />\
	     		</td>\
	     		<td>\
	     			<input type="text" id="' +sinstrument+ '" name="' +sinstrument+ '" placeholder="" class="form-control name_list" />\
	     		</td>\
	     		<td>\
	     			<input type="text" id="' +srank+ '" name="' +srank+ '" placeholder="" class="form-control name_list" />\
	     		</td>\
	     		<td>\
	     			<input type="text" id="' +sproses+ '" name="' +sproses+ '" placeholder="" class="form-control name_list" />\
	     		</td>\
	     		<td>\
	     			<input type="text" id="' +sdelivery+ '" name="' +sdelivery+ '" placeholder="" class="form-control name_list" />\
	     		</td>\
	     		<td>\
	     			<input type="text" id="' +sremarks+ '" name="' +sremarks+ '" placeholder="" class="form-control name_list" />\
	     		</td>\
	     		<td>\
	     			<button id="' + sbtndelete + '" name="' + sbtndelete + '" type="button" class="btn btn-danger btn-sm" onclick="sbtndelete(this)">\
	     				<i class="fa fa-times"></i>\
	     			</button>\
	     		</td>\
	     	</tr>'
	     	);
	     });

	     function sbtndelete(ths) {
	     	var msg = 'Anda yakin menghapus Baris ini?';
	     	swal({
	     		title: msg,
	     		text: "",
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
	          //startcode
	          var row = ths.id.replace('sline_btndelete_', '');
	          var info = "";
	          var info2 = "";
	          var info3 = "warning";
	          var sno = document.getElementById("sno_" + row).value.trim();
	          // var no_pisigp = document.getElementById("no_pisigp").value.trim();
	          changeKdLine4(row);
	          //finishcode

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

	     function changeKdLine4(row) {
	     	var id_field4 = "#line_field4_" + row;
	     	$(id_field4).remove();

	     	var jml_line4 = document.getElementById("jml_line4").value.trim();
	     	jml_line4 = Number(jml_line4);  
	     	nextRow = Number(row) + 1;
	     	for($i = nextRow; $i <= jml_line4; $i++) {
	     		var sno = '#sno_' + $i;
	     		var sno_new = 'sno_' + ($i-1);
	     		$(sno).val(($i-1));
	     		$(sno).attr({"id":sno_new, "name":sno_new});

	     		var sitem = '#sitem_' + $i;
	     		var sitem_new = 'sitem_' + ($i-1);
	     		$(sitem).attr({"id":sitem_new, "name":sitem_new});

	     		var snominal = '#snominal_' + $i;
	     		var snominal_new = 'snominal_' + ($i-1);
	     		$(snominal).attr({"id":snominal_new, "name":snominal_new});

	     		var stolerance = '#stolerance_' + $i;
	     		var stolerance_new = 'stolerance_' + ($i-1);
	     		$(stolerance).attr({"id":stolerance_new, "name":stolerance_new});


	     		var sinstrument = '#sinstrument_' + $i;
	     		var sinstrument_new = 'sinstrument_' + ($i-1);
	     		$(sinstrument).attr({"id":sinstrument_new, "name":sinstrument_new});

	     		var srank = '#srank_' + $i;
	     		var srank_new = 'srank_' + ($i-1);
	     		$(srank).attr({"id":srank_new, "name":srank_new});

	     		var sproses = '#sproses_' + $i;
	     		var sproses_new = 'sproses_' + ($i-1);
	     		$(sproses).attr({"id":sproses_new, "name":sproses_new});

	     		var sdelivery = '#sdelivery_' + $i;
	     		var sdelivery_new = 'sdelivery_' + ($i-1);
	     		$(sdelivery).attr({"id":sdelivery_new, "name":sdelivery_new});

	     		var sremarks = "#sremarks_" + $i;
	     		var sremarks_new = "sremarks_" + ($i-1);
	     		$(sremarks).attr({"id":sremarks_new, "name":sremarks_new});

	     		var sbtndelete = "#sline_btndelete_" + $i;
	     		var sbtndelete_new = "sline_btndelete_" + ($i-1);
	     		$(sbtndelete).attr({"id":sbtndelete_new, "name":sbtndelete_new});

	     		var id_field4 = "#line_field4_" + $i;
	     		var id_field4_new = "line_field4_" + ($i-1);
	     		$(id_field4).attr({"id":id_field4_new, "name":id_field4_new});

	     	}
	     	jml_line4 = jml_line4 - 1;
	     	document.getElementById("jml_line4").value = jml_line4;
	     	console.log(document.getElementById("jml_line4").value);

	     }



	      // E. HEAT TREATMENT (IF ANY)
	     // Initialize Select2 Elements

	     $("#add5").click(function(){
	     	var jml_line5 = document.getElementById("jml_line5").value.trim();
	     	jml_line5 = Number(jml_line5) + 1;
	     	document.getElementById("jml_line5").value = jml_line5  ;

	     	var hno = 'hno_'+jml_line5;
	     	var hitem = 'hitem_'+jml_line5;
	     	var hnominal = 'hnominal_'+jml_line5;
	     	var htolerance = 'htolerance_'+jml_line5;
	     	var hinstrument = 'hinstrument_'+jml_line5;
	     	var hrank = 'hrank_'+jml_line5;
	     	var hproses = 'hproses_'+jml_line5;
	     	var hdelivery = 'hdelivery_'+jml_line5;
	     	var hremarks = 'hremarks_'+jml_line5;
	     	var hbtndelete = 'hline_btndelete_'+jml_line5;
	     	var id_field5 = 'line_field5_'+jml_line5;

	     	$("#dynamic_field5").append(
	     		'<tr id="'+id_field5+'">\
	     		<td>\
	     			<input type="text" id="' +hno+ '" name="' +hno+ '" placeholder="" class="form-control name_list" value="'+jml_line5+'" align="center"/>\
	     		</td>\
	     		<td>\
	     			<div class="input-group">\
	     				<input type="text" id="' +hitem+ '" name="' +hitem+ '" onchange="validatejam(this)" placeholder="" class="form-control name_list"  value="" />\
	     			</div>\
	     		</td>\
	     		<td>\
	     			<div class="input-group">\
	     				<input type="text" id="' +hnominal+ '" name="' +hnominal+ '" onchange="validatepart(this)" placeholder="" class="form-control name_list"  value=""/>\
	     			</div>\
	     		</td>\
	     		<td>\
	     			<input type="text" id="' +htolerance+ '" name="' +htolerance+ '" placeholder="" class="form-control name_list" />\
	     		</td>\
	     		<td>\
	     			<input type="text" id="' +hinstrument+ '" name="' +hinstrument+ '" placeholder="" class="form-control name_list" />\
	     		</td>\
	     		<td>\
	     			<input type="text" id="' +hrank+ '" name="' +hrank+ '" placeholder="" class="form-control name_list" />\
	     		</td>\
	     		<td>\
	     			<input type="text" id="' +hproses+ '" name="' +hproses+ '" placeholder="" class="form-control name_list" />\
	     		</td>\
	     		<td>\
	     			<input type="text" id="' +hdelivery+ '" name="' +hdelivery+ '" placeholder="" class="form-control name_list" />\
	     		</td>\
	     		<td>\
	     			<input type="text" id="' +hremarks+ '" name="' +hremarks+ '" placeholder="" class="form-control name_list" />\
	     		</td>\
	     		<td>\
	     			<button id="' + hbtndelete + '" name="' + hbtndelete + '" type="button" class="btn btn-danger btn-sm" onclick="hbtndelete(this)">\
	     				<i class="fa fa-times"></i>\
	     			</button>\
	     		</td>\
	     	</tr>'
	     	);
	     });


	     function hbtndelete(ths) {
	     	var msg = 'Anda yakin menghapus Baris ini?';
	     	swal({
	     		title: msg,
	     		text: "",
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
	          //startcode
	          var row = ths.id.replace('hline_btndelete_', '');
	          var info = "";
	          var info2 = "";
	          var info3 = "warning";
	          var hno = document.getElementById("hno_" + row).value.trim();
	          // var no_pisigp = document.getElementById("no_pisigp").value.trim();
	          changeKdLine5(row);
	          //finishcode

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

	     function changeKdLine5(row) {
	     	var id_field5 = "#line_field5_" + row;
	     	$(id_field5).remove();

	     	var jml_line5 = document.getElementById("jml_line5").value.trim();
	     	jml_line5 = Number(jml_line5);  
	     	nextRow = Number(row) + 1;
	     	for($i = nextRow; $i <= jml_line5; $i++) {
	     		var hno = '#hno_' + $i;
	     		var hno_new = 'hno_' + ($i-1);
	     		$(hno).val(($i-1));
	     		$(hno).attr({"id":hno_new, "name":hno_new});

	     		var hitem = '#hitem_' + $i;
	     		var hitem_new = 'hitem_' + ($i-1);
	     		$(hitem).attr({"id":hitem_new, "name":hitem_new});

	     		var hnominal = '#hnominal_' + $i;
	     		var hnominal_new = 'hnominal_' + ($i-1);
	     		$(hnominal).attr({"id":hnominal_new, "name":hnominal_new});

	     		var htolerance = '#htolerance_' + $i;
	     		var htolerance_new = 'htolerance_' + ($i-1);
	     		$(htolerance).attr({"id":htolerance_new, "name":htolerance_new});

	     		var hinstrument = '#hinstrument_' + $i;
	     		var hinstrument_new = 'hinstrument_' + ($i-1);
	     		$(hinstrument).attr({"id":hinstrument_new, "name":hinstrument_new});

	     		var hrank = '#hrank_' + $i;
	     		var hrank_new = 'hrank_' + ($i-1);
	     		$(hrank).attr({"id":hrank_new, "name":hrank_new});

	     		var hproses = '#hproses_' + $i;
	     		var hproses_new = 'hproses_' + ($i-1);
	     		$(hproses).attr({"id":hproses_new, "name":hproses_new});

	     		var hdelivery = '#hdelivery_' + $i;
	     		var hdelivery_new = 'hdelivery_' + ($i-1);
	     		$(hdelivery).attr({"id":hdelivery_new, "name":hdelivery_new});

	     		var hremarks = "#hremarks_" + $i;
	     		var hremarks_new = "hremarks_" + ($i-1);
	     		$(hremarks).attr({"id":hremarks_new, "name":hremarks_new});

	     		var hbtndelete = "#hline_btndelete_" + $i;
	     		var hbtndelete_new = "hline_btndelete_" + ($i-1);
	     		$(hbtndelete).attr({"id":hbtndelete_new, "name":hbtndelete_new});

	     		var id_field5 = "#line_field5_" + $i;
	     		var id_field5_new = "line_field5_" + ($i-1);
	     		$(id_field5).attr({"id":id_field5_new, "name":id_field5_new});

	     	}
	     	jml_line5 = jml_line5 - 1;
	     	document.getElementById("jml_line5").value = jml_line5;
	     	console.log(document.getElementById("jml_line5").value);

	     }





	     // Initialize Select2 Elements




			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	     	// II. APPEARENCE
			 // Initialize Select2 Elements

			 $("#tambah").click(function(){
			 	var jml_rows = document.getElementById("jml_rows").value.trim();
			 	jml_rows = Number(jml_rows) + 1;
			 	document.getElementById("jml_rows").value = jml_rows  ;
			 	var apno = 'apno_'+jml_rows;
			 	var apitem = 'apitem_'+jml_rows;
			 	var apnominal = 'apnominal_'+jml_rows;
			 	var aptolerance = 'aptolerance_'+jml_rows;
			 	var apinstrument = 'apinstrument_'+jml_rows;
			 	var aprank = 'aprank_'+jml_rows;
			 	var approses = 'approses_'+jml_rows;
			 	var apdelivery = 'apdelivery_'+jml_rows;
			 	var apremarks = 'apremarks_'+jml_rows;
			 	var apbtndelete = 'apline_btndelete_'+jml_rows;
			 	var id_field6 = 'line_field6_'+jml_rows;
			 	$("#dynamic_field6").append(
			 		'<tr id="'+id_field6+'">\
			 		<td>\
			 			<input type="text" id="' +apno+ '" name="' +apno+ '" placeholder="" class="form-control name_list" value="'+jml_rows+'" align="center"/>\
			 		</td>\
			 		<td>\
			 			<div class="input-group">\
			 				<input type="text" id="' +apitem+ '" name="' +apitem+ '" onchange="validatejam(this)" placeholder="" class="form-control name_list"  value="" />\
			 			</div>\
			 		</td>\
			 		<td>\
			 			<div class="input-group">\
			 				<input type="text" id="' +apnominal+ '" name="' +apnominal+ '" onchange="validatepart(this)" placeholder="" class="form-control name_list"  value=""/>\
			 			</div>\
			 		</td>\
			 		<td>\
			 			<input type="text" id="' +aptolerance+ '" name="' +aptolerance+ '" placeholder="" class="form-control name_list" />\
			 		</td>\
			 		<td>\
			 			<input type="text" id="' +apinstrument+ '" name="' +apinstrument+ '" placeholder="" class="form-control name_list" />\
			 		</td>\
			 		<td>\
			 			<input type="text" id="' +aprank+ '" name="' +aprank+ '" placeholder="" class="form-control name_list" />\
			 		</td>\
			 		<td>\
			 			<input type="text" id="' +approses+ '" name="' +approses+ '" placeholder="" class="form-control name_list" />\
			 		</td>\
			 		<td>\
			 			<input type="text" id="' +apdelivery+ '" name="' +apdelivery+ '" placeholder="" class="form-control name_list" />\
			 		</td>\
			 		<td>\
			 			<input type="text" id="' +apremarks+ '" name="' +apremarks+ '" placeholder="" class="form-control name_list" />\
			 		</td>\
			 		<td>\
			 			<button id="' + apbtndelete + '" name="' + apbtndelete + '" type="button" class="btn btn-danger btn-sm" onclick="apbtndelete(this)">\
			 				<i class="fa fa-times"></i>\
			 			</button>\
			 		</td>\
			 	</tr>'
			 	);
			 });

			 function apbtndelete(ths) {
			 	var msg = 'Anda yakin menghapus Baris ini?';
			 	swal({
			 		title: msg,
			 		text: "",
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
	          //startcode
	          var row = ths.id.replace('apline_btndelete_', '');
	          var info = "";
	          var info2 = "";
	          var info3 = "warning";
	          var apno = document.getElementById("apno_" + row).value.trim();
	          // var no_pisigp = document.getElementById("no_pisigp").value.trim();
	          changeKdLine6(row);
	          //finishcode

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

			 function changeKdLine6(row) {
			 	var id_field6 = "#line_field6_" + row;
			 	$(id_field6).remove();

			 	var jml_rows = document.getElementById("jml_rows").value.trim();
			 	jml_rows = Number(jml_rows);  
			 	nextRow = Number(row) + 1;
			 	for($i = nextRow; $i <= jml_rows; $i++) {
			 		var apno = '#apno_' + $i;
			 		var apno_new = 'apno_' + ($i-1);
			 		$(apno).val(($i-1));
			 		$(apno).attr({"id":apno_new, "name":apno_new});

			 		var apitem = '#apitem_' + $i;
			 		var apitem_new = 'apitem_' + ($i-1);
			 		$(apitem).attr({"id":apitem_new, "name":apitem_new});

			 		var apnominal = '#apnominal_' + $i;
			 		var apnominal_new = 'apnominal_' + ($i-1);
			 		$(apnominal).attr({"id":apnominal_new, "name":apnominal_new});

			 		var aptolerance = '#aptolerance_' + $i;
			 		var aptolerance_new = 'aptolerance_' + ($i-1);
			 		$(aptolerance).attr({"id":aptolerance_new, "name":aptolerance_new});

			 		var apinstrument = '#apinstrument_' + $i;
			 		var apinstrument_new = 'apinstrument_' + ($i-1);
			 		$(apinstrument).attr({"id":apinstrument_new, "name":apinstrument_new});

			 		var aprank = '#aprank_' + $i;
			 		var aprank_new = 'aprank_' + ($i-1);
			 		$(aprank).attr({"id":aprank_new, "name":aprank_new});

			 		var approses = '#approses_' + $i;
			 		var approses_new = 'approses_' + ($i-1);
			 		$(approses).attr({"id":approses_new, "name":approses_new});

			 		var apdelivery = '#apdelivery_' + $i;
			 		var apdelivery_new = 'apdelivery_' + ($i-1);
			 		$(apdelivery).attr({"id":apdelivery_new, "name":apdelivery_new});

			 		var apremarks = "#apremarks_" + $i;
			 		var apremarks_new = "apremarks_" + ($i-1);
			 		$(apremarks).attr({"id":apremarks_new, "name":apremarks_new});

			 		var apbtndelete = "#apline_btndelete_" + $i;
			 		var apbtndelete_new = "apline_btndelete_" + ($i-1);
			 		$(apbtndelete).attr({"id":apbtndelete_new, "name":apbtndelete_new});

			 		var id_field6 = "#line_field6_" + $i;
			 		var id_field6_new = "line_field6_" + ($i-1);
			 		$(id_field6).attr({"id":id_field6_new, "name":id_field6_new});

			 	}
			 	jml_rows = jml_rows - 1;
			 	document.getElementById("jml_rows").value = jml_rows;
			 	console.log(document.getElementById("jml_rows").value);

			 }




	      //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	      /////III. DIMENSION

	      $("#dimention").click(function(){
	      	var jml_input1 = document.getElementById("jml_input1").value.trim();
	      	jml_input1 = Number(jml_input1) + 1;
	      	document.getElementById("jml_input1").value = jml_input1  ;

	      	var dno = 'dno_'+jml_input1;
	      	var ditem = 'ditem_'+jml_input1;
	      	var dnominal = 'dnominal_'+jml_input1;
	      	var dtolerance = 'dtolerance_'+jml_input1;
	      	var dinstrument = 'dinstrument_'+jml_input1;
	      	var drank = 'drank_'+jml_input1;
	      	var dproses = 'dproses_'+jml_input1;
	      	var ddelivery = 'ddelivery_'+jml_input1;
	      	var dremarks = 'dremarks_'+jml_input1;
	      	var dbtndelete = 'dline_btndelete_'+jml_input1;
	      	var id_field7 = 'line_field7_'+jml_input1;
	      	$("#dynamic_field7").append(
	      		'<tr id="'+id_field7+'">\
	      		<td>\
	      			<input type="text" id="' +dno+ '" name="' +dno+ '" placeholder="" class="form-control name_list" value="'+jml_input1+'" align="center"/>\
	      		</td>\
	      		<td>\
	      			<div class="input-group">\
	      				<input type="text" id="' +ditem+ '" name="' +ditem+ '" onchange="validatejam(this)" placeholder="" class="form-control name_list"  value="" />\
	      			</div>\
	      		</td>\
	      		<td>\
	      			<div class="input-group">\
	      				<input type="text" id="' +dnominal+ '" name="' +dnominal+ '" onchange="validatepart(this)" placeholder="" class="form-control name_list"  value=""/>\
	      			</div>\
	      		</td>\
	      		<td>\
	      			<input type="text" id="' +dtolerance+ '" name="' +dtolerance+ '" placeholder="" class="form-control name_list" />\
	      		</td>\
	      		<td>\
	      			<input type="text" id="' +dinstrument+ '" name="' +dinstrument+ '" placeholder="" class="form-control name_list" />\
	      		</td>\
	      		<td>\
	      			<input type="text" id="' +drank+ '" name="' +drank+ '" placeholder="" class="form-control name_list" />\
	      		</td>\
	      		<td>\
	      			<input type="text" id="' +dproses+ '" name="' +dproses+ '" placeholder="" class="form-control name_list" />\
	      		</td>\
	      		<td>\
	      			<input type="text" id="' +ddelivery+ '" name="' +ddelivery+ '" placeholder="" class="form-control name_list" />\
	      		</td>\
	      		<td>\
	      			<input type="text" id="' +dremarks+ '" name="' +dremarks+ '" placeholder="" class="form-control name_list" />\
	      		</td>\
	      		<td>\
	      			<button id="' + dbtndelete + '" name="' + dbtndelete + '" type="button" class="btn btn-danger btn-sm" onclick="dbtndelete(this)">\
	      				<i class="fa fa-times"></i>\
	      			</button>\
	      		</td>\
	      	</tr>'
	      	);
	      });

	      function dbtndelete(ths) {
	      	var msg = 'Anda yakin menghapus Baris ini?';
	      	swal({
	      		title: msg,
	      		text: "",
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
	          //startcode
	          var row = ths.id.replace('dline_btndelete_', '');
	          var info = "";
	          var info2 = "";
	          var info3 = "warning";
	          var dno = document.getElementById("dno_" + row).value.trim();
	          // var no_pisigp = document.getElementById("no_pisigp").value.trim();
	          changeKdLine7(row);
	          //finishcode

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

	      function changeKdLine7(row) {
	      	var id_field7 = "#line_field7_" + row;
	      	$(id_field7).remove();

	      	var jml_input1 = document.getElementById("jml_input1").value.trim();
	      	jml_input1 = Number(jml_input1);  
	      	nextRow = Number(row) + 1;
	      	for($i = nextRow; $i <= jml_input1; $i++) {
	      		var dno = '#dno_' + $i;
	      		var dno_new = 'dno_' + ($i-1);
	      		$(dno).val(($i-1));
	      		$(dno).attr({"id":dno_new, "name":dno_new});

	      		var ditem = '#ditem_' + $i;
	      		var ditem_new = 'ditem_' + ($i-1);
	      		$(ditem).attr({"id":ditem_new, "name":ditem_new});

	      		var dnominal = '#dnominal_' + $i;
	      		var dnominal_new = 'dnominal_' + ($i-1);
	      		$(dnominal).attr({"id":dnominal_new, "name":dnominal_new});

	      		var dtolerance = '#dtolerance_' + $i;
	      		var dtolerance_new = 'dtolerance_' + ($i-1);
	      		$(dtolerance).attr({"id":dtolerance_new, "name":dtolerance_new});


	      		var dinstrument = '#dinstrument_' + $i;
	      		var dinstrument_new = 'dinstrument_' + ($i-1);
	      		$(dinstrument).attr({"id":dinstrument_new, "name":dinstrument_new});

	      		var drank = '#drank_' + $i;
	      		var drank_new = 'drank_' + ($i-1);
	      		$(drank).attr({"id":drank_new, "name":drank_new});

	      		var dproses = '#dproses_' + $i;
	      		var dproses_new = 'dproses_' + ($i-1);
	      		$(dproses).attr({"id":dproses_new, "name":dproses_new});

	      		var ddelivery = '#ddelivery_' + $i;
	      		var ddelivery_new = 'ddelivery_' + ($i-1);
	      		$(ddelivery).attr({"id":ddelivery_new, "name":ddelivery_new});

	      		var dremarks = "#dremarks_" + $i;
	      		var dremarks_new = "dremarks_" + ($i-1);
	      		$(dremarks).attr({"id":dremarks_new, "name":dremarks_new});

	      		var dbtndelete = "#dline_btndelete_" + $i;
	      		var dbtndelete_new = "dline_btndelete_" + ($i-1);
	      		$(dbtndelete).attr({"id":dbtndelete_new, "name":dbtndelete_new});

	      		var id_field7 = "#line_field7_" + $i;
	      		var id_field7_new = "line_field7_" + ($i-1);
	      		$(id_field7).attr({"id":id_field7_new, "name":id_field7_new});

	      	}
	      	jml_input1 = jml_input1 - 1;
	      	document.getElementById("jml_input1").value = jml_input1;
	      	console.log(document.getElementById("jml_input1").value);

	      }

	      //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	      /////IV. SOC FREE
	      $("#socfree").click(function(){
	      	var inputhidden = document.getElementById("inputhidden").value.trim();
	      	inputhidden = Number(inputhidden) + 1;
	      	document.getElementById("inputhidden").value = inputhidden  ;

	      	var scno = 'scno_'+inputhidden;
	      	var scitem = 'scitem_'+inputhidden;
	      	var scinstrument = 'scinstrument_'+inputhidden;
	      	var scrank = 'scrank_'+inputhidden;
	      	var scproses = 'scproses_'+inputhidden;
	      	var scdeivery = 'scdeivery_'+inputhidden;
	      	var scremarks = 'scremarks_'+inputhidden;
	      	var scbtndelete = 'scline_btndelete_'+inputhidden;
	      	var id_field8 = 'line_field8_'+inputhidden;


	      	$("#dynamic_field8").append(
	      		'<tr id="'+id_field8+'">\
	      		<td>\
	      			<input type="text" id="' +scno+ '" name="' +scno+ '" placeholder="" class="form-control name_list" value="'+inputhidden+'" align="center"/>\
	      		</td>\
	      		<td>\
	      			<div class="input-group">\
	      				<input type="text" id="' +scitem+ '" name="' +scitem+ '" onchange="validatejam(this)" placeholder="" class="form-control name_list"  value="" />\
	      			</div>\
	      		</td>\
	      		<td>\
	      			<input type="text" id="' +scinstrument+ '" name="' +scinstrument+ '" placeholder="" class="form-control name_list" />\
	      		</td>\
	      		<td>\
	      			<input type="text" id="' +scrank+ '" name="' +scrank+ '" placeholder="" class="form-control name_list" />\
	      		</td>\
	      		<td>\
	      			<input type="text" id="' +scproses+ '" name="' +scproses+ '" placeholder="" class="form-control name_list" />\
	      		</td>\
	      		<td>\
	      			<input type="text" id="' +scdeivery+ '" name="' +scdeivery+ '" placeholder="" class="form-control name_list" />\
	      		</td>\
	      		<td>\
	      			<input type="text" id="' +scremarks+ '" name="' +scremarks+ '" placeholder="" class="form-control name_list" />\
	      		</td>\
	      		<td>\
	      			<button id="' + scbtndelete + '" name="' + scbtndelete + '" type="button" class="btn btn-danger btn-sm" onclick="scbtndelete(this)">\
	      				<i class="fa fa-times"></i>\
	      			</button>\
	      		</td>\
	      	</tr>'
	      	);
	      });

	      function scbtndelete(ths) {
	      	var msg = 'Anda yakin menghapus Baris ini?';
	      	swal({
	      		title: msg,
	      		text: "",
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
	          //startcode
	          var row = ths.id.replace('scline_btndelete_', '');
	          var info = "";
	          var info2 = "";
	          var info3 = "warning";
	          var scno = document.getElementById("scno_" + row).value.trim();
	          // var no_pisigp = document.getElementById("no_pisigp").value.trim();
	          changeKdLine8(row);
	          //finishcode

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

	      function changeKdLine8(row) {
	      	var id_field8 = "#line_field8_" + row;
	      	$(id_field8).remove();

	      	var inputhidden = document.getElementById("inputhidden").value.trim();
	      	inputhidden = Number(inputhidden);  
	      	nextRow = Number(row) + 1;
	      	for($i = nextRow; $i <= inputhidden; $i++) {
	      		var scno = '#scno_' + $i;
	      		var scno_new = 'scno_' + ($i-1);
	      		$(scno).val(($i-1));
	      		$(scno).attr({"id":scno_new, "name":scno_new});

	      		var scitem = '#scitem_' + $i;
	      		var scitem_new = 'scitem_' + ($i-1);
	      		$(scitem).attr({"id":scitem_new, "name":scitem_new});


	      		var scinstrument = '#scinstrument_' + $i;
	      		var scinstrument_new = 'scinstrument_' + ($i-1);
	      		$(scinstrument).attr({"id":scinstrument_new, "name":scinstrument_new});

	      		var scrank = '#scrank_' + $i;
	      		var scrank_new = 'scrank_' + ($i-1);
	      		$(scrank).attr({"id":scrank_new, "name":scrank_new});

	      		var scproses = '#scproses_' + $i;
	      		var scproses_new = 'scproses_' + ($i-1);
	      		$(scproses).attr({"id":scproses_new, "name":scproses_new});

	      		var scdeivery = '#scdeivery_' + $i;
	      		var scdeivery_new = 'scdeivery_' + ($i-1);
	      		$(scdeivery).attr({"id":scdeivery_new, "name":scdeivery_new});

	      		var scremarks = "#scremarks_" + $i;
	      		var scremarks_new = "scremarks_" + ($i-1);
	      		$(scremarks).attr({"id":scremarks_new, "name":scremarks_new});

	      		var scbtndelete = "#scline_btndelete_" + $i;
	      		var scbtndelete_new = "scline_btndelete_" + ($i-1);
	      		$(scbtndelete).attr({"id":scbtndelete_new, "name":scbtndelete_new});

	      		var id_field8 = "#line_field8_" + $i;
	      		var id_field8_new = "line_field8_" + ($i-1);
	      		$(id_field8).attr({"id":id_field8_new, "name":id_field8_new});

	      	}
	      	inputhidden = inputhidden - 1;
	      	document.getElementById("inputhidden").value = inputhidden;
	      	console.log(document.getElementById("inputhidden").value);

	      }

			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	       //PART ROUTING
	    //    $("#partrouting").click(function(){
	    //    	var barishidden = document.getElementById("barishidden").value.trim();
	    //    	barishidden = Number(barishidden) + 1;
	    //    	document.getElementById("barishidden").value = barishidden  ;
	    //    	var pno = 'pno_'+barishidden;
	    //    	var plevel = 'plevel_'+barishidden;
	    //    	var ppart_no = 'ppart_no_'+barishidden;
	    //    	var ppart_name = 'ppart_name_'+barishidden;
	    //    	var pproses = 'pproses_'+barishidden;
	    //    	var psupplier = 'psupplier_'+barishidden;
	    //    	var pbtndelete = 'pline_btndelete_'+barishidden;
	    //    	var id_field9 = 'line_field9_'+barishidden;
	    //    	$("#dynamic_field9").append(
	    //    		'<tr id="'+id_field9+'">\
	    //    		\
	    //    		<td>\
	    //    			<input type="text" id="' +plevel+ '" name="' +plevel+ '" placeholder="" class="form-control name_list" value="" align="center"/>\
	    //    		</td>\
	    //    		<td>\
	    //    			<div class="input-group">\
	    //    				<input type="text" id="' +ppart_no+ '" name="' +ppart_no+ '" onchange="validatejam(this)" placeholder="" class="form-control name_list"  value="" />\
	    //    			</div>\
	    //    		</td>\
	    //    		<td>\
	    //    			<div class="input-group">\
	    //    				<input type="text" id="' +ppart_name+ '" name="' +ppart_name+ '" onchange="validatepart(this)" placeholder="" class="form-control name_list"  value=""/>\
	    //    			</div>\
	    //    		</td>\
	    //    		<td>\
	    //    			<input type="text" id="' +pproses+ '" name="' +pproses+ '" placeholder="" class="form-control name_list" />\
	    //    		</td>\
	    //    		<td>\
	    //    			<input type="text" id="' +psupplier+ '" name="' +psupplier+ '" placeholder="" class="form-control name_list" />\
	    //    		</td>\
	    //    		<td>\
	    //    			<button id="' + pbtndelete + '" name="' + pbtndelete + '" type="button" class="btn btn-danger btn-sm" onclick="deleteLine(this)">\
	    //    				<i class="fa fa-times"></i>\
	    //    			</button>\
	    //    		</td>\
	    //    	</tr>'
	    //    	);


	    //    });

	    //    function deleteLine(ths) {
	    //    	var msg = 'Anda yakin menghapus Line ini?';
	    //    	swal({
	    //    		title: msg,
	    //    		text: "",
	    //    		type: 'warning',
	    //    		showCancelButton: true,
	    //    		confirmButtonColor: '#3085d6',
	    //    		cancelButtonColor: '#d33',
	    //    		confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, delete it!',
	    //    		cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
	    //    		allowOutsideClick: true,
	    //    		allowEscapeKey: true,
	    //    		allowEnterKey: true,
	    //    		reverseButtons: false,
	    //    		focusCancel: true,
	    //    	}).then(function () {
	    //       //startcode
	    //       var row = ths.id.replace('line_btndelete_', '');
	    //       var info = "";
	    //       var info2 = "";
	    //       var info3 = "warning";
	    //       var no = document.getElementById("no_" + row).value.trim();
	    //       var no_doc = document.getElementById("no_doc").value.trim();
	    //       if(no === "" || no === "0" ||  no_doc === "" || no_doc === "0" ) {
	    //       	changeKdLine(row);
	    //       } else {
	    //         //DELETE DI DATABASE
	    //         // remove these events;
	    //         window.onkeydown = null;
	    //         window.onfocus = null;
	    //         var token = document.getElementsByName('_token')[0].value.trim();
	    //         // delete via ajax
	    //         // hapus data detail dengan ajax
	    //         var url = '{{ route('tlhpn01s.deleteLine', ['param','param2']) }}';
	    //         url = url.replace('param', window.btoa(no_doc));
	    //         url = url.replace('param2', window.btoa(no));

	    //         $.ajax({
	    //         	type     : 'POST',
	    //         	url      : url,
	    //         	dataType : 'json',
	    //         	data     : {
	    //         		_method : 'DELETE',
	    //         		_token  : token
	    //         	},
	    //         	success:function(data){
	    //         		if(data.status === 'OK'){
	    //         			changeKdLine(row);
	    //         			info = "Deleted!";
	    //         			info2 = data.message;
	    //         			info3 = "success";
	    //         			swal(info, info2, info3);
	    //         		} else {
	    //         			info = "Cancelled";
	    //         			info2 = data.message;
	    //         			info3 = "error";
	    //         			swal(info, info2, info3);
	    //         		}
	    //         	}, error:function(){ 
	    //         		info = "System Error!";
	    //         		info2 = "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.";
	    //         		info3 = "error";
	    //         		swal(info, info2, info3);
	    //         	}
	    //         });
	    //         //END DELETE DI DATABASE
	    //     }
	    //       //finishcode
	    //   }, function (dismiss) {
	    //       // dismiss can be 'cancel', 'overlay',
	    //       // 'close', and 'timer'
	    //       if (dismiss === 'cancel') {
	    //         // swal(
	    //         //   'Cancelled',
	    //         //   'Your imaginary file is safe :)',
	    //         //   'error'
	    //         // )
	    //     }
	    // })
	    //    }

	    //    function changeKdLine(row) {
	    //    	var id_field = "#line_field_" + row;
	    //    	$(id_field).remove();

	    //    	var barishidden = document.getElementById("barishidden").value.trim();
	    //    	barishidden = Number(barishidden);  
	    //    	nextRow = Number(row) + 1;
	    //    	for($i = nextRow; $i <= barishidden; $i++) {
	    //    		var no = '#no_' + $i;
	    //    		var no_new = 'no_' + ($i-1);
	    //    		$(no).attr({"id":no_new, "name":no_new});

	    //    		var jam = '#jam_' + $i;
	    //    		var jam_new = 'jam_' + ($i-1);
	    //    		$(jam).attr({"id":jam_new, "name":jam_new});

	    //    		var part_no = '#part_no_' + $i;
	    //    		var part_no_new = 'part_no_' + ($i-1);
	    //    		$(part_no).attr({"id":part_no_new, "name":part_no_new});

	    //    		var qty = '#qty_' + $i;
	    //    		var qty_new = 'qty_' + ($i-1);
	    //    		$(qty).attr({"id":qty_new, "name":qty_new});

	    //    		var btndelete = '#line_btndelete_' + $i;
	    //    		var btndelete_new = 'line_btndelete_' + ($i-1);
	    //    		$(btndelete).attr({"id":btndelete_new, "name":btndelete_new});

	    //    		var btnpopupshift = '#line_btnpopupshift_' + $i;
	    //    		var btnpopupshift_new = 'line_btnpopupshift_' + ($i-1);
	    //    		$(btnpopupshift).attr({"id":btnpopupshift_new, "name":btnpopupshift_new});

	    //    		var btnpopuppart = '#line_btnpopuppart_' + $i;
	    //    		var btnpopuppart_new = 'line_btnpopuppart_' + ($i-1);
	    //    		$(btnpopuppart).attr({"id":btnpopuppart_new, "name":btnpopuppart_new});

	    //    		var id_field = "#line_field_" + $i;
	    //    		var id_field_new = "line_field_" + ($i-1);
	    //    		$(id_field).attr({"id":id_field_new, "name":id_field_new});

	    //    		var text = document.getElementById(no_new).innerHTML;
	    //    		text = text.replace($i, ($i-1));
	    //    		document.getElementById(no_new).innerHTML = text;

	    //    	}
	    //    	barishidden = barishidden - 1;
	    //    	document.getElementById("barishidden").value = barishidden;

	    //    }


	       ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	</script>
 @endsection

