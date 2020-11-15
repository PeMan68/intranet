<li>
    {{ $location->name }}
    <a href="{{ route('locations.edit', $location->id) }}"><span class="badge badge-success" data-toggle="tooltip" title="Ändra platsens namn">edit<span></a>
    <a href="{{ route('locations.create', $location->id) }}"><span class="badge badge-info" data-toggle="tooltip" title="Lägg till plats under denna">lägg till<span></a>
    @if ($location->deletable())
    <a href="{{ route('locations.destroy', $location->id) }}"><span class="badge badge-danger" data-toggle="tooltip" title="Ta bort plats">ta bort<span></a>
    @endif
    @if (count($location->demoProducts))        
    <a href="{{ route('demoproducts.index', ['filter' => $location->name]) }}">({{ count($location->demoProducts) }} produkter)</a>
    @endif
</li>