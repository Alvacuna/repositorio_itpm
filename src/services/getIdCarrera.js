export const getIdCarrera = (id) => {
    return fetch(`/prototipo_2/src/php/carreras.php?id=${id}`)
    .then((response) => response.json())
      .then((data) => data);
}