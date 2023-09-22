let links = document.querySelectorAll("[data-delete]");

// On boucle sur les liens
for(let link of links){
    // On met un écouteur d'évènements
    link.addEventListener("click", function(e){
        // On empêche la navigation de nous rediriger
        e.preventDefault();

        // On demande confirmation de l'utilisateur
        if(confirm("Voulez-vous supprimer cette image ?")){
            // On envoie la requête ajax
            fetch(this.getAttribute("href"), {
                method: "DELETE",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({"_token": this.dataset.token})
            }).then(response => response.json())
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