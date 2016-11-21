<?php
/*
* Template Name: Login
*/
?>
<?php
get_header();
?>

<style type="text/css">
	/* tabbed list */
	ul.tabs_login {
		padding: 0; margin: 20px 0 0 0;
		position: relative;
		list-style: none;
		font-size: 14px;
		z-index: 1000;
		float: left;
	}
/*
	ul.tabs_login li {

		border: 0px solid #E7E9F6;
		-webkit-border-top-right-radius: 2px;
		-khtml-border-radius-topright: 2px;
		-moz-border-radius-topright: 2px;
		border-top-right-radius: 2px;
		-webkit-border-top-left-radius: 2px;
		-khtml-border-radius-topleft: 2px;
		-moz-border-radius-topleft: 2px;
		border-top-left-radius: 2px;
		line-height: 28px;
		padding: 10px;
		margin: 0px 5px 0 0;
		position: relative;
		background: #fff;
		overflow: hidden;
		float: left;
	}

	ul.tabs_login li a {
		text-decoration: none;
		padding: 0 10px;
		display: block;
		outline: none;
	}
	*/

	html ul.tabs_login li.active_login {
		border-left: 1px solid #E7E9F6;
		border-top: 1px solid #E7E9F6;
		border-right: 1px solid #E7E9F6;
		border-bottom: 1px solid #fff;
		-webkit-border-top-right-radius:2px;
		-khtml-border-radius-topright: 2px;
		-moz-border-radius-topright: 2px;
		border-top-right-radius: 2px;
		-webkit-border-top-left-radius: 2px;
		-khtml-border-radius-topleft: 2px;
		-moz-border-radius-topleft: 2px;
		border-top-left-radius: 2px;
		background: #fff;
		color: #333;
	}
	html body ul.tabs_login li.active_login a {
		font-weight: bold;
		background: #fff;
		border: 1px solid #ffffff;
	}
	.tab_container_login {
		background: #fff;
		position: relative;
		margin: 0 0 20px 0;
		border: 1px solid #E7E9F6;
		-webkit-border-bottom-left-radius: 2px;
		-khtml-border-radius-bottomleft: 2px;
		-moz-border-radius-bottomleft: 2px;
		border-bottom-left-radius: 2px;
		-webkit-border-bottom-right-radius: 2px;
		-khtml-border-radius-bottomright: 2px;
		-moz-border-radius-bottomright: 2px;
		border-bottom-right-radius: 2px;
		-webkit-border-top-right-radius: 2px;
		-khtml-border-radius-topright: 2px;
		-moz-border-radius-topright: 2px;
		border-top-right-radius: 2px;
		z-index: 999;
		float: left;
		width: 100%;
		top: -1px;
	}

	.nav>li>a:active, .nav>li>a:focus {
		background-color: none;
	}

	.tab_content_login {
		padding: 7px 15px 15px 15px;
		padding-top: 10px;
	}
	.tab_content_login ul {
		padding: 0; margin: 0 0 0 15px;
	}
	.tab_content_login li { margin: 5px 0; }
	/* global styles */
	#login-register-password {}
	#login-register-password h3 {
		border: 0 none;
		margin: 10px 0;
		padding: 0;
	}
	#login-register-password p {
		margin: 0 0 15px 0;
		padding: 0;
	}
	/* form elements */
	.wp-user-form {}
	.username, .password, .login_fields, .address, .name, .telephone  {
		margin: 7px 0 0 0;
		overflow: hidden;
		width: 100%;
	}


	.username label, .password label, .address label, .name label, .telephone label { float: left; clear: none; width: 25%; }
	.username input, .password input, .address input, .name input, .telephone input {
		font: 12px/1.5 "Lucida Grande", "Lucida Sans Unicode", Verdana, sans-serif;
		float: left; clear: none; width: 200px; padding: 2px 3px; color: #777;
	}
	.rememberme { overflow: hidden; width: 100%; margin-bottom: 7px; }
	#rememberme { float: left; clear: none; margin: 4px 4px -4px 0; }
	.user-submit { padding: 5px 10px; margin: 5px 0; }
	.userinfo { float: left; clear: none; width: 75%; margin-bottom: 10px; }
	.userinfo p {
		margin-left: 10px;
	}
	.usericon { float: left; clear: none; width: 15%; margin: 0 0 10px 22px; }
	.usericon img {
		border: 1px solid #F4950E;
		padding: 1px;
	}
</style>




<div id="login-register-password" class="search-main-container">

	<?php global $user_ID, $user_identity; get_currentuserinfo(); if (!$user_ID) { ?>

		<ul class="nav nav-tabs tabs_login">
			<li class="nav-item active_login"><a href="#tab1_login" class="nav-link">Login</a></li>
			<li class="nav-item"><a href="#tab2_login" class="nav-link">Register</a></li>
			<li class="nav-item"><a href="#tab3_login" class="nav-link">Forgot?</a></li>
		</ul>
		<div class="tab_container_login">
			<div id="tab1_login" class="tab_content_login">

				<?php $register = $_GET['register']; $reset = $_GET['reset']; if ($register == true) { ?>

					<h3>Success!</h3>
					<p>Check your email for the password and then return to log in.</p>

				<?php } elseif ($reset == true) { ?>

					<h3>Success!</h3>
					<p>Check your email to reset your password.</p>

				<?php } else { ?>

					<h3>Have an account?</h3>
					<p>Log in or sign up! It&rsquo;s fast &amp; <em>free!</em></p>

				<?php } ?>

				<form method="post" action="<?php bloginfo('url') ?>/wp-login.php" class="wp-user-form">
					<div class="username">
						<label for="user_login"><?php _e('Username'); ?>: </label>
						<input type="text" name="log" value="<?php echo esc_attr(stripslashes($user_login)); ?>" size="20" id="user_login" tabindex="11" />
					</div>
					<div class="password">
						<label for="user_pass"><?php _e('Password'); ?>: </label>
						<input type="password" name="pwd" value="" size="20" id="user_pass" tabindex="12" />
					</div>
					<div class="login_fields">
						<div class="rememberme">
							<label for="rememberme">
								<input type="checkbox" name="rememberme" value="forever" checked="checked" id="rememberme" tabindex="13" /> Remember me
							</label>
						</div>
						<?php do_action('login_form'); ?>
						<input type="submit" name="user-submit" value="<?php _e('Login'); ?>" tabindex="14" class="user-submit" />
						<!--<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />-->
						<!-- TO DO -->
						<input type="hidden" name="redirect_to" value="<?php echo 'http://realonline.imareal.sbg.ac.at.local/wp-admin/;' ?>" />
						<input type="hidden" name="user-cookie" value="1" />
					</div>
				</form>
			</div>
			<div id="tab2_login" class="tab_content_login" style="display:none;">
				<h3>Register for this site!</h3>
				<p>Sign up now for the good stuff.</p>
				<form method="post" action="<?php echo site_url('wp-login.php?action=register', 'login_post') ?>" class="wp-user-form">
					<!-- Registrierung Felder -->
					<div class="username">
						<label for="user_login"><?php _e('Ihr Benutzername *'); ?>: </label>
						<input type="text" name="user_login" value="<?php echo esc_attr(stripslashes($user_login)); ?>" size="20" id="user_login" tabindex="101" />
					</div>
					<div class="password">
						<label for="user_email"><?php _e('E-Mail *'); ?>: </label>
						<input type="text" name="user_email" value="<?php echo esc_attr(stripslashes($user_email)); ?>" size="25" id="user_email" tabindex="102" />
					</div>

					<div class="name">
						<label for="first_name"><?php _e('Vorname *'); ?>: </label>
						<input type="text" name="first_name" value="<?php echo esc_attr(stripslashes($first_name)); ?>" size="35" id="first_name" tabindex="102" />
					</div>
					<div class="name">
						<label for="last_name"><?php _e('Nachname *'); ?>: </label>
						<input type="text" name="last_name" value="<?php echo esc_attr(stripslashes($last_name)); ?>" size="35" id="last_name" tabindex="102" />
					</div>
					<hr>
					<div class="address">
						<label for="address"><?php _e('Adresse'); ?>: </label>
						<input type="text" name="address" value="<?php echo esc_attr(stripslashes($address)); ?>" size="40" id="address" tabindex="102" />
					</div>

					<div class="address">
						<label for="address"><?php _e('Stadt'); ?>: </label>
						<input type="text" name="address" value="<?php echo esc_attr(stripslashes($address)); ?>" size="40" id="address" tabindex="102" />
					</div>
					<div class="address">
						<label for="address"><?php _e('Land'); ?>: </label>
						<input type="text" name="address" value="<?php echo esc_attr(stripslashes($address)); ?>" size="40" id="address" tabindex="102" />
					</div>
					<div class="address">
						<label for="address"><?php _e('Postleitzahl / ZIP Code'); ?>: </label>
						<input type="text" name="address" value="<?php echo esc_attr(stripslashes($address)); ?>" size="40" id="address" tabindex="102" />
					</div>

					<div class="telephone">
						<label for="user_email"><?php _e('Telefon'); ?>: </label>
						<input type="text" name="user_email" value="<?php echo esc_attr(stripslashes($user_email)); ?>" size="25" id="user_email" tabindex="102" />
					</div>
					<div class="password">
						<label for="user_email"><?php _e('Institution / Firma'); ?>: </label>
						<input type="text" name="user_email" value="<?php echo esc_attr(stripslashes($user_email)); ?>" size="25" id="user_email" tabindex="102" />
					</div>
					<div class="password">
						<label for="user_email"><?php _e(' UID der Institution / Firma'); ?>: </label>
						<input type="text" name="user_email" value="<?php echo esc_attr(stripslashes($user_email)); ?>" size="25" id="user_email" tabindex="102" />
					</div>
					<hr>
					<div class="address">
						<label for="address"><?php _e('Website'); ?>: </label>
						<input type="text" name="address" value="<?php echo esc_attr(stripslashes($address)); ?>" size="40" id="address" tabindex="102" />
					</div>
					<div class="address">
						<label for="address"><?php _e('Geburtsdatum'); ?>: </label>
						<input type="text" name="address" value="<?php echo esc_attr(stripslashes($address)); ?>" size="40" id="address" tabindex="102" />
					</div>



					<div class="login_fields">
						<?php do_action('register_form'); ?>
						<input type="submit" name="user-submit" value="<?php _e('Sign up!'); ?>" class="user-submit" tabindex="103" />
						<?php $register = $_GET['register']; if($register == true) { echo '<p>Check your email for the password!</p>'; } ?>
						<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>?register=true" />
						<input type="hidden" name="user-cookie" value="1" />
					</div>
				</form>
			</div>
			<div id="tab3_login" class="tab_content_login" style="display:none;">
				<h3>Lose something?</h3>
				<p>Enter your username or email to reset your password.</p>
				<form method="post" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" class="wp-user-form">
					<div class="username">
						<label for="user_login" class="hide"><?php _e('Username or Email'); ?>: </label>
						<input type="text" name="user_login" value="" size="20" id="user_login" tabindex="1001" />
					</div>
					<div class="login_fields">
						<?php do_action('login_form', 'resetpass'); ?>
						<input type="submit" name="user-submit" value="<?php _e('Reset my password'); ?>" class="user-submit" tabindex="1002" />
						<?php $reset = $_GET['reset']; if($reset == true) { echo '<p>A message will be sent to your email address.</p>'; } ?>
						<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>?reset=true" />
						<input type="hidden" name="user-cookie" value="1" />
					</div>
				</form>
			</div>
		</div>

	<?php } else { // is logged in ?>

		<div class="sidebox">
			<h3>Welcome, <?php echo $user_identity; ?></h3>
			<div class="usericon">
				<?php global $userdata; get_currentuserinfo(); echo get_avatar($userdata->ID, 60); ?>

			</div>
			<div class="userinfo">
				<p>You&rsquo;re logged in as <strong><?php echo $user_identity; ?></strong></p>
				<p>
					<a href="<?php echo wp_logout_url('index.php'); ?>">Log out</a> |
					<?php if (current_user_can('manage_options')) {
						echo '<a href="' . admin_url() . '">' . __('Admin') . '</a>'; } else {
						echo '<a href="' . admin_url() . 'profile.php">' . __('Profile') . '</a>'; } ?>

				</p>
			</div>
		</div>

	<?php } ?>

</div>
</div>
<?php
get_footer();
?>


<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$(".tab_content_login").hide();
		$("ul.tabs_login li:first").addClass("active_login").show();
		$(".tab_content_login:first").show();
		$("ul.tabs_login li").click(function() {
			$("ul.tabs_login li").removeClass("active_login");
			$(this).addClass("active_login");
			$(".tab_content_login").hide();
			var activeTab = $(this).find("a").attr("href");
			//if ($.browser.msie) {$(activeTab).show();}
			//else {
			$(activeTab).show(); //)}
			return false;
		});
	});
</script>
