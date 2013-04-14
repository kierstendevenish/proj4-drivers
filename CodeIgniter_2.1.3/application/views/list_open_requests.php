<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
   <title>Flower Shop - Open Requests</title>
 </head>
 <body>
   <h1>Open delivery requests:</h1>
   <table>
       <tr>
           <th>Pickup Time</th>
           <th>Delivery Time</th>
           <th>Delivery Address</th>
       </tr>
   <?php if (count($requests) > 0):
        foreach ($requests as $req):
            echo "<tr><td>" . $req['pickupTime'] . "</td><td>" . $req['deliveryTime'] . "</td><td>" . $req['deliveryAddr'] . "</td></tr>";
        endforeach;
   endif; ?>
   </table>
 </body>
</html>