@permission(['ehs-*', 'mgt-gembaehs-*'])
  <li class="header">EHS NAVIGATION</li>
  @permission(['ehs-wp-approve-prc','ehs-wp-reject-prc'])
    <li class="treeview">
      <a href="#">
        <i class="fa fa-files-o"></i> <span>MASTER</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @permission(['ehs-wp-approve-prc','ehs-wp-reject-prc'])
          <li class="{{ route('ehsmwppics.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('ehsmwppics.index') }}"><i class="fa fa-circle-o"></i>PIC Ijin Kerja</a>
          </li>
          <li class="{{ route('ehsspaccidents.index_masterlimbah') == request()->url() ? 'active' : '' }}">
           <a href="{{ route('ehsspaccidents.index_masterlimbah') }}"><i class="fa fa-circle-o"></i>Master Limbah B3 </a>
         </li>
        @endpermission
      </ul>
    </li>
  @endpermission
  @permission(['ehs-*', 'mgt-gembaehs-*'])
    <li class="treeview">
      <a href="#">
        <i class="fa fa-files-o"></i> <span>TRANSAKSI</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
      @if (strlen(Auth::user()->username) > 5)
        @permission(['ehs-wp-view','ehs-wp-create','ehs-wp-delete'])
          <li class="{{ route('ehstwp1s.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('ehstwp1s.index') }}"><i class="fa fa-circle-o"></i>Daftar Ijin Kerja</a>
          </li>
        @endpermission
      @endif
      @if (strlen(Auth::user()->username) == 5)
        @permission(['ehs-wp-view','ehs-wp-approve-*','ehs-wp-reject-*'])
          <li class="{{ route('ehstwp1s.all') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('ehstwp1s.all') }}"><i class="fa fa-circle-o"></i>Daftar Ijin Kerja</a>
          </li>
          <li class="{{ route('ehsspaccidents.index_swapantau') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('ehsspaccidents.index_swapantau') }}"><i class="fa fa-circle-o"></i>SWAPANTAU</a>
          </li>
          <li class="{{ route('ehsspaccidents.index_festronik') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('ehsspaccidents.index_festronik') }}"><i class="fa fa-circle-o"></i>Festronik</a>
          </li>
          <li class="{{ route('ehsspaccidents.index_equipfacility') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('ehsspaccidents.index_equipfacility') }}"><i class="fa fa-circle-o"></i>Equipment & Facility </a>
          </li>
          <li class="{{ route('ehsenv.index_ef') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('ehsenv.index_ef') }}"><i class="fa fa-circle-o"></i>Equipment & Facility 2</a>
          </li>
          <li class="{{ route('ehsspaccidents.index_pbhnkimia') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('ehsspaccidents.index_pbhnkimia') }}"><i class="fa fa-circle-o"></i>Pemakaian Bahan Kimia</a>
          </li>
          <li class="{{ route('ehsspaccidents.index_lvlairlimbah') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('ehsspaccidents.index_lvlairlimbah') }}"><i class="fa fa-circle-o"></i>Level Instalasi Air Limbah
            </a>
          </li>
          <li class="{{ route('ehsspaccidents.index_sp_accident') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('ehsspaccidents.index_sp_accident') }}"><i class="fa fa-circle-o"></i>Accident</a>
          </li>
        @endpermission
        @permission(['mgt-gembaehs-*'])
          @permission(['mgt-gembaehs-create'])
            <li class="{{ route('mgmtgembaehss.index') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('mgmtgembaehss.index') }}"><i class="fa fa-circle-o"></i>Daftar EHS Patrol</a>
            </li>
          @endpermission
          <li class="{{ route('mgmtgembaehss.indexcm') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mgmtgembaehss.indexcm') }}"><i class="fa fa-circle-o"></i>Daftar EHS Patrol - CM</a>
          </li>
        @endpermission
      @endif
      </ul>
    </li>
  @endpermission
  @if (strlen(Auth::user()->username) == 5)
    @permission(['ehs-*', 'mgt-gembaehs-*'])
      <li class="treeview">
        <a href="#">
          <i class="fa fa-files-o"></i> <span>LAPORAN</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          @permission(['ehs-*'])
            <li>
              <a href="{{ url('/monitoringwp') }}" target="_blank"><i class="fa fa-circle-o"></i>Monitoring WP</a>
            </li>
            <li>
              <a href="{{ url('/monitoringwpall') }}" target="_blank"><i class="fa fa-circle-o"></i>Monitoring WP IGP GROUP</a>
            </li>
            <li>
              <a href="{{ route('ehsenvreps.proses_equipment') }}"><i class="fa fa-circle-o"></i>Equipment & Facility</a>
            </li>
            <li>
              <a href="{{ route('ehsenvreps.prosesmon_pkimia') }}"><i class="fa fa-circle-o"></i>Pemakaian Bahan Kimia
             </a>
            </li>
             <li>
              <a href="{{ route('ehsenvreps.prosesmon_alimbah') }}"><i class="fa fa-circle-o"></i> Instalasi Air Limbah
             </a>
            </li>
          @endpermission
          @permission(['mgt-gembaehs-*'])
            <li class="{{ route('mgmtgembaehss.laporan') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('mgmtgembaehss.laporan') }}"><i class="fa fa-circle-o"></i>EHS Patrol</a>
            </li>
          @endpermission
        </ul>
      </li>
    @endpermission
  @endif
@endpermission

