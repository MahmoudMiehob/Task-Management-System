@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mt-5 g-3">
        @foreach(['pending', 'in_progress', 'completed'] as $status)
        <div class="col-md-4">
            <div class="p-3 bg-light rounded-3 h-100">
                <h5 class="fw-bold @if($status === 'pending') text-primary @elseif($status === 'in_progress') text-warning @else text-success @endif mb-3">
                    {{ ucfirst(str_replace('_', ' ', $status)) }} ({{ $tasks->where('status', $status)->count() }})
                </h5>
                @foreach($tasks->where('status', $status) as $task)
                <div class="card shadow-sm mb-3 task-card" data-task-id="{{ $task->id }}" data-bs-toggle="modal" data-bs-target="#statusModal" data-task-title="{{ $task->title }}" data-task-description="{{ $task->description }}" data-current-status="{{ $task->status }}">
                    <div class="card-body">
                        <h6 class="card-title fw-bold">{{ $task->title }}</h6>
                        <p class="text-muted small">{{ Str::limit($task->description, 80) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Task Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="taskId">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" id="taskTitle" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" id="taskDescription" rows="3" readonly></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" id="statusSelect">
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateStatusBtn">Update Status</button>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    let currentTaskId = null;

    $('.task-card').on('click', function() {
        currentTaskId = $(this).data('task-id');
        $('#taskId').val(currentTaskId);
        $('#taskTitle').val($(this).data('task-title'));
        $('#taskDescription').val($(this).data('task-description'));
        $('#statusSelect').val($(this).data('current-status'));
    });

    $('#updateStatusBtn').on('click', function() {
        const newStatus = $('#statusSelect').val();
        const taskId = $('#taskId').val();

        $.ajax({
            url: `/user/tasks/${taskId}/update-status`,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: { status: newStatus },
            success: function(response) {
                window.location.reload();
            },
            error: function(error) {
                alert('Error updating status');
                console.error('Error:', error);
            }
        });
    });
});
</script>
