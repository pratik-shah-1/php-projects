<!-- **********FORGOT_PASSWORD********** -->
<div class="model">
    <!-- MODEL_CLOSE -->
    <button class="model_close_btn">&times;</button>
    <!-- FORGOT_PASSOWORD -->
    <div class="popup_main d_none" id="forgot_password_popup">
        <p class="popup_title">Forgot Password</p>
        <form class="forgot_password_popup_form" action="">
            <div class="form_group">
                <input class="input" type="text" placeholder="Email" name="forgot_password_email">
                <div class="validation_message d_none">
                    <p>Validation Message!!!</p>
                </div>
            </div>
            <button class="popup_btn" name="forgot_password_btn">Send</button>
            <a href="javascript:void(0)" onclick="open_model('login')">Login Now</a>
        </form>
    </div>
</div>

<!-- **********FORGOT-PASSWORD-SCRIPTS********** -->
<script>

    $('.forgot_password_popup_form').submit((e)=>{

        e.preventDefault();
        // DISABLE SEND BUTTON...
        $('[name="forgot_password_btn"]').prop('disabled', true);

        let validation = forgot_password_email_validation();

        if(validation){
            const email = $('[name="forgot_password_email"]').val();
            // STORE EMAIL GLOBALLY...
            store.email = email;
            const json = JSON.stringify({email});
            $.ajax({
                url : `${BASE_URL}/forgot-password`,
                method : 'POST',
                contentType : 'application/json',
                data : json,
                success : function(res){
                    if(res!==undefined && res!==""){
                        try{
                            const result = JSON.parse(res);
                            Swal.fire({
                                title : `${result.otp}`,
                                text : result.message,
                                icon : 'info'
                            }).then((res)=>{
                                $('[name="forgot_password_btn"]').prop('disabled', false);
                                if(res.isConfirmed){
                                    $('.forgot_password_popup_form').trigger('reset');
                                    close_model();
                                    open_model('otp');
                                }
                            });
                        }   
                        catch(e){
                            $('[name="forgot_password_btn"]').prop('disabled', false);
                            console.log('Invalid JSON Response!!!');
                            Swal.fire({
                                title : 'Server Error',
                                text : 'Invalid JSON Response!!!',
                                icon : 'error'
                            });
                        }                 
                    }
                }
            });
        }
        else{
            $('[name="forgot_password_btn"]').prop('disabled', false);
        }
    });
</script>