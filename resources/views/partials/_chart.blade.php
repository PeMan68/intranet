@section('scriptsHead')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
@endsection

<div class="card">
					<div class="card-body" style="height:200px;">
						{!! $chart->container() !!}
					</div>					
			</div>
@section('scriptsBody')
{!! $chart->script() !!}
@endsection