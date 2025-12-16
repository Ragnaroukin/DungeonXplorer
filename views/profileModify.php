<div class="profile-container">
    <header class="profile-header">
        <h1>Profil</h1>
    </header>

    <form method="post" action="modifying">
        <div class="profile-image-box">
            <div id="upload-box">
                <img id="preview" src=<?= url($joueurImage) ?>>
            </div>

            <input type="file" id="imageInput" name="image" accept="image/*" hidden>
            <script>
                const box = document.getElementById('upload-box');
                const input = document.getElementById('imageInput');
                const preview = document.getElementById('preview');

                box.addEventListener('click', () => {
                    input.click();
                });

                input.addEventListener('change', () => {
                    const file = input.files[0];

                    if (!file) return;

                    const reader = new FileReader();

                    reader.onload = (e) => {
                        preview.src = e.target.result;
                    };

                    reader.readAsDataURL(file);
                });
            </script>
        </div>
        <p class="fst-italic">Cliquer sur l'image pour la modifier</p>

        <section class="profile-details">
            <p>
                <span>Pseudo :</span> <?= $pseudo ?>
            </p>
            <p>
                <?php if ($admin) {
                    echo '<span>Statut :</span> Administrateur';
                } else {
                    echo '<span>Statut :</span> Utilisateur';
                } ?>
            </p>
        </section>
        <input class="btn btn-lg btn-danger text-light mt-3 w-100" type="submit" value="Valider">
    </form>
</div>