<?php

namespace App\Livewire;

use App\Models\Article;
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
    public $selectedCategory = 'All Categories';
    public $selectedBrand = 'All Brands';
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

    public function setCategory($category)
    {
        $this->selectedCategory = $category;
        $this->resetPage(); // If you're using pagination
    }

    public function setBrand($brand)
    {
        $this->selectedBrand = $brand;
        $this->resetPage(); // If you're using pagination
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
        // Check table structure and get filterable columns
        $articleColumns = Schema::getColumnListing('articles');

        // Define category and brand columns based on your actual table structure
        $categoryColumn = in_array('categorie', $articleColumns) ? 'categorie' :
                         (in_array('category', $articleColumns) ? 'category' : null);

        $brandColumn = in_array('marque', $articleColumns) ? 'marque' :
                      (in_array('brand', $articleColumns) ? 'brand' : null);

        $query = Article::query();

        // Get categories and brands if the columns exist
        $categories = collect();
        $brands = collect();

        if ($categoryColumn) {
            $categories = Article::select($categoryColumn)
                ->distinct()
                ->whereNotNull($categoryColumn)
                ->pluck($categoryColumn)
                ->filter();

            if ($this->selectedCategory !== 'All Categories' && $categoryColumn) {
                $query->where($categoryColumn, $this->selectedCategory);
            }
        }

        if ($brandColumn) {
            $brands = Article::select($brandColumn)
                ->distinct()
                ->whereNotNull($brandColumn)
                ->pluck($brandColumn)
                ->filter();

            if ($this->selectedBrand !== 'All Brands' && $brandColumn) {
                $query->where($brandColumn, $this->selectedBrand);
            }
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

        // If no category/brand columns found, use some default values for the filter UI
        if ($categories->isEmpty()) {
            $categories = collect(['Fruits', 'Shoes', 'Jackets', 'Computer', 'T-shirts', 'Sunglass', 'EarPods']);
        }

        if ($brands->isEmpty()) {
            $brands = collect(['Colorss', 'Lion Test', 'Laptop', 'A & S Company', 'Fruits', 'HP', 'trestllqa']);
        }

        return view('livewire.articles-index', [
            'articles' => $articles,
            'categories' => $categories,
            'brands' => $brands,
            'discountAmount' => $this->discountAmount,
            'totalQty' => $this->totalQty,
            'subTotal' => $this->subTotal,
            'total' => $this->total,
            'categoryColumn' => $categoryColumn,
            'brandColumn' => $brandColumn,
        ]);
    }
}
