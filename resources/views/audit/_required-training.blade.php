<table id="requiredtraining" class="table table-bordered table-hover"  style="width:100%;margin-top: -12px;">
                    <thead>
                        <tr>
                            <th style="width:20%">KODE TR</th>
                            <th style="width:50%">DESC</th>
                            <th style="width:30%">STATUS</th>
                        </tr>
                    </thead>
                    @foreach ($list_training as $trn)
                    <tr>                  
                           <td>{{ $trn->kode_tr }}</td>
                            <td>{{ $trn->desc_trn }}</td>
                            @if ($trn->status == '1')
                            <td>AKTIF</td>
                            @elseif ($trn->status == '0')
                            <td>TIDAK AKTIF</td>
                            @endif
                    </tr>
                    @endforeach

                </table>  