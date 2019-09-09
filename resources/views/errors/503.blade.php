@extends('errors::layout')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __($exception->getMessage() ?: 'Tillfälligt avbrott, intranet uppdateras. Prova igen om en kvart...'))
