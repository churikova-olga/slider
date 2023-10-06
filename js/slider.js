let index = 1;
showSlides(index);

function plusSlides(n) {
  showSlides((index += n));
}

function currentSlide(n) {
  showSlides((index = n));
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");

  let dots = document.getElementsByClassName("dot");

  if (n > slides.length) {
    index = 1;
  }
  if (n < 1) {
    index = slides.length;
  }
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].classList.remove("active");
  }
  slides[index - 1].style.display = "flex";
  dots[index - 1].classList.add("active");
}
