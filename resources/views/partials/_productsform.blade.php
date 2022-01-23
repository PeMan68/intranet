<form action="{{ route('products.search') }}" method="post">
    @csrf
<input type="text" id="filter" name="filter">
<b-button type="submit">Sök</b-button>
<form>