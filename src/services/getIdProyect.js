export const getIdProyect = (id) => {
    return fetch(`/prototipo_2/src/php/config.php?id=${id}`)
      .then((response) => response.json())
      .then((data) => data);
  };
  
