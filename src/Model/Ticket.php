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

        if (isset($data["event_id"]) && isset($data["price"]) && isset($data["user_id"])) {
            $event_id = $data["event_id"];
            $price = $data["price"];
            $ticket_sql = "INSERT INTO ticket (event_id, price)  VALUES($event_id,$price)";
            $result = mysqli_query($this->conn, $ticket_sql);
            if ($result) {
                $last_ticket_id = mysqli_insert_id($this->conn);
                $user_id = $data["user_id"];
                $transaction_sql = "INSERT INTO ticket_transaction (user_id, ticket_id)  VALUES($user_id,$last_ticket_id)";
                $result = mysqli_query($this->conn, $transaction_sql);
                return $result;
            }
        }
        return http_response_code(403);
       

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


