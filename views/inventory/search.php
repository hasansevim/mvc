<?php include_once('../templates/header.php'); ?>
<div class="contains">
    <div class="wrapper">
        <form action="/elearn/mvc/public/inventory" method="POST">
            <input type="text" name="q" placeholder="store inventory search" value="<?php echo htmlspecialchars($q, ENT_QUOTES); ?>" />
            <button>Store Inventory Search</button>
        </form>
    </div>
</div>
<div class='contains'>
    <div class='wrapper'>
        <?php
        // Output results 

        if ($posted) {
            if ($results) {
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
                echo '<p class="alert">Sorry, no records match your search...</p>'; // Output no results message
            }
        }
        ?>
    </div>
</div>
<?php include_once('../templates/footer.php'); ?>

