@extends('app')
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
						@if(\AclRepository::can('edit', 'Languages'))
							<a 
							class ="btn btn-default" 
							href  ='{{ url("/language/edit/$language->id") }}' 
							role  ="button">
							Edit
							</a>
						@endif
						@if(\AclRepository::can('delete', 'Languages'))
							<a 
							class ="btn btn-default" 
							href  ='{{ url("/language/delete/$language->id") }}' 
							role  ="button">
							Delete
							</a>
						@endif

						@if(\AclRepository::can('edit', 'Languages'))
							<a 
							class ="btn btn-default" 
							href  ='{{ url("/language/active/$language->id") }}' 
							role  ="button"
							>
							@if($language->is_active === 'True')
								Disable
							@else
								Activate
							@endif
							</a>
						@endif

						@if(\AclRepository::can('edit', 'Languages'))
							@if($language->is_default !== 'True')
								<a class="btn btn-default" href='{{ url("/language/default/$language->id") }}' role="button">Default</a>
							@endif
						@endif
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection