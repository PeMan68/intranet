@extends('../layouts.emailGeneric')


@section('message')
{!! nl2br(e($mailMessage)) !!}

@endsection