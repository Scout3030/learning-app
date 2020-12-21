<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Response;
use Laravel\Cashier\Http\Controllers\WebhookController;

class StripeWebHookController extends Controller
{
    /**
     * @param $payload
     * @return Response
     */
    public function handleChargeSucceeded($payload) {
        try {
            $invoide_id = $payload['data']['object']["invoice"];
            $user = $this->getUserByStripeId($payload['data']['object']['customer']);

            if ($user) {
                $order = $user->orders()
                    ->where("status", Order::PENDING)
                    ->latest()
                    ->first();
                if ($order) {
                   $order->update([
                       'invoice_id' => $invoide_id,
                       'status' => Order::SUCCESS
                   ]);

                   //ATTACH COURSES FOR USER
                    $coursesId = $order->orderLines()->pluck("course_id");
                    Log::info(json_encode($coursesId));
                    $user->courses_learning()->attach($coursesId);

                    Log::info(json_encode($user));
                    Log::info(json_encode($order));
                    Log::info("Pedido actualizado correctamente");
                    return new Response('Webhook Handled: {handleChargeSucceeded}', 200);

                }
            }

        }catch (\Exception $exception) {
            Log::debug("Exception Webhook {handleChargeSucceeded}:".$exception->getMessage());
            return new Response('Webhook Handled: {handleChargeSucceeded}', 200);
        }
    }
}
