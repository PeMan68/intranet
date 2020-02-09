@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="post" action="{{ route('admin.settings.store') }}" class="form-horizontal" role="form">
					@csrf

                    @if(count(config('setting_fields', [])) )

                        @foreach(config('setting_fields') as $section => $fields)
                            <div class="card mb-4">
                                <div class="card-header">
									<h2 class="d-inline align-middle"><i class="material-icons">{{ array_get($fields, 'icon', 'settings_applications') }}</i>
                                    {{ $fields['title'] }}</h2>
                                </div>

                                <div class="card-body">
                                    <p class="text-muted">{{ $fields['desc'] }}</p>
                                    <div class="row">
                                        <div class="col-md-8">
                                            @foreach($fields['elements'] as $field)
                                                @includeIf('admin.settings.fields.' . $field['type'] )
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- end panel for {{ $fields['title'] }} -->
                        @endforeach

                    @endif

                    <div class="row m-b-md">
                        <div class="col-md-12">
                            <button class="btn-primary btn">
                                Spara Inställningar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection