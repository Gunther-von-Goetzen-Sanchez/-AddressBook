# -AddressBook

An address book in which you can add, edit and delete entries - Symfony 3.4, PHP7, Doctrine with SQLite and Twig

Create a folder with the name AddressBook and install Symfony 3.4 in it
  
C:\AddressBook>composer create-project symfony/framework-standard-edition AddressBook "3.4.*"

Initialize your folder as a Git repository
C:\AddressBook>git init

Pull the AddressBook app on your local workspace

C:\AddressBook>git pull https://github.com/Gunther-von-Goetzen-Sanchez/AddressBook.git master

Make sure you have configured your driver to be SQlite and you have the right path to your DB

Doctrine Configuration
doctrine:
    dbal:
        driver: pdo_sqlite
		path: '%kernel.project_dir%/sqlite.db'

Start the Symfony server

C:\AddressBook>php bin/console server:run

Enjoy it!

REQUIREMENTS
Symfony 3.4 
PHP7 
Doctrine with SQLite 
Twig
Composer
Git
