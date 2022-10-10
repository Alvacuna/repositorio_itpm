export const getIdGestion = (id) => {
    return fetch(`/proyecto/src/php/anoProduccion.php?id=${id}`)
    .then((response) => response.json())
    .then((data) => data);
}
