export const getListGestion = () => {
    return fetch("/proyecto/src/php/anoProduccion.php")
    .then((response) => response.json())
    .then((data) => data);
}