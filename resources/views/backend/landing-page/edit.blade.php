@extends('backend.layouts.app')
@section('title', 'Edit | Landing Page | REDD++ Kalimantan Barat')
@section('header', 'Edit | Landing Page')

@section('css')
    <link href="{{ asset('/backend_template/libs/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/datatables/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/datatables/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/datatables/select.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/custombox/custombox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/backend_template/libs/dropify/dropify.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link href="https://unpkg.com/filepond@4/dist/filepond.min.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview@4/dist/filepond-plugin-image-preview.min.css" rel="stylesheet">
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
    <form class="form-horizontal" id="form_landing_page" method="POST" action="{{ route('cms.landing-page.update', ['id' => $id]) }}" enctype="multipart/form-data" data-parsley-validate novalidate>
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="mt-0 header-title">Tambah Landing Page</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a class="btn btn-icon waves-effect waves-light btn-primary" href="{{ route('cms.landing-page.index') }}">
                                Kembali<i class="fas fas fa-right-long"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card-box">
                    <div class="row">
                        @if (session('failed'))
                            <div class="col-12">
                                <div class="alert alert-danger">{{session('failed')}}</div>
                            </div>
                        @endif
                        <div class="col-12">
                            <div class="form-group">
                                <label for="sort_order" class="control-label">Urutan Section</label>
                                <input type="text" class="form-control" id="sort_order" name="sort_order" parsley-trigger="change" placeholder="Masukan section key..." value="{{ $landingPageSection->sort_order }}" required>
                                @error('sort_order')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="section_id" class="control-lalbel">Nama Section</label>
                                <select name="section_id" id="section_id" class="form-control" required>
                                    <option value="">Pilih</option>
                                    @foreach ($sections as $section)
                                        <option value="{{$section['id']}}">{{$section['nama']}}</option>
                                    @endforeach
                                </select>
                                @error('section_id')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Fields</h5>
                        <button type="button"
                                id="addField"
                                class="btn btn-primary waves-effect btn-sm">
                            + Tambah Field
                        </button>
                    </div>

                    <div class="card-body">
                        @foreach($landingPageSection->content as $key => $value)
                            @php
                                $field = $availableFields[$key] ?? null;
                            @endphp
                            @if($field)
                                <div class="field-init"
                                    data-key="{{ $key }}"
                                    data-label="{{ $field['label'] }}"
                                    data-type="{{ $field['type'] }}"
                                    data-value="{{ $value }}">
                                </div>
                            @endif
                        @endforeach
                        <div id="fieldContainer"></div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary waves-effect btn-block" type="submit">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="fieldModal" tabindex="-1" role="dialog" aria-labelledby="fieldModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>
                        Tambah Field
                    </h5>
                </div>
                <div class="modal-body">
                    @foreach($availableFields as $key => $field)
                        <button
                            type="button"
                            class="btn btn-light btn-block field-option"
                            data-key="{{ $key }}"
                            data-label="{{ $field['label'] }}"
                            data-type="{{ $field['type'] }}">
                            {{ $field['label'] }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
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
    <script src="https://unpkg.com/filepond@4/dist/filepond.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview@4/dist/filepond-plugin-image-preview.min.js"></script>
    <script>
        $('#section_id').select2();
        let targetSection = "{{$landingPageSection->section->nama}}";
        let valueSection = $('#section_id option').filter(function () {
            return $(this).text() === targetSection;
        }).val();
        $("[name='section_id']").val(valueSection).trigger('change');

        FilePond.registerPlugin(FilePondPluginImagePreview);

        function buildField(key, label, type, value = '')
        {
            let input = '';
            if(type === 'textarea')
            {
                input = `
                    <textarea
                        class="form-control"
                        name="fields[${key}]">${value}</textarea>
                `;
            } else if(type === 'image')
            {
                input = `
                    <input
                        type="file"
                        class="filepond"
                        name="fields[${key}]"
                        accept="image/png,image/jpeg,image/jpg">

                    <input
                        type="hidden"
                        class="existing-image"
                        data-field="${key}"
                        value="${value}">
                `;
            }
            else
            {
                input = `
                    <input
                        type="text"
                        class="form-control"
                        name="fields[${key}]"
                        value="${value}">
                `;
            }
            return `
                <div
                    class="card mb-2 field-item"
                    data-field="${key}">
                    <div class="card-header d-flex justify-content-between">
                        <strong>${label}</strong>
                        <button
                            type="button"
                            class="btn btn-danger btn-sm remove-field">
                            Hapus
                        </button>
                    </div>
                    <div class="card-body">
                        ${input}
                    </div>
                </div>
            `;
        }

        $('#addField').click(function(){
            $('#fieldModal').modal('show');
        });

        $('.field-option').click(function(){
            let key = $(this).data('key');
            let label = $(this).data('label');
            let type = $(this).data('type');
            if(
                $('[data-field="'+key+'"]').length
            ){
                alert('Field sudah ditambahkan');
                return;
            }
            $('#fieldContainer').append(
                buildField(
                    key,
                    label,
                    type
                )
            );
            FilePond.registerPlugin(
                FilePondPluginImagePreview
            );

            const pond = FilePond.create(
                document.querySelector('.filepond'),
                {
                    storeAsFile: true
                }
            );
            $('#fieldModal').modal('hide');
        });

        $(document).on(
            'click',
            '.remove-field',
            function(){
                $(this)
                    .closest('.field-item')
                    .remove();
            }
        );

        $('.field-init').each(function(){
            const key = $(this).data('key');
            const label = $(this).data('label');
            const type = $(this).data('type');
            const value = $(this).data('value');

            $('#fieldContainer').append(
                buildField(
                    key,
                    label,
                    type,
                    value
                )
            );

            if(type !== 'image')
            {
                return;
            }

            const imageUrl = value
                ? '/' + value
                : null;

            const input = $('#fieldContainer')
                .find('.filepond')
                .last()[0];

            const pond = FilePond.create(input,{
                storeAsFile:true,
                files:imageUrl ? [
                    {
                        source:imageUrl,
                        options:{
                            type:'local'
                        }
                    }
                ] : [],
                server:{
                    load:(source,load,error)=>{

                        fetch(source)
                            .then(res => res.blob())
                            .then(load)
                            .catch(error);
                    }
                }
            });
            pond.on('removefile',function(){
                $(input)
                    .closest('.field-item')
                    .find('.existing-image')
                    .val('');
            });
        });
    </script>
@endsection
