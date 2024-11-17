<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Http\Requests\PharmacyRequest;
use  App\Http\Requests\PharmacyLoginRequest;
use App\Http\Requests\AddProductRequest;
use  App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\DeleteProductRequest; 
use  App\Models\User;
use  App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use  App\Http\Controllers\BaseController;
use App\Http\Resources\PharmacyResource;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class DashboardController extends BaseController
{

    public function login(PharmacyLoginRequest $request)
     { 
        $dataRequest=$request->only('phone','password');
        if(!auth()->attempt($dataRequest)){
            return $this->sendError("this data is false");
        }
        $user = User::where('phone', $request->phone)->first();
        if(!Hash::check($request->password, $user->password)){
            return $this->sendError("this data is false");     
        }
        $accessToken = $user->createToken('authToken')->accessToken;
        $data['token'] = $accessToken;
        $data['token_type']= 'Bearer';
        $data['user'] = new PharmacyResource($user);
        return $this->sendResponse($data, "Login successfully");
    }
    public function storeProduct(AddProductRequest $request )
    {
            $image = $request->file('image');
            $imagePath = public_path('images'); 
            $imageName = time() . '_' . $image->getClientOriginalName(); 
            $image->move($imagePath, $imageName); 
        $product = new Product($request->all()); 
        $product->img_path = 'images/' . $imageName;

        $product->save();
        return $this->sendResponse($product, "Added successfully");
    }
    public function editProduct(UpdateProductRequest $request)
    {
        if($request->hasFile("image")){
            $image = $request->file('image');
            $imagePath = public_path('images'); 
            $imageName = time() . '_' . $image->getClientOriginalName(); 
            $image->move($imagePath, $imageName); 
            $thisImage = 'images/' . $imageName;
        }
        else{
            $product = Product::find($request->product_id);
            $thisImage=$product->img_path;
        }
        Product::where('id', $request->product_id)->update([
           'img_path'=>$thisImage,
           'scientific_name'=>$request->scientific_name,
           'commercial_name'=>$request->commercial_name,
           'manufacturer'=>$request->manufacturer,
           'price'=>$request->price,
           'quantity'=>$request->quantity,
          'expiration_date'=>$request->expiration_date,
          'category_id'=>$request->category_id,
        ]);
       
    return $this->sendResponse(null, "Edited successfully");
}

public function deleteProduct(DeleteProductRequest $request)
{
    $product = Product::where('id', $request->product_id)->first();
    if (!$product) {
        return "Product not found";
    }
    $product->delete();
    return $this->sendResponse(null, "delete done");

}
public function getProduct(Request $request)
{
   
    $product = Product::find($request->product_id);

    if (!$product) {
        return "Product not found";
    }
    $category_id = $product->category_id;
    $category=Category::find($category_id);
    $product->category_name = $category->name;
    return $this->sendResponse($product, "Product:");
}

public function generateReport(Request $request)
{
    $store_id= $request->store_id;
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');

    $data=[];
    $sales = Order::whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
                   ->where('order_status', 'has been arrived')
                   ->where('store_id',$store_id)
                   ->get();

    $orders = Order::whereBetween('created_at', [$start_date, $end_date])
                   ->where('order_status', '!=', 'has been arrived')
                   ->where('store_id',$store_id)
                   ->get();
    if(empty($sales))
    {
        $data[]="sales report:";
   // echo"sales report:\n";
    foreach ($sales as $sale) {
        $data[]= "Order Id : " . $sale->id . ", Order amount: " . $sale->products ;
        //echo "Order Id : " . $sale->id . ", Order amount: " . $sale->products . "\n";
    }
    }
    else
    {
        $data[]="No sales :";
        //echo "No sales\n";
    }
    if($orders)
    {
        $data[]= "orders report :";
    //echo "orders report\n";
    foreach ($orders as $order) {
        $data[]= "Order Id : " . $order->id . ",Order amount: " . $order->products ;
        //echo "Order Id : " . $order->id . ",Order amount: " . $order->products . "\n";
    }
   }
   else
   {
    $data[]= "No orders :";
    //echo "No orders\n"; 
}
return $this->sendResponse($data,"");
}
}