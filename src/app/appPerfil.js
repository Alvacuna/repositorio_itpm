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
const tutor = document.querySelector("[nombreTutor]")
const gestion = document.querySelector("[gestion]")
const modalidad = document.querySelector("[modalidad]")
const img = document.querySelector("[portada]")
const titleProyect = document.querySelector("[title-proyecto]")
const linkDrive = document.querySelector("[linkDrive]")
const resumen = document.querySelector("[resumenProyecto]")
getIdProyect(getGET().id).then((data) => {
  
  data.map((user) => {
    console.log(user)
    const card = userCardTemplate.content.cloneNode(true).children[0];
    const header = card.querySelector("[data-header]");
    const body = card.querySelector("[data-body]");
    switch (parseInt(user.id_carrera)) {
      case 1:
        img.src = `../img/portadas/port-sif.webp`;
        break;
      case 2:
        img.src = `../img/portadas/port-mei.webp`;
        break;
      case 3:
        img.src = `../img/portadas/port-maz.webp`;
        break;
      case 4:
        img.src = `../img/portadas/port-ina.webp`;
        break;
      case 5:
        img.src = `../img/portadas/port-elect.webp`;
        break;
      case 6:
        img.src = `../img/portadas/port-gtr.webp`;
        break;
      case 7:
        img.src = `../img/portadas/port-agr.webp`;
        break;
      case 8:
        img.src = `../img/portadas/port-maz-corp.webp`;
        break;
      default:
        console.log("hola" + id_carr);
        break;
    }
    carrera.textContent= user.nombre_carrera
    console.log(user.link_pdf)
    titleProyect.textContent= user.titulo
    linkDrive.textContent=user.link_pdf
    linkDrive.setAttribute("href", user.link_pdf);
    nombreAutor.textContent = user.nombreConcat
    tutor.textContent = user.nombre_tutor
    gestion.textContent = user.gestion
    resumen.textContent = user.resumen
    console.log(user.gestion)
    userCardContainer.append(card);
    return { titulo: user.titulo, resumen: user.resumen, element: card };
  })
    
});


