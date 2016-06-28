<?php include_once "../templates/header.php"; ?>

<div class="contains">
    <div class='wrapper'>
        <?php
            if ($results) {
                echo "<h2>Customer List</h3>";
                echo "<table>";
                echo "<tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Address</th></tr>";
                foreach ($results as $key => $value) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($value['first_name'], ENT_QUOTES) . "</td>";
                    echo "<td>" . htmlspecialchars($value['last_name'], ENT_QUOTES) . "</td>";
                    echo "<td>" . htmlspecialchars($value['email'], ENT_QUOTES) . "</td>";
                    echo "<td>" . htmlspecialchars($value['contact'], ENT_QUOTES) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else { // no records
                echo "<p class='alert'>Sorry, no records found. Try again.</p>";
            }
        ?>
    </div>
</div>

<?php include_once "../templates/footer.php"; ?>
