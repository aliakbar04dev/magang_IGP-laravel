@permission(['budget-*'])
  <li class="header">BUDGET & COST CONTROL NAVIGATION</li>
  @permission(['budget-cr-rate-*','budget-cr-klasifikasi-*','budget-cr-kategori-*'])
    <li class="treeview">
      <a href="#">
        <i class="fa fa-files-o"></i> <span>MASTER</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @permission(['budget-cr-rate-*'])
          <li class="{{ route('bgttcrrates.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('bgttcrrates.index') }}"><i class="fa fa-circle-o"></i>Rate MP</a>
          </li>
        @endpermission
        @permission(['budget-cr-klasifikasi-*'])
          <li class="{{ route('bgttcrklasifis.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('bgttcrklasifis.index') }}"><i class="fa fa-circle-o"></i>Klasifikasi</a>
          </li>
        @endpermission
        @permission(['budget-cr-kategori-*'])
          <li class="{{ route('bgttcrkategors.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('bgttcrkategors.index') }}"><i class="fa fa-circle-o"></i>Kategori</a>
          </li>
        @endpermission
      </ul>
    </li>
  @endpermission
  @permission(['budget-komite-*','budget-komiteapproval', 'budget-komiteapproval-1', 'budget-komiteapproval-2','budget-cr-activities-*'])
    <li class="treeview">
      <a href="#">
        <i class="fa fa-files-o"></i> <span>TRANSAKSI</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @permission(['budget-komite-*'])
          <li class="{{ route('bgttkomite1s.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('bgttkomite1s.index') }}"><i class="fa fa-circle-o"></i>Daftar Komite Investasi</a>
          </li>
        @endpermission
        @permission(['budget-komiteapproval', 'budget-komiteapproval-1', 'budget-komiteapproval-2'])
          @permission('budget-komiteapproval')
            <li class="{{ route('bgttkomite1s.all') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('bgttkomite1s.all') }}"><i class="fa fa-circle-o"></i>Mapping Komite Investasi</a>
            </li>
          @endpermission
          <li class="{{ route('bgttkomite1s.allnotulen') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('bgttkomite1s.allnotulen') }}"><i class="fa fa-circle-o"></i>Notulen Komite Investasi</a>
          </li>
        @endpermission
        @permission(['budget-cr-activities-view', 'budget-cr-activities-create', 'budget-cr-activities-delete'])
          <li class="{{ route('bgttcrregiss.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('bgttcrregiss.index') }}"><i class="fa fa-circle-o"></i>CR Activities</a>
          </li>
          <li class="{{ route('bgttcrsubmits.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('bgttcrsubmits.index') }}"><i class="fa fa-circle-o"></i>CR Activities Progress</a>
          </li>
        @endpermission
        @permission('budget-cr-activities-approve-dep')
          <li class="{{ route('bgttcrregiss.indexdep') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('bgttcrregiss.indexdep') }}"><i class="fa fa-circle-o"></i>CR Activities [Dept]</a>
          </li>
          <li class="{{ route('bgttcrsubmits.indexdep') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('bgttcrsubmits.indexdep') }}"><i class="fa fa-circle-o"></i>CR Activities Progress [Dept]</a>
          </li>
        @endpermission
        @permission('budget-cr-activities-approve-div')
          <li class="{{ route('bgttcrregiss.indexdiv') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('bgttcrregiss.indexdiv') }}"><i class="fa fa-circle-o"></i>CR Activities [Div]</a>
          </li>
          <li class="{{ route('bgttcrsubmits.indexdiv') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('bgttcrsubmits.indexdiv') }}"><i class="fa fa-circle-o"></i>CR Activities Progress [Div]</a>
          </li>
        @endpermission
        @permission('budget-cr-activities-approve-budget')
          <li class="{{ route('bgttcrregiss.indexbudget') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('bgttcrregiss.indexbudget') }}"><i class="fa fa-circle-o"></i>CR Activities [Budget]</a>
          </li>
          <li class="{{ route('bgttcrsubmits.indexbudget') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('bgttcrsubmits.indexbudget') }}"><i class="fa fa-circle-o"></i>CR Activities Progress [Budget]</a>
          </li>
        @endpermission
      </ul>
    </li>
  @endpermission
  @permission(['budget-cr-activities-*'])
    <li class="treeview">
      <a href="#">
        <i class="fa fa-files-o"></i> <span>REPORT</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @permission(['budget-cr-activities-*'])
          <li class="{{ route('bgttcrsubmits.report') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('bgttcrsubmits.report') }}"><i class="fa fa-circle-o"></i>CR Progress Report</a>
          </li>
          <li class="{{ route('bgttcrsubmits.reportclassification') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('bgttcrsubmits.reportclassification') }}"><i class="fa fa-circle-o"></i>CR Classification Report</a>
          </li>
          <li class="{{ route('bgttcrsubmits.reportcategories') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('bgttcrsubmits.reportcategories') }}"><i class="fa fa-circle-o"></i>CR Categories Report</a>
          </li>
        @endpermission
        @permission('budget-cr-activities-approve-budget')
          <li class="{{ route('bgttcrsubmits.indexgrafik') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('bgttcrsubmits.indexgrafik') }}"><i class="fa fa-circle-o"></i>CR Progress Grafik</a>
          </li>
          <li class="{{ route('bgttcrsubmits.indexdashboard') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('bgttcrsubmits.indexdashboard') }}"><i class="fa fa-circle-o"></i>CR Dashboard</a>
          </li>
        @endpermission
      </ul>
    </li>
  @endpermission
@endpermission