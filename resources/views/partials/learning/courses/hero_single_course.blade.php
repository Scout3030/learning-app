<!-- Hero single course section -->
<section class="hero-section-single-course set-single-bg">
    <div class="container">
        <div class="hero-text-single-course text-white">
            <img alt="{{ $course->title }}" src="{{ $course->imagePath() }}" class="img-fluid" />
            <h2>{{ $course->title }}</h2>
            @include('partials.learning.courses.rating', ['rating' => $course->rating])
        </div>
    </div>
</section>
<!-- Hero single course section end -->
