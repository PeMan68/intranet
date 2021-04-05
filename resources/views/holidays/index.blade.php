@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-6">
				<h3>Lediga dagar</h3>
			</div>
		</div>
	</div>
	<div class="card-body">
		<holidays-table 
			:items="{{ $holidays }}" 
			:link="'/holidays/create'"
			:fields="{{ $fields }}"
			>
			Lägg till datum
		</holidays-table>
	</div>
</div>
	
@endsection
