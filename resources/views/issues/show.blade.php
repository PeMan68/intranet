@extends('layouts.app')

@include('menues.issues')

@section('scriptsBody')
    <script>
        $(document).ready(function() {
            $('#buttons').hide();


            $("#issueheader").change(function() {
                $('#buttons').show();
            });
        });

    </script>
@endsection

{{-- @section('scriptsBody')
    <script type="text/javascript">
        $(document).ready(function() {
            var i = 1;
            $('#form-table').hide();

            $('#add').click(function() {
                i++;
                $('#form-table').show();
                $('#form-table').append('<tr id="row' + i +
                    '" class="dynamic-added"><td><input type="file" class="form-control-file" name="files[]"></td><td><input type="text" class="form-control form-control-sm" id="fileDescription"  name="fileDescriptions[]" value="{{ old('fileDescription') }}"></td><td><button type="button" name="remove" id="' +
                    i + '" class="btn btn-danger btn_remove btn-sm">X</button></td></tr>');
            });

            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });
        });

    </script>
@endsection --}}

@section('content')
    <div class="card">
        <div class="card-header h3">
            Ärende {{ $issue->ticketNumber }} utcheckat av
            {{ $issue->userCurrent->name }}
            {{ $issue->userCurrent->surname }}
            @if ($auth_user->id == $issue->userCurrent_id)
                <a class="btn btn-primary btn-sm m-2" href="{{ route('issues.index') }}" role="button">
                    Checka tillbaks ärende
                    <i class="material-icons white md-18 ml-1" data-toggle="tooltip"
                        title="Checka tillbaks ärendet när du är klar så det inte är blockerat för andra användare"
                        style="vertical-align: middle;">help</i>
                </a>
                @if (is_null($issue->timeClosed))
                    <a class="btn btn-success btn-sm m-2" href="{{ route('issues.close', $issue->id) }}"
                        role="button">Avsluta ärende</a>
                @endif
            @endif

        </div>
        <div class="card-body">
            @if ($auth_user->id != $issue->userCurrent_id)
                <div class="alert alert-info">
                    Ärendet är för närvarande utcheckat av
                    {{ $issue->userCurrent->name }}
                    {{ $issue->userCurrent->surname }}.
                    Du kan läsa men inte ändra några uppgifter förrän ärendet är ledigt.
                    Det går att lägga till kommentarer.
                </div>
            @endif
            @if (!is_null($issue->timeClosed))
                <div class="alert alert-danger">
                    Ärendet är avslutat.
                    <a class="btn btn-danger btn-sm m-2" href="{{ route('issues.reopen', $issue->id) }}"
                        role="button">Öppna
                        ärende igen</a>
                </div>
            @endif
            <form action="{{ url('issues', [$issue->id]) }}" method="post" id="issueheader">
                @method('PUT')
                @csrf
                @if ($auth_user->id != $issue->userCurrent_id or !is_null($issue->timeClosed))
                    <fieldset disabled>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 30%;"><strong>Ärende skapat:</strong></td>
                                <td>
                                    {{ date('Y-m-d H:i', strtotime($issue->created_at)) }}
                                    av
                                    {{ $issue->userCreate->name }}
                                    {{ $issue->userCreate->surname }}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Kundnr:</strong></td>
                                <td>
                                    <input type="text" value="{{ old('customerNumber', $issue->customerNumber) }}"
                                        class="form-control" id="customerNumber" name="customerNumber">
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Kund:</strong></td>
                                <td><input type="text" value="{{ $issue->customer }}" class="form-control" id="customer"
                                        name="customer"></td>
                            </tr>
                            <tr>
                                <td><strong>Kontakt:</strong></td>
                                <td><input type="text" value="{{ $issue->customerName }}" class="form-control"
                                        id="customerName" name="customerName"></td>
                            </tr>
                            <tr>
                                <td><strong>Telefon:</strong></td>
                                <td> <input type="text" value="{{ $issue->customerTel }}" class="form-control"
                                        id="customerTel" name="customerTel"></td>
                            </tr>
                            <tr>
                                <td><strong>E-mail:</strong></td>
                                <td><input type="text" value="{{ $issue->customerMail }}" class="form-control"
                                        id="customerMail" name="customerMail"></td>
                            </tr>
                            <tr>
                                <td><strong>Område:</strong></td>
                                <td><select class="form-control" id="task_id" name="task_id">
                                        <option value="-">---</option>

                                        @foreach ($tasks as $task)
                                            <option value="{{ $task->id }}"
                                                {{ $task->id == $issue->task_id ? 'selected' : '' }}>
                                                {{ $task->name }}</option>
                                        @endforeach
                                    </select></td>
                            </tr>
                            <tr>
                                <td><strong>Personligt eller grupp:</strong></td>
                                <td><select class="form-control" id="taskPersonal_id" name="taskPersonal_id">
                                        <option value="0" {{ old('taskPersonal_id') == '0' ? 'selected' : '' }}>
                                            Gruppärende
                                        </option>
                                        <option value="{{ $auth_user->id }}" @if (!old() && $auth_user->id == $issue->taskPersonal_id) selected @endif>{{ $auth_user->name }}
                                            {{ $auth_user->surname }}
                                        </option>
                                    </select></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table style="width: 100%;">
                            <tr>
                                <td><strong>Rubrik:</strong></td>
                                <td><input type="text" value="{{ old('header', $issue->header) }}" class="form-control"
                                        id="header" name="header"></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;"><strong>Ärendebeskrivning:</strong></td>
                                <td> <textarea class="form-control" id="description" name="description"
                                        rows="7">{{ old('description', $issue->description) }}</textarea></td>
                            </tr>
                            <tr>
                                <td><strong>Intern kommentar:</strong></td>
                                <td> <textarea class="form-control" id="descriptionInternal" name="descriptionInternal"
                                        rows="5">{{ old('descriptionInternal', $issue->descriptionInternal) }}</textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="prio1" name="prio" value="1"
                                {{ $issue->prio == '1' ? 'checked' : '' }}>
                            <label for="prio1" class="font-weight-bold m-0">Prioritet Normal</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="prio2" name="prio" value="2"
                                {{ $issue->prio == '2' ? 'checked' : '' }}>
                            <label for="prio2" class="font-weight-bold m-0">Prioritet Hög</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" id="vip" name="vip" value="1"
                                {{ $issue->vip == '1' ? 'checked' : '' }}>
                            <label for="vip" class="font-weight-bold m-0">VIP-kund</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" id="paused" name="paused" value="1"
                                {{ $issue->paused == '1' ? 'checked' : '' }}>
                            <label for="vip" class="font-weight-bold m-0">Ärendet Pausat</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" id="waitingForCustomer"
                                name="waitingForCustomer" value="1"
                                {{ $issue->waitingForCustomer == '1' ? 'checked' : '' }}>
                            <label for="vip" class="font-weight-bold m-0">Väntar på svar från Kund</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" id="waitingForInternal"
                                name="waitingForInternal" value="1"
                                {{ $issue->waitingForInternal == '1' ? 'checked' : '' }}>
                            <label for="vip" class="font-weight-bold m-0">Väntar på svar från Kollega</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" id="buttons">
                        <button type="submit" class="btn btn-primary m-2" name="save">
                            Spara ändringarna
                        </button>
                        <button type="submit" class="btn btn-secondary m-2" name="cancel">
                            Ångra ändringarna
                        </button>

                    </div>
                </div>
                </fieldset>
                <hr>
                @if (is_null($issue->timeClosed))
                    <div class="row">
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                @foreach ($followers as $user)
                                    <b-avatar v-b-tooltip.hover text="{{ $user->initials() }}"
                                        size="2em"
                                        title="{{ $user->name . ' ' . $user->surname }}"></b-avatar>
                                @endforeach
                                @if ($follow)
                                    <b-button size="sm" v-b-tooltip.hover
                                        title="Du kan sluta följa ärendet om det inte är ditt primära område"
                                        href="{{ route('issues.unfollow', $issue->id) }}" variant="primary">
                                        Sluta följa ärende
                                        <i class="material-icons white md-18 ml-1" style="vertical-align: middle;">help</i>
                                    </b-button>
                                @else
                                    <b-button size="sm" v-b-tooltip.hover
                                        title="Följ ärendet för att få mail när det händer något"
                                        href="{{ route('issues.follow', $issue->id) }}" variant="primary">
                                        Följ ärende
                                        <i class="material-icons white md-18 ml-1" style="vertical-align: middle;">help</i>
                                    </b-button>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if (is_null($issue->timeCustomercallback))
                                <div class="alert alert-primary">
                                    <b-button size="sm" v-b-tooltip.hover
                                        title="Klicka här för att bekräfta att kunden har fått en första feedback"
                                        href="{{ route('issues.contacted', $issue->id) }}" variant="primary">
                                        Klicka här när kunden är kontaktad
                                        <i class="material-icons white md-18 ml-1" style="vertical-align: middle;">help</i>
                                    </b-button>
                                </div>
                            @else
                                <div class="alert alert-success">
                                    <i class="material-icons align-middle" data-toggle="tooltip"
                                        title="Kund kontaktad">how_to_reg</i>
                                    Kund kontaktad: {{ date('Y-m-d H:i', strtotime($issue->timeCustomercallback)) }}
                                    <b-button size="sm" v-b-tooltip.hover title="Klicka här för ta bort bekräftelsen"
                                        href="{{ route('issues.uncontacted', $issue->id) }}" variant="secondary">
                                        Ångra kund kontaktad
                                        <i class="material-icons white md-18 ml-1" style="vertical-align: middle;">help</i>
                                    </b-button>
                                </div>
                            @endif
                        </div>

                    </div>
                @endif
            </form>
            <div class="row py-1">
                <div class="col-md-8">
                    <div class="font-weight-bold">Bilagor:</div>
                    @foreach ($files as $file)
                        <a href="{{ '/issues/attachment/download/' . $file->id }}">{{ $file->filename }}</a>
                        &nbsp;
                        &nbsp;
                    @endforeach
                </div>
            </div>
            <div class="row py-2">
                <div class="col-md-8">
                    <form-file :id={{ $issue->id }}></form-file>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-3 my-3" style="background-color: rgb(240, 240, 240)">
        <div>
            <h3>Lägg till anteckning</h3>
            @if (is_null($issue->timeClosed))
                <issue-comment-form :contacts="{{ $contacts }}" :comment="{{ $new_comment }}"
                    :follow="{{ $follow }}">
                </issue-comment-form>
            @endif
            <h3>Historik</h3>
            <hr>
            @foreach ($comments as $comment)
                <issue-comment>
                    <template #date>
                        {{ date('Y-m-d H:i', strtotime($comment->checkin)) }}
                    </template>
                    <template #type>
                        @switch($comment->type)
                            @case(0)
                            <i class="material-icons">info</i>
                            @break
                            @case(1)
                            <i class="material-icons">phone</i>
                            @break
                            @case(2)
                            <i class="material-icons">mail</i>
                            @break
                        @endswitch
                    </template>
                    @switch($comment->direction)
                        {{-- direction==0 > internal note
                        direction==1 > outbound message
                        direction==2 > inbound message --}}
                        @case(0)
                        <template #from>
                            {{ $comment->user->name . ' ' . $comment->user->surname }}
                        </template>
                        @break

                        @case(1)
                        <template #from>
                            {{ $comment->user->name . ' ' . $comment->user->surname }}
                        </template>
                        <template #to>
                            <i class="material-icons">forward</i>
                            {{ $comment->contact_id == 0 ? $comment->issue->customerName : $comment->contact->name }}
                        </template>
                        @break

                        @case(2)
                        <template #to>
                            <i class="material-icons">forward</i>
                            {{ $comment->user->name . ' ' . $comment->user->surname }}
                        </template>
                        <template #from>
                            {{ $comment->contact_id == 0 ? $comment->issue->customerName : $comment->contact->name }}
                        </template>
                        @break

                        @default

                    @endswitch

                    <b-card style="max-width: 50rem;"
                        border-variant="{{ $comment->direction == 0 ? 'info' : ($comment->contact_id == 0 ? 'success' : 'warning') }}">
                        <b-card-text>
                            {!! nl2br(e($comment->comment)) !!}
                        </b-card-text>
                    </b-card>
                </issue-comment>
            @endforeach
        </div>
    </div>
@endsection
