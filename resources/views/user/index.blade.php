@extends('layouts.admin')

@section('title', trans('user.page_title.index'))

@section('content')

<section>
	<h1>{{ trans('user.page_title.index') }}</h1>
</section>

@if(isset($users))
<div class="table-wrapper even-horizontal-medium-table">
	<table>
		<thead>
			<tr>
				<th width="50">ID</th>
				<th>{{ trans('user.table_heading.name') }}</th>
				<th>{{ trans('user.table_heading.email') }}</th>
				<th>{{ trans('user.table_heading.role') }}</th>
				<th>{{ trans('user.table_heading.status') }}</th>
				<th class="edit-field-heading"></th>
			</tr>
		</thead>
		<tbody>
			@forelse($users as $user)
			<tr>
				<td>
					<div class="field-label hide-medium">ID</div>
					<span>{{ $user->id }}</span>
				</td>
				<td>
					<div class="field-label hide-medium">{{ trans('user.table_heading.name') }}</div>
					<span>{{ $user->name }}</span>
				</td>
				<td>
					<div class="field-label hide-medium">{{ trans('user.table_heading.email') }}</div>
					<span>{{ $user->email }}</span>
				</td>
				<td>
					<div class="field-label hide-medium">{{ trans('user.table_heading.role') }}</div>
					<span>{{ trans('user.role.'.$user->role) }}</span>
				</td>
				<td class="@if ($user->status === 'active') success-field @else error-field @endif">
					<div class="field-label hide-medium">{{ trans('user.table_heading.status') }}</div>
					<span>{{ trans('user.status.'.$user->status) }}</span>
				</td>
				<td class="edit-field">
					<div>
						<div class="field-label hide-medium">{{ trans('user.table_heading.edit_or_delete') }}</div>
						<a href="{{ action('UserController@edit', $user->id) }}"  title="{{ trans('user.link_title.edit') }}"><i class="fa fa-edit"></i></a>
						<form action="{{ action('UserController@destroy', $user->id) }}" id="user_{{ $user->id }}" class="inline" method="post">
							{{ csrf_field() }}
							{{ method_field('delete') }}
							<a href="#" title="{{ trans('user.link_title.delete') }}" data-delete-id="user_{{ $user->id }}" data-delete-confirm="{{ trans('user.message.delete_instance') }}"><i class="fa fa-trash"></i></a>
						</form>
					</div>
				</td>
			</tr>
			@empty
			@endforelse
		</tbody>
	</table>
</div>

{{ $users->links() }}

@else
<p>{{ trans('user.message.no_result') }}</p>
@endif

@endsection

@section('sidebar')
	<h3>Sidebar</h3>
	<p>Bourbon Neat is used for grid system in this example.</p>
@stop

@section('javascript')
	@parent
@endsection
