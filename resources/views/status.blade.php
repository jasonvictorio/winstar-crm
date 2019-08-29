@extends('adminlte.layout   ')

@section('title', 'Status')

@section('content')

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="col-md-12">
                        <?php
                                use WinstarCRM\Status;
                                use WinstarCRM\Helpers\CRMGrid;

                                $newgrid = new CRMGrid(Status::class, 'Status Table',
                                    array(
                                    'column_configs' => array(
                                        'id'=> array('header'=>'ID', 'type' => 'text', 'length' => 5),
                                        'company_id'=> array('header'=>'Company ID', 'type' => 'text', 'length' => 5),
                                        'status'=> array('header'=>'Status', 'length' => 15),
                                        'type'=> array('header'=>'Type', 'length' => 15)
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
@endsection
