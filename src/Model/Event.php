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
        $image = $data["image"];


        $sql = "INSERT INTO event (name,location,date,description,image)  VALUES($name,$location,$date,$description,$image)";
        $result = mysqli_query($this->conn, $sql);

    }
    public function update($ticketId, $data)
    {
        $name = $data["name"];
        $location = $data["location"];
        $date = $data["date"];
        $description = $data["description"];
        $image = $data["image"];
        $sql = "UPDATE event SET name = $name,location=$location,date=$date,description=$description,image=$image ";
        mysqli_query($this->conn, $sql);

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


