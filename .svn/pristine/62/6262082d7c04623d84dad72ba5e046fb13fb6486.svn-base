@permission(['mgt-gembadep-*'])
  @if (Auth::user()->masKaryawan()->kode_site === "IGPK")
    <li class="header">PLANT KIM NAVIGATION</li>
  @else 
    <li class="header">PLANT JKT NAVIGATION</li>
  @endif
  @permission(['mgt-gembadep-*'])
    <li class="treeview">
      <a href="#">
        <i class="fa fa-files-o"></i> <span>TRANSAKSI</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
      @permission(['mgt-gembadep-*'])
        @permission(['mgt-gembadep-create'])
          <li class="{{ route('mgmtgembadeps.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mgmtgembadeps.index') }}"><i class="fa fa-circle-o"></i>Daftar Genba DEP</a>
          </li>
        @endpermission
        <li class="{{ route('mgmtgembadeps.indexcm') == request()->url() ? 'active' : '' }}">
          <a href="{{ route('mgmtgembadeps.indexcm') }}"><i class="fa fa-circle-o"></i>Daftar Genba DEP - CM</a>
        </li>
      @endpermission
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-files-o"></i> <span>LAPORAN</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
      @permission(['mgt-gembadep-*'])
        <li class="{{ route('mgmtgembadeps.laporan') == request()->url() ? 'active' : '' }}">
          <a href="{{ route('mgmtgembadeps.laporan') }}"><i class="fa fa-circle-o"></i>Genba DEP</a>
        </li>
      @endpermission
      </ul>
    </li>
  @endpermission
@endpermission