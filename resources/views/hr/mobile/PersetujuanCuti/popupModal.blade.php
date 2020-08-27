<style>
#tableinfo>thead>tr>th, #tableinfo>tbody>tr>th, #tableinfo>tfoot>tr>th, #tableinfo>thead>tr>td, #tableinfo>tbody>tr>td>p,#tableinfo>tbody>tr>td, #tableinfo>tfoot>tr>td{
    padding: 0px !important;
    margin:0px !important;
}</style>
<div class="modal fade" id="popupModal" tabindex="-1" role="dialog" aria-labelledby="popupModalLabel" aria-hidden="true">
        {{-- <div class="modal-dialog"> --}}
        <div class="modal-dialog" style="width:95%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="popupModalLabel1">Popup</h4> <b></b>
                </div>
                <div class="modal-body">
                    
                        <!-- Main content -->
                        <section class="content">
                            <div class="collapse" style="display:block;">
                                    <div class="row" >
                                            <div class="col-md-12">
                                                <div class="box box-primary">
                                                    <div class="box-header">
                                                            <h3 class="box-title">Info Karyawan</h3>
                                                            <br>
                                                            <table class="table table-striped" id="tableinfo">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th>Nama Karyawan</th>
                                                                            <td><p id="namaDetail"></p></td> 
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Sisa Cuti Tahunan</th>
                                                                            <td><p id="sisaCutiTahunan"></p></td> 
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Sisa Cuti Besar</th>
                                                                            <td><p id="sisaCutiBesar"></p></td> 
                                                                        </tr>
                                                                        <tr class="collapse multi-collapse sembunyi">
                                                                            <th width="20%">NPK</th>
                                                                            <td><p id="npkDetail"></p></td> 
                                                                        </tr>
                                                                        
                                                                        <tr class="collapse multi-collapse sembunyi">
                                                                            <th>Nama Atasan</th>
                                                                            <td><p id="namaAtasanDetail"></p></td> 
                                                                        </tr>
                                                                        <tr class="collapse multi-collapse sembunyi">
                                                                            <th>Tanggal Pengajuan</th>
                                                                            <td><p id="tglDetail"></p></td>
                                                                        </tr>
                                                                        <tr class="collapse multi-collapse sembunyi">
                                                                            <th>Bagian</th>
                                                                            <td><p id="bagDetail"></p></td> 
                                                                        </tr>
                                                                        <tr class="collapse multi-collapse sembunyi">
                                                                            <th>No Doc Cuti</th>
                                                                            <td><p id="nodocDetail"></p></td> 
                                                                        </tr>
                                                                        
                                                                    </tbody>
                                                                </table>
                                                            <div class="box-tools pull-right">
                                                                    <button type="button" id="ajucuti" class="btn btn-box-tool" data-toggle="collapse" href=".sembunyi" role="button" aria-expanded="false" aria-controls="sembunyi"><i class="fa fa-plus"></i>
                                                                    </button>
                                                            </div>
                                                    </div>
                                                    
                                                    <!-- /.box-header -->
                                                    <!-- Add Forms Data Here-->                   
                                                    {{-- <div class="box-body"> 
                                                        <table class="table table-striped">
                                                            <tbody>
                                                                <tr>
                                                                    <th width="20%">NPK</th>
                                                                    <td><p id="npkDetail"></p></td> 
                                                                </tr>
                                                                <tr>
                                                                    <th>Nama Karyawan</th>
                                                                    <td><p id="namaDetail"></p></td> 
                                                                </tr>
                                                                <tr>
                                                                    <th>Nama Atasan</th>
                                                                    <td><p id="namaAtasanDetail"></p></td> 
                                                                </tr>
                                                                <tr>
                                                                    <th>Tanggal Pengajuan</th>
                                                                    <td><p id="tglDetail"></p></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Bagian</th>
                                                                    <td><p id="bagDetail"></p></td> 
                                                                </tr>
                                                                <tr>
                                                                    <th>No Doc Cuti</th>
                                                                    <td><p id="nodocDetail"></p></td> 
                                                                </tr>
                                                                <tr>
                                                                    <th>Sisa Cuti Tahunan</th>
                                                                    <td><p id="sisaCutiTahunan"></p></td> 
                                                                </tr>
                                                                <tr>
                                                                    <th>Sisa Cuti Besar</th>
                                                                    <td><p id="sisaCutiBesar"></p></td> 
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                
                                                        <div class="clearfix">&nbsp;</div>
                                                         
                                
                                                        <div class="clearfix">&nbsp;</div> 
                                                        <center><a class="btn btn-sm btn-primary" href="javascript:void(0)" id="backButton">Close</a></center>
                                                      </div>  --}}
                                                      <!-- end Forms-->  
                                                      
                                                </div>
                                                <!-- /.box-body --> 
                                            </div>
                                            <!-- /.box -->
                                        </div>
                            </div>
                            <center id="ubahStatus" style='display:none'>
                                    <form style="display: inline" id="formDecline" onSubmit=Decline() action="javascript:void(0)">
                                            <input type="hidden" name="no_cuti" id="no_cuti_decline" >
                                            <input type="hidden" name="data"  value="2">
                                            {{csrf_field()}}
                                            <button class="btn btn-danger btn-sm" type="submit">
                                                <i class="glyphicon glyphicon-remove"></i> Tolak
                                            </button>
                                            </form>
                                            &nbsp;&nbsp;
                                    <form style="display: inline" id="formApprove" onSubmit=Approve() action="javascript:void(0)">
                                            <input type="hidden" name="no_cuti" id="no_cuti_approve">
                                            <input type="hidden" name="data"  value="1">
                                            {{csrf_field()}}
                                            <button class="btn btn-success btn-sm" type="submit">
                                                <i class="glyphicon glyphicon-ok"></i> Approve
                                            </button>
                                            </form>
                                    
                            </center>
                            <table id="tblDetailMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="width: 1%;">No</th>
                                            <th style="width: 5%;">TGL</th>
                                            <th>KD Cuti</th> 
                                            <th>Jenis Cuti</th>
                                        </tr>
                                    </thead>
                                </table>

                                <center><a class="btn btn-sm btn-primary" href="javascript:void(0)" id="backButton">Close</a></center>
                            <!-- /.row -->
                        </section>
                        <!-- /.content -->
                      </div>
            </div>
        </div>
    </div>