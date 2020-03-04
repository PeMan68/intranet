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
	"timePicker": true,
	"timePickerIncrement":15,
	"timePicker24Hour":true,
	"startDate": moment().startOf('hour'),
    "endDate": moment().startOf('hour').add(2, 'hour'),
    "showWeekNumbers": true,
    "locale": {
        "format": "YYYY-MM-DD HH:mm",
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

<script type="text/javascript">
    $(document).ready(function(){      
		var i=1;  

		$('#add').click(function(){  
			i++;  
			$('#form-table').append('<tr id="row'+i+'" class="dynamic-added"><td class="text-md-right">Namn</td><td><input type="text" name="name[]" class="form-control" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
		});  

		$(document).on('click', '.btn_remove', function(){  
			var button_id = $(this).attr("id");   
			$('#row'+button_id+'').remove();  
		});
	});
</script>
@endsection

@section('content')
<div class="card">
	<div class="card-header h3">Registrera besökare</div>

	<div class="card-body">
		<form method="POST" action="{{ route('visitors.store') }}">
			@csrf
			<table class="table table-borderless" id="form-table">  
			<tr><td class="text-md-right">
				Vem besöks
			</td>
			<td>
				<select class="form-control" id="user_id" name="who">
					@foreach ($users as $user)
						<option value="{{ $user->id }}" @if ($user->id == Auth::user()->id) selected @endif>{{ $user->name }}</option>
					@endforeach
				</select>
			</td>
			<td></td>
			</tr>

			<tr><td class="text-md-right">
				Ange tidpunkt
			</td>
			<td>
				<input id="start" type="text" class="form-control" name="daterange" value="{{ old('daterange') }}">
			</td>
			<td></td>
			</tr>

			<tr><td class="text-md-right">
				Företag
			</td>
			<td>
			<input id="company" type="text" class="form-control" name="company" value="{{ old('company') }}">
			</td>
			<td></td>
			</tr>
			
			<tr><td class="text-md-right">
				Namn
			</td>
			<td>
				<input type="text" name="name[]" class="form-control">
			</td>
			<td></td>  
			</tr>  
			</table>  

			<div class="form-group row mb-0">
				<div class="col-md-8 offset-md-4">
					<button type="submit" class="btn btn-primary">Spara</button>
					<button class="btn btn-secondary" type="submit" name="reset" value="reset">Avbryt</button>
					<button type="button" name="add" id="add" class="btn btn-success">+ Lägg till namn</button>								
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
