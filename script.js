window.addEventListener("DOMContentLoaded", function () {

    let imgs = document.querySelectorAll(".album-container .img-box")
    // console.log(imgs)

    imgs.forEach(function (img) {
        img.style.transform = "scale(1)";
    });


    window.addEventListener("scroll", function () {
        const form = document.querySelector("form");
        const fixedHeading = document.querySelector(".fixed-heading");
        const scrollThreshold = 80;

        if (window.scrollY > scrollThreshold) {
            form.classList.add("form-fixed");
            fixedHeading.classList.remove("hide-heading");
        } else {
            form.classList.remove("form-fixed");
            fixedHeading.classList.add("hide-heading");
        }
    });


})
