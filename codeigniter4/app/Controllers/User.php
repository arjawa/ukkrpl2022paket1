<?php

namespace App\Controllers;

class User extends BaseController
{
    public function __construct()
    {
      
    }
    
    public function index()
    {
      if ($this->session->logged_in == true) {
        return redirect()->to(base_url("dashboard"));
      } else {
        return redirect()->to(base_url("user/login"));
      }
    }
    
    public function login()
    {
      return view("user/login", ["title" => "Masuk"]);
    }
    
    public function action()
    {
      if ($this->request->getVar("action") == "register") {
        $data = [
          "nik" => $this->request->getVar("nik"),
          "nama" => $this->request->getVar("nama")
        ];
        
        if (empty($data["nik"]) || empty($data["nama"])) {
          return "data nik atau nama tidak boleh kosong";
        }
        
        if (file_exists(WRITEPATH."config.txt")) {
          $users = json_decode(file_get_contents(WRITEPATH."config.txt"));
          array_push($users, $data);
          write_file(WRITEPATH."config.txt", json_encode($users), "w");
        } else {
          write_file(WRITEPATH."config.txt", json_encode(array($data)), "w");
        }
        
        return redirect()->to(base_url("user/login"));
      } else if ($this->request->getVar("action") == "login") {
        $users = json_decode(file_get_contents(WRITEPATH."config.txt"));
        
        foreach ($users as $user) {
          if ($user->nik == $this->request->getVar("nik")) {
            if ($user->nama == $this->request->getVar("nama")) {
              $data = [
                "nik" => $this->request->getVar("nik"),
                "nama" => $this->request->getVar("nama"),
                "logged_in" => true
              ];
              $this->session->set($data);
              return redirect()->to(base_url("dashboard"));
            }
            return "nama tidak sesuai dengan nik";
          }
        }
        
        return "nik tidak terdaftar";
      }
      
    }
    
    public function logout() {
      $this->session->destroy();
      return redirect()->to(base_url("user/login"));
    }
}
