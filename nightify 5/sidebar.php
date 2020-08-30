<div class="sidebar-header">
  <br><br>
  <a href="/"><img src="https://i.imgur.com/w1tTQQJ.png" width="90%" alt="Nightify"></a>
  <h3>Nightify</h3>
</div>

<ul class="list-unstyled components">
    <p><?if($login['name']!='') echo 'Hi, '.$login['name']; else echo 'Welcome!';?></p>
    <li class="active">
        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false"><i class="fas fa-plus"></i> Events</a>
        <ul class="collapse list-unstyled" id="homeSubmenu">
            <li><a href="/category.php?category=Public">Public</a></li>
            <li><a href="/category.php?category=House Parties">House Parties</a></li>
            <li><a href="/category.php?category=Dining">Dining</a></li>
        </ul>
    </li>
    <li>
        <?
          if($login['name']!='') {
        ?>
        <a href="/user.php?userid=<?=$login['id']?>"><i class="fas fa-user"></i> My Profile</a>
        <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false"><i class="fas fa-cogs"></i> Settings</a>
        <ul class="collapse list-unstyled" id="pageSubmenu">
            <li><a href="/password.php"><i class="fas fa-key"></i> Change Password</a></li>
            <li><a href="/profile.php"><i class="fas fa-cog"></i> Edit Profile</a></li>
            <li><a href="/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
        <?
          }
          else
          {
        ?>
        <a  href="/login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
        <a  href="/signup.php"><i class="fas fa-user-plus"></i> Sign Up</a>
        <?
          }
        ?>
        <a href="/contactus.php"><i class="fas fa-question"></i> Contact Us</a>
    </li>
</ul>

<ul class="list-unstyled CTAs">
    <li><a href="/add.php" class="article">Add an event</a></li>
</ul>

<div>
  <form action="/search.php" method="get">
    <input x-webkit-speech class="col-xs-9" type="text" name="q" id="q" placeholder="Search for Events..." value="<?=$_GET['q']?>" style="color:black;">
    <button class="btn btn-success col-xs-2">
       <i class="fa fa-search" aria-hidden="true"></i>
    </button>
  </form>
</div>
