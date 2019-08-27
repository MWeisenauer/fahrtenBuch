<html>
<head>
 <title>Fahrtenbuch</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta http-equiv="pragma" content="no-cache">

	<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>	
</head>
<body>
 <div data-role="page" data-theme="b" id="list1">
    <div data-role="header" data-theme="b">
     <h1>Fahrtenbuch</h1>
     <a class="ui-icon-nodisc" href="#left-panel" data-iconpos="notext" data-icon="arrow-r" data-theme="d" data-iconshadow="false" data-shadow="false">Open left panel</a>
     <!-- <a class="ui-icon-nodisc" href="#right-panel" data-iconpos="notext" data-icon="arrow-l" data-theme="d" data-iconshadow="false" data-shadow="false">Open right panel</a> -->
    </div> 
    
	 <?php include ("revealPanel.php"); ?>

	 <div data-role="content" data-theme="b">
 <?php 
	 setcookie ("eMail", Abgemeldet, time() - 3000000);
	 setcookie ("nrSchild", Abgemeldet, time() - 3000000);
	 setcookie ("Angemeldet", Abgemeldet, time() - 3000000);
	 setcookie ("fahrzeugTyp", Abgemeldet, time() - 3000000);
 ?>
 <script language="javascript" type="text/javascript">
  window.document.location.href = "index.php";
 </script>
 </div>		 
</body>
</htnl>