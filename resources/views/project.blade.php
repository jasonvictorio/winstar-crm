@extends('adminlte.layout   ')

@section('title', 'Projects')

@section('content')
  <business-module-component
    api-endpoint="project"
    display-property="name"
    :columns="[
      { property: 'name', label: 'Name', required: true },
      { property: 'start_date', label: 'Start Date', type: 'date' },
      { property: 'estimated_end_date', label: 'Estimated End Date', type: 'date' },
      { property: 'company', label: 'Company', relation: 'company', relationDisplay: 'name', required: true },
      { property: 'status', label: 'Status', relation: 'status', relationDisplay: 'name', required: true },
      { property: 'customer', label: 'Customer', relation: 'customer', relationDisplay: 'name', required: true },
    ]"
  />
@endsection
