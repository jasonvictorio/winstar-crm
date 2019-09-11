@extends('adminlte.layout   ')

@section('title', 'Companies')

@section('content')
  <table-component
    api-endpoint="status"
    display-property="status"
    :columns="[
        { property: 'status', label: 'Status' },
        { property: 'type', label: 'Type' },
        { property: 'company', label: 'Company', relation: 'companies', relationDisplay: 'name' },
    ]"
  />
@endsection
