<?php

namespace Zeus
{
	class Maintenance
	{
		public static function CanPassthrough()
		{
			if(isset($_COOKIE['_ZEUSMAINTENANCEPASSTHROUGH']))
			{
				$db = new Database();
				$db = $db->dbConnection;
				
				$theCookie = str_replace(API::$MaintenanceHeader, '', $_COOKIE['_ZEUSMAINTENANCEPASSTHROUGH']);
				
				$query = $db->prepare('SELECT `date`, `ip` FROM `maintenancepassthroughkeys` WHERE `cookie`=:cookie');
				$query->bindParam(':cookie', $theCookie);
				$query->execute();
				$result = $query->fetch(\PDO::FETCH_ASSOC);
				
				if(!empty($result))
				{
					if($result['ip'] == API::GetIPAddress() && time()-strtotime($result['date']) < 60*60*24)
					{
						return true;
					}
					else
					{
						$query = $db->prepare('DELETE FROM `maintenancepassthroughkeys` WHERE `cookie`=:cookie');
						$query->bindParam(':cookie', $theCookie);
						$query->execute();
						return false;
					}
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}	
		}
	}
}