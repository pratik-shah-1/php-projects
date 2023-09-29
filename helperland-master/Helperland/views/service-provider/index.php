<?= component('header'); ?>

<!-- **********SERVICE_PROVIDER********** -->
<main>

    <div class="welcome_message">
        <p>Welcome, <span><?= session('userName'); ?></span></p>
    </div>

    <div class="table_tab">
        <div class="table_tab_left">
            <div class="table_tab_list">
                <a href="javascript:void(0)" class="table_tab_btn active_table_tab" onclick="load_sp_new_services_data()">New Service Request</a>
                <a href="javascript:void(0)" class="table_tab_btn" onclick="load_sp_upcoming_services_data()">Upcoming Services</a>
                <a href="javascript:void(0)" class="table_tab_btn">Service Schedule</a>
                <a href="javascript:void(0)" class="table_tab_btn" onclick="load_sp_service_history_data()">Service History</a>
                <a href="javascript:void(0)" class="table_tab_btn" onclick="load_sp_rating_data()">My Rating</a>
                <a href="javascript:void(0)" class="table_tab_btn" onclick="load_sp_customer_data()">Block Customer</a>
            </div>
        </div>
        <div class="table_tab_right">

            <!-- PROFILE -->
            <div class="table_tab_content d_none">
                <?= component('service-provider/', 'profile'); ?>
            </div>

            <!-- NEW SERVICE REQUEST -->
            <div class="table_tab_content">
                <?= component('service-provider/', 'new-service-request'); ?>
            </div>

            <!-- UPCOMING SERVICES -->
            <div class="table_tab_content d_none">
                <?= component('service-provider/', 'upcoming-services'); ?>
            </div>

            <!-- SERVICE SCHEDULE -->
            <div class="table_tab_content d_none">
                <?= component('service-provider/', 'service-schedule') ?>
            </div>

            <!-- SERVICE HISTORY -->
            <div class="table_tab_content d_none">
                <?= component('service-provider/', 'service-history'); ?>
            </div>

            <!-- MY RATING -->
            <div class="table_tab_content d_none">
                <?= component('service-provider/', 'my-rating'); ?>
            </div>

            <!-- BLOCK CUSTOMER -->
            <div class="table_tab_content d_none">
                <?= component('service-provider/', 'block-customer'); ?>
            </div>

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

<script>
    function load_sp_new_services_data(){
        store.service_provider.table.new_services.ajax.reload();
    }

    function load_sp_upcoming_services_data(){
        store.service_provider.table.upcoming_services.ajax.reload();
    }

    function load_sp_service_history_data(){
        store.service_provider.table.service_history.ajax.reload();
    }

    function load_sp_rating_data(){
        store.service_provider.table.rating.ajax.reload();
    }

    function show_service_details(id){
        // MERGE ALL TABLE DATA... BY SPREAD OBJECT...
        let data = [...store.service_provider.data.service_history,
                    ...store.service_provider.data.new_services,
                    ...store.service_provider.data.upcoming_services];

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
                // MEANS SERVICE IS EXPIRED AND STATUS IS PENDING (1)
                if(data.Service.IsExpired==1 && data.Service.Status==1){
                    return `<div class="table_btn_container">
                                <button class="accept_btn" onclick="complete_service(${id})">Complete</button>
                            </div>`;
                }
                return ``;
            })()}
            `
        );

        open_model('service_details');
    }    
</script>

<!-- **********COMPLTE-SERVICE********** -->
<script>
    function complete_service(id){
        $.ajax({
            url : `${BASE_URL}/service-provider/service/complete/${id}`,
            method : 'PATCH',
            success : function(res){
                if(res!==undefined && res!==""){
                    try{
                        const result = JSON.parse(res);
                        Swal.fire({
                            title : 'Good job!',
                            text : result.message,
                            icon : 'success'
                        });
                        store.service_provider.table.upcoming_services.ajax.reload();
                    }
                    catch(e){
                        console.log('Invalid Json Response!!!');
                        Swal.fire({
                            title : 'Server Error',
                            text : 'Invalid Response Coming From Server!!!',
                            icon : 'error'
                        });
                    }
                }
            }
        });
    }
</script>

<?= component('footer'); ?>