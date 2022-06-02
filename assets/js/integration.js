//  API Integration Already Exist
$(document).ready(function(){
	
	var addAPIForm = $("#addAPI");
	
	var validator = addAPIForm.validate({
		
		rules:{
			url :{ required : true },
			key : { required : true, title : true },
			vendor : { required : true, selected : true, remote : { url : baseURL + "api_CheckEmailExists", type :"post"}}
		},
		messages:{
			url :{ required : "This field is required"},
			key : { required : "This field is required", title : "Please enter valid title", },
			vendor : { required : "This field is required", selected : "Please select atleast one option", remote : "Vendor already Exist"  }
		}
	});
});

//  EMAIL SETTING ALREADY EXIST
 $(document).ready(function(){
	
	var addEmailIntegrationForm = $("#addEmailSetting");
	
	var validator = addEmailIntegrationForm.validate({
		
		rules:{
			username :{ required : true },
			title : { required : true, title : true, remote : { url : baseURL + "emailTitleCheckEmailExists", type :"post"} },
			vendor : { required : true, selected : true}
		},
		messages:{
			username :{ required : "This field is required"},
			title : { required : "This field is required", title : "Please enter valid email title", remote : "Title already Exist" },
			vendor : { required : "This field is required", selected : "Please select atleast one option" }
		}
	});
});


// DELETE EMAIL SETTING
jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteEmail", function(){
		var emailId = $(this).data("emailId"),
			hitURL = baseURL + "deleteEmailRecord",
			currentRow = $(this);
		var confirmation = confirm("Are you sure to delete this Email Setting ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { emailId : emailId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Email Setting successfully deleted"); }
				else if(data.status = false) { alert("Email Setting deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	jQuery(document).on("click", ".searchList", function(){
	});	
});