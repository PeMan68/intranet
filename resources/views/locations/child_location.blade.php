<li><a href="{{ route('locations.create', $child_location->id) }}">[+]</a>{{ $child_location->name }}</li>
@if ($child_location->locations)
    <ul style="list-style-type: none">
        @foreach ($child_location->locations as $childLocation)
            @include('locations/child_location', ['child_location' => $childLocation])
        @endforeach
    </ul>
@endif