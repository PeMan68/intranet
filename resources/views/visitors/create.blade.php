@extends('layouts.app')

@include('menues.visitors')

@section('scriptsBody')
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
			<div class="form-group">
				<label for="user_id">Vem besöks</label>	
				<select class="form-control" id="user_id" name="who">
					@foreach ($users as $user)
					<option value="{{ $user->id }}" @if ($user->id == Auth::user()->id) selected @endif>{{ $user->name }}</option>
					@endforeach
				</select>
			</div>
			
			<div class="form-group">
			<label for="startTime">Ankomsttid</label>	
				<b-form-datepicker id="startTime" name="startDate" value="{{ now() }}"></b-form-datepicker>
				<b-form-timepicker name="startTime" minutes-step="30" value="08:00"></b-form-timepicker>
			</div>
			<div class="form-group">
				<label for="stopTime">Sluttid</label>	
				<b-form-datepicker id="stopTime" name="stopDate" value="{{ now() }}"></b-form-datepicker>
				<b-form-timepicker name="stopTime" minutes-step="30" value="16:00"></b-form-timepicker>
			</div>
			<div class="form-group">
				<label for="company">Företag</label>
				<input id="company" type="text" class="form-control" name="company" value="{{ old('company') }}">
			</div>
			<div class="form-group row mb-0">
				<div class="col-md-8 offset-md-4">
					<button type="submit" class="btn btn-primary">Spara</button>
					<a type="button" class="btn btn-secondary" href="{{ route('visitors.index') }}">Avbryt</a>
					<button type="button" name="add" id="add" class="btn btn-success">+ Lägg till namn</button>								
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
