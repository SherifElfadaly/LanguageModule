@extends('core::app')
@section('content')

<div class="container">
	<div class="col-sm-9">

		<h3>{{ $item }}'s Translations</h3>
		@if(\CMS::permissions()->can('add', 'LanguageContents'))
			<a 
			class ="btn btn-default" href='{{ url("admin/language/languagecontents/create", [$item, $itemId]) }}'>
				Add Translations
			</a>
		@endif
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
						<td>{{ $languageContent->translations->first()->value }}</td>
						<td>

							@if(\CMS::permissions()->can('delete', 'LanguageContents'))
								<a 
								class ="btn btn-default" 
								href  ='{{ url("admin/language/languagecontents/delete", [$languageContent->id]) }}' 
								role  ="button">
								Delete
								</a>
							@endif

							@if(\CMS::permissions()->can('add', 'LanguageContents'))
								@foreach($languageContent->languages as $langugage)
									<a 
									class ="btn btn-default" 
									href  ='{{ url("admin/language/languagecontents/create", [$item, $itemId, $langugage['lang']->id, $languageContent->id]) }}' 
									role  ="button"
									>
									{{ $langugage['lang']->key }}
									<small>@if( ! $langugage['translated']) || Not Translated @endif</small>
									</a>
								@endforeach
							@endif
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection