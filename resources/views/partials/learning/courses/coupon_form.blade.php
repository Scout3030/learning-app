<form
    class="intro-newslatter"
    action="{{ route('apply_coupon') }}"
    method="POST"
>
    @csrf
    <input
        type="text"
        name="coupon"
        placeholder="{{ __("¿Tienes un cupón de descuento?") }}"
        value="{{ session("coupon") }}"
    />
    <button type="submit" class="site-btn">
        {{ __("Canjear") }}
    </button>
</form>
