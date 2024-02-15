<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $projects = Project::all();

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $types = Type::all();
        $technologies = Technology::all();

        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();

        $project = new Project();

        $project->title = $data['title'];
        $project->content = $data['content'];
        $project->slug = Str::of($project->title)->slug('-');

        $project->save();

        if (isset($data['technologies'])) {
            $project->technologies()->sync($data['technologies']);
        }

        return redirect()->route('admin.projects.index')->with('message', "Progetto $project->title creato correttamente");
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {

        $types = Type::all();
        $technologies = Technology::all();

        return view('admin.projects.edit', compact('project', 'types', 'technologies'))->with('message', "Progetto $project->id modificato correttamente");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $this->validation($request->all());

        $project->update($data);

        if (isset($data['technologies'])) {
            $project->technologies()->sync($data['technologies']);
        } else {
            $project->technologies()->sync([]);
        }


        return redirect()->route('admin.projects.show', $project->slug)->with('message', "Progetto $project->id aggiornato correttamente");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {

        $project->technologies()->sync([]);

        $project->delete();

        return redirect()->route('admin.projects.index')->with('message', "Progetto $project->id cancellato correttamente");
    }

    public function validation($data)
    {

        $validator = Validator::make($data, [
            'title' => 'required|max:45',
            'content' => 'required|max:500',
        ], [
            'title.required' => 'Il titolo è obbligatorio.',
            'content.required' => 'Il contenuto è obbligatorio.',
        ])->validate();

        return $validator;
    }
}
