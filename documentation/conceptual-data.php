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
	<strong>PROFILE:</strong>
	<li>profileId (primary key)</li>
	<li>profileActivationToken</li>
	<li>profileAvatarUrl</li>
	<li>profileEmail</li>
	<li>profileHash</li>
	<li>profilePhone</li>
	<li>profileUsername</li>

</ul>

<ul>
	<strong>BUSINESS:</strong>
	<li>businessId (primary key)</li>
	<li>businessAddress</li>
	<li>businessLng</li>
	<li>businessLat</li>
	<li>businessName</li>
	<li>businessUrl</li>

</ul>

<ul>
	<strong>BEHAVIOR:</strong>
	<li>behaviorId (primary key)</li>
	<li>behaviorBusinessId (foreign key)</li>
	<li>behaviorProfileId (foreign key)</li>
	<li>behaviorContent</li>
	<li>behaviorDate</li>
	<li>behaviorType</li>

</ul>

<ul>
	<strong>VOTE:</strong>
	<li>voteId (primary key)</li>
	<li>voteBehaviorId (foreign key)</li>
	<li>behaviorProfileId (foreign key)</li>
	<li>voteDate</li>
	<li>voteResult</li>


</ul>


<h2>Relations</h2>

	<ul>
	<li>one profile can have many votes (1 to m)</li>
	<li>One profile can have many behaviors (1 to m)</li>
	<li>A behavior can have multiple votes (1 to m)</li>
	<li>A business can have many behaviors (1 to m)</li>

</ul>
<br>
<br>
<br>
<img src="../images/erd-db.png" alt="erd" height="850" width="850">
<br>
<br>
<a href="user-story.php">Next page</a>
<a href="index.php">Home</a>
</body>
</html>