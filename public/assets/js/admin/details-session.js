import * as helpers from '/assets/js/functions.js';
document.querySelectorAll("#NewFormForStudent .tr-body").forEach(tr => {
    tr.addEventListener("click", e => {
        window.location.href = "/etudiants/" + 
                                tr.querySelector("td:nth-child(1)").innerText + "-" + 
                                tr.querySelector("td:nth-child(2)").innerText + "-" +
                                tr.dataset.id + "/" +
                                "creer-fiche";
    });
});
helpers.removeDivFeedback(".alert");

document.querySelectorAll(".btn-close-session").forEach(form => {
    form.addEventListener("click", e => {
        e.stopPropagation();
        if(!window.confirm("Voulez vous fermer cette session ?"))
            e.preventDefault();
    });
});

document.querySelectorAll(".btn-delete-session").forEach(form => {
    form.addEventListener("click", e => {
        e.stopPropagation();
        if(!window.confirm("Voulez vous suprrimer cette session ?"))
            e.preventDefault();
    });
});

