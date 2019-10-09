@extends('adminlte.layout')

@section('title', 'Chart')

@section('content')
  <report-component
    api-endpoint="task"
    :groups="[
      { property: 'status', label: 'Status', relationDisplay: 'name' },
      { property: 'project', label: 'Project', relationDisplay: 'name' },
      { property: 'task_category', label: 'Task Category', relationDisplay: 'name' },
    ]"
    :filters="[
      { property: 'status', label: 'Status', relation: 'status', relationDisplay: 'name' },
      { property: 'project', label: 'Project', relation: 'project', relationDisplay: 'name' },
    ]"
  />
@endsection
