export const getAllProyects = () => {
  return fetch("/proyecto/src/php/config.php")
    .then((response) => response.json())
    .then((data) => data);
};

