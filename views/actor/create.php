<?php include_once('../templates/header.php'); ?>

<div class="contains">
    <div class="wrapper">
        <form action="/elearn/mvc/public/actors" method="POST">
            <input type="text" name="first_name" placeholder="first name" value="<?php echo htmlspecialchars($first_name, ENT_QUOTES); ?>" />
            <input type="text" name="last_name" placeholder="last name" value="<?php echo htmlspecialchars($last_name, ENT_QUOTES); ?>" /> 
           <button>Create a Record</button>
        </form>
    </div>
</div>  
<div class="contains">
    <div class="wrapper">
        <?php
        if ($posted) {
            if ($success) {
                echo "<p>A new record was created successfully</p>";
            } else {
                echo "<p>Sorry, database error, cannot create new record. </p>";
            }
        }
        ?>
    </div>
</div>
<?php include_once ('../templates/footer.php'); ?>

