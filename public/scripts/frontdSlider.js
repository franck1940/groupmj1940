$(function () {
    let slideIndex = 0;
    let timesOut = 5000;
    let isDotClicked = false;
    showSlides();

    $("#dot1").click({ param: 1 }, currentSlide);
    $("#dot2").click({ param: 2 }, currentSlide);
    $("#dot3").click({ param: 3 }, currentSlide);
    $("#dot4").click({ param: 4 }, currentSlide);
    $("#dot5").click({ param: 5 }, currentSlide);
    $("#dot6").click({ param: 6 }, currentSlide);
    $("#dot7").click({ param: 7 }, currentSlide);
    $("#dot8").click({ param: 8 }, currentSlide);
    $("#dot9").click({ param: 9 }, currentSlide);
    $("#dot10").click({ param: 10 }, currentSlide);
    $("#dot10").click({ param: 11 }, currentSlide);
    $("#dot10").click({ param: 12 }, currentSlide);
    $("#dot10").click({ param: 13 }, currentSlide);
    $("#dot10").click({ param: 14 }, currentSlide);
    $("#dot10").click({ param: 15 }, currentSlide);
    $("#dot10").click({ param: 16 }, currentSlide);
    $("#dot10").click({ param: 17 }, currentSlide);
    $("#dot10").click({ param: 18 }, currentSlide);


    function showSlides() {
        let i;
        let slides = document.getElementsByClassName("mySlides");
        let dots = document.getElementsByClassName("dot");
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        if (slideIndex == 0 && !isDotClicked)
            slideIndex++;

        if (slideIndex > slides.length) { slideIndex = 1 }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
        if (!isDotClicked) {
            slideIndex++;
            setTimeout(showSlides, timesOut); // Change image every 2 seconds
        }

        if (isDotClicked) {
            isDotClicked = false;
        }
    }

    function currentSlide(event) {
        let value = event.data.param;
        slideIndex = value;
        timesOut = 10000;
        isDotClicked = true;
        showSlides();
    }
})