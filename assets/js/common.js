
jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteUser", function(){
		var userId = $(this).data("userid"),
			hitURL = baseURL + "deleteUser",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this user ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { userId : userId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("User successfully deleted"); }
				else if(data.status = false) { alert("User deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});	
	jQuery(document).on("click", ".searchList", function(){
	});
});

jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteVendor", function(){
		var vendorId = $(this).data("vendorid"),
			hitURL = baseURL + "deleteVendor",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this vendor ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { vendorId : vendorId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Vendor successfully deleted"); }
				else if(data.status = false) { alert("Vendor deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	jQuery(document).on("click", ".searchList", function(){
	});	
});


jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteRole", function(){
		var roleId = $(this).data("roleid"),
			hitURL = baseURL + "deleteRole",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this Role ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { roleId : roleId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Role successfully deleted"); }
				else if(data.status = false) { alert("Role deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	jQuery(document).on("click", ".searchList", function(){
	});	
});

//  DELETE WAREHOUSE FROM LIST
jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteWarehouse", function(){
		var warehouseId = $(this).data("warehouseid"),
			hitURL = baseURL + "deleteWarehouse",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this Warehouse ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { warehouseId : warehouseId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Warehouse successfully deleted"); }
				else if(data.status = false) { alert("Warehouse deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	jQuery(document).on("click", ".searchList", function(){
	});	
});

//  DELETE PINCODE FROM LIST
jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deletePincode", function(){
		var pincodeId = $(this).data("pincodeid"),
			hitURL = baseURL + "deletePincode",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this Pincode ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { pincodeId : pincodeId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Pincode successfully deleted"); }
				else if(data.status = false) { alert("Pincode deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	jQuery(document).on("click", ".searchList", function(){
	});	
});

//  DELETE API INTEGRATION 
jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteAPI", function(){
		var api_id = $(this).data("api_id"),
			hitURL = baseURL + "deleteAPI",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this API ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { api_id : api_id } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("API successfully deleted"); }
				else if(data.status = false) { alert("API deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	jQuery(document).on("click", ".searchList", function(){
	});	
});

