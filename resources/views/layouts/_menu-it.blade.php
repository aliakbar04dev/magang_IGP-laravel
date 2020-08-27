@if (strlen(Auth::user()->username) == 5)
  <li class="header">IT NAVIGATION</li>
  <li class="treeview">
    <a href="#">
      <i class="fa fa-files-o"></i> <span>NETWORK</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li>
        <a href="{{ url('/network') }}" target="_blank"><i class="fa fa-circle-o"></i>Monitoring Network</a>
      </li>
    </ul>
  </li>
  @if (Auth::user()->masKaryawan()->kode_dep === "H5")
    <li class="treeview">
      <a href="#">
        <i class="fa fa-files-o"></i> <span>WORK ORDER IT</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li>
          <a href="{{ route('view.daftar') }}"><i class="fa fa-circle-o"></i>Input WO</a>
        </li>
        <li>
          <a href="{{ route('view.approval') }}"><i class="fa fa-circle-o"></i>Approval Atasan</a>
        </li>
        <li>
          <a href="{{ route('view.approvalit') }}"><i class="fa fa-circle-o"></i>Approval IT</a>
        </li>
        <li>
          <a href="{{ route('view.monitoring') }}"><i class="fa fa-circle-o"></i>Monitoring WO</a>
        </li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-files-o"></i> <span>CLAIM IT</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li>
          <a href="{{ route('user.daftar') }}"><i class="fa fa-circle-o"></i>Input Claim (User)</a>
        </li>
        <li>
          <a href="{{ route('staff.daftar') }}"><i class="fa fa-circle-o"></i>Respon Claim (All IT)</a>
        </li>
        <li>
          <a href="#"><i class="fa fa-circle-o"></i>Update Claim (Per PIC IT)</a>
        </li>
        <li>
          <a href="#"><i class="fa fa-circle-o"></i>Statistik Claim</a>
        </li>
      </ul>
    </li>
    {{-- @permission(['it-*'])
      <li class="treeview">
        <a href="#">
          <i class="fa fa-files-o"></i> <span>WORK ORDER</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
        @permission(['it-wo-*'])
          <li class="{{ route('wos.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('wos.index') }}"><i class="fa fa-circle-o"></i>Daftar Work Order</a>
          </li>
        @endpermission
        @if (strlen(Auth::user()->username) == 5)
          @if (Auth::user()->masKaryawan()->kode_dep === "H5")
            <li class="{{ route('wos.approval') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('wos.approval') }}"><i class="fa fa-circle-o"></i>IT - Work Order</a>
            </li>
          @endif
        @endif
        </ul>
      </li>
    @endpermission --}}
  @endif
@endif