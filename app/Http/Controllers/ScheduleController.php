<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Schedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    /**
     * Menampilkan daftar jadwal milik user.
     */
    public function index(): View
    {
        $schedules = Schedule::where('user_id', auth()->id())
            ->with('category')
            ->orderBy('date')
            ->orderBy('start_time')
            ->paginate(10);

        return view('schedules.index', compact('schedules'));
    }


    /**
     * Menampilkan form membuat jadwal.
     */
    public function create(): View
    {
        $categories = Category::where('user_id', auth()->id())
            ->orderBy('name')
            ->get();

        return view('schedules.create', compact('categories'));
    }


    /**
     * Menyimpan jadwal baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => [
                'nullable',
                'integer',
                'exists:categories,id',
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

            'date' => [
                'required',
                'date',
            ],

            'start_time' => [
                'required',
                'date_format:H:i',
            ],

            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],

            'location' => [
                'nullable',
                'string',
                'max:255',
            ],

            'priority' => [
                'required',
                'in:low,medium,high',
            ],

            'status' => [
                'required',
                'in:upcoming,ongoing,completed,skipped,cancelled',
            ],

            'is_recurring' => [
                'boolean',
            ],

            'recurrence_rule' => [
                'nullable',
                'string',
                'max:255',
            ],

            'reminder_minutes' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ]);

        $validated['user_id'] = auth()->id();

        $validated['is_recurring'] =
            $request->boolean('is_recurring');

        Schedule::create($validated);

        return redirect()
            ->route('schedules.index')
            ->with(
                'success',
                'Jadwal berhasil ditambahkan.'
            );
    }


    /**
     * Menampilkan detail jadwal.
     */
    public function show(Schedule $schedule): View
    {
        abort_unless(
            $schedule->user_id === auth()->id(),
            403
        );

        $schedule->load('category');

        return view(
            'schedules.show',
            compact('schedule')
        );
    }


    /**
     * Menampilkan form edit jadwal.
     */
    public function edit(Schedule $schedule): View
    {
        abort_unless(
            $schedule->user_id === auth()->id(),
            403
        );

        $categories = Category::where('user_id', auth()->id())
            ->orderBy('name')
            ->get();

        return view(
            'schedules.edit',
            compact('schedule', 'categories')
        );
    }


    /**
     * Memperbarui jadwal.
     */
    public function update(
        Request $request,
        Schedule $schedule
    ): RedirectResponse {

        abort_unless(
            $schedule->user_id === auth()->id(),
            403
        );

        $validated = $request->validate([
            'category_id' => [
                'nullable',
                'integer',
                'exists:categories,id',
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

            'date' => [
                'required',
                'date',
            ],

            'start_time' => [
                'required',
                'date_format:H:i',
            ],

            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],

            'location' => [
                'nullable',
                'string',
                'max:255',
            ],

            'priority' => [
                'required',
                'in:low,medium,high',
            ],

            'status' => [
                'required',
                'in:upcoming,ongoing,completed,skipped,cancelled',
            ],

            'is_recurring' => [
                'boolean',
            ],

            'recurrence_rule' => [
                'nullable',
                'string',
                'max:255',
            ],

            'reminder_minutes' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ]);

        $validated['is_recurring'] =
            $request->boolean('is_recurring');

        $schedule->update($validated);

        return redirect()
            ->route('schedules.index')
            ->with(
                'success',
                'Jadwal berhasil diperbarui.'
            );
    }


    /**
     * Menghapus jadwal.
     */
    public function destroy(
        Schedule $schedule
    ): RedirectResponse {

        abort_unless(
            $schedule->user_id === auth()->id(),
            403
        );

        $schedule->delete();

        return redirect()
            ->route('schedules.index')
            ->with(
                'success',
                'Jadwal berhasil dihapus.'
            );
    }
}