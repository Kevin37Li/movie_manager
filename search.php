<html>

<style>
    table, th, td {
    border:1px solid black;
    }
</style>

<body>

<h2><b> Searching Page :</b></h3>
<hr>

<?php

$db = new mysqli('localhost', 'cs143', '', 'class_db');
if ($db->connect_errno > 0) { 
    die('Unable to connect to database [' . $db->connect_error . ']'); 
}

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
else if(isset($_GET['actor'])) {


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
    HTML;

    if(!empty($_GET['actor'])) {
    
        $name = explode(" ", $_GET["actor"]);
        $first_name = $name[0];
        $last_name = $name[1];
    }
    else {
        $first_name = "";
        $last_name = "";
    }
    

    // if($empty($name))
    // {
        // echo "first name is empty".count($name);
    // }

    if(empty($last_name)){
        $actor_info = $db->prepare("select id, last, first, dob 
                                    from Actor 
                                    where lower(first) like ? or lower(last) like ?");

        $actor_info->bind_param('ss', strtolower('%'.$first_name.'%'),
                                    strtolower('%'.$first_name.'%'));
    } else {
        $actor_info = $db->prepare("select id, last, first, dob 
                                    from Actor 
                                    where (lower(first) like ? or lower(last) like ?) and lower(last) like ?");

        $actor_info->bind_param('sss', strtolower('%'.$first_name.'%'),
                                    strtolower('%'.$first_name.'%'),
                                    strtolower('%'.$last_name.'%'));
    }
    $actor_info->execute();
    $actor_info->bind_result($aid, $last, $first, $dob);
    $actor_info->store_result();

    while($actor_info->fetch()) {
        echo "<tr>";
        echo "<td><a href=\"actor.php?id=".$aid."\">";
        echo $first.' '.$last;
        echo "</a></td>";

        echo "<td><a href=\"actor.php?id=".$aid."\">";
        echo $dob;
        echo "</a></td></tr>";
        
    }

    $actor_info->close();

    echo "</tbody></table>";
}
else if(isset($_GET['movie'])) {


    echo <<< HTML

        <form class="form-group" method="GET" id="usrform2">
        <label for="search_input2">Movie title:</label>
            <input type="text" id="search_input2" class="form-control" placeholder="Search..." name="movie">
            <input type="submit" value="Search Movie!" class="btn btn-default" style="margin-bottom:10px">
        </form>

        <h4><b>matching Movies are:</b></h4>

        <table>
            <thead>
                <tr>
                    <td>Title</td>
                    <td>Year</td>
                </tr>
            </thead>
            <tbody>
    HTML;

    if(!empty($_GET['movie'])) {
    
        $keywords = explode(" ", $_GET["movie"]);
    }
    else {
        $keywords[0] = "";
    }
    

    $query = "select id, title, year
              from Movie
              where";
    $i = 0;

    foreach($keywords as $keyword)
    {
        $keyword = trim($keyword);
        if($i == 0)
        {
            $query .= " title like '%$keyword%'";
        }
        else
        {
            $query .= " and title like '%$keyword%'";
        }

        $i++;
    }

    $rs = $db->query($query);


    while($row = $rs->fetch_assoc()) {
        echo "<tr>";
        echo "<td><a href=\"movie.php?id=".$row['id']."\">";
        echo $row['title'];
        echo "</a></td>";

        echo "<td><a href=\"actor.php?id=".$row['id']."\">";
        echo $row['year'];
        echo "</a></td></tr>";
        
    }

    $rs->free();

    echo "</tbody></table>";
}

?>
        
<?php
$db->close();
?>

</body>
</html>