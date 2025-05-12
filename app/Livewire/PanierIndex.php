<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class PanierIndex extends Component
{
    public array $items = [];
    public float $taxRate = 0;
    public string $discountType = 'fixed';
    public float $discountValue = 0;
    public float $shippingCost = 0;
    public array $heldOrders = [];

    // Listen for cart update events from ArticlesIndex
    protected $listeners = ['cart-updated' => 'refreshCart', 'resume-order' => 'resumeOrder'];

    public function mount()
    {
        // Initialize from session
        $this->refreshCartFromSession();

        // Also load extra cart data
        $this->loadExtraData();

        // Load held orders
        $this->heldOrders = Session::get('held_orders', []);
    }

    // Refresh cart data from session
    public function refreshCartFromSession()
    {
        $this->items = Session::get('cart_items', []);
    }

    // Refresh cart when event is received
    public function refreshCart()
    {
        $this->refreshCartFromSession();
    }

    // Update session and dispatch event
    protected function updateCartSession()
    {
        Session::put('cart_items', $this->items);
        Session::save(); // Force immediate save

        // Dispatch event to notify ArticlesIndex
        $this->dispatch('cart-updated', items: $this->items);
    }

    // Load extra cart properties
    protected function loadExtraData()
    {
        $extra = Session::get('panier_extra', []);
        $this->discountType = $extra['discountType'] ?? 'fixed';
        $this->discountValue = (float)($extra['discountValue'] ?? 0);
        $this->shippingCost = (float)($extra['shippingCost'] ?? 0);
    }

    // Save extra cart properties
    protected function saveExtraData()
    {
        $extra = [
            'discountType' => $this->discountType,
            'discountValue' => $this->discountValue,
            'shippingCost' => $this->shippingCost
        ];

        Session::put('panier_extra', $extra);
        Session::save();
    }

    public function holdOrder()
    {
        if (!empty($this->items)) {
            $order = [
                'items' => $this->items,
                'extra' => [
                    'discountType' => $this->discountType,
                    'discountValue' => $this->discountValue,
                    'shippingCost' => $this->shippingCost
                ],
                'timestamp' => now()->format('Y-m-d H:i:s'),
                'total' => $this->total
            ];

            $this->heldOrders[] = $order;
            Session::put('held_orders', $this->heldOrders);
            
            // Clear current cart
            $this->clearCart();
            
            // Reset extra data
            $this->discountType = 'fixed';
            $this->discountValue = 0;
            $this->shippingCost = 0;
            $this->saveExtraData();
            
            $this->dispatch('order-held');
        }
    }

    public function resumeOrder($index)
    {
        if (isset($this->heldOrders[$index])) {
            $order = $this->heldOrders[$index];
            
            // Restore cart items
            $this->items = $order['items'];
            Session::put('cart_items', $this->items);
            
            // Restore extra data
            $this->discountType = $order['extra']['discountType'];
            $this->discountValue = $order['extra']['discountValue'];
            $this->shippingCost = $order['extra']['shippingCost'];
            $this->saveExtraData();
            
            // Remove from held orders
            array_splice($this->heldOrders, $index, 1);
            Session::put('held_orders', $this->heldOrders);
            
            $this->dispatch('cart-updated', items: $this->items);
        }
    }

    public function clearCart()
    {
        $this->items = [];
        Session::forget('cart_items');
        Session::save();

        // Dispatch event to notify ArticlesIndex
        $this->dispatch('cart-updated', items: $this->items);
    }

    public function incrementQty($articleId)
    {
        if (isset($this->items[$articleId])) {
            $this->items[$articleId]['qty']++;
            $this->updateCartSession();
        }
    }

    public function decrementQty($articleId)
    {
        if (isset($this->items[$articleId])) {
            if ($this->items[$articleId]['qty'] > 1) {
                $this->items[$articleId]['qty']--;
            } else {
                $this->deleteItem($articleId);
                return;
            }
            $this->updateCartSession();
        }
    }

    public function deleteItem($articleId)
    {
        // Convert to int for proper array key matching
        $articleId = (int) $articleId;

        if (array_key_exists($articleId, $this->items)) {
            unset($this->items[$articleId]);
            $this->updateCartSession();
        }
    }

    // Update session when properties change
    public function updated($name, $value)
    {
        if (in_array($name, ['discountType', 'discountValue', 'shippingCost'])) {
            $this->saveExtraData();
        }
    }

    // Get subtotal
    public function getSubTotalProperty(): float
    {
        return collect($this->items)->sum(fn($item) => $item['qty'] * $item['price']);
    }

    // Get discount amount
    public function getDiscountAmountProperty(): float
    {
        if ($this->discountType === 'percentage') {
            return ($this->subTotal * ($this->discountValue / 100));
        }
        return min($this->discountValue, $this->subTotal); // Don't allow negative totals
    }

    // Get total quantity
    public function getTotalQtyProperty(): int
    {
        return collect($this->items)->sum('qty');
    }

    // Get total
    public function getTotalProperty(): float
    {
        $total = $this->subTotal - $this->discountAmount + $this->shippingCost;
        $total += $this->subTotal * ($this->taxRate / 100);
        return max(0, round($total, 2)); // Ensure total is never negative
    }

    public function render()
    {
        return view('livewire.panier-index', [
            'discountAmount' => $this->discountAmount,
            'totalQty' => $this->totalQty,
            'subTotal' => $this->subTotal,
            'total' => $this->total,
        ]);
    }
}