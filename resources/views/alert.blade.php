@if(session()->has('message'))
	<div class="alert alert-{{ session()->get('class') }}" role="alert">
		{{ session()->get('message') }}
	</div>
@endif
