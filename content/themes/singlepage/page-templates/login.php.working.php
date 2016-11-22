<?php
/*
* Template Name: Login
*/

get_header();
?>

<div class="wrapper">
<div class="wp_login_form">
<div class="form_heading">Custom Login Form</div>

<?php
$args = array(
'redirect' => home_url(),
'id_username' => 'user',
'id_password' => 'pass',
)
;?>

<?php wp_login_form( $args ); ?>
	<?php
	/* for Registration */

	/*
	$website = "http://example.com";
	$userdata = array(
		'user_login'  =>  'login_name',
		'user_url'    =>  $website,
		'user_pass'   =>  NULL,  // When creating an user, `user_pass` is expected.
		'first_name' => NULL,
		'last_name' => NULL
	);

	$user_id = wp_insert_user( $userdata ) ;

	//On success
	if ( ! is_wp_error( $user_id ) ) {
		echo "User created : ". $user_id;
	}
	*/
	?>
<?php get_footer() ?>

</div>

<style>

.wp_login_form{
border: 1px solid rgb(162, 46, 51);
width: 400px;
height: 350px;
border-radius: 5px;
margin-left: 35%;
}

.form_heading{
width: 380px;
height: 42px;
background-color: rgb(162, 46, 51);
color: #fff;
padding-top: 15px;
padding-left: 20px;
font-size: 20px;
}

form{
margin-left: 50px;
}

label{
clear:both;
margin-right: 200px;
}

.input{
height: 35px;
width: 270px;
border: 1px solid rgb(201, 201, 201);
background-color: rgb(238, 235, 236);
radius-border: 3px;
}

#wp-submit{
height: 35px;
width: 90px;
border: 1px rgb(162, 46, 51);
background-color: rgb(162, 46, 51);
border-radius: 3px;
color: #fff;
}

.error-msg{
color: red;
margin-left: 35%;
position: relative;
}

</style>