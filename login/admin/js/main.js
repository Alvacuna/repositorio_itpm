/* Validar documentos */
const archivos = document.querySelector('#archivos');
archivos.addEventListener('change', (e) => {
    for (let i = 0; i < archivos.files.length; i++) {
        if (archivos.files[i].type != "application/pdf") {
            alert('Seleccione un archivo PDF\nEl archivo '+(i+1)+' no es un PDF');
            archivos.value = '';
        }
    }
});
/* Select de Año dinámico */
const gestion = new Date().getFullYear();
for (let i = gestion; i >= 2020; i--) {
    document.querySelector('#gestion').insertAdjacentHTML("beforeend", `<option value="${i}-II">${i} - II</option>`);
    document.querySelector('#gestion').insertAdjacentHTML("beforeend", `<option value="${i}-I">${i} - I</option>`);
}
/* Inputs dinámicos para autor */
const autores = document.querySelector('#autores');
const agregarAutores = document.querySelector('#agregarautor');
let total = 1;
agregarAutores.addEventListener('click', () => {
    const autor = document.querySelector('#autor').cloneNode(true);
    autor.childNodes[1].childNodes[1].value='';
    autor.childNodes[3].childNodes[1].value='';
    autor.insertAdjacentHTML("beforeend", `<button type="button" onclick="eliminar(this)" class="eliminar">Eliminar Campos</button>`);
    autores.insertAdjacentElement("beforeend", autor);
});
/* Inputs dinámicos para tutor */
const tutores = document.querySelector('#tutores');
const agregarTutores = document.querySelector('#agregartutor');
agregarTutores.addEventListener('click', () => {
    const tutor = document.querySelector('#tutor').cloneNode(true);
    tutor.insertAdjacentHTML("beforeend", `<button type="button" onclick="eliminar(this)" class="eliminar">Eliminar Campo</button>`);
    tutores.insertAdjacentElement("beforeend", tutor);
})
/* Eliminar */
const eliminar = (e) => {
    e.parentNode.remove();
};
/* Barra de Progreso */
const form = document.querySelector('#form');
form.addEventListener('submit', (e) => {
    const files = document.querySelector('#archivos').files[0];
    const progress = document.querySelector('#progress');
    let formdata = new FormData();
    formdata.append("inputFile", files);
    let ax = new XMLHttpRequest();
    ax.upload.addEventListener("progress",(e) => {
        let porcentaje = (e.loaded * 100) / e.total;
        progress.value = Math.round(porcentaje);
    });
    ax.open("POST", "prueba.php");
    ax.send(formdata);
});