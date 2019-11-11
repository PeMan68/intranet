@extends('layouts.app')

@section('content')
<div class="container">
	<div class="card">
		<div class="card-header h3">Nytt ärende</div>

		<div class="card-body">
			<form action="/issues" method="post">
				@csrf
				<div class="row justify-content-center">
					<div class="col-md-6">
					<hr>
					@foreach ($tasks as $task)
						<div class="h4">{{ $task->area->area }}</div>
						<div class="form-check">
							<input type="radio" class="form-check-input" id="issuePrio1" name="{{ $task->id }}" value="{{ $task->id }}">
							<label for="issuePrio1" class="font-weight-bold h5">{{ $task->name }}</label>
						</div>
					@endforeach
						<hr>
						<div class="form-group">
							<label for="issueDescription" class="font-weight-bold h5">Formell beskrivning(*)</label>
							<textarea class="form-control" id="issueDescription" name="description" rows="8"></textarea>
						</div>
						<div class="form-group">
							<label for="issueDescriptionInternal" class="font-weight-bold h5">Intern anteckning</label>
							<textarea class="form-control" id="issueDescriptionInternal" name="descriptionInternal" rows="6"></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="issueCustomerNumber" class="font-weight-bold h5">Kundnummer</label>
							<input type="text" class="form-control" id="issueCustomerNumber" name="customernumber" value="{{ old('customernumber') }}">
						</div>
						<div class="form-group">
							<label for="issueCustomer" class="font-weight-bold h5">Kund</label>
							<input type="text" class="form-control" id="issueCustomer" name="customer" value="{{ old('customer') }}">
						</div>
						<div class="form-group">
							<label for="issuePerson" class="font-weight-bold h5">Kontaktperson(*)</label>
							<input type="text" class="form-control" id="issuePerson"  name="person">
						</div>
						<div class="form-group">
							<label for="issuePhone" class="font-weight-bold h5">Telefon(*)</label>
							<input type="text" class="form-control" id="issuePhone"  name="phone">
						</div>
						<div class="form-group">
							<label for="issueEmail" class="font-weight-bold h5">E-post(*)</label>
							<input type="text" class="form-control" id="issueEmail"  name="email">
						</div>
						<div class="form-check">
							<input type="checkbox" class="form-check-input" id="issueUrgent" name="urgent" value="">
							<label for="issueUrgent" class="font-weight-bold h5">Brådskande</label>
						</div>
						<div class="form-check">
							<input type="checkbox" class="form-check-input" id="issueVip" name="vip" value="">
							<label for="issueVip" class="font-weight-bold h5">VIP</label>
						</div>
						<div class="form-check">
							<input type="radio" class="form-check-input" id="issuePrio1" name="vip" value="1">
							<label for="issuePrio1" class="font-weight-bold h5">Låg prioritet</label>
						</div>
						<div class="form-check">
							<input type="radio" class="form-check-input" id="issuePrio2" name="vip" value="2" checked>
							<label for="issuePrio2" class="font-weight-bold h5">Normal prioritet</label>
						</div>
						<div class="form-check">
							<input type="radio" class="form-check-input" id="issuePrio3" name="vip" value="3">
							<label for="issuePrio3" class="font-weight-bold h5">Hög prioritet</label>
						</div>
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
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection