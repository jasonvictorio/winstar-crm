@extends('adminlte.layout   ')

@section('title', 'Customer')

@section('content')
  <business-module-component
    api-endpoint="customer"
    display-property="name"
    :columns="[
      { property: 'first_name', label: 'First Name' },
      { property: 'company', label: 'Company', relation: 'company', relationDisplay: 'name' },
      { property: 'status', label: 'Status', relation: 'status', relationDisplay: 'name' },
      { property: 'nature_of_contact', label: 'Nature of Contact', relation: 'nature-of-contact', relationDisplay: 'name' },
      { property: 'first_contacted', label: 'First Contacted', type: 'date' },
      { property: 'last_contacted', label: 'Last Contacted', type: 'date' },
    ]"
  />
@endsection
