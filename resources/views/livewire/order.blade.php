<div class="w-screen mt-40 h-screen">
    <div class="w-full h-full">
        <h2 class="text-2xl text-center my-8"> Objednávka </h2>
        <table class="w-full p-8">
            <tr>
                <th class="text-xl p-4"> Cena vstupenky </th>
                <th class="text-xl p-4"> Číslo vstupenky </th>
                <th class="text-xl p-4"> Typ vstupenky </th>
            </tr>
            @foreach ($order->orderItems as $orderItem)
                <tr class="border-gray-800 border-b">
                    <td class="text-center p-4"> {{ $orderItem->seat->seatType->price }}Kč </td>
                    <td class="text-center p-4"> {{ $orderItem->seat->number }} </td>
                    <td class="text-center p-4"> {{ $orderItem->seat->seatType->type }} </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
