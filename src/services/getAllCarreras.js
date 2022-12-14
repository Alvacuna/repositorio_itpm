export const getAllCarreras = () => {
    return fetch("/proyecto/src/php/carreras.php")
    .then((response) => response.json())
    .then((data) => data);
}