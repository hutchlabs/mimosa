<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gradlead\Template;

class TemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except'=>['defaultTemplates']]);
        $this->middleware('tenant');
    }

    public function index()
    {
        $items = Template::all();
        return $this->json_response($items);
    }
    
    public function defaultTemplates()
    {
        $items = Theme::withoutGlobalScope('organization_id')->find($this->getTenant()->id);
        if (!$items) {
            $items = Theme::withoutGlobalScope('organization_id')->find(1);
        }
        return $this->json_response($items);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
           'name' => 'required|max:255', 'type'=>'required', 'template' => 'required', ]
        );

        $i = new Template();
        $i->name = $request->name;
        $i->type = $request->type;
        $i->description = $request->description;
        $i->template = $request->template;
        $i->system = 0;
        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }

    public function update(Request $request, $itemId)
    {
        $user = $request->user();

        $this->validate($request, [
           'name' => 'required|max:255',
           'type' => 'required|max:255',
           'template' => 'max:255',
          ]
        );
        
        $i = Template::find($itemId);

        if (is_null($i)) {
            return $this->json_response(['Cannot find template to update'], true);    
        }
        
        $i->name = $request->name;
        $i->type = $request->type;
        $i->description = $request->description;
        $i->template = $request->template;
        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }
    
    public function destroy(Request $request, $itemId)
    {
        $i = Template::find($itemId);
        if (is_null($i)) {
            $this->json_report(['Cannot find template'], true);
        } else {
            $i->delete();
            return $this->ok();
        }
    }
}
