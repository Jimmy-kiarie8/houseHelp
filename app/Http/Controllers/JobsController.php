<?php

namespace App\Http\Controllers;

use App\Jobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobsController extends Controller {
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		// return $request->all();
		$job = new Jobs;
		$job->description = $request->description;
		$job->mechanic_id = $request->mechanic_id;
		$job->client_id = Auth::id();
		$job->user_id = Auth::id();
		$job->save();
		return $job;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Jobs  $jobs
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Jobs $jobs) {
		return $request->all();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Jobs  $jobs
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Jobs $jobs) {
		//
	}

	public function updateJobTrue(Request $request, Jobs $jobs, $id) {
		// return $request->all();
		$job = Jobs::find($id);
		$job->status = true;
		$job->save();
		return $job;
	}

	public function updateJobFalse(Request $request, Jobs $jobs, $id) {
		// return $request->all();
		$job = Jobs::find($id);
		$job->status = false;
		// return $request->status;
		$job->save();
		return $job;
	}

	public function getJobs(Request $request, Jobs $jobs, $id) {
		return json_decode(json_encode(Jobs::where('user_id', $id)->get()), true);
	}

	public function getJobInfo(Request $request, Jobs $user, $id) {
		/*$jobs = User::with(['jobs'])->where('id', Auth::id())->get();
			                    $pass_job = [];
			                    $jobArray = [];
			                    $preA = [];
			                    foreach ($jobs as $job) {
			                        $jobArray[] = $job->jobs;
			                        $arrayJ = json_decode(json_encode($jobArray), true);
			                        // var_dump($arrayJ); die;
			                        foreach ($arrayJ as $element) {
			                            $preA[] = array_prepend($element, Auth::user()->name);
			                        }
			                        $pass_job[] = $preA;
			                        var_dump($pass_job); die;
			                    }
			                    foreach ($pass_job as $value) {
			                        $job_info = $value;
			                    }
		*/
		// $user = User::where('id', $client_id);
		return Jobs::where('user_id', Auth::id())->get();
	}

	public function updateReqFalse(Request $request, Jobs $user, $id) {
		// return $request->all();
		$job = Jobs::find($id);
		$job->respo = $request->respo;
		$job->save();
		return $job;
	}

	public function updateReqTrue(Request $request, Jobs $user, $id) {
		// return $request->all();
		$job = Jobs::find($id);
		$job->respo = $request->respo;
		$job->save();
		return $job;
	}
}
