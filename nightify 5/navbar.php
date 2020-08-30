<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-4">
        <button type="button" id="sidebarCollapse" class="btn btn-md btn-success">
        <i class="glyphicon glyphicon-align-left"></i>
        <span>Menu</span>
        </button>
      </div>
      <div class="col-xs-4" style="text-align: center;">
        <a href="/"><img class="hidden-lg hidden-md" src="https://i.imgur.com/w1tTQQJ.png" width="50px" alt="Pelto"></a>
      </div>
      <div class="hidden-xs col-xs-4" style="text-align: right; padding-top: 10px;">
        <a href="/"><i class="fas fa-newspaper"></i> Feed</a>&nbsp;
        <a href="/add.php"><i class="fas fa-plus"></i> Create</a>&nbsp;
        <a href="/profile.php"><i class="fas fa-user"></i> Profile</a>&nbsp;
        <?
          if($login['name']!='') {
        ?>
        <a href="/logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>&nbsp;
        <?
          }
          else
          {
        ?>
        <a href="/login.php"><i class="fas fa-sign-in-alt"></i> Login</a>&nbsp;
        <a href="/signup.php"><i class="fas fa-user-plus"></i> Sign Up</a>
        <?
          }
        ?>
      </div>
    </div>
  </div>
</nav>
