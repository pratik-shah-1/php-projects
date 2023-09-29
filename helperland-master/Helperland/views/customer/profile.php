<div class="profile">
    <div class="tab_container">
        <div class="tab_indicator profile_tabs">
            <button class="tab_btn active_profile_tab"><div><img src="<?= assets('assets/img/profile/Details.png'); ?>"></div><span>My Details</span></button>
            <button class="tab_btn"><div><img src="<?= assets('assets/img/profile/Address.png'); ?>"></div><span>My Addresses</span></button>
            <button class="tab_btn"><div><img src="<?= assets('assets/img/profile/Password.png'); ?>" alt=""></div><span>Change Password</span></button>
        </div>

        <div class="tab_body">
            <!-- MY DETAILS -->
            <div class="tab_content">
                <form class="my_details" id="customer_details">
                    <div class="my_details_inner_div_1">
                        <div class="label_input">
                            <label class="label" for="">First Name</label>
                            <input class="input" type="text" name="firstname">
                            <div class="validation_message d_none">
                                <p>Validation Message!</p>
                            </div>
                        </div>
                        <div class="label_input">
                            <label class="label" for="">Last Name</label>
                            <input class="input" type="text" name="lastname">
                            <div class="validation_message d_none">
                                <p>Validation Message!</p>
                            </div>
                        </div>
                        <div class="label_input">
                            <label class="label" for="">Email Address</label>
                            <input class="input" type="text" name="email" readonly>
                            <div class="validation_message d_none">
                                <p>Validation Message!</p>
                            </div>
                        </div>
                        <div class="label_phone_number">
                            <label class="label" for="">Phone Number</label>
                            <div class="phone_number">
                                <label for="">+49</label>
                                <input type="text" name="phone">
                            </div>
                            <div class="validation_message d_none">
                                <p>Validation Message!</p>
                            </div>
                        </div>
                        <div class="label_input">
                            <label class="label" for="">Date of Birth</label>
                            <input class="input" type="date" name="dob">
                            <div class="validation_message d_none">
                                <p>Validation Message!</p>
                            </div>
                        </div><!-- END_GRID_DIV -->
                    </div><!-- END_GRID_DIV -->
                    <div class="my_details_inner_div_2">
                        <div class="label_select">
                            <label class="label" for="">My Preferred Language</label>
                            <select class="select" name="language">
                                <option value="1">English</option>
                                <option value="2">Hindi</option>
                            </select>
                            <div class="validation_message d_none">
                                <p>Validation Message!</p>
                            </div>
                        </div>
                        <button class="profile_save_btn">Save</button>
                    </div><!-- END_GRID_DIV -->
                </form><!-- END_MY_DETAILS_FORM -->
            </div><!-- END_TAB_CONTENT -->

            <!-- MY ADDRESS -->
            <div class="tab_content d_none">
                <div class="my_addresses">
                    <table>
                        <thead>
                            <tr>
                                <th>Addresses</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="customer_address_tbody">
                            <!-- GENERATE BY JAVASCRIPT -->
                        </tbody>
                    </table>
                    <button  onclick="open_model('add_address');" class="profile_save_btn">Add New Address</button>
                </div><!-- MY ADDRESSES -->
            </div><!-- TAB CONTENT -->

            <!-- CHANGE-PASSWORD -->
            <div class="tab_content d_none">
                <form class="change_password" id="change_password">
                    <div class="label_input">
                        <label class="label" for="">Old Password</label>
                        <input class="input" type="password" placeholder="Current Password" name="change_password_old">
                        <div class="validation_message d_none">
                            <p>Validation Message!!!</p>
                        </div>
                    </div>
                    <div class="label_input">
                        <label class="label" for="">New Password</label>
                        <input class="input" type="password" placeholder="Password" name="change_password_new">
                        <div class="validation_message d_none">
                            <p>Validation Message!!!</p>
                        </div>
                    </div>
                    <div class="label_input">
                        <label class="label" for="">Confirm Password</label>
                        <input class="input" type="password" placeholder="Confirm Password" name="change_password_confirm">
                        <div class="validation_message d_none">
                            <p>Validation Message!!!</p>
                        </div>
                    </div>
                    <button class="profile_save_btn">Save</button>
                </form>
            </div><!-- END_TAB_CONTENT -->
        </div><!-- END_TAB_BODY -->
    </div><!-- END_TAB_CONTAINER -->
</div><!-- END_PROFILE -->


<!-- **********CUSTOMER MY-DETAILS SCRIPTS********** -->
<script>

    // LOAD CUSTOMER DETAILS...
    function customer_my_details(){
        $.ajax({
            url : `${BASE_URL}/user/details`,
            method : 'GET',
            success : function(res){
                if(res!=="" && res!==undefined){
                    const result = JSON.parse(res);
                    // SET CUSTOMER DETAILS...
                    $('[name="firstname"]').val(result.FirstName);
                    $('[name="lastname"]').val(result.LastName);
                    $('[name="email"]').val(result.Email);
                    $('[name="phone"]').val(result.Mobile);
                    $('[name="language"]').val(result.LanguageId);
                    $('[name="dob"]').val(result.DateOfBirth);
                }
            }
        })
    }
    customer_my_details();

    $('#customer_details').submit((e)=>{
        e.preventDefault();
        let validation = true;

        validationArr = [firstname_validation(),
                         lastname_validation(),
                         email_validation(),
                         phone_validation(),
                         dob_validation()];

        for(let i=0; i<validationArr.length; i++){
            if(validationArr[i]==false){
                validation = false;
                break;
            }
        }

        if(validation){
            // CONVERTING A FORM DATA INTO JSON DATA....
            let json = JSON.stringify({
                firstName : $('[name="firstname"]').val(),
                lastName : $('[name="lastname"]').val(),
                email : $('[name="email"]').val(),
                phone : $('[name="phone"]').val(),
                language : parseInt($('[name="language"]').val()),
                dateOfBirth : $('[name="dob"]').val()
            });
            $.ajax({
                url :  `${BASE_URL}/user/details`,
                method : 'PATCH',
                contentType : 'application/json',
                data : json,
                success : function(res){
                    if(res!=="" && res!==undefined){
                        try{
                            const result = JSON.parse(res);
                            Swal.fire({
                                title : `${result.message}`,
                                icon : 'success'
                            });
                            customer_my_details();
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

<!-- **********CUSTOMER MY-ADDRESS SCRIPTS********** -->
<script>
    function customer_my_address(){
        $.ajax({
            url : `${BASE_URL}/user/address`,
            method : 'GET',
            success : function(res){
                if(res!=="" && res!==undefined){
                    const address = JSON.parse(res);
                    store.customer.address = address;
                    let temp = ``;
                    for(result of address){
                        temp += `
                            <tr>
                                <td>
                                    <div>
                                        <p><span>Address</span> : ${result.AddressLine1} ${result.AddressLine2}, ${result.PostalCode} ${result.City}</p>
                                        <p><span>Phone Number</span> : ${result.Mobile}</p>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <button onclick="edit_address(${result.AddressId})"><i class="fas fa-edit"></i></button>
                                        <button onclick="delete_address(${result.AddressId})"><i class="fas fa-trash-alt"></i></button>    
                                    </div>
                                </td>
                            </tr>
                        `;
                    }
                    $('#customer_address_tbody').html(``);
                    $('#customer_address_tbody').html(temp);
                }
            }
        });
    }
    customer_my_address();

    // EDIT ADDRESS...
    function edit_address(id){
        $.ajax({
            url : `${BASE_URL}/user/address/${id}`,
            method : 'GET',
            success : function(res){
                if(res!=="" && res!==undefined){
                    try{
                        const result = JSON.parse(res);
                        store.id.edit = result.AddressId;
                        $('[name="edit_address_street_name"]').val(result.AddressLine1);
                        $('[name="edit_address_house_number"]').val(result.AddressLine2);
                        $('[name="edit_address_postal_code"]').val(result.PostalCode);
                        $('[name="edit_address_city"]').val(result.City);
                        $('[name="edit_address_phone"]').val(result.Mobile);
                        open_model('edit_address');
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

    // DELETE ADDRESS...
    function delete_address(id){
        Swal.fire({
            title : 'Are you Sure?',
            error : 'warning',
            showCancelButton: true,
            focusConfirm: false,        
        }).then((res)=>{
            if(res.isConfirmed){
                // AJAX REQUEST...
                $.ajax({
                    url : `${BASE_URL}/user/address/${id}`,
                    method : 'DELETE',
                    success : function(res){
                        if(res!=="" && res!==undefined){
                            try{
                                const result = JSON.parse(res);
                                Swal.fire({
                                    title : result.message,
                                    icon : 'success'
                                });
                                customer_my_address();
                            }
                            catch(e){
                                Swal.fire({
                                    title : 'Invalid JSON Response!',
                                    icon : 'error'
                                });
                            }
                        }
                    }
                })
            }
        });
    }
</script>

<!-- **********CUSTOMER CHANGE-PASSWORD SCRIPTS********** -->
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

