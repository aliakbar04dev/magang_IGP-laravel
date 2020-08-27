@if (strlen(Auth::user()->username) == 5)
  @permission(['pp-*', 'monitoring-ops', 'prc-po-apr-*', 'prc-po-setting-npk', 'prc-ssr-*', 'prc-rfq-*', 'prc-reportpp-*'])
  <li class="header">PROCUREMENT NAVIGATION</li>
    @permission(['prc-po-setting-npk'])
      <li class="treeview">
        <a href="#">
          <i class="fa fa-files-o"></i> <span>MASTER</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          @permission(['prc-po-setting-npk'])
            <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i> <span>PURCHASE ORDER</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                @permission(['prc-po-setting-npk'])
                  <li class="{{ route('prcmnpks.index') == request()->url() ? 'active' : '' }}">
                    <a href="{{ route('prcmnpks.index') }}"><i class="fa fa-circle-o"></i>Setting NPK</a>
                  </li>
                  <li class="{{ route('prctepobpids.index') == request()->url() ? 'active' : '' }}">
                    <a href="{{ route('prctepobpids.index') }}"><i class="fa fa-circle-o"></i>Mapping BPID</a>
                  </li>
                @endpermission
              </ul>
            </li>
          @endpermission
        </ul>
      </li>
    @endpermission
    @permission(['pp-*', 'prc-po-apr-*', 'prc-ssr-*', 'prc-rfq-*'])
      <li class="treeview">
        <a href="#">
          <i class="fa fa-files-o"></i> <span>TRANSAKSI</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          @permission(['pp-*'])
            <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i> <span>PP</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                @permission(['pp-reg-view','pp-reg-approve-*'])
                  <li class="{{ route('ppregs.index') == request()->url() ? 'active' : '' }}">
                    <a href="{{ route('ppregs.index') }}"><i class="fa fa-circle-o"></i>Register PP</a>
                  </li>
                @endpermission
              </ul>
            </li>
          @endpermission
          @permission(['prc-po-apr-*'])
            <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i> <span>PURCHASE ORDER</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                @permission(['prc-po-apr-*'])
                  @permission('prc-po-apr-pic')
                    <li class="{{ route('baanpo1s.indexpic') == request()->url() ? 'active' : '' }}">
                      <a href="{{ route('baanpo1s.indexpic') }}"><i class="fa fa-circle-o"></i>Approval PO PIC</a>
                    </li>
                  @endpermission
                  @permission('prc-po-apr-sh')
                    <li class="{{ route('baanpo1s.indexsh') == request()->url() ? 'active' : '' }}">
                      <a href="{{ route('baanpo1s.indexsh') }}"><i class="fa fa-circle-o"></i>Approval PO SH</a>
                    </li>
                  @endpermission
                  @permission('prc-po-apr-dep')
                    <li class="{{ route('baanpo1s.indexdep') == request()->url() ? 'active' : '' }}">
                      <a href="{{ route('baanpo1s.indexdep') }}"><i class="fa fa-circle-o"></i>Approval PO DEP</a>
                    </li>
                  @endpermission
                  @permission('prc-po-apr-div')
                    <li class="{{ route('baanpo1s.indexdiv') == request()->url() ? 'active' : '' }}">
                      <a href="{{ route('baanpo1s.indexdiv') }}"><i class="fa fa-circle-o"></i>Approval PO DIV</a>
                    </li>
                  @endpermission
                  @permission(['prc-po-apr-*'])
                    <li class="{{ route('baanpo1s.index') == request()->url() ? 'active' : '' }}">
                      <a href="{{ route('baanpo1s.index') }}"><i class="fa fa-circle-o"></i>Daftar PO</a>
                    </li>
                    <li class="{{ route('baanpo1s.monitoring') == request()->url() ? 'active' : '' }}">
                      <a href="{{ route('baanpo1s.monitoring') }}"><i class="fa fa-circle-o"></i>Monitoring PO Portal</a>
                    </li>
                    <li class="{{ route('baanpo1s.monitoringtotal') == request()->url() ? 'active' : '' }}">
                      <a href="{{ route('baanpo1s.monitoringtotal') }}"><i class="fa fa-circle-o"></i>Monitoring Total PO</a>
                    </li>
                  @endpermission
                @endpermission
              </ul>
            </li>
          @endpermission
          @permission(['prc-ssr-*'])
            <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i> <span>SSR</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                @permission(['prc-ssr-*'])
                  <li class="{{ route('prctssr1s.index') == request()->url() ? 'active' : '' }}">
                    <a href="{{ route('prctssr1s.index') }}"><i class="fa fa-circle-o"></i>Daftar SSR</a>
                  </li>
                @endpermission
              </ul>
            </li>
          @endpermission
          @permission(['prc-rfq-*', 'prc-ssr-*'])
            <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i> <span>RFQ</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                @permission(['prc-rfq-*', 'prc-ssr-*'])
                  @permission(['prc-rfq-*'])
                    <li class="{{ route('prctrfqs.index') == request()->url() ? 'active' : '' }}">
                      <a href="{{ route('prctrfqs.index') }}"><i class="fa fa-circle-o"></i>Daftar RFQ</a>
                    </li>
                  @endpermission
                  <li class="{{ route('prctrfqs.indexanalisa') == request()->url() ? 'active' : '' }}">
                    <a href="{{ route('prctrfqs.indexanalisa') }}"><i class="fa fa-circle-o"></i>Analisa RFQ</a>
                  </li>
                @endpermission
              </ul>
            </li>
          @endpermission
        </ul>
      </li>
    @endpermission
    @permission(['monitoring-ops', 'prc-reportpp-*', 'prc-po-apr-*'])
      <li class="treeview">
        <a href="#">
          <i class="fa fa-files-o"></i> <span>LAPORAN</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          @permission(['monitoring-ops', 'prc-reportpp-*'])
            <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i> <span>PP</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                @permission('monitoring-ops')
                  <li>
                    <a href="{{ url('/ops') }}" target="_blank"><i class="fa fa-circle-o"></i>Monitoring OPS</a>
                  </li>
                  <li>
                    <a href="{{ url('/ops2') }}" target="_blank"><i class="fa fa-circle-o"></i>Monitoring OPS 2</a>
                  </li>
                  <li>
                    <a href="{{ url('/komite') }}" target="_blank"><i class="fa fa-circle-o"></i>Monitoring Komite</a>
                  </li>
                  <li>
                    <a href="{{ url('/pppolpb') }}" target="_blank"><i class="fa fa-circle-o"></i>Monitoring PP-PO-LPB</a>
                  </li>
                @endpermission
                @permission('prc-reportpp-*')
                  <li class="{{ route('reportpp.index') == request()->url() ? 'active' : '' }}">
                    <a href="{{ route('reportpp.index') }}"><i class="fa fa-circle-o"></i>Monitoring PP</a>
                  </li>
                @endpermission
              </ul>
            </li>
          @endpermission
          @permission(['prc-po-apr-*'])
            <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i> <span>PURCHASE ORDER</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                @permission(['prc-po-apr-*'])
                  <li class="{{ route('baanpo1s.indexhistory') == request()->url() ? 'active' : '' }}">
                    <a href="{{ route('baanpo1s.indexhistory') }}"><i class="fa fa-circle-o"></i>History Pembelian</a>
                  </li>
                @endpermission
              </ul>
            </li>
          @endpermission
        </ul>
      </li>
    @endpermission
  @endpermission
@endif