window.addEventListener("DOMContentLoaded", function () {

    let imgs = document.querySelectorAll(".album-container .img-box")
    // console.log(imgs)

    imgs.forEach(function (img) {
        img.style.transform = "scale(1)";
    });

})
