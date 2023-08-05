<?php
	if(ISSET($_POST['search'])){
		$keyword = $_POST['keyword'];
?>
<div>
	<h3>Result</h3>
	<hr style="border-top:2px dotted #ccc;"/>
	<?php
		require 'conn.php';
		$query = mysqli_query($conn, "SELECT * FROM `categories` WHERE `category` LIKE '%$keyword%' ORDER BY `category`") or die(mysqli_error());
		while($fetch = mysqli_fetch_array($query)){
	?>
	<div style="word-wrap:break-word;">
		<a href="get_search.php?id=<?php echo $fetch['id']?>"><h3><?php echo $fetch['category']?></h3></a>
		<p><?php echo substr($fetch['balance'], 0, 100)?>...</p>
		<p><?php echo substr($fetch['description'], 0, 100)?>...</p>
	</div>
	<hr style="border-bottom:1px solid #ccc;"/>
	<?php
		}
	?>
</div>
<?php
	}
?>