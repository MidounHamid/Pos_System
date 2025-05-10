<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Article;
use Illuminate\Support\Facades\Session;

class PanierIndex extends Component
{
    public array $items = [];
    public float $taxRate = 0;
    public string $discountType = 'fixed';
    public float $discountValue = 0;
    public float $shippingCost = 0;

    protected $listeners = ['cart-updated' => 'handleCartUpdate'];

    public function mount()
    {
        // Use the same session key as ArticlesIndex
        $this->items = session()->get('cart_items', []);
    }

    protected function saveToSession()
    {
        session()->put('cart_items', $this->items);
        session()->save(); // Force immediate save
    }

    public function clearCart()
    {
        $this->items = [];
        session()->forget('cart_items');
        session()->forget('panier_extra');
        session()->save();
        // Dispatch event to both components
        $this->dispatch('cart-updated', items: []);
        // Force a page refresh to ensure clean state
        $this->redirect(request()->header('Referer'));
    }

    public function handleCartUpdate($items)
    {
        $this->items = $items;
        $this->saveToSession();
    }

    public function incrementQty($articleId)
    {
        if (isset($this->items[$articleId])) {
            $this->items[$articleId]['qty']++;
            $this->saveToSession();
            $this->dispatch('cart-updated', items: $this->items);
        }
    }

    public function decrementQty($articleId)
    {
        if (isset($this->items[$articleId])) {
            if ($this->items[$articleId]['qty'] > 1) {
                $this->items[$articleId]['qty']--;
            } else {
                unset($this->items[$articleId]);
            }
            $this->saveToSession();
            $this->dispatch('cart-updated', items: $this->items);
        }
    }

    public function deleteItem($articleId)
    {
        if (isset($this->items[$articleId])) {
            unset($this->items[$articleId]);
            $this->saveToSession();
            $this->dispatch('cart-updated', items: $this->items);
        }
    }

    // Load session data for other properties
    public function hydrate()
    {
        $extra = session()->get('panier_extra', []);
        $this->discountType = $extra['discountType'] ?? 'fixed';
        $this->discountValue = $extra['discountValue'] ?? 0;
        $this->shippingCost = $extra['shippingCost'] ?? 0;
    }

    // Keep existing computed properties
    public function getSubTotalProperty(): float
    {
        return collect($this->items)->sum(fn($item) => $item['qty'] * $item['price']);
    }

    public function getDiscountAmountProperty(): float
    {
        return $this->discountType === 'percentage'
            ? $this->subTotal * ($this->discountValue / 100)
            : $this->discountValue;
    }

    public function getTotalQtyProperty(): int
    {
        return collect($this->items)->sum('qty');
    }

    public function getTotalProperty(): float
    {
        $total = $this->subTotal - $this->discountAmount + $this->shippingCost;
        $total += $this->subTotal * ($this->taxRate / 100);
        return round($total, 2);
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
