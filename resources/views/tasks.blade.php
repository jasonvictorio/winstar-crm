@extends('layouts.app')

@section('content')
<!-- Styles -->
<link href="{{ asset('css/home.css') }}" rel="stylesheet">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" id="breadcrumbid">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tasks</li>
                    </ol>
                </nav>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="col-md-12">
                        <?php 
                                use WinstarCRM\Task;
                                use WinstarCRM\Helpers\CRMGrid;

                                $newgrid = new CRMGrid(Task::class, 'Tasks Table', 
                                    array(
                                    'column_configs' => array(
                                        'id'=> array('header'=>'ID', 'type' => 'text', 'length' => 5),
                                        'user_id'=> array('header'=>'User ID', 'type' => 'text', 'length' => 5),
                                        'project_id'=> array('header'=>'Project ID', 'type' => 'text', 'length' => 5),
                                        'task_description'=> array('header'=>'Task Description', 'length' => 10),
                                        'task_type_id'=> array('header'=>'Task type', 'type' => 'text', 'length' => 5),
                                        'task_category_id'=> array('header'=>'Task Category', 'type' => 'text', 'length' => 5),
                                        'created_date'=> array('header'=>'Created Date', 'length' => 10),
                                        'deadline_date'=> array('header'=>'Deadline', 'length' => 10),
                                        'estimated_duration'=> array('header'=>'Estimated Duration', 'length' => 10),
                                        'priority_level'=> array('header'=>'Priority Level', 'length' => 10),
                                        'status'=> array('header'=>'Status', 'length' => 10),
                                        'company_id'=> array('header'=>'Company ID', 'type' => 'text', 'length' => 5)
                                    ),
                                    'table_config' => array(
                                        'is_editable' => true,
                                        'enable_delete' => true,
                                        'is_sortable' => true,
                                        'set_size' => '-sm',
                                        'paginate' => 5,
                                        'enable_filter' => true,
                                        'enable_add' => true
                                    ))
                                );
                                $newgrid->display();
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection