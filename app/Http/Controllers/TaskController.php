<?php

namespace App\Http\Controllers;


use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskController extends Controller
{
    public function index()
    {
        try {
            $tasks = Task::with(['assignedTo', 'createdBy'])->get();
            return view('tasks.index', compact('tasks'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while fetching tasks. Please try again later.');
        }
    }
    public function adminDashboard()
    {
        try {
            $tasks = Task::with(['assignedTo', 'createdBy'])->paginate(10);
            $users = User::whereIn('id', function ($query) {
                $query->select('model_id')
                    ->from('model_has_roles')
                    ->whereIn('role_id', [2]);
            })->get();

            return view('admin.dashboard', compact('tasks', 'users'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while fetching tasks. Please try again later.');
        }
    }
    public function userDashboard()
    {
        try {
            $tasks = Task::where('assigned_to', auth()->id())->get();
            return view('user.dashboard', compact('tasks'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while fetching tasks. Please try again later.');
        }
    }

    public function updateStatus(Request $request, Task $task)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,in_progress,completed',
            ]);

            $task->update(['status' => $request->status]);

            return redirect()->route('user.dashboard')->with('success', 'Task status updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the task status. Please try again later.');
        }
    }

    //store task
    public function store(StoreTaskRequest $request)
    {
        DB::beginTransaction();
        try {
            Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'assigned_to' => $request->assigned_to,
                'created_by' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while creating the task. Please try again later.');
        }
    }

    // Update a task
    public function update(UpdateTaskRequest $request, Task $task)
    {
        try {
            if (!$task) {
                throw new ModelNotFoundException('Task not found.');
            }

            $task->fill($request->validated());
            $task->save();

            return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('tasks.index')->with('error', 'Task not found.');
        } catch (\Exception $e) {
            return redirect()->route('tasks.index')->with('error', 'An error occurred while updating the task.');
        }
    }

    // Delete a task
    public function destroy(Task $task)
    {
        try {
            $task->delete();

            return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the task. Please try again later.');
        }
    }

    public function restore($id)
    {
        try {
            Task::withTrashed()->findOrFail($id)->restore();
            return redirect()->route('tasks.index')->with('success', 'Task restored successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while restoring the task. Please try again later.');
        }
    }
}
