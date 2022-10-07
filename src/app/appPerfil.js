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
getIdProyect(getGET().id).then((data) => {
  
  data.map((user) => {

    const card = userCardTemplate.content.cloneNode(true).children[0];
    const header = card.querySelector("[data-header]");
    const body = card.querySelector("[data-body]");
    console.log(card)
    header.textContent = user.titulo;
    body.textContent = user.resumen;
    header.setAttribute("href", `./src/pages/perfil.html?id=${user.id_trabajos}`);
    userCardContainer.append(card);
    return { titulo: user.titulo, resumen: user.resumen, element: card };
  })
    
});
