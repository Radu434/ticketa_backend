<?php

class Ticket
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAll()
    {
        $query = "SELECT * FROM ticket";
        $result = mysqli_query($this->conn, $query);

        $tickets = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $tickets[] = $row;
        }
        return $tickets;

    }

    public function getById($ticketId)
    {
        $query = "SELECT * FROM ticket WHERE id LIKE $ticketId";
        $result = mysqli_query($this->conn, $query);
        $tickets = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $tickets[] = $row;
        }
        return json_encode($tickets);
    }

    public function getByEvent($eventId)
    {
        $query = "SELECT * FROM ticket WHERE event_id LIKE $eventId";
        $result = mysqli_query($this->conn, $query);
        $tickets = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $tickets[] = $row;
        }
        return json_encode($tickets);
    }

    public function create($data): int
    {

        if (isset($data["event_id"]) && isset($data["price"])) {
            $event_id = $data["event_id"];
            $price = $data["price"];
            $type = $data["type"];

            // Correctly format the SQL query with quotes around string values
            $sql = "INSERT INTO ticket (event_id, price, type) VALUES(?,?,?)";
            $stmt = mysqli_prepare($this->conn, $sql);

            $stmt->bind_param("ids", $event_id,$price, $type);
        
            $stmt->execute();

            return mysqli_insert_id( $this->conn);
        }
        return -1;
       

    }
    public function getByUserId($user_id)
    {
        $query = "SELECT ticket.* FROM ticket JOIN ticket_transaction ON ticket.id LIKE ticket_transaction.ticket_id
         JOIN user ON ticket_transaction.user_id LIKE user.id WHERE user.id=$user_id";
        $result = mysqli_query($this->conn, $query);
        $tickets = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $tickets[] = $row;
        }
        return json_encode($tickets);

    }
    public function update($ticketId, $data)
    {
        $event_id = $data["event_id"];
        $price = $data["price"];
        $sql = "UPDATE ticket SET event_id = $event_id, price = $price WHERE id = $ticketId";
        mysqli_query($this->conn, $sql);

    }
    public function delete($ticketId)
    {
        $sql = "DELETE FROM ticket WHERE id = $ticketId";
        return mysqli_query($this->conn, $sql);
    }
    public function deleteAll()
    {
        $sql = "DELETE FROM ticket";
    }

}


