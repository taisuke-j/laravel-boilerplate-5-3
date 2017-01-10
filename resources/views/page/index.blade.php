@extends('layouts.admin')

@section('title', trans('page.page_title.index'))

@section('content')

<section>
	<h1>{{ trans('page.page_title.index') }}</h1>
</section>

@if(isset($pages))
<div class="table-wrapper even-horizontal-medium-table">
	<table>
		<thead>
			<tr>
				<th width="50">ID</th>
				<th>{{ trans('page.table_heading.title') }}</th>
				<th>{{ trans('page.table_heading.slug') }}</th>
				<th>{{ trans('page.table_heading.category') }}</th>
				<th>{{ trans('page.table_heading.status') }}</th>
				<th class="edit-field-heading"></th>
			</tr>
		</thead>
		<tbody>
			@forelse($pages as $page)
			<tr>
				<td>
					<div class="field-label hide-medium">ID</div>
					<span>{{ $page->id }}</span>
				</td>
				<td>
					<div class="field-label hide-medium">{{ trans('page.table_heading.title') }}</div>
					<a href="{{ url('/page/'.$page->slug) }}" title="{{ trans('page.link_title.show') }}">{{ $page->title }}</a>
				</td>
				<td>
					<div class="field-label hide-medium">{{ trans('page.table_heading.slug') }}</div>
					<span>{{ $page->slug }}</span>
				</td>
				<td>
					<div class="field-label hide-medium">{{ trans('page.table_heading.category') }}</div>
					@if (count($page->categories()->get()))
						<span>{{ $page->categories()->first()->name }}</span>
					@else
						<span>{{ trans('page.placeholder.not_set') }}</span>
					@endif
				</td>
				<td class="@if ($page->status === 'public') success-field @endif">
					<div class="field-label hide-medium">{{ trans('page.table_heading.status') }}</div>
					<span>{{ trans('page.status.'.$page->status) }}</span>
				</td>
				<td class="edit-field">
					<div>
						<div class="field-label hide-medium">{{ trans('page.table_heading.edit_or_delete') }}</div>
						<a href="{{ action('PageController@edit', $page->slug) }}"  title="{{ trans('page.link_title.edit') }}"><i class="fa fa-edit"></i></a>
						<form action="{{ action('PageController@destroy', $page->slug) }}" id="page_{{ $page->id }}" class="inline" method="post">
							{{ csrf_field() }}
							{{ method_field('delete') }}
							<a href="#" title="{{ trans('page.link_title.delete') }}" data-delete-id="page_{{ $page->id }}" data-delete-confirm="{{ trans('page.message.delete_instance') }}"><i class="fa fa-trash"></i></a>
						</form>
					</div>
				</td>
			</tr>
			@empty
			@endforelse
		</tbody>
	</table>
</div>

{{ $pages->links() }}

@else
<p>{{ trans('page.message.no_result') }}</p>
@endif

@endsection

@section('sidebar')
	<h3>Sidebar</h3>
	<p>Bourbon Neat is used for grid system in this example.</p>
@stop

@section('javascript')
	@parent
@endsection
