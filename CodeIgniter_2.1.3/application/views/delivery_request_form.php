<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
   <title>Flower Shop - New Request</title>
 </head>
 <body>
   <h1>Create a delivery request:</h1>
   <?php echo validation_errors(); ?>
   <?php echo form_open('delivery/sendRequest'); ?>
     <label for="username">Flowershop Address:</label>
     <input type="text" size="20" id="shopAddr" name="shopAddr"/>
     <br/>
     <label for="password">Pickup Time:</label>
     <input type="text" size="10" id="pickupTime" name="pickupTime"/>
     <br/>
     <label for="phone">Delivery Address:</label>
     <input type="text" size="100" id="deliveryAddr" name="deliveryAddr"/>
     <br/>
     <label for="esl">Delivery Time:</label>
     <input type="text" size="10" id="deliveryTime" name="deliveryTime"/>
     <br/>
     <input type="submit" value="Send Request"/>
    </form><br><br>
 </body>
</html>