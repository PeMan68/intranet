@extends('layouts.issues')

@section('nav-left')
	<a class="nav-link" href="{{ url('/issues/create/') }}">Nytt ärende</a>
	<a class="nav-link" href="{{ url('/issues/') }}">Mina ärenden</a>
@endsection

@section('scriptsHead')
<script>
$(document).ready(function(){
	$('#buttons').hide();


	$("#issueheader").change(function(){
		$('#buttons').show();
	});
});
</script>
@endsection

@section('content')
<div class="card">
	<div class="card-header h3">Ärende {{ $issue->ticketNumber }}
	</div>

	<div class="card-body">
		<form action="{{ url('issues', [$issue->id]) }}" method="post" id="issueheader">
			@method('PUT')
			@csrf
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
							<td><input type="text" value="{{ old('customerNumber', $issue->customerNumber) }}" class="form-control" id="customerNumber" name="customerNumber"></td></tr>
						<tr><td><strong>Kund:</strong></td>
							<td><input type="text" value="{{ $issue->customer }}" class="form-control" id="customer" name="customer"></td></tr>
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
								@foreach ($users as $user)
									<option value="{{ $user->id }}" @if (!old() && $user->id == $issue->taskPersonal_id) selected @endif>{{ $user->name }} {{ $user->surname }}</option>
								@endforeach
							</select></td></tr>
					</table>
				</div>
				<div class="col-md-6">
					<table style="width: 100%;">
						<tr><td style="width: 30%;"><strong>Ärendebeskrivning:</strong></td>
							<td> <textarea class="form-control" id="description" name="description" rows="8">{{ old('description', $issue->description) }}</textarea></td></tr>
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
					<div>
						Följare:
						@foreach ($followers as $user)
							{{ $user->name }}
						@endforeach
					</div>
					<div>
						@if ($follow)
							<a href="{{ route('issues.unfollow', $issue->id) }}">Sluta följa ärende</a>
						@else
							<a href="{{ route('issues.follow', $issue->id) }}">Följ ärende</a>
						@endif
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6" id="buttons">
					<button type="submit" class="btn btn-primary mr-2" name="save">
						Spara ändringarna
					</button>
					<button type="submit" class="btn btn-secondary mr-2" name="cancel">
						Ångra ändringarna
					</button>

				</div>
			</div>
		</form>
	</div>
	<strong>Händelselogg</strong>
	<table class="table-responsive table-sm table-bordered">
	@if($comments->count())
		<thead>
			<th width="20%">Tidpunkt</th>
			<th width="40%">Anteckning</th>
			<th width="40%">Meddelanden till kund</th>
		</thead>
	@foreach($comments as $comment)
		<tr>
			<form action="{{ route('issuecomments.update', $comment->id) }}" method="post">
			@method('PUT')
			@csrf
			<td> {{ date('Y-m-d H:i', strtotime($comment->checkin)) }}
			<br>
			{{ $comment->user->name . ' ' . $comment->user->surname }} </td>
			<td> {!! nl2br(e($comment->comment_internal)) !!} </td>
			<td> {!! nl2br(e($comment->comment_external)) !!} </td>
			</form>
		</tr>
	@endforeach
	@endif
		<form action="{{ route('issuecomments.update', $new_comment->id) }}" method="post">
			@method('PUT')
			@csrf
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
				<button type="submit" class="btn btn-success mr-2" name="saveAndClose">
					Spara  och avsluta ärende
				</button>
			</td>
		</tr>
		</form>
	</table>
		
				
</div>
@endsection