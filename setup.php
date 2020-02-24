<?php
require_once('foundation.php');
try
{
$roar = $blog->exec("CREATE TABLE blog_moderators(
	moderatorID INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	moderatorname VARCHAR(16),
	password VARCHAR(16),
	email VARCHAR(16))");

}
catch(PDOException $e) {
            echo $e->getMessage();
        }
try
{
$roar2 = $blog->exec("CREATE TABLE blog_categories(
	catID INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	catTitle VARCHAR(4096))");


}
catch(PDOException $e) {
            echo $e->getMessage();
        }
try
{
$roar3 = $blog->exec("CREATE TABLE blog_pub(
	pubID INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	pubTitle VARCHAR(4096),
	pubDesc VARCHAR(4096),
	pubCont TEXT,
	pubDate DATETIME)");

}
catch(PDOException $e) {
            echo $e->getMessage();
        }
        try
{
$roar4 = $blog->exec("CREATE TABLE matching(
	matchID INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	pubID INT(11),
	catID INT(11))");

}
catch(PDOException $e) {
            echo $e->getMessage();
        }
 

 try
        {
$roar6 = $blog->query("SELECT * FROM blog_moderators WHERE moderatorID = 1");
$row1 = $roar6->fetch();
if(!(isset($row1['moderatorID']))) { $roar6 = $blog->query("INSERT INTO blog_moderators(moderatorname, password, email) VALUES('zhasik', 'zhasik', 'programmer')"); }
}
catch(PDOException $e) {
            echo $e->getMessage();
        }
