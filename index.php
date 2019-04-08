<?php 
	//$db = mysqli_connect('localhost', 'root', 'suckall', 'tetris');
	//session_start(); 
    $result = 3;
    include('server.php');
	

	if (!isset($_SESSION['username'])) {
	    $_SESSION['msg'] = "You must log in first";
	}

	if (isset($_GET['logout'])) {
	    session_destroy();
	    unset($_SESSION['username']); 
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	    <title>Tetris</title><link rel='shortcut icon' type='image/png' href='/favicon.png' />
	    
	    <link rel="stylesheet" type="text/css" href="style.css">


	    <div class="title">
	    	<div class="top">
	    		Tetris with Leaderboard !!!
	    	</div>
	    	<div class="console">
	    		<div style="float: right;">
				    <input type="button" class="btn-log" onclick="document.location.href='register.php';" value="Register">
			        <input type="button" class="btn-log" onclick="document.location.href='login.php';" value=" Login ">
		        </div>
			        <!-- logged in user information -->
		        <?php  if (isset($_SESSION['username'])) : ?>
		          	<br>
		          	<div class="loginInfo">
		            	<!-- notification  -->
		        		<br>
		              	Welcome <strong><?php echo $_SESSION['username']; ?></strong>
		             	<input type="button" class="btn-logout" onclick="document.location.href='index.php?logout=1';" value="Logout">
		             	 
		          	</div>
		        <?php endif ?>


	    	</div>
	    </div>
	  

	</head>





	<body>
		<div class="corpo">


			<div class="panel">
				<p class="boardtitle">YOUR HIGHSCORES</p> <br/>

				<div class="punteggi">
				<?php  if (isset($_SESSION['username'])) :    // se loggato riporto i best score personali

		            $user = $_SESSION['username'];			// non essendo consentito il login ai bannati, non controllo lo stato in questa score tab
		            $query = "SELECT score FROM scores where name = '$user'
		              ORDER BY score DESC LIMIT  5;";
		            $result = mysqli_query($db, $query);
		            $i = 1;
		            echo "<table> 
		                <tr>
		                <th>Pos</th>
		                <th>Score</th>
		                </tr>";
		        	while($row = mysqli_fetch_array($result)) {
		              echo "<tr>";
		              echo "<td>" . $i++ . "</td>";
		              echo "<td>" . $row['score'] . "</td>";
		              echo "</tr>";
		            }
		              echo "</table>";
		            endif ?>

		        <?php  if (!isset($_SESSION['username'])) : //se non sono loggato    
		            echo 'You must be logged in!';
		        endif ?>

		        </div>

			</div>


			<div class="panel" style="min-width:20%;">
				<p class="boardtitle">LEADERBOARD</p>		<!-- CLASSIFICA GENERALE: mostra punteggi giocatori solo NON bannati -->

				<div class="punteggi">
			        <?php 
			            $query = "SELECT s.name, s.score FROM scores s inner join users u on s.name = u.username WHERE u.Banned = 0 ORDER BY s.score DESC LIMIT  10;";
			            $result = mysqli_query($db, $query);
			            $i = 1;
			            
			            echo "<table> 
			                <tr>
			                <th>Pos</th>
			                <th>Name</th>
			                <th>Score</th>
			                </tr>";
			            while($row = mysqli_fetch_array($result)) {
			                echo "<tr>";
			                echo "<td>" . $i++ . "</td>";
			                echo "<td>" . $row['name'] . "</td>";
			                echo "<td>" . $row['score'] . "</td>";
			                echo "</tr>";
			            }
			            echo "</table>";
			        ?>

			    </div>
			          
			</div>

			<div class="panel">
				<div class="boardtitle">SCORE:    </div>
		        <div id="score" class="boardtitle" style="float: right;"></div>
		        <BR><BR>

		        <div class="boardtitle">LAST:      </div>
		        <div id="lastscore" class="boardtitle" style="float: right;"></div>
		        <BR><BR>


		        <div class="boardtitle">MATCH:     </div>
		        <div id="playcount" class="boardtitle" style="float: right;"></div>
		        <BR><BR>

		        <div id="endgame" class="boardtitle"></div>
			</div>




			<div class="panel">
				<div style="display: block;">
			    	<input type="button" class="btn-play" id="play" onclick="playPressed()" value="PLAY">
			    </div>
			    <div style="display: block;">
			    	<input type="button" class="btn-play" onclick="document.location.href='rules.html';" value="HOW TO">
			    </div>
			</div>







			<div>
				<canvas id="tetris" width="240" height="400" />
		    		<script src="tetris.js"></script>
		    	</canvas>
			</div>


		</div>








		    <footer>
        <p>
            <a href="http://jigsaw.w3.org/css-validator/check/referer">
                <img style="border:0;width:88px;height:31px"
                    src="http://jigsaw.w3.org/css-validator/images/vcss"
                    alt="Valid CSS!" />
            </a>
        P_Web Pellicci Giacomo 2017 </p>
    </footer>



	</body>
</html>




