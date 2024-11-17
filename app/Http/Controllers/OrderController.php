<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddOrderResource;
use Illuminate\Http\Request;
use App\Http\Requests\AddOrderRequest;
use App\Http\Resources\ShowOrdersResource;
use App\Http\Resources\ShowOrdersStoreResource;
use App\Http\Resources\ShowOrderIdResource;   
use App\Models\Order;
use App\Models\Product;

class OrderController extends BaseController
{
    public function addOrder(AddOrderRequest $request)
    {
        foreach ($request->products as $productData) 
        {
            $productId = $productData['product_id'];
            $orderQuantity = $productData['order_quantity'];
            $product = Product::find($productId);
          
            if (!$product) {
                return $this->sendError("Product not found");
            }
            $productQuantity = $product->quantity;
            if ($productQuantity < $orderQuantity) {
                return $this->sendError("The order quantity for product ID {$productId} exceeds the available quantity.");
            } 
        }
        $order = Order::create([
            'pharmacist_id' => $request->pharmacist_id,
            'store_id' => $request-> store_id, 
            'order_status' => 'in preparation', 
            'payment_status' => 'unpaid', 
            ]);
            foreach ($request->products as $productData) {
                $productId = $productData['product_id'];
                $orderQuantity = $productData['order_quantity'];
                $product = Product::find($productId);
                $order->products()->attach($product, ['orderQuantity' => $orderQuantity]);
            }
            
            $addOrder= new AddOrderResource($order);  
            return $this->sendResponse($addOrder, "done");
    }

    public function getOrdersByPharmacist(Request $request)
    {
        $orders= Order::where("pharmacist_id", $request->pharmacist_id)->get();
        if( $orders->isEmpty()){
            return $this->sendError("Not Found Orders");
        }
        foreach($orders as $order){
            $order->products();
            $resourceorder[]=new ShowOrdersResource($order);
        }
        return $this->sendResponse($resourceorder,"orders list");
    }
    public function getOrderByStore(Request $request)
    {
        $orders= Order::where("store_id", $request->store_id)->get();
        if($orders->isEmpty()){
            return $this->sendError("Not Found order");
        }
        foreach($orders as $order){
            $resourceorder[]=new ShowOrdersStoreResource($order);
        }
        return $this->sendResponse($resourceorder,"orders list");

    }

    public function getOrdersById(Request $request)
    {
        $order = Order::find($request->order_id);
    
        if (!$order) {
            return $this->sendError("Order not found");
        } 
    
        return $this->sendResponse(new ShowOrderIdResource($order), "Orders list");
    }

    public function editStatuse(Request $request)
{
    $order = Order::find($request->order_id);
    if(!$order)
    {
        return $this->sendError("this order not found");
    }
    $order_status = $request->order_status;
    $previous_status = $order->order_status;
    $message = [];
    if ($order_status) {
        if ($order_status == $previous_status)
        {
            $message[] = "There is nothing to modify in order_status";
        }
        else
        {
            $order->order_status = $order_status;
            $order->save();

            if ($order_status == "has been sent")
            {
                $productArray = $order->products;
                foreach ($productArray as $productItem)
                {
                    $productId = $productItem['id'];
                    $orderQuantity = $productItem->pivot->orderQuantity;
                    $product = Product::find($productId);
                    $quantityProduct = $product->quantity;
                    $sub = $quantityProduct - $orderQuantity;
                    $product->quantity = $sub;
                    $product->save();
                }
            }

            $message[] = "Order Status Edited successfully";
        }
    }

    if ($request->payment_status)
    {
        if ($order->payment_status != $request->payment_status)
        {
            $order->payment_status = $request->payment_status;
            $order->save();
            $message[] = "Payment Status Edited successfully";
        }
        else
        {
            $message[] = "There is nothing to modify in payment_status";
        }
    }
    return $this->sendResponse($order, $message);
}


}


