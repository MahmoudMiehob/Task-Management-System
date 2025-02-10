@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mt-5 g-3">
        <!-- Pending Column -->
        <div class="col-md-4">
            <div class="p-3 bg-light rounded-3 h-100">
                <h5 class="fw-bold text-primary mb-3"> Pending ({{ $tasks->where('status', 'pending')->count() }})</h5>
                @foreach($tasks->where('status', 'pending') as $task)
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h6 class="card-title fw-bold">{{ $task->title }}</h6>
                            <p class="text-muted small">{{ Str::limit($task->description, 80) }}</p>
                            <select class="form-select form-select-sm status-select" data-task-id="{{ $task->id }}">
                                <option value="pending" selected>Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- In Progress Column -->
        <div class="col-md-4">
            <div class="p-3 bg-light rounded-3 h-100">
                <h5 class="fw-bold text-warning mb-3"> In Progress ({{ $tasks->where('status', 'in_progress')->count() }})</h5>
                @foreach($tasks->where('status', 'in_progress') as $task)
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h6 class="card-title fw-bold">{{ $task->title }}</h6>
                            <p class="text-muted small">{{ Str::limit($task->description, 80) }}</p>
                            <select class="form-select form-select-sm status-select" data-task-id="{{ $task->id }}">
                                <option value="pending">Pending</option>
                                <option value="in_progress" selected>In Progress</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Completed Column -->
        <div class="col-md-4">
            <div class="p-3 bg-light rounded-3 h-100">
                <h5 class="fw-bold text-success mb-3"> Completed ({{ $tasks->where('status', 'completed')->count() }})</h5>
                @foreach($tasks->where('status', 'completed') as $task)
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h6 class="card-title fw-bold">{{ $task->title }}</h6>
                            <p class="text-muted small">{{ Str::limit($task->description, 80) }}</p>
                            <select class="form-select form-select-sm status-select" data-task-id="{{ $task->id }}">
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed" selected>Completed</option>
                            </select>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
