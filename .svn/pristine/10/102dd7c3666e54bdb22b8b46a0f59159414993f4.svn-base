<div class="modal fade" id="KDKatalogModal" tabindex="-1" role="dialog" aria-labelledby="KDKatalogModalLabel"
    aria-hidden="true">
    {{-- <div class="modal-dialog" style="width:800px"> --}}
    <div class="modal-dialog" style="width:80%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="katalogModalLabel">Popup</h4> <b>
                    <font color="red">Klik 2x untuk memilih</font>&nbsp;&nbsp;<div id="loadingkatalog" style="display: none;"><div class="loader" style="display: inline-block;margin-bottom: -5px;"></div> Menyimpan perubahan...</div>
                </b>
            </div>
            <div class="modal-body" style="width:100%;">
                <table id="lookupKatalog" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="25%">Item No</th>
                            <th width="30%">Deskripsi</th>
                            <th width="10%">QTY/Unit</th>
                            <th width="10%">LifeTime (QTY)</th>
                            <th width="25%">Keterangan</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th style="padding-right:0px; padding-left:0px;">
                                <div class="input-group" style="width:100%;">
                                    <input class="form-control" id="item_no_add" value="" data="" required="required"
                                        style="text-transform:uppercase;background-color:white;" readonly
                                        name="item_no_add" type="text">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-info" onclick="showPopupItemKatalog('0')"
                                            data-toggle="modal" data-target="#KDItemKatalogModal" style="height: 34px;">
                                            <span class="glyphicon glyphicon-search"></span>
                                        </button>
                                    </span>
                                </div>
                            </th>
                            <th style="padding-right:0px; padding-left:0px;"><input type="text" class="form-control" value=""
                                    name="desc1_add" id="desc1_add" placeholder="Deskripsi" readonly
                                    style="width:100%">
                            </th>
                            <th style="padding-right:0px; padding-left:0px;"><input type="number" id="nil_qpu_add"
                                    style="width:100%" class="nil_qpu_add form-control" placeholder="QTY/Unit"
                                    value="">
                            </th>
                            <th style="padding-right:0px; padding-left:0px;"><input type="number" placeholder="LifeTime(Qty)" id="qty_life_add"
                                    style="width:100%" class="qty_life_add form-control"
                                    value="">
                            </th>
                            <th style="padding-right:0px; padding-left:0px;"><input type="text" placeholder="Keterangan" id="kete_add"
                                    style="width:80%" class="kete_add form-control" 
                                    value=""><button type="submit" id="btnadditemkatalog" name="btnadditemkatalog" class="btn btn-success pull-right" style="height: 34px;">
                                            <span class="glyphicon glyphicon-plus"></span>
                                          </button>
                            </th>
                        </tr>
                    </tfoot>
                </table>
                <label style="display:block">* klik item pengecekan untuk memunculkan No Item</label>
                <input class="form-control " placeholder="No Item" value='' style="width:150px; display:inline;" type="text" id="item_no2" readonly>
                <button type="button" id="delkatalog" name="delkatalog" class="btn btn-danger" style="margin-left: 10px;">
                    Hapus
                </button>
                <input class="form-control" placeholder="No Item" value='' style="width:150px;" type="hidden" id="item_no_oper" readonly>
            </div>
        </div>
    </div>
</div>