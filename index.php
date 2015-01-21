<html>
<head>
<title>TheGame</title>

<link href="js/jquery-ui-1.11.2.custom/jquery-ui.css" rel="stylesheet">
<style>
body {
	background-color: #33F;
	color: white;
}
.title {
  position: relative;
  margin: auto;
  width: 50%;
}
.title-logo {
	color: black;
	text-shadow: 2px -2px #FFF;
}
h1, h2 {
	text-align: center;
	margin: 0;
}
h2 {
	font-style: italic;
}
h1 {
	font-weight: bold;
	font-size: 5em;
}
input {
	margin: 2px;
}

#shim {
	position: absolute;
	left: 0;
	top: 0;
	height: 100%;
	width: 100%;
	background-color: #000;
	opacity: 0.5;
	z-index: 10;
}

</style>
<script type="text/javascript" src="js/jquery-2.1.1.js" ></script>
<script type="text/javascript" src="js/lodash.js" ></script>
<script type="text/javascript" src="js/jquery-ui-1.11.2.custom/jquery-ui.js" ></script>

<script type="text/javascript">
	var endpoint = 'http://sot.meaglin.com/api.php';
	var token = '';
	$(document).ready(function() {
		$('#tabs').tabs();
		$('#tabscontainer').animate({
			height: $('#tabs').outerHeight(true) + 'px'
		}, {
			easing: 'easeOutBounce',
			duration: 1000
		});

		$('#tabs input[name="register"]').on('click', function(event) {
			event.preventDefault();
			var data = $(event.target).parent().serializeArray();
			data = _.zipObject(_.pluck(data, 'name'), _.pluck(data, 'value'));
			$.post(endpoint + '?action=register', data, null, 'json').done(function (result) {
				if(!result.success) {
					$('<div>' + result.error + '</div>').dialog({ 
						title: 'Error',
						buttons: [ { 
							text: "Close", 
							click: function() { $( this ).dialog( "close" ); } 
						}]
					});
					return;
				}
				$('<div>Registration successfull, please now login using your email and password.</div>').dialog({ 
					title: 'Success',
					buttons: [ { 
						text: "Close", 
						click: function() { $( this ).dialog( "close" ); } 
					}]
				});
				console.log(result);
			});
		});
		$('#tabs input[name="login"]').on('click', function(event) {
			event.preventDefault();
			var data = $(event.target).parent().serializeArray();
			data = _.zipObject(_.pluck(data, 'name'), _.pluck(data, 'value'));
			console.log('login', data);
			$.post(endpoint + '?action=login', data, null, 'json').done(function (result) {
				if(!result.success) {
					$('<div>' + result.error + '</div>').dialog({ 
						title: 'Error',
						buttons: [ { 
							text: "Close", 
							click: function() { $( this ).dialog( "close" ); } 
						}]
					});
					return;
				}
				$('<div>Login successfull</div>').dialog({ 
					title: 'Success',
					buttons: [ { 
						text: "Close", 
						click: function() { $( this ).dialog( "close" ); } 
					}]
				});
				token = result.data.token;
				console.log(result);
			});
		});
	});
</script>
</head>
<body>
<div id="shim" style="display: none;" > </div>
<div id="login" class="title" >
	<h1><span class="title-logo">T</span>he<span class="title-logo">G</span>ame</h1>
	<div id="tabscontainer" style="height: 0px; overflow: hidden;" >
		<div id="tabs" >
			<ul>
				<li><a href="#tabs-1">Login</a></li>
				<li><a href="#tabs-2">Register</a></li>
			</ul>
			<div id="tabs-1" >
				<form>
					Email: <input type="text" name="username" />
					<br />
					Password: <input type="password" name="password" />
					<br />
					<input type="submit" name="login" value="Login"/>
				</form>
			</div>
			<div id="tabs-2" >
				<form>
					Email: <input type="text" name="username" />
					<br />
					Password: <input type="password" name="password" />
					<br />
					<input type="submit" name="register" value="Register" />
				</form>
			</div>
		</div>
	</div>
</div>
<div id="body" style="display: none;" >

</div>
</body>
</html>