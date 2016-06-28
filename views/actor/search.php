<?php include_once('../templates/header.php'); ?>
<div class="contains">
    <div class="wrapper">
        <!--        <h1>Actors Search</h1>-->
        <form action="/elearn/mvc/public/actors" method="POST">
            <input type="text" name="q" placeholder="Actor Name" value="<?php echo htmlspecialchars($q, ENT_QUOTES); ?>" />
            <button>Actors Search</button>
        </form>
    </div>
    <div class="wrapper">
    <?php
    // Output results if needed
    if ($posted) {
          if ($results) {
                // output results
                echo "<h3 class='center sucess'>" . count($results) . " Actor" . (count($results) == 1 ? "  " : "s") . "/films are relate d to '" . strtoupper($q) . "'" . "  Search. " . "</h3>";
                echo "<table>";
                echo "<tr>";
                echo "<th>First Name</th><th>Last Name</th><th>Film Title</th>";
                echo "</tr>";

                foreach ($results as $key => $value) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($value['first_name'], ENT_QUOTES) . "</td>" .
                    "<td>" . htmlspecialchars($value['last_name'], ENT_QUOTES) . "</td>" .
                    "<td>" . htmlspecialchars($value['films'], ENT_QUOTES) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
         } else {
                echo '<p class="alert">Sorry, no records match your search...</p>'; // Output no results message
          }
    }
    ?>
    </div>
</div>
<?php include_once('../templates/footer.php'); ?>
