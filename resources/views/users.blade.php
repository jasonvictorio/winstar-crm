@extends('adminlte.layout   ')

@section('title', 'Users')

@section('content')
  <business-module-component
    api-endpoint="users"
    display-property="name"
    :columns="[
      { property: 'name', label: 'Name' },
      { property: 'company', label: 'Company', relation: 'companies', relationDisplay: 'name' },
      { property: 'email', label: 'Email', type: 'email' },
      { property: 'access', label: 'Access', relation: 'accesses', relationDisplay: 'name' },
    ]"
  />
@endsection
