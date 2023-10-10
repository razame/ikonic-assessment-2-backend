<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackRequest;
use App\Models\Attachment;
use App\Models\Feedback;
use Illuminate\Http\JsonResponse;

class FeedbackController extends Controller
{
    public function index(): JsonResponse {
        $searchString   = request()->has('search') ? request()->get('search') : '';
        $recordsPerPage = 10;

        $feedbacks = Feedback::with(['createdBy' => function($q){
            return $q->select('id', 'name');
        }]);

        if ($searchString !== '') {

            $feedbacks = $feedbacks->whereHas('createdBy' , function($q) use ($searchString) {
                return $q->where('name', 'LIKE', "%$searchString%");
            })
            ->orWhere(function($q) use ($searchString) {
                return $q->where('title', 'LIKE', "%$searchString%")
                    ->orWhere('description', 'LIKE', "%$searchString%");
            });
        }

        $feedbacks = $feedbacks->paginate($recordsPerPage);

        return response()->json([
            'feedbacks' => $feedbacks->items(),
            'is_first_page' => $feedbacks->currentPage() === 1,
            'is_last_page' => $feedbacks->currentPage() === $feedbacks->lastPage()
        ]);
    }


    public function store(FeedbackRequest $request): JsonResponse {

        $request = $request->merge(['user_id' => auth()->user()->id]);

        $feedback = Feedback::create($request->only(['title', 'description', 'category', 'user_id']));

        if (!$feedback) {
            return response()->json(['message' => 'Could not create data'], 419);
        }

        $message = 'Created feedback and attachments uploaded successfully';

        $couldNotUploadFiles = [];

        foreach ($request->get('images') as $key => $image) {

            $uploadedImage = saveImage($image);

            if ( empty($uploadedImage['path']) ) {
                $couldNotUploadFiles[] = $key + 1;
                continue;
            }

            Attachment::create([
                'attachable_id'     => $feedback->id,
                'attachable_type'   => Feedback::class,
                "href"              => $uploadedImage['path'],
                "public_id"         => $uploadedImage['public_id']
            ]);
        }

        if (!empty($couldNotUploadFiles)) {
            $message = 'Could not upload files no # ' . implode(', ', $couldNotUploadFiles);
        }

        return response()->json([
            'feedback'  =>  $feedback,
            'message'   =>  $message
        ]);
    }




    public function show($id): JsonResponse {

        $feedback = Feedback::with('createdBy')->find($id);

        if (!$feedback) {
            return response()->json(['message' => 'Could not find requested data'], 404);
        }
        return response()->json([
            'feedback'  =>  $feedback
        ]);
    }

}
