@extends('layouts.app')
@section('content-body')
    <animal-card :card="{{$card}}"></animal-card>
@endsection
