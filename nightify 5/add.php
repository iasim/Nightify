<?
include('session.php');
if($login['contactnumber']=='')
{
	header("location: profile.php?action=incomplete");
}
if($login['displaypicture']=='')
{
	header("location: displaypicture.php?action=incomplete");
}
if (isset($_POST['action'])) {
    if ($_POST['action'] == "submit") {
        foreach ($_FILES["eventimage"]["name"] as $key => $error) {
            if (basename($_FILES["eventimage"]["name"][$key]) != "") {
                $imageFileType = pathinfo(basename($_FILES["eventimage"]["name"][$key]), PATHINFO_EXTENSION);
                $imageFileType = strtolower($imageFileType);
                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    $message  = '<div class="alert alert-danger" role="alert">
					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					Sorry, only JPG, JPEG, PNG & GIF files are allowed.
					</div>';
                    $uploadOk = 0;
                    $class    = "has-error";
                    break;
                }
                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["eventimage"]["tmp_name"][$key]);
                if ($check !== false) {
                    //$message = "File is an image - " . $check["mime"] . ".";
                } else {
					$message  = '<div class="alert alert-danger" role="alert">
					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					File is not an image. Sorry, there was an error uploading your file.
					</div>';
                    $uploadOk = 0;
                    $class    = "has-error";
                    break;
                }
            }
        }
        if ($uploadOk !== 0) {
            foreach ($_FILES["eventimage"]["name"] as $key => $error) {
                if (basename($_FILES["eventimage"]["name"][$key]) != "") {
                    $target_dir  = "uploads/events/";
                    $newfilename = time() . '_' . rand(100, 999) . '_' . $login['id'] . '.' . pathinfo(basename($_FILES["eventimage"]["name"][$key]), PATHINFO_EXTENSION);
					$newfilename = strtolower($newfilename);
                    $target_file = $target_dir . $newfilename;
                    $filename[]  = $newfilename;
                    if (move_uploaded_file($_FILES["eventimage"]["tmp_name"][$key], $target_file)) {
                        //$message = "The file ". basename( $_FILES["eventimage"]["name"][$key]). " has been uploaded.";
                    }
                }
                /*// Check if file already exists
                if (file_exists($target_file)) {
                $message .= "Sorry, file already exists.";
                $uploadOk = 0;
                }*/
                /*// Check file size
                if ($_FILES["eventimage"]["size"][$key] > 500000) {
                $message .= "Sorry, your file is too large.";
                $uploadOk = 0;
                }*/
            }
            $userid = mysqli_real_escape_string($connection, $login['id']);
            $eventname = mysqli_real_escape_string($connection, $_POST['eventname']);
						$eventprice = mysqli_real_escape_string($connection, $_POST['eventprice']);
						$eventcategory = mysqli_real_escape_string($connection, $_POST['eventcategory']);
            $eventimage1 = mysqli_real_escape_string($connection, $filename[0]);
            $eventimage2 = mysqli_real_escape_string($connection, $filename[1]);
            $eventimage3 = mysqli_real_escape_string($connection, $filename[2]);
            $eventimage4 = mysqli_real_escape_string($connection, $filename[3]);
            $eventimage5 = mysqli_real_escape_string($connection, $filename[4]);
						$eventlocation = mysqli_real_escape_string($connection, $_POST['eventlocation']);
						$eventdate = mysqli_real_escape_string($connection, $_POST['eventdate']);
						$eventstarttime = mysqli_real_escape_string($connection, $_POST['eventstarttime']);
						$eventendtime = mysqli_real_escape_string($connection, $_POST['eventendtime']);
						$eventdescription = mysqli_real_escape_string($connection, $_POST['eventdescription']);
            mysqli_query($connection, "INSERT INTO events (userid, eventname, eventprice, eventcategory, eventimage1, eventimage2, eventimage3, eventimage4, eventimage5,
							eventlocation, eventdate, eventstarttime, eventendtime, eventdescription)
						VALUES ('$userid', '$eventname', '$eventprice', '$eventcategory', '$eventimage1', '$eventimage2', '$eventimage3', '$eventimage4', '$eventimage5',
							'$eventlocation', '$eventdate', '$eventstarttime', '$eventendtime', '$eventdescription')");
            $event = mysqli_query($connection, "SELECT eventid FROM events WHERE eventimage1='$eventimage1'");
            $event = mysqli_fetch_assoc($event);
						header('Location: event.php?eventid='.$event['eventid']);
        }
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
        <title>Add an event - <?=$site_name?></title>
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
            <form class="<? echo $class; ?>" action="add.php" method="post" enctype="multipart/form-data">
                <legend>Add an event</legend>
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
													<div class="row">
														<div class="col-md-8">
															<input type="text" class="form-control" id="eventname" name="eventname" placeholder="Name" value="<?=$_POST['eventname']?>" required autofocus>
														</div>
														<div class="col-md-4">
															<select class="form-control" id="eventcategory" name="eventcategory" required>
																<option value="Public" <? if($_POST['eventcategory']=='Public') echo 'selected'; elseif($_POST['eventcategory']=='') echo 'selected';?>>Public</option>
																<option value="House Parties" <? if($_POST['eventcategory']=='House Parties') echo 'selected';?>>House Parties</option>
																<option value="Dining" <? if($_POST['eventcategory']=='Dining') echo 'selected';?>>Dining</option>
															</select>
														</div>
													</div>
                        </div>
												<div class="form-group">
													<div class="row">
														<div class="col-md-6">
															<input type="number" class="form-control" id="eventprice" name="eventprice" placeholder="Price ($0 for FREE)" value="<?=$_POST['eventprice']?>" required>
														</div>
														<div class="col-md-6">
															<input type="date" class="form-control" id="eventdate" name="eventdate" placeholder="Date" value="<?=$_POST['eventdate']?>" required>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="row">
														<div class="col-md-6">
															Start Time
															<input type="time" class="form-control" id="eventstarttime" name="eventstarttime" placeholder="Start Time" value="<?=$_POST['eventstarttime']?>" required>
														</div>
														<div class="col-md-6">
															End Time
															<input type="time" class="form-control" id="eventendtime" name="eventendtime" placeholder="End Time" value="<?=$_POST['eventendtime']?>" required>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="row">
														<div class="col-md-12">
															<input type="text" class="form-control" id="eventlocation" name="eventlocation" placeholder="Location" value="<?=$_POST['eventlocation']?>" required>
														</div>
													</div>
												</div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label for="eventimage">Image</label>
                            <input type="file" class="form-control-file" id="eventimage" name="eventimage[]" aria-describedby="fileHelp" required>
                            <br>
                            <input type="file" class="form-control-file" id="eventimage" name="eventimage[]" aria-describedby="fileHelp">
                            <br>
                            <input type="file" class="form-control-file" id="eventimage" name="eventimage[]" aria-describedby="fileHelp">
                            <br>
                            <input type="file" class="form-control-file" id="eventimage" name="eventimage[]" aria-describedby="fileHelp">
                            <br>
                            <input type="file" class="form-control-file" id="eventimage" name="eventimage[]" aria-describedby="fileHelp">
                            <small id="fileHelp" class="form-text text-muted">Only JPG, JPEG, PNG & GIF files are allowed</small>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="eventdescription" name="eventdescription" rows="10" placeholder="Describe your event... (optional)"><?=$_POST['eventdescription']?></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="action" value="submit">Submit</button>
            </form>
        </div>
			</div>
			</div>
    </body>
	</html>
