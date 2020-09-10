
if (pathName == '/projet/admin.php' || pathName == '/projet/sous-admin.php') {
    
    var showMoreUtilisateurs = document.querySelector('#show-more-utilisateurs');
    var hideMoreUtilisateurs = document.querySelector('.hide-more-utilisateurs');
    let click = 0;
    showMoreUtilisateurs.addEventListener('click', () =>{
        click++;
        if (click%2 == 1) {
            hideMoreUtilisateurs.className = "show-more-utilisateurs";
        }else{
            hideMoreUtilisateurs.className = "hide-more-utilisateurs";
        }
    });

    var adminShowOptions = document.querySelectorAll('.admin-tab-bord li');
    var adminOptions = document.querySelectorAll('.admin-options-aff');

    var urlName = window.location.search;
    var adminOptionsUrl = urlName.substr(urlName.lastIndexOf('?') + 1);
    var adminShowOptionsUrl = adminOptionsUrl+'-options';
    
    for (let i = 0; i < adminShowOptions.length; i++) {
        if (adminShowOptions[i].id == 'show-more-utilisateurs') {
            hideMoreUtilisateurs.className = "show-more-utilisateurs";
        }
        if (adminShowOptions[i].id == adminOptionsUrl) {
            desactiveLiOptions();
            adminShowOptions[i].classList.add('active-li-options');
        }
    }

    for (let j = 0; j < adminOptions.length; j++) {
        if (adminOptions[j].id == adminShowOptionsUrl) {
            desactiveDivOptions();
            adminOptions[j].style.display = 'block';
        }
    }

    function desactiveLiOptions(){
        adminShowOptions.forEach(li => {
            li.classList.remove('active-li-options');
        });
    }
    function desactiveDivOptions(){
        adminOptions.forEach(div => {
            div.classList.remove('active-div-options');
        });
    }

    var sousAdminGestionButtons = document.querySelectorAll('.sous-admin-gestion-button');
    var sousAdminGestionOptions = document.querySelectorAll('.sous-admin-gestion-option');

    var sousAdminGestionButtonsUrl = urlName.substr(urlName.lastIndexOf('&') + 1);
    var sousAdminGestionOptionsUrl = sousAdminGestionButtonsUrl+'-option';
    
    for (let i = 0; i < sousAdminGestionButtons.length; i++) {

        if (sousAdminGestionButtons[i].id == sousAdminGestionButtonsUrl) {
            desactiveSousAdminGestionButtons();
            desactiveLiOptions();
            adminShowOptions[0].classList.add('active-li-options');
            sousAdminGestionButtons[i].classList.add('sous-admin-gestion-button-active');
        }
    }

    for (let i = 0; i < sousAdminGestionOptions.length; i++) {

        if (sousAdminGestionOptions[i].id == sousAdminGestionOptionsUrl) {
            desactiveSousAdminGestionOptions();
            desactiveDivOptions();
            adminOptions[0].style.display = 'block';
            sousAdminGestionOptions[i].classList.add('sous-admin-gestion-option-active');
        }
    }

    function desactiveSousAdminGestionButtons(){
        sousAdminGestionButtons.forEach(a => {
            a.classList.remove('sous-admin-gestion-button-active');
        });
    }

    function desactiveSousAdminGestionOptions(){
        sousAdminGestionOptions.forEach(div => {
            div.classList.remove('sous-admin-gestion-option-active');
        });
    }
    
    var entreprisesGestionButtons = document.querySelectorAll('.entreprises-gestion-button');
    var entreprisesGestionOptions = document.querySelectorAll('.entreprises-gestion-option');

    var entreprisesGestionButtonsUrl = urlName.substr(urlName.lastIndexOf('&') + 1);
    var entreprisesGestionOptionsUrl = entreprisesGestionButtonsUrl+'-option';
    
    for (let i = 0; i < entreprisesGestionButtons.length; i++) {

        if (entreprisesGestionButtons[i].id == entreprisesGestionButtonsUrl) {
            desactiveEntreprisesGestionButtons();
            desactiveLiOptions();
            adminShowOptions[2].classList.add('active-li-options');
            entreprisesGestionButtons[i].classList.add('entreprises-gestion-button-active');
        }
    }

    for (let i = 0; i < entreprisesGestionOptions.length; i++) {

        if (entreprisesGestionOptions[i].id == entreprisesGestionOptionsUrl) {
            desactiveEntreprisesGestionOptions();
            desactiveDivOptions();
            adminOptions[1].style.display = 'block';
            entreprisesGestionOptions[i].classList.add('entreprises-gestion-option-active');
        }
    }

    function desactiveEntreprisesGestionButtons(){
        entreprisesGestionButtons.forEach(a => {
            a.classList.remove('entreprises-gestion-button-active');
        });
    }

    function desactiveEntreprisesGestionOptions(){
        entreprisesGestionOptions.forEach(div => {
            div.classList.remove('entreprises-gestion-option-active');
        });
    }

    var groupesGestionButtons = document.querySelectorAll('.groupes-gestion-button');
    var groupesGestionOptions = document.querySelectorAll('.groupes-gestion-option');

    var groupesGestionButtonsUrl = urlName.substr(urlName.lastIndexOf('&') + 1);
    var groupesGestionOptionsUrl = groupesGestionButtonsUrl+'-option';
    
    for (let i = 0; i < groupesGestionButtons.length; i++) {

        if (groupesGestionButtons[i].id == groupesGestionButtonsUrl) {
            desactiveGroupesGestionButtons();
            desactiveLiOptions();
            adminShowOptions[3].classList.add('active-li-options');
            groupesGestionButtons[i].classList.add('groupes-gestion-button-active');
        }
    }

    for (let i = 0; i < groupesGestionOptions.length; i++) {

        if (groupesGestionOptions[i].id == groupesGestionOptionsUrl) {
            desactiveGroupesGestionOptions();
            desactiveDivOptions();
            adminOptions[2].style.display = 'block';
            groupesGestionOptions[i].classList.add('groupes-gestion-option-active');
        }
    }

    function desactiveGroupesGestionButtons(){
        groupesGestionButtons.forEach(a => {
            a.classList.remove('groupes-gestion-button-active');
        });
    }

    function desactiveGroupesGestionOptions(){
        groupesGestionOptions.forEach(div => {
            div.classList.remove('groupes-gestion-option-active');
        });
    }

    var individusGestionButtons = document.querySelectorAll('.individus-gestion-button');
    var individusGestionOptions = document.querySelectorAll('.individus-gestion-option');

    var individusGestionButtonsUrl = urlName.substr(urlName.lastIndexOf('&') + 1);
    var individusGestionOptionsUrl = individusGestionButtonsUrl+'-option';
    
    for (let i = 0; i < individusGestionButtons.length; i++) {

        if (individusGestionButtons[i].id == individusGestionButtonsUrl) {
            desactiveIndividusGestionButtons();
            desactiveLiOptions();
            adminShowOptions[4].classList.add('active-li-options');
            individusGestionButtons[i].classList.add('individus-gestion-button-active');
        }
    }

    for (let i = 0; i < individusGestionOptions.length; i++) {

        if (individusGestionOptions[i].id == individusGestionOptionsUrl) {
            desactiveIndividusGestionOptions();
            desactiveDivOptions();
            adminOptions[3].style.display = 'block';
            individusGestionOptions[i].classList.add('individus-gestion-option-active');
        }
    }

    function desactiveIndividusGestionButtons(){
        individusGestionButtons.forEach(a => {
            a.classList.remove('individus-gestion-button-active');
        });
    }

    function desactiveIndividusGestionOptions(){
        individusGestionOptions.forEach(div => {
            div.classList.remove('individus-gestion-option-active');
        });
    }

    var entreprisesInformations = document.querySelectorAll('.entreprises-informations');
    var modifierEntrp = document.querySelectorAll('#modifier_entrp');
    var clickModif = new Array(modifierEntrp.length);
    for (let i = 0; i < modifierEntrp.length; i++) {
        clickModif[i] = 0;
        modifierEntrp[i].addEventListener('click',()=>{
            clickModif[i]++;
            if (clickModif[i]%2 == 1) {
                hideEntrpModifications();
                entreprisesInformations[i].style.height = '220px';
            }
            else{
                hideEntrpModifications();
                entreprisesInformations[i].style.height = '';
            }
        })
    }

    var groupesInformations = document.querySelectorAll('.groupes-informations');
    var modifierGrp = document.querySelectorAll('#modifier_grp');

    for (let i = 0; i < modifierGrp.length; i++) {
        clickModif[i] = 0;
        modifierGrp[i].addEventListener('click',()=>{
            clickModif[i]++;
            if (clickModif[i]%2 == 1) {
                hideGrpModifications();
                groupesInformations[i].style.height = '220px';
            }
            else{
                hideGrpModifications();
                groupesInformations[i].style.height = '';
            }
        })
    }

    var individusInformations = document.querySelectorAll('.individus-informations');
    var modifierIndv = document.querySelectorAll('#modifier_indv');

    for (let i = 0; i < modifierIndv.length; i++) {
        clickModif[i] = 0;
        modifierIndv[i].addEventListener('click',()=>{
            clickModif[i]++;
            if (clickModif[i]%2 == 1) {
                hideIndvModifications();
                individusInformations[i].style.height = '220px';
            }
            else{  
                hideIndvModifications();
                individusInformations[i].style.height = '';
            }
        })
    }

    var validerEntrpModifications = document.querySelectorAll('#id_entrp_modificaitions');
    var validerEntrpModificationsUrl = urlName.substr(urlName.lastIndexOf('=') + 1);

    for (let i = 0; i < validerEntrpModifications.length; i++) {
        
        if (validerEntrpModifications[i].value == validerEntrpModificationsUrl) {
            hideEntrpModifications();
            entreprisesInformations[i].style.height = '220px';
            desactiveEntreprisesGestionButtons();
            desactiveLiOptions();
            adminShowOptions[2].classList.add('active-li-options');
            entreprisesGestionButtons[0].classList.add('entreprises-gestion-button-active');
            desactiveEntreprisesGestionOptions();
            desactiveDivOptions();
            adminOptions[1].style.display = 'block';
            entreprisesGestionOptions[1].classList.add('entreprises-gestion-option-active');
        }
    }

    var validerGrpModificationsId = document.querySelectorAll('#id_grp_modificaitions');
    var validerGrpModificationsUrl = urlName.substr(urlName.lastIndexOf('=') + 1);

    for (let i = 0; i < validerGrpModificationsId.length; i++) {
        
        if (validerGrpModificationsId[i].value == validerGrpModificationsUrl) {
            hideGrpModifications();
            groupesInformations[i].style.height = '220px';
            desactiveGroupesGestionButtons();
            desactiveLiOptions();
            adminShowOptions[3].classList.add('active-li-options');
            groupesGestionButtons[0].classList.add('groupes-gestion-button-active');
            desactiveGroupesGestionOptions();
            desactiveDivOptions();
            adminOptions[2].style.display = 'block';
            groupesGestionOptions[1].classList.add('groupes-gestion-option-active');
        }
    }

    var validerIndvModificationsId = document.querySelectorAll('#id_indv_modificaitions');
    var validerIndvModificationsUrl = urlName.substr(urlName.lastIndexOf('=') + 1);

    for (let i = 0; i < validerIndvModificationsId.length; i++) {
        
        if (validerIndvModificationsId[i].value == validerIndvModificationsUrl) {
            hideIndvModifications();
            individusInformations[i].style.height = '220px';
            desactiveIndividusGestionButtons();
            desactiveLiOptions();
            adminShowOptions[4].classList.add('active-li-options');
            individusGestionButtons[0].classList.add('individus-gestion-button-active');
            desactiveIndividusGestionOptions();
            desactiveDivOptions();
            adminOptions[3].style.display = 'block';
            individusGestionOptions[1].classList.add('individus-gestion-option-active');
        }
    }

    function hideEntrpModifications(){
        entreprisesInformations.forEach(d => {
            d.style.height = '63px';
        })
    }

    function hideGrpModifications(){
        groupesInformations.forEach(d => {
            d.style.height = '63px';
        })
    }

    function hideIndvModifications(){
        individusInformations.forEach(d => {
            d.style.height = '63px';
        })
    }

}