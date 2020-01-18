        <nav class="navbar navbar-expand-md navbar-light shadow-sm navbar-bg">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Marknad
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="http://172.16.0.2:10099/INTRANET/SFA/">SFA</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="http://172.16.0.2:10099/INTRANET/SFA/CONTM/index">SFA Sök kund</a>
								<a class="dropdown-item" href="http://172.16.0.2:10099/INTRANET/SFA/Offers/index">SFA Sök Offert</a>
							</div>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							  Adminstration
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href=" http://172.16.0.184/qweb ">QUARTA</a>
								<a class="dropdown-item" href="http://194.243.72.228">GESTREQ</a>
								<a class="dropdown-item" href="http://172.16.0.161">Reserved Area</a>
								<a class="dropdown-item" href="http://172.16.0.183/projects/si5/wiki">Dokumentation SIGIP mm</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="./posten">Posten Adresslappar</a>
							</div>
						</li>

						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Teknisk Support
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="http://productselection.net">Product Selection</a>
								<a class="dropdown-item" href="http://gavazzi.se">Nya Gavazzi.se</a>
								<a class="dropdown-item" href="http://support-carlogavazzi.se">Gamla supportsidan</a>
							</div>
						</li>	
						@hasroles(['superadmin', 'support'])
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Ärenden
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="{{ url('/issues/') }}">Visa alla</a>
								<a class="dropdown-item" href="{{ url('/issues/create/') }}">Nytt ärende</a>
							</div>
						</li>
						@endhasrole						

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
                               </div>
                            </li>
                        @endguest
						<li class="nav-item dropdown">
							<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
								Hantera <span class="caret"></span>
							</a>

							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="{{ route('visitors.index') }}">Besökare</a>
							@hasrole('superadmin')
								<a class="dropdown-item" href="{{ url('/admin/settings/')}}">Inställningar</a>
								<a class="dropdown-item" href="{{ url('/admin/tasks/')}}">Hantera ärenden</a>
								<a class="dropdown-item" href="{{ route('admin.users.index')}}">Hantera användare</a>
								<a class="dropdown-item" href="{{ route('admin.images.create')}}">Lägg till fil till receptionsskärm</a>
							@endhasrole
                              </div>
                            </li>

                    </ul>
                </div>
            </div>
        </nav>


