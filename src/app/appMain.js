import { getAllCarreras } from "../services/getAllCarreras.js";
import { getTrabajosGrado } from "../services/getTrabajosGrado.js";
import { getCountRevistas } from "../services/getCountRevistas.js";
import { getListGestion } from "../services/getListGestion.js";

import { getContReciente } from "../services/getContReciente.js";
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
    cajaLink.setAttribute("href" , `../proyecto/src/pages/searchCarreras.html?id=${user.id_carrera}`)
    userCajaContainer.append(caja);
    return {nombre_carrera: user.nombre_carrera, element: caja}
  });
});



//Contendor de caja de trabajos de grado
const countTrabajoDeGrado = document.querySelector("[contador]")
const linkTrabajoDeGrado = document.querySelector("[caja-modalidad]")

getTrabajosGrado().then((data) =>  {
  data.map((data)=> {
    countTrabajoDeGrado.textContent= data.cantidad
    linkTrabajoDeGrado.setAttribute("href", `../proyecto/src/pages/searchModalidad.html?id=5`)
  })
})

//Contendor de caja de revistas

const countRevistas = document.querySelector("[contador-resvistas]")
const linkRevistas = document.querySelector("[caja-mod-revistas]")
getCountRevistas().then((data) => {
  data.map((dat) => {
    countRevistas.textContent = dat.cantidad
    linkRevistas.setAttribute("href", `../proyecto/src/pages/searchRevistas.html?id=5`)
  })
})


//año de produccion
let producciones = []
const productTemplame = document.querySelector("[template-contenido-año]")
const productContainer = document.querySelector("[container-contenido-año]")
getListGestion().then((data) => {
  producciones = data.map((dat) => {
    const product = productTemplame.content.cloneNode(true).children[0];
    console.log(product)
    const añoDeProduction = product.querySelector("[contenido-año]")
    const recursoProduction = product.querySelector("[contenido-recurso]")
    añoDeProduction.textContent = "Gestion: "+dat.gestion
    recursoProduction.textContent = "Recursos: "+dat.cantidad
    añoDeProduction.setAttribute("href", `../proyecto/src/pages/searchGestion.html?id=${dat.gestion}`)
    productContainer.append(product)
    return {gestion: dat.gestion, cantidad:dat.cantidad, element: product}
  })
})





// Contenidos Destacados
const descTemplate = document.querySelector("[template-cont-destacado]")
const descContainer = document.querySelector("[container-cont-destacado]")
getContReciente().then((data) => {
  data.map((dat) => {
    const destacado = descTemplate.content.cloneNode(true).children[0]
    const titleDesc = destacado.querySelector("[destacado-title]")
    const autorDesc = destacado.querySelector("[destacado-autor]")
    titleDesc.setAttribute("href", `../proyecto/src/pages/perfil.html?id=${dat.id_trabajos}`);
    titleDesc.textContent= dat.titulo
    autorDesc.textContent = dat.nombre_autor + " " + dat.apellido_autor
    descContainer.append(destacado)
  })

})


