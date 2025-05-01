<div id="navBarContainer">
	<nav class="navBar">
	<a href="index.php">
  <img src="assets\images\icons\logo.png" alt="HTML tutorial" style="width:150px;height:50px;">
</a>

		<div class="group">
			<div class="navItem">
				<span role='link' tabindex='0' 
					onclick="openPage('search.php')" class="navItemLink">
					Search
					<img src="assets/images/icons/search.png" class="icon" alt="Search">
				</span>
			</div>

		</div>

		<div class="group">
			<div class="navItem">
				<span role="link" tabindex="0" onclick="openPage('browse.php')" class="navItemLink">Browse
				</span>
			</div>

			<div class="navItem">
				<span role="link" tabindex="0" onclick="openPage('yourMusic.php')" class="navItemLink">Library
				</span>
			</div>

			<div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('history.php')" class="navItemLink">History</span>
            </div>
            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('movie.php')" class="navItemLink">Movies</span>
            </div>

			<div class="navItem">
				<span role="link" tabindex="0" onclick="openPage('settings.php')" class="navItemLink"><?php echo $userLoggedIn->getFirstAndLastName(); ?>
				</span>
			</div>
		</div>
	</nav>
</div>