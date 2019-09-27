@extends('adminlte.layout')

@section('title', 'Tasks')

@section('content')
  <business-module-component
    api-endpoint="task"
    display-property="name"
    :columns="[
        { property: 'name' },
        { property: 'description' },
        { property: 'created_date', type: 'date' },
        { property: 'deadline_date', type: 'date' },
        { property: 'project', relation: 'project', relationDisplay: 'name' },
        { property: 'status', relation: 'status', relationDisplay: 'name' },
        { property: 'task_type', relation: 'task_type', relationDisplay: 'name' },
        { property: 'task_category', relation: 'task_category', relationDisplay: 'name' },
        { property: 'company', relation: 'company', relationDisplay: 'name' },
        { property: 'status', relation: 'status', relationDisplay: 'name' },

    ]"
  />
@endsection
