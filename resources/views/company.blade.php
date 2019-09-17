@extends('adminlte.layout   ')

@section('title', 'Companies')

@section('content')
  <business-module-component
    api-endpoint="company"
    display-property="name"
    :columns="[
      { property: 'name', label: 'Name' },
      { property: 'address', label: 'Address' },
    ]"
  />
@endsection
