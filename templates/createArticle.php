<?php include "templates/include/header.php" ?>

      <form action="index.php?action=<?php echo $results['formAction']?>" method="post">

        <ul>

          <li>
            <label for="title">Название статьи</label>
            <input type="text" name="title" id="title" placeholder="Название статьи" required autofocus maxlength="255" />
          </li>

          <li>
            <label for="summary">Краткое описание</label>
            <textarea name="summary" id="summary" placeholder="Краткое описание" required maxlength="1000" style="height: 5em;"></textarea>
          </li>

          <li>
            <label for="content">Текст статьи</label>
            <textarea name="content" id="content" placeholder="Текст статьи" required maxlength="100000" style="height: 30em;"></textarea>
          </li>

          <li>
            <label for="publicationDate">Дата публикации</label>
            <input type="date" name="publicationDate" id="publicationDate" placeholder="YYYY-MM-DD" required maxlength="10"/>
          </li>


        </ul>

        <div class="buttons">
          <input type="submit" name="saveChanges" value="Save Changes" />
          <input type="submit" formnovalidate name="cancel" value="Cancel" />
        </div>

      </form>

<?php include "templates/include/footer.php" ?>
