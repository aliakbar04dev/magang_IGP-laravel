@permission(['mgt-gemba-*'])
  <li class="header">MANAGEMENT NAVIGATION</li>
  @permission(['mgt-gemba-*'])
    <li class="treeview">
      <a href="#">
        <i class="fa fa-files-o"></i> <span>TRANSAKSI</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
      @permission(['mgt-gemba-*'])
        @permission(['mgt-gemba-create'])
          <li class="{{ route('mgmtgembas.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mgmtgembas.index') }}"><i class="fa fa-circle-o"></i>Daftar Genba BOD</a>
          </li>
        @endpermission
        <li class="{{ route('mgmtgembas.indexcm') == request()->url() ? 'active' : '' }}">
          <a href="{{ route('mgmtgembas.indexcm') }}"><i class="fa fa-circle-o"></i>Daftar Genba BOD - CM</a>
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
      @permission(['mgt-gemba-*'])
        <li class="{{ route('mgmtgembas.laporan') == request()->url() ? 'active' : '' }}">
          <a href="{{ route('mgmtgembas.laporan') }}"><i class="fa fa-circle-o"></i>Genba BOD</a>
        </li>
      @endpermission
      </ul>
    </li>
  @endpermission
@endpermission