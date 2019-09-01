
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
								@foreach($dates as $date)
								<th scope="col" class="text-center">
								{{ date('j/n',$date) }}
								</th>
								@endforeach
							</tr>
						</thead>
						<tbody>
							@foreach($users as $user)
							<tr>
								<td class="table-dark">
									{{ $user->name }}
								</td>
								@for ($a=0; $a<=$period; $a++)
								<td>
								{{ $a. ':' . $loop->index }}
									<img src="{{ $activities[$a][$loop->index][0][2] }}" class="img-fluid @if ($activities[$a][$loop->index][0][0]===0) invisible @endif" title="{{ $activities[$a][$loop->index][0][0] }}">
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

