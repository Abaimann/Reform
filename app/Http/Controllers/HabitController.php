<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Habit;
use App\Models\HabitCompletion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HabitController extends Controller
{
    /**
     * Menampilkan daftar habit milik user.
     */
    public function index(): View
    {
        $habits = Habit::where(
            'user_id',
            auth()->id()
        )
            ->with('category')
            ->withCount('completions')
            ->orderByDesc('is_active')
            ->orderBy('name')
            ->paginate(10);

        return view(
            'habits.index',
            compact('habits')
        );
    }


    /**
     * Menampilkan form membuat habit.
     */
    public function create(): View
    {
        $categories = Category::where(
            'user_id',
            auth()->id()
        )
            ->orderBy('name')
            ->get();

        return view(
            'habits.create',
            compact('categories')
        );
    }


    /**
     * Menyimpan habit baru.
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

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'frequency' => [
                'required',
                'in:daily,weekly,monthly',
            ],

            'target' => [
                'required',
                'integer',
                'min:1',
            ],

            'unit' => [
                'required',
                'string',
                'max:50',
            ],

            'reminder_time' => [
                'nullable',
                'date_format:H:i',
            ],

            'is_active' => [
                'boolean',
            ],
        ]);


        /*
         * Pastikan kategori memang milik user
         * yang sedang login.
         */

        if (!empty($validated['category_id'])) {

            abort_unless(
                Category::where(
                    'id',
                    $validated['category_id']
                )
                    ->where(
                        'user_id',
                        auth()->id()
                    )
                    ->exists(),
                403
            );
        }


        $validated['user_id'] = auth()->id();

        $validated['is_active'] =
            $request->boolean('is_active');


        Habit::create($validated);


        return redirect()
            ->route('habits.index')
            ->with(
                'success',
                'Habit berhasil ditambahkan.'
            );
    }


    /**
     * Menampilkan detail habit.
     */
    public function show(
        Habit $habit
    ): View {

        abort_unless(
            $habit->user_id === auth()->id(),
            403
        );


        $habit->load([
            'category',
            'completions',
        ]);


        return view(
            'habits.show',
            compact('habit')
        );
    }


    /**
     * Menampilkan form edit habit.
     */
    public function edit(
        Habit $habit
    ): View {

        abort_unless(
            $habit->user_id === auth()->id(),
            403
        );


        $categories = Category::where(
            'user_id',
            auth()->id()
        )
            ->orderBy('name')
            ->get();


        return view(
            'habits.edit',
            compact(
                'habit',
                'categories'
            )
        );
    }


    /**
     * Memperbarui habit.
     */
    public function update(
        Request $request,
        Habit $habit
    ): RedirectResponse {

        abort_unless(
            $habit->user_id === auth()->id(),
            403
        );


        $validated = $request->validate([

            'category_id' => [
                'nullable',
                'integer',
                'exists:categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'frequency' => [
                'required',
                'in:daily,weekly,monthly',
            ],

            'target' => [
                'required',
                'integer',
                'min:1',
            ],

            'unit' => [
                'required',
                'string',
                'max:50',
            ],

            'reminder_time' => [
                'nullable',
                'date_format:H:i',
            ],

            'is_active' => [
                'boolean',
            ],
        ]);


        /*
         * Pastikan kategori memang milik user.
         */

        if (!empty($validated['category_id'])) {

            abort_unless(
                Category::where(
                    'id',
                    $validated['category_id']
                )
                    ->where(
                        'user_id',
                        auth()->id()
                    )
                    ->exists(),
                403
            );
        }


        $validated['is_active'] =
            $request->boolean('is_active');


        $habit->update($validated);


        return redirect()
            ->route('habits.index')
            ->with(
                'success',
                'Habit berhasil diperbarui.'
            );
    }


    /**
     * Menandai habit selesai.
     */
    public function complete(
        Habit $habit
    ): RedirectResponse {

        abort_unless(
            $habit->user_id === auth()->id(),
            403
        );


        abort_unless(
            $habit->is_active,
            422
        );


        $today = now()->toDateString();


        $alreadyCompleted = $habit->completions()
            ->whereDate(
                'completed_at',
                $today
            )
            ->exists();


        if ($alreadyCompleted) {

            return redirect()
                ->back()
                ->with(
                    'success',
                    'Habit hari ini sudah selesai.'
                );
        }


        HabitCompletion::create([

            'habit_id' => $habit->id,

            'completed_at' => $today,

            'value' => $habit->target,

            'notes' => null,

        ]);


        return redirect()
            ->back()
            ->with(
                'success',
                'Habit berhasil ditandai selesai.'
            );
    }


    /**
     * Menghapus habit.
     */
    public function destroy(
        Habit $habit
    ): RedirectResponse {

        abort_unless(
            $habit->user_id === auth()->id(),
            403
        );


        $habit->delete();


        return redirect()
            ->route('habits.index')
            ->with(
                'success',
                'Habit berhasil dihapus.'
            );
    }
}