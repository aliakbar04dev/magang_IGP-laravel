@permission(['admin-view','user-view'])
  <li class="header">ADMIN NAVIGATION</li>
  <li class="treeview">
    <a href="#">
      <i class="fa fa-lock"></i> <span>Admin</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
    @permission(['admin-view','user-view'])
      <li class="{{ route('users.index') == request()->url() ? 'active' : '' }}">
        <a href="{{ route('users.index') }}"><i class="fa fa-circle-o"></i>User</a>
      </li>
      @permission('admin-view')
        <li class="{{ route('permissions.index') == request()->url() ? 'active' : '' }}">
          <a href="{{ route('permissions.index') }}"><i class="fa fa-circle-o"></i>Permission</a>
        </li>
        <li class="{{ route('roles.index') == request()->url() ? 'active' : '' }}">
          <a href="{{ route('roles.index') }}"><i class="fa fa-circle-o"></i>Role</a>
        </li>
      @endpermission
      <li class="{{ route('logs.users') == request()->url() ? 'active' : '' }}">
        <a href="{{ route('logs.users') }}"><i class="fa fa-circle-o"></i>Monitoring Logs</a>
      </li>
      @permission('user-create')
        <li class="{{ route('syncs.index') == request()->url() ? 'active' : '' }}">
          <a href="{{ route('syncs.index') }}"><i class="fa fa-circle-o"></i>Sync</a>
        </li>
      @endpermission
      @if (config('app.env', 'local') === 'production')
        <li>
          <a target="_blank" href="{{ route('apis.baanpo1s') }}"><i class="fa fa-circle-o"></i>Send Notifikasi E-PO</a>
        </li>
      @else 
        <li>
          <a target="_blank" href="{{ route('apis.baanpo1strial') }}"><i class="fa fa-circle-o"></i>Send Notifikasi E-PO (TRIAL)</a>
        </li>
      @endif
      <li>
        <a target="_blank" href="{{ route('phpinfo.users') }}"><i class="fa fa-book"></i>PHP Info</a>
      </li>
      <li>
        <a target="_blank" href="{{ url('/testconnection') }}"><i class="fa fa-book"></i>Test Connection</a>
      </li>
      <li>
        <a target="_blank" href="{{ route('cekefaktur.users') }}"><i class="fa fa-book"></i>Cek E-Faktur</a>
      </li>
      @if (Auth::user()->username === "14438" || Auth::user()->username === "08268" || Auth::user()->username === "14523" || Auth::user()->username === "16266")
        <li>
          <a href="{{ route('updatesvn.users') }}"><i class="fa fa-book"></i>Update SVN</a>
        </li>
      @endif
      @if (Auth::user()->username === "14438" || Auth::user()->username === "08268")
        <li>
          <a href="{{ route('mappingserverh.users') }}"><i class="fa fa-book"></i>Mapping Server H JKT</a>
        </li>
        <li>
          <a href="{{ route('mappingserverhkim.users') }}"><i class="fa fa-book"></i>Mapping Server H KIM</a>
        </li>
        <li>
          <a href="{{ route('rebootserver.users') }}"><i class="fa fa-book"></i>Restart Server</a>
        </li>
      @endif
      @if (Auth::user()->username === "14438")
        <li>
          <a href="{{ route('cektelegram.users') }}"><i class="fa fa-book"></i>Cek Telegram</a>
        </li>
      @endif
    @endpermission
    </ul>
  </li>
@endpermission