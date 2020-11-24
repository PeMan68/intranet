@extends('layouts.app')

@section('stylesheets')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('scriptsHead')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

@endsection

@section('scriptsBody')
<script>
	document.getElementById('calendarcategory_id').on('change',function(){
    var description = $(this).children('option:selected').data('name');
    document.getElementById('description').value=description;
	});
</script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h3">Lägg till händelse</div>

                <div class="card-body">

                    <form method="POST" action="{{ route('calendar.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="category" class="col-md-4 col-form-label text-md-right">Vem</label>

                            <div class="col-md-6">
								<select class="form-control" id="user_id" name="user_id">
									@foreach ($users as $user)
										<option value="{{ $user->id }}" @if ($user->id == Auth::user()->id) selected @endif>{{ $user->name }}</option>
									@endforeach
								</select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="category" class="col-md-4 col-form-label text-md-right">Typ</label>

                            <div class="col-md-6">
								<select class="form-control" id="calendarcategory_id" name="calendarcategory_id">
									@foreach ($categories as $category)
										<option value="{{ $category->id }}">{{ $category->name }}</option>
									@endforeach
								</select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Beskrivning</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control" name="description" value="{{ old('description') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="start" class="col-md-4 col-form-label text-md-right">Startdatum</label>
                            
                            <div class="col-md-6">
                                <b-form-datepicker id="start" name="start"></b-form-datepicker>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="stop" class="col-md-4 col-form-label text-md-right">Slutdatum (Kan lämnas tomt om samma dag)</label>
                            <div class="col-md-6">
                                <b-form-datepicker id="stop" name="stop"></b-form-datepicker>
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Spara
                                </button>
								<button class="btn btn-secondary" type="submit" name="reset" value="reset">
									Avbryt
								</button>                            
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
