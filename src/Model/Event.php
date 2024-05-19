<?php

class Event
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAll()
    {
        $query = "SELECT * FROM event";
        $result = mysqli_query($this->conn, $query);

        $events = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $events[] = $row;
        }
        return json_encode($events);

    }

    public function getById($event_id)
    {
        $query = "SELECT * FROM event WHERE id LIKE $event_id";
        $result = mysqli_query($this->conn, $query);
        $tickets = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $tickets[] = $row;
        }
        return json_encode($tickets);
    }

    public function create($data)
    {
        $name = $data["name"];
        $location = $data["location"];
        $date = $data["date"];
        $description = $data["description"];
        $photo = $data["photo"];
        
        $sql = "INSERT INTO event (name,location,date,description,photo)  VALUES('$name','$location','$date','$description','$photo')";
        echo $sql;
        $result = mysqli_query($this->conn, $sql);

        return mysqli_insert_id($this->conn) ;



    }
    public function update($ticketId, $data)
    {
        $current = $this->getById($ticketId);


        $sql = "UPDATE event SET name = ?, location = ?, date = ?, description = ?, photo = ? WHERE id = ?";
        

        $stmt = mysqli_prepare($this->conn,$sql);
        

        $name = $data["name"] ?? $current["name"];
        $location = $data["location"] ?? $current["location"];
        $date = $data["date"] ?? $current["date"];
        $description = $data["description"] ?? $current["description"];
        $photo = $data["photo"] ?? $current["photo"];
        $id = (int)$ticketId;
        
        $stmt->bind_param('sssssi', $name, $location, $date, $description, $photo, $id);
        
        if ($stmt->execute() === false) {
            die('Execute failed: ' . htmlspecialchars($stmt->error));
        } else {
            echo 'Update successful!';
        }
        
        $stmt->close();


    }
    public function delete($event_id)
    {
        $sql = "DELETE FROM event WHERE id = $event_id";
        return mysqli_query($this->conn, $sql);
    }
    public function deleteAll()
    {
        $sql = "DELETE FROM event";
    }

}


