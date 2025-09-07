<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class CategoryController extends Controller
{


    public function store(Request $request){


      
        if ($request->hasFile('categoryImage')) {
          
            $image = $request->file('categoryImage');
            $imagePath= $image->store('categories', 'public'); 
        }



        $category=Category::create([

            'categoryName'=>$request->categoryName,
            'categoryDescription'=>$request->categoryDescription,
            'categoryImage'=>$imagePath

        ]);


        return response()->json([

            "status"=>"success",
            "message"=>"category created successfully",
            "data"=>$category

        ],201);





    }




    public  function index(Request $request){


        $per_page=$request->query("per_page",4);



        $categories=Category::paginate($per_page);

        return response()->json([

            "status"=>"success",
            "message"=>"categories retrieved successfully",
            "data"=>$categories

        ],200);




    }


    public function show($slug){



        $category=Category::where("categorySlug",$slug)->first();


        if ($category) {
            
            
        return response()->json([

            "status"=>"success",
            "message"=>"category retrieved successfully",
            "data"=>$category

        ],200);

        }

       else{

        return response()->json([

            "status"=>"error",
            "message"=>"category not found"

        ],404);

       }






    }
    




    public function update(Request $request,$slug){



        $category=Category::where("categorySlug",$slug)->first();


        


            $category->categoryName = $request->categoryName;
            $category->categorySlug = Str::slug($request->categoryName); 
            $category->categoryDescription = $request->categoryDescription;
            if ($request->hasFile('categoryImage')) {

                if ($category->categoryImage) {
                    Storage::disk('public')->delete($category->categoryImage); // this for deleting the old image
                }

                $image = $request->file('categoryImage');
                $imagePath= $image->store('categories', 'public'); 
                $category->categoryImage = $imagePath;
            }

            $category->save();


            return response()->json([
                'message' => 'Category updated successfully',
                'category' => $category
            ],201);

        
      






    }




    public function destroy($slug){



    $category=Category::where("categorySlug",$slug)->first();


    if ($category) {
    

        if ($category->categoryImage) {
            Storage::disk('public')->delete($category->categoryImage); // this for deleting the old image
        }

        $category->delete();

        return response()->json([

            "status"=>"success",
            "message"=>"category deleted successfully"

        ],200);





    }

    else{

        return response()->json([

            "status"=>"error",
            "message"=>"category not found"

        ],404);


    }







    }









}
