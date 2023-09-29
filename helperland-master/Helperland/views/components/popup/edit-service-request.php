<!-- **********EDIT_SERVICE_DETAILS********** -->
<div class="model">
    <!-- MODEL_CLOSE -->
    <button class="model_close_btn">&times;</button>
    <!-- SERVICE_DETAILS -->
    <form  class="popup_main d_none" id="edit_service_request_popup">
        <p class="popup_title">Edit Service Request</p>
        <!-- DATE AND TIME -->
        <div>
            <div class="form_group">
                <label class="label" for="">Date</label>
                <input class="input" type="date" name="edit_service_date">
                <div class="validation_message d_none">
                    <p>Enter Date!</p>
                </div>
            </div>
            <div class="form_group">
                <label class="label" for="">Time</label>
                <input class="input" type="time" name="edit_service_time">
                <div class="validation_message d_none">
                    <p>Enter Date!</p>
                </div>
            </div>
        </div>
        <!-- SERVICE ADDRESS -->
        <div>
            <p>Service Address</p>
            <div class="form_group">
                <label class="label" for="">Street Name</label>
                <input class="input" type="text" name="edit_service_street_name">
                <div class="validation_message d_none">
                    <p>Enter Date!</p>
                </div>
            </div>
            <div class="form_group">
                <label class="label" for="">House Number</label>
                <input class="input" type="text" name="edit_service_house_number">
                <div class="validation_message d_none">
                    <p>Enter Date!</p>
                </div>
            </div>
            <div class="form_group">
                <label class="label" for="">Postal Code</label>
                <input class="input" type="text" name="edit_service_postal_code">
                <div class="validation_message d_none">
                    <p>Enter Date!</p>
                </div>
            </div>
            <div class="form_group">
                <label class="label" for="">City</label>
                <input class="input" type="text" name="edit_service_city">
                <!-- <select class="select" name="">
                    <option value="">Select</option>
                </select> -->
                <div class="validation_message d_none">
                    <p>Enter Date!</p>
                </div>
            </div>
        </div>
        <!-- INVOICE ADDRESS -->
        <div>
            <p>Invoice Address</p>
            <div class="form_group">
                <label class="label" for="">Street Name</label>
                <input class="input" type="text" name="edit_service_street_name_readonly" readonly>
                <div class="validation_message d_none">
                    <p>Enter Date!</p>
                </div>
            </div>
            <div class="form_group">
                <label class="label" for="">House Number</label>
                <input class="input" type="text" name="edit_service_house_number_readonly" readonly>
                <div class="validation_message d_none">
                    <p>Enter Date!</p>
                </div>
            </div>
            <div class="form_group">
                <label class="label" for="">Postal Code</label>
                <input class="input" type="text" name="edit_service_postal_code_readonly" readonly>
                <div class="validation_message d_none">
                    <p>Enter Date!</p>
                </div>
            </div>
            <div class="form_group">
                <label class="label" for="">City</label>
                <input class="input" type="text" name="edit_service_city_readonly" readonly>
                <!-- <select class="select" name="">
                    <option value="">Select</option>
                </select> -->
                <div class="validation_message d_none">
                    <p>Enter Date!</p>
                </div>
            </div>
        </div>
        <!-- TEXTAREA -->
        <div class="form_group">
            <p>What do you want to reschedule service request?</p>
            <textarea class="textarea" placeholder="What do you want to reschedule service request?" name="" readonly></textarea>
            <div class="validation_message d_none">
                <p>Enter Date!</p>
            </div>
        </div>
        <!-- TEXTAREA -->
        <div class="form_group">
            <p>Call center EMP Notes</p>
            <textarea class="textarea" placeholder="Enter Notes" name="" readonly></textarea>
            <div class="validation_message d_none">
                <p>Enter Date!</p>
            </div>
        </div>
        <button class="update_btn">Update</button>
    </form>
</div>

<script>
    // READONLY FIELD...
    $('[name="edit_service_city"]').keyup(()=>{      
        const val = $('[name="edit_service_city"]').val();
        $('[name="edit_service_city_readonly"]').val(val);
    });
    $('[name="edit_service_postal_code"]').keyup(()=>{      
        const val = $('[name="edit_service_postal_code"]').val();
        $('[name="edit_service_postal_code_readonly"]').val(val);
    });
    $('[name="edit_service_street_name"]').keyup(()=>{      
        const val = $('[name="edit_service_street_name"]').val();
        $('[name="edit_service_street_name_readonly"]').val(val);
    });
    $('[name="edit_service_house_number"]').keyup(()=>{      
        const val = $('[name="edit_service_house_number"]').val();
        $('[name="edit_service_house_number_readonly"]').val(val);
    });
</script>

<script>
    $('#edit_service_request_popup').submit((e)=>{
        e.preventDefault();
        const json = JSON.stringify({
            date : $('[name="edit_service_date"]').val(),
            time : $('[name="edit_service_time"]').val(),
            street_name : $('[name="edit_service_street_name"]').val(),
            house_number : $('[name="edit_service_house_number"]').val(),
            postal_code : $('[name="edit_service_postal_code"]').val(),
            city : $('[name="edit_service_city"]').val(),
            id : store.id.reschedule
        });
        $.ajax({
            url : `${BASE_URL}/admin/service/reschedule/${store.id.reschedule}`,
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
                        close_model();
                        store.admin.table.service_requests.ajax.reload();
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
    });
</script>