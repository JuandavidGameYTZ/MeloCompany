from flask import Flask, render_template, request, redirect, url_for
import pyodbc

app = Flask(__name__)

def conectar_bd():
    return pyodbc.connect(
        'DRIVER={ODBC Driver 17 for SQL Server};'
        'SERVER=localhost;'
        'DATABASE=melo;'
        'Trusted_Connection=yes;'
    )

@app.route('/')
def login():
    return render_template('login.html')

@app.route('/iniciar_sesion', methods=['POST'])
def iniciar_sesion():
    usuario = request.form['usuario']
    contrasena = request.form['contrasena']

    conn = conectar_bd()
    cursor = conn.cursor()
    cursor.execute("SELECT * FROM InicioSesion WHERE NombreUsuario=? AND Contrasena=?", (usuario, contrasena))
    resultado = cursor.fetchone()
    conn.close()

    if resultado:
        return f"Bienvenido {usuario}"
    else:
        return "Usuario o contraseña incorrectos"

@app.route('/registro')
def registro():
    return render_template('register.html')

@app.route('/registrarse', methods=['POST'])
def registrarse():
    usuario = request.form['usuario']
    correo = request.form['correo']
    contrasena = request.form['contrasena']

    conn = conectar_bd()
    cursor = conn.cursor()

    # Validar si el usuario ya existe
    cursor.execute("SELECT * FROM InicioSesion WHERE NombreUsuario=? OR CorreoElectronico=?", (usuario, correo))
    if cursor.fetchone():
        return "Ya existe un usuario con ese nombre o correo"

    # Insertar nuevo usuario
    cursor.execute("INSERT INTO InicioSesion (NombreUsuario, CorreoElectronico, Contrasena) VALUES (?, ?, ?)",
                   (usuario, correo, contrasena))
    conn.commit()
    conn.close()

    return redirect(url_for('login'))

if __name__ == '__main__':
    app.run(debug=True)
