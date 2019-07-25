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
                        <li class="breadcrumb-item active" aria-current="page">Contacts</li>
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
                                use WinstarCRM\Contact;
                                use WinstarCRM\Helpers\CRMGrid;

                                $newgrid = new CRMGrid(Contact::class, 'Contacts Table', 
                                    array(
                                    'column_configs' => array(
                                        'id' => array('header'=>'ID', 'type' => 'text', 'length' => 5),
                                        'company_id' => array('header'=>'Company ID', 'type' => 'text', 'length' => 5),
                                        'user_id' => array('header'=>'User ID', 'type' => 'text', 'length' => 5),
                                        'customer_id' => array('header'=>'Customer ID', 'type' => 'text', 'length' => 5),
                                        'first_name' => array('header'=>'First Name', 'length' => 15),
                                        'surname' => array('header'=>'Surname', 'length' => 15),
                                        'email' => array('header'=>'Email', 'length' => 15),
                                        'mobile' => array('header'=>'Mobile', 'length' => 15),
                                       
                                    ),
                                    'table_config' => array(
                                        'is_editable' => true,
                                        'enable_delete' => true,
                                        'is_sortable' => true,
                                        'set_size' => '-sm',
                                        'paginate' => 5,
                                        'enable_filter' => true,
                                        'enable_add'=> array(
                                            'company_id' => array('header'=>'Company ID'),
                                            'user_id' => array('header'=>'User ID'),
                                            'customer_id' => array('header'=>'Customer ID'),
                                            'first_name' => array('header'=>'First Name'),
                                            'surname' => array('header'=>'Surname'),
                                            'email' => array('header'=>'Email', 'type'=>'text'),
                                            'mobile'=>array('header'=>'Mobile')
                                        )
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