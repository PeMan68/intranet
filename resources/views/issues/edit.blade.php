@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
			<div class="card">
				<div class="card-header h3">Uppdatera ärende #{{$issue->id}}</div>
				<div class="card-body">
					<form action="{{ url('issues', [$issue->id]) }}" method="post">
						@method('PUT')
						@csrf
						<div class="form-group">
						<label for="issueCustomer" class="font-weight-bold h5">Kund</label>
						<input type="text" value="{{ $issue->customer }}" class="form-control" id="issueCustomer"  name="customer">
						</div>
						<div class="form-group">
						<label for="description">Beskrivning</label>
						<input type="text" value="{{ $issue->description }}" class="form-control" id="issueDescription" name="description">
						</div>
						<div class="form-group row mb-0">
							<div class="col-md-8 offset-md-4">
								<button type="submit" class="btn btn-primary">
									Spara
								</button>
								<button class="btn btn-secondary" type="submit" name="reset" value="reset">
									Avbryt
								</button>                            
								<button class="btn btn-danger" type="submit" name="delete" value="delete">
									Radera
								</button>                            
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection