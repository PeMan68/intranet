@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header h3">Uppdatera kontakt</div>

                    <div class="card-body">
                        <p><small>Kontakter inom koncernen(organisationen) som kan vara delaktiga i ärenden ska markeras med hjälp av kryssrutan. <br>
                                Kundkontakter är normalt sett externa ("Hör inte till organisationen") 
                               
                            </small></p>
                        <form action="{{ route('contacts.update',$contact->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="internal" id="internal" value="1"
                                    {{ $contact->internal <> '1' ? '' : 'checked' }}>
                                <label class="form-check-label" for="internal">Hör till organisationen</label>
                            </div>

                            <div class="form-group">
                                <label for="name">Namn</label>
                                <input class="form-control" type="text" name="name" id="name" value="{{ $contact->name }}">
                            </div>

                            <div class="form-group">
                                <label for="email">E-post</label>
                                <input class="form-control" type="text" name="email" id="email" value="{{ $contact->email }}">
                            </div>

                            <div class="form-group">
                                <label for="telephone">Telefon</label>
                                <input class="form-control" type="text" name="telephone" id="telephone"
                                    value="{{ $contact->telephone }}">
                            </div>

                            <div class="form-group">
                                <label for="address1">Adress 1</label>
                                <input class="form-control" type="text" name="address1" id="address1"
                                    value="{{ $contact->address1 }}">
                            </div>

                            <div class="form-group">
                                <label for="address2">Adress 2</label>
                                <input class="form-control" type="text" name="address2" id="address2"
                                    value="{{ $contact->address2 }}">
                            </div>

                            <div class="form-group">
                                <label for="zip_city">Postnummer och Ort</label>
                                <input class="form-control" type="text" name="zip_city" id="zip_city"
                                    value="{{ $contact->zip_city }}">
                            </div>

                            <div class="form-group">
                                <label for="company">Företag</label>
                                <input class="form-control" type="text" name="company" id="company"
                                    value="{{ $contact->company }}">
                            </div>

                            <div class="form-group">
                                <label for="customer_number">Kundnummer</label>
                                <input class="form-control" type="text" name="customer_number" id="customer_number"
                                    value="{{ $contact->customer_number }}">
                            </div>

                            <button type="submit" class="btn btn-primary m-1" name="save" value="save">
                                Spara
                            </button>
                            <button class="btn btn-secondary" type="reset" name="reset" value="reset">
                                Återställ
                            </button>  
                            <button class="btn btn-secondary" type="submit" name="abort" value="abort">
                                Avbryt
                            </button>  
                            <button class="btn btn-danger" type="submit" name="delete" value="delete">
                                Radera
                            </button> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
