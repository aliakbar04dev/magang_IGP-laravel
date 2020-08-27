<div class="modal fade" id="serahModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="serahModalLabel" aria-hidden="true">
  {{-- <div class="modal-dialog" style="width:800px"> --}}
  <div class="modal-dialog" style="width:80%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="serahModalLabel">Popup</h4> <b><font color="red">Klik 2x untuk memilih</font></b>
      </div>
      <div class="modal-body">
        <table id="tblDetail" class="table table-bordered table-striped" cellspacing="0" width="115%">
          <thead>
            <tr>
              <th style="text-align: center;width: 2%;"><input type="checkbox" name="chk-all" id="chk-all" class="icheckbox_square-blue"></th>
              <th>Batch</th>
              <th>T/T / P/P</th>
              <th>JTempo</th>
              <th>Supplier</th>
              <th>Tgl Doc</th>
              <th>CCUR</th>
              <th>AMNT</th>
              <th>VATH1</th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="box-footer">
        <button id="btn-pilih" type="button" class="btn btn-success">Serah</button>
        &nbsp;&nbsp;
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>