<!-- **********EDIT_ADDRESS********** -->
<div class="model">
    <!-- MODEL_CLOSE -->
    <button class="model_close_btn">&times;</button>
    <!-- EDIT_ADDRESS -->
    <form class="popup_main d_none" id="edit_address_popup">
        <p class="popup_title">Edit Address</p>
        <div class="form_group">
            <label class="label" for="">Steet Name</label>
            <input class="input" type="text" name="edit_address_street_name">
            <div class="validation_message d_none">
                <p>Enter Stree name!</p>
            </div>
        </div>	
        <div class="form_group">
            <label class="label" for="">House Number</label>
            <input class="input" type="text" name="edit_address_house_number">
            <div class="validation_message d_none">
                <p>Enter Stree name!</p>
            </div>
        </div>
        <div class="form_group">
            <label class="label" for="">Postal Code</label>
            <input class="input" type="text" name="edit_address_postal_code">
            <div class="validation_message d_none">
                <p>Enter Stree name!</p>
            </div>
        </div>
        <div class="form_group">
            <label class="label" for="">City</label>
            <input class="input" type="text" name="edit_address_city">
            <div class="validation_message d_none">
                <p>Enter Stree name!</p>
            </div>
        </div>
        <div class="form_group">
            <label class="label" for="">Phone Number</label>
            <div class="phone_number">
                <label for="">+49</label>
                <input type="text" name="edit_address_phone">
            </div>
            <div class="validation_message d_none">
                <p>Enter Stree name!</p>
            </div>
        </div>
        <button class="popup_btn">Edit</button>
    </form>
</div>

<!-- **********EDIT ADDRESS SCRIPT********** -->
<script>
    $('#edit_address_popup').submit((e)=>{
        e.preventDefault();
        let validation = true;

        const validationArr = [edit_address_phone_validation(),
                               edit_address_street_name_validation(),
                               edit_address_house_number_validation(),
                               edit_address_city_validation(),
                               edit_address_postal_code_validation()];

        for(let i =0; i<validationArr.length; i++){
            if(validationArr[i]==false){
                validation = false;
                break;
            }
        }

        if(validation){
            let json = JSON.stringify({
                streetName : $('[name="edit_address_street_name"]').val(),
                houseNumber : $('[name="edit_address_house_number"]').val(),
                phone : $('[name="edit_address_phone"]').val(),
                city : $('[name="edit_address_city"]').val(),
                postalCode : $('[name="edit_address_postal_code"]').val(),
            });

            $.ajax({
                url : `${BASE_URL}/user/address/${store.id.edit}`,
                method : 'PATCH',
                contentType : 'application/json',
                data : json,
                success : function(res){
                    if(res!=="" && res!==undefined){
                        try{
                            const result = JSON.parse(res);
                            Swal.fire({
                                title : result.message,
                                icon : 'success'
                            });
                            customer_my_address();
                            $('#edit_address_popup').trigger('reset');
                            close_model();
                        }
                        catch(e){
                            Swal.fire({
                                title : 'Invalid JSON Response!',
                                icon : 'error'
                            })
                        }
                    }
                }
            });
        }
    });
</script>