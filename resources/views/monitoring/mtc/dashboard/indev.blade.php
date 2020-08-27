@extends('monitoring.mtc.layouts.app3')

@section('content')
  
@endsection
<center><p style="font-size: 36px; margin-top:250px;">IN DEVELOPMENT</h1></center>
    @if($id == 'power')
    <footer style="background-color:white; min-height:50px;" class="navbar-fixed-bottom">
            <center>
              <a href="{{ route('smartmtcs.dashboardmtc2') }}" class="btn bg-navy">Home</a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <a href="{{ route('smartmtcs.powerutil') }}" class="btn bg-navy">Back</a>
        </center>
          </footer>
          @else 
          <footer style="background-color:white; min-height:50px;" class="navbar-fixed-bottom">
                <center>
                  <a href="{{ route('smartmtcs.dashboardmtc2') }}" class="btn bg-navy">Home</a>
            </center>
              </footer>
          @endif
@section('scripts')
