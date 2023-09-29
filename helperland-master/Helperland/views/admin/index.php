<?= component('admin-header'); ?>

<!-- **********ADMIN_PANEL********** -->
<main class="admin_panel">

    <div class="admin_left">
        <div class="admin_tab_list">
            <a class="admin_tab_btn active_admin_tab_btn" href="javascript:void(0)">Service Requests</a>
            <a class="admin_tab_btn" href="javascript:void(0)">User Management</a>
        </div><!-- END_ADMIN_TAB_LIST -->
    </div><!-- END_ADMIN_LEFT -->

    <div class="admin_right">

        <div class="admin_tab_content">
            <?= component('admin/', 'service-requests') ?>
        </div>

        <div class="admin_tab_content d_none">
            <?= component('admin/', 'user-management') ?>
        </div>

        <!-- ----------ADMIN FOOTER---------- -->
        <div class="admin_copyright_line">
            <p>©2022 Helperland. All rights reserved.</p>
        </div><!-- END_FOOTER -->        
    </div><!-- END_ADMIN_RIGHT -->
</main><!-- END_ADMIN_PANEL -->

<!-- EXCEL2TABLE -->
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<!-- DATATABLE -->
<script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<!-- AOS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<!-- TITL-JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tilt.js/1.0.3/tilt.jquery.min.js"></script>
<!-- SWEET-ALERT -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- CUSTOM_JAVASCRIPT -->
<script src="<?= assets('assets/js/accordion.js'); ?>"></script>
<script src="<?= assets('assets/js/avatar.js'); ?>"></script>
<script src="<?= assets('assets/js/admintab.js'); ?>"></script>
<script src="<?= assets('assets/js/dropdown.js'); ?>"></script>
<script src="<?= assets('assets/js/footer.js'); ?>"></script>
<script src="<?= assets('assets/js/homenav.js'); ?>"></script>
<script src="<?= assets('assets/js/label.js'); ?>"></script>
<script src="<?= assets('assets/js/model.js'); ?>"></script>
<script src="<?= assets('assets/js/navtabs.js'); ?>"></script>
<script src="<?= assets('assets/js/sidenav.js'); ?>"></script>
<script src="<?= assets('assets/js/tabletab.js'); ?>"></script>
<script src="<?= assets('assets/js/validation.js'); ?>"></script>
<script src="<?= assets('assets/js/loader.js'); ?>"></script>

<script>
    // (CALL EACH TIME WHEN THE CHANGES IN DATATABLE)
    function dropdown_issue_callback(){
        const dropdown_btn = $('.dropdown_btn');
        const dropdown_menu = $('.dropdown_menu');
        
        for(let i=0; i<dropdown_btn.length; i++){
            dropdown_btn[i].addEventListener('click', ()=>{
                dropdown_menu[i].classList.toggle('d_none');
                for(let j=0; j<dropdown_btn.length; j++){
                    if(j!==i){
                        dropdown_menu[j].classList.add('d_none');
                    }
                }
            });
        }
        
        window.onclick = function(event) {
            if (!event.target.matches('.dropdown_btn')) {
                const dropdowns = $(".dropdown_menu");
                for (let i = 0; i < dropdowns.length; i++) {
                    dropdowns[i].classList.add('d_none');
                }
            }
        }
        
        for(let i=0; i<dropdown_btn.length; i++){
        dropdown_btn[i].addEventListener('click',function(event){
                event.stopPropagation();
            });
        }        
    }
</script>
