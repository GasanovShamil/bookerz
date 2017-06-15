<h2>Titre</h2><?php echo $book['title']; ?>

<h2>Description</h2><?php echo $book['description']; ?>

<h2>Auteur</h2><?php echo $book['author']; ?>

<h2>Date de parution</h2><?php echo $book['published']; ?>

<h2>Editeur</h2><?php echo $book['editor']; ?>

<h5>ISBN-10</h5><?php echo $book['ISBN10']; ?>
<h5>ISBN-13</h5><?php echo $book['ISBN13']; ?>
<br>

<a href="/salon/view/<?php echo $book['id']; ?>">Accéder au chat</a>
