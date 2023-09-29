<?= component('header'); ?>

<!-- **********GUARANTEE_MAIN********** -->

<!-- BANNER -->
<div class="banner">
    <img src="<?= assets('assets/img/banner/guarantee.png'); ?>" alt="">
</div>	


<main class="guarantee">

    <!-- SECTION-1 -->
    <div class="guarantee_s1">
        <!-- TITLE -->
        <div class="title_with_icon">
            <p>Our Guarantee</p>
            <div>
                <div><img src="<?= assets('assets/img/global/separator.png'); ?>" alt=""></div>
            </div>
        </div>

        <div>
            <div class="gurantee_s1_sp_card_container">
                <!-- SP-RATED-CARD -->
                <div class="gurantee_s1_sp_card">
                    <div class="service_provider">
                        <img class="hat_style" src="<?= assets('assets/img/table/hat.png'); ?>" alt="">
                        <div>
                            <p>Lyum Watson</p>    
                            <div>
                                <i class="fas fa-star rated_star"></i>
                                <i class="fas fa-star rated_star"></i>
                                <i class="fas fa-star rated_star"></i>
                                <i class="fas fa-star rated_star"></i>
                                <i class="fas fa-star unrated_star"></i>
                                <span>4</span>
                            </div>
                        </div>
                    </div>
                    <p>Rating by Amjad to Haroon Scotyt Smith</p>
                </div>
                <div class="gurantee_s1_sp_card">
                    <div class="service_provider">
                        <img class="hat_style" src="<?= assets('assets/img/table/hat.png'); ?>" alt="">
                        <div>
                            <p>Lyum Watson</p>    
                            <div>
                                <i class="fas fa-star rated_star"></i>
                                <i class="fas fa-star rated_star"></i>
                                <i class="fas fa-star rated_star"></i>
                                <i class="fas fa-star rated_star"></i>
                                <i class="fas fa-star unrated_star"></i>
                                <span>4</span>
                            </div>
                        </div>
                    </div>
                    <p>Rating by Amjad to Haroon Scotyt Smith</p>
                </div>
            </div>
            <div class="guarantee_s1_right">
                <p class="guarantee_s1_title">Experienced cleaners for your home</p>
                <p class="guarantee_s1_para">Your satisfaction is important to us, so we only provide cleaners who meet our requirements. Before a cleaner can call themselves a “helper”, they go through a strict selection process. Among other things, we require a valid ID, trade license and a certificate of good conduct. To ensure that our helpers always give their best, we have introduced a rating system. It allows you to directly evaluate your helper's performance. It serves both motivation and quality assurance.</p>
            </div>	
        </div>

    </div><!-- END-SECTION-1 -->

    <div class="guarantee_s2">
        <div class="title_with_icon">
            <p>Double protection</p>
            <div style="background-color: #eef8fa;">
                <div style="background-color: #eef8fa;"><img src="<?= assets('assets/img/global/separator.png'); ?>" alt=""></div>
            </div>
        </div>	
        <p class="guarantee_s2_para">Mishaps happen to all of us from time to time. As a rule, the damage can be settled quickly via the liability insurance of the cleaning staff. For double protection, we have taken out insurance that can also step in in the event of larger amounts of damage. In the event of damage, we will not leave you alone.</p>
    </div>

    <div class="guarantee_s3">
        <div>
            <img src="<?= assets('assets/img/global/guarantee.png'); ?>" alt="">
        </div>
        <div class="guarantee_s3_para">
            <p>Your satisfaction is our motivation</p>
            <p>We don't know what makes you happy, but if it's not dusting, our friendly helpers will relieve you of this burden. Don't fret anymore that valuable time is wasted on housework, but enjoy life to the full. You are worth filling your time with beautiful experiences. You can find suggestions for your free time on our blog. Have a look or follow us on Facebook so you don't miss a tip.</p>
            <br>
            <p>Our first tip for you: finally free yourself and enjoy the time you have gained. Book your helper now!</p>	
        </div>
        <div>
            <a class="form_btn" href="<?= url('/book-now') ?>">Book Now</a>
        </div>
    </div>


</main>

<?= component('footer'); ?>
