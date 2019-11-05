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
$('input[name="daterange"]').daterangepicker({
    "showWeekNumbers": true,
    "locale": {
        "format": "YYYY-MM-DD",
        "separator": " till ",
        "applyLabel": "Välj",
        "cancelLabel": "Avbryt",
        "fromLabel": "Från",
        "toLabel": "Till",
        "customRangeLabel": "Custom",
        "weekLabel": "V",
        "daysOfWeek": [
            "Sön",
            "Mån",
            "Tis",
            "Ons",
            "Tor",
            "Fre",
            "Lör"
        ],
        "monthNames": [
            "Januari",
            "Februari",
            "Mars",
            "April",
            "Maj",
            "Juni",
            "Juli",
            "Augusti",
            "September",
            "Oktober",
            "November",
            "December"
        ],
        "firstDay": 1
    },
});
</script>
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
                <div class="card-header h3">Ändra händelse</div>

                <div class="card-body">
					@if ($errors->any())
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
                    <form method="POST" action="{{ route('calendar.update',$entry->id) }}">
                        @csrf
						@method('PUT')

                        <div class="form-group row">
                            <label for="user_id" class="col-md-4 col-form-label text-md-right">Vem</label>

                            <div class="col-md-6">
								<select class="form-control" id="user_id" name="user_id">
									@foreach ($users as $user)
										<option value="{{ $user->id }}" @if ($user->id==$entry->user_id) selected @endif>{{ $user->name }}</option>
									@endforeach
								</select>
                            </div>
                        </div>

                       <div class="form-group row">
                            <label for="category" class="col-md-4 col-form-label text-md-right">Typ</label>

                            <div class="col-md-6">
								<select class="form-control" id="calendarcategory_id" name="calendarcategory_id">
									@foreach ($categories as $category)
										<option value="{{ $category->id }}" @if ($category->id==$entry->calendarcategory_id) selected @endif>{{ $category->name }}</option>
									@endforeach
								</select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Beskrivning</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control" name="description" value="{{ $entry->description }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="start" class="col-md-4 col-form-label text-md-right">Tidsperiod</label>

                            <div class="col-md-6">
                                <input id="start" type="text" class="form-control" name="daterange" value="{{ $entry->start }} till {{ $entry->stop }}">
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
								<button class="btn btn-danger" type="submit" name="delete" value="delete">
									Radera
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
