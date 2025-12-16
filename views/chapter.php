<?php require_once "inventaire.php"; ?>

<div id="chapterContent" class="d-flex justify-content-center align-items-center">
    <div id="chapImage">
        <img src="<?php echo $chapter["chapter_image"]; ?>" alt="Château">
        <div id="story">
            <?php echo $chapter["chapter_content"]; ?>
        </div>
    </div>

    <div class="dialog-container">
        <?php foreach ($links as $link) { ?>
            <form action="avancement" method="POST" class="dialog-form">
                <input type="hidden" name="choice" value="<?php echo $link['link_chapter_id']; ?>">
                <button type="submit" class="dialog-box">
                    <?php echo $link["link_description"]; ?>
                </button>
            </form>
        <?php } ?>

    </div>
</div>

<script src="js/inventaire.js"></script>