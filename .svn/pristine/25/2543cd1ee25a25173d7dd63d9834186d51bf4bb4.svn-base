@if (session()->has('flash_notification.message'))
  {{-- <div class="container"> --}}
    <div class="alert alert-dismissible alert-{{ session()->get('flash_notification.level') }}">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      {!! session()->get('flash_notification.message') !!}
    </div>
  {{-- </div> --}}
@endif

@if (session()->has('sweet_alert.title'))
	<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
    <script>
    	@if (session()->has('sweet_alert.timer'))
	    	swal({
	    	  type: '{!! session()->get('sweet_alert.type') !!}',
			  title: '{!! session()->get('sweet_alert.title') !!}',
			  text: '{!! session()->get('sweet_alert.text') !!}',
			  timer: '{!! session()->get('sweet_alert.timer') !!}',
			  showConfirmButton: '{!! session()->get('sweet_alert.showConfirmButton') !!}'
			}).catch(swal.noop);
		@else
			swal({
	    	  type: '{!! session()->get('sweet_alert.type') !!}',
			  title: '{!! session()->get('sweet_alert.title') !!}',
			  text: '{!! session()->get('sweet_alert.text') !!}'
			});
		@endif
    </script>
@endif