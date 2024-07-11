<?php

class Beats {
    public function newBeat() {

        // POST
        // title
        // youtube_url
        // tags
        $post = file_get_contents('php://input');
        $post = (object) json_decode($post, true);
        $token = $post->token;
        $db = new Database();
        $conn = $db->conn;

        
        $stmt = $conn->query("SELECT * FROM users WHERE token = '$token'");
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($user)) {
            $user = (object) $user[0];

            // e($user);

            $name = $post->title;
            $youtube_url = $post->youtube_url;
            $tags = $post->tags;

            try {

                $stmt = $conn->prepare("INSERT INTO beats (user_id, title, youtube_url, tags) VALUES ('$user->id', '$name', '$youtube_url', '$tags')");
                $stmt->execute();

                $id = $conn->lastInsertId();
                
                response('success', array('id' => $id), 'Beat registered successfully');
            } catch (PDOException $e) {
                response('error', [], $e->getMessage());
            }
        } else {
            response("error", [], "Token not found");
        }
    }

    public function getBeats() {

        // GET
        // token
        $get = (object) $_GET;
        $db = new Database();
        $conn = $db->conn;
        $token = $get->token;
                
        $stmt = $conn->query("SELECT * FROM users WHERE token = '$token'");
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($user)) {
            $user = (object) $user[0];
            $stmt = $conn->query("SELECT * FROM beats WHERE user_id = '$user->id'");
            $collections = (object) $stmt->fetchAll(PDO::FETCH_ASSOC);

            response("success", $collections, "Beats found successfully");
        } else {
            response("error", [], "Token not found");
        }
    }

    public function getAllBeats() {

        // GET
        // token
        $get = (object) $_GET;
        $db = new Database();
        $conn = $db->conn;
        $token = $get->token;
                
        $stmt = $conn->query("SELECT * FROM users WHERE token = '$token'");
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($user)) {
            $user = (object) $user[0];
            $stmt = $conn->query("SELECT * FROM beats");
            $collections = (object) $stmt->fetchAll(PDO::FETCH_ASSOC);

            response("success", $collections, "Beats found successfully");
        } else {
            response("error", [], "Token not found");
        }
    }

    
    public function getBeatByNameAndTag() {
        // GET
        // token
        // name
        $get = (object) $_GET;
        $db = new Database();
        $conn = $db->conn;
        $token = $get->token;
                
        $stmt = $conn->query("SELECT * FROM users WHERE token = '$token'");
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($user)) {
            $user = (object) $user[0];
            $stmt = $conn->query("SELECT * FROM beats WHERE user_id = '$user->id' AND tags LIKE '%$get->name%'");
            $collections = (object) $stmt->fetchAll(PDO::FETCH_ASSOC);

            response("success", $collections, "Collections found successfully");
        } else {
            response("error", [], "Token not found");
        }
    }

            
    public function deleteBeatById() {
        // GET
        // token
        // id
        $get = (object) $_GET;
        $db = new Database();
        $conn = $db->conn;
        $token = $get->token;
                
        $stmt = $conn->query("SELECT * FROM users WHERE token = '$token'");
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($user)) {
            $user = (object) $user[0];
            $stmt = $conn->query("DELETE FROM beats WHERE id = '$get->id'");
            $collections = (object) $stmt->fetchAll(PDO::FETCH_ASSOC);

            response("success", $collections, "Beat delete successfully");
        } else {
            response("error", [], "Token not found");
        }
    }
}