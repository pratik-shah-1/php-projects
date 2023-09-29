<!-- IF ERROR THEN TARGET HERE -->
<a href="#target_section" id="target_btn" class="d_none">Error_Target</a>
<section id="target_section">
    <!-- THIS SECTION WILL BE HIDDEN  -->
</section>
<!-- IF ERROR THEN TARGET HERE -->
    

<div class="schedule_plan">

    <!-- FIRST DIV -->
    <!-- ******************FIRST DIV NOT IN SRS************************ -->
    <div class="label_select d_none">
        <label class="label" for="">Select Number of Rooms and Bath</label>
        <div>
            <select class="select" name="" id="">
                <option value="">1 Bed</option>
            </select>
            <select class="select" name="" id="">
                <option value="">1 Bath</option>
            </select>
        </div>

    </div>

    <!-- SECOND_DIV -->
    <div>
        <div class="label_select">
            <label class="label" for="">When do you need cleaner?</label>
            <div>
                <div class="form_group">
                    <div class="from_date">
                        <label style="padding-bottom:0;"><img src="<?= assets('assets/img/table/calendar_blue.png'); ?>" alt=""></label>
                        <input type="date" name="schedule_date">
                    </div>
                        <div class="validation_message d_none">
                        <p>Validation Message</p>
                    </div>		
                </div>
                <div class="form_group">
                    <input class="input_time" type="time" name="schedule_time">
                    <div class="validation_message d_none">
                        <p>Validation Message</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="label_select">
            <label class="label">How long do you need your cleaner to stay?</label>
            <select class="select" name="duration">
                <option value="3">3 Hours</option>
                <option value="4">4 Hours</option>
                <option value="5">5 Hours</option>
                <option value="6">6 Hours</option>
            </select>
            <div class="validation_message d_none">
                <p>Validation Message</p>
            </div>
        </div>
    </div>
    <!-- THIRD DIV -->
    <div>
        <label for="">Extra Services</label>
        <!-- EXTRA SERVIES CONTAINER...	 -->
        <div>
            <!-- EXTRA SERVICE DIV [INPUT+LABEL] -->
            <div>
                <input id="cabinet" type="checkbox" name="extra_services" value="1">
                <label for="cabinet">
                    <div><img src="<?= assets('assets/img/customer/book_service/cabinet.png'); ?>" alt=""></div>
                    <p>Inside Cabinets</p>
                </label>
            </div>
            <!-- EXTRA SERVICE DIV [INPUT+LABEL] -->
            <div>
                <input id="fridge" type="checkbox" name="extra_services" value="2">
                <label for="fridge">
                    <div><img src="<?= assets('assets/img/customer/book_service/fridge.png'); ?>" alt=""></div>
                    <p>Inside Fridge</p>
                </label>
            </div>
            <!-- EXTRA SERVICE DIV [INPUT+LABEL] -->
            <div>
                <input id="oven" type="checkbox" name="extra_services" value="3">
                <label for="oven">
                    <div><img src="<?= assets('assets/img/customer/book_service/oven.png'); ?>" alt=""></div>
                    <p>Inside Oven</p>
                </label>
            </div>
            <!-- EXTRA SERVICE DIV [INPUT+LABEL] -->
            <div>
                <input id="laundry" type="checkbox" name="extra_services" value="4">
                <label for="laundry">
                    <div><img src="<?= assets('assets/img/customer/book_service/laundry.png'); ?>" alt=""></div>
                    <p>Laundry Wash & Dry</p>
                </label>
            </div>
            <!-- EXTRA SERVICE DIV [INPUT+LABEL] -->
            <div>
                <input id="window" type="checkbox" name="extra_services" value="5">
                <label for="window">
                    <div><img src="<?= assets('assets/img/customer/book_service/window.png'); ?>" alt=""></div>
                    <p>Interior Windows</p>
                </label>
            </div>
        </div>
    </div>
    <!-- FOURTH DIV -->
    <div>
        <div class="label_input">
            <label class="label" for="">Comments</label>
            <textarea class="textarea" name="comments"></textarea>
        </div>
        <div>
            <input type="checkbox" name="has_pets" value="true">
            <label for="">I have a Pets at Home</label>
        </div>
    </div>
    <button id="schedule_plan_submit_btn" class="book_service_btn">Continue</button>
</div>

<!-- **********BOOK-SERVICE-S2-SCRIPTS********** -->
<script>
    // SECTION-2-BTN-CLICK...
    $('#schedule_plan_submit_btn').click(function(){

        let validation = true;
        let validationArr = [schedule_date_validation(), 
                             schedule_time_validation()];

        for(let i=0; i<validationArr.length; i++){
            if(validationArr[i]==false){
                validation = false;
                break;
            }
        }

        if(validation){

            // STORE SCHEDULE PLAN DATA
            let extraService = $('[name="extra_services"]:checked');
            let temp = [];
            extraService.filter((i, element) => {
                temp.push(element.value);
            });
            extraService = temp;
            store.bookService.extraService = extraService;
            store.bookService.extraTime = extraService.length!==0 ? (extraService.length*30)/60 : 0;
            store.bookService.date = $('[name="schedule_date"]').val();
            store.bookService.time = $('[name="schedule_time"]').val(); // [INCOMING INPUT TIME IN 24HRS]...
            store.bookService.duration = parseInt($('[name="duration"]').val());
            store.bookService.comments = $('[name="comments"]').val();
            store.bookService.hasPets = Boolean($('[name="has_pets"]:checked').val());
            update_payment_summary();
            change_book_service_tabs(2);
        }
        else{
            // SCROLL-UP PAGE WHEN ERROR COMES...
            document.getElementById('target_btn').click();
            window.scrollTo({top: $(window).scrollTop()-200, behavior: "smooth"});
        }
    });
</script>

<!-- **********ON CHANGE UPDATE PAYMENT SUMMARY********** -->
<script>
    // ON DATE CHANGE UPDATE PAYMENT SUMMARY...
    $('[name="schedule_date"]').change(function(){
        store.bookService.date = $('[name="schedule_date"]').val();
        update_payment_summary();
    });

    $('[name="schedule_time"]').change(function(){
        store.bookService.time = $('[name="schedule_time"]').val();
        update_payment_summary();
    });

    $('[name="duration"]').change(function(){
        store.bookService.duration = parseInt($('[name="duration"]').val());
        update_payment_summary();
    });

    $('[name="comments"]').keyup(function(){
        store.bookService.comments = $('[name="comments"]').val();
    });

    $('[name="extra_services"]').change(function(){
        let extraService = $('[name="extra_services"]:checked');
        let temp = [];
        extraService.filter((i, element) => {
            temp.push(element.value);
        });
        extraService = temp;
        store.bookService.extraService = extraService;
        store.bookService.extraTime = extraService.length!==0 ? (extraService.length*30)/60 : 0;;
        update_payment_summary();
    });

</script>