<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Congratulations Winner</title>
	<style>

		body {
			font-family: Arial, sans-serif;
			color: #000;
			text-align: center;
			margin: 0;
			padding: 0;
			background:#c77979 !important;
			background-size: 600% 600%;
			animation: animatedBackground 10s ease infinite;
		}

		.container {
			padding: 20px;
		}

		h1 {
			color: white;
			margin-top: 20px;
		}

		a {
			color: white;
			text-decoration: none;
		}

		.button {
			background-color: #007BFF;
			color: white;
			padding: 10px 20px;
			text-decoration: none;
			border-radius: 5px;
			font-size: 18px;
			display: inline-block;
			margin-top: 20px;
		}
	</style>
</head>
<body>
	<div class="container">
		<img src="https://needmaterials.com/frontend/images/logo/winner-logo.gif" alt="Winner Logo" width="100" height="auto" style="display: block; margin: 0 auto;">
		<h1>Congratulations, Winner!</h1>
		<p style="font-size: 22px; margin: 0;">
			<a href="{{ route('frontend.myBids') }}">
				<strong>Title:</strong> {{ $title }}
			</a>
		</p>
		<p style="font-size: 22px; margin: 10px 0;">
			<a href="{{ route('frontend.myBids') }}">
				<strong>Bid Winning Price:</strong> {{ $price }}
			</a>
		</p>

		<p style="font-size: 18px; margin: 10px 0;">
			If you are agree this bid just click on <span style="font-weight: bold; color: green;"> Accept </span> and not agree just click on <span style="font-weight: bold; color: red;"> Reject </span>
		</p>


		<!-- Button Section -->
		<a href="{{ route('frontend.myBids') }}" class="button">
			View My Bids
		</a>
	</div>
</body>
</html>
