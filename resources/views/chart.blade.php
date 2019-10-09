@extends('adminlte.layout')

@section('title', 'Chart')

@section('content')
  <report-component
    api-endpoint="task"
    :groups="[{
      label: 'Status',
      value: { groupBy: 'status.id', name: 'status.name', label: 'Status' },
    }, {
      label: 'Project',
      value: { groupBy: 'project.id', name: 'project.name', label: 'Project'  },
    }, {
      label: 'Task Category',
      value: { groupBy: 'task_category.id', name: 'task_category.name', label: 'Task Category'  },
    }]"
    :filters="[
      { property: 'status', label: 'Status', relation: 'status', relationDisplay: 'name' },
      { property: 'project', label: 'Project', relation: 'project', relationDisplay: 'name' },
    ]"
  />
@endsection
