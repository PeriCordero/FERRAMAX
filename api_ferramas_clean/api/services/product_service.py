from api.models.product import Product

class ProductService:
    def __init__(self, mysql):
        self.mysql = mysql

    def get_all_products(self):
        cursor = self.mysql.connection.cursor()
        cursor.execute("SELECT ID, NOMBRE_PRODUCTO, MARCA, PRICE, FECHA_REGISTRO, CATEGORIA FROM PRODUCTOS")
        results = cursor.fetchall()

        products = [
            Product(
                id=row[0],
                nombre_producto=row[1],
                marca=row[2],
                price=float(row[3]),
                fecha_registro=str(row[4]),
                categoria=row[5]
            ).to_dict()
            for row in results
        ]

        return products
