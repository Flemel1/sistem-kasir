<?php

namespace App\Livewire\Pages;

use App\Enums\PriceChoose;
use App\Enums\StatusOrder;
use App\Models\OpenOrder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Services\PrinterService;
use Exception;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ItemNotFoundException;
use Livewire\Attributes\On;
use Livewire\Component;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class CreateOrder extends Component
{
    public Collection $currentOrders;
    public EloquentCollection $products;
    public int $total = 0;

    public ?OpenOrder $openBill = null;

    public function mount(Request $request, $open_bill_id = null): void
    {
        $openBillID = $open_bill_id ?? $request->query('open_bill_id');
        if ($openBillID) {
            try {
                $openBill = OpenOrder::whereNull('doned_at')->findOrFail($openBillID);
                $this->currentOrders = collect($openBill->ordered_items)->map(function ($item) {
                    if (!isset($item['identifier'])) {
                        $item['identifier'] = base64_encode(($item['product_name'] ?? '') . '_' . ($item['product_id'] ?? ''));
                    }
                    if (!isset($item['additional_products'])) {
                        $item['additional_products'] = [];
                    }
                    if (!isset($item['additional_product_prices'])) {
                        $item['additional_product_prices'] = 0;
                    }
                    if (!isset($item['price_choose'])) {
                        $item['price_choose'] = PriceChoose::NORMAL->value;
                    }
                    if (!isset($item['takeaway_price'])) {
                        $item['takeaway_price'] = 0;
                    }
                    if (!isset($item['product_id'])) {
                        $item['product_id'] = 0;
                    }
                    return $item;
                });
                $this->total = $openBill->grand_total;

                $this->openBill = $openBill;
            } catch (ModelNotFoundException $ex) {
                abort(404);
            } catch (Exception $th) {
                abort(500);
            }
        } else {
            $this->currentOrders = collect([]);
        }

        $this->products = Product::all();
    }


    public function open_create_order_modal(): void
    {
        $this->dispatch('open-create-order-modal');
    }

    #[On('add-product')]
    public function add_product(
        $product_id,
        $product_name,
        $amount,
        $price,
        $takeaway_price,
        $price_choose,
        $additional_products,
        $identifier
    ): void {

        $currentOrders = collect($this->currentOrders);
        $additional_product_prices = 0;
        $product = $currentOrders->first(function (array $value, int $key) use ($identifier, $price_choose) {
            return $identifier == $value['identifier'] && $price_choose == $value['price_choose'];
        });



        foreach ($additional_products as $additional_product) {
            foreach ($additional_product as $item) {
                $additional_product_prices += $item['price'];
            }
        }

        if (is_null($product)) {

            if ($price_choose === PriceChoose::TAKEAWAY->value) {
                $substring = "(Takeaway)";
                if (!strpos($product_name, $substring)) {
                    $product_name = $product_name . " " . "(Takeaway)";
                }
            }

            $currentOrders->add([
                'product_id' => $product_id,
                'product_name' => $product_name,
                'amount' => intval($amount),
                'price' => intval($price),
                'takeaway_price' => intval($takeaway_price),
                'price_choose' => $price_choose,
                'additional_product_prices' => $additional_product_prices,
                'additional_products' => $additional_products,
                'identifier' => $identifier
            ]);

            $this->currentOrders = $currentOrders;
            $this->total = $currentOrders->sum(function (array $value) {

                if ($value['price_choose'] === PriceChoose::TAKEAWAY->value) {
                    return $value['amount'] * $value['takeaway_price'] + $value['additional_product_prices'];
                } else {
                    return $value['amount'] * $value['price'] + $value['additional_product_prices'];
                }
            });
        } else {
            $updatedCurrentOrders = $currentOrders->map(function (array $value, int $key) use ($product, $amount) {
                if ($product['identifier'] == $value['identifier'] && $product['price_choose'] == $value['price_choose']) {
                    $value['amount'] = intval($amount);
                    return $value;
                }

                return $value;
            });
            $this->currentOrders = $updatedCurrentOrders;
            $this->total = $updatedCurrentOrders->sum(function (array $value) use ($additional_product_prices) {
                if ($value['price_choose'] === PriceChoose::TAKEAWAY->value) {
                    return $value['amount'] * $value['takeaway_price'] + $additional_product_prices;
                } else {
                    return $value['amount'] * $value['price'] + $additional_product_prices;
                }
            });
        }
    }

    #[On("update-product")]
    public function update_product(
        $product_id,
        $product_name,
        $amount,
        $price,
        $takeaway_price,
        $price_choose,
        $additional_products,
        $old_identifier,
        $identifier
    ) {
        $this->remove_product($old_identifier);
        $this->add_product(
            $product_id,
            $product_name,
            $amount,
            $price,
            $takeaway_price,
            $price_choose,
            $additional_products,
            $identifier
        );
        $this->dispatch('update-product-state');
    }

    public function remove_product($identifier): void
    {
        $currentOrders = collect($this->currentOrders);
        $product = $currentOrders->first(function (array $value, int $key) use ($identifier) {
            return $identifier == $value['identifier'];
        });

        if (!is_null($product)) {
            $updatedCurrentOrders = $currentOrders->whereNotIn('identifier', $identifier);
            $this->currentOrders = $updatedCurrentOrders;
            $this->total = $updatedCurrentOrders->sum(function (array $value) {
                return $value['amount'] * $value['price'] + $value['additional_product_prices'];
            });
        }
    }

    public function edit_product($identifier): void
    {
        $currentOrders = collect($this->currentOrders);

        $product = $currentOrders->first(function (array $value, int $key) use ($identifier) {
            return $identifier == $value['identifier'];
        });

        if (!is_null($product)) {
            $additional_products = Product::where('id', $product['product_id'])
                ->withWhereHas('additional_products')
                ->get()
                ->first()->additional_products ?? collect([]);
            $currentProductProperties = $product;
            $data = [
                'current_product_properties' =>  $currentProductProperties,
                'additional_products' => $additional_products
            ];
            $this->dispatch(
                'open-edit-modal',
                data: $data
            );
        }
    }

    #[On('create-order')]
    public function create_order(string $customer_name, string $cash_money, string $status_order): void
    {
        if ($this->currentOrders->isNotEmpty()) {
            if ($status_order === StatusOrder::OPENED->value) {
                if ($this->openBill) {
                    $this->openBill->customer_name = $customer_name;
                    $this->openBill->ordered_items = $this->currentOrders;
                    $this->openBill->grand_total = $this->total;
                    $this->openBill->save();
                } else {
                    $openOrder = new OpenOrder();
                    $openOrder->customer_name = $customer_name;
                    $openOrder->ordered_items = $this->currentOrders;
                    $openOrder->grand_total = $this->total;
                    $openOrder->save();
                }

                $this->redirectRoute('open-bill');
            } else {
                $cash_money = intval($cash_money);
                if ($cash_money >= $this->total) {
                    try {
                        $change_money =  $cash_money - $this->total;
                        DB::beginTransaction();
                        $order = Order::create([
                            'customer_name' => $customer_name,
                            'total_payment' => $this->total,
                            'cash_money' => $cash_money,
                            'change_money' => $change_money,
                            'status_order' => $status_order
                        ]);

                        if ($order) {
                            $order_id = $order->id;

                            $groupByOrders = $this->currentOrders->groupBy('identifier')->all();

                            foreach ($groupByOrders as $order) {
                                if ($order->count() > 1) {
                                    $orderTemp = [
                                        'product_id' => $order[0]['product_id'],
                                        'amount' => 0
                                    ];

                                    foreach ($order as $obj) {
                                        $orderTemp['amount'] += $obj['amount'];
                                    }

                                    OrderDetail::create([
                                        'product_id' => $orderTemp['product_id'],
                                        'order_id' => $order_id,
                                        'amount' => $orderTemp['amount']
                                    ]);
                                } else {
                                    OrderDetail::create([
                                        'product_id' => $order[0]['product_id'],
                                        'order_id' => $order_id,
                                        'amount' => $order[0]['amount']
                                    ]);
                                }
                            }

                            if ($this->openBill) {
                                $this->openBill->doned_at = now();
                                $this->openBill->save();
                            }

                            DB::commit();
                            $this->dispatch('create-order-status', [
                                'type' => 'success',
                                'message' => 'Pesanan Berhasil Dibuat'
                            ]);
                            try {
                                $this->print_invoice($customer_name, $cash_money);
                            } catch (\Exception $e) {
                                $this->dispatch('create-order-status', [
                                    'type' => 'warning',
                                    'message' => 'Printer tidak terhubung. Silakan colok printer terlebih dahulu.'
                                ]);
                            }
                            $this->redirectRoute('order');
                        } else {
                            DB::rollBack();
                            $this->dispatch('create-order-status', [
                                'type' => 'error',
                                'message' => 'Pesanan Gagal Dibuat'
                            ]);
                        }
                    } catch (Exception $ex) {
                        DB::rollBack();
                        $this->dispatch('create-order-status', [
                            'type' => 'error',
                            'message' => $ex->getMessage()
                        ]);
                    }
                } else {
                    $this->dispatch('create-order-status', [
                        'type' => 'error',
                        'message' => 'Uang cash kurang'
                    ]);
                }
            }
        }
    }

    private function print_invoice(string $customer_name, string $cash_money)
    {
        $change_money =  $cash_money - $this->total;
        $currentDate = now()->format('d/m/Y H:m:s');
        $printerId = PrinterService::getActivePrinterName();
        $connector = new WindowsPrintConnector($printerId);
        $printer = new Printer($connector);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setEmphasis(true);
        $printer->text("KopiiRaya \n");
        $printer->text("Jl. Ring Road Utara No.11, Yogyakarta \n");
        $printer->feed(2);
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Tanggal: $currentDate \n");
        $printer->text("Kasir: Kasir \n");
        $printer->text("Customer: $customer_name \n");
        $printer->setEmphasis(false);

        $printer->text("\n===============================\n");
        foreach ($this->currentOrders as $orderItem) {
            $totalPricePerItem = 0;

            if ($orderItem['price_choose'] === PriceChoose::TAKEAWAY->value) {
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->text(sprintf(
                    "%.0f x %s \n",
                    $orderItem['amount'],
                    $orderItem['product_name']
                ));
                foreach ($orderItem['additional_products'] as $key => $additional_product) {
                    foreach ($additional_product as $item) {
                        $printer->text($key . ' : ' . $item['name'] . "\n");
                    }
                }
                $printer->setJustification(Printer::JUSTIFY_RIGHT);
                $totalPricePerItem = $orderItem['takeaway_price'] * $orderItem['amount']  + $orderItem['additional_product_prices'];
                $printer->text('Rp. ' . number_format($totalPricePerItem, 2) . "\n");
            } else {
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->text(sprintf(
                    "%.0f x %s \n",
                    $orderItem['amount'],
                    $orderItem['product_name']
                ));
                foreach ($orderItem['additional_products'] as $key => $additional_product) {
                    foreach ($additional_product as $item) {
                        $printer->text($key . ' : ' . $item['name'] . "\n");
                    }
                }
                $printer->setJustification(Printer::JUSTIFY_RIGHT);
                $totalPricePerItem = $orderItem['price'] * $orderItem['amount']  + $orderItem['additional_product_prices'];;
                $printer->text('Rp. ' . number_format($totalPricePerItem, 2) . "\n");
            }
        }

        $printer->text("\n===============================\n");
        $printer->setEmphasis(true);
        $printer->text("Total: Rp. " . number_format($this->total, 2) . "\n");
        $printer->text("Bayar: Rp. " . number_format($cash_money, 2) . "\n");
        $printer->text("Kembali: Rp. " . number_format($change_money, 2) . "\n");
        $printer->feed(2);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Terima Kasih Telah Berkunjung");
        $printer->feed(5);
        $printer->close();

        return response()->json(['status' => 200, 'message' => 'printed invoice successfully']);
    }

    public function render()
    {
        return view('livewire.pages.create-order');
    }
}
