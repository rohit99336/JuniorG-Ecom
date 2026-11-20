<?php

namespace App\Http\Controllers\Ecom;

use App\Models\Product;
use App\Models\Unit;
use App\Models\Color;
use App\Models\Category;
use App\Models\Stock;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\ProductExport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $title = 'Products';
            $subTitle = 'List of Products';
            $products = Product::all();
            $counter = 1;

            if (request()->ajax()) {
                // $Products = Product::with('creater', 'updater')->select('Products.*');
                $Products = Product::with('creater', 'updater', 'category', 'unit', 'color', 'productVariants');
                return DataTables::of($Products)
                    ->addColumn('sr_no', function () use (&$counter) {
                        return $counter++;
                    })
                    ->addColumn('action', function ($Product) {
                        return  '<a href="' . route('ecomadmin.prod.products.show', $Product->id) . '" class="btn btn-info"><i class="bx bx-show "></i></a>' . '&nbsp;&nbsp;<a class="btn btn-primary edit" id="' . $Product->id . '" href="' . route('ecomadmin.prod.products.edit', $Product->id) . '" ><i class="bx bx-edit-alt "></i></a>' . '&nbsp;&nbsp;<button class="btn btn-danger delete" id="' . $Product->id . '" data-id="' . $Product->id . '"><i class="bx bx-trash-alt "></i></button>' . '&nbsp;&nbsp;<a href="' . route('ecomadmin.prod.new-stock', $Product->id) . '" class="btn btn-warning" title="Add new stock"><i class="bi bi-box-arrow-in-down"></i></a>' . '&nbsp;&nbsp;<a href="' . route('ecomadmin.prod.export-stock', $Product->id) . '" class="btn btn-info" title="Debit Product"><i class="bi bi-box-arrow-in-up"></i></a>';
                    })
                    ->addColumn('creater', function ($Product) {
                        return $Product->creater->name;
                    })
                    ->addColumn('Product', function ($Product) {
                        return '<div style="width: 30px; height: 30px; background-Product: ' . $Product->code . '"></div>';
                    })
                    ->editColumn('is_active', function ($Product) {
                        return $Product->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                    })
                    ->addColumn('is_featured', function ($Product) {
                        return $Product->is_featured ? '<span class="badge bg-success">Featured</span>' : '<span class="badge bg-danger">Not Featured</span>';
                    })
                    ->addColumn('is_cod', function ($Product) {
                        return $Product->is_cod ? '<span class="badge bg-success">COD</span>' : '<span class="badge bg-danger">Not COD</span>';
                    })

                    // ->addColumn('info', function ($Product) {
                    //     return '<a href="' . route('ecomadmin.prod.products.show', $Product->id) . '" class="btn btn-info"><i class="bx bx-info-circle "></i></a>';
                    // })

                    // ->addColumn('info', function ($Product) {
                    //     $total_variants = $Product->productVariants->count();
                    //     $total_stock = $Product->productVariants->sum('quantity');

                    //     return '<a href="' . route('ecomadmin.prod.products.show', $Product->id) . '" class="btn btn-info"><i class="bx bx-info-circle "></i></a>' . '&nbsp;&nbsp;<span class="badge bg-success">' . $total_variants . ' Variants</span>' . '&nbsp;&nbsp;<span class="badge bg-success">' . $total_stock . ' Stock</span>';
                    // })

                    ->addColumn('info', function ($Product) {
                        $total_variants = $Product->productVariants->count();
                        $total_stock = $Product->productVariants->sum('quantity');

                        return '<small><b>No. of variants:</b> ' . $total_variants . '</small>  <br>' . '&nbsp;&nbsp;<small><b>Total stock:</b> ' . $total_stock . '</small>';
                    })

                    // // variants with stock
                    // ->addColumn('variant_stock', function ($Product) {
                    //     $variant_stock = '';
                    //     foreach ($Product->productVariants as $variant) {
                    //         $variant_stock .= '<small><b>' . $variant->color->name . ' </b>' . '</small>' . '&nbsp;&nbsp;<small><b>' . $variant->quantity . ' </b>' . '</small><br>';
                    //     }
                    //     return $variant_stock;
                    // })

                    // variants with stock
                    ->addColumn('variant_stock', function ($Product) {
                        $variant_stock = '';
                        foreach ($Product->productVariants as $variant) {
                            $variant_stock .= '<small><b>' . $variant->unit_size . ' </b>' . '</small>' . '<small><b>' . $variant->unit->short_name . ' </b>' . '</small>' . ' - <small>' . $variant->quantity . '</small><br>';
                        }
                        return $variant_stock;
                    })
                    ->rawColumns(['action', 'Product', 'is_active', 'creater', 'is_featured', 'is_cod', 'info', 'variant_stock', 'sr_no'])
                    ->make(true);
            }
            return view('ecom.admin.products.index', compact('products', 'title', 'subTitle'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $title = 'Products';
            $subTitle = 'Create Product';
            $categories = Category::all();
            $units = Unit::all();
            $colors = Color::all();
            return view('ecom.admin.products.create', compact('title', 'subTitle', 'categories', 'units', 'colors'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Log::info($request->all());
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'category_id' => 'required',
                    'name' => 'required',
                    'description' => 'nullable',
                    'min_quantity' => 'nullable',
                    'tax_type' => 'nullable',
                    'tax' => 'nullable',
                    'is_active' => 'nullable',
                    'is_bestseller' => 'nullable',
                    'is_cod' => 'nullable',
                    'is_refundable' => 'nullable',
                    'is_featured' => 'nullable',
                    'tags' => 'nullable',
                    'variants' => 'required|array',
                    // 'variant.unit_id' => 'required',
                    // 'variant.unit_size' => 'required',
                    // 'variant.price' => 'required',
                    // 'variant.quantity' => 'required',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // check product name is unique with category
            if (Product::where('name', $request->name)->where('category_id', $request->category_id)->first()) {
                return redirect()->back()->with('error', 'Product name already exists in this category');
            }

            $product = Product::create([
                'uuid' => Uuid::uuid4()->toString(),
                'category_id' => $request->category_id,
                'unit_id' => $request->unit_id,
                // 'color_id' => $request->color_id,
                'name' => $request->name,
                'description' => $request->description,
                'sku' => $request->sku,
                'min_quantity' => $request->min_quantity,
                'price' => $request->price,
                'tax_type' => $request->tax_type,
                'tax' => $request->tax,
                'is_featured' => $request->is_featured == 'on' ? 1 : 0,
                'is_bestseller' => $request->is_bestseller == 'on' ? 1 : 0,
                'is_active' => $request->is_active,
                'is_cod' => $request->is_cod == 'on' ? 1 : 0,
                'is_refundable' => $request->is_refundable == 'on' ? 1 : 0,
                'tags' => $request->tags,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
                'schema' => $request->schema,
                'eastimate_shiping_time' => $request->eastimate_shiping_time,
                'created_by' => auth()->guard('ecomadmin')->user()->id,
                'updated_by' => auth()->guard('ecomadmin')->user()->id,
            ]);

            // Create Product Variants
            foreach ($request->variants as $variant) {

                // // check if variant is empty
                // if (empty($variant['color_id']) || empty($variant['unit_id']) || empty($variant['unit_size']) || empty($variant['price']) || empty($variant['quantity']) || empty($variant['thumbnail_image'])) {
                //     return redirect()->back()->with('error', 'Product variant creation failed');
                // }

                // check if color_id, unit_id, unit_size, price is unique
                $productVariant = ProductVariant::where('product_id', $product->id)
                    // ->where('color_id', $variant['color_id'])
                    ->where('unit_id', $variant['unit_id'])
                    ->where('unit_size', $variant['unit_size'])
                    // ->where('price', $variant['price'])
                    ->first();

                if ($productVariant) {
                    return redirect()->back()->with('error', 'Product variant creation failed');
                }

                $productVariant = ProductVariant::create([
                    'uuid' => Uuid::uuid4()->toString(),
                    'product_id' => $product->id,
                    'name' => $variant['name'],
                    'color_id' => $variant['color_id'] ?? null,
                    'unit_id' => $variant['unit_id'] ?? null,
                    'unit_size' => $variant['unit_size'] ?? null,
                    'price' => $variant['price'],
                    'org_price' => $variant['org_price'],
                    'tax_type' => $request->tax_type,
                    'tax' => $request->tax,
                    'quantity' => $variant['quantity'],
                    'thumbnail_image' => $variant['thumbnail_image'],
                    'created_by' => auth()->guard('ecomadmin')->user()->id,
                    'updated_by' => auth()->guard('ecomadmin')->user()->id,
                ]);

                // Create Product Images
                foreach ($variant['images'] as $key => $image) {
                    $productImage = ProductImage::create([
                        'uuid' => Uuid::uuid4()->toString(),
                        'product_id' => $product->id,
                        'product_variant_id' => $productVariant->id,
                        // 'image' => $image['image'],
                        'image' => $image,
                        'created_by' => auth()->guard('ecomadmin')->user()->id,
                        'updated_by' => auth()->guard('ecomadmin')->user()->id,
                    ]);
                }

                $productStock = Stock::create([
                    'uuid' => Uuid::uuid4()->toString(),
                    'product_id' => $product->id,
                    'product_variant_id' => $productVariant->id,
                    'stock' => $variant['quantity'],
                    'created_by' => auth()->guard('ecomadmin')->user()->id,
                    'updated_by' => auth()->guard('ecomadmin')->user()->id,
                ]);

                // compare product variant price for lowest price and update product price
                $lowestPrice = ProductVariant::where('product_id', $product->id)->min('price');
                $product->price = $lowestPrice;
                $product->save();
            }

            if ($product) {
                return redirect()->route('ecomadmin.prod.products.index')
                    ->with('success', 'Product created successfully');
            }

            return redirect()->back()->with('error', 'Product creation failed');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $title = 'Products';
            $subTitle = 'Product Details';
            $product = Product::with('productVariants', 'productImages')->findOrFail($id);
            return view('ecom.admin.products.show', compact('title', 'subTitle', 'product'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $title = 'Products';
            $subTitle = 'Edit Product';
            $product = Product::with('productVariants', 'productImages')->findOrFail($id);
            $categories = Category::all();
            $units = Unit::all();
            $colors = Color::all();
            return view('ecom.admin.products.edit', compact('title', 'subTitle', 'product', 'categories', 'units', 'colors'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'category_id' => 'required',
                    'name' => 'required',
                    'description' => 'nullable',
                    'min_quantity' => 'nullable',
                    'tax_type' => 'nullable',
                    'tax' => 'nullable',
                    'is_active' => 'nullable',
                    'is_cod' => 'nullable',
                    'is_refundable' => 'nullable',
                    'is_featured' => 'nullable',
                    'is_bestseller' => 'nullable',
                    'tags' => 'nullable',
                    'variants' => 'required|array',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // check product name is unique with category
            if (Product::where('name', $request->name)->where('category_id', $request->category_id)->where('id', '!=', $id)->first()) {
                return redirect()->back()->with('error', 'Product name already exists in this category');
            }

            $product = Product::findOrFail($id);
            $product->category_id = $request->category_id;
            $product->unit_id = $request->unit_id;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->sku = $request->sku;
            $product->min_quantity = $request->min_quantity;
            $product->price = $request->price;
            $product->tax_type = $request->tax_type;
            $product->tax = $request->tax;
            $product->is_featured = $request->is_featured == 'on' ? 1 : 0;
            $product->is_bestseller = $request->is_bestseller == 'on' ? 1 : 0;
            $product->is_active = $request->is_active;
            $product->is_cod = $request->is_cod == 'on' ? 1 : 0;
            $product->is_refundable = $request->is_refundable == 'on' ? 1 : 0;
            $product->tags = $request->tags;
            $product->meta_description = $request->meta_description;
            $product->meta_keywords = $request->meta_keywords;
            $product->schema =  $request->schema;
            $product->eastimate_shiping_time = $request->eastimate_shiping_time;
            $product->updated_by = auth()->guard('ecomadmin')->user()->id;
            $product->save();

            foreach ($request->variants as $variant) {
                $productVariant = ProductVariant::updateOrCreate(
                    [
                        // 'product_id' => $product->id,
                        'id' => $variant['variant_id'],
                        // 'unit_id' => $variant['unit_id'],
                        // 'unit_size' => $variant['unit_size'],
                        // 'price' => $variant['price'],
                    ],
                    [
                        'product_id' => $product->id,
                        'name' => $variant['name'],
                        'color_id' => $variant['color_id'],
                        'org_price' => $variant['org_price'],
                        'tax_type' => $request->tax_type,
                        'tax' => $request->tax,
                        'quantity' => $variant['quantity'],
                        'thumbnail_image' => $variant['thumbnail_image'],
                        'created_by' => auth()->guard('ecomadmin')->user()->id,
                        'updated_by' => auth()->guard('ecomadmin')->user()->id,

                        // // Conditionally set UUID only during creation
                        // 'uuid' => !isset($variant['uuid']) ? Uuid::uuid4()->toString() : null,

                        // Conditionally set UUID only if not already set
                        'uuid' => isset($variant['uuid']) ? $variant['uuid'] : Uuid::uuid4()->toString(),

                        'unit_id' => $variant['unit_id'],
                        'unit_size' => $variant['unit_size'],
                        'price' => $variant['price'],
                    ]
                );

                // Delete image
                ProductImage::where('product_variant_id', $productVariant->id)->delete();

                // Create Product Images
                foreach ($variant['images'] as $key => $image) {
                    $productImage = ProductImage::create([
                        'uuid' => Uuid::uuid4()->toString(),
                        'product_id' => $product->id,
                        'product_variant_id' => $productVariant->id,
                        'image' => $image,
                        'created_by' => auth()->guard('ecomadmin')->user()->id,
                        'updated_by' => auth()->guard('ecomadmin')->user()->id,
                    ]);
                }

                // Create or update stock
                $productStock = Stock::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'product_variant_id' => $productVariant->id,
                    ],
                    [
                        'uuid' => Uuid::uuid4()->toString(),
                        'stock' => $variant['quantity'],
                        'created_by' => auth()->guard('ecomadmin')->user()->id,
                        'updated_by' => auth()->guard('ecomadmin')->user()->id,
                    ]
                );
            }

            return redirect()->route('ecomadmin.prod.products.index')->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            // return redirect()->route('ecomadmin.prod.products.index')
            //     ->with('success', 'Product deleted successfully');

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());

            // if ($product) {
            //     return redirect()->route('ecomadmin.prod.products.index')
            //         ->with('success', 'Product deleted successfully');
            // }
        }
    }


    //======================================== Stock ===============================//
    public function addStock(string $id)
    {
        try {
            $title = 'Products';
            $subTitle = 'Product Stock';
            $product = Product::with('productVariants', 'productImages')->where('id', $id)->first();
            return view('ecom.admin.products.addNewStock', compact('title', 'subTitle', 'product'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function ExportStockForm(string $id)
    {
        try {
            $title = 'Products';
            $subTitle = 'Export Product Stock';
            $product = Product::with('productVariants', 'productImages')->where('id', $id)->first();
            return view('ecom.admin.products.exportStock', compact('title', 'subTitle', 'product'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function storeNewStock(Request $request)
    {
        Log::info($request->all());
        try {
            // $validator = Validator::make(
            //     $request->all(),
            //     [
            //         'category_id' => 'required',
            //         'name' => 'required',
            //         'description' => 'nullable',
            //         'min_quantity' => 'nullable',
            //         'tax_type' => 'nullable',
            //         'tax' => 'nullable',
            //         'is_active' => 'nullable',
            //         'is_cod' => 'nullable',
            //         'is_refundable' => 'nullable',
            //         'is_featured' => 'nullable',
            //         'is_bestseller' => 'nullable',
            //         'tags' => 'nullable',
            //         'variants' => 'required|array',
            //     ]
            // );

            // if ($validator->fails()) {
            //     return redirect()->back()->withErrors($validator)->withInput();
            // }

            $product = Product::findOrFail($request->product_id);

            foreach ($request->variants as $variant) {

                // update product variant
                $productVariant = ProductVariant::find($variant['variant_id']);
                $oldSctock = $productVariant->quantity;
                $productVariant->quantity =  $variant['type'] == "import" ? $productVariant->quantity + $variant['quantity'] : $productVariant->quantity - $variant['quantity'];
                $productVariant->stock =  $variant['type'] == "import" ? $productVariant->stock + $variant['quantity'] : $productVariant->quantity - $variant['quantity'];
                $productVariant->updated_by = auth()->guard('ecomadmin')->user()->id;
                $productVariant->save();

                // // add new stock
                // $productStock = Stock::where('product_id', $product->id)->where('product_variant_id', $productVariant->id)->first();
                // $productStock->stock = $variant['type'] == "import" ? $productStock->stock + $variant['quantity'] : $productStock->stock - $variant['quantity'];
                // $productStock->save();

                // add product export
                $productExport = new ProductExport();
                $productExport->product_id = $product->id;
                $productExport->product_variant_id = $productVariant->id;
                $productExport->old_sctock = $oldSctock;
                $productExport->current_sctock = $productVariant->quantity ;
                $productExport->quantity = $variant['quantity'];
                $productExport->price = $variant['price'];
                $productExport->type = $variant['type'];
                $productExport->export_by = auth()->guard('ecomadmin')->user()->id;
                $productExport->name = $request->name ?? null;
                $productExport->phone = $request->phone ?? null;
                $productExport->email = $request->email ?? null;
                $productExport->pincode = $request->pincode ?? null;
                $productExport->address = $request->address ?? null;
                $productExport->save();
            }

            return redirect()->route('ecomadmin.prod.products.index')->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function stocks()
    {
        try {
            $title = 'Stock';
            $subTitle = 'Stock Transaction';
            $counter = 1;

            if (request()->ajax()) {
                // $Products = Product::with('creater', 'updater')->select('Products.*');
                $stocks = ProductExport::with('product', 'productVariant', 'exportBy');
                return DataTables::of($stocks)
                    ->addColumn('sr_no', function () use (&$counter) {
                        return $counter++;
                    })
                    ->addColumn('action', function ($stock) {
                        return  '<a href="' . route('ecomadmin.prod.stock-detail', $stock->id) . '" class="btn btn-info"><i class="bx bx-show "></i></a>' . '&nbsp;&nbsp;<button class="btn btn-danger delete" id="' . $stock->id . '" data-id="' . $stock->id . '"><i class="bx bx-trash-alt "></i></button>';
                    })
                    ->addColumn('exportBy', function ($stock) {
                        return $stock->exportBy->name;
                    })
                    ->addColumn('product', function ($stock) {
                        return $stock->product->name;
                    })
                    ->addColumn('created_at', function ($stock) {
                        return $stock->product->name;
                    })
                    ->addColumn('productVariant', function ($stock) {
                        return $stock->productVariant->name;
                    })
                    ->editColumn('created_at', '{{ date("d-m-Y", strtotime($created_at)) }}')
                    ->rawColumns(['action', 'exportBy', 'productVariant'])
                    ->make(true);
            }
            return view('ecom.admin.products.stock', compact('title', 'subTitle'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function StockDetail(string $id)
    {
        try {
            $title = 'Stock';
            $subTitle = 'Stock Transaction Details';
            $stock = ProductExport::with('product', 'productVariant', 'exportBy')->findOrFail($id);
            return view('ecom.admin.products.transaction-detail', compact('title', 'subTitle', 'stock'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroyTransaction(string $id)
    {
        try {
            $stock = ProductExport::findOrFail($id);
            $stock->delete();

            return response()->json([
                'success' => true,
                'message' => 'Transacion deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
