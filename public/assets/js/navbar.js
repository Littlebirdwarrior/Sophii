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
