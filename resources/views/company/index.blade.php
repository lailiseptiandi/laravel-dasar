@extends('layouts.dashboard')
@section('title')
    <title>Company</title>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row">
                    <div class="d-flex flex-row">
                        <div class="ml-2">
                            <button type="button" data-target="#add-data" data-toggle="modal" class="btn btn-primary">Add
                                Data</button>
                        </div>
                        <div class="ml-2">
                            <form action="{{ route('pdf.company') }}" method="get">
                                @csrf
                                <div class="d-flex flex-row">
                                    <select name="id_company" class="form-control mr-2" id="">
                                        @foreach ($companies as $c)
                                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>

                                    <button type="submit" class="btn btn-danger">Export PDF</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-header">{{ __('Company') }}</div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Logo</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($companies as $item)
                                        <tr>
                                            <td>{{ $companies->firstItem() + $loop->index }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>
                                                <img src="{{ Storage::url('company/' . $item->logo) }}" width="200px"
                                                    height="auto" alt="">
                                            </td>
                                            <td>
                                                <form action="{{ route('company.destroy', $item->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" data-target="#edit-data-{{ $item->id }}"
                                                        data-toggle="modal" class="btn btn-primary">Edit</a>
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $companies->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-data" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Company</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('company.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Name Company</label>
                            <input type="text" name="name" placeholder="Enter Name" value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">E-Mail</label>
                            <input type="email" name="email" placeholder="Enter E-Mail" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Logo</label>
                            <input type="file" name="logo" class="form-control">
                            {{-- <div class="col-md-12 mb-2">
                                <img id="preview-image-before-upload"
                                    src="https://www.riobeauty.co.uk/images/product_image_not_found.gif" alt="preview image"
                                    style="max-height: 250px;">
                            </div> --}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($companies as $company)
        <div class="modal fade" id="edit-data-{{ $company->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Company</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('company.update', $company->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Name Company</label>
                                <input type="text" name="name" placeholder="Enter Name" value="{{ $company->name }}"
                                    class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">E-Mail</label>
                                <input type="email" name="email" placeholder="Enter E-Mail" value="{{ $company->email }}"
                                    class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Logo</label>
                                <input type="file" name="logo" class="form-control">
                                <div class="rounded">
                                    <img src="{{ Storage::url('company/' . $company->logo) }}" alt="" height="100px"
                                        width="auto">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
@push('after-script')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(e) {


            $('#logo').change(function() {

                let reader = new FileReader();

                reader.onload = (e) => {

                    $('#preview-image-before-upload').attr('src', e.target.result);
                }

                reader.readAsDataURL(this.files[0]);

            });

        });
    </script>
@endpush
