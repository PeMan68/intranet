<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
					<div class="card-body">
						{!! $chart->container() !!}
					</div>					
				</div>
			</div>
		</div>
	</div>
</div>
{!! $chart->script() !!}
