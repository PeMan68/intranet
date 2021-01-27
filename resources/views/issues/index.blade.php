@extends('layouts.app')

@section('content')

<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-6">
                <h3>Ärenden</h3>
                <small>Sidan uppdaterad {{ date('y-m-d H:i') }}</small>
			</div>
		</div>
	</div>

	<div class="card-body">
		<issue-table 
			:items-all = "{{ $itemsAll }}" 
			:items30 = "{{ $items30 }}" 
			:fields = "{{ $fields }}"
			>
		</issue-table>
	</div>
</div>
@endsection

