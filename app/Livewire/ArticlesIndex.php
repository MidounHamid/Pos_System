<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Famille;
use App\Models\Marque;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Schema;

class ArticlesIndex extends Component
{
    use WithPagination;

    // Existing properties
    // 
    public array $items = [];
    public float $taxRate = 0;
    public string $discountType = 'fixed';
    public float $discountValue = 0;
    public float $shippingCost = 0;

    // Filter properties
    public $selectedCategory = 'all';
    public $selectedBrand = 'all';
    public $search = '';

    public function handleAddToCart($articleId)
    {
        if (!is_numeric($articleId)) {
            return;
        }

        $article = Article::find($articleId);

        if (!$article) {
            return;
        }

        if (isset($this->items[$articleId])) {
            $this->items[$articleId]['qty']++;
        } else {
            $this->items[$articleId] = [
                'id' => $article->id,
                'name' => $article->designation,
                'qty' => 1,
                'price' => round($article->prix_ht * (1 + $article->tva / 100), 2),
            ];
        }

        $this->dispatch('cart-updated', items: $this->items);
    }

    public function setCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->resetPage();
    }

    public function setBrand($brandId)
    {
        $this->selectedBrand = $brandId;
        $this->resetPage();
    }

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

    // Reset page when search is updated
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $categories = Famille::all();
        $brands = Marque::all();

        $query = Article::query();

        if ($this->selectedCategory !== 'all') {
            $query->where('famille_id', $this->selectedCategory);
        }

        if ($this->selectedBrand !== 'all') {
            $query->where('marque_id', $this->selectedBrand);
        }

        // Add search functionality
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('designation', 'like', '%' . $this->search . '%')
                  ->orWhere('code_barre', 'like', '%' . $this->search . '%');
            });
        }

        // Optional: Add pagination if needed
        // $articles = $query->paginate(12);
        // Or get all results
        $articles = $query->get();

        return view('livewire.articles-index', [
            'articles' => $articles,
            'categories' => $categories,
            'brands' => $brands,
            'selectedCategory' => $this->selectedCategory,
            'selectedBrand' => $this->selectedBrand,
            'discountAmount' => $this->discountAmount,
            'totalQty' => $this->totalQty,
            'subTotal' => $this->subTotal,
            'total' => $this->total,
        ]);
    }
}
