<?php include_once('../templates/header.php'); ?>

<style> 
    table tr td { width: 20%; }
</style>
<div class="contains">
    <div class="wrapper">
        <h1>Rentals</h1>
        <form action="/elearn/mvc/public/rentals" method="POST">
            <input type="text" name="q" placeholder="Rental search" value="<?php echo htmlspecialchars($q, ENT_QUOTES); ?>" />
            <button>Search</button>
        </form>
    </div>
    <!--</div>
    <div class='contains'>-->
    <div class='wrapper'>
        <?php
// Output results if needed
        if ($posted) {
            if ($results) {
                // output results
                echo "<h3 class='center sucess'> There are " . count($results) . " Movie Rental" . (count($results) == 1 ? "  " : "s") . "  related to '" . strtoupper($q) . "' Search" . "</h3>";
                echo "<table>";     //open the table
                echo "<tr>";        
                echo "<th>Movie Title</th><th>First Name</th><th>Last Name</th><th>Rental Date</th><th>Return Date</th>";  //Header rows
                echo "</tr>";      
                foreach ($results as $key => $value) {
                    echo "<tr>";  //record row
                    echo "<td>" . htmlspecialchars($value['title'], ENT_QUOTES) . "</td>";
                    echo "<td>" . htmlspecialchars($value['first_name'], ENT_QUOTES) . "</td>";
                    echo "<td>" . htmlspecialchars($value['last_name'], ENT_QUOTES) . "</td>";
                    echo "<td>" . htmlspecialchars(date('m/d/Y', strtotime($value['rental_date'])), ENT_QUOTES) . "</td>";
                    echo "<td>" . htmlspecialchars(date('m/d/Y', strtotime($value['return_date'])), ENT_QUOTES) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";   //close the table
            } else {
                echo '<p class="alert">Sorry, no records match your search...</p>'; // Output no results message
            }
        }
        ?>
    </div>
</div>

<?php include_once('../templates/footer.php'); ?>

