<?php

namespace App\Http\Controllers;

use App\Comments;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller {
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Comments  $comments
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Comments $comments) {
		//
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function comments(Request $request, Comments $comments, $id) {
		// return $request->all();
		$comment = new Comments;
		$comment->comment = $request->comment;
		$comment->rating = $request->rating;
		$comment->user_id = Auth::id();
		$comment->mechanic_id = $id;
		// $comment->save();
		// return $comment;
		if ($comment->save()) {
			$user = User::find($id);
			if ($user->rating != null) {
				$rating = ($user->rating + $request->rating) / 2;
			} else {
				$rating = $request->rating;
			}
			$user->rating = $rating;
			$user->save();
		}
		return $comment;

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Comments  $comments
	 * @return \Illuminate\Http\Response
	 */
	public function getComments() {
		return Comments::orderBy('created_at', 'ASC')->get();
	}

	public function getAllComments(Request $request, Comments $comments, $id) {
		return Comments::find($id);
	}

	public function getPostCom() {
		return BlogComment::all();
	}

	public function getSingleCom(Request $request, BlogComment $blogComment, $id) {
		return BlogComment::find($id);
	}

	public function Postcom(CommentRequest $request, BlogComment $blogComment, $id) {
		// return $request->all();
		$comment = new BlogComment;
		$comment->user_id = Auth::id();
		$comment->comment = $request->comment;
		$comment->blog_id = $id;
		$comment->save();
		return $comment;
	}

	public function getImgBlog(Request $request, BlogComment $blogComment, $id) {
		$blogs = BlogComment::where('id', $id)->get();
		foreach ($blogs as $blog) {
			$image = $blog->image;
		}
		return $image;
	}

	public function getBlogC(Request $request, BlogComment $blogComment, $id) {
		return BlogComment::where('blog_id', $id)->get();
	}

	public function fewComments() {
		return Comments::orderBy('created_at', 'ASC')->limit(5)->get();
	}
}
