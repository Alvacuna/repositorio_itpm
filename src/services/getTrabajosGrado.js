export const getTrabajosGrado = () => {
  return fetch("/proyecto/src/php/recursos.php")
    .then((response) => response.json())
    .then((data) => data);
};

