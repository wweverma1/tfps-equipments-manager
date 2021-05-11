<?php
    session_start(); 

    if ($_SESSION['user']['role']!='M')
    {
        $_SESSION['message'] = "You must log in first";
        header('location: login.php');
    }
?>
<title>Success | TFPS</title>	
</head>
<body>

    <h1 style="font-weight:bold;">TFPS Equipments Manager</h1> 

    <h3>Equipment taken Successfully.</h3>

    
    <h3>This page will automatically redirect.</h3> 

<script type="text/javascript">
	setTimeout('Redirect()', 2500);


	function Redirect() 
	{
    	window.location = "<?php echo 'dashboard.php'; ?>";
    }

</script>

</body>
</html>



