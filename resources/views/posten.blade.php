@extends('layouts.app')

@section('title','Home')

@section('header','Posthantering')

@section('content')
	<div class="container">
		<p>
		<h2>Utskrift av adresslapp</h2>
		Användarnamn: 650058000365221 </br>
		Lösenord: QTS856JF</br>
		</p>
		<p>
			<a class="btn btn-secondary" target="_blank" href="https://po.unifaun.se/ext.po.se.posten " role="button">Gå till Posten</a>
		</p>
		<p>
			<div class="alert alert-info">
				<p>2019-09-02</p>
				<p>OBS! Utskrifterna funkar ej med Firefox efter Firefox uppdaterats nyligen. 
				<ul>
					<li>Använd Internet Explorer för utskrift av adresslapp.</li>
					<li>Använd 32-bitars java för Internet Explorer.</li>
				</ul>
				</p>
			</div>
		</p>
	</div>
@endsection
