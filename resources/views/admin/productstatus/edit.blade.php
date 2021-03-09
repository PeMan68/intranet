@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header h3">Ändra Status för demoprodukter</div>
                    <div class="card-body">
                        @if ($status->hasAnyProducts())
                            <div class="alert alert-danger">
                                Varning! Denna produktstatus används!
                            </div>
                        @endif
                        <form action="{{ route('admin.productstatus.update', [$status->id]) }}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label for="name" class="font-weight-bold h5">Beskrivning</label>
                                <input type="text" value="{{ $status->description }}" class="form-control"
                                    id="description" name="description">
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Spara
                                    </button>
                                    <button class="btn btn-secondary" type="submit" name="reset" value="reset">
                                        Avbryt
                                    </button>
                                    <b-button variant="danger" type="submit" name="delete" value="delete" @if ($status->hasAnyProducts()) disabled @endif>
                                        Radera
                                    </b-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
