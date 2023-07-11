<nav>
    <p><a href="index.php">Accueil</a></p>
    <?php
        foreach( $this->get_distinct_species() as $espece ) {
            ?>
                <p>
                    <a href="index.php?page=<?php echo $espece ?>">
                        <?php echo $espece ?>
                    </a>
                </p>
            <?php
        }
    ?>
</nav>