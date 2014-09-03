<html>
	<head>
		<title>WebORM</title>
		<link rel="stylesheet" href="css/bootstrap.css"/>
	</head>
	<body>
		<div class="col-lg-4">
		</div>
		<div class="col-lg-4">
			<h3 align="center">WebORM</h3>
		  	<?php
				require_once('Datasource/Model.php');

				class test extends Model
				{
					var $id="";
					var $name="";
					/*var $condition = array(
						'columns'=> array('name', 'address', 'id'),
						'where' => array('name' => 'prajakta'),// 'id' => '2'),// 'address' => 'pune'),
						'and_or' => array('AND'),//, 'AND'),
						//'group_by' => 'name',
						//'having' => array('aggregate_function' => 'COUNT','column' => 'id'),
						'order_by' =>'id DESC'

						);*/
					var $oneToMany = array(
						'target_table' =>'test1',
						'join_type' => 'inner',
						'columns' => array ('test.name', 'test.id', 'test1.age'),
						'group_by' => 'name',
						'order_by' =>'test.id DESC'
						);
				}
				$test =  new test();
				/*$test->id=$_POST['id'];
				$test->name=$_POST['name'];*/

				if(isset($_POST['insert']))
				{
					if($test->save())
			  		{
						echo '<p class="text-success">Succefully inserted</p>';
		  			}
					else
		  			{
		    				echo '<p class="text-danger">Failed to insert</p>';
		  			}
				}
				else if(isset($_POST['update']))
				{
		  			if($test->modify())
		  			{
		    				echo '<p class="text-success">Succefully updated</p>';
		  			}
		  			else
		  			{
		     				echo '<p class="text-danger">Failed to update</p>';
		  			}
				}
				else if(isset($_POST['delete']))
				{
		  			if($test->remove())
		  			{
		    				echo '<p class="text-success">Succefully deleted</p>';
		  			}
		  			else
		  			{
		    				echo '<p class="text-danger">Failed to delete</p>';
		  			}
				}

			?>
	  
	   		<form action="index.php" method="post"> 
	    			<div class="form-group">
				      <label>ID</label>
				      <input type="text" class="form-control" name="id" id="id" placeholder="Enter id">
				</div>
			    	<div class="form-group">
				      <label>Name</label>
	      				<input type="text" class="form-control" name="name" id="name" placeholder="Name">
			    	</div>
	     			<button type="submit" name="insert" class="btn btn-default">Insert</button>
				<button type="submit" name="update" class="btn btn-default">Update</button>
			      	<button type="submit" name="delete" class="btn btn-default">Delete</button>
			     	<button type="reset" class="btn btn-default">Reset</button>
	 		</form> 
	 
		  	<div>
		    	<h3>Records</h3>
		    	<table class="table table-hover">
			      	<th>ID</th>
			      	<th>Name</th>
			      	<th>Address</th>
			      	<th>Age</th>
			    	<?php
						
						$result = $test->search();
						if($result)
			      		{
			        		foreach($result as $row)
			        		echo '<tr><td>'.$row['id'].'</td><td>'.$row['name'].'</td><td>'.$row['address'].'</td><td>'.$row['age'].'</td></tr>';
			      		}
			      		else
			      		{
			        		echo 'No Records found.';
			      		}
				   ?>
				</table>
		  	</div>	
		</div>
	</body>
</html>


