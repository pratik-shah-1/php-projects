<?php

use Illuminate\Support\Facades\Route;

//------------CONTROLLERS--------------
use App\Http\Controllers\Admin;
use App\Http\Controllers\BackgroundImages;
use App\Http\Controllers\ContactDetails;
use App\Http\Controllers\FooterText;
use App\Http\Controllers\IntroCard;
use App\Http\Controllers\Portfolio;
use App\Http\Controllers\ArrangePortfolio;
use App\Http\Controllers\TopPortfolio;
use App\Http\Controllers\Resume;
use App\Http\Controllers\SocialMediaLinks;
use App\Http\Controllers\General;
use App\Http\Controllers\ContactForm;
//--------------------------
//      GENERAL ROUTES...
//--------------------------
Route::get('/', [General::class, 'home_view']);
Route::get('/portfolio', [General::class, 'portfolio_view']);
Route::get('/contact', [General::class, 'contact_view']);



//--------------------------
//      ADMIN ROUTES
//      NAMED---> ROUTES LOGIN, WELCOME, LOGOUT 
//--------------------------


//-----------UPLOAD ROUTES--------------
Route::get('/admin', [Admin::class, 'login_view'])->name('login');
Route::post('/admin/auth', [Admin::class, 'auth']);
Route::post('/send_mail', [ContactForm::class, 'send_mail']);

// CONTACT FORM MAIL SYSTEM VIEW
Route::get('/mail_view', function(){
    $arr = ['name' => 'Gaurav', 
            'email' => 'gauravbarai9@gmail.com',
            'msg' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Et rerum excepturi mollitia, similique iusto, aspernatur veritatis maiores asperiores culpa tempore voluptatum omnis molestiae suscipit ad veniam temporibus repellendus dolores quam cumque quis necessitatibus odit quas? Minus, qui, vel? Exercitationem ipsa soluta expedita, provident. Ut nemo eum illum et excepturi a.'];
    return view('general.mail', $arr);
});


//-----------PROTECTED VIEW ROUTES-----------
Route::middleware(['auth'])->group(function (){
    Route::get('/admin/intro-card', [IntroCard::class, 'view']);
    Route::get('/admin/backgrounds', [BackgroundImages::class, 'view']);
    Route::get('/admin/footer-text', [FooterText::class, 'view']);
    Route::get('/admin/contact-details', [ContactDetails::class, 'view']);
    Route::get('/admin/resume', [Resume::class, 'view']);
    Route::get('/admin/social-media-links', [SocialMediaLinks::class, 'view']);
    Route::get('/admin/portfolio/add', [Portfolio::class, 'add_view']);
    Route::get('/admin/portfolio/view', [Portfolio::class, 'list_view']);
    Route::get('/admin/portfolio/edit/{id}', [Portfolio::class, 'edit_view']);
    Route::get('/admin/logout', [Admin::class, 'logout']);
    Route::get('/admin/portfolio/arrange', [ArrangePortfolio::class, 'view']);
    Route::get('/admin/portfolio/top-3', [TopPortfolio::class, 'view']);
    Route::view('/admin/welcome', 'admin.welcome')->name('welcome');
});

//-----------PROTECTED ADD-UPDATE ROUTES--------------
Route::middleware(['auth'])->group(function () {
    Route::post('background_images/upload', [BackgroundImages::class, 'upload']);
    Route::post('/resume/upload', [Resume::class, 'upload']);
    Route::post('/contact_details/upload', [ContactDetails::class, 'upload']);
    Route::post('/footer_text/upload', [FooterText::class, 'upload']);
    Route::post('/intro_card/upload', [IntroCard::class, 'upload']);
    Route::post('/social_media_links/add', [SocialMediaLinks::class, 'add']);
    Route::post('/social_media_links/edit/{id}', [SocialMediaLinks::class, 'edit']);
    Route::post('/social_media_links/arrange', [SocialMediaLinks::class, 'arrange']);
    Route::get('/social_media_links/remove/{id}', [SocialMediaLinks::class, 'remove']);    
    Route::post('/portfolio/upload/', [Portfolio::class, 'add']);
    Route::post('/portfolio/edit/{id}', [Portfolio::class, 'edit']);
    Route::post('/portfolio/set_top3', [TopPortfolio::class, 'set']);
    Route::post('/portfolio/arrange', [ArrangePortfolio::class, 'arrange']);
    Route::get('/portfolio/remove/{id}', [Portfolio::class, 'remove']);    
});


