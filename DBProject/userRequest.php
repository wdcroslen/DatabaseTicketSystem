<?php
//TODO: Make this into a seperate file to only have to call once
$servername = "ilinkserver.cs.utep.edu";
$username = "wdcroslen";
$password = "*utep2020!";
$database = "f20am_team13";
$currentUser = "";
$conn = new mysqli($servername, $username, $password, $database);
session_start();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>HomePage</title>
    <link href="main-style.css" rel="stylesheet" type="text/css" />
<!--    <link href="table-style.css" rel="stylesheet" />-->
</head>

<body>

<div name="header" id="header">
    <div class="button-box-left">
        <a href="index.php" class="logo">Ticket</a>
    </div>

    <?php
    function showTables(){
//        data-table.class = visible
    }
    ?>
    <div class="button-box-left">
        <script>
            function showTickets(){
                var elem = document.getElementById("data-table");
                var butt = document.getElementById("ticketB");
                if (elem.className == "invisible"){
                    elem.classList.remove("invisible");
                    butt.textContent = "Hide Tickets"
                }
                else {
                    elem.classList.add("invisible");
                    butt.textContent = "View Tickets"
                }
            }
            function showPanel(){
                // var elem = document.getElementById("ticketPanelButton");
                document.getElementById("sideBar").style.width = "300px";
            }
            function hidePanel(){
                // var elem = document.getElementById("ticketPanelButton");
                document.getElementById("sideBar").style.width = "0";
            }
        </script>
        <button onclick = "showTickets()"  id="ticketB" name="filter">View Tickets</button>
        <button onclick = "showPanel(), fillPlaceholder()"  id="ticketPanelButton" name="filter">Ticket Panel</button>

    </div>



    <div class="button-box">
    </div>

</div>

<div id ="sideBar">
    <div>
        <h3>Generate A Ticket</h3>
        <form>
            <p class ="closeButton" onclick = "hidePanel()"
            >Close</p>

            <?php $session_value=(isset($_SESSION['user']))?$_SESSION['user']:''; ?>
                <script>
                    function fillPlaceholder(){
                        var myvar='<?php echo $session_value;?>';
                        document.getElementById("minerRequest").value = myvar;
                    }
                </script>

            <input name="minerRequest" id="minerRequest" type="text" placeholder="fullMinerEmail"></input>
            <div style="padding: 10px"></div>
            <label for="category">Choose a Category for your issue:</label>
            <select name="category" id="category" class="select">
                    <option value="Software">Software</option>
                    <option value="Hardware">Hardware</option>
            </select>
            <div style="padding: 10px"></div>
            <input type="submit" value="Generate Request" name="submit">
        </form>
    </div>

</div>

<div id = "centered">
    <img src="UTEP_LOGO.png" alt="logo here">
</div>

<div id = "centered-sesh">
    Welcome <?php

    if(isset($_SESSION['user'])) {
        echo "Your session is running " . $_SESSION['user'];
        showTickets();
    }

    function showTickets(){
        global $conn;
        $query = "SELECT * FROM Ticket Where UtepEmail = '" . $_SESSION['user']."'";
        $result = mysqli_query($conn,$query);
        echo '<br></br>';
        echo "<div id = 'data-table' class = 'invisible'><table> ";
        echo "<h3> Here are the Tickets You Have Submitted</h3> ";
        echo "<tr><th>Ticket ID</th><th>User</th><th>Status</th><th>Category</th><th>Time Requested</th>";
        while($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo ("<td>".$row[0]."</td>" . " " . " <td>".$row[1]."</td>" .
                "<td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td>");

            echo "</tr>";
            print("\n");
        }
        echo "</table> </div>";
    }


    function generateTicket(){
        global $conn;
        $user =  $_GET['minerRequest'];
        $category =$_GET['category'];
        $a=date("Y-m-d H:i:s");
        $query = "INSERT INTO Ticket (UtepEmail,Status,Category,RequestTime) Values('$user','Open','$category','$a')";
        if ($conn->query($query) === TRUE) {
           $a = true;
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    }

    if (isset($_GET['submit'])) {
        generateTicket();
    }

    ?>

</div>


</body>
</html>

