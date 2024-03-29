<?php
session_start();
if(isset($_SESSION['clientName'])) $clientName=$_SESSION['clientName'];
if(isset($_SESSION['clientID'])) $clientID=$_SESSION['clientID'];
require_once("db.php");
?>
<html>
<head>
  <title>Reynholm Industries</title>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" href="stylesheet.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<a href="clientLanding.php"><img src="reynholm.png" height=5% width=5% /></a>
  <ul class="nav nav-tabs">
  <li class="active"><a href="clientLanding.php">Home</a></li>
  <li><a href="clientListingsPage.php">Recalls</a></li>
  <li><a href="clientCurrentLoads.php">Potential Violations</a></li>
  <li><a href="clientPastLoads.php">Processed Potential Violations</a></li>
  <li><a href="createListing.php">Add Recalls</a></li>
  <li><a href="clientAccountManagement.php">Manage Account</a></li>
</ul>

<img style='margin-left: auto; display: block; margin-right: auto;' src="CPSCPage.png" width=850px/>

<?php
//resume the session variable on this page
$clientID = $_SESSION["clientID"];
$clientName = $_SESSION["clientName"];
$timeString = "";
$currentTime = date("a");
if ($currentTime == "am") {
  $timeString = "morning";
} else {
  $timeString = "afternoon";
}

    echo "<div style='text-align:center;width: 850px;'>Good ".$timeString." ".$clientName."!</div>";
?>
<div id="pieChart" style="margin: auto;
background-color:white;
width: 850px;
border: 3px solid black;
padding: 10px;
text-align:center;"></div>

<script src="//cdnjs.cloudflare.com/ajax/libs/d3/4.7.2/d3.min.js"></script>
<script src="d3pie.min.js"></script>
<script>
var pie = new d3pie("pieChart", {
	"header": {
		"title": {
			"text": "All Violations",
			"fontSize": 20,
			"font": "open sans"
		},
		"subtitle": {
			"text": "by process status",
			"color": "#999999",
			"font": "open sans"
		},
		"titleSubtitlePadding": 9
	},
	"footer": {
		"color": "#999999",
		"fontSize": 10,
		"font": "open sans",
		"location": "bottom-left"
	},
	"size": {
		"canvasWidth": 590,
		"pieInnerRadius": "40%",
		"pieOuterRadius": "63%"
	},
	"data": {
		"sortOrder": "value-desc",
		"content": [
			{
				"label": "Flagged, Awaiting Review",
				"value": <?php $sql=("select count(state) as total from listing where clientID='$clientID' and state='NA'");
        $result = $mydb->query($sql);
        while($row=mysqli_fetch_array($result)){echo $row['total'];}?>,
				"color": "#1c6898"
			},
			{
				"label": "Unflagged, Awaiting Review",
				"value": <?php $sql=("select count(state) as total from listing where clientID='$clientID' and state='L'");
        $result = $mydb->query($sql);
        while($row=mysqli_fetch_array($result)){echo $row['total'];}?>,
				"color": "#a39216"
			},
			{
				"label": "Reviewed, In Violation",
				"value": <?php $sql=("select count(state) as total from listing where clientID='$clientID' and state='IT'");
        $result = $mydb->query($sql);
        while($row=mysqli_fetch_array($result)){echo $row['total'];}?>,
				"color": "#1628a4"
			},
			{
				"label": "Reviewed, Non-Violating",
				"value": <?php $sql=("select count(state) as total from listing where clientID='$clientID' and state='F'");
        $result = $mydb->query($sql);
        while($row=mysqli_fetch_array($result)){echo $row['total'];}?>,
				"color": "#12bd09"
			}
		]
	},
	"labels": {
		"outer": {
			"pieDistance": 32
		},
		"inner": {
			"hideWhenLessThanPercentage": 3
		},
		"mainLabel": {
			"fontSize": 11
		},
		"percentage": {
			"color": "#ffffff",
			"decimalPlaces": 0
		},
		"value": {
			"color": "#adadad",
			"fontSize": 11
		},
		"lines": {
			"enabled": true
		},
		"truncation": {
			"enabled": true
		}
	},
	"effects": {
		"pullOutSegmentOnClick": {
			"effect": "linear",
			"speed": 400,
			"size": 8
		}
	},
	"misc": {
		"gradient": {
			"enabled": true,
			"percentage": 100
		}
	}
});
</script>
<div id="pieChart2" style="margin: auto;
background-color:white;
width: 850px;
border: 3px solid black;
padding: 10px;
text-align:center;"></div>

<script src="//cdnjs.cloudflare.com/ajax/libs/d3/4.7.2/d3.min.js"></script>
<script src="d3pie.min.js"></script>
<script>
var pie2 = new d3pie("pieChart2", {
	"header": {
		"title": {
			"text": "Unreviewed Violations",
			"fontSize": 20,
			"font": "open sans"
		},
		"subtitle": {
			"text": "by process status",
			"color": "#999999",
			"font": "open sans"
		},
		"titleSubtitlePadding": 9
	},
	"footer": {
		"color": "#999999",
		"fontSize": 10,
		"font": "open sans",
		"location": "bottom-left"
	},
	"size": {
		"canvasWidth": 590,
		"pieInnerRadius": "40%",
		"pieOuterRadius": "63%"
	},
	"data": {
		"sortOrder": "value-desc",
		"content": [
			{
				"label": "Flagged",
				"value": <?php $sql=("select count(state) as total from listing where clientID='$clientID' and state='NA'");
        $result = $mydb->query($sql);
        while($row=mysqli_fetch_array($result)){echo $row['total'];}?>,
				"color": "#1c6898"
			},
			{
				"label": "Unflagged",
				"value": <?php $sql=("select count(state) as total from listing where clientID='$clientID' and state='L'");
        $result = $mydb->query($sql);
        while($row=mysqli_fetch_array($result)){echo $row['total'];}?>,
				"color": "#a39216"
			}
		]
	},
	"labels": {
		"outer": {
			"pieDistance": 32
		},
		"inner": {
			"hideWhenLessThanPercentage": 3
		},
		"mainLabel": {
			"fontSize": 11
		},
		"percentage": {
			"color": "#ffffff",
			"decimalPlaces": 0
		},
		"value": {
			"color": "#adadad",
			"fontSize": 11
		},
		"lines": {
			"enabled": true
		},
		"truncation": {
			"enabled": true
		}
	},
	"effects": {
		"pullOutSegmentOnClick": {
			"effect": "linear",
			"speed": 400,
			"size": 8
		}
	},
	"misc": {
		"gradient": {
			"enabled": true,
			"percentage": 100
		}
	}
});
</script>
<div id="pieChart3" style="margin: auto;
background-color:white;
width: 850px;
border: 3px solid black;
padding: 10px;
text-align:center;"></div>

<script src="//cdnjs.cloudflare.com/ajax/libs/d3/4.7.2/d3.min.js"></script>
<script src="d3pie.min.js"></script>
<script>
var pie2 = new d3pie("pieChart3", {
	"header": {
		"title": {
			"text": "Violations of the past month",
			"fontSize": 20,
			"font": "open sans"
		},
		"subtitle": {
			"text": "by process status",
			"color": "#999999",
			"font": "open sans"
		},
		"titleSubtitlePadding": 9
	},
	"footer": {
		"color": "#999999",
		"fontSize": 10,
		"font": "open sans",
		"location": "bottom-left"
	},
	"size": {
		"canvasWidth": 590,
		"pieInnerRadius": "40%",
		"pieOuterRadius": "63%"
	},
	"data": {
		"sortOrder": "value-desc",
		"content": [
			{
				"label": "Flagged",
				"value": <?php $sql=("select count(state) as total from listing where clientID='$clientID' and state='NA'");
        $result = $mydb->query($sql);
        while($row=mysqli_fetch_array($result)){echo $row['total'];}?>,
				"color": "#1c6898"
			},
			{
				"label": "Unflagged",
				"value": <?php $sql=("select count(state) as total from listing where clientID='$clientID' and state='L'");
        $result = $mydb->query($sql);
        while($row=mysqli_fetch_array($result)){echo $row['total'];}?>,
				"color": "#a39216"
			}
		]
	},
	"labels": {
		"outer": {
			"pieDistance": 32
		},
		"inner": {
			"hideWhenLessThanPercentage": 3
		},
		"mainLabel": {
			"fontSize": 11
		},
		"percentage": {
			"color": "#ffffff",
			"decimalPlaces": 0
		},
		"value": {
			"color": "#adadad",
			"fontSize": 11
		},
		"lines": {
			"enabled": true
		},
		"truncation": {
			"enabled": true
		}
	},
	"effects": {
		"pullOutSegmentOnClick": {
			"effect": "linear",
			"speed": 400,
			"size": 8
		}
	},
	"misc": {
		"gradient": {
			"enabled": true,
			"percentage": 100
		}
	}
});
</script>
   <center><p style='margin-left: auto; display: block; margin-right: auto;'>
     <a style="background-color:white;" href="logout.php">Click here to log out</a>
   </p></center>
</body>
</html>
