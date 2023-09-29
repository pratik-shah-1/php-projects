<div class="payment_summary">
    <p>Payment Summary</p>
    <div>
        <div>
            <p><span id="service_date">00/00/0000</span>&nbsp;&nbsp;<span id="service_time">00:00</span>&nbsp;&nbsp;</p>
            <!-- NOT INCLUDED IN SRS... -->
            <!-- <p><span>1 bed</span> <span>1 bath</span></p>	 -->
        </div>
        <div>
            <p>Duration</p>
            <div>
                <p>Basic</p>
                <p id="service_duration">0 Hours</p>
            </div>
            <div id="service_extra_container">
                <!-- DYNAMICLY RENDER BY JAVASCRIPT -->
                <!-- <div>
                    <p>Inside Cabinets(Extra)</p>
                    <p>30 Mins</p>
                </div> -->
            </div>
            <div>
                <p>Total Service Time</p>
                <p id="service_total_time">0 Hours</p>
            </div>
        </div>
        <div>
            <div>
                <p>Per Hour Cleaning</p>	
                <p id="service_per_hour_price">€0</p>
                <!-- $ -->
            </div>
            <!-- NOT INCLUDED IN SRS... -->
            <!-- <div>
                <p>Discount</p>	
                <p>-$27</p>
            </div> -->
        </div>
        <div>
            <div>
                <p>Total Payment</p>
                <p id="service_total_price">€0</p>	
                <!-- $ -->                
            </div>
            <!-- NOT INCLUDED IN SRS... -->
            <!-- <div>
                <p>Effective Price</p>
                <p>$50.4</p>
            </div>
            <p><span>*</span>You will save 20% according to §35a EStG.</p> -->
        </div>
        <button onclick="open_model('included_services')">
            <i class="far fa-smile"></i>
            <p>See what is always included</p>
        </button>
    </div>
</div>

<!-- **********UPDATE-PAYMENT-SUMMARY-SCRIPTS********** -->
<script>

    function update_payment_summary(){
        let serviceDate = moment(store.bookService.date, 'YYYY-MM-DD').format('DD/MM/YYYY');
        store.bookService.totalPrice = store.bookService.perHourPrice*store.bookService.duration 
                                      + (store.bookService.perHourPrice/2)*store.bookService.extraService.length;
        $('#service_date').html(serviceDate);
        $('#service_time').html(store.bookService.time);
        $('#service_duration').html(`${store.bookService.duration} Hours`);
        $('#service_total_time').html(`${parseInt(store.bookService.duration) + parseInt(store.bookService.extraTime)} Hours`);
        $('#service_extra_container').html(extra_services_html());
        $('#service_per_hour_price').html(`€${store.bookService.perHourPrice}`);
        $('#service_total_price').html(`€${store.bookService.totalPrice}`);

        // EXTRA SERVICES HTML...
        function extra_services_html(){
            // 1 => 'Cabinet'
            // 2 => 'Fridge'
            // 3 => 'Oven'
            // 4 => 'Laundry'
            // 5 => 'Window'
            let extraServices = ``;
            for(let i=0; i<store.bookService.extraService.length; i++){
                if(store.bookService.extraService[i] == 1)
                    extraServices += `<div><p>Inside Cabinet (Extra)</p><p>30 Mins</p></div>`; 
                else if(store.bookService.extraService[i] == 2)
                    extraServices += `<div><p>Inside Fridge (Extra)</p><p>30 Mins</p></div>`; 
                else if(store.bookService.extraService[i] == 3)
                    extraServices += `<div><p>Inside Oven (Extra)</p><p>30 Mins</p></div>`; 
                else if(store.bookService.extraService[i] == 4)
                    extraServices += `<div><p>Inside Laundry (Extra)</p><p>30 Mins</p></div>`; 
                else if(store.bookService.extraService[i] == 5)
                    extraServices += `<div><p>Inside Window (Extra)</p><p>30 Mins</p></div>`; 
            }
            return extraServices;
        }
    }

</script>

