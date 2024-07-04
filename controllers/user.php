<?php

class User {
    public function login() {
        
        // GET
        // email
        // password
        $get = (object) $_GET;

        if (isset($get->email)) {
            $email = $get->email;
            $password = md5($get->password);
            $db = new Database();
            $conn = $db->conn;  

            $stmt = $conn->query("SELECT * FROM users WHERE email = '$email' AND password = '$password'");
            $user = (object) $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

            // e($user->id);

            // generate token 
            $token = bin2hex(openssl_random_pseudo_bytes(16));
            $user->token = $token;

            $stmt = $conn->prepare("UPDATE users SET token = '$token' WHERE id = '$user->id'");
            if($stmt->execute()) {
                response('success', $user, 'User registered successfully');
            }
            
        }
    }

    public function register() {
        
        // POST
        // username
        // email
        // password
        $post = file_get_contents('php://input');
        $post = (object) json_decode($post, true);

        $db = new Database();
        $conn = $db->conn;

        $post->password = md5($post->password);

        $stmt = $conn->query("SELECT * FROM users WHERE email = '$post->email'");
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($user)) {
            response('error', [], 'Email already exists');
            die();
        }


        try {

            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES ('$post->username', '$post->email', '$post->password')");
            $stmt->execute();
            
            response('success', [], 'User registered successfully');
        } catch (PDOException $e) {
            response('error', [], $e->getMessage());
        }
    }

    public function getUserById() {
        // GET
        // id
        $get = (object) $_GET;

        $token = $get->token;
        $db = new Database();
        $conn = $db->conn;
        $stmt = $conn->query("SELECT * FROM users WHERE token = '$get->token'");
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);


        if(!empty($user)) {
            $userId = $get->id;

            $db = new Database();
            $conn = $db->conn;
    
            $stmt = $conn->query("SELECT * FROM users WHERE id = '$get->id'");
            $user = (object) $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
    
            response("success", $user, "User found successfully");
        } else {
            response("error", [], "Token not found");
        }



    }

    public function getUsers() {
        // GET
        // token
        $get = (object) $_GET;
        $token = $get->token;
        $db = new Database();
        $conn = $db->conn;

        
        $stmt = $conn->query("SELECT * FROM users WHERE token = '$token'");
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($user)) {
            $stmt = $conn->query("SELECT * FROM users");
            $user = (object) $stmt->fetchAll(PDO::FETCH_ASSOC);

            response("success", $user, "Users found successfully");
        } else {
            response("error", [], "Token not found");
        }

    }
}