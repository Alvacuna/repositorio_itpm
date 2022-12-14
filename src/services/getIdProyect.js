export const getIdProyect = (id) => {
    return fetch(`/proyecto/src/php/config.php?id=${id}`)
      .then((response) => response.json())
      .then((data) => data);
  };
  
