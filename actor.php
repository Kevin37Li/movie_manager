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

    $actor_id = $_GET["id"];

    $actor_info = $db->prepare("select * from Actor where id=?");
    $actor_info->bind_param('i', $actor_id);
    $actor_info->execute();
    $actor_info->bind_result($aid, $last, $first, $sex, $dob, $dod);
    $actor_info->store_result();

    if(!$actor_info->fetch()) {
        echo "actor_info fetch is failed";
    }

    $actor_info->close();

    $movie_actor_info = $db->prepare("select * from MovieActor where aid=?");
    $movie_actor_info->bind_param('i', $actor_id);
    $movie_actor_info->execute();
    $movie_actor_info->bind_result($mid, $aid, $role);
    $movie_actor_info->store_result();
                    
?>

    <h3><b> Actor Information Page :</b></h3>
    <hr>
    <h4><b>Actor Information is:</b></h4><div class="table-responsive">     
    <table>
        <thead> 
            <tr>
                <td>Name</td>
                <td>Sex</td>
                <td>Date of Birth</td>
                <td>Date of Death</td>
            </tr></thead>
        <tbody>
            <tr>
                <td><?php echo $first.' '.$last ?></td>
                <td><?php echo $sex ?></td>
                <td><?php echo $dob ?></td>
                <td><?php
                        if(is_null($dod)) {
                            echo "Still alive";
                        } 
                        else {
                            echo $dod;
                        }
                    ?></td>
            </tr>
        </tbody>
    </table>
    <h4><b>Actor's Movies and Role:</b></h4>
        <table>
            <thead> 
                <tr>
                    <td>Role</td>
                    <td>Movie Title</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    while($movie_actor_info->fetch()) {
                        echo "<tr><td>";
                        echo $role;
                        echo "</td>";

                        echo "<td><a href=\"movie.php?id=".$mid."\">";
                    
                        $movie_info = $db->prepare("select title from Movie where id=?");
                        $movie_info->bind_param('i', $mid);
                        $movie_info->execute();
                        $movie_info->bind_result($title);
                        $movie_info->store_result();

                        if($movie_info->fetch()) {
                            echo $title;
                            echo "</a></td></tr>";
                        } else {
                            echo "some error with movie fetch";
                        }

                        $movie_info->close();
                        
                    }

                    $movie_actor_info->close();
                    
                ?>
            </tbody>
        </table>

<?php
    $db->close();
?>

</body>
</html> 