
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Kalender</div>

                <div class="card-body">
				<a href="calendar/create"><button>Lägg till</button></a>
				<button>Framåt</button>
				<button>Bakåt</button>
					<table class="table table-sm table-bordered">
						<thead>
							<tr>
								<th scope="col">
									Namn
								</th>
								@for ($date=$start; $date<=$stop; $date=strtotime('+1 day', $date))
								<th scope="col" class="text-center">
								{{ date('j/n',$date) }}
								</th>
								@endfor
							</tr>
						</thead>
						<tbody>
							@foreach($users as $user)
							<tr>
								<td class="table-dark">
									{{ $user->name }}
								</td>
								@for ($date=$start; $date<=$stop; $date=strtotime('+1 day', $date))
								<td>
									@foreach($activities as $activity)
										@if($activity->start <= date('Y-m-d',$date) And $activity->stop >= date('Y-m-d', $date) And $user->id == $activity->user_id)
											<img src="{{ $activity->calendarCategory->img_url }}" class="img-fluid" title="{{ $activity->description }}">
										@else
										
										@endif
									@endforeach
								</td>
								@endfor
							</tr>
							@endforeach
						</tbody>
					</table>
                </div>
            </div>
        </div>
    </div>
</div>

