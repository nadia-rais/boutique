<?php $page_selected = 'admin_articles.php'; ?>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<?php
include("includes/header.php");
require('admin_nav.php');

?>
<!DOCTYPE html>
<html>
<head>
    <title>boutique - admin_articles</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes"/>
    <link rel="shortcut icon" type="image/x-icon" href="https://i.ibb.co/0mKd0xT/icon-round-fanzine.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
          <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<main>
  <?php

if ($user->is_admin==0) {
    ?>
  <div class="admin">
    <div class="button">
  <a href="admin_articles.php?articles">Voir les articles</a><br/>
  <a href="admin_articles.php?ajouter">ajouter un article</a><br/>
  </div>

  <?php

  if (isset($_GET['articles'])) {
      if (!empty($_SESSION['statusMsg'])) {
          echo '<p>'.$_SESSION['statusMsg'].'</p>';
          unset($_SESSION['statusMsg']);
      } ?>
    <div class="row">
            <div class="panel-heading">Articles </div>
            <table class="table">
                <tr>
                    <th width="10%">Nom du fanzine</th>
                    <th width="10%">Auteur</th>
                    <th width="10%">Editions</th>
                    <th width="10%">Description</th>
                    <th width="10%">Citation</th>
                    <th width="10%">Nbe de pages</th>
                    <th width="10%">Année de parution</th>
                    <th width="10%">Prix</th>
                    <th width="10%">Date d'ajout</th>
                    <th width="10%"></th>
                </tr>
                <?php

        $users = $db->getRows('article', array('order_by'=>'id_article DESC'));
      if (!empty($users)) {
          $count = 0;
          foreach ($users as $user) {
              $count++; ?>
                <tr>
                    <td><?php echo $user['nom_article']; ?></td>
                    <td><?php echo $user['auteur_article']; ?></td>
                    <td><?php echo $user['editions_article']; ?></td>
                    <td><?php echo $user['citation_article']; ?></td>
                    <td><?php echo $user['nb_pages']; ?></td>
                    <td><?php echo $user['annee_parution']; ?></td>
                    <td><?php echo $user['prix_article']; ?>   euros</td>
                    <td><?php echo $user['date_registration']; ?></td>
                    <td>
                        <a href="admin_articles.php?id_article=<?php echo $user['id_article']; ?>" class="glyphicon glyphicon-edit"></a>
                        <a href="action_article.php?action_type=delete&id_article=<?php echo $user['id_article']; ?> " onclick="return confirm('Are you sure?');">X</a>
                    </td>
                </tr>
                <?php
          }
      } else { ?>
                <tr><td colspan="4">Aucun article trouvé......</td>
                <?php }
  } ?>
    </div>

    </tbody>
  </table>
  <?php
//modification d'un article
   if (isset($_GET['id_article'])) {
      $userData = $db->getRows('article', array('where'=>array('id_article'=>$_GET['id_article']),'return_type'=>'single'));
      if (!empty($userData)) {
          ?>

          <section id="container-register">

        <div class="">Modifier l'article <a href="admin_articles.php" class="glyphicon glyphicon-arrow-left"></a></div>
            <form method="post" action="action_article.php" class="form" id="userForm">

                <div class="form-group">
                    <label>Nom de l'article</label>
                    <input type="text" class="form-control" name="nom_article" value="<?php echo $userData['nom_article']; ?>"/>
                </div>
                <div class="form-group">
                    <label>Auteur de l'article</label>
                    <input type="text" class="form-control" name="auteur_article" value="<?php echo $userData['auteur_article']; ?>"/>
                </div>
                <div class="form-group">
                    <label>Edition de l'article</label>
                    <input type="text" class="form-control" name="editions_article" value="<?php echo $userData['editions_article']; ?>"/>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <input type="textarea" class="form-control" name="description_article" value="<?php echo $userData['description_article']; ?>"/>
                </div>
                <div class="form-group">
                    <label>Citation de l'article</label>
                    <input type="textarea" class="form-control" name="citation_article" value="<?php echo $userData['citation_article']; ?>"/>
                </div>
                <div class="form-group">
                    <label>Nombre de pages </label>
                    <input type="number" class="form-control" name="nb_pages" value="<?php echo $userData['nb_pages']; ?>"/>
                </div>
                <div class="form-group">
                    <label>Année de parution </label>
                    <input type="number" class="form-control" name="annee_parution" value="<?php echo $userData['annee_parution']; ?>"/>
                </div>
                <div class="form-group">
                    <label>Prix </label>
                    <input type="number" class="form-control" name="prix_article" value="<?php echo $userData['prix_article']; ?>"/>
                </div>

                <div class="form-group">
                    <label>Catégorie</label>

  <select name="id_sous_categorie">
  <?php
  $products = $db->query('SELECT * FROM sous_categorie');

  foreach ($products as $product):
  // On affiche chaque entrée une à une

  ?>
  <strong>Sous catégorie</strong> : <?php echo "<option value = '" . $product->id_sous_categorie . "'>" . $product->nom_sous_categorie . "</option>";
  ?>
  <br />
  <?php endforeach; ?>
  </select>
  </div>
                <input type="hidden" name="action_type" value="add"/>
                <input type="submit" class="form-control btn-default" name="submit_article" value="Modifier le fanzine"/>

            <section id="modification">
              <h1>Illsutration du fanzine</h1>
              <form id="formpic" method="POST">
                <label> adresse url de l'image </label>
                <input type="text" id="avatar" name="linkimg" accept="image/png, image/jpeg">
                <input type="submit" name="submit1" value="Upload">
              </form>

              <form id="formfiles" action="upload.php" method="post" enctype="multipart/form-data">
                <label for="fileUpload">ou sélectionner votre fichier:</label>
                <div id="inputfiles">
                <input type="file" name="photo" id="fileUpload">
                <input type="submit" name="submit" value="Upload">
                </div>
                <p><strong>Note:</strong> Seuls les formats .jpg, .jpeg, .jpeg, .gif, .png sont autorisés jusqu'à une taille maximale de 5 Mo.</p>
              </form>
            </form>
      </section>
    </section>
  <?php  ?>


    <?php
      }
  } ?>



  <?php
  if (isset($_GET['ajouter'])) {
     $userData = $db->getRows('article', array('where'=>array('id_article'=>$_GET['ajouter']),'return_type'=>'single'));

 ?>

      <div class="row">
          <div class="panel panel-default user-add-edit">
              <div class="panel-heading">Ajouter un article <a href="admin_articles.php" class="glyphicon glyphicon-arrow-left"></a></div>
              <div class="panel-body">
                  <form method="post" action="action_article.php" class="form">
                      <div class="form-group">
                          <label>Nom de l'article</label>
                          <input type="text" class="form-control" name="nom_article"/>
                      </div>
                      <div class="form-group">
                          <label>Auteur de l'article</label>
                          <input type="text" class="form-control" name="auteur_article"/>
                      </div>
                      <div class="form-group">
                          <label>Edition de l'article</label>
                          <input type="text" class="form-control" name="editions_article"/>
                      </div>
                      <div class="form-group">
                          <label>Description</label>
                          <input type="textarea" class="form-control" name="description_article"/>
                      </div>
                      <div class="form-group">
                          <label>Citation de l'article</label>
                          <input type="textarea" class="form-control" name="citation_article"/>
                      </div>
                      <div class="form-group">
                          <label>Nombre de pages </label>
                          <input type="number" class="form-control" name="nb_pages"/>
                      </div>
                      <div class="form-group">
                          <label>Année de parution </label>
                          <input type="number" class="form-control" name="annee_parution"/>
                      </div>
                      <div class="form-group">
                          <label>Prix </label>
                          <input type="number" class="form-control" name="prix_article"/>
                      </div>

                          <div class="form-group">
                              <label>catégorie</label>

                        <select name="id_sous_categorie">
                        <?php
                        $products = $db->query('SELECT * FROM sous_categorie');

                        foreach ($products as $product):
                        // On affiche chaque entrée une à une

                        ?>
                        <strong>Sous catégorie</strong> : <?php echo "<option value = '" . $product->id_sous_categorie . "'>" . $product->nom_sous_categorie . "</option>";
                        ?>
                        <br />
                        <?php endforeach; ?>
                        </select>
                        </div>

    </div>


                      <input type="hidden" name="action_type" value="add"/>
                      <input type="submit" class="form-control btn-default" name="submit" value="Créer l'article"/>
                      <form class="" action="admin_articles.php?ajouter" method="post">


                      <input type="number" name="nb_articles_stock" value="">
                      nombre articles<input type="hidden" name="id_article" value="<?php echo "1" ;?>">
                      <?php

                      
                      ?>
                      </form>

                  </form>
              </div>
          </div>
      </div>


    <?php
  } } else {
    echo "vous n'avez pas le droit d'accéder à cette page, bien essayé ;)";
    echo "<a href='index.php'> Retour à l'accueil </a>";
}   ?>
  </main>
  </body>
  </html>

</main>
</body>
</html>
