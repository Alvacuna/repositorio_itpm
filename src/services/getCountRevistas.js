export const getCountRevistas = () => {
    return fetch("/proyecto/src/php/othersRecursos.php").then((response) => response.json())
    .then((data) => data);
}