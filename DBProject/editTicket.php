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
            function goBack() {
                window.location.href = "admin.php";
            }
        </script>
        <button onclick = "showTickets()"  id="ticketB" name="filter">Edit Ticket</button>
        <button onclick = "showNotes()"  id="noteButton" name="filter">Show Notes</button>
        <button onclick = "goBack()" href="admin.php" id ="ticketB">Go Back</button>

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

<div>
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
                <label for='note'>Enter a note for this ticket:</label><br>
                <textarea maxlength='200' rows='4' cols='50' id='note' name='note'></textarea>
                <div style='padding:10px'></div>
                <label for='status'>Change Ticket Status</label><br>
                
                <select name='status' id='status' class='select'>
                    <option value='Open'>Open</option>
                    <option value='Hold'>Hold</option>
                    <option value='Solved'>Solved</option>
                </select>
                
                <br>
                <br>
                <input type='submit' value='Add Note' name='addNote' style = 'width: 80px height: 40px'>
                
                </form>
                
              
                <br>";

        echo "</div>";
    }

    function viewNotes(){
        global $conn;
        $tid = $_SESSION['TicketId'];
        $query = "SELECT * FROM Notes Where TicketId = $tid";
        $result = mysqli_query($conn,$query);
        $q2 = "SELECT lastChanged FROM statusChange Where TicketId = $tid";
        $lastChanged = mysqli_fetch_array(mysqli_query($conn,$q2));
        echo '<br></br>';
        echo "<div id = 'notes-on-ticket' class = 'invisible'><table> ";
        echo "<h3> Here are the Notes on this particular ticket.</h3> ";
        echo "<tr><th>Ticket ID</th><th>Author</th><th>Time Added</th><th>Last Changed</th><th>Note</th>";
        while($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo ("<td>".$row[0]."</td>" . " " . " <td>".$row[2]."</td>" . " <td>".$row[3]."</td>" . " <td>".$lastChanged[0]."</td>" ." <td>".$row[1]."</td>");

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
        $selectedStatus = $_POST['status'];
        //TODO: if selected status == resolved update time resolved  attribute in ticket table.
        $date=date("Y-m-d H:i:s");
        if (!$note == ""){
            $query = "INSERT INTO Notes (TicketId,TechMember,Note,TimeAdded) Values($tid,'$user','$note','$date')";
            if ($conn->query($query) === TRUE) {
                $b = true;
            } else {
                echo "Error: " . $query . "<br>" . $conn->error;
            }
        }


        function format_interval(DateInterval $interval) {
            $result = "";
            if ($interval->y) { $result .= $interval->format("%y years "); }
            if ($interval->m) { $result .= $interval->format("%m months "); }
            if ($interval->d) { $result .= $interval->format("%d days "); }
            if ($interval->h) { $result .= $interval->format("%h hours "); }
            if ($interval->i) { $result .= $interval->format("%i minutes "); }
            if ($interval->s) { $result .= $interval->format("%s seconds "); }

            return $result;
        }





        $dateNow= new DateTime();
        $currStatusQ = "Select Status from ticket where TicketId = $tid";
        $status = mysqli_fetch_array(mysqli_query($conn,$currStatusQ));
        if ($status[0] == $selectedStatus) {
            echo "";
        } else {
            if ($selectedStatus == "Solved"){
                $startTimeQ = "Select RequestTime from ticket where ticketId = $tid";
                $startTime = mysqli_fetch_array(mysqli_query($conn,$startTimeQ));
                $diff = abs(strtotime($date) - strtotime($startTime[0]));  //What is stored in the DB
                    /// THIS IS HOW YOU CONVERT TO HUMAN READBLE FORMAT
//                $start_time   = date_create_from_format('Y-m-d H:i:s', $startTime[0]);
//                $difference = $dateNow->diff($start_time);
//                echo "Difference:" . format_interval($difference) . "<br>";
//

                $resolveQuery = "UPDATE Ticket set ResolveTime = $diff WHERE TicketID = $tid";
                $resolved = mysqli_query($conn,$resolveQuery);
            }
            $updateQuery = "UPDATE Ticket set Status = '$selectedStatus' WHERE TicketId = $tid";

            $q2 = "INSERT INTO statusChange (TicketId,lastChanged) Values($tid,'$date')";

            if ($conn->query($q2) === TRUE) {
                $b = true;
            } else {
                echo "Error: " . $q2 . "<br>" . $conn->error;
            }
            if ($conn->query($updateQuery) === TRUE) {
                $b = true;
            } else {
                echo "Error: " . $updateQuery . "<br>" . $conn->error;
            }
        }
        $URL = "editTicket.php";
        echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';

    }


    ?>

</div>


</body>
</html>

