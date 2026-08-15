@extends('backend.layouts.app')
@section('title', 'Data Kawasan Hutan | REDD++ Kalimantan Barat')
@section('header', 'Data Kawasan Hutan')

@section('css')
    <link href="{{ asset('/backend_template/libs/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/datatables/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/datatables/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/datatables/select.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/custombox/custombox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/backend_template/libs/dropify/dropify.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <style>
        .table th {
            text-align: center;
        }
        .table td {
            justify-content: center;
            text-align: center;
        }

        .select2-container .select2-selection--single {
            height: 38px;           /* samakan dengan input/select */
            display: flex;
            align-items: center;    /* center vertical */
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;   /* samakan dengan height */
            padding-left: 10px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px;
            top: 0;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #0d6efd; /* biru bootstrap */
            border-color: #0d6efd;
            color: white;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box table-responsive">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <h4 class="mt-0 header-title">Tabel Data</h4>
                    </div>
                    <div class="col-md-6 text-right">
                        <button class="btn btn-icon waves-effect waves-light btn-primary" data-toggle="modal" data-target="#createModal" id="create" name="create">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <table id="table_data_kawasan" class="table table-bordered table-bordered dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Kawasan Hutan</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div> <!-- end row -->

    <div id="createModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="createModalLabel">Tambah Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form class="form-horizontal" id="form_kawasan_hutan" method="POST" data-parsley-validate novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="kawasanHutanId" class="control-label">Kawasan Hutan</label>
                                    <select name="kawasan_hutan_id" id="kawasanHutanId" class="form-control" required>
                                        <option value="">Pilih Hutan</option>
                                        @foreach ($kawasanHutans as $kawasanHutan)
                                            <option value="{{$kawasanHutan['id']}}">{{$kawasanHutan['nama']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="tahunDari" class="control-label">Dari Tahun</label>
                                            <select id="tahunDari" class="form-control" required>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="tahunSampai" class="control-label">Sampai Tahun</label>
                                            <select id="tahunSampai" class="form-control" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tahun</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyKawasan">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect width-md waves-light" data-dismiss="modal">Close</button>
                    <input type="hidden" name="aksi" id="aksi" value="Save">
                    <input type="hidden" name="hidden_id" id="hidden_id">
                    <button type="submit" name="aksi_button" id="aksi_button" class="btn btn-primary waves-effect width-md waves-light">Save</button>
                </div>
            </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection

@section('js')
    <!-- third party js -->
    <script src="{{ asset('/backend_template/libs/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/pdfmake/vfs_fonts.js') }}"></script>
    <!-- third party js ends -->

    <!-- Datatables init -->
    <script src="{{ asset('/backend_template/js/pages/datatables.init.js') }}"></script>
    <!-- Validation js (Parsleyjs) -->
    <script src="{{ asset('/backend_template/libs/parsleyjs/parsley.min.js') }}"></script>

    <!-- validation init -->
    <script src="{{ asset('/backend_template/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/dropify/dropify.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        $('#kawasanHutanId, #tahunDari, #tahunSampai').select2();

        const currentYear = new Date().getFullYear();
        const startYear = 2000;

        var dataTables = $('#table_data_kawasan').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('cms.data-kawasan.datatable') }}",
            },
            columns:[
                {
                    data: 'DT_RowIndex'
                },
                {
                    data: 'kawasan',
                    name: 'kawasan'
                },
                {
                    data: 'nilai',
                    name: 'nilai',
                    orderable:false,
                    searchable:false
                }
            ]
        });

        for (let year = currentYear; year >= startYear; year--) {
            $('#tahunDari, #tahunSampai').append(
                `<option value="${year}" ${year === currentYear ? 'selected' : ''}>${year}</option>`
            );
        }

        $('#tahunDari').on('change', function () {
            const dari = parseInt($(this).val());

            $('#tahunSampai option').each(function () {
                const tahun = parseInt($(this).val());

                if (!isNaN(tahun)) {
                    $(this).prop('disabled', tahun < dari);
                }
            });

            if (parseInt($('#tahunSampai').val()) < dari) {
                $('#tahunSampai').val(dari);
            }
        });

        $('#tahunSampai').on('change', function () {
            const sampai = parseInt($(this).val());

            $('#tahunDari option').each(function () {
                const tahun = parseInt($(this).val());

                if (!isNaN(tahun)) {
                    $(this).prop('disabled', tahun > sampai);
                }
            });

            if (parseInt($('#tahunDari').val()) > sampai) {
                $('#tahunDari').val(sampai);
            }
        });

        $('#tahunDari, #tahunSampai').on('change', function () {
            generateTable();
        });

        function generateTable() {
            let dari = parseInt($('#tahunDari').val());
            let sampai = parseInt($('#tahunSampai').val());

            if (dari > sampai) {
                alert('Tahun Dari tidak boleh lebih besar dari Tahun Sampai');
                return;
            }

            let html = '';
            let index = 0;

            for (let tahun = dari; tahun <= sampai; tahun++) {

                html += `
                    <tr>
                        <td>
                            ${tahun}
                            <input type="hidden"
                                name="data_kawasan[${index}][tahun]"
                                value="${tahun}">
                        </td>
                        <td>
                            <input
                                type="text"
                                class="form-control"
                                name="data_kawasan[${index}][nilai]">
                        </td>
                    </tr>
                `;

                index++;
            }

            $('#tbodyKawasan').html(html);
        }

        function reset()
        {
            $('#form_kawasan_hutan')[0].reset();
            $('#tahunDari').val(currentYear).trigger('change');
            $('#tahunSampai').val(currentYear).trigger('change');
            $('#kawasanHutanId').val('').trigger('change');
            generateTable();
        }

        $('#create').click(function(){
            reset();
            $('#form_result').html('');
            $('#aksi_button').text('Save');
            $('#aksi_button').prop('disabled', false);
            $('.modal-title').text('Tambah Data');
            $('#aksi_button').val('Save');
            $('#aksi').val('Save');
        });

        $('#form_kawasan_hutan').on('submit', function(e){
            e.preventDefault();
            if($('#aksi').val() == 'Save')
            {
                $.ajax({
                    url: "{{ route('cms.data-kawasan.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    beforeSend: function()
                    {
                        $('#aksi_button').text('Menyimpan...');
                        $('#aksi_button').prop('disabled', true);
                    },
                    success: function(data)
                    {
                        var html = '';
                        if(data.errors)
                        {
                            html = '<div class="alert alert-danger">'+data.errors+'</div>';
                            $('#aksi_button').prop('disabled', false);
                            reset();
                            $('#aksi_button').text('Save');
                            $('#data-kawasan').DataTable().ajax.reload();
                        }
                        if(data.success)
                        {
                            html = '<div class="alert alert-success">'+data.success+'</div>';
                            $('#aksi_button').prop('disabled', false);
                            reset();
                            $('#aksi_button').text('Save');
                            $('#data-kawasan').DataTable().ajax.reload();
                        }

                        $('#form_result').html(html);
                    }
                });
            }
        });

        $(document).on('click', '.deleteData',function(){
            var id = $(this).attr('id');
            var url = "{{ route('cms.data-kawasan.destroy.data', ['id' => ":id"]) }}";
            url = url.replace(":id", id);
            return new swal({
                title: "Apakah Anda Yakin Menghapus Ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#1976D2",
                confirmButtonText: "Ya"
            }).then((result)=>{
                if(result.value)
                {
                    $.ajax({
                        url: url,
                        dataType: "json",
                        beforeSend: function()
                        {
                            return new swal({
                                title: "Checking...",
                                text: "Harap Menunggu",
                                imageUrl: "{{ asset('/images/preloader.gif') }}",
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
                        },
                        success: function(data)
                        {
                            if(data.errors)
                            {
                                Swal.fire({
                                    icon: 'errors',
                                    title: data.errors,
                                    showConfirmButton: true
                                });
                            }
                            if(data.success)
                            {
                                $('#table_data_kawasan').DataTable().ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: data.success,
                                    showConfirmButton: true
                                });
                            }
                        }
                    });
                }
            });
        });

        let editing = false;

        $(document).on('click', '.editNilai', function () {
            if (editing) {
                alert('Selesaikan edit yang sedang berlangsung.');
                return;
            }

            editing = true;
            var btn = $(this);
            var id = btn.attr('id');
            // baris yang dipilih
            var tr = btn.closest('tr');
            // ambil nilai lama
            var tdNilai = tr.find('.tdNilai');
            var nilai = tdNilai.attr('data-value');
            // ubah td menjadi input
            tdNilai.html(
                '<input type="string" class="form-control inputNilai" value="' + nilai + '">'
            );
            // ubah tombol menjadi save
            tr.find('.tdAction').html(
                '<button type="button" class="saveNilai btn btn-success" data-id="' + id + '">' +
                    '<i class="fas fa-save"></i> Save' +
                '</button>'
            );
        });

        $(document).on('click', '.saveNilai', function () {
            var btn = $(this);
            var id = btn.data('id');
            var tr = btn.closest('tr');
            var nilaiBaru = tr.find('.inputNilai').val();
            return new swal({
                title: "Apakah Anda Yakin Merubah Ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#1976D2",
                confirmButtonText: "Ya"
            }).then((result)=>{
                if(result.value)
                {
                    $.ajax({
                        url: "{{ route('cms.data-kawasan.update.nilai') }}",
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id,
                            nilai: nilaiBaru
                        },
                        beforeSend: function()
                        {
                            return new swal({
                                title: "Checking...",
                                text: "Harap Menunggu",
                                imageUrl: "{{ asset('/images/preloader.gif') }}",
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
                        },
                        success: function (data) {
                            if(data.errors)
                            {
                                Swal.fire({
                                    icon: 'errors',
                                    title: data.errors,
                                    showConfirmButton: true
                                });
                            }
                            if(data.success)
                            {
                                Swal.fire({
                                    icon: 'success',
                                    title: data.success,
                                    showConfirmButton: true
                                });
                                // kembalikan input menjadi text
                                tr.find('.tdNilai').text(nilaiBaru);
                                tr.find('.tdNilai').attr("data-value", nilaiBaru);
                                // kembalikan tombol edit & delete
                                tr.find('.tdAction').html(
                                    '<button type="button" id="' + id + '" class="editNilai btn btn-warning">' +
                                        '<i class="fas fa-edit"></i>' +
                                    '</button> ' +
                                    '<button type="button" id="' + id + '" class="deleteNilai btn btn-danger">' +
                                        '<i class="fas fa-trash"></i>' +
                                    '</button>'
                                );
                                // tampilkan semua tombol lagi
                                $('.editNilai, .deleteNilai').show();
                            }
                        }
                    });
                    editing = false;
                }
            });
        });

        $(document).on('click', '.deleteNilai',function(){
            var id = $(this).attr('id');
            var url = "{{ route('cms.data-kawasan.destroy.nilai', ['id' => ":id"]) }}";
            url = url.replace(":id", id);
            return new swal({
                title: "Apakah Anda Yakin Menghapus Ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#1976D2",
                confirmButtonText: "Ya"
            }).then((result)=>{
                if(result.value)
                {
                    $.ajax({
                        url: url,
                        dataType: "json",
                        beforeSend: function()
                        {
                            return new swal({
                                title: "Checking...",
                                text: "Harap Menunggu",
                                imageUrl: "{{ asset('/images/preloader.gif') }}",
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
                        },
                        success: function(data)
                        {
                            if(data.errors)
                            {
                                Swal.fire({
                                    icon: 'errors',
                                    title: data.errors,
                                    showConfirmButton: true
                                });
                            }
                            if(data.success)
                            {
                                $('#table_data_kawasan').DataTable().ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: data.success,
                                    showConfirmButton: true
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
