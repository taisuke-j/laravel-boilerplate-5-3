@extends('layouts.admin')

@section('title', trans('category.page_title.index'))

@section('content')

<section>
	<h1>{{ trans('category.page_title.index') }}</h1>
</section>

@if(isset($categories))
<div class="table-wrapper even-horizontal-medium-table">
	<table>
		<thead>
			<tr>
				<th width="50">ID</th>
				<th>{{ trans('category.table_heading.name') }}</th>
				<th>{{ trans('category.table_heading.slug') }}</th>
				<th class="edit-field-heading"></th>
			</tr>
		</thead>
		<tbody>
			@forelse($categories as $category)
			<tr>
				<td>
					<div class="field-label hide-medium">ID</div>
					<span>{{ $category->id }}</span>
				</td>
				<td>
					<div class="field-label hide-medium">{{ trans('category.table_heading.name') }}</div>
					<span>{{ $category->name }}</span>
				</td>
				<td>
					<div class="field-label hide-medium">{{ trans('category.table_heading.slug') }}</div>
					<span>{{ $category->slug }}</span>
				</td>
				<td class="edit-field">
					<div>
						<div class="field-label hide-medium">{{ trans('category.table_heading.edit_or_delete') }}</div>
						<a href="{{ url('/admin/category/'.$category->id.'/edit') }}" title="{{ trans('category.link_title.edit') }}"><i class="fa fa-edit"></i></a>
						<form action="{{ url('/admin/category/'.$category->id) }}" id="category_{{ $category->id }}" class="inline" method="post">
							{{ csrf_field() }}
							{{ method_field('delete') }}
							<a href="#" title="{{ trans('category.link_title.delete') }}" data-delete-id="category_{{ $category->id }}" data-delete-confirm="{{ trans('category.message.delete_instance') }}"><i class="fa fa-trash"></i></a>
						</form>
					</div>
				</td>
			</tr>
			@empty
			@endforelse
		</tbody>
	</table>
</div>

{{ $categories->links() }}

@else
<p>{{ trans('category.message.no_result') }}</p>
@endif

<p class="add-button">
	<a href="{{ url('/admin/'.$model.'/category/create') }}" title="{{ trans('category.link_title.create') }}" class="button">{{ trans('category.link_title.create') }}</a>
</p>

@endsection

@section('sidebar')
	<h3>Sidebar</h3>
	<p>Bourbon Neat is used for grid system in this example.</p>
@stop

@section('javascript')
	@parent
@endsection
