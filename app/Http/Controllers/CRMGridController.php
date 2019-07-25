<?php

namespace WinstarCRM\Http\Controllers;

use Illuminate\Http\Request;
use WinstarCRM\Helpers\CRMGrid;
use Illuminate\Pagination\Paginator;

class CRMGridController extends Controller
{
     /**
     * Change grid page
     *
     * @param Request $request
     * @return string html
     */
    public function change_page(Request $request)
    {
        // create object from dynamic class name
        $model_class = $request->model_class;
        $obj = new $model_class;

        // Convert json back to array
        $grid_config_array = json_decode($request->grid_config_array, true);

        // Rebuild grid html to show new page
        $newgrid = new CRMGrid($request->model_class, $request->table_name, $grid_config_array);

        // Change page
        $newgrid->change_page($request->model_class, $request->page_no);

        return $newgrid->return_html($request->model_class, $request->page_no);
    }

    /**
     * Add new record to storage
     * 
     * @param Request $request
     * @return string html
     */
    public function add(Request $request)
    {
        // Get array of request inputs
        $inputs = $request->all();

        // Convert json back to array
        $grid_config_array = json_decode($request->grid_config_array, true);

        // Rebuild table html to show add
        $newgrid = new CRMGrid($request->model_class, $request->table_name, $grid_config_array);
        
        // Add data
        $new_id = $newgrid->add($request->model_class, $inputs, $request->current_page);   

        $json_array = json_encode(array(
            'return_html' => $newgrid->return_html($request->model_class, $request->current_page),
            'new_id' => $new_id
        ));

        return $json_array;
    }

    /**
     * Edit the specified record column value
     *
     * @param Request $request
     */
    public function edit(Request $request)
    {   
        // Create object from dynamic class name
        $model_class = $request->model_class;
        $obj = new $model_class;

        // Get the id for the record and column name.
        $exploded_value = explode('-', $request->key);
        $column = $exploded_value[0];
        $id = $exploded_value[1];

        // Updated the record based on id and column name.
        $model = $obj::find($id);   
        $model[$column] = $request->value;
        $model->save();
    }

    /**
     * Edit the specified record
     *
     * @param Request $request
     */
    public function edit_row(Request $request)
    {
        // Get array of request inputs
        $inputs = $request->all();

        // Convert json back to array
        $grid_config_array = json_decode($request->grid_config_array, true);

        // Rebuild table html to show add
        $newgrid = new CRMGrid($request->model_class, $request->table_name, $grid_config_array);

        $newgrid->update($request->model_class, $inputs, $request->current_page);   

        return $newgrid->return_html($request->model_class, $request->current_page);
    }

    /**
     * Remove the specified record from storage
     * and rebuild the table
     * 
     * @param Request $request
     * @return string html
     */
    public function delete(Request $request)
    {   
        // Convert json back to array
        $grid_config_array = json_decode($request->grid_config_array, true);

         // Rebuild table html to show delete
        $newgrid = new CRMGrid($request->model_class, $request->table_name, $grid_config_array);

        // Delete data
        $newgrid->destroy($request->model_class, $request->id, $request->current_page);
        return $newgrid->return_html($request->model_class, $request->current_page);
    }

    /**
     * Sort according to specified column
     * and rebuild the table
     * 
     * @param Request $request
     * @return string html
     */
    public function sort(Request $request)
    {
        // Create object from dynamic class name
        $model_class = $request->model_class;
        $obj = new $model_class;

        // Get the column name.
        $exploded_value = explode('_', $request->id);
        $column_name = $exploded_value[1];

        // Convert json back to array
        $grid_config_array = json_decode($request->grid_config_array, true);

        // Rebuild table html to show sort
        $newgrid = new CRMGrid($obj, $request->table_name, $grid_config_array);

        // Sort data
        $newgrid->sort($model_class, $column_name, $request->type, $request->current_page);
        return $newgrid->return_html($model_class, $request->current_page);
    }

     /**
     * Get and return all details of record using provided id
     * 
     * @param Request $request
     * @return string html
     */
    public function get_details(Request $request)
    {
        // Create object from dynamic class name
        $model_class = $request->model_class;
        $obj = new $model_class;

        $model = $obj::find($request->id);
        
        $json = json_encode($model);

        return $json;
    }
}
