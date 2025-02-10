@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <button type="button" class="btn btn-primary rounded-pill px-4 mt-5 py-2 shadow-sm" data-bs-toggle="modal"
            data-bs-target="#createTaskModal">
            <i class="bi bi-plus-lg me-2"></i>New Task
        </button>
    </div>

    <!-- Tasks Table -->
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light-primary">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase fw-semibold text-dark">Title</th>
                            <th class="py-3 text-uppercase fw-semibold text-dark">Description</th>
                            <th class="py-3 text-uppercase fw-semibold text-dark">Assigned To</th>
                            <th class="py-3 text-uppercase fw-semibold text-dark">Created By</th>
                            <th class="py-3 text-uppercase fw-semibold text-dark">Status</th>
                            <th class="pe-4 py-3 text-uppercase fw-semibold text-dark text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr class="hover-scale">
                                <td class="ps-4 fw-medium">{{ $task->title }}</td>
                                <td class="text-muted">{{ Str::limit($task->description, 40) }}</td>
                                <td>
                                    <div class="d-flex align-items-center">

                                        {{ $task->assignedTo->name }}
                                    </div>
                                </td>
                                <td>{{ $task->createdBy->name }}</td>
                                <td>
                                    <span
                                        class="badge rounded-pill bg-{{ $task->status == 'completed' ? 'success' : ($task->status == 'in_progress' ? 'warning' : 'secondary') }} bg-opacity-10 text-{{ $task->status == 'completed' ? 'success' : ($task->status == 'in_progress' ? 'warning' : 'secondary') }} py-2 px-3">
                                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button type="button" class="btn btn-outline-primary btn-icon rounded-3"
                                            data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-icon rounded-3"
                                            data-bs-toggle="modal" data-bs-target="#deleteTaskModal{{ $task->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Edit Task Modal -->
                            <div class="modal fade" id="editTaskModal{{ $task->id }}" tabindex="-1"
                                aria-labelledby="editTaskModalLabel{{ $task->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title fs-5" id="editTaskModalLabel{{ $task->id }}">Edit Task
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body pt-0">
                                            <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label class="form-label">Title</label>
                                                    <input type="text" class="form-control rounded-3" name="title"
                                                        value="{{ $task->title }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Description</label>
                                                    <textarea class="form-control rounded-3" name="description"
                                                        rows="3">{{ $task->description }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Assigned To</label>
                                                    <select class="form-select rounded-3" name="assigned_to" required>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}" {{ $task->assigned_to == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label">Status</label>
                                                    <select class="form-select rounded-3" name="status" required>
                                                        <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                        <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                    </select>
                                                </div>
                                                <div class="d-grid gap-2">
                                                    <button type="submit" class="btn btn-primary rounded-pill py-2">Update
                                                        Task</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Task Modal -->
                            <div class="modal fade" id="deleteTaskModal{{ $task->id }}" tabindex="-1"
                                aria-labelledby="deleteTaskModalLabel{{ $task->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title fs-5" id="deleteTaskModalLabel{{ $task->id }}">Confirm
                                                Delete</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body pt-0">
                                            <div class="text-center mb-4">

                                                <p class="text-muted">Are you sure you want to delete this task?</p>
                                            </div>
                                            <div class="d-flex gap-2 justify-content-center">
                                                <button type="button" class="btn btn-light rounded-pill px-4"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger rounded-pill px-4">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Task Modal -->
<div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTaskModalLabel">Create New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="assigned_to" class="form-label">Assigned To</label>
                        <select class="form-select" id="assigned_to" name="assigned_to" required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Task</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add this in your head section -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
