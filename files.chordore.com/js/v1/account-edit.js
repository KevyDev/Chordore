document.addEventListener("DOMContentLoaded", () => {
    const accountEdit = {};
    accountEdit.form = document.getElementById('account-edit-form');
    accountEdit.inputBanner = document.getElementById('account-edit-form-input-banner');
    accountEdit.inputPhoto = document.getElementById('account-edit-form-input-photo');
    accountEdit.inputName = document.getElementById('account-edit-form-input-name');
    accountEdit.inputUsername = document.getElementById('account-edit-form-input-username');
    accountEdit.inputEmail = document.getElementById('account-edit-form-input-email');
    accountEdit.inputBio = document.getElementById('account-edit-form-input-bio');
    accountEdit.inputLocation = document.getElementById('account-edit-form-input-location');
    accountEdit.inputLink = document.getElementById('account-edit-form-input-link');
    accountEdit.bannerContainer = document.getElementById('account-edit-banner-container');
    accountEdit.bannerOptionsUpload = document.getElementById('account-edit-banner-option-upload');
    accountEdit.bannerOptionsCancel = document.getElementById('account-edit-banner-option-cancel');
    accountEdit.bannerOptions = document.getElementById('account-edit-banner-options');
    accountEdit.bannerDefault = accountEdit.bannerContainer.innerHTML;
    accountEdit.bannerSelected = '';
    accountEdit.photoContainer = document.getElementById('account-edit-photo-container');
    accountEdit.photoOptionsUpload = document.getElementById('account-edit-photo-option-upload');
    accountEdit.photoOptionsCancel = document.getElementById('account-edit-photo-option-cancel');
    accountEdit.photoOptions = document.getElementById('account-edit-photo-options');
    accountEdit.photoDefault = accountEdit.photoContainer.innerHTML;
    accountEdit.photoSelected = '';

    accountEdit.bannerOptionsUpload.addEventListener('click', () => {
        accountEdit.inputBanner.click();
    });

    accountEdit.photoOptionsUpload.addEventListener('click', () => {
        accountEdit.inputPhoto.click();
    });

    accountEdit.selectBanner = function (event) {
        var extSuport = /(.jpeg|.jpg|.png|.gif|.JPEG|.JPG|.PNG|.PNG)$/i,
            banner = accountEdit.inputBanner;
        if (extSuport.exec(banner.value)) {
            accountEdit.bannerSelected = banner.files[0];
            accountEdit.setNewImgVisor(banner.files[0], accountEdit.bannerContainer, 'banner');
            accountEdit.bannerOptions.classList.add("selected");
        } else {
            alert();
        }
    }

    accountEdit.selectPhoto = function (event) {
        var extSuport = /(.jpeg|.jpg|.png|.gif|.JPEG|.JPG|.PNG|.PNG)$/i,
            photo = accountEdit.inputPhoto;
        if (extSuport.exec(photo.value)) {
            accountEdit.photoSelected = photo.files[0];
            accountEdit.setNewImgVisor(photo.files[0], accountEdit.photoContainer, 'photo');
            accountEdit.photoOptions.classList.add("selected");
        } else {
            alert();
        }
    }

    accountEdit.inputBanner.addEventListener('change', accountEdit.selectBanner);
    accountEdit.inputPhoto.addEventListener('change', accountEdit.selectPhoto);

    accountEdit.bannerOptionsCancel.addEventListener('click', () => {
        accountEdit.bannerSelected = '';
        accountEdit.bannerContainer.innerHTML = accountEdit.bannerDefault;
        accountEdit.bannerOptions.classList.remove("selected");
    });

    accountEdit.photoOptionsCancel.addEventListener('click', () => {
        accountEdit.photoSelected = '';
        accountEdit.photoContainer.innerHTML = accountEdit.photoDefault;
        accountEdit.photoOptions.classList.remove("selected");
    });

    // accountEdit.bannerOptionsSave.addEventListener('click', () => {


    // });

    accountEdit.form.addEventListener('submit', (event) => {
        event.preventDefault();
        var data = new FormData();
        if (accountEdit.bannerSelected !== '') {
            data.append('banner', accountEdit.bannerSelected);
        }
        if (accountEdit.photoSelected !== '') {
            data.append('photo', accountEdit.photoSelected);
        }
        data.append('name', accountEdit.inputName.value);
        data.append('username', accountEdit.inputUsername.value);
        data.append('email', accountEdit.inputEmail.value);
        data.append('bio', accountEdit.inputBio.value);
        data.append('location', accountEdit.inputLocation.value);
        data.append('link', accountEdit.inputLink.value);
        app.ajaxPetition(accountEdit.form.action, accountEdit.form.method, data, function (data) {
            if (data.state == 1) {
                window.location.assign(data.redirect);
            } else {
                document.getElementById('error-warn-text').innerHTML = data.response;
            }
        }, 1);
    });

    accountEdit.setNewImgVisor = function (image, container, specialClass) {
        var visor = new FileReader();
        visor.onload = function (e) {
            container.innerHTML = '<img src="' + e.target.result + '" class="' + specialClass + '" />';
        }
        visor.readAsDataURL(image);
    }

});