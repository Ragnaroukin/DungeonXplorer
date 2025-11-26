<?php 
require_once "header.php";
?>
<section class="get-in-touch">
    <h1 class="title">Ajout de classe :</h1>
    <form class="contact-form row" method="post" action="">
        <div class="img-field">
            <div id="upload-box1">
                <span id="text1">Cliquer pour ajouter une image</span>
                <img id="preview1">
            </div>

            <input type="file" id="imageInput1" name="image1" accept="image/*" hidden>

            <div id="upload-box2">
                <span id="text2">Cliquer pour ajouter une image</span>
                <img id="preview2">
            </div>

            <input type="file" id="imageInput2" name="image2" accept="image/*" hidden>
            <script>
                const box1 = document.getElementById('upload-box1');
                const input1 = document.getElementById('imageInput1');
                const preview1 = document.getElementById('preview1');
                const text1 = document.getElementById('text1');

                const box2 = document.getElementById('upload-box2');
                const input2 = document.getElementById('imageInput2');
                const preview2 = document.getElementById('preview2');
                const text2 = document.getElementById('text2');

                box1.addEventListener('click', () => {
                    input1.click();
                });

                input1.addEventListener('change', () => {
                    const file1 = input1.files[0];

                    if (!file1) return;

                    const reader1 = new FileReader();

                    reader1.onload = (e) => {
                        preview1.src = e.target.result;
                        preview1.style.display = 'block';
                        text1.style.display = 'none';
                    };

                    reader1.readAsDataURL(file1);
                })

                box2.addEventListener('click', () => {
                    input2.click();
                });

                input2.addEventListener('change', () => {
                    const file2 = input2.files[0];

                    if (!file2) return;

                    const reader2 = new FileReader();

                    reader2.onload = (e) => {
                        preview2.src = e.target.result;
                        preview2.style.display = 'block';
                        text2.style.display = 'none';
                    };

                    reader2.readAsDataURL(file2);
                });
            </script>

        </div>
        <div class="form-field col-lg-6">
            <label>Nom :</label>
            <input id="num" name="name" class="input-text js-input" type="text" placeholder="Nom de classe" required>
        </div>
        <br>
        <div class="form-field col-lg-6 ">
            <label>Vie :</label>
            <input id="pv" name="pv" class="input-text js-input" type="number" required>
        </div>
        <div class="form-field col-lg-6 ">
            <label>Mana :</label>
            <input id="mp" name="mp" class="input-text js-input" type="number" required>
        </div>
        <div class="form-field col-lg-6 ">
            <label>Force :</label>
            <input id="str" name="str" class="input-text js-input" type="number" required>
        </div>
        <div class="form-field col-lg-6 ">
            <label>Initiative :</label>
            <input id="ini" name="ini" class="input-text js-input" type="number" required>
        </div>
        <div class="form-field col-lg-6 ">
            <label>Max item :</label>
            <input id="max-item" name="maxItem" class="input-text js-input" type="number" required>
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