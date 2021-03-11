$(document).ready(function(){

var user_href;
var user_href_splitted;
var user_id;
var image_src;
var image_href_splitted;
var image_name;
var photo_id;




$(".modal_thumbnails").click(function(){

$("#set_user_image").prop('disabled', false);

user_href = $("#user-id").prop('href');
user_href_splitted = user_href.split("=");
user_id = user_href_splitted[user_href_splitted.length -1];

image_src = $(this).prop("src");
image_href_splitted = image_src.split("/");
image_name = image_href_splitted[image_href_splitted.length -1];

photo_id = $(this).attr("data");

$.ajax({
	url: "includes/ajax_code.php",
	data:{photo_id:photo_id},
	type: "POST",
	success:function(data){
		if(!data.error) {
			$("#modal_sidebar").html(data);
			
		}
	}
});
	




});


$("#set_user_image").click(function(){

	$.ajax({

		url: "includes/ajax_code.php",
		data:{image_name: image_name, user_id: user_id},
		type: "POST",
		success:function(data){

			if(!data.error) {

				$(".user_image_box a img").prop('src', data);

				// location.reload(true);
			}
		}

	});

});



/****** Edit Photo Sidebar ****************/

$(".info-box-header").click(function(){


	$(".inside").slideToggle("fast");

	$("#toggle").toggleClass("glyphicon glyphicon-menu-down glyphicon, glyphicon glyphicon-menu-up");

});


/*********  Delete Function  ********/

$(".delete_link").click(function(){

	return confirm("Are you sure you want to delete this item?");  // confirm() - builin funkcija za potvrdu

});


/************ Current Page Active Highlight ***************/
$(document).ready(function() {
$("[href]").each(function() {
    if (this.href == window.location.href) {
        $(this).addClass("active");
        }
    });
});

/******  Input file syling (showing value of image input fild in register form)   ********/
$(".new-button").click(function(e) {
	$("#image_upload").click();

});

$("#image_upload").change(function() {
	var value = $(this).val(),
		path = value.split("\\"),
		file = path[path.length-1];
$(".image_name").html(file);
$(".image_name").html(file).style.padding = '10px 15px';		
});





tinymce.init({selector:'textarea'});


});





