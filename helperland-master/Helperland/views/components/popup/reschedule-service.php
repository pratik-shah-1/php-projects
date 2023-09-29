<!-- **********RESCHEDULE_SERVICE********** -->
<div class="model">
    <!-- MODEL_CLOSE -->
    <button class="model_close_btn">&times;</button>
    <!-- RESCHEDULE_SERVICE_REQUEST -->
    <form class="popup_main d_none" id="reschedule_service_request_popup">
        <p class="popup_title">Reschedule Service Request</p>
        <div class="form_group">
            <label class="label" for="">Select New Date & Time</label>
            <div>
                <input class="input" type="date" name="reschedule_service_date">
                <input class="input" type="time" name="reschedule_service_time">
            </div>
            <div class="validation_message d_none">
                <p>validaton message!!!</p>
            </div>
            <button class="popup_btn">Update</button>
        </div>
    </form>
</div>

<!-- **********RESCHEDULE-SCRIPTS********** -->
<script>
    $('#reschedule_service_request_popup').submit((e)=>{

        e.preventDefault();

        let validation = reschedule_service_validation();
        if(validation){
            let json = JSON.stringify({
                date : $('[name="reschedule_service_date"]').val(),
                time : $('[name="reschedule_service_time"]').val(),
            });

            $.ajax({
                url : `${BASE_URL}/customer/service/reschedule/${store.id.reschedule}`,
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
                            // RELOAD CURRENT SERVICE REQUESTS TABLE...
                            store.customer.table.dashboard.ajax.reload();
                            close_model();
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