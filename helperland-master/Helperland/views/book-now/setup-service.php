<div class="setup_service">
    <div class="form_group">
        <label class="label" for="">Enter your Postal Code</label>
        <input class="input" type="text" placeholder="Postal Code" name="setup_service_postal_code">
        <div class="validation_message d_none">
            <p>Please Enter Postal Code!</p>
        </div>
    </div>
    <div class="form_group">
        <label for="">Temp Label</label>
        <button id="setup_service_submit_btn" class="book_service_btn">Check Availability</button>
    </div>
</div>


<!-- **********BOOK-SERVICE-S1-SCRIPTS********** -->
<script>
    <?php if(session('userRole')==1){ ?>
        if(store.loggedUserAddress){
            if(store.loggedUserAddress.PostalCode!==null){
                $('[name="setup_service_postal_code"]').val(store.loggedUserAddress.PostalCode);
            }
        }
        if(store.loggedUserDetails.Mobile!==null){
            $('[name="add_address_phone"]').val(store.loggedUserDetails.Mobile);
        }
    <?php } ?>


    $('#setup_service_submit_btn').click(function(){

        let validation = setup_service_postal_code_validation();
        
        if(validation){
            const postalCode = $('[name="setup_service_postal_code"]').val();

            let json = JSON.stringify({postalCode});

            $.ajax({
                url :  `${BASE_URL}/book-service/check-postal-code`,
                method : 'POST',
                contentType : 'application/json',
                data : json,
                success : function(res){
                    if(res!=="" && res!==undefined){
                        try{
                            const result = JSON.parse(res);
                            // STORE POSTAL CODE...
                            store.bookService.postalCode = parseInt(postalCode);
                            change_book_service_tabs(1);
                        }
                        catch(e){
                            Swal.fire({
                                title : 'Invalid JSON Response!',
                                icon : 'error'
                            });
                        }
                    }
                }
            });
        }
    });    
</script>

<script>
    // ON CHANGE POSTAL CODE STORE IN SERVICE REQUEST OBJECT...
    $('[name="setup_service_postal_code"]').focusout(function(){
        const postalCode = $('[name="setup_service_postal_code"]').val();
        store.bookService.postalCode = parseInt(postalCode);
    });
</script>