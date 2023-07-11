<?php
    /* 
    ==== Connexion à la BDD ====

    11. S'assurer d'avoir une méthode "config" que l'on exécutera au tout début de notre constructeur
    12. Dans la méthode config, ouvrir une connexion avec la base de données contenant la table animals (de refuge). Stocker la connexion dans un attribut "bdd" ou "db".

    ==== Génération du menu ====
    13. Créer une méthode "show_menu"
    14. Exécuter la méthode show_menu dans le show_body, à l'emplacement désirez
    15. Créer une méthode get_distinct_species permettant de retourner un tableau des différentes espèces de BDD
    16. Implémenter la méthode show_menu, de manière à ce qu'elle affiche un lien par espèces
    17. Chaque lien doit diriger ver l'index.php et contenir une variable "page" en GET dont la valeur sera l'espèce.

    18. Afficher la liste des animaux, dont l'espèce correspond à $_GET['page'], à la suite du body
    */
    class App {

        private $root ; // Chemin vers la racine de l'application
        private $db ; // Connexion à la BDD

        function __construct() {

            $this->config();

            $this->show_header();
            $this->show_body();
            $this->show_list();
            $this->show_footer();
        }

        function config() {
            $this->root = getcwd();
            $this->db = new PDO(
                "mysql:dbname=refuge_bdd;host=localhost",
                'root',
                ''
            );
        }

        function show_header() {
            include_once $this->root."/templates/header.php" ;
        }

        function show_footer() {
            include_once $this->root."/templates/footer.php" ;
        }

        function show_body() {
            echo "<h1>Mon refuge</h1>";
            $this->show_menu();
            echo "\t\t<p>Le chemin ROOT est " . getcwd() . "</p>\n" ;
            echo "\t\t<p>Les données GET sont : </p>\n" ;
            var_dump( $_GET );
        }

        function show_list() {
            $query = $this->db->prepare("SELECT * FROM animals WHERE espece = ?");
            //requete sql, va chercher les données qu'on veut 
            $query->execute(array($_GET['page']));
            //récupère les données, ici les animaux car $_GET['page'] récupère les animaux, 
            //$_GET['page'] va remplacer le point d'interogation parce qu'on peut pas mettre de variable dans la requète SQL
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            //donne les données, on peut les utiliser elles sont sur la page
            var_dump($result);
            
            echo "Voici la liste des animaux:<ul>";
            foreach($result as $animal){
                echo "<li>".
                    $animal['nom']
                ."</li>";
            }
                
            echo "</ul>";
        }

        function show_menu() {
            include $this->root . "/templates/menu.php" ;
        }
        
        // Retourne un tableau contenant les différentes espéces de la base
        function get_distinct_species() {

            // Préparation de la requête
            $query = $this->db->prepare("SELECT DISTINCT( espece ) FROM animals");

            // Exécution de la requête
            $query->execute(array());

            // Récupération des lignes
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            // Simplification du tableau
            $species = array();

            foreach( $result as $row ) {
                // Pour chaque espèce, on la rajoute dans le tableaux d'espèces
                array_push( $species, $row['espece'] );
            }

            return $species ;

        }

    };