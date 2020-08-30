<?
include('session.php');

if ($_GET['eventid'] == '') {
header('Location: index.php'); }

$eventid = mysqli_real_escape_string($connection, $_GET['eventid']);
$event = mysqli_query($connection,"SELECT * FROM events WHERE eventid = '$eventid' LIMIT 1");
$event = mysqli_fetch_array($event);
$userid = $event['userid'];
$user = mysqli_query($connection,"SELECT * FROM users WHERE id = '$userid' LIMIT 1");
$user = mysqli_fetch_array($user);

if ($_GET['action'] == "delete")
{
	if($login['id']==$event['userid'])
	{
		unlink('uploads/events/'.$event['eventimage1']);
		if($event['eventimage2']!='')
			unlink('uploads/events/'.$event['eventimage2']);
		if($event['eventimage3']!='')
			unlink('uploads/events/'.$event['eventimage3']);
		if($event['eventimage4']!='')
			unlink('uploads/events/'.$event['eventimage4']);
		if($event['eventimage5']!='')
			unlink('uploads/events/'.$event['eventimage5']);
		mysqli_query($connection, "DELETE FROM events WHERE eventid = '$eventid' LIMIT 1");
		header('Location: profile.php?action=eventdeleted');
	}
	else
	{
		header('Location: error.php');
	}
}
if (isset($_POST['action'])) {
    if ($_POST['action'] == "sendmessage") {
		if($login['contactnumber']=='')
		{
			header("location: profile.php?action=incomplete");
		}
		if($login['displaypicture']=='')
		{
			header("location: displaypicture.php?action=incomplete");
		}
		$to = $user['name'].' <'.$user['email'].'>';
		$subject = $login['name'].' is interested in your product - Nightify';
		$from = "Nightify <summitsingh5@gmail.com>";
		$body='Hi '.$user['name'].',<br><br>'.$login['name'].' is interested in your event ('.$event['eventname'].') (<a href="https://'.$_SERVER["HTTP_HOST"].'/event.php?eventid='.$event['eventid'].'">https://'.$_SERVER["HTTP_HOST"].'/event.php?eventid='.$event['eventid'].'</a>)<br><br><a href="https://'.$_SERVER["HTTP_HOST"].'/user.php?userid='.$login['id'].'">Click here to contact '.$login['name'].' and send your contact information.</a><br><br>==================================================================<br>Below is the message sent by '.$login['name'].':<br>==================================================================<br><br>'.$_POST['message-text'].'<br><br>==================================================================<br><br>Thank you,<br>Nightify Team<br><br><img src="http://icons.iconarchive.com/icons/itzikgur/my-seven/256/Girls-Red-Dress-icon.png" width="100px" alt="Nightify">';
		$headers = "From: " . $from . "\r\n";
		$headers .= "Reply-To: ". $from . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		mail($to,$subject,$body,$headers,'-fsummitsingh5@gmail.com');
		$message = '<div class="alert alert-success" role="alert">
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		<strong>Your message has been successfully sent to the seller. Seller will send you contact information if interested. <a href="index.php">Check homepage</a></strong>
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
	<title><?=$event['eventname']?> - <?=$site_name?></title>
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
            <div class="col-lg-12">
                <h1 class="page-header"><?=$event['eventname']?>
                    <small><?=date_format(date_create($event['eventdate']),"d M Y")?></small>
										<p class="pull-right text-success bg-success">$<?=$event['eventprice']?></p>
                </h1>
            </div>
        </div>

        <div class="row">

            <div class="col-md-8">
				<div id="carousel-images" class="carousel slide" data-ride="carousel">
				  <!-- Indicators -->
				  <ol class="carousel-indicators">
					<li data-target="#carousel-images" data-slide-to="0" class="active"></li>
					<?
					if($event['eventimage2']!='')
						echo '<li data-target="#carousel-images" data-slide-to="1"></li>';
					if($event['eventimage3']!='')
						echo '<li data-target="#carousel-images" data-slide-to="2"></li>';
					if($event['eventimage4']!='')
						echo '<li data-target="#carousel-images" data-slide-to="3"></li>';
					if($event['eventimage5']!='')
						echo '<li data-target="#carousel-images" data-slide-to="4"></li>';
					?>
				  </ol>

				  <!-- Wrapper for slides -->
				  <div class="carousel-inner" role="listbox">
					<div class="item active">
					  <img style="margin: auto;" src="https://i0.wp.com/<?=$_SERVER["HTTP_HOST"]?>/uploads/events/<?=$event['eventimage1']?>?w=500&h=500" alt="...">
					</div>
					<?
					if($event['eventimage2']!='')
						echo '
					<div class="item">
					  <img style="margin: auto;" src="https://i0.wp.com/'.$_SERVER["HTTP_HOST"].'/uploads/events/'.$event['eventimage2'].'?w=500&h=500" alt="...">
					</div>';
					if($event['eventimage3']!='')
						echo '
					<div class="item">
					  <img style="margin: auto;" src="https://i0.wp.com/'.$_SERVER["HTTP_HOST"].'/uploads/events/'.$event['eventimage3'].'?w=500&h=500" alt="...">
					</div>';
					if($event['eventimage4']!='')
						echo '
					<div class="item">
					  <img style="margin: auto;" src="https://i0.wp.com/'.$_SERVER["HTTP_HOST"].'/uploads/events/'.$event['eventimage4'].'?w=500&h=500" alt="...">
					</div>';
					if($event['eventimage5']!='')
						echo '
					<div class="item">
					  <img style="margin: auto;" src="https://i0.wp.com/'.$_SERVER["HTTP_HOST"].'/uploads/events/'.$event['eventimage5'].'?w=500&h=500" alt="...">
					</div>';
					?>
				  </div>

				  <!-- Controls -->
				  <a class="left carousel-control" href="#carousel-images" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				  </a>
				  <a class="right carousel-control" href="#carousel-images" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				  </a>
				</div>
				<br><br>
				<iframe width="100%" height="300" frameborder="1" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBjM5iPN6jG1uBYvid24MnheMVr93eQlxc&q=<?=$event['eventlocation']?>" allowfullscreen></iframe>

            </div>

						<div class="col-md-4">
							<h3>Event Information:</h3>
											<ul>
													<li>Event Category: <b><?=$event['eventcategory']?></b></li>
													<li>Start Time: <b><?=$event['eventstarttime']?></b></li>
													<li>End Time: <b><?=$event['eventendtime']?></b></li>
													<li>Location: <b><?=$event['eventlocation']?></b></li>
													<li>Date Added: <b><?=date_format(date_create($event['date']),"d M Y")?></b></li> (not event date)
											</ul>
							<h3>Host Information:</h3>
			                <ul>
			                    <li>Host Name: <a href="/user.php?userid=<?=$user['id']?>"><b><?=$user['name']?></b></a></li>
			                    <li>Location: <b><?=$user['address3']?></b></li>
			                </ul>
				<?
				if($login['id']==$event['userid'])
				{
					echo '
					<!--<div class="btn-group">
						<a href="/edit.php?eventid='.$event['eventid'].'" class="btn btn-warning">Edit event</a>
					</div>-->
					<div class="btn-group">
						<a href="?eventid='.$event['eventid'].'&action=delete" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete?\')">Delete Event</a>
					</div>
					';
				}
				?>
				<?
				if($login['id']!=$user['id'])
				{
				?>
				<div class="btn-group">
					<a href="/user.php?userid=<?=$user['id']?>" class="btn btn-success">View <?=$user['name']?>'s Profile</a>
				</div>
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Contact Host</button>
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
							<textarea class="form-control" id="message-text" name="message-text" rows="10">I'm interested in this event</textarea>
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

				<div class="row">

						<div class="col-lg-12">
								<h3 class="page-header">More...</h3>
						</div>

						<div class="col-md-12">
								<div class="row">
		<?
		$page = $_GET['page'];
		if ($page == '') { $page = 1; }
		$limit = 6;
		$offset = $limit * ($page-1);
		$result = mysqli_query($connection, "SELECT * FROM events WHERE eventcategory like '%".mysqli_real_escape_string($connection, $event['eventcategory'])."%' AND eventid != $eventid ORDER BY eventdate DESC LIMIT $offset, $limit");
		$i = 0;
		$r = 0;
		while ($row = mysqli_fetch_array($result))
		{
			//if ($r==3) { echo '</tr><tr style="height:270px">'; $r = 0; }
			$i ++;
			$r ++;
			$d_name = $row['eventname'];

			if (strlen($d_name) > 30)
				$d_name = substr($d_name, 0, 27) . '...';
		?>
										<div class="col-xs-12 col-sm-12 col-lg-4 col-md-4">
												<div class="thumbnail" style="height:250px;">
														<a href="/event.php?eventid=<?=$row['eventid']?>" title="<?=$row['eventname']?>"><img src="https://i0.wp.com/<?=$_SERVER["HTTP_HOST"]?>/uploads/events/<?=$row['eventimage1']?>?w=320&h=150px" alt="">
														<div class="caption">
																<small class="text-success bg-success">$<?=$row['eventprice']?></small>
																<h4><?=$d_name?></a>
																</h4>
																<small><?=date_format(date_create($row['eventdate']),"d M Y")?></small>
																<small><a href="/category.php?category=<?=$row['eventcategory']?>"><?=$row['eventcategory']?></a></small>
														</div>
												</div>
										</div>
		<?
		}
		if ($i==0)
			echo '<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			No related events found...
			</div>';
		?>
								</div>
						</div>

				</div>

    </div>

	</div>
</div>

</body>

</html>
