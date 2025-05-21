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

    <div class="row">
        @foreach ($articles as $article)
        @if (isset($article->id, $article->designation, $article->prix_ht, $article->tva))
        <div class="col-md-3 mb-4">
            <div class="card h-100 border-0 rounded-3 position-relative p-0 cursor-pointer"
                 wire:click="handleAddToCart({{ $article->id }})"
                 style="cursor: pointer; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: all 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 15px rgba(0,0,0,0.15)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)';"
                 >
                <!-- Price tag in top-left corner -->
                <div class="position-absolute top-0 start-0 p-0 z-1">
                    <div class="bg-primary text-white fw-bold py-1 px-2 rounded-start" style="border-top-right-radius: 0;">
                        {{ $article->prix_ht }} DH
                    </div>
                </div>

                <!-- Volume tag in top-right corner -->
                <div class="position-absolute top-0 end-0 p-0 z-1">
                    <div class="bg-dark text-white fw-bold py-1 px-2 rounded-start" style="border-top-left-radius: 0;">
                        {{ $article->stock }} {{ $article->unite->unite }}
                    </div>
                </div>

                <div class="text-center p-3">
                    <img src="{{ $article->photo ? asset('storage/' . $article->photo) : asset('images/placeholder-product.png') }}"
                        class="img-fluid mx-auto d-block"
                        style="height: 180px; object-fit: contain;"
                        alt="{{ $article->designation }}">
                </div>

                <div class="card-body text-center p-2">
                    <h5 class="card-title fw-bold mb-1">{{ $article->designation }}</h5>
                    <p class="text-muted mb-1 small">{{ $article->famille->famille }}     <span class="text-blue-500">{{ strtolower($article->designation) }}</span>
                    </p>
                    <p class="text-muted small mb-2">{{ $article->code_barre }}</p>
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