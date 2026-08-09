<?php

namespace App\Domains\Programs\Http\Controllers;

use App\Domains\Programs\Http\Requests\StoreProgramRequest;
use App\Domains\Programs\Http\Requests\UpdateProgramRequest;
use App\Domains\Programs\Models\Program;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Program::class, 'program');
    }

    public function index(Request $request): View
    {
        $search = $request->query('search');

        $programs = Program::query()
            ->when($search, fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%");
            }))
            ->orderByDesc('is_active')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('programs.index', compact('programs', 'search'));
    }

    public function create(): View
    {
        return view('programs.create', [
            'departments' => ['Media', 'Technology', 'Business', 'Policy', 'Education'],
        ]);
    }

    public function store(StoreProgramRequest $request): RedirectResponse
    {
        Program::create(array_merge($request->validated(), [
            'slug' => Str::slug($request->validated()['name']),
            'is_active' => $request->boolean('is_active'),
        ]));

        return redirect()->route('programs.index')->with('success', 'Program added successfully.');
    }

    public function show(Program $program): View
    {
        return view('programs.show', compact('program'));
    }

    public function edit(Program $program): View
    {
        return view('programs.edit', [
            'program' => $program,
            'departments' => ['Media', 'Technology', 'Business', 'Policy', 'Education'],
        ]);
    }

    public function update(UpdateProgramRequest $request, Program $program): RedirectResponse
    {
        $program->update(array_merge($request->validated(), [
            'slug' => Str::slug($request->validated()['name']),
            'is_active' => $request->boolean('is_active'),
        ]));

        return redirect()->route('programs.show', $program)->with('success', 'Program details updated successfully.');
    }

    public function destroy(Program $program): RedirectResponse
    {
        $program->delete();

        return redirect()->route('programs.index')->with('success', 'Program deleted.');
    }
}
