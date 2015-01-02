Script generates file and puts it into folder with minimal size.
Use config/main.php in order to configure sizes of  folders and files.

You can use database to store sizes in it. To do it set 'use_db' into  true,
configure database settings and run writer.sql.

To start:
index.php write <count of files you want write>

To get statistic:
index.php stat