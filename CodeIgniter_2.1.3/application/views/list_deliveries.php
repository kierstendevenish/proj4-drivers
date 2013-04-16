<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
   <title>Deliveries</title>
 </head>
 <body>
   <h1>Deliveries:</h1><br>
   <table border='1' rules='all'>
       <tr>
           <th>Flowershop</th>
           <th>Delivery ID</th>
           <th>Pickup Time</th>
           <th>Address</th>
           <th>Delivery Time</th>
           <th>Delivered</th>
       </tr>
   <?php if (count($deliveries) > 0):
        foreach ($deliveries as $bid):
            echo "<tr><td>" . $bid['fs_esl'] . "</td><td>" . $bid['delivery_id'] . "</td><td>" . $bid['pickupTime'] . "</td><td>".$bid['deliveryAddr']."</td><td>".$bid['deliveryTime']."</td><td><a href='".base_url()."/index.php/delivered/".$bid['deliveryId']."/".$bid['fs_esl']."'>Delivered</a></td></tr>";
        endforeach;
   endif; ?>
   </table>
 </body>
</html>