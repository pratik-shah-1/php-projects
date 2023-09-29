@extends('shopers.master')
@section('title','MyBooks-Shopers')
@section('content')

@if(session('disable'))
  <script>swal('Account is Disabled','Ask to Admin','warning');</script>
@endif

@if(session()->has('signup'))
  <script>swal('Signup Successfully...','','success');</script>
@elseif(session()->has('wrong'))
    <script>swal('Enter Correct Details...','','error');</script>
@endif

<!-- Main Container -->
<main class="my-5 px-3">
  <!--- Login Form ---->
    <form class='s_login' method="POST" action="/shoper/signin">
        @csrf
        <p>Login</p>

        <div>
          <label>Email Address or Mobile</label>
          <input class="form-control" type="text" name="email" required>
          <p class="email_error_msg d-none text-danger m-0 small">Helo This is Error</p>
        </div>

        <div>
          <label>Password</label>
          <input class="form-control" type="password" name="pswd" required>
          <p class="pswd_error_msg d-none text-danger m-0 small">Helo This is Error</p>
        </div>

        <div>
          <label></label>
          <input class='mt-2 btn btn-outline-primary' type="submit" value="Login">
        </div>

        <div class='flex-row justify-content-center pt-2'>
          <p class='m-0 mr-2'>Not a Member?</p>
          <a class='signup_btn' href="#">Signup</a>
        </div>    
    </form>

  <!--- Signup Form ---->
  <form class='s_signup d-none' method="POST" action="/shoper/signup">
    @csrf
    <p>Signup</p>
    <div class='section_1'>
      <p>Shop Info</p>
      
      <div>
          <label>State</label>
          <select class="form-control" name="state" onchange="find_city(this.value);">
          @foreach($state as $i)
          <option value="{{$i->state}}">{{$i->state}}</option>
          @endforeach
          </select>
      </div>
      
      <div>
        <label>City</label>
        <select name="city" class="form-control">
        @foreach($city as $j)
        <option value="{{$j->city}}">{{$j->city}}</option>
        @endforeach
        </select>
      </div>
      
      <div>
        <label>Shop Address</label>
        <textarea class="form-control" name="adrs"></textarea>
        <!-- <input class="form-control" type="text" name="adrs" required> -->
        <p class="address_error_msg d-none text-danger m-0 small">Helo This is Error</p>
      </div>
      
      <div>
        <label>Zip Code</label>
        <input class="form-control" type="text" name="zcode" required>
        <p class="zcode_error_msg d-none text-danger m-0 small">Helo This is Error</p>
      </div>
      
      <div class='flex-row justify-content-end pt-2'> 
        <button class='btn btn-primary next_btn' href="">Next</button>
      </div>
      
      <div class='flex-row justify-content-center pt-2'>
        <p class='m-0 mr-2'>Already Member?</p>
        <a class='login_btn' href="#">Login</a>
      </div>
    
    </div>
    <div class='section_2 d-none'>
      <p>Shoper Info</p>
      
      <div>
        <label>Full Name</label>
        <input class="form-control" type="text" name="name" required>
        <p class="name_error_msg d-none text-danger m-0 small"></p>
      </div>
      
      <div>
        <label>Mobile Number</label>
        <input class="form-control" type="text" name="mobile" required>
        <p class="mobile_error_msg d-none text-danger m-0 small"></p>
      </div>
      
      <div>
        <label>Email Address</label>
        <input class="form-control" type="text" name="email" required>
        <p class="email_error_msg d-none text-danger m-0 small"></p>
      </div>
      
      <div>
        <label>Password</label>
        <input class="form-control" type="password" name="pswd" required>
        <p class="pswd_error_msg d-none text-danger m-0 small"></p>
      </div>
      
      <div>
        <label>Confirm Password</label>
        <input class="form-control" type="password" name="cpswd" required>
        <p class="cpswd_error_msg d-none text-danger m-0 small"></p>
      </div>
      
      <div class='flex-row align-item-center justify-content-between pt-2'> 
        <button class='btn btn-outline-primary prev_btn' href="">Previous</button>
        <button class='btn btn-primary'>Signup</button>
      </div>
    </div>
  </form>
</main>

<script>
  
  function find_city(state){
    const city_option = $('[name="city"]')[0];
    $.ajax({
      url:'/find_city/'+state, 
      method: 'GET',
      success:function(res){
        const city = JSON.parse(res);
        city_option.innerHTML = "";
        for(let i = 0; i< city.length; i++){
          city_option.innerHTML += "<option value='"+city[i]['city']+"'>"+city[i]['city']+"</option>";        
        }
      }
    });
  }

  $('.login_btn').click(function(e){
    e.preventDefault();
    $('.s_login').removeClass('d-none');
    $('.s_signup').addClass('d-none');
  });

  $('.signup_btn').click(function(e){
    e.preventDefault();
    $('.s_signup').removeClass('d-none');
    $('.s_login').addClass('d-none');
  }); 

  $('.next_btn').click(function(e){
    e.preventDefault();
    $('.section_1').addClass('d-none');
    $('.section_2').removeClass('d-none');
  });

  $('.prev_btn').click(function(e){
    e.preventDefault();
    $('.section_1').removeClass('d-none');
    $('.section_2').addClass('d-none');
  });


  $('[name="email"]').focusout(function(){
    const val = $(this).val();
    const reg = /^[a-zA-Z0-9.]+@[a-zA-Z0-9]+(\.[a-zA-Z]{2,})+$/;
    $('.email_error_msg').removeClass('d-none').html('');
        if(val == ""){
          $('.email_error_msg').html('Email Address cannot be blank!');
            $(this).addClass('is-invalid');
        }
        else if(!reg.test(val)){
          $('.email_error_msg').html('Please Enter Valid Email Address!!!');
            $(this).addClass('is-invalid');
        }
        else{
            $('.email_error_msg').html('').addClass('d-none');
            $(this).addClass('is-valid').removeClass('is-invalid');
        }
  });


  //-----------------------------------------------------
  //      Password Validation
  //-----------------------------------------------------
  $('[name="pswd"]').focusout(function(){
    const val = $(this).val();
    const reg = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;        
    
    $('.pswd_error_msg').removeClass('d-none').html('');
        
        if(val == ""){
          $('.pswd_error_msg').html('Password Field cannot be blank!');
            $(this).addClass('is-invalid');
        }
        else if(!reg.test(val)){
          $('.pswd_error_msg').html('Make combo of special character, digits and capital!');
            $(this).addClass('is-invalid');
        }
        else{
            $('.pswd_error_msg').html('');
            $(this).addClass('is-valid').removeClass('is-invalid');
        }
  });

  $('[name="cpswd"]').keyup(function(){
    const val = $(this).val();
    const prev_val = $('[name="pswd"]:nth(1)').val();

    $('.cpswd_error_msg').removeClass('d-none').html('');
        if(val == ""){
          $('.cpswd_error_msg').html('Confirm Password Filed Cannot be Blank !!!');
            $(this).addClass('is-invalid');
        }
        else if(val != prev_val){
          $('.cpswd_error_msg').html('Password and Confirm Password Not Match!!!');
            $(this).addClass('is-invalid');
        }
        else{
            $('.cpswd_error_msg').html('');
            $(this).addClass('is-valid').removeClass('is-invalid');
        }
  });

  //-----------------------------------------------------
  //      Mobile Validation
  //-----------------------------------------------------
  $('[name="mobile"]').focusout(function(){
    const val = $(this).val();
    const reg = /^[0-9]{10}$/;

    $('.mobile_error_msg').removeClass('d-none').html('');
        
        if(val == ""){
          $('.mobile_error_msg').html('Mobile Field cannot be blank!');
            $(this).addClass('is-invalid');
        }
        else if(!reg.test(val)){
          $('.mobile_error_msg').html('Mobile Number Must be 10 Digits!!!');
            $(this).addClass('is-invalid');
        }
        else{
            $('.mobile_error_msg').html('');
            $(this).addClass('is-valid').removeClass('is-invalid');
        }
  });

  //-----------------------------------------------------
  //      Zip Code Validation
  //-----------------------------------------------------
  $('[name="zcode"]').focusout(function(){
    const val = $(this).val();
    const reg = /^[0-9]{6}$/;

    $('.zcode_error_msg').removeClass('d-none').html('');        
        if(val == ""){
          $('.zcode_error_msg').html('Zip Code Field cannot be blank!');
            $(this).addClass('is-invalid');
        }
        else if(!reg.test(val)){
          $('.zcode_error_msg').html('Zip Code Must be 6 Digits!!!');
            $(this).addClass('is-invalid');
        }
        else{
            $('.zcode_error_msg').html('');
            $(this).addClass('is-valid').removeClass('is-invalid');
        }
  });

  //-----------------------------------------------------
  //      Full Name Validation
  //-----------------------------------------------------
  $('[name="name"]').focusout(function(){
    const val = $(this).val();
    const reg = /^[A-Za-z]/;        
    $('.name_error_msg').removeClass('d-none').html('');
        
        if(val == ""){
          $('.name_error_msg').html('Name Field cannot be blank!');
            $(this).addClass('is-invalid');
        }
        else if(!reg.test(val)){
          $('.name_error_msg').html('Please Enter only Alphabets !!!');
            $(this).addClass('is-invalid');
        }
        else{
            $('.name_error_msg').html('');
            $(this).addClass('is-valid').removeClass('is-invalid');
        }
  });

</script>
@endsection
