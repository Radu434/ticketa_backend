<?php

class User
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAll()
    {
        $query = "SELECT * FROM user";
        $result = mysqli_query($this->conn, $query);

        $users = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
        return json_encode($users);

    }

    public function getById($user_id)
    {
        $query = "SELECT * FROM user WHERE id LIKE $user_id";
        $result = mysqli_query($this->conn, $query);
        $users = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
        return json_encode($users);
    }
    public function getByEmail($email)
    {
        // Prepare the SQL statement
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE email LIKE ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        $stmt->close();
        return json_encode($users);
    }
    public function getByUsername($username)
    {
        $query = "SELECT * FROM username WHERE id LIKE $username";
        $result = mysqli_query($this->conn, $query);
        $users = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
        return json_encode($users);
    }

    public function create($data): int
    {
        $email = $data["email"];
        $password = $data["password"];
        $username = $data["username"];

        $sql = "INSERT INTO user (email, password, username) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sss', $email, $password, $username);
        $stmt->execute();
        return mysqli_insert_id($this->conn);

    }
    public function update($userId, $data): int
    {
        $current = json_decode($this->getById($userId), true)[0];
        $email = $data["email"] ?? $current["email"];
        $password = $data["password"] ?? $current["password"];
        $username = $data["username"] ?? $current["username"];
        $sql = "UPDATE user SET email = ?,password = ?,username = ?  WHERE id = $userId";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sss', $email, $password, $username);
        if ($stmt->execute() === false) {
            die('Execute failed: ' . htmlspecialchars($stmt->error));
        }

        $stmt->close();
        return mysqli_insert_id( $this->conn);
    }
    public function delete($user_id)
    {
        $sql = "DELETE FROM user WHERE id = $user_id";
        return mysqli_query($this->conn, $sql);
    }
    public function deleteAll()
    {
        $sql = "DELETE FROM user";
    }

}


