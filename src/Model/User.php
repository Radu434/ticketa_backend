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
        $tickets = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $tickets[] = $row;
        }
        return json_encode($tickets);
    }

    public function create($data)
    {
        $email = $data["email"];
        $password = $data["password"];
        $username = $data["username"];

        $sql = "INSERT INTO Ticket (email,password,username)  VALUES($email,$password,$username)";
        $result = mysqli_query($this->conn, $sql);

    }
    public function update($ticketId, $data)
    {
        $email = $data["email"];
        $password = $data["password"];
        $username = $data["username"];
        $sql = "UPDATE user SET email = $email,password = $password,username = $username  ";
        mysqli_query($this->conn, $sql);

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


