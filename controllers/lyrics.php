<?php

class Lyrics {
    public function getLyrics() {
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
            $stmt = $conn->query("SELECT * FROM lyrics WHERE user_id = '$user->id'");
            $collections = (object) $stmt->fetchAll(PDO::FETCH_ASSOC);

            response("success", $collections, "Lyrics found successfully");
        } else {
            response("error", [], "Token not found");
        }
    }

    public function newlyric() {
        // POST
        // token
        // collection_id
        // title
        // content
        // youtube_url


        $post = file_get_contents('php://input');
        $post = (object) json_decode($post, true);
        $token = $post->token;
        $db = new Database();
        $conn = $db->conn;

        
        $stmt = $conn->query("SELECT * FROM users WHERE token = '$token'");
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($user)) {
            $user = (object) $user[0];

            try {

                $stmt = $conn->prepare("INSERT INTO lyrics (user_id, collection_id, title, content, youtube_url) VALUES ('$user->id', '$post->collection_id', '$post->title', '$post->content', '$post->youtube_url')");
                $stmt->execute();

                $id = $conn->lastInsertId();
                
                response('success', array('id' => $id), 'Lyric registered successfully');
            } catch (PDOException $e) {
                response('error', [], $e->getMessage());
            }
        } else {
            response("error", [], "Token not found");
        }

    }

    public function getLyricsById() {
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
            $stmt = $conn->query("SELECT * FROM lyrics WHERE user_id = '$user->id' AND id = '$get->id'");
            $collections = (object) $stmt->fetchAll(PDO::FETCH_ASSOC);

            response("success", $collections, "Lyric found successfully");
        } else {
            response("error", [], "Token not found");
        }
    }

    public function getLyricsByCollectionId() {
        // GET
        // token
        // collection_id
        $get = (object) $_GET;
        $db = new Database();
        $conn = $db->conn;
        $token = $get->token;
                
        $stmt = $conn->query("SELECT * FROM users WHERE token = '$token'");
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($user)) {
            $stmt = $conn->query("SELECT * FROM lyrics WHERE collection_id = '$get->collection_id'");
            $collections = (object) $stmt->fetchAll(PDO::FETCH_ASSOC);

            response("success", $collections, "Lyric found successfully");
        } else {
            response("error", [], "Token not found");
        }
    }

    public function getLyricsByName() {
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
            $stmt = $conn->query("SELECT * FROM lyrics WHERE user_id = '$user->id' AND title LIKE '%$get->name%' OR content LIKE '%$get->name%'");
            $collections = (object) $stmt->fetchAll(PDO::FETCH_ASSOC);

            response("success", $collections, "Lyric found successfully");
        } else {
            response("error", [], "Token not found");
        }
    }


    public function updateLyric() {
        // POST
        // token
        // lyric_id
        // collection_id
        // title
        // content
        // youtube_url

        $post = file_get_contents('php://input');
        $post = (object) json_decode($post, true);
        $db = new Database();
        $conn = $db->conn;
        $token = $post->token;

        $stmt = $conn->query("SELECT * FROM users WHERE token = '$token'");
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($user)) {
            $stmt = $conn->prepare("UPDATE lyrics SET collection_id = '$post->collection_id', title = '$post->title', content = '$post->content', youtube_url = '$post->youtube_url' WHERE id = '$post->lyric_id'");
            if($stmt->execute()) {
                response('success', $user, 'Lyric updated successfully');
            }
        }
    }
}