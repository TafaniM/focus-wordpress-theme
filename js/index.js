// var $8973aab45c5aa6ba$exports = {};

// document.addEventListener('DOMContentLoaded', function() {
//     const images = document.querySelectorAll('.gallery img');
//     const overlay = document.getElementById('overlay2');
//     const overlayImage = document.getElementById('overlay2-image');
//     const overlayCaption = document.getElementById('overlay2-caption');
//     images.forEach(function(image) {
//         image.addEventListener('click', function() {
//             overlayImage.src = this.src;
//             overlayCaption.textContent = this.alt;
//             overlay.style.display = 'block';
//             document.body.classList.add('overlay-open');
//         });
//     });
//     overlay.addEventListener('click', function() {
//         overlay.style.display = 'none';
//         document.body.classList.remove('overlay-open');
//     });
// });
document.addEventListener("DOMContentLoaded", function () {
  const menuIcon = document.querySelector(".menu-icon");
  if (menuIcon) {
    menuIcon.addEventListener("click", function () {
      var menu = document.querySelector(".menu-content");
      if (menu.style.display === "none") menu.style.display = "block";
      else menu.style.display = "none";
    });
  }

  const images = document.querySelectorAll(".gallery img");
  const overlay = document.getElementById("overlay2");
  const overlayImage = document.getElementById("overlay2-image");
  const overlayCaption = document.getElementById("overlay2-caption");
  const prevButton = document.getElementById("prevButton");
  const nextButton = document.getElementById("nextButton");
  let currentIndex = 0;
  function showImage(index) {
    const image = images[index];
    overlayImage.src = image.src;
    overlayCaption.textContent = image.alt;
  }
  images.forEach(function (image, index) {
    image.addEventListener("click", function () {
      currentIndex = index;
      showImage(currentIndex);
      overlay.style.display = "block";
      document.body.classList.add("overlay-open");
    });
  });
  overlay.addEventListener("click", function (e) {
    if (
      e.target === overlay ||
      e.target === prevButton ||
      e.target === nextButton
    )
      return;
    overlay.style.display = "none";
    document.body.classList.remove("overlay-open");
  });
  prevButton.addEventListener("click", function () {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    showImage(currentIndex);
  });
  nextButton.addEventListener("click", function () {
    currentIndex = (currentIndex + 1) % images.length;
    showImage(currentIndex);
  });
});

//# sourceMappingURL=index.js.map
