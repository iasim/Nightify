<?
include('session.php');

if ($_GET['userid'] == '') {
header('Location: /index.php'); }

$userid = mysqli_real_escape_string($connection, $_GET['userid']);
$user = mysqli_query($connection,"SELECT * FROM users WHERE id = '$userid' LIMIT 1");
$user = mysqli_fetch_array($user);

if (isset($_POST['action'])) {
    if ($_POST['action'] == "sendmessage") {
		$to = $user['name'].' <'.$user['email'].'>';
		$subject = $login['name'].' has sent you contact information - Nightify';
		$from = $login['name'].' <'.$login['email'].'>';
		$body='Hi '.$user['name'].',<br><br>'.$login['name'].' has sent you contact information.<br><br><a href="https://'.$_SERVER["HTTP_HOST"].'/user.php?userid='.$login['id'].'">Click here to check '.$login['name'].'\'s events.</a><br><br>==================================================================<br>Below is the message sent by '.$login['name'].':<br>==================================================================<br><br>'.$_POST['message-text'].'<br><br>==================================================================<br><br>Thank you,<br>Nightify Team<br><br><img src="http://icons.iconarchive.com/icons/itzikgur/my-seven/256/Girls-Red-Dress-icon.png" width="100px" alt="Nightify">';
		$headers = "From: " . $from . "\r\n";
		$headers .= "Reply-To: ". $from . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		mail($to,$subject,$body,$headers,'-f'.$login['email']);
		$message = '<div class="alert alert-success" role="alert">
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		<strong>Your message has been successfully sent to this user. User will reply you back if interested. <a href="index.php">Check homepage</a></strong>
		</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title><?=$user['name']?> - <?=$site_name?></title>
  <? include('meta.php'); ?>
</head>

<body>
<div class="wrapper">
<nav id="sidebar">
<? include('sidebar.php'); ?>
</nav>
<div id="content">
<? include('navbar.php'); ?>
<div class="container">
<? echo $message; ?>
    <div class="row">
        <div style="padding-top:50px;"></div>
        <div class="col-lg-3 col-md-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="media">
                        <div align="center">
							<?
							if($user['displaypicture']!='')
								echo '<img class="img-responsive img-circle" src="https://i0.wp.com/'.$_SERVER["HTTP_HOST"].'/uploads/displaypictures/'.$user['displaypicture'].'?w=200&h=200" alt="..." width="200">';
							else
								echo '<img class="img-responsive img-circle" src="https://i0.wp.com/'.$_SERVER["HTTP_HOST"].'/uploads/displaypictures/default.jpg?w=200&h=200" alt="..." width="200">';
							?>
                        </div>
						<br>
                        <div class="media-body">
						<a href="#" class="btn btn-link" style="text-decoration:none;"><i class="fa fa-lg fa-laptop" aria-hidden="true"></i></a><?=$user['permission']?>
                            <hr>
                            <h3><strong>Bio</strong></h3>
                            <p><?=$user['bio']?></p>
                            <hr>
                            <h3><strong>Location</strong></h3>
                            <p><?=$user['address3']?></p>
                            <hr>
                            <h3><strong>User Type</strong></h3>
                            <p><?=$user['type']?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <span>
                        <h1 class="panel-title pull-left" style="font-size:30px;"><?=$user['name']?></h1>
                    </span>
                    <br><br>
                    <hr>

					<?
					if($login['id']==$user['id'])
					{
						echo '
						<div class="btn-group">
							<a href="/profile.php" class="btn btn-danger">Edit Profile</a>
						</div>
						';
					}
					?>
					<?
					if($login['id']!=$user['id'])
					{
					?>
					<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">Send Contact Information</button>
					<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
						<form action="" method="post">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="exampleModalLabel">New message</h4>
						  </div>
						  <div class="modal-body">
							  <div class="form-group">
								<label for="recipient-name" class="control-label">Recipient:</label>
								<input type="text" class="form-control" id="recipient-name" value="<?=$user['name']?>" disabled>
							  </div>
							  <div class="form-group">
								<label for="message-text" class="control-label">Message:</label>
								<textarea class="form-control" id="message-text" name="message-text" rows="10">
Email: <?=$login['email']?>

Contact Number: <?=$login['contactnumber']?>

Address: <?=$login['address1']?>, <?=$login['address2']?>, <?=$login['address3']?></textarea>
							  </div>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary" name="action" value="sendmessage">Send message</button>
						  </div>
						</form>
						</div>
					  </div>
					</div>
					<?
					}
					?>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</div>

</body>

</html>
