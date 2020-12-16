@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-6">
				<h3>Dokumenthantering</h3>
			</div>
		</div>
	</div>
	<div class="card-body">
		<document-table 
			:items="{{ $items }}" 
			:fields="{{ $fields }}"
			:link="'/documents/create'"
			>
			Ladda upp
		</document-table>
	</div>
</div>
	
@endsection
