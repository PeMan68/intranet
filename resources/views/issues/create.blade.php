@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h3">Lägg till ärende</div>

                <div class="card-body">
				<form action="/issues" method="post">
					@csrf
					<div class="form-group">
						<label for="customer">Kund</label>
						<input type="text" class="form-control" id="issueCustomer"  name="customer">
					</div>
					<div class="form-group">
						<label for="description">Beskrivning</label>
						<input type="text" class="form-control" id="issueDescription" name="description">
					</div>
					@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
					@endif
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Spara
                                </button>
								<button class="btn btn-secondary" type="submit" name="reset" value="reset">
									Avbryt
								</button>                            
                            </div>
                        </div>
				</form>
@endsection