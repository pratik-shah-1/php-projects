<!-- **********OTP********** -->
<div class="model">
    <!-- MODEL_CLOSE -->
    <button class="model_close_btn">&times;</button>
	<!-- POPUP-MAIN -->
	<div class="popup_main d_none" id="otp_popup">
		<p class="popup_title">OTP</p>
		<form class="otp_popup_form">
			<div class="form_group">
				<input class="input" type="text" placeholder="OTP" name="otp">				
                <div class="validation_message d_none">
                    <p>Validation Message!!!</p>
                </div>
			</div>
			<button class="popup_btn">SUBMIT</button>
		</form>
	</div>
</div>

<!-- **********OTP-SCRIPTS********** -->
<script>

    $('.otp_popup_form').submit((e)=>{

        e.preventDefault();

        let validation = otp_validation();

        if(validation){

            const json = JSON.stringify({
                otp:parseInt($('[name="otp"]').val()),
                email:store.email
            });

            $.ajax({
                url : `${BASE_URL}/verify-otp`,
                method : 'POST',
                contentType : 'application/json',
                data : json,
                success : function(res){
                    if(res!==undefined && res!==""){
                        try{
                            const result = JSON.parse(res);
                            $('.otp_popup_form').trigger('reset');
                            close_model();
                            open_model('set_new_password');
                        }
                        catch(e){
                            console.log('Invalid JSON Response!!!');
                            Swal.fire({
                                title : 'SERVER ERROR',
                                text : 'Invalid JSON Response!!!',
                                icon : 'error'
                            });
                        }
                    }
                }
            });
        }
    });
</script>