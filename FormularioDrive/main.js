function val() {
    var arc = document.formu.archivos;
    if(arc.files[0].type != "application/pdf"){
        alert('Seleccione un archivo PDF');
        arc.value='';
    }
}
/* const contenedor = document.querySelector('#dinamic');
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
}; */