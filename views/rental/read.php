<?php include_once('../templates/header.php'); ?>

<style> 
    table tr td { width: 20%; }
</style>
<div class="contains">
  <div class='wrapper'>
<?php
// Output results if needed

if ($results) {
    // output results
    echo "<h2>Movie Rentals Datailed List</h2>";
    echo "<table>";
    echo "<tr>";
    echo "<th>Movie Title</th><th>First Name</th><th>Last Name</th><th>Rental Date</th><th>Return Date</th>";
    echo "</tr>";
    foreach ($results as $key => $value) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($value['title'], ENT_QUOTES) . "</td>";
        echo "<td>" . htmlspecialchars($value['first_name'], ENT_QUOTES) . "</td>";
        echo "<td>" . htmlspecialchars($value['last_name'], ENT_QUOTES) . "</td>";
        echo "<td>" . htmlspecialchars(date('m/d/Y', strtotime($value['rental_date'])), ENT_QUOTES) . "</td>";
        echo "<td>" . htmlspecialchars(date('m/d/Y', strtotime($value['return_date'])), ENT_QUOTES) . "</td>";

        echo "</tr>";
    }
    echo "</table>";
} else {
    echo '<p class="alert">Sorry, database error. Cannot display movie rental information.</p>'; // Output no results message
}
?>
    </div>
</div>

<?php include_once('../templates/footer.php'); ?>

