#!/usr/bin/env python3

from flask import Flask, render_template, json, request, redirect, session
import os.path

app = Flask(__name__)
app.secret_key = "ukkrpl1"

# halaman utama
@app.route("/")
def login():
  data = {
    "title": "Login"
  }
  # render halaman login
  return render_template("user/login.html", data=data)

# login handler
@app.route("/user/action", methods=["POST"])
def action():
  # mengambil data dari form login
  nik = request.form["nik"]
  nama = request.form["nama"]
  action = request.form["action"]
  
  # cek apakah input kosong
  if (nik == "" or nama == ""):
    return "nik atau nama tidak boleh kosong"
  
  # registrasi user
  if (action == "register"):
    # jika file config.txt ada
    if (os.path.isfile("static/config.txt")):
      entry = {"nik": nik, "nama": nama}
      with open("static/config.txt", "r+") as config:
        data = json.load(config)
        data.append(entry)
        config.seek(0)
        json.dump(data, config)
        config.truncate()
      return "data user tersimpan"
    # jika file config.txt tidak ada
    else:
      entry = [{"nik": nik, "nama": nama}]
      with open("static/config.txt", "w") as config:
        json.dump(entry, config)
      return "data user tersimpan"
  # login user
  elif (action == "login"):
    with open("static/config.txt") as users:
      # cek setiap data dari config.txt dengan for loop
      for user in json.load(users):
        if (user["nik"] == nik):
          if (user["nama"] == nama):
            # set session
            session["nik"] = nik
            session["nama"] = nama
            session["logged_in"] = True
            return redirect("/dashboard")
          return "nama tidak sesuai dengan nik"
      return "nik belum terdaftar"

# logout handler
@app.route("/logout")
def logout():
  session.clear()
  return redirect("/")
  

# halaman dashboard
@app.route("/dashboard")
def dashboard():
  # cek jika session ada dan session valid
  if (session and session["logged_in"] == True):
    data = {
      "title": "Dashboard",
      "nama": session["nama"]
    }
    return render_template("dashboard/index.html", data=data)
  return redirect("/")

# halaman tambah data perjalanan
@app.route("/dashboard/insert")
def insert():
  # cek jika session ada dan session valid
  if (session and session["logged_in"] == True):
    data = {
      "title": "Dashboard"
    }
    return render_template("dashboard/insert.html", data=data)
  return redirect("/")

# insert data handler
@app.route("/dashboard/insert_data", methods=["POST"])
def insert_data():
  # cek jika session ada dan session valid
  if (session and session["logged_in"] == True):
    # mengambil data dari form tambah data perjalanan
    tanggal = request.form["tanggal"]
    jam = request.form["jam"]
    lokasi = request.form["lokasi"]
    suhu = request.form["suhu"]
    
    # cek jika file data perjalanan.txt ada
    if (os.path.isfile(f"static/{session['nik']}.txt")):
      entry = {"tanggal": tanggal, "jam": jam, "lokasi": lokasi, "suhu": suhu}
      with open(f"static/{session['nik']}.txt", "r+") as notes:
        data = json.load(notes)
        data.append(entry)
        notes.seek(0)
        json.dump(data, notes)
        notes.truncate()
      return "catatan tersimpan"
    # jika file data perjalanan.txt tidak ada
    else:
      entry = [{"tanggal": tanggal, "jam": jam, "lokasi": lokasi, "suhu": suhu}]
      with open(f"static/{session['nik']}.txt", "w") as notes:
        json.dump(entry, notes)
      return "catatan tersimpan"
  return redirect("/")

# halaman dashboard
@app.route("/dashboard/view")
def view():
  # cek jika session ada dan session valid
  if (session and session["logged_in"] == True):
    # jika file data perjalanan.txt ada
    if (os.path.isfile(f"static/{session['nik']}.txt")):
      notes = json.load(open(f"static/{session['nik']}.txt"))
    #jika file data perjalanan tidak ada
    else:
      notes = "belum ada catatan yang tersimpan"
    data = {
      "title": "Dashboard",
      "notes": notes
    }
    # filter data menggunakan array sort dan lambda secara descending
    if (request.args.get("filter") == "suhu"):
      data["notes"].sort(key=lambda x: x["suhu"], reverse=True)
    elif (request.args.get("filter") == "tanggal"):
      data["notes"].sort(key=lambda x: x["tanggal"], reverse=True)
    return render_template("dashboard/view.html", data=data)
  return redirect("/")
  
if __name__ == "__main__":
  app.run(debug = True)
