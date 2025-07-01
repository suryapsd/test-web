  <div class="step" data-target="#step-{{ $stepNum }}">
    <button type="button" class="step-trigger">
      <span class="bs-stepper-circle">{{ $stepNum }}</span>
      <span class="bs-stepper-label mt-1">
        <span class="bs-stepper-title">{{ $title }}</span>
        <span class="bs-stepper-subtitle">{{ $subtitle }}</span>
      </span>
    </button>
  </div>
  @if ($chevron)
    <div class="line">
      <i class="ti ti-chevron-right"></i>
    </div>
  @endif
