<!-- **********LOGIN********** -->
<div class="model">
    <!-- MODEL_CLOSE -->
    <button class="model_close_btn">&times;</button>
    <!-- LOGIN -->
    <div class="popup_main d_none" id="login_popup">
        <p class="popup_title">Login</p>
        <form class="login_popup_form">
            <div class="form_group">
                <div class="input_icon">
                    <input class="input" type="text" placeholder="Email" name="login_email" value="<?= cookie('email'); ?>">
                    <label for=""><i class="fas fa-user"></i></label>
                </div>
                <div class="validation_message d_none">
                    <p>Validation Message!!!</p>
                </div>
            </div>
            <div class="form_group">
                <div class="input_icon">
                    <input class="input" type="password" placeholder="Password" name="login_password" value="<?= cookie('password'); ?>">
                    <label for=""><i class="fas fa-lock"></i></label>
                </div>
                <div class="validation_message d_none">
                    <p>Validation Message!!!</p>
                </div>
            </div>
            <div>
                <input type="checkbox" name="remember" value="true">
                <label class="label" for="">Remember Me</label>
            </div>
            <div>
                <button class="popup_btn">Login</button>
            </div>
        </form>
        <div class="login_popup_footer">
            <a href="javascript:void(0)" onclick="open_model('forgot_password')">Forgot Password?</a>
            <p>Don't Have an Account? <a href="<?= url('/customer/signup') ?>">Create an Account</a></p>
        </div><!-- END_LOGIN_POPUP_FOOTER -->
    </div><!-- END_LOGIN_POPUP -->
</div>

<!-- **********LOGIN-POPUP-SCRIPTS********** -->
<script>

    $('.login_popup_form').submit((e)=>{

        e.preventDefault();
    
        let validation = true;

        const validationArr = [login_password_validation(),
                                login_email_validation()];

        for(let i=0; i<validationArr.length; i++){
            if(validationArr[i]==false){
                validation = false;
                break;
            }	
        }

        let json = JSON.stringify({
            email : $('[name="login_email"]').val(),
            password : $('[name="login_password"]').val(),
            remember : $('[name="remember"]').prop('checked')? true : false
        })

        if(validation){
            $.ajax({
                url : `${BASE_URL}/login`,
                method : 'POST',
                contentType : 'application/json',
                data : json,
                success : function(res){
                    if(res!=="" && res!==undefined){
                        try{
                            const result = JSON.parse(res);
                            $('.login_popup_form').trigger('reset');
                            switch(result.role){
                                case 1:
                                    window.location.replace(`${BASE_URL}/customer/dashboard`);
                                    break;
                                case 2:
                                    window.location.replace(`${BASE_URL}/service-provider/dashboard`);
                                    break;
                                case 3:
                                    window.location.replace(`${BASE_URL}/admin/dashboard`);
                                    break;
                            }
                        }
                        catch(e){
                            console.log('Invalid Json Response!');
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