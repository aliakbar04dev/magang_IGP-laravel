@if (strlen(Auth::user()->username) > 5)
  @permission(['ppc-picadpr-*','ppc-dnsupp-download'])
    <li class="header">E-PPC NAVIGATION</li>
    @permission(['ppc-picadpr-*'])
    <li class="treeview">
      <a href="#">
        <i class="fa fa-files-o"></i> <span>TRANSAKSI</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
      @permission(['ppc-picadpr-*'])
        <li class="{{ route('ppctdprs.all') == request()->url() ? 'active' : '' }}">
          <a href="{{ route('ppctdprs.all') }}"><i class="fa fa-circle-o"></i>Delivery Problem Report</a>
        </li>
        <li class="{{ route('ppctdprpicas.index') == request()->url() ? 'active' : '' }}">
          <a href="{{ route('ppctdprpicas.index') }}"><i class="fa fa-circle-o"></i>PICA DEPR</a>
        </li>
      @endpermission
      </ul>
    </li>
    @endpermission
    @permission(['ppc-dnsupp-download'])
    <li class="treeview">
      <a href="#">
        <i class="fa fa-files-o"></i> <span>LAPORAN</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
      @permission(['ppc-dnsupp-download'])
        <li class="{{ route('baandnsupps.all') == request()->url() ? 'active' : '' }}">
          <a href="{{ route('baandnsupps.all') }}"><i class="fa fa-circle-o"></i>Delivery Note</a>
        </li>
      @endpermission
      </ul>
    </li>
    @endpermission
  @endpermission
  @permission(['ppc-dnclaim-*'])
    <li class="header">CLAIM NAVIGATION</li>
    @permission(['ppc-dnclaim-*'])
    <li class="treeview">
      <a href="#">
        <i class="fa fa-files-o"></i> <span>TRANSAKSI</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
      @permission(['ppc-dnclaim-*'])
        <li class="{{ route('baaniginh008s.all') == request()->url() ? 'active' : '' }}">
          <a href="{{ route('baaniginh008s.all') }}"><i class="fa fa-circle-o"></i>DN - CLAIM</a>
        </li>
        <li class="{{ route('ppctdnclaimsj1s.index') == request()->url() ? 'active' : '' }}">
          <a href="{{ route('ppctdnclaimsj1s.index') }}"><i class="fa fa-circle-o"></i>SURAT JALAN CLAIM</a>
        </li>
      @endpermission
      </ul>
    </li>
    @endpermission
  @endpermission
@endif