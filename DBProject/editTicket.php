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
                document.getElementById("notes-on-ticket").classList.add("invisible");
                document.getElementById("noteButton").textContent = "Show Notes";

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
                    butt.textContent = "Edit Ticket"
                }
            }

            function showNotes(){
                document.getElementById("data-table").classList.add("invisible");
                document.getElementById("ticketB").textContent = "Edit Ticket";

                var elem = document.getElementById("notes-on-ticket");
                var logo =  document.getElementById("Ulogo");
                var butt = document.getElementById("noteButton");

                if (elem.className == "invisible"){
                    elem.classList.remove("invisible");
                    butt.textContent = "Hide Tickets"
                    logo.classList.add("invisible");
                }
                else {
                    elem.classList.add("invisible");
                    logo.classList.remove("invisible");
                    butt.textContent = "Show Notes"
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
        <button onclick = "showTickets()"  id="ticketB" name="filter">Edit Ticket</button>
        <button onclick = "showNotes()"  id="noteButton" name="filter">Show Notes</button>
        <button onclick = "showPanel()"  id="ticketPanelButton" name="filter">Ticket Panel</button>

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
        viewNotes();
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
                <textarea maxlength='200' rows='4' cols='50' id='note' name='note'> Enter Note here...</textarea>
                <input type='submit' value='Add Note' name='addNote'>
                </form>
                
              
                <br>";

        echo "</div>";
    }

    function viewNotes(){
        global $conn;
        $tid = $_SESSION['TicketId'];
        $query = "SELECT * FROM Notes Where TicketId = $tid";
        $result = mysqli_query($conn,$query);
        echo '<br></br>';
        echo "<div id = 'notes-on-ticket' class = 'invisible'><table> ";
        echo "<h3> Here are the Notes on this particular ticket.</h3> ";
        echo "<tr><th>Ticket ID</th><th>Note</th>";
        while($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo ("<td>".$row[0]."</td>" . " " . " <td>".$row[1]."</td>");

            echo "</tr>";
            print("\n");
        }
        echo "</table> ";

        echo "</div>";
    }


    if (isset($_POST['addNote'])) {
        global $conn;
        $user = $_SESSION['user'];
        $tid = $_SESSION['TicketId'];
        $note = $_POST['note'];
        $date=date("Y-m-d H:i:s");
        $query = "INSERT INTO Notes (TicketId,Note) Values($tid,'$note')";
        $q2 = "INSERT INTO AddNotes (TicketId,TechMember,TimeAdded) Values($tid,'$user','$date')";
        if ($conn->query($query) === TRUE) {
            $b = true;
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
        if ($conn->query($q2) === TRUE) {
            $b = true;
        } else {
            echo "Error: " . $q2 . "<br>" . $conn->error;
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

