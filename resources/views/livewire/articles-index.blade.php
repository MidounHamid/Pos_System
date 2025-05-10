<div>
    <!-- Search Bar -->
    <div class="mb-4">
        <div class="input-group">
            <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                   placeholder="Search by name or code...">
            <button class="btn btn-outline-secondary" type="button">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>

    <!-- Category Filter -->
    <div class="mb-3">
        <div class="d-flex overflow-auto" style="gap: 0.5rem; scrollbar-width: thin;">
            <button wire:click="setCategory('all')" wire:key="category-all"
                    class="btn btn-sm {{ $selectedCategory === 'all' ? 'btn-primary' : 'btn-light' }} rounded-pill">
                All Categories
            </button>
            @foreach ($categories as $category)
                <button wire:click="setCategory('{{ $category->id }}')" wire:key="category-{{ $category->id }}"
                        class="btn btn-sm {{ $selectedCategory == $category->id ? 'btn-primary' : 'btn-light' }} rounded-pill">
                    {{ $category->famille }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Brand Filter -->
    <div class="mb-4">
        <div class="d-flex overflow-auto" style="gap: 0.5rem; scrollbar-width: thin;">
            <button wire:click="setBrand('all')" wire:key="brand-all"
                    class="btn btn-sm {{ $selectedBrand === 'all' ? 'btn-primary' : 'btn-light' }} rounded-pill">
                All Brands
            </button>
            @foreach ($brands as $brand)
                <button wire:click="setBrand('{{ $brand->id }}')" wire:key="brand-{{ $brand->id }}"
                        class="btn btn-sm {{ $selectedBrand == $brand->id ? 'btn-primary' : 'btn-light' }} rounded-pill">
                    {{ $brand->marque }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Filter Debug Info (Remove in production) -->
    <div class="mb-3 small text-muted">
        <p>Current Filters: Category: {{ $selectedCategory }} | Brand: {{ $selectedBrand }}</p>
    </div>

    <!-- Products Grid -->
    <div class="row">
        @foreach ($articles as $article)
            @if (isset($article->id, $article->designation, $article->prix_ht, $article->tva))
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ $article->photo ? asset('storage/' . $article->photo) : asset('images/placeholder-product.png') }}"
                             class="card-img-top img-fluid"
                             style="height: 200px; object-fit: cover; background-color: #f8f9fa;"
                             alt="{{ $article->designation }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-2">{{ $article->designation }}</h5>
                            <p class="card-text text-muted small mb-2">{{ $article->code_barre }}</p>

                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge bg-success fs-6">
                                        {{ number_format($article->prix_ht * (1 + $article->tva / 100), 2) }} €
                                    </span>
                                    <span class="text-muted small">
                                        {{ number_format($article->prix_ht * (1 + $article->tva / 100) * 0.925, 2) }} €/pièce
                                    </span>
                                </div>
                                <button wire:click="handleAddToCart({{ $article->id }})"
                                        class="btn btn-primary w-100">
                                    <i class="fas fa-cart-plus me-2"></i>
                                    Ajouter au panier
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

        @if(count($articles) === 0)
            <div class="col-12 text-center py-5">
                <div class="alert alert-info">
                    No products found matching your criteria.
                </div>
            </div>
        @endif
    </div>
</div>