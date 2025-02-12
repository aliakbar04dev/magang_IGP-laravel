<div class="box-body ">
  <div class="col-md-6">    
   <div class="form-group{{ $errors->has('kd_plant') ? ' has-error' : '' }}">          
    <div class="col-md-6">
      {!! Form::label('pt', 'PT (*)') !!}
      <div class="input-group">
        {!! Form::select('pt', ['IGP' => 'INTI GANDA PERDANA', 'GKD' => 'GEMALA KEMPA DAYA', 'AWI' => 'AKASHI WAHANA INDONESIA', 'AGI' => 'ASANO GEAR INDONESIA'], null, ['class'=>'form-control select2', 'id' => 'pt', 'required']) !!} 
      </div>
    </div>
    <div class="col-md-6">
      {!! Form::label('kd_plant', 'Plant (*)') !!}
      <div class="input-group">
        <select id="kd_plant" name="kd_plant" class="form-control select2">
          <option value="">-</option>         
          @foreach($plants->get() as $kodePlant)
          <option value="{{$kodePlant->kd_plant}}"
            @if (!empty($tcalorder1->kd_plant))
            {{ $kodePlant->kd_plant == $tcalorder1->kd_plant ? 'selected="selected"' : '' }}
            @endif 
            >{{$kodePlant->nm_plant}}</option>      
            @endforeach
          </select>              
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-6{{ $errors->has('no_order') ? ' has-error' : '' }}">
       {!! Form::label('no_order', 'No Order') !!}      
       {!! Form::text('no_order', null, ['class'=>'form-control','required', 'readonly' => '','placeholder' => 'No Order']) !!}
       {!! $errors->first('no_order', '<p class="help-block">:message</p>') !!}
     </div>
     <div class="col-md-6{{ $errors->has('tgl_order') ? ' has-error' : '' }}">
       {!! Form::label('tgl_order', 'Tanggal Order') !!}
       @if (empty($tcalorder1->tgl_order))
       {!! Form::date('tgl_order', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => \Carbon\Carbon::now()]) !!}
       @else
       {!! Form::date('tgl_order', \Carbon\Carbon::parse($tcalorder1->tgl_order), ['class'=>'form-control']) !!}
       @endif
       {!! $errors->first('tgl_order', '<p class="help-block">:message</p>') !!}
     </div>
   </div> 
   <div class="form-group">
    <div class="col-md-4{{ $errors->has('kd_cust') ? ' has-error' : '' }}">
     {!! Form::label('kd_cust', 'Customer (F9)(*)') !!}      
     <div class="input-group">
      {!! Form::text('kd_cust', null, ['class'=>'form-control','placeholder' => 'Customer','onkeydown' => 'btnpopupCustClick(event)', 'onchange' => 'validateCust()','required']) !!} 
      <span class="input-group-btn">
        <button id="btnpopupCust" type="button" class="btn btn-info" data-toggle="modal" data-target="#custModal">
          <label class="glyphicon glyphicon-search"></label>
        </button>
      </span>
    </div>
    {!! $errors->first('kd_cust', '<p class="help-block">:message</p>') !!}
  </div>
  <div class="col-md-8">
    {!! Form::label('nm_cust', 'Nama Customer') !!}      
    {!! Form::text('nm_cust', null, ['class'=>'form-control','placeholder' => 'Nama Customer', 'disabled'=>'']) !!} 
  </div>
</div>
<div class="form-group">  
  <div class="col-md-6{{ $errors->has('tgl_estimasi') ? ' has-error' : '' }}">
   {!! Form::label('tgl_estimasi', 'Tanggal Estimasi') !!}
   @if (empty($tcalorder1->tgl_estimasi))
   {!! Form::date('tgl_estimasi', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => \Carbon\Carbon::now()]) !!}
   @else
   {!! Form::date('tgl_estimasi', \Carbon\Carbon::parse($tcalorder1->tgl_estimasi), ['class'=>'form-control']) !!}
   @endif
   {!! $errors->first('tgl_estimasi', '<p class="help-block">:message</p>') !!}
 </div>
 <div class="col-md-6{{ $errors->has('tgl_estimasi_serti') ? ' has-error' : '' }}">
   {!! Form::label('tgl_estimasi_serti', 'Tanggal Estimasi Sertifikat') !!}
   @if (empty($tcalorder1->tgl_estimasi_serti))
   {!! Form::date('tgl_estimasi_serti', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => \Carbon\Carbon::now()]) !!}
   @else
   {!! Form::date('tgl_estimasi_serti', \Carbon\Carbon::parse($tcalorder1->tgl_estimasi_serti), ['class'=>'form-control']) !!}
   @endif
   {!! $errors->first('tgl_estimasi_serti', '<p class="help-block">:message</p>') !!}
 </div>
</div> 
<!-- /.form-group -->
<div class="form-group">
  <div class="col-md-4">
   <p class="help-block">(*) tidak boleh kosong</p>
   {!! Form::hidden('jml_tbl_detail', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_tbl_detail']) !!}
 </div>
</div>
</div>  
<div class="col-md-6">  
  <div class="form-group">
    <center>
      <p>
        {!! Html::image(asset('images/no_image.png'), 'File Not Found', ['id'=>'imgAlatUkur', 'name'=>'imgAlatUkur', 'width'=>'300px', 'height'=>'150px']) !!}        
      </p>
    </center>
  </div>
</div>
<!-- /.box-body -->   
</div>
<!-- /.box-body -->
<div class="box-body">
  <div class="row">
   <div class="col-md-12">
    <div class="box box-primary">
     <div class="box-header with-border">
      <h3 class="box-title">Detail</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">            
      @include('datatable._action-addrem')
      <table id="tblDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
       <thead>
        <tr>
         <th style="width: 2%;">No</th>
         <th style="width: 16%;">No Seri<font color='red'>&nbsp;(F9)(*)</font></th>
         <th style="width: 20%;">Nama Alat Ukur</th>
         <th style="width: 7%;">Kode Barang<font color='red'>&nbsp;(F9)(*)</font></th> 
         <th style="width: 20%;">Nama Barang</th>                          
         <th style="width: 7%;">Spesifikasi</th>
         <th style="width: 7%;">Resolusi</th>
         <th style="width: 7%;">Titik Ukur</th>
         <th style="width: 7%;">Keterangan</th>
         <th style="width: 7%;">No Sertifikat</th>
         <th style="width: 7%;">Harga Unit</th>
       </tr>
     </thead>
     <tbody>
      @if (!empty($tcalorder1->no_order)) 
      @foreach ($model->tcalorder1Det($tcalorder1->no_order)->get() as $tcalorder2)
      <tr>
       <td>{{ $loop->iteration }}</td>
       <td><input type='hidden' value="row-{{ $loop->iteration }}-no_seri"><input type='text' id="row-{{ $loop->iteration }}-no_seri" name="row-{{ $loop->iteration }}-no_seri" value='{{ $tcalorder2->no_seri }}' size='16' maxlength='100' onkeydown='popupNoseri(event)' onchange='validateNoseri(event)' required><input type='hidden' id="row-{{ $loop->iteration }}-id" name="row-{{ $loop->iteration }}-id" value='0' readonly='readonly'></td>
       <td><textarea id="row-{{ $loop->iteration }}-nm_alatukur" name="row-{{ $loop->iteration }}-nm_alatukur" rows='2' cols='20' disabled='' style='text-transform:uppercase;resize:vertical'>{{ $model->getNoSeri($tcalorder2->no_seri, $tcalorder1->kd_plant) }}</textarea></td>
       <td><input type='text' id="row-{{ $loop->iteration }}-kd_brg" name="row-{{ $loop->iteration }}-kd_brg" value='{{ $tcalorder2->kd_brg }}' size='8' maxlength='8' onkeydown='popupBarang(event)' onchange='validateBarang(event)' required></td>
       <td><textarea id="row-{{ $loop->iteration }}-nm_brg" name="row-{{ $loop->iteration }}-nm_brg" rows='2' cols='20' disabled='' style='text-transform:uppercase;resize:vertical'>{{ $model->getNmBrg($tcalorder2->kd_brg) }}</textarea></td>
       <td><input type='text' id="row-{{ $loop->iteration }}-nm_spec" name="row-{{ $loop->iteration }}-nm_spec" value='{{ $tcalorder2->nm_spec }}' size='8' maxlength='30'></td>
       <td><input type='text' id="row-{{ $loop->iteration }}-nm_reso" name="row-{{ $loop->iteration }}-nm_reso" value='{{ $tcalorder2->nm_reso }}' size='8' maxlength='30'></td>
       <td><input type='text' id="row-{{ $loop->iteration }}-jml_titik" name="row-{{ $loop->iteration }}-jml_titik" value='{{ $tcalorder2->jml_titik }}' size='8' maxlength='30'></td>
       <td><input type='text' id="row-{{ $loop->iteration }}-ket" name="row-{{ $loop->iteration }}-ket" value='{{ $tcalorder2->ket }}' size='16' maxlength='30'></td>
       <td><input type='text' id="row-{{ $loop->iteration }}-no_serti" name="row-{{ $loop->iteration }}-no_serti" value='{{ $tcalorder2->no_serti }}' size='30' maxlength='30' disabled=''><input type='hidden' id="row-{{ $loop->iteration }}-lok_pict" name="row-{{ $loop->iteration }}-lok_pict" value='{{ $model->getImage($tcalorder2->no_seri) }}' size='30' maxlength='30'><input type='hidden' id="row-{{ $loop->iteration }}-kd_au" name="row-{{ $loop->iteration }}-kd_au" value='{{ $tcalorder2->kd_au }}'></td>
       <td><input type='number' id="row-{{ $loop->iteration }}-hrg_unit" name="row-{{ $loop->iteration }}-hrg_unit" value='{{ $tcalorder2->hrg_unit }}'></td>
     </tr>
     @endforeach
     @endif               
   </tbody>
 </table>
</div>
<!-- /.box-body -->
</div>
<!-- /.box -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->
</div>
<!-- /.box-body -->
<div class="box-footer">
  {!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  &nbsp;&nbsp;
  @if (!empty($tcalorder1->no_order))
  <button id="btn-delete" type="button" class="btn btn-danger">Delete</button>
  &nbsp;&nbsp;
  <button id="btn-print" type="button" class="btn btn-primary">Print Tag</button>
  &nbsp;&nbsp;
  @endif
  <a class="btn btn-default" href="{{ route('kalibrasi.index') }}">Cancel</a>
</div>
<!-- Popup NoSeri Modal -->
@include('eqa.kalibrasi.popup.noseriModal')
<!-- Popup Barang Modal -->
@include('eqa.kalibrasi.popup.barangModal')
<!-- Popup Cust Modal -->
@include('eqa.kalibrasi.popup.custModal')

@section('scripts')
<script type="text/javascript">

  document.getElementById("pt").focus();

  function autoUpperCase(a){
    a.value = a.value.toUpperCase();
  }   
    //Initialize Select2 Elements
    $(".select2").select2();

    $(document).ready(function(){
      $("#btnpopupCust").click(function(){
        popupCust();
      });

      $("#btn-print").click(function(){
        printTag();
      });

      var kode = document.getElementById("kd_cust").value.trim();     
      if(kode !== '') {
        var url = '{{ route('datatables.validasiCustQa', ['param']) }}';
        url = url.replace('param', window.btoa(kode));
            //use ajax to run the check
            $.get(url, function(result){  
              if(result !== 'null'){
                result = JSON.parse(result);
                document.getElementById("nm_cust").value = result["nm_cust"];
              }
            });
          }

      //MEMBUAT TABEL DETAIL
      var table = $('#tblDetail').DataTable({
        "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
        "iDisplayLength": 10,
        //responsive: true,
        'searching': false,
        "ordering": false,
        "scrollX": "true",
        "scrollY": "500px",
        "scrollCollapse": true,
        "paging": false
      });
      
      document.getElementById("removeRow").disabled = true;

      var counter = table.rows().count();
      document.getElementById("jml_tbl_detail").value = counter;

      $("#btn-delete").click(function(){
        var no_order = document.getElementById("no_order").value;
        if(no_order !== "") {
          var msg = 'Anda yakin menghapus data ini?';
          var txt = 'No Order: ' + no_order;
          swal({
            title: msg,
            text: txt,
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
            var urlRedirect = "{{ route('kalibrasi.delete', 'param') }}";
            urlRedirect = urlRedirect.replace('param', window.btoa(no_order));
            window.location.href = urlRedirect;
          }, function (dismiss) {
            if (dismiss === 'cancel') {
            }
          })
        }
      });

      $('#addRow').on( 'click', function () {
        tambahBaris(table);
      });

      $('#tblDetail tbody').on( 'click', 'tr', function () {    
        if ( $(this).hasClass('selected') ) {
          $(this).removeClass('selected');
          document.getElementById("removeRow").disabled = true;      
        } else {
          table.$('tr.selected').removeClass('selected');
          $(this).addClass('selected');
          document.getElementById("removeRow").disabled = false;
          //untuk memunculkan gambar
          var row = table.row('.selected').index();
          changeImage(row);      
        }
      });

      $('#removeRow').click( function () {
       var table = $('#tblDetail').DataTable();
       counter = table.rows().count()-1;
       document.getElementById("jml_tbl_detail").value = counter;
       var index = table.row('.selected').index();
       var row = index;
       if(index == null) {
        swal("Tidak ada data yang dipilih!", "", "warning");
        } else {
          var target = 'row-' + (row+1) + '-';
          var id = document.getElementById(target +'id').value.trim();
          var no_order = document.getElementById("no_order").value;
          var no_seri = document.getElementById(target +'no_seri').value.trim();
          var kd_brg = document.getElementById(target +'kd_brg').value.trim();
          
          if(no_order === '') {
            changeId(row);
          } else {
            if(no_seri === '' || kd_brg === '') {
              changeId(row);
            }else{          
              swal({
                title: "Are you sure?",
                text: "No Seri: " + no_seri,
                type: "warning",
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
              var info = "";
              var info2 = "";
              var info3 = "warning";
              
            //DELETE DI DATABASE
            // remove these events;
            window.onkeydown = null;
            window.onfocus = null;
            var token = document.getElementsByName('_token')[0].value.trim();
            // delete via ajax
            // hapus data detail dengan ajax
            var url = "{{ route('kalibrasidet.hapus', ['param', 'param1', 'param2'])}}";
            url = url.replace('param',  window.btoa(no_order));
            url = url.replace('param1', window.btoa(no_seri));
            url = url.replace('param2', window.btoa(kd_brg));
            $.ajax({
              type     : 'POST',
              url      : url,
              dataType : 'json',
              data     : {
                _method : 'GET',
                // menambah csrf token dari Laravel
                _token  : token
              },
              success:function(data){
               if(data.status === 'OK'){
                changeId(row);
                info = "Deleted!";
                info2 = data.message;
                info3 = "success";
                swal(info, info2, info3);
              } else {
                info = "Cancelled";
                info2 = data.message;
                info3 = "error";
                swal(info, info2, info3);
              }
            }, error:function(){ 
              info = "System Error!";
              info2 = "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.";
              info3 = "error";
              swal(info, info2, info3);
            }
          });
            //END DELETE DI DATABASE

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
          }
        }
      });

      $('#removeAll').click( function () {
        var no_order = document.getElementById("no_order").value;
        swal({
          title: "Are you sure?",
          text: "Remove All Detail",
          type: "warning",
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
                        var info = "";
                        var info2 = "";
                        var info3 = "warning";

                        //DELETE DI DATABASE
                        // remove these events;
                        window.onkeydown = null;
                        window.onfocus = null;
                        var token = document.getElementsByName('_token')[0].value.trim();
                        // delete via ajax
                        // hapus data detail dengan ajax
                        var url = "{{ route('kalibrasidet.hapusdetail', 'param')}}";
                        url = url.replace('param',  window.btoa(no_order));
                        $.ajax({
                          type     : 'POST',
                          url      : url,
                          dataType : 'json',
                          data     : {
                            _method : 'GET',
                            // menambah csrf token dari Laravel
                            _token  : token
                          },
                          success:function(data){
                            if(data.status === 'OK'){
                              info = "Deleted!";
                              info2 = data.message;
                              info3 = "success";
                              swal(info, info2, info3);
                            //clear tabel
                            var table = $('#tblDetail').DataTable();
                            table.clear().draw(false);
                          } else {
                            info = "Cancelled";
                            info2 = data.message;
                            info3 = "error";
                            swal(info, info2, info3);
                          }
                        }, error:function(){ 
                          info = "System Error!";
                          info2 = "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.";
                          info3 = "error";
                          swal(info, info2, info3);
                        }
                      });

                      }, function (dismiss) {
                        if (dismiss === 'cancel') {
                        }
                      })    
      });
    });

    function btnpopupCustClick(e) {
        if(e.keyCode == 120) { //F9
          $('#btnpopupCust').click();
        } else if(e.keyCode == 9) { //TAB
          e.preventDefault();
          document.getElementById('kd_cust').focus();
        }
    }

    //POPUP CUST
    function popupCust() {
      var myHeading = "<p>Popup Cust</p>";
      $("#custModalLabel").html(myHeading);

      var url = '{{ route('datatables.popupCustQa') }}';
      var lookupCust = $('#lookupCust').DataTable({
        processing: true, 
        "oLanguage": {
          'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
        }, 
        serverSide: true,
        "pagingType": "numbers",
        ajax: url,
        "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
        responsive: true,
        "order": [[0, 'asc']],
        columns: [
        { data: 'kd_cust', name: 'kd_cust'},
        { data: 'nm_cust', name: 'nm_cust'}
        ],
        "bDestroy": true,
        "initComplete": function(settings, json) {
          $('div.dataTables_filter input').focus();
          $('#lookupCust tbody').on( 'dblclick', 'tr', function () {
            var dataArr = [];
            var rows = $(this);
            var rowData = lookupCust.rows(rows).data();
            $.each($(rowData),function(key,value){
              document.getElementById("kd_cust").value = value["kd_cust"];
              document.getElementById("nm_cust").value = value["nm_cust"];
              $('#custModal').modal('hide');
              validateCust();
            });
          });
          $('#custModal').on('hidden.bs.modal', function () {
            var kode = document.getElementById("kd_cust").value.trim();
            if(kode === '') {
              $('#kd_cust').focus();
            } else {
              $('#tgl_estimasi').focus();
            }
          });
        },
      });     
    }

    //VALIDASI CUST
    function validateCust() {
      var kode = document.getElementById("kd_cust").value.trim();     
      if(kode !== '') {
        var url = '{{ route('datatables.validasiCustQa', ['param']) }}';
        url = url.replace('param', window.btoa(kode));
              //use ajax to run the check
              $.get(url, function(result){  
                if(result !== 'null'){
                  result = JSON.parse(result);
                  document.getElementById("nm_cust").value = result["nm_cust"];
                  document.getElementById("tgl_estimasi").focus();
                } else {
                  document.getElementById("kd_cust").value = "";
                  document.getElementById("nm_cust").value = "";
                  document.getElementById("kd_cust").focus();
                  swal("Customer tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
                }
              });
            } else {
              document.getElementById("kd_cust").value = "";
              document.getElementById("nm_cust").value = "";
            }   
          }

    //POPUP NOSERI
    function popupNoseri(e) {
      if(e.keyCode == 120 || e.keyCode == 13) {
          var kd_plant = document.getElementById("kd_plant").value.trim();
          var pt = document.getElementById("pt").value.trim();
          if(kd_plant === ''){
            kd_plant = '-';
          } 
          var myHeading = "<p>Popup No Seri</p>";
          $("#noseriModalLabel").html(myHeading);
          var url = '{{ route('datatables.popupNoseri', ['param','param1']) }}';
          url = url.replace('param', window.btoa(kd_plant));
          url = url.replace('param1', window.btoa(pt));
          $('#noseriModal').modal('show');
          var lookupNoseri = $('#lookupNoseri').DataTable({
            processing: true, 
            "oLanguage": {
              'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
            }, 
            serverSide: true,
            pagingType: "simple",
            "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
            ajax: url,
            columns: [
            { data: 'id_no', name: 'id_no'},
            { data: 'nm_alat', name: 'nm_alat'},
            { data: 'maker', name: 'maker'},
            { data: 'spec', name: 'spec'},
            { data: 'res', name: 'res'},
            { data: 'titik_ukur', name: 'titik_ukur'},
            { data: 'keterangan', name: 'keterangan'},
            { data: 'lok_pict', name: 'lok_pict', visible:false}
            ],
            "bDestroy": true,
            "initComplete": function(settings, json) {
             $('div.dataTables_filter input').focus();
             $('#lookupNoseri tbody').on( 'dblclick', 'tr', function () {
              var dataArr = [];
              var rows = $(this);
              var rowData = lookupNoseri.rows(rows).data();
              $.each($(rowData),function(key,value){
               var id = e.target.id.replace('no_seri', '');
               document.getElementById(e.target.id).value = value["id_no"];
               document.getElementById(id +'nm_alatukur').value = value["nm_alat"];
               document.getElementById(id +'nm_spec').value = value["spec"];
               document.getElementById(id +'nm_reso').value = value["res"];
               document.getElementById(id +'jml_titik').value = value["titik_ukur"];
               document.getElementById(id +'ket').value = value["keterangan"];
               document.getElementById(id +'lok_pict').value = value["lok_pict"];
               document.getElementById(id +'kd_au').value = value["kd_au"];
                 //untuk memunculkan gambar
                 var row = id.replace('row-', '');
                 row = row.replace('-', '');
                 row = row-1;
                 changeImage(row);
                 $('#noseriModal').modal('hide');
                 if(validateNoseriDuplicate(e.target.id)) {
                  document.getElementById(id +'no_seri').focus();
                } else {
                  document.getElementById(e.target.id).value = "";
                  document.getElementById(id +'nm_alatukur').value = "";
                  document.getElementById(id +'nm_spec').value = "";
                  document.getElementById(id +'nm_reso').value = "";
                  document.getElementById(id +'jml_titik').value = "";
                  document.getElementById(id +'ket').value = "";
                  document.getElementById(id +'lok_pict').value = "";
                  document.getElementById(id +'kd_au').value = "";
                  document.getElementById(e.target.id).focus();
                  swal("No Seri tidak boleh ada yang sama!", "Perhatikan inputan anda!", "warning");
                }
              });
            });
             $('#noseriModal').on('hidden.bs.modal', function () {
              var no_seri = document.getElementById(e.target.id).value.trim();
              if(no_seri === '') {
               document.getElementById(e.target.id).focus();
             } else {
               var id = e.target.id.replace('no_seri', '');
               document.getElementById(id +'no_seri').focus();
             }
           });
           },
         });
        
      }
      if(e.keyCode == 40) { //kursor bawah
        $('#addRow').click();
      }
    }

    //VALIDASI NOSERI
    function validateNoseri(e){
      var kd_plant = document.getElementById("kd_plant").value.trim();
      var pt = document.getElementById("pt").value.trim();
      if(kd_plant === ''){
        kd_plant = '-';
      } 
      var id = e.target.id.replace('no_seri', '');    
      var no_seri = document.getElementById(e.target.id).value.trim();
      if(no_seri === '') {
       document.getElementById(e.target.id).value = "";
       document.getElementById(id +'nm_alatukur').value = "";
       document.getElementById(id +'nm_spec').value = "";
       document.getElementById(id +'nm_reso').value = "";
       document.getElementById(id +'jml_titik').value = "";
       document.getElementById(id +'ket').value = "";
       document.getElementById(id +'lok_pict').value = "";
       document.getElementById(id +'kd_au').value = "";
     }else{
       var url = '{{ route('datatables.validasiNoseri', ['param', 'param1', 'param2']) }}';
       url = url.replace('param', window.btoa(kd_plant));
       url = url.replace('param1', window.btoa(no_seri));
       url = url.replace('param2', window.btoa(pt));
       $.get(url, function(result){  
        if(result !== 'null'){
         result = JSON.parse(result);
         document.getElementById(id +'nm_alatukur').value = result["nm_alat"];
         document.getElementById(id +'nm_spec').value = result["spec"];
         document.getElementById(id +'nm_reso').value = result["res"];
         document.getElementById(id +'jml_titik').value = result["titik_ukur"];
         document.getElementById(id +'ket').value = result["keterangan"];
         document.getElementById(id +'lok_pict').value = result["lok_pict"];
         document.getElementById(id +'kd_au').value = result["kd_au"];
             //untuk memunculkan gambar
             var row = id.replace('row-', '');
             row = row.replace('-', '');
             row = row-1;
             changeImage(row);
             if(!validateNoseriDuplicate(e.target.id)) {
              document.getElementById(e.target.id).value = "";
              document.getElementById(id +'nm_alatukur').value = "";
              document.getElementById(id +'nm_spec').value = "";
              document.getElementById(id +'nm_reso').value = "";
              document.getElementById(id +'jml_titik').value = "";
              document.getElementById(id +'ket').value = "";
              document.getElementById(id +'lok_pict').value = "";
              document.getElementById(id +'kd_au').value = "";
              document.getElementById(e.target.id).focus();
              swal("NoSeri dan Proses tidak boleh ada yang sama!", "Perhatikan inputan anda!", "warning");
            }
          } else {
           document.getElementById(e.target.id).value = "";
           document.getElementById(id +'nm_alatukur').value = "";
           document.getElementById(id +'nm_spec').value = "";
           document.getElementById(id +'nm_reso').value = "";
           document.getElementById(id +'jml_titik').value = "";
           document.getElementById(id +'ket').value = "";
           document.getElementById(id +'lok_pict').value = "";
           document.getElementById(id +'kd_au').value = "";
           document.getElementById(e.target.id).focus();
           swal("NoSeri tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
         }
       });
     } 
    }

    //VALIDASI NOSERI DUPLICATE
    function validateNoseriDuplicate(parentId){
      var id = parentId.replace('no_seri', '');
      var no_seri = document.getElementById(parentId).value.trim();

      if(no_seri !== '' ) {
        var table = $('#tblDetail').DataTable();
        var valid = 'T';
        for($i = 0; $i < table.rows().count(); $i++) {
          var data = table.cell($i, 1).data();
          var posisi = data.indexOf("no_seri");
          var target = data.substr(0, posisi);
          target = target.replace('<input type="hidden" value="', '');
          target = target.replace("<input type='hidden' value=", '');
          target = target.replace('<input value="', '');
          target = target.replace("<input value='", '');
          target = target.replace("<input value=", '');
          target = target.replace("<input value=", '');

          var target_no_seri = target +'no_seri';
          if(parentId !== target_no_seri) {
            var no_seri_temp = document.getElementById(target_no_seri).value.trim();
            if(no_seri_temp !== '') {
              if(no_seri_temp === no_seri) {
                valid = 'F';
                $i = table.rows().count();
              }
            }
          }
        }
        if(valid === 'T') {
          return true;
        } else {
          return false;
        }
      } else {
        return true;
      }
    }

    //POPUP BARANG
    function popupBarang(e) {
      if(e.keyCode == 120 || e.keyCode == 13) {
        var myHeading = "<p>Popup Barang</p>";
        $("#barangModalLabel").html(myHeading);
        var url = '{{ route('datatables.popupBarang') }}';
        $('#barangModal').modal('show');
        var lookupBarang = $('#lookupBarang').DataTable({
          processing: true, 
          "oLanguage": {
            'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
          }, 
          serverSide: true,
          pagingType: "simple",
          "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
          ajax: url,
          columns: [
          { data: 'kd_brg', name: 'kd_brg'},
          { data: 'nm_brg', name: 'nm_brg'}
          ],
          "bDestroy": true,
          "initComplete": function(settings, json) {
            $('div.dataTables_filter input').focus();
            $('#lookupBarang tbody').on( 'dblclick', 'tr', function () {
              var dataArr = [];
              var rows = $(this);
              var rowData = lookupBarang.rows(rows).data();
              $.each($(rowData),function(key,value){
                var id = e.target.id.replace('kd_brg', '');
                document.getElementById(e.target.id).value = value["kd_brg"];
                document.getElementById(id +'nm_brg').value = value["nm_brg"];
                $('#barangModal').modal('hide');
                document.getElementById(id +'kd_brg').focus();            
              });
            });
            $('#barangModal').on('hidden.bs.modal', function () {
              var kd_brg = document.getElementById(e.target.id).value.trim();
              if(kd_brg === '') {
                document.getElementById(e.target.id).focus();
              } else {
                var id = e.target.id.replace('kd_brg', '');
                document.getElementById(id +'kd_brg').focus();
              }
            });
          },
        });
      }
    }

    //VALIDASI BARANG
    function validateBarang(e){
      var id = e.target.id.replace('kd_brg', '');
      var kd_brg = document.getElementById(e.target.id).value.trim();
      if(kd_brg === '') {
        document.getElementById(e.target.id).value = "";
        document.getElementById(id +'nm_brg').value = "";
      }else{
        var url = '{{ route('datatables.validasiBarang', 'param') }}';
        url = url.replace('param', window.btoa(kd_brg));
        $.get(url, function(result){  
          if(result !== 'null'){
            result = JSON.parse(result);
            document.getElementById(id +'nm_brg').value = result["nm_brg"];       
          } else {
            document.getElementById(e.target.id).value = "";
            document.getElementById(id +'nm_brg').value = "";
            document.getElementById(e.target.id).focus();
            swal("Barang tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
          }
        });
      } 
    }

    function changeId(row) {
      var table = $('#tblDetail').DataTable();
      table.row(row).remove().draw(false);
      var jml_row = document.getElementById("jml_tbl_detail").value.trim();
      jml_row = Number(jml_row) + 1;
      nextRow = Number(row) + 1;
      for($i = nextRow; $i <= jml_row; $i++) {
        var id = "#row-" + $i + "-id";
        var id_new = "row-" + ($i-1) + "-id";
        $(id).attr({"id":id_new, "name":id_new});
        var no_seri = "#row-" + $i + "-no_seri";
        var no_seri_new = "row-" + ($i-1) + "-no_seri";
        $(no_seri).attr({"id":no_seri_new, "name":no_seri_new});
        var nm_alatukur = "#row-" + $i + "-nm_alatukur";
        var nm_alatukur_new = "row-" + ($i-1) + "-nm_alatukur";
        $(nm_alatukur).attr({"id":nm_alatukur_new, "name":nm_alatukur_new});
        var kd_brg = "#row-" + $i + "-kd_brg";
        var kd_brg_new = "row-" + ($i-1) + "-kd_brg";
        $(kd_brg).attr({"id":kd_brg_new, "name":kd_brg_new});
        var nm_brg = "#row-" + $i + "-nm_brg";
        var nm_brg_new = "row-" + ($i-1) + "-nm_brg";
        $(nm_brg).attr({"id":nm_brg_new, "name":nm_brg_new});
        var nm_spec = "#row-" + $i + "-nm_spec";
        var nm_spec_new = "row-" + ($i-1) + "-nm_spec";
        $(nm_spec).attr({"id":nm_spec_new, "name":nm_spec_new});
        var nm_reso = "#row-" + $i + "-nm_reso";
        var nm_reso_new = "row-" + ($i-1) + "-nm_reso";
        $(nm_reso).attr({"id":nm_reso_new, "name":nm_reso_new});
        var jml_titik = "#row-" + $i + "-jml_titik";
        var jml_titik_new = "row-" + ($i-1) + "-jml_titik";
        $(jml_titik).attr({"id":jml_titik_new, "name":jml_titik_new});
        var ket = "#row-" + $i + "-ket";
        var ket_new = "row-" + ($i-1) + "-ket";
        $(ket).attr({"id":ket_new, "name":ket_new});
        var no_serti = "#row-" + $i + "-no_serti";
        var no_serti_new = "row-" + ($i-1) + "-no_serti";
        $(no_serti).attr({"id":no_serti_new, "name":no_serti_new});  
        var lok_pict = "#row-" + $i + "-lok_pict";
        var lok_pict_new = "row-" + ($i-1) + "-lok_pict";
        $(lok_pict).attr({"id":lok_pict_new, "name":lok_pict_new});
        var kd_au = "#row-" + $i + "-kd_au";
        var kd_au_new = "row-" + ($i-1) + "-kd_au";
        $(kd_au).attr({"id":kd_au_new, "name":kd_au_new});    
      }
      //set ulang no tabel
      for($i = 0; $i < table.rows().count(); $i++) {
        table.cell($i, 0).data($i +1);
      }
      jml_row = jml_row - 1;
      document.getElementById("jml_tbl_detail").value = jml_row;
    }

    function changeImage(row){
      var index = Number(row) +1;
      var row_lok_pict = "row-" +index + "-lok_pict";
      var lok_pict = document.getElementById(row_lok_pict).value.trim();
      if(lok_pict !== ''){
        var urlImage="{{ route('mstalatukurkal.showImage', ['param']) }}";
        urlImage = urlImage.replace('param', lok_pict);
        $.get(urlImage, function(result){  
          if(result !== 'null'){
            urlImage=result; 
            document.getElementById("imgAlatUkur").src= urlImage;   
          } else {
            urlImage="{{asset('images/no_image.png')}}";
            document.getElementById("imgAlatUkur").src= urlImage;
          }
        });
      }else{
        urlImage="{{asset('images/no_image.png')}}";
      }  
    }

    //Cetak Tag
    function printTag(){
      var param = document.getElementById("no_order").value.trim();

      var url = '{{ route('kalibrasi.print', ['param']) }}';
      url = url.replace('param', window.btoa(param));
      window.open(url);
    }

    function tambahBaris(table){
       
      var counter = table.rows().count();
      document.getElementById("jml_tbl_detail").value = counter;

      counter = table.rows().count();
       counter++;
       document.getElementById("jml_tbl_detail").value = counter;
       var id = 'row-' + counter +'-id';
       var no_seri = 'row-' + counter +'-no_seri';
       var nm_alatukur = 'row-' + counter +'-nm_alatukur';
       var kd_brg = 'row-' + counter +'-kd_brg';
       var nm_brg = 'row-' + counter +'-nm_brg';
       var nm_spec = 'row-' + counter +'-nm_spec';
       var nm_reso = 'row-' + counter +'-nm_reso';
       var jml_titik = 'row-' + counter +'-jml_titik';
       var ket = 'row-' + counter +'-ket';
       var no_serti = 'row-' + counter +'-no_serti';
       var lok_pict = 'row-' + counter +'-lok_pict';
       var kd_au = 'row-' + counter +'-kd_au';
       var hrg_unit = 'row-' + counter +'-hrg_unit';
       table.row.add([
        counter,
        "<input type='hidden' value=" + no_seri + "><input type='text' id=" + no_seri + " name=" + no_seri + " size='16' maxlength='100' onkeydown='popupNoseri(event);' onchange='validateNoseri(event)' required><input type='hidden' id=" + id + " name=" + id + " value='0' readonly='readonly'>",
        "<textarea id=" + nm_alatukur + " name=" + nm_alatukur + " rows='2' cols='20' disabled='' style='text-transform:uppercase;resize:vertical'></textarea>",
        "<input type='text' id=" + kd_brg + " name=" + kd_brg + " size='8' maxlength='8' onkeydown='popupBarang(event)' onchange='validateBarang(event)' required>",
        "<textarea id=" + nm_brg + " name=" + nm_brg + " rows='2' cols='20' disabled='' style='text-transform:uppercase;resize:vertical'></textarea>",
        "<input type='text' id=" + nm_spec + " name=" + nm_spec + " size='8' maxlength='30'>",
        "<input type='text' id=" + nm_reso + " name=" + nm_reso + " size='8' maxlength='30'>",
        "<input type='text' id=" + jml_titik + " name=" + jml_titik + " size='8' maxlength='30'>",
        "<input type='text' id=" + ket + " name=" + ket + " size='16' maxlength='30'>",
        "<input type='text' id=" + no_serti + " name=" + no_serti + " size='30' maxlength='30' disabled=''><input type='hidden' id=" + lok_pict + " name=" + lok_pict + " size='30' maxlength='30'> <input type='hidden' id=" + kd_au + " name=" + kd_au + ">",
        "<input type='number' id=" + hrg_unit + " name=" + hrg_unit + ">"
        
        ]).draw(false);
    }

</script>
@endsection