@extends('layouts.app')

@section('content')

        <div class="row pb-3">
                <div class="col">
                        @include('partials._chart')
                </div>
        </div>
        <div class="row">
                <div class="col-xl-9 pb-3">
					@include('partials._kalender')
				</div>
                <div class="col-xl-3 pb-3">
					@include('partials._visitors')
                </div>
        </div>

@endsection
