<?php

namespace App\Http\Controllers;

use App\Education;
use App\Experience;
use App\MechSkill;
use App\Resume;
use App\skills;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResumeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function experience(Request $request, Experience $experience, $id)
    {
        // return $request->all();
        $experience = new Experience;
        // $flight = App\Flight::firstOrCreate(['name' => 'Flight 10']);
        $experience->job_title = $request->job_title;
        $experience->company_name = $request->company_name;
        $experience->start_date = $request->start_date;
        $experience->end_date = $request->end_date;
        $experience->bio = $request->bio;
        $experience->mechanic_id = $id;
        $experience->user_id = Auth::id();
        $experience->save();
        $all_skills = serialize($request->skillsArr);
        if ($experience->save() && $request->skillsArr) {
            $skills = MechSkill::updateOrCreate(
                ['mechanic_id' => $id],
                [
                    'skills' => $all_skills,
                    'mechanic_id' => $id,
                    'user_id' => Auth::id(),
                ]
            );
        }
        return $experience;
    }
    public function education(Request $request, Education $education, $id)
    {
        // return $request->all();
        $education = new Education;
        $education->course_name = $request->course_name;
        $education->institute = $request->institute;
        $education->start_date = $request->start_date;
        $education->end_date = $request->end_date;
        $education->bio = $request->bio;
        $education->mechanic_id = $id;
        $education->user_id = Auth::id();
        $education->save();
        return $education;
    }

    public function skills(Request $request, skills $skills, $id)
    {
        // return $request->all();
        $skills = new skills;
        $skills->skill_title = $request->skill_title;
        $skills->bio = $request->bio;
        $skills->mechanic_id = $id;
        $skills->user_id = Auth::id();
        $skills->save();
        return $skills;
    }

    public function personal(Request $request, Resume $resume, $id)
    {
        // return $request->all();
        // $personal = new Resume;
        // var_dump($request->quarification); die;
        $personal = Resume::updateOrCreate(
            ['mechanic_id' => $id],
            [
                'about' => $request->about,
                'interest' => $request->interest,
                'quarification' => $request->quarification,
                'reference' => $request->reference,
                'mechanic_id' => $id,
                'user_id' => Auth::id(),
            ]
        );
        /*$personal->about = $request->about;
        $personal->interest = $request->interest;
        $personal->quarification = $request->quarification;
        $personal->mechanic_id = $id;
        $personal->user_id = Auth::id();
        $personal->save();*/
        return $personal;
    }

    public function getEducation()
    {
        return Education::all();
    }

    public function getPersonal()
    {
        return Resume::all();
    }

    public function getExperience()
    {
        return Experience::all();
    }

    public function getSkills()
    {
        /*$skills = Skills::all();
        $skillsArr = [];
        foreach ($skills as $skill) {
            $skillsArr[] = $skill->skill_title;
        }
        return $skillsArr;*/
        return Skills::all();
    }


    public function getMeckSkills()
    {
        $skills = MechSkill::find('1');
        $skillsArr = unserialize($skills->skills);
        return Skills::whereIn('id', $skillsArr)->get();
        // return unserialize($skills->skills);
    }
}
