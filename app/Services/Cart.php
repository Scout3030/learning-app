<?php


namespace App\Services;


use App\Helpers\Currency;
use App\Models\Course;
use Illuminate\Support\Collection;

class Cart
{
    /**
     * @var Collection
     */
    protected Collection $cart;

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

}