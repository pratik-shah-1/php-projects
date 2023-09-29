<!-- ----------GLOBAL FUNCTIONS---------- -->
<script>
    // ----------SET LOADER----------
    function open_loader(){
        $('.backlight_container').addClass('loader');
        $('body').css({'overflow-y':'hidden'});
    }

    // ----------CLOSE LOADER----------
    function close_loader(){
        $('.backlight_container').removeClass('loader');
        $('body').css({'overflow-y':'auto'});
    }

    // ----------GET-TOKEN----------
    function getToken(){
        let cookie = document.cookie.split(';');
        let arr = [];
        cookie = cookie.map((i)=> {
            arr = [];
            key = i.split('=')[0].trim();
            value = i.split('=')[1].trim();
            arr[key]=value;
            return arr;
        });
        let filtered = cookie.filter((i)=> {
            return i['X-CSRF-TOKEN'];
        } );
        return filtered[0]['X-CSRF-TOKEN'];
    }
</script>

<!-- ----------AJAX-PRE-SETUP---------- -->
<script>
    let ajaxMethod = `GET`;

    $.ajaxSetup({
        contentType : 'application/json',
        beforeSend : function(xhr, req){
            xhr.setRequestHeader('X-CSRF-TOKEN', getToken());
            ajaxMethod = req.type;
            ajaxMethod!=='GET' && open_loader();
        },
        complete : function(){
            close_loader();
        },
        error : function(obj){
            if(ajaxMethod!=='GET'){
                const {responseText} = obj;
                const error = JSON.parse(responseText);
                Swal.fire({
                    title : error.message,
                    icon : 'error'
                });
            }
            else{
                console.log('Getting Ajax Error', obj);
            }
            // DISABLED BUTTON...
            $('[name="forgot_password_btn"]').prop('disabled', false);
            $('.form_btn').prop('disabled', false);
            $('#confirm_booking_submit_btn').prop('disabled', false);
        }        
    });
</script>

<!-- STORE OBJECT FOR GLOBAL DATA STORING -->
<script>
    let BASE_URL = `<?= BASE_URL; ?>`; 
    let store = {};

    // ----------ID----------
    store.id = {        
        accept:null,
        reject:null,
        cancel:null,
        rateSp:null,
        complete:null,
        reschedule:null,
        update:null,
        delete:null,
    };

    // ----------BOOK SERVICE----------
    store.bookService = {            
        postalCode : '',
        date : moment().format('DD/MM/YYYY'),
        time : moment().format('H:m'),
        duration : 3,
        comments : '',
        hasPets : false,
        extraService : [],
        extraTime : 0,
        serviceProviderId : null,
        perHourPrice : 20,
        totalPrice : 0,
        address : {},
    };

    // ----------CUSTOMER----------
    store.customer = {
        address : [],
        table:{
            current_services : null,
            service_history : null
        },
        data:{
            current_services : [],
            service_history : [],
            service_providers : []
        }
    };

    // ----------SERVICE PROVIDER----------
    store.service_provider = {
        table:{
            new_services : null,
            upcoming_services : null,
            service_history : null,
            rating : null,
        },
        data:{
            new_services : [],
            upcoming_services : [],
            service_history : [],
            rating : [],
            customers : []
        }
    };

    // ----------ADMIN----------
    store.admin = {
        table:{
            service_requests : null,
            user_management : null
        },
        data:{
            service_requests : [],
            user_management : []
        }
    };

</script>

<!-- LOGGED-USER-DETAILS -->
<script>
    <?php if(session('userRole')==1){ ?>
        // ----------USER-DETAILS----------
        $.ajax({
            url : `${BASE_URL}/user/details`,
            method : 'GET',
            success : function(res){
                const result = JSON.parse(res);
                store.loggedUserDetails = result;
            }
        });
        // ----------USER-ADDRESS----------
        $.ajax({
            url : `${BASE_URL}/user/address`,
            method : 'GET',
            success : function(res){
                const result = JSON.parse(res);
                if(result.length>0){
                    store.loggedUserAddress = result[0];
                }
                else{
                    store.loggedUserAddress = [];
                }
            }
        });
    <?php } ?>
</script>
