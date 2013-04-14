<?php

Class User extends CI_Model
{

	function login($username, $password)
	{
		$db = new PDO('sqlite:./application/db/deliveryDrivers');
		$result = $db->query("SELECT * FROM Users WHERE username='" . $username . "' AND password='" . $password . "' LIMIT 1;");


		if(count($result) == 1)
		{
		     return $result;
		}
		else
		{
		     return false;
		}
	}
        
        function getEsl($username)
        {
                $db = new PDO('sqlite:./application/db/deliveryDrivers');
                $result = $db->query("SELECT esl FROM Users WHERE username='" . $username . "' LIMIT 1;");
                
                if(count($result) == 1)
                {
                    foreach ($result as $row)
                    {
                        $esl = $row['esl'];
                    }
                    
                    return $esl;
                }
                
                return '';
        }
        
        function setEsl($username, $esl)
        {
                $db = new PDO('sqlite:./application/db/deliveryDrivers');
                $result = $db->query("UPDATE Users SET esl='" . $esl . "' WHERE username='" . $username . "';");
        }
     
        
        function register($username, $password, $name, $phone, $rate = "")
        {
                $db = new PDO('sqlite:./application/db/deliveryDrivers');
                $query = "INSERT INTO Users (username, password, name, phone, rate) VALUES ('" . $username . "','" . $password . "','" . $name . "','" . $phone . "','" . $rate . "');";
                $result = $db->query($query);
        }
        
        function getALlEsls()
        {
                $db = new PDO('sqlite:./application/db/deliveryDrivers');
                $result = $db->query("SELECT esl FROM Users;");
                
                return $result;
        }

        function saveEsl($username = '', $esl = '')
        {
            $db = new PDO('sqlite:./application/db/deliveryDrivers');
            $query = "INSERT INTO Esls (username, esl) VALUES ('" . $username . "','" . $esl . "');";
            $result = $db->query($query);
        }

        function getUserEsls($username = '')
        {
            $db = new PDO('sqlite:./application/db/deliveryDrivers');
            $result = $db->query("SELECT esl FROM Esls WHERE username='".$username."';");

            return $result;
        }

        function getUserByEsl($uid = '')
        {
            $esl = site_url() . "/rfq/index/" . $uid;

            $db = new PDO('sqlite:./application/db/deliveryDrivers');
            $result = $db->query("SELECT username FROM Esls WHERE esl='".$esl."' LIMIT 1;");

            if(count($result) == 1)
                {
                    foreach ($result as $row)
                    {
                        $username = $row['username'];
                    }

                    return $username;
                }

                return '';
        }

        function getName($username = '')
        {
            $db = new PDO('sqlite:./application/db/deliveryDrivers');
            $result = $db->query("SELECT name FROM Users WHERE username='".$username."';");

            if(count($result) == 1)
                {
                    foreach ($result as $row)
                    {
                        $name = $row['name'];
                    }

                    return $name;
                }

                return '';
        }

        function getRate($username = '')
        {
            $db = new PDO('sqlite:./application/db/deliveryDrivers');
            $result = $db->query("SELECT rate FROM Users WHERE username='".$username."';");

            if(count($result) == 1)
                {
                    foreach ($result as $row)
                    {
                        $rate = $row['rate'];
                    }

                    return $rate;
                }

                return '';
        }

        function saveFoursquareToken($username = '', $token = '')
        {
            $db = new PDO('sqlite:./application/db/deliveryDrivers');
            $db->query("UPDATE Users SET fsAccessToken='".$token."' WHERE username='".$username."';");
        }

        function getFoursquareToken($username = '')
        {
            $db = new PDO('sqlite:./application/db/deliveryDrivers');
            $result = $db->query("SELECT fsAccessToken FROM Users WHERE username='".$username."';");

            if(count($result) == 1)
                {
                    foreach ($result as $row)
                    {
                        $token = $row['fsAccessToken'];
                    }

                    return $token;
                }

                return '';
        }

        function saveFoursquareId($username = '', $id = '')
        {
            $db = new PDO('sqlite:./application/db/deliveryDrivers');
            $db->query("UPDATE Users SET fsId='".$id."' WHERE username='".$username."';");
        }

        function saveLocation($username = '', $lat = 0, $long = 0)
        {
            $db = new PDO('sqlite:./application/db/deliveryDrivers');
            $db->query("UPDATE Users SET latitude='".$lat."', longitude='".$long."' WHERE username='".$username."';");
        }

        function getLocation($username = '')
        {
            $db = new PDO('sqlite:./application/db/deliveryDrivers');
            $result = $db->query("SELECT latitude, longitude FROM Users WHERE username='".$username."';");

            $loc = array();
            if(count($result) == 1)
                {
                    foreach ($result as $row)
                    {
                        $loc['lat'] = $row['latitude'];
                        $loc['long'] = $row['longitude'];
                    }

                    return $loc;
                }

                return '';
        }

        function getUserByFoursquareId($id = '')
        {
            log_message("info", $id);
            $db = new PDO('sqlite:./application/db/deliveryDrivers');
            $result = $db->query("SELECT username FROM Users WHERE fsId='".$id."';");

            if(count($result) == 1)
                {
                    foreach ($result as $row)
                    {
                        $username = $row['username'];
                    }

                    return $username;
                }

                return '';
        }

        function getUserBids($username = '')
        {
            $db = new PDO('sqlite:./application/db/deliveryDrivers');
            $result = $db->query("SELECT * FROM Bids WHERE username='".$username."';");

            return $result;
        }

        function getUserByPhone($phone = '')
        {
            log_message("info", $id);
            $db = new PDO('sqlite:./application/db/deliveryDrivers');
            $result = $db->query("SELECT username FROM Users WHERE phone=".$phone.";");

            if(count($result) == 1)
                {
                    foreach ($result as $row)
                    {
                        $username = $row['username'];
                    }

                    return $username;
                }

                return '';
        }

        function saveRequest($id, $fs_esl, $deliveryTime, $deliveryAddr, $pickupTime)
        {
            $db = new PDO('sqlite:./application/db/deliveryDrivers');
            $db->query("UPDATE appDataString SET dataValue='" . $id . "' WHERE dataKey='deliveryId';");
            $db->query("UPDATE appDataString SET dataValue='" . $fs_esl . "' WHERE dataKey='fs_esl';");
            $db->query("UPDATE appDataString SET dataValue='" . $deliveryTime . "' WHERE dataKey='deliveryTime';");
            $db->query("UPDATE appDataString SET dataValue='" . $deliveryAddr . "' WHERE dataKey='deliveryAddr';");
            $db->query("UPDATE appDataString SET dataValue='" . $pickupTime . "' WHERE dataKey='pickupTime';");
        }
}
?>