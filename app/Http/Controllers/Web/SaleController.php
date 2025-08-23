<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    public function index()
    {
        $sales = auth()->user()->sales()->with('customer')->latest()->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = auth()->user()->customers()->get();
        $products = auth()->user()->products()->where('stock_quantity', '>', 0)->get();
        return view('sales.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $totalAmount = 0;
            $saleNumber = 'SALE-' . time();

            // Calculate total amount
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $totalAmount += $product->price * $item['quantity'];
            }

            $discount = $request->discount ?? 0;
            $tax = $request->tax ?? 0;
            $finalAmount = ($totalAmount - $discount) + $tax;

            $sale = auth()->user()->sales()->create([
                'sale_number' => $saleNumber,
                'customer_id' => $request->customer_id,
                'total_amount' => $totalAmount,
                'discount' => $discount,
                'tax' => $tax,
                'final_amount' => $finalAmount,
            ]);

            // Create sale items and update stock
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for product: {$product->name}");
                }

                $sale->saleItems()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'total_price' => $product->price * $item['quantity'],
                ]);

                // Update stock
                $product->decrement('stock_quantity', $item['quantity']);
            }

            DB::commit();

            return redirect()->route('sales.index')->with('success', 'Sale created successfully');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(Sale $sale)
    {
        $this->authorize('view', $sale);
        $sale->load('customer', 'saleItems.product');
        return view('sales.show', compact('sale'));
    }

    public function invoice(Sale $sale)
    {
        $this->authorize('view', $sale);
        $sale->load('customer', 'storeKeeper', 'saleItems.product');

        $pdf = Pdf::loadView('invoices.sale', compact('sale'));
        return $pdf->download('invoice-' . $sale->sale_number . '.pdf');
    }

    public function salesReport()
    {
        $sales = auth()->user()->sales()->with('customer')->get();

        $pdf = Pdf::loadView('reports.sales', compact('sales'));
        return $pdf->download('sales-report-' . date('Y-m-d') . '.pdf');
    }
}
