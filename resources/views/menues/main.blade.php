<span class="border-top mt-1"></span>
<div class="text-light">CG webb-platser</div>
<a href="http://172.16.0.2:10099/INTRANET/SFA/">SFA</a>
<a href="http://172.16.0.161">Reserved Area</a>
<a href="http://productselection.net">Product Selection</a>
<a href="http://gavazzi.se">Nya Gavazzi.se</a>
<a href="http://support-carlogavazzi.se">Gamla supportsidan</a>
<span class="border-top mt-1"></span>
<div class="text-light">CG verktyg</div>
<a href=" http://172.16.0.184/qweb ">QUARTA</a>
<a href="http://194.243.72.228">GESTREQ</a>
<a href="http://172.16.0.183/projects/si5/wiki">Dokumentation SIGIP mm</a>
<a href="./posten">Posten Adresslappar</a>
@showmodule('enable_demoprodukter')
<span class="border-top mt-1"></span>
<div class="text-light">Inställningar</div><a href="{{ route('productlocations.index')}}">Hantera platser</a>
@endshowmodule
@hasrole('superadmin')
<a href="{{ route('admin.tasks.index')}}">Hantera ärenden</a>
<a href="{{ route('admin.users.index')}}">Hantera användare</a>
<a href="{{ route('admin.images.create')}}">Lägg till fil till receptionsskärm</a>
<a href="{{ route('admin.importproducts')}}">Uppdatera produktlista</a>
<a href="{{ route('admin.productstatus.index')}}">Hantera produktstatus</a>
@endhasrole
