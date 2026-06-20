@extends('backend.layouts.app')
@section('title', 'LSM | Master Data | REDD++ Kalimantan Barat')
@section('header', 'LSM | Master Data')

@section('css')
    <link href="{{ asset('/backend_template/libs/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/datatables/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/datatables/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/datatables/select.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/custombox/custombox.min.css') }}" rel="stylesheet">
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
                <table id="table_md_lsm" class="table table-bordered table-bordered dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Aksi</th>
                            <th>Nama</th>
                            <th>Kabupaten/Kota</th>
                            <th>Wilayah Cakupan</th>
                            <th>Link</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div> <!-- end row -->

    <div id="createModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="createModalLabel">Tambah Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form class="form-horizontal" id="form_md_lsm" method="POST" data-parsley-validate novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="nama" class="control-label">Nama LSM<span class="text-danger">*</span></label>
                            <input type="text" name="nama" id="nama" parsley-trigger="change" required
                            placeholder="Masukan nama LSM..." class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="link" class="control-label">Link<span class="text-danger">*</span></label>
                            <input type="text" name="link" id="link" parsley-trigger="change" required
                            placeholder="Masukan link..." class="form-control">
                            <span id="error" style="color:red"></span>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="kabupaten_kota_id" class="control-label">Kabupaten/Kota</label>
                                    <select name="kabupaten_kota_id" id="kabupaten_kota_id" class="form-control" required>
                                        <option value="">Pilih</option>
                                        @foreach ($kabupatenKotas as $kabupatenKota)
                                            <option value="{{$kabupatenKota['id']}}">{{$kabupatenKota['nama']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="md_wilayah_cakupan_id" class="control-label">Wilayah Cakupan</label>
                                    <select name="md_wilayah_cakupan_id" id="md_wilayah_cakupan_id" class="form-control" required>
                                        <option value="">Pilih</option>
                                        @foreach ($wilayahCakupans as $wilayahCakupan)
                                            <option value="{{$wilayahCakupan['id']}}">{{$wilayahCakupan['nama']}}</option>
                                        @endforeach
                                    </select>
                                </div>
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

    <div id="detail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="detailModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="detail-title">Detail Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="detail_nama" class="control-label col-md-6">Nama LSM</label>
                        <div class="col-md-6">
                            <span id="detail_nama"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="detail_kabupaten_kota" class="control-label col-md-6">Kabupaten/Kota</label>
                        <div class="col-md-6">
                            <span id="detail_kabupaten_kota"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="detail_wilayah_cakupan" class="control-label col-md-6">Wilayah Cakupan</label>
                        <div class="col-md-6">
                            <span id="detail_wilayah_cakupan"></span>
                        </div>
                    </div>
                </div>
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
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        $('#kabupaten_kota_id').select2();
        $('#md_wilayah_cakupan_id').select2();
        var dataTables = $('#table_md_lsm').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('cms.master-data.lsm.datatable') }}",
            },
            columns:[
                {
                    data: 'DT_RowIndex'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'kabupaten_kota_id',
                    name: 'kabupaten_kota_id'
                },
                {
                    data: 'md_wilayah_cakupan_id',
                    name: 'md_wilayah_cakupan_id'
                },
                {
                    data: 'link',
                    name: 'link'
                }
            ]
        });

        function reset()
        {
            $('#form_md_lsm')[0].reset();
            $("[name='kabupaten_kota_id']").val('').trigger('change');
            $("[name='md_wilayah_cakupan_id']").val('').trigger('change');
        }

        $('#create').click(function(){
            reset();
            $('#aksi_button').text('Save');
            $('#aksi_button').prop('disabled', false);
            $('.modal-title').text('Add Data');
            $('#aksi_button').val('Save');
            $('#aksi').val('Save');
            $('#form_result').html('');
        });

        $('#form_md_lsm').on('submit', function(e){
            e.preventDefault();
            if($('#aksi').val() == 'Save')
            {
                $.ajax({
                    url: "{{ route('cms.master-data.lsm.store') }}",
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
                            $('#table_md_lsm').DataTable().ajax.reload();
                        }
                        if(data.success)
                        {
                            html = '<div class="alert alert-success">'+data.success+'</div>';
                            $('#aksi_button').prop('disabled', false);
                            reset();
                            $('#aksi_button').text('Save');
                            $('#table_md_lsm').DataTable().ajax.reload();
                        }

                        $('#form_result').html(html);
                    }
                });
            }
            if($('#aksi').val() == 'Edit')
            {
                $.ajax({
                    url: "{{ route('cms.master-data.lsm.update') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    beforeSend: function(){
                        $('#aksi_button').text('Mengubah...');
                        $('#aksi_button').prop('disabled', true);
                    },
                    success: function(data)
                    {
                        var html = '';
                        if(data.errors)
                        {
                            html = '<div class="alert alert-danger">'+data.errors+'</div>';
                            $('#aksi_button').prop('disabled', false);
                            $('#aksi_button').text('Edit');
                        }
                        if(data.success)
                        {
                            reset();
                            $('#aksi_button').prop('disabled', false);
                            $('#aksi_button').text('Save');
                            $('#table_md_lsm').DataTable().ajax.reload();
                            $('#createModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil di ubah',
                                showConfirmButton: true
                            });
                        }

                        $('#form_result').html(html);
                    }
                });
            }
        });

        $(document).on('click', '.detail', function(){
            var id = $(this).attr('id');
            var url = "{{ route('cms.master-data.lsm.show', ['id' => ":id"]) }}";
            url = url.replace(":id", id);
            $.ajax({
                url: url,
                dataType: "json",
                success: function(data)
                {
                    $('#detail-title').text('Detail Data');
                    $('#detail_nama').text(data.result.nama);
                    $('#detail_kabupaten_kota').text(data.result.kabupaten_kota);
                    $('#detail_wilayah_cakupan').text(data.result.wilayah_cakupan);
                    $('#detail').modal('show');
                }
            });
        });

        $(document).on('click', '.edit', function(){
            var id = $(this).attr('id');
            var url = "{{ route('cms.master-data.lsm.edit', ['id' => ":id"]) }}";
            url = url.replace(":id", id);

            $('#form_result').html('');
            $.ajax({
                url: url,
                dataType: "json",
                success: function(data)
                {
                    $('#nama').val(data.result.nama);
                    $('#link').val(data.result.link);

                    let targetKabupatenKota = data.result.kabupaten_kota;
                    let valueKabupatenKota = $('#kabupaten_kota_id option').filter(function () {
                        return $(this).text() === targetKabupatenKota;
                    }).val();
                    $("[name='kabupaten_kota_id']").val(valueKabupatenKota).trigger('change');

                    let targetWilayahCakupan = data.result.wilayah_cakupan;
                    let valueWilayahCakupan = $('#md_wilayah_cakupan_id option').filter(function () {
                        return $(this).text() === targetWilayahCakupan;
                    }).val();
                    $("[name='md_wilayah_cakupan_id']").val(valueWilayahCakupan).trigger('change');

                    $('#hidden_id').val(id);
                    $('.modal-title').text('Edit Data');
                    $('#aksi_button').text('Edit');
                    $('#aksi_button').prop('disabled', false);
                    $('#aksi_button').val('Edit');
                    $('#aksi').val('Edit');
                    $('#createModal').modal('show');
                }
            });
        });

        $(document).on('click', '.delete',function(){
            var id = $(this).attr('id');
            var url = "{{ route('cms.master-data.lsm.destroy', ['id' => ":id"]) }}";
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
                                $('#table_md_lsm').DataTable().ajax.reload();
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

        function isValidUrl(url) {
            const pattern = /^(https?:\/\/)[\w\-]+(\.[\w\-]+)+[/#?]?.*$/;
            return pattern.test(url);
        }

        $('#link').on('blur', function () {
            let url = $(this).val();

            if (!isValidUrl(url)) {
                $('#error').text('URL tidak valid atau harus diawali http/https');
            } else {
                $('#error').text('');
            }
        });
    </script>
@endsection
