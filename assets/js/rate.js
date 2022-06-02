
$(document).ready(function(){
	
	var addRateForm = $("#addRate");
	
	var validator = addRateForm.validate({
		
		rules:{
			dest_pincode : { required : true, digits : true, minlength: 6},
			origin_pincode : { required : true, digits : true, minlength: 6},
            pkg_type : { required : true, selected : true},
            del_speed : { required : true, selected : true},
            weight : { required : true, digits : true},
            pay_mode : { required : true, selected : true}
            
		},
		messages:{
			dest_pincode : { required : "Destination Pinode Required", digits : "Please Enter Valid Destination Pincode" , minlength: "Enter Valid Destination Pincode", },
            origin_pincode : { required : "Origin Pinode Required", digits : "Please Enter Valid Origin Pincode" , minlength: "Enter Valid Destination Pincode", },
            pkg_type : { required : "This field is required", selected : "Package Type is Missing" },
            del_speed : { required : "This field is required", selected : "Delivery Speed is Missing" },
            weight : { required : "Weight is Missing", digits : "Please enter numbers only" },
            pay_mode : { required : "This field is required", selected : "Please Select Payment Mode" }
		}
	});
});
