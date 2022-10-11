import { getIdGestion } from "../services/getIdGestion.js";
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

let users = [];

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
  
console.log(getGET().id)
getIdGestion(getGET().id).then((data) => {
    users = data.map((user) => {

      const card = userCardTemplate.content.cloneNode(true).children[0];
      const header = card.querySelector("[data-header]");
      const body = card.querySelector("[data-body]");
      const img = card.querySelector("[data-img]");
      const carrers = card.querySelector("[data-carrera]");
      const gestion = card.querySelector("[data-gestion]")
      switch (parseInt(user.id_carrera)) {
        case 1:
          img.src = `../img/portadas/portada-mei.webp`;
          break;
        case 2:
          img.src = `../img/portadas/portada-maz.webp`;
          break;
        case 3:
          img.src = `../img/portadas/portada-ina.webp`;
          break;
        case 4:
          img.src = `../img/portadas/portada-sif.webp`;
          break;
        case 5:
          img.src = `../img/portadas/portada-gtr.webp`;
          break;
        case 6:
          img.src = `../img/portadas/portada-elect.webp`;
          break;
        case 7:
          img.src = `../img/portadas/portada-maz-corpa.webp`;
          break;
        case 8:
          img.src = `../img/portadas/portada-agr.webp`;
          break;
        default:
          console.log("hola" + id_carr);
          break;
      }
  
      header.textContent = user.titulo;
      body.textContent = user.nombre_autor;
      carrers.textContent = user.nombre_carrera;
      gestion.textContent = user.gestion
      header.setAttribute("href", `../pages/perfil.html?id=${user.id_trabajos}`);
      userCardContainer.append(card);
      return { titulo: user.titulo, nombre_autor: user.nombre_autor, carrers: user.nombre_carrera,gestion: user.gestion, element: card };
      })
});
