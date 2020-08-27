@if (strlen(Auth::user()->username) > 5)
  @permission(['qpr-*','pica-view','pica-create','pica-delete','pica-submit','sa-*'])
    <li class="header">E-QUALITY CONTROL NAVIGATION</li>
    @permission(['qpr-*','pica-view','pica-create','pica-delete','pica-submit'])
      <li class="treeview">
        <a href="#">
          <i class="fa fa-file-text-o"></i> <span>QPR</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
        @permission(['qpr-*'])
          <li class="{{ route('qprs.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('qprs.index') }}"><i class="fa fa-circle-o"></i>Daftar QPR</a>
          </li>
        @endpermission
        @permission(['pica-*'])
          <li class="{{ route('picas.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('picas.index') }}"><i class="fa fa-circle-o"></i>PICA</a>
          </li>
        @endpermission
        <li>
            <a target="_blank" href="{{ route('qprs.userguide') }}"><i class="fa fa-book"></i>Download User Guide</a>
          </li>
        </ul>
      </li>
    @endpermission
    @permission(['sa-*']) 
      <li class="treeview">
        <a href="#">
          <i class="fa fa-file-text-o"></i> <span>SPECIAL ACCEPTANCE</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">         
          <li class="{{ route('qatsas.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('qatsas.index') }}"><i class="fa fa-circle-o"></i>Special Acceptance</a>
          </li>
        </ul>
      </li>
    @endpermission
  @endpermission
@endif