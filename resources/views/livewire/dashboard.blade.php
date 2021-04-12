<div class="w-screen mt-40 h-screen">
    {{-- <table class="my-8">
        <tr class="bg-blue-400">
        <td class="p-2">STUFF</td>
        </tr>
        <tr class="h-4">
        <td></td>
        </tr>
        <tr class="bg-blue-400">
        <td class="p-2">MORE STUFF</td>
        </tr>
        </table> --}}
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
                    <td class="text-center p-4"> {{ __('order_states.' . $order->state->state) }} </td>
                    <td class="text-center p-4"> {{ $order->created_at->format('H:i:s d. m. Y') }} </td>
                    <td class="text-center"> <a href="{{ url('order ' . $order->id) }}" class="p-4 bg-gray-800 hover:bg-gray-700"> Podrobnosti  </a> </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
