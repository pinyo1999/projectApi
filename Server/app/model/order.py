from typing import Optional, List
from pydantic import BaseModel, Field


class createOrderModel(BaseModel):
    id: str = Field(min_length=4, max_length=4)
    no: int
    quantity: int
    price: float
    detail_order: List[dict]
    status: str


class updateOrderModel(BaseModel):
    no: Optional[int]
    quantity: Optional[int]
    price: Optional[float]
    detail_order: Optional[List[dict]]
    status: Optional[str]
