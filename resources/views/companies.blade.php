@extends('adminlte.layout   ')

@section('title', 'Companies')

@section('content')
<div class="card-body">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
    <div class="col-md-12">
        <?php
            use WinstarCRM\Company;
            use WinstarCRM\Helpers\CRMGrid;

            $newgrid = new CRMGrid(Company::class, 'Companies Table',
                array(
                'column_configs' => array(
                    'id' => array('header'=>'ID', 'type' => 'text', 'length' => 5),
                    'name' => array('header'=>'Name', 'length' => 20),
                    'address' => array('header'=>'Address', 'length' => 50)
                ),
                'table_config' => array(
                    'enable_add' => true,
                    'enable_edit' => true,
                    'is_editable' => true,
                    'enable_delete' => true,
                    'is_sortable' => true,
                    'set_size' => '-sm',
                    'paginate' => 10,
                    'enable_filter' => true,
                    'constraint' => array('id', '>', 1)
                ))
            );
            $newgrid->display();
        ?>
    </div>
</div>
@endsection
