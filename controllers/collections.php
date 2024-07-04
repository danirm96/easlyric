<?php

class Collections {
    public function getCollections() {

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
            $stmt = $conn->query("SELECT * FROM collections WHERE user_id = '$user->id'");
            $collections = (object) $stmt->fetchAll(PDO::FETCH_ASSOC);

            response("success", $collections, "Collections found successfully");
        } else {
            response("error", [], "Token not found");
        }
    }

    public function newCollection() {

        // POST
        // name
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

            $name = $post->name;
            $tags = $post->tags;

            try {

                $stmt = $conn->prepare("INSERT INTO collections (user_id, tags, name) VALUES ('$user->id', '$post->name', '$post->tags')");
                $stmt->execute();

                $id = $conn->lastInsertId();
                
                response('success', array('id' => $id), 'Collection registered successfully');
            } catch (PDOException $e) {
                response('error', [], $e->getMessage());
            }
        } else {
            response("error", [], "Token not found");
        }

    }

    public function getCollectionById() {
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
            $stmt = $conn->query("SELECT * FROM collections WHERE user_id = '$user->id' AND id = '$get->id'");
            $collections = (object) $stmt->fetchAll(PDO::FETCH_ASSOC);

            response("success", $collections, "Collections found successfully");
        } else {
            response("error", [], "Token not found");
        }
    }

    public function getCollectionByNameAndTag() {
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
            $stmt = $conn->query("SELECT * FROM collections WHERE user_id = '$user->id' AND name LIKE '%$get->name%' OR tags LIKE '%$get->name%'");
            $collections = (object) $stmt->fetchAll(PDO::FETCH_ASSOC);

            response("success", $collections, "Collections found successfully");
        } else {
            response("error", [], "Token not found");
        }
    }
    
    public function updateCollection() {

        // POST
        // token
        // tags
        // name
        // id
        $post = file_get_contents('php://input');
        $post = (object) json_decode($post, true);

        // e($post);
        $db = new Database();
        $conn = $db->conn;
        $token = $post->token;

        $stmt = $conn->query("SELECT * FROM users WHERE token = '$token'");
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($user)) {
            $datetime = date('Y-m-d H:i:s');
            $stmt = $conn->prepare("UPDATE collections SET tags = '$post->tags', name = '$post->name', updated_at = '$datetime' WHERE id = '$post->id'");
            if($stmt->execute()) {
                response('success', [], 'Collection updated successfully');
            }
        }
    }
}