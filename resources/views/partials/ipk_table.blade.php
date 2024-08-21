<thead>
    <tr class="fw-bold">
        <th class="text-center">Status</th>
        <th>NPM</th>
        <th>Nama Mahasiswa</th>
        <th>Terakhir KRS</th>
        <th>PA</th>
        <th>IPK</th>
    </tr>
</thead>
<tbody>
    @foreach ($dataStatus as $status => $dataIPK)
        @if (count($dataIPK) > 0)
            <tr>
                <td rowspan="{{ count($dataIPK) }}" class="text-center fw-bold">
                    {{ $status }}
                </td>
                @foreach ($dataIPK as $index => $mahasiswa)
                    @if ($index > 0)
            <tr>
        @endif
        <td>{{ $mahasiswa->NPM }}</td>
        <td>{{ $mahasiswa->Nama }}</td>
        <td>{{ $mahasiswa->Tahun_Terakhir_KRS }}</td>
        <td>{{ $mahasiswa->PA }}</td>
        <td>{{ $mahasiswa->IPK }}</td>
        @if ($index > 0)
            </tr>
        @endif
    @endforeach
    </tr>
    @endif
    @endforeach
</tbody>
