@extends('layouts.dashboard')
@section('title')
    <title>Employee</title>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="mt-4 mb-3">
                    <button type="button" data-target="#add-data" data-toggle="modal" class="btn btn-primary">Add
                        Data</button>
                    <a href="{{ route('pdf.employee') }}" class="btn btn-danger">Export PDF</a>

                </div>
                <form action="{{ route('import.employee') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="file" name="excel_file" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success">Import</button>
                </form>

                <div class="card mt-2">
                    <div class="card-header">{{ __('Company') }}</div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Company</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employees as $item)
                                        <tr>
                                            <td>{{ $employees->firstItem() + $loop->index }}</td>
                                            <td>
                                                @if ($item->Company == null)
                                                    No Company
                                                @else
                                                    {{ $item->Company->name }}
                                                @endif
                                            </td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>
                                                <form action="{{ route('employee.destroy', $item->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="" data-target="#edit-data-{{ $item->id }}"
                                                        data-toggle="modal" class="btn btn-primary">Edit</a>
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $employees->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-data" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Employee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('employee.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Company</label>
                            <select name="company_id" class="form-control js-example-basic-single">
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class=" form-group">
                            <label for="">Name</label>
                            <input type="text" name="name" placeholder="Enter Name" value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class=" form-group">
                            <label for="">E-Mail</label>
                            <input type="email" name="email" placeholder="Enter E-Mail" {{ old('email') }}
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
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

    @foreach ($employees as $el)
        <div class="modal fade" id="edit-data-{{ $el->id }}" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Employee</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('employee.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Company</label>
                                <select name="company_id" class="form-control js-example-basic-single">
                                    @foreach ($companies as $company)
                                        @if ($el->company_id == $company->id)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @else
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class=" form-group">
                                <label for="">Name</label>
                                <input type="text" name="name" placeholder="Enter Name" value="{{ $el->name }}"
                                    class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class=" form-group">
                                <label for="">E-Mail</label>
                                <input type="email" name="email" placeholder="Enter E-Mail" value="{{ $el->email }}"
                                    class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
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
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
@endpush
