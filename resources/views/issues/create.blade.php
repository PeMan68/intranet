@extends('layouts.app')

@section('content')
<div class="container">
	<div class="card">
		<div class="card-header h3">Nytt ärende</div>

		<div class="card-body">
			<form action="/issues" method="post">
				@csrf
				<div class="row justify-content-center">
<div class="col-lg-8">
	<div class="row">
					<div class="col-md-6">
						<div class="font-weight-bold h5">Område</div>
					@foreach ($tasks as $task)
						<div class="form-check">
							<input type="radio" class="form-check-input" id="issuePrio1" name="task" value="{{ $task->id }}" {{ old('task') == $task->id ? 'checked' : '' }}/>
							<label for="issuePrio1">{{ $task->name }}</label>
						</div>
					@endforeach
					</div>
					<div class="col-md-6">
						<div class="font-weight-bold h5">Personligt eller grupp</div>
						<div class="form-check">
							<input type="radio" class="form-check-input" id="issuePrio1" name="task2" value="0" {{ old('task2') == "0" ? 'checked' : !old() ? 'checked' : '' }}>
							<label for="issuePrio1">Gruppärende</label>
						</div>
					@foreach ($users as $user)
						<div class="form-check">
							<input type="radio" class="form-check-input" id="issuePrio1" name="task2" value="{{ $user->id }}" {{ old('task2') == $user->id ? 'checked' : '' }}>
							<label for="issuePrio1">{{ $user->name }} {{ $user->surname }}</label>
						</div>
					@endforeach
					</div>
	</div>
	<div class="row">
	<div class="col-md-12">
						<hr>
	</div>
	</div>
	<div class="row">
	<div class="col-md-6">
	
						<div class="form-group">
							<label for="issueDescription" class="font-weight-bold h5">Formell beskrivning(*)</label>
							<textarea class="form-control" id="issueDescription" name="description" rows="8">{{ old('description') }}</textarea>
						</div>
	</div>
	<div class="col-md-6">
						<div class="form-group">
							<label for="issueDescriptionInternal" class="font-weight-bold h5">Intern anteckning</label>
							<textarea class="form-control" id="issueDescriptionInternal" name="descriptionInternal" rows="8">{{ old('descriptionInternal') }}</textarea>
						</div>
	</div>
	</div>
	</div>
	
					<div class="col-lg-4">
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
							<input type="text" class="form-control" id="issuePerson"  name="person" value="{{ old('person') }}">
						</div>
						<div class="form-group">
							<label for="issuePhone" class="font-weight-bold h5">Telefon(*)</label>
							<input type="text" class="form-control" id="issuePhone"  name="phone"  value="{{ old('phone') }}">
						</div>
						<div class="form-group">
							<label for="issueEmail" class="font-weight-bold h5">E-post(*)</label>
							<input type="text" class="form-control" id="issueEmail"  name="email" value="{{ old('email') }}">
						</div>
						<div class="form-check">
							<input type="checkbox" class="form-check-input" id="issueFollow" name="follow" value="1" {{ old('follow') == "1" ? 'checked' : ''}}>
							<label for="issueFollow">Jag vill följa detta ärende</label>
						</div>
						<div class="font-weight-bold h5">Påverka prioritet</div>
						<div class="form-check">
							<input type="checkbox" class="form-check-input" id="issueUrgent" name="urgent" value="1" {{ old('urgent') == "1" ? 'checked' : ''}}>
							<label for="issueUrgent" class="font-weight-bold">Brådskande</label>
						</div>
						<div class="form-check">
							<input type="checkbox" class="form-check-input" id="issueVip" name="vip" value="1" {{ old('vip') == "1" ? 'checked' : ''}}>
							<label for="issueVip" class="font-weight-bold">VIP-kund</label>
						</div>
						<div class="form-check">
							<input type="radio" class="form-check-input" id="issuePrio1" name="prio" value="1" {{ old('prio') == "1" ? 'checked' : '' }}>
							<label for="issuePrio1" class="font-weight-bold">Låg prioritet</label>
						</div>
						<div class="form-check">
							<input type="radio" class="form-check-input" id="issuePrio2" name="prio" value="2" {{ old('prio') == "2" ? 'checked' : !old() ? 'checked' : '' }}>
							<label for="issuePrio2" class="font-weight-bold">Normal prioritet</label>
						</div>
						<div class="form-check">
							<input type="radio" class="form-check-input" id="issuePrio3" name="prio" value="3"{{ old('prio') == "3" ? 'checked' : '' }}>
							<label for="issuePrio3" class="font-weight-bold">Hög prioritet</label>
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
				</div>
			</form>
	</div>
</div>

@endsection