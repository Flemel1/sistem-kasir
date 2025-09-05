@php
    use App\Enums\PriceChoose;

    $normal = PriceChoose::NORMAL;
    $takeaway = PriceChoose::TAKEAWAY;
@endphp


<div wire:ignore.self class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal">{{ $product_name }}</h5>
            </div>
            <form wire:submit="submit">
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="amount" class="form-label">Jumlah</label>
                            <div class="mb-3 d-flex align-items-center gap-2">
                                @if ($form->amount >= 2)
                                    <button wire:click="decrease_amount" type="button" class="btn btn-danger">-</button>
                                @endif
                                <span>{{ $form->amount }}</span>
                                <button wire:click="increase_amount"  type="button" class="btn btn-success">+</button>
                            </div>
                            {{-- <input wire:model="form.amount" type="number" id="amount" class="form-control"
                                placeholder="Jumlah" required> --}}
                            @error('form.amount')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    @if (sizeof($additional_products) > 0)
                        <div class="row">
                            @foreach ($additional_products as $additional_product)
                                <label class="form-label">
                                    {{ $additional_product['group_name'] }}
                                    @if ($additional_product['is_optional'])
                                        (Optional)
                                    @endif
                                </label>

                                <div class="mb-3 d-flex flex-wrap">
                                    @if ($additional_product['is_optional'] && $additional_product['is_multiple'])
                                        @foreach ($additional_product['items'] as $item)
                                            <div key="{{ uniqid('item_input_') }}"
                                                class="form-check form-check-inline mt-3">
                                                <input wire:model="form.input_multiple_additional_products"
                                                    class="form-check-input" type="checkbox"
                                                    id="{{ $item['item_name'] }}"
                                                    value="{{ $additional_product['group_name'] . '_' . $item['item_name'] . '_' . $item['item_price'] }}" />
                                                <label class="form-check-label"
                                                    for="{{ $item['item_name'] }}">{{ $item['item_name'] }}</label>
                                            </div>
                                        @endforeach
                                    @endif

                                    @if ($additional_product['is_optional'] && $additional_product['is_multiple'] == false)
                                        @foreach ($additional_product['items'] as $item)
                                            <div key="{{ uniqid('item_input_') }}"
                                                class="form-check form-check-inline mt-3">
                                                <input
                                                    wire:model="form.input_single_additional_products.{{ $additional_product['group_name'] }}"
                                                    class="form-check-input" type="radio"
                                                    id="{{ $item['item_name'] }}"
                                                    value="{{ $item['item_name'] . '_' . $item['item_price'] }}" />
                                                <label class="form-check-label"
                                                    for="{{ $item['item_name'] }}">{{ $item['item_name'] }}</label>
                                            </div>
                                        @endforeach
                                    @endif

                                    @if ($additional_product['is_optional'] == false && $additional_product['is_multiple'])
                                        @foreach ($additional_product['items'] as $item)
                                            <div key="{{ uniqid('item_input_') }}"
                                                class="form-check form-check-inline mt-3">
                                                <input wire:model="form.input_multiple_additional_products"
                                                    class="form-check-input" type="checkbox"
                                                    id="{{ $item['item_name'] }}"
                                                    value="{{ $additional_product['group_name'] . '_' . $item['item_name'] . '_' . $item['item_price'] }}" />
                                                <label class="form-check-label"
                                                    for="{{ $item['item_name'] }}">{{ $item['item_name'] }}</label>
                                            </div>
                                        @endforeach
                                    @endif

                                    @if ($additional_product['is_optional'] == false && $additional_product['is_multiple'] == false)
                                        @foreach ($additional_product['items'] as $item)
                                            <div key="{{ uniqid('item_input_') }}"
                                                class="form-check form-check-inline mt-3">
                                                <input
                                                    wire:model="form.input_single_additional_products.{{ $additional_product['group_name'] }}"
                                                    class="form-check-input" type="radio"
                                                    id="{{ $item['item_name'] }}"
                                                    value="{{ $item['item_name'] . '_' . $item['item_price'] }}" />
                                                <label class="form-check-label"
                                                    for="{{ $item['item_name'] }}">{{ $item['item_name'] }}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                @error('form.input_single_additional_products')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                @error('form.input_multiple_additional_products')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            @endforeach
                        </div>
                    @endif

                    <div class="d-flex gap-2">
                        <div>
                            <input wire:model="form.price_choose" class="form-check-input" type="radio"
                                value="{{ $normal }}" id="normal-radio" checked />
                            <label class="form-check-label" for="normal-radio">
                                Normal
                            </label>
                        </div>
                        <div>
                            <input wire:model="form.price_choose" class="form-check-input" type="radio"
                                value="{{ $takeaway }}" id="takeaway-radio" />
                            <label class="form-check-label" for="takeaway-radio">
                                Takeaway
                            </label>
                        </div>
                        @error('form.price_choose')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click="close" type="button" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
