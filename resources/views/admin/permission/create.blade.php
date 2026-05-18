@extends('layouts.app')

@section('body')
	<h1 class="text-gray-700 text-3xl font-medium">
		{{ __('Create permission') }}
	</h1>

	<!-- Bootstrap classes below -->
	<div class="bg-light p-4 rounded">
		<div class="lead">
			{{ __('Add a new permission') }}
		</div>

		<div class="container mt-4">
			<form method="POST" action="{{ route('admin.permission.store') }}">
				@csrf

				<div class="mb-3">
					<label for="name" class="form-label">
						{{ __('Name') }}
					</label>

					<input value="{{ old('name') }}" type="text" class="form-control" name="name" placeholder="Name" required>

					@if($errors->has('name'))
						<span class="text-danger text-left">{{ $errors->first('name') }}</span>
					@endif
				</div>

				<button type="submit" class="btn btn-primary">
					{{ __('Save permission') }}
				</button>

				<a href="{{ route('admin.permissions') }}" class="btn btn-default">
					{{ __('Back') }}
				</a>
			</form>
		</div>
	</div>
@endsection
