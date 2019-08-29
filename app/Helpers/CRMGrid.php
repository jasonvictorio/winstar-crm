<?php

namespace WinstarCRM\Helpers;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;

class CRMGrid
{
    private $table_name;
    private $model_class;
    private $grid_config_array;

    private $columns = array();
    private $modal = array();
    private $data = array();

    private $is_editable = false;
    private $enable_delete = false;
    private $is_sortable = false;
    private $paginate = false;
    private $enable_filter = false;
    private $enable_add = false;
    private $enable_edit = false;
    private $constraint = false;
    private $size = '';
    private $show_created_at = false;
    private $show_updated_at = false;

    public function __construct($model, $table_name, $grid_config_array = null)
    {
        // Initialise variables
        $this->table_name = $table_name;
        $this->model_class = $model;
        $this->grid_config_array = ($grid_config_array == '') || ($grid_config_array == null)
            ? $this->get_default_grid_config_array($this->model_class)
            : $grid_config_array;

        // Set table config
        $this->set_table_config( $this->grid_config_array);

        // Get all data from model
        $this->change_page($this->model_class);

        $model_columns = Schema::getColumnListing($this->get_table());

        //add created at
        if($this->show_created_at)
        {
            $grid_config_array['column_configs']['created_at'] = array('header' => 'Created At');
        }

        //add updated at
        if($this->show_updated_at)
        {
            $grid_config_array['column_configs']['updated_at'] = array('header' => 'Updated At');
        }

        // Set column config
        foreach($grid_config_array['column_configs'] as $column_name => $column_config)
        {
            // If given column name exist in model, use as header
            if(in_array($column_name, $model_columns))
            {
                // Set header
                if(isset($column_config['header']))
                    $this->columns[$column_name]['header'] = $column_config['header'];
                else
                    $this->columns[$column_name]['header'] = $column_name;

                // Set input type
                if(isset($column_config['type']))
                    $this->columns[$column_name]['type'] = $column_config['type'];
                else
                    $this->columns[$column_name]['type'] = 'text';

                // Set length
                if(isset($column_config['length']))
                    $this->columns[$column_name]['length'] = $column_config['length'];
                else
                    $this->columns[$column_name]['length'] = 10;

                // Set regex
                if(isset($column_config['regex']))
                    $this->columns[$column_name]['regex'] = $column_config['regex'];
                else
                    $this->columns[$column_name]['regex'] = null;
            }
        }

        // Set modal config from enable_add or enable_edit
        // If enable_add is set, array from enable_add used even for edit modal
        if($this->enable_add)
        {
            $this->set_modal_config($this->enable_add, $model_columns);
        }
        else if($this->enable_edit)
        {
            $this->set_modal_config($this->enable_edit, $model_columns);
        }
    }

    public function display()
    {
        echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>';
        echo '<script src="'.asset('js/CRMGrid.js').'"></script>';
        echo '<link href="'.asset('css/grid.css').'" rel="stylesheet">';
        echo '<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">';

        // Create unique identifer for each table
        $identifer = str_replace(' ', '', $this->table_name);
        $identifer = strtolower($identifer);

        // Add Modal
        echo '<div class="modal fade" id="'.$identifer.'_add_new_record" tabindex="-1" role="dialog">';
            echo '<div class="modal-dialog" role="document">';
                echo '<div class="modal-content">';
                    echo '<div class="modal-header">';
                        echo '<h5 id="modal-title" class="modal-title">Add New Record</h5>';
                        echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                            echo '<span aria-hidden="true">&times;</span>';
                        echo '</button>';
                    echo '</div>';
                    echo '<div class="modal-body">';
                    echo '<div id="'.$identifer.'_modal_success_alert" class="alert alert-success" role="alert">';
                    echo '</div>';
                    echo '<form id="'.$identifer.'_modal_form" method="POST" action="/postadd">';
                        if($this->enable_add)
                        {
                            foreach($this->modal as $column_name => $column_data)
                            {
                                // TODO: lmao
                                $obj = new $this->model_class();

                                // Display column only if it is a fillable column as specified in its model
                                $fillable_columns = $obj->getFillable();
                                if(in_array($column_name, $fillable_columns))
                                {
                                    echo '<div class="form-group row">';
                                        echo '<label for="input-'.$column_name.'" class="col-sm-3 col-form-label">'.$column_data['header'].'</label>';
                                        echo '<div class="col-sm-9">';
                                            if($column_data['relation']) {
                                                echo '<autocomplete-component css-class="form-control" placeholder="'.$column_data['header'].'" display-column="'.$column_data['displayColumn'].'" name="input-'.$column_name.'" relation="'.$column_data['relation'].'" />';
                                            } else {
                                                echo '<input regex="'.$column_data['regex'].'" type="'.$column_data['type'].'" maxlength="'.$column_data['length'].'" class="form-control" name="input-'.$column_name.'" id="input-'.$column_name.'" placeholder="'.$column_data['header'].'">';
                                            }
                                        echo '</div>';
                                    echo '</div>';
                                }
                            }
                        }
                    echo '</form >';
                    echo '</div>';
                    echo '<div class="modal-footer">';
                        echo '<button id="modal_submit_button" model_class="'.$this->model_class.'" table_name="'.$this->table_name.'" type="button" type="submit" class="btn btn-success" onclick="submit_modal(this)">Submit</button>';
                        echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';

        // Edit Modal
        echo '<div class="modal fade" id="'.$identifer.'_edit_record" tabindex="-1" role="dialog">';
            echo '<div class="modal-dialog" role="document">';
                echo '<div class="modal-content">';
                    echo '<div class="modal-header">';
                        echo '<h5 id="'.$identifer.'_modal-title" class="modal-title">Edit Record</h5>';
                        echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                            echo '<span aria-hidden="true">&times;</span>';
                        echo '</button>';
                    echo '</div>';
                    echo '<div class="modal-body">';
                    echo '<div id="'.$identifer.'_modal_edit_success_alert" class="alert alert-success" role="alert">';
                    echo '</div>';
                    echo '<form id="'.$identifer.'_modal_edit_form" method="POST" action="/postadd">';
                    echo '<input type="hidden" id="selected_id" name="selected_id" value="">';
                        if($this->enable_edit)
                        {
                            foreach($this->modal as $column_name => $column_data)
                            {
                                $obj = new $this->model_class();

                                // Display column only if it is a fillable column as specified in its model
                                $fillable_columns = $obj->getFillable();
                                if(in_array($column_name, $fillable_columns))
                                {
                                    echo '<div class="form-group row">';
                                        echo '<label for="input-'.$column_name.'" class="col-sm-3 col-form-label">'.$column_data['header'].'</label>';
                                        echo '<div class="col-sm-9">';
                                            if($column_data['relation']) {
                                                echo '<autocomplete-component css-class="form-control" placeholder="'.$column_data['header'].'" display-column="'.$column_data['displayColumn'].'" name="input-'.$column_name.'" relation="'.$column_data['relation'].'" />';
                                            } else {
                                                echo '<input regex="'.$column_data['regex'].'" type="'.$column_data['type'].'" maxlength="'.$column_data['length'].'" class="form-control" name="input-'.$column_name.'" id="input-'.$column_name.'" placeholder="'.$column_data['header'].'">';
                                            }
                                        echo '</div>';
                                    echo '</div>';
                                }
                            }
                        }
                    echo '</form >';
                    echo '</div>';
                    echo '<div class="modal-footer">';
                        echo '<button id="modal_save_button" model_class="'.$this->model_class.'" table_name="'.$this->table_name.'" type="button" type="submit" class="btn btn-primary" onclick="save_modal(this)">Save</button>';
                        echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';

        echo '<input type="hidden" id="'.$identifer.'-grid_config_array" value="'.htmlspecialchars(json_encode($this->grid_config_array)).'">';
        echo '<div id="'.$identifer.'-crm_grid">';
            echo '<input type="hidden" id="'.$identifer.'-current_page" value="'.$this->data['current_page'].'">';
            echo '<table id="_table" class="table table-bordered table-responsive'.$this->size.'">';
                // Create row for the table name
                echo '<tr class="header_row">';
                    foreach($this->columns as $column_name => $column_data)
                    {
                        echo '<th>'.$column_data['header'].'';
                        if($this->is_sortable)
                        {
                            echo '<i id="'.$identifer.'_'.$column_name.'_'.'sort_button" class="fa fa-fw fa-sort" ';
                            echo 'onclick="sort(this)" table_name="'.$this->table_name.'" model_class="'.$this->model_class.'"></i>';
                        }
                        if($this->enable_filter)
                        {
                            echo '<div class="dropdown">';
                                echo '<i id="'.$identifer.'_'.$column_name.'_'.'filter_button" class="fa fa-filter" data-toggle="dropdown"';
                                echo 'onclick="toggle_filter(this)" table_name="'.$this->table_name.'" model_class="'.$this->model_class.'"></i>';
                                echo '<div class="dropdown-menu" id="'.$identifer.'_'.$column_name.'_dropdown">';
                                    echo '<i class="fa fa-search"></i>';
                                    echo '<input id="'.$identifer.'_'.$column_name.'_search" class="dropdown-item" type="search" placeholder="Search.." onkeyup="filterFunction(this)">';
                                    echo '<hr class="dropdown_row">';
                                    // Get all distinct values for column
                                    $distinct_values = array();
                                    foreach($this->data['data'] as $data)
                                    {
                                        // If value doesnt exist in $distinct_values array, push
                                        if(!in_array($data[$column_name], $distinct_values))
                                        {
                                            array_push($distinct_values, $data[$column_name]);
                                        }
                                    }
                                    foreach($distinct_values as $value)
                                    {
                                        echo '<div class="dropdown-item" name="'.$identifer.'_'.$column_name.'_div">';
                                            echo '<input type="checkbox" name="'.$identifer.'_'.$column_name.'_checkbox" value="'.$value.'" onclick="filterGrid(this)"> ';
                                            echo '<label class="dropdown_label">'.$value.'</label>';
                                        echo '</div>';
                                    }
                                echo '</div>';
                            echo '</div>';
                        }
                        echo '</th>';
                    }
                    if($this->enable_delete)
                    {
                        echo '<th>Actions</th>';
                    }
                echo '</tr>';
                foreach($this->data['data'] as $data)
                {
                    echo '<tr>';
                        foreach($this->columns as $column_name => $column_data)
                        {
                            echo '<td><input class="table_input '.$identifer.'_'.$column_name.'" regex="'.$column_data['regex'].'" type="'.$column_data['type'].'" id ="'.$column_name.'-'.$data['id'].'" model_class="'.$this->model_class.'"';
                            echo 'value="'.$data[$column_name].'" size="'.strlen($data[$column_name]).'" maxlength="'.$column_data['length'].'"';
                            if(!$this->is_editable)
                            {
                                echo 'readonly';
                            }
                            echo '></td>';
                        }
                        if($this->enable_edit || $this->enable_delete)
                        {
                            echo '<td>';

                            // Set button width to 45% or 94%
                            if($this->enable_edit && $this->enable_delete)
                                $action_button_class = "action_button_2";
                            else
                                $action_button_class = "action_button_1";

                            if($this->enable_edit)
                            {
                                    echo '<button id="'.$data['id'].'" table_name="'.$this->table_name.'" model_class="'.$this->model_class.'" onclick="edit_row(this)" type="submit" class="btn btn-primary '.$action_button_class.'">';
                                    echo '<i class="fa fa-edit" aria-hidden="true"></i> ';
                                    echo 'Edit';
                                    echo '</button>';
                            }
                            if($this->enable_delete)
                            {
                                    echo '<button id="'.$data['id'].'" table_name="'.$this->table_name.'" model_class="'.$this->model_class.'" onclick="delete_row(this)" type="submit" class="btn btn-danger '.$action_button_class.'">';
                                    echo '<i class="fa fa-trash-o" aria-hidden="true"></i> ';
                                    echo 'Delete';
                                    echo '</button>';
                            }
                            echo '</td>';
                        }
                    echo '</tr>';
                }
                if($this->enable_add)
                {
                    echo '<tr>';
                        // Colspan set to 45 just to indicate span all columns
                        // it will need to be increased if you hav more than 45 columns...
                        echo '<td colspan="45">';
                            echo '<button id="add" table_name="'.$this->table_name.'" model_class="'.$this->model_class.'" data-toggle="modal" data-target="#'.$identifer.'_add_new_record" type="submit" class="btn btn-success btn-block add_new_record">';
                            echo '<i class="fa fa-plus" aria-hidden="true"></i> ';
                            echo 'Add New Record';
                            echo '</button>';
                        echo '</td>';
                    echo '</tr>';
                }
                echo '<tr>';
                    echo '<td colspan="45">';
                        // Pagination
                        echo '<nav aria-label="Grid pages">';
                            echo '<ul class="pagination justify-content-center">';
                                // If first page disable first
                                $disabled_class = "";
                                if($this->data['current_page'] == 1)
                                    $disabled_class = "disabled";
                                echo '<li id="first" class="page-item '.$disabled_class.'"><a class="page-link" table_name="'.$this->table_name.'" model_class="'.$this->model_class.'" page_no="1" onclick="change_page(this)">First</a></li>';

                                // If first page disable previous
                                $disabled_class = "";
                                if($this->data['current_page'] == 1)
                                    $disabled_class = "disabled";
                                echo '<li id="previous" class="page-item '.$disabled_class.'"><a class="page-link" table_name="'.$this->table_name.'" model_class="'.$this->model_class.'" page_no="previous" onclick="change_page(this)">Previous</a></li>';

                                // Set page links
                                for($count=1; $count<=$this->data['last_page']; $count++)
                                {
                                    $page_item_class = "page-item";
                                    if($count == $this->data['current_page'])
                                        $page_item_class = "page-item active";
                                    echo '<li class="'.$page_item_class.'"><a class="page-link" table_name="'.$this->table_name.'" model_class="'.$this->model_class.'" page_no="'.$count.'" onclick="change_page(this)">'.$count.'</a></li>';
                                }

                                // If current page is last page disable next button
                                $disabled_class = "";
                                if($this->data['current_page'] == $this->data['last_page'])
                                    $disabled_class = "disabled";
                                echo '<li id="next" class="page-item '.$disabled_class.'"><a class="page-link" table_name="'.$this->table_name.'" model_class="'.$this->model_class.'" page_no="next" onclick="change_page(this)">Next</a></li>';

                                // If last page disable last
                                $disabled_class = "";
                                if($this->data['current_page'] == $this->data['last_page'])
                                    $disabled_class = "disabled";
                                echo '<li id="'.$identifer.'_last" class="page-item '.$disabled_class.'"><a class="page-link" table_name="'.$this->table_name.'" model_class="'.$this->model_class.'" page_no="'.$this->data['last_page'].'" onclick="change_page(this)">Last</a></li>';
                            echo '</ul>';
                        echo '</nav>';
                    echo '</td>';
                echo '</tr>';
            echo '</table>';
        echo '</div>';
    }

    /**
     * Return grid html as string
     *
     * @param string $size
     * @return string $html
     */
    public function return_html($model_class, $currentPage)
    {
        // Create unique identifer for each table
        $identifer = str_replace(' ', '', $this->table_name);
        $identifer = strtolower($identifer);

        $html = '<input type="hidden" id="'.$identifer.'-current_page" value="'.$currentPage.'">';
        $html .= '<table id="_table" class="table table-bordered table-responsive'.$this->size.'">';
            // Create row for the table name
            $html .= '<tr class="header_row">';
                foreach($this->columns as $column_name => $column_data)
                {
                    $html .= '<th>'.$column_data['header'].'';
                    if($this->is_sortable)
                    {
                        $html .= '<i id="'.$identifer.'_'.$column_name.'_'.'sort_button" class="fa fa-fw fa-sort" ';
                        $html .= 'onclick="sort(this)" table_name="'.$this->table_name.'" model_class="'.$model_class.'"></i>';
                    }
                    if($this->enable_filter)
                    {
                        $html .= '<div class="dropdown">';
                            $html .= '<i id="'.$identifer.'_'.$column_name.'_'.'filter_button" class="fa fa-filter" data-toggle="dropdown"';
                            $html .= 'onclick="toggle_filter(this)" table_name="'.$this->table_name.'" model_class="'.$model_class.'"></i>';
                            $html .= '<div class="dropdown-menu" id="'.$identifer.'_'.$column_name.'_dropdown">';
                                $html .= '<i class="fa fa-search"></i>';
                                $html .= '<input id="'.$identifer.'_'.$column_name.'_search" class="dropdown-item" type="search" placeholder="Search.." onkeyup="filterFunction(this)">';
                                $html .= '<hr class="dropdown_row">';
                                // Get all distinct values for column
                                $distinct_values = array();
                                foreach($this->data['data'] as $data)
                                {
                                    // If value doesnt exist in $distinct_values array, push
                                    if(!in_array($data[$column_name], $distinct_values))
                                    {
                                        array_push($distinct_values, $data[$column_name]);
                                    }
                                }
                                foreach($distinct_values as $value)
                                {
                                    $html .= '<div class="dropdown-item" name="'.$identifer.'_'.$column_name.'_div">';
                                        $html .= '<input type="checkbox" name="'.$identifer.'_'.$column_name.'_checkbox" value="'.$value.'" onclick="filterGrid(this)"> ';
                                        $html .= '<label class="dropdown_label">'.$value.'</label>';
                                    $html .= '</div>';
                                }
                            $html .= '</div>';
                        $html .= '</div>';
                    }
                    $html .= '</th>';
                }
                if($this->enable_delete)
                {
                    $html .= '<th>Actions</th>';
                }
            $html .= '</tr>';
            foreach($this->data['data'] as $data)
            {
                $html .= '<tr>';
                    foreach($this->columns as $column_name => $column_data)
                    {
                        $html .= '<td><input class="table_input '.$identifer.'_'.$column_name.'" regex="'.$column_data['regex'].'" type="'.$column_data['type'].'" id ="'.$column_name.'-'.$data['id'].'" model_class="'.$model_class.'"';
                        $html .= 'value="'.$data[$column_name].'" size="'.strlen($data[$column_name]).'" maxlength="'.$column_data['length'].'"';
                        if(!$this->is_editable)
                        {
                            $html .= 'readonly';
                        }
                        $html .= '></td>';
                    }
                    if($this->enable_edit || $this->enable_delete)
                    {
                        $html .= '<td>';

                        // Set button width to 45% or 94%
                        if($this->enable_edit && $this->enable_delete)
                            $action_button_class = "action_button_2";
                        else
                            $action_button_class = "action_button_1";

                        if($this->enable_edit)
                        {
                            $html .= '<button id="'.$data['id'].'" table_name="'.$this->table_name.'" model_class="'.$this->model_class.'" onclick="edit_row(this)" type="submit" class="btn btn-primary '.$action_button_class.'">';
                            $html .= '<i class="fa fa-edit" aria-hidden="true"></i> ';
                            $html .= 'Edit';
                            $html .= '</button>';
                        }
                        if($this->enable_delete)
                        {
                            $html .= '<button id="'.$data['id'].'" table_name="'.$this->table_name.'" model_class="'.$this->model_class.'" onclick="delete_row(this)" type="submit" class="btn btn-danger '.$action_button_class.'">';
                            $html .= '<i class="fa fa-trash-o" aria-hidden="true"></i> ';
                            $html .= 'Delete';
                            $html .= '</button>';
                        }
                        $html .= '</td>';
                    }
                $html .= '</tr>';
            }
            if($this->enable_add)
            {
                $html .= '<tr>';
                    // Colspan set to 45 just to indicate span all columns
                    // it will need to be increased if you hav more than 45 columns...
                    $html .= '<td colspan="45">';
                        $html .= '<button id="add" table_name="'.$this->table_name.'" model_class="'.$this->model_class.'" data-toggle="modal" data-target="#'.$identifer.'_add_new_record" type="submit" class="btn btn-success btn-block add_new_record">';
                        $html .= '<i class="fa fa-plus" aria-hidden="true"></i> ';
                        $html .= 'Add New Record';
                        $html .= '</button>';
                    $html .= '</td>';
                $html .= '</tr>';
            }
            $html .= '<tr>';
                $html .= '<td colspan="45">';
                    // Pagination
                    $html .= '<nav aria-label="Grid pages">';
                        $html .= '<ul class="pagination justify-content-center">';
                            // If first page disable first
                            $disabled_class = "";
                            if($currentPage == 1)
                                $disabled_class = "disabled";
                            $html .= '<li id="first" class="page-item '.$disabled_class.'"><a class="page-link" table_name="'.$this->table_name.'" model_class="'.$model_class.'" page_no="1" onclick="change_page(this)">First</a></li>';

                            // If first page disable previous
                            $disabled_class = "";
                            if($currentPage == 1)
                                $disabled_class = "disabled";
                            $html .= '<li id="previous" class="page-item '.$disabled_class.'"><a class="page-link" table_name="'.$this->table_name.'" model_class="'.$model_class.'" page_no="previous" onclick="change_page(this)">Previous</a></li>';

                            // Set page links
                            for($count=1; $count<=$this->data['last_page']; $count++)
                            {
                                $page_item_class = "page-item";
                                if($count == $currentPage)
                                    $page_item_class = "page-item active";
                                $html .= '<li class="'.$page_item_class.'"><a class="page-link" table_name="'.$this->table_name.'" model_class="'.$model_class.'" page_no="'.$count.'" onclick="change_page(this)">'.$count.'</a></li>';
                            }
                            // If current page is last page disable next button
                            $disabled_class = "";
                            if($currentPage == $this->data['last_page'])
                                $disabled_class = "disabled";
                            $html .= '<li id="next" class="page-item '.$disabled_class.'"><a class="page-link" table_name="'.$this->table_name.'" model_class="'.$model_class.'" page_no="next" onclick="change_page(this)">Next</a></li>';

                            // If last page disable last
                            $disabled_class = "";
                            if($currentPage == $this->data['last_page'])
                                $disabled_class = "disabled";
                            $html .= '<li id="'.$identifer.'_last" class="page-item '.$disabled_class.'"><a class="page-link" table_name="'.$this->table_name.'" model_class="'.$model_class.'" page_no="'.$this->data['last_page'].'" onclick="change_page(this)">Last</a></li>';
                        $html .= '</ul>';
                    $html .= '</nav>';
                $html .= '</td>';
            $html .= '</tr>';
        $html .= '</table>';
        return $html;
    }

    /**
     * If true table contents editable
     *
     * @param bool $is_editable
     */
    public function is_editable(bool $is_editable = false)
    {
        $this->is_editable = $is_editable;
    }

    /**
     * Enable row deletion
     *
     * @param bool $enable_delete
     */
    public function enable_delete(bool $enable_delete = false)
    {
        $this->enable_delete = $enable_delete;
    }

    /**
     * Enable column sorting
     *
     * @param bool $is_sortable
     */
    public function is_sortable(bool $is_sortable = false)
    {
        $this->is_sortable = $is_sortable;
    }

    /**
     * Set table size, accepts -sm|-md|-lg|-xl
     *
     * @param string $size
     */
    public function set_size(string $size = '-sm')
    {
        if($size == '-sm')
        {
            $this->size = '-sm';
        }
        else if($size == '-md')
        {
            $this->size = '-md';
        }
        else if($size == '-lg')
        {
            $this->size = '-lg';
        }
        else if($size == '-xl')
        {
            $this->size = '-xl';
        }
    }

    /**
     * Set table pagination size
     *
     * @param int $paginate
     */
    public function enable_paginate($paginate = false)
    {
        $this->paginate = $paginate;
    }

    /**
     * Enable column filtering
     *
     * @param bool $enable_filter
     */
    public function enable_filter(bool $enable_filter = false)
    {
        $this->enable_filter = $enable_filter;
    }

    /**
     * Enable row addition through modal
     *
     * @param mixed $enable_add
     */
    public function enable_add($enable_add = false)
    {
        $this->enable_add = $enable_add;
    }

    /**
     * Enable row editing through modal
     *
     * @param mixed $enable_add
     */
    public function enable_edit($enable_edit = false)
    {
        $this->enable_edit =  $enable_edit;
    }

    /**
     * Set model constraint
     *
     * @param mixed $constraint
     */
    public function set_constraint($constraint = false)
    {
        $this->constraint = $constraint;
    }

    /**
     * Show created at
     *
     * @param bool $show_created_at
     */
    public function set_show_created_at($show_created_at = true)
    {
        $this->show_created_at = $show_created_at;
    }

    /**
     * Show updated at
     *
     * @param bool $show_updated_at
     */
    public function set_show_updated_at($show_updated_at = true)
    {
        $this->show_updated_at = $show_updated_at;
    }

    /**
     * Paginate and return model
     *
     * @param string $model_class
     * @param string $currentPage
     *
     * @return LengthAwarePaginator $model
     */
    public function paginate($model_class, $currentPage = 0)
    {
        if($this->paginate)
        {
            if($this->constraint)
            {
                $constraint = $this->constraint;

                //Set current page
                Paginator::currentPageResolver(function () use ($currentPage) {
                    return $currentPage;
                });

                $model = $model_class::where($constraint[0],$constraint[1],$constraint[2])->paginate($this->paginate);
            }
            else
            {
                //Set current page
                Paginator::currentPageResolver(function () use ($currentPage) {
                    return $currentPage;
                });
                $model = $model_class::paginate($this->paginate);
            }
        }
        else
        {
            // If pagination not set, show all records in one page
            $total_rows = count($model_class::all()->toArray());
            if($this->constraint)
            {
                $constraint = $this->constraint;
                $model = $model_class::where($constraint[0],$constraint[1],$constraint[2])->paginate($total_rows);
            }
            else
            {
                $model = $model_class::paginate($total_rows);
            }
        }
        return $model;
    }

    /**
     * Set current page data
     *
     * @param string $model
     * @param string $currentPage
     *
     */
    public function change_page($model_class, $currentPage = 0)
    {
        // Paginate and set current page
        $this->data = $this->paginate($model_class, $currentPage)->toArray();
    }

    /**
     * Add record to model
     * Set current page data
     *
     * @param string $model_class
     * @param string $inputs
     * @param string $currentPage
     */
    public function add($model_class, $inputs, $currentPage)
    {
        // Create object from dynamic class name
        $obj = new $model_class;

        foreach($inputs as $input_name => $input_data)
        {
            // Ignore _token
            if(strpos($input_name, "input-") !== false)
            {
                $exploded_value = explode('-', $input_name);
                $column_name = $exploded_value[1];

                // Add data to object
                $obj[$column_name] = $input_data;
            }
        }

        // Save data
        $obj->save();

        $this->change_page($model_class, $currentPage);

        return $obj->id;
    }

    /**
     * Update record in model
     * Set current page data
     *
     * @param string $model_class
     * @param string $inputs
     * @param string $currentPage
     */
    public function update($model_class, $inputs, $currentPage)
    {
        // Create object from dynamic class name
        $obj = new $model_class;

        // Get model object for record
        foreach($inputs as $input_name => $input_data)
        {
            // Get specified record
            if(strpos($input_name, "selected_id") !== false)
                $obj = $obj::find($input_data);
        }

        foreach($inputs as $input_name => $input_data)
        {
             // Ignore _token and selected_id
             if(strpos($input_name, "input-") !== false)
             {
                 $exploded_value = explode('-', $input_name);
                 $column_name = $exploded_value[1];

                 // Add data to object
                 $obj[$column_name] = $input_data;
             }
        }

        // Save data
        $obj->save();

        $this->change_page($model_class, $currentPage);
    }

    /**
     * Delete record from model
     * Set current page data
     *
     * @param string $model_class
     * @param string $id
     * @param string $currentPage
     */
    public function destroy($model_class, $id, $currentPage)
    {
        // Create object from dynamic class name
        $obj = new $model_class;

        // Use object's static methods
        $model = $obj::find($id);
        $model->delete();

        $this->change_page($model_class, $currentPage);
    }

    /**
     * Sort model and set new data
     *
     * @param string $model_class
     * @param string $column_name
     * @param string $type
     * @param string $currentPage
     */
    public function sort($model_class, $column_name, $type, $currentPage)
    {
        // Do this only is pagination is disabled
        // Paginate before sort to only sort on current page
        $model = $this->paginate($model_class, $currentPage);

        if($type == 'ASC')
            $model = $model->sortBy($column_name);
        else if($type == 'DESC')
            $model = $model->sortByDesc($column_name);
        $this->data['data'] = $model;

        //CHANGE SORT
        //IF PAGINATION DISABLED sort on $this->data['data']
    }

    // TODO: FOR return html use passed in model class
    /**
     * Return current model class table name
     *
     * @return string
     */
    private function get_table()
    {
        $obj = new $this->model_class;
        return $obj->getTable();
    }

    // TODO: make this work with empty model
    private function get_default_grid_config_array($model) {
        $temp_model = $model::all()->toArray();
        $temp_array = array_keys($temp_model[0]);
        $default_columns = array();

        foreach($temp_array as $column_name) {
            $default_columns[$column_name]['header'] = $column_name;
        }

        return array(
            'column_configs' => $default_columns,
            'table_config' => array(
                'is_editable' => true,
                'enable_delete' => true,
                'is_sortable' => true,
                'set_size' => '-sm',
                'paginate' => 5,
                'enable_filter' => true,
                'enable_add' => true,[0]
            )
        );
    }

    private function set_table_config ($grid_config_array) {
        if(isset($grid_config_array['table_config']['is_editable']))
            $this->is_editable($grid_config_array['table_config']['is_editable']);

        if(isset($grid_config_array['table_config']['enable_delete']))
            $this->enable_delete($grid_config_array['table_config']['enable_delete']);

        if(isset($grid_config_array['table_config']['is_sortable']))
            $this->is_sortable($grid_config_array['table_config']['is_sortable']);

        if(isset($grid_config_array['table_config']['set_size']))
            $this->set_size($grid_config_array['table_config']['set_size']);

        if(isset($grid_config_array['table_config']['paginate']))
            $this->enable_paginate($grid_config_array['table_config']['paginate']);

        if(isset($grid_config_array['table_config']['enable_filter']))
            $this->enable_filter($grid_config_array['table_config']['enable_filter']);

        if(isset($grid_config_array['table_config']['enable_add']))
            $this->enable_add($grid_config_array['table_config']['enable_add']);

        if(isset($grid_config_array['table_config']['enable_edit']))
            $this->enable_edit($grid_config_array['table_config']['enable_edit']);

        if(isset($grid_config_array['table_config']['constraint']))
            $this->set_constraint($grid_config_array['table_config']['constraint']);

        if(isset($grid_config_array['table_config']['show_created_at']))
            $this->set_show_created_at($grid_config_array['table_config']['show_created_at']);

        if(isset($grid_config_array['table_config']['show_updated_at']))
            $this->set_show_updated_at($grid_config_array['table_config']['show_updated_at']);
    }

    private function set_modal_config($config, $model_columns) {
        foreach($model_columns as $column_name)
        {
            // Get column header from enable_add array/column_configs
            // or use column name from table
            $this->modal[$column_name]['header'] = $config[$column_name]['header']
                ?? $this->columns[$column_name]['header']
                ?? $column_name;

            // Get column type from enable_add array/column_configs
            // or use text
            $this->modal[$column_name]['type'] = $config[$column_name]['type']
                ?? $this->columns[$column_name]['type']
                ?? 'text';

            // Get column length from enable_add array/column_configs
            // or set length to 10
            $this->modal[$column_name]['length'] = $config[$column_name]['length']
                ?? $this->columns[$column_name]['length']
                ?? 10;

            // Get column regex from enable_add array/column_configs
            // or set null
            $this->modal[$column_name]['regex'] = $config[$column_name]['regex']
                ?? $this->columns[$column_name]['regex']
                ?? null;

            // get relation for foreign keys
            $this->modal[$column_name]['relation'] = $config[$column_name]['relation']
                ?? $this->columns[$column_name]['relation']
                ?? null;

            // get column to be displayed for relations
            $this->modal[$column_name]['displayColumn'] = $config[$column_name]['displayColumn']
                ?? $this->columns[$column_name]['displayColumn']
                ?? 'id';
        }
    }
}
