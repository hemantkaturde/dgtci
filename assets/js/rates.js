   $('#addRates').modal({backdrop: 'static', keyboard: false})


$(function(){
$(document).on("click", "#saverates", function(e) {
e.preventDefault();
    let check = 1;
    
    if($("#weight").val() == "" || $("#weight").val() == 0)
    {
        $("#weight").css({'border-color':'red'});
        check = 0;
    }
    else
    {
        $("#weight").css({'border-color':'green'});
    }

    if($("#a").val() == "" || $("#a").val() == 0)
    {
        $("#a").css({'border-color':'red'});
        check = 0;
    }
    else
    {
        $("#a").css({'border-color':'green'});
    }

    if($("#c").val() == "" || $("#c").val() == 0)
    {
        $("#c").css({'border-color':'red'});
        check = 0;
    }
    else
    {
        $("#c").css({'border-color':'green'});
    }

    if($("#e").val() == "" || $("#e").val() == 0)
    {
        $("#e").css({'border-color':'red'});
        check = 0;
    }
    else
    {
        $("#e").css({'border-color':'green'});
    }

    if($("#b").val() == "" || $("#b").val() == 0)
    {
        $("#b").css({'border-color':'red'});
        check = 0;
    }
    else
    {
        $("#b").css({'border-color':'green'});
    }

    if($("#d").val() == "" || $("#d").val() == 0)
    {
        $("#d").css({'border-color':'red'});
        check = 0;
    }
    else
    {
        $("#d").css({'border-color':'green'});
    }

    if(check == 0)
    {
        $("body, html").animate({'scrollTop':0},1000);
    }
    else
    {
        var data = $("#form").serialize(); 
        var clientid = $('#userid').val();
        $("#saverates").prop('disabled', true);
        $.ajax({
            type: "POST",
            url: baseURL + "addRates",
            data: { data : data,clientid:clientid } ,
            success: function(result){
                  $("#form")[0].reset();
                  $('#weight').val('');
                  $('#a').val('');
                 // $("#form").reset();
                  //$('#notification').html(result); 
                  window.location.href =baseURL +"<?php echo 'uploadRates/';?>" + clientid;

            }
        });
        e.preventDefault();
    }
    });

});

    //  DELETE API INTEGRATION 
jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteRates", function(){
		var id = $(this).data("id"),
			hitURL = baseURL + "deleteRates",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete Rate ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : id } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Rate successfully deleted"); }
				else if(data.status = false) { alert("Rate deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	jQuery(document).on("click", ".searchList", function(){
	});	
});

$(function(){
$(document).on("click", "#updaterates", function(e) {
e.preventDefault();
    let check = 1;
    
    if($("#weight1").val() == "" || $("#weight1").val() == 0)
    {
        $("#weight1").css({'border-color':'red'});
        check = 0;
    }
    else
    {
        $("#weight1").css({'border-color':'green'});
    }

    if($("#a1").val() == "" || $("#a1").val() == 0)
    {
        $("#a1").css({'border-color':'red'});
        check = 0;
    }
    else
    {
        $("#a1").css({'border-color':'green'});
    }

    if($("#c1").val() == "" || $("#c1").val() == 0)
    {
        $("#c1").css({'border-color':'red'});
        check = 0;
    }
    else
    {
        $("#c1").css({'border-color':'green'});
    }

    if($("#e1").val() == "" || $("#e1").val() == 0)
    {
        $("#e1").css({'border-color':'red'});
        check = 0;
    }
    else
    {
        $("#e1").css({'border-color':'green'});
    }

    if($("#b1").val() == "" || $("#b1").val() == 0)
    {
        $("#b1").css({'border-color':'red'});
        check = 0;
    }
    else
    {
        $("#b1").css({'border-color':'green'});
    }

    if($("#d1").val() == "" || $("#d1").val() == 0)
    {
        $("#d1").css({'border-color':'red'});
        check = 0;
    }
    else
    {
        $("#d1").css({'border-color':'green'});
    }

    if(check == 0)
    {
        $("body, html").animate({'scrollTop':0},1000);
    }
    else
    {
        var data = $("#updateform").serialize(); 
        var clientid1 = $('#userid1').val();
        // console.log(data);
        $("#updaterates").prop('disabled', true);
        $.ajax({
            type: "POST",
            url: baseURL + "updateRates",
            data: { data : data,clientid1:clientid1 } ,
            success: function(result){

                  window.location.href =baseURL +"<?php echo 'uploadRates/';?>" + clientid1;

            }
        });
        e.preventDefault();
    }
    });

});

