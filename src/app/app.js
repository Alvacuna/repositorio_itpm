import { getAllProyects } from "../services/getAllProyects.js";

const userCardTemplate = document.querySelector("[data-user-template]");
const userCardContainer = document.querySelector("[data-user-cards-container]");
const searchInput = document.querySelector("[data-search]");
const searchFomr = document.querySelector("[search-form]");
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
console.log(getGET().searchAll.length)

searchInput.value = getGET().searchAll;

setTimeout(() => {
  if(getGET().searchAll.length != 0){
    console.log(getGET().searchAll)
    document.getElementById("active").click()
  } else {
    console.log("no hay nada")
  }  
}, 200)

console.log(getGET().searchAll.length)

console.log(searchInput.value);
// const removeAccents = (str) => {
//   return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
// } 
searchFomr.addEventListener("submit", (e) => {
  e.preventDefault();
  const value = e.target.search.value;
  console.log(value);
  users.forEach((user) => {
    const IsVisible =
      user.titulo.toLowerCase().includes(value.toLowerCase()) ||
      user.nombre_autor.toLowerCase().includes(value.toLowerCase());
    user.element.classList.toggle("hide", !IsVisible);
  });
});


// const getAllProyects = () => {
//   return fetch("php/config.php")
//     .then((response) => response.json())
//     .then((data) => data);
// };

getAllProyects().then((data) => {
  users = data.map((user) => {
    const card = userCardTemplate.content.cloneNode(true).children[0];
    const header = card.querySelector("[data-header]");
    const body = card.querySelector("[data-body]");
    const img = card.querySelector("[data-img]");
    const carrers = card.querySelector("[data-carrera]");
    const gestion = card.querySelector("[data-gestion]")
    switch (parseInt(user.id_carrera)) {
      case 1:
        img.src = `../img/portadas/portada_${user.id_carrera}.jpg`;
        break;
      case 2:
        img.src = `../img/portadas/portada_${user.id_carrera}.jpg`;
        break;
      case 3:
        img.src = `../img/portadas/portada_${user.id_carrera}.jpg`;
        break;
      case 4:
        img.src = `../img/portadas/portada_${user.id_carrera}.jpg`;
        break;
      case 5:
        img.src = `../img/portadas/portada_${user.id_carrera}.jpg`;
        break;
      case 6:
        img.src = `../img/portadas/portada_${user.id_carrera}.jpg`;
        break;
      case 7:
        img.src = `../img/portadas/portada_${user.id_carrera}.jpg`;
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
  });
});

// fetch("php/config.php")
//   .then((response) => response.json())
//   .then((data) => {
//     users = data.map((user) => {
//       console.log(user);
//       const card = userCardTemplate.content.cloneNode(true).children[0];
//       const header = card.querySelector("[data-header]");
//       const body = card.querySelector("[data-body]");
//       header.textContent = user.title;
//       body.textContent = user.resumen;
//       header.setAttribute("href", "https://www.w3schools.com");
//       userCardContainer.append(card);
//       return { title: user.title, resumen: user.resumen, element: card };
//     });
//   });

console.log(document.location.href);
