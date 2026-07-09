@php
    $index = 1;
@endphp

@foreach($group as $kabupaten => $rows)
    <div class="card mb-2">
        <div class="card-header p-2">
            <a
                href="#"
                class="btn-kabupaten"
                data-target="#kabupaten{{ md5($kabupaten) }}">
                <i class="fa fa-chevron-right mr-2"></i>
                <strong>{{ $kabupaten }}</strong>
            </a>
        </div>
        <div
            id="kabupaten{{ md5($kabupaten) }}"
            class="collapse">
            <div class="card-body p-2">
                <table class="table table-bordered table-sm mb-0">
                    <thead>
                        <tr>
                            <th width="80">No</th>
                            <th width="120">Tahun</th>
                            <th>Nilai</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->tahun }}</td>
                                <td class="tdNilai" data-value="{{$row->nilai}}">{{ $row->nilai }}</td>
                                <td class="tdAction">
                                    <button type="button" id="{{$row->encrypted_id}}" class="editNilai btn btn-icon waves-effect btn-warning" title="Edit Nilai"><i class="fas fa-edit"></i></button>
                                    <button type="button" data-id="{{$row->encrypted_id}}" data-penyebab="{{$row->penyebab_deforestasi_id}}" class="deleteNilai btn btn-icon waves-effect btn-danger" title="Delete Nilai"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endforeach
