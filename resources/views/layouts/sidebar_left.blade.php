<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ Auth::user()->foto() }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->username }}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    {{-- <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
      </div>
    </form> --}}
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->

    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <li class="{{  url('/home') == request()->url() ? 'active' : '' }}">
        <a href="{{ url('/home') }}">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>
      @include('layouts._menu-admin')
      @include('layouts._menu-faco')
      @include('layouts._menu-mtc')
      @include('layouts._menu-eng')
      @include('layouts._menu-eproc')
      @include('layouts._menu-eppc')
      @include('layouts._menu-prc')
      @include('layouts._menu-qc')
      @include('layouts._menu-qa')
      @include('layouts._menu-pis')
      @include('layouts._menu-ppc')
      @include('layouts._menu-ppckim')
      @include('layouts._menu-prod')
      @include('layouts._menu-ehs')
      @include('layouts._menu-sales')
      @include('layouts._menu-eqc')
      @include('layouts._menu-mgt')
      @include('layouts._menu-mgtdep')
      @include('layouts._menu-hr')
      @include('layouts._menu-budget')
      @include('layouts._menu-employeeinfo')
      @include('layouts._menu-it')
      @include('layouts._menu-newemployee')
      @include('layouts._menu-setting')
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>