@extends('adminlte.layout   ')

@section('title', 'Customer')

@section('content')
  <business-module-component
    api-endpoint="customer"
    display-property="name"
    :columns="[
      { property: 'first_name', label: 'First Name' },
      { property: 'company', label: 'Company', relation: 'company', relationDisplay: 'name' },
      { property: 'status', label: 'Status', relation: 'status', relationDisplay: 'status' },
      { property: 'nature_of_contact', label: 'Nature of Contact', relation: 'nature-of-contact', relationDisplay: 'name' },
    ]"
  />
@endsection
