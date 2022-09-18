<?php require_once 'parts/header.php' ?>

<div class="errors p-3">
    
    <h1 class="h2">Code: <?php echo $e->getCode() ?></h1>

    <h1 class="h2">Message: <?php echo $e->getMessage() ?></h1>

</div>

<?php require_once 'parts/footer.php' ?>
