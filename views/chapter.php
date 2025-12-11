<div id="chapterContent" class="d-flex justify-content-center align-items-center">
    <div id="chapImage">
        <img src="<?php echo $chapter["chapter_img"]; ?>" alt="Château">
        <div id="story">
            <!-- Ton texte de dialogue ici -->
            <?php echo $chapter["chapter_content"]; ?>
        </div>
    </div>
    <div class="dialog-container">
        <?php foreach($links as $link) { ?>
        <a href="#" class="dialog-box"><?php echo $link["link_description"]?></a>
        <?php } ?>
    </div>
</div>