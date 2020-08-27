@if (strlen(Auth::user()->username) == 5)
@permission(['ppc-*'])
  <li class="header">PPC JKT NAVIGATION</li>
  @permission(['ppc-dpr-*', 'ppc-dnsupp-view', 'ppc-uniqcode-matuse-*'])
    <li class="treeview">
      <a href="#">
        <i class="fa fa-files-o"></i> <span>DATA INPUT</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i> <span>DLV & PROD PLAN ASSY</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>DLV TIME CONTROL (TRUCK)</a>
            </li>
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>PULLING CONTROL</a>
            </li>
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>E-KANBAN</a>
            </li>
          </ul>
        </li>
        @permission(['ppc-uniqcode-matuse-*'])
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i> <span>PROD PLAN MACH</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>DPS</a>
            </li>
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>DANDORY</a>
            </li>
            @permission(['ppc-uniqcode-matuse-*'])
            <li class="{{ route('uniqcodematuses.index') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('uniqcodematuses.index') }}"><i class="fa fa-circle-o"></i>MATERIAL USAGE</a>
            </li>
            @endpermission
          </ul>
        </li>
        @endpermission
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i> <span>ORDER HANDLING</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>LVC</a>
            </li>
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>PLANNING OVERTIME</a>
            </li>
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>COR</a>
            </li>
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>MATERIAL ISSUE</a>
            </li>
          </ul>
        </li>
        @permission(['ppc-dpr-*', 'ppc-dnsupp-view'])
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i> <span>MATERIAL PLANNING</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>SUBCONT CONTROL</a>
            </li>
            @permission(['ppc-dpr-*'])
            <li class="{{ route('ppctdprs.index') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('ppctdprs.index') }}"><i class="fa fa-circle-o"></i>Delivery Problem Report</a>
            </li>
              @permission(['ppc-dpr-apr-sh'])
                <li class="{{ route('ppctdprs.indexsh') == request()->url() ? 'active' : '' }}">
                  <a href="{{ route('ppctdprs.indexsh') }}"><i class="fa fa-circle-o"></i>DEPR Approval SH</a>
                </li>
              @endpermission
              @permission(['ppc-dpr-apr-dh'])
                <li class="{{ route('ppctdprs.indexdep') == request()->url() ? 'active' : '' }}">
                  <a href="{{ route('ppctdprs.indexdep') }}"><i class="fa fa-circle-o"></i>DEPR Approval DEP</a>
                </li>
              @endpermission
            <li class="{{ route('ppctdprpicas.all') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('ppctdprpicas.all') }}"><i class="fa fa-circle-o"></i>PICA DEPR</a>
            </li>
            @endpermission
            @permission(['ppc-dnsupp-view'])
            <li class="{{ route('baandnsupps.view') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('baandnsupps.view') }}"><i class="fa fa-circle-o"></i>DN RELEASE TO SUPPLIER</a>
            </li>
            @endpermission
          </ul>
        </li>
        @endpermission
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i> <span>WAREHOUSE PART</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>DLV TIME CONTROL (TRUCK SUPPLIER)</a>
            </li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i> <span>TOOLS,CONS & SERVICE PART</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            
          </ul>
        </li>
      </ul>
    </li>
  @endpermission
  @permission(['ppc-dncust-view', 'ppc-dsfin-view', 'ppc-mtruck-*', 'ppc-pag-view', 'ppc-dnsupp-view', 'ppc-stockwhs-view', 'ppc-cycletime-*'])
    <li class="treeview">
      <a href="#">
        <i class="fa fa-files-o"></i> <span>REPORT</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @permission(['ppc-dncust-view', 'ppc-dsfin-view', 'ppc-mtruck-*'])
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i> <span>DLV & PROD PLAN ASSY</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @permission(['ppc-dncust-view'])
            <li class="{{ route('baandncusts.index') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('baandncusts.index') }}"><i class="fa fa-circle-o"></i>OutStd. PO/DN TO CUSTOMER</a>
            </li>
            @endpermission
            @permission(['ppc-dsfin-view'])
            <li class="{{ route('baanOutDsFin.index') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('baanOutDsFin.index') }}"><i class="fa fa-circle-o"></i>OutStd. DS TO FINANCE</a>
            </li>
            @endpermission
            @permission(['ppc-mtruck-*'])
            <li class="{{ route('mtruck.index') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('mtruck.index') }}"><i class="fa fa-circle-o"></i>DLV TIME CONTROL (TRUCK)</a>
            </li>
            @endpermission
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>PULLING CONTROL</a>
            </li>
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>PALLET CONTROL</a>
            </li>
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>E-KANBAN</a>
            </li>
          </ul>
        </li>
        @endpermission
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i> <span>PROD PLAN MACH</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>DPS</a>
            </li>
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>DANDORY</a>
            </li>
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>MATERIAL USAGE</a>
            </li>
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>EFF CONTROL SYSYTEM</a>
            </li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i> <span>ORDER HANDLING</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>LVC</a>
            </li>
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>PLANNING OVERTIME</a>
            </li>
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>COR</a>
            </li>
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>MATERIAL ISSUE</a>
            </li>
          </ul>
        </li>
        @permission(['ppc-pag-view', 'ppc-dnsupp-view', 'ppc-stockwhs-view','ppc-dpr-report'])
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i> <span>MATERIAL PLANNING</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @permission(['ppc-pag-view'])
            <li class="{{ route('baanpags.index') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('baanpags.index') }}"><i class="fa fa-circle-o"></i>OUTSTANDING PAG</a>
            </li>
            @endpermission
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>SUBCONT CONTROL</a>
            </li>
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>TSURUBE CONTROL</a>
            </li>
            @permission(['ppc-dnsupp-view'])
            <li class="{{ route('baandnsupps.index') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('baandnsupps.index') }}"><i class="fa fa-circle-o"></i>DN RELEASE TO SUPPLIER</a>
            </li>
            @endpermission
            @permission(['ppc-stockwhs-view'])
            <li class="{{ route('stockohigps.ppc') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('stockohigps.ppc') }}"><i class="fa fa-circle-o"></i>STOCK WAREHOUSE</a>
            </li>
            @endpermission
            @permission(['ppc-dpr-report'])
                <li class="{{ route('ppctdprs.indexrep') == request()->url() ? 'active' : '' }}">
                  <a href="{{ route('ppctdprs.indexrep') }}"><i class="fa fa-circle-o"></i>DELIVERY PROBLEM REPORT</a>
                </li>
              @endpermission
          </ul>
        </li>
        @endpermission
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i> <span>WAREHOUSE PART</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @permission(['ppc-mtruck-*'])
            <li class="{{ route('mtruck.indexwhs') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('mtruck.indexwhs') }}"><i class="fa fa-circle-o"></i>DLV TIME CONTROL (TRUCK SUPPLIER)</a>
            </li>
            @endpermission
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>WAREHOUSE TRANFER CONTROL (WTI)</a>
            </li>
          </ul>
        </li>
        @permission(['ppc-cycletime-*'])
          <li class="{{ route('vwtctperiods.indexppc') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('vwtctperiods.indexppc') }}"><i class="fa fa-circle-o"></i>Cycle Time</a>
          </li>
        @endpermission
      </ul>
    </li>
  @endpermission
  @permission(['ppc-levelinventorycp-view'])
    <li class="treeview">
      <a href="#">
        <i class="fa fa-files-o"></i> <span>INVENTORY LEVEL</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i> <span>DLV & PROD PLAN ASSY</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @permission(['ppc-levelinventorycp-view'])
            <li class="{{ route('stockohigps.finishgood') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('stockohigps.finishgood') }}"><i class="fa fa-circle-o"></i>FINISH GOOD</a>
            </li>
            @endpermission
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i> <span>PROD PLAN MACH (WIP FINISH)</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="#"><i class="fa fa-circle-o"></i>FINISH PART</a>
            </li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i> <span>WAREHOUSE</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @permission(['ppc-levelinventorycp-view'])
            <li class="{{ route('stockohigps.componenpart') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('stockohigps.componenpart') }}"><i class="fa fa-circle-o"></i>COMPONENT PART</a>
            </li>
            @endpermission
            @permission(['ppc-levelinventorycp-view'])
            <li class="{{ route('stockohigps.tools') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('stockohigps.tools') }}"><i class="fa fa-circle-o"></i>LEVEL TOOLS & SPARE PARTS</a>
            </li>
            <li class="{{ route('stockohigps.consumable') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('stockohigps.consumable') }}"><i class="fa fa-circle-o"></i>CONSUMABLE</a>
            </li>       
            <li class="{{ route('stockohigps.servicepart') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('stockohigps.servicepart') }}"><i class="fa fa-circle-o"></i>SERVICE PARTS (JWRM3)</a>
            </li>
            @endpermission
          </ul>
        </li>
      </ul>
    </li>
  @endpermission
@endpermission
@endif