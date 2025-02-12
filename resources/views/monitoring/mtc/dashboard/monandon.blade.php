@extends('monitoring.mtc.layouts.app3')
<style type="text/css">
  body {
    background-image: url("{{ asset('images/warehouse_bg.jpg') }}");
  }
</style>
@section('content')
  <div class="container3">
    @if (isset($andon) && isset($tgl_andon))
      {{-- @if($andon->mtcAndons("1", $tgl_andon)->count() > 0) --}}
        <!-- Informasi ANDON IGP 2-->
        <!-- Info boxes -->
        <div class="row" id="box-body-andon-igp1" name="box-body-andon-igp1">
          @include ('mtc.andon.andon1')
        </div>
        <!-- /.row -->
        <!-- End Informasi ANDON IGP 1-->
      {{-- @endif --}}

      {{-- @if($andon->mtcAndons("2", $tgl_andon)->count() > 0) --}}
        <!-- Informasi ANDON IGP 2-->
        <!-- Info boxes -->
        <div class="row" id="box-body-andon-igp2" name="box-body-andon-igp2">
          @include ('mtc.andon.andon2')
        </div>
        <!-- /.row -->
        <!-- End Informasi ANDON IGP 2-->
      {{-- @endif --}}
      
      {{-- @if($andon->mtcAndons("3", $tgl_andon)->count() > 0) --}}
        <!-- Informasi ANDON IGP 3-->
        <!-- Info boxes -->
        <div class="row" id="box-body-andon-igp3" name="box-body-andon-igp3">
          @include ('mtc.andon.andon3')
        </div>
        <!-- /.row -->
        <!-- End Informasi ANDON IGP 3-->
      {{-- @endif --}}
    @endif
  </div>
@endsection

@section('scripts')
<script>
  /*
  $(document).ready(function () {
    {{-- @if(isset($andon) && isset($tgl_andon)) --}}
      
      var title1 = "";
      {{-- @if($andon->mtcAndons("1", $tgl_andon)->count() > 0) --}}
        title1 = "<strong><font size='12'>LINE IGP-1</font></strong>";
      {{-- @endif --}}
      var title2 = "";
      {{-- @if($andon->mtcAndons("2", $tgl_andon)->count() > 0) --}}
        title2 = "<strong><font size='12'>LINE IGP-2</font></strong>";
      {{-- @endif --}}
      var title3 = "";
      {{-- @if($andon->mtcAndons("3", $tgl_andon)->count() > 0) --}}
        title3 = "<strong><font size='12'>LINE IGP-3</font></strong>";
      {{-- @endif --}}

      if(title1 !== "") {
        document.getElementById("box-title-andon-igp1").innerHTML = title1;
      }
      if(title2 !== "") {
        document.getElementById("box-title-andon-igp2").innerHTML = title2;
      }
      if(title3 !== "") {
        document.getElementById("box-title-andon-igp3").innerHTML = title3;
      }

      setInterval(function(){
        $("#box-body-andon-igp1").load("mtc-andon-igp1/T", function() {
          if(title1 !== "") {
            document.getElementById("box-title-andon-igp1").innerHTML = title1;
          }
        });
        $("#box-body-andon-igp2").load("mtc-andon-igp2/T", function() {
          if(title2 !== "") {
            document.getElementById("box-title-andon-igp2").innerHTML = title2;
          }
        });
        $("#box-body-andon-igp3").load("mtc-andon-igp3/T", function() {
          if(title3 !== "") {
            document.getElementById("box-title-andon-igp3").innerHTML = title3;
          }
        });
      }, 10000);
    {{-- @endif --}}
  });
  */

  //auto refresh
  setTimeout(function() {
    location.reload();
  }, 60000); //1000 = 1 second
</script>
@endsection