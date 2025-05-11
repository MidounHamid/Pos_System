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

    // Listen for cart update events from ArticlesIndex
    protected $listeners = ['cart-updated' => 'refreshCart'];

    public function mount()
    {
        // Initialize from session
        $this->refreshCartFromSession();

        // Also load extra cart data
        $this->loadExtraData();
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