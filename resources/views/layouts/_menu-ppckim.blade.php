@if (strlen(Auth::user()->username) == 5)
  @permission(['ppckim-*', 'ppc-dnclaim-view', 'ppc-dnclaim-approve', 'ppc-monclaim-calculation', 'ppc-bpbcrcons-view'])
    <li class="header">PPC KIM NAVIGATION</li>
    @permission(['ppc-dnclaim-view', 'ppc-dnclaim-approve', 'ppc-monclaim-calculation', 'ppc-bpbcrcons-view'])
      <li class="treeview">
        <a href="#">
          <i class="fa fa-files-o"></i> <span>TRANSAKSI</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
        @permission(['ppc-dnclaim-view', 'ppc-dnclaim-approve'])
          <li class="{{ route('baaniginh008s.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('baaniginh008s.index') }}"><i class="fa fa-circle-o"></i>DN CLAIM TO SUPPLIER</a>
          </li>
          <li class="{{ route('ppctdnclaimsj1s.all') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('ppctdnclaimsj1s.all') }}"><i class="fa fa-circle-o"></i>SURAT JALAN CLAIM</a>
          </li>
        @endpermission
        @permission(['ppc-monclaim-calculation'])
          <li class="{{ route('baaniginh008s.monclaimcalculation') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('baaniginh008s.monclaimcalculation') }}"><i class="fa fa-circle-o"></i>Monetary Claim Calculation</a>
          </li>
        @endpermission
        @permission(['ppc-bpbcrcons-view'])
          <li class="{{ route('bpbcrcons.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('bpbcrcons.index') }}"><i class="fa fa-circle-o"></i>BPB CR CONSUMABLE REGULER</a>
          </li>
          <li class="{{ route('bpbcrconsireg.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('bpbcrconsireg.index') }}"><i class="fa fa-circle-o"></i>BPB CR CONSUMABLE IREGULER</a>
          </li>
        @endpermission
        </ul>
      </li>
    @endpermission
    @permission(['ppckim-levelinventorycp-view'])
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
              <i class="fa fa-files-o"></i> <span>PPC</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @permission(['ppckim-levelinventorycp-view'])
                <li class="{{ route('stockohigps.finishgoodkim') == request()->url() ? 'active' : '' }}">
                  <a href="{{ route('stockohigps.finishgoodkim') }}"><i class="fa fa-circle-o"></i>FINISH GOOD</a>
                </li>
              @endpermission
              @permission(['ppckim-levelinventorycp-view'])
                <li class="{{ route('stockohigps.wippartkim') == request()->url() ? 'active' : '' }}">
                  <a href="{{ route('stockohigps.wippartkim') }}"><i class="fa fa-circle-o"></i>WIP PART</a>
                </li>
              @endpermission
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
              @permission(['ppckim-levelinventorycp-view'])
                <li class="{{ route('stockohigps.componenpartkim') == request()->url() ? 'active' : '' }}">
                  <a href="{{ route('stockohigps.componenpartkim') }}"><i class="fa fa-circle-o"></i>COMPONENT PART</a>
                </li>
              @endpermission
              @permission(['ppckim-levelinventorycp-view'])
                <li class="{{ route('stockohigps.toolskim') == request()->url() ? 'active' : '' }}">
                  <a href="{{ route('stockohigps.toolskim') }}"><i class="fa fa-circle-o"></i>TOOLS & SPARE PARTS</a>
                </li>
                <li class="{{ route('stockohigps.consumablekim') == request()->url() ? 'active' : '' }}">
                  <a href="{{ route('stockohigps.consumablekim') }}"><i class="fa fa-circle-o"></i>CONSUMABLE</a>
                </li>
              @endpermission
            </ul>
          </li>
        </ul>
      </li>
    @endpermission
    @permission(['ppckim-levelinventorycp-view'])
      <li class="treeview">
        <a href="#">
          <i class="fa fa-files-o"></i> <span>REPORT</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          @permission(['ppckim-fto-view'])
          <li class="{{ route('ppcvftodays.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('ppcvftodays.index') }}"><i class="fa fa-circle-o"></i>FTO DAILY</a>
          </li>
          @endpermission
        </ul>
      </li>
    @endpermission
  @endpermission
@endif