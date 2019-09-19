@extends('adminlte.layout   ')

@section('title', 'Customer')

@section('content')
  <business-module-component
    api-endpoint="customer"
    display-property="name"
    :columns="[
      { property: 'first_name', label: 'First Name', required: true },
      { property: 'last_name', label: 'Last Name' },
      { property: 'company', label: 'Company', relation: 'company', relationDisplay: 'name', required: true },
      { property: 'status', label: 'Status', relation: 'status', relationDisplay: 'name' },
      { property: 'nature_of_contact', label: 'Nature of Contact', relation: 'nature-of-contact', relationDisplay: 'name' },
      { property: 'first_contacted', label: 'First Contacted', type: 'date' },
      { property: 'last_contacted', label: 'Last Contacted', type: 'date' },
    ]"
  />
@endsection
