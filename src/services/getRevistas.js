export const getRevistas = (id) => {
    return fetch(`/proyecto/src/php/othersRecursos.php?id=${id}`).then((response) => response.json())
    .then((data) => data);
}