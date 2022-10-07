import { getAllCarreras } from "../services/getAllCarreras.js";

const searchFormAll = document.querySelector('[search-form-all]')

searchFormAll.addEventListener('submit', (e) => {
    
  console.log(e.target.searchAll.value)
})
const userCajaTemplate = document.querySelector("[caja-carreras-template]");
const userCajaContainer = document.querySelector("[caja-carreras]");
let users=[]
getAllCarreras().then((data) => {
  users = data.map((user) => {
      const caja = userCajaTemplate.content.cloneNode(true).children[0];
    const cajaLink = caja.querySelector("[caja]");
    cajaLink.textContent = user.nombre_carrera
    console.log(cajaLink)
    cajaLink.setAttribute("href" , `../prototipo_2/src/pages/searchCarreras.html?id=${user.id_carrera}`)
    userCajaContainer.append(caja);
    return {nombre_carrera: user.nombre_carrera, element: caja}
  });
});
