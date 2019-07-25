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
                        <li class="breadcrumb-item active" aria-current="page">Task reassignments</li>
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
                                use WinstarCRM\TaskReassignment;
                                use WinstarCRM\Helpers\CRMGrid;

                                $newgrid = new CRMGrid(TaskReassignment::class, 'Task Reassignments', 
                                    array(
                                    'column_configs' => array(
                                        'id'=> array('header'=>'ID', 'type' => 'text', 'length' => 5),
                                        'task_id'=> array('header'=>'Task ID', 'type' => 'text', 'length' => 5),
                                        'reason'=> array('header'=>'Reason', 'length' => 50),
                                        'previous_user_id'=> array('header'=>'Previous User', 'type' => 'text', 'length' => 5),
                                        'current_user_id'=> array('header'=>'Current User', 'type' => 'text', 'length' => 5),
                                        'date_time'=> array('header'=>'Date/Time', 'length' => 20),
                                        'company_id'=> array('header'=>'Company ID', 'type' => 'text', 'length' => 5)
                                    ),
                                    'table_config' => array(
                                        'is_editable' => true,
                                        'enable_delete' => true,
                                        'is_sortable' => true,
                                        'set_size' => '-sm',
                                        'paginate' => 5,
                                        'enable_filter' => true
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