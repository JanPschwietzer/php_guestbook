<html>
    <head>
        <meta charset="utf-8">
        <title>Guestbook</title>
    
    <style>
        html{
            font-family: Arial, Helvetica, sans-serif;
        }
        header {
            padding: 0px 25% 10px 25%;
            text-align: justify;
        }
        main {
            padding-left: 25%;
            padding-right: 25%;
        }
        form {
            display: grid;
            grid-auto-columns: 1fr;
            grid-auto-rows: 1fr 3fr 2fr 2fr;
            grid-row-gap: 5px;
        }
        .php-message {
            text-align: center;
        }

        .php-article{
            padding-top: 5px;
            padding-left: 25%;
            padding-right: 25%;
            color: red;
        }
        .php-article h1 {
            text-decoration: underline;
        }
        .php-article p {
            padding-left: 10px;
        }
    </style>
    </head>

    <body>
        <header>
            <h1>Willkommen!</h1>
            <p>You found your way into our guestbook, drop your name and a message!</p>
        </header>
        <main>
            <form action="index.php" method="POST">
                <input type="text" name="name" placeholder="Name" maxlength="30">
                <textarea name="nachricht" maxlength="300" placeholder="Nachricht" rows="3"></textarea>
                <input type="submit">
                <input type="reset">
            </form>
        </main>

        <?php
            $name = htmlentities($_POST["name"]);
            $nachricht = htmlentities($_POST["nachricht"]);

            $con = @new mysqli("", "username", "password", "database");

            if ($con->connect_error)
            {
                exit("Error, connection could not be etablished!");
            }

            if ($name != "" && $nachricht != "")
            {
                $sql = 'INSERT INTO eintraege (name, nachricht) VALUES ("'.$name.'", "'.$nachricht.'")'; //eintraege = the table that should contain name (varchar), nachricht (varchar), id (int)

                if ($con->query($sql) == true)
                {
                    echo "<p class='php-message' style='color: green'>Thanks! Your message got displayed!</p>";
                }
                else
                {
                    echo "<p class='php-message' style='color: red'>Your message did not find a way onto our server, sorry!</p>";
                }
            }

            $sql = "SELECT * FROM eintraege ORDER BY id DESC";

            if ($res = $con->query($sql))
            {
                if ($res->num_rows == 0)
                {
                    exit("Keine Einträge im Gästebuch.");
                }

                while ($dsatz = $res->fetch_assoc())
                {
                    echo "<article class='php-article'>";
                    echo "<h1>" . $dsatz["name"] . "</h1>";
                    echo "<p>" . $dsatz["nachricht"] . "</p>";
                    echo "</article>";
                }
                $res->close();
            }

            $con->close();
        ?>

    </body>
</html>
