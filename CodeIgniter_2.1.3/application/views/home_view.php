
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <body>
   <h2>Welcome <?php echo $username; ?>!</h2><br>
   You last checked in at: <?php echo $lat . ", " . $long; ?><br><br>
   <a href='driver/foursquareAuth' target='_blank'>Connect with Foursquare</a><br>
   <a href='driver/listEsls'>View Esls</a><br>
   <a href='driver/listBids'>Bid History</a><br>
   <a href='driver/deliveries'>Deliveries</a><br>
   
   <br><a href="home/logout">Logout</a>
 </body>
</html>


