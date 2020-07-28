@extends('layouts.app')

@section('content')
    <ingredient-create-component :pizza="{{ json_encode($pizza) }}"></ingredient-create-component>
@endsection