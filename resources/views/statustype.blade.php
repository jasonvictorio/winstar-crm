@extends('adminlte.layout')

@section('title', 'Status Type')

@section('content')
  <business-module-component
    api-endpoint="status-type"
    display-property="name"
    :columns="[
        { property: 'name', label: 'name' },
    ]"
  />
@endsection
