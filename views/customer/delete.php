<?php include_once('../templates/header.php'); ?>

<div class="contains">
    <div class="wrapper">
        <form action="/elearn/mvc/public/actors" method="GET">
            <input type="text" name="id" placeholder="enter actor id number to delete" value="<?php echo htmlspecialchars($_GET['id'], ENT_QUOTES); ?>" />
            <button>Delete a Customer</button>
        </form>
    </div>
</div>  
<div class="contains">
    <div class="wrapper">
        <?php
        if ($submitted) {
            if ($success) {
                echo ("<p>Record was deleted</p>");
            } else {
                echo ("<p>Sorry, database error, cannot delete this record" . $id . "</p>");
            }
        }
        ?>
    </div>
</div>
<?php include_once ('../templates/footer.php'); ?>
