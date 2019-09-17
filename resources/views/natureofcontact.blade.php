@extends('adminlte.layout')

@section('title', 'Nature of Contact')

@section('content')
  <business-module-component
    api-endpoint="nature-of-contact"
    display-property="name"
    :columns="[
        { property: 'name', label: 'Name' },
    ]"
  />
@endsection
