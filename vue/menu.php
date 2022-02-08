
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="z-index: 50;">
  <a class="navbar-brand" href="#"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <?php
      echo '  <li id="accueil"class="nav-item "><a class="nav-link" href="index.php?action=accueil&id='.$_SESSION["token"].'">Accueil</a></li>';
      echo '<li id="ajouter"class="nav-item"><a class="nav-link" href="index.php?action=ajoutLivre&id='.$_SESSION["token"].'">Ajouter un livre</a></li>';
      echo '<li class="nav-item"><a class="nav-link" href="index.php?action=allLivre&id='.$_SESSION["token"].'">Liste des livres</a></li>';
      echo '  <li class="nav-item"><a class="nav-link" href="index.php?action=deleteLivre&id='.$_SESSION["token"].'">Supprimer un livre</a></li>';
      echo '  <li id="compte"class="nav-item"><a class="nav-link" href="index.php?action=moncompte&id='.$_SESSION["token"].'">Mon Compte</a></li>';
      echo '  <li class="nav-item"><a class="nav-link " href="index.php">Déconnexion</a></li>';
      ?>
    </ul>
  </div>
</nav>
