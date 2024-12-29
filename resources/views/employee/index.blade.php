@extends('layouts.app')

@section('title', 'List Employee')

@section('content')
    <div class="container mt-4">
        <div class="row mb-0">
            <div class="col-lg-9 col-xl-6">
                <h4 class="mb-3">{{ $pageTitle }}</h4>
            </div>
            <div class="col-lg-3 col-xl-6">
                <ul class="list-inline mb-0 float-end">
                    <li class="list-inline-item">
                        <a href="{{ route('employees.exportExcel') }}" class="btn btn-outline-success">
                            <i class="bi bi-download me-1"></i> Export to Excel
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="{{ route('employees.exportPdf') }}" class="btn btn-outline-danger">
                            <i class="bi bi-download me-1"></i> Export to PDF
                        </a>
                    </li>
                    <li class="list-inline-item">|</li>
                    <li class="list-inline-item">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#createEmployee">
                            <i class="bi bi-plus-circle me-1"></i> Create Employee
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="table-responsive border p-3 rounded-3 mb-5">
            <table class="table table-bordered table-hover table-striped mb-0 bg-white datatable" id="employeeTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>No.</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Age</th>
                        <th>Position</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade @if ($errors->any()) show @endif" id="createEmployee" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="@if ($errors->any()) false @else true @endif"
        @if ($errors->any()) style="display: block;" @endif>
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Karyawan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="closeModalX"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input class="form-control @error('firstName') is-invalid @enderror" type="text"
                                name="firstName" id="firstName" value="{{ old('firstName') }}"
                                placeholder="Enter First Name">
                            @error('firstName')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input class="form-control @error('lastName') is-invalid @enderror" type="text"
                                name="lastName" id="lastName" value="{{ old('lastName') }}" placeholder="Enter Last Name">
                            @error('lastName')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="email" name="email"
                                id="email" value="{{ old('email') }}" placeholder="Enter Email">
                            @error('email')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input class="form-control @error('age') is-invalid @enderror" type="number" name="age"
                                id="age" value="{{ old('age') }}" placeholder="Enter Age">
                            @error('age')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="position" class="form-label">Position</label>
                            <select name="position" id="position"
                                class="form-select @error('position') is-invalid @enderror">
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}"
                                        {{ old('position') == $position->id ? 'selected' : '' }}>
                                        {{ $position->code . ' - ' . $position->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('position')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="cv" class="form-label">Curriculum Vitae (CV)</label>
                            <input type="file" class="form-control @error('cv') is-invalid @enderror" name="cv"
                                id="cv">
                            @error('cv')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="closeModalText">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const modalElement = document.getElementById('createEmployee');
    const closeModalX = document.getElementById('closeModalX');
    const closeModalText = document.getElementById('closeModalText');
    const form = modalElement.querySelector('form');

    const showModalWithBackdrop = () => {
        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade show';
        document.body.appendChild(backdrop);
        document.body.classList.add('modal-open');
    };

    if (modalElement.classList.contains('show')) {
        showModalWithBackdrop();
    }

    const clearErrors = () => {
        const errorMessages = modalElement.querySelectorAll('.text-danger small');
        errorMessages.forEach((message) => message.remove());

        const errorInputs = modalElement.querySelectorAll('.is-invalid');
        errorInputs.forEach((input) => input.classList.remove('is-invalid'));
    };

    const resetForm = () => {
        form.reset();
        clearErrors();

        // Reset nilai input ke default
        document.getElementById('firstName').value = '';
        document.getElementById('lastName').value = '';
        document.getElementById('email').value = '';
        document.getElementById('age').value = '';
        document.getElementById('cv').value = '';

        // Reset select position ke opsi pertama
        const positionSelect = document.getElementById('position');
        if(positionSelect.options.length > 0) {
            positionSelect.selectedIndex = 0;
        }
    };

    const closeModal = () => {
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) backdrop.remove();
        document.body.classList.remove('modal-open');
        modalElement.style.display = 'none';
        modalElement.classList.remove('show');
        resetForm();
    };

    // Event handlers
    closeModalX.addEventListener('click', closeModal);
    closeModalText.addEventListener('click', closeModal);

    // Event listener untuk modal
    modalElement.addEventListener('hidden.bs.modal', resetForm);
    modalElement.addEventListener('show.bs.modal', resetForm);

    // Event listener untuk tombol Create Employee
    const createEmployeeBtn = document.querySelector('[data-bs-target="#createEmployee"]');
    createEmployeeBtn.addEventListener('click', resetForm);
});
    </script>

@endsection
