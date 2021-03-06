@extends('../layouts.emailToCustomer')

@section('header')
    Orsak till uppdatering: 
    @if ($type == 'header')    
    Ny information registrerat
    @endif
@endsection

@section('message')
Nedan ser du de uppgifter vi registrerat om ärendet.<br>
Om du vill uppdatera eller komplettera med några uppgifter kan du svara på detta mail.<br><br>
Om du kontaktar oss via andra kanaler, uppge gärna ärendenumret.
@endsection