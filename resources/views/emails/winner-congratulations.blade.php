<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	<img style="margin-left: 100px !important;" src="https://needmaterials.com/frontend/images/logo/winner-logo.gif">
	<h1> Congratulation Winner</h1> <br> 

	  <a href="{{ route('frontend.myBids') }}" style="color: #000; text-decoration: none; font-size: 22px;"> Title: {{ $title }} </a> <br>
	  <a href="{{ route('frontend.myBids') }}" style="color: #000; text-decoration: none; font-size: 22px;"> Bidding Price: {{ $price }} </a>


	<h2 style="color: red;">  </h2>
</body>
</html>