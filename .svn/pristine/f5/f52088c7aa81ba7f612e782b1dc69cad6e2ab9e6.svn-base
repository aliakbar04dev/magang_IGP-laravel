@permission(['faco-*'])
  <li class="header">FACO</li>
  <li class="treeview">
    <a href="#">
      <i class="fa fa-files-o"></i> <span>Lalu Lintas</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
    @permission(['faco-lalin-ksr-acc', 'faco-lalin-ksr-acc-approve'])
      <li class="{{ route('lalins.indexksracc') == request()->url() ? 'active' : '' }}">
        <a href="{{ route('lalins.indexksracc') }}"><i class="fa fa-circle-o"></i>Kasir ke Accounting</a>
      </li>
    @endpermission
    @permission(['faco-lalin-acc-fin', 'faco-lalin-acc-fin-approve'])
      <li class="{{ route('lalins.indexaccfin') == request()->url() ? 'active' : '' }}">
        <a href="{{ route('lalins.indexaccfin') }}"><i class="fa fa-circle-o"></i>Accounting ke Finance</a>
      </li>
    @endpermission
    @permission(['faco-lalin-fin-ksr', 'faco-lalin-fin-ksr-approve'])
      <li class="{{ route('lalins.indexfinksr') == request()->url() ? 'active' : '' }}">
        <a href="{{ route('lalins.indexfinksr') }}"><i class="fa fa-circle-o"></i>Finance ke Kasir</a>
      </li>
    @endpermission
    </ul>
  </li>
@endpermission