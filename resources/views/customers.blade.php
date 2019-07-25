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
                        <li class="breadcrumb-item active" aria-current="page">Customers</li>
                    </ol>
                </nav>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="col-md-12" id="scroll">
                        <?php 
                                use WinstarCRM\Customer;
                                use WinstarCRM\Helpers\CRMGrid;

                                $newgrid = new CRMGrid(Customer::class, 'Customer Table', 
                                    array(
                                    'column_configs' => array(
                                        'id' => array('header'=>'ID', 'length' => 5),
                                        'company_id' => array('header'=>'Company ID', 'length' => 5),
                                        'next_follow_up_date' => array('header'=>'Next follow up', 'length' => 10),
                                        'latest_contact_or_actions' => array('header'=>'Recent follow up', 'length' => 50),
                                        'nature_of_contact' => array('header'=>'Nature of contact', 'length' => 50),
                                        'notes' => array('header'=>'Notes', 'length' => 50),
                                        'first_contacted' => array('header'=>'First contacted', 'length' => 10),
                                        'last_contacted' => array('header'=>'Last contacted', 'length' => 10),
                                        'days_since_last_contact' => array('header'=>'Since last contact', 'length' => 12),
                                        'status_id' => array('header'=>'Status', 'length' => 50),
                                        'month_ordered' => array('header'=>'Month ordered', 'length' => 50),
                                        'package_ordered' => array('header'=>'Package ordered', 'length' => 50),
                                        'hear_about_us' => array('header'=>'Hear about us', 'length' => 50),
                                        'up_sell' => array('header'=>'Up sell', 'length' => 50),
                                        'quote_total' => array('header'=>'Quote total', 'length' => 50),
                                        'addons' => array('header'=>'Addons', 'length' => 50),
                                        'total' => array('header'=>'Total', 'length' => 50),
                                        'invoiced' => array('header'=>'Invoiced', 'length' => 50),
                                        'annual_renewal_date' => array('header'=>'Annual renewal date', 'length' => 10),
                                        'annual_renewal_amount' => array('header'=>'Annual renewal amount', 'length' => 10)
                                    ),
                                    'table_config' => array(
                                        'is_editable' => true,
                                        'enable_delete' => true,
                                        'is_sortable' => true,
                                        'set_size' => '-sm',
                                        'paginate' => 5,
                                        'enable_filter' => true,
                                        'enable_add'=> array(
                                            'company_id' => array('header'=>'Company ID', 'length' => 5),
                                            'next_follow_up_date' => array('header'=>'Next follow up', 'length' => 10),
                                            'latest_contact_or_actions' => array('header'=>'Recent follow up', 'length' => 50),
                                            'nature_of_contact' => array('header'=>'Nature of contact', 'length' => 50),
                                            'notes' => array('header'=>'Notes', 'length' => 50),
                                            'first_contacted' => array('header'=>'First contacted', 'length' => 10),
                                            'last_contacted' => array('header'=>'Last contacted', 'length' => 10),
                                            'days_since_last_contact' => array('header'=>'Since last contact', 'length' => 12),
                                            'status_id' => array('header'=>'Status', 'length' => 50),
                                            'month_ordered' => array('header'=>'Month ordered', 'length' => 50),
                                            'package_ordered' => array('header'=>'Package ordered', 'length' => 50),
                                            'hear_about_us' => array('header'=>'Hear about us', 'length' => 50),
                                            'up_sell' => array('header'=>'Up sell', 'length' => 50),
                                            'quote_total' => array('header'=>'Quote total', 'length' => 50),
                                            'addons' => array('header'=>'Addons', 'length' => 50),
                                            'total' => array('header'=>'Total', 'length' => 50),
                                            'invoiced' => array('header'=>'Invoiced', 'length' => 50),
                                            'annual_renewal_date' => array('header'=>'Annual renewal date', 'length' => 10),
                                            'annual_renewal_amount' => array('header'=>'Annual renewal amount', 'length' => 10)
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