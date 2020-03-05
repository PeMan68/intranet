<div class="card">
	<div class="card-header">
		<div class="btn-group" role="group">
		<a href="{{ route('home', ['datePage' => strtotime('-28 days', $start)]) }}" class="btn btn-sm btn-outline-secondary"><i class="material-icons">first_page</i></a>
		<a href="{{ route('home', ['datePage' => strtotime('-7 days', $start)]) }}" class="btn btn-sm btn-outline-secondary"><i class="material-icons">chevron_left</i></a>
		<a href="{{ route('home', ['dateOffset' => 'today']) }}" class="btn btn-sm btn-outline-secondary"><i class="material-icons">calendar_today</i></a>
		<a href="{{ route('home', ['datePage' => strtotime('+7 days', $start)]) }}" class="btn btn-sm btn-outline-secondary"><i class="material-icons">chevron_right</i></a>
		<a href="{{ route('home', ['datePage' => strtotime('+28 days', $start)]) }}" class="btn btn-sm btn-outline-secondary"><i class="material-icons">last_page</i></a>
		</div>
		<a href="calendar/create" class="btn btn-outline-secondary">Lägg till</a>
	</div>
	<div class="card-body">
		<div class="calendar">
		@for ($date=$start; $date<=$stop; $date=strtotime('+1 day', $date))
				@if ($date<>$start)
					@if (date('Ymd')==date('Ymd',$date))
						<div class="calendar-header-today"> 
					@elseif (date('w', $date)==0 or date('w', $date)==6)
						<div class="calendar-header-weekend"> 
					@else
						<div class="calendar-header"> 	
					@endif
					{{ date('j/n',$date) }}
				@else
					<div class="calendar-header"> 
				<div>&nbsp;</div>
				@endif
			</div>
		@endfor
		@foreach ($users as $user)
			@for ($date=$start; $date<=$stop; $date=strtotime('+1 day', $date))
					@if ($date==$start)
						<div class="calendar-item"> 
						<div class="names">{{ $user->name }} {{ $user->surname[0] }}</div>
					@else
						@if (date('Ymd')==date('Ymd',$date))
							<div class="calendar-item-today"> 
						@elseif (date('w', $date)==0 or date('w', $date)==6)
							<div class="calendar-item-weekend"> 
						@else
							<div class="calendar-item"> 
						@endif
						@foreach ($activities as $activity)
							@if ($activity->start <= date('Y-m-d',$date) And $activity->stop >= date('Y-m-d', $date) And $user->id == $activity->user_id)
								@switch ($activity->calendarcategory_id)
									@case(1)
										<a href="{{ route('calendar.edit',$activity->id) }}" data-toggle="tooltip" title="{{$activity->description }}">
											<div class="activity text-truncate bg-activity-info">{{ $activity->description }}</div>
										</a>
										@break
									@case(2)
										<a href="{{ route('calendar.edit',$activity->id) }}" data-toggle="tooltip" title="{{$activity->description }}">
											<div class="activity text-truncate bg-activity-ledig">{{ $activity->description }}</div>
										</a>
										@break
									@case(3)
										<a href="{{ route('calendar.edit',$activity->id) }}" data-toggle="tooltip" title="{{$activity->description }}">
											<div class="activity text-truncate  bg-activity-prel">{{ $activity->description }}</div>
										</a>
										@break
									@case(4)
										<a href="{{ route('calendar.edit',$activity->id) }}" data-toggle="tooltip" title="{{$activity->description }}">
											<div class="activity text-truncate bg-activity-resa">{{ $activity->description }}</div>
										</a>
										@break
									@case(5)
										<a href="{{ route('calendar.edit',$activity->id) }}" data-toggle="tooltip" title="{{$activity->description }}">
											<div class="activity text-truncate bg-activity-sjuk">{{ $activity->description }}</div>
										</a>
										@break
								@endswitch
							@else
							@endif
						@endforeach
					@endif
				</div>
			@endfor
		@endforeach
		</div>
	</div>
</div>

