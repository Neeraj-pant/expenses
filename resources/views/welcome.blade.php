@extends('layouts.app')

@section('content')
<div class="container">
    @include('alert')
    <div class="main">
        <div class="containear">
		  <section class="background">
		    <div class="content-wrapper">
		      <p class="content-title">Manage Groups.</p>
		      <p class="content-subtitle">Create, edit and delete Group!</p>
		    </div>
		  </section>
		  <section class="background">
		    <div class="content-wrapper">
		      <p class="content-title">Somthing special in payment.</p>
		      <p class="content-subtitle">add an see the paymeny detail.</p>
		    </div>
		  </section>
		  <section class="background">
		    <div class="content-wrapper">
		      <p class="content-title">Manage User.</p>
		      <p class="content-subtitle">Check every users activity.</p>
		    </div>
		  </section>
		</div>
    </div>
</div>
@endsection
