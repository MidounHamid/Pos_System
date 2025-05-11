<div class="card shadow-sm">
    <div class="card-body">
        <h4 class="mb-4"><i class="fas fa-shopping-cart me-2"></i>Shopping Cart</h4>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="bg-light">
                    <tr>
                        <th>PRODUCT</th>
                        <th class="text-center">QTY</th>
                        <th class="text-end">PRICE</th>
                        <th class="text-end">SUB TOTAL</th>
                        <th class="text-center"><i class="fas fa-times"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $itemId => $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <button wire:click="decrementQty({{ $itemId }})"
                                        class="btn btn-sm btn-outline-secondary px-3">-</button>
                                    <span>{{ $item['qty'] }}</span>
                                    <button wire:click="incrementQty({{ $itemId }})"
                                        class="btn btn-sm btn-outline-secondary px-3">+</button>
                                </div>
                            </td>
                            <td class="text-end">${{ number_format($item['price'], 2) }}</td>
                            <td class="text-end">${{ number_format($item['price'] * $item['qty'], 2) }}</td>
                            <td class="text-center">
                                <button wire:click="deleteItem({{ (int) $itemId }})"
                                class="btn btn-link text-danger p-0"
                                wire:loading.attr="disabled"
                                title="Remove item">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-shopping-cart fa-2x mb-3"></i><br>
                                Your cart is empty
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-tag me-2"></i>Discount Type</label>
                    <select wire:model.live="discountType" class="form-select">
                        <option value="fixed">Fixed Amount</option>
                        <option value="percentage">Percentage</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-percent me-2"></i>Discount Value</label>
                    <input type="number" wire:model.live="discountValue"
                        class="form-control @error('discountValue') is-invalid @enderror" step="0.01" min="0"
                        @if ($discountType === 'percentage') max="100" @endif placeholder="Enter discount">
                    @error('discountValue')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-truck me-2"></i>Shipping Cost</label>
                    <input type="number" wire:model.live="shippingCost"
                        class="form-control @error('shippingCost') is-invalid @enderror" step="0.01" min="0"
                        placeholder="Enter shipping cost">
                    @error('shippingCost')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 bg-light">
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-6">Total Items:</dt>
                            <dd class="col-6 text-end">{{ $totalQty }}</dd>

                            <dt class="col-6">Sub Total:</dt>
                            <dd class="col-6 text-end">${{ number_format($subTotal, 2) }}</dd>

                            <dt class="col-6 text-danger">Discount:</dt>
                            <dd class="col-6 text-end text-danger">-${{ number_format($discountAmount, 2) }}</dd>

                            <dt class="col-6">Shipping:</dt>
                            <dd class="col-6 text-end">${{ number_format($shippingCost, 2) }}</dd>

                            <dt class="col-6 fw-bold">Grand Total:</dt>
                            <dd class="col-6 text-end fw-bold">${{ number_format($total, 2) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <button wire:click="clearCart" class="btn btn-danger px-4"
                @if (empty($items)) disabled @endif>
                <i class="fas fa-trash me-2"></i>Reset
            </button>

            <div class="d-flex gap-2">
                <button class="btn btn-secondary px-4">
                    <i class="fas fa-pause me-2"></i>Hold Order
                </button>
                <button class="btn btn-success px-4">
                    <i class="fas fa-credit-card me-2"></i>Pay Now
                </button>
            </div>
        </div>
    </div>
</div>
