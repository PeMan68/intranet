@extends('layouts.app')

@include('menues.issues')

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
			:items="{{ $products }}" 
			:fields="{{ $fields }}" >
		</issue-table>
	</div>
</div>
{{-- <div>{{$products}}</div> --}}
@endsection

