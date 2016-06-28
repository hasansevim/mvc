
<?php include_once ('../templates/header.php'); ?>

<div class="contains">
    <div class="wrapper">
        <h1>Actors Read Only</h1>
        <?php
        if ($results) {
            //output results
            echo "<table><tr><th>First Name</th><th>Last Name</th></tr>";
            foreach ($results as $key => $value) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($value['first_name'], ENT_QUOTES) . "</td>" .
                "<td>" . htmlspecialchars($value['last_name'], ENT_QUOTES) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo '<p class="alert">Sorry, no records in the database...</p>'; // Output no results message
        }
        ?>

    </div>
</div>  

<?php include_once ('../templates/footer.php'); ?>