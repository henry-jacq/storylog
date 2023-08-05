let btnRmFeatImg = document.querySelector('.btn-remove-image');
let previewImg = document.getElementById('imagePreview');
let inputFile = document.getElementById('blogFeaturedImage');

// Image preview
inputFile.addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (file != undefined) {
        const reader = new FileReader();
        reader.onload = function (e) {
            previewImg.src = e.target.result;
            if (btnRmFeatImg.classList.contains('d-none')) {
                btnRmFeatImg.classList.remove('d-none');
            }
        };
        reader.readAsDataURL(file);
    } else {
        previewImg.src = '';
    }
});

// Remove image from the input and the preview image
btnRmFeatImg.addEventListener('click', function (e) {
    e.preventDefault();
    inputFile.value = null;
    previewImg.src = '';
    this.classList.add('d-none');
});