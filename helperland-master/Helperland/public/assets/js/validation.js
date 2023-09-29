const TextRegEx = /^[A-Za-z]{3,}/;
const EmailRegEx = /^[a-zA-Z0-9.]+@[a-zA-Z0-9]+(\.[a-zA-Z]{2,})+$/;
const PasswordRegEx = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;
const PhoneRegEx = /^[0-9]{10}$/;
const PostalCodeRegEx = /^[0-9]{5,6}$/;
const HouseNumberRegEx = /^[0-9]{1,4}$/;

// ------------MIN & MAX VALIDATION--------------
let today = moment().format('YYYY-MM-DD');
let tomorrow = moment().add(1, 'days').format('YYYY-MM-DD');
let serviceMinDate = (new Date()).getHours()<18 ? today : tomorrow;

$('[name="schedule_date"]').attr('min', serviceMinDate);
$('[name="reschedule_service_date"]').attr('min', serviceMinDate);
$('[name="edit_service_date"]').attr('min', serviceMinDate);
$('[name="schedule_time"]').attr('min', '08:00').attr('max', '18:00');
$('[name="reschedule_service_time"]').attr('min', '08:00').attr('max', '18:00');
$('[name="edit_service_time"]').attr('min', '08:00').attr('max', '18:00');
// $('[name="dob"]').attr('max', today);

// ----------FIRST-NAME-VALIDATION----------
function firstname_validation(){
    const input_value = $('[name="firstname"]').val();
    if(input_value==''){
        $('[name="firstname"]').next().removeClass('d_none').children().html('Please Enter First Name !');
        return false;
    }
    else if(TextRegEx.test(input_value)==false){
        $('[name="firstname"]').next().removeClass('d_none').children().html('First Name Should be a Min 3 Characters required!');
        return false;
    }
    else{
        $('[name="firstname"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------LAST-NAME-VALIDATION----------
function lastname_validation(){
    const input_value = $('[name="lastname"]').val();
    if(input_value==''){
        $('[name="lastname"]').next().removeClass('d_none').children().html('Please Enter Last Name !');
        return false;
    }
    else if(TextRegEx.test(input_value)==false){
        $('[name="lastname"]').next().removeClass('d_none').children().html('Last Name Should be a Min 3 Characters required');
        return false;
    }
    else{
        $('[name="lastname"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------PHONE-NUMBER-VALIDATION----------
function phone_validation(){
    const input_value = $('[name="phone"]').val();
    if(input_value==''){
        $('[name="phone"]').parent().next().removeClass('d_none').children().html('Please Enter Phone Number !');
        return false;
    }
    else if(PhoneRegEx.test(input_value)==false){
        $('[name="phone"]').parent().next().removeClass('d_none').children().html('Enter a Valid Phone Number !');
        return false;
    }
    else{
        $('[name="phone"]').parent().next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------EMAIL-ADDRESS-VALIDATION----------
function email_validation(){
    const input_value = $('[name="email"]').val();
    if(input_value==""){
        $('[name="email"]').next().removeClass('d_none').children().html('Please Enter Email Address !');
        return false;
    }
    else if(EmailRegEx.test(input_value)==false){        
        $('[name="email"]').next().removeClass('d_none').children().html('Enter a Valid Email Address !');
        return false;
    }
    else{
        $('[name="email"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------MESSAGE-VALIDATON----------
function message_validation(){
    const input_value = $('[name="message"]').val();
    if(input_value==''){
        $('[name="message"]').next().removeClass('d_none').children().html('Please Enter Message !');
        return false;
    }
    else{
        $('[name="message"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------SUBJECT-VALIDATON----------
function subject_validation(){
    const input_value = $('[name="subject"]').val();
    if(input_value==''){
        $('[name="subject"]').next().removeClass('d_none').children().html('Please Select a Subject !');
        return false;
    }
    else{
        $('[name="subject"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------SUBJECT-VALIDATON----------
function language_validation(){
    const input_value = $('[name="language"]').val();
    if(input_value==''){
        $('[name="language"]').next().removeClass('d_none').children().html('Please Select a language !');
        return false;
    }
    else{
        $('[name="language"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------PASSWORD-VALIDATON----------
function password_validation(){
    const input_value = $('[name="password"]').val();
    if(input_value==''){
        $('[name="password"]').next().removeClass('d_none').children().html('Please Enter Password !');
        return false;
    }
    else if(PasswordRegEx.test(input_value)==false){
        $('[name="password"]').next().removeClass('d_none').children().html('Please a Valid Password!');
        return false;
    }
    else{
        $('[name="password"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------CONFIRM-PASSWORD-VALIDATON----------
function cpassword_validation(){
    const password = $('[name="password"]').val();
    const cpassword = $('[name="cpassword"]').val();
    if(cpassword==''){
        $('[name="cpassword"]').next().removeClass('d_none').children().html('Please Enter a Confirm Password !');
        return false;
    }
    else if(PasswordRegEx.test(cpassword)==false){
        $('[name="cpassword"]').next().removeClass('d_none').children().html('Please a Valid Password!');
        return false;
    }
    else if(cpassword!==password){
        $('[name="cpassword"]').next().removeClass('d_none').children().html('Password & Confirm Password not Matched!');
        return false;
    }
    else{
        $('[name="cpassword"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------LOGIN-EMAIL-ADDRESS-VALIDATION----------
function login_email_validation(){
    const input_value = $('[name="login_email"]').val();
    if(input_value==''){
        $('[name="login_email"]').parent().next().removeClass('d_none').children().html('Please Enter Email Address !');
        return false;
    }
    else if(EmailRegEx.test(input_value)==false){
        $('[name="login_email"]').parent().next().removeClass('d_none').children().html('Enter a Valid Email Address !');
        return false;
    }
    else{
        $('[name="login_email"]').parent().next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------LOGIN -PASSWORD-VALIDATON----------
function login_password_validation(){
    const input_value = $('[name="login_password"]').val();
    if(input_value==''){
        $('[name="login_password"]').parent().next().removeClass('d_none').children().html('Please Enter Password !');
        return false;
    }
    else if(PasswordRegEx.test(input_value)==false){
        $('[name="login_password"]').parent().next().removeClass('d_none').children().html('Please a Valid Password!');
        return false;
    }
    else{
        $('[name="login_password"]').parent().next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------CHANGE-PASSWORD-OLD-VALIDATON----------
function change_password_old_validation(){
    const input_value = $('[name="change_password_old"]').val();
    if(input_value==''){
        $('[name="change_password_old"]').next().removeClass('d_none').children().html('Please Enter Old Password !');
        return false;
    }
    // else if(PasswordRegEx.test(input_value)==false){
    //     $('[name="change_password_old"]').next().removeClass('d_none').children().html('Please a Valid Password!');
    //     return false;
    // }
    else{
        $('[name="change_password_old"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------CHANGE-PASSWORD-NEW-VALIDATON----------
function change_password_new_validation(){
    const input_value = $('[name="change_password_new"]').val();
    if(input_value==''){
        $('[name="change_password_new"]').next().removeClass('d_none').children().html('Please Enter a New Password !');
        return false;
    }
    else if(PasswordRegEx.test(input_value)==false){
        $('[name="change_password_new"]').next().removeClass('d_none').children().html('Please a Valid Password!');
        return false;
    }
    else{
        $('[name="change_password_new"]').next().addClass('d_none').children().html('');
        return true;
    }
    
}

// ----------CHANGE-PASSWORD-CONFIRM-VALIDATON----------
function change_password_confirm_validation(){
    const password = $('[name="change_password_new"]').val();
    const cpassword = $('[name="change_password_confirm"]').val();
    if(cpassword==''){
        $('[name="change_password_confirm"]').next().removeClass('d_none').children().html('Please Enter a Confirm Password !');
        return false;
    }
    else if(PasswordRegEx.test(cpassword)==false){
        $('[name="change_password_confirm"]').next().removeClass('d_none').children().html('Please a Valid Password!');
        return false;
    }
    else if(cpassword!==password){
        $('[name="change_password_confirm"]').next().removeClass('d_none').children().html('Password & Confirm Password not Matched!');
        return false;
    }
    else{
        $('[name="change_password_confirm"]').next().addClass('d_none').children().html('');
        return true;
    }    
}

// ----------FORGOT-PASSWORD-EMAIL-ADDRESS-VALIDATION----------
function forgot_password_email_validation(){
    const input_value = $('[name="forgot_password_email"]').val();
    if(input_value==''){
        $('[name="forgot_password_email"]').next().removeClass('d_none').children().html('Please Enter Email Address !');
        return false;
    }
    else if(EmailRegEx.test(input_value)==false){
        $('[name="forgot_password_email"]').next().removeClass('d_none').children().html('Enter a Valid Email Address !');
        return false;
    }
    else{
        $('[name="forgot_password_email"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------OTP-VALIDATON----------
function otp_validation(){
    const input_value = parseInt($('[name="otp"]').val());
    if(input_value==''){
        $('[name="otp"]').next().removeClass('d_none').children().html('Please Enter OTP !');
        return false;
    }
    else if(parseInt(input_value.toString().length)!==4){
        $('[name="otp"]').next().removeClass('d_none').children().html('Invalid OTP !');
        return false;
    }
    else{
        $('[name="otp"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------SET_NEW_PASSWORD-VALIDATON----------
function set_new_password_validation(){
    const input_value = $('[name="set_new_password"]').val();
    if(input_value==''){
        $('[name="set_new_password"]').next().removeClass('d_none').children().html('Please Enter Password !');
        return false;
    }
    else if(PasswordRegEx.test(input_value)==false){
        $('[name="set_new_password"]').next().removeClass('d_none').children().html('Please a Valid Password!');
        return false;
    }
    else{
        $('[name="set_new_password"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------SET_NEW_CONFIRM-PASSWORD-VALIDATON----------
function set_new_cpassword_validation(){
    const password = $('[name="set_new_password"]').val();
    const cpassword = $('[name="set_new_cpassword"]').val();
    if(cpassword==''){
        $('[name="set_new_cpassword"]').next().removeClass('d_none').children().html('Please Enter a Confirm Password !');
        return false;
    }
    else if(cpassword!==password){
        $('[name="set_new_cpassword"]').next().removeClass('d_none').children().html('Password & Confirm Password not Matched!');
        return false;
    }
    else{
        $('[name="set_new_cpassword"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------SETUP-SERVICE-POSTAL-CODE-VALIDATON----------
function setup_service_postal_code_validation(){
    const postal_code = $('[name="setup_service_postal_code"]').val();
    if(postal_code==''){
        $('[name="setup_service_postal_code"]').next().removeClass('d_none').children().html('Please Enter Postal Code !');
        return false;
    }
    else if(PostalCodeRegEx.test(postal_code)==false){
        $('[name="setup_service_postal_code"]').next().removeClass('d_none').children().html('Postal Code Shoud be a Min:5 or Max:6 Digits !');
        return false;
    }
    else{
        $('[name="setup_service_postal_code"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------SCHEDULE-DATE-VALIDATON----------
function schedule_date_validation(){
    const selectedDate = $('[name="schedule_date"]').val();
    const minDate = $('[name="schedule_date"]').attr('min');
    const minDateObj = new Date(minDate);
    const selectedDateObj = new Date(selectedDate);
    if(selectedDate==undefined || selectedDate==""){
        $('[name="schedule_date"]').parent().next().removeClass('d_none').children().html('Please Select Date !');
        return false;
    }
    else if(selectedDateObj.getTime() < minDateObj.getTime()){
        // IF SELECTED DATE IS LESS THEN THE MIN DATE... IT IS INVALID...
        $('[name="schedule_date"]').parent().next().removeClass('d_none').children().html('Invalid Date Selection!');
        return false;
    }
    else{
        $('[name="schedule_date"]').parent().next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------SCHEDULE-TIME-VALIDATON----------
function schedule_time_validation(){
    const min = $('[name="schedule_time"]').attr('min');
    const max = $('[name="schedule_time"]').attr('max');
    const input_val = $('[name="schedule_time"]').val();
    const minTime = (new Date(`1999-09-20 ${min}`)).getTime();
    const maxTime = (new Date(`1999-09-20 ${max}`)).getTime();
    const selectedTime = (new Date(`1999-09-20 ${input_val}`)).getTime();

    if(input_val=="" || input_val==undefined){
        $('[name="schedule_time"]').next().removeClass('d_none').children().html('Please Select a Time !');
        return false;
    }
    else if(selectedTime < minTime || selectedTime > maxTime){
        $('[name="schedule_time"]').next().removeClass('d_none').children().html('Select a time in range of 08:00 AM to 06:00 PM!');
        return false;
    }
    else{
        $('[name="schedule_time"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------ADDRESS-FORM-STREET-NAME-VALIDATON----------
function address_form_street_name_validation(){
    const input_value = $('[name="address_form_street_name"]').val();
    if(input_value==''){
        $('[name="address_form_street_name"]').next().removeClass('d_none').children().html('Please Enter Street Name !');
        return false;
    }
    else if(TextRegEx.test(input_value)==false){
        $('[name="address_form_street_name"]').next().removeClass('d_none').children().html('Street Name Should be Min 3 Characters Required !');
        return false;
    }
    else{
        $('[name="address_form_street_name"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------ADDRESS-FORM-HOUSE-NUMBER-VALIDATON----------
function address_form_house_number_validation(){
    const input_value = $('[name="address_form_house_number"]').val();
    if(input_value==''){
        $('[name="address_form_house_number"]').next().removeClass('d_none').children().html('Please Enter a House Number!');
        return false;
    }
    else if(HouseNumberRegEx.test(input_value)==false){
        $('[name="address_form_house_number"]').next().removeClass('d_none').children().html('House Number Should be Numbers !');
        return false;
    }
    else{
        $('[name="address_form_house_number"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------ADDRESS-FORM-POSTAL-CODE-VALIDATON----------
function address_form_postal_code_validation(){
    const input_value = $('[name="address_form_postal_code"]').val();
    if(input_value==''){
        $('[name="address_form_postal_code"]').next().removeClass('d_none').children().html('Please Enter Postal Code !');
        return false;
    }
    else if(PostalCodeRegEx.test(input_value)==false){
        $('[name="address_form_postal_code"]').next().removeClass('d_none').children().html('Postal Code Shoud be a Min:5 or Max:6 Digits !');
        return false;
    }
    else{
        $('[name="address_form_postal_code"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------ADDRESS-FORM-CITY-VALIDATON----------
function address_form_city_validation(){
    const input_value = $('[name="address_form_city"]').val();
    if(input_value==''){
        $('[name="address_form_city"]').next().removeClass('d_none').children().html('Please Enter City Name !');
        return false;
    }
    else if(TextRegEx.test(input_value)==false){
        $('[name="address_form_city"]').next().removeClass('d_none').children().html('City should be min 3 characters required!');
        return false;
    }
    else{
        $('[name="address_form_city"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------ADDRESS-FORM-PHONE-VALIDATON----------
function address_form_phone_validation(){
    const input_value = $('[name="address_form_phone"]').val();
    if(input_value==''){
        $('[name="address_form_phone"]').parent().next().removeClass('d_none').children().html('Please Enter Phone Number !');
        return false;
    }
    else if(PhoneRegEx.test(input_value)==false){
        $('[name="address_form_phone"]').parent().next().removeClass('d_none').children().html('Phone Number Should be a 10 Digits !');
        return false;
    }
    else{
        $('[name="address_form_phone"]').parent().next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------BOOK-SERVICES-ADDRESS-VALIDATON----------
function book_service_address_validation(){
    const input_value = $('[name="service_booking_address"]:checked').val();
    if(input_value==undefined || input_value==""){
        $('#your_details_submit_btn').prev().removeClass('d_none').children().html('Please Add or Select Address !');
        return false;
    }
    else{
        $('#your_details_submit_btn').prev().addClass('d_none').children().html('');
        return true;
    }
}


// ----------ADD-ADDRESS-STREET-NAME-VALIDATON----------
function add_address_street_name_validation(){
    const input_value = $('[name="add_address_street_name"]').val();
    if(input_value==''){
        $('[name="add_address_street_name"]').next().removeClass('d_none').children().html('Please Enter Street Name !');
        return false;
    }
    else if(TextRegEx.test(input_value)==false){
        $('[name="add_address_street_name"]').next().removeClass('d_none').children().html('Street Name Should be a Min 3 Characters required!');
        return false;
    }
    else{
        $('[name="add_address_street_name"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------ADD-ADDRESS-HOUSE-NUMBER-VALIDATON----------
function add_address_house_number_validation(){
    const input_value = $('[name="add_address_house_number"]').val();
    if(input_value==''){
        $('[name="add_address_house_number"]').next().removeClass('d_none').children().html('Please Enter a House Number!');
        return false;
    }
    else if(HouseNumberRegEx.test(input_value)==false){
        $('[name="add_address_house_number"]').next().removeClass('d_none').children().html('House Number Should be Numbers !');
        return false;
    }
    else{
        $('[name="add_address_house_number"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------ADD-ADDRESS-POSTAL-CODE-VALIDATON----------
function add_address_postal_code_validation(){
    const input_value = $('[name="add_address_postal_code"]').val();
    if(input_value==''){
        $('[name="add_address_postal_code"]').next().removeClass('d_none').children().html('Please Enter Postal Code !');
        return false;
    }
    else if(PostalCodeRegEx.test(input_value)==false){
        $('[name="add_address_postal_code"]').next().removeClass('d_none').children().html('Postal Code Shoud be a Min:5 or Max:6 Digits !');
        return false;
    }
    else{
        $('[name="add_address_postal_code"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------ADD-ADDRESS-CITY-VALIDATON----------
function add_address_city_validation(){
    const input_value = $('[name="add_address_city"]').val();
    if(input_value==''){
        $('[name="add_address_city"]').next().removeClass('d_none').children().html('Please Enter City Name !');
        return false;
    }
    else if(TextRegEx.test(input_value)==false){
        $('[name="add_address_city"]').next().removeClass('d_none').children().html('City should be min 3 characters required!');
        return false;
    }
    else{
        $('[name="add_address_city"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------ADD-ADDRESS-PHONE-VALIDATON----------
function add_address_phone_validation(){
    const input_value = $('[name="add_address_phone"]').val();
    if(input_value==''){
        $('[name="add_address_phone"]').parent().next().removeClass('d_none').children().html('Please Enter Phone Number !');
        return false;
    }
    else if(PhoneRegEx.test(input_value)==false){
        $('[name="add_address_phone"]').parent().next().removeClass('d_none').children().html('Phone Number Should be a 10 Digits !');
        return false;
    }
    else{
        $('[name="add_address_phone"]').parent().next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------EDIT-ADDRESS-STREET-NAME-VALIDATON----------
function edit_address_street_name_validation(){
    const input_value = $('[name="edit_address_street_name"]').val();
    if(input_value==''){
        $('[name="edit_address_street_name"]').next().removeClass('d_none').children().html('Please Enter Street Name !');
        return false;
    }
    else if(TextRegEx.test(input_value)==false){
        $('[name="edit_address_street_name"]').next().removeClass('d_none').children().html('Street Name should be min 3 characters required!');
        return false;
    }
    else{
        $('[name="edit_address_street_name"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------EDIT-ADDRESS-HOUSE-NUMBER-VALIDATON----------
function edit_address_house_number_validation(){
    const input_value = $('[name="edit_address_house_number"]').val();
    if(input_value==''){
        $('[name="edit_address_house_number"]').next().removeClass('d_none').children().html('Please Enter a House Number!');
        return false;
    }
    else if(HouseNumberRegEx.test(input_value)==false){
        $('[name="edit_address_house_number"]').next().removeClass('d_none').children().html('House Number Should be Numbers !');
        return false;
    }
    else{
        $('[name="edit_address_house_number"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------EDIT-ADDRESS-POSTAL-CODE-VALIDATON----------
function edit_address_postal_code_validation(){
    const input_value = $('[name="edit_address_postal_code"]').val();
    if(input_value==''){
        $('[name="edit_address_postal_code"]').next().removeClass('d_none').children().html('Please Enter Postal Code !');
        return false;
    }
    else if(PostalCodeRegEx.test(input_value)==false){
        $('[name="edit_address_postal_code"]').next().removeClass('d_none').children().html('Postal Code Shoud be a Min:5 or Max:6 Digits !');
        return false;
    }
    else{
        $('[name="edit_address_postal_code"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------EDIT-ADDRESS-CITY-VALIDATON----------
function edit_address_city_validation(){
    const input_value = $('[name="edit_address_city"]').val();
    if(input_value==''){
        $('[name="edit_address_city"]').next().removeClass('d_none').children().html('Please Enter City Name !');
        return false;
    }
    else if(TextRegEx.test(input_value)==false){
        $('[name="edit_address_city"]').next().removeClass('d_none').children().html('City should be min 3 characters required!');
        return false;
    }
    else{
        $('[name="edit_address_city"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------EDIT-ADDRESS-PHONE-VALIDATON----------
function edit_address_phone_validation(){
    const input_value = $('[name="edit_address_phone"]').val();
    if(input_value==''){
        $('[name="edit_address_phone"]').parent().next().removeClass('d_none').children().html('Please Enter Phone Number !');
        return false;
    }
    else if(PhoneRegEx.test(input_value)==false){
        $('[name="edit_address_phone"]').parent().next().removeClass('d_none').children().html('Phone Number Should be a 10 Digits !');
        return false;
    }
    else{
        $('[name="edit_address_phone"]').parent().next().addClass('d_none').children().html('');
        return true;
    }
}

// -------------------DATE OF BIRTH VALIDATION-----------
function dob_validation(){
    const input_val = $('[name="dob"]').val();    
    const user = new Date(input_val);
    if(input_val==""){
        $('[name="dob"]').next().removeClass('d_none').children().html('Please Select Date Of Birth !')
        return false;
    }
    else if(user.getTime() > (new Date()).getTime()){
        $('[name="dob"]').next().removeClass('d_none').children().html('Please Select a Valid Date !')
        return false;
    }
    else{
        $('[name="dob"]').next().addClass('d_none').children().html('')
        return true;
    }
}

// -------------------CANCEL REQUEST VALIDATON-----------
function cancel_service_validation(){
    const input_val = $('[name="cancel_service_reason"]').val();    
    if(input_val==""){
        $('[name="cancel_service_reason"]').next().removeClass('d_none').children().html('Please write a reason for cancel service !')
        return false;
    }
    else{
        $('[name="cancel_service_reason"]').next().addClass('d_none').children().html('')
        return true;
    }
}

// ----------SCHEDULE-DATE-AND-TIME-VALIDATON----------
function reschedule_service_validation(){
    let input_date = $('[name="reschedule_service_date"]').val();    
    let input_time = $('[name="reschedule_service_time"]').val();    
    let minDate    = $('[name="reschedule_service_date"]').attr('min');
    let minTime    = $('[name="reschedule_service_time"]').attr('min');
    let maxTime    = $('[name="reschedule_service_time"]').attr('max');
    let minDateObj      = new Date(minDate);
    let minTimeObj      = new Date(`1999-09-20 ${minTime}`)
    let maxTimeObj      = new Date(`1999-09-20 ${maxTime}`)
    let selectedTimeObj = new Date(`1999-09-20 ${input_time}`)
    let selectedDateObj = new Date(`${input_date}`);

    if(input_date==""){
        $('[name="reschedule_service_date"]').parent().next().removeClass('d_none').children().html('Please Enter a new date!')
        return false;
    }
    else if(input_time==""){
        $('[name="reschedule_service_date"]').parent().next().removeClass('d_none').children().html('Please Enter a new time !')
        return false;
    }
    else if(selectedTimeObj.getTime() < minTimeObj.getTime() || selectedTimeObj.getTime() > maxTimeObj.getTime()){
        $('[name="reschedule_service_date"]').parent().next().removeClass('d_none').children().html('Select a time in range of 08:00 AM to 06:00 PM!')
        return false;
    }
    else if(selectedDateObj.getTime() < minDateObj.getTime()){
        $('[name="reschedule_service_date"]').parent().next().removeClass('d_none').children().html('Invalid Date Selection!')
        return false;
    }
    else{
        $('[name="reschedule_service_date"]').parent().next().addClass('d_none').children().html('')
        return true;
    }
}

// ----------RATING-FEEDBACK-VALIDATON----------
function rating_feedback_validation(){
    const input_value = $('[name="rating_feedback"]').val();
    const quality_rating = $('[name="quality_rating"]:checked').val();
    const arrival_rating = $('[name="arrival_rating"]:checked').val();
    const friendly_rating = $('[name="friendly_rating"]:checked').val();
    if(input_value=="" || arrival_rating=="" || quality_rating=="" || friendly_rating==""){
        $('[name="rating_feedback"]').next().removeClass('d_none').children().html('Please Give Feedback & Rating!');
        return false;
    }   
    else{
        $('[name="rating_feedback"]').next().removeClass('d_none').children().html('');
        return true;
    } 
}

// ----------SP-MY-ADDRESS-STREET-NAME-VALIDATON----------
function street_name_validation(){
    const input_value = $('[name="street_name"]').val();
    if(input_value==''){
        $('[name="street_name"]').next().removeClass('d_none').children().html('Please Enter Street Name !');
        return false;
    }
    else if(TextRegEx.test(input_value)==false){
        $('[name="street_name"]').next().removeClass('d_none').children().html('Street Name should be min 3 characters required!');
        return false;
    }
    else{
        $('[name="street_name"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------SP-MY-ADDRESS-HOUSE-NUMBER-VALIDATON----------
function house_number_validation(){
    const input_value = $('[name="house_number"]').val();
    if(input_value==''){
        $('[name="house_number"]').next().removeClass('d_none').children().html('Please Enter a House Number!');
        return false;
    }
    else if(HouseNumberRegEx.test(input_value)==false){
        $('[name="house_number"]').next().removeClass('d_none').children().html('House Number Should be Numbers !');
        return false;
    }
    else{
        $('[name="house_number"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------SP-MY-ADDRESS-POSTAL-CODE-VALIDATON----------
function postal_code_validation(){
    const input_value = $('[name="postal_code"]').val();
    if(input_value==''){
        $('[name="postal_code"]').next().removeClass('d_none').children().html('Please Enter Postal Code !');
        return false;
    }
    else if(PostalCodeRegEx.test(input_value)==false){
        $('[name="postal_code"]').next().removeClass('d_none').children().html('Postal Code Shoud be a Min:5 or Max:6 Digits !');
        return false;
    }
    else{
        $('[name="postal_code"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------SP-MY-ADDRESS-CITY-VALIDATON----------
function city_validation(){
    const input_value = $('[name="city"]').val();
    if(input_value==''){
        $('[name="city"]').next().removeClass('d_none').children().html('Please Enter City Name !');
        return false;
    }
    else if(TextRegEx.test(input_value)==false){
        $('[name="city"]').next().removeClass('d_none').children().html('City should be min 3 characters required!');
        return false;
    }
    else{
        $('[name="city"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// --------------EDIT-SERVICE-REQUEST-VALIDATION--------------
function edit_service_street_name_validation(){
    const input_value = $('[name="edit_service_street_name"]').val();
    if(input_value==''){
        $('[name="edit_service_street_name"]').next().removeClass('d_none').children().html('Please Enter Street Name !');
        return false;
    }
    else if(TextRegEx.test(input_value)==false){
        $('[name="edit_service_street_name"]').next().removeClass('d_none').children().html('Street Name should be min 3 characters required!');
        return false;
    }
    else{
        $('[name="edit_service_street_name"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------SP-MY-ADDRESS-HOUSE-NUMBER-VALIDATON----------
function edit_service_house_number_validation(){
    const input_value = $('[name="edit_service_house_number"]').val();
    if(input_value==''){
        $('[name="edit_service_house_number"]').next().removeClass('d_none').children().html('Please Enter a House Number!');
        return false;
    }
    else if(HouseNumberRegEx.test(input_value)==false){
        $('[name="edit_service_house_number"]').next().removeClass('d_none').children().html('House Number Should be Numbers !');
        return false;
    }
    else{
        $('[name="edit_service_house_number"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------SP-MY-ADDRESS-POSTAL-CODE-VALIDATON----------
function edit_service_postal_code_validation(){
    const input_value = $('[name="edit_service_postal_code"]').val();
    if(input_value==''){
        $('[name="edit_service_postal_code"]').next().removeClass('d_none').children().html('Please Enter Postal Code !');
        return false;
    }
    else if(PostalCodeRegEx.test(input_value)==false){
        $('[name="edit_service_postal_code"]').next().removeClass('d_none').children().html('Postal Code Shoud be a Min:5 or Max:6 Digits !');
        return false;
    }
    else{
        $('[name="edit_service_postal_code"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------SP-MY-ADDRESS-CITY-VALIDATON----------
function edit_service_city_validation(){
    const input_value = $('[name="edit_service_city"]').val();
    if(input_value==''){
        $('[name="edit_service_city"]').next().removeClass('d_none').children().html('Please Enter City Name !');
        return false;
    }
    else if(TextRegEx.test(input_value)==false){
        $('[name="edit_service_city"]').next().removeClass('d_none').children().html('City should be min 3 characters required!');
        return false;
    }
    else{
        $('[name="edit_service_city"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------EDIT-SERVICE-VALIDATON----------
function edit_service_date_validation(){
    const selectedDate = $('[name="edit_service_date"]').val();
    const minDate = $('[name="edit_service_date"]').attr('min');
    const minDateObj = new Date(minDate);
    const selectedDateObj = new Date(selectedDate);
    if(selectedDate==undefined || selectedDate==""){
        $('[name="edit_service_date"]').next().removeClass('d_none').children().html('Please Select Date !');
        return false;
    }
    else if(selectedDateObj.getTime() < minDateObj.getTime()){
        // IF SELECTED DATE IS LESS THEN THE MIN DATE... IT IS INVALID...
        $('[name="edit_service_date"]').next().removeClass('d_none').children().html('Invalid Date Selection!');
        return false;
    }
    else{
        $('[name="edit_service_date"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// ----------SCHEDULE-TIME-VALIDATON----------
function edit_service_time_validation(){
    const min = $('[name="edit_service_time"]').attr('min');
    const max = $('[name="edit_service_time"]').attr('max');
    const input_val = $('[name="edit_service_time"]').val();
    const minTime = (new Date(`1999-09-20 ${min}`)).getTime();
    const maxTime = (new Date(`1999-09-20 ${max}`)).getTime();
    const selectedTime = (new Date(`1999-09-20 ${input_val}`)).getTime();

    if(input_val=="" || input_val==undefined){
        $('[name="edit_service_time"]').next().removeClass('d_none').children().html('Please Select a Time !');
        return false;
    }
    else if(selectedTime < minTime || selectedTime > maxTime){
        $('[name="edit_service_time"]').next().removeClass('d_none').children().html('Select a time in range of 08:00 AM to 06:00 PM!');
        return false;
    }
    else{
        $('[name="edit_service_time"]').next().addClass('d_none').children().html('');
        return true;
    }
}

// -------------------CONTACTUS, SIGNUP, PROFILE-----------
$('[name="firstname"]').focusout(function(){
    firstname_validation();    
});

$('[name="lastname"]').focusout(function(){
    lastname_validation();
});

$('[name="phone"]').focusout(function(){
    phone_validation();
});

$('[name="email"]').focusout(function(){
    email_validation();
});

$('[name="password"]').focusout(function(){
    password_validation();
});

$('[name="cpassword"]').focusout(function(){
    cpassword_validation();
});

// --------------CONTACT-US-----------------
$('[name="message"]').focusout(function(){
    message_validation();
});

$('[name="subject"]').focusout(function(){
    subject_validation();
});    

$('[name="language"]').focusout(function(){
    language_validation();
});    

// -----------------LOGIN----------
$('[name="login_email"]').focusout(function(){
    login_email_validation();
});

$('[name="login_password"]').focusout(function(){
    login_password_validation();
});

// ----------------CHANGE-PASSWORD-----------------
$('[name="change_password_old"]').focusout(function(){
    change_password_old_validation();
});

$('[name="change_password_new"]').focusout(function(){
    change_password_new_validation();
});

$('[name="change_password_confirm"]').focusout(function(){
    change_password_confirm_validation();
});

// -----------------FORGOT-PASSWORD------------
$('[name="forgot_password_email"]').focusout(function(){
    forgot_password_email_validation();
});

$('[name="otp"]').focusout(function(){
    otp_validation();
});        

$('[name="set_new_password"]').focusout(function(){
    set_new_password_validation();
});

$('[name="set_new_cpassword"]').focusout(function(){
    set_new_cpassword_validation();
});

// ------------BOOK-SERVICE-S1-VALIDATION------------
$('[name="setup_service_postal_code"]').focusout(function(){
    setup_service_postal_code_validation();
});

// ------------BOOK-SERVICE-S2-VALIDATION------------
$('[name="schedule_date"]').change(function(){
    schedule_date_validation();
});

$('[name="schedule_time"]').change(function(){
    schedule_time_validation();
});

// ------------BOOK-SERVICE-S3-VALIDATION------------
$('[name="address_form_street_name"]').focusout(function(){
    address_form_street_name_validation();
});

$('[name="address_form_house_number"]').focusout(function(){
    address_form_house_number_validation();
});

$('[name="address_form_postal_code"]').focusout(function(){
    address_form_postal_code_validation();
});

$('[name="address_form_city"]').focusout(function(){
    address_form_city_validation();
});

$('[name="address_form_phone"]').focusout(function(){
    address_form_phone_validation();
});

// -----------ADD ADDRESS -POPUP-MODEL-------------------
$('[name="add_address_street_name"]').focusout(function(){
    add_address_street_name_validation();
});

$('[name="add_address_house_number"]').focusout(function(){
    add_address_house_number_validation();
});

$('[name="add_address_postal_code"]').focusout(function(){
    add_address_postal_code_validation();
});

$('[name="add_address_city"]').focusout(function(){
    add_address_city_validation();
});

$('[name="add_address_phone"]').focusout(function(){
    add_address_phone_validation();
});



// -----------EDIT ADDRESS -POPUP-MODEL-------------------
$('[name="edit_address_street_name"]').focusout(function(){
    edit_address_street_name_validation();
});

$('[name="edit_address_house_number"]').focusout(function(){
    edit_address_house_number_validation();
});

$('[name="edit_address_postal_code"]').focusout(function(){
    edit_address_postal_code_validation();
});

$('[name="edit_address_city"]').focusout(function(){
    edit_address_city_validation();
});

$('[name="edit_address_phone"]').focusout(function(){
    edit_address_phone_validation();
});

$('[name="dob"]').focusout(function(){
    dob_validation();
});

// ------------CUSTOMER DASHBOARD POPUP VALIDATION-----------------
$('[name="cancel_service_reason"]').focusout(function(){
    cancel_service_validation();
});

$('[name="reschedule_service_date"]').focusout(function(){
    reschedule_service_validation();
});

$('[name="reschedule_service_time"]').focusout(function(){
    reschedule_service_validation();
});

$('[name="rating_feedback"]').focusout(function(){
    rating_feedback_validation();
});

// ----------SP MY ADDRESS VALIDATON----------
// -----------EDIT ADDRESS -POPUP-MODEL-------------------
$('[name="street_name"]').focusout(function(){
    street_name_validation();
});

$('[name="house_number"]').focusout(function(){
    house_number_validation();
});

$('[name="postal_code"]').focusout(function(){
    postal_code_validation();
});

$('[name="city"]').focusout(function(){
    city_validation();
});

// -----------EDIT SERVICE REQUEST POPUP MODEL-------------------
$('[name="edit_service_date"]').focusout(function(){
    edit_service_date_validation();
});

$('[name="edit_service_time"]').focusout(function(){
    edit_service_time_validation();
});

// -----------EDIT SERVICE REQUEST POPUP MODEL (SERVICE ADDRESS)-------------------
$('[name="edit_service_street_name"]').focusout(function(){
    edit_service_street_name_validation();
});

$('[name="edit_service_house_number"]').focusout(function(){
    edit_service_house_number_validation();
});

$('[name="edit_service_city"]').focusout(function(){
    edit_service_city_validation();
});

$('[name="edit_service_postal_code"]').focusout(function(){
    edit_service_postal_code_validation();
});


// let date = new Date();
// let yyyy = date.getFullYear();
// let mm = date.getMonth()+1;
// let dd = date.getDate();
// let tdd = date.getDate()+1; // TOMORROW DATE...
// mm = mm<10? `0${mm}` : mm;
// dd = dd<10? `0${dd}` : dd;
// tdd = tdd<10? `0${tdd}`: tdd;
// let today = `${yyyy}-${mm}-${dd}`;
// let tomorrow = `${yyyy}-${mm}-${tdd}`;

