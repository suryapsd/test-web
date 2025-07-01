<div id="step-{{ $contentNum }}" class="content">
  <div class="content-header mb-3">
    <h6 class="mb-0">{{ $title }}</h6>
    <small>{{ $desc }}</small>
  </div>
  <div class="row g-3">
    {{ $slot }}
  </div>
  <div class="col-12 d-flex justify-content-between mt-3">
    @if (!$isFirst)
      <button class="btn btn-label-secondary btn-prev">
        <i class="ti ti-arrow-left me-sm-1 me-0"></i>
        <span class="align-middle d-sm-inline-block d-none">Previous</span>
      </button>
    @endif
    @if (!$isLast)
      <button class="btn btn-primary btn-next">
        <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
        <i class="ti ti-arrow-right"></i>
      </button>
    @else
      <button class="btn btn-success btn-submit">Submit</button>
    @endif
  </div>
</div>
