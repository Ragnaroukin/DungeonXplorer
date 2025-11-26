<?php require_once "header.php" ?>
<section class="get-in-touch">
    <h1 class="title">Ajout Model :</h1>
    <form class="contact-form row">
        <div class="img-field">
            <div id="upload-box">
                <span id="text">Cliquer pour ajouter une image</span>
                <img id="preview">
            </div>

            <input type="file" id="imageInput" name="image" accept="image/*" hidden>
            <script>
                const box = document.getElementById('upload-box');
                const input = document.getElementById('imageInput');
                const preview = document.getElementById('preview');
                const text = document.getElementById('text');

                box.addEventListener('click', () => {
                    input.click();
                });

                input.addEventListener('change', () => {
                    const file = input.files[0];

                    if (!file) return;

                    const reader = new FileReader();

                    reader.onload = (e) => {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                        text.style.display = 'none';
                    };

                    reader.readAsDataURL(file);
                });
            </script>

        </div>
        <div class="form-field col-lg-6">
            <label>Numéro :</label>
            <input id="num" class="input-text js-input" type="number" placeholder="Numéro du chapitre" required>
        </div>
        <div class="form-field col-lg-6">
            <label>Dropdown :</label>
            <br>
            <select id="dropdown" name="dropdown" class="w-100">
                <option value="">-- Choisir une catégorie --</option>
                <option value="action">Action</option>
                <option value="aventure">Aventure</option>
                <option value="fantasy">Fantaisie</option>
                <option value="horreur">Horreur</option>
            </select>
        </div>
        <div class="form-field col-lg-6 ">
            <label>Champ textuel :</label>
            <input id="champ-textuel" class="input-text js-input" type="text" required>
        </div>
        <div class="form-field col-lg-6 ">
            <label>Champ numérique :</label>
            <input id="champ-num" class="input-text js-input" type="number" required>
        </div>

        <div class="form-field col-lg-6 long-text">
            <label>Description :</label>
            <textarea id="description" name="description" rows="6"></textarea>
        </div>
        <div class="form-field col-lg-12">
            <input class="submit-btn" type="submit" value="Ajouter">
        </div>
    </form>
</section>
<?php require_once "footer.php" ?>