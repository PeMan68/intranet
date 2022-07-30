@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Hantera användare</div>

        <div class="card-body">
            <a href="users/export">Ladda ned excelfil</a>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Förnamn</th>
                        <th scope="col">Efternamn</th>
                        <th scope="col">Email</th>
                        <th scope="col">Aktiv</th>
                        <th scope="col">Visa i kalender</th>
                        <th scope="col">Roll</th>
                        <th scope="col">Avdelning</th>
                        <th scope="col">Hantera</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->surname }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->active }}</td>
                            <td>{{ $user->calendar }}</td>
                            <td>{{ implode(', ',$user->roles()->get()->pluck('name')->toArray()) }}</td>
                            <td>{{ implode(', ',$user->departments()->get()->pluck('name')->toArray()) }}</td>
                            <td>
                                <b-button variant="primary" size="sm"
                                    href="{{ route('admin.users.edit', $user->id) }}">Ändra</b-button>
                                <b-button variant="primary" size="sm"
                                    href="{{ route('admin.impersonate', $user->id) }}">Agera som</b-button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
