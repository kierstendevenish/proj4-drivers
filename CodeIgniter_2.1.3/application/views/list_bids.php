<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
   <title>Bids</title>
 </head>
 <body>
   <h1>Pending Bids:</h1><br>
   <table border='1' rules='all'>
       <tr>
           <th>Flowershop</th>
           <th>Delivery ID</th>
           <th>Pickup Time</th>
           <th>Address</th>
           <th>Delivery Time</th>
       </tr>
   <?php if (count($bids) > 0):
        foreach ($bids as $bid):
            echo "<tr><td>" . $bid['fs_esl'] . "</td><td>" . $bid['delivery_id'] . "</td><td>" . $bid['pickupTime'] . "</td><td>".$bid['deliveryAddr']."</td><td>".$bid['deliveryTime']."</td></tr>";
        endforeach;
   endif; ?>
   </table>
 </body>
</html>