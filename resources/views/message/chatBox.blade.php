@extends('layout.base')

@section('styleCSS')
<title>Messenger</title>
	  <link rel="stylesheet"  href="/assets/css/chatBox.css">
	  <script src="/assets/vendor/htmx/htmx.js"></script>
@endsection

@section('Page') 

		<div class="container-fluid h-100 " >
			<div class="row justify-content-center h-100">
				<div class="col-md-4 col-xl-3 chat" style="margin-top : 110px;" data-aos="fade-right" data-aos-duration="1500"><div class="card mb-sm-3 mb-md-0 contacts_card" >
					<div class="card-header">
						<div class="input-group">
							<input type="text" placeholder="Type the user code..." name ='id' id="userInput" class="form-control search">
							<div class="input-group-prepend">
								<span class="input-group-text search_btn" id="submitBtn"><i class="bi bi-search"></i></span>
							</div>
						</div>
					</div>

					@livewire('contacts')


					<div class="card-footer"></div>
				</div></div>
				<div class="col-md-8 col-xl-6 chat" style="margin-top : 110px;">
					<div class="card" data-aos="fade-left" data-aos-duration="1500">

						@isset($conversation)
							<script src="/assets/js/conversation.js"></script>
							@livewire('messages')
						@endisset

					</div>
				</div>
			</div>
		</div>

	@if (session('notFound'))
	<script>new swal({ 
		 icon: "error",
		 title: 'The user you entered does not exist.', });</script>
	@endif

	@if (session('you'))
	<script>new swal({ title: 'You can\'t contact yourself.', });</script>
	@endif


	<script src="/assets/js/chatBox.js"></script>
@endsection


