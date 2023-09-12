<form>

    @if($categories)
        <div class="row mb-30">
            <div class="col-md-6">
                <div class="form-group mb-0">
                    <label for="p_category">{{ __('Select Category') }}</label>
                    <select class="form-select pl-3" id="p_category" wire:model.defer="p_category" wire:click="p_categoryChanged($event.target.value)">
                        <option selected >{{ __('Select Category') }}</option>
                        @foreach($categories as $item)
                            <option value="{{ $item['id'] }}">{{ $item[$category_column] ? $item[$category_column] : $item['name_en'] }}</option>
                        @endforeach
                    </select>
                </div>
                @error('p_category') <span class="text-danger error">{{ $message }}</span>@enderror
            </div>
            <div class="col-md-6">
                <div class="form-group mb-0">
                    <label for="category">{{ __('Select Sub Category') }}</label>
                    <select class="form-select pl-3" id="category" wire:model.defer="category">
                        <option selected>{{ __('Select Sub Category') }}</option>
                        @if($child_categories)
                            @foreach($child_categories as $child_category)
                                <option value="{{ $child_category['id'] }}">{{ $child_category[$category_column] ? $child_category[$category_column] : $child_category['name_en'] }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                @error('category') <span class="text-danger error">{{ $message }}</span>@enderror
            </div>
        </div>
    @endif

    <div class="form-group">
        <label for="title">{{ __('Title') }}</label>
        <input type="text" class="form-control form-control-sm" id="title" wire:model.defer="title" placeholder="Enter Title">
        @error('title') <span class="text-danger error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="description">{{ __('Description') }}</label>
        <textarea class="form-control form-control-sm" id="description" wire:model.defer="description" placeholder="Enter description"></textarea>
        @error('description') <span class="text-danger error">{{ $message }}</span> @enderror
    </div>
    @if($editing && count($oldImages))
        <table class="table table-sm">
            <thead>
            <th>Previous Image</th>
            <th>Action</th>
            </thead>
            <tbody>
            @foreach($oldImages as $key => $image)
            <tr>
                <td><img src="{{ $image->src }}" width="50px" alt=""></td>
                <td><a href="#" wire:click.prevent="imageDelete({{ $image->id }}, {{ $key }})">Delete</a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    @endif

    @if ($images && count($images))
        {{ __('Photo Preview') }}:
        @foreach ($images as $image)
            <img class="img-thumbnail" src="{{ $image->temporaryUrl() }}" style="height: 100px">
        @endforeach
    @endif

    <div class="form-group">
        <label for="images">{{ __('Images') }}</label>
        <input type="file" multiple id="images" wire:model="images">
        <div wire:loading wire:target="images">{{ __('Uploading') }}...</div>
        @error('images') <span class="text-danger error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group mb-0">
        @if($editing)
            <button type="button" class="btn btn-info" wire:click.prevent="update">Update</button>
        @else
            <button type="button" class="btn btn-info" wire:click.prevent="store">Save</button>
        @endif
    </div>
</form>
