@extends('adminlte.layout')

@section('title', 'Nature of Contact')

@section('content')
  <business-module-component
    display-property="name"
    :columns="[
        { property: 'name', label: 'Name' },
    ]"
  />
@endsection
