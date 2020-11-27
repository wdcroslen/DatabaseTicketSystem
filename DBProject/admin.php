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
</head>

<body>

<div name="header" id="header">
    <div class="button-box-left">
        <a href="index.php" class="logo">Ticket</a>
    </div>

    <div class="button-box-left">
        <script>
            function showTickets(){
                document.getElementById("openTickets").classList.add("invisible");
                document.getElementById("ticketB2").textContent = "Show Open";

                var elem = document.getElementById("data-table");
                var logo =  document.getElementById("Ulogo");
                var butt = document.getElementById("ticketB");

                if (elem.className == "invisible"){
                    elem.classList.remove("invisible");
                    butt.textContent = "Hide Tickets"
                    logo.classList.add("invisible");
                }
                else {
                    elem.classList.add("invisible");
                    logo.classList.remove("invisible");
                    butt.textContent = "View Tickets"
                }
            }

            function showOpenTickets(){
                document.getElementById("data-table").classList.add("invisible");
                document.getElementById("ticketB").textContent = "View Tickets";

                var elem = document.getElementById("openTickets");
                var logo =  document.getElementById("Ulogo");
                var butt = document.getElementById("ticketB2");

                if (elem.className == "invisible"){
                    elem.classList.remove("invisible");
                    butt.textContent = "Hide Tickets"
                    logo.classList.add("invisible");
                }
                else {
                    elem.classList.add("invisible");
                    logo.classList.remove("invisible");
                    butt.textContent = "Show Open Tickets"
                }
            }

            function showPanel(){
                // var elem = document.getElementById("ticketPanelButton");
                document.getElementById("sideBar").style.width = "310px";
            }
            function hidePanel(){
                // var elem = document.getElementById("ticketPanelButton");
                document.getElementById("sideBar").style.width = "0";
            }
        </script>
        <button onclick = "showTickets()"  id="ticketB" name="filter">View Tickets</button>
        <button onclick = "showOpenTickets()"  id="ticketB2" name="filter">Show Open Tickets</button>
        <button onclick = "showPanel(), fillPlaceholder()"  id="ticketPanelButton" name="filter">Ticket Panel</button>

    </div>



    <div class="button-box">
    </div>

</div>

<div id ="sideBar">
    <div>
        <h3>Resolve Tickts / Add Notes</h3>
        <form>
            <p class ="closeButton" onclick = "hidePanel()"
            >Close</p>

        </form>
    </div>

</div>

<div id = "centered">
    <img id = "Ulogo" src="UTEP_LOGO.png" alt="logo here">
</div>

<div id = "centered-sesh">
    Welcome ADMIN <?php

    if(isset($_SESSION['user'])) {
        echo "Your session is running " . $_SESSION['user'];
        showTickets();
        showOpenTickets();
    }

    function showTickets(){
        global $conn;
        $query = "SELECT * FROM Ticket";
        //TODO: let the ticket member order the tickets
        $result = mysqli_query($conn,$query);
        echo '<br></br>';
        echo "<div id = 'data-table' class = 'invisible'><table> ";
        echo "<h3> These are all the Tickets</h3> ";
        echo "<tr><th>Ticket ID</th><th>User</th><th>Status</th><th>Category</th>";
        while($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo ("<td>".$row[0]."</td>" . " " . " <td>".$row[1]."</td>" .
                "<td>".$row[2]."</td><td>".$row[3]."</td>");

            echo "</tr>";
            print("\n");
        }
        echo "</table> </div>";
    }
    function showOpenTickets(){
        global $conn;
        $query = "SELECT * FROM UnsolvedTickets";
        $result = mysqli_query($conn,$query);
        echo '<br></br>';
        echo "<div id = 'openTickets' class = 'invisible'><table> ";
        echo "<h3> These are all unresolved tickets</h3> ";
        echo "<tr><th>Ticket ID</th><th>User</th><th>Status</th><th>Category</th>";
        while($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo ("<td>".$row[0]."</td>" . " " . " <td>".$row[1]."</td>" .
                "<td>".$row[2]."</td><td>".$row[3]."</td>");

            echo "</tr>";
            print("\n");
        }
        echo "</table> </div>";
    }


    function generateTicket(){
        global $conn;
        $user =  $_GET['minerRequest'];
        $category =$_GET['category'];
        $query = "INSERT INTO Ticket (UtepEmail,Status,Category) Values('$user','Open','$category')";
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

