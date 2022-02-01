<span class="border-top mt-1"></span>
<div class="text-light">CG webb-platser</div>
<navigation-link url="http://172.16.0.2:10099/INTRANET/SFA/"><slot>SFA</slot></navigation-link>
<navigation-link url="http://172.16.0.161"><slot>Reserved Area</slot></navigation-link>
<navigation-link url="http://productselection.net"><slot>Product Selection</slot></navigation-link>
<navigation-link url="http://gavazzi.se"><slot>Gavazzi.se</slot></navigation-link>
<span class="border-top mt-1"></span>
<div class="text-light">CG verktyg</div>
<navigation-link url="http://172.16.0.184/qweb"><slot>QUARTA</slot></navigation-link>
<navigation-link url="http://194.243.72.228"><slot>GESTREQ</slot></navigation-link>
<navigation-link url="http://172.16.0.183/projects/si5/wiki"><slot>Dokumentation SIGIP mm</slot></navigation-link>
<a href="/posten">Adressetiketter</a>
<span class="border-top mt-1"></span>
<div class="text-light">Hantera</div>
<a href="{{ route('holidays.index')}}">Hantera lediga dagar</a>
<a href="{{ route('contacts.index')}}">Hantera kontakter</a>
@showmodule('enable_demoprodukter')
<a href="{{ route('locations.index')}}">Hantera platser</a>
@endshowmodule
@hasrole('admin')
<span class="border-top mt-1"></span>
<div class="text-light">Admin Hantera</div>
<a href="{{ route('locations.create', '0') }}">Ny huvudplats</a>
@endhasrole
@hasrole('superadmin')
<span class="border-top mt-1"></span>
<div class="text-light">Superadmin Hantera</div>
<a href="{{ route('admin.tasks.index')}}">Hantera ärenden</a>
<a href="{{ route('admin.users.index')}}">Hantera användare</a>
<a href="{{ route('admin.images.create')}}">Lägg till fil till receptionsskärm</a>
<a href="{{ route('admin.productstatus.index')}}">Hantera produktstatus</a>
<a href="{{ route('admin.importproducts')}}">Uppdatera produktlista</a>
@endhasrole
