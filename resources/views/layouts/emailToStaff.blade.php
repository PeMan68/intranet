<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>

<body>
    <span style='font-size: 1em; font-family: Verdana,Arial,sans-serif;'>
        <p>
            @yield('header')
        </p>
    </span>
    @if (is_null($issue->timeCustomercallback) && is_null($issue->timeClosed))
        <span style='font-size: 0.8em; font-family: Verdana,Arial,sans-serif;'>
            <b><i>
                    Kunden har inte fått någon återkoppling ännu!<br><br>
                    Om du kan, kontakta kunden för att ge en första feedback
                </i></b>
            <ul>
                <li>Öppna ärendet, kontrollera status för återkoppling</li>
                <li>Kontakta kunden för en första återkoppling</li>
                <li>Markera kunden som kontaktad</li>
            </ul>
            <hr>
        </span>
    @endif
    <span style='font-size: 0.8em; font-family: Verdana,Arial,sans-serif;'>
        <p>
            |
            <a href="{{ url('/issues/' . $issue->id) }}">Öppna ärende</a>
            |
            @yield('links')

        </p>
        <hr>
        <table>
            <tr>
                <td><b>Typ:</b> </td>
                <td>{{ $issue->task->name }}</td>
            </tr>
            <tr>
                <td><b>Skapat:</b> </td>
                <td>{{ date('Y-m-d H:i', strtotime($issue->created_at)) }}</td>
            </tr>
            <tr>
                <td><b>Skapat av:</b> </td>
                <td>{{ $issue->userCreate->name . ' ' . $issue->userCreate->surname }}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><b>Kund:</b></td>
                <td>{{ $issue->customer }}</td>
            </tr>
            <tr>
                <td><b>Kundnummer:</b></td>
                <td>{{ $issue->customerNumber }}</td>
            </tr>
            <tr>
                <td><b>Namn:</b></td>
                <td>{{ $issue->customerName }}</td>
            </tr>
            <tr>
                <td><b>Telefon:</b></td>
                <td>{{ $issue->customerTel }}</td>
            </tr>
            <tr>
                <td><b>Mail:</b></td>
                <td>{{ $issue->customerMail }}</td>
            </tr>
        </table>
        <p>
            <b>Rubrik:</b><br>
            {!! nl2br(e($issue->header)) !!}
            <br>
        </p>
        <p>
            <b>Ärendebeskrivning:</b><br>
            {!! nl2br(e($issue->description)) !!}
            <br>
        </p>
        @if (!is_null($issue->descriptionInternal))
            <p>
                <b>Intern anteckning:</b><br>
                {!! nl2br(e($issue->descriptionInternal)) !!}
            </p>
        @endif
        <hr>
        <b>Händelselogg</b>
        @foreach ($issue
        ->issueComments()
        ->where('comment', '<>', null)
        ->orderBy('checkin', 'desc')
        ->get()
    as $comment)
            <br>
            <span style='font-size: 0.9em; font-family: Verdana,Arial,sans-serif;'>
                {{ date('Y-m-d H:i', strtotime($comment->checkin)) }}
                @switch($comment->type)
                    {{--
                    type==0 > info
                    type==1 > phone
                    type==2 > mail
                    --}}
                    @case(0)
                    &#x1f6c8;
                    @break
                    @case(1)
                    &#x260E;
                    @break
                    @case(2)
                    &#x2709;
                    @break
                @endswitch

                @switch($comment->direction)
                    {{--
                    direction==0 > internal note
                    direction==1 > outbound message
                    direction==2 > inbound message
                    --}}
                    @case(0)
                    {{ $comment->user->name . ' ' . $comment->user->surname }}
                    @break

                    @case(1)
                    {{ $comment->user->name . ' ' . $comment->user->surname }}
                    &#x279E;
                    {{ $comment->contact_id == 0 ? $comment->issue->customerName : $comment->contact->name }}
                    @break

                    @case(2)
                    {{ $comment->contact_id == 0 ? $comment->issue->customerName : $comment->contact->name }}
                    &#x279E;
                    {{ $comment->user->name . ' ' . $comment->user->surname }}
                    @break

                @endswitch
            </span>
            <br>
            <p style='font-size: 1em; font-family: Verdana,Arial,sans-serif; padding-left: 20px;'>
                {!! nl2br(e($comment->comment)) !!}
            </p>
        @endforeach
        <p>&nbsp;</p>

    </span>
</body>

</html>
