<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductController extends Controller
{
    public function index()
    {
        $products = auth()->user()->products()->with('category')->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = auth()->user()->categories()->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'sku' => 'nullable|string|unique:products,sku',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        auth()->user()->products()->create($request->all());

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    public function show(Product $product)
    {
        $this->authorize('view', $product);
        $product->load('category');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        $categories = auth()->user()->categories()->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        if ($product->saleItems()->count() > 0) {
            return back()->with('error', 'Cannot delete product with existing sales');
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }

    public function stockReport()
    {
        $products = auth()->user()->products()->with('category')->get();

        $pdf = Pdf::loadView('reports.stock', compact('products'));
        return $pdf->download('stock-report-' . date('Y-m-d') . '.pdf');
    }
}
