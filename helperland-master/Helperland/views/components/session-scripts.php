<?php if(flashSession('openLoginForm')){ ?>
	<!-- ----------OPEN_LOGIN_FORM---------- -->
	<script> open_model('login'); </script>
<?php } ?>


<?php if(flashSession('openForgotPasswordForm')){ ?>
	<!-- ----------OPEN_FORGOT_PASSWORD---------- -->
	<script> open_model('forgot_password'); </script>
<?php } ?>


<?php if(flashSession('logout')){ ?>
	<!-- ----------LOGOUT---------- -->
	<script> Swal.fire({ title : `Logout Successfully`, icon : 'success' }); </script>
<?php } ?>


<?php if(flashSession('accountVerified')){ ?>
	<!-- ----------ACCOUNT VERIFYED STATUS---------- -->
	<script> Swal.fire({ title : `Account Verified Successfully.`, icon : 'success' }); </script>
<?php } ?>

