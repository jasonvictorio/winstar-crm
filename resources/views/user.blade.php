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
      { property: 'role', label: 'Role', relation: 'role', relationDisplay: 'name', required: true },
      { property: 'password', label: 'Password', type: 'password', hide: true, editable: false, required: true },
      { property: 'avatar', label: 'Avatar', hide: true, editable: true, type: 'file' },
    ]"
  />
@endsection
