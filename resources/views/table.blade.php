@extends('adminlte.layout   ')

@section('title', 'Users')

@section('content')
  <table-component
    api-endpoint="users"
    display-property="name"
    :columns="[
      { property: 'id', label: 'ID' },
      { property: 'name', label: 'Name' },
      { property: 'company.name', label: 'Company' },
      { property: 'email', label: 'Email' },
    ]"
  />
@endsection
