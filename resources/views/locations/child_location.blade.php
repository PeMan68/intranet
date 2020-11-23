@include('locations/links', ['location' => $location])
@if ($location->locations)
    <ul style="list-style-type: none">
        @foreach ($location->locations as $childLocation)
            @include('locations/child_location', ['location' => $childLocation])
        @endforeach
    </ul>
@endif