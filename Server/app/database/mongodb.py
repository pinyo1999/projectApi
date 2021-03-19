import pymongo

from model.order import createOrderModel, updateOrderModel


class MongoDB:
    def __init__(self, host, port, user, password, auth_db, db, collection):
        self.host = host
        self.port = port
        self.user = user
        self.password = password
        self.auth_db = auth_db
        self.db = db
        self.collection = collection
        self.connection = None

    def _connect(self):
        print(self.host)
        client = pymongo.MongoClient(
            host=self.host,
            port=self.port,
            username=self.user,
            password=self.password,
            authSource=self.auth_db,
            authMechanism="SCRAM-SHA-1",
        )
        db = client[self.db]
        self.connection = db[self.collection]
        print(self.connection)

    def find(self, sort_by, order):
        mongo_results = self.connection.find({})
        if sort_by is not None and order is not None:
            mongo_results.sort(sort_by, self._get_sort_by(order))

        return list(mongo_results)

    def _get_sort_by(self, sort: str) -> int:
        return pymongo.DESCENDING if sort == "desc" else pymongo.ASCENDING

    def find_one(self, order_id):
        return self.connection.find_one({"_id": order_id})

    def create(self, order: createOrderModel):
        order_dict = order.dict(exclude_unset=True)

        insert_dict = {**order_dict, "_id": order_dict["id"]}

        inserted_result = self.connection.insert_one(insert_dict)
        order_id = str(inserted_result.inserted_id)

        return order_id

    def update(self, order_id, order: updateOrderModel):
        updated_result = self.connection.update_one(
            {"id": order_id}, {"$set": order.dict(exclude_unset=True)}
        )
        return [order_id, updated_result.modified_count]

    def delete(self, order_id):
        deleted_result = self.connection.delete_one({"id": order_id})
        return [order_id, deleted_result.deleted_count]
