<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
  public function index()
  {
    if ($this->session->logged_in !== true) {
      return redirect()->to(base_url("user/login"));
    }
    $data = [
      "title" => "Dashboard",
      "nama" => $this->session->nama
    ];
    return view("dashboard/index", $data);
  }
  
  public function insert()
  {
    if ($this->session->logged_in !== true) {
      return redirect()->to(base_url("user/login"));
    }
    return view("dashboard/insert", ["title" => "Tambah Catatan Perjalanan"]);
  }
  
  public function view()
  {
    if ($this->session->logged_in !== true) {
      return redirect()->to(base_url("user/login"));
    }
    if (file_exists(WRITEPATH.$this->session->get("nik").".txt")) {
      $data = [
        "notes" => json_decode(file_get_contents(WRITEPATH.$this->session->get("nik").".txt"))
      ];
      if ($this->request->getVar("filter") !== null) {
        array_sort_by_multiple_keys($data["notes"], [
          $this->request->getVar("filter") => SORT_DESC
        ]);
      }
    } else {
      $data = [
        "notes" => "belum ada catatan perjalanan"
      ];
    }
    
    $data["title"] = "Data Perjalanan";
    
    return view("dashboard/view", $data);
  }
  
  public function insert_data()
  {
    if ($this->session->logged_in !== true) {
      return redirect()->to(base_url("user/login"));
    }
    $data = [
      "tanggal" => $this->request->getVar("tanggal"),
      "jam" => $this->request->getVar("jam"),
      "lokasi" => $this->request->getVar("lokasi"),
      "suhu" => $this->request->getVar("suhu")
    ];
    
    if (file_exists(WRITEPATH.$this->session->get("nik").".txt")) {
      $notes = json_decode(file_get_contents(WRITEPATH.$this->session->get("nik").".txt"));
      array_push($notes, $data);
      write_file(WRITEPATH.$this->session->get("nik").".txt", json_encode($notes), "w");
    } else {
      write_file(WRITEPATH.$this->session->get("nik").".txt", json_encode(array($data)), "w");
    }
    return redirect()->to(base_url("dashboard/view"));
  }
}