<?php


namespace App\Services;


use App\Helpers\Currency;
use App\Models\Coupon;
use App\Models\Course;
use Illuminate\Support\Collection;

class Cart
{
    /**
     * @var Collection
     */
    protected $cart;

    /**
     * Cart constructor
     */
    public function __construct()
    {
        if (session()->has("cart")) {
            $this->cart = session("cart");
        } else {
            $this->cart = new Collection;
        }
    }

    /**
     * Get cart content
     */
    public function getContent(): Collection {
        return $this->cart;
    }

    /**
     * Save the cart on session
     */
    protected function save(): void {
        session()->put("cart", $this->cart);
        session()->save();
    }

    /**
     * Add course on cart
     *
     * @param Course $course
     */
    public function addCourse(Course $course): void {
        $this->cart->push($course);
        $this->save();
    }

    /**
     * Remove course from cart
     *
     * @param int $id
     */
    public function removeCourse(int $id): void {
        $this->cart = $this->cart->reject(function (Course $course) use ($id) {
           return $course->id === $id;
        });
        $this->save();
    }

    /**
     * Calculate the total price
     *
     * @param bool $formatted
     * @return mixed|string
     */
    public function totalAmount($formatted = true) {
        $amount = $this->cart->sum(function (Course $course) {
            return $course->price;
        });
        if ($formatted) {
            return Currency::formatCurrency($amount);
        }
        return $amount;
    }

    /**
     * getting the taxes
     *
     * @param bool $formatted
     * @return float|int|string
     */
    public function taxes($formatted = true) {
        $total = $this->totalAmount(false);
        if ($total) {
            $total = ($total * env('TAXES')) / 100;
            if ($formatted) {
                return Currency::formatCurrency($total);
            }
            return $total;
        }
        return 0;
    }

    /**
     * Total products in cart
     *
     * @return int
     */
    public function hasProducts(): int {
        return $this->cart->count();
    }

    /**
     * Clear cart
     */
    public function clear(): void {
        $this->cart = new Collection;
        $this->save();
    }

    /**
     * @param bool $formatted
     * @return float|mixed|string
     */
    public function totalAmountWithDiscount($formatted = true) {
        $amount = $this->totalAmount(false);
        $withDiscount = $amount;
        if (session()->has("coupon")) {
            $coupon = Coupon::available(session("coupon"))->first();
            if (!$coupon) {
                return $amount;
            }

            $coursesInCart = $this->getContent()->pluck("id");
            if ($coursesInCart) {
                // courses attached to coupon in database
                $coursesForApply = $coupon->courses()->whereIn("id", $coursesInCart);

                // id courses attached on database for apply coupon
                $idCourses = $coursesForApply->pluck("id")->toArray();

                if (!count($idCourses)) {
                    $this->removeCoupon();
                    session()->flash("message", ["danger", __("El cupón no se puede aplicar")]);
                    return $amount;
                }

                // total price courses without discount applied
                $priceCourses = $coursesForApply->sum("price");

                // check discount type and apply
                if ($coupon->discount_type === Coupon::PERCENT) {
                    $discount = round($priceCourses - ($priceCourses * ((100 - $coupon->discount) / 100)), 2);
                    $withDiscount = $amount - $discount;
                }
                if ($coupon->discount_type === Coupon::PRICE) {
                    $withDiscount = $amount - $coupon->discount;
                }
            } else {
                $this->removeCoupon();
                return $amount;
            }
        }
        if ($formatted) {
            return Currency::formatCurrency($withDiscount);
        }
        return $withDiscount;
    }

    /**
     * remove coupon
     */
    protected function removeCoupon():void {
        session()->remove('coupon');
        session()->save();
    }
}