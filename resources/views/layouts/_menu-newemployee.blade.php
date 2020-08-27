@permission(['karyawanbaru-create'])
  <li class="header">OTHERS NAVIGATION</li>
  @permission(['karyawanbaru-create'])
    <li class="treeview">
      <a href="#">
        <i class="fa fa-gear"></i> <span>NEW EMPLOYEE</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @permission(['karyawanbaru-create'])
          <li class="{{ route('mobiles.indexreg') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mobiles.indexreg') }}"><i class="fa fa-circle-o"></i>Registrasi Karyawan</a>
          </li>
        @endpermission
      </ul>
    </li>
  @endpermission
@endpermission