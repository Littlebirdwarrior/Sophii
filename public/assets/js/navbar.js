/*
* Deployer ou collapse la sidebar
*
* */

// Ajoutez un gestionnaire d'événements au bouton
const navCollapse = () => {
    const maNav = document.getElementById("sidebar");
    maNav.classList.toggle("deployed");
    maNav.classList.toggle("collapse");
}


/*
* En responsive, la sidebar est sur le coté
*
* */

const navShow = () => {
    const maNav = document.getElementById("sidebar");
    maNav.classList.toggle("nav-none");
    maNav.classList.toggle("nav-show");
}

const navNone = () => {
    const maNav = document.getElementById("sidebar");
    maNav.classList.toggle("nav-show");
    maNav.classList.toggle("nav-none");
}