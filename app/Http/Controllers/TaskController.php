<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Menampilkan daftar task milik user.
     */
    public function index(): View
    {
        $tasks = Task::where('user_id', auth()->id())
            ->with(['category', 'parent'])
            ->whereNull('parent_id')
            ->orderByRaw("
                CASE
                    WHEN status = 'in_progress' THEN 1
                    WHEN status = 'pending' THEN 2
                    WHEN status = 'completed' THEN 3
                    ELSE 4
                END
            ")
            ->orderBy('due_date')
            ->paginate(10);

        return view(
            'tasks.index',
            compact('tasks')
        );
    }


    /**
     * Menampilkan form membuat task.
     */
    public function create(): View
    {
        $categories = Category::where(
            'user_id',
            auth()->id()
        )
            ->orderBy('name')
            ->get();

        $parentTasks = Task::where(
            'user_id',
            auth()->id()
        )
            ->whereNull('parent_id')
            ->orderBy('title')
            ->get();

        return view(
            'tasks.create',
            compact(
                'categories',
                'parentTasks'
            )
        );
    }


    /**
     * Menyimpan task baru.
     */
    public function store(
        Request $request
    ): RedirectResponse {

        $validated = $request->validate([

            'category_id' => [
                'nullable',
                'integer',
                'exists:categories,id',
            ],

            'parent_id' => [
                'nullable',
                'integer',
                'exists:tasks,id',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'due_date' => [
                'nullable',
                'date',
            ],

            'priority' => [
                'required',
                'in:low,medium,high',
            ],

            'status' => [
                'required',
                'in:pending,in_progress,completed,cancelled',
            ],

            'progress' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],
        ]);


        /*
         * Pastikan category memang milik user
         * yang sedang login.
         */

        if (!empty($validated['category_id'])) {

            abort_unless(
                Category::where('id', $validated['category_id'])
                    ->where('user_id', auth()->id())
                    ->exists(),
                403
            );
        }


        /*
         * Pastikan parent task memang milik user
         * yang sedang login.
         */

        if (!empty($validated['parent_id'])) {

            abort_unless(
                Task::where('id', $validated['parent_id'])
                    ->where('user_id', auth()->id())
                    ->exists(),
                403
            );
        }


        $validated['user_id'] = auth()->id();


        Task::create($validated);


        return redirect()
            ->route('tasks.index')
            ->with(
                'success',
                'Task berhasil ditambahkan.'
            );
    }


    /**
     * Menampilkan detail task.
     */
    public function show(
        Task $task
    ): View {

        abort_unless(
            $task->user_id === auth()->id(),
            403
        );


        $task->load([
            'category',
            'parent',
            'subtasks',
        ]);


        return view(
            'tasks.show',
            compact('task')
        );
    }


    /**
     * Menampilkan form edit task.
     */
    public function edit(
        Task $task
    ): View {

        abort_unless(
            $task->user_id === auth()->id(),
            403
        );


        $categories = Category::where(
            'user_id',
            auth()->id()
        )
            ->orderBy('name')
            ->get();


        /*
         * Parent task tidak boleh memilih dirinya sendiri
         * dan hanya mengambil task utama milik user.
         */

        $parentTasks = Task::where(
            'user_id',
            auth()->id()
        )
            ->whereNull('parent_id')
            ->where('id', '!=', $task->id)
            ->orderBy('title')
            ->get();


        return view(
            'tasks.edit',
            compact(
                'task',
                'categories',
                'parentTasks'
            )
        );
    }


    /**
     * Memperbarui task.
     */
    public function update(
        Request $request,
        Task $task
    ): RedirectResponse {

        abort_unless(
            $task->user_id === auth()->id(),
            403
        );


        $validated = $request->validate([

            'category_id' => [
                'nullable',
                'integer',
                'exists:categories,id',
            ],

            'parent_id' => [
                'nullable',
                'integer',
                'exists:tasks,id',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'due_date' => [
                'nullable',
                'date',
            ],

            'priority' => [
                'required',
                'in:low,medium,high',
            ],

            'status' => [
                'required',
                'in:pending,in_progress,completed,cancelled',
            ],

            'progress' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],
        ]);


        /*
         * Pastikan category milik user.
         */

        if (!empty($validated['category_id'])) {

            abort_unless(
                Category::where('id', $validated['category_id'])
                    ->where('user_id', auth()->id())
                    ->exists(),
                403
            );
        }


        /*
         * Pastikan parent task milik user.
         */

        if (!empty($validated['parent_id'])) {

            abort_unless(
                Task::where('id', $validated['parent_id'])
                    ->where('user_id', auth()->id())
                    ->exists(),
                403
            );


            /*
             * Task tidak boleh menjadi parent
             * untuk dirinya sendiri.
             */

            abort_if(
                (int) $validated['parent_id'] === (int) $task->id,
                422,
                'Task tidak dapat menjadi parent dirinya sendiri.'
            );
        }


        $task->update($validated);


        return redirect()
            ->route('tasks.index')
            ->with(
                'success',
                'Task berhasil diperbarui.'
            );
    }


    /**
     * Menghapus task.
     */
    public function destroy(
        Task $task
    ): RedirectResponse {

        abort_unless(
            $task->user_id === auth()->id(),
            403
        );


        $task->delete();


        return redirect()
            ->route('tasks.index')
            ->with(
                'success',
                'Task berhasil dihapus.'
            );
    }
}