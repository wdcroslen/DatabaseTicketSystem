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
            function showPanel() {
                // var elem = document.getElementById("ticketPanelButton");
                document.getElementById("sideBar").style.width = "310px";
                hidePanel2();
            }
            function showPanel2() {
                // var elem = document.getElementById("ticketPanelButton");
                document.getElementById("sideBar2").style.width = "310px";
                hidePanel();

            }

            function hidePanel() {
                // var elem = document.getElementById("ticketPanelButton");
                document.getElementById("sideBar").style.width = "0";
            }
            function hidePanel2() {
                // var elem = document.getElementById("ticketPanelButton");
                document.getElementById("sideBar2").style.width = "0";
            }
        </script>
        <button onclick = "showPanel(), fillPlaceholder()"  id="ticketPanelButton" name="filter">Ticket Panel</button>
        <button onclick="showPanel2()" id="ticketPanelButton" name="filter">Delete Panel</button>
        <button onclick = "showTickets()"  id="ticketB" name="filter">View Tickets</button>


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
            <div style="padding: 10px"></div>
            <input type="submit" id ="generateButton" value="Generate Request" name="submit">
            <div style="padding: 10px"></div>
            <br>
            <img src="generate_ticket.png" alt="logo here">
        </form>
    </div>

</div>

<div id="sideBar2">
    <div>
        <h3>Remove A Ticket</h3>
        <form href="editTicket.php" method="post">
            <p class="closeButton2" onclick="hidePanel2()">Close</p>

            <label for="TicketId">Choose a Specific Ticket To Delete</label>
            <input type="text" id="DeleteId" name="DeleteId" required>
            <div style="padding: 10px"></div>
            <input type="submit" class= "butt" value="Delete Ticket" name="delete">
            <div style="padding: 10px"></div>
            <div style="padding: 10px"></div>
            <img id="ticketL" src="Ticket.png" alt="logo here">

        </form>
    </div>
</div>

<div id = "centered">
    <img src="UTEP_LOGO.png" alt="logo here">
</div>

<div id = "centered-sesh">
    Welcome <?php
    $userIDs = [];
    if(isset($_SESSION['user'])) {
        echo "Your session is running " . $_SESSION['user'];
        showTickets();
    }
    if (isset($_POST['delete'])) {
        $tID = isset($_POST['DeleteId']) ? $_POST['DeleteId'] : " ";
        $_SESSION['DeleteId'] = $tID;
        if (in_array($tID, $userIDs)) {
            $q1 = "DELETE FROM notes WHERE TicketId = $tID";
            $q2 = "DELETE FROM statuschange WHERE TicketId = $tID";
            $query = "DELETE FROM TICKET WHERE TicketId = $tID";
            echo $tID;
            mysqli_query($conn,$q1);
            mysqli_query($conn,$q2);
            mysqli_query($conn,$query);
            $URL = "userRequest.php";
            echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
            echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
        } else {
            echo "You do not have permission to delete that ID.";
        }

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
            global $userIDs;
            array_push($userIDs,$row[0]);
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

