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
                        <li class="breadcrumb-item active" aria-current="page">Domains</li>
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
                                use WinstarCRM\Domain;
                                use WinstarCRM\Helpers\CRMGrid;

                                $newgrid = new CRMGrid(Domain::class, 'Domains Table', 
                                    array(
                                    'column_configs' => array(
                                        'id'=> array('header'=>'ID', 'type' => 'text', 'length' => 5),
                                        'company_id'=> array('header'=>'Company ID', 'type' => 'text', 'length' => 5),
                                        'customer_id'=> array('header'=>'Customer ID', 'type' => 'text', 'length' => 5),
                                        'url'=> array('header'=>'Url'),
                                        'renewal_date'=> array('header'=>'Renewal date', 'length' => 10),
                                        'status_id'=> array('header'=>'Status', 'type' => 'text', 'length' => 5)
                                       
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