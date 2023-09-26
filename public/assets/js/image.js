
/* AJAX (Asynchronous JavaScript and XML) pour effectuer des requêtes asynchrones vers le serveur.
Plus précisément, il utilise la fonction fetch pour envoyer une requête HTTP de type DELETE vers l'URL
spécifiée dans le lien sur lequel l'utilisateur a cliqué.*/

//recuperer le lien avec un attribut
let links = document.querySelectorAll("[data-delete]");

// On boucle sur les liens
for(let link of links){
    // On met un écouteur d'évènements sur le data-delete
    link.addEventListener("click", function(e){
        // On empêche la navigation de nous rediriger en bloquant son comportement par default
        e.preventDefault();

        // On demande confirmation de l'utilisateur par une popup ~ alert()
        if(confirm("Voulez-vous supprimer cette image ?")){
            // On envoie la requête Ajax à l'url spécifiée dans le lien
            /*La requête est configurée pour être une requête de type DELETE avec les en-têtes appropriés,
            y compris l'en-tête "X-Requested-With" indiquant une requête AJAX et
            le type de contenu "application/json".*/
            fetch(this.getAttribute("href"), {
                method: "DELETE",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "Content-Type": "application/json"
                },
                /*Le corps de la requête contient un jeton (token) provenant
                des données de l'élément cliqué, qui est converti en JSON.*/
                body: JSON.stringify({"_token": this.dataset.token})
            }).then(response => response.json())
                /*Une fois que la réponse du serveur est reçue, elle est analysée en tant que JSON avec response.json().
                 En fonction de la réponse, si data.success est vrai, l'élément parent du lien est supprimé de la page
                (ce qui semble être la suppression d'une image). Sinon, une alerte est affichée et un message est
                enregistré dans la console.*/
                .then(data => {
                    if(data.success){
                        //je cible l'image, puis sa div parente, et je la remove
                        this.parentElement.remove();
                    }else{
                        alert(data.error);
                        console.log('erreur ici')
                    }
                })
        }
    });
}