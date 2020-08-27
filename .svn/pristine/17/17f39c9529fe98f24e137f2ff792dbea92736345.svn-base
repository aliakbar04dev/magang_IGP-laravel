<li class="header">SETTING NAVIGATION</li>
<li class="treeview">
  <a href="#">
    <i class="fa fa-gear"></i> <span>Settings</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    @if (strlen(Auth::user()->username) > 5)
    <li class="{{ url('/settings/users') == request()->url() ? 'active' : '' }}">
      <a href="{{ url('/settings/users') }}"><i class="fa fa-circle-o"></i>Daftar User</a>
    </li>
    @endif
    <li class="{{ url('/settings/password') == request()->url() ? 'active' : '' }}">
      <a href="{{ url('/settings/password') }}"><i class="fa fa-circle-o"></i>Change Password</a>
    </li>
    <li class="{{ url('/settings/profile') == request()->url() ? 'active' : '' }}">
      <a href="{{ url('/settings/profile') }}"><i class="fa fa-circle-o"></i>View Profile</a>
    </li>
    <li>
      <a href="{{ route('settings.cp') }}"><i class="fa fa-phone"></i>Contact Person</a>
    </li>
    <li>
      <a target="_blank" href="{{ route('settings.userguide') }}"><i class="fa fa-book"></i>Download User Guide</a>
    </li>
    <li>
      <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form2').submit();"><i class="fa fa-sign-out"></i>Sign out
      </a>
      <form id="logout-form2" action="{{ url('/logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
      </form>
    </li>
  </ul>
</li>