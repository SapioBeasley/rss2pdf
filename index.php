<!DOCTYPE html>
<html>
    <head>
        <title>XML to PDF</title>
    </head>
    <body>

        <?php if (!empty($_POST)): ?>
            Your submitted url is <?php echo htmlspecialchars($_POST['urlToParse']); ?>.<br>
            View pdf <a href="pdf.php?url=<?php echo urlencode($_POST['urlToParse']); ?>">here</a>.
        <?php else: ?>
            <form action=<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> method="post">
                <input type="text" name="urlToParse" placeholder="INPUT URL"><br>
                <input type="submit">
            </form>
        <?php endif; ?>

    </body>
</html>
