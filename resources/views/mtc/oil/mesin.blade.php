@if (isset($mesins))
  @if($mesins->get()->count() > 0)
    <div class="box-body">
      <table cellspacing="5" width="100%">
        <thead>
          @foreach($mesins->get() as $mesin)
            @if($loop->first || ($loop->iteration % 5) == 1) 
              <tr>
            @endif
              <td cellpadding="20" style="width: 20%;text-align: center;">
                @if (isset($kd_mesin))
                  @if ($kd_mesin === $mesin->kd_mesin)
                    <button class="btn btn-success" style="width: 90%;margin: 5px 5px 5px 5px;" onclick="grafik('{{ base64_encode($mesin->kd_mesin) }}')">{{ $mesin->kd_mesin }}</button>
                  @else 
                    <button class="btn btn-primary" style="width: 90%;margin: 5px 5px 5px 5px;" onclick="grafik('{{ base64_encode($mesin->kd_mesin) }}')">{{ $mesin->kd_mesin }}</button>
                  @endif
                @else
                  <button class="btn btn-primary" style="width: 90%;margin: 5px 5px 5px 5px;" onclick="grafik('{{ base64_encode($mesin->kd_mesin) }}')">{{ $mesin->kd_mesin }}</button>
                @endif
              </td>
            @if($loop->iteration % 5 == 0 || $loop->last) 
              </tr>
            @endif
          @endforeach
      </table>
    </div>
    <!-- /.box-body -->
  @endif  
@endif