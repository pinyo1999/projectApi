import uvicorn
from fastapi import FastAPI, Path, Query, HTTPException
from starlette.responses import JSONResponse
from typing import Optional
from fastapi.middleware.cors import CORSMiddleware

from database.mongodb import MongoDB
from config.development import config
from model.order import createOrderModel, updateOrderModel


print("config", config)
print("------------")

# ให้ตัวแปร mongo_config เก็บค่า dict ของ config ที่ mongo_config
mongo_config = config["mongo_config"]

print("mongo_config", mongo_config)


mongo_db = MongoDB(
    mongo_config["host"],
    mongo_config["port"],
    mongo_config["user"],
    mongo_config["password"],
    mongo_config["auth_db"],
    mongo_config["db"],
    mongo_config["collection"],
)
mongo_db._connect()


app = FastAPI()

# ตรวจสอบการเข้าถึงว่าจะให้ใครเข้ามาได้บ้าง
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)


@app.get("/")
def index():
    return JSONResponse(content={"message": "Connected 2"}, status_code=200)


@app.get("/detail/")
def get_order(
    sort_by: Optional[str] = None,
    order: Optional[str] = Query(None, min_length=3, max_length=4),
):
    try:
        # calling function "find" from mongodb.py
        result = mongo_db.find(sort_by, order)
    except:
        raise HTTPException(status_code=500, detail="Something went wrong !!")

    return JSONResponse(
        content={"status": "OK", "data": result},
        status_code=200,
    )


@app.get("/detail/{order_id}")
def get_order_by_id(order_id: str = Path(None, min_length=4, max_length=4)):
    try:
        result = mongo_db.find_one(order_id)
    except:
        raise HTTPException(status_code=500, detail="Something went wrong !!")

    if result is None:
        raise HTTPException(status_code=404, detail="Order Id not found !!")

    return JSONResponse(
        content={"status": "OK", "data": result},
        status_code=200,
    )


@app.post("/detail")
def create_books(order: createOrderModel):
    try:
        order_id = mongo_db.create(order)
    except:
        raise HTTPException(status_code=500, detail="Something went wrong !!")

    return JSONResponse(
        content={
            "status": "ok",
            "data": {
                "order_id": order_id,
            },
        },
        status_code=201,
    )


@app.patch("/detail/{order_id}")
def update_books(
    order: updateOrderModel,
    order_id: str = Path(None, min_length=4, max_length=4),
):
    print("order", order)
    try:
        updated_order_id, modified_count = mongo_db.update(order_id, order)
    except:
        raise HTTPException(status_code=500, detail="Something went wrong !!")

    if modified_count == 0:
        raise HTTPException(
            status_code=404,
            detail=f"order Id: {updated_order_id} is not update want fields",
        )

    return JSONResponse(
        content={
            "status": "ok",
            "data": {
                "order_id": updated_order_id,
                "modified_count": modified_count,
            },
        },
        status_code=200,
    )


@app.delete("/detail/{order_id}")
def delete_book_by_id(order_id: str = Path(None, min_length=4, max_length=4)):
    try:
        deleted_order_id, deleted_count = mongo_db.delete(order_id)
    except:
        raise HTTPException(status_code=500, detail="Something went wrong !!")

    if deleted_count == 0:
        raise HTTPException(
            status_code=404, detail=f"Order Id: {deleted_order_id} is not Delete"
        )

    return JSONResponse(
        content={
            "status": "ok",
            "data": {
                "order_id": deleted_order_id,
                "deleted_count": deleted_count,
            },
        },
        status_code=200,
    )


if __name__ == "__main__":
    uvicorn.run("main:app", host="127.0.0.1", port=3000, reload=True)