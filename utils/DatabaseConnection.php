<?php
class DatabaseConnection {
    private static $servername = "localhost";
    private static $username = "rp";
    private static $password = "";
    private static $dbname = "Silver-Book";
    private static $conn = null;

    public static function getConnection() {
        if (self::$conn === null) {
            try {
                $dsn = "mysql:host=" . self::$servername . ";dbname=" . self::$dbname;
                self::$conn = new PDO($dsn, self::$username, self::$password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
                die();
            }
        }
        return self::$conn;
    }
}
?>
