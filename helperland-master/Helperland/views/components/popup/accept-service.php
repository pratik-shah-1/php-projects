<!-- **********ACCEPT-SERVICE-DETAILS********** -->
<div class="model">
    <!-- MODEL_CLOSE -->
    <button class="model_close_btn">&times;</button>
    <!-- SERVICE_DETAILS -->
    <div  class="popup_main d_none" id="accept_service_request_popup">
        <p class="popup_title">Service Details</p>
        <!-- FIRST DIV -->
        <div class="">
            <div>
                <p>05/10/2021 | 08:00 - 11:30</p>
                <p>Duration : <span>3.5Hours</span></p>
            </div>
            <div>
                <p>Service Id : <span>8485</span></p>
                <p>Extras : <span>Inside Cabinats</span></p>
                <p>Total Amount : <span class="payment_text">87,50$</span></p>
            </div>
            <div>
                <p>Customer Name : <span>Gaurang Patel</span></p>
                <p>Service Address : <span>Koenigstrasse 112, 99897 Tambach-Dietharz </span></p>			
                <p>Distance : <span>296km</span></p>
            </div>
            <div>
                <p>Conmments : <span>I don't have pets</span></p>
            </div>
            <div class="table_btn_container">
                <button class="accept_btn"><i class="fas fa-check"></i>Accept</button>
            </div>		
        </div>
        <!-- SECOND DIV FOR MAP -->
        <div>
            <img src="<?= assets('assets/img/static/contact/section_2/map.png'); ?>" alt="">
        </div>
    </div>
</div>

<!-- **********ACCEPT-SERVICE-BY-SP********** -->
<script>
    function accept_service(){
        $.ajax({
            url : `${BASE_URL}/service-provider/service/accept/${store.id.accept}`,
            method : 'PATCH',
            success : function(res){
                if(res!=="" && res!==undefined){
                    try{
                        const result = JSON.parse(res);
                        Swal.fire({
                            title : result.message,
                            icon : 'success'
                        });
                        store.service_provider.table.new_services.ajax.reload();
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
</script>