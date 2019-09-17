@extends('adminlte.layout')

@section('title', 'Status')

@section('content')
  <business-module-component
    api-endpoint="status"
    display-property="status"
    :columns="[
        { property: 'status', label: 'Status' },
        { property: 'company', label: 'Company', relation: 'company', relationDisplay: 'name' },
        { property: 'status_type', label: 'Type', relation: 'status-type', relationDisplay: 'name' },
    ]"
  />
@endsection
