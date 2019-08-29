@extends('adminlte.layout')

@section('title', 'Users')

@section('content')
<div class="card-body">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="col-md-12">
        <?php
            use WinstarCRM\User;
            use WinstarCRM\Helpers\CRMGrid;

            $newgrid = new CRMGrid(User::class, 'Users Table',
                array(
                'column_configs' => array(
                    'id' => array('header'=>'ID', 'type' => 'text', 'length' => 5),
                    'name' => array('header'=>'Name', 'length' => 10),
                    'email' => array('header'=>'Email', 'length' => 20, 'regex' => '^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$'),
                    'access' => array('header'=>'Access', 'length' => 1)
                ),
                'table_config' => array(
                    'show_created_at' => false,
                    'is_editable' => true,
                    'enable_delete' => true,
                    'is_sortable' => true,
                    'set_size' => '-sm',
                    'paginate' => 5,
                    'enable_filter' => true,
                    'enable_add'=> array(
                        'name'=>array('header'=>'Name'),
                        'email' => array('header'=>'Email', 'type'=>'text'),
                        'access'=>array('header'=>'Access'),
                        'password' => array('header'=>'Password'),
                        'company_id' => array('header'=>'Company ID', 'relation'=>'companies', 'displayColumn'=>'name'),
                    ),
                    'enable_edit' => true
                ))
            );
            $newgrid->display();
        ?>
    </div>
</div>
@endsection
