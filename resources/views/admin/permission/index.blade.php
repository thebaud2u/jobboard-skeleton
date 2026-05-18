@extends('layouts.admin')

@section('body')
	<h1 class="text-gray-700 text-3xl font-medium">
		{{ __('Permissions') }}
	</h1>

	<!-- Bootstrap classes below -->
	<div class="bg-light p-4 rounded">
		<div class="lead">
			{{ __('Manage permissions') }}
		</div>

		<div :class="'mt-2'">
			<a href="{{ route('admin.permissions.create') }}" class="btn btn-primary btn-sm float-right">
				{{ __('Add permission') }}
			</a>
		</div>

		<div class="container mt-4">

			<table class="table table-striped">
				<thead>
				<tr>
					<th scope="col" width="15%">{{ __('Name') }}</th>
					<th scope="col">{{ __('Guard') }}</th>
					<th scope="col" colspan="2" width="1%"></th>
				</tr>
				</thead>
				<tbody>
					@foreach($permissions as $permission)
						<tr>
							<td>{{ $permission->name }}</td>
							<td>{{ $permission->guard_name }}</td>
							<td>
								<a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-info btn-sm">
									{{ __('Edit') }}
								</a>
							</td>
							<td>
								<form method="post" action="{{ route('admin.permissions.destroy', $permission->id) }}" class="inline">
									@method('delete')
									@csrf

									<button type="submit" class="btn btn-danger btn-sm">
										{{ __('Delete') }}
									</button>
								</form>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

		</div>
	</div>
@endsection
