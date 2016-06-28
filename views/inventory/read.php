<?php include_once('../templates/header.php'); ?>
<div class="contains">
    <div class='wrapper'>
        <?php
         // Output results 
        if ($results) {
            echo "<h2>Inventory List</h2>";
                echo "<table><tr><th>Movie Title</th><th>Total Inventory</th><th>Inventory Details</th><th>Store Address</th></tr>";

                foreach ($results as $key => $value) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($value['title'], ENT_QUOTES) . "</td>" .
                    "<td>" . htmlspecialchars($value['inventory_total'], ENT_QUOTES) . "</td>" .
                    "<td>" . htmlspecialchars($value['inventory_id'], ENT_QUOTES) . "</td>" .
                    "<td>" . htmlspecialchars($value['address'], ENT_QUOTES) . "</td>";
                    echo "</tr>";
                }
            echo "</table>";
        } else {
            echo '<p class="alert">Sorry, connection error, cannot read inventory. Try again later</p>'; // Output no results message
        }
        ?>
    </div>
</div>
<?php include_once('../templates/footer.php'); ?>

