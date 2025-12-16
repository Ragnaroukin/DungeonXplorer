<div class="classCards">
    <?php foreach($class as $c) {?>
    <div class="card">
        <img src=<?= url($c['class_img']) ?>>
        <form action="hero" method="post">
            <input type="hidden" name="class_id" value="<?php echo $c["class_id"] ?>">
            <input type="submit" value="<?php echo $c["class_name"] ?>">
        </form>
    </div>
    <?php } ?>
</div>
<div class="d-flex justify-content-center">
    <button class="btn btn-danger align-middle btn-lg text-black fw-bold" type="button" onclick="history.back()">Retour</button>
</div>