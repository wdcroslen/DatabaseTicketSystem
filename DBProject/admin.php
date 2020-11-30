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
                function showTickets() {
                    setInvisible();

                    var elem = document.getElementById("data-table");
                    var logo = document.getElementById("Ulogo");
                    var butt = document.getElementById("ticketB");

                    if (elem.className == "invisible") {
                        elem.classList.remove("invisible");
                        butt.textContent = "Hide Tickets";
                        logo.classList.add("invisible");
                    } else {
                        elem.classList.add("invisible");
                        logo.classList.remove("invisible");
                        butt.textContent = "View Tickets";
                    }
                }

                function showOpenTickets() {
                    setInvisible();

                    var elem = document.getElementById("openTickets");
                    var logo = document.getElementById("Ulogo");
                    var butt = document.getElementById("ticketB2");

                    if (elem.className == "invisible") {
                        elem.classList.remove("invisible");
                        butt.textContent = "Hide Tickets";
                        logo.classList.add("invisible");
                    } else {
                        elem.classList.add("invisible");
                        logo.classList.remove("invisible");
                        butt.textContent = "Unresolved Tickets";
                    }
                }

                function showTicketLeaderboard() {
                    setInvisible();

                    var elem = document.getElementById("ticketLeaderboard");
                    var logo = document.getElementById("Ulogo");
                    var butt = document.getElementById("ticketLeaderboardButton");

                    if (elem.className == "invisible") {
                        elem.classList.remove("invisible");
                        butt.textContent = "Hide Leaderboard";
                        logo.classList.add("invisible");
                    } else {
                        elem.classList.add("invisible");
                        logo.classList.remove("invisible");
                        butt.textContent = "Ticket Leaderboard";
                    }
                }

                function setInvisible()
                {
                    document.getElementById("openTickets").classList.add('invisible');
                    document.getElementById("data-table").classList.add('invisible');
                    document.getElementById("ticketLeaderboard").classList.add('invisible');

                    document.getElementById("ticketB2").textContent = "Unresolved Tickets";
                    document.getElementById("ticketB").textContent = "View Tickets";
                    document.getElementById("ticketLeaderboardButton").textContent = "Ticket Leaderboard";
                }

                function showPanel() {
                    // var elem = document.getElementById("ticketPanelButton");
                    document.getElementById("sideBar").style.width = "310px";
                }

                function hidePanel() {
                    // var elem = document.getElementById("ticketPanelButton");
                    document.getElementById("sideBar").style.width = "0";
                }
            </script>
            <button onclick="showTickets()" id="ticketB" name="filter">View Tickets</button>
            <button onclick="showOpenTickets()" id="ticketB2" name="filter">Unresolved Tickets</button>
            <button onclick="showPanel(), fillPlaceholder()" id="ticketPanelButton" name="filter">Ticket Panel</button>
            <button onclick="showTicketLeaderboard()" id="ticketLeaderboardButton" name="filter">Ticket Leaderboard</button>

        </div>



        <div class="button-box">
        </div>

    </div>

    <div id="sideBar">
        <div>
            <h3>Resolve Tickets/Add Notes</h3>
            <form href="editTicket.php" method="post">
                <p class="closeButton" onclick="hidePanel()">Close</p>

                <label for="TicketId">Choose a Specific Ticket to View</label>
                <input type="text" id="TicketId" name="TicketId" required>
                <div style="padding: 10px"></div>
                <input type="submit" value="View Ticket" name="submit">

            </form>
        </div>

    </div>

    <div id="centered">
        <img id="Ulogo" src="UTEP_LOGO.png" alt="logo here">
    </div>

    <div id="centered-sesh">
        Welcome ADMIN <?php
                        if (isset($_SESSION['user'])) {
                            echo "Your session is running " . $_SESSION['user'];
                            showTickets();
                            showOpenTickets();
                            showTicketLeaderboard();
                        }

                        function showTickets()
                        {
                            global $conn;
                            $query = "SELECT * FROM Ticket";
                            $result = mysqli_query($conn, $query);
                            echo '<br></br>';
                            echo "<div id = 'data-table' class = 'invisible'><table> ";
                            echo "<h3>These are all the Tickets</h3> ";
                            echo "<tr><th>Ticket ID</th><th>User</th><th>Status</th><th>Category</th><th>Time Requested</th>";
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr>";
                                echo ("<td>" . $row[0] . "</td>" . " " . " <td>" . $row[1] . "</td>" .
                                    "<td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td>");

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

                        function showTicketLeaderboard()
                        {
                            global $conn;
                            $query = "SELECT * FROM Ticket WHERE ResolveTime is not null order by ResolveTime";
                            $result = mysqli_query($conn, $query);
                            echo '<br></br>';
                            echo "<div id = 'ticketLeaderboard' class = 'invisible'><table> ";
                            echo "<h3>Leaderboard By Fastest Resolved</h3> ";
                            echo "<tr><th>Ticket ID</th><th>User</th><th>Status</th><th>Category</th><th>Time Resolved</th>";

                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr>";
                                echo ("<td>" . $row[0] . "</td>" . " " . " <td>" . $row[1] . "</td>" .
                                    "<td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . formatSeconds($row[5]) . "</td>");

                                echo "</tr>";
                                print("\n");
                            }
                            echo "</table>";
                            echo "<br>";


                            echo "<div> <h3>Most Popular Category</h3> </div>";
                            $query = "SELECT category FROM Ticket GROUP BY Category ORDER BY COUNT(*) DESC limit 1";
                            $result = mysqli_fetch_array(mysqli_query($conn, $query));
                            echo "<p>$result[0]</p>";

                            echo "<br>";
                            echo "<div> <h3>Average Resolve Time</h3> </div>";
                            $query = "select avg(ResolveTime) from ticket";
                            $result = mysqli_fetch_array(mysqli_query($conn, $query));
                            $a = formatSeconds($result[0]);
                            echo "<p>$a</p> <p>Hours:Minutes:Seconds</p></div>";
                        }

                        function formatSeconds($seconds)
                        {
                            $hours = 0;
                            $milliseconds = str_replace("0.", '', $seconds - floor($seconds));

                            if ($seconds > 3600) {
                                $hours = floor($seconds / 3600);
                            }
                            $seconds = $seconds % 3600;


                            return str_pad($hours, 2, '0', STR_PAD_LEFT)
                                . gmdate(':i:s', $seconds)
                                . ($milliseconds ? ".$milliseconds" : '');
                        }

                        function generateTicket()
                        {
                            global $conn;
                            $user =  $_GET['minerRequest'];
                            $category = $_GET['category'];
                            $query = "INSERT INTO Ticket (UtepEmail,Status,Category) Values('$user','Open','$category')";
                            if ($conn->query($query) === TRUE) {
                                $a = true;
                            } else {
                                echo "Error: " . $query . "<br>" . $conn->error;
                            }
                        }

                        if (isset($_POST['submit'])) {
                            $tID = isset($_POST['TicketId']) ? $_POST['TicketId'] : " ";
                            $_SESSION['TicketId'] = $tID;
                            $URL = "editTicket.php";
                            echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
                            echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                            //        header('Location:editTicket.php');
                        }

                        function format_interval(DateInterval $interval)
                        {
                            $result = "";
                            if ($interval->y) {
                                $result .= $interval->format("%y years ");
                            }
                            if ($interval->m) {
                                $result .= $interval->format("%m months ");
                            }
                            if ($interval->d) {
                                $result .= $interval->format("%d days ");
                            }
                            if ($interval->h) {
                                $result .= $interval->format("%h hours ");
                            }
                            if ($interval->i) {
                                $result .= $interval->format("%i minutes ");
                            }
                            if ($interval->s) {
                                $result .= $interval->format("%s seconds ");
                            }

                            return $result;
                        }
                        ?>

    </div>


</body>

</html>