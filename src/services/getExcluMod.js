export const getExcluMod = (id) => {
    return fetch(`/proyecto/src/php/recursos.php?id=${id}`)
    .then((response) => response.json())
    .then((data) => data);
}
