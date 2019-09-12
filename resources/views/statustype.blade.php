@extends('adminlte.layout')

@section('title', 'Status Type')

@section('content')
  <table-component
    api-endpoint="status-types"
    display-property="name"
    :columns="[
        { property: 'name', label: 'name' },
    ]"
  />
@endsection
