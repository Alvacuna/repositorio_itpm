import { getRevistas } from "../services/getRevistas.js";
import { getAllProyects } from "../services/getAllProyects.js";
import { getListGestion } from "../services/getListGestion.js";
import { getContReciente } from "../services/getContReciente.js";
const userCardTemplate = document.querySelector("[data-user-template]");
const userCardContainer = document.querySelector("[data-user-cards-container]");
const searchInput = document.querySelector("[data-search]");
const searchFomr = document.querySelector("[search-form]");

const btnAll = document.querySelector("[all]");
const btnAutor = document.querySelector("[autor]");
const btnGestion = document.querySelector("[gestion]");
const btnTutor = document.querySelector("[tutor]");

let stateFilter = 1;

btnAll.addEventListener("click", (e) => {
  e.preventDefault();
  stateFilter = 1;
});
btnAutor.addEventListener("click", (e) => {
  e.preventDefault();
  stateFilter = 2;
});
btnGestion.addEventListener("click", (e) => {
  e.preventDefault();
  stateFilter = 3;
});
btnTutor.addEventListener("click", (e) => {
  e.preventDefault();
  stateFilter = 4;
});

const sig = document.querySelector(".siguiente");
const ant = document.querySelector(".anterior");
const count = document.querySelector(".count");

let users = [];

function getGET() {
  let loc = document.location.href;

  if (loc.indexOf("?") > 0) {
    let getString = loc.split("?")[1];

    let GET = getString.split("&");
    let get = {};

    for (let i = 0, l = GET.length; i < l; i++) {
      let tmp = GET[i].split("=");
      get[tmp[0]] = unescape(decodeURI(tmp[1]));
    }
    return get;
  }
}



searchFomr.addEventListener("submit", (e) => {
  e.preventDefault();
  const value = e.target.search.value;
  console.log(stateFilter);
  switch (stateFilter) {
    case 1:
      users.forEach((user) => {
        const IsVisible =
          user.titulo.toLowerCase().includes(value.toLowerCase()) ||
          user.nombre_autor.toLowerCase().includes(value.toLowerCase()) ||
          user.carrers.toLowerCase().includes(value.toLowerCase());
        user.element.classList.toggle("hide", !IsVisible);
      });
      break;
    case 2:
      users.forEach((user) => {
        const IsVisible = user.nombre_autor
          .toLowerCase()
          .includes(value.toLowerCase());
          
        user.element.classList.toggle("hide", !IsVisible);
      });
      break;
    case 3:
      users.forEach((user) => {
        const IsVisible =
          user.gestion.toLowerCase().includes(value.toLowerCase())
        user.element.classList.toggle("hide", !IsVisible);
      });
      break;
    case 4:
      users.forEach((user) => {
        const IsVisible =
          user.titulo.toLowerCase().includes(value.toLowerCase())
        user.element.classList.toggle("hide", !IsVisible);
      }); 
     break;
  }
});
let contadoSup = 2;
let contadoInf = 0;
sig.addEventListener("click", (e) => {
  e.preventDefault();

});



getRevistas(getGET().id).then((data) => {


  users = data.map((user) => {
    const card = userCardTemplate.content.cloneNode(true).children[0];
    const header = card.querySelector("[data-header]");
    const body = card.querySelector("[data-body]");
    const img = card.querySelector("[data-img]");
    const carrers = card.querySelector("[data-carrera]");
    const gestion = card.querySelector("[data-gestion]");
    switch (parseInt(user.id_carrera)) {
      case 1:
        img.src = `../img/portadas/port-mei.webp`;
        break;
      case 2:
        img.src = `../img/portadas/port-maz.webp`;
        break;
      case 3:
        img.src = `../img/portadas/port-ina.webp`;
        break;
      case 4:
        img.src = `../img/portadas/port-sif.webp`;
        break;
      case 5:
        img.src = `../img/portadas/port-gtr.webp`;
        break;
      case 6:
        img.src = `../img/portadas/port-elect.webp`;
        break;
      case 7:
        img.src = `../img/portadas/port-maz-corp.webp`;
        break;
      case 8:
        img.src = `../img/portadas/port-agr.webp`;
        break;
      default:
        console.log("hola" + id_carr);
        break;
    }

    header.textContent = user.titulo;
    body.textContent = user.nombre_autor + " " + user.apellido_autor;
    carrers.textContent = user.nombre_carrera;
    gestion.textContent = user.gestion;
    header.setAttribute("href", `../pages/perfil.html?id=${user.id_trabajos}`);
    userCardContainer.append(card);
    return {
      titulo: user.titulo,
      nombre_autor: user.nombre_autor + " " + user.apellido_autor,
      carrers: user.nombre_carrera,
      gestion: user.gestion,
      element: card,
    };
  });
});


//año de produccion
let producciones = [];
const productTemplame = document.querySelector("[template-contenido-año]");
const productContainer = document.querySelector("[container-contenido-año]");
getListGestion().then((data) => {
  producciones = data.map((dat) => {
    const product = productTemplame.content.cloneNode(true).children[0];
    console.log(dat);
    const añoDeProduction = product.querySelector("[contenido-año]");
    const recursoProduction = product.querySelector("[contenido-recurso]");
    añoDeProduction.textContent = "Gestion: " + dat.gestion;
    recursoProduction.textContent = "Recursos: " + dat.cantidad;
    añoDeProduction.setAttribute(
      "href",
      `../pages/searchGestion.html?id=${dat.gestion}`
    );
    productContainer.append(product);
    return { gestion: dat.gestion, cantidad: dat.cantidad, element: product };
  });
});

// Contenidos Destacados
const descTemplate = document.querySelector("[template-cont-destacado]");
const descContainer = document.querySelector("[container-cont-destacado]");
getContReciente().then((data) => {
  console.log(data.length);
  data.slice(data.length - 5, data.length).map((dat) => {
    console.log(dat);
    const destacado = descTemplate.content.cloneNode(true).children[0];
    const titleDesc = destacado.querySelector("[destacado-title]");
    const autorDesc = destacado.querySelector("[destacado-autor]");
    titleDesc.setAttribute(
      "href",
      `../pages/perfil.html?id=${dat.id_trabajos}`
    );
    titleDesc.textContent = dat.titulo;
    autorDesc.textContent = dat.nombre_autor + " " + dat.apellido_autor;
    descContainer.append(destacado);
  });
});

