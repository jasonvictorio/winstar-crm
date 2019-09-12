@extends('adminlte.layout   ')

@section('title', 'Users')

@section('content')
  <table-component
    api-endpoint="users"
    display-property="name"
    :columns="[
      { property: 'name', label: 'Name' },
      { property: 'company', label: 'Company', relation: 'companies', relationDisplay: 'name' },
      { property: 'email', label: 'Email', type: 'email' },
      { property: 'access', label: 'Access', relation: 'accesses', relationDisplay: 'name' },
      { property: 'password', label: 'Password', type: 'password', hide: true},
    ]"
  />
@endsection
