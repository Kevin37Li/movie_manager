<html>
<body>

<h2><b> Searching Page :</b></h3>
<hr>

<?php

if(empty($_GET)) {
    echo <<< HTML
        <form class="form-group" method="GET" id="usrform1">
        <label for="search_input1">Actor name:</label>
            <input type="text" id="search_input1" class="form-control" placeholder="Search..." name="actor">
            <input type="submit" value="Search Actor!" class="btn btn-default" style="margin-bottom:10px">
        </form>
                <form class="form-group" method="GET" id="usrform2">
        <label for="search_input2">Mo-ie title:</label>
            <input type="text" id="search_input2" class="form-control" placeholder="Search..." name="movie">
            <input type="submit" value="Search Movie!" class="btn btn-default" style="margin-bottom:10px">
        </form>
        
    HTML;
}
else if(isset($_GET['actor']) && !empty($_GET['app'])) {
    echo <<< HTML

        <form class="form-group" method="GET" id="usrform1">
        <label for="search_input1">Actor name:</label>
            <input type="text" id="search_input1" class="form-control" placeholder="Search..." name="actor">
            <input type="submit" value="Search Actor!" class="btn btn-default" style="margin-bottom:10px">
        </form>

        <h4><b>matching Actors are:</b></h4>

        <table>
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Date of Birth</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><a href="actor.php?id=55773">Joel Schumacher</a></td>
                    <td><a href="actor.php?id=55773">1939-08-29</a></td>
                </tr>
            </tbody>
        </table>
    HTML;
}

?>
        
          <!--php query start from here -->

  <!--php query end from here -->
</body>
</html>