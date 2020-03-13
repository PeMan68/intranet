@extends('layouts.app')

@include('menues.issues')

@section('scriptsBody')
<script type="text/javascript">
    $(document).ready(function(){      
		var i=1;  
		$('#form-table').hide();

		$('#add').click(function(){  
			i++; 
			$('#form-table').show();
			$('#form-table').append('<tr id="row'+i+'" class="dynamic-added"><td class="custom-file"><input type="file" class="custom-file-input"  id="f'+i+'" name="files[]"><label class="custom-file-label" for="f'+i+'">Välj fil</label></td><td><input type="text" class="form-control form-control-sm" id="fileDescription"  name="fileDescriptions[]" value="{{ old('fileDescription') }}"></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove btn-sm">X</button></td></tr>');  
		});  

		$(document).on('click', '.btn_remove', function(){  
			var button_id = $(this).attr("id");   
			$('#row'+button_id+'').remove();  
		});
	});
</script>
@endsection

@section('content')
<div class="card">
	<div class="card-header h3">Nytt ärende</div>

	<div class="card-body">
		<form action="/issues" method="post" enctype="multipart/form-data">
			@csrf
			<input type="hidden" name="timeInit" value="{{ $timeInit }}">
			<div class="row justify-content-center">
					<div class="col-lg-6">
						<div class="form-row">
							<div class="col-md-4">
								<div class="font-weight-bold">Område</div>
							@foreach ($tasks as $task)
								<div class="form-check">
									<input type="radio" class="form-check-input" id="task_id" name="task_id" value="{{ $task->id }}" {{ old('task_id') == $task->id ? 'checked' : '' }}/>
									<label for="task_id">{{ $task->name }}</label>
								</div>
							@endforeach
							</div>
							<div class="col-md-4">
								<div class="font-weight-bold">Personligt eller grupp</div>
								<div class="form-check">
									<input type="radio" class="form-check-input" id="taskPersonal_id" name="taskPersonal_id" value="0" {{ old('taskPersonal_id') == "0" ? 'checked' : !old() ? 'checked' : '' }}>
									<label for="taskPersonal_id">Gruppärende</label>
								</div>
								<div class="form-check">
									<input type="radio" class="form-check-input" id="taskPersonal_id" name="taskPersonal_id" value="{{ $user->id }}" {{ old('taskPersonal_id') == $user->id ? 'checked' : '' }}>
									<label for="taskPersonal_id">{{ $user->name }} {{ $user->surname }}</label>
								</div>
							</div>
							<div class="col-md-4">

								<div class="font-weight-bold">Påverka prioritet</div>
								<div class="form-check">
									<input type="radio" class="form-check-input" id="issuePrio1" name="prio" value="1" {{ old('prio') == "1" ? 'checked' : !old() ? 'checked' : '' }}>
									<label for="issuePrio1">Normal prioritet</label>
								</div>
								<div class="form-check">
									<input type="radio" class="form-check-input" id="issuePrio2" name="prio" value="2" {{ old('prio') == "2" ? 'checked' : '' }}>
									<label for="issuePrio2">Hög prioritet</label>
								</div>
								<div class="form-check pt-4">
									<input type="checkbox" class="form-check-input" id="urgent" name="urgent" value="1" {{ old('urgent') == "1" ? 'checked' : ''}}>
									<label for="urgent">Brådskande</label>
								</div>
								<div class="form-check">
									<input type="checkbox" class="form-check-input" id="vip" name="vip" value="1" {{ old('vip') == "1" ? 'checked' : ''}}>
									<label for="vip">VIP-kund</label>
								</div>


							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12">
								<hr>
								<div class="form-check">
									<input type="checkbox" class="form-check-input" id="follow" name="follow" value="1" {{ old('follow') == "1" ? 'checked' : ''}}>
									<label for="follow">Jag vill följa detta ärende</label>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-6">
						<div class="form-row">
							<div class="col-md-4 form-group">
								<label for="customerNumber" class="font-weight-bold">Kundnummer</label>
								<input type="text" class="form-control form-control-sm" id="customerNumber" name="customerNumber" value="{{ old('customerNumber') }}">
							</div>
							<div class="col-md-8 form-group">
								<label for="customer" class="font-weight-bold">Kund</label>
								<input type="text" class="form-control form-control-sm" id="customer" name="customer" value="{{ old('customer') }}">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-8 form-group">
								<label for="customerName" class="font-weight-bold">Kontaktperson(*)</label>
								<input type="text" class="form-control form-control-sm" id="customerName"  name="customerName" value="{{ old('customerName') }}">
							</div>
							<div class="col-md-4 form-group">
								<label for="customerTel" class="font-weight-bold">Telefon(*)</label>
								<input type="text" class="form-control form-control-sm" id="customerTel"  name="customerTel"  value="{{ old('customerTel') }}">
							</div>
						</div>
						<div class="form-group">
							<label for="customerMail" class="font-weight-bold">E-post(*)</label>
							<input type="text" class="form-control form-control-sm" id="customerMail"  name="customerMail" value="{{ old('customerMail') }}">
						</div>
						<div class="form-row">
							<div class="col-md-6 form-group">
								<label for="description" class="font-weight-bold">Formell beskrivning(*)</label>
								<textarea class="form-control form-control-sm" id="description" name="description" rows="8">{{ old('description') }}</textarea>
							</div>
							<div class="col-md-6 form-group">
								<label for="descriptionInternal" class="font-weight-bold">Intern anteckning</label>
								<textarea class="form-control form-control-sm" id="descriptionInternal" name="descriptionInternal" rows="8">{{ old('descriptionInternal') }}</textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group">
						<br>
						<table id="form-table" class="table">
							<tr>
							<th>Fil</th>
							<th>Beskrivning</th>
							</tr>
						</table>
						<br>
						<button type="button" name="add" id="add" class="btn btn-sm btn-success">+ Lägg till fil</button>
					</div>
				</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
							<button type="submit" class="btn btn-primary m-1" name="save">
								Spara och återgå
							</button>
							<button type="submit" class="btn btn-success m-1" name="saveOpen">
								Spara och checka ut ärende
							</button>
							<a class="btn btn-secondary m-1" href="/issues">
								Avbryt
							 </a>                          
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

@endsection