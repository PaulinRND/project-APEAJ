<?php
$bsIcons = true;
$title = "Consultation Formation";
$scripts = "<script src='./assets/js/sadmin/formation.js' type='module'></script>";
ob_start(); //On bufferise l'affichage
?>
<div class="container">
  <?php
    switch ($error) {
        case 1 :
          echo '<div class="alert alert-danger my-3" role="alert">Une erreur s\'est produite lors de l\'initialisation de la page.</div>';
          $content = ob_get_clean();
          require("../app/views/layout.php");
          exit();
        case 2 :
          echo '<div class="row alert alert-danger my-3" role="alert"> La formation n\'existe pas.</div>'; break;
        case 3:
          echo '<div class="row alert alert-danger my-3" role="alert">Une erreur s\'est produite lors de la mise à jour de la formation.</div>'; break;
        case 4:
          echo '<div class="row alert alert-danger my-3" role="alert">Ajout impossible d\'un utilisateur, les valeurs rentrées ne sont pas valides.</div>'; break;
        case 5:
          echo '<div class="row alert alert-danger my-3" role="alert">Une erreur s\'est produite lors de la suppression de l\'utilisateur.</div>'; break; 
        case 6:
          echo '<div class="row alert alert-danger my-3" role="alert">Une erreur s\'est produite lors de l\'ajout d\'un utilisateur à une formation.</div>'; break;
        case 7:
          echo '<div class="row alert alert-danger my-3" role="alert">Modification de l\utilisateur avec succès</div>'; break;
        case 8:
          echo '<div class="row alert alert-danger my-3" role="alert">Une erreur s\'est produite lors de la suppression de la formation.</div>'; break;
        case 26:
            echo '<div class="row alert alert-danger my-3" role="alert">L\'utilisateur n\'existe pas</div>'; break;
    }

    switch ($success) {
      case 1 :
        echo '<div class="alert alert-success my-3" role="alert">La formation a bien été modifié.</div>'; break;
      case 2 :
        echo '<div class="alert alert-success my-3" role="alert">Suppression de l\'utilisateur enregistrée.</div>'; break;
      case 3 :
        echo '<div class="alert alert-success my-3" role="alert">Ajout de l\'utilisateur enregistré.</div>'; break;
      

    }
    ?>


    <h2 class="text-center fw-bold"><?= htmlentities($training->wording)?></h2>
    <div class="d-flex align-items-center justify-content-end">
      <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="POST">
        <input type="hidden" name="action" value="disconnect">
        <button type="submit" class="btn btn-danger">
          <i class="bi bi-power me-2"></i>Se déconnecter  
        </button>
      </form> 
      <div class="ms-3"><i class="bi bi-person-circle p-0" style="font-size: 3rem"></i></div>
    </div>

    <!-- Affichage de l'image de la formation A CHANGER -->
    <div class="row border border-2 border-black rounded pt-2">
      <div class="col-5 col-lg-4 mb-2">
        <img src="<?= $training->picture ?>" class="w-100" alt="Image formation">
      </div>
      <div class="col-7 col-lg-3 d-flex flex-column justify-content-evenly align-items-center mb-2">
        <div>
          <span>Niveau de qualification</span>
          <div class="border rounded mt-2 p-2"><?= htmlentities($training->qualifLevel)?></div>
        </div>
        <div>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateTraining">
            <i class="bi bi-pencil-square me-2"></i>Modification
          </button></div>
        <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="POST">
          <input type="hidden" name="action" value="deleteTraining">
          <input type="hidden" name="idTraining" value="<?= $training->idTraining ?>">
          <button type="submit" class="btn btn-primary btn-removed-training">
            <i class="bi bi-trash me-2"></i>Suppression
          </button>
        </form> 
      </div>
      <div class="col-12 col-lg-5 d-flex flex-column mb-2">
        <span>Description de la formation</span>  
        <div class="border rounded h-100 mt-2 p-2"><?= htmlentities($training->description)?></div>
      </div>
    </div>

    <div class="row">
      <div class="d-flex justify-content-between p-0 my-4">
        <div class="fw-bold fs-4">Liste des éducateurs de la formation</div>
        <button id="btn-newUser" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newUser"> 
          <i class="bi bi-person-plus-fill me-2"></i>Nouveau
        </button>           
      </div>
    </div>
    <!-- Liste des educateur de la formation -->
    <div class="row g-3">
      <!-- Tableau pour parcourir la liste des éducateur de la formation-->
      <?php
      if(is_array($admins)){
        foreach($admins as $admin) {
          echo $admin->getCardTemplateSAdmin();
        }
      }
      ?>
    </div>
    <!-- Liste des étudiants de la formation -->
    <div class="row">
      <div class="fw-bold fs-4 my-4">Liste des Etudiants de la formation</div>
    </div>

    <div class="row g-3">
      <!-- Tableau pour parcourir la liste des étudiants de la formation-->
      <?php
      if(is_array($students)) {
        foreach($students as $student) {
          echo $student->getCardTemplateSAdmin();
        }
      }
      ?>
    </div>

    
    <div class="modal fade" id="updateTraining" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="newTrainingLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="<?= $_SERVER ["REQUEST_URI"]?>" method="POST">
                <input type="hidden" name="action" value="updateTraining">
                <input type="hidden" name="idTraining" value="<?= $training->idTraining ?>">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newTrainingLabel">Ajouter formation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">     
                        <div class="row">
                            <!--Selection de l'image -->
                            <div class="col-4">
                                <label for="inputImgTraining">
                                    <img id="imgTraining" src="<?= $training->picture ?>" class="w-100 border border-black border-2 rounded" alt="Photo de la formation">
                                </label>
                                <input id="inputImgTraining" type="file" class="d-none" name="imgTraining">
                            </div>   
                            <div class="col-8">
                                <div class="">
                                    <label for="inputName" class="form-label">Nom de la formation</label>
                                    <input id="inputName" type="text" class="form-control" name="wording" value="<?= $training->wording ?>">
                                </div>
                                <div class="">
                                    <label for="inputLevel" class="form-label">Niveau de la formation</label>
                                    <input id="inputLevel" type="text" class="form-control" name="qualifLevel" value="<?= $training->qualifLevel ?>">
                                </div>
                            </div>
                            <div class="col-12 my-3">
                                <label for="inputDescription" class="form-label">Description Formation</label>                                        
                                <textarea class="form-control" id="inputDescription" rows="3" name="description"><?= $training->description ?></textarea>
                            </div>
                
                            <div class="modal-footer">
                                <button type="button" class="me-3 btn btn-danger" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle me-2"></i>Annuler
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-2"></i>Valider
                                </button>
                            </div>
                        </div>      
                    </div>  
                </div>
            </form>
        </div>  
    </div>

    <!-- Modal ajout utilisateur-->
    <div class="modal fade" id="newUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="newUserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="<?= $_SERVER["REQUEST_URI"]?>" method="POST">
                <input type="hidden" name="action" value="addUser">
                <input type="hidden" name="idTraining" value="<?= $training->idTraining ?>">
                    
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newUserLabel">Ajouter utilisateur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-4">
                                <label for="inputImgUserAdd">
                                    <img id="imgUserAdd" class="w-100 border" alt="Image de l'utilisateur">
                                </label>
                                <input id="inputImgUserAdd" type="file" class="d-none" name="picture">
                            </div>

                            <div class="col-8 d-flex flex-column justify-content-between">
                                <div class="mb-3">
                                    <label for="inputLastName">Nom</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                                        <input id="inputLastName" type="text" class="form-control" name="lastName">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="inputFirstName">Prénom</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                                        <input id="inputFirstName" type="text" class="form-control" name="firstName">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12 mt-3">
                                <label for="inputTypePwd" class="form-label">Type de mot de passe</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <select class="form-select selectTypePwd" id="inputTypePwd" name="typePwd">
                                        <option value="1">Texte</option>
                                        <option value="2">Code</option>
                                        <option value="3">Schéma</option>
                                    </select>
                                </div>
                            </div>

                            <div class="textField">
                                <div class="col-12 mt-3">
                                    <label for="inputPwdText" class="form-label">Mot de passe</label>
                                    <div class="input-group">
                                        <input id="inputPwdText" type="password" class="form-control input-pwd" name="pwd">
                                        <span role="button" class="input-group-text"><i class="bi bi-eye"></i></span>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="inputConfirmPwd" class="form-label">Confirmation du mot de passe</label>
                                    <div class="input-group">
                                        <input id="inputVerifPwd" type="password" class="form-control input-pwd" name="verifPwd">
                                        <span role="button" class="input-group-text"><i class="bi bi-eye"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="codeField">
                                <div class="col-12 mt-3">
                                    <label for="inputPwd" class="form-label">Code</label>
                                    <div class="input-group">
                                        <input id="inputPwd" type="password" class="form-control input-pwd" name="pwd" pattern="[0-9]{4,6}">
                                        <span role="button" class="input-group-text"><i class="bi bi-eye"></i></span>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="inputConfirmPwd" class="form-label">Confirmation du code</label>
                                    <div class="input-group">
                                        <input id="inputVerifPwd" type="password" class="form-control input-pwd" name="verifPwd" pattern="[0-9]{4,6}">
                                        <span role="button" class="input-group-text"><i class="bi bi-eye"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="schemaField">
                                <div class="col-12 mt-3">
                                    schéma
                                </div>
                                <div class="col-12 mt-3">
                                    confirmation schéma
                                </div>
                            </div>
                            <!-- Selection du type d'utilisateur -->
                            <div class="col-12 my-3">
                                <label class="form-label" for="inputRole">Rôle de l'utilisateur</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-mortarboard"></i></span>
                                    <select class="form-select" id="inputRole" name="role">
                                        <option value="student">Élève</option>
                                        <option value="educator">Educateur</option>
                                        <option value="educator-admin">Educateur administrateur</option>
                                        <option value="CIP">CIP</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer text-center">
                                <button type="button" class="btn btn-danger me-2" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle me-2"></i>Annuler
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-2"></i>Valider
                                </button>
                            </div>
                        </div>  
                    </div>  
                </div>
            </form>
        </div>
    </div>

    
    <!-- Modal modifier utilisateur-->
    <div class="modal fade" id="updateUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="newUserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="<?= $_SERVER ["REQUEST_URI"]?>" method="POST">
                <input type="hidden" name="action" value="updateAdmin">
                <input id="idUser" type="hidden" name="idUser">
                <input type="hidden" name="idTraining" value="<?= $training->idTraining ?>">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newUserLabel">Ajouter utilisateur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-4">
                                <label for="inputImgUserUpdate">
                                    <img id="imgUserUpdate" class="w-100 border" alt="Image de l'utilisateur">
                                </label>
                                <input id="inputImgUserUpdate" type="file" class="d-none" name="picture">
                            </div>

                            <div class="col-8 d-flex flex-column justify-content-between">
                                <div class="mb-3">
                                    <label for="inputLastName">Nom</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                                        <input id="inputLastName" type="text" class="form-control" name="lastName">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="inputFirstName">Prénom</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                                        <input id="inputFirstName" type="text" class="form-control" name="firstName">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12 mt-3">
                                <label for="inputTypePwd" class="form-label">Type de mot de passe</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <select class="form-select selectTypePwd" id="inputTypePwd" name="typePwd">
                                        <option value="1">Texte</option>
                                        <option value="2">Code</option>
                                        <option value="3">Schéma</option>
                                    </select>
                                </div>
                            </div>

                            <div class="textField">
                                <div class="col-12 mt-3">
                                    <label for="inputPwd" class="form-label">Mot de passe</label>
                                    <div class="input-group">
                                        <input id="inputPwd" type="password" class="form-control input-pwd" name="pwd">
                                        <span role="button" class="input-group-text"><i class="bi bi-eye"></i></span>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="inputConfirmPwd" class="form-label">Confirmation du mot de passe</label>
                                    <div class="input-group">
                                        <input id="inputVerifPwd" type="password" class="form-control input-pwd" name="verifPwd">
                                        <span role="button" class="input-group-text"><i class="bi bi-eye"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="codeField">
                                <div class="col-12 mt-3">
                                    <label for="inputPwd" class="form-label">Code</label>
                                    <div class="input-group">
                                        <input id="inputPwd" type="password" class="form-control input-pwd" name="pwd" pattern="[0-9]{4,6}">
                                        <span role="button" class="input-group-text"><i class="bi bi-eye"></i></span>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="inputConfirmPwd" class="form-label">Confirmation du code</label>
                                    <div class="input-group">
                                        <input id="inputVerifPwd" type="password" class="form-control input-pwd" name="verifPwd" pattern="[0-9]{4,6}">
                                        <span role="button" class="input-group-text"><i class="bi bi-eye"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="schemaField">
                                <div class="col-12 mt-3">
                                    schéma
                                </div>
                                <div class="col-12 mt-3">
                                    confirmation schéma
                                </div>
                            </div>
                            <div class="col-12 my-3">
                                <label class="form-label" for="inputRole">Rôle de l'utilisateur</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-mortarboard"></i></span>
                                    <select class="form-select selectRole" id="inputRole" name="role">
                                        <option value="student">Élève</option>
                                        <option value="educator">Educateur</option>
                                        <option value="educator-admin">Educateur administrateur</option>
                                        <option value="CIP">CIP</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer text-center">
                                <button type="button" class="btn btn-danger me-2 btn-cancel" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle me-2"></i>Annuler
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-2"></i>Valider
                                </button>
                            </div>
                        </div>  
                    </div>  
                </div>
            </form>
        </div>
    </div>

</div>


<script>
    const adminsTab = <?= json_encode($admins) ?>;
</script>


<?php
$content = ob_get_clean(); //On récupère le contenu bufferisé

require("../app/views/layout.php"); //On require le fichier avec toutes les variables définies
//pas obligatoire de définir toutes les variables, voir fichier layout.php