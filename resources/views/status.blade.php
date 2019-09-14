@extends('adminlte.layout')

@section('title', 'Status')

@section('content')
  <business-module-component
    api-endpoint="status"
    display-property="status"
    :columns="[
        { property: 'status', label: 'Status' },
        { property: 'company', label: 'Company', relation: 'companies', relationDisplay: 'name' },
        { property: 'status_type', label: 'Type', relation: 'status-types', relationDisplay: 'name' },
    ]"
  />
@endsection
