<div class="make_payment">
    <div>
        <p>Pay Securely with Helperland payment gateway!</p>
        <div>
            <div class="label_input">
                <label class="label" for="">Promo Code (Optional)</label>
                <input class="input" type="text" placeholder="Optional" name="promo_code">
            </div>
            <button class="book_service_outline_btn">Apply</button>	
        </div>
    </div>
    <div class="label_input">
        <div>
            <input type="text" placeholder="XXXX-XXXX-XXXX-XXXX" value="1234-1234-1234-1234">
            <input type="text" placeholder="MM/YY" value="12/24">
            <input type="text" placeholder="CVV/CVC" value="123">
        </div>
        <div>
            <p>Accepeted Card</p>
            <div>
                <img title="Visa Card" src="<?= assets('assets/img/customer/book_service/visa.png'); ?>" alt="">
                <img title="Master Card" src="<?= assets('assets/img/customer/book_service/master_card.png'); ?>" alt="">
                <img title="American Express" src="<?= assets('assets/img/customer/book_service/american_express.png'); ?>" alt="">
            </div>
        </div>
    </div>
    <div>
        <input type="checkbox" name="TermCheckBox">
        <label for="">I accept the <a href="javascript:void(0)">term and condition</a>. the <a href="javascript:void(0)">cancellation policy</a> and the <a href="javascript:void(0)">privacy policy</a>. i confirm that helperland start to execute that contract before the expiry of the withdrawal period and i lose my right of withdrawal as consumer with full performance of the contract.</label>
    </div>
    <button id="confirm_booking_submit_btn" class="book_service_btn" disabled>Complete Booking</button>
</div>

<!-- **********BOOK-SERVICE-S4-SCRIPTS********** -->
<script>
    $('[name="TermCheckBox"]').click(()=>{
        if($('[name="TermCheckBox"]').prop('checked')){
            $('#confirm_booking_submit_btn').prop('disabled', false);
        }
        else{
            $('#confirm_booking_submit_btn').prop('disabled', true);
        }
    });

    // SECTION-4-BTN-CLICK...
    $('#confirm_booking_submit_btn').click(function(){
        $('#confirm_booking_submit_btn').prop('disabled', true);
        $.ajax({
            url : `${BASE_URL}/book-service`,
            method : 'POST',
            contentType : 'application/json',
            data : JSON.stringify(store.bookService),
            success : function(res){
                if(res!=="" && res!==undefined){
                    try{
                        const result = JSON.parse(res);
                        Swal.fire({
                            title : result.message,
                            text : `Service Request Id = ${result.id}`,
                            icon : 'success'
                        });
                        reset_book_service_tabs();
                    }
                    catch(e){
                        Swal.fire({
                            title : 'Invalid Json Response!',
                            icon : 'error'
                        });
                    }
                }
            }
        });
    });

    function reset_book_service_tabs(){

        // SECTION - 1
        $('[name="setup_service_postal_code"]').val('');

        // SECTION - 2
        $('[name="schedule_date"]').val('');
        $('[name="schedule_time"]').val('');
        $('[name="duration"]').val('3');
        $('[name="comments"]').val('');
        $('[name="extra_services"]:checked').click();
        $('[name="has_pets"]').prop('checked', false);

        // SECTION - 3
        $('#address_form').trigger('reset')
        $('[name="service_booking_address"]:checked').prop('checked', false);
        $('[name="favourite_sp"]:checked').prop('checked', false);

        // SECTION - 4
        $('[name="TermCheckBox"]').prop('checked', false);
        $('#confirm_booking_submit_btn').prop('disabled', true);

        // DISABLE ALL TABs..
        tab_btn[1].setAttribute('disabled', true);
        tab_btn[2].setAttribute('disabled', true);
        tab_btn[3].setAttribute('disabled', true);
        $('.tab_btn').removeClass('active_book_service_tab');
        $('.tab_content').addClass('d_none');
        tab_btn[0].classList.add('active_book_service_tab');
        tab_content[0].classList.remove('d_none');
    }
</script>