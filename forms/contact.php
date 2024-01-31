<?php
require_once "forms/connection.php";

class Contact
{
    private $conn;

    public function __construct()
    {
        $obj = new Connexion();
        $this->conn = $obj->getConnexion();
    }

    public function handleFormSubmission()
    {
        if (isset($_POST["submit"])) {
            $name = htmlspecialchars($_POST["name"]);
            $email = htmlspecialchars($_POST["email"]);
            $subject = htmlspecialchars($_POST["subject"]);
            $message = htmlspecialchars($_POST["message"]);

            // Use prepared statements to prevent SQL injection
            $sql = "INSERT INTO Contact (name, email, subject, message) VALUES (?, ?, ?, ?)";

            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$name, $email, $subject, $message]);
                echo "Record inserted successfully";
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

            $this->conn = null; // Close the database connection
        }
    }
}

// Create an instance of the Contact class
$contactObj = new Contact();

// Call the handleFormSubmission method to handle the form submission
$contactObj->handleFormSubmission();
?>

