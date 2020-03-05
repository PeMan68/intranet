@extends('layouts.app')

@include('menues.issues')

@section('scriptsBody')
<script>
$(document).ready(function($) {
    $(".table-row").click(function() {
        window.document.location = $(this).data("href");
    });
});
</script>
@endsection

@section('content')
<div class="card">
	<div class="card-header">
		<div class="row">
		<div class="col-6">
		@if (isset($filter))		
			<h3>Alla ärenden, sökning "{{ $filter }}"</h3>
		@else	
			<h3>Ärenden, sorterade efter prioritet</h3>
		@endif
		<small>Sidan uppdaterad {{ date('y-m-d H:i') }}</small>
		</div>
		<div class="col-6">	
				<form class="form-inline float-right" method="POST" action="issues">
					@method('GET')
					@csrf
					<div class="input-group">
						<div class="input-group-prepend">
						<span class="input-group-text"><i class="material-icons">search</i></span>
						</div>		
						<input type=text class="form-control" name="search" placeholder="Sök..." value="{{$filter}}">
					</div>		
				</form>
	</div>
	</div>
	</div>

	<div class="card-body">
		<table class="table table-sm table-hover">
			<thead class="thead-light">
				<tr>
					<th class="d-none d-lg-table-cell">#</th>
					@hasrole ('superadmin')
					<th class="d-none d-xl-table-cell">Level</th>
					@endhasrole
					<th class="d-none d-sm-table-cell">Skapat</th>
					<th class="d-none d-xl-table-cell">Senast</th>
					<th>Område</th>
					<th></th>
					<th>Kund</th>
					<th class="d-none d-md-table-cell">Namn</th>
					<th class="d-none d-lg-table-cell">Beskrivning</th>
				</tr>
			</thead>
			<tbody>
			@foreach($issues as $issue)
				<tr
				@if (!is_null($issue->timeClosed))
					class="table-row" 
				@elseif (!is_null($issue->userCurrent_id)) 
					class="table-row table-active" 
					data-toggle="tooltip" title="Utcheckat av {{ $issue->userCurrent->name.' '.$issue->userCurrent->surname }}" 
				@elseif ($issue->hoursToCallback() < 0)
					class="table-row table-danger"
					data-toggle="tooltip" title="Tiden för återkoppling till kund har löpt ut. Kontakta kunden snarast!" 
				@elseif ($issue->userCurrentLevel() == 3)
					class="table-row table-warning"
					data-toggle="tooltip" title="Ärendet tillhör ditt primära ansvarsområde" 
				@elseif ($issue->userCurrentLevel() == 2)
					class="table-row table-success"
					data-toggle="tooltip" title="Ärendet tillhör ditt sekundära ansvarsområde" 
				@else
					class="table-row"
				@endif
				data-placement="left"
				data-href="{{ URL::to('issues/' . $issue->id) }}">
					<td class="d-none d-lg-table-cell">{{$issue->ticketNumber}}</td>
					@hasrole('superadmin')
					<td class="d-none d-xl-table-cell">{{ (int)$issue->calculated_prio }}</td>
					@endhasrole
					<td class="d-none d-sm-table-cell" data-toggle="tooltip" title="Skapat {{ $issue->timeInit }}">{{date('y-m-d',strtotime($issue->timeInit))}}</td>
					<td class="d-none d-xl-table-cell" data-toggle="tooltip" title="Senast uppdaterad {{ $issue->updated_at }}">{{date_diff
					($issue->updated_at,
					now())->format('%Dd:%Hh')
					}}</td>
					<td>{{$issue->task->name ?? '#saknas'}}</td>
					<td class="text-right">
						@if (!is_null($issue->timeClosed))
							<i class="material-icons" data-toggle="tooltip" title="Avslutat">done_all</i>
						@else
							@if ($issue->prio == "2") 
								<i class="material-icons" data-toggle="tooltip" title="Hög prio">grade</i> 
							@endif 
							@if ($issue->vip == "1") 
								<i class="material-icons" data-toggle="tooltip" title="VIP">favorite</i> 
							@endif 
							@if ($issue->taskPersonal_id <> 0) 
								<i class="material-icons" data-toggle="tooltip" title="Personligt ärende för {{ $issue->namePersonalTask->name }} {{ $issue->namePersonalTask->surname }}">face</i> 
							@endif 
							@if ($issue->waitingForReply == "1") 
								<i class="material-icons" data-toggle="tooltip" title="Väntar på svar">snooze</i> 
							@endif 
							@if ($issue->paused == "1") 
								<i class="material-icons" data-toggle="tooltip" title="Pausat ärende">pause_circle_filled</i> 
							@endif 
							@if (!is_null($issue->timeCustomercallback)) 
								<i class="material-icons" data-toggle="tooltip" title="Kontaktad">how_to_reg</i> 
							@endif 
						@endif 
					</td>
					<td>{{$issue->customer}}</td>
					<td class="d-none d-md-table-cell">{{$issue->customerName}}</td>
					<td class="d-none d-lg-table-cell">
					<div class="d-inline-block text-truncate stretched-link" style="max-width: 300px;" data-toggle="tooltip" title="{{$issue->description }}">{{$issue->description}}
					</div>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection