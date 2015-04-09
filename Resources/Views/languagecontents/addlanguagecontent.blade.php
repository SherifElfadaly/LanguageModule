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
		<h3>Add New Language Content</h3>
		<form class="form-inline" id="languageContent_form_edit" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<div class="row">
				<div class="col-sm-3 col-sm-offset-9">
					<a href='{{ url("/language/languagecontents/show", [$item, $itemId]) }}' class="btn btn-block btn-default">back</a>
				</div>

				<div class="col-sm-3 col-sm-offset-9">
					<button type="submit" id="languageContent_submit" class="btn btn-block btn-default">Submit</button>
				</div>
				
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-4 control-label">Language</label>
					<div class="col-sm-3">
						<select class="form-control" name="language_id" id="languageContent_language">
							<option value="{{ $language->id }}" selected>{{ $language->title }}</option>
						</select>
					</div>
				</div>

				<div class="col-sm-3 col-sm-offset-1">
					<a id="add" class="btn btn-default" @if($languageContent) disabled @endif>Add</a>
					<a id="remove" class="btn btn-default" @if($languageContent) disabled @endif>Remove</a>
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
						name="title[]" 
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
						name="key[]" 
						@if($languageContentData)
						value = "{{ $languageContentData->key }}"
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
						name="value[]" 
						placeholder="Value" 
						value="{{ old('value') }}"
						>
						@if($languageContentData)
						{{ $languageContentData->value }}
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
		@include('gallery::parts.modals.mediamodal')
	</div>
</div>

<script src="{{ asset('assets/js/content/addcontentgalleries.js') }}"></script>
<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: "textarea",
    theme: "modern",
    height: 300,
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor"
   ],
   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons", 
   style_formats: [
        {title: 'Bold text', inline: 'b'},
        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
        {title: 'Example 1', inline: 'span', classes: 'example1'},
        {title: 'Example 2', inline: 'span', classes: 'example2'},
        {title: 'Table styles'},
        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
    ]
 }); 
</script>
@endsection
