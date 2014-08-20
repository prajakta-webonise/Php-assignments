<?php
class DB extends PDO
{
	protected $host = "127.3.193.130";
	protected $port= 3306;
	protected $db_user= 'admin3H1X3hG';
	protected $db_password='8twEuU2pvb66';
	protected $db_name='courierservices';
	protected $db_options = array(PDO::ATTR_PERSISTENT => true);

	//Constructor to connect Mysql Databases
	function __construct()
	{
		try {

			 parent::__construct("mysql:host=$this->host;dbname=$this->db_name",$this->db_user,$this->db_password,$this->db_options);
		}
 		catch (PDOException $e) {
   			 echo 'Connection failed: ' . $e->getMessage();
			 die();
		}
	}
	function getStatus($order_id)
	{
		try
		{
			$track_details_id = $this->getTrckDetailsId($order_id);
			$stmt =  parent::prepare("SELECT s.status FROM status s , track_details t WHERE t.id=? AND t.status_id = s.id ");
			$id = $this->getTrckDetailsId($order_id);
			
			$stmt->bindParam(1, $track_details_id['id']);			

			if($stmt->execute())
			{
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				return $result['status'];
			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	function getTrckDetailsId($order_id)
	{

		$sql = "SELECT td.id FROM track t, orders o , track_details td  WHERE o.id=t.order_id AND t.id=td.track_id AND o.id=".$order_id;
		$result = $this->query($sql);
		return $result->fetch(PDO::FETCH_ASSOC);
	}
	function getProductName($order_id)
	{

		$sql = "SELECT p.name FROM  orders o , products p  WHERE o.product_id=p.id AND o.id=".$order_id;
		$result = $this->query($sql);
		return $result->fetch(PDO::FETCH_ASSOC);
	}
	function getFromAddress($order_id)
	{

		$sql = "SELECT u.first_name,u.last_name,u.address_line1, u.address_line2, u.city,u.state,u.country,u.pincode FROM  orders o , users u  WHERE o.user_id=u.id AND o.id=".$order_id;
		$result = $this->query($sql);
		return $result->fetch(PDO::FETCH_ASSOC);
	}
	function updateTrackDetails($status_id,$order_id)
	{
		try
		{
			$stmt =  parent::prepare("UPDATE track_details SET status_id=? WHERE id=?");
			$id = $this->getTrckDetailsId($order_id);
			
			$stmt->bindParam(1, $status_id);
			$stmt->bindParam(2, $id['id']);

			if($stmt->execute())
			{
				if($status_id == 6)
				{
					$this->updateDelivered($order_id);
				}
				
				return true;
			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	function updateDelivered($order_id=0)
	{
		try
		{
			$stmt =  parent::prepare("UPDATE orders SET status=1 WHERE id=?");
			$stmt->bindParam(1, $order_id);

			if($stmt->execute())
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	function getListNewOrders($status,$userID=0)
	{
		try
		{
			if($userID == 0)
			{
				$stmt =  parent::prepare("SELECT o.id as ID,p.name as ProductName, o.to_name as To1,u.first_name as From_Name,o.date_time as Date1 FROM orders o,users u, products p 
										  WHERE p.id=o.product_id AND u.id=o.user_id AND o.status = ? ORDER BY o.id desc ");
				$stmt->bindParam(1, $status);
				
				if($stmt->execute())
				{
					return $stmt->fetchAll(PDO::FETCH_ASSOC);
				}
				else
				{
					return false;
				}
			}
			else
			{
				$stmt =  parent::prepare("SELECT o.id as ID,p.name as ProductName, o.to_name as To1,u.first_name as From_Name,o.date_time as Date1 FROM orders o,users u, products p 
										  WHERE p.id=o.product_id AND u.id=o.user_id AND o.status = ? AND user_id = ? ORDER BY o.id desc ");
				$stmt->bindParam(1, $status);
				$stmt->bindParam(2, $userID);
				
				if($stmt->execute())
				{
					return $stmt->fetchAll(PDO::FETCH_ASSOC);
				}
				else
				{
					return false;
				}
			}
			
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	function addPriceRange($weight=array())
	{
		try 
		{			
			$stmt = parent::prepare("INSERT INTO weight (from_range,to_range,price) VALUES (?,?,?)");
			$stmt->bindParam(1, $weight['from']);
			$stmt->bindParam(2, $weight['to']);
			$stmt->bindParam(3, $weight['price']);
			if($stmt->execute())
			{
				return true;
			}
			else
			{
				return false;
			}
			
		}
 		catch (PDOException $e) {
   			 echo 'Error: ' . $e->getMessage();
			 die();
		}
	}
	function getOrderDetails($id)
	{
		try
		{
			$stmt = parent::prepare("SELECT * FROM orders WHERE id = ?");
			$stmt->bindParam(1, $id);
			if($stmt->execute())
				{
					return $stmt->fetch(PDO::FETCH_ASSOC);
				}
				else
				{
					return false;
				}
		}
 		catch (PDOException $e) {
   			 echo 'Error: ' . $e->getMessage();
			 die();
		}
	}
	function getTrackDetails($id)
	{
		try
		{
			$stmt = parent::prepare("SELECT * FROM track WHERE order_id = ?");
			$stmt->bindParam(1, $id);
			if($stmt->execute())
				{
					return $stmt->fetch(PDO::FETCH_ASSOC);
				}
				else
				{
					return false;
				}
		}
 		catch (PDOException $e) {
   			 echo 'Error: ' . $e->getMessage();
			 die();
		}
	}
	function getTrack($trackId,$status=0)
	{
		
		try
		{
			$stmt = parent::prepare("SELECT * FROM track_details td, status s, track t WHERE t.id=td.track_id and s.id = td.status_id and  t.id = ? order by date desc,time desc");
			$stmt->bindParam(1, $trackId);
			if($stmt->execute())
				{
					if($status == 1)
					{
						return $stmt->fetch(PDO::FETCH_ASSOC);
					}
					else
					{
						return $stmt->fetchAll(PDO::FETCH_ASSOC);
					}
					
				}
				else
				{
					return false;
				}
		}
 		catch (PDOException $e) {
   			 echo 'Error: ' . $e->getMessage();
			 die();
		}
	}
	function getOrderId($trackId)
	{
		
		try
		{
			$stmt = parent::prepare("SELECT o.id AS Id FROM orders o, track t WHERE o.id=t.order_id AND t.id=?");
			$stmt->bindParam(1, $trackId);
			if($stmt->execute())
				{
					$order_id = $stmt->fetch(PDO::FETCH_ASSOC);
					
					return $order_id['Id'];
					
					
				}
				else
				{
					return false;
				}
		}
 		catch (PDOException $e) {
   			 echo 'Error: ' . $e->getMessage();
			 die();
		}
	}
	function getListStatus()
	{
		try
		{
			$stmt = parent::prepare("SELECT * FROM status");
			
			if($stmt->execute())
				{
					
					return $stmt->fetchAll(PDO::FETCH_ASSOC);				
					
				}
				else
				{
					return false;
				}
		}
 		catch (PDOException $e) {
   			 echo 'Error: ' . $e->getMessage();
			 die();
		}
	}
	function getListWeight()
	{
		try
		{
			$stmt = parent::prepare("SELECT * FROM weight");
			
			if($stmt->execute())
				{
					
					return $stmt->fetchAll(PDO::FETCH_ASSOC);				
					
				}
				else
				{
					return false;
				}
		}
 		catch (PDOException $e) {
   			 echo 'Error: ' . $e->getMessage();
			 die();
		}
	}
	function getWeightDetails($id)
	{
		try
		{
			$stmt = parent::prepare("SELECT * FROM weight WHERE id=?");
			$stmt->bindParam(1, $id);
			if($stmt->execute())
			{
				
				return $stmt->fetch(PDO::FETCH_ASSOC);				
				
			}
			else
			{
				return false;
			}
		}
 		catch (PDOException $e) {
   			 echo 'Error: ' . $e->getMessage();
			 die();
		}
	}
	function updatePriceRange($weight=array())
	{
		try 
		{			
			$stmt = parent::prepare("UPDATE weight SET from_range=?,to_range=?,price=? WHERE id=?");
			$stmt->bindParam(1, $weight['from_range']);
			$stmt->bindParam(2, $weight['to_range']);
			$stmt->bindParam(3, $weight['price']);
			$stmt->bindParam(4, $weight['order_id']);
			if($stmt->execute())
			{
				return true;
			}
			else
			{
				return false;
			}
			
		}
 		catch (PDOException $e) {
   			 echo 'Error: ' . $e->getMessage();
			 die();
		}
	}

}
$db = new DB();
//$result = $db->updateTrackDetails(3,21);
//foreach($result as $value)
//print_r($result);
//print_r($db->getListNewOrders(0,5))
?>