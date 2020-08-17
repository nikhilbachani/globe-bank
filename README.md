# Globe Bank
Content Management System (CMS) built using with PHP and MySQL

## Setting Up
1. Clone the repository inside your web document root from where your web server can read files
    * Into the *htdocs* folder if using an AMP (Apache, MySQL, PHP) installation like WAMP or MAMP
    * In Users/[username]/Sites on macOS if the Sites folder is set up
2. In a command-line application, connect to your MySQL server using default 'root' credentials and import the database *globe_bank* from the provided SQL file
    * For stand-alone MySQL installation: `mysql -u root -p globe_bank < [full_path_to_create_db.sql file]`
    * For AMP stack installations: `[path_to_mysql_executable] --host=localhost -u root -p globe_bank < [full_path_to_create_db.sql file]`
3. Start Apache and MySQL servers
4. Navigate to **localhost:[apache_port_number]/globe_bank/public** to see the *public-facing site*
5. To access the *staff area*, navigate to **localhost:[apache_port_number]/globe_bank/public/staff** and use default staff user credentials:
    * Username: **john_doe**
    * Password: **JohnDoe@12345**
6. Now in the staff area, you can perform CRUD operations for subjects, pages, and admins.
