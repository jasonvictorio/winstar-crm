@extends('adminlte.layout   ')

@section('title', 'Companies')

@section('content')
  <table-component
    api-endpoint="companies"
    display-property="name"
    :columns="[
      { property: 'name', label: 'Name' },
      { property: 'address', label: 'Address' },
    ]"
  />
@endsection
