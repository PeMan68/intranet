@extends('layouts.app')

@section('content')

<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-6">
				<h3>Produkter</h3>
			</div>
			<div class="col-6">

				<span class="text-right">
					@include('partials._productsform')
				</span>
			</div>
			</div>
		</div>
	</div>
	<div class="card-body">
        <h4>Sök produkter</h4>
        <p>Du kan söka produkt på följande information:
            <ul>
                <li>Del av produktnamn</li>
                <li>Del av benämning</li>
                <li>E-nummer. E-numret ska vara komplett, inga mellanrum och inget "E" först.</li>
            </ul>
        @hasroles(['admin'])
        <p> Om du har rättighet, så kan du uppdatera produktinformationen genom att ladda upp en excelfil med information.
            Om du ser denna text, så har du rättighet att göra det.
        </p>
        @endhasroles
	</div>
</div>

@endsection