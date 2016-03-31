# Gestion de dossiers administratifs
## Installation

 1. Copier le bundle IutDossiersBundle dans vote projet Symfony2 (dossier /src)
 2. Enregistrer le bundle dans le Kernel et ses dépendances (/app/AppKernel.php)

		$bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Iut\DossiersBundle\IutDossiersBundle(), // <--- Le bundle
            new Symfony\Bundle\AsseticBundle\AsseticBundle(), //  <--- Dépendance
            new \Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(), // <--- Dépendance
            new \FOS\JsRoutingBundle\FOSJsRoutingBundle() // <--- Dépendance
        );

 3. Mettre à jour Symfony2

    ``composer update``
 4. Installer les ressources (assets) nécéssaire

    ``php app/console symfony assets:install``

 5.  Générer la base de données

    ``php app/console symfony doctrine:schema:update --force``

 6. Importer la base de données existante (dump_sql_dossiers.sql)

## Configuration
### E-Mails
Il est possible de définir une adresse e-mail d'envoi par défaut. Tous les e-mails envoyés via l'application le seront à travers cette adresse.
Pour ce faire, il suffit de modifier le fichier parameters.yml, et indiquer les paramètres liés au mail:

    mailer_transport: smtp
    mailer_host: votre_hote_smtp
    mailer_user: votre_utilisateur
    mailer_password: votre_mot_de_passe

De plus, il faut modifier le config.yml comme ceci:

    swiftmailer:
	    transport: "%mailer_transport%"
	    host:      "%mailer_host%"
	    username:  "%mailer_user%"
	    password:  "%mailer_password%"
	    spool:     { type: memory }
	    sender_address: "votre.adresse@hote.fr"





