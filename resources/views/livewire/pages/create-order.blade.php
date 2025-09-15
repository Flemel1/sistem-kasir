@section('title', 'Buat Pesanan')

<div>
    <div class="row">
        <div class="col-sm-8 col-md-8 col-lg-8">
            <div class="row">
                @foreach ($products as $product)
                    <livewire:components.card-product :key="uniqId('product_')" :id="$product->id" :title="$product->product_name"
                        :description="$product->product_description" :price="$product->product_price" :takeawayprice="$product->product_takeaway_price" />
                @endforeach

            </div>
        </div>
        <div class="col-sm-4 col-md-4 col-lg-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h3>Pesanan</h3>
                    <ol>
                        @foreach ($currentOrders as $order)
                            <li>
                                <div class="row">
                                    <p class="w-75 m-0">{{ $order['product_name'] }} x{{ $order['amount'] }}</p>
                                    <div class="w-25 row">
                                        <span wire:click="edit_product('{{ $order['identifier'] }}')"
                                            class="p-0 btn text-primary">Edit</span>
                                        <span wire:click="remove_product('{{ $order['identifier'] }}')"
                                            class="p-0 btn text-danger">Hapus</span>
                                    </div>

                                </div>
                                @foreach ($order['additional_products'] as $key => $additional_product)
                                    <p class="mb-0"> {{ $key }} {{ ' : ' }}
                                        @foreach ($additional_product as $item)
                                            {{ $item['name'] }}
                                        @endforeach
                                    </p>
                                @endforeach
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h3>Total</h3>
                    <p>Rp. {{ number_format($total, thousands_separator: '.') }}</p>
                </div>
            </div>
            @if (sizeof($currentOrders) > 0)
                <button wire:click="open_create_order_modal" type="button" class="btn btn-success">Pesan</button>
            @endif
        </div>
    </div>

    <livewire:components.modal-order />
    <livewire:components.modal-create-order />
    @livewire('components.notification-toast')

    @script
        <script>
            $wire.on('open-modal', () => {
                $('#modal').show()
                $('.modal').addClass('show')
            })

            $wire.on('open-edit-modal', () => {
                $('#modal').show()
                $('.modal').addClass('show')
            })

            $wire.on('close-modal', () => {
                $('#modal').hide()
                $('.modal').removeClass('show')
            })

            $wire.on('add-product', () => {
                $('#modal').hide()
                $('.modal').removeClass('show')
            })

            $wire.on('update-product-state', () => {
                $('#modal').hide()
                $('.modal').removeClass('show')
            })

            $wire.on('open-create-order-modal', () => {
                $('#modal-create-order').show()
                $('#modal-create-order').addClass('show')
            })
            $wire.on('close-create-order-modal', () => {
                $('#modal-create-order').hide()
                $('#modal-create-order').removeClass('show')
            })

            $wire.on('create-order-status', (detail) => {
                const {
                    type,
                    message
                } = detail[0]
                const toastEl = $('#notification-toast')
                const toastBody = $('#notification-toast .toast-body')

                if (type === 'error') {
                    toastEl.addClass('bg-danger')
                } else {
                    toastEl.addClass('bg-success')
                }
                const toast = new bootstrap.Toast(toastEl)
                toastBody.text(message)
                toast.show()
            })
        </script>
    @endscript
</div>
