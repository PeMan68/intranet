@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header h3">Lägg till kontakt</div>

                    <div class="card-body">
                        <p><small>Lägg till kontakter inom koncernen(organisationen) som kan vara delaktiga i ärenden. <br>
                                Kundkontakter är normalt sett externa ("Hör inte till organisationen") 
                                och läggs automatiskt till av systemet vid registering av ärenden.
                            </small></p>
                        <form action="/contacts" method="post">
                            @csrf
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="internal" id="internal" value="1"
                                    {{ old('internal') <> '1' ? '' : 'checked' }}>
                                <label class="form-check-label" for="internal">Hör till organisationen</label>
                            </div>

                            <div class="form-group">
                                <label for="name">Namn</label>
                                <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}">
                            </div>

                            <div class="form-group">
                                <label for="email">E-post</label>
                                <input class="form-control" type="text" name="email" id="email" value="{{ old('email') }}">
                            </div>

                            <div class="form-group">
                                <label for="telephone">Telefon</label>
                                <input class="form-control" type="text" name="telephone" id="telephone"
                                    value="{{ old('telephone') }}">
                            </div>

                            <div class="form-group">
                                <label for="address1">Adress 1</label>
                                <input class="form-control" type="text" name="address1" id="address1"
                                    value="{{ old('address1') }}">
                            </div>

                            <div class="form-group">
                                <label for="address2">Adress 2</label>
                                <input class="form-control" type="text" name="address2" id="address2"
                                    value="{{ old('address2') }}">
                            </div>

                            <div class="form-group">
                                <label for="zip_city">Postnummer och Ort</label>
                                <input class="form-control" type="text" name="zip_city" id="zip_city"
                                    value="{{ old('zip_city') }}">
                            </div>

                            <div class="form-group">
                                <label for="company">Företag</label>
                                <input class="form-control" type="text" name="company" id="company"
                                    value="{{ old('company') }}">
                            </div>

                            <div class="form-group">
                                <label for="customer_number">Kundnummer</label>
                                <input class="form-control" type="text" name="customer_number" id="customer_number"
                                    value="{{ old('customer_number') }}">
                            </div>

                            <button type="submit" class="btn btn-primary m-1" name="save">
                                Spara
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
