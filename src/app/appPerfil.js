import { getIdProyect } from "../services/getIdProyect.js";

const userCardTemplate = document.querySelector("[data-user-template]");
const userCardContainer = document.querySelector("[data-user-cards-container]");



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

console.log(getGET().id);
const carrera = document.querySelector("[carrera]")
const nombreAutor = document.querySelector("[nombreAutor]")
const tutor = document.querySelector("[tutor]")
const gestion = document.querySelector("[gesion]")
const modalidad = document.querySelector("[modalidad]")
const img = document.querySelector("[portada]")
const titleProyect = document.querySelector("[title-proyecto]")
const linkDrive = document.querySelector("[linkDrive]")
getIdProyect(getGET().id).then((data) => {
  
  data.map((user) => {
  
    const card = userCardTemplate.content.cloneNode(true).children[0];
    const header = card.querySelector("[data-header]");
    const body = card.querySelector("[data-body]");
    img.src = `../img/portadas/portada-mei.webp`
    carrera.textContent= user.nombre_carrera
    console.log(user.link_pdf)
    titleProyect.textContent= user.titulo
    linkDrive.textContent=user.link_pdf
    linkDrive.setAttribute("href", user.link_pdf);
    nombreAutor.textContent = user.nombre_autor + " " + user.apellido_autor



    userCardContainer.append(card);
    return { titulo: user.titulo, resumen: user.resumen, element: card };
  })
    
});


