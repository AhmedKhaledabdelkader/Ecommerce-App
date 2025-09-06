<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;



class SubcategoryController extends Controller
{


    public function store(Request $request){



        if ($request->hasFile('subcategoryImage')) {
          
            $image = $request->file('subcategoryImage');
            $imagePath= $image->store('subcategories', 'public'); 
        }

        $subcategory=Subcategory::create([

            'subcategoryName'=>$request->subcategoryName,
            'subcategoryDescription'=>$request->subcategoryDescription,
            'subcategoryImage'=>$imagePath
        ]);


        $subcategory->categories()->attach($request->categories);


        return response()->json([

            "status"=>"success",
            "message"=>"subcategory created successfully",
           'subcategory' => $subcategory->load('categories')

        ],201);




    }



    public function index(){


        $subcategories=Subcategory::with('categories')->get();

        return response()->json([

            "status"=>"success",
            "message"=>"subcategories retrieved successfully",
            "data"=>$subcategories

        ],200);

    }



    public function show($slug){


        $subcategory=Subcategory::where('subcategorySlug',$slug)->with('categories')->first();

        if($subcategory){

            return response()->json([

                "status"=>"success",
                "message"=>"subcategory retrieved successfully",
                "data"=>$subcategory
    
            ],200);






        
    }

    else{

        return response()->json([

            "status"=>"error",
            "message"=>"subcategory not found"

        ],404);



    }





}



public function update(Request $request,$slug){

$subcategory=Subcategory::where("subcategorySlug",$slug)->first();


    $subcategory->subcategoryName=$request->subcategoryName;
    $subcategory->subcategorySlug = Str::slug($request->subcategoryName); 
    $subcategory->subcategoryDescription=$request->subcategoryDescription;


    if ($request->hasFile('subcategoryImage')) {
        if ($subcategory->subcategoryImage) {
            Storage::disk('public')->delete($subcategory->subcategoryImage);
        }
        $image= $request->file('subcategoryImage');
        $imagePath=$image->store('subcategories', 'public');
        $subcategory->subcategoryImage=$imagePath;
    }

    $subcategory->save();


    $subcategory->categories()->sync($request->categories);

 
    return response()->json([
        'message' => 'Subcategory updated successfully',
        'subcategory' => $subcategory->load('categories')
    ],201);
    
    

        
}



public function destroy($slug){


    $subcategory=Subcategory::where("subcategorySlug",$slug)->first();

    if($subcategory){

        if ($subcategory->subcategoryImage) {
            Storage::disk('public')->delete($subcategory->subcategoryImage);
        }

        $subcategory->categories()->detach();

        $subcategory->delete();

        return response()->json([

            "status"=>"success",
            "message"=>"subcategory deleted successfully"

        ],200);






    }


    else{


        return response()->json([

            "status"=>"error",
            "message"=>"subcategory not found"

        ],404);


    }


}







}