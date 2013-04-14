Create an account
<?php 
echo form_open('pages/login');
echo form_input('username', $username);
echo form_input('password');
echo form_submit('loginSubmit', "Login");
echo form_close();
 ?>
<br>
