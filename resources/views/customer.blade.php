@extends('adminlte.layout   ')

@section('title', 'Customer')

@section('content')
  <business-module-component
    api-endpoint="customer"
    display-property="name"
    :columns="[
      { property: 'name', editable: false },
      { property: 'first_name', label: 'First Name', required: true, hide: true },
      { property: 'last_name', label: 'Last Name', hide: true },
      { property: 'company', label: 'Company', relation: 'company', relationDisplay: 'name', required: true },
      { property: 'first_contacted', label: 'First Contacted', type: 'date' },
      { property: 'last_contacted', label: 'Last Contacted', type: 'date' },
    ]"
  />
@endsection
