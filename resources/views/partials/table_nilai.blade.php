<div class="table-responsive-sm">
    <table class="table table-bordered border-dark">
        <thead>
            <tr class="text-center">
                <th>Tahun</th>
                <th>A</th>
                <th>B</th>
                <th>C</th>
                <th>D</th>
                <th>E</th>
                <th>A + B</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->Tahun }}</td>
                    <td>{{ number_format($item->A_percentage, 2) }}%</td>
                    <td>{{ number_format($item->B_percentage, 2) }}%</td>
                    <td>{{ number_format($item->C_percentage, 2) }}%</td>
                    <td>{{ number_format($item->D_percentage, 2) }}%</td>
                    <td>{{ number_format($item->E_percentage, 2) }}%</td>
                    <td>{{ number_format($item->A_percentage + $item->B_percentage, 2) }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
