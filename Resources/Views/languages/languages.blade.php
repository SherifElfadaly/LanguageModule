@extends('language::app')

@section('content')

<div class="container">
	<div class="col-sm-9">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Language Key</th>
					<th>Language Title</th>
					<th>Language Description</th>
					<th>Language Flag</th>
					<th>Is Actived</th>
					<th>is Default</th>
					<th>Options</th>
				</tr>
			</thead>
			<tbody>
				@foreach($languages as $language)
				<tr>
					<th scope="row">{{ $language->id }}</th>
					<td>{{ $language->key }}</td>
					<td>{{ $language->title }}</td>
					<td>{{ $language->description }}</td>
					<td>{{ $language->flag }}</td>
					<td>{{ $language->is_active }}</td>
					<td>{{ $language->is_default }}</td>
					<td>
						<a class="btn btn-default" href='{{ url("/language/edit/$language->id") }}' role="button">Edit</a>
						<a class="btn btn-default" href='{{ url("/language/delete/$language->id") }}' role="button">Delete</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection