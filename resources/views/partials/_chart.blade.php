<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
					<div class="card-body" style="height:200px;">
						{!! $chart->container() !!}
					</div>					
			</div>
		</div>
	</div>
</div>
{!! $chart->script() !!}
