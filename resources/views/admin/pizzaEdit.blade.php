@extends('layouts.app')

@section('content')
    <pizza-edit-component :pizza="{{ json_encode($pizza) }}"></pizza-edit-component>
@endsection