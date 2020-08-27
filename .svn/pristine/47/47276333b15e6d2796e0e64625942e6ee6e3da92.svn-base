@if (isset($andon) && isset($tgl_andon))
  @if($andon2s->count() > 0)
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title" id="box-title-andon-igp2" name="box-title-andon-igp2">ANDON LINE IGP-2</h3>
          <div class="box-tools pull-right">
            @if (isset($dashboard))
              <button id="btn-close" name="btn-close" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Close" onclick="window.open('', '_self', ''); window.close();">
                <span class="glyphicon glyphicon-remove"></span>
              </button>
            @else 
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            @endif
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          @foreach($andon2s as $mtc_andon) 
            @if($loop->first || ($loop->iteration % 7) == 0) 
              <div class="row">
            @endif
              <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="info-box" style="background-color: #CACFD2;padding: 5px;border: 5px solid black;">
                  <table cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <td style="width: 20%;text-align: center">
                          @if($mtc_andon != null) 
                            @if($mtc_andon->status_mc == "1") 
                              <div style="background-color: red;padding: 1px;border: 1px solid red;">
                                <font color="white">{{ numberFormatter(0, 0)->format($mtc_andon->linestop_mc/60) }}'</font>
                              </div>
                            @else 
                              <div style="padding: 1px;border: 1px solid red;">
                                {{ numberFormatter(0, 0)->format($mtc_andon->linestop_mc/60) }}'
                              </div>
                            @endif
                          @else 
                            <div style="padding: 1px;border: 1px solid red;">
                              &nbsp;
                            </div>
                          @endif
                        </td>
                        <td style="text-align: center"><strong>{{ $mtc_andon->line }}</strong></td>
                        <td style="width: 20%;text-align: center">
                          {{-- @if($mtc_andon != null) 
                            @if($mtc_andon->status_mc == "1") 
                              <div style="background-color: #EC7063;padding: 1px;border: 1px solid #EC7063;">
                                {{ numberFormatter(0, 0)->format($mtc_andon->linestop_mc/60) }}'
                              </div>
                            @else 
                              <div style="padding: 1px;border: 1px solid #EC7063;">
                                {{ numberFormatter(0, 0)->format($mtc_andon->linestop_mc/60) }}'
                              </div>
                            @endif
                          @else 
                            <div style="padding: 1px;border: 1px solid #EC7063;">
                              &nbsp;
                            </div>
                          @endif --}}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 20%;text-align: center">
                          @if($mtc_andon != null) 
                            @if($mtc_andon->status_supply == "1") 
                              <div style="background-color: yellow;padding: 1px;border: 1px solid yellow;">
                                {{ numberFormatter(0, 0)->format($mtc_andon->linestop_supply/60) }}'
                              </div>
                            @else 
                              <div style="padding: 1px;border: 1px solid yellow;">
                                {{ numberFormatter(0, 0)->format($mtc_andon->linestop_supply/60) }}'
                              </div>
                            @endif
                          @else 
                            <div style="padding: 1px;border: 1px solid yellow;">
                              &nbsp;
                            </div>
                          @endif
                        </td>
                        <td style="text-align: center">LS: </td>
                        <td style="width: 20%;text-align: center"></td>
                      </tr>
                      <tr>
                        <td style="width: 20%;text-align: center">
                          @if($mtc_andon != null) 
                            @if($mtc_andon->status_qc == "1") 
                              <div style="background-color: blue;padding: 1px;border: 1px solid blue;">
                                <font color="white">{{ numberFormatter(0, 0)->format($mtc_andon->linestop_qc/60) }}'</font>
                              </div>
                            @else 
                              <div style="padding: 1px;border: 1px solid blue;">
                                {{ numberFormatter(0, 0)->format($mtc_andon->linestop_qc/60) }}'
                              </div>
                            @endif
                          @else 
                            <div style="padding: 1px;border: 1px solid blue;">
                              &nbsp;
                            </div>
                          @endif
                        </td>
                        <td style="text-align: center">Freq: </td>
                        <td style="width: 20%;text-align: center"></td>
                      </tr>
                    </thead>
                  </table>
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
            @if($loop->iteration % 6 == 0 || $loop->last) 
              </div>
            @endif
          @endforeach
        </div>
        <!-- ./box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  @endif
@endif