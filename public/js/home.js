$(document).ready(function(){
    set_hover_hide_siblings("#column2", "#extra_options_1", "#extra_options_2");
    set_hover_hide_siblings("#column3");
    set_hover_hide_siblings("#column5");
});

function set_hover_hide_siblings(element_id, element_options_1, element_options_2){
    $(element_id).find("a, img, div").mouseover(function(){
        $(element_id).siblings().css("opacity","0.4");
        $(element_options_1).css("display","inline");
        $(element_options_2).css("display","inline");
    });
    $(element_id).find("a, img, div").mouseleave(function(){
        $(element_id).siblings().css("opacity","1");
        $(element_options_1).css("display","none");
        $(element_options_2).css("display","none");
    });
}