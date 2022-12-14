export const getIdCarrera = (id) => {
    return fetch(`/proyecto/src/php/carreras.php?id=${id}`)
    .then((response) => response.json())
      .then((data) => data);
}