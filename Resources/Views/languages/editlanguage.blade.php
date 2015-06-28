@extends('core::app')
@section('content')

<div class="container">
	<div class="col-sm-9">
		@if (count($errors) > 0)
		<div class="alert alert-danger">
			<strong>Whoops!</strong> There were some problems with your input.<br><br>
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif

		@if (Session::has('message'))
		<div class="alert alert-success">
			<ul>
				<li>{{ Session::get('message') }}</li>
			</ul>
		</div>
		@endif

		<h3>Add New Llanguage</h3>
		<form class="form-horizontal" id="language_form_edit" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Language Key</label>
				<div class="col-sm-10">
					<input 
					type        ="text" 
					class       ="form-control" 
					id          ="language_key" 
					name        ="key" 
					placeholder ="Language Key" 
					value       ="{{ $language->key }}"
					>
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Language Title</label>
				<div class="col-sm-10">
					<input 
					type        ="text" 
					class       ="form-control" 
					id          ="language_title" 
					name        ="title" 
					placeholder ="Language Title" 
					value       ="{{ $language->title }}"
					>
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Language Description</label>
				<div class="col-sm-10">
					<input 
					type        ="text" 
					class       ="form-control" 
					id          ="language_desription" 
					name        ="description" 
					placeholder ="Language Description" 
					value       ="{{ $language->description }}"
					>
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Language Flag</label>
				<div class="col-sm-10">
					<input 
					type        ="text" 
					class       ="form-control" 
					id          ="language_flag" 
					name        ="flag" 
					placeholder ="Language Flag" 
					value       ="{{ $language->flag }}"
					>
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword3" class="col-sm-2 control-label">Is Active</label>
				<div class="col-sm-10">
					<input 
					type ="checkbox" 
					id   ="is_active" 
					name ="is_active" 
					@if($language->is_active === 'True') 
						checked
					@endif"
					>
					Is Active
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword3" class="col-sm-2 control-label">Is Default</label>
				<div class="col-sm-10">
					<input 
					type ="checkbox" 
					id   ="is_default" 
					name ="is_default" 
					@if($language->is_default === 'True') 
						checked
					@endif"
					>
					Is Default
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" id="language_submit" class="btn btn-default">Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
