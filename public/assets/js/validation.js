

$(document).ready(function () {
    $('.submit-on-click').on('click', function () {
        console.log('passe-ici')
        var valeur = $(this).val();
        console.log(valeur, 'test');
        $.ajax({
            type: 'POST',
            url: $('.validation-button').attr('action'),
            data: {champRadio: valeur},
            success: function (response) {
                // Gérez la réponse du serveur ici si nécessaire
                console.log('Requête réussie');

                //window.location.href = "{{ path('valider_feuille_route') }}";
            },
            error: function () {
                // Gérez les erreurs ici si nécessaire
                console.error('Erreur lors de la requête');
            }
        });
    });
});





