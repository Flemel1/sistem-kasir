<div class="col-sm-12 col-md-6 col-lg-4 mb-3">
    <div class="card h-100">
        <div class="card-body">
            <h5 class="card-title">{{ $model->title }}</h5>
            <p class="card-text">
                {{ $model->description }}
            </p>
        </div>
        <div class="card-footer">
            <button wire:click="open_modal({{ $model->id }})" type="button" class="btn btn-primary">Pilih</button>
        </div>
    </div>
</div>
