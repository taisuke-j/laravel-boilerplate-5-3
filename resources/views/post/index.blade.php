@extends('layouts.admin')

@section('title', trans('post.page_title.index'))

@section('content')

<section>
	<h1>{{ trans('post.page_title.index') }}</h1>
</section>

@if(isset($posts))
<div class="table-wrapper even-horizontal-medium-table">
	<table>
		<thead>
			<tr>
				<th width="50">ID</th>
				<th>{{ trans('post.table_heading.title') }}</th>
				<th>{{ trans('post.table_heading.slug') }}</th>
				<th>{{ trans('post.table_heading.category') }}</th>
				<th>{{ trans('post.table_heading.status') }}</th>
				<th class="edit-field-heading"></th>
			</tr>
		</thead>
		<tbody>
			@forelse($posts as $post)
			<tr>
				<td>
					<div class="field-label hide-medium">ID</div>
					<span>{{ $post->id }}</span>
				</td>
				<td>
					<div class="field-label hide-medium">{{ trans('post.table_heading.title') }}</div>
					<a href="{{ url('/post/'.$post->slug) }}" title="{{ trans('post.link_title.show') }}">{{ $post->title }}</a>
				</td>
				<td>
					<div class="field-label hide-medium">{{ trans('post.table_heading.slug') }}</div>
					<span>{{ $post->slug }}</span>
				</td>
				<td>
					<div class="field-label hide-medium">{{ trans('post.table_heading.category') }}</div>
					@if (count($post->categories()->get()))
						<span>{{ $post->categories()->first()->name }}</span>
					@else
						<span>{{ trans('post.placeholder.not_set') }}</span>
					@endif
				</td>
				<td class="@if ($post->status === 'public') success-field @endif">
					<div class="field-label hide-medium">{{ trans('post.table_heading.status') }}</div>
					<span>{{ trans('post.status.'.$post->status) }}</span>
				</td>
				<td class="edit-field">
					<div>
						<div class="field-label hide-medium">{{ trans('post.table_heading.edit_or_delete') }}</div>
						<a href="{{ action('PostController@edit', $post->slug) }}"  title="{{ trans('post.link_title.edit') }}"><i class="fa fa-edit"></i></a>
						<form action="{{ action('PostController@destroy', $post->slug) }}" id="post_{{ $post->id }}" class="inline" method="post">
							{{ csrf_field() }}
							{{ method_field('delete') }}
							<a href="#" title="{{ trans('post.link_title.delete') }}" data-delete-id="post_{{ $post->id }}" data-delete-confirm="{{ trans('post.message.delete_instance') }}"><i class="fa fa-trash"></i></a>
						</form>
					</div>
				</td>
			</tr>
			@empty
			@endforelse
		</tbody>
	</table>
</div>

{{ $posts->links() }}

@else
<p>{{ trans('post.message.no_result') }}</p>
@endif

@endsection

@section('sidebar')
	<h3>Sidebar</h3>
	<p>Bourbon Neat is used for grid system in this example.</p>
@stop

@section('javascript')
	@parent
@endsection
