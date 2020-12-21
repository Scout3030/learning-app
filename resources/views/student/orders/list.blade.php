<!-- orders section -->
<section class="course-section spad">
    <div class="container">
        <div class="section-title mb-4 mt-0 pt-0">
            <h2>{{ __("Tus pedidos") }}</h2>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="table-responsive">
                <table class="table">
                    @include("partials.student.orders.order_thead", ["detail" => false])
                    <tbody>
                        @forelse($orders as $order)
                            @include("partials.student.orders.order_row", ["detail" => false])
                        @empty
                            <tr class="text-center">
                                <td colspan="7">
                                    <div class="empty-results">
                                        {!! __("No tienes ningún pedido todavía") !!}
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            @if(count($orders))
                {{ $orders->links() }}
            @endif
        </div>
    </div>
</section>
<!-- orders end section -->
