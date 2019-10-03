@extends('adminlte.layout')

@section('title', 'Status')

@section('content')
  <business-module-component
    api-endpoint="status"
    display-property="name"
    :columns="[
        { property: 'name', label: 'Status' },
    ]"
  />
@endsection
