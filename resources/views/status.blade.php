@extends('adminlte.layout')

@section('title', 'Status')

@section('content')
  <business-module-component
    api-endpoint="status"
    display-property="name"
    :columns="[
        { property: 'name', label: 'Status' },
        { property: 'status_type', label: 'Type', relation: 'status-type', relationDisplay: 'name' },
    ]"
  />
@endsection
