<?php

Class Request extends CI_Model
{
        function create($shopAddr, $pickupTime, $deliveryAddr, $deliveryTime)
        {
                $db = new PDO('sqlite:./application/db/deliveryDrivers');
                $result = $db->query("INSERT INTO Requests (shopAddr, pickupTime, deliveryAddr, deliveryTime, delivered) VALUES ('" . $shopAddr . "','" . $pickupTime . "','" . $deliveryAddr . "','" . $deliveryTime . "',0);");
        }
        
        function allOpen()
        {
                $db = new PDO('sqlite:./application/db/deliveryDrivers');
                $result = $db->query("SELECT * FROM Requests WHERE delivered=0;");
                return $result;
        }

        function makeBid($username, $id, $fs_esl, $deliveryTime, $deliveryAddr, $pickupTime)
        {
            $db = new PDO('sqlite:./application/db/deliveryDrivers');
            $result = $db->query("INSERT INTO Bids VALUES ('" . $username . "','" . $fs_esl . "','" . $id . "','" . $deliveryAddr . "','" . $deliveryTime . "','" . $pickupTime . "', 0, 0);");
        }

        function calcDistance($startLat, $startLong, $endLat, $endLong)
        {
            return sqrt(pow(($endLat - $startLat), 2) + pow(($endLong - $startLong), 2));
        }

        function getReqDeliveryId()
        {
            $db = new PDO('sqlite:./application/db/deliveryDrivers');
            $result = $db->query("SELECT dataValue FROM appDataString WHERE dataKey='deliveryId';");

            if(count($result) == 1)
                {
                    foreach ($result as $row)
                    {
                        $data = $row['dataValue'];
                    }

                    return $data;
                }

                return '';
        }

        function getReqShopEsl()
        {
            $db = new PDO('sqlite:./application/db/deliveryDrivers');
            $result = $db->query("SELECT dataValue FROM appDataString WHERE dataKey='fs_esl';");

            if(count($result) == 1)
                {
                    foreach ($result as $row)
                    {
                        $data = $row['dataValue'];
                    }

                    return $data;
                }

                return '';
        }

        function getReqDeliveryTime()
        {
            $db = new PDO('sqlite:./application/db/deliveryDrivers');
            $result = $db->query("SELECT dataValue FROM appDataString WHERE dataKey='deliveryTime';");

            if(count($result) == 1)
                {
                    foreach ($result as $row)
                    {
                        $data = $row['dataValue'];
                    }

                    return $data;
                }

                return '';
        }

        function getReqDeliveryAddr()
        {
            $db = new PDO('sqlite:./application/db/deliveryDrivers');
            $result = $db->query("SELECT dataValue FROM appDataString WHERE dataKey='deliveryAddr';");

            if(count($result) == 1)
                {
                    foreach ($result as $row)
                    {
                        $data = $row['dataValue'];
                    }

                    return $data;
                }

                return '';
        }

        function getReqPickupTime()
        {
            $db = new PDO('sqlite:./application/db/deliveryDrivers');
            $result = $db->query("SELECT dataValue FROM appDataString WHERE dataKey='pickupTime';");

            if(count($result) == 1)
                {
                    foreach ($result as $row)
                    {
                        $data = $row['dataValue'];
                    }

                    return $data;
                }

                return '';
        }

        function bidAccepted($username = '', $deliveryId = '')
        {
            $db = new PDO('sqlite:./application/db/deliveryDrivers');
            $result = $db->query("UPDATE Bids SET accepted=1 WHERE username='".$username."' AND delivery_id='".$deliveryId."';");
        }

        function getShopEslByRequest($deliveryId = '')
        {
            $db = new PDO('sqlite:./application/db/deliveryDrivers');
            $result = $db->query("SELECT fs_esl FROM Bids WHERE delivery_id='".$deliveryId."';");

            if(count($result) == 1)
                {
                    foreach ($result as $row)
                    {
                        $data = $row['fs_esl'];
                    }

                    return $data;
                }

                return '';
        }

        function delivered($username, $deliveryId)
        {
            $db = new PDO('sqlite:./application/db/deliveryDrivers');
            $db->query("UPDATE Bids SET delivered=1 WHERE username='".$username."' AND delivery_id='".$deliveryId."';");
        }
}
?>