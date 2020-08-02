<!-- curriculum -->
<div class="card" id="course-curriculum">
    @forelse($course->units as $unit)
        @include("partials.learning.courses.curriculum." . strtolower($unit->unit_type))
    @empty
        <div class="empty-results">
            {{ __("El contenido de este curso todavía no está definido") }}
        </div>
    @endforelse
</div>
<!-- end curriculum -->
