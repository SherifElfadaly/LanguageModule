@extends('app')
@section('content')

<div class="container">
	<div class="col-sm-8">

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

		<h3>Add New Translation</h3>
		<form class="form-inline" id="languageContent_form_edit" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<div class="row">
				<div class="col-sm-3 col-sm-offset-9">
					<a href='{{ url("admin/language/languagecontents/show", [$item, $itemId]) }}' class="btn btn-block btn-default">back</a>
				</div>

				<div class="col-sm-3 col-sm-offset-9">
					<button type="submit" id="languageContent_submit" class="btn btn-block btn-default">Submit</button>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label">Language</label>
					<div class="col-sm-3">
						<select class="form-control" name="language_id" id="languageContent_language">
							<option value="{{ $language->id }}" selected>{{ $language->title }}</option>
						</select>
					</div>
				</div>
			</div>

			<div class="row"><br></div>

			<div class="row">
				<div class="col-sm-12 data">

					<div class="form-group">
						<label for="inputEmail3">Title</label>
						<input 
						type="text" 
						class="form-control" 
						id="title" 
						name="title" 
						placeholder="Title" 
						@if($languageContent)
							value = "{{ $languageContent->title }}"
						readonly 
						@else
							value = "{{ old('key') }}"
						@endif
						>
					</div>
					<div class="form-group">
						<label for="inputEmail3">Key</label>
						<input 
						type="text" 
						class="form-control" 
						id="key" 
						name="key" 
						@if($translations)
							value = "{{ $translations->key }}"
						@endif
						placeholder="Key" 
						>
					</div>
					<div class="form-group">
						<label for="inputEmail3">Value</label>
						<textarea
						type="text" 
						class="form-control" 
						id="value" 
						name="value" 
						placeholder="Value" 
						value="{{ old('value') }}"
						>
						@if($translations)
							{{ $translations->value }}
						@endif
						</textarea> 
					</div>
					<div class="row"><br></div>

				</div>
			</div>
		</form>
	</div>
	<div class="col-sm-2">
		<label for="album_name">Choos Galleries</label>
		{!! $mediaLibrary !!}
	</div>
</div>

@include('language::languagecontents.assets.addlanguagecontentgalleries')
@include('language::languagecontents.assets.tinymce')
@endsection
