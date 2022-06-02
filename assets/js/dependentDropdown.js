
/************  GET STATE DATA *************/

function getStateDataperCountry()
{
    var country_id = ($('#country').val());
    var path = baseURL + 'getStateData/' + country_id;
    $.ajax({
        type : 'POST',
        url : path,
        dataType : 'json',
        success : function(response)
        {
            var data = "";
            data += '<select type="text" class="form-control state" data-live-search="true" id="state" name="state" placeholder="Maharashtra">';
            data += '<option value="0">Select State</option>';
                $.each(response['state'], function(index, value){
                    data += '<option value="'+value['state_id']+'">'+value['state_title'].toUpperCase()+'</option>';
                });
            data += '</select>';
            $('#state').html(data);
        },
        error : function(response)
        {
            console.log(response);
        }

    });
}
// =========================
function getReturnStateDataperCountry()
{
    var country_id = ($('#return_country').val());
    var path = baseURL + 'getStateData/' + country_id;
    $.ajax({
        type : 'POST',
        url : path,
        dataType : 'json',
        success : function(response)
        {
            var data = "";
            data += '<select type="text" class="form-control " id="return_state" name="return_state" placeholder="Maharashtra">';
            data += '<option value="0">Select State</option>';
                $.each(response['state'], function(index, value){
                    data += '<option value="'+value['state_id']+'">'+value['state_title'].toUpperCase()+'</option>';
                });
            data += '</select>';
            $('#return_state').html(data);
        },
        error : function(response)
        {
            console.log(response);
        }

    });
}
/************  GET CITY DATA *************/
function getDistrictDataperState()
{
    var state_id = $('#state').val();
    var path = baseURL + 'getDistrictData/' + state_id;
    $.ajax({
        type : 'POST',
        url : path,
        dataType : 'json',
        success : function(response)
        {
            var data = "";
            data += '<select type="text" class="form-control " id="district" name="district" placeholder="Maharashtra">';
            data += '<option value="0">Select District</option>';
                $.each(response['dist'], function(index, value){
                    data += '<option value="'+value['districtid']+'">'+value['district_title'].toUpperCase()+'</option>';
                });
            data += '</select>';
            $('#district').html(data);
        },
        error : function(response)
        {
            console.log(response);
        }
    });
}
// ==========
function getReturnDistrictDataperState()
{
    var state_id = $('#return_state').val();
    var path = baseURL + 'getDistrictData/' + state_id;
    $.ajax({
        type : 'POST',
        url : path,
        dataType : 'json',
        success : function(response)
        {
            var data = "";
            data += '<select type="text" class="form-control " id="return_district" name="return_district" placeholder="Maharashtra">';
            data += '<option value="0">Select District</option>';
                $.each(response['dist'], function(index, value){
                    data += '<option value="'+value['districtid']+'">'+value['district_title'].toUpperCase()+'</option>';
                });
            data += '</select>';
            $('#return_district').html(data);
        },
        error : function(response)
        {
            console.log(response);
        }
    });
}
    /************  GET CITY DATA *************/
function getCityData()
{
    var state_id = $('#state').val();
    var dist_id = $('#district').val();
    var path = baseURL + 'getCityData/' + state_id + '/' + dist_id;
    $.ajax({
        type : 'POST',
        url : path,
        dataType : 'json',
        success : function(response)
        {
            var data = "";
            data += '<select type="text" class="form-control " id="city" name="city" placeholder="Maharashtra">';
            data += '<option value="0">Select City</option>';
                $.each(response['city'], function(index, value){
                    data += '<option value="'+value['id']+'">'+value['name'].toUpperCase()+'</option>';
                });
            data += '</select>';
            $('#city').html(data);
        },
        error : function(response)
        {
            console.log(response);
        }
    });
}

// ================================
function getReturnCityDataperState()
{
    var state_id = $('#return_state').val();
    var dist_id = $('#return_district').val();
    var path = baseURL + 'getCityData/' + state_id + '/' + dist_id;
    $.ajax({
        type : 'POST',
        url : path,
        dataType : 'json',
        success : function(response)
        {
            var data = "";
            data += '<select type="text" class="form-control " id="return_city" name="return_city" placeholder="Maharashtra">';
            data += '<option value="0">Select City</option>';
                $.each(response['city'], function(index, value){
                    data += '<option value="'+value['id']+'">'+value['name'].toUpperCase()+'</option>';
                });
            data += '</select>';
            $('#return_city').html(data);
        },
        error : function(response)
        {
            console.log(response);
        }
    });
}


/*This function is used to fetch pickup Location data*/
function getPickupdetails(){
    var pickup_address =  $('#pickup_address').val();
    var path = baseURL + 'getPickupdetails/' + pickup_address;

    if(pickup_address){
            $.ajax({
                type : 'POST',
                url : path,
                dataType : 'json',
                success : function(response)
                {
                    $('#pickup_detail_address').val(response.pickupAddress[0].address);
                    $('#pickup_country').val(response.pickupAddress[0].country_name);
                    $('#pickup_state').val(response.pickupAddress[0].state_title);
                    $('#pickup_district').val(response.pickupAddress[0].district_title);
                    $('#pickup_city').val(response.pickupAddress[0].name);
                    $('#pickup_pincode').val(response.pickupAddress[0].pincode);
                    $('#pickup_email').val(response.pickupAddress[0].contact_email);
                    $('#pickup_contact_no').val(response.pickupAddress[0].contact_no);

                },
                error : function(response)
                {
                    console.log(response);
                }
            });
      }else{

            $('#pickup_detail_address').val('');
            $('#pickup_country').val('');
            $('#pickup_state').val('');
            $('#pickup_district').val('');
            $('#pickup_city').val('');
            $('#pickup_pincode').val('');
            $('#pickup_email').val('');
            $('#pickup_contact_no').val('');
      }

}


/*This function is used to calculate total order value data*/

 function calculateTotalorderValue(){

    var order_value =  $('#order_value').val();
    var tax_percentage_value =  $('#tax_percentage_value').val();

    if(order_value && tax_percentage_value){
        $('#total_order_value').val(order_value+tax_percentage_value);
    }


}

