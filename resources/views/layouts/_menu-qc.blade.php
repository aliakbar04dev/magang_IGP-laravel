@if (strlen(Auth::user()->username) == 5)
  @permission(['pica-view','pica-approve','pica-reject','qc-alatukur-*','qc-pppolpb-*','qc-usul-prob-create','qc-usul-prob-delete','qc-usul-prob-view'])
  <li class="header">QUALITY CONTROL NAVIGATION</li>
    @permission(['pica-view','pica-approve','pica-reject','qc-usul-prob-create','qc-usul-prob-delete','qc-usul-prob-view'])
      <li class="treeview">
        <a href="#">
          <i class="fa fa-file-text-o"></i> <span>QPR</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          @permission(['pica-view','pica-approve','pica-reject'])
          <li class="{{ route('qprs.all') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('qprs.all') }}"><i class="fa fa-circle-o"></i>Daftar QPR</a>
          </li>
          @endpermission
          @permission(['qc-usul-prob-create','qc-usul-prob-delete','qc-usul-prob-view'])
          <li class="{{ route('usulprob.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('usulprob.index') }}"><i class="fa fa-circle-o"></i>Usulan Problem</a>
          </li>
          @endpermission
          <li>
            <a target="_blank" href="{{ route('qprs.userguide') }}"><i class="fa fa-book"></i>Download User Guide</a>
          </li>
        </ul>
      </li>
    @endpermission
    @permission(['qc-alatukur-*'])
      <li class="treeview">
        <a href="#">
          <i class="fa fa-file-text-o"></i> <span>Alat Ukur</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          @permission(['qc-alatukur-*'])
          <li class="{{ route('mstalatukur.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mstalatukur.index') }}"><i class="fa fa-circle-o"></i>Master</a>
          </li>
          <li class="{{ route('histalatukur.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('histalatukur.index') }}"><i class="fa fa-circle-o"></i>History</a>
          </li>
          <li class="{{ route('alatukur.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('alatukur.index') }}"><i class="fa fa-circle-o"></i>Cetak Laporan</a>
          </li>
          @endpermission
        </ul>
      </li>
    @endpermission
    @permission(['qc-pppolpb-*']) 
      <li class="treeview">
        <a href="#">
          <i class="fa fa-files-o"></i> <span>LAPORAN</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">         
          <li class="{{ route('pppolpb.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('pppolpb.index') }}"><i class="fa fa-circle-o"></i>Laporan PP PO LPB</a>
          </li>
        </ul>
      </li>
    @endpermission
  @endpermission
@endif