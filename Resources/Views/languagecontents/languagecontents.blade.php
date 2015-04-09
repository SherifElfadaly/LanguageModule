@extends('app')

@section('content')
<div class="container">
	<div class="col-sm-9">
		<h3>{{ $item }}'s Language Content</h3>

		<a 
		class="btn btn-default" href='{{ url("/language/languagecontents/create", [$item, $itemId]) }}' 
		role="button">
		Add Language Content Data
		</a>

		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Title</th>
					<th>Value</th>
					<th>Options</th>
				</tr>
			</thead>
			<tbody>
				@foreach($languageContents as $languageContent)
					<tr>
						<th scope="row">{{ $languageContent->id }}</th>
						<td>{{ $languageContent->title }}</td>
						<td>{{ $languageContent->languageContentData->first()->value }}</td>
						<td>
							<a 
							class="btn btn-default" 
							href='{{ url("/language/languagecontents/delete", [$languageContent->id]) }}' 
							role="button">
							Delete
							</a>

							@foreach($languageContent->languages as $langugage)
								<a 
								class="btn btn-default" 
								href='{{ url("/language/languagecontents/create", [$item, $itemId, $langugage['lang']->id, $languageContent->id]) }}' 
								role="button"
								>
								{{ $langugage['lang']->key }}
								<small>@if( ! $langugage['translated']) || Not Translated @endif</small>
								</a>
							@endforeach
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection