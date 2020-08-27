@permission(['sales-*'])
  <li class="header">SALES NAVIGATION</li>
  @permission(['sales-exchangerate-*', 'sales-bom-*'])
    <li class="treeview">
      <a href="#">
        <i class="fa fa-files-o"></i> <span>MASTER</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
      @permission(['sales-exchangerate-*'])
        <li class="{{ route('tcsls004ms.index') == request()->url() ? 'active' : '' }}">
          <a href="{{ route('tcsls004ms.index') }}"><i class="fa fa-circle-o"></i>PC - Exchange Rate</a>
        </li>
      @endpermission
      @permission(['sales-bom-*'])
        <li class="{{ route('slstboms.bom') == request()->url() ? 'active' : '' }}">
          <a href="{{ route('slstboms.bom') }}"><i class="fa fa-circle-o"></i>BOM</a>
        </li>
      @endpermission
      </ul>
    </li>
  @endpermission
@endpermission