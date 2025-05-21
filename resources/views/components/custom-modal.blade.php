<!-- resources/views/components/modal.blade.php -->
<div class="modal fade" id="{{ $id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="{{ $id }}Label">{{ $title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ $cancelLabel ?? __('Cancel') }}</button>
                <button type="button" id="submitButton" class="btn btn-primary" onclick="{{ $confirmAction ?? '' }}">{{ $confirmLabel ?? __('Confirm') }}</button>
            </div>
        </div>
    </div>
</div>