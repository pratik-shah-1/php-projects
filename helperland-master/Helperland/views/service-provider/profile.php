<div class="profile">
    <div class="tab_container">
        <div class="tab_indicator profile_tabs">
            <button class="tab_btn active_profile_tab"><div><img src="<?= assets('assets/img/profile/Details.png'); ?>"></div><span>My Details</span></button>
            <button class="tab_btn "><div><img src="<?= assets('assets/img/profile/Password.png'); ?>" alt=""></div><span>Change Password</span></button>
        </div>
        <div class="tab_body">

            <!-- **********MY-DETAILS--TAB********** -->
            <div class="tab_content">
                <div class="sp_my_details">
                    <p class="sp_account_status">Account Status : <span id="userStatus">Active</span></p>
                    <!-- BASIC DETAILS -->
                    <div class="sp_basic_details_container">
                        <!-- TITLE -->
                        <div class="sp_basic_details_title_avatar">
                            <p>Basic Details</p>
                            <div><img class="avatar" src="<?= assets('assets/img/avatar/car.png'); ?>" alt=""></div>
                        </div>
                        <div class="form_group">
                            <label class="label" for="">First Name</label>
                            <input class="input" type="text" name="firstname">
                            <div class="validation_message d_none">
                                <p>Validation Message!!!</p>
                            </div>
                        </div>
                        <div class="form_group">
                            <label class="label" for="">Last Name</label>
                            <input class="input" type="text" name="lastname">
                            <div class="validation_message d_none">
                                <p>Validation Message!!!</p>
                            </div>
                        </div>
                        <div class="form_group">
                            <label class="label" for="">Email Address</label>
                            <input class="input" type="text" name="email" readonly>
                            <div class="validation_message d_none">
                                <p>Validation Message!!!</p>
                            </div>
                        </div>
                        <div class="label_phone_number form_group">
                            <label class="label" for="">Phone Number</label>
                            <div class="phone_number">
                                <label for="">+49</label>
                                <input type="text" name="phone">
                            </div>
                            <div class="validation_message d_none">
                                <p>Validation Message!!!</p>
                            </div>
                        </div>
                        <div class="label_input">
                            <label class="label" for="">Date of Birth</label>
                            <input class="input" type="date" name="dob">
                            <div class="validation_message d_none">
                                <p>Validaton Message!!!</p>
                            </div>
                        </div>
                        <div class="label_select">
                            <label class="label" for="">Language</label>
                            <select class="select" name="language">
                                <option value="1">English</option>
                                <option value="2">Hindi</option>
                            </select>
                        </div>
                        <!-- GENDER -->
                        <div class="gender_div">
                            <!-- MALE -->
                            <div>
                                <input type="radio" id="male" name="gender" value="1">
                                <label for="male">Male</label>
                            </div>
                            <!-- FEMALE -->
                            <div>
                                <input type="radio" id="female" name="gender" value="2">
                                <label for="female">Female</label>
                            </div>
                            <!-- NOT SAY -->
                            <div>
                                <input type="radio" id="no_gender" name="gender" value="0" checked>
                                <label for="no_gender">Rather Not to say</label>
                            </div>
                        </div>
                        <!-- SELECT AVATAR -->
                        <div class="select_avatar_container">
                            <p>Select Avatar</p>
                            <div>
                                <div>
                                    <input type="radio" name="avatar" value="car" id="avatar_car" checked>
                                    <label for="avatar_car"><img src="<?= assets('assets/img/avatar/car.png'); ?>" alt=""></label>
                                </div>
                                <div>
                                    <input type="radio" name="avatar" value="female" id="avatar_female">
                                    <label for="avatar_female"><img src="<?= assets('assets/img/avatar/female.png'); ?>" alt=""></label>
                                </div>
                                <div>
                                    <input type="radio" name="avatar" value="hat" id="avatar_hat">
                                    <label for="avatar_hat"><img src="<?= assets('assets/img/avatar/hat.png'); ?>" alt=""></label>
                                </div>
                                <div>
                                    <input type="radio" name="avatar" value="iron" id="avatar_iron">
                                    <label for="avatar_iron"><img src="<?= assets('assets/img/avatar/iron.png'); ?>" alt=""></label>
                                </div>
                                <div>
                                    <input type="radio" name="avatar" value="male" id="avatar_male">
                                    <label for="avatar_male"><img src="<?= assets('assets/img/avatar/male.png'); ?>" alt=""></label>
                                </div>
                                <div>
                                    <input type="radio" name="avatar" value="ship" id="avatar_ship">
                                    <label for="avatar_ship"><img src="<?= assets('assets/img/avatar/ship.png'); ?>" alt=""></label>
                                </div>
                            </div>
                        </div>
                    </div><!-- END BASIC DETAILS CONTAINER -->
                    <!-- MY ADDRESS -->
                    <div class="sp_my_address_container">
                        <div>
                            <p>My Address</p>
                        </div>
                        <div class="form_group">
                            <label class="label" for="">Street Name</label>
                            <input class="input" type="text" name="street_name">
                            <div class="validation_message d_none">
                                <p>Validation Message!!!</p>
                            </div>
                        </div>
                        <div class="form_group">
                            <label class="label" for="">House Number</label>
                            <input class="input" type="text" name="house_number">
                            <div class="validation_message d_none">
                                <p>Validation Message!!!</p>
                            </div>
                        </div>
                        <div class="form_group">
                            <label class="label" for="">Postal Code</label>
                            <input class="input" type="text" name="postal_code">
                            <div class="validation_message d_none">
                                <p>Validation Message!!!</p>
                            </div>
                        </div>
                        <div class="form_group">
                            <label class="label" for="">City</label>
                            <input class="input" type="text" name="city">
                            <div class="validation_message d_none">
                                <p>Validation Message!!!</p>
                            </div>
                        </div>
                    </div><!-- END BASIC DETAILS CONTAINER -->
                    <input type="hidden" name="sp_address_id" value="">
                    <button class="profile_save_btn"  onclick="update_sp_profile_details()">Save</button>
                </div><!-- END SP MY DETAILS -->
            </div><!-- END TAB CONTENT -->

            <!-- **********CHANGE-PASSWORD--TAB********** -->
            <div class="tab_content d_none">
                <form class="change_password" id="change_password">
                    <div class="form_group">
                        <label class="label" for="">Old Password</label>
                        <input class="input" type="password" placeholder="Current Password" name="change_password_old">
                        <div class="validation_message d_none">
                            <p>Validation Message!!!</p>
                        </div>
                    </div>
                    <div class="form_group">
                        <label class="label" for="">New Password</label>
                        <input class="input" type="password" placeholder="Password" name="change_password_new">                                            
                        <div class="validation_message d_none">
                            <p>Validation Message!!!</p>
                        </div>
                    </div>
                    <div class="form_group">
                        <label class="label" for="">Confirm Password</label>
                        <input class="input" type="password" placeholder="Confirm Password" name="change_password_confirm">
                        <div class="validation_message d_none">
                            <p>Validation Message!!!</p>
                        </div>
                    </div>
                    <button class="profile_save_btn">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- **********SP-PROFILE-SCRIPTS********** -->
<script>
    // LOAD SERVICE PROVIDER DETAILS...
    function sp_my_details(){
        $.ajax({
            url : `${BASE_URL}/user/details`,
            method : 'GET',
            success : function(res){
                if(res!=="" && res!==undefined){
                    const result = JSON.parse(res);
                    // SET SERVICE PROVIDER DETAILS...
                    switch(result.IsActive){
                        case 0:
                            $('#userStatus').text('NoActive').css({color:'red'});
                            break;
                        case 1:
                            $('#userStatus').text('Active');
                            break;
                        default:
                            $('#userStatus').text('NoActive').css({color:'red'});
                    }                    
                    $('[name="firstname"]').val(result.FirstName);
                    $('[name="lastname"]').val(result.LastName);
                    $('[name="email"]').val(result.Email);
                    $('[name="phone"]').val(result.Mobile);
                    $('[name="language"]').val(result.LanguageId);
                    $('[name="dob"]').val(result.DateOfBirth);
                    $(`[name="gender"][value="${result.Gender}"]`).prop('checked', true);
                    $(`[name="avatar"][value="${result.UserProfilePicture}"]`).prop('checked', true);
                    $('.avatar').attr('src', `${BASE_URL}/assets/img/avatar/${result.UserProfilePicture}.png`);
                }
            }
        })
    }
    sp_my_details();

    function sp_my_address(){
        $.ajax({
            url : `${BASE_URL}/user/address`,
            method : 'GET',
            success : function(res){
                if(res!=="" && res!==undefined){
                    let result = JSON.parse(res);
                    result = result[0];
                    // SET SERVICE PROVIDER DETAILS...
                    $('[name="sp_address_id"]').val(result.AddressId);
                    $('[name="street_name"]').val(result.AddressLine1);
                    $('[name="house_number"]').val(result.AddressLine2);
                    $('[name="postal_code"]').val(result.PostalCode);
                    $('[name="city"]').val(result.City);
                }
            }
        });
    }
    sp_my_address();
</script>

<!-- **********UPDATE-SP-PROFILE-DETIALS********** -->
<script>
    function update_sp_profile_details(){

        let validation = true;

        const validationArr = [firstname_validation(),
                               lastname_validation(),
                               email_validation(),
                               phone_validation(),
                               dob_validation(),
                               street_name_validation(),
                               house_number_validation(),
                               postal_code_validation(),
                               city_validation()];

        for(let i=0; i<validationArr.length; i++){
            if(validationArr[i]==false){
                validation = false;
                break;
            }
        }

        if(validation){
            update_sp_details();
        }

        /*
            NOTE
            update_sp_address() WILL CALL INSIDE update_sp_details()
        */

        // UPDATE SP-DETAILS....
        function update_sp_details(){
            let json = JSON.stringify({
                firstName : $('[name="firstname"]').val(),
                lastName : $('[name="lastname"]').val(),
                email : $('[name="email"]').val(),
                phone : $('[name="phone"]').val(),
                dateOfBirth : $('[name="dob"]').val(),
                language : parseInt($('[name="language"]').val()),
                gender : $('[name="gender"]:checked').val(),
                avatar : $('[name="avatar"]:checked').val(),
            });

            $.ajax({
                url : `${BASE_URL}/user/details`,
                method : 'PATCH',
                contentType : 'application/json',
                data : json,
                success : function(res){
                    if(res!=="" && res!==undefined){
                        try{
                            const result = JSON.parse(res);
                            console.log(result.message);
                            update_sp_address();
                        }
                        catch(e){
                            Swal.fire({
                                title : 'Invalid JSON Response!',
                                icon : 'error',
                            });
                        }
                    }
                }
            });            
        }

        // UPDATE SP-ADDRESS....
        function update_sp_address(){
            // BY DEFAULT WE ADD THE ADDRESS...
            let url = `${BASE_URL}/user/address`;
            let method = 'POST';
            let json = JSON.stringify({
                phone : $('[name="phone"]').val(),
                streetName : $('[name="street_name"]').val(),
                houseNumber : $('[name="house_number"]').val(),
                postalCode : $('[name="postal_code"]').val(),
                city : $('[name="city"]').val(),
            });

            // IF ADDRESS AVAILABE THEN UPDATE...
            if($('[name="sp_address_id"]').val()!==""){
                let id = $('[name="sp_address_id"]').val();
                url = `${BASE_URL}/user/address/${id}`;
                method = 'PATCH';
            }

            $.ajax({
                url : url,
                method : method,
                contentType : 'application/json',
                data : json,
                success : function(res){
                    if(res!=="" && res!==undefined){
                        try{
                            const result = JSON.parse(res);
                            console.log(result.message);
                            Swal.fire({
                                title : 'You profile Updated Successfully.',
                                icon : 'success',
                            });             
                            // REALOAD ALL DATA...    
                            sp_my_address();
                            sp_my_details();
                        }
                        catch(e){
                            Swal.fire({
                                title : 'Invalid JSON Response!',
                                icon : 'error',
                            });
                        }
                    }
                }
            });
        }

    }
</script>

<!-- **********SERVICE PROVIDER CHANGE-PASSWORD SCRIPTS********** -->
<script>
    $('#change_password').submit((e)=>{
        e.preventDefault();
        let validation = true;

        const validationArr = [change_password_new_validation(),
                               change_password_old_validation(),
                               change_password_confirm_validation()];

        for(i of validationArr){
            if(i==false){
                validation = false;
                break;
            }
        }

        if(validation){

            let json = JSON.stringify({
                oldPassword : $('[name="change_password_old"]').val(),
                newPassword : $('[name="change_password_new"]').val(),
                confirmPassword : $('[name="change_password_confirm"]').val()
            });

            $.ajax({
                url : `${BASE_URL}/change-password`,
                method : 'PATCH',
                contentType : 'application/json',
                data : json,
                success : function(res){
                    if(res!=="" && res!==undefined){
                        try{
                            const result = JSON.parse(res);
                            console.log(result.message);
                            Swal.fire({
                                title : `${result.message}`,
                                icon : 'success'
                            });
                            $('#change_password').trigger('reset');
                        }
                        catch(e){
                            Swal.fire({
                                title : 'Invalid JSON Response!',
                                icon : 'error'
                            })
                        }
                    }
                }
            })
        }

    })
</script>

