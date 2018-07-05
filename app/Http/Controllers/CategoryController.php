<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\AttachmentCategory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller {
	public function getDocs() {
		return Attachment::all();
	}

	public function getAllUsers() {
		return User::all();
	}

	public function getCat() {
		return AttachmentCategory::all();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$category = AttachmentCategory::find($request->id);
		$category->name = $request->name;
		$category->description = $request->description;
		$category->save();

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id, AttachmentCategory $attachmentCategory) {
        // return $request->all();
		AttachmentCategory::where('id', $id)->delete();
	}

	public function getLogedDocs()
	{
		return AttachmentCategory::with(['documents'])->where('id', Auth::id())->get();
	}

	public function download()
	{
		return;
	}
}
