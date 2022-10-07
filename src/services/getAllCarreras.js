export const getAllCarreras = () => {
    return fetch("/prototipo_2/src/php/carreras.php")
    .then((response) => response.json())
    .then((data) => data);
}