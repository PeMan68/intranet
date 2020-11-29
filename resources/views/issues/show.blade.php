@extends('layouts.app')

@include('menues.issues')

@section('scriptsBody')
<script>
$(document).ready(function(){
	$('#buttons').hide();


	$("#issueheader").change(function(){
		$('#buttons').show();
	});
});
</script>
@endsection

@section('scriptsBody')
<script type="text/javascript">
    $(document).ready(function(){      
		var i=1;  
		$('#form-table').hide();

		$('#add').click(function(){  
			i++; 
			$('#form-table').show();
			$('#form-table').append('<tr id="row'+i+'" class="dynamic-added"><td><input type="file" class="form-control-file" name="files[]"></td><td><input type="text" class="form-control form-control-sm" id="fileDescription"  name="fileDescriptions[]" value="{{ old('fileDescription') }}"></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove btn-sm">X</button></td></tr>');  
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
	<div class="card-header h3">
		Ärende {{ $issue->ticketNumber }} utcheckat av 
		{{ $issue->userCurrent->name }} 
		{{ $issue->userCurrent->surname }}
		@if ($auth_user->id == $issue->userCurrent_id)
			<a class="btn btn-primary btn-sm m-2" href="{{ route('issues.index') }}" role="button">
			Checka tillbaks ärende
			<i class="material-icons white md-18 ml-1" data-toggle="tooltip" 
			title="Checka tillbaks ärendet när du är klar så det inte är blockerat för andra användare" 
			style="vertical-align: middle;">help</i>
			</a>
		@endif
	</div>
	<div class="card-body">
		@if ($auth_user->id <> $issue->userCurrent_id)
		<div class="alert alert-info">
			Ärendet är för närvarande utcheckat av
			{{ $issue->userCurrent->name }}
			{{ $issue->userCurrent->surname }}.
			Du kan läsa men inte ändra några uppgifter förrän ärendet är ledigt.
			Det går att lägga till kommentarer.
		</div>
		@endif
		@if (!is_null($issue->timeClosed))
		<div class="alert alert-danger">
			Ärendet är avslutat.
			<a class="btn btn-danger btn-sm m-2" href="{{ route('issues.reopen', $issue->id) }}" role="button">Öppna ärende igen</a>
		</div>
		
		@endif
		<form action="{{ url('issues', [$issue->id]) }}" method="post" id="issueheader">
			@method('PUT')
			@csrf
			@if ($auth_user->id <> $issue->userCurrent_id or !is_null($issue->timeClosed)) 
				<fieldset disabled>
			@endif

			<div class="row">
				<div class="col-md-6">
					<table style="width: 100%;">
						<tr><td style="width: 30%;"><strong>Ärende skapat:</strong></td>
						<td> 
						{{ date('Y-m-d H:i', strtotime($issue->created_at)) }}
						av
						{{ $issue->userCreate->name}}
						{{ $issue->userCreate->surname}}
						</td></tr>
						<tr><td><strong>Kundnr:</strong></td>
							<td>
								<input type="text" value="{{ old('customerNumber', $issue->customerNumber) }}" 
								class="form-control" id="customerNumber" name="customerNumber">
							</td>
						</tr>
						<tr><td><strong>Kund:</strong></td>
							<td><input type="text" value="{{ $issue->customer }}" class="form-control" id="customer" name="customer" ></td></tr>
						<tr><td><strong>Kontakt:</strong></td>
							<td><input type="text" value="{{ $issue->customerName }}" class="form-control" id="customerName" name="customerName"></td></tr>
						<tr><td><strong>Telefon:</strong></td>
							<td> <input type="text" value="{{ $issue->customerTel }}" class="form-control" id="customerTel" name="customerTel"></td></tr>
						<tr><td><strong>E-mail:</strong></td>
							<td><input type="text" value="{{ $issue->customerMail }}" class="form-control" id="customerMail" name="customerMail"></td></tr>
						<tr><td><strong>Område:</strong></td>
							<td><select class="form-control" id="task_id" name="task_id">
									<option value="-">---</option>
								
								@foreach ($tasks as $task)
									<option value="{{ $task->id }}" @if ($task->id == $issue->task_id) selected @endif>{{ $task->name }}</option>
								@endforeach
							</select></td></tr>
						<tr><td><strong>Personligt eller grupp:</strong></td>
							<td><select class="form-control" id="taskPersonal_id" name="taskPersonal_id">
								<option value="0" {{ old('taskPersonal_id') == '0' ? 'selected' : ''}} >Gruppärende</option>
									<option value="{{ $auth_user->id }}" @if (!old() && $auth_user->id == $issue->taskPersonal_id) selected @endif>{{ $auth_user->name }} {{ $auth_user->surname }}</option>
							</select></td></tr>
					</table>
				</div>
				<div class="col-md-6">
					<table style="width: 100%;">
						<tr><td><strong>Rubrik:</strong></td>
							<td><input type="text" value="{{ old('header', $issue->header) }}" class="form-control" id="header" name="header" ></td></tr>
						<tr><td style="width: 30%;"><strong>Ärendebeskrivning:</strong></td>
							<td> <textarea class="form-control" id="description" name="description" rows="7">{{ old('description', $issue->description) }}</textarea></td></tr>
						<tr><td><strong>Intern kommentar:</strong></td>
							<td> <textarea class="form-control" id="descriptionInternal" name="descriptionInternal" rows="5">{{ old('descriptionInternal', $issue->descriptionInternal) }}</textarea></td></tr>
					</table>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-check form-check-inline">
						<input type="checkbox" class="form-check-input" id="vip" name="vip" value="1" {{ $issue->vip == "1" ? 'checked' : ''}}>
						<label for="vip" class="font-weight-bold m-0">VIP-kund</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" class="form-check-input" id="prio1" name="prio" value="1" {{ $issue->prio == "1" ? 'checked' : ''}}>
						<label for="prio1" class="font-weight-bold m-0">Prioritet Normal</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" class="form-check-input" id="prio2" name="prio" value="2" {{ $issue->prio == "2" ? 'checked' : ''}}>
						<label for="prio2" class="font-weight-bold m-0">Prioritet Hög</label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
				</div>
			</div>
					<div class="form-row">
						<div class="form-group">
							<br>
							<label for="file" class="font-weight-bold">Bilagor:</label>
							<table class="table table-sm table-borderless">
							@foreach ($files as $file)
								<tr>
								<td><a href="{{ '/storage/'.$file->url }}">{{ $file->filename }}</a></td>
								<td>{{ $file->description }}</td>
								</tr>
							@endforeach
							</table>
						</div>
					</div>
				<div class="form-row">
					<div class="form-group">
						<br>
						<table id="form-table" class="table">
							<tr>
							<th width="30%">Fil</th>
							<th width="70%">Beskrivning</th>
							</tr>
						</table>
						<br>
						<b-form-file
							name="files"
							multiple
							v-model="file1"
							:state="Boolean(file1)"
							placeholder="Choose a file or drop it here..."
							drop-placeholder="Drop file here..."
							></b-form-file>
					</div>
				</div>
			<div class="row">
				<div class="col-md-6" id="buttons">
					<button type="submit" class="btn btn-primary m-2" name="save">
						Spara ändringarna
					</button>
					<button type="submit" class="btn btn-secondary m-2" name="cancel">
						Ångra ändringarna
					</button>

				</div>
			</div>
			</fieldset>
				<hr>
			@if (is_null($issue->timeClosed))
			<div class="row">
				<div class="col-md-6">
					<div class="alert alert-info">
						@foreach ($followers as $user)
							<span class="badge badge-pill circle badge-dark font-weight-light" data-toggle="tooltip" title="{{ $user->name.' '.$user->surname }}">{{ $user->initials() }}</span>
						@endforeach
						@if ($follow)
							<a class="btn btn-primary btn-sm m-2" href="{{ route('issues.unfollow', $issue->id) }}" role="button">Sluta följa ärende</a>
						@else
							<a class="btn btn-primary btn-sm m-2" href="{{ route('issues.follow', $issue->id) }}">
								Följ ärende<i class="material-icons white md-18 ml-1" data-toggle="tooltip" title="Följ ärendet för att få mail när det händer något" style="vertical-align: middle;">help</i>
							</a>
						@endif
					</div>
				</div>
				<div class="col-md-6">
					@if (is_null($issue->timeCustomercallback))
					<div class="alert alert-primary">
						<a class="btn btn-sm btn-primary m-1" href="{{ route('issues.contacted', $issue->id) }}">
							Klicka här när kunden är kontaktad
							<i class="material-icons white md-18 ml-1" data-toggle="tooltip" title="Klicka här för att bekräfta att kund har fått en första återkoppling" style="vertical-align: middle;">help</i>
						</a>
					</div>
					@else
					<div class="alert alert-success">
						<i class="material-icons align-middle" data-toggle="tooltip" title="Kund kontaktad">how_to_reg</i> 
						Kund kontaktad: {{ date('Y-m-d H:i', strtotime($issue->timeCustomercallback)) }}
						<a class="btn btn-sm btn-secondary m-1" href="{{ route('issues.uncontacted', $issue->id) }}">
							Ångra kund kontaktad
							<i class="material-icons white md-18 m-1" data-toggle="tooltip" title="Klicka här för ta bort bekräftelsen" style="vertical-align: middle;">help</i>
						</a>
					</div>
					@endif
				</div>
			</div>
			@endif
		</form>
	</div>
	<strong>Händelselogg</strong>
	<form action="{{ route('issuecomments.update', $new_comment->id) }}" method="post">
		<table class="table-responsive table-sm table-bordered">
		@if($comments->count())
			<thead>
				<th width="20%">Tidpunkt</th>
				<th width="40%">Interna anteckningar</th>
				<th width="40%">Kommunikation med kund</th>
			</thead>
		@foreach($comments as $comment)
			<tr>
				<td> {{ date('Y-m-d H:i', strtotime($comment->checkin)) }}
				<br>
				{{ $comment->user->name . ' ' . $comment->user->surname }} </td>
				<td> {!! nl2br(e($comment->comment_internal)) !!} </td>
				<td> {!! nl2br(e($comment->comment_external)) !!} </td>
			</tr>
		@endforeach
		@endif
			@if (is_null($issue->timeClosed))
				@method('PUT')
				@csrf
				<input type="hidden" name="follow" value="{{$follow}}">
			<tr>
				<td>
				</td>
				<td>
					<textarea class="form-control" id="comment_internal" name="comment_internal" rows="3">{{ old('comment_internal') }}</textarea>
					<small class="text-muted">Intern anteckning</small>
				</td>	
				<td>
					<textarea class="form-control" id="comment_external" name="comment_external" rows="3">{{ old('comment_external') }}</textarea>
					<small class="text-muted">(Detta fält kommer skickas till kunds e-postadress i kommande version)</small>
				</td>	
			</tr>
			<tr>
				<td>
				</td>
				<td>
					<button type="submit" class="btn btn-primary mr-2" name="save">
						Spara  kommentar
					</button>
					@if ($auth_user->id == $issue->userCurrent_id)
					<button type="submit" class="btn btn-success mr-2" name="saveAndClose">
						Spara och avsluta ärende
					</button>
					@endif
				</td>
			</tr>
			@endif
		</table>
	</form>
		
				
</div>
@endsection