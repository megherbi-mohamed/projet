<?php
$ville_query = "SELECT ville FROM villes";
$ville_result = mysqli_query($conn, $ville_query);
?>
<div class="demande-emploie-container">
    <div class="demande-emploie-left">
        <div class="liste-demande-emploie">
            <h4>Vos demande d'emploie</h4>
            <div class="demande-emploie">
              demande1  
            </div>
            <div class="demande-emploie">
              demande2  
            </div>
            <div class="demande-emploie">
              demande3 
            </div>
        </div>
        <div class="update-mobile-demandeur">
            <h4>Modifier le numéro de téléphone</h4>
            <form action="">
                <input type="text" id="tlph_user" value="<?php echo $row['tlph_user'] ?>">
                <div>
                    <input type="submit" id="modifer" value="Modifier">
                    <button id="ajt_nv_btn">Ajouter un nouveau</button>
                </div>
            </form>
            <form action="">
                <input type="text" id="tlph_2_user" placeholder="Nouveau numéro">
                <input type="submit" id="ajouter" value="Ajouter">
            </form>
        </div>
    </div>
    <div class="demande-emploie-right">
        <div class="demande-emploie-information">
            <h3>Ajouter une demande d'emploie</h3>
            <form action="">
                <div>
                    <label>Nom et prénom</label>
                    <input type="text" id="nom_emp" name="nom_emp">
                </div>
                <div>
                    <label>Age</label>
                    <input type="text" id="age_emp" name="age_emp">
                </div>
                <div>
                    <label>Sexe</label>
                    <select name="sexe_emp" id="sexe_emp">
                        <option value="homme">Homme</option>
                        <option value="femme">Femme</option>
                    </select>
                </div>
                <div>
                    <label>Adresse</label>
                    <input type="text" id="add_emp" name="add_emp">
                </div>
                <div>
                    <label>Ville</label>
                    <select name="ville_emp" id="ville_emp">
                    <?php while($ville_row = mysqli_fetch_assoc($ville_result)){?>
                        <option value="<?php echo $ville_row['ville']; ?>"><?php echo $ville_row['ville']; ?></option>
                    <?php } ?>
                    </select>
                </div>
                <div>
                    <label>Commune</label>
                    <select name="commune_emp" id="commune_emp">
                    <?php while($commune_row = mysqli_fetch_assoc($commune_result)){?>
                        <option value="<?php echo $commune_row['ville']; ?>"><?php echo $commune_row['ville']; ?></option>
                    <?php } ?>
                    </select>
                </div>
                <div>
                    <label>N° Téléphone</label>
                    <input type="text" id="tlph_emp" name="tlph_emp">
                    <button id="add_number">Ajouter un numéro</button>
                </div>
                <div>
                    <label>E-mail</label>
                    <input type="text" id="email_emp" name="email_emp">
                </div>
                <div>
                    <label>Profession</label>
                    <select name="profession_emp" id="profession_emp">
                        <option value="maçon">Macon</option>
                        <option value="peinteur">Peinteur</option>
                        <option value="menuisier">Menuisier</option>
                        <option value="plombier">Plombier</option>
                        <option value="chauffagier">Chauffagier</option>
                        <option value="autres">Autres</option>
                    </select>
                </div>
                <div class="autre_profession">
                    <input type="text" name="autre_profession_emp" id="autre_profession_emp">
                </div>
                <div>
                    <label>Salaire</label>
                    <input type="text" name="salaire_emp" id="salaire_emp">
                </div>
                <div>
                    <input type="submit" value="Valider">
                </div>
            </form>
        </div>
    </div>
</div>
    