<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
   <title>Delivery Driver - Register</title>
 </head>
 <body>
   <h1>Register for an account:</h1>
   <?php echo validation_errors(); ?>
   <?php echo form_open('register/save'); ?>
     <label for="username">Username:</label>
     <input type="text" size="20" id="username" name="username"/>
     <br/>
     <label for="password">Password:</label>
     <input type="password" size="20" id="password" name="password"/>
     <br/>
    <label for="name">Name:</label>
     <input type="text" size="25" id="name" name="name"/>
     <br/>
     <label for="phone">Phone Number (for SMS):</label>
     <input type="text" size="11" id="phone" name="phone"/>
     <br/>
     <label for="rate">Rate:</label>
     <input type="text" size="6" id="rate" name="rate"/>
     <br/>
     <input type="submit" value="Register"/>
    </form><br><br>
 </body>
</html>