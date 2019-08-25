
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Kalender</div>

                <div class="card-body">
				<button>Lägg till</button>
				<button>Framåt</button>
				<button>Bakåt</button>
					<table class="table table-sm table-bordered">
						<thead>
							<tr>
								<th scope="col">
									Namn
								</th>
								@for ($i = 1; $i < 21; $i++)
								<th scope="col" class="text-center">
								{{ $i }}/1
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
								@for ($i = 1; $i < 21; $i++)
								<td>
									<img src="images/green.png" class="img-fluid invisible" alt="semester" title="beskrivning">
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

