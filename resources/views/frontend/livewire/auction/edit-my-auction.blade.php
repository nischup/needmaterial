<div>
    <form>
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

        <div class="mb-2">
            <div class="form-group mb-0">
                <label for="service_type"> {{ __('Service Type') }}</label>
                <input type="text" class="form-control" readonly value="{{ $auction->service }}">
            </div>
        </div>

        <div class="mb-2">
            <div class="form-group mb-0">
                <label for="service_type"> {{ __('Bid Type') }}</label>
                <input type="text" class="form-control input-group-sm" readonly value="{{ $is_open_bid ? 'Open Bid' : 'Close Bid' }}">
            </div>
        </div>

        <div class="mb-2">
            <div class="form-group mb-0">
                <label for="title">{{ __('Auction Title') }}</label>
                <input type="text" class="input-group-sm" id="title" wire:model.defer="title">
            </div>
            @error('title') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>

        <div class="mb-30">
            <div class="form-group mb-0" wire:ignore>
                <label for="description_input">{{ __('Auction Description') }}</label>
                <textarea id="editor" rows="5">{!! $description !!}</textarea>
            </div>
            @error('description') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>

        <div class="mb-30">
            <div class="form-group mb-0">
                <label for="comment">{{ __('Comment') }}:</label>
                <textarea placeholder="{{ __('Comment') }}" wire:model.defer="comment" rows="2" style="height: unset"></textarea>
                @error('comment') <span class="text-danger error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="row mb-30">
            <div class="col-md-4">
                <div class="form-group mb-0">
                    <label>{{ __('Start time') }}:</label>
                    <input type="datetime-local" class="form-control" placeholder="{{ __('Start time') }}" wire:model.defer="start_time"/>
                    @error('start_time') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mb-0">
                    <label>{{ __('End time') }}:</label>
                    <input type="datetime-local" class="form-control" placeholder="{{ __('End time') }}" wire:model.defer="end_time"/>
                    @error('end_time') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mb-0">
                    <label>{{ __('Delivery Date') }}:</label>
                    <input class="form-control" type="date" wire:model.defer="delivery_date" placeholder="{{ __('Delivery Date') }}">
                    @error('delivery_date') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div class="row mb-30">
            <div class="col-md-6">
                <div class="form-group mb-0">
                    <input class="form-check-input ml-0" value="1" type="checkbox" wire:model.defer="included_delivery_cost" style="height: auto" id="included_delivery_cost"><label>{{ __('With Delivery Charge') }}</label>
                    @error('included_delivery_cost') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-0">
                    <input class="form-check-input" type="checkbox" wire:model.defer="vat" style="height: auto" id="vat"><label>{{ __('With VAT') }}</label>
                    @error('vat') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>
        <div class="form-group mb-0">
            <button type="button" wire:click.prevent="update" class="custom-button">{{ __('Update') }}</button>
        </div>
    </form>
</div>

@push('scripts')
    <script src="https://cdn.tiny.cloud/1/17ycczrflflupm9i12k8e0q2tp8gua0mlhkzcb1kkbirlaxv/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: '#editor',
            init_instance_callback: function (editor) {
                var freeTiny = document.querySelector('.tox .tox-notification--in');
                freeTiny.style.display = 'none';
            },
            menubar: false,
            statusbar: false,
            plugins: 'autoresize anchor autolink charmap code codesample directionality fullpage help hr image imagetools insertdatetime link lists media nonbreaking pagebreak preview print searchreplace table template textpattern toc visualblocks visualchars',
            toolbar: 'h1 h2 bold italic strikethrough blockquote bullist numlist backcolor | link image media | removeformat help fullscreen ',
            skin: 'bootstrap',
            toolbar_drawer: 'floating',
            min_height: 200,
            autoresize_bottom_margin: 16,
            onchange_callback : "loadTextEditorContent",
            setup: (editor) => {
                editor.on('init', () => {
                    editor.getContainer().style.transition = "border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out"
                });
                editor.on('focus', () => {
                    editor.getContainer().style.boxShadow = "0 0 0 .2rem rgba(0, 123, 255, .25)",
                        editor.getContainer().style.borderColor = "#80bdff"
                });
                editor.on('blur', () => {
                    editor.getContainer().style.boxShadow = "",
                        editor.getContainer().style.borderColor = ""
                });
                editor.on('change', function (e) {
                    loadTextEditorContent(editor.getContent());
                    console.log('change event fired');
                });
            }
        });


        function loadTextEditorContent(contents) {
            @this.set('description', contents, true);
        }
    </script>
@endpush
