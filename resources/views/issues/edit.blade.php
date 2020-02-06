@extends('layouts.app')

@section('content')
<div class="container">
	<div class="card">
		<div class="card-header h3">Utcheckat ärende #{{$issue->id}}</div>
		<div class="card-body">
			<form action="{{ url('issues', [$issue->id]) }}" method="post">
				@method('PUT')
				@csrf
				<div class="row">
					<div class="col-md-6">
                        <div class="form-group row">
                            
							<label for="task_id" class="col-md-4 col-form-label text-md-right">Område</label>
                            <div class="col-md-6">
								<select class="form-control" id="task_id" name="task_id">
									@foreach ($tasks as $task)
										<option value="{{ $task->id }}" @if ($task->id == $issue->task_id) selected @endif>{{ $task->name }}</option>
									@endforeach
								</select>
                            </div>
							
                        </div>
                        <div class="form-group row">
                            
							<label for="taskPersonal_id" class="col-md-4 col-form-label text-md-right">Personligt eller grupp</label>
                            <div class="col-md-6">
								<select class="form-control" id="taskPersonal_id" name="taskPersonal_id">
									<option value="0">Gruppärende</option>
									@foreach ($users as $user)
										<option value="{{ $user->id }}" @if ($user->id == $issue->taskPersonal_id) selected @endif>{{ $user->name }} {{ $user->surname }}</option>
									@endforeach
								</select>
                            </div>
							
                        </div>


						<div class="form-group">
							<label for="customer" class="font-weight-bold h5">Kund</label>
							<input type="text" value="{{ $issue->customer }}" class="form-control" id="customer"  name="customer">
						</div>

						<div class="form-group">
							<label for="description" class="font-weight-bold h5">Formell beskrivning(*)</label>
							<textarea class="form-control" id="description" name="description" rows="8">{{ old('description', $issue->description) }}</textarea>
						</div>

						<div class="form-group">
							<label for="descriptionInternal" class="font-weight-bold">Intern anteckning</label>
							<textarea class="form-control" id="descriptionInternal" name="descriptionInternal" rows="8">{{ $issue->descriptionInternal }}</textarea>
						</div>

						<div class="form-group">
							<label for="customerNumber" class="font-weight-bold">Kundnummer</label>
							<input type="text" value="{{ old('customerNumber', $issue->customerNumber) }}" class="form-control" id="customerNumber" name="customerNumber">
						</div>

						<div class="form-group">
							<label for="customerName" class="font-weight-bold">Kontaktperson(*)</label>
							<input type="text" value="{{ $issue->customerName }}" class="form-control" id="customerName" name="customerName">
						</div>

						<div class="form-group">
							<label for="customerMail" class="font-weight-bold">E-post(*)</label>
							<input type="text" value="{{ $issue->customerMail }}" class="form-control" id="customerMail" name="customerMail">
						</div>

						<div class="form-group">
							<label for="customerTel" class="font-weight-bold">Telefon(*)</label>
							<input type="text" value="{{ $issue->customerTel }}" class="form-control" id="customerTel" name="customerTel">
						</div>

						<div class="form-check">
							<input type="checkbox" class="form-check-input" id="follow" name="follow" value="1" {{ $issue->follow == "1" ? 'checked' : ''}}>
							<label for="follow" class="font-weight-bold">Jag vill följa detta ärende</label>
						</div>

						<div class="form-check">
							<input type="checkbox" class="form-check-input" id="vip" name="vip" value="1" {{ $issue->vip == "1" ? 'checked' : ''}}>
							<label for="vip" class="font-weight-bold">VIP-kund</label>
						</div>

						<div class="form-group row mb-0">
							<div class="col-md-8 offset-md-4">
								<button type="submit" class="btn btn-primary mr-2" name="save">
									Spara
								</button>
								<a class="btn btn-secondary mr-2" href="/issues">
									Avbryt
								</a>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection