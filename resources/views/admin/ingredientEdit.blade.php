@extends('layouts.app')

@section('content')
    <ingredient-edit-component :data="{{ json_encode($data) }}"></ingredient-edit-component>
@endsection