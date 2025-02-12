<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LabelingRule;

class LabelingRuleController extends Controller
{
    public function index()
    {
        $rules = LabelingRule::all();
        return view('feed-management.labeling-rules', compact('rules'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'platform' => 'required|in:Google,Meta,TikTok',
            'label' => 'required|in:Hero,Villain,Zombie,Sidekick',
            'metric' => 'required|in:ROAS,Conversion Rate,Clicks,Impressions',
            'condition' => 'required|in:>,<,=',
            'value' => 'required|numeric',
        ]);

        LabelingRule::create($request->all());

        return redirect()->route('labeling-rules.index')->with('success', 'Labeling rule added successfully.');
    }

    public function destroy($id)
    {
        LabelingRule::findOrFail($id)->delete();
        return redirect()->route('labeling-rules.index')->with('success', 'Rule deleted.');
    }
}
