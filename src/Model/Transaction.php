<?php

class Transaction
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAll()
    {
        $query = "SELECT * FROM ticket_transaction";
        $result = mysqli_query($this->conn, $query);

        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;

    }

    public function getById($id)
    {
        $query = "SELECT * FROM ticket_transaction WHERE id LIKE $id";
        $result = mysqli_query($this->conn, $query);
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return json_encode($data);
    }

    public function getByUserId($userId)
    {
        $query = "SELECT * FROM ticket_transaction WHERE user_id LIKE $userId";
        $result = mysqli_query($this->conn, $query);
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return json_encode($data);
    }

    public function create($data): int
    {

        if (isset($data["user_id"]) && isset($data["ticket_id"])) {
            $user_id = $data["user_id"];
            $ticket_id = $data["ticket_id"];

            // Correctly format the SQL query with quotes around string values
            $sql = "INSERT INTO ticket_transaction (user_id, ticket_id) VALUES(?,?)";
            $stmt = mysqli_prepare($this->conn, $sql);

            $stmt->bind_param("ii", $user_id, $ticket_id);

            $stmt->execute();

            return mysqli_insert_id($this->conn);
        }
        return -1;


    }



}


