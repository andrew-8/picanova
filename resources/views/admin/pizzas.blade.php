
@extends('layouts.app')

@section('content')

        <pizzas-component :pizzas="{{ json_encode($pizzas) }}"></pizzas-component>

@endsection