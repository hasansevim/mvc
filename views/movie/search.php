<?php include_once('../templates/header.php'); ?>
<style>
    td:first-child {width: 150px;}
</style>
<div class="contains">
    <div class="wrapper">
        <form action="/elearn/mvc/public/movies" method="POST">
            <input type="text" name="q" placeholder = "Movie search.." value="<?php echo htmlspecialchars($q, ENT_QUOTES); ?>" />
            <button>Movies Search</button>
        </form> 
    </div>
    <!--</div>
    <div class='contains'>-->
    <div class='wrapper'>
        <?php
        //Output results 
        if ($posted) {
            if ($results) { //if the results array is not empty -- posted and not posted 
                echo "<table>";
                echo "<tr>";
                echo "<th>Movie Title</th><th>Release Year</th>"
                . "<th>Rental Duration</th><th>Rental Rate</th><th>Length</th><th>Replacement Cost</th><th>Rating</th><th>Description</th>";
                echo "</tr>";

                foreach ($results as $key => $value) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($value['title'], ENT_QUOTES) . "</td>";
                    //   echo "<td>" . htmlspecialchars($value['description'], ENT_QUOTES) . "</td>";
                    echo "<td>" . htmlspecialchars($value['release_year'], ENT_QUOTES) . "</td>";
                    echo "<td>" . htmlspecialchars($value['rental_duration'], ENT_QUOTES) . "</td>";
                    echo "<td>" . htmlspecialchars($value['rental_rate'], ENT_QUOTES) . "</td>";
                    echo "<td>" . htmlspecialchars($value['length'], ENT_QUOTES) . "</td>";
                    echo "<td>" . htmlspecialchars($value['replacement_cost'], ENT_QUOTES) . "</td>";
                    echo "<td>" . htmlspecialchars($value['rating'], ENT_QUOTES) . "</td>";
                    echo "<td>" . htmlspecialchars($value['description'], ENT_QUOTES) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {  // no records 
                echo '<p class="alert">Sorry, no records match your search...</p>'; // Output no results message
            }
        }
        ?>
    </div>
</div>
<?php include_once ('../templates/footer.php'); ?>


