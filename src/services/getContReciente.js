export const getContReciente = () => {
    return fetch("/proyecto/src/php/contReciente.php")
    .then((response) => response.json())
    .then((data) => data);
}

