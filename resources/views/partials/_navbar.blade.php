<nav class="navbar navbar-expand-md navbar-light shadow-sm navbar-bg">
	<div class="container-fluid">
		<a class="navbar-brand" href="{{ url('/') }}">{{ setting('app_name') }}</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<!-- Left Side Of Navbar -->
			<ul class="navbar-nav">
			</ul>
			
			<!-- Centered Of Navbar -->
			<ul class="navbar-nav mx-auto">
				<li class="nav-item">
					<a class="nav-link" href="{{ url('/') }}">Hem</a>
				</li>
				@showmodule('enable_issues')
				<li class="nav-item">
					<a class="nav-link" href="{{ url('/issues/') }}">Ärenden
					@if (expiredIssues() > 0)
						<span class="badge badge-danger" data-toggle="tooltip" title="Kunder som inte blivit kontaktade">{{ expiredIssues() }}</span>
					@endif
					@if (unansweredIssues() > 0)
						<span class="badge badge-warning" data-toggle="tooltip" title="Dina öppna ärenden">{{ unansweredIssues() }}</span>
					@endif
					@if (!setting('enable_issues'))
						<sup>beta</sup>
					@endif
					</a>
				</li>
				@endshowmodule

				@showmodule('enable_demoprodukter')
				<li class="nav-item">
					<a class="nav-link" href="{{ url('/demoproducts/') }}">Demoprodukter
					@if (!setting('enable_demoprodukter'))
						<sup>beta</sup>
					@endif
					</a>
				</li>
				@endshowmodule

				@showmodule('enable_dokument')
				<li class="nav-item">
					<a class="nav-link" href="{{ url('/documents/') }}">Dokument
					@if (!setting('enable_dokument'))
						<sup>beta</sup>
					@endif
					</a>
				</li>
				@endshowmodule
				
				@showmodule('enable_visitors')
				<li class="nav-item">
					<a class="nav-link" href="{{ route('visitors.index') }}">Besökare
						@if (!setting('enable_visitors'))
						<sup>beta</sup>
					@endif
					</a>
				</li>
				@endshowmodule
			</ul>


			<!-- Right Side Of Navbar -->
			<ul class="navbar-nav ml-auto">
				<!-- Authentication Links -->
				@guest
					<li class="nav-item">
						<a class="nav-link" href="{{ route('login') }}">Logga in</a>
					</li>
					@if (Route::has('register'))
						<li class="nav-item">
							<a class="nav-link" href="{{ route('register') }}">Ny användare</a>
						</li>
					@endif
				@else
					<li class="nav-item dropdown">
						<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
							{{ Auth::user()->name }} <span class="caret"></span>
						</a>

						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
							@impersonate
								<a class="dropdown-item" href="{{ route('admin.impersonate.destroy')}}">Återgå</a>
							@else
							<a class="dropdown-item" href="{{ route('logout') }}"
							   onclick="event.preventDefault();
											 document.getElementById('logout-form').submit();">
								Logga ut
							</a>

							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								@csrf
							</form>
							@endimpersonate
							@hasrole('superadmin')
								<a class="dropdown-item" href="{{ url('/admin/settings/')}}">Inställningar</a>
							@endhasrole
					   </div>
					</li>
				@endguest
			</ul>
		</div>
	</div>
</nav>

