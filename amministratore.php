<?php include('server.php') ?>
<?php 
    $noerr;
    $ban = 0; 
 ?>

<?php if ($_SESSION['username'] != "admin"):   //protezione per accesso "manuale" alla pagina amministratore
    header('location: index.php');
endif ?>


<!DOCTYPE html>
<html>
    <head>
        <title>AdminConsole</title><link rel='shortcut icon' type='image/png' href='/favicon.png' />
        
        <link rel="stylesheet" type="text/css" href="style.css">
		
        <div class="title">
            <span class="top">
                Admin Management System
            </span>
        

            <span class = "console">
                <button type="submit" class="btn" style="width: 200px;" onclick="document.location.href='index.php?logout=1';">HOME</button>
            </span>    
        </div>

        

    </head>

    <body>

    <div class= "corpo">
            You can manage the game. <br/>
            Search user to activate the Admin Control Panel and show his top 10 scores.<br/>
            Once an user is found you can see his account status: ACTIVE or BANNED.<br/>
            You see the amount of scores saved on Score count. <br/>    
            You can ban an activated account or activate a banned account.<br/>
            You can also delete all score history of an user.<br/>
    </div>

    <div class="corpo">    
            <div class = "adminpanel">  
                <div class="header adminpanel">
                    <h2>User Finder</h2>
                </div>

                <form class="adminpanel" style="color: black; font-size: 90%;" method="post" action="amministratore.php">
                    
                    <?php include('errors.php'); ?>

                    <div class="input-group">
                        <label>Username</label>
                        <input type="text" name="finduser" value="<?php echo $username; ?>" autofocus>
                    </div>

                    <div class="input-group">
                        <button type="submit" class="btn" name="finduser_btn">Find !</button>
                    </div>
                </form>
            </div>

            <div class="adminscore">
                <?php
                    //ADMIN  ACTION      controllare se: bannato, non esiste, solo dopo tiro fuori gli score
                    if (count($errors) == 0 && $search != 0) { // se l'user esiste e non è bannato allora procedo con la visualizzazione dei 10 best score
                        $noerr = 1;
                        $query = "SELECT score FROM scores where name = '$username' ORDER BY score DESC LIMIT  10;";
                        $results = mysqli_query($db, $query);
                        $i = 1;
                        echo '<span class="boardtitle">TOP 10 SCORES</span>';
                        echo "<table id='adminscore'> 
                                <tr>
                              <th>Pos</th>
                              <th>Score</th>
                              </tr>";
                        while($row = mysqli_fetch_array($results)) {
                            echo "<tr>";
                            echo "<td>" . $i++ . "</td>";
                            echo "<td>" . $row['score'] . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";               
                    }

                ?>
            </div>    
    </div>

    <div class ="corpo">
        <div class="green">
            <?php  if (isset($_POST['finduser_btn']) && isset($noerr)) : 
              echo  "Username under investigation:  " . "<span class='highlight'>" . $username . "</span>";
            endif ?>    
        </div>

        <div class="green">
            <?php  if (isset($_POST['finduser_btn']) && isset($noerr)) : 
                  $query = "SELECT Banned FROM users WHERE username = '$username';";      // recupero ban/no ban
                  $results = mysqli_query($db, $query);
                  $results = mysqli_fetch_array($results);
                  echo "Status: ";
                    if ($results['Banned'] == 1){ //       0 ACTIVE; 1 BANNED;
                        echo "<strong>" . "BANNED" . "</strong>" ;
                        $ban = 1;
                    }
                    else{
                        echo "<strong>" . "ACTIVE" . "</strong>" ;
                        $ban = 0;
                    }
            endif ?> 
        </div>

        <?php if (isset($_POST['finduser_btn']) && isset($noerr)) : ?>

                <div class="green">
                    <p class="admin">Score count: 
                    <?php
                        $query = "SELECT * FROM scores WHERE name = '$username';";
                        $results = mysqli_query($db, $query);
                        $n = mysqli_num_rows($results);
                        echo "<span class='highlight'>" . $n . "<span>";
                    ?> </p>
                </div>


                <div class='green'>
                    <form class = "trasp" method="post">
                    <input type="hidden" class = "trasp" name="scoreD" value="<?php echo $username; ?>">
                    <button type='submit' class='btn' name='scoreDel'>Delete scores</button>
                    </form>
                </div>


            <?php if ($ban == 0) : ?>  <!-- NOT BANNED , SHOW THE BAN BUTTON-->
                <div class='green'>
                    <form class = "trasp" method="post">
                        <input type="hidden" class = "trasp" name="userD" value="<?php echo $username; ?>">
                        <button type='submit' class="btn" name='userDel'>Ban user</button>
                    </form>
                </div>
            <?php else: ?>
                <div class='green'>
                    <form class = "trasp" method="post">
                        <input type="hidden" class = "trasp" name="userB" value="<?php echo $username; ?>">
                        <button type='submit' class="btn" name='userBack'>Active user</button>
                    </form>
                </div>
            <?php endif ?>
        <?php endif ?>
    </div>




    <footer>
        <p>
            <a href="http://jigsaw.w3.org/css-validator/check/referer">
                <img style="border:0;width:88px;height:31px"
                    src="http://jigsaw.w3.org/css-validator/images/vcss"
                    alt="Valid CSS!" />
            </a>
        UserFinder 1.0 </p>
    </footer>
    </body>
</html>


    

