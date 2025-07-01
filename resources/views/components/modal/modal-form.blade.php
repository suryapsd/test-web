<style>
  .modal-scroll {
    max-height: 75vh;
    overflow-y: auto;
  }
</style>
<div class="modal fade" id="ajaxModal{{ $id }}" tabindex="-1" data-bs-focus="false" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog {{ $size }} ms-2 ms-sm-auto p-0">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span id="titleType"></span> {{ $title }}</h5>
        @if ($isrequired)
          <small style="font-size: 12px; color: red;" id="required-info">* is required</small>
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ $formAction }}" id="modalForm{{ $id }}" name="modalForm{{ $id }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
        @csrf
        <div class="modal-body {{ $modalScroll ? 'modal-scroll' : '' }}">
          <div class="row">
            {{ $slot }}
          </div>
        </div>
        <div class="modal-footer gap-2 pt-4 btnSection{{ $id }}">
          <button type="submit" class="m-0 btn btn-primary submitBtn{{ $id }}" id="saveBtn" data-initiate="0">Create</button>
          <button type="submit" class="m-0 btn btn-outline-primary submitBtn{{ $id }}" id="anotherBtn" data-text="Create another" data-initiate="1">Create another</button>
          <button type="button" class="m-0 btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
@push('script')
  <script>
    // $('#ajaxModal{{ $id }}').on('shown.bs.modal', function() {
    //   var $modalContent = $(this).find('.modal-scroll');
    //   var modalHeight = $modalContent.outerHeight();

    //   if (modalHeight > window.innerHeight * 0.75) {
    //     $modalContent.css('overflow-y', 'auto');
    //   } else {
    //     $modalContent.css('overflow-y', '');
    //   }
    // });
  </script>
@endpush
