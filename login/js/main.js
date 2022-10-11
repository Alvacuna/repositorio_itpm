/* Validar documentos */
/* function val() {
    if (document.formu.archivos.files[0].type != "application/pdf") {
        alert('Seleccione un archivo PDF');
        document.formu.archivos.value = '';
    }
} */
function val() {
    var archivos = document.formu.archivos;
    for (let i = 0; i < archivos.files.length; i++) {
        if (archivos.files[i].type != "application/pdf") {
            alert('Seleccione un archivo PDF');
            archivos.value = '';
        }
    }
}
/* Select de Año dinámico */
const gestion = new Date().getFullYear();
for (let i = gestion; i >= 1998; i--) {
    document.querySelector('#gestion').insertAdjacentHTML("beforeend", `<option value="${i} - II">${i} - II</option>`);
    document.querySelector('#gestion').insertAdjacentHTML("beforeend", `<option value="${i} - I">${i} - I</option>`);
}
/* Inputs dinámicos para autor */
const contenedor = document.querySelector('#dinamic');
const btnAgregar = document.querySelector('#agregar');
let total = 1;
btnAgregar.addEventListener('click', () => {
    contenedor.insertAdjacentHTML("beforeend", `<div><input type="text" name="nombre[]" placeholder="Autor ${total} Nombre" required><input type="text" name="apellido[]" placeholder="Autor ${total++} Apellido" required><button onclick="eliminar(this)">Eliminar</button></div>`);
});
const eliminar = (e) => {
    e.parentNode.remove();
    actualizarContador();
};
const actualizarContador = () => {
    let divs = contenedor.children;
    total = 1;
    for (let i = 0; i < divs.length; i++) {
        divs[i].children[0].placeholder = `Autor ${total} Nombre`;
        divs[i].children[1].placeholder = `Autor ${total++} Apellido`;
    }
};