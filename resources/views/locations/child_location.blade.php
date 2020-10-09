<li>{{ $child_location->name }}</li>
@if ($child_location->locations)
    <ul>
        @foreach ($child_location->locations as $childLocation)
            @include('locations/child_location', ['child_location' => $childLocation])
        @endforeach
    </ul>
@endif