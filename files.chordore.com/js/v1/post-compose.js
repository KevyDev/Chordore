document.addEventListener("DOMContentLoaded", () => {
    const postCompose = {};
    postCompose.form = document.getElementById('form-post-compose');
    postCompose.button = document.getElementById('post-compose-button');
    postCompose.cancelButton = document.getElementById('post-compose-cancel-button');
    postCompose.imageButton = document.getElementById('post-compose-img');
    postCompose.privacyButton = document.getElementById('post-compose-privacy');
    postCompose.charactersDiv = document.getElementById('post-compose-characters');
    postCompose.inputText = document.getElementById('post-compose-input-text');
    postCompose.inputPrivacy = document.getElementById('post-compose-input-privacy');
    postCompose.inputImg = document.getElementById('post-compose-input-image');
    postCompose.imgVisor = document.getElementById('post-compose-img-visor');
    postCompose.imagesSlots = [];

    // Funcion que cuenta los caracteres del post
    postCompose.countCharacters = function (characters) {
        characters = postCompose.form.text.maxLength - (characters);
        postCompose.charactersDiv.style.color = characters <= 10 ? '#f00' : '';
        postCompose.charactersDiv.innerText = characters;
    }

    // Cambiar el tamano del textarea
    postCompose.resizeTextarea = function () {
        var style = (window.getComputedStyle) ? window.getComputedStyle(postCompose.inputText) : postCompose.inputText.currentStyle;
        var textareaPaddingTop = parseInt(style.paddingTop, 10);
        var textareaPaddingBottom = parseInt(style.paddingBottom, 10);
        var textareaPaddings = textareaPaddingTop + textareaPaddingBottom;
        var textareaLineHeight = parseInt(style.lineHeight, 10);
        postCompose.inputText.style.height = ((textareaLineHeight) + textareaPaddings) + 'px';
        var textareaHeight = postCompose.inputText.scrollHeight;
        var numberOfLines = Math.floor((textareaHeight - textareaPaddings) / textareaLineHeight);
        postCompose.inputText.style.height = ((numberOfLines * textareaLineHeight) + textareaPaddings) + 'px';
    };

    // Formatear el texto escrito por el usuario
    postCompose.formatText = function () {
        var text = postCompose.inputText.value;
        postCompose.countCharacters(text.length);
        postCompose.resizeTextarea();
    }

    // Funcion para cuando se haga un submit en el form del post
    postCompose.onSubmit = function (event) {
        event.preventDefault();
        var data = new FormData();
        data.append('text', postCompose.inputText.value);
        data.append('privacy', postCompose.inputPrivacy.value);
        postCompose.imagesSlots.forEach(image => {
            data.append('images[]', image);
        });
        postCompose.form.classList.remove('shown');
        app.ajaxPetition(postCompose.form.action, postCompose.form.method, data, function (data) {
            if (data.state == 0) {
                postCompose.form.classList.add('shown');
            } else {
                postCompose.countCharacters(0);
                postCompose.inputText.value = '';
                postCompose.inputText.style.height = '';
                postCompose.imgVisor.innerHTML = '';
                postCompose.imagesSlots = [];
                postCompose.inputPrivacy.value = 1;
                postCompose.privacyButton.classList.remove('privacy-friends');
                postCompose.privacyButton.classList.remove('privacy-private');
                postCompose.privacyButton.classList.add('privacy-public');
                postCompose.inputPrivacy.value = 1;
                if (postLoaders.accountContainer) {
                    var myPostsContainer = postLoaders.accountContainer.attributes.myContainer.value;
                    if (myPostsContainer == '1') {
                        postLoaders.accountContainer.innerHTML = data.post + postLoaders.accountContainer.innerHTML;
                    }
                }
                if (postLoaders.homeContainer) {
                    postLoaders.homeContainer.innerHTML = data.post + postLoaders.homeContainer.innerHTML;
                }
                postLoaders.removeClassForAnimation();
            }
        }, 1);
    }

    // Funcion para cuando se haga click en el boton de mostrar el form en moviles
    postCompose.buttonClick = function () {
        postCompose.form.classList.add('shown');
        postCompose.inputText.focus();
    }

    // Funcion para cuando se haga click en el boton de ocultar el form en moviles
    postCompose.cancelButtonClick = function () {
        postCompose.form.classList.remove('shown');
    }

    // Funcion para cuando se cambie la privacidad del post
    postCompose.changePrivacy = function () {
        if (postCompose.inputPrivacy.value == 1) {
            postCompose.inputPrivacy.value = 2;
            postCompose.privacyButton.classList.remove('privacy-public');
            postCompose.privacyButton.classList.remove('privacy-private');
            postCompose.privacyButton.classList.add('privacy-friends');
        } else if (postCompose.inputPrivacy.value == 2) {
            postCompose.inputPrivacy.value = 0;
            postCompose.privacyButton.classList.remove('privacy-friends');
            postCompose.privacyButton.classList.remove('privacy-public');
            postCompose.privacyButton.classList.add('privacy-private');
        } else if (postCompose.inputPrivacy.value == 0) {
            postCompose.inputPrivacy.value = 1;
            postCompose.privacyButton.classList.remove('privacy-friends');
            postCompose.privacyButton.classList.remove('privacy-private');
            postCompose.privacyButton.classList.add('privacy-public');
        } else {
            postCompose.inputPrivacy.value = 1;
            postCompose.privacyButton.classList.remove('privacy-friends');
            postCompose.privacyButton.classList.remove('privacy-private');
            postCompose.privacyButton.classList.add('privacy-public');
        }
    }

    // Funcion para cuando se vaya a seleccionar una imagen
    postCompose.selectImage = function (event) {
        var extSuport = /(.jpeg|.jpg|.png|.gif|.JPEG|.JPG|.PNG|.PNG)$/i,
            images = postCompose.inputImg.files;
        var images_array = Object.values(images);
        var bloqued = false;
        images_array.forEach((image, index, images_arr) => {
            if (!bloqued) {
                if (extSuport.exec(image.name)) {
                    if (postCompose.imagesSlots.length < postCompose.inputImg.attributes.maxImgs.value) {
                        setSlot = postCompose.setImageSlot(image);
                    } else {
                        bloqued = true;
                        alert('demasiadas imgs');
                    }
                }
            }
        });
        postCompose.inputImg.value = '';
    };

    // Anadir una imagen del array de seleccionadas
    postCompose.setImageSlot = function (image) {
        if (postCompose.imagesSlots.length > 0) {
            postCompose.imagesSlots.forEach(slot => {
                if (slot == image) {
                    return false;
                }
            });
            postCompose.imagesSlots[postCompose.imagesSlots.length] = image;
            postCompose.setNewImgVisor(image);
            return true;
        } else {
            postCompose.imagesSlots[postCompose.imagesSlots.length] = image;
            postCompose.setNewImgVisor(image);
            return true;
        }
    }

    // Quitar una imagen del array de seleccionadas
    postCompose.removeImageSlot = function (index) {
        if (postCompose.imagesSlots.length > 0) {
            postCompose.imagesSlots.splice(index, 1);
        } else {
            return false;
        }
    }

    // Poner una imagen en los visores
    postCompose.setNewImgVisor = function (image) {
        var visor = new FileReader();
        visor.onload = function (e) {
            postCompose.imgVisor.innerHTML += '<div class="img-container"><img src="' + e.target.result + '" /><span class="icon-cross post-compose-img-remove"></span></div>';
        }
        visor.readAsDataURL(postCompose.imagesSlots[postCompose.imagesSlots.length - 1]);
    }

    // Quitar una imagen de los visores
    postCompose.removeImgVisor = function (image) {
        image.classList.add('removing');
        var image_index = Object.values(postCompose.imgVisor.children).indexOf(image);
        postCompose.removeImageSlot(image_index);
        setTimeout(() => {
            image.parentElement.removeChild(image);
        }, 200);
    }

    if (postCompose.form) {
        // Cuando se da click en el boton de mostrar el form
        postCompose.button.addEventListener('click', postCompose.buttonClick);

        // Cuando se da click en el boton de ocultar el form
        postCompose.cancelButton.addEventListener('click', postCompose.cancelButtonClick);

        // Contar inicialmente los caracteres del form
        postCompose.countCharacters(postCompose.inputText.value.length);

        // Formatear el texto escrito por el usuario
        postCompose.inputText.addEventListener('keyup', function () { postCompose.formatText(); });
        postCompose.inputText.addEventListener('mouseup', function () { postCompose.formatText(); });

        // Cambiar la privacidad cuando se de click en el boton
        postCompose.privacyButton.addEventListener('click', postCompose.changePrivacy);

        // Boton para seleccionar imagenes
        postCompose.imageButton.addEventListener('click', () => { postCompose.inputImg.click(); });

        // Cuando se seleccione una imagen
        postCompose.inputImg.addEventListener('change', postCompose.selectImage);

        // Cuando se haga submit al form
        postCompose.form.addEventListener('submit', postCompose.onSubmit);
    }
});