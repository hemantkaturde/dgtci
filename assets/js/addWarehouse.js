
 $(document).ready(function(){
	
	var addUserForm = $("#addWarehouse");
	
	var validator = addUserForm.validate({
		
		rules:{
			fname :{ required : true },
			email : { required : true, email : true, remote : { url : baseURL + "warehouseCheckEmailExists", type :"post"} },
			password : { required : true },
			cpassword : {required : true, equalTo: "#password"},
			mobile : { required : true, digits : true },
			role : { required : true, selected : true},
			vendor : { required : true, selected : true},
			pincode : { required : true, selected : true}
		},
		messages:{
			fname :{ required : "This field is required"},
			email : { required : "This field is required", email : "Please enter valid email address", remote : "Email already taken" },
			password : { required : "This field is required"},
			cpassword : {required : "This field is required", equalTo: "Please enter same password" },
			mobile : { required : "This field is required", digits : "Please enter numbers only" },
			role : { required : "This field is required", selected : "Please select atleast one option" },
			vendor : { required : "This field is required", selected : "Please select atleast one option" },
			pincode : { required : "Invalid Pincode", digits : "Please enter numbers only" }
		}
	});
});
