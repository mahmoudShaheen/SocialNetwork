
		</div>
		<div id="footer">Copyright 2017, CSE ZU</div>
	</body>
</html>

<?php
	//Close database connection if any
	global $connection;
	if($connection) {
		mysqli_close($connection);
	}
?>