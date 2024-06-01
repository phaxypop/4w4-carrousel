(function () {
  console.log("Vive Javascrip");
  let carrousel = document.querySelector(".carrousel");
  console.log("conteneur carrousel = " + carrousel.tagName);
  let bouton = document.querySelector(".bouton__ouvrir");
  console.log("bouton = " + bouton.tagName);
  let carrousel__x = document.querySelector(".carrousel__x");
  console.log("carrousel__x" + carrousel__x.tagName);
  let galerie = document.querySelector(".galerie");
  console.log("galerie = " + galerie.tagName);

  let carrousel__figure = document.querySelector(".carrousel__figure");

  /* récupère la première image de la galerie */
  // let galerie__img = galerie.querySelector('img')
  /* pour créer une collection d'images de la galerie */
  let galerie__img = galerie.querySelectorAll("img");
  console.log(galerie__img);
  let index = 0;
  for (const elm of galerie__img) {
    creer_image_carrousel(index, elm);
    creer_radio_carrousel(index);
    index = index + 1;
  }

  /**
   * Créer l'image du carrousel à partir de la galerie
   * @param {*} index  le numéro de l'image
   * @param  elm l'élément image de la galerie
   */
  function creer_image_carrousel(index, elm) {
    console.log(elm.src);
    /* Création dynamique d'une image du carrousel */
    let carrousel__img = document.createElement("img");
    carrousel__img.src = elm.src;
    carrousel__img.classList.add("carrousel__img");
    carrousel__img.dataset.index = index;
    carrousel__figure.appendChild(carrousel__img);
  }

  /**
   * Création d'un radio bouton du carrousel
   * @param {*} index  le numéro du radio
   */
  function creer_radio_carrousel(index) {
    let carrousel__radio = document.createElement("input");
    // class
    carrousel__radio.setAttribute("type", "radio");
    // index
    carrousel__radio.setAttribute("name", "carrousel__radio");
    // type
    carrousel__radio.setAttribute("class", "carrousel__radio");
    // data-index
    carrousel__radio.setAttribute("data-index", index);
    carrousel__radio.addEventListener("click", function () {
      let images = document.querySelectorAll(".carrousel__img");
      images.forEach(function (image) {
        image.style.opacity = "0";
      });
      let selectedIndex = parseInt(this.getAttribute("data-index"));
      images[selectedIndex].style.opacity = "1";
    });
    document.querySelector(".carrousel__form").appendChild(carrousel__radio);
  }

  /*
    console.log("première image de la galerie = " + galerie__img.src)
    carrousel__img.src = galerie__img.src
    console.log("première image du carrousel = " + carrousel__img.src)
    carrousel__figure.appendChild(carrousel__img)
    console.log(carrousel__figure)
  */

  /* écouteur pour ouvrir la boîte modale */
  bouton.addEventListener("mousedown", function () {
    carrousel.classList.add("carrousel--ouvrir"); // ouvrir le carrousel
  });
  /* Écouteur pour fermer la boîte modale */
  carrousel__x.addEventListener("mousedown", function () {
    carrousel.classList.remove("carrousel--ouvrir"); // fermer le carrousel
    console.log("fermer carrousel");
  });
})();
