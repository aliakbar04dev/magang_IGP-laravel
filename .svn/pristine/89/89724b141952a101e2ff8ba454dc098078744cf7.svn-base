@if (strlen(Auth::user()->username) > 5)
  @permission(['prc-po-apr-*', 'prc-rfq-*'])
    <li class="header">E-PROCUREMENT NAVIGATION</li>
    @permission(['prc-po-apr-*'])
    <li class="treeview">
      <a href="#">
        <i class="fa fa-files-o"></i> <span>PURCHASE ORDER</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
      @permission(['prc-po-apr-*'])
        <li class="{{ route('baanpo1s.index') == request()->url() ? 'active' : '' }}">
          <a href="{{ route('baanpo1s.index') }}"><i class="fa fa-circle-o"></i>Daftar PO</a>
        </li>
      @endpermission
      </ul>
    </li>
    @endpermission
    @permission(['prc-rfq-*'])
    <li class="treeview">
      <a href="#">
        <i class="fa fa-files-o"></i> <span>REQUEST FOR QUOTATION</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
      @permission(['prc-rfq-*'])
        <li class="{{ route('prctrfqs.indexall') == request()->url() ? 'active' : '' }}">
          <a href="{{ route('prctrfqs.indexall') }}"><i class="fa fa-circle-o"></i>Daftar RFQ</a>
        </li>
      @endpermission
      </ul>
    </li>
    @endpermission
  @endpermission
@endif