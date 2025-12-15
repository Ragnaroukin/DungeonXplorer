<div class="classCards">
    <?php foreach($class as $c) {?>
    <div class="card">
        <img src="../<?php echo $c["class_img"] ?>" alt="">
        <form action="hero" method="post">
            <input type="hidden" name="class_id" value="<?php echo $c["class_id"] ?>">
            <input type="submit" value="<?php echo $c["class_name"] ?>">
        </form>
    </div>
    <?php } ?>
</div>