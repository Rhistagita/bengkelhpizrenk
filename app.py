from flask import Flask, render_template, request, redirect, url_for
import sqlite3

app = Flask(__name__)

def init_db():
    conn = sqlite3.connect('database.db')
    c = conn.cursor()
    c.execute('''CREATE TABLE IF NOT EXISTS jasa (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    nama TEXT,
                    keluhan TEXT,
                    harga INTEGER
                )''')
    c.execute('''CREATE TABLE IF NOT EXISTS buku_kas (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    nama TEXT,
                    jumlah INTEGER
                )''')
    conn.commit()
    conn.close()

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/pemilik')
def pemilik():
    conn = sqlite3.connect('database.db')
    c = conn.cursor()
    c.execute("SELECT * FROM jasa")
    jasa_data = c.fetchall()
    c.execute("SELECT * FROM buku_kas")
    buku_kas_data = c.fetchall()
    conn.close()
    return render_template('pemilik.html', jasa=jasa_data, buku_kas=buku_kas_data)

@app.route('/karyawan')
def karyawan():
    return render_template('karyawan.html')

@app.route('/tambah_jasa', methods=['POST'])
def tambah_jasa():
    nama = request.form['nama']
    keluhan = request.form['keluhan']
    harga = request.form['harga']
    
    conn = sqlite3.connect('database.db')
    c = conn.cursor()
    c.execute("INSERT INTO jasa (nama, keluhan, harga) VALUES (?, ?, ?)", (nama, keluhan, harga))
    conn.commit()
    conn.close()
    return redirect(url_for('karyawan'))

@app.route('/tambah_pinjaman', methods=['POST'])
def tambah_pinjaman():
    nama = request.form['nama']
    jumlah = request.form['jumlah']
    
    conn = sqlite3.connect('database.db')
    c = conn.cursor()
    c.execute("INSERT INTO buku_kas (nama, jumlah) VALUES (?, ?)", (nama, jumlah))
    conn.commit()
    conn.close()
    return redirect(url_for('karyawan'))

if __name__ == '__main__':
    init_db()
    app.run(debug=True, port=5500)
