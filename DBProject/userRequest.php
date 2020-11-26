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
            function showPanel(){
                // var elem = document.getElementById("ticketPanelButton");
                document.getElementById("sideBar").style.width = "250px";
            }
            function hidePanel(){
                // var elem = document.getElementById("ticketPanelButton");
                document.getElementById("sideBar").style.width = "0";
            }
        </script>
        <button onclick = "showTickets()"  id="ticketB" name="filter">View Tickets</button>
        <button onclick = "showPanel()"  id="ticketPanelButton" name="filter">Ticket Panel</button>
    </div>

    <div class="button-box">
    </div>
</div>

<div id ="sideBar">
    <h3>Generate A Ticket</h3>
    <form>
        <p class ="closeButton" onclick = "hidePanel()"
        >Close</p>
        <input type="text" placeholder="fullMinerEmail">
        <div style="padding: 10px"></div>
        <select name="cols" id="cols" class="select">
            <option id="select-title">Select Category</option>
        </select>

        <div style="padding: 10px"></div>
<!--        <input type="number" placeholder="Limit number of rows">-->
        <div style="padding: 10px"></div>

    </form>

    <div id="table-select">
        <div id="table-box" onCLick="showCheckboxes()">

        </div>

        <div id="checkboxes" class="hidden">
            <label for="col1">
                <input type="checkbox" id="col1" />col1</label>
            <label for="col2">
                <input type="checkbox" id="col2" />col4</label>
            <label for="col3">
                <input type="checkbox" id="col3" />col5</label>
            <label for="col4">
                <input type="checkbox" id="col4" />col6</label>
            <label for="col5">
                <input type="checkbox" id="col5" />col7</label>
            <label for="col6">
                <input type="checkbox" id="col4" />col8</label>
            <label for="col7">
                <input type="checkbox" id="col5" />col9</label>
            <label for="col8">
                <input type="checkbox" id="col6" />col10</label>
        </div>
    </div>

    <div style="padding: 10px"></div>

    <button onclick="showDataTable()">Fake Submit</button>
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
    ?><br>

</>


<!--<div id = "data-table" class = "invisible">-->
<!--    <table>-->
<!--        <tr>-->
<!--            <th>Name</th>-->
<!--            <th>ID</th>-->
<!--            <th>Date of Purchase</th>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>app.blah.example</td>-->
<!--            <td>23987698630984</td>-->
<!--            <td>03/06/2020</td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>movie.another.example</td>-->
<!--            <td>43637658996754</td>-->
<!--            <td>03/05/2020</td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>tv.show.wow</td>-->
<!--            <td>56457457659769</td>-->
<!--            <td>03/04/2020</td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>app.fun.app</td>-->
<!--            <td>43653476744575</td>-->
<!--            <td>03/05/2020</td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>movie.harry.potter</td>-->
<!--            <td>98703495034546</td>-->
<!--            <td>03/08/2020</td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>movie.another.one</td>-->
<!--            <td>49046980954567</td>-->
<!--            <td>03/07/2020</td>-->
<!--        </tr>-->
<!--    </table>-->
<!--</div>-->


<div id = "share" class="invisible">
    <h4>Share Query</h4>
    <input type="text" placeholder="Share with a fellow Googler.">
    <div style="padding:10px"></div>
    <button id="header-button" onclick="hideShare()">Share</button>
</div>

<!--<script src="script.js"></script>-->


</body>
</html>

