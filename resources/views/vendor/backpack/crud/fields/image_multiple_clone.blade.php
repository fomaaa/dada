<div hidden id="clone" class="form-group col-md-6 image clearfix"
     data-preview="#{{ $field['name'] }}" data-name="{{ $field['name'] }}"
     data-aspectRatio="{{ isset($field['aspect_ratio']) ? $field['aspect_ratio'] : 0 }}"
     data-crop-gallery="{{ isset($field['crop-gallery']) ? $field['crop-gallery'] : false }}" @include('crud::inc.field_wrapper_attributes')>
<!-- Wrap the image or canvas element with a block element (container) -->
<div class="row">
    <div class="col-sm-6" style="margin-bottom: 20px;">
        <img id="mainImage" src="">
    </div>
</div>
<div class="btn-group">
    <label class="btn btn-primary btn-file">
        {{ trans('backpack::crud.choose_file') }} <input type="file" accept="image/*"
                                                         id="uploadImage" @include('crud::inc.field_attributes', ['default_class' => 'hide'])>
        <input type="hidden" id="hiddenImage" name="{{ $field['name'] }}">
    </label>
    @if(isset($field['crop-gallery']) && $field['crop-gallery'])
    <button class="btn btn-default" id="rotateLeft" type="button" style="display: none;"><i
                class="fa fa-rotate-left"></i></button>
    <button class="btn btn-default" id="rotateRight" type="button" style="display: none;"><i
                class="fa fa-rotate-right"></i></button>
    <button class="btn btn-default" id="zoomIn" type="button" style="display: none;"><i
                class="fa fa-search-plus"></i></button>
    <button class="btn btn-default" id="zoomOut" type="button" style="display: none;"><i
                class="fa fa-search-minus"></i></button>
    <button class="btn btn-warning" id="reset" type="button" style="display: none;"><i
                class="fa fa-times"></i></button>
    @endif
    <button class="btn btn-danger" id="remove" type="button"><i class="fa fa-trash"></i></button>
</div>
</div>

@push('crud_fields_scripts')
    {{-- YOUR JS HERE --}}
    <script src="{{ asset('vendor/backpack/cropper/dist/cropper.min.js') }}"></script>
    <script>
        jQuery(document).ready(function ($) {


        });

    </script>
@endpush
