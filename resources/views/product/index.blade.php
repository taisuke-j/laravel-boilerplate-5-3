@extends('layouts.admin')

@section('title', trans('product.page_title.index'))

@section('content')

<section>
	<h1>{{ trans('product.page_title.index') }}</h1>
</section>

@if(isset($products))
<div class="table-wrapper even-horizontal-medium-table">
	<table>
		<thead>
			<tr>
				<th width="50">ID</th>
				<th>{{ trans('product.table_heading.name') }}</th>
				<th>{{ trans('product.table_heading.category') }}</th>
				<th>{{ trans('product.table_heading.status') }}</th>
				<th>{{ trans('product.table_heading.stock') }}</th>
				<th class="edit-field-heading"></th>
			</tr>
		</thead>
		<tbody>
			@forelse($products as $product)
			<tr>
				<td>
					<div class="field-label hide-medium">ID</div>
					<span>{{ $product->id }}</span>
				</td>
				<td>
					<div class="field-label hide-medium">{{ trans('product.table_heading.name') }}</div>
					<a href="{{ action('ProductController@show', $product->id) }}" title="{{ trans('product.link_title.show') }}">{{ $product->name }}</a>
				</td>
				<td>
					<div class="field-label hide-medium">{{ trans('product.table_heading.category') }}</div>
					@if (count($product->categories()->get()))
						<span>{{ $product->categories()->first()->name }}</span>
					@else
						<span>{{ trans('product.placeholder.not_set') }}</span>
					@endif
				</td>
				<td class="@if ($product->status === 'in_stock') success-field @else error-field @endif">
					<div class="field-label hide-medium">{{ trans('product.table_heading.status') }}</div>
					<span>{{ trans('product.status.'.$product->status) }}</span>
				</td>
				<td>
					<div class="field-label hide-medium">{{ trans('product.table_heading.stock') }}</div>
					<span>{{ number_format($product->stock) }}</span>
				</td>
				<td class="edit-field">
					<div>
						<div class="field-label hide-medium">{{ trans('product.table_heading.edit_or_delete') }}</div>
						<a href="{{ action('ProductController@edit', $product->id) }}"  title="{{ trans('product.link_title.edit') }}"><i class="fa fa-edit"></i></a>
						<form action="{{ action('ProductController@destroy', $product->id) }}" id="product_{{ $product->id }}" class="inline" method="post">
							{{ csrf_field() }}
							{{ method_field('delete') }}
							<a href="#" title="{{ trans('product.link_title.delete') }}" data-delete-id="product_{{ $product->id }}" data-delete-confirm="{{ trans('product.message.delete_instance') }}"><i class="fa fa-trash"></i></a>
						</form>
					</div>
				</td>
			</tr>
			@empty
			@endforelse
		</tbody>
	</table>
</div>

{{ $products->links() }}

@else
<p>{{ trans('product.message.no_result') }}</p>
@endif

@endsection

@section('sidebar')
	<h3>Sidebar</h3>
	<p>Bourbon Neat is used for grid system in this example.</p>
@stop

@section('javascript')
	@parent
@endsection
