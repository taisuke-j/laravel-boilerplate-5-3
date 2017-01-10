@extends('layouts.admin')

@section('title', trans('asset.page_title.index'))

@section('content')

<section>
	<h1>{{ trans('asset.page_title.index') }}</h1>
</section>

@if(isset($assets))
<div class="table-wrapper even-horizontal-medium-table">
	<table>
		<thead>
			<tr>
				<th width="50">ID</th>
				<th>{{ trans('asset.table_heading.type') }}</th>
				<th>{{ trans('asset.table_heading.path') }}</th>
				<th class="edit-field-heading"></th>
			</tr>
		</thead>
		<tbody>
			@forelse($assets as $asset)
			<tr>
				<td>
					<div class="field-label hide-medium">ID</div>
					<span>{{ $asset->id }}</span>
				</td>
				<td>
					<div class="field-label hide-medium">{{ trans('asset.table_heading.type') }}</div>
					<span>{{ $asset->type }}</span>
				</td>
				<td>
					<div class="field-label hide-medium">{{ trans('asset.table_heading.path') }}</div>
					<span>{{ $asset->path }}</span>
				</td>
				<td class="edit-field">
					<div>
						<div class="field-label hide-medium">{{ trans('asset.table_heading.edit_or_delete') }}</div>
						<form action="{{ action('AssetController@destroy', $asset->id) }}" id="asset_{{ $asset->id }}" class="inline" method="post">
							{{ csrf_field() }}
							{{ method_field('delete') }}
							<a href="#" title="{{ trans('asset.link_title.delete') }}" data-delete-id="asset_{{ $asset->id }}" data-delete-confirm="{{ trans('asset.message.delete_instance') }}"><i class="fa fa-trash"></i></a>
						</form>
					</div>
				</td>
			</tr>
			@empty
			@endforelse
		</tbody>
	</table>
</div>

{{ $assets->links() }}

@else
<p>{{ trans('asset.message.no_result') }}</p>
@endif

@endsection

@section('sidebar')
	<h3>Sidebar</h3>
	<p>Bourbon Neat is used for grid system in this example.</p>
@stop

@section('javascript')
	@parent
@endsection
