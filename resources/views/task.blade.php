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
        { property: 'task_category', relation: 'task-category', relationDisplay: 'name' },
        { property: 'company', relation: 'company', relationDisplay: 'name' },
    ]"
  />
@endsection
