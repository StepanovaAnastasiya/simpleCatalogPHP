<?php include "templates/include/header.php" ?>

      <h1>Все статьи</h1>

<?php if ( isset( $results['errorMessage'] ) ) { ?>
        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>


<?php if ( isset( $results['statusMessage'] ) ) { ?>
        <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
<?php } ?>

      <table>
        <tr>
          <th>Название статьи</th>
          <th>Краткое описание</th>
          <th>Дата публикации</th>
          <th></th>
        </tr>

<?php foreach ( $results['articles'] as $article ) { ?>

        <tr>
          <td>
            <a href="index.php?action=viewArticle&amp;articleId=<?php echo $article->id?>"><?php echo $article->title?></a>
          </td>
          <td>
            <p><?php echo htmlspecialchars( $article->summary )?></p>
          </td>
          <td><?php echo date('j M Y', $article->publicationDate)?></td>
          <td><a href="index.php?action=deleteArticle&amp;articleId=<?php echo $article->id ?>">Удалить</a></td>
        </tr>

<?php } ?>

      </table>
      <?php for ($i=1; $i <= $results['pagesNumber']; $i++) {
        echo "<a href='?page=$i'>$i</a>"." ";
      } ?>
      <p><a href="index.php?action=newArticle">Добавить новую статью</a></p>

<?php include "templates/include/footer.php" ?>
