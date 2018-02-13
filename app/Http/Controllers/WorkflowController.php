<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class WorkflowController extends Controller
{
    //
    function getClientId($userid){
        $clientgroup = DB::table('userpositiongroup as upg')->where('upg.user_user_id','=',$userid)
                        ->distinct()
                        ->get();
            return $clientgroup;
    }

    public function addWF(Request $request,$upgid)
    {
        $user = Auth::user();
    	$rand = rand(1000,99999);
        $clients = $this->getClientId($user->user_id);
        foreach ($clients as $client) {
            $clientId = $client->client_id;
        }
    	DB::table('workflow')->insert(['w_id'=>$rand,
    									'workflowName'=>$request['wfname'],
    									'status'=>'active',
                                        'client_id'=>$clientId]);

    	return redirect()->route('viewWorkflow',['upgid'=>$upgid]);
    	
    }

    //edit
    public function editWf(Request $req,$upgid,$wfid)
    {
        DB::table('workflow')->where('w_id','=',$wfid)->update(['workflowName'=>$req['wfname']]);
        return redirect()->route('viewWorkflow',['upgid'=>$upgid]);
    }

    //retrieve

    //remove
    public function deleteWf($upgid,$wfid)
    {
        //detect if workflow is being used in a template
        $wftemplatecount = DB::table('template')->where('workflow_w_id','=',$wfid)->count();

        if($wftemplatecount>0)
            return redirect()->route('viewWorkflow',['upgid'=>$upgid])->with('activewf','Workflow is being used by a template!');
        else{
             DB::table('workflow')->where('w_id','=',$wfid)->update(['status'=>'inactive']);
             return redirect()->route('viewWorkflow',['upgid'=>$upgid])->with('removewf','Workflow successfully removed.');
        }
    }
    //turn workflow into active


}
