<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Resources\Settings\CategoryResource;
use App\Laravue\Models\Settings\Category;
use Illuminate\Http\Request;
use App\Laravue\JsonResponse;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parent = Category::with('parent')->get();
        $children = Category::whereNull('parent_id')->has('children')->with('children')->get();

        // Return collection of categories as a resource
        // return CategoryResource::collection(Category::with('parent')->orderBy('parent_id', 'asc')->get());
        return response()->json(new JsonResponse(['parent' => $parent, 'children' => $children]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $category = Category::create([
                'parent_id' => $params['parent_id'],
                'name' => $params['name'],
                'description' => $params['description'],
            ]);

            return new CategoryResource($category);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        if ($category === null) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required']
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $category->parent_id = $params['parent_id'];
            $category->name = $params['name'];
            $category->description = $params['description'];
            $category->save();
        }

        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }

    public function name($id) {
        $name = Category::findOrFail($id);
        return $name;
    }

    public function currencycategories()
    {

        $currencies = Category::where('parent_id', 201)->get();

        return response()->json(new JsonResponse($currencies));

    }

    public function medicationcategories()
    {

        $medications = Category::where('parent_id', 204)->get();

        return response()->json(new JsonResponse($medications));

    }

    public function petcategories()
    {

        $coats = Category::where('parent_id', 3)->orderby('name')->get();
        $breeds = Category::where('parent_id', 2)->orderby('name')->get();

        return response()->json(new JsonResponse(['coats' => $coats, 'breeds' => $breeds]));

    }

    public function revenuecategories()
    {

        $currencies = Category::where('parent_id', 201)->orderBy('name')->get();
        $non_operatings = Category::where('parent_id', 223)->orderBy('name')->get();
        $payment_methods = Category::where('parent_id', 214)->orderBy('name')->get();
        $operatings = Category::where('parent_id', 222)->orderBy('name')->get();
        $recurrence = Category::where('parent_id', 231)->orderBy('description')->get();

        return response()->json(new JsonResponse(['currencies' => $currencies, 'operatings' => $operatings, 'payment_methods' => $payment_methods, 'non_operatings' => $non_operatings, 'recurrence' => $recurrence]));

    }

    public function vaccinecategories()
    {

        $vaccines = Category::where('parent_id', 4)->get();

        return response()->json(new JsonResponse($vaccines));

    }

}
