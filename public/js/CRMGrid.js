function change_page(element)
{
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    var model_class = element.getAttribute('model_class');
    var table_name = element.getAttribute('table_name');

    var identifer = table_name.replace(/\s/g, "");
    identifer = identifer.toLowerCase();
    var current_page = document.getElementById(identifer+'-current_page').value;
    var grid_config_array = document.getElementById(identifer+'-grid_config_array').value;

    var page_no = element.getAttribute('page_no');

    // If selected page is current page, ignore
    if(page_no == current_page)
        return;

    // If next or previous clicked
    if(page_no == 'next')
        page_no = parseInt(current_page) + 1;
    if(page_no == 'previous')
        page_no = parseInt(current_page) - 1;

    var data = JSON.stringify({_token:csrf_token, table_name:table_name, model_class:model_class, grid_config_array:grid_config_array , page_no:page_no});
    var grid_html;
    $.ajax({
        method: 'POST',
        url: '/change_page',
        data: data,
        dataType: 'JSON',
        contentType: "application/json; charset=utf-8",
        async: true, 
        complete: function(data) {
            grid_html = data['responseText'];
            document.getElementById(identifer+"-crm_grid").innerHTML = grid_html;
            attach_events();
        }
    });
}

function edit_row(element, id){
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    var model_class = element.getAttribute('model_class');
    var table_name = element.getAttribute('table_name');
    var element_id = element.id;

    // If id passed as parameter use it to _modal_edit_form inputs
    if (id !== undefined){
        element_id = id;
    } 

    var identifer = table_name.replace(/\s/g, "");
    identifer = identifer.toLowerCase();

    var data = JSON.stringify({_token:csrf_token, model_class:model_class, id:element_id});
    $.ajax({
        method: 'POST',
        url: '/get_details',
        data: data,
        dataType: 'JSON',
        contentType: "application/json; charset=utf-8",
        async: true, 
        complete: function(data) {
            responseJSON = data['responseJSON'];
            // For each column in response
            for (var key in responseJSON){  

                // Set and validate input values
                var validation_success = true;
                var failed_input;
                $('#'+identifer+'_modal_edit_form > div > div > input').each(function()
                {
                    // If input for column exists set value
                    if(this.id == "input-"+key)
                        this.value = responseJSON[key];
                    
                    var regex = this.getAttribute('regex');

                    if(validate(this, regex)){
                        this.style.backgroundColor = '';
                    }      
                    else{
                        validation_success = false;
                        failed_input = this;
                    }
                });

                if(validation_success == false){
                    failed_input.style.backgroundColor = '#ffa4a4';
                }                             
            }
            //TODO: maybe add back button here if id is set to go back to add modal?

            // If _add_new_record modal is open, close it first
            if(id !== undefined){
                // Create event _add_new_record modal 
                // to only show _edit_record modal when _add_new_record is fully hidden
                $('#'+identifer+'_add_new_record').on('hidden.bs.modal', function(){
                    // Show edit modal
                    $('#'+identifer+'_edit_record').modal('show');

                    // Remove event 
                    $('#'+identifer+'_add_new_record').off('hidden.bs.modal');
                });

                $('#'+identifer+'_add_new_record').modal('hide');
            }
            else{
                 $('#'+identifer+'_edit_record').modal('show');
            }
            // Store id in _modal_edit_form
            $('#selected_id').val(element_id);
        }
    });
}

function delete_row(element){
    // Delete confirmation
    if(confirm('Are you sure you want to delete this record?'))
    {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var model_class = element.getAttribute('model_class');
        var table_name = element.getAttribute('table_name');

        var identifer = table_name.replace(/\s/g, "");
        identifer = identifer.toLowerCase();
        var current_page = document.getElementById(identifer+'-current_page').value;
        var grid_config_array = document.getElementById(identifer+'-grid_config_array').value;

        var data = JSON.stringify({_token:csrf_token, current_page:current_page, table_name:table_name, model_class:model_class, grid_config_array:grid_config_array ,id:element.id});
        var grid_html;
        $.ajax({
            method: 'POST',
            url: '/delete',
            data: data,
            dataType: 'JSON',
            contentType: "application/json; charset=utf-8",
            async: true, 
            complete: function(data) {
                grid_html = data['responseText'];
                document.getElementById(identifer+"-crm_grid").innerHTML = grid_html;
                attach_events();
            }
        });
    }
    else
    {
        return false;
    }
}

function sort(element){
    var id = element.getAttribute("id");
    var class_name = element.getAttribute("class");
    
    $('.fa fa-fw').removeClass().addClass('fa fa-fw fa-sort');

    var type;
    if(class_name =='fa fa-fw fa-sort'){
        element.setAttribute("class", "fa fa-fw fa-sort-asc");
        type = "ASC";
    }
    else if(class_name =='fa fa-fw fa-sort-asc'){
        element.setAttribute("class", "fa fa-fw fa-sort-desc");
        type = "DESC";
    }
    else {
        element.setAttribute("class", "fa fa-fw fa-sort-asc");
        type = "ASC";
    }

    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    var model_class = element.getAttribute('model_class');
    var table_name = element.getAttribute('table_name');

    var identifer = table_name.replace(/\s/g, "");
    identifer = identifer.toLowerCase();
    var current_page = document.getElementById(identifer+'-current_page').value;
    var grid_config_array = document.getElementById(identifer+'-grid_config_array').value;

    var data = JSON.stringify({_token:csrf_token, current_page:current_page, table_name:table_name, model_class:model_class, grid_config_array:grid_config_array, id:element.id, type:type});
    $.ajax({
        method: 'POST',
        url: '/postsort',
        data: data,
        dataType: 'JSON',
        contentType: "application/json; charset=utf-8",
        complete: function(data) {
            grid_html = data['responseText'];
            document.getElementById(identifer+"-crm_grid").innerHTML = grid_html;
            attach_events();
            if(type == "ASC"){
                document.getElementById(id).setAttribute("class", "fa fa-fw fa-sort-asc");
            }
            else{
                document.getElementById(id).setAttribute("class", "fa fa-fw fa-sort-desc");
            }
        }
    });
}

function toggle_filter(element){
    // Generate id based on filter selected
    var table_name = element.getAttribute('table_name');

    var identifer = table_name.replace(/\s/g, "");
    identifer = identifer.toLowerCase();

    var split_array = element.id.split('_');
    var column_name = split_array[1];

    // Use id to toggle specified filter
    $('#'+identifer+'_'+column_name+'_filter_dropdown').toggle();
}

function filterFunction(element){
    // Generate id based on filter selected
    var split_array = element.id.split('_');
    var table_name = split_array[0];
    var column_name = split_array[1];

    // Filter the checkbox list in the dropdown
    var input, filter, checkbox, i;
    input = document.getElementById(""+table_name+"_"+column_name+"_search");
    filter = input.value.toUpperCase();
    checkbox = document.getElementsByName(""+table_name+"_"+column_name+"_checkbox");
    div = document.getElementsByName(""+table_name+"_"+column_name+"_div");
    for (i = 0; i < checkbox.length; i++) {
        txtValue = checkbox[i].value;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            div[i].style.display = "inline-block";
        } else {
            div[i].style.display = "none";
        }
    }
}

function filterGrid(element){
    // Generate id based on filter selected
    var split_array = element.name.split('_');
    var table_name = split_array[0];
    var column_name = split_array[1];
    checkbox = document.getElementsByName(""+table_name+"_"+column_name+"_checkbox");

    // Build get checked values
    var checked_values = [];
    for (i = 0; i < checkbox.length; i++) {
        if(checkbox[i].checked == true)
            checked_values.push(checkbox[i].value.replace(/\s/g, ""));
    }
    
    // Sort Grid
    if(checked_values.length != 0){
        $(".table_input").filter(function(){
            var parent_tr = $(this).parent().parent();
            var input_split_array = ($(this).attr('id')).split('-');
            var input_column_name = input_split_array[0];
            var input_value = $(this).val();

            // Strip whitespace for better comparison
            input_value = input_value.replace(/\s/g, "");

            // use input_column_name to check if input is for selected filter column
            if(input_column_name == column_name){
                if(checked_values.indexOf(input_value) != -1){
                    parent_tr.show();
                }
                else{
                    parent_tr.hide();
                }
            }
        });
    }
    else{
        $(".table_input").filter(function(){
            parent_tr = $(this).parent().parent();
            $(parent_tr).show();
        });
    }
}

// Modal submit button function
function submit_modal(element){
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    var model_class = element.getAttribute('model_class');
    var table_name = element.getAttribute('table_name');

    var identifer = table_name.replace(/\s/g, "");
    identifer = identifer.toLowerCase();
    var current_page = document.getElementById(identifer+'-current_page').value;
    var grid_config_array = document.getElementById(identifer+'-grid_config_array').value;

    // Create object with form data
    var data = new Object();

    var validation_success = true;
    var failed_input;
    $('#'+identifer+'_modal_form > div > div > input').each(function()
    {
        var regex = this.getAttribute('regex');

        if(validate(this, regex)){
            data[this.name] = this.value;
            this.style.backgroundColor = '';
        }      
        else{
            validation_success = false;
            failed_input = this;
        }
    });

    if(validation_success == false){
        failed_input.style.backgroundColor = '#ffa4a4';
        return false;
    }

    data['_token'] = csrf_token;
    data['table_name'] = table_name;
    data['model_class'] = model_class;
    data['current_page'] = current_page;
    data['grid_config_array'] = grid_config_array;

    data = JSON.stringify(data);
    
    $.ajax({
        method: 'POST',
        url: '/postadd',
        data: data,
        dataType: 'JSON',
        contentType: "application/json; charset=utf-8",
        async: true, 
        complete: function(data) {
            grid_html = data['responseJSON']['return_html'];
            document.getElementById(identifer+"-crm_grid").innerHTML = grid_html;
            attach_events();
            $('#'+identifer+'_modal_success_alert').html(
                'New record successfully added! ' +
                '<a id="'+identifer+'_modal_alert_view" href="javascript:void(0);" class="alert-link">'+
                    'View'+
                '</a>/'+
                '<a id="'+identifer+'_modal_alert_edit" href="javascript:void(0);" class="alert-link">'+
                    'Edit'+
                '</a>'
            );

            $('#'+identifer+'_modal_success_alert').show();
            $('#'+identifer+'_modal_form > div > div > input').each(function()
            {
                $(this).val("");
            });

            // Add click event for alert view link
            $("#"+identifer+"_modal_alert_view").click(function(element) {
                element.preventDefault(); 

                var last_children = document.getElementById(""+identifer+"_last").children;
                var last_a = last_children[0];

                change_page( last_a );  
                $('#'+identifer+'_add_new_record').modal('hide');
            });

            // Add click event for alert edit link
            submit_modal_element = element;
            $("#"+identifer+"_modal_alert_edit").click(function(element) {
                element.preventDefault(); 

                var new_id = data['responseJSON']['new_id'];
                edit_row( submit_modal_element, new_id );
            });
        }
    });
}

// Modal save button function
function save_modal(element){
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    var model_class = element.getAttribute('model_class');
    var table_name = element.getAttribute('table_name');

    var identifer = table_name.replace(/\s/g, "");
    identifer = identifer.toLowerCase();
    var current_page = document.getElementById(identifer+'-current_page').value;
    var grid_config_array = document.getElementById(identifer+'-grid_config_array').value;

    // Create object with form data
    var data = new Object();

    data['selected_id'] = $('#selected_id').val();
    var validation_success = true;
    var failed_input;
    $('#'+identifer+'_modal_edit_form > div > div > input').each(function()
    {
        var regex = this.getAttribute('regex');

        if(validate(this, regex)){
            data[this.name] = this.value;
            this.style.backgroundColor = '';
        }      
        else{
            validation_success = false;
            failed_input = this;
        }
    });

    if(validation_success == false){
        failed_input.style.backgroundColor = '#ffa4a4';
        return false;
    }

    data['_token'] = csrf_token;
    data['table_name'] = table_name;
    data['model_class'] = model_class;
    data['current_page'] = current_page;
    data['grid_config_array'] = grid_config_array;

    data = JSON.stringify(data);

    $.ajax({
        method: 'POST',
        url: '/posteditrow',
        data: data,
        dataType: 'JSON',
        contentType: "application/json; charset=utf-8",
        async: true, 
        complete: function(data) {
            grid_html = data['responseText'];
            document.getElementById(identifer+"-crm_grid").innerHTML = grid_html;
            attach_events();

            $('#'+identifer+'_modal_edit_success_alert').html('Record successfully Edited!');

            $('#'+identifer+'_modal_edit_success_alert').show();
        }
    });
}

// Save edits in table to database
// TODO: change to attach function to input onclick
// TODO: refresh combo box values to match new edit
$(document).ready(function()
{
    // Hide success alerts 
    var modal_alerts_to_hide = document.querySelectorAll("[id*='_success_alert']")
    for (count = 0; count < modal_alerts_to_hide.length; count++)
        modal_alerts_to_hide[count].style.display = "none";

    attach_events();
});

function attach_events(){
    // Store inital background color to reset to
    var field_background_color; 

    $('.table_input').on('input',function(element){
        var regex = element.target.getAttribute('regex');
        if(validate(element.target, regex)){
            // Set field background color - light green
            element.target.style.backgroundColor = "#caffa5";

            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            var model_class = element.target.getAttribute('model_class');
            var data = JSON.stringify({_token:csrf_token, model_class:model_class, key:element.target.id, value:element.target.value});
            $.ajax({
                method: 'POST',
                url: '/postedit',
                data: data,
                dataType: 'JSON',
                contentType: "application/json; charset=utf-8"
            });
        }
        else{
            // Set field background color - light red
            element.target.style.backgroundColor = "#ffa4a4";
        }
    });

    // Events to reset table_input color on blur
    $('.table_input').on("focus",function(element){
        field_background_color = element.target.style.backgroundColor;
    });
    $('.table_input').on("blur",function(element){
        element.target.style.backgroundColor = field_background_color;
    });
}

/**
 * Validates given field against a given regex string
 * 
 * @param object field
 * @param string regex
 * 
 * @return boolean
 */
function validate(field, regex){
    // Check if regex is set
    if(regex == null || regex == ""){    
        return true;
    }
    else{
        // Create regex pattern from string
        regex = new RegExp(regex);

        if (regex.test(field.value) == false) {
            return false;
        }
        else{
            return true;
        }
    }
}

