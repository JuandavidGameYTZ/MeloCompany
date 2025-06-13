import pyodbc

def conectar_bd():
    conexion = pyodbc.connect(
        'DRIVER={ODBC Driver 17 for SQL Server};'
        'SERVER=localhost;'
        'DATABASE=melo;'
        'Trusted_Connection=yes;'
    )
    return conexion
