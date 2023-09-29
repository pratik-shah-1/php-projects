<!-- **********ADD_ADDRESS********** -->
<div class="model">
    <!-- MODEL_CLOSE -->
    <button class="model_close_btn">&times;</button>
    <!-- EDIT_ADDRESS -->
    <form class="popup_main d_none" id="add_address_popup">
        <p class="popup_title">Add Address</p>
        <div class="form_group">
            <label class="label" for="">Steet Name</label>
            <input class="input" type="text" name="add_address_street_name">
            <div class="validation_message d_none">
                <p>Enter Stree name!</p>
            </div>
        </div>
        <div class="form_group">
            <label class="label" for="">House Number</label>
            <input class="input" type="text" name="add_address_house_number">
            <div class="validation_message d_none">
                <p>Enter Stree name!</p>
            </div>
        </div>
        <div class="form_group">
            <label class="label" for="">Postal Code</label>
            <input class="input" type="text" name="add_address_postal_code">
            <div class="validation_message d_none">
                <p>Enter Stree name!</p>
            </div>
        </div>
        <div class="form_group">
            <label class="label" for="">City</label>
            <input class="input" type="text" name="add_address_city">
            <div class="validation_message d_none">
                <p>Enter Stree name!</p>
            </div>
        </div>
        <div class="form_group">
            <label class="label" for="">Phone Number</label>
            <div class="phone_number" >
                <label for="">+49</label>
                <input type="text" name="add_address_phone">
            </div>
            <div class="validation_message d_none">
                <p>Enter Stree name!</p>
            </div>
        </div>
        <button class="popup_btn">Add</button>
    </form>
</div>

<!-- **********ADD ADDRESS SCRIPT********** -->
<script>

    $('[name="add_address_phone"]').focus(()=>{
        $('[name="add_address_phone"]').val(store.loggedUserDetails.Mobile);
    });

    $('[name="add_address_postal_code"]').focus(()=>{
        $('[name="add_address_postal_code"]').val(store.loggedUserAddress.PostalCode);
    })

    $('#add_address_popup').submit((e)=>{
        e.preventDefault();
        let validation = true;

        const validationArr = [add_address_phone_validation(),
                               add_address_street_name_validation(),
                               add_address_house_number_validation(),
                               add_address_city_validation(),
                               add_address_postal_code_validation()];

        for(let i =0; i<validationArr.length; i++){
            if(validationArr[i]==false){
                validation = false;
                break;
            }
        }

        let json = JSON.stringify({
            streetName : $('[name="add_address_street_name"]').val(),
            houseNumber : $('[name="add_address_house_number"]').val(),
            postalCode :  $('[name="add_address_postal_code"]').val(),
            city :  $('[name="add_address_city"]').val(),
            phone : $('[name="add_address_phone"]').val()
        });

        if(validation){
            $.ajax({
                url : `${BASE_URL}/user/address`,
                method : 'POST',
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
                            $('#add_address_popup').trigger('reset');
                            close_model();
                            customer_my_address();
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