@extends('adminlte.layout   ')

@section('title', 'Users')

@section('content')
  <business-module-component
    api-endpoint="user"
    display-property="name"
    :columns="[
      { property: 'name', label: 'Name' },
      { property: 'company', label: 'Company', relation: 'company', relationDisplay: 'name' },
      { property: 'email', label: 'Email', type: 'email' },
      { property: 'access', label: 'Access', relation: 'access', relationDisplay: 'name' },
    ]"
  />
@endsection
