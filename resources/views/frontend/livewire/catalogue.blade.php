<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="header" style="margin-bottom: unset">
        <h4 class="title" style="width: unset">Catalogue</h4>
        <div style="margin-bottom: 10px; text-align: right">
            @if($creating || $editing)
                <button type="button" wire:click.prevent="showAll" style="width: auto" class="btn btn-primary btn-sm">Show All</button>
            @else
                <button type="button" wire:click.prevent="createNew" style="width: auto" class="btn btn-primary btn-sm">Create new</button>
            @endif
        </div>
    </div>

    @if($creating || $editing)
        @include('frontend.livewire.partial.manage-catalogue')
    @else
    <table class="table table-sm">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Thumbnail</th>
            <th scope="col">Title</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        @if($catalogues)
        <tbody>
            @foreach($catalogues as $catalogue)
            <tr>
                <th scope="row">{{ $catalogue->id }}</th>
                <td>
                    @php
                    $thumbnail = count($catalogue->images) ? $catalogue->images[0]->src : asset('frontend\images\product-placeholder.webp');
                    @endphp
                    <img height="70px" src="{{ $thumbnail }}" alt="{{ $catalogue->title }}">
                </td>
                <td>{{ $catalogue->title }}</td>
                <td>
                    <a href="#" wire:click.prevent="edit({{ $catalogue->id }})">Edit</a>
                    <a href="#" wire:click.prevent="delete({{ $catalogue->id }})">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>

        @endif
    </table>
    {{ $catalogues->links() }}
    @endif
</div>
