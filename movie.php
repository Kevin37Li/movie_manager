<html>
<style>
    table, th, td {
    border:1px solid black;
    }
</style>
<body>

<?php
    $db = new mysqli('localhost', 'cs143', '', 'class_db');
    if ($db->connect_errno > 0) { 
        die('Unable to connect to database [' . $db->connect_error . ']'); 
    }

    $movie_id = $_GET["id"];

    $movie_info = $db->prepare("select * 
                                from Movie, MovieGenre 
                                where id=? and mid = id");
    $movie_info->bind_param('i', $movie_id);
    $movie_info->execute();
    $movie_info->bind_result($id, $title, $year, $rating, $company, $mid, $genre);
    $movie_info->store_result();

    if(!$movie_info->fetch()) {
        echo "movie_info fetch is failed";
    }

    $movie_info->close();

    $actor_info = $db->prepare("select id, first, last, role
                                from MovieActor, Actor 
                                where mid = ? and id = aid;");
    $actor_info->bind_param('i', $movie_id);
    $actor_info->execute();
    $actor_info->bind_result($aid, $first, $last, $role);
    $actor_info->store_result();

?>

<h3><b> Movie Information Page :</b></h3>
<hr>
<h4><b> Movie Information is:</b></h4>
Title :<?php echo $title ?>(<?php echo $year ?>)<br>
Producer :<?php echo $company ?><br>
MPAA Rating :<?php echo $rating ?><br>
Genre :<?php echo $genre ?><br>

<h4><b> Actors in this Movie:</b></h4>
<table>
    <thead>
        <tr>
            <td>Name</td>
            <td>Role</td>
        </tr>
    </thead>
    <tbody>
        <?php
            while($actor_info->fetch()) {
                echo "<tr>";
                echo "<td><a href=\"actor.php?id=".$aid."\">";
                echo $first.' '.$last;
                echo "</a></td>";

                echo "<td>";
                echo $role;
                echo "</td></tr>";
                
            }

            $actor_info->close();
                    
        ?>
    </tbody>
</table>

<hr> 

<h4><b>User Review :</b></h4><a href="review.php?id=1472">By now, nobody ever rates this movie. Be the first one to give a review<br><hr></a>

<?php
    $db->close();
?>

</body>
</html> 