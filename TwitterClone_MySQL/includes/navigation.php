<!-- Top navbar-->
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<ul class="nav navbar-nav">
			<?php
				if(!isset($_SESSION['userId']))
				{?>
				<li><a href="/TwitterClone" class="navbar-brand"> Twitter Clone</a></li>
				<li><a href="index.php"></span> About</a></li>

			<?php }

			if(isset($_SESSION['userId']))
			{?>
			<li style="font-weight:bold; font-size:18px">	<a href="/TwitterClone" class="navbar-brand"><?php echo $_SESSION["firstname"]?>'s Twitter Clone</a></li>
			<li style="margin-left:500px;font-weight:bold; font-size:18px"><a href="userProfile.php?id=<?php echo $_SESSION["userId"] ?>"> Welcome <?php echo $_SESSION["name"] ?>  </a></li>
			<li style="margin-left:20px; font-weight:bold; font-size:18px"><a href="logout.php"> Logout</a></li>

		<?php } ?>

			</ul>
		</div>
	</nav>
