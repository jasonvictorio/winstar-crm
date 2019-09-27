@extends('adminlte.layout   ')

@section('title', 'Task Types')

@section('content')
  <business-module-component
    api-endpoint="task-type"
    display-property="name"
    :columns="[
      { property: 'name', label: 'Name', required: true },
    ]"
  />
@endsection
