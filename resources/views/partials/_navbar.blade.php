<b-navbar toggleable="md" type="light" class="navbar-bg">
	<b-navbar-brand href="{{ url('/') }}">{{ setting('app_name') }}</b-navbar-brand>
		<b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
			<b-collapse id="nav-collapse" is-nav>
			<!-- Left Side Of Navbar -->
			<b-navbar-nav>
			</b-navbar-nav>			
			
			<!-- Centered Of Navbar -->
			<b-navbar-nav class="mx-auto">
				<b-nav-item href="{{ url('/') }}">Hem</b-nav-item>
				@showmodule('enable_issues')
				<b-nav-item href="{{ url('/issues/') }}">Ärenden
					@if (expiredIssues() > 0)
						<span class="badge badge-danger" data-toggle="tooltip" title="Kunder som inte blivit kontaktade">{{ expiredIssues() }}</span>
					@endif
					@if (unansweredIssues() > 0)
						<span class="badge badge-primary" data-toggle="tooltip" title="Dina öppna ärenden">{{ unansweredIssues() }}</span>
					@endif
					@if (!setting('enable_issues'))
						<sup>beta</sup>
					@endif
				</b-nav-item>
				@endshowmodule

				@showmodule('enable_demoprodukter')
				<b-nav-item href="{{ url('/demoproducts/') }}">Demoprodukter
					@if (!setting('enable_demoprodukter'))
						<sup>beta</sup>
					@endif
				</b-nav-item>
				@endshowmodule

				@showmodule('enable_dokument')
				<b-nav-item href="{{ url('/documents/') }}">Dokument
					@if (!setting('enable_dokument'))
						<sup>beta</sup>
					@endif
				</b-nav-item>
				@endshowmodule
				
				@showmodule('enable_visitors')
				<b-nav-item href="{{ route('visitors.index') }}">Besökare
						@if (!setting('enable_visitors'))
						<sup>beta</sup>
					@endif
				</b-nav-item>
				@endshowmodule
			</b-navbar-nav>

			<!-- Right Side Of Navbar -->
			<b-navbar-nav class="ml-auto">
			<!-- Authentication Links -->
			@guest
				<b-nav-item href="{{ route('login') }}">Logga in</b-nav-item>
				@if (Route::has('register'))
					<b-nav-item href="{{ route('register') }}">Ny användare</b-nav-item>
				@endif
			@else
				<b-nav-item-dropdown text="{{ Auth::user()->name }}" right>
					@impersonate
						<b-dropdown-item href="{{ route('admin.impersonate.destroy')}}">Återgå</b-dropdown-item>
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
						<b-dropdown-item href="{{ url('/admin/settings/')}}">Inställningar</b-dropdown-item>
					@endhasrole
				</b-nav-item-dropdown>
			@endguest
			</b-navbar-nav>
			</b-collapse>
</b-navbar>
			


