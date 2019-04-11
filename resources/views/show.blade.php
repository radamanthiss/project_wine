<?php

$datos=file_get_contents(storage_path().'/data/info.json');
$info = json_decode($datos,true);
$title= $info['title'];
$pubDate=$info['pubDate'];
$fecha_actual=date('Y-m-d H:i:s');

?>
<!DOCTYPE html>
<html>
<head>
    <title>Availability</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />
    <meta charset="utf-8">
    <!-- fonts -->
    <link href="//fonts.googleapis.com/css?family=Nunito:300,400,700" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Muli:300,400" rel="stylesheet">
    <!-- /fonts -->
    <<!-- css -->
    <link rel="Stylesheet" href="css/common.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- /css -->
    <!-- script -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="js/utils.js"></script>
    <!-- script -->
    <link rel="shortcut icon" href="images/favicon.ico">
</head>
<body onload="nobackbutton();">
    <main>
    <h1>Complete validation</h1>
  	<p>Selected wine: {{$title}}</p>
  	@if($pubDate <= $fecha_actual)
  	<p>Selected wine is available</p> 
    <p>Availability date: {{$pubDate}}</p>
    @else <p>Wine not available at this time</p> 
    @endif
    <a class="btn btn-primary" href="{{url('home')}}" role="button">Back to wine list</a>
    </main>
   
</body>
</html>