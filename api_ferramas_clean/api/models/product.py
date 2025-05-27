class Product:
    def __init__(self, id, nombre_producto, marca, price, fecha_registro, categoria):
        self.id = id
        self.nombre_producto = nombre_producto
        self.marca = marca
        self.price = price
        self.fecha_registro = fecha_registro
        self.categoria = categoria

    def to_dict(self):
        return {
            "ID": self.id,
            "NOMBRE_PRODUCTO": self.nombre_producto,
            "MARCA": self.marca,
            "PRICE": self.price,
            "FECHA_REGISTRO": self.fecha_registro,
            "CATEGORIA": self.categoria
        }
