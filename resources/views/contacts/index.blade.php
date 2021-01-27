@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <h3>Kontakter</h3>
                </div>
            </div>
        </div>

        <div class="card-body">
            <contact-table 
                :contacts="{{ $contacts }}"
                :fields="{{ $fields }}"
                >
            </contact-table>
        </div>
    </div>
@endsection
