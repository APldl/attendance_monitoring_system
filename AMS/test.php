<!DOCTYPE html>
<html>
<head>
	<title>List of User Names</title>
	<style>
		.heading {
			text-align: center;
		}
		.user-list {
			list-style: none;
			padding: 0;
			margin: 0;
			display: flex;
			flex-direction: column;
			align-items: center;
		}
		.user-item {
			background-color: #f0f0f0;
			padding: 10px;
			margin: 5px;
			border-radius: 5px;
			font-size: 18px;
			font-weight: bold;
			text-align: center;
			width: 300px;
			height: 50px;
			display: flex;
			flex-direction: row;
			align-items: center;
			justify-content: space-between;
		}
		.user-icon {
			width: 40px;
			height: 40px;
			margin-left: 0;
			border-radius: 50%;
			object-fit: cover;
		}
		.user-name {
			text-align: center;
			flex: 1;
			margin-left: 10px;
		}
	</style>
</head>
<body>
	<h1 class="heading">List of User Names</h1>
	<ul class="user-list">
		<li class="user-item">
			<img class="user-icon" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="User Icon">
			<div class="user-name">John Doe</div>
		</li>
		<li class="user-item">
			<img class="user-icon" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="User Icon">
			<div class="user-name">Jane Smith</div>
		</li>
		<li class="user-item">
			<img class="user-icon" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="User Icon">
			<div class="user-name">Bob Johnson</div>
		</li>
		<li class="user-item">
			<img class="user-icon" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="User Icon">
			<div class="user-name">Sara Lee</div>
		</li>
		<li class="user-item">
			<img class="user-icon" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="User Icon">
			<div class="user-name">Tom Brown</div>
		</li>
	</ul>
</body>
</html>