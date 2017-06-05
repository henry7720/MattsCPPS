<?php
session_start();
if(!isset($_SESSION['username'], $_SESSION['password'])) {
	header("Location: index.php");
} else {
?>
<html lang="en"><head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Matt's CPPS | Admin Panel</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-dark bg-inverse navbar-fixed-top">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button class="navbar-toggler hidden-sm-up pull-sm-right" type="button" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    ☰
                </button> <img src="http://mattscpps.us/play/start/style/matts-cpps-logo.png" width="166" height="44">
            <!-- Top Menu Items -->
            <ul class="nav navbar-nav top-nav navbar-right pull-xs-right">
                <li class="dropdown nav-item">
                    <a href="javascript:;" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['username']; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item">
                            <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
			</div>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-toggleable-sm navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav list-group">
					<br />
                    <li class="list-group-item">
                        <a href="home.php"><i class="fa fa-fw fa-dashboard"></i> Home</a>
                    </li>
                    <li class="list-group-item">
                        <a href="chat.php"><i class="fa fa-fw fa-wrench"></i> Chat Logs</a>
                    </li>
                    <li class="list-group-item">
                        <a href="bans.php"><i class="fa fa-fw fa-wrench"></i> Manage Bans</a>
                    </li>
					<li class="list-group-item">
                        <a href="staff.php"><i class="fa fa-fw fa-wrench"></i> Demote Staff</a>
                    </li>
					<li class="list-group-item">
                        <a href="http://mattscpps.us/blog/posts/admin-writenew-post/" target="_blank"><i class="fa fa-fw fa-edit"></i> New Blog Post</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Admin Panel
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-wrench"></i> Chat Logs
                            </li>
                        </ol>
                    </div>
                </div>
<b>Start at ID:</b> <form action="chat.php" style="display: inline;"><input class="form-control" style="width: 70px;display: inline;" type="text" name="start" id="start" style="text-align:center;" placeholder="Latest" value="<?php if(isset($_GET['start']) && ctype_digit($_GET['start'])) { echo $_GET['start']; } ?>"> <input class="btn btn-primary" type="submit" value="Go"></form>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>User Lookup:</b> <form action="userchat.php" style="display: inline;"><input class="form-control" style="width: 120px;display: inline;" type="text" name="u" id="u" style="text-align:center;" placeholder="Username"> <input class="btn btn-primary" type="submit" value="Go"></form>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Message Search:</b> <form action="chatsearch.php" style="display: inline;"><input class="form-control" style="width: 150px;display: inline;" type="text" name="msg" id="msg" style="text-align:center;" placeholder="Message"> <input class="btn btn-primary" type="submit" value="Go"></form>
<br />
<br />
Latest 300 messages are displayed.
<br />
<div class="table-responsive">
<table border class="table table-bordered table-hover">
<tbody>
<tr>
<td><b>ID</b></td><td><b>Username</b></td><td><b>Message</b></td><td><b>Room</b></td><td><b>Time</b></td>
</tr>
<?php
try {
if(isset($_GET['start']) && !empty($_GET['start'])) {
	$start = $_GET['start'];
	$query = $db->prepare("SELECT * FROM `messages` WHERE ID <= :Start ORDER BY ID DESC LIMIT 300");
	$query->bindValue(":Start", $start);
} else {
	$query = $db->prepare("SELECT * FROM `messages` ORDER BY ID DESC LIMIT 300");
}
$query->execute();
while ($row = $query->fetch(PDO::FETCH_ASSOC))
{
	$id = $row['ID'];
	$username = '<a href="userchat.php?u=' . $row['Username'] . '">' . $row['Username'] . '</a>';
	$message = htmlentities($row['Message']);
	$emotecode = array("(laugh-emote)", "(smile-emote)", "(straightface-emote)", "(frown-emote)", "(shocked-emote)", "(tongue-emote)", "(wink-emote)", "(sick-emote)", "(mad-emote)", "(upset-emote)", "(meh-emote)", "(idea-emote)", "(coffee-emote)", "(question-emote)", "(exclamation-emote)", "(flower-emote)", "(clover-emote)", "(joystick-emote)", "(toot-emote)", "(pizza-emote)", "(icecream-emote)", "(cake-emote)", "(popcorn-emote)", "(heart-emote)");
	$emoteimg = array("<img src='http://mattscpps.us/admin/panel/img/emotes/laugh.png'>", "<img src='http://mattscpps.us/admin/panel/img/emotes/smile.png'>", "<img src='http://mattscpps.us/admin/panel/img/emotes/straightface.png'>", "<img src='http://mattscpps.us/admin/panel/img/emotes/frown.png'>", "<img src='http://mattscpps.us/admin/panel/img/emotes/shocked.png'>", "<img src='http://mattscpps.us/admin/panel/img/emotes/tongue.png'>", "<img src='http://mattscpps.us/admin/panel/img/emotes/wink.png'>", "<img src='http://mattscpps.us/admin/panel/img/emotes/sick.png'>", "<img src='http://mattscpps.us/admin/panel/img/emotes/mad.png'>", "<img src='http://mattscpps.us/admin/panel/img/emotes/upset.png'>", "<img src='http://mattscpps.us/admin/panel/img/emotes/meh.png'>", "<img src='http://mattscpps.us/admin/panel/img/emotes/idea.png'>", "<img src='http://mattscpps.us/admin/panel/img/emotes/coffee.png'>", "<img src='http://mattscpps.us/admin/panel/img/emotes/question.png'>", "<img src='http://mattscpps.us/admin/panel/img/emotes/exclamation.png'>", "<img src='http://mattscpps.us/admin/panel/img/emotes/flower.png'>", "<img src='http://mattscpps.us/admin/panel/img/emotes/clover.png'>", "<img src='http://mattscpps.us/admin/panel/img/emotes/joystick.png'>", "<img src='http://mattscpps.us/admin/panel/img/emotes/toot.png'>", "<img src='http://mattscpps.us/admin/panel/img/emotes/pizza.png'>", "<img src='http://mattscpps.us/admin/panel/img/emotes/icecream.png'>", "<img src='http://mattscpps.us/admin/panel/img/emotes/cake.png'>", "<img src='http://mattscpps.us/admin/panel/img/emotes/popcorn.png'>", "<img src='http://mattscpps.us/admin/panel/img/emotes/heart.png'>"); 
	$message = str_replace($emotecode, $emoteimg, $message);
	$room = $row['Room'];
	$rooms = {100: "Town", 110: "Coffee Shop", 111: "Book Room",  120: "Dance Club", 121: "Lounge", 122: "School", 130: "Clothes Shop", 200: "Ski Village", 212: "Phoning Facility", 220: "Ski Lodge", 221: "Lodge Attic", 230: "Ski Hill", 300: "Plaza", 310: "Pet Shop", 320: "Dojo", 321: "Dojo Courtyard", 322: "Ninja Hideout", 323: "EPF Command Room", 330: "Pizza Parlor", 340: "Mall", 400: "Beach", 410: "Lighthouse", 411: "Beacon", 420: "Rockhopper's Ship", 421: "Ship Hold", 422: "Captain's Quarters", 423: "Crows Nest", 430: "Hotel Lobby", 431: "Hotel Gym", 432: "Hotel Roof", 433: "Cloud Forest", 434: "Puffle Park", 435: "Skatepark", 800: "Dock", 801: "Snow Forts", 802: "Stadium", 803: "HQ", 804: "Boiler Room", 805: "Iceberg", 806: "Cave", 807: "Mine Shack", 808: "Mine", 809: "Forest", 810: "Cove", 811: "Box Dimension", 812: "Fire Dojo", 813: "Cave Mine", 814: "Hidden Lake", 815: "Underwater Room", 816: "Water Dojo"}
	if($room < 1000) {
		if($room == '816')
		{
			$roomname = "Water Dojo";
		}
		$room = $room . "<br /><font size=1>{$roomname}</font>";
	}
	if($room > 1000) {
		$getName = $db->prepare("SELECT * FROM `penguins` WHERE ID = :Room - 1000");
		$getName->bindParam(':Room', $room);
		$getName->execute();
		$column = $getName->fetch(PDO::FETCH_ASSOC);
		$player = $column['Username'];
		$room = $room . "<br /><font size=1>{$player}'s Igloo</font>";
	}
	$time = date('Y-m-d H:i:s', $row['Time']);
	echo "
	<tr>
	<td width=50>{$id}</td><td width=20>{$username}</td><td width=900>{$message}</td><td width=200><center>{$room}</center></td><td width=140>{$time}</td>
	</tr>";
}
} catch (Exception $e) {
	die("Database error");
}
?>
</tbody>
</table>
</div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>




</body></html>
<?php } ?>
