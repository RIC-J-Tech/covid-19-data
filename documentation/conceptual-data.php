<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Conceptual Model</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
<h2>Entities & Attributes</h2>
<ul>
	<strong>USER:</strong>
	<li>userId (primary key)</li>
	<li>userFirstName</li>
	<li>userLastName</li>
	<li></li>

</ul>

<ul>
	<strong>SPORT:</strong>
	<li>sportId (primary key)</li>
	<li>sportLeague</li>
	<li>sportName</li>

</ul>

<ul>
	<strong>BET:</strong>
	<li>betId (primary key)</li>
	<li>betSportId (foreign key)</li>
	<li>betType</li>
	<li>betUserId(foreign key)</li>

</ul>

<h2>Relations</h2>
<p>
<ul>
	<li>A user can select multiple bet types (1 to n)</li>
	<li>A sport can have many type bets (1 to m)</li>


</ul>
</p>
</div>
<a href="erd.html">ERD PAGE</a>

</body>
</html>