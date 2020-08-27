@if (strlen(Auth::user()->username) == 5)
  @permission(['pica-*'])
    <li class="header">PROJECT DEVELOPMENT</li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-file-text-o"></i> <span>PPAP DOCUMENT</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i> <span>Part Inspection Standard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @permission(['pica-*'])
            <li><a href="{{ route('pistandards.index') }}"><i class="fa fa-circle-o"></i>Part Inspection Standard</a></li>  
            <li><a href="{{ url('admin/aprovalstaf') }}"><i class="fa fa-circle-o"></i>Staf Approval</a></li>
            <li><a href="{{ url('admin/aprovalSectHeadSQE') }}"><i class="fa fa-circle-o"></i>Sect Approval</a></li>
            <li><a href="{{ url('admin/aprovalDeptHeadSQE') }}"><i class="fa fa-circle-o"></i>Dept Approval</a></li>
            @endpermission
          </ul>
        </li>
      </ul>
    </li>
  @endpermission
@endif
@if (strlen(Auth::user()->username) > 5)
  @permission(['sa-*'])
    <li class="header">PROJECT DEVELOPMENT</li>
    <li class="treeview">
      @permission(['sa-*']) 
        <a href="#">
          <i class="fa fa-file-text-o"></i> <span>PPAP DOCUMENT</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">         
         <li><a href="{{ route('pistandards.index') }}"><i class="fa fa-circle-o"></i>Part Inspection Standard</a></li>  
        </ul>
      @endpermission
    </li>
  @endpermission
@endif