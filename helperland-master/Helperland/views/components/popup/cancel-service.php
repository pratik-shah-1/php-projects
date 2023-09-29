<!-- **********CANCEL_SERVICE_REQUEST********** -->
<div class="model">
    <!-- MODEL_CLOSE -->
    <button class="model_close_btn">&times;</button>
    <!-- CANCEL_SERVICE_REQUEST -->
    <form class="popup_main d_none" id="cancel_service_request_popup">
        <p class="popup_title">Cancel Service Request</p>
        <div class="form_group">
            <label class="label" for="">Why you want to cancel the service request?</label>
            <textarea class="textarea" name="cancel_service_reason"></textarea>
            <div class="validation_message d_none">
                <p>Validation message!!!</p>
            </div>
        </div>
        <button class="popup_btn">Cancel Now</button>
    </form>
</div>

<!-- **********CANCEL-SERVICE-SCRIPTS********** -->
<script>
    $('#cancel_service_request_popup').submit((e)=>{
        e.preventDefault();

        let validation = cancel_service_validation();

        if(validation){
            let json = JSON.stringify({
                reason : $('[name="cancel_service_reason"]').val(),
                service_id : store.id.cancel
            });
            $.ajax({
                url : `${BASE_URL}/customer/service/cancel/${store.id.cancel}`,
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
                            $('[name="cancel_service_reason"]').val('');
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