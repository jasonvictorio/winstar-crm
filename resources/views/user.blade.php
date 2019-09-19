@extends('adminlte.layout   ')

@section('title', 'Users')

@section('content')
  <business-module-component
    api-endpoint="user"
    display-property="name"
    :columns="[
      { property: 'name', label: 'Name', required: true },
      { property: 'company', label: 'Company', relation: 'company', relationDisplay: 'name', required: true },
      { property: 'email', label: 'Email', type: 'email', required: true },
      { property: 'access', label: 'Access', relation: 'access', relationDisplay: 'name', required: true },
      { property: 'password', label: 'Password', type: 'password', hide: true, editable: false, required: true },
    ]"
  />
@endsection
