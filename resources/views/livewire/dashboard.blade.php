<div class="w-screen mt-40 h-screen">
    <div class="w-full h-full">
        <table class="w-full p-8">
            <tr >
                <th class="text-xl p-4"> Celková cena </th>
                <th class="text-xl p-4"> Status objednávky </th>
                <th class="text-xl p-4"> Čas objednání </th>
            </tr>
            @foreach ($orders as $order)
                <tr class="border-gray-800 border-b">
                    <td class="text-center p-4"> {{ $order->orderItems->sum('seat.seatType.price') }} </td>

                    <td class="text-center p-4"> 

                        @if (($order->state->id ?? 0) === 1 && $order->created_at->addMinutes($verification_expire_time)->isPast())
                            Objednávce vypršela platnost
                        @else
                            {{ __('order_states.' . $order->state->state) }}
                        @endif
                    </td>
                    <td class="text-center p-4"> {{ $order->created_at->format('H:i:s d. m. Y') }} </td>
                    <td class="text-center"> <a href="{{ route('order', ['id' => $order->id]) }}" class="p-4 bg-gray-800 hover:bg-gray-700"> Podrobnosti  </a> </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="fixed inset-x-0 bottom-1 text-center">
        <button class="btn btn-secondary" wire:click="seatpicker"> Vybrat vstupenky </button>
    </div>
</div>
