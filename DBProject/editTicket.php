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
                document.getElementById("ticketB2").textContent = "Unresolved Tickets";

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
                    butt.textContent = "Unresolved Tickets"
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
        <button onclick = "showOpenTickets()"  id="ticketB2" name="filter">Unresolved Tickets</button>
        <button onclick = "showPanel(), fillPlaceholder()"  id="ticketPanelButton" name="filter">Ticket Panel</button>

    </div>



    <div class="button-box">
    </div>

</div>

<div id ="sideBar">
    <div>
        <h3>Resolve Tickets/Add Notes</h3>
        <form>
            <p class ="closeButton" onclick = "hidePanel()"
            >Close</p>

            <label for="specificTicket">Choose a Specific Ticket to View</label>
            <input type = "text" id = "specificTicket" name ="specificTicket" >
            <div style="padding: 10px"></div>
            <input type="submit" value="Generate Request" name="submit">

        </form>
    </div>

</div>

<div id = "centered">
    <img id = "Ulogo" src="UTEP_LOGO.png" alt="logo here">
</div>

<div id = "centered-sesh">
    Welcome To Ticket Editing <?php
    echo $_SESSION['user'];
    if(isset($_SESSION['TicketId'])) {
        echo "You are viewing Ticket:" . $_SESSION['TicketId'];
        showTickets();
        showCurrentNote();
    }

    function showTickets(){
        global $conn;
        $tid = $_SESSION['TicketId'];
        $query = "SELECT * FROM Ticket where TicketId = $tid";
        $result = mysqli_query($conn,$query);
        echo '<br></br>';
        echo "<div id = 'data-table' class = 'invisible'><table> ";
        echo "<h3>This is your selected Ticket</h3> ";
        echo "<tr><th>Ticket ID</th><th>User</th><th>Status</th><th>Category</th><th>Time Requested</th>";
        while($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo ("<td>".$row[0]."</td>" . " " . " <td>".$row[1]."</td>" .
                "<td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td>");

            echo "</tr>";
            print("\n");
        }
        echo "</table> ";
        echo "</br> ";
        echo "</br> ";
        echo "<form method='post' action='editTicket.php' id='addNoteForm'>
                <textarea maxlength='200' rows='4' cols='50' id = 'note' name='note' form='usrform'> Enter Note here...</textarea>
                <input type='submit' value='Add Note' name='addNote'>
                </form>
                
              
                <br>";

        echo "</div>";
    }
//      <button onclick = 'addNote()'  id='ticketPanelButton' name='filter'>Add Note</button>

    function showCurrentNote(){
        global $conn;
        $query = "SELECT * FROM UnsolvedTickets";
        $result = mysqli_query($conn,$query);
        echo '<br></br>';
        echo "<div id = 'openTickets' class = 'invisible'><table> ";
        echo "<h3> These are all unresolved tickets</h3> ";
        echo "<tr><th>Ticket ID</th><th>User</th><th>Status</th><th>Category</th><th>Time Requested</th>";
        while($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo ("<td>".$row[0]."</td>" . " " . " <td>".$row[1]."</td>" .
                "<td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td>");

            echo "</tr>";
            print("\n");
        }
        echo "</table> ";

        echo "</div>";
    }

    if (isset($_POST['addNote'])) {
        global $conn;
        $tid = $_SESSION['TicketId'];
        $note = $_POST['note'];
        $a=date("Y-m-d H:i:s");
        $query = "INSERT INTO Notes (TicketId,Note) Values($tid,$note)";
        if ($conn->query($query) === TRUE) {
            $b = true;
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    }

//    if($_SERVER['REQUEST_METHOD']=='POST') {
//
//        $tID = isset($_POST['TicketId']) ? $_POST['TicketId'] : " ";
//        $_SESSION['ID'] = $tID;
//        if ($tID) {
//            header('location:editTicket.php');
//        }
//    }

    ?>

</div>


</body>
</html>

