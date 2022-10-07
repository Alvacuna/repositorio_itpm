export const getAllProyects = () => {
  return fetch("/prototipo_2/src/php/config.php")
    .then((response) => response.json())
    .then((data) => data);
};

