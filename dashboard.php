<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
	<link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.27.3/dist/apexcharts.min.js"></script>
	<script src="scripts/dark.js"></script>
    <script src="scripts/nav.js"></script>
</head>
<body>
    <?php include('header.php'); ?>
    <?php include('navbar.php'); ?>

    <main>
        <div class="grid">
            <div class="box">
                <h1>Dashboard</h1>
                Welcome to the Triage admin panel!
            </div>
            <div class="box">
                <h1>Firewall</h1>
            </div>
            <div class="box">
                <h1>Networking</h1>
            </div>
            <div class="box">
                <h1></h1>
            </div>
            <div class="box">Box 5</div>
            <div class="box">Box 6</div>
            <div class="box">Box 7</div>
            <div class="box">Box 8</div>
        </div>
    </main>
    
</body>
</html>