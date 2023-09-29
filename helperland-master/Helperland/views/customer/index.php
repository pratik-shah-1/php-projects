<?= component('header'); ?>

<!-- **********MAIN********** -->
<main>

    <!-- WELCOME_MESSAGE -->
    <div class="welcome_message">
        <p>Welcome, <span><?= session('userName'); ?></span></p>
    </div>

    <!-- TAB AND TABLE -->
    <div class="table_tab">
        <!-- LEFT -->
        <div class="table_tab_left">
            <!-- TAB AND TABLE LIST -->
            <div class="table_tab_list">
                <a href="javascript:void(0)" class="table_tab_btn active_table_tab" onclick="load_customer_dashboard_data()">Dashboard</a>
                <a href="javascript:void(0)" class="table_tab_btn" onclick="load_customer_service_history_data()">Service History</a>
                <a href="javascript:void(0)" class="table_tab_btn" onclick="load_customer_sp_data()">Favorite Service Provider</a>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="table_tab_right">

            <!-- PROFILE -->
            <div class="table_tab_content d_none">
                <?= component('customer/', 'profile'); ?>
            </div>
            
            <!-- CUSTOMER_SERVICE_REQUESTS -->
            <div class="table_tab_content">
                <?= component('customer/', 'current-service-requests'); ?>
            </div>

            <!-- SERVICE_HISTORY -->
            <div class="table_tab_content d_none">
                <?= component('customer/', 'service-history'); ?>
            </div><!-- END_TABLE_TAB_CONTENT -->

            <!-- FAVOURITE PROS -->
            <div class="table_tab_content d_none">
                <?= component('customer/', 'favourite-sp'); ?>
            </div><!-- END_TABLE_TAB_CONTENT -->

        </div><!-- END_TABLE_TAB_RIGHT -->
    </div><!-- END_TABLE_TAB -->
</main><!-- END_MAIN -->

<script>
    // FOR OPEN MY SETTING OUTSIDE THE SERVICE PROVIDER PAGE...
    if(localStorage.getItem('openMySetting')){
        localStorage.removeItem('openMySetting');
        // OPEN MY SETTING CODE...
        $('.table_tab_btn').removeClass('active_table_tab');
        $('.table_tab_content').addClass('d_none');        
        document.getElementsByClassName('table_tab_content')[0].classList.remove('d_none');
    }
</script>

<!-- **********CUSTOMER-SECTIONS-RELOAD-SCRIPTS**********s -->
<script>

    // LOAD CUSTOMER DASHBOARD DATA...
    function load_customer_dashboard_data(){
        store.customer.table.dashboard.ajax.reload();
    }

    // LOAD CUSTOMER SERVICE HISTORY DATA...
    function load_customer_service_history_data(){
        store.customer.table.service_history.ajax.reload();
    }

    // SHOW SERVICE DETAILS...
    function show_service_details(id, userAction){
        let data = [...store.customer.data.current_services,
                    ...store.customer.data.service_history];

        data = data.filter((i)=>{
            if(id===i.Service.Id){
                return i;
            }
        });

        // SERVICE DATA...
        data = data[0];
        // SETUP HTML... $ €
        $('#service_details_popup').html(`
            <p class="popup_title">Service Details</p>
            <div>
                <p>${data.Service.ServiceDate} | ${data.Service.StartTime} - ${data.Service.EndTime}</p>
                <p>Duration : <span>${data.Service.Duration} Hours</span></p>
            </div>
            <div>
                <p>Service Id : <span>${data.Service.Id}</span></p>
                ${(function(){
                    let extraService = ``;
                    if(data.Service.ExtraService!==null){
                        for(let i=0; i<data.Service.ExtraService.length; i++){
                            if(data.Service.ExtraService[i]==1){
                                extraService += `<p>Extras : <span>Inside Cabinet</span></p>`;
                            }
                            else if(data.Service.ExtraService[i]==2){
                                extraService += `<p>Extras : <span>Inside Fridge</span></p>`;
                            }
                            else if(data.Service.ExtraService[i]==3){
                                extraService += `<p>Extras : <span>Inside Oven</span></p>`;
                            }
                            else if(data.Service.ExtraService[i]==4){
                                extraService += `<p>Extras : <span>Inside Laundry</span></p>`;
                            }
                            else if(data.Service.ExtraService[i]==5){
                                extraService += `<p>Extras : <span>Inside Window</span></p>`;
                            }
                        }
                        return extraService;
                    }
                    else{
                        return extraService;
                    }
                })()}
                <p>Net Amout : <span class="price_text">${data.Service.TotalCost} €</span></p>
            </div>
            <div>
                <p>Service Address : <span>${data.ServiceAddress.AddressLine1} ${data.ServiceAddress.AddressLine2}, ${data.ServiceAddress.PostalCode} ${data.ServiceAddress.City} </span></p>
                <p>Billing Address : <span>Same as Cleaning Address</span></p>
                <p>Phone : <span>+49 ${data.ServiceAddress.Mobile}</span></p>
                <p>Email : <span>${data.ServiceAddress.Email}</span></p>
            </div>
            <div>
                <p>Conmments : <span>${data.Service.Comments? data.Service.Comments:''}</span></p>
            </div>
            ${(function(){
                if(userAction!==false){
                    return `<div class="table_btn_container">
                                <button class="reschedule_btn" onclick="reschedule_service_open_model(${data.Service.Id})"><i class="fas fa-redo-alt"></i> Reschdule</button>
                                <button class="cancel_btn" onclick="cancel_service_open_model(${data.Service.Id})"><i class="fas fa-times"></i> Cancel</button>
                            </div>`;
                }
                else {
                    return ``;
                }
            })()}`
        );
        open_model('service_details');
    }
</script>

<?= component('footer'); ?>