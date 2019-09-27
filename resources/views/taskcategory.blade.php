@extends('adminlte.layout')

@section('title', 'Task Categories')

@section('content')
  <business-module-component
    api-endpoint="task-category"
    display-property="name"
    :columns="[
        { property: 'name', label: 'Name' },
    ]"
  />
@endsection
